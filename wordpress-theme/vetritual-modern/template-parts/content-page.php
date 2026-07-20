<?php
if (! defined('ABSPATH')) {
    exit;
}

$title = isset($args['title']) && is_string($args['title']) ? $args['title'] : '';
$content = isset($args['content']) && is_string($args['content']) ? $args['content'] : '';
?>

<article class="vr-text-page">
  <?php if (! empty($title)) : ?>
    <h2><?php echo esc_html($title); ?></h2>
  <?php endif; ?>
  <?php if (! empty($content)) : ?>
    <div class="vr-text-page__content">
      <?php echo wp_kses_post(wpautop($content)); ?>
    </div>
  <?php else : ?>
    <p><?php esc_html_e('Контент этой страницы будет добавлен в ближайшее время.', 'vetritual-modern'); ?></p>
  <?php endif; ?>
</article>

