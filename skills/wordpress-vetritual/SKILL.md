---
name: wordpress-vetritual
description: Build, migrate, remediate, test, or deploy the Vet Ritual WordPress theme. Use for WordPress Pages, menus, media, custom post types, theme settings, templates, content editability, local verification, and production deployment in this repository.
---

# Vet Ritual WordPress

Use native WordPress content management while preserving the approved Vet Ritual visual design.

## Entry checks

1. Read `AGENTS.md` and `memory/WORDPRESS_SKILLS.md`.
2. For multi-slice work, read `memory/WORDPRESS_MIGRATION_WORKFLOW.md`; for subagents, read `memory/subagents/WORDPRESS_ASSIGNMENTS.md`.
3. Work in `wordpress-theme/vetritual-modern`; do not treat exported or preview HTML as the source of truth.
4. Verify locally at `http://localhost/vetritual-wp/` after syncing to `C:\xampp\htdocs\vetritual-wp\wp-content\themes\vetritual-modern`.

## Content ownership

| Content | WordPress owner |
|---|---|
| Page titles, long text, SEO copy, hero copy and image | Pages, excerpts, featured images, blocks |
| Header and footer navigation | Registered menus via `wp_nav_menu()` |
| Services, price groups, feature cards, process steps, reviews | Existing `vr_*` custom post types and their metaboxes |
| Editor-changeable images | Media Library or featured images |
| Logo, contacts, analytics, verification tags, global CTA defaults, colour token | Settings API theme options |

Do not use theme-option JSON arrays or `vr_theme_setting_array()` for page-section content. Do not hardcode editor-owned copy in a template: add a page field, a proper post type field, or a menu item instead.

## Theme work

- Keep fixed visual wrappers in template parts; escape all dynamic output.
- Prefer Page/CPT data before adding a new option. Theme options are global-only.
- Preserve the active theme version and asset query version at `1.0` until an explicit release request.
- Do not add page builders, ACF, or other plugins as a base-theme dependency.

## Verification and deployment

1. Run PHP and JavaScript syntax checks for changed files.
2. Check home, service pages, 404, menus, and mobile layouts at 360, 768, and 1280 px on the local instance.
3. Confirm user-visible Russian text is not mojibake.
4. Commit only related files. The GitHub workflow deploys the theme atomically; do not modify WordPress core, `wp-config.php`, uploads, or deployment archives.
