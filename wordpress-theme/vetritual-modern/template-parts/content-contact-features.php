<?php
if (! defined('ABSPATH')) {
    exit;
}

$contact_features = function_exists('vr_get_feature_cards') ? vr_get_feature_cards('contact') : array();
if (empty($contact_features)) {
    return;
}
?>

<section class="vr-section">
  <div class="vr-shell vr-feature-grid">
    <?php foreach ($contact_features as $contact_feature) : ?>
      <?php
      if (! is_array($contact_feature)) {
          continue;
      }

      $feature_title = isset($contact_feature['title']) ? (string) $contact_feature['title'] : '';
      $feature_html = isset($contact_feature['html']) ? (string) $contact_feature['html'] : '';
      $feature_text = isset($contact_feature['text']) ? (string) $contact_feature['text'] : '';
      $feature_items = isset($contact_feature['items']) && is_array($contact_feature['items']) ? $contact_feature['items'] : array();
      ?>
      <article class="vr-feature-card">
        <?php if ($feature_title !== '') : ?>
          <h3><?php echo esc_html($feature_title); ?></h3>
        <?php endif; ?>
        <?php if ($feature_html !== '') : ?>
          <?php echo wp_kses_post($feature_html); ?>
        <?php elseif ($feature_text !== '') : ?>
          <p><?php echo esc_html($feature_text); ?></p>
        <?php endif; ?>
        <?php if (! empty($feature_items)) : ?>
          <ul>
            <?php foreach ($feature_items as $feature_item) : ?>
              <li><?php echo esc_html((string) $feature_item); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </article>
    <?php endforeach; ?>
  </div>
</section>
