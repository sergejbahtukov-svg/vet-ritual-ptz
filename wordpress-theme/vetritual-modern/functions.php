<?php
if (! defined('ABSPATH')) {
    exit;
}

define('VR_THEME_VERSION', '1.0');

require_once get_template_directory() . '/inc/helpers/theme-options.php';
require_once get_template_directory() . '/inc/content-model.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/customizer.php';

function vr_setup_theme() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('customize-selective-refresh-widgets');

    register_nav_menus(
        array(
            'primary' => __('Основное меню', 'vetritual-modern'),
            'footer_services' => __('Меню услуг в подвале', 'vetritual-modern'),
        )
    );
}
add_action('after_setup_theme', 'vr_setup_theme');

function vr_route_alias_redirects() {
    if (is_admin() || wp_doing_ajax()) {
        return;
    }

    $path = '';
    if (! empty($_SERVER['REQUEST_URI'])) {
        $path = wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    $path = trim((string) $path, '/');
    $home_path = trim((string) wp_parse_url(home_url('/'), PHP_URL_PATH), '/');
    if ($home_path !== '' && strpos($path . '/', $home_path . '/') === 0) {
        $path = trim(substr($path, strlen($home_path)), '/');
    }

    $page = $path !== '' ? get_page_by_path($path) : null;
    if ($page instanceof WP_Post && $page->post_status === 'publish') {
        return;
    }

    $aliases = vr_route_aliases();
    if (array_key_exists($path, $aliases)) {
        wp_safe_redirect(home_url('/' . $aliases[$path] . '/'), 301);
        exit;
    }
}
add_action('template_redirect', 'vr_route_alias_redirects');

function vr_theme_settings_fields_sections() {
    return array(
        'vr_general' => array(
            'title' => __('Основное', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Глобальные данные сайта и контакты.', 'vetritual-modern') . '</p>';
            },
        ),
        'vr_social' => array(
            'title' => __('Соцсети', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Ссылки на сообщества и текст подвала.', 'vetritual-modern') . '</p>';
            },
        ),
        'vr_hero' => array(
            'title' => __('Глобальные CTA', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Кнопки по умолчанию. Заголовки, тексты и изображения редактируются в страницах WordPress.', 'vetritual-modern') . '</p>';
            },
        ),
        'vr_seo' => array(
            'title' => __('SEO и верификация', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Meta, OG и коды подтверждения для поисковых систем.', 'vetritual-modern') . '</p>';
            },
        ),
        'vr_analytics' => array(
            'title' => __('Аналитика и HTML-вставки', 'vetritual-modern'),
            'callback' => function () {
                echo '<p>' . esc_html__('Согласие cookie, счетчики аналитики и служебные HTML-вставки.', 'vetritual-modern') . '</p>';
            },
        ),
    );
}

function vr_sanitize_theme_bool_like($value) {
    return in_array((string) $value, array('1', 'true', 'on', 'yes'), true) ? '1' : '0';
}

function vr_sanitize_theme_settings($input) {
    if (! is_array($input)) {
        return array();
    }

    $output = array();
    $definitions = vr_theme_option_fields();

    foreach ($definitions as $key => $field) {
        if (! array_key_exists($key, $input)) {
            continue;
        }

        $value = wp_unslash($input[$key]);
        if (is_array($value) || is_object($value)) {
            $value = '';
        } else {
            $value = (string) $value;
        }

        if (in_array($key, array('yandex_metrika_webvisor', 'yandex_metrika_ecommerce'), true)) {
            $output[$key] = vr_sanitize_theme_bool_like($value);
            continue;
        }

        if (in_array($key, array('custom_head_html', 'body_start_html', 'body_end_html'), true)) {
            $output[$key] = wp_kses_post($value);
            continue;
        }

        if (isset($field['type']) && 'url' === $field['type']) {
            $output[$key] = esc_url_raw($value);
            continue;
        }

        if (isset($field['type']) && 'textarea' === $field['type']) {
            $output[$key] = sanitize_textarea_field($value);
            continue;
        }

        if (isset($field['type']) && 'checkbox' === $field['type']) {
            $output[$key] = vr_sanitize_theme_bool_like($value);
            continue;
        }

        $output[$key] = sanitize_text_field($value);
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
    $rows = isset($field['rows']) ? (int) $field['rows'] : 8;
    $type = $field['type'];

    if ('textarea' === $type) {
        echo '<textarea id="vr_theme_' . esc_attr($key) . '" name="' . esc_attr($name) . '" rows="' . esc_attr($rows) . '" class="large-text code" style="height: 160px; width: 100%;">' . esc_textarea((string) $value) . '</textarea>';
        return;
    }

    if ('checkbox' === $type) {
        echo '<label for="vr_theme_' . esc_attr($key) . '">';
        echo '<input id="vr_theme_' . esc_attr($key) . '" name="' . esc_attr($name) . '" value="1" type="checkbox" ' . checked('1', (string) $value, false) . ' style="margin-right: 6px;">';
        echo esc_html__('Включить', 'vetritual-modern');
        echo '</label>';
        return;
    }

    if ('url' === $type) {
        echo '<input id="vr_theme_' . esc_attr($key) . '" name="' . esc_attr($name) . '" value="' . esc_attr((string) $value) . '" class="regular-text" type="url">';
        return;
    }

    echo '<input id="vr_theme_' . esc_attr($key) . '" name="' . esc_attr($name) . '" value="' . esc_attr((string) $value) . '" class="regular-text" type="text">';
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
    $customize_url = add_query_arg(
        array(
            'url' => home_url('/'),
            'return' => admin_url('themes.php?page=vr-theme-options'),
        ),
        admin_url('customize.php')
    );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Настройки темы Vet Ritual', 'vetritual-modern'); ?></h1>
        <p class="description">
            <strong><?php esc_html_e('Быстрые правки:', 'vetritual-modern'); ?></strong>
            <a href="<?php echo esc_url($customize_url); ?>" target="_blank">
                <?php esc_html_e('Открыть стандартный кастомайзер WordPress', 'vetritual-modern'); ?>
            </a>
        </p>
        <p class="description">
            <?php esc_html_e('Здесь хранятся только глобальные настройки темы. Тексты страниц, услуги, цены, отзывы, меню и изображения редактируются штатными сущностями WordPress.', 'vetritual-modern'); ?>
        </p>
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
