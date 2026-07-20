# Build Template List (to be populated by agent-theme-builder)

- `front-page.php`
- `page.php`
- `single.php`
- `404.php`
- `header.php`
- `footer.php`
- `index.php`
- `assets/css/theme.css`
- `assets/js/theme.js`
- `assets/js/integrations.js`
- `template-parts/content-about.php`
- `template-parts/content-contact.php`
- `template-parts/content-hero.php`
- `template-parts/content-page.php`
- `template-parts/content-prices.php`
- `template-parts/content-process.php`
- `template-parts/content-reviews.php`
- `template-parts/content-services.php`

## Готово к сборке (фактическое состояние)
- `theme.json`
- `theme-options` слой (`inc/helpers/theme-options.php` + `inc/setup.php` интеграция)
- `functions.php` с enqueue, локализацией и маршрутизацией

## Quality constraints
- Имена файлов должны соответствовать секциям из Webasyst:
  - `home` → `front-page.php` (+ частичные шаблоны)
  - `about`/`page` → `page.php` с ACF-полями
  - `error` → `404.php`
- Иерархия шаблонов должна быть зафиксирована в `BUILD_LOG.md`.
