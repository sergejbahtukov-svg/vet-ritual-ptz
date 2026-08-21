#!/usr/bin/env bash
set -Eeuo pipefail

# ISPmanager starts non-interactive SSH sessions with a reduced PATH.
export PATH="/usr/local/bin:${PATH}"

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

  [[ -d "$target" ]] || die "link target is missing: $target"
  [[ ! -e "$link" || -L "$link" ]] || die "refusing to replace a non-symlink: $link"
  [[ ! -e "$temporary" && ! -L "$temporary" ]] || die "temporary link already exists: $temporary"
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

remove_redundant_service_intro_content() {
  local root="$1"

  wp --path="$root" eval '
    $migration_option = "vr_redundant_service_intro_content_removed_20260727";
    if (! get_option($migration_option, false)) {
      $service_slugs = array(
        "uslugi",
        "usyplenie-zhivotnyh",
        "krematsyja-zhyvotnyh",
        "vyvoz-zhivotnyh",
        "usyplenie-koshek",
        "usyplenie-sobak",
        "obschaja-krematsyja",
        "individualnaja-krematsyja",
      );

      foreach ($service_slugs as $service_slug) {
        $service_page = get_page_by_path($service_slug);
        if ($service_page instanceof WP_Post) {
          wp_update_post(array(
            "ID" => (int) $service_page->ID,
            "post_content" => "",
          ));
        }
      }

      update_option($migration_option, "1", false);
    }
  ' --quiet
}

restore_approved_price_catalog() {
  local root="$1"

  wp --path="$root" eval '
    $migration_option = "vr_price_catalog_restored_20260818_v2";
    if (! get_option($migration_option, false)) {
      $catalog = array(
        "usyplenie" => array(
          array("label" => "Кошка", "value" => "3 000–3 500 руб."),
          array("label" => "Собаки 5–10 кг", "value" => "4 000–5 000 руб."),
          array("label" => "Собаки 11–20 кг", "value" => "5 000–6 000 руб."),
          array("label" => "Собаки от 20 кг", "value" => "от 7 000 руб."),
        ),
        "obschaya-krematsiya" => array(
          array("label" => "до 1 кг", "value" => "2 000–2 500 руб."),
          array("label" => "1–5 кг", "value" => "4 000 руб."),
          array("label" => "5–10 кг", "value" => "4 500 руб."),
          array("label" => "10–20 кг", "value" => "5 500 руб."),
          array("label" => "20–30 кг", "value" => "6 000 руб."),
          array("label" => "30–40 кг", "value" => "7 000 руб."),
          array("label" => "40–50 кг", "value" => "8 500 руб."),
          array("label" => "От 50 кг", "value" => "10 000–12 000 руб."),
        ),
        "individualnaya-krematsiya" => array(
          array("label" => "Попугай, крыса", "value" => "4 500 руб."),
          array("label" => "до 5 кг", "value" => "8 000 руб."),
          array("label" => "до 10 кг", "value" => "8 500 руб."),
          array("label" => "до 20 кг", "value" => "9 000 руб."),
          array("label" => "до 30 кг", "value" => "10 000 руб."),
          array("label" => "до 40 кг", "value" => "11 000 руб."),
          array("label" => "до 50 кг", "value" => "13 500 руб."),
          array("label" => "от 50 кг", "value" => "от 16 000 руб."),
        ),
      );
      $groups = array();

      foreach ($catalog as $slug => $rows) {
        $group = get_page_by_path($slug, OBJECT, "vr_price_group");
        if (! $group instanceof WP_Post) {
          throw new RuntimeException(sprintf("Price group is missing: %s", $slug));
        }
        $groups[$slug] = $group;
      }

      foreach ($catalog as $slug => $rows) {
        update_post_meta((int) $groups[$slug]->ID, "_vr_price_rows", $rows);
      }

      update_option($migration_option, "1", false);
    }
  ' --quiet
}

fix_individual_cremation_price_order() {
  local root="$1"

  wp --path="$root" eval '
    $migration_option = "vr_individual_cremation_price_order_fixed_20260821";
    if (! get_option($migration_option, false)) {
      $group = get_page_by_path("individualnaya-krematsiya", OBJECT, "vr_price_group");
      if (! $group instanceof WP_Post) {
        throw new RuntimeException("Individual cremation price group is missing");
      }

      $rows = get_post_meta((int) $group->ID, "_vr_price_rows", true);
      if (! is_array($rows)) {
        throw new RuntimeException("Individual cremation price rows are invalid");
      }

      $small_animal_index = null;
      $up_to_five_index = null;
      foreach ($rows as $index => $row) {
        $label = trim((string) ($row["label"] ?? ""));
        if ($label === "Попугай, крыса") {
          $small_animal_index = (int) $index;
        } elseif ($label === "до 5 кг") {
          $up_to_five_index = (int) $index;
        }
      }

      if ($small_animal_index === null || $up_to_five_index === null) {
        throw new RuntimeException("Required individual cremation price rows are missing");
      }

      if ($small_animal_index > $up_to_five_index) {
        $small_animal_row = $rows[$small_animal_index];
        array_splice($rows, $small_animal_index, 1);
        array_splice($rows, $up_to_five_index, 0, array($small_animal_row));
        update_post_meta((int) $group->ID, "_vr_price_rows", array_values($rows));
      }

      update_option($migration_option, "1", false);
    }
  ' --quiet
}

deploy_release() {
  local root="$1"
  local sha="$2"
  local domain="$3"
  local package="$4"
  local db_update="${5:-false}"
  local server_host="$6"
  local deploy_dir
  local releases
  local backups
  local state_file
  local theme_link
  local release
  local new_theme
  local previous_target=""
  local previous_active_theme
  local backup_file
  local switched=0

  validate_root "$root"
  [[ "$sha" =~ ^[0-9a-f]{40}$ ]] || die "release id must be a full Git SHA"
  [[ "$domain" =~ ^[A-Za-z0-9.-]+$ ]] || die "domain must be a hostname without a URL scheme"
  [[ "$server_host" =~ ^[A-Za-z0-9.-]+$ ]] || die "server host must be a hostname or IP address"
  [[ -f "$package" ]] || die "release package is missing: $package"
  [[ -f "$root/wp-load.php" && -d "$root/wp-content/themes" ]] || die "WordPress root is invalid: $root"
  require_command tar
  require_command wp
  require_command curl
  require_command flock

  deploy_dir="$root/.vetritual-deploy"
  releases="$deploy_dir/releases"
  backups="$deploy_dir/backups"
  state_file="$deploy_dir/.deploy-state"
  theme_link="$root/wp-content/themes/vetritual-modern"
  release="$releases/$sha"
  previous_active_theme="$(wp --path="$root" option get stylesheet --quiet)"
  [[ "$previous_active_theme" =~ ^[A-Za-z0-9_-]+$ ]] || die "active WordPress theme slug is invalid"

  mkdir -p "$releases" "$backups"
  exec 9>"$deploy_dir/.deploy.lock"
  flock -n 9 || die "another deployment is already running"

  if [[ -L "$theme_link" ]]; then
    previous_target="$(readlink -f -- "$theme_link")"
    [[ "$previous_target" == "$releases/"* && -d "$previous_target" ]] || die "active theme link points outside managed releases"
  elif [[ -e "$theme_link" ]]; then
    die "refusing to replace an unmanaged theme directory: $theme_link"
  fi

  [[ ! -e "$release" && ! -L "$release" ]] || die "release already exists: $release"

  rollback_on_error() {
    local exit_code=$?
    if [[ "$switched" == "1" && -n "$previous_target" ]]; then
      set +e
      atomic_link "$previous_target" "$theme_link" "error-${sha}" >/dev/null 2>&1 || true
      write_state "$state_file" rolled_back "$sha" "$previous_target" "$release" >/dev/null 2>&1 || true
    fi
    if [[ "$switched" == "1" && "$previous_active_theme" != "vetritual-modern" ]]; then
      set +e
      wp --path="$root" theme activate "$previous_active_theme" --quiet >/dev/null 2>&1 || true
    fi
    exit "$exit_code"
  }
  trap rollback_on_error ERR

  backup_file="$backups/db-${sha}-$(date -u +%Y%m%dT%H%M%SZ).sql"
  wp --path="$root" db export "$backup_file" --add-drop-table --quiet
  [[ -s "$backup_file" ]] || die "database backup is empty"

  mkdir "$release"
  tar --extract --gzip --file "$package" --directory "$release" --no-same-owner --no-same-permissions
  new_theme="$release/wp-content/themes/vetritual-modern"
  [[ -d "$new_theme" ]] || die "release package does not contain the theme"
  if find "$release" -type l -print -quit | grep -q .; then
    die "release package contains a symlink"
  fi

  if [[ "$db_update" == "true" ]]; then
    wp --path="$root" core update-db --quiet
  fi

  write_state "$state_file" prepared "$sha" "$previous_target" "$release"
  atomic_link "$new_theme" "$theme_link" "$sha"
  switched=1
  wp --path="$root" theme activate vetritual-modern --quiet
  remove_redundant_service_intro_content "$root"
  restore_approved_price_catalog "$root"
  fix_individual_cremation_price_order "$root"
  write_state "$state_file" switched "$sha" "$previous_target" "$release"

  wp --path="$root" cache flush --quiet
  if ! curl --fail --silent --show-error --location --max-time 30 \
    --connect-to "${domain}:80:${server_host}:80" "http://${domain}/" > /dev/null; then
    if [[ -n "$previous_target" ]]; then
      atomic_link "$previous_target" "$theme_link" "smoke-${sha}"
      switched=0
      write_state "$state_file" rolled_back "$sha" "$previous_target" "$release"
    fi
    die "server smoke-check failed"
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
  local deploy_dir
  local state_file
  local status
  local state_sha
  local previous_target
  local release
  local theme_link

  validate_root "$root"
  deploy_dir="$root/.vetritual-deploy"
  state_file="$deploy_dir/.deploy-state"
  theme_link="$root/wp-content/themes/vetritual-modern"
  [[ -f "$state_file" ]] || { echo "no deployment state; rollback skipped"; return 0; }

  status="$(state_value "$state_file" status)"
  state_sha="$(state_value "$state_file" sha)"
  previous_target="$(state_value "$state_file" previous)"
  release="$(state_value "$state_file" release)"
  [[ "$state_sha" == "$sha" && ( "$status" == "success" || "$status" == "switched" ) ]] || {
    echo "no active release for $sha; rollback skipped"
    return 0
  }
  [[ -n "$previous_target" && "$previous_target" == "$deploy_dir/releases/"* && -d "$previous_target" ]] || {
    echo "no previous managed theme release; rollback skipped"
    return 0
  }
  [[ "$release" == "$deploy_dir/releases/"* && -d "$release" ]] || die "state points outside managed releases"
  [[ -L "$theme_link" && "$(readlink -f -- "$theme_link")" == "$release/wp-content/themes/vetritual-modern" ]] || {
    echo "active theme changed; rollback skipped"
    return 0
  }

  atomic_link "$previous_target" "$theme_link" "rollback-${sha}"
  write_state "$state_file" rolled_back "$sha" "$previous_target" "$release"
  echo "rolled back $sha"
}

case "${1:-}" in
  deploy)
    [[ $# -eq 7 ]] || die "usage: $0 deploy ROOT SHA DOMAIN PACKAGE true|false SERVER_HOST"
    deploy_release "$2" "$3" "$4" "$5" "$6" "$7"
    ;;
  rollback)
    [[ $# -eq 3 ]] || die "usage: $0 rollback ROOT SHA"
    rollback_release "$2" "$3"
    ;;
  *)
    die "usage: $0 {deploy|rollback} ..."
    ;;
esac
