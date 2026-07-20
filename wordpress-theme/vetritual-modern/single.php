<?php
get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <main class="site-main vr-section">
          <div class="vr-shell">
            <article class="vr-post">
              <h1><?php the_title(); ?></h1>
              <div class="vr-entry-content"><?php the_content(); ?></div>
            </article>
          </div>
        </main>
        <?php
    }
}

get_footer();

