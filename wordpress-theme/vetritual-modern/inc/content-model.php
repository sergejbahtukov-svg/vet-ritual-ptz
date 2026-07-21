<?php
if (! defined('ABSPATH')) {
    exit;
}

function vr_sanitize_meta_rows($rows) {
    $clean = array();

    foreach ((array) $rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        $label = sanitize_text_field((string) ($row['label'] ?? ''));
        $value = sanitize_text_field((string) ($row['value'] ?? ''));
        if ($label === '' && $value === '') {
            continue;
        }

        $clean[] = array(
            'label' => $label,
            'value' => $value,
        );
    }

    return $clean;
}

function vr_sanitize_meta_text_list($items) {
    $clean = array();

    foreach ((array) $items as $item) {
        $item = sanitize_text_field((string) $item);
        if ($item !== '') {
            $clean[] = $item;
        }
    }

    return $clean;
}

function vr_register_content_model() {
    add_post_type_support('page', 'excerpt');

    $content_types = array(
        'vr_service' => array(
            'singular' => 'Service',
            'plural' => 'Services',
            'menu_icon' => 'dashicons-heart',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
        ),
        'vr_price_group' => array(
            'singular' => 'Price Group',
            'plural' => 'Price Groups',
            'menu_icon' => 'dashicons-money-alt',
            'supports' => array('title', 'editor', 'excerpt', 'page-attributes'),
        ),
        'vr_feature' => array(
            'singular' => 'Feature Card',
            'plural' => 'Feature Cards',
            'menu_icon' => 'dashicons-editor-ul',
            'supports' => array('title', 'editor', 'page-attributes'),
        ),
        'vr_process_step' => array(
            'singular' => 'Process Step',
            'plural' => 'Process Steps',
            'menu_icon' => 'dashicons-list-view',
            'supports' => array('title', 'editor', 'page-attributes'),
        ),
        'vr_review' => array(
            'singular' => 'Review',
            'plural' => 'Reviews',
            'menu_icon' => 'dashicons-format-quote',
            'supports' => array('title', 'editor', 'excerpt', 'page-attributes'),
        ),
    );

    foreach ($content_types as $post_type => $config) {
        register_post_type(
            $post_type,
            array(
                'labels' => array(
                    'name' => $config['plural'],
                    'singular_name' => $config['singular'],
                    'add_new_item' => 'Add ' . $config['singular'],
                    'edit_item' => 'Edit ' . $config['singular'],
                ),
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
                'menu_icon' => $config['menu_icon'],
                'supports' => $config['supports'],
                'capability_type' => 'post',
            )
        );
    }

    register_post_meta(
        'vr_service',
        '_vr_service_url',
        array(
            'single' => true,
            'type' => 'string',
            'show_in_rest' => true,
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );
    register_post_meta(
        'vr_service',
        '_vr_service_media_class',
        array(
            'single' => true,
            'type' => 'string',
            'show_in_rest' => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );
    register_post_meta(
        'vr_service',
        '_vr_service_asset',
        array(
            'single' => true,
            'type' => 'string',
            'show_in_rest' => true,
            'sanitize_callback' => 'sanitize_file_name',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );

    register_post_meta(
        'vr_price_group',
        '_vr_price_rows',
        array(
            'single' => true,
            'type' => 'array',
            'show_in_rest' => array(
                'schema' => array(
                    'type' => 'array',
                    'items' => array(
                        'type' => 'object',
                        'properties' => array(
                            'label' => array('type' => 'string'),
                            'value' => array('type' => 'string'),
                        ),
                    ),
                ),
            ),
            'sanitize_callback' => 'vr_sanitize_meta_rows',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );

    register_post_meta(
        'vr_feature',
        '_vr_feature_context',
        array(
            'single' => true,
            'type' => 'string',
            'show_in_rest' => true,
            'sanitize_callback' => 'sanitize_key',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );
    register_post_meta(
        'vr_feature',
        '_vr_feature_items',
        array(
            'single' => true,
            'type' => 'array',
            'show_in_rest' => array(
                'schema' => array(
                    'type' => 'array',
                    'items' => array('type' => 'string'),
                ),
            ),
            'sanitize_callback' => 'vr_sanitize_meta_text_list',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        )
    );
}
add_action('init', 'vr_register_content_model', 5);

function vr_add_content_model_meta_boxes() {
    add_meta_box('vr_service_details', __('Параметры карточки услуги', 'vetritual-modern'), 'vr_render_service_meta_box', 'vr_service', 'normal', 'default');
    add_meta_box('vr_price_rows', __('Строки цен', 'vetritual-modern'), 'vr_render_price_rows_meta_box', 'vr_price_group', 'normal', 'default');
    add_meta_box('vr_feature_details', __('Параметры карточки', 'vetritual-modern'), 'vr_render_feature_meta_box', 'vr_feature', 'normal', 'default');
}
add_action('add_meta_boxes', 'vr_add_content_model_meta_boxes');

function vr_render_service_meta_box($post) {
    wp_nonce_field('vr_save_content_model_meta', 'vr_content_model_nonce');
    $url = get_post_meta($post->ID, '_vr_service_url', true);
    $media_class = get_post_meta($post->ID, '_vr_service_media_class', true);
    $asset = get_post_meta($post->ID, '_vr_service_asset', true);
    ?>
    <p>
      <label for="vr_service_url"><strong><?php esc_html_e('Ссылка на страницу услуги', 'vetritual-modern'); ?></strong></label><br>
      <input id="vr_service_url" name="vr_service_url" type="url" class="widefat" value="<?php echo esc_attr((string) $url); ?>" placeholder="<?php echo esc_attr(home_url('/usyplenie-zhivotnyh/')); ?>">
    </p>
    <p>
      <label for="vr_service_media_class"><strong><?php esc_html_e('CSS-класс медиаблока', 'vetritual-modern'); ?></strong></label><br>
      <input id="vr_service_media_class" name="vr_service_media_class" type="text" class="widefat" value="<?php echo esc_attr((string) $media_class); ?>" placeholder="vr-service-media--euthanasia">
    </p>
    <p>
      <label for="vr_service_asset"><strong><?php esc_html_e('Fallback asset из assets/media', 'vetritual-modern'); ?></strong></label><br>
      <input id="vr_service_asset" name="vr_service_asset" type="text" class="widefat" value="<?php echo esc_attr((string) $asset); ?>" placeholder="service-euthanasia.webp">
    </p>
    <p class="description"><?php esc_html_e('Основное изображение задается как featured image записи услуги. Asset нужен только как запасной вариант.', 'vetritual-modern'); ?></p>
    <?php
}

function vr_render_price_rows_meta_box($post) {
    wp_nonce_field('vr_save_content_model_meta', 'vr_content_model_nonce');
    $rows = get_post_meta($post->ID, '_vr_price_rows', true);
    $rows = is_array($rows) ? array_values($rows) : array();
    $row_count = max(12, count($rows) + 3);
    ?>
    <table class="widefat striped">
      <thead>
        <tr>
          <th><?php esc_html_e('Позиция', 'vetritual-modern'); ?></th>
          <th><?php esc_html_e('Цена', 'vetritual-modern'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php for ($index = 0; $index < $row_count; $index++) : ?>
          <?php $row = isset($rows[$index]) && is_array($rows[$index]) ? $rows[$index] : array(); ?>
          <tr>
            <td><input name="vr_price_rows[<?php echo esc_attr((string) $index); ?>][label]" type="text" class="widefat" value="<?php echo esc_attr((string) ($row['label'] ?? '')); ?>"></td>
            <td><input name="vr_price_rows[<?php echo esc_attr((string) $index); ?>][value]" type="text" class="widefat" value="<?php echo esc_attr((string) ($row['value'] ?? '')); ?>"></td>
          </tr>
        <?php endfor; ?>
      </tbody>
    </table>
    <p class="description"><?php esc_html_e('Пустые строки не сохраняются. Описание под заголовком берется из excerpt.', 'vetritual-modern'); ?></p>
    <?php
}

function vr_render_feature_meta_box($post) {
    wp_nonce_field('vr_save_content_model_meta', 'vr_content_model_nonce');
    $context = get_post_meta($post->ID, '_vr_feature_context', true);
    $items = get_post_meta($post->ID, '_vr_feature_items', true);
    $items = is_array($items) ? implode("\n", $items) : '';
    ?>
    <p>
      <label for="vr_feature_context"><strong><?php esc_html_e('Где показывать', 'vetritual-modern'); ?></strong></label><br>
      <select id="vr_feature_context" name="vr_feature_context">
        <option value="about" <?php selected($context, 'about'); ?>><?php esc_html_e('О нас', 'vetritual-modern'); ?></option>
        <option value="contact" <?php selected($context, 'contact'); ?>><?php esc_html_e('Контакты', 'vetritual-modern'); ?></option>
      </select>
    </p>
    <p>
      <label for="vr_feature_items"><strong><?php esc_html_e('Пункты списка', 'vetritual-modern'); ?></strong></label><br>
      <textarea id="vr_feature_items" name="vr_feature_items" rows="6" class="widefat"><?php echo esc_textarea($items); ?></textarea>
    </p>
    <p class="description"><?php esc_html_e('Основной текст карточки берется из редактора записи. Каждый пункт списка пишется с новой строки.', 'vetritual-modern'); ?></p>
    <?php
}

function vr_save_content_model_meta($post_id) {
    if (! isset($_POST['vr_content_model_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['vr_content_model_nonce'])), 'vr_save_content_model_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $post_type = get_post_type($post_id);

    if ($post_type === 'vr_service') {
        update_post_meta($post_id, '_vr_service_url', esc_url_raw((string) wp_unslash($_POST['vr_service_url'] ?? '')));
        update_post_meta($post_id, '_vr_service_media_class', sanitize_text_field((string) wp_unslash($_POST['vr_service_media_class'] ?? '')));
        update_post_meta($post_id, '_vr_service_asset', sanitize_file_name((string) wp_unslash($_POST['vr_service_asset'] ?? '')));
    }

    if ($post_type === 'vr_price_group') {
        $rows = isset($_POST['vr_price_rows']) && is_array($_POST['vr_price_rows']) ? wp_unslash($_POST['vr_price_rows']) : array();
        update_post_meta($post_id, '_vr_price_rows', vr_sanitize_meta_rows($rows));
    }

    if ($post_type === 'vr_feature') {
        $context = sanitize_key((string) wp_unslash($_POST['vr_feature_context'] ?? 'about'));
        if (! in_array($context, array('about', 'contact'), true)) {
            $context = 'about';
        }

        $items_source = (string) wp_unslash($_POST['vr_feature_items'] ?? '');
        $items = preg_split('/\R+/', $items_source);
        update_post_meta($post_id, '_vr_feature_context', $context);
        update_post_meta($post_id, '_vr_feature_items', vr_sanitize_meta_text_list($items));
    }
}
add_action('save_post', 'vr_save_content_model_meta');

function vr_get_ordered_content_posts($post_type, $limit = -1, $query_args = array()) {
    $args = array_merge(
        array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'numberposts' => $limit,
            'orderby' => array(
                'menu_order' => 'ASC',
                'date' => 'ASC',
            ),
            'order' => 'ASC',
        ),
        $query_args
    );

    $posts = get_posts($args);

    return is_array($posts) ? $posts : array();
}

function vr_get_post_plain_text($post, $word_limit = 36) {
    if (! $post instanceof WP_Post) {
        return '';
    }

    $text = has_excerpt($post) ? get_the_excerpt($post) : wp_strip_all_tags(strip_shortcodes($post->post_content));
    $text = trim(preg_replace('/\s+/', ' ', (string) $text));

    return $word_limit > 0 ? wp_trim_words($text, $word_limit, '') : $text;
}

function vr_url_to_page_path($url) {
    $path = trim((string) wp_parse_url((string) $url, PHP_URL_PATH), '/');
    $home_path = trim((string) wp_parse_url(home_url('/'), PHP_URL_PATH), '/');

    if ($home_path !== '' && ($path === $home_path || strpos($path . '/', $home_path . '/') === 0)) {
        $path = trim(substr($path, strlen($home_path)), '/');
    }

    return $path;
}

function vr_get_service_cards() {
    $cards = array();

    foreach (vr_get_ordered_content_posts('vr_service') as $post) {
        $url = (string) get_post_meta($post->ID, '_vr_service_url', true);
        $asset = (string) get_post_meta($post->ID, '_vr_service_asset', true);
        $image_src = get_the_post_thumbnail_url($post, 'large');
        $linked_page_path = $url !== '' ? vr_url_to_page_path($url) : '';
        $linked_page = $linked_page_path !== '' ? get_page_by_path($linked_page_path) : null;

        if (! $image_src && $linked_page instanceof WP_Post) {
            $image_src = get_the_post_thumbnail_url($linked_page, 'large');
        }

        $text = vr_get_post_plain_text($post);
        $cards[] = array(
            'title' => get_the_title($post),
            'text' => $text,
            'link' => $url !== '' ? $url : '#',
            'image' => $asset,
            'image_src' => $image_src ? $image_src : '',
            'media' => (string) get_post_meta($post->ID, '_vr_service_media_class', true),
        );
    }

    if (! empty($cards)) {
        return $cards;
    }

    return array();
}

function vr_get_price_cards() {
    $cards = array();

    foreach (vr_get_ordered_content_posts('vr_price_group') as $post) {
        $rows = get_post_meta($post->ID, '_vr_price_rows', true);
        $rows = is_array($rows) ? vr_sanitize_meta_rows($rows) : array();

        if (empty($rows)) {
            continue;
        }

        $cards[] = array(
            'title' => get_the_title($post),
            'note' => has_excerpt($post) ? get_the_excerpt($post) : '',
            'rows' => $rows,
        );
    }

    return $cards;
}

function vr_get_feature_cards($context) {
    $cards = array();
    $context = sanitize_key((string) $context);

    foreach (vr_get_ordered_content_posts(
        'vr_feature',
        -1,
        array(
            'meta_key' => '_vr_feature_context',
            'meta_value' => $context,
        )
    ) as $post) {
        $text = trim(preg_replace('/\s+/', ' ', wp_strip_all_tags(strip_shortcodes($post->post_content))));
        $items = get_post_meta($post->ID, '_vr_feature_items', true);

        $cards[] = array(
            'title' => get_the_title($post),
            'html' => apply_filters('the_content', $post->post_content),
            'text' => $text,
            'items' => is_array($items) ? vr_sanitize_meta_text_list($items) : array(),
        );
    }

    return $cards;
}

function vr_get_process_steps() {
    $steps = array();

    foreach (vr_get_ordered_content_posts('vr_process_step') as $post) {
        $description = wp_strip_all_tags(strip_shortcodes($post->post_content));
        $steps[] = array(
            'title' => get_the_title($post),
            'description' => trim(preg_replace('/\s+/', ' ', $description)),
        );
    }

    return $steps;
}

function vr_get_reviews() {
    $reviews = array();

    foreach (vr_get_ordered_content_posts('vr_review') as $post) {
        $text = wp_strip_all_tags(strip_shortcodes($post->post_content));
        $reviews[] = array(
            'name' => get_the_title($post),
            'subtitle' => has_excerpt($post) ? get_the_excerpt($post) : '',
            'text' => trim(preg_replace('/\s+/', ' ', $text)),
        );
    }

    return $reviews;
}
