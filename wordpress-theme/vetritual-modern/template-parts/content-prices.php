<?php
if (! defined('ABSPATH')) {
    exit;
}

$price_cards = function_exists('vr_get_price_cards') ? vr_get_price_cards() : array();
$price_cards = array_values(array_filter($price_cards, 'is_array'));
if (empty($price_cards)) {
    return;
}
?>

<section class="vr-section" id="prices">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker">Цены</p>
      <h2>Стоимость зависит от услуги и веса животного</h2>
    </div>
    <div class="vr-price-grid">
      <?php foreach ($price_cards as $index => $price_card) : ?>
        <?php $price_card_class = ! empty($price_card['class']) ? ' ' . sanitize_html_class($price_card['class']) : ($index === 2 ? ' vr-price-card--accent' : ''); ?>
        <article class="vr-price-card<?php echo esc_attr($price_card_class); ?>">
          <h3><?php echo esc_html($price_card['title'] ?? ''); ?></h3>
          <?php if (! empty($price_card['note'])) : ?>
            <p class="vr-price-note"><?php echo esc_html($price_card['note']); ?></p>
          <?php endif; ?>
          <?php foreach (array_filter((array) ($price_card['rows'] ?? array()), 'is_array') as $price_row) : ?>
            <div class="vr-price-row"><span><?php echo esc_html($price_row['label'] ?? ''); ?></span><strong><?php echo esc_html($price_row['value'] ?? ''); ?></strong></div>
          <?php endforeach; ?>
        </article>
      <?php endforeach; ?>
    </div>
    <p class="vr-footnote">Вывоз рассчитывается в зависимости от района и сложности работ. Точную стоимость можно уточнить по телефону.</p>
  </div>
</section>
