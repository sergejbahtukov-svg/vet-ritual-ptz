<?php
if (! defined('ABSPATH')) {
    exit;
}

$raw_services = (string) vr_theme_setting('services_cards_json', '[]');
$services = json_decode($raw_services, true);
if (! is_array($services)) {
    $services = array();
}

$intro_title = vr_theme_setting('services_intro_title', '');
$intro_text = vr_theme_setting('services_intro_text', '');
?>

<section class="vr-services vr-section" id="services">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker"><?php echo esc_html($intro_title); ?></p>
      <h2><?php echo esc_html(vr_theme_setting('services_intro_text', '')); ?></h2>
      <p class="vr-section__intro"><?php echo esc_html($intro_text); ?></p>
    </div>

    <?php if (! empty($services)) : ?>
      <div class="vr-services-slider" data-vr-services-slider>
        <div class="vr-services-slider__buttons">
          <button type="button" class="vr-services-slider__button" data-vr-services-prev aria-label="<?php esc_attr_e('Назад', 'vetritual-modern'); ?>">◀</button>
          <button type="button" class="vr-services-slider__button" data-vr-services-next aria-label="<?php esc_attr_e('Вперед', 'vetritual-modern'); ?>">▶</button>
        </div>
        <div class="vr-services-slider__track" data-vr-services-track>
          <?php foreach ($services as $service) : ?>
            <?php
            if (! is_array($service)) {
                continue;
            }
            $title = isset($service['title']) ? (string)$service['title'] : '';
            $text = isset($service['text']) ? (string)$service['text'] : '';
            $link = isset($service['link']) ? (string)$service['link'] : '';
            $icon = isset($service['icon']) ? (string)$service['icon'] : '';
            ?>
            <article class="vr-service-card">
              <?php if ($icon !== '') : ?>
                <img
                  class="vr-service-card__icon"
                  src="<?php echo esc_url(vr_theme_media_url($icon)); ?>"
                  alt="<?php echo esc_attr($title); ?>"
                  loading="lazy">
              <?php endif; ?>
              <h3><?php echo esc_html($title); ?></h3>
              <p><?php echo esc_html($text); ?></p>
              <?php if (! empty($link)) : ?>
                <a href="<?php echo esc_url(home_url($link)); ?>"><?php esc_html_e('Узнать подробнее', 'vetritual-modern'); ?></a>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    <?php else : ?>
      <p><?php esc_html_e('Сейчас список услуг временно недоступен.', 'vetritual-modern'); ?></p>
    <?php endif; ?>
  </div>
</section>

