<?php
/**
 * One-time local content seed for the native WordPress theme architecture.
 *
 * This is not a runtime dependency. It repairs local seed content and creates
 * missing Pages, CPT entries, media attachments, and menus so templates read
 * native WordPress data instead of Customizer JSON.
 */

$wp_load = getenv('VR_WP_LOAD') ?: 'C:/xampp/htdocs/vetritual-wp/wp-load.php';
if (! file_exists($wp_load)) {
    fwrite(STDERR, "wp-load.php not found: {$wp_load}\n");
    exit(1);
}

require_once $wp_load;

if (! function_exists('wp_insert_post')) {
    fwrite(STDERR, "WordPress is not loaded.\n");
    exit(1);
}

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

function vr_seed_has_mojibake($value) {
    return is_string($value) && preg_match('/(Рџ|Рђ|Рљ|Р’|РЈ|РЎ|Рњ|Рќ|Рћ|Р±|СЃ|С‹|СЊ|вЂ|В©|Р)/u', $value);
}

function vr_seed_should_replace($value) {
    return trim((string) $value) === '' || vr_seed_has_mojibake($value);
}

function vr_seed_upsert_post(array $post_data, $slug, $post_type = 'page') {
    $existing = get_page_by_path($slug, OBJECT, $post_type);
    $post_data['post_name'] = $slug;
    $post_data['post_type'] = $post_type;
    $post_data['post_status'] = $post_data['post_status'] ?? 'publish';

    if ($existing instanceof WP_Post) {
        $update = array(
            'ID' => $existing->ID,
            'menu_order' => $post_data['menu_order'] ?? $existing->menu_order,
        );

        if (array_key_exists('post_content', $post_data) && vr_seed_should_replace($existing->post_content)) {
            $update['post_content'] = $post_data['post_content'];
        }
        if (array_key_exists('post_excerpt', $post_data) && vr_seed_should_replace($existing->post_excerpt)) {
            $update['post_excerpt'] = $post_data['post_excerpt'];
        }
        if (array_key_exists('post_title', $post_data) && (vr_seed_should_replace($existing->post_title) || $existing->post_title === 'Sample Page')) {
            $update['post_title'] = $post_data['post_title'];
        }

        $result = wp_update_post(wp_slash($update), true);
        if (is_wp_error($result)) {
            fwrite(STDERR, "Failed to update {$post_type}:{$slug} - " . $result->get_error_message() . "\n");
        }
        return (int) $existing->ID;
    }

    $id = wp_insert_post(wp_slash($post_data), true);
    if (is_wp_error($id)) {
        fwrite(STDERR, "Failed to create {$post_type}:{$slug} - " . $id->get_error_message() . "\n");
        return 0;
    }

    return (int) $id;
}

function vr_seed_update_post_meta($post_id, array $meta) {
    if (! $post_id) {
        return;
    }

    foreach ($meta as $key => $value) {
        update_post_meta((int) $post_id, $key, $value);
    }
}

function vr_seed_add_post_meta_if_empty($post_id, array $meta) {
    if (! $post_id) {
        return;
    }

    foreach ($meta as $key => $value) {
        if (trim((string) get_post_meta((int) $post_id, $key, true)) === '') {
            update_post_meta((int) $post_id, $key, $value);
        }
    }
}

function vr_seed_theme_asset_path($file_name) {
    $candidates = array(
        get_template_directory() . '/assets/media/' . $file_name,
        dirname(__DIR__) . '/wordpress-theme/vetritual-modern/assets/media/' . $file_name,
    );

    foreach ($candidates as $path) {
        if (file_exists($path)) {
            return $path;
        }
    }

    return '';
}

function vr_seed_attachment_from_theme_asset($file_name, $title, $alt) {
    $existing = get_posts(array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => 1,
        'meta_key' => '_vr_seed_source_asset',
        'meta_value' => $file_name,
        'fields' => 'ids',
    ));

    if (! empty($existing[0])) {
        return (int) $existing[0];
    }

    $source = vr_seed_theme_asset_path($file_name);
    if ($source === '') {
        fwrite(STDERR, "Media asset not found: {$file_name}\n");
        return 0;
    }

    $upload = wp_upload_bits($file_name, null, file_get_contents($source));
    if (! empty($upload['error'])) {
        fwrite(STDERR, "Failed to upload {$file_name}: {$upload['error']}\n");
        return 0;
    }

    $attachment_id = wp_insert_attachment(
        array(
            'post_mime_type' => wp_check_filetype($upload['file'])['type'],
            'post_title' => $title,
            'post_content' => '',
            'post_status' => 'inherit',
        ),
        $upload['file']
    );

    if (is_wp_error($attachment_id)) {
        fwrite(STDERR, "Failed to create attachment {$file_name}: " . $attachment_id->get_error_message() . "\n");
        return 0;
    }

    $metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
    wp_update_attachment_metadata($attachment_id, $metadata);
    update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt);
    update_post_meta($attachment_id, '_vr_seed_source_asset', $file_name);

    return (int) $attachment_id;
}

function vr_seed_menu($name, $location, array $slugs, array $page_ids, array $child_slugs = array(), $parent_slug = '') {
    $menu = wp_get_nav_menu_object($name);
    $menu_id = $menu ? (int) $menu->term_id : wp_create_nav_menu($name);

    if (! $menu_id || is_wp_error($menu_id)) {
        return;
    }

    $existing_items = wp_get_nav_menu_items($menu_id);
    $items_by_object_id = array();
    foreach ((array) $existing_items as $item) {
        $items_by_object_id[(int) $item->object_id] = $item;
    }

    foreach ($slugs as $slug) {
        if (empty($page_ids[$slug]) || isset($items_by_object_id[(int) $page_ids[$slug]])) {
            continue;
        }

        $item_id = wp_update_nav_menu_item(
            $menu_id,
            0,
            array(
                'menu-item-object-id' => $page_ids[$slug],
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            )
        );

        if (! is_wp_error($item_id) && $item_id) {
            $items_by_object_id[(int) $page_ids[$slug]] = (object) array('ID' => (int) $item_id);
        }
    }

    if ($parent_slug !== '' && ! empty($page_ids[$parent_slug])) {
        $parent_page_id = (int) $page_ids[$parent_slug];
        $parent_item = $items_by_object_id[$parent_page_id] ?? null;

        if ($parent_item && ! empty($parent_item->ID)) {
            foreach ($child_slugs as $child_slug) {
                if (empty($page_ids[$child_slug])) {
                    continue;
                }

                $child_item = $items_by_object_id[(int) $page_ids[$child_slug]] ?? null;
                if ($child_item && ! empty($child_item->ID)) {
                    update_post_meta((int) $child_item->ID, '_menu_item_menu_item_parent', (int) $parent_item->ID);
                }
            }
        }
    }

    $locations = get_theme_mod('nav_menu_locations', array());
    $locations[$location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

function vr_seed_repair_theme_options() {
    if (! function_exists('vr_theme_setting_defaults')) {
        return;
    }

    $defaults = vr_theme_setting_defaults();
    $options = get_option('vr_theme_options', array());
    if (! is_array($options)) {
        $options = array();
    }

    foreach ($defaults as $key => $value) {
        if (is_string($value) && (! isset($options[$key]) || vr_seed_should_replace($options[$key]))) {
            $options[$key] = $value;
        }

        $theme_mod_key = 'vr_theme_' . $key;
        $theme_mod = get_theme_mod($theme_mod_key, null);
        if (is_string($theme_mod) && vr_seed_has_mojibake($theme_mod)) {
            remove_theme_mod($theme_mod_key);
        }
    }

    update_option('vr_theme_options', $options);
}

vr_seed_repair_theme_options();

$pages = array(
    'home' => array(
        'post_title' => 'Усыпление, кремация и вывоз животных с бережным сопровождением',
        'post_excerpt' => 'Работаем круглосуточно, выезжаем по Петрозаводску, Прионежскому району и дальним районам Карелии по согласованию.',
        'post_content' => '<!-- wp:paragraph --><p>Vet Ritual PTZ помогает владельцам домашних животных в сложный момент: консультация, выезд специалиста, усыпление на дому, вывоз и кремация.</p><!-- /wp:paragraph -->',
        'menu_order' => 0,
    ),
    'o-nas' => array(
        'post_title' => 'О нас',
        'post_excerpt' => 'Бережная помощь владельцам животных в Петрозаводске и Карелии.',
        'post_content' => '<!-- wp:paragraph --><p>Мы занимаемся ритуальными услугами для домашних животных: объясняем порядок действий, приезжаем на дом или в клинику, помогаем с вывозом и организацией кремации.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Главный принцип работы - спокойное сопровождение без давления, суеты и навязывания лишних услуг.</p><!-- /wp:paragraph -->',
        'menu_order' => 10,
    ),
    'uslugi' => array(
        'post_title' => 'Услуги',
        'post_excerpt' => 'Усыпление, кремация и вывоз животных в Петрозаводске и Карелии.',
        'post_content' => '<!-- wp:paragraph --><p>Помогаем взять на себя сложные организационные шаги: усыпление животного на дому, общая или индивидуальная кремация, аккуратный вывоз тела из дома или клиники.</p><!-- /wp:paragraph -->',
        'menu_order' => 20,
    ),
    'tseny' => array(
        'post_title' => 'Цены',
        'post_excerpt' => 'Стоимость зависит от услуги, веса животного, района выезда и формата кремации.',
        'post_content' => '<!-- wp:paragraph --><p>Итоговую стоимость диспетчер уточняет по телефону после веса животного, адреса и выбранного формата услуги.</p><!-- /wp:paragraph -->',
        'menu_order' => 30,
    ),
    'kontakty' => array(
        'post_title' => 'Контакты',
        'post_excerpt' => 'Свяжитесь с нами в любое время суток.',
        'post_content' => '<!-- wp:paragraph --><p>Позвоните в любое время суток. Ответим спокойно, уточним ситуацию и подберем подходящий формат помощи.</p><!-- /wp:paragraph -->',
        'menu_order' => 40,
    ),
    'usyplenie-zhivotnyh' => array(
        'post_title' => 'Усыпление животных',
        'post_excerpt' => 'Безболезненная процедура на дому, консультация специалиста и время на спокойное прощание.',
        'post_content' => '<!-- wp:heading --><h2>Как проходит процедура</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Сначала специалист вводит препарат для расслабления и наркоза. После наступления глубокого сна проводится второй этап процедуры. Владелец получает время спокойно попрощаться.</p><!-- /wp:paragraph -->',
        'menu_order' => 50,
    ),
    'krematsyja-zhyvotnyh' => array(
        'post_title' => 'Кремация животных',
        'post_excerpt' => 'Общая или индивидуальная кремация с понятными условиями и аккуратной транспортировкой.',
        'post_content' => '<!-- wp:paragraph --><p>Доступны два формата: общая кремация без возврата праха и индивидуальная кремация с возвратом урны.</p><!-- /wp:paragraph -->',
        'menu_order' => 60,
    ),
    'vyvoz-zhivotnyh' => array(
        'post_title' => 'Вывоз животных',
        'post_excerpt' => 'Аккуратная транспортировка тела животного из дома или клиники в крематорий.',
        'post_content' => '<!-- wp:paragraph --><p>Организуем бережный вывоз тела питомца по Петрозаводску, Прионежскому району и другим районам Карелии по согласованию.</p><!-- /wp:paragraph -->',
        'menu_order' => 70,
    ),
    'usyplenie-koshek' => array(
        'post_title' => 'Усыпление кошек',
        'post_excerpt' => 'Помощь на дому в привычной для кошки обстановке, без поездки в клинику и лишнего стресса.',
        'post_content' => '<!-- wp:paragraph --><p>Специалист приезжает домой, спокойно объясняет порядок процедуры и помогает провести прощание в знакомой для кошки обстановке.</p><!-- /wp:paragraph -->',
        'menu_order' => 80,
    ),
    'usyplenie-sobak' => array(
        'post_title' => 'Усыпление собак',
        'post_excerpt' => 'Выезд специалиста, поддержка владельца и бережное сопровождение питомца любого размера.',
        'post_content' => '<!-- wp:paragraph --><p>Процедура проводится с учетом веса и состояния собаки. Заранее согласуем стоимость, время приезда и дальнейшие действия после прощания.</p><!-- /wp:paragraph -->',
        'menu_order' => 90,
    ),
    'obschaja-krematsyja' => array(
        'post_title' => 'Общая кремация',
        'post_excerpt' => 'Достойный формат прощания без выдачи праха, с соблюдением санитарных и ветеринарных требований.',
        'post_content' => '<!-- wp:paragraph --><p>Общая кремация подходит, когда владельцу не требуется возврат праха. Мы аккуратно забираем тело питомца и организуем дальнейшую процедуру.</p><!-- /wp:paragraph -->',
        'menu_order' => 100,
    ),
    'individualnaja-krematsyja' => array(
        'post_title' => 'Индивидуальная кремация',
        'post_excerpt' => 'Отдельная кремация питомца с возвратом урны.',
        'post_content' => '<!-- wp:paragraph --><p>Индивидуальная кремация проводится отдельно, после чего владельцу возвращается урна с прахом питомца.</p><!-- /wp:paragraph -->',
        'menu_order' => 110,
    ),
);

$page_ids = array();
foreach ($pages as $slug => $data) {
    $page_ids[$slug] = vr_seed_upsert_post($data, $slug, 'page');
}

$page_seo = array(
    'home' => array(
        '_vr_seo_title' => 'Ритуальные услуги для животных в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Помогаем организовать усыпление, кремацию и вывоз домашних животных в Петрозаводске и Карелии. Круглосуточно консультируем по телефону.',
    ),
    'o-nas' => array(
        '_vr_seo_title' => 'О Vet Ritual — ритуальные услуги для животных в Петрозаводске',
        '_vr_meta_description' => 'Рассказываем о работе Vet Ritual: консультации, выезде, вывозе и организации кремации домашних животных в Петрозаводске и Карелии.',
    ),
    'uslugi' => array(
        '_vr_seo_title' => 'Услуги для животных в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Выберите формат помощи для питомца: усыпление на дому, общая или индивидуальная кремация, вывоз. Уточним порядок и стоимость по телефону.',
    ),
    'tseny' => array(
        '_vr_seo_title' => 'Цены на ритуальные услуги для животных | Vet Ritual',
        '_vr_meta_description' => 'Цены на усыпление и кремацию животных. Итоговую стоимость уточняем по весу питомца, адресу и выбранному формату услуги.',
    ),
    'kontakty' => array(
        '_vr_seo_title' => 'Контакты Vet Ritual в Петрозаводске',
        '_vr_meta_description' => 'Свяжитесь с Vet Ritual в любое время: ответим на вопросы об усыплении, кремации и вывозе домашних животных, согласуем формат помощи.',
    ),
    'usyplenie-zhivotnyh' => array(
        '_vr_seo_title' => 'Усыпление животных на дому в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Усыпление домашних животных на дому в Петрозаводске: консультация, спокойное прощание и бережное сопровождение. Уточните порядок и стоимость.',
    ),
    'krematsyja-zhyvotnyh' => array(
        '_vr_seo_title' => 'Кремация животных в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Общая и индивидуальная кремация домашних животных в Петрозаводске. Расскажем об условиях, вывозе и вариантах возврата урны.',
    ),
    'vyvoz-zhivotnyh' => array(
        '_vr_seo_title' => 'Вывоз животных в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Организуем аккуратный вывоз тела домашнего животного из дома или клиники в крематорий. Согласуем адрес, время и дальнейший формат услуги.',
    ),
    'usyplenie-koshek' => array(
        '_vr_seo_title' => 'Усыпление кошек на дому в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Усыпление кошек на дому в привычной обстановке. Спокойно объясним порядок процедуры, согласуем время приезда и стоимость.',
    ),
    'usyplenie-sobak' => array(
        '_vr_seo_title' => 'Усыпление собак на дому в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Усыпление собак на дому с бережным сопровождением владельца. Уточним порядок процедуры, время приезда и стоимость по телефону.',
    ),
    'obschaja-krematsyja' => array(
        '_vr_seo_title' => 'Общая кремация животных в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Общая кремация домашних животных без возврата праха. Объясним порядок услуги, организуем вывоз и согласуем стоимость.',
    ),
    'individualnaja-krematsyja' => array(
        '_vr_seo_title' => 'Индивидуальная кремация животных в Петрозаводске | Vet Ritual',
        '_vr_meta_description' => 'Индивидуальная кремация домашнего животного с возвратом урны. Расскажем об условиях, вывозе и согласуем порядок услуги.',
    ),
);

foreach ($page_seo as $slug => $meta) {
    if (! empty($page_ids[$slug])) {
        vr_seed_add_post_meta_if_empty($page_ids[$slug], $meta);
    }
}

$featured_images = array(
    'home' => array('hero-pets-mobile.webp', 'Главный экран Vet Ritual', 'Домашние животные в спокойной светлой сцене'),
    'uslugi' => array('page-hero-services.webp', 'Услуги Vet Ritual', 'Бережное сопровождение владельца животного'),
    'o-nas' => array('hero-heaven.webp', 'О Vet Ritual', 'Спокойный светлый мемориальный образ'),
    'tseny' => array('page-hero-services.webp', 'Цены Vet Ritual', 'Спокойное сопровождение при выборе услуги'),
    'kontakty' => array('hero-mobile-cloud.webp', 'Контакты Vet Ritual', 'Мягкий светлый фон для связи со службой'),
    'usyplenie-zhivotnyh' => array('page-hero-euthanasia.webp', 'Усыпление животных', 'Спокойная домашняя сцена с питомцем'),
    'krematsyja-zhyvotnyh' => array('page-hero-cremation.webp', 'Кремация животных', 'Светлая мемориальная композиция'),
    'vyvoz-zhivotnyh' => array('page-hero-transport.webp', 'Вывоз животных', 'Аккуратная транспортировка питомца'),
    'usyplenie-koshek' => array('page-hero-cats.webp', 'Усыпление кошек', 'Спокойное сопровождение кошки дома'),
    'usyplenie-sobak' => array('page-hero-dogs.webp', 'Усыпление собак', 'Спокойное сопровождение собаки дома'),
    'obschaja-krematsyja' => array('page-hero-common-cremation.webp', 'Общая кремация', 'Светлая мемориальная сцена'),
    'individualnaja-krematsyja' => array('page-hero-individual-cremation.webp', 'Индивидуальная кремация', 'Урна и светлая мемориальная композиция'),
);

foreach ($featured_images as $slug => $image_data) {
    if (empty($page_ids[$slug])) {
        continue;
    }

    $current_thumbnail = get_post_thumbnail_id($page_ids[$slug]);
    $current_alt = $current_thumbnail ? get_post_meta($current_thumbnail, '_wp_attachment_image_alt', true) : '';
    if ($current_thumbnail && ! vr_seed_has_mojibake($current_alt)) {
        continue;
    }

    $attachment_id = vr_seed_attachment_from_theme_asset($image_data[0], $image_data[1], $image_data[2]);
    if ($attachment_id) {
        set_post_thumbnail($page_ids[$slug], $attachment_id);
    }
}

$service_cards = array(
    'usyplenie-zhivotnyh' => array(
        'post_title' => 'Усыпление животных',
        'post_excerpt' => 'Безболезненная процедура на дому, консультация специалиста и время на спокойное прощание.',
        'post_content' => '<!-- wp:paragraph --><p>Процедура проводится на дому в два этапа: сначала обезболивание и наркоз, затем мягкое прекращение жизненных функций.</p><!-- /wp:paragraph -->',
        'menu_order' => 10,
        'asset' => 'service-euthanasia.webp',
        'media_class' => 'vr-service-media--euthanasia',
    ),
    'krematsyja-zhyvotnyh' => array(
        'post_title' => 'Кремация животных',
        'post_excerpt' => 'Общая или индивидуальная кремация с понятными условиями и аккуратной транспортировкой.',
        'post_content' => '<!-- wp:paragraph --><p>Можно выбрать общую кремацию без выдачи праха или индивидуальную кремацию с возвратом урны.</p><!-- /wp:paragraph -->',
        'menu_order' => 20,
        'asset' => 'service-cremation.webp',
        'media_class' => 'vr-service-media--cremation',
    ),
    'vyvoz-zhivotnyh' => array(
        'post_title' => 'Вывоз животных',
        'post_excerpt' => 'Аккуратная транспортировка тела животного из дома или клиники в крематорий.',
        'post_content' => '<!-- wp:paragraph --><p>Аккуратно транспортируем тело животного из дома или ветеринарной клиники в крематорий с соблюдением санитарных требований.</p><!-- /wp:paragraph -->',
        'menu_order' => 30,
        'asset' => 'service-transport-owner.webp',
        'media_class' => 'vr-service-media--soft vr-service-media--transport',
    ),
    'usyplenie-koshek' => array(
        'post_title' => 'Усыпление кошек',
        'post_excerpt' => 'Помощь на дому в привычной для кошки обстановке, без поездки в клинику и лишнего стресса.',
        'post_content' => '<!-- wp:paragraph --><p>Помощь на дому в привычной для кошки обстановке, без поездки в клинику и лишнего стресса.</p><!-- /wp:paragraph -->',
        'menu_order' => 40,
        'asset' => 'page-hero-cats.webp',
        'media_class' => 'vr-service-media--cats',
    ),
    'usyplenie-sobak' => array(
        'post_title' => 'Усыпление собак',
        'post_excerpt' => 'Выезд специалиста, поддержка владельца и бережное сопровождение питомца любого размера.',
        'post_content' => '<!-- wp:paragraph --><p>Выезд специалиста, поддержка владельца и бережное сопровождение питомца любого размера.</p><!-- /wp:paragraph -->',
        'menu_order' => 50,
        'asset' => 'page-hero-dogs.webp',
        'media_class' => 'vr-service-media--dogs',
    ),
    'obschaja-krematsyja' => array(
        'post_title' => 'Общая кремация',
        'post_excerpt' => 'Достойный формат прощания без выдачи праха, с соблюдением санитарных и ветеринарных требований.',
        'post_content' => '<!-- wp:paragraph --><p>Достойный формат прощания без выдачи праха, с соблюдением санитарных и ветеринарных требований.</p><!-- /wp:paragraph -->',
        'menu_order' => 60,
        'asset' => 'page-hero-common-cremation.webp',
        'media_class' => 'vr-service-media--common-cremation',
    ),
    'individualnaja-krematsyja' => array(
        'post_title' => 'Индивидуальная кремация',
        'post_excerpt' => 'Отдельная кремация питомца с возвратом урны.',
        'post_content' => '<!-- wp:paragraph --><p>Отдельная кремация питомца с возвратом урны.</p><!-- /wp:paragraph -->',
        'menu_order' => 70,
        'asset' => 'page-hero-individual-cremation.webp',
        'media_class' => 'vr-service-media--individual-cremation',
    ),
);

foreach ($service_cards as $slug => $data) {
    $asset = $data['asset'];
    $media_class = $data['media_class'];
    unset($data['asset'], $data['media_class']);

    $service_id = vr_seed_upsert_post($data, $slug, 'vr_service');
    vr_seed_update_post_meta(
        $service_id,
        array(
            '_vr_service_url' => home_url('/' . $slug . '/'),
            '_vr_service_media_class' => $media_class,
            '_vr_service_asset' => $asset,
        )
    );

    if ($service_id && ! get_post_thumbnail_id($service_id)) {
        $attachment_id = vr_seed_attachment_from_theme_asset($asset, $data['post_title'], $data['post_excerpt']);
        if ($attachment_id) {
            set_post_thumbnail($service_id, $attachment_id);
        }
    }
}

$price_groups = array(
    'usyplenie' => array(
        'post' => array(
            'post_title' => 'Усыпление',
            'post_excerpt' => 'По городу',
            'post_content' => '<!-- wp:paragraph --><p>Редактируйте строки цен в блоке "Строки цен" ниже.</p><!-- /wp:paragraph -->',
            'menu_order' => 10,
        ),
        'rows' => array(
            array('label' => 'Кошка', 'value' => '3 000–3 500 руб.'),
            array('label' => 'Собаки 5–10 кг', 'value' => '4 000–5 000 руб.'),
            array('label' => 'Собаки 11–20 кг', 'value' => '5 000–6 000 руб.'),
            array('label' => 'Собаки от 20 кг', 'value' => 'от 7 000 руб.'),
        ),
    ),
    'obschaya-krematsiya' => array(
        'post' => array(
            'post_title' => 'Общая кремация',
            'post_content' => '<!-- wp:paragraph --><p>Редактируйте строки цен в блоке "Строки цен" ниже.</p><!-- /wp:paragraph -->',
            'menu_order' => 20,
        ),
        'rows' => array(
            array('label' => 'до 5 кг', 'value' => '4 000 руб.'),
            array('label' => 'до 10 кг', 'value' => '4 500 руб.'),
            array('label' => 'до 20 кг', 'value' => '5 500 руб.'),
            array('label' => 'до 30 кг', 'value' => '6 000 руб.'),
            array('label' => 'до 40 кг', 'value' => '7 000 руб.'),
            array('label' => 'до 50 кг', 'value' => '8 500 руб.'),
            array('label' => 'от 50 кг', 'value' => '10 000–12 000 руб.'),
        ),
    ),
    'individualnaya-krematsiya' => array(
        'post' => array(
            'post_title' => 'Индивидуальная кремация',
            'post_excerpt' => 'С отдельным возвратом урны',
            'post_content' => '<!-- wp:paragraph --><p>Редактируйте строки цен в блоке "Строки цен" ниже.</p><!-- /wp:paragraph -->',
            'menu_order' => 30,
        ),
        'rows' => array(
            array('label' => 'до 5 кг', 'value' => '8 000 руб.'),
            array('label' => 'Попугай, крыса', 'value' => '4 500 руб.'),
            array('label' => 'до 10 кг', 'value' => '8 500 руб.'),
            array('label' => 'до 20 кг', 'value' => '9 000 руб.'),
            array('label' => 'до 30 кг', 'value' => '10 000 руб.'),
            array('label' => 'до 40 кг', 'value' => '11 000 руб.'),
            array('label' => 'до 50 кг', 'value' => '13 500 руб.'),
            array('label' => 'от 50 кг', 'value' => 'от 16 000 руб.'),
        ),
    ),
);

foreach ($price_groups as $slug => $data) {
    $price_group_id = vr_seed_upsert_post($data['post'], $slug, 'vr_price_group');
    vr_seed_update_post_meta($price_group_id, array('_vr_price_rows' => $data['rows']));
}

$feature_cards = array(
    'about-individualnyy-podhod' => array(
        'post' => array(
            'post_title' => 'Индивидуальный подход',
            'post_content' => '<!-- wp:paragraph --><p>Мы заранее объясняем порядок индивидуальной кремации, условия возврата урны и отвечаем на вопросы владельца.</p><!-- /wp:paragraph -->',
            'menu_order' => 10,
        ),
        'context' => 'about',
        'items' => array(),
    ),
    'about-chto-vazhno' => array(
        'post' => array(
            'post_title' => 'Что важно',
            'post_content' => '',
            'menu_order' => 20,
        ),
        'context' => 'about',
        'items' => array(
            'бережное отношение к питомцу и владельцу;',
            'прозрачные цены по весовым категориям;',
            'время на прощание без спешки;',
            'круглосуточный прием обращений.',
        ),
    ),
    'contact-chto-mozhno-utochnit' => array(
        'post' => array(
            'post_title' => 'Что можно уточнить',
            'post_content' => '',
            'menu_order' => 10,
        ),
        'context' => 'contact',
        'items' => array(
            'стоимость услуги по весу питомца;',
            'срок приезда специалиста;',
            'формат общей или индивидуальной кремации;',
            'условия возврата урны после индивидуальной кремации.',
        ),
    ),
    'contact-kak-prohodit-obrashchenie' => array(
        'post' => array(
            'post_title' => 'Как проходит обращение',
            'post_content' => '<!-- wp:paragraph --><p>Вы звоните, называете адрес и примерный вес животного. Мы спокойно объясняем варианты, согласуем время приезда и заранее проговариваем стоимость без скрытых условий.</p><!-- /wp:paragraph -->',
            'menu_order' => 20,
        ),
        'context' => 'contact',
        'items' => array(),
    ),
    'contact-zona-vyezda' => array(
        'post' => array(
            'post_title' => 'Зона выезда',
            'post_content' => '<!-- wp:paragraph --><p>Петрозаводск, Прионежский район и другие районы Карелии по согласованию. Дальний выезд рассчитывается отдельно по расстоянию.</p><!-- /wp:paragraph -->',
            'menu_order' => 30,
        ),
        'context' => 'contact',
        'items' => array(),
    ),
);

foreach ($feature_cards as $slug => $data) {
    $feature_id = vr_seed_upsert_post($data['post'], $slug, 'vr_feature');
    vr_seed_update_post_meta(
        $feature_id,
        array(
            '_vr_feature_context' => $data['context'],
            '_vr_feature_items' => $data['items'],
        )
    );
}

$steps = array(
    'zvonok' => array('post_title' => 'Звонок', 'post_content' => 'Уточняем ситуацию, адрес, вес животного и подходящий формат услуги.', 'menu_order' => 10),
    'vyezd' => array('post_title' => 'Выезд', 'post_content' => 'Специалист приезжает домой или в клинику и помогает с подготовкой и документами.', 'menu_order' => 20),
    'proshchanie' => array('post_title' => 'Прощание', 'post_content' => 'Оставляем время, чтобы владелец мог спокойно попрощаться.', 'menu_order' => 30),
    'krematsiya' => array('post_title' => 'Кремация', 'post_content' => 'Организуем общую или индивидуальную кремацию.', 'menu_order' => 40),
);

foreach ($steps as $slug => $data) {
    vr_seed_upsert_post($data, $slug, 'vr_process_step');
}

$reviews = array(
    'anna-saarinen' => array(
        'post_title' => 'Анна Сааринен',
        'post_excerpt' => 'Хозяйка кота Марсика',
        'post_content' => 'Диспетчер быстро организовал выезд. Поддержка рядом, внимательно объяснили формат и помогли без лишнего стресса.',
        'menu_order' => 10,
    ),
    'igor-tarasov' => array(
        'post_title' => 'Игорь Тарасов',
        'post_excerpt' => 'Хозяин немецкой овчарки Рекса',
        'post_content' => 'Сотрудники приехали быстро, помогли с погрузкой и не навязывали лишних услуг. Все прошло достойно и спокойно.',
        'menu_order' => 20,
    ),
);

foreach ($reviews as $slug => $data) {
    vr_seed_upsert_post($data, $slug, 'vr_review');
}

if (! empty($page_ids['home'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $page_ids['home']);
}

update_option('permalink_structure', '/%postname%/');
vr_seed_menu(
    'Основное меню',
    'primary',
    array('o-nas', 'uslugi', 'usyplenie-zhivotnyh', 'krematsyja-zhyvotnyh', 'vyvoz-zhivotnyh', 'usyplenie-koshek', 'usyplenie-sobak', 'obschaja-krematsyja', 'individualnaja-krematsyja', 'tseny', 'kontakty'),
    $page_ids,
    array('usyplenie-zhivotnyh', 'krematsyja-zhyvotnyh', 'vyvoz-zhivotnyh', 'usyplenie-koshek', 'usyplenie-sobak', 'obschaja-krematsyja', 'individualnaja-krematsyja'),
    'uslugi'
);
vr_seed_menu('Услуги в подвале', 'footer_services', array('usyplenie-zhivotnyh', 'krematsyja-zhyvotnyh', 'vyvoz-zhivotnyh', 'usyplenie-koshek', 'usyplenie-sobak', 'obschaja-krematsyja', 'individualnaja-krematsyja'), $page_ids);

flush_rewrite_rules(false);

echo "Seed complete\n";
