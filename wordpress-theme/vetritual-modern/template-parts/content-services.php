<?php
if (! defined('ABSPATH')) {
    exit;
}

$services = function_exists('vr_get_service_cards') ? vr_get_service_cards() : array();
$services = array_values(array_filter($services, 'is_array'));
if (empty($services)) {
    return;
}
?>

<section class="vr-section" id="services">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker">Наши услуги</p>
      <h2>Помогаем взять на себя сложные организационные шаги</h2>
    </div>
    <div class="vr-services-slider" data-vr-services-slider>
      <div class="vr-services" data-vr-services-track>
        <?php foreach ($services as $service) : ?>
          <?php
          $service_link = isset($service['link']) ? (string) $service['link'] : '/' . trim((string) ($service['slug'] ?? ''), '/') . '/';
          if ($service_link === '//') {
              $service_link = '#';
          }
          $service_href = preg_match('~^(https?:|tel:|mailto:|#)~', $service_link) ? $service_link : home_url('/' . trim($service_link, '/') . '/');
          $service_image = isset($service['icon']) ? (string) $service['icon'] : (string) ($service['image'] ?? '');
          $service_image_src = ! empty($service['image_src']) ? (string) $service['image_src'] : '';
          $service_media = isset($service['media']) ? (string) $service['media'] : '';
          $service_image_url = $service_image_src !== '' ? $service_image_src : ($service_image !== '' ? vr_theme_media_url($service_image) : '');
          $service_title = isset($service['title']) ? (string) $service['title'] : '';
          ?>
          <a class="vr-service-card" href="<?php echo esc_url($service_href); ?>">
            <div class="vr-service-media <?php echo esc_attr($service_media); ?>">
              <?php if ($service_image_url !== '') : ?>
                <img src="<?php echo esc_url($service_image_url); ?>" alt="<?php echo esc_attr($service_title); ?>" loading="lazy">
              <?php endif; ?>
            </div>
            <h3><?php echo esc_html($service_title); ?></h3>
            <p><?php echo esc_html($service['text'] ?? ''); ?></p>
            <span class="vr-service-card__more">Подробнее</span>
          </a>
        <?php endforeach; ?>
      </div>
      <div class="vr-services-slider__controls">
        <button class="vr-slider-button" type="button" aria-label="Предыдущие услуги" data-vr-services-prev>‹</button>
        <button class="vr-slider-button" type="button" aria-label="Следующие услуги" data-vr-services-next>›</button>
      </div>
    </div>
  </div>
</section>
