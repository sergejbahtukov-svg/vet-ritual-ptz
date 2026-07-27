<?php
if (! defined('ABSPATH')) {
    exit;
}

$contact_page = get_page_by_path('kontakty');
$title = vr_get_home_section_value('contact', 'kicker', 'Контакты');
$headline = vr_get_home_section_value('contact', 'title', 'Позвоните в любое время суток');
$text = vr_get_home_section_value('contact', 'content', 'Вы можете уточнить детали услуги или выбрать урну. Мы отвечаем быстро и уважительно.');
$cta_label = vr_get_home_section_value('contact', 'cta', 'Получить консультацию');

if ($contact_page instanceof WP_Post) {
    $title = vr_get_home_section_value('contact', 'kicker', get_the_title($contact_page));
}

$phone = vr_theme_setting('phone_main', '+7 953 533-16-00');
$email = vr_theme_setting('contact_email', '');
$address = vr_theme_setting('address_text', 'Республика Карелия, г. Петрозаводск, пр. Энергетиков, 33');
$phone_href = preg_replace('/[^0-9+]/', '', $phone);
$contact_href = $phone_href !== '' ? 'tel:' . $phone_href : '';

if ($contact_href === '' && $email !== '') {
    $contact_href = 'mailto:' . antispambot($email);
}
?>

<section class="vr-section vr-section--contact">
  <div class="vr-shell vr-contact">
    <div>
      <p class="vr-kicker"><?php echo esc_html($title); ?></p>
      <h2><?php echo esc_html($headline); ?></h2>
      <p><?php echo esc_html($text); ?></p>
    </div>
    <div class="vr-contact__panel">
      <a class="vr-phone-large" href="<?php echo esc_url($contact_href); ?>"><?php echo esc_html($phone !== '' ? $phone : antispambot($email)); ?></a>
      <span><?php echo esc_html($address); ?></span>
      <a class="vr-button" href="<?php echo esc_url($contact_href); ?>"><?php echo esc_html($cta_label); ?></a>
    </div>
  </div>
</section>
