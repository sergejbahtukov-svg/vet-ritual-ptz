<?php
if (! defined('ABSPATH')) {
    exit;
}

$reviews = function_exists('vr_get_reviews') ? vr_get_reviews() : array();
if (empty($reviews)) {
    return;
}
$reviews_kicker = vr_get_home_section_value('reviews', 'kicker', 'Клиенты говорят');
$reviews_title = vr_get_home_section_value('reviews', 'title', 'Отзывы о нашей работе');
?>

<section class="vr-section" id="reviews">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker"><?php echo esc_html($reviews_kicker); ?></p>
      <h2><?php echo esc_html($reviews_title); ?></h2>
    </div>
    <div class="vr-reviews">
      <?php foreach ($reviews as $review) : ?>
        <?php
        if (! is_array($review)) {
            continue;
        }

        $review_name = isset($review['name']) ? (string) $review['name'] : '';
        $review_subtitle = isset($review['subtitle']) ? (string) $review['subtitle'] : '';
        $review_text = isset($review['text']) ? (string) $review['text'] : '';
        ?>
        <article>
          <h3><?php echo esc_html($review_name); ?></h3>
          <span><?php echo esc_html($review_subtitle); ?></span>
          <p><?php echo esc_html($review_text); ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
