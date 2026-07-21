# WordPress Skills And Tools

## Current Capability Check

- Dedicated Codex WordPress skill/tool: not available in the current tool list.
- Plugin dependency strategy: do not depend on ACF, page builders, form builders, SEO plugins, or cache plugins for the base theme.
- WordPress source of truth: native Pages, Menus, Media Library, Featured Images, CPTs, blocks/patterns, and theme template parts.
- Webasyst/Smarty source of truth: visual DOM/CSS/layout reference only. Do not port Smarty syntax into WordPress.

## Required Local Skills For This Project

| Area | Required Skill | Project Rule | Main Files |
|---|---|---|---|
| WordPress template hierarchy | `front-page.php`, `page.php`, `404.php`, `index.php`, template parts | Use WordPress hierarchy instead of custom route rendering. | `wordpress-theme/vetritual-modern/*.php`, `template-parts/*.php` |
| Native content model | Pages, excerpts, featured images, CPTs | Page text belongs in WP Pages; repeatable editorial data belongs in CPTs or blocks, not Customizer JSON. | `inc/content-model.php`, `tools/seed-wordpress-content.php` |
| Menus | `register_nav_menus()`, `wp_nav_menu()` | Header/footer navigation must come from WP menus. | `functions.php`, `header.php`, `footer.php` |
| Media | Media Library, attachments, featured images | Editor-changeable images must be media/featured images. Theme assets are fallback only. | `assets/media/`, seed script, page templates |
| Global settings | Customizer/theme mods only for global values | Allowed: phone, email, address, logo/site identity, analytics IDs, verification tags, limited global CTA defaults. | `inc/customizer.php`, `inc/helpers/theme-options.php` |
| Escaping/security | `esc_html`, `esc_url`, `wp_kses_post`, `sanitize_*` | Every dynamic value must be escaped at output and sanitized at save/import. | all templates/helpers |
| Verification | PHP lint, HTTP smoke, Playwright 360/768/1280 | Do not claim visual readiness without browser checks. | `tools/`, local WP URL |

## Available Codex Skills To Use

- `qa-acceptance`: use for final acceptance QA and failure logging.
- `frontend-design`: use only when doing visual/layout comparison or CSS polish.
- `browser:control-in-app-browser`: use only when the in-app browser is needed for manual/interactive inspection.

There is no dedicated WordPress skill in the available Codex skill list. Therefore WordPress work must follow this document plus `AGENTS.md` and the native checklist below.

## Native WordPress Checklist Before Any Theme Edit

1. Read `AGENTS.md`.
2. Read this file.
3. Confirm the active local WP URL: `http://localhost/vetritual-wp/`.
4. Confirm the source theme path: `wordpress-theme/vetritual-modern`.
5. Confirm the active XAMPP theme path: `C:\xampp\htdocs\vetritual-wp\wp-content\themes\vetritual-modern`.
6. Check for old debt before editing:
   - `vr_route_map`
   - `vr_get_route_info`
   - `vr_get_route_fallback_content`
   - `*_json` Customizer content fields
   - `vr_theme_setting_array()` as a content source
   - mojibake strings such as `Рџ`, `Рґ`, `Р»`
7. Keep source-of-truth boundaries:
   - Pages: page title/content/excerpt.
   - Menus: navigation.
   - Media: editable images and featured images.
   - CPTs/blocks: repeatable services, prices, process, reviews.
   - Customizer: global contacts, analytics, verification, global CTA fallback.
8. Edit only source files, then sync to XAMPP theme.
9. Run seed/import only with XAMPP PHP: `C:\xampp\php\php.exe`.
10. Verify with lint, HTTP smoke, and responsive browser checks.

## Orchestration Roles

| Subagent | Mini Task | Output |
|---|---|---|
| `agent-skill-scout` | Check available WP skills/tools/plugins and project docs before implementation. | Capability note and blockers. |
| `agent-wp-architecture` | Keep native WP architecture clean: no route overlay, no JSON content in Customizer. | File-level architecture findings/fixes. |
| `agent-theme-builder` | Port visual wrappers into WP templates and template parts. | Edited PHP/CSS/JS files. |
| `agent-content-mapper` | Map Webasyst content into WP Pages, Menus, Media, CPTs/blocks. | Seed/update plan and content checks. |
| `agent-seo-qa` | Check URLs, canonical, titles, 404, redirects, smoke pages. | QA report with failures and evidence. |

## Forbidden Shortcuts

- Do not copy Smarty control logic into PHP templates.
- Do not use Customizer JSON arrays for page sections.
- Do not hardcode editable page text in templates when a WP Page/CPT can own it.
- Do not add plugin dependency to solve base theme architecture.
- Do not treat `preview.html` as proof of WordPress readiness.
