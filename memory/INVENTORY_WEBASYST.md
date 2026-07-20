# Инвентаризация Webasyst темы `vetritual-modern`

## Цель
Дать полный список того, что нужно перенести в WordPress без потери контента, логики и SEO-цепочки.

## 1) Маршруты и типы контента, найденные в теме
1. `/` → главная (`index.html` + `home.html`).
2. `/o-nas/` → страница “О нас” (`page.url == o-nas`, контент из `about.html` с доп. секцией контактов).
3. `/uslugi/` → служебная страница со списком услуг (карта из `page.html` + `home.html` сервисные карточки в некоторых местах).
4. `/usyplenie-zhivotnyh/` → услуга “усыпление животных”.
5. `/usyplenie-koshek/` → услуга “усыпление кошек”.
6. `/usyplenie-sobak/` → услуга “усыпление собак”.
7. `/krematsyja-zhivotnyh/` → услуга “кремация животных”.
8. `/obschaja-krematsyja/` → услуга “общая кремация”.
9. `/individualnaja-krematsyja/` → услуга “индивидуальная кремация”.
10. `/vyvoz-zhivotnyh/` → услуга “вывоз животных”.
11. `/vyvoz-umershih-zhivotnyh/` → алиас старого URL для услуги вывоза.
12. `/vyvoz-umershikh-zhivotnyh/` → алиас старого URL для услуги вывоза.
13. `/vyvoz-tela-zhivotnogo/` → алиас старого URL для услуги вывоза.
14. `/tseny/` → прайс.
15. `/kontakty/` → контакты.
16. `/about/` → алиас `o-nas` (по комментариям в `WORDPRESS_MIGRATION_WORKFLOW.md`).
17. 404: `error.html` с подстановкой кода ошибки.

## 2) Компоненты макета из Webasyst
1. `index.html` — глобальный shell, head, canonical/OG/robots, схемы, подключения интеграций.
2. `header.html` — логотип, меню, CTA-звонок, мобильный переключатель.
3. `footer.html` — бренд, блоки ссылок, контакты, адрес/телефон.
4. `page.html` — роутинг страницы, hero, условные секции по `page.url`, вывод `$page.content`.
5. `home.html` — hero, блок услуг, CTA, секция цен, отзывы, процесс, контакты.
6. `about.html` — блок с преимуществами/доверительным контентом.
7. `error.html` — верстка ошибки.
8. `css/theme.css` — ключевые стили и медиа-запросы.
9. `js/theme.js` — UI-логика, слайдер и мобильное меню.
10. `js/integrations.js` — загрузка аналитики и согласие cookie.

## 3) SEO/метаданные (из `index.html`)
1. Базовый домен для canonical: `https://vet-ritual-ptz.ru`.
2. Путь берется из `$wa->currentUrl(false, true)`.
3. Для каждого известного пути жёстко заданы:
   - заголовок страницы,
   - description.
4. Для всех не-404: canonical + OpenGraph.
5. Для 404: `robots` = `noindex, follow`.
6. JSON-LD:
   - `LocalBusiness`,
   - `WebPage`,
   - `BreadcrumbList` для внутренних страниц.

## 4) Theme Settings, используемые в текущей сборке
1. `vr_theme_color`
2. `vr_yandex_verification`, `vr_google_verification`, `vr_bing_verification`, `vr_mailru_verification`.
3. `vr_analytics_load_mode`, `vr_analytics_cookie_key`, `vr_yandex_metrika_id`, `vr_yandex_metrika_webvisor`, `vr_yandex_metrika_ecommerce`, `vr_ga4_measurement_id`, `vr_gtm_container_id`, `vr_vk_pixel_id`, `vr_meta_pixel_id`, `vr_topmailru_counter_id`, `vr_tiktok_pixel_id`.
4. `vr_custom_head_html`, `vr_body_start_html`, `vr_body_end_html`.

## 5) Скрипты и интеграции
1. UI-логика в `theme.js`:
   - мобильное меню,
   - слайдер услуг,
   - cookie banner.
2. Интеграции в `integrations.js`:
   - режим загрузки always / after_cookie_accept / disabled,
   - поддержка `cookie consent`.

## 6) Риски переноса, которые нужно закрыть до WP build
1. Дублирующиеся URL: `/about/` и `o-nas`, 3 алиаса для `/vyvoz-zhivotnyh/`.
2. Неэкранированный вывод `$page.content` требует эквивалентной обработке в WP (`wp_kses_post`/контролируемый блок).
3. Различные OG-картики в Webasyst сейчас почти фиксированы через домен и файл; нужно определить fallback-стратегию в WP.
4. Функции cookie-согласия должны сохранить текущий UX и не ломать интеграции.
5. Навигация в хедере/футере должна остаться синхронизированной с URL и SEO-контентом.

