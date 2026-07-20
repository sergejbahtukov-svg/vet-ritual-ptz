<?php
if (! defined('ABSPATH')) {
    exit;
}

$raw_reviews = (string) vr_theme_setting('reviews_json', '[]');
$reviews = json_decode($raw_reviews, true);
if (! is_array($reviews)) {
    $reviews = array();
}
?>

<section class="vr-section" id="reviews">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker"><?php esc_html_e('Отзывы', 'vetritual-modern'); ?></p>
      <h2><?php esc_html_e('Что говорят о нас', 'vetritual-modern'); ?></h2>
    </div>

    <?php if (empty($reviews)) : ?>
      <p><?php esc_html_e('Отзывы пока не добавлены.', 'vetritual-modern'); ?></p>
    <?php else : ?>
      <div class="vr-reviews">
        <?php foreach ($reviews as $review) : ?>
          <?php
          if (! is_array($review)) {
            continue;
          }
          $name = isset($review['name']) ? (string) $review['name'] : '';
          $subtitle = isset($review['subtitle']) ? (string) $review['subtitle'] : '';
          $text = isset($review['text']) ? (string) $review['text'] : '';
          ?>
          <article>
            <h3><?php echo esc_html($name); ?></h3>
            <?php if (! empty($subtitle)) : ?>
              <p class="vr-review-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
            <?php if (! empty($text)) : ?>
              <p><?php echo esc_html($text); ?></p>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

