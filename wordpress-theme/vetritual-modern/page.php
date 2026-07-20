<?php
get_header();
$route = vr_get_route_info();
$slug = $route['slug'];
$page_content = vr_get_route_page_content($slug);
$fallback_content = vr_get_route_fallback_content($slug);
?>

<main id="primary" class="site-main">
  <?php
  $vr_hero_route = $route;
  $vr_is_front_page = false;
  require get_template_directory() . '/template-parts/content-hero.php';
  $vr_hero_route = null;
  $vr_is_front_page = null;
  ?>

  <section class="vr-section">
    <div class="vr-shell vr-text-page">
      <?php
      if ($slug === 'o-nas') {
          get_template_part('template-parts/content-about');
          get_template_part('template-parts/content-contact');
      } elseif ($slug === 'uslugi') {
          get_template_part('template-parts/content-services');
          get_template_part('template-parts/content-page', null, array('title' => $route['title'], 'content' => $fallback_content));
      } elseif ($slug === 'tseny') {
          get_template_part('template-parts/content-prices');
          get_template_part('template-parts/content-page', null, array('title' => $route['title'], 'content' => $fallback_content));
      } elseif ($slug === 'kontakty') {
          get_template_part('template-parts/content-contact');
          get_template_part('template-parts/content-page', null, array('title' => $route['title'], 'content' => $fallback_content));
      } elseif (in_array($slug, array('usyplenie-zhivotnyh', 'usyplenie-koshek', 'usyplenie-sobak', 'krematsyja-zhyvotnyh', 'obschaja-krematsyja', 'individualnaja-krematsyja', 'vyvoz-zhivotnyh'), true)) {
          get_template_part('template-parts/content-page', null, array('title' => $route['title'], 'content' => $fallback_content));
          get_template_part('template-parts/content-process');
          get_template_part('template-parts/content-contact');
      } else {
          get_template_part('template-parts/content-page', null, array('title' => $route['title'], 'content' => $page_content ?: $fallback_content));
      }
      ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
