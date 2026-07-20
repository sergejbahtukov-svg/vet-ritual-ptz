<?php
if (! defined('ABSPATH')) {
    exit;
}

$route = null;
if (isset($args) && isset($args['route']) && is_array($args['route'])) {
    $route = $args['route'];
} elseif (isset($vr_hero_route) && is_array($vr_hero_route)) {
    $route = $vr_hero_route;
} else {
    $route = vr_get_route_info();
}

$is_front_page = false;
if (! empty($vr_is_front_page) || (isset($args) && ! empty($args['is_front_page']))) {
    $is_front_page = true;
}

$slug = isset($route['slug']) ? (string) $route['slug'] : '';
$route_title = isset($route['title']) ? (string) $route['title'] : '';
$route_description = isset($route['description']) ? (string) $route['description'] : '';

$hero_title = $is_front_page
    ? vr_theme_setting('hero_title', $route_title)
    : ($route_title !== '' ? $route_title : vr_theme_setting('hero_title'));

$hero_subtitle = $is_front_page
    ? vr_theme_setting('hero_subtitle', '')
    : $route_description;
if ($hero_subtitle === '') {
    $hero_subtitle = vr_theme_setting('hero_subtitle', '');
}

$hero_image = '';
$hero_attachment_id = (int) vr_theme_setting('hero_image_id', 0);
if ($hero_attachment_id > 0) {
    $hero_image = wp_get_attachment_image_url($hero_attachment_id, 'large');
}
if (empty($hero_image)) {
    $hero_image = vr_theme_setting('hero_image', '');
}
if (empty($hero_image)) {
    $hero_image = vr_theme_setting('hero_image_id', '');
}
if (is_string($hero_image) && preg_match('#^https?://#', $hero_image)) {
    $hero_image_url = $hero_image;
} else {
    $hero_image_url = vr_theme_media_url($hero_image);
}

$hero_cta_primary = vr_theme_setting('hero_primary_cta_text', '');
$hero_cta_primary_url = vr_theme_setting('hero_primary_cta_url', '');
$hero_cta_secondary = vr_theme_setting('hero_secondary_cta_text', '');
$hero_cta_secondary_url = vr_theme_setting('hero_secondary_cta_url', '');
$hero_kicker = $is_front_page ? '' : vr_theme_setting('hero_title', '');

$hero_class_map = array(
    'o-nas' => 'vr-page-hero--about',
    'uslugi' => 'vr-page-hero--services',
    'tseny' => 'vr-page-hero--prices',
    'kontakty' => 'vr-page-hero--contacts',
    'usyplenie-zhivotnyh' => 'vr-page-hero--euthanasia',
    'usyplenie-koshek' => 'vr-page-hero--cats',
    'usyplenie-sobak' => 'vr-page-hero--dogs',
    'krematsyja-zhyvotnyh' => 'vr-page-hero--cremation',
    'obschaja-krematsyja' => 'vr-page-hero--common-cremation',
    'individualnaja-krematsyja' => 'vr-page-hero--individual-cremation',
    'vyvoz-zhivotnyh' => 'vr-page-hero--transport',
);

$route_hero_class = isset($route['hero_class']) && is_string($route['hero_class']) ? trim($route['hero_class']) : '';
if ($is_front_page) {
    $hero_class = $route_hero_class !== '' ? $route_hero_class : 'vr-hero';
} elseif ($route_hero_class !== '') {
    $hero_class = $route_hero_class;
} elseif (isset($hero_class_map[$slug])) {
    $hero_class = $hero_class_map[$slug];
} else {
    $hero_class = 'vr-page-hero';
}

if (! $is_front_page) {
    if (strpos($hero_class, 'vr-page-hero') !== 0 && strpos($hero_class, 'vr-page-hero ') !== 0) {
        $hero_class = 'vr-page-hero ' . $hero_class;
    }
}
?>

<section class="<?php echo esc_attr($hero_class); ?>">
  <div class="vr-shell">
    <div class="vr-page-hero__content">
      <?php if (! empty($hero_kicker)) : ?>
        <p class="vr-kicker"><?php echo esc_html($hero_kicker); ?></p>
      <?php endif; ?>
      <h1><?php echo esc_html($hero_title); ?></h1>
      <?php if (! empty($hero_subtitle)) : ?>
        <p class="vr-page-hero__intro"><?php echo esc_html($hero_subtitle); ?></p>
      <?php endif; ?>
      <div class="vr-page-hero__actions">
        <?php if (! empty($hero_cta_primary) && ! empty($hero_cta_primary_url)) : ?>
          <a class="vr-button" href="<?php echo esc_url($hero_cta_primary_url); ?>"><?php echo esc_html($hero_cta_primary); ?></a>
        <?php endif; ?>
        <?php if (! empty($hero_cta_secondary) && ! empty($hero_cta_secondary_url)) : ?>
          <a class="vr-button vr-button--ghost" href="<?php echo esc_url($hero_cta_secondary_url); ?>"><?php echo esc_html($hero_cta_secondary); ?></a>
        <?php endif; ?>
      </div>
    </div>
    <div class="vr-page-hero__media" aria-hidden="true">
      <?php if (! empty($hero_image_url)) : ?>
        <img src="<?php echo esc_url($hero_image_url); ?>" alt="<?php echo esc_attr($hero_title); ?>" loading="lazy">
      <?php endif; ?>
    </div>
  </div>
</section>
