# Theme Settings Contract (WordPress, user-configurable first)

## 1) Цель
1. Все настройки, влияющие на внешний вид и поведение, должны быть настраиваемыми из админки без редактирования шаблонов.
2. Любая настройка в шаблонах всегда имеет безопасный fallback.

## 2) Источник данных и приоритеты
1. Приоритет 1: ACF Options Page (`theme_global_*`).
2. Приоритет 2: Theme Options / Customizer (`theme_mods`).
3. Приоритет 3: `theme.json` defaults (editor-facing).
4. Приоритет 4: hardcoded fallback constants из `theme-options.php`.

## 3) Обязательные поля для пользователя
1. `site_name` — название компании.
2. `site_city` — город обслуживания.
3. `phone_main` — основной телефон.
4. `phone_secondary` — дополнительный телефон.
5. `contact_email` — email.
6. `address_text` — адрес.
7. `hero_title`, `hero_subtitle`.
8. `hero_primary_cta_text`, `hero_primary_cta_url`.
9. `hero_secondary_cta_text`, `hero_secondary_cta_url`.
10. `default_meta_title`, `default_meta_description`.
11. `og_image_id`, `twitter_card_type`.
12. `cookie_consent_mode`.

## 4) Рекомендуемые поля (опционально, но включены в контракт)
1. `services_intro_title`, `services_intro_text`.
2. `consultation_form_title`, `consultation_form_text`.
3. `contact_block_title`, `contact_block_phone`, `contact_block_email`, `contact_block_address`.
4. `cookies_text`, `cookie_button_accept`, `cookie_button_reject`.
5. `analytics keys`: `yandex_metrika_id`, `ga4_id`, `gtm_id`, `vk_pixel_id`, `meta_pixel_id`, `topmailru_counter_id`, `tiktok_pixel_id`.
6. `custom_head_html`, `body_start_html`, `body_end_html` (trusted users only).

5) Output policy
1. Все строковые поля выводятся через `esc_html`/`esc_url`.
2. Контентные/списковые поля через `wp_kses_post` и ограниченный allowlist.
3. JSON-списки валидируются при сохранении/чтении.
4. В шаблонах не должно быть прямого чтения глобальных массивов настроек без helper.

6) Runtime policy
1. Режим интеграций:
2. `always` — scripts подгружаются сразу.
3. `after_cookie_accept` — ждём `localStorage` ключ, затем запуск.
4. `disabled` — интеграции не грузим до ручного включения.
2. Значения куки/ключа согласия едины между PHP и JS.

7) Acceptance
1. Менеджер может изменить контактные данные, телефоны и CTA без редактирования PHP.
2. Команда может отключить интеграции для staging через `cookie_consent_mode = disabled`.
3. Любой новый блок на главной получает настройки через опции, а не через hardcoded values.

