<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  $route = vr_get_route_info();
  $is_404 = is_404() || $route['slug'] === '404';
  $title = $route['title'];
  $description = $route['description'];
  $canonical = $route['route_path'];
  $domain = trailingslashit(esc_url_raw(vr_theme_setting('public_domain_url', home_url('/'))));
  $og_image = vr_theme_media_url(vr_theme_setting('og_image', 'og-logo-share.png'));
  $site_name = vr_theme_setting('site_name', get_bloginfo('name'));
  ?>

  <title><?php echo esc_html($title); ?></title>
  <meta name="description" content="<?php echo esc_attr($description); ?>">
  <?php if (! $is_404) : ?>
    <link rel="canonical" href="<?php echo esc_url($canonical); ?>">
  <?php endif; ?>

  <meta property="og:type" content="website">
  <meta property="og:locale" content="ru_RU">
  <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
  <meta property="og:title" content="<?php echo esc_attr($title); ?>">
  <meta property="og:description" content="<?php echo esc_attr($description); ?>">
  <meta property="og:url" content="<?php echo esc_url($canonical); ?>">
  <meta property="og:image" content="<?php echo esc_url($og_image); ?>">

  <meta name="twitter:card" content="<?php echo esc_attr(vr_theme_setting('twitter_card_type', 'summary_large_image')); ?>">
  <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
  <meta name="twitter:description" content="<?php echo esc_attr($description); ?>">
  <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">

  <meta name="theme-color" content="<?php echo esc_attr(vr_theme_setting('theme_color', '#fffdf8')); ?>">
  <meta name="msapplication-TileColor" content="<?php echo esc_attr(vr_theme_setting('theme_color', '#fffdf8')); ?>">

  <meta name="geo.placename" content="Петрозаводск">
  <meta name="geo.region" content="RU-KR">

  <?php if (! $is_404) : ?>
    <script type="application/ld+json">
      {
        "@context":"https://schema.org",
        "@type":"LocalBusiness",
        "@id":"<?php echo esc_js(rtrim($domain, '/')); ?>/#organization",
        "name":"<?php echo esc_js($site_name); ?>",
        "url":"<?php echo esc_js($domain); ?>",
        "telephone":"<?php echo esc_js(vr_theme_setting('phone_main', '')); ?>",
        "address":{"@type":"PostalAddress","streetAddress":"<?php echo esc_js(vr_theme_setting('address_text', '')); ?>","addressLocality":"Петрозаводск","addressRegion":"Республика Карелия","addressCountry":"RU"}
      }
    </script>
  <?php endif; ?>

  <?php if (! $is_404) : ?>
    <script type="application/ld+json">
      {
        "@context":"https://schema.org",
        "@type":"WebPage",
        "@id":"<?php echo esc_js($canonical); ?>#webpage",
        "url":"<?php echo esc_js($canonical); ?>",
        "name":"<?php echo esc_js($title); ?>",
        "description":"<?php echo esc_js($description); ?>",
        "inLanguage":"ru-RU"
      }
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

  <?php
  if ($canonical !== home_url('/')) {
    wp_enqueue_style('vetritual-theme-style');
  }
  wp_head();
  ?>

  <?php echo wp_kses_post(vr_theme_setting('custom_head_html', '')); ?>

  <?php
  $favicons = array(
    'icon' => 'favicon.ico',
    'icon_alt' => 'favicon.svg',
    'png32' => 'favicon-32x32.png',
    'png16' => 'favicon-16x16.png',
  );
  foreach ($favicons as $rel => $file) :
    if (! $file) {
        continue;
    }
    ?>
    <link rel="<?php echo esc_attr($rel); ?>" href="<?php echo esc_url(vr_theme_media_url($file)); ?>" <?php if ($rel === 'png32' || $rel === 'png16') { echo 'sizes="' . esc_attr($rel === 'png32' ? '32x32' : '16x16') . '" type="image/png"'; } ?> >
    <?php
  endforeach;
  ?>
</head>
<body <?php body_class('vr-site'); ?>>
<?php wp_body_open(); ?>

<?php echo wp_kses_post(vr_theme_setting('body_start_html', '')); ?>

<header class="vr-header" data-vr-header>
  <div class="vr-shell vr-header__inner">
    <a class="vr-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <span class="vr-brand__mark">
        <img src="<?php echo esc_url(vr_theme_media_url('logo-mark.svg')); ?>" alt="<?php echo esc_attr($site_name); ?>" loading="eager">
      </span>
      <span>
        <strong><?php echo esc_html($site_name); ?></strong>
        <small><?php echo esc_html(vr_theme_setting('site_city', '')); ?></small>
      </span>
    </a>

    <button class="vr-menu-toggle" type="button" aria-label="<?php esc_attr_e('Открыть меню', 'vetritual-modern'); ?>" aria-expanded="false" data-vr-menu-toggle>
      <span></span><span></span><span></span>
    </button>

    <nav class="vr-nav" aria-label="<?php esc_attr_e('Основная навигация', 'vetritual-modern'); ?>" data-vr-menu>
      <a href="<?php echo esc_url(home_url('/o-nas/')); ?>">О нас</a>
      <span class="vr-nav__item">
        <a href="<?php echo esc_url(home_url('/uslugi/')); ?>"><?php esc_html_e('Услуги', 'vetritual-modern'); ?></a>
        <span class="vr-nav__dropdown">
          <a href="<?php echo esc_url(home_url('/usyplenie-zhivotnyh/')); ?>"><?php esc_html_e('Усыпление животных', 'vetritual-modern'); ?></a>
          <a href="<?php echo esc_url(home_url('/usyplenie-koshek/')); ?>"><?php esc_html_e('Усыпление кошек', 'vetritual-modern'); ?></a>
          <a href="<?php echo esc_url(home_url('/usyplenie-sobak/')); ?>"><?php esc_html_e('Усыпление собак', 'vetritual-modern'); ?></a>
          <a href="<?php echo esc_url(home_url('/krematsyja-zhyvotnyh/')); ?>"><?php esc_html_e('Кремация животных', 'vetritual-modern'); ?></a>
          <a href="<?php echo esc_url(home_url('/obschaja-krematsyja/')); ?>"><?php esc_html_e('Общая кремация', 'vetritual-modern'); ?></a>
          <a href="<?php echo esc_url(home_url('/individualnaja-krematsyja/')); ?>"><?php esc_html_e('Индивидуальная кремация', 'vetritual-modern'); ?></a>
          <a href="<?php echo esc_url(home_url('/vyvoz-zhivotnyh/')); ?>"><?php esc_html_e('Вывоз животных', 'vetritual-modern'); ?></a>
        </span>
      </span>
      <a href="<?php echo esc_url(home_url('/tseny/')); ?>"><?php esc_html_e('Цены', 'vetritual-modern'); ?></a>
      <a href="<?php echo esc_url(home_url('/kontakty/')); ?>"><?php esc_html_e('Контакты', 'vetritual-modern'); ?></a>
      <a class="vr-nav__call" href="tel:<?php echo esc_attr(vr_theme_setting('phone_main', '')); ?>"><?php echo esc_html(vr_theme_setting('phone_main', '')); ?></a>
    </nav>

    <div class="vr-header__actions">
      <a class="vr-header-button vr-header-button--call" href="tel:<?php echo esc_attr(vr_theme_setting('phone_main', '')); ?>"><?php echo esc_html(vr_theme_setting('phone_main', '')); ?></a>
    </div>
  </div>
</header>

