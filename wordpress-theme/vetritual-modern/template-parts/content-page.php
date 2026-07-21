<?php
if (! defined('ABSPATH')) {
    exit;
}

$content = isset($args['content']) && is_string($args['content']) ? $args['content'] : '';
?>

<?php if (! empty($content)) : ?>
  <?php echo wp_kses_post($content); ?>
<?php else : ?>
  <p><?php esc_html_e('Контент этой страницы будет добавлен в ближайшее время.', 'vetritual-modern'); ?></p>
<?php endif; ?>
