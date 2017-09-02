<?php

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <section class="error-404 not-found">
      <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('That page can not be found.', '43d-records'); ?></h1>
      </header><!-- .page-header -->

      <div class="page-content">
        <p><?php esc_html_e('It looks like nothing was found at this location.', '43d-records'); ?></p>

      </div><!-- .page-content -->
    </section><!-- .error-404 -->

  </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
