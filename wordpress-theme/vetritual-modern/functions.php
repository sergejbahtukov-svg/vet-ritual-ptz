<?php
if (! defined('ABSPATH')) {
    exit;
}

define('VR_THEME_VERSION', '1.0');

require_once get_template_directory() . '/inc/helpers/theme-options.php';
require_once get_template_directory() . '/inc/setup.php';

function vr_setup_theme() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');

    register_nav_menus(
        array(
            'primary' => __('Главное меню', 'vetritual-modern'),
        )
    );
}
add_action('after_setup_theme', 'vr_setup_theme');

function vr_route_rewrite_rules() {
    add_rewrite_tag('%vr_route_page%', '([^&]+)');

    foreach (array_keys(vr_route_map()) as $slug) {
        add_rewrite_rule(sprintf('^%s/?$', preg_quote($slug, '#')), 'index.php?vr_route_page=' . $slug, 'top');
    }
    add_rewrite_rule('^about/?$', 'index.php?vr_route_page=o-nas', 'top');
    add_rewrite_rule('^vyvoz-umershih-zhivotnyh/?$', 'index.php?vr_route_page=vyvoz-zhivotnyh', 'top');
    add_rewrite_rule('^vyvoz-umershikh-zhivotnyh/?$', 'index.php?vr_route_page=vyvoz-zhivotnyh', 'top');
    add_rewrite_rule('^vyvoz-tela-zhivotnogo/?$', 'index.php?vr_route_page=vyvoz-zhivotnyh', 'top');
}
add_action('init', 'vr_route_rewrite_rules');

function vr_route_query_vars($vars) {
    $vars[] = 'vr_route_page';
    return $vars;
}
add_filter('query_vars', 'vr_route_query_vars');

function vr_route_alias_redirects() {
    if (is_admin() || wp_doing_ajax()) {
        return;
    }

    $path = '';
    if (! empty($_SERVER['REQUEST_URI'])) {
        $path = wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    $path = trim((string)$path, '/');
    if ($path === 'about') {
        wp_safe_redirect(home_url('/o-nas/'), 301);
        exit;
    }

    $aliases = vr_route_aliases();
    if (array_key_exists($path, $aliases) && $path !== 'about') {
        wp_safe_redirect(home_url('/' . $aliases[$path] . '/'), 301);
        exit;
    }
}
add_action('template_redirect', 'vr_route_alias_redirects');

function vr_route_meta($key, $default = '') {
    $route = vr_get_route_info();
    if (! is_array($route) || ! isset($route[$key]) || empty($route[$key])) {
        return $default;
    }

    return $route[$key];
}

function vr_theme_settings_fields_sections() {
    return array(
        'vr_general' => array(
            'title' => __('Бренд и контакты', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Базовые контактные и брендовые данные.', 'vetritual-modern') . '</p>';
            },
        ),
        'vr_hero' => array(
            'title' => __('Hero и CTA', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Главная секция и основные кнопки.', 'vetritual-modern') . '</p>';
            },
        ),
        'vr_sections' => array(
            'title' => __('Контентные блоки', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Контент для главной, цен, услуг и отзывов.', 'vetritual-modern') . '</p>';
            },
        ),
        'vr_seo' => array(
            'title' => __('SEO и домен', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Title/description, OG и verification-метки.', 'vetritual-modern') . '</p>';
            },
        ),
        'vr_analytics' => array(
            'title' => __('Аналитика и согласие', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Режимы cookie и идентификаторы интеграций.', 'vetritual-modern') . '</p>';
            },
        ),
    );
}

function vr_sanitize_theme_settings($input) {
    if (! is_array($input)) {
        return array();
    }

    $output = array();
    $defaults = vr_theme_setting_defaults();
    $definitions = vr_theme_option_fields();
    $json_fields = array(
        'services_cards_json',
        'prices_cards_json',
        'process_steps_json',
        'reviews_json',
        'about_features_json',
    );

    foreach ($definitions as $key => $field) {
        if (! array_key_exists($key, $input)) {
            continue;
        }

        $value = wp_unslash($input[$key]);
        if (! is_scalar($value)) {
            $value = '';
        } else {
            $value = (string)$value;
        }

        if (in_array($key, $json_fields, true)) {
            if (json_decode($value, true) === null) {
                $value = $defaults[$key];
            }
        } else {
            if (in_array($key, array('custom_head_html', 'body_start_html', 'body_end_html'), true)) {
                $value = wp_kses_post($value);
            } else {
                $value = sanitize_text_field($value);
            }
        }

        $output[$key] = $value;
    }

    return $output;
}
add_action('admin_init', function () {
    register_setting(
        'vr_theme_options_group',
        'vr_theme_options',
        array(
            'type' => 'array',
            'sanitize_callback' => 'vr_sanitize_theme_settings',
        )
    );

    $fields = vr_theme_option_fields();
    $sections = vr_theme_settings_fields_sections();
    foreach ($sections as $section_id => $section) {
        add_settings_section($section_id, $section['title'], $section['callback'], 'vr_theme_options');
    }

    foreach ($fields as $key => $meta) {
        add_settings_field(
            'vr_theme_' . $key,
            $meta['label'],
            'vr_render_theme_setting_field',
            'vr_theme_options',
            $meta['section'],
            array(
                'key' => $key,
                'field' => $meta,
            )
        );
    }
});

function vr_render_theme_setting_field($args) {
    $key = $args['key'];
    $field = $args['field'];
    $value = vr_theme_setting($key, '');
    $name = 'vr_theme_options[' . esc_attr($key) . ']';
    $rows = isset($field['rows']) ? (int)$field['rows'] : 8;
    $type = $field['type'];

    if ('textarea' === $type) {
        echo '<textarea id="vr_theme_' . esc_attr($key) . '" name="' . esc_attr($name) . '" rows="' . esc_attr($rows) . '" class="large-text code" style="height: 160px; width: 100%;">' . esc_textarea((string)$value) . '</textarea>';
        return;
    }

    echo '<input id="vr_theme_' . esc_attr($key) . '" name="' . esc_attr($name) . '" value="' . esc_attr((string)$value) . '" class="regular-text" type="text">';
}

function vr_add_settings_page() {
    add_theme_page(
        __('Настройки темы Vet Ritual', 'vetritual-modern'),
        __('Настройки темы', 'vetritual-modern'),
        'manage_options',
        'vr-theme-options',
        'vr_render_theme_settings_page'
    );
}
add_action('admin_menu', 'vr_add_settings_page');

function vr_render_theme_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Настройки темы Vet Ritual', 'vetritual-modern'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('vr_theme_options_group');
            do_settings_sections('vr_theme_options');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function vr_render_theme_assets() {
    wp_enqueue_style('vetritual-theme-style', get_template_directory_uri() . '/assets/css/theme.css', array(), VR_THEME_VERSION);
    wp_enqueue_script('vetritual-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array(), VR_THEME_VERSION, true);
    wp_localize_script(
        'vetritual-theme-js',
        'vrThemeConfig',
        array(
            'cookieKey' => vr_theme_setting('cookie_consent_key', 'vr_cookie_consent'),
        )
    );

    $mode = vr_theme_setting('cookie_consent_mode', 'disabled');
    $integrations_payload = array(
        'mode' => $mode,
        'cookieKey' => vr_theme_setting('cookie_consent_key', 'vr_cookie_consent'),
        'ymId' => vr_theme_setting('yandex_metrika_id', ''),
        'ymWebvisor' => vr_theme_setting_bool('yandex_metrika_webvisor', false),
        'ymEcommerce' => vr_theme_setting_bool('yandex_metrika_ecommerce', false),
        'ga4Id' => vr_theme_setting('ga4_id', ''),
        'gtmId' => vr_theme_setting('gtm_id', ''),
        'vkId' => vr_theme_setting('vk_pixel_id', ''),
        'metaId' => vr_theme_setting('meta_pixel_id', ''),
        'topmailruId' => vr_theme_setting('topmailru_counter_id', ''),
        'tiktokId' => vr_theme_setting('tiktok_pixel_id', ''),
    );

    $has_integrations = ! empty($integrations_payload['ymId']) || ! empty($integrations_payload['ga4Id']) || ! empty($integrations_payload['gtmId']) || ! empty($integrations_payload['vkId']) || ! empty($integrations_payload['metaId']) || ! empty($integrations_payload['topmailruId']) || ! empty($integrations_payload['tiktokId']);
    if ($mode !== 'disabled' && $has_integrations) {
        wp_register_script(
            'vetritual-integrations-js',
            get_template_directory_uri() . '/assets/js/integrations.js',
            array('vetritual-theme-js'),
            VR_THEME_VERSION,
            true
        );
        wp_localize_script('vetritual-integrations-js', 'vrAnalyticsConfig', $integrations_payload);
        wp_enqueue_script('vetritual-integrations-js');
    }
}
add_action('wp_enqueue_scripts', 'vr_render_theme_assets');
