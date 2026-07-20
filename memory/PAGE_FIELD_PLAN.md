# Полевой план для страницы (Webasyst → WordPress)

## 1) Базовая модель страниц
1. `page.url` (Webasyst) → `post_name` (WordPress).
2. `page.name` (Webasyst) → `post_title` (WordPress).
3. `page.content` (Webasyst) → `post_content` (WordPress) + `wp_kses_post`-санация при выводе.
4. Доп. SEO в старом шаблоне сейчас формируется по пути; в WP это:
   - отдельная таблица/настройка в Theme Options или ACF.
   - если нет значения в поле, использовать глобальный fallback.

## 2) Контентные поля, которые нужно создать в WordPress
1. Поля контента страницы:
   - `vr_page_url` (для отладки роутинга),
   - `vr_page_lead`,
   - `vr_page_hero_class`,
   - `vr_page_content_fallback`.
2. Для главной страницы:
   - `home_hero_title`, `home_hero_subtitle`,
   - `home_services`, `home_prices`, `home_reviews`, `home_process_steps`.
3. Для услуг:
   - `service_cards_json`,
   - `service_prices_json`,
   - `service_process_json`.
4. Для контактов:
   - `contact_phone`, `contact_phone2`,
   - `contact_address`,
   - `contact_email`,
   - `contact_hours`.
5. Для блоков о компании:
   - `about_intro`,
   - `about_features_json`,
   - `about_services_brief`.

## 3) SEO-поля для маршрутов
1. `vr_page_title` (legacy from Webasyst route matrix).
2. `vr_meta_description` (legacy from route matrix).
3. `vr_robots` (default `index, follow`, для `404` — `noindex, follow`).
4. `vr_canonical_url` (выполняется автоматически через domain+path).
5. `vr_og_type`, `vr_twitter_card`, `vr_og_image`.

## 4) Integrations fields
1. `vr_analytics_mode` (`always|after_cookie_accept|disabled`).
2. `vr_cookie_consent_key`.
3. `vr_yandex_metrika_id`, `vr_ga4_id`, `vr_gtm_id`, `vr_vk_pixel_id`, `vr_meta_pixel_id`, `vr_tiktok_pixel_id`, `vr_topmailru_counter_id`.
4. `vr_custom_head_html`, `vr_body_start_html`, `vr_body_end_html` (only trusted admin role).

## 5) Маппинг статусов заполнения
1. `required` — поля, которые должны быть заполнены минимум для публикации маршрута:
   - title/description,
   - content/post_content,
   - contacts на `/kontakty/`.
2. `recommended` — контент для блоков:
   - цены,
   - преимущества,
   - контакты в footer/header.
3. `optional` — альтернативные OG/соц теги и рекламные вставки.

## 6) Приоритеты источников значений
1. Для UI/контента страниц: ACF → `page` postmeta → Theme Options.
2. Для SEO/метаданных: Theme Options → ACF страницы → fallback из route map.
3. Для интеграций и html-injection: Theme Options только (только администратор).

