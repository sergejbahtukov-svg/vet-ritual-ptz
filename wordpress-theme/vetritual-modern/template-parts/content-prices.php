<?php
if (! defined('ABSPATH')) {
    exit;
}

$raw_prices = (string) vr_theme_setting('prices_cards_json', '[]');
$price_groups = json_decode($raw_prices, true);
if (! is_array($price_groups)) {
    $price_groups = array();
}
?>

<section class="vr-section" id="prices">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker">Цены</p>
      <h2><?php esc_html_e('Стоимость услуг', 'vetritual-modern'); ?></h2>
    </div>

    <?php if (empty($price_groups)) : ?>
      <p><?php esc_html_e('Пакеты цен скоро будут обновлены.', 'vetritual-modern'); ?></p>
    <?php else : ?>
      <div class="vr-prices-grid">
        <?php foreach ($price_groups as $group) : ?>
          <?php
          if (! is_array($group)) {
              continue;
          }
          $title = isset($group['title']) ? (string) $group['title'] : '';
          $note = isset($group['note']) ? (string) $group['note'] : '';
          $rows = isset($group['rows']) && is_array($group['rows']) ? $group['rows'] : array();
          ?>
          <article class="vr-price-card">
            <h3><?php echo esc_html($title); ?></h3>
            <?php if (! empty($note)) : ?>
              <p class="vr-price-card__note"><?php echo esc_html($note); ?></p>
            <?php endif; ?>
            <?php if (! empty($rows)) : ?>
              <ul class="vr-price-card__rows">
                <?php foreach ($rows as $row) : ?>
                  <?php
                  if (! is_array($row)) { continue; }
                  $label = isset($row['label']) ? (string) $row['label'] : '';
                  $value = isset($row['value']) ? (string) $row['value'] : '';
                  ?>
                  <li>
                    <span><?php echo esc_html($label); ?></span>
                    <strong><?php echo esc_html($value); ?></strong>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

