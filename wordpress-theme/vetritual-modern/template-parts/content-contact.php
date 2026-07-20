<?php
if (! defined('ABSPATH')) {
    exit;
}

$title = vr_theme_setting('contact_block_title', '');
$text = vr_theme_setting('contact_block_text', '');
$phone = vr_theme_setting('contact_block_phone', vr_theme_setting('phone_main', ''));
$email = vr_theme_setting('contact_block_email', vr_theme_setting('contact_email', ''));
$address = vr_theme_setting('contact_block_address', vr_theme_setting('address_text', ''));
?>

<section class="vr-section" id="contacts">
  <div class="vr-shell">
    <div class="vr-contact vr-contact__panel">
      <?php if (! empty($title)) : ?>
        <h2><?php echo esc_html($title); ?></h2>
      <?php endif; ?>
      <?php if (! empty($text)) : ?>
        <p><?php echo esc_html($text); ?></p>
      <?php endif; ?>
      <ul class="vr-contact__items">
        <?php if (! empty($phone)) : ?>
          <li><a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li>
        <?php endif; ?>
        <?php if (! empty($email)) : ?>
          <li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li>
        <?php endif; ?>
        <?php if (! empty($address)) : ?>
          <li><?php echo esc_html($address); ?></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</section>

