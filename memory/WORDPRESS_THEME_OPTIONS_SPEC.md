# WordPress Theme Options Specification

## 1) Роль документа
Этот документ описывает полный перечень настраиваемых параметров темы, которые должны быть доступны пользователю в WP без ручного редактирования кода.  
Он используется как контракт между `agent-content-mapper`, `agent-wp-architecture` и `agent-theme-builder`.

## 2) Группы настроек

### 2.1. Блок бренда и контактов
- `site_name` — текстовое поле (default: название компании).
- `site_city` — текстовое поле (город/регион).
- `phone_main` — телефон (форматированный текст).
- `phone_secondary` — дополнительный телефон.
- `email_contact` — e-mail.
- `whatsapp_url` — URL для WhatsApp/мессенджера.
- `address_text` — многострочный текст адреса.

### 2.2. Блок Hero и CTA
- `hero_title` — заголовок.
- `hero_subtitle` — подзаголовок.
- `hero_primary_cta_text` — текст кнопки.
- `hero_primary_cta_url` — URL кнопки.
- `hero_secondary_cta_text` — текст второй кнопки.
- `hero_secondary_cta_url` — URL второй кнопки.
- `hero_image_id` — ID/URL изображения в медиатеке.

### 2.3. Услуги и секции
- `services_intro_title` — заголовок секции услуг.
- `services_intro_text` — описание.
- `services_list_json` — JSON/реестр карточек услуг с:
  - `title`
  - `text`
  - `icon`
  - `link`

### 2.4. Блоки страниц/формы
- `consultation_form_title`
- `consultation_form_text`
- `contact_block_title`
- `contact_block_phone`
- `contact_block_email`
- `contact_block_address`

### 2.5. SEO fallback
- `default_meta_title`
- `default_meta_description`
- `og_image_id`
- `twitter_card_type` — `summary`/`summary_large_image`.
- `robots_default` — `index,follow` по умолчанию.

### 2.6. Cookie/consent
- `cookie_consent_mode` — `always|on_consent|disabled`.
- `cookie_banner_text`
- `cookie_button_accept`
- `cookie_button_reject`
- `consent_integration_metrika`
- `consent_integration_ga`
- `consent_integration_gtm`
- `consent_integration_vk`
- `consent_integration_meta`

## 3) Технические требования
- Все значения читаются через `vr_theme_setting($key, $default = '')`.
- Вывод в шаблонах через соответствующие `esc_*` функции.
- Для массивных блоков (например, список услуг) — валидация формата и fallback на безопасные дефолты.
- Изменения должны быть доступны из:
  1) `Customizer` (базовые поля),
  2) `Settings API` (структурированные блоки),
  3) `ACF option page` (по необходимости для визуального редактора блоков).
- Протестировать, что не происходит fatal при пустых значениях после импорта/миграции.

## 4) Acceptance Criteria для сабагента
- Документ покрывает все поля из Webasyst scope (header/footer/home/page/seo/forms/consents).
- `agent-wp-architecture` реализует минимум один источник данных (customizer/options/acf) для каждой категории.
- `agent-seo-qa` проверяет наличие и корректность fallback-полей.
