<?php
if (! defined('ABSPATH')) {
    exit;
}

function vr_customize_sanitize_text($value) {
    return sanitize_text_field(wp_unslash((string) $value));
}

function vr_customize_sanitize_url($value) {
    return esc_url_raw(wp_unslash((string) $value));
}

function vr_customize_sanitize_textarea($value) {
    return sanitize_textarea_field(wp_unslash((string) $value));
}

function vr_customize_sanitize_hex($value) {
    $value = sanitize_hex_color($value);
    return $value ? $value : '#fffdf8';
}

function vr_register_theme_customizer(WP_Customize_Manager $wp_customize) {
    if (! current_user_can('edit_theme_options')) {
        return;
    }

    $defaults = vr_theme_setting_defaults();

    $wp_customize->add_panel(
        'vr_customizer_panel',
        array(
            'title' => __('Vet Ritual Theme', 'vetritual-modern'),
            'priority' => 30,
        )
    );

    $sections = array(
        'vr_customizer_general' => array(
            'title' => __('Основное', 'vetritual-modern'),
            'description' => __('Глобальные данные компании и контакты.', 'vetritual-modern'),
            'priority' => 25,
        ),
        'vr_customizer_social' => array(
            'title' => __('Соцсети и подвал', 'vetritual-modern'),
            'description' => __('Ссылки и глобальный текст в подвале.', 'vetritual-modern'),
            'priority' => 30,
        ),
        'vr_customizer_hero' => array(
            'title' => __('Глобальные CTA', 'vetritual-modern'),
            'description' => __('Кнопки по умолчанию. Заголовки и тексты страниц редактируются в WordPress Pages.', 'vetritual-modern'),
            'priority' => 35,
        ),
        'vr_customizer_colors' => array(
            'title' => __('Цвета', 'vetritual-modern'),
            'description' => __('Токены внешнего вида темы.', 'vetritual-modern'),
            'priority' => 45,
        ),
    );

    foreach ($sections as $id => $args) {
        $wp_customize->add_section(
            $id,
            array(
                'title' => $args['title'],
                'description' => $args['description'],
                'priority' => $args['priority'],
                'panel' => 'vr_customizer_panel',
            )
        );
    }

    $fields = array(
        'site_name' => array('section' => 'vr_customizer_general', 'type' => 'text', 'label' => __('Название компании', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'site_city' => array('section' => 'vr_customizer_general', 'type' => 'text', 'label' => __('Город/регион', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'brand_tagline' => array('section' => 'vr_customizer_general', 'type' => 'text', 'label' => __('Подпись бренда', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'phone_main' => array('section' => 'vr_customizer_general', 'type' => 'text', 'label' => __('Основной телефон', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'phone_secondary' => array('section' => 'vr_customizer_general', 'type' => 'text', 'label' => __('Дополнительный телефон', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'contact_email' => array('section' => 'vr_customizer_general', 'type' => 'text', 'label' => __('Email', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'address_text' => array('section' => 'vr_customizer_general', 'type' => 'textarea', 'label' => __('Адрес', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_textarea'),
        'business_hours_text' => array('section' => 'vr_customizer_general', 'type' => 'text', 'label' => __('Режим работы', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'social_vk_url' => array('section' => 'vr_customizer_social', 'type' => 'text', 'label' => __('ВКонтакте', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_url'),
        'social_telegram_url' => array('section' => 'vr_customizer_social', 'type' => 'text', 'label' => __('Telegram', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_url'),
        'social_whatsapp_url' => array('section' => 'vr_customizer_social', 'type' => 'text', 'label' => __('WhatsApp', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_url'),
        'footer_secondary_text' => array('section' => 'vr_customizer_social', 'type' => 'text', 'label' => __('Текст в подвале', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'hero_primary_cta_text' => array('section' => 'vr_customizer_hero', 'type' => 'text', 'label' => __('Основная кнопка: текст', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'hero_primary_cta_url' => array('section' => 'vr_customizer_hero', 'type' => 'text', 'label' => __('Основная кнопка: ссылка', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_url'),
        'hero_secondary_cta_text' => array('section' => 'vr_customizer_hero', 'type' => 'text', 'label' => __('Вторичная кнопка: текст', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_text'),
        'hero_secondary_cta_url' => array('section' => 'vr_customizer_hero', 'type' => 'text', 'label' => __('Вторичная кнопка: ссылка', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_url'),
        'theme_color' => array('section' => 'vr_customizer_colors', 'type' => 'color', 'label' => __('Цвет темы', 'vetritual-modern'), 'sanitize' => 'vr_customize_sanitize_hex'),
    );

    foreach ($fields as $field_id => $field) {
        $setting_id = 'vr_theme_' . $field_id;
        $default = isset($defaults[$field_id]) ? $defaults[$field_id] : '';

        $wp_customize->add_setting(
            $setting_id,
            array(
                'default' => $default,
                'type' => 'theme_mod',
                'transport' => 'refresh',
                'sanitize_callback' => $field['sanitize'],
            )
        );

        if ('color' === $field['type']) {
            if (class_exists('WP_Customize_Color_Control')) {
                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize,
                        $setting_id . '_control',
                        array(
                            'label' => $field['label'],
                            'section' => $field['section'],
                            'settings' => $setting_id,
                        )
                    )
                );
            }
            continue;
        }

        $wp_customize->add_control(
            $setting_id . '_control',
            array(
                'type' => 'textarea' === $field['type'] ? 'textarea' : 'text',
                'label' => $field['label'],
                'section' => $field['section'],
                'settings' => $setting_id,
            )
        );
    }
}
add_action('customize_register', 'vr_register_theme_customizer');

function vr_register_theme_color_css() {
    $color = vr_theme_setting('theme_color', '#fffdf8');
    echo '<style id="vr-theme-color-inline">:root{--vr-theme-color:' . esc_html($color) . ';}</style>';
}
add_action('wp_head', 'vr_register_theme_color_css');
