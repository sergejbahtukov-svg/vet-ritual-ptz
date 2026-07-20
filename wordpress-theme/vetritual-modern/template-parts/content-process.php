<?php
if (! defined('ABSPATH')) {
    exit;
}

$raw_steps = (string) vr_theme_setting('process_steps_json', '[]');
$steps = json_decode($raw_steps, true);
if (! is_array($steps)) {
    $steps = array();
}
?>

<section class="vr-section" id="process">
  <div class="vr-shell">
    <div class="vr-section__head">
      <p class="vr-kicker"><?php esc_html_e('Как мы работаем', 'vetritual-modern'); ?></p>
      <h2><?php esc_html_e('Этапы помощи', 'vetritual-modern'); ?></h2>
    </div>

    <?php if (empty($steps)) : ?>
      <p><?php esc_html_e('Этапы процесса пока не заданы.', 'vetritual-modern'); ?></p>
    <?php else : ?>
      <ol class="vr-process-list">
        <?php foreach ($steps as $index => $step) : ?>
          <?php
          if (! is_array($step)) {
            continue;
          }
          $title = isset($step['title']) ? (string) $step['title'] : '';
          $description = isset($step['description']) ? (string) $step['description'] : '';
          ?>
          <li>
            <span><?php echo esc_html((string) ($index + 1)); ?></span>
            <h3><?php echo esc_html($title); ?></h3>
            <?php if (! empty($description)) : ?>
              <p><?php echo esc_html($description); ?></p>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>
  </div>
</section>

