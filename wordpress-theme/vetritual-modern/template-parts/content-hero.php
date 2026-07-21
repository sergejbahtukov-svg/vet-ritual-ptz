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
    $hero_primary_cta_text = (string) vr_theme_setting('hero_primary_cta_text', 'Позвонить 24/7');
    $hero_primary_cta_url = (string) vr_theme_setting('hero_primary_cta_url', 'tel:' . $phone_href);
    $hero_secondary_cta_text = (string) vr_theme_setting('hero_secondary_cta_text', 'Посмотреть цены');
    $hero_secondary_cta_url = (string) vr_theme_setting('hero_secondary_cta_url', home_url('/tseny/'));
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
          <p class="vr-kicker">Петрозаводск и Карелия · 24/7</p>
          <h1><?php echo esc_html($hero_title); ?></h1>
          <p><?php echo esc_html($hero_subtitle); ?></p>
          <div class="vr-actions">
            <a class="vr-button" href="<?php echo esc_url($hero_primary_cta_url); ?>"><?php echo esc_html($hero_primary_cta_text); ?></a>
            <a class="vr-button vr-button--ghost" href="<?php echo esc_url($hero_secondary_cta_url); ?>"><?php echo esc_html($hero_secondary_cta_text); ?></a>
          </div>
          <div class="vr-hero__facts" aria-label="Ключевая информация">
            <span><strong>30-60 мин</strong> приезд специалиста</span>
            <span><strong>20 мин</strong> выполнение услуги</span>
            <span><strong>24/7</strong> принимаем обращения</span>
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
    <p class="vr-kicker">Круглосуточно в Петрозаводске</p>
    <h1><?php echo esc_html($hero_title); ?></h1>
    <?php if ($hero_lead !== '') : ?>
      <p><?php echo esc_html($hero_lead); ?></p>
    <?php endif; ?>
    <a class="vr-button" href="tel:<?php echo esc_attr($phone_href); ?>">Позвонить сейчас</a>
  </div>
</section>
