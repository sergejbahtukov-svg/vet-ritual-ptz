<?php
/** Template Name: Правовой документ */
get_header();
?>
<main id="primary" class="site-main">
  <?php while (have_posts()) : the_post(); ?>
    <article class="vr-section vr-legal-page">
      <div class="vr-shell vr-text-page">
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</main>
<?php get_footer(); ?>
