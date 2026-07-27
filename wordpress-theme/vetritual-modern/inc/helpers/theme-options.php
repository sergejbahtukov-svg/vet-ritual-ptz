<?php
if (! defined('ABSPATH')) {
    exit;
}

function vr_theme_setting_defaults() {
    return array(
        'public_domain_url' => 'https://vet-ritual-ptz.ru',
        'site_name' => 'Vet Ritual PTZ',
        'logo_attachment_id' => 0,
        'site_description' => 'Ритуальные вет-услуги для домашних животных в Петрозаводске и Карелии',
        'site_city' => 'Петрозаводск и Карелия',
        'brand_tagline' => 'бережная помощь 24/7',
        'phone_main' => '+7 953 533-16-00',
        'phone_secondary' => '',
        'contact_email' => '',
        'address_text' => 'Республика Карелия, г. Петрозаводск, пр. Энергетиков, 33',
        'social_vk_url' => '',
        'social_telegram_url' => '',
        'social_whatsapp_url' => '',
        'business_hours_text' => 'Круглосуточно, без выходных',
        'footer_secondary_text' => 'Внимательное сопровождение и поддержка в сложный момент',
        'footer_disclaimer' => 'Информация на сайте носит информационный характер и не является публичной офертой.',
        'theme_color' => '#fffdf8',
        'media_base_url' => '',
        'default_meta_title' => 'Усыпление и кремация животных в Петрозаводске | Vet Ritual',
        'default_meta_description' => 'Бережное усыпление, кремация и вывоз домашних животных в Петрозаводске и Карелии. Круглосуточно, аккуратное сопровождение, понятные условия.',
        'og_image' => 'og-logo-share.png',
        'twitter_card_type' => 'summary_large_image',
        'cookie_consent_mode' => 'disabled',
        'cookie_consent_key' => 'vr_cookie_consent',
        'cookie_banner_text' => 'Мы используем cookie, чтобы сайт работал стабильно и корректно учитывал согласие.',
        'cookie_banner_heading' => 'Мы используем cookie',
        'cookie_button_accept' => 'Хорошо',
        'cookie_button_reject' => 'Позже',
        'yandex_metrika_id' => '',
        'yandex_metrika_webvisor' => '0',
        'yandex_metrika_ecommerce' => '0',
        'ga4_id' => '',
        'gtm_id' => '',
        'vk_pixel_id' => '',
        'meta_pixel_id' => '',
        'topmailru_counter_id' => '',
        'tiktok_pixel_id' => '',
        'yandex_verification' => '701ae8a1515ea5e3',
        'google_verification' => '',
        'bing_verification' => '',
        'mailru_verification' => '',
        'custom_head_html' => '',
        'body_start_html' => '',
        'body_end_html' => '',
        'copyright_text' => 'vet-ritual-ptz.ru © 2026',
    );
}

function vr_theme_option_fields() {
    return array(
        'logo_attachment_id' => array('section' => 'vr_general', 'label' => 'Логотип', 'type' => 'media'),
        'site_name' => array('section' => 'vr_general', 'label' => 'Название компании', 'type' => 'text'),
        'site_description' => array('section' => 'vr_general', 'label' => 'Описание сайта', 'type' => 'textarea', 'rows' => 3),
        'site_city' => array('section' => 'vr_general', 'label' => 'Город/регион', 'type' => 'text'),
        'brand_tagline' => array('section' => 'vr_general', 'label' => 'Подпись в логотипе', 'type' => 'text'),
        'phone_main' => array('section' => 'vr_general', 'label' => 'Основной телефон', 'type' => 'text'),
        'phone_secondary' => array('section' => 'vr_general', 'label' => 'Дополнительный телефон', 'type' => 'text'),
        'contact_email' => array('section' => 'vr_general', 'label' => 'Контактный email', 'type' => 'text'),
        'address_text' => array('section' => 'vr_general', 'label' => 'Адрес', 'type' => 'textarea', 'rows' => 4),
        'business_hours_text' => array('section' => 'vr_general', 'label' => 'Режим работы', 'type' => 'text'),
        'theme_color' => array('section' => 'vr_general', 'label' => 'Цвет темы браузера', 'type' => 'text'),
        'media_base_url' => array('section' => 'vr_general', 'label' => 'Базовый URL медиа, если ассеты вынесены', 'type' => 'text'),

        'social_vk_url' => array('section' => 'vr_social', 'label' => 'Ссылка ВКонтакте', 'type' => 'url'),
        'social_telegram_url' => array('section' => 'vr_social', 'label' => 'Ссылка Telegram', 'type' => 'url'),
        'social_whatsapp_url' => array('section' => 'vr_social', 'label' => 'Ссылка WhatsApp', 'type' => 'url'),
        'footer_secondary_text' => array('section' => 'vr_social', 'label' => 'Текст в подвале', 'type' => 'text'),
        'footer_disclaimer' => array('section' => 'vr_social', 'label' => 'Юридическое примечание в подвале', 'type' => 'textarea', 'rows' => 3),

        'public_domain_url' => array('section' => 'vr_seo', 'label' => 'Публичный домен', 'type' => 'url'),
        'default_meta_title' => array('section' => 'vr_seo', 'label' => 'Meta title по умолчанию', 'type' => 'text'),
        'default_meta_description' => array('section' => 'vr_seo', 'label' => 'Meta description по умолчанию', 'type' => 'textarea', 'rows' => 4),
        'og_image' => array('section' => 'vr_seo', 'label' => 'OG изображение по умолчанию', 'type' => 'text'),
        'twitter_card_type' => array('section' => 'vr_seo', 'label' => 'Twitter card type', 'type' => 'text'),
        'yandex_verification' => array('section' => 'vr_seo', 'label' => 'Yandex verification', 'type' => 'text'),
        'google_verification' => array('section' => 'vr_seo', 'label' => 'Google verification', 'type' => 'text'),
        'bing_verification' => array('section' => 'vr_seo', 'label' => 'Bing verification', 'type' => 'text'),
        'mailru_verification' => array('section' => 'vr_seo', 'label' => 'Mail.ru verification', 'type' => 'text'),

        'cookie_consent_mode' => array('section' => 'vr_analytics', 'label' => 'Режим cookie consent', 'type' => 'text'),
        'cookie_consent_key' => array('section' => 'vr_analytics', 'label' => 'Cookie key', 'type' => 'text'),
        'cookie_banner_text' => array('section' => 'vr_analytics', 'label' => 'Текст cookie banner', 'type' => 'textarea', 'rows' => 4),
        'cookie_banner_heading' => array('section' => 'vr_analytics', 'label' => 'Заголовок cookie banner', 'type' => 'text'),
        'cookie_button_accept' => array('section' => 'vr_analytics', 'label' => 'Кнопка согласия', 'type' => 'text'),
        'cookie_button_reject' => array('section' => 'vr_analytics', 'label' => 'Кнопка отказа', 'type' => 'text'),
        'yandex_metrika_id' => array('section' => 'vr_analytics', 'label' => 'Yandex Metrika ID', 'type' => 'text'),
        'yandex_metrika_webvisor' => array('section' => 'vr_analytics', 'label' => 'Вебвизор', 'type' => 'checkbox'),
        'yandex_metrika_ecommerce' => array('section' => 'vr_analytics', 'label' => 'Ecommerce', 'type' => 'checkbox'),
        'ga4_id' => array('section' => 'vr_analytics', 'label' => 'GA4 ID', 'type' => 'text'),
        'gtm_id' => array('section' => 'vr_analytics', 'label' => 'GTM ID', 'type' => 'text'),
        'vk_pixel_id' => array('section' => 'vr_analytics', 'label' => 'VK Pixel ID', 'type' => 'text'),
        'meta_pixel_id' => array('section' => 'vr_analytics', 'label' => 'Meta Pixel ID', 'type' => 'text'),
        'topmailru_counter_id' => array('section' => 'vr_analytics', 'label' => 'Top.Mail.Ru counter ID', 'type' => 'text'),
        'tiktok_pixel_id' => array('section' => 'vr_analytics', 'label' => 'TikTok Pixel ID', 'type' => 'text'),
        'custom_head_html' => array('section' => 'vr_analytics', 'label' => 'HTML перед </head>', 'type' => 'textarea', 'rows' => 8),
        'body_start_html' => array('section' => 'vr_analytics', 'label' => 'HTML после <body>', 'type' => 'textarea', 'rows' => 8),
        'body_end_html' => array('section' => 'vr_analytics', 'label' => 'HTML перед </body>', 'type' => 'textarea', 'rows' => 8),
        'copyright_text' => array('section' => 'vr_analytics', 'label' => 'Copyright', 'type' => 'text'),
    );
}

function vr_theme_setting($key, $default = '') {
    $defaults = vr_theme_setting_defaults();
    $fallback = array_key_exists($key, $defaults) ? $defaults[$key] : $default;

    $options = get_option('vr_theme_options', array());
    if (is_array($options) && array_key_exists($key, $options) && $options[$key] !== '') {
        return $options[$key];
    }

    return $fallback;
}

function vr_migrate_legacy_theme_mod_settings() {
    if (get_option('vr_theme_legacy_mod_migration_complete', false)) {
        return;
    }

    $options = get_option('vr_theme_options', array());
    $options = is_array($options) ? $options : array();
    $legacy = array();

    foreach (array_keys(vr_theme_setting_defaults()) as $key) {
        $value = get_theme_mod('vr_theme_' . $key, null);
        if ($value !== null && $value !== '' && (! array_key_exists($key, $options) || $options[$key] === '')) {
            $legacy[$key] = $value;
        }
    }

    $legacy_logo_id = absint(get_theme_mod('custom_logo', 0));
    if ($legacy_logo_id > 0 && empty($options['logo_attachment_id'])) {
        $legacy['logo_attachment_id'] = $legacy_logo_id;
    }

    if (! empty($legacy)) {
        $options = array_merge($options, vr_sanitize_theme_settings($legacy));
        update_option('vr_theme_options', $options);
    }

    update_option('vr_theme_legacy_mod_migration_complete', '1', false);
}
add_action('after_setup_theme', 'vr_migrate_legacy_theme_mod_settings', 20);

function vr_theme_setting_bool($key, $default = false) {
    $value = vr_theme_setting($key, $default ? '1' : '0');
    return in_array((string) $value, array('1', 'true', 'on', 'yes'), true);
}

function vr_theme_media_url($path = '') {
    $path = ltrim((string) $path, '/');
    $base_url = trim((string) vr_theme_setting('media_base_url', ''));

    if ($path !== '' && preg_match('#^https?://#i', $path)) {
        return $path;
    }

    if ($base_url !== '') {
        return trailingslashit($base_url) . $path;
    }

    return trailingslashit(get_template_directory_uri() . '/assets/media') . $path;
}

function vr_route_aliases() {
    return array(
        'tsyeny' => 'tseny',
        'about' => 'o-nas',
        'usyplenie-koshek' => 'usyplenie-zhivotnyh',
        'usyplenie-sobak' => 'usyplenie-zhivotnyh',
        'obschaja-krematsyja' => 'krematsyja-zhyvotnyh',
        'individualnaja-krematsyja' => 'krematsyja-zhyvotnyh',
        'vyvoz-umershih-zhivotnyh' => 'vyvoz-zhivotnyh',
        'vyvoz-umershikh-zhivotnyh' => 'vyvoz-zhivotnyh',
        'vyvoz-tela-zhivotnogo' => 'vyvoz-zhivotnyh',
    );
}
