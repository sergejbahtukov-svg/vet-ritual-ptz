<?php
if (! defined('ABSPATH')) {
    exit;
}

$intro_title = vr_theme_setting('about_intro_title', '');
$intro_text = vr_theme_setting('about_intro_text', '');
$raw_features = (string) vr_theme_setting('about_features_json', '[]');
$features = json_decode($raw_features, true);
if (! is_array($features)) {
    $features = array();
}
?>

<section class="vr-section" id="about">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker"><?php echo esc_html($intro_title); ?></p>
      <h2><?php echo esc_html(vr_theme_setting('about_intro_title', '')); ?></h2>
    </div>

    <div class="vr-about__copy">
      <p><?php echo esc_html($intro_text); ?></p>
    </div>

    <div class="vr-feature-grid">
      <?php foreach ($features as $feature) : ?>
        <?php if (! is_array($feature)) { continue; } ?>
        <article class="vr-feature-card">
          <h3><?php echo esc_html(isset($feature['title']) ? (string) $feature['title'] : ''); ?></h3>
          <?php if (! empty($feature['text'])) : ?>
            <p><?php echo esc_html((string) $feature['text']); ?></p>
          <?php endif; ?>
          <?php if (! empty($feature['items']) && is_array($feature['items'])) : ?>
            <ul>
              <?php foreach ($feature['items'] as $item) : ?>
                <li><?php echo esc_html((string) $item); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

