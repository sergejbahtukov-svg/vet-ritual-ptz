<?php
get_header();

$path = '';
if (! empty($_SERVER['REQUEST_URI'])) {
    $path = esc_html(wp_unslash($_SERVER['REQUEST_URI']));
}
?>

<main class="site-main">
  <section class="vr-page-hero vr-page-hero--error">
    <div class="vr-shell">
      <p class="vr-kicker">Ошибка 404</p>
      <h1><?php esc_html_e('Страница не найдена', 'vetritual-modern'); ?></h1>
      <p><?php esc_html_e('Запрошенный адрес не найден. Выберите другой раздел или вернитесь на главную.', 'vetritual-modern'); ?></p>
      <p><strong><?php echo wp_kses_post($path); ?></strong></p>
      <a class="vr-button" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Вернуться на главную', 'vetritual-modern'); ?></a>
    </div>
  </section>
</main>

<?php get_footer(); ?>

