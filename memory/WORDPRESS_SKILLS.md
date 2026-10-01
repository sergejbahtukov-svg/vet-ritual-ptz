# WordPress Skills And Tools

## Available project skills

- `skills/wordpress-vetritual/SKILL.md` — project content ownership and verification.
- `.codex/skills/wordpress-router/` and `.codex/skills/wp-project-triage/` — inspect the theme and choose a workflow.
- `.codex/skills/wp-wpcli-and-ops/` — targeted WordPress operations.
- `.codex/skills/wp-performance/` — performance investigations.

Use native Pages, Menus, Media Library, custom post types, blocks and theme template parts. The base theme does not depend on page builders or ACF.

## Required Local Skills For This Project

| Area | Required Skill | Project Rule | Main Files |
|---|---|---|---|
| WordPress template hierarchy | `front-page.php`, `page.php`, `404.php`, `index.php`, template parts | Use WordPress hierarchy instead of custom route rendering. | `wordpress-theme/vetritual-modern/*.php`, `template-parts/*.php` |
| Native content model | Pages, excerpts, featured images, CPTs | Page text belongs in WP Pages; repeatable editorial data belongs in CPTs or blocks, not Customizer JSON. | `inc/content-model.php`, `tools/seed-wordpress-content.php` |
| Menus | `register_nav_menus()`, `wp_nav_menu()` | Header/footer navigation must come from WP menus. | `functions.php`, `header.php`, `footer.php` |
| Media | Media Library, attachments, featured images | Editor-changeable images must be media/featured images. Theme assets are fallback only. | `assets/media/`, seed script, page templates |
| Global settings | Settings API/theme options only for global values | Phone, email, address, legal identity, logo/site identity, analytics IDs, verification tags and limited global CTA defaults. | `inc/helpers/theme-options.php` |
| Escaping/security | `esc_html`, `esc_url`, `wp_kses_post`, `sanitize_*` | Every dynamic value must be escaped at output and sanitized at save/import. | all templates/helpers |
| Verification | PHP lint, HTTP smoke, Playwright 360/768/1280 | Do not claim visual readiness without browser checks. | `tools/`, local WP URL |

## Additional skills

- `qa-acceptance`: final acceptance QA when needed.
- `frontend-design`: visual/layout work when needed.

## Native WordPress Checklist Before Any Theme Edit

1. Read `AGENTS.md`.
2. Read this file.
3. Confirm the active local WP URL: `http://localhost/vetritual-wp/`.
4. Confirm the source theme path: `wordpress-theme/vetritual-modern`.
5. Confirm the active XAMPP theme path: `C:\xampp\htdocs\vetritual-wp\wp-content\themes\vetritual-modern`.
6. Check for `*_json` theme-option content fields, `vr_theme_setting_array()` as a content source and mojibake before editing.
7. Keep source-of-truth boundaries:
   - Pages: page title/content/excerpt.
   - Menus: navigation.
   - Media: editable images and featured images.
   - CPTs/blocks: repeatable services, prices, process, reviews.
   - Settings API options: global contacts, analytics, verification, global CTA fallback.
8. Edit only source files, then sync to XAMPP theme.
9. Run targeted content operations with XAMPP PHP or WP-CLI; do not rerun the full seed to change existing prices.
10. Verify with lint, HTTP smoke, and responsive browser checks.

## Forbidden Shortcuts

- Do not use theme-option JSON arrays for page sections.
- Do not hardcode editable page text in templates when a WP Page/CPT can own it.
- Do not add plugin dependency to solve base theme architecture.
