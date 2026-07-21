# QA Log

## 2026-07-21 WordPress Port Closeout

- Scope: Webasyst reference `http://vetritual.lvh.me/` versus WordPress `http://localhost/vetritual-wp/`.
- Pages: `/`, `/uslugi/`, `/o-nas/`, `/tseny/`, `/kontakty/`, `/usyplenie-zhivotnyh/`, `/krematsyja-zhyvotnyh/`, `/vyvoz-zhivotnyh/`, synthetic 404.
- Viewports: 360, 768, 1280.
- Result: 27 browser comparisons, 0 diffs in hero/title/lead/hero geometry/container width/overflow/compat mode.
- Evidence: `audit-screenshots/wp-port-2026-07-21-final/metrics.json` and matching viewport screenshots.
- PHP lint: `theme-options.php` and `header.php` passed.
- Deferred polish: no visible media blocker; manifest is now linked in WordPress and uses relative local icon paths.

## 2026-07-21 Remaining 3 Points QA

- Scope: visual side-by-side, native WordPress editability, pre-production checklist.
- Reference URLs: Webasyst `http://vetritual.lvh.me/`; WordPress `http://localhost/vetritual-wp/`.
- Evidence: `C:\xampp\tmp-playwright\vetritual-wp-qa\compare-remaining-3\summary.json`, `compact.json`, screenshots in `original`, `wordpress`, and `diff`.

| Check | Status | Confirmed result | Next atomic task |
| --- | --- | --- | --- |
| Visual side-by-side at 360/768/1280 | PASS with polish notes | All compared pages return expected 200/404, H1 text matches, no horizontal overflow, home section order matches, H1 computed typography matches. Pixel diff max: `tseny` 24% at 360, home 19.24% at 360, 404 23.62% at 360. | Polish mobile `/tseny/` first screen and review mobile media/content offsets where pixel diff is above 15%. |
| Hero/layout geometry | PASS with minor deltas | Hero Y delta is 0 on all pages/viewports. Container width delta is 28 px only at 360; 0 at 768/1280. | Decide whether mobile shell width must be exact Webasyst parity or acceptable WP viewport padding. |
| Console/load QA | WARN | Browser console shows CSP blocks for inline scripts involving Kaspersky local injection/speculation rules. Theme files, `wp-content`, active plugins, and Apache conf search did not locate CSP source; active plugins and mu-plugins are empty. | Re-check on clean browser/profile or production server without antivirus injection before final release sign-off. |
| Native WP editability | PASS | Front page and all core pages are published, use default page template, have editable title/content/excerpt/featured image. Primary menu has 4 items; footer services menu has 3. CPTs exist in admin: `vr_price_group` 3, `vr_process_step` 4, `vr_review` 2. | Editor acceptance pass: manually open Pages, Menus, Media, Prices, Process Steps, Reviews in admin and confirm non-technical editing flow. |
| No legacy JSON content settings | PASS | `vr_theme_options` has 46 global keys and no `*_json` keys. Content-like keys are global contacts/CTA/meta/cookie/copyright, not page section payloads. | Keep page/service/price/review content out of Customizer/theme settings. |
| OG/favicons/canonical | PASS local, PROD pending | Local pages expose `og:image`; favicons/manifest are linked. Canonical is local `http://localhost/vetritual-wp/...`, as expected in local WP. | Before production switch, set WP `home` and `siteurl` to the production domain and re-check canonical/OG URLs over HTTPS. |
| Forms/phones/analytics | WARN | No `<form>` elements detected on core pages. Phone links resolve to `tel:+79535331600`. Analytics IDs are empty, so counters are not emitted. | If leads require forms, add native WP form handling or confirmed external integration. Set analytics IDs only after owner provides final counters. |
| Backup/deploy readiness | PENDING | No deploy archive or production backup was created in this QA-only iteration. | Before deploy, create DB export and theme/uploads backup, then package deployment artifacts only under `deploy-vetritual-modern/`. |
