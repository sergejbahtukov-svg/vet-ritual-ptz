<?php get_header(); ?>

<main id="primary" class="site-main">
  <?php get_template_part('template-parts/content-hero', null, array('is_front_page' => true)); ?>

  <?php get_template_part('template-parts/content-services'); ?>

  <?php get_template_part('template-parts/content-about'); ?>
  <?php get_template_part('template-parts/content-prices'); ?>
  <?php get_template_part('template-parts/content-process'); ?>
  <?php get_template_part('template-parts/content-reviews'); ?>
  <?php get_template_part('template-parts/content-contact'); ?>
</main>

<?php get_footer(); ?>
