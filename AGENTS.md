# Vet Ritual WordPress project

The running site uses WordPress. The theme source is `wordpress-theme/vetritual-modern/`.

## Local environment

- Local URL: `http://localhost/vetritual-wp/`.
- Local installation: `C:\xampp\htdocs\vetritual-wp`.
- Active local theme: `C:\xampp\htdocs\vetritual-wp\wp-content\themes\vetritual-modern`.
- Public site: `https://vet-ritual-ptz.ru/`.

Read `memory/WORDPRESS_SKILLS.md` and the project skill `skills/wordpress-vetritual/SKILL.md` before changing the theme. Run the WordPress project triage script from the theme directory before implementation. Use `.codex/skills/wordpress-router/` to choose a workflow, and `.codex/skills/wp-wpcli-and-ops/` for WordPress operations.

## Content ownership

- Pages own page titles and body content.
- Registered WordPress menus own navigation.
- Media Library and featured images own editor-changeable images.
- The `vr_price_group` post type and `_vr_price_rows` post meta own prices. Update only the intended price group; do not run the full content seed to change an existing price list.
- Theme settings own global business details such as phone, address, legal name, INN and OGRNIP. Keep global settings editable through the Settings API.
- Use native WordPress escaping at output and sanitize saved values.

## Workflow

1. Check Git status and preserve unrelated work.
2. Change the WordPress source theme or native WordPress content owner.
3. Sync changed theme files to the active local theme.
4. Verify the local WordPress pages, including Russian text, links, prices, footer and mobile layout when affected.
5. Use the existing WordPress deployment workflow for production releases. Confirm the target and retain its database backup.

Do not store credentials, tokens, private keys or database dumps in the repository. Do not bump the theme version for routine edits. Do not create deployment archives in the project root.
