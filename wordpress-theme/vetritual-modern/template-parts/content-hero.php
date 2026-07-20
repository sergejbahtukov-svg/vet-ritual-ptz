<?php
if (! defined('ABSPATH')) {
    exit;
}

$route = isset($args['route']) && is_array($args['route']) ? $args['route'] : vr_get_route_info();
$slug = isset($route['slug']) ? (string)$route['slug'] : '';
$route_title = isset($route['title']) ? (string)$route['title'] : '';
$route_description = isset($route['description']) ? (string)$route['description'] : '';
$is_front_page = ! empty($args['is_front_page']);

$hero_title = $is_front_page
    ? vr_theme_setting('hero_title', $route_title)
    : ($route_title !== '' ? $route_title : vr_theme_setting('hero_title'));

$hero_subtitle = $is_front_page
    ? vr_theme_setting('hero_subtitle', '')
    : $route_description;
if ($hero_subtitle === '') {
    $hero_subtitle = vr_theme_setting('hero_subtitle', '');
}

$hero_image = vr_theme_setting('hero_image_id', '');
if ($hero_image === '') {
    $hero_image = vr_theme_setting('hero_image', '');
}
$hero_image_url = vr_theme_media_url($hero_image);

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
    'home' => 'vr-page-hero--home',
);
$hero_class = isset($hero_class_map[$slug]) ? $hero_class_map[$slug] : 'vr-page-hero--home';
?>

<section class="vr-page-hero <?php echo esc_attr($hero_class); ?>">
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
