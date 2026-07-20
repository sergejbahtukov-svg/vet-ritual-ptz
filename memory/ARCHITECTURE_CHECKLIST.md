# Architecture Checklist (до начала сборки WP темы)

## 1) Базовый каркас темы
1. `style.css` и `functions.php` созданы.
2. `index.php`, `front-page.php`, `page.php`, `404.php`, `header.php`, `footer.php` есть.
3. `template-parts/` содержит ключевые partials:
   - hero,
   - services,
   - contact,
   - prices,
   - reviews,
   - process,
   - footer-widgets,
   - content-page.
4. Assets:
   - `assets/css/theme.css`,
   - `assets/js/theme.js`,
   - `assets/js/integrations.js`.
5. `inc/` каталог:
   - `inc/helpers/theme-options.php`,
   - при необходимости `inc/integrations.php`, `inc/route.php`.
6. `theme.json` для базовых настроек редактора и блоков.

## 2) Роутинг и меню
1. Карта URL в `CONTENT_MAP.md` подтверждена.
2. Настроены алиасы и редиректы:
   - `/about/` → `/o-nas/`,
   - `/vyvoz-umershih-zhivotnyh/` → `/vyvoz-zhivotnyh/`,
   - `/vyvoz-umershikh-zhivotnyh/` → `/vyvoz-zhivotnyh/`,
   - `/vyvoz-tela-zhivotnogo/` → `/vyvoz-zhivotnyh/`.
3. Header и footer ссылки приводятся только к существующим маршрутам.
4. Навигация учитывает мобильный вариант и доступность (`aria`).

## 3) Theme Settings слой
1. Реализован единый helper:
2. Функция `vr_theme_setting($key, $default = '')`.
3. Источник значений: `theme_mods` + `options` + `ACF options`.
4. Есть строгий fallback и типизация:
   - `string`,
   - `bool/int`,
   - JSON массив для карточек.
5. Все значения в шаблонах выводятся через `esc_html`/`esc_url`/`wp_kses_post`.

## 4) Безопасность и соответствие WordPress
1. Никаких прямых включений `$_GET`/`$_REQUEST` в шаблоны без санитайза.
2. Нет inline SQL в шаблонах.
3. Для произвольного HTML — только trusted options и роль администратора.
4. Cookie-логика вынесена в отдельный скрипт с проверкой режима.

## 5) Интеграции
1. `integrations.js` подключается только если есть mode и ключи.
2. Поддержка `always`, `after_cookie_accept`, `disabled`.
3. Для `after_cookie_accept` — чтение ключа из `localStorage` и вызов `window.vrAcceptAnalytics()`.
4. Поддержать `body_start/body_end` HTML placeholders.

## 6) Acceptance Criteria перед build
1. `WORDPRESS_THEME_OPTIONS_SPEC.md` согласован с `THEME_SETTINGS_CONTRACT.md`.
2. Архитектурные артефакты созданы и проверены `agent-wp-architecture`.
3. `BUILD_TEMPLATE_LIST.md` + `BUILD_LOG.md` согласованы с текущей структурой.
4. Критические артефакты Webasyst инвентаризации и рисков закрыты.

