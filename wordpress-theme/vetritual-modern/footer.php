<?php
if (! defined('ABSPATH')) {
    exit;
}

$site_name = vr_theme_setting('site_name', get_bloginfo('name'));
$site_city = vr_theme_setting('site_city', 'Петрозаводск и Карелия');
$phone = vr_theme_setting('phone_main', '+7 953 533-16-00');
$phone_href = preg_replace('/[^0-9+]/', '', $phone);
$address = vr_theme_setting('address_text', 'Республика Карелия, г. Петрозаводск, пр. Энергетиков, 33');
$footer_note = vr_theme_setting('footer_secondary_text', 'Внимательное сопровождение и поддержка в сложный момент');
$cookie_mode = vr_theme_setting('cookie_consent_mode', 'disabled');
$cookie_banner_text = vr_theme_setting('cookie_banner_text', '');
$cookie_accept = vr_theme_setting('cookie_button_accept', 'Хорошо');
$copyright = trim(vr_theme_setting('copyright_text', 'vet-ritual-ptz.ru © 2026'));
?>

<footer class="vr-footer">
  <div class="vr-shell vr-footer__grid">
    <div>
      <a class="vr-brand vr-brand--footer" href="<?php echo esc_url(home_url('/')); ?>">
        <span class="vr-brand__mark">
          <img src="<?php echo esc_url(vr_theme_media_url('logo-mark.svg')); ?>" alt="" loading="lazy">
        </span>
        <span>
          <strong><?php echo esc_html($site_name); ?></strong>
          <small><?php echo esc_html($site_city); ?></small>
        </span>
      </a>
      <p><?php echo esc_html($footer_note); ?></p>
      <p>Информация на сайте носит информационный характер и не является публичной офертой.</p>
    </div>
    <div>
      <h2>Меню</h2>
      <?php if (has_nav_menu('primary')) : ?>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '%3$s',
                'depth' => 1,
                'fallback_cb' => false,
            )
        );
        ?>
      <?php else : ?>
        <a href="<?php echo esc_url(home_url('/o-nas/')); ?>">О нас</a>
        <a href="<?php echo esc_url(home_url('/uslugi/')); ?>">Услуги</a>
        <a href="<?php echo esc_url(home_url('/tseny/')); ?>">Цены</a>
        <a href="<?php echo esc_url(home_url('/kontakty/')); ?>">Контакты</a>
      <?php endif; ?>
    </div>
    <div>
      <h2>Услуги</h2>
      <?php if (has_nav_menu('footer_services')) : ?>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer_services',
                'container' => false,
                'items_wrap' => '%3$s',
                'depth' => 1,
                'fallback_cb' => false,
            )
        );
        ?>
      <?php else : ?>
        <a href="<?php echo esc_url(home_url('/usyplenie-zhivotnyh/')); ?>">Усыпление животных</a>
        <a href="<?php echo esc_url(home_url('/krematsyja-zhyvotnyh/')); ?>">Кремация животных</a>
        <a href="<?php echo esc_url(home_url('/vyvoz-zhivotnyh/')); ?>">Вывоз животных</a>
      <?php endif; ?>
    </div>
    <div>
      <h2>Контакты</h2>
      <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
      <span><?php echo esc_html($address); ?></span>
    </div>
  </div>
  <div class="vr-shell vr-footer__bottom"><?php echo esc_html($copyright); ?></div>
</footer>

<?php if ($cookie_mode !== 'disabled' && ! empty($cookie_banner_text)) : ?>
  <div class="vr-cookie-banner" data-vr-cookie-banner hidden>
    <div class="vr-cookie-banner__body">
      <p><strong>Мы используем cookie</strong></p>
      <p><?php echo wp_kses_post($cookie_banner_text); ?></p>
    </div>
    <button class="vr-cookie-banner__button" type="button" data-vr-cookie-accept><?php echo esc_html($cookie_accept); ?></button>
  </div>
<?php endif; ?>

<?php echo wp_kses_post(vr_theme_setting('body_end_html', '')); ?>
<?php wp_footer(); ?>
</body>
</html>
