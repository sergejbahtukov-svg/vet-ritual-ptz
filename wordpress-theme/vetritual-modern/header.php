<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  $is_404 = is_404();
  $queried_object = get_queried_object();
  $title = wp_get_document_title();
  $description = (string) get_bloginfo('description');
  $canonical = home_url('/');

  if ($queried_object instanceof WP_Post) {
      $title = get_the_title($queried_object);
      $description = has_excerpt($queried_object) ? get_the_excerpt($queried_object) : vr_get_post_plain_text($queried_object);
      $canonical = get_permalink($queried_object);
  } elseif (is_front_page()) {
      $front_id = (int) get_option('page_on_front');
      if ($front_id > 0) {
          $front_post = get_post($front_id);
          $title = get_the_title($front_id);
          $description = has_excerpt($front_id) ? get_the_excerpt($front_id) : vr_get_post_plain_text($front_post);
      }
      $canonical = home_url('/');
  }

  if ($is_404) {
      $title = __('Страница не найдена', 'vetritual-modern');
      $description = __('Запрошенная страница не найдена.', 'vetritual-modern');
      $canonical = '';
  }

  if ($description === '') {
      $description = (string) vr_theme_setting('site_description', get_bloginfo('description'));
  }

  $canonical = $canonical ? esc_url_raw($canonical) : '';
  $domain = trailingslashit(esc_url_raw(vr_theme_setting('public_domain_url', home_url('/'))));
  $og_image = '';
  if ($queried_object instanceof WP_Post) {
      $og_image = get_the_post_thumbnail_url($queried_object, 'full');
  }
  if (! $og_image) {
      $og_image = vr_theme_media_url(vr_theme_setting('og_image', 'og-logo-share.png'));
  }
  $og_image = esc_url_raw($og_image);

  $og_image_alt = 'Логотип Vet Ritual: ритуальные вет-услуги в Петрозаводске и Карелии';
  $site_name = vr_theme_setting('site_name', get_bloginfo('name'));
  $brand_tagline = vr_theme_setting('brand_tagline', 'бережная помощь 24/7');
  $phone_main = vr_theme_setting('phone_main', '');
  $phone_href = preg_replace('/[^0-9+]/', '', $phone_main);
  $address_text = vr_theme_setting('address_text', '');
  $theme_color = vr_theme_setting('theme_color', '#fffdf8');
  $brand_logo = '';
  $logo_id = absint(get_theme_mod('custom_logo', 0));
  if ($logo_id > 0) {
      $brand_logo = wp_get_attachment_image(
          $logo_id,
          'full',
          false,
          array(
              'class' => 'vr-brand__logo',
              'alt' => esc_attr($site_name),
          )
      );
  }

  $organization_schema = array(
      '@context' => 'https://schema.org',
      '@type' => 'LocalBusiness',
      '@id' => rtrim($domain, '/') . '/#organization',
      'name' => $site_name,
      'url' => $domain,
      'telephone' => $phone_main,
      'description' => $description,
      'priceRange' => 'RUB',
      'image' => $og_image,
      'address' => array(
          '@type' => 'PostalAddress',
          'streetAddress' => $address_text,
          'addressLocality' => 'Petrozavodsk',
          'addressRegion' => 'Republic of Karelia',
          'addressCountry' => 'RU',
      ),
      'areaServed' => array(
          array('@type' => 'City', 'name' => 'Petrozavodsk'),
          array('@type' => 'AdministrativeArea', 'name' => 'Republic of Karelia'),
      ),
      'openingHours' => 'Mo-Su 00:00-23:59',
  );

  $webpage_schema = array(
      '@context' => 'https://schema.org',
      '@type' => 'WebPage',
      '@id' => $canonical . '#webpage',
      'url' => $canonical,
      'name' => $title,
      'description' => $description,
      'inLanguage' => 'ru-RU',
      'primaryImageOfPage' => $og_image,
      'isPartOf' => array(
          '@type' => 'WebSite',
          '@id' => rtrim($domain, '/') . '/#website',
          'name' => $site_name,
          'url' => $domain,
      ),
      'about' => array('@id' => rtrim($domain, '/') . '/#organization'),
  );

  $breadcrumb_schema = array(
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => array(
          array('@type' => 'ListItem', 'position' => 1, 'name' => $site_name, 'item' => $domain),
          array('@type' => 'ListItem', 'position' => 2, 'name' => $title, 'item' => $canonical),
      ),
  );
  ?>

  <meta name="description" content="<?php echo esc_attr($description); ?>">
  <?php if (! $is_404 && $canonical !== '') : ?>
    <link rel="canonical" href="<?php echo esc_url($canonical); ?>">
  <?php endif; ?>
  <link rel="image_src" href="<?php echo esc_url($og_image); ?>">

  <meta property="og:type" content="website">
  <meta property="og:locale" content="ru_RU">
  <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
  <meta property="og:title" content="<?php echo esc_attr($title); ?>">
  <meta property="og:description" content="<?php echo esc_attr($description); ?>">
  <?php if (! $is_404 && $canonical !== '') : ?>
    <meta property="og:url" content="<?php echo esc_url($canonical); ?>">
  <?php endif; ?>
  <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
  <meta property="og:image:secure_url" content="<?php echo esc_url($og_image); ?>">
  <meta property="og:image:alt" content="<?php echo esc_attr($og_image_alt); ?>">

  <meta name="twitter:card" content="<?php echo esc_attr(vr_theme_setting('twitter_card_type', 'summary_large_image')); ?>">
  <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
  <meta name="twitter:description" content="<?php echo esc_attr($description); ?>">
  <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">
  <meta name="twitter:image:alt" content="<?php echo esc_attr($og_image_alt); ?>">

  <meta name="theme-color" content="<?php echo esc_attr($theme_color); ?>">
  <meta name="msapplication-TileColor" content="<?php echo esc_attr($theme_color); ?>">
  <meta name="msapplication-TileImage" content="<?php echo esc_url(vr_theme_media_url('mstile-150x150.png')); ?>">
  <meta name="geo.placename" content="Петрозаводск">
  <meta name="geo.region" content="RU-KR">

  <?php if (! $is_404 && $canonical !== '') : ?>
    <script type="application/ld+json">
      <?php echo wp_json_encode($organization_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    </script>
  <?php endif; ?>

  <?php if (! $is_404 && $canonical !== '') : ?>
    <script type="application/ld+json">
      <?php echo wp_json_encode($webpage_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    </script>
  <?php endif; ?>

  <?php if (! $is_404 && ! is_front_page() && $canonical !== '') : ?>
    <script type="application/ld+json">
      <?php echo wp_json_encode($breadcrumb_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    </script>
  <?php endif; ?>

  <?php if (! empty(vr_theme_setting('yandex_verification', ''))) : ?>
    <meta name="yandex-verification" content="<?php echo esc_attr(vr_theme_setting('yandex_verification')); ?>">
  <?php endif; ?>
  <?php if (! empty(vr_theme_setting('google_verification', ''))) : ?>
    <meta name="google-site-verification" content="<?php echo esc_attr(vr_theme_setting('google_verification')); ?>">
  <?php endif; ?>
  <?php if (! empty(vr_theme_setting('bing_verification', ''))) : ?>
    <meta name="msvalidate.01" content="<?php echo esc_attr(vr_theme_setting('bing_verification')); ?>">
  <?php endif; ?>
  <?php if (! empty(vr_theme_setting('mailru_verification', ''))) : ?>
    <meta name="mailru-verification" content="<?php echo esc_attr(vr_theme_setting('mailru_verification')); ?>">
  <?php endif; ?>

  <?php wp_head(); ?>
  <?php echo wp_kses_post(vr_theme_setting('custom_head_html', '')); ?>

  <link rel="icon" href="<?php echo esc_url(vr_theme_media_url('favicon.ico')); ?>" sizes="any">
  <link rel="icon" href="<?php echo esc_url(vr_theme_media_url('favicon.svg')); ?>" type="image/svg+xml">
  <link rel="icon" href="<?php echo esc_url(vr_theme_media_url('favicon-32x32.png')); ?>" sizes="32x32" type="image/png">
  <link rel="icon" href="<?php echo esc_url(vr_theme_media_url('favicon-16x16.png')); ?>" sizes="16x16" type="image/png">
  <link rel="apple-touch-icon" href="<?php echo esc_url(vr_theme_media_url('apple-touch-icon.png')); ?>">
  <link rel="manifest" href="<?php echo esc_url(vr_theme_media_url('site.webmanifest')); ?>">
</head>
<body <?php body_class('vr-site'); ?>>
<?php wp_body_open(); ?>
<?php echo wp_kses_post(vr_theme_setting('body_start_html', '')); ?>

<?php
if (! class_exists('VR_Header_Nav_Walker')) {
    class VR_Header_Nav_Walker extends Walker_Nav_Menu {
        private $items_with_children = array();

        public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args = null, &$output = '') {
            if ($element) {
                $id_field = $this->db_fields['id'];
                $this->items_with_children[$element->$id_field] = ! empty($children_elements[$element->$id_field]);
            }

            parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }

        public function start_lvl(&$output, $depth = 0, $args = null) {
            if ($depth === 0) {
                $output .= "\n        <span class=\"vr-nav__dropdown\">\n";
            }
        }

        public function end_lvl(&$output, $depth = 0, $args = null) {
            if ($depth === 0) {
                $output .= "        </span>\n";
            }
        }

        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            if ($depth > 1) {
                return;
            }

            $title = apply_filters('the_title', $item->title, $item->ID);
            $attributes = '';

            if (! empty($item->url)) {
                $attributes .= ' href="' . esc_attr($item->url) . '"';
            }
            if (! empty($item->target)) {
                $attributes .= ' target="' . esc_attr($item->target) . '"';
            }
            if (! empty($item->xfn)) {
                $attributes .= ' rel="' . esc_attr($item->xfn) . '"';
            }

            if ($depth === 0 && ! empty($this->items_with_children[$item->ID])) {
                $output .= '      <span class="vr-nav__item">' . "\n        ";
            } else {
                $output .= str_repeat('  ', max(0, $depth + 3));
            }

            $output .= '<a' . $attributes . '>' . esc_html($title) . '</a>' . "\n";
        }

        public function end_el(&$output, $item, $depth = 0, $args = null) {
            if ($depth === 0 && ! empty($this->items_with_children[$item->ID])) {
                $output .= "      </span>\n";
            }
        }
    }
}
?>

<header class="vr-header" data-vr-header>
  <div class="vr-shell vr-header__inner">
    <a class="vr-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <span class="vr-brand__mark">
        <?php if (! empty($brand_logo)) : ?>
          <?php echo wp_kses_post($brand_logo); ?>
        <?php else : ?>
          <img src="<?php echo esc_url(vr_theme_media_url('logo-mark.svg')); ?>" alt="<?php echo esc_attr($site_name); ?>" loading="eager">
        <?php endif; ?>
      </span>
      <span>
        <strong><?php echo esc_html($site_name); ?></strong>
        <small><?php echo esc_html($brand_tagline); ?></small>
      </span>
    </a>

    <button class="vr-menu-toggle" type="button" aria-label="<?php esc_attr_e('Открыть меню', 'vetritual-modern'); ?>" aria-expanded="false" data-vr-menu-toggle>
      <span></span><span></span><span></span>
    </button>

    <nav class="vr-nav" aria-label="<?php esc_attr_e('Основная навигация', 'vetritual-modern'); ?>" data-vr-menu>
      <?php if (has_nav_menu('primary')) : ?>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '%3$s',
                'depth' => 2,
                'fallback_cb' => false,
                'walker' => new VR_Header_Nav_Walker(),
            )
        );
        ?>
      <?php else : ?>
        <a href="<?php echo esc_url(home_url('/o-nas/')); ?>">О нас</a>
        <a href="<?php echo esc_url(home_url('/uslugi/')); ?>">Услуги</a>
        <a href="<?php echo esc_url(home_url('/tseny/')); ?>">Цены</a>
        <a href="<?php echo esc_url(home_url('/kontakty/')); ?>">Контакты</a>
      <?php endif; ?>
      <a class="vr-nav__call" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone_main); ?></a>
    </nav>

    <div class="vr-header__actions">
      <a class="vr-header-button vr-header-button--call" href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone_main); ?></a>
    </div>
  </div>
</header>
