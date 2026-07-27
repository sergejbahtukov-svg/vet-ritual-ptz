<?php
if (! defined('ABSPATH')) {
    exit;
}

$is_front_page = ! empty($args['is_front_page']) || is_front_page();
$phone = vr_theme_setting('phone_main', '+7 953 533-16-00');
$phone_href = preg_replace('/[^0-9+]/', '', $phone);
$queried_object = get_queried_object();

if ($is_front_page) :
    $hero_title = 'Усыпление, кремация и вывоз животных с бережным сопровождением';
    $hero_subtitle = 'Работаем круглосуточно, выезжаем по Петрозаводску, Прионежскому району и дальним районам Карелии по согласованию.';
    $hero_kicker = vr_get_home_section_value('hero', 'kicker', 'Петрозаводск и Карелия · 24/7');
    $hero_primary_cta_text = vr_get_home_section_value('hero', 'cta', 'Позвонить 24/7');
    $hero_primary_cta_url = vr_get_home_section_value('hero', 'cta_url', 'tel:' . $phone_href);
    $hero_secondary_cta_text = vr_get_home_section_value('hero', 'secondary_cta', 'Посмотреть цены');
    $hero_secondary_cta_url = vr_get_home_section_value('hero', 'secondary_cta_url', home_url('/tseny/'));
    $hero_facts = vr_get_home_section_lines(
        'hero',
        array(
            '30–60 мин|приезд специалиста',
            '20 мин|выполнение услуги',
            '24/7|принимаем обращения',
        )
    );
    $hero_image_src = vr_theme_media_url('hero-pets-mobile.webp');

    if ($queried_object instanceof WP_Post) {
        $front_title = get_the_title($queried_object);
        $front_text = has_excerpt($queried_object) ? get_the_excerpt($queried_object) : vr_get_post_plain_text($queried_object);
        $front_image_src = get_the_post_thumbnail_url($queried_object, 'full');

        if ($front_title !== '') {
            $hero_title = $front_title;
        }
        if ($front_text !== '') {
            $hero_subtitle = $front_text;
        }
        if ($front_image_src) {
            $hero_image_src = $front_image_src;
        }
    }
    ?>
    <section class="vr-hero">
      <div class="vr-shell vr-hero__grid">
        <div class="vr-hero__content">
          <p class="vr-kicker"><?php echo esc_html($hero_kicker); ?></p>
          <h1><?php echo esc_html($hero_title); ?></h1>
          <p><?php echo esc_html($hero_subtitle); ?></p>
          <div class="vr-actions">
            <a class="vr-button" href="<?php echo esc_url($hero_primary_cta_url); ?>"><?php echo esc_html($hero_primary_cta_text); ?></a>
            <a class="vr-button vr-button--ghost" href="<?php echo esc_url($hero_secondary_cta_url); ?>"><?php echo esc_html($hero_secondary_cta_text); ?></a>
          </div>
          <div class="vr-hero__facts" aria-label="<?php echo esc_attr__('Ключевая информация', 'vetritual-modern'); ?>">
            <?php foreach ($hero_facts as $hero_fact) : ?>
              <?php $fact_parts = array_pad(explode('|', (string) $hero_fact, 2), 2, ''); ?>
              <span><strong><?php echo esc_html(trim($fact_parts[0])); ?></strong><?php echo esc_html(' ' . trim($fact_parts[1])); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="vr-hero__visual" aria-hidden="true">
          <img src="<?php echo esc_url($hero_image_src); ?>" alt="">
        </div>
      </div>
    </section>
    <?php
    return;
endif;

$slug = '';
$hero_title = '';
$hero_lead = '';

if ($queried_object instanceof WP_Post) {
    $slug = get_post_field('post_name', $queried_object);
    $hero_title = get_the_title($queried_object);
    if (has_excerpt($queried_object)) {
        $hero_lead = get_the_excerpt($queried_object);
    }
}

$page_hero_kicker = vr_get_home_section_value('page-hero', 'kicker', 'Круглосуточно в Петрозаводске');
$page_hero_cta_text = vr_get_home_section_value('page-hero', 'cta', 'Позвонить сейчас');
$page_hero_cta_url = vr_get_home_section_value('page-hero', 'cta_url', 'tel:' . $phone_href);

$hero_modifiers = array(
    'o-nas' => 'vr-page-hero--about',
    'uslugi' => 'vr-page-hero--services',
    'tseny' => 'vr-page-hero--prices',
    'kontakty' => 'vr-page-hero--contacts',
    'usyplenie-zhivotnyh' => 'vr-page-hero--euthanasia',
    'krematsyja-zhyvotnyh' => 'vr-page-hero--cremation',
    'vyvoz-zhivotnyh' => 'vr-page-hero--transport',
);
$hero_class = 'vr-page-hero';
if (isset($hero_modifiers[$slug])) {
    $hero_class .= ' ' . $hero_modifiers[$slug];
}
?>

<section class="<?php echo esc_attr($hero_class); ?>">
  <div class="vr-shell">
    <p class="vr-kicker"><?php echo esc_html($page_hero_kicker); ?></p>
    <h1><?php echo esc_html($hero_title); ?></h1>
    <?php if ($hero_lead !== '') : ?>
      <p><?php echo esc_html($hero_lead); ?></p>
    <?php endif; ?>
    <a class="vr-button" href="<?php echo esc_url($page_hero_cta_url); ?>"><?php echo esc_html($page_hero_cta_text); ?></a>
  </div>
</section>
