<?php
if (! defined('ABSPATH')) {
    exit;
}

$process_steps = function_exists('vr_get_process_steps') ? vr_get_process_steps() : array();
if (empty($process_steps)) {
    return;
}
$process_kicker = vr_get_home_section_value('process', 'kicker', 'Как проходит обращение');
$process_title = vr_get_home_section_value('process', 'title', 'Понятный порядок, когда сил разбираться почти нет');
?>

<section class="vr-section vr-section--image">
  <div class="vr-shell vr-process">
    <div>
      <p class="vr-kicker"><?php echo esc_html($process_kicker); ?></p>
      <h2><?php echo esc_html($process_title); ?></h2>
    </div>
    <ol>
      <?php foreach ($process_steps as $process_step) : ?>
        <?php
        if (! is_array($process_step)) {
            continue;
        }

        $step_title = isset($process_step['title']) ? (string) $process_step['title'] : '';
        $step_description = isset($process_step['description']) ? (string) $process_step['description'] : '';
        ?>
        <li><strong><?php echo esc_html($step_title); ?></strong><span><?php echo esc_html($step_description); ?></span></li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
