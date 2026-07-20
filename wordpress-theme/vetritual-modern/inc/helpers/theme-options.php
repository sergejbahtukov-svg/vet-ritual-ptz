<?php
if (! defined('ABSPATH')) {
    exit;
}

function vr_theme_setting_defaults() {
    return array(
        'public_domain_url' => 'https://vet-ritual-ptz.ru',
        'site_name' => 'Vet Ritual PTZ',
        'site_city' => 'Петрозаводск и Карелия',
        'phone_main' => '+7 953 533-16-00',
        'phone_secondary' => '',
        'contact_email' => '',
        'address_text' => 'Республика Карелия, г. Петрозаводск, пр. Энергетиков, 33',
        'theme_color' => '#fffdf8',
        'media_base_url' => '',
        'hero_title' => 'Усыпление, кремация и вывоз животных с бережным сопровождением',
        'hero_subtitle' => 'Работаем круглосуточно, выезжаем по Петрозаводску, Прионежскому району и дальним районам Карелии по согласованию.',
        'hero_primary_cta_text' => 'Позвонить 24/7',
        'hero_primary_cta_url' => 'tel:+79535331600',
        'hero_secondary_cta_text' => 'Посмотреть цены',
        'hero_secondary_cta_url' => '#prices',
        'hero_image' => 'hero-pets-mobile.webp',
        'hero_image_id' => 'hero-pets-mobile.webp',
        'services_intro_title' => 'Наши услуги',
        'services_intro_text' => 'Помогаем взять на себя сложные организационные шаги',
        'about_intro_title' => 'О компании',
        'about_intro_text' => 'Мы — ритуальная служба для домашних питомцев в Петрозаводске. Берем на себя заботы с момента звонка до транспортировки, кремации и передачи урны.',
        'contact_block_title' => 'Контакты',
        'contact_block_text' => 'Позвоните в любое время суток. Ответим спокойно и подберем формат помощи.',
        'contact_block_phone' => '+7 953 533-16-00',
        'contact_block_email' => '',
        'contact_block_address' => 'Республика Карелия, г. Петрозаводск, пр. Энергетиков, 33',
        'default_meta_title' => 'Усыпление и кремация животных в Петрозаводске | Vet Ritual',
        'default_meta_description' => 'Усыпление, кремация и вывоз животных в Петрозаводске и Карелии. Круглосуточно, аккуратное сопровождение, понятные условия.',
        'og_image' => 'og-logo-share.png',
        'twitter_card_type' => 'summary_large_image',
        'cookie_consent_mode' => 'disabled',
        'cookie_consent_key' => 'vr_cookie_consent',
        'cookie_banner_text' => 'Мы используем cookie, чтобы сайт работал стабильно и корректно учитывал согласие. Продолжая пользоваться сайтом, вы соглашаетесь с использованием cookie.',
        'cookie_button_accept' => 'Хорошо',
        'cookie_button_reject' => 'Позже',
        'services_cards_json' => '[{"title":"Усыпление животных","text":"Процедура проводится на дому в два этапа: сначала обезболивание и наркоз, затем мягкое прекращение жизненных функций.","link":"\/usyplenie-zhivotnyh\/","icon":"service-euthanasia.webp"},{"title":"Кремация животных","text":"Можно выбрать общую кремацию без выдачи праха или индивидуальную кремацию с возвратом урны.","link":"\/krematsyja-zhyvotnyh\/","icon":"service-cremation.webp"},{"title":"Вывоз животных","text":"Аккуратно транспортируем тело животного из дома или клиники в крематорий с соблюдением санитарных требований.","link":"\/vyvoz-zhivotnyh\/","icon":"service-transport-owner.webp"},{"title":"Усыпление кошек","text":"Помощь на дому в привычной для кошки обстановке, без поездки в клинику и лишнего стресса.","link":"\/usyplenie-koshek\/","icon":"page-hero-cats.webp"},{"title":"Усыпление собак","text":"Выезд специалиста, поддержка владельца и бережное сопровождение питомца любого размера.","link":"\/usyplenie-sobak\/","icon":"page-hero-dogs.webp"}]',
        'prices_cards_json' => '[{"title":"Усыпление","note":"По городу","rows":[{"label":"Кошка","value":"3 000–3 500 руб."},{"label":"Собаки 5–10 кг","value":"4 000–5 000 руб."},{"label":"Собаки 11–20 кг","value":"5 000–6 000 руб."},{"label":"Собаки от 20 кг","value":"от 7 000 руб."}]},{"title":"Общая кремация","rows":[{"label":"до 5 кг","value":"4 000 руб."},{"label":"до 10 кг","value":"4 500 руб."},{"label":"до 20 кг","value":"5 500 руб."},{"label":"до 50 кг","value":"7 000 руб."}]},{"title":"Индивидуальная кремация","note":"С отдельным возвратом урны","rows":[{"label":"до 5 кг","value":"8 000 руб."},{"label":"5–20 кг","value":"8 500–10 000 руб."},{"label":"30 кг","value":"10 000–12 000 руб."}]}]',
        'process_steps_json' => '[{"title":"Звонок","description":"Уточняем ситуацию, адрес, вес животного и подходящий формат услуги."},{"title":"Выезд","description":"Специалист приезжает домой или в клинику и помогает с подготовкой и документами."},{"title":"Прощание","description":"Оставляем время, чтобы владелец мог спокойно попрощаться."},{"title":"Кремация","description":"Организуем общую или индивидуальную кремацию."}]',
        'reviews_json' => '[{"name":"Анна Сааринен","subtitle":"Хозяйка кота Марсика","text":"Диспетчер быстро организовал выезд. Поддержка рядом, внимательно объяснили формат и помогли без лишнего стресса."},{"name":"Игорь Тарасов","subtitle":"Хозяин немецкой овчарки Рекса","text":"Сотрудники приехали быстро, помогли с погрузкой и не навязывали лишних услуг. Все прошло достойно и спокойно."}]',
        'about_features_json' => '[{"title":"Индивидуальный подход","text":"Мы объясняем формат услуги и порядок действий до начала работы."},{"title":"Что важно","items":["бережное отношение к питомцу и владельцу","прозрачные цены по весовым категориям","время на прощание без суеты","круглосуточный прием обращений"]}]',
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
        'site_name' => array('section' => 'vr_general', 'label' => 'Название компании', 'type' => 'text'),
        'site_city' => array('section' => 'vr_general', 'label' => 'Город/регион', 'type' => 'text'),
        'phone_main' => array('section' => 'vr_general', 'label' => 'Основной телефон', 'type' => 'text'),
        'phone_secondary' => array('section' => 'vr_general', 'label' => 'Доп. телефон', 'type' => 'text'),
        'contact_email' => array('section' => 'vr_general', 'label' => 'Контактный email', 'type' => 'text'),
        'address_text' => array('section' => 'vr_general', 'label' => 'Адрес', 'type' => 'textarea'),

        'hero_title' => array('section' => 'vr_hero', 'label' => 'Hero: заголовок', 'type' => 'text'),
        'hero_subtitle' => array('section' => 'vr_hero', 'label' => 'Hero: подзаголовок', 'type' => 'textarea'),
        'hero_primary_cta_text' => array('section' => 'vr_hero', 'label' => 'Hero CTA: текст основной кнопки', 'type' => 'text'),
        'hero_primary_cta_url' => array('section' => 'vr_hero', 'label' => 'Hero CTA: ссылка', 'type' => 'text'),
        'hero_secondary_cta_text' => array('section' => 'vr_hero', 'label' => 'Hero CTA: текст вторичной кнопки', 'type' => 'text'),
        'hero_secondary_cta_url' => array('section' => 'vr_hero', 'label' => 'Hero CTA: ссылка вторичной кнопки', 'type' => 'text'),
        'hero_image' => array('section' => 'vr_hero', 'label' => 'Hero: имя файла изображения', 'type' => 'text'),
        'hero_image_id' => array('section' => 'vr_hero', 'label' => 'Hero: резервный источник изображения', 'type' => 'text'),
        'media_base_url' => array('section' => 'vr_hero', 'label' => 'Базовый URL медиа', 'type' => 'text'),

        'services_intro_title' => array('section' => 'vr_sections', 'label' => 'Заголовок блока Услуги', 'type' => 'text'),
        'services_intro_text' => array('section' => 'vr_sections', 'label' => 'Подзаголовок блока Услуги', 'type' => 'textarea'),
        'services_cards_json' => array('section' => 'vr_sections', 'label' => 'Карточки услуг (JSON)', 'type' => 'textarea'),
        'prices_cards_json' => array('section' => 'vr_sections', 'label' => 'Карточки цен (JSON)', 'type' => 'textarea'),
        'process_steps_json' => array('section' => 'vr_sections', 'label' => 'Этапы обращения (JSON)', 'type' => 'textarea'),
        'reviews_json' => array('section' => 'vr_sections', 'label' => 'Отзывы (JSON)', 'type' => 'textarea'),
        'contact_block_title' => array('section' => 'vr_sections', 'label' => 'Заголовок блока контактов', 'type' => 'text'),
        'contact_block_text' => array('section' => 'vr_sections', 'label' => 'Текст блока контактов', 'type' => 'textarea'),
        'contact_block_phone' => array('section' => 'vr_sections', 'label' => 'Телефон для контактов', 'type' => 'text'),
        'contact_block_email' => array('section' => 'vr_sections', 'label' => 'Контактный email в блоке контактов', 'type' => 'text'),
        'contact_block_address' => array('section' => 'vr_sections', 'label' => 'Адрес в блоке контактов', 'type' => 'text'),
        'about_intro_title' => array('section' => 'vr_sections', 'label' => 'О компании: заголовок', 'type' => 'text'),
        'about_intro_text' => array('section' => 'vr_sections', 'label' => 'О компании: текст', 'type' => 'textarea'),
        'about_features_json' => array('section' => 'vr_sections', 'label' => 'О компании: JSON фич', 'type' => 'textarea'),

        'default_meta_title' => array('section' => 'vr_seo', 'label' => 'SEO title (fallback)', 'type' => 'text'),
        'default_meta_description' => array('section' => 'vr_seo', 'label' => 'SEO description (fallback)', 'type' => 'textarea'),
        'og_image' => array('section' => 'vr_seo', 'label' => 'OG image (имя файла)', 'type' => 'text'),
        'twitter_card_type' => array('section' => 'vr_seo', 'label' => 'Twitter Card', 'type' => 'text'),
        'public_domain_url' => array('section' => 'vr_seo', 'label' => 'Публичный домен', 'type' => 'text'),
        'yandex_verification' => array('section' => 'vr_seo', 'label' => 'Verification: Yandex', 'type' => 'text'),
        'google_verification' => array('section' => 'vr_seo', 'label' => 'Verification: Google', 'type' => 'text'),
        'bing_verification' => array('section' => 'vr_seo', 'label' => 'Verification: Bing', 'type' => 'text'),
        'mailru_verification' => array('section' => 'vr_seo', 'label' => 'Verification: Mail.ru / VK', 'type' => 'text'),
        'custom_head_html' => array('section' => 'vr_seo', 'label' => 'HTML в head', 'type' => 'textarea'),

        'cookie_consent_mode' => array('section' => 'vr_analytics', 'label' => 'Режим согласия (always|on_consent|disabled)', 'type' => 'text'),
        'cookie_consent_key' => array('section' => 'vr_analytics', 'label' => 'Ключ cookie согласия', 'type' => 'text'),
        'cookie_banner_text' => array('section' => 'vr_analytics', 'label' => 'Текст cookie-баннера', 'type' => 'textarea'),
        'cookie_button_accept' => array('section' => 'vr_analytics', 'label' => 'Кнопка согласия', 'type' => 'text'),
        'cookie_button_reject' => array('section' => 'vr_analytics', 'label' => 'Кнопка отклонения', 'type' => 'text'),
        'yandex_metrika_id' => array('section' => 'vr_analytics', 'label' => 'ID счетчика Яндекс.Метрики', 'type' => 'text'),
        'yandex_metrika_webvisor' => array('section' => 'vr_analytics', 'label' => 'Webvisor Яндекс.Метрики', 'type' => 'text'),
        'yandex_metrika_ecommerce' => array('section' => 'vr_analytics', 'label' => 'ecommerce Мetrika', 'type' => 'text'),
        'ga4_id' => array('section' => 'vr_analytics', 'label' => 'GA4 Measurement ID', 'type' => 'text'),
        'gtm_id' => array('section' => 'vr_analytics', 'label' => 'Google Tag Manager ID', 'type' => 'text'),
        'vk_pixel_id' => array('section' => 'vr_analytics', 'label' => 'VK Pixel ID', 'type' => 'text'),
        'meta_pixel_id' => array('section' => 'vr_analytics', 'label' => 'Meta Pixel ID', 'type' => 'text'),
        'topmailru_counter_id' => array('section' => 'vr_analytics', 'label' => 'TopMail.ru / myTarget ID', 'type' => 'text'),
        'tiktok_pixel_id' => array('section' => 'vr_analytics', 'label' => 'TikTok Pixel ID', 'type' => 'text'),
        'body_start_html' => array('section' => 'vr_analytics', 'label' => 'HTML сразу после body', 'type' => 'textarea'),
        'body_end_html' => array('section' => 'vr_analytics', 'label' => 'HTML перед закрытием body', 'type' => 'textarea'),
        'copyright_text' => array('section' => 'vr_analytics', 'label' => 'Текст в подвале', 'type' => 'text'),
    );
}

function vr_theme_setting($key, $default = '') {
    static $cache = array();

    if (array_key_exists($key, $cache)) {
        return $cache[$key];
    }

    $defaults = vr_theme_setting_defaults();
    $value = array_key_exists($key, $defaults) ? $defaults[$key] : $default;

    $options = get_option('vr_theme_options', array());
    if (is_array($options) && array_key_exists($key, $options) && $options[$key] !== '') {
        $value = $options[$key];
    }

    $theme_mod = get_theme_mod("vr_theme_{$key}", null);
    if ($theme_mod !== null && $theme_mod !== '') {
        $value = $theme_mod;
    }

    if (function_exists('get_field')) {
        $acf_value = get_field("vr_{$key}", 'option', false);
        if ($acf_value !== null && $acf_value !== '') {
            $value = $acf_value;
        }
    }

    $cache[$key] = $value;

    return $value;
}

function vr_theme_setting_array($key, $default = array()) {
    $value = vr_theme_setting($key, $default);

    if (is_array($value)) {
        return $value;
    }

    if (! is_string($value)) {
        return $default;
    }

    $decoded = json_decode($value, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        return $decoded;
    }

    return $default;
}

function vr_theme_setting_bool($key, $default = false) {
    $value = vr_theme_setting($key, $default ? '1' : '0');
    if (is_bool($value)) {
        return $value;
    }

    if (is_numeric($value)) {
        return (int)$value === 1;
    }

    return in_array(strtolower((string)$value), array('1', 'true', 'yes', 'on'), true);
}

function vr_theme_media_url($file_name) {
    $media_base = vr_theme_setting('media_base_url', '');
    if (empty($media_base)) {
        $media_base = get_template_directory_uri() . '/assets/media';
    }

    $file_name = ltrim((string)$file_name, '/');
    return esc_url(trailingslashit($media_base) . $file_name);
}

function vr_route_aliases() {
    return array(
        'about' => 'o-nas',
        'vyvoz-umershih-zhivotnyh' => 'vyvoz-zhivotnyh',
        'vyvoz-umershikh-zhivotnyh' => 'vyvoz-zhivotnyh',
        'vyvoz-tela-zhivotnogo' => 'vyvoz-zhivotnyh',
    );
}

function vr_route_map() {
    return array(
        'o-nas' => array(
            'title' => 'О Vet Ritual PTZ: кремация животных в Петрозаводске',
            'description' => 'Vet Ritual PTZ помогает владельцам питомцев в Петрозаводске: вывоз, бережная кремация, прозрачные цены и круглосуточный прием обращений.',
            'hero_title' => 'О нас',
            'hero_class' => 'vr-page-hero vr-page-hero--about',
            'hero_lead' => 'О службе, которая помогает владельцам питомцев пройти тяжелый момент спокойно и без лишней суеты.',
        ),
        'uslugi' => array(
            'title' => 'Услуги Vet Ritual: усыпление и кремация животных в Петрозаводске',
            'description' => 'Усыпление, кремация и вывоз животных в Петрозаводске и Карелии. Бережная помощь Vet Ritual на дому, консультация и выезд 24/7.',
            'hero_title' => 'Услуги',
            'hero_class' => 'vr-page-hero vr-page-hero--services',
            'hero_lead' => 'Все основные направления помощи: усыпление, кремация и вывоз животных по Петрозаводску и Карелии.',
        ),
        'usyplenie-zhivotnyh' => array(
            'title' => 'Усыпление животных на дому в Петрозаводске | Vet Ritual',
            'description' => 'Бережное усыпление животных на дому в Петрозаводске: консультация, выезд 24/7, безболезненная процедура в два этапа и помощь с кремацией.',
            'hero_title' => 'Усыпление животных',
            'hero_class' => 'vr-page-hero vr-page-hero--euthanasia',
            'hero_lead' => 'Безболезненная процедура на дому, консультация специалиста и время на спокойное прощание.',
        ),
        'usyplenie-koshek' => array(
            'title' => 'Усыпление кошек на дому в Петрозаводске | Vet Ritual',
            'description' => 'Бережное усыпление кошек на дому в Петрозаводске: консультация, выезд специалиста и поддержка на каждом этапе.',
            'hero_title' => 'Усыпление кошек',
            'hero_class' => 'vr-page-hero vr-page-hero--cats',
            'hero_lead' => 'Помощь в привычной для кошки обстановке, без лишнего стресса.',
        ),
        'usyplenie-sobak' => array(
            'title' => 'Усыпление собак на дому в Петрозаводске | Vet Ritual',
            'description' => 'Бережное усыпление собак на дому в Петрозаводске и Карелии с выездом специалиста и поддержкой владельца.',
            'hero_title' => 'Усыпление собак',
            'hero_class' => 'vr-page-hero vr-page-hero--dogs',
            'hero_lead' => 'Выезд специалиста, поддержка владельца и бережное сопровождение питомца любого размера.',
        ),
        'krematsyja-zhyvotnyh' => array(
            'title' => 'Кремация животных в Петрозаводске | Vet Ritual',
            'description' => 'Общая и индивидуальная кремация домашних животных в Петрозаводске и Карелии.',
            'hero_title' => 'Кремация животных',
            'hero_class' => 'vr-page-hero vr-page-hero--cremation',
            'hero_lead' => 'Общая или индивидуальная кремация с прозрачными условиями.',
        ),
        'obschaja-krematsyja' => array(
            'title' => 'Общая кремация животных в Петрозаводске | Vet Ritual',
            'description' => 'Организуем общую кремацию питомцев без выдачи праха: бережный вывоз и прозрачные условия.',
            'hero_title' => 'Общая кремация',
            'hero_class' => 'vr-page-hero vr-page-hero--common-cremation',
            'hero_lead' => 'Бережно организуем общую кремацию без лишних действий и по согласованной стоимости.',
        ),
        'individualnaja-krematsyja' => array(
            'title' => 'Индивидуальная кремация животных в Петрозаводске | Vet Ritual',
            'description' => 'Отдельная кремация питомца с возвратом урны и прозрачным порядком передачи праха.',
            'hero_title' => 'Индивидуальная кремация',
            'hero_class' => 'vr-page-hero vr-page-hero--individual-cremation',
            'hero_lead' => 'Отдельная кремация питомца с возвратом урны.',
        ),
        'vyvoz-zhivotnyh' => array(
            'title' => 'Вывоз умерших животных в Петрозаводске | Vet Ritual',
            'description' => 'Бережно вывезем тело питомца из дома или ветеринарной клиники в крематорий. 24/7 в Петрозаводске и Карелии.',
            'hero_title' => 'Вывоз животных',
            'hero_class' => 'vr-page-hero vr-page-hero--transport',
            'hero_lead' => 'Законная и безопасная транспортировка тела животного из дома или клиники в крематорий.',
        ),
        'tseny' => array(
            'title' => 'Цены на усыпление и кремацию животных в Петрозаводске',
            'description' => 'Стоимость услуги зависит от веса животного, расстояния и выбранного формата обслуживания.',
            'hero_title' => 'Цены',
            'hero_class' => 'vr-page-hero vr-page-hero--prices',
            'hero_lead' => 'Стоимость зависит от услуги, веса питомца, района выезда и выбранного формата.',
        ),
        'kontakty' => array(
            'title' => 'Контакты Vet Ritual в Петрозаводске',
            'description' => 'Телефон, адрес и подробности по обращениям: Vet Ritual помогает 24/7.',
            'hero_title' => 'Контакты',
            'hero_class' => 'vr-page-hero vr-page-hero--contacts',
            'hero_lead' => 'Позвоните в любое время, ответим спокойно и по делу.',
        ),
    );
}

function vr_normalize_route_slug($value = '') {
    $value = is_string($value) ? $value : '';
    $value = preg_replace('#\?.*#', '', $value);
    $value = trim($value, '/');

    if ($value === '') {
        return 'home';
    }

    $value = sanitize_title($value);
    $aliases = vr_route_aliases();
    if (array_key_exists($value, $aliases)) {
        return $aliases[$value];
    }

    return $value;
}

function vr_resolve_route_slug($value = '') {
    if ($value === '') {
        $route_query = get_query_var('vr_route_page', '');
        if (! empty($route_query)) {
            return vr_normalize_route_slug($route_query);
        }

        $request_path = '';
        if (! empty($_SERVER['REQUEST_URI'])) {
            $request_path = wp_parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }
        if ($request_path === null) {
            $request_path = '';
        }
        $value = $request_path;
    }

    $value = vr_normalize_route_slug((string)$value);
    if ($value === 'home' || array_key_exists($value, vr_route_map()) || is_numeric($value)) {
        return $value;
    }

    return '404';
}

function vr_get_route_info($route_slug = '') {
    $slug = vr_resolve_route_slug($route_slug);
    $map = vr_route_map();
    if (array_key_exists($slug, $map)) {
        return array_merge(
            array(
                'slug' => $slug,
                'hero_title' => $map[$slug]['hero_title'],
                'hero_lead' => '',
                'title' => $map[$slug]['title'],
                'description' => $map[$slug]['description'],
                'hero_class' => $map[$slug]['hero_class'],
                'route_path' => trailingslashit(home_url($slug)),
            ),
            array(
                'route_path' => trailingslashit(home_url($slug)),
            ),
            $map[$slug]
        );
    }

    if ($slug === 'home') {
        return array(
            'slug' => 'home',
            'title' => vr_theme_setting('default_meta_title', ''),
            'description' => vr_theme_setting('default_meta_description', ''),
            'hero_title' => vr_theme_setting('hero_title', ''),
            'hero_lead' => vr_theme_setting('hero_subtitle', ''),
            'hero_class' => 'vr-hero',
            'hero_secondary_cta_text' => vr_theme_setting('hero_secondary_cta_text', ''),
            'hero_secondary_cta_url' => vr_theme_setting('hero_secondary_cta_url', ''),
            'route_path' => home_url('/'),
        );
    }

    return array(
        'slug' => $slug,
        'title' => get_bloginfo('name'),
        'description' => vr_theme_setting('default_meta_description', ''),
        'hero_title' => ucfirst(str_replace('-', ' ', $slug)),
        'hero_lead' => '',
        'hero_class' => 'vr-page-hero',
        'route_path' => home_url($slug),
    );
}

function vr_route_is_known($slug) {
    $slug = vr_normalize_route_slug($slug);
    return array_key_exists($slug, vr_route_map());
}

function vr_get_route_page_content($slug) {
    $slug = vr_normalize_route_slug($slug);
    if ($slug === 'home') {
        return '';
    }

    $page = get_page_by_path($slug);
    if ($page instanceof WP_Post && ! empty($page->post_content)) {
        return apply_filters('the_content', $page->post_content);
    }

    return '';
}

function vr_get_route_fallback_content($slug) {
    $slug = vr_normalize_route_slug($slug);
    switch ($slug) {
        case 'uslugi':
            return '<h2>Услуги Vet Ritual PTZ</h2><p>Помогаем владельцам животных в сложный момент: усыпление на дому, кремация и вывоз тела.</p><ul><li><a href="/usyplenie-zhivotnyh/">Усыпление животных на дому</a>.</li><li><a href="/krematsyja-zhyvotnyh/">Кремация животных</a>.</li><li><a href="/vyvoz-zhivotnyh/">Вывоз животных</a>.</li></ul><p>Работаем по Петрозаводску, Прионежскому району и районом Карелии по согласованию.</p>';
        case 'usyplenie-zhivotnyh':
            return '<h2>Усыпление животных</h2><p>Процедура проходит спокойно: сначала обезболивание и наркоз, затем мягкое прекращение жизненных функций.</p>';
        case 'usyplenie-koshek':
            return '<h2>Усыпление кошек</h2><p>Мы выезжаем в спокойной обстановке и помогаем владельцу пройти это без стресса.</p>';
        case 'usyplenie-sobak':
            return '<h2>Усыпление собак</h2><p>Поддерживаем владельца и проводим процедуру на дому с достаточным временем на прощание.</p>';
        case 'krematsyja-zhyvotnyh':
            return '<h2>Кремация животных</h2><p>Организуем общую и индивидуальную кремацию с корректной документацией и коммуникацией.</p>';
        case 'obschaja-krematsyja':
            return '<h2>Общая кремация</h2><p>Доступный формат с чёткой предварительной стоимостью и поштучным расчётом веса.</p>';
        case 'individualnaja-krematsyja':
            return '<h2>Индивидуальная кремация</h2><p>Отдельная кремация питомца с возвратом праха в урне.</p>';
        case 'vyvoz-zhivotnyh':
            return '<h2>Вывоз животных</h2><p>Аккуратно транспортируем тело питомца из дома или клиники в крематорий и согласовываем формат кремации заранее.</p>';
        case 'tseny':
            return '<h2>Цены</h2><p>Стоимость услуг зависит от веса питомца, зоны выезда и выбранного формата кремации.</p>';
        case 'kontakty':
            return '<h2>Контакты</h2><p>Позвоните по указанному номеру. Консультация: +7 953 533-16-00.</p>';
        default:
            return '';
    }
}


