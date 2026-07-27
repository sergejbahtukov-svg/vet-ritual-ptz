<?php
if (! defined('ABSPATH')) {
    exit;
}

$about_page = get_page_by_path('o-nas');
$about_features = function_exists('vr_get_feature_cards') ? vr_get_feature_cards('about') : array();
if (! $about_page instanceof WP_Post && empty($about_features)) {
    return;
}

$about_page_content = $about_page instanceof WP_Post && ! empty($about_page->post_content) ? apply_filters('the_content', $about_page->post_content) : '';
$about_kicker = vr_get_home_section_value('about', 'kicker', 'О крематории');
$about_title = vr_get_home_section_value('about', 'title', $about_page instanceof WP_Post ? get_the_title($about_page) : '');
?>

<section class="vr-section" id="about">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker"><?php echo esc_html($about_kicker); ?></p>
      <h2><?php echo esc_html($about_title); ?></h2>
    </div>
    <div class="vr-feature-grid">
      <article>
        <?php if ($about_page_content !== '') : ?>
          <?php echo wp_kses_post($about_page_content); ?>
        <?php endif; ?>
      </article>
      <?php foreach ($about_features as $about_feature) : ?>
        <?php
        if (! is_array($about_feature)) {
            continue;
        }

        $feature_title = isset($about_feature['title']) ? (string) $about_feature['title'] : '';
        $feature_html = isset($about_feature['html']) ? (string) $about_feature['html'] : '';
        $feature_text = isset($about_feature['text']) ? (string) $about_feature['text'] : '';
        $feature_items = isset($about_feature['items']) && is_array($about_feature['items']) ? $about_feature['items'] : array();
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
  </div>
</section>
