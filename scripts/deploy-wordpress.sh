#!/usr/bin/env bash
set -Eeuo pipefail

die() {
  printf 'deploy-wordpress: %s\n' "$1" >&2
  exit 1
}

require_command() {
  command -v "$1" >/dev/null 2>&1 || die "required command is missing: $1"
}

validate_root() {
  local root="$1"
  [[ "$root" =~ ^/[A-Za-z0-9._/-]+$ ]] || die "deployment root must be a safe absolute Unix path"
  [[ "$root" != "/" && "$root" != *".."* ]] || die "deployment root is unsafe"
}

atomic_link() {
  local target="$1"
  local link="$2"
  local token="$3"
  local temporary="${link}.tmp.${token}.${BASHPID}"

  if [[ -e "$link" && ! -L "$link" ]]; then
    die "refusing to replace a non-symlink: $link"
  fi
  if [[ -e "$temporary" || -L "$temporary" ]]; then
    die "temporary symlink already exists: $temporary"
  fi
  ln -s -- "$target" "$temporary"
  mv -Tf -- "$temporary" "$link"
}

write_state() {
  local state_file="$1"
  local status="$2"
  local sha="$3"
  local previous="$4"
  local release="$5"
  local temporary="${state_file}.tmp.${BASHPID}"

  umask 077
  {
    printf 'status=%s\n' "$status"
    printf 'sha=%s\n' "$sha"
    printf 'previous=%s\n' "$previous"
    printf 'release=%s\n' "$release"
  } > "$temporary"
  mv -Tf -- "$temporary" "$state_file"
}

state_value() {
  local state_file="$1"
  local key="$2"
  awk -F= -v wanted="$key" '$1 == wanted { print substr($0, index($0, "=") + 1); exit }' "$state_file"
}

rollback_current() {
  local root="$1"
  local sha="$2"
  local current="$root/current"
  local previous_target="$3"

  [[ -n "$previous_target" && -d "$previous_target" ]] || die "previous release is unavailable for rollback"
  atomic_link "$previous_target" "$current" "rollback-${sha}"
}

deploy_release() {
  local root="$1"
  local sha="$2"
  local domain="$3"
  local package="$4"
  local db_update="${5:-false}"
  local releases="$root/releases"
  local shared="$root/shared"
  local current="$root/current"
  local previous="$root/previous"
  local state_file="$shared/.deploy-state"
  local release="$releases/$sha"
  local current_target
  local previous_target
  local backup_file
  local switched=0

  validate_root "$root"
  [[ "$sha" =~ ^[0-9a-f]{40}$ ]] || die "release id must be a full Git SHA"
  [[ "$domain" =~ ^[A-Za-z0-9.-]+$ ]] || die "domain must be a hostname without a URL scheme"
  [[ -f "$package" ]] || die "release package is missing: $package"
  require_command rsync
  require_command tar
  require_command wp
  require_command curl

  [[ -L "$current" ]] || die "current must be a symlink prepared by the server bootstrap"
  current_target="$(readlink -f -- "$current")"
  [[ "$current_target" == "$releases/"* && -d "$current_target" ]] || die "current must point into releases/"
  previous_target="$current_target"
  [[ ! -e "$release" && ! -L "$release" ]] || die "release already exists: $release"

  mkdir -p "$releases" "$shared/backups" "$shared/uploads"
  require_command flock
  exec 9>"$shared/.deploy.lock"
  flock -n 9 || die "another deployment is already running"

  rollback_on_error() {
    local exit_code=$?
    if [[ "${switched:-0}" == "1" ]]; then
      set +e
      atomic_link "$previous_target" "$current" "error-${sha}" >/dev/null 2>&1 || true
      write_state "$state_file" rolled_back "$sha" "$previous_target" "$release" >/dev/null 2>&1 || true
    fi
    exit "$exit_code"
  }
  trap rollback_on_error ERR

  [[ -f "$shared/wp-config.php" ]] || {
    [[ -f "$current_target/wp-config.php" ]] || die "shared/wp-config.php is missing"
    cp -p -- "$current_target/wp-config.php" "$shared/wp-config.php"
  }

  if [[ -d "$current_target/wp-content/uploads" && ! -L "$current_target/wp-content/uploads" ]]; then
    rsync -a --ignore-existing -- "$current_target/wp-content/uploads/" "$shared/uploads/"
  fi

  backup_file="$shared/backups/db-${sha}-$(date -u +%Y%m%dT%H%M%SZ).sql"
  wp --path="$current_target" db export "$backup_file" --add-drop-table --quiet
  [[ -s "$backup_file" ]] || die "database backup is empty: $backup_file"
  cp -p -- "$shared/wp-config.php" "$shared/backups/wp-config-${sha}.php"

  mkdir "$release"
  rsync -a --links \
    --exclude='/wp-config.php' \
    --exclude='/wp-content/uploads' \
    -- "$current_target/" "$release/"
  tar --extract --gzip --file "$package" --directory "$release" --no-same-owner --no-same-permissions
  [[ ! -e "$release/wp-config.php" && ! -L "$release/wp-config.php" ]] || die "release contains wp-config.php"
  [[ ! -e "$release/wp-content/uploads" && ! -L "$release/wp-content/uploads" ]] || die "release contains uploads"
  ln -s -- "$shared/wp-config.php" "$release/wp-config.php"
  mkdir -p "$release/wp-content"
  ln -s -- "$shared/uploads" "$release/wp-content/uploads"

  if [[ "$db_update" == "true" ]]; then
    wp --path="$release" core update-db --quiet
  fi

  write_state "$state_file" prepared "$sha" "$previous_target" "$release"
  atomic_link "$release" "$current" "$sha"
  switched=1
  write_state "$state_file" switched "$sha" "$previous_target" "$release"
  atomic_link "$previous_target" "$previous" "$sha"

  if ! {
    wp --path="$release" cache flush --quiet
    curl --fail --silent --show-error --location --max-time 30 --proto '=https' --tlsv1.2 \
      "https://${domain}/" > /dev/null
  }; then
    rollback_current "$root" "$sha" "$previous_target"
    switched=0
    write_state "$state_file" rolled_back "$sha" "$previous_target" "$release"
    die "post-switch smoke-check failed; release rolled back"
  fi

  write_state "$state_file" success "$sha" "$previous_target" "$release"
  rm -f -- "$package"
  switched=0
  trap - ERR
  printf 'deployed %s\n' "$sha"
}

rollback_release() {
  local root="$1"
  local sha="$2"
  local shared="$root/shared"
  local state_file="$shared/.deploy-state"
  local current="$root/current"
  local status
  local state_sha
  local previous_target
  local release

  validate_root "$root"
  [[ -f "$state_file" ]] || { echo "no deployment state; rollback skipped"; return 0; }
  status="$(state_value "$state_file" status)"
  state_sha="$(state_value "$state_file" sha)"
  previous_target="$(state_value "$state_file" previous)"
  release="$(state_value "$state_file" release)"
  [[ "$state_sha" == "$sha" && "$status" == "switched" ]] || {
    echo "no switched release for $sha; rollback skipped"
    return 0
  }
  [[ "$release" == "$root/releases/"* && -d "$release" ]] || die "state points outside releases"
  [[ "$previous_target" == "$root/releases/"* && -d "$previous_target" ]] || die "state points to an invalid previous release"
  [[ "$(readlink -f -- "$current")" == "$release" ]] || {
    echo "current no longer points to failed release; rollback skipped"
    return 0
  }
  rollback_current "$root" "$sha" "$previous_target"
  write_state "$state_file" rolled_back "$sha" "$previous_target" "$release"
  echo "rolled back $sha"
}

case "${1:-}" in
  deploy)
    [[ $# -ge 5 ]] || die "usage: $0 deploy ROOT SHA DOMAIN PACKAGE [true|false]"
    deploy_release "$2" "$3" "$4" "$5" "${6:-false}"
    ;;
  rollback)
    [[ $# -eq 3 ]] || die "usage: $0 rollback ROOT SHA"
    rollback_release "$2" "$3"
    ;;
  *)
    die "usage: $0 {deploy|rollback} ..."
    ;;
esac
