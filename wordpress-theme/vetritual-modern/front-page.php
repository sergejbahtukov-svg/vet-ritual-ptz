<?php get_header(); ?>

<main id="primary" class="site-main">
  <?php
  $route = vr_get_route_info('home');
  $vr_hero_route = $route;
  $vr_is_front_page = true;
  require get_template_directory() . '/template-parts/content-hero.php';
  $vr_hero_route = null;
  $vr_is_front_page = null;
  ?>

  <section class="vr-section" id="services">
    <div class="vr-shell">
      <div class="vr-section__head">
        <p class="vr-kicker"><?php echo esc_html(vr_theme_setting('services_intro_title')); ?></p>
        <h2><?php echo esc_html(vr_theme_setting('services_intro_text')); ?></h2>
      </div>
      <?php get_template_part('template-parts/content-services'); ?>
    </div>
  </section>

  <?php get_template_part('template-parts/content-about'); ?>
  <?php get_template_part('template-parts/content-prices'); ?>
  <?php get_template_part('template-parts/content-process'); ?>
  <?php get_template_part('template-parts/content-contact'); ?>
  <?php get_template_part('template-parts/content-reviews'); ?>

</main>

<?php get_footer(); ?>
