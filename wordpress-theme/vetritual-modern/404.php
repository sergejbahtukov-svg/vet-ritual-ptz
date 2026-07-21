<?php
status_header(404);
nocache_headers();
get_header();
?>

<main>
  <section class="vr-page-hero vr-page-hero--error">
    <div class="vr-shell">
      <p class="vr-kicker">Ошибка 404</p>
      <h1>Страница не найдена</h1>
      <p>Страница не найдена</p>
      <a class="vr-button" href="<?php echo esc_url(home_url('/')); ?>">Вернуться на главную</a>
    </div>
  </section>
</main>

<?php get_footer(); ?>
