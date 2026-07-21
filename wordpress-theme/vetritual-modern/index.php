<?php
get_header();
?>

<main id="primary" class="site-main">
  <section class="vr-section">
    <div class="vr-shell vr-text-page">
      <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <article <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </article>
        <?php endwhile; ?>
      <?php else : ?>
        <h1><?php esc_html_e('Материалы не найдены', 'vetritual-modern'); ?></h1>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
