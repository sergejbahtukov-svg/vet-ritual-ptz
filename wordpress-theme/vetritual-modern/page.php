<?php
get_header();
?>

<main id="primary" class="site-main">
  <?php if (have_posts()) : ?>
    <?php
    the_post();
    $slug = get_post_field('post_name', get_the_ID());
    ?>
    <?php get_template_part('template-parts/content-hero'); ?>

    <?php if ($slug === 'o-nas') : ?>
      <?php get_template_part('template-parts/content-about'); ?>
    <?php elseif ($slug === 'uslugi') : ?>
      <?php if (trim((string) get_the_content(null, false, get_the_ID())) !== '') : ?>
        <section class="vr-section">
          <div class="vr-shell vr-text-page">
            <?php get_template_part('template-parts/content-page', null, array('content' => apply_filters('the_content', get_the_content(null, false, get_the_ID())))); ?>
          </div>
        </section>
      <?php endif; ?>
      <?php get_template_part('template-parts/content-services'); ?>
    <?php elseif ($slug === 'tseny') : ?>
      <?php if (trim((string) get_the_content(null, false, get_the_ID())) !== '') : ?>
        <section class="vr-section">
          <div class="vr-shell vr-text-page">
            <?php get_template_part('template-parts/content-page', null, array('content' => apply_filters('the_content', get_the_content(null, false, get_the_ID())))); ?>
          </div>
        </section>
      <?php endif; ?>
      <?php get_template_part('template-parts/content-prices'); ?>
    <?php elseif ($slug === 'kontakty') : ?>
      <?php get_template_part('template-parts/content-contact'); ?>
      <?php get_template_part('template-parts/content-contact-features'); ?>
    <?php elseif (in_array($slug, array('usyplenie-zhivotnyh', 'usyplenie-koshek', 'usyplenie-sobak', 'krematsyja-zhyvotnyh', 'obschaja-krematsyja', 'individualnaja-krematsyja', 'vyvoz-zhivotnyh'), true)) : ?>
      <?php if (trim((string) get_the_content(null, false, get_the_ID())) !== '') : ?>
        <section class="vr-section">
          <div class="vr-shell vr-text-page">
            <?php get_template_part('template-parts/content-page', null, array('content' => apply_filters('the_content', get_the_content(null, false, get_the_ID())))); ?>
          </div>
        </section>
      <?php endif; ?>
      <?php get_template_part('template-parts/content-process'); ?>
      <?php get_template_part('template-parts/content-contact'); ?>
    <?php elseif (trim((string) get_the_content(null, false, get_the_ID())) !== '') : ?>
      <section class="vr-section">
        <div class="vr-shell vr-text-page">
          <?php get_template_part('template-parts/content-page', null, array('content' => apply_filters('the_content', get_the_content(null, false, get_the_ID())))); ?>
        </div>
      </section>
    <?php endif; ?>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
