<?php
if (! defined('ABSPATH')) {
    exit;
}

$phone = vr_theme_setting('contact_block_phone', vr_theme_setting('phone_main', ''));
$email = vr_theme_setting('contact_block_email', vr_theme_setting('contact_email', ''));
$address = vr_theme_setting('contact_block_address', vr_theme_setting('address_text', ''));
$cookie_banner_text = vr_theme_setting('cookie_banner_text', '');
$cookie_accept = vr_theme_setting('cookie_button_accept', __('Принять', 'vetritual-modern'));
$cookie_reject = vr_theme_setting('cookie_button_reject', '');
$copyright = vr_theme_setting('copyright_text', get_bloginfo('name'));
?>

<footer class="vr-footer">
  <div class="vr-shell">
    <div class="vr-footer__grid">
      <section class="vr-footer__block">
        <h2><?php esc_html_e('Контакты', 'vetritual-modern'); ?></h2>
        <p><?php echo esc_html($address); ?></p>
        <?php if (! empty($phone)) : ?>
          <p><a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></p>
        <?php endif; ?>
        <?php if (! empty($email)) : ?>
          <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
        <?php endif; ?>
      </section>

      <section class="vr-footer__block">
        <h2><?php esc_html_e('Быстрые ссылки', 'vetritual-modern'); ?></h2>
        <p><a href="<?php echo esc_url(home_url('/o-nas/')); ?>"><?php esc_html_e('О нас', 'vetritual-modern'); ?></a></p>
        <p><a href="<?php echo esc_url(home_url('/uslugi/')); ?>"><?php esc_html_e('Услуги', 'vetritual-modern'); ?></a></p>
        <p><a href="<?php echo esc_url(home_url('/tseny/')); ?>"><?php esc_html_e('Цены', 'vetritual-modern'); ?></a></p>
        <p><a href="<?php echo esc_url(home_url('/kontakty/')); ?>"><?php esc_html_e('Контакты', 'vetritual-modern'); ?></a></p>
      </section>
    </div>

    <div class="vr-footer__bottom">
      <p>&copy; <?php echo esc_html($copyright); ?></p>
    </div>
  </div>
</footer>

<?php if (! empty($cookie_banner_text)) : ?>
  <div class="vr-cookie-banner" data-vr-cookie-banner hidden>
    <div class="vr-shell vr-cookie-banner__inner">
      <p><?php echo wp_kses_post($cookie_banner_text); ?></p>
      <div class="vr-cookie-banner__actions">
        <button type="button" class="vr-button" data-vr-cookie-accept><?php echo esc_html($cookie_accept); ?></button>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php echo wp_kses_post(vr_theme_setting('body_end_html', '')); ?>
<?php wp_footer(); ?>
</body>
</html>

