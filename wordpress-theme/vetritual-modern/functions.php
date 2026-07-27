<?php
if (! defined('ABSPATH')) {
    exit;
}

define('VR_THEME_VERSION', '1.0');

require_once get_template_directory() . '/inc/helpers/theme-options.php';
require_once get_template_directory() . '/inc/content-model.php';
require_once get_template_directory() . '/inc/setup.php';

function vr_setup_theme() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');

    register_nav_menus(
        array(
            'primary' => __('Основное меню', 'vetritual-modern'),
            'footer_services' => __('Меню услуг в подвале', 'vetritual-modern'),
        )
    );
}
add_action('after_setup_theme', 'vr_setup_theme');

function vr_get_page_seo_meta($post_id, $meta_key) {
    return trim(wp_strip_all_tags((string) get_post_meta((int) $post_id, $meta_key, true)));
}

function vr_get_document_meta_description($post = null) {
    if (! $post instanceof WP_Post && is_singular()) {
        $post = get_queried_object();
    }

    if ($post instanceof WP_Post) {
        $custom_description = vr_get_page_seo_meta($post->ID, '_vr_meta_description');
        if ($custom_description !== '') {
            return $custom_description;
        }

        $excerpt = has_excerpt($post) ? get_the_excerpt($post) : '';
        if ($excerpt !== '') {
            return trim(wp_strip_all_tags($excerpt));
        }

        $content = vr_get_post_plain_text($post);
        if ($content !== '') {
            return $content;
        }
    }

    return trim((string) vr_theme_setting('default_meta_description', get_bloginfo('description')));
}

function vr_filter_document_title_parts($parts) {
    $site_name = trim((string) vr_theme_setting('site_name', get_bloginfo('name')));

    if (is_front_page()) {
        $front_page_id = (int) get_option('page_on_front');
        $front_page_title = $front_page_id > 0 ? vr_get_page_seo_meta($front_page_id, '_vr_seo_title') : '';
        $parts['title'] = $front_page_title !== ''
            ? $front_page_title
            : trim((string) vr_theme_setting('default_meta_title', $site_name));
        $parts['site'] = '';
        $parts['tagline'] = '';
        return $parts;
    }

    if (! is_singular()) {
        return $parts;
    }

    $post = get_queried_object();
    if (! $post instanceof WP_Post) {
        return $parts;
    }

    $custom_title = vr_get_page_seo_meta($post->ID, '_vr_seo_title');
    if ($custom_title !== '') {
        $parts['title'] = $custom_title;
        $parts['site'] = '';
        $parts['tagline'] = '';
        return $parts;
    }

    $parts['title'] = get_the_title($post);
    $parts['site'] = $site_name;
    $parts['tagline'] = '';
    return $parts;
}
add_filter('document_title_parts', 'vr_filter_document_title_parts');

function vr_default_page_seo_meta() {
    return array(
        'home' => array('title' => 'Ритуальные услуги для животных в Петрозаводске | Vet Ritual', 'description' => 'Помогаем организовать усыпление, кремацию и вывоз домашних животных в Петрозаводске и Карелии. Круглосуточно консультируем по телефону.'),
        'o-nas' => array('title' => 'О Vet Ritual — ритуальные услуги для животных в Петрозаводске', 'description' => 'Рассказываем о работе Vet Ritual: консультации, выезде, вывозе и организации кремации домашних животных в Петрозаводске и Карелии.'),
        'uslugi' => array('title' => 'Услуги для животных в Петрозаводске | Vet Ritual', 'description' => 'Выберите формат помощи для питомца: усыпление на дому, общая или индивидуальная кремация, вывоз. Уточним порядок и стоимость по телефону.'),
        'tseny' => array('title' => 'Цены на ритуальные услуги для животных | Vet Ritual', 'description' => 'Цены на усыпление и кремацию животных. Итоговую стоимость уточняем по весу питомца, адресу и выбранному формату услуги.'),
        'kontakty' => array('title' => 'Контакты Vet Ritual в Петрозаводске', 'description' => 'Свяжитесь с Vet Ritual в любое время: ответим на вопросы об усыплении, кремации и вывозе домашних животных, согласуем формат помощи.'),
        'usyplenie-zhivotnyh' => array('title' => 'Усыпление животных на дому в Петрозаводске | Vet Ritual', 'description' => 'Усыпление домашних животных на дому в Петрозаводске: консультация, спокойное прощание и бережное сопровождение. Уточните порядок и стоимость.'),
        'krematsyja-zhyvotnyh' => array('title' => 'Кремация животных в Петрозаводске | Vet Ritual', 'description' => 'Общая и индивидуальная кремация домашних животных в Петрозаводске. Расскажем об условиях, вывозе и вариантах возврата урны.'),
        'vyvoz-zhivotnyh' => array('title' => 'Вывоз животных в Петрозаводске | Vet Ritual', 'description' => 'Организуем аккуратный вывоз тела домашнего животного из дома или клиники в крематорий. Согласуем адрес, время и дальнейший формат услуги.'),
        'usyplenie-koshek' => array('title' => 'Усыпление кошек на дому в Петрозаводске | Vet Ritual', 'description' => 'Усыпление кошек на дому в привычной обстановке. Спокойно объясним порядок процедуры, согласуем время приезда и стоимость.'),
        'usyplenie-sobak' => array('title' => 'Усыпление собак на дому в Петрозаводске | Vet Ritual', 'description' => 'Усыпление собак на дому с бережным сопровождением владельца. Уточним порядок процедуры, время приезда и стоимость по телефону.'),
        'obschaja-krematsyja' => array('title' => 'Общая кремация животных в Петрозаводске | Vet Ritual', 'description' => 'Общая кремация домашних животных без возврата праха. Объясним порядок услуги, организуем вывоз и согласуем стоимость.'),
        'individualnaja-krematsyja' => array('title' => 'Индивидуальная кремация животных в Петрозаводске | Vet Ritual', 'description' => 'Индивидуальная кремация домашнего животного с возвратом урны. Расскажем об условиях, вывозе и согласуем порядок услуги.'),
    );
}

function vr_migrate_seo_meta_and_primary_menu() {
    if (get_option('vr_seo_menu_migration_20260727', false)) {
        return;
    }

    foreach (vr_default_page_seo_meta() as $slug => $meta) {
        $page = get_page_by_path($slug);
        if (! $page instanceof WP_Post) {
            continue;
        }

        if (vr_get_page_seo_meta($page->ID, '_vr_seo_title') === '') {
            update_post_meta($page->ID, '_vr_seo_title', $meta['title']);
        }
        if (vr_get_page_seo_meta($page->ID, '_vr_meta_description') === '') {
            update_post_meta($page->ID, '_vr_meta_description', $meta['description']);
        }
    }

    $locations = get_nav_menu_locations();
    $menu_id = ! empty($locations['primary']) ? (int) $locations['primary'] : 0;
    $parent_page = get_page_by_path('uslugi');
    if ($menu_id > 0 && $parent_page instanceof WP_Post) {
        $items_by_object_id = array();
        foreach ((array) wp_get_nav_menu_items($menu_id) as $item) {
            $items_by_object_id[(int) $item->object_id] = $item;
        }

        $parent_item = $items_by_object_id[(int) $parent_page->ID] ?? null;
        if ($parent_item && ! empty($parent_item->ID)) {
            $service_slugs = array('usyplenie-zhivotnyh', 'krematsyja-zhyvotnyh', 'vyvoz-zhivotnyh', 'usyplenie-koshek', 'usyplenie-sobak', 'obschaja-krematsyja', 'individualnaja-krematsyja');
            foreach ($service_slugs as $service_slug) {
                $service_page = get_page_by_path($service_slug);
                if (! $service_page instanceof WP_Post) {
                    continue;
                }

                $service_item = $items_by_object_id[(int) $service_page->ID] ?? null;
                if (! $service_item) {
                    $service_item_id = wp_update_nav_menu_item(
                        $menu_id,
                        0,
                        array(
                            'menu-item-object-id' => $service_page->ID,
                            'menu-item-object' => 'page',
                            'menu-item-type' => 'post_type',
                            'menu-item-status' => 'publish',
                            'menu-item-parent' => (int) $parent_item->ID,
                        )
                    );
                    if (is_wp_error($service_item_id) || ! $service_item_id) {
                        continue;
                    }
                    $service_item = (object) array('ID' => (int) $service_item_id);
                }

                update_post_meta((int) $service_item->ID, '_menu_item_menu_item_parent', (int) $parent_item->ID);
            }
        }
    }

    update_option('vr_seo_menu_migration_20260727', '1', false);
}
add_action('after_setup_theme', 'vr_migrate_seo_meta_and_primary_menu', 40);

function vr_add_page_seo_meta_box() {
    add_meta_box(
        'vr_page_seo',
        __('SEO страницы', 'vetritual-modern'),
        'vr_render_page_seo_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_page', 'vr_add_page_seo_meta_box');

function vr_render_page_seo_meta_box($post) {
    wp_nonce_field('vr_save_page_seo_meta', 'vr_page_seo_nonce');
    $title = vr_get_page_seo_meta($post->ID, '_vr_seo_title');
    $description = vr_get_page_seo_meta($post->ID, '_vr_meta_description');
    ?>
    <p>
      <label for="vr_seo_title"><strong><?php esc_html_e('Заголовок вкладки (title)', 'vetritual-modern'); ?></strong></label><br>
      <input id="vr_seo_title" name="vr_seo_title" class="widefat" type="text" value="<?php echo esc_attr($title); ?>">
    </p>
    <p>
      <label for="vr_meta_description"><strong><?php esc_html_e('Meta description', 'vetritual-modern'); ?></strong></label><br>
      <textarea id="vr_meta_description" name="vr_meta_description" class="widefat" rows="3"><?php echo esc_textarea($description); ?></textarea>
    </p>
    <p class="description"><?php esc_html_e('Если поля пустые, тема использует заголовок и отрывок страницы. Тексты не попадают в навигацию.', 'vetritual-modern'); ?></p>
    <?php
}

function vr_save_page_seo_meta($post_id) {
    if (
        ! isset($_POST['vr_page_seo_nonce'])
        || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['vr_page_seo_nonce'])), 'vr_save_page_seo_meta')
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || ! current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    $fields = array(
        '_vr_seo_title' => 'vr_seo_title',
        '_vr_meta_description' => 'vr_meta_description',
    );

    foreach ($fields as $meta_key => $field_name) {
        $value = isset($_POST[$field_name]) ? sanitize_text_field(wp_unslash($_POST[$field_name])) : '';
        if ($value === '') {
            delete_post_meta($post_id, $meta_key);
            continue;
        }

        update_post_meta($post_id, $meta_key, $value);
    }
}
add_action('save_post_page', 'vr_save_page_seo_meta');

function vr_seed_default_menus() {
    if (get_option('vr_default_menus_seeded', false)) {
        return;
    }

    $locations = get_theme_mod('nav_menu_locations', array());
    $locations = is_array($locations) ? $locations : array();
    $definitions = array(
        'primary' => array(
            'name' => 'Основное меню',
            'paths' => array('o-nas', 'uslugi', 'tseny', 'kontakty'),
        ),
        'footer_services' => array(
            'name' => 'Услуги в подвале',
            'paths' => array('usyplenie-zhivotnyh', 'krematsyja-zhyvotnyh', 'vyvoz-zhivotnyh'),
        ),
    );

    foreach ($definitions as $location => $definition) {
        if (! empty($locations[$location])) {
            continue;
        }

        $menu_id = wp_create_nav_menu($definition['name']);
        if (is_wp_error($menu_id)) {
            continue;
        }

        foreach ($definition['paths'] as $path) {
            $page = get_page_by_path($path);
            if (! $page instanceof WP_Post) {
                continue;
            }

            wp_update_nav_menu_item(
                $menu_id,
                0,
                array(
                    'menu-item-object-id' => $page->ID,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                )
            );
        }

        $locations[$location] = $menu_id;
    }

    set_theme_mod('nav_menu_locations', $locations);
    update_option('vr_default_menus_seeded', '1', false);
}
add_action('after_setup_theme', 'vr_seed_default_menus', 30);

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

        if (isset($field['type']) && 'media' === $field['type']) {
            $output[$key] = absint($value);
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

    if ('media' === $type) {
        $attachment_id = absint($value);
        $preview = $attachment_id > 0 ? wp_get_attachment_image($attachment_id, 'thumbnail', false, array('class' => 'vr-theme-media__preview')) : '';
        echo '<div class="vr-theme-media" data-title="' . esc_attr__('Выберите логотип', 'vetritual-modern') . '" data-button="' . esc_attr__('Использовать логотип', 'vetritual-modern') . '">';
        echo '<input id="vr_theme_' . esc_attr($key) . '" name="' . esc_attr($name) . '" value="' . esc_attr((string) $attachment_id) . '" type="hidden">';
        echo '<span class="vr-theme-media__preview-wrap">' . $preview . '</span>';
        echo '<button class="button vr-theme-media__select" type="button">' . esc_html__('Выбрать из медиатеки', 'vetritual-modern') . '</button> ';
        echo '<button class="button-link-delete vr-theme-media__remove" type="button">' . esc_html__('Убрать', 'vetritual-modern') . '</button>';
        echo '</div>';
        return;
    }

    echo '<input id="vr_theme_' . esc_attr($key) . '" name="' . esc_attr($name) . '" value="' . esc_attr((string) $value) . '" class="regular-text" type="text">';
}

function vr_add_settings_page() {
    add_options_page(
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

function vr_enqueue_theme_settings_media($hook_suffix) {
    if ('settings_page_vr-theme-options' !== $hook_suffix) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script(
        'vetritual-theme-settings',
        get_template_directory_uri() . '/assets/js/theme-settings.js',
        array('jquery'),
        VR_THEME_VERSION,
        true
    );
}
add_action('admin_enqueue_scripts', 'vr_enqueue_theme_settings_media');

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
