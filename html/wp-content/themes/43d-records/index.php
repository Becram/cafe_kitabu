<?php

global $category_name, $tag;

$category_name = is_category() ? single_cat_title('', false) : '';
$tag = is_tag() ? single_tag_title('', false) : '';
$p43d_records_total_length_formatted = '';

while (have_posts()) :

  the_post();
  $p43d_records_custom = get_post_custom($post->ID);
  $p43d_records_esc_permalink = esc_url(get_permalink());

  if (!empty($p43d_records_custom)) {

    if (array_key_exists('HTTPS', $_SERVER) === false) {
      $_SERVER['HTTPS'] = 'off';
    }

    $p43d_records_spec_mp3 = false;
    $p43d_records_total_length = '-';
    $p43d_records_recorded_sound_id_mp3 = isset($p43d_records_custom['cf_43d_records_recorded_sound_id_mp3'][0])
      ? intval($p43d_records_custom['cf_43d_records_recorded_sound_id_mp3'][0])
      : -1;
    $p43d_records_recorded_sound_url_mp3 = isset($p43d_records_custom['cf_43d_records_recorded_sound_url_mp3'][0])
      ? $p43d_records_custom['cf_43d_records_recorded_sound_url_mp3'][0]
      : '';
    $p43d_records_recorded_sound_url_mp3 = ($_SERVER['HTTPS'] == 'on') ?
      str_replace('http://', 'https://', $p43d_records_recorded_sound_url_mp3)
      : str_replace('https://', 'http://', $p43d_records_recorded_sound_url_mp3);

    if ($p43d_records_recorded_sound_id_mp3 > 0) {
      $p43d_records_metas = wp_get_attachment_metadata($p43d_records_recorded_sound_id_mp3);
      $p43d_records_spec_mp3 = p43d_records_audio_meta_stringify($p43d_records_metas, true);
      $p43d_records_total_length = floatval($p43d_records_metas['length']);
      $p43d_records_total_length_formatted = $p43d_records_metas['length_formatted'];
    }

    $p43d_records_spec_ogg = false;
    $p43d_records_recorded_sound_id_ogg = isset($p43d_records_custom['cf_43d_records_recorded_sound_id_ogg'][0])
      ? intval($p43d_records_custom['cf_43d_records_recorded_sound_id_ogg'][0])
      : -1;
    $p43d_records_recorded_sound_url_ogg = isset($p43d_records_custom['cf_43d_records_recorded_sound_url_ogg'][0])
      ? $p43d_records_custom['cf_43d_records_recorded_sound_url_ogg'][0]
      : '';
    $p43d_records_recorded_sound_url_ogg = ($_SERVER['HTTPS'] == 'on') ?
      str_replace('http://', 'https://', $p43d_records_recorded_sound_url_ogg)
      : str_replace('https://', 'http://', $p43d_records_recorded_sound_url_ogg);

    if ($p43d_records_recorded_sound_id_ogg > 0) {
      $p43d_records_metas = wp_get_attachment_metadata($p43d_records_recorded_sound_id_ogg);
      $p43d_records_spec_ogg = p43d_records_audio_meta_stringify($p43d_records_metas, true);
      $p43d_records_total_length = floatval($p43d_records_metas['length']);
      $p43d_records_total_length_formatted = $p43d_records_metas['length_formatted'];
    }

    $p43d_records_cover_image_id = -1;
    if (has_post_thumbnail()) {
      $p43d_records_cover_image_id = get_post_thumbnail_id();
    } else if (isset($p43d_records_custom['cf_43d_records_cover_image_id'][0])) {
      $p43d_records_cover_image_id = $p43d_records_custom['cf_43d_records_cover_image_id'][0];
    }

    if ($p43d_records_cover_image_id > 0) {
      $p43d_records_cover_image_src_1440 = wp_get_attachment_image_src($p43d_records_cover_image_id, 'landscape_1440');
      $p43d_records_cover_image_src_2560 = wp_get_attachment_image_src($p43d_records_cover_image_id, 'landscape_2560');
      $p43d_records_cover_image_src_3200 = wp_get_attachment_image_src($p43d_records_cover_image_id, 'landscape_3200');
      $p43d_records_cover_image_src_4096 = wp_get_attachment_image_src($p43d_records_cover_image_id, 'landscape_4096');
      $p43d_records_cover_image_src_5120 = wp_get_attachment_image_src($p43d_records_cover_image_id, 'landscape_5120');
      $p43d_records_cover_image_src_full = wp_get_attachment_image_src($p43d_records_cover_image_id, 'full');
    }

    if (empty($p43d_records_cover_image_src_full)) {
      $p43d_records_cover_image_src_full = array(P43D_RECORDS_BASE_URL . '/img/default_logo.png');
    }
    if (empty($p43d_records_cover_image_src_1440)) {
      $p43d_records_cover_image_src_1440 = $p43d_records_cover_image_src_full;
    }
    if (empty($p43d_records_cover_image_src_2560)) {
      $p43d_records_cover_image_src_2560 = $p43d_records_cover_image_src_full;
    }
    if (empty($p43d_records_cover_image_src_3200)) {
      $p43d_records_cover_image_src_3200 = $p43d_records_cover_image_src_full;
    }
    if (empty($p43d_records_cover_image_src_4096)) {
      $p43d_records_cover_image_src_4096 = $p43d_records_cover_image_src_full;
    }
    if (empty($p43d_records_cover_image_src_5120)) {
      $p43d_records_cover_image_src_5120 = $p43d_records_cover_image_src_full;
    }

    $p43d_records_rec_date = isset($p43d_records_custom['cf_43d_records_rec_date'][0]) ? trim($p43d_records_custom['cf_43d_records_rec_date'][0]) : '';
    $p43d_records_rec_time = isset($p43d_records_custom['cf_43d_records_rec_time'][0]) ? trim($p43d_records_custom['cf_43d_records_rec_time'][0]) : '';

    $p43d_records_equips = isset($p43d_records_custom['cf_43d_records_equipments'][0]) ? trim($p43d_records_custom['cf_43d_records_equipments'][0]) : '';

    $p43d_records_latitude = isset($p43d_records_custom['cf_43d_records_latitude'][0]) && strlen(trim($p43d_records_custom['cf_43d_records_latitude'][0])) > 0
      ? floatval($p43d_records_custom['cf_43d_records_latitude'][0]) : '';
    $p43d_records_longitude = isset($p43d_records_custom['cf_43d_records_longitude'][0]) && strlen(trim($p43d_records_custom['cf_43d_records_longitude'][0])) > 0
      ? floatval($p43d_records_custom['cf_43d_records_longitude'][0]) : '';
  }

  get_header();
  ?>

  <ul id="main_menu">
    <li class="menulist" title="Menu">menu</li>
    <li class="infobox" title="Content">content</li>
    <li class="timeline" title="Timeline">timeline</li>
  </ul>

  <ul id="ctrl_btns">
    <li class="play">
      <img class="default" src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_play.svg"
           alt="play button"/>
      <img class="over"
           src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_play_over.svg"
           alt="play button"/>
    </li>
    <li class="pause hidden">
      <img class="default"
           src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_pause.svg"
           alt="pause button"/>
      <img class="over"
           src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_pause_over.svg"
           alt="pause button"/>
    </li>
  </ul>

  <p id="bg"><!--// <?php the_post_thumbnail(); ?> //--></p>

  <div id="info_content">

    <p class="close_btn"><img src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_close.svg"
                              alt="close button"/></p>

    <div class="outer_container">
      <div class="bg"></div>

      <div <?php post_class("inner_container"); ?>>
        <h1><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>

        <?php the_title('<h2 class="entry-title">', '</h2>'); ?>

        <p class="posted_on info"><span
            class="label"><?php esc_html_e('Posted On', '43d-records'); ?></span><?php echo date('F j, Y H:i', strtotime($post->post_date)); ?>
        </p>
        <?php if (strlen($p43d_records_rec_date) > 0) : ?>
          <p class="recorded_on info"><span
              class="label"><?php esc_html_e('Recorded On', '43d-records'); ?></span><?php echo esc_html($p43d_records_rec_date . ' ' . $p43d_records_rec_time); ?>
          </p>
        <?php endif; ?>

        <?php if (strlen($p43d_records_latitude) > 0 && strlen($p43d_records_longitude) > 0) :
          $geo_str = p43d_records_geo_stringify($p43d_records_latitude, $p43d_records_longitude);
          $maplink = 'https://maps.google.com/maps?z=12&amp;t=e'
            . '&amp;ll=' . $p43d_records_latitude . ',' . $p43d_records_longitude
            . '&amp;q=' . $p43d_records_latitude . ',' . $p43d_records_longitude;
          ?>
          <p class="geo info"><span
              class="label"><?php esc_html_e('Location', '43d-records'); ?></span><?php echo esc_html($geo_str); ?>
            <a href="<?php echo esc_url($maplink); ?>" target="_blank" class="icon_link"><img class="geo_icon"
                                                                                              src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_geo.svg"
                                                                                              alt="Google Maps"/></a>
          </p>
        <?php endif; ?>

        <?php if ($p43d_records_spec_mp3 !== false) : ?>
          <dl class="specs mp3 hidden">
            <dt><?php esc_html_e('SPECS', '43d-records'); ?></dt>
            <dd>
              <ul><?php foreach ($p43d_records_spec_mp3 as $spec): ?>
                  <li><?php echo esc_html($spec); ?></li><?php endforeach; ?></ul>
            </dd>
          </dl>
        <?php endif; ?>
        <?php if ($p43d_records_spec_ogg !== false) : ?>
          <dl class="specs ogg hidden">
            <dt><?php esc_html_e('SPECS', '43d-records'); ?></dt>
            <dd>
              <ul><?php foreach ($p43d_records_spec_ogg as $spec): ?>
                  <li><?php echo esc_html($spec); ?></li><?php endforeach; ?></ul>
            </dd>
          </dl>
        <?php endif; ?>

        <?php if (strlen($p43d_records_equips) > 0) : ?>
          <p class="equipments info"><span
              class="label"><?php esc_html_e('Equipments', '43d-records'); ?></span><?php echo esc_html($p43d_records_equips); ?>
          </p>
          <?php
        endif;

        $p43d_records_categ = get_the_category_list(', ', 'multiple', $post->ID);
        if (strlen($p43d_records_categ) > 0) : ?>
          <p class="tags info"><span
              class="label"><?php esc_html_e('Categories', '43d-records'); ?></span><?php echo wp_kses_post($p43d_records_categ); ?>
          </p>
          <?php
        endif;

        $p43d_records_tags = wp_get_post_tags($post->ID);
        if (count($p43d_records_tags) > 0) : ?>
          <p class="tags info"><span
              class="label"><?php esc_html_e('Tags', '43d-records'); ?></span><?php the_tags(''); ?></p>
          <?php
        endif;
        ?>

        <div class="content">
          <?php
          the_content();
          ?>

          <?php
          wp_link_pages(array(
            'before' => '<p class="page-links"><span class="page-links-title">' . __('Pages:', '43d-records') . '</span>',
            'after' => '</p>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page', '43d-records') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
          ));

          ?>
          <div class="post_link_container">
            <?php
            previous_post_link('<p class="post_link">%link</p>', __('<span>&laquo; Previous Entry</span> &ldquo;%title&rdquo;', '43d-records'), false);
            next_post_link('<p class="post_link">%link</p>', __('<span>&raquo; Next Entry</span> &ldquo;%title&rdquo;', '43d-records'), false);
            ?>
          </div>

          <?php
          if (comments_open() || get_comments_number()) {
            comments_template();
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <?php break; endwhile; ?>

  <div id="menulist">
    <p class="close_btn"><img src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_close.svg"
                              alt="close button"/></p>

    <div class="outer_container">
      <div class="bg"></div>

      <div class="inner_container">
        <h1><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
        <?php
        $p43d_records_desc = get_bloginfo('description', 'display');
        if (strlen($p43d_records_desc) > 0) :
          ?>
          <p class="description"><?php echo $p43d_records_desc; ?></p>
        <?php endif; ?>

        <h3><?php esc_html_e('Recordings List', '43d-records'); ?><?php
          if (is_archive()) {
            echo ' (';
            the_archive_title();
            echo ')';
          }
          ?></h3>
        <ul id="posts_list">
          <?php
          wp_reset_postdata();

          list($numposts, $page, $per_page, $list_html) = post_list(0, P43D_RECORDS_LIST_NUM, false, $category_name, $tag);
          echo $list_html;

          $last_page = ceil($numposts / $per_page) - 1;
          $prev_page = $page - 1;
          $next_page = $page + 1;
          ?>
        </ul>
        <p id="posts_list_navi" class="clearfix<?php if ($last_page == 0) {
          echo ' hidden';
        } ?>" data-page="<?php echo $page; ?>" data-last="<?php echo $last_page ?>">
          <a href="<?php echo esc_url(admin_url('admin-ajax.php')); ?>?page=<?php if ($prev_page >= 0) {
            echo esc_url($prev_page);
          } ?>" class="recent<?php if ($page <= 0) {
            echo ' hidden';
          } ?>"><?php printf(__("&laquo; recent %d records", '43d-records'), $per_page); ?></a>
          <a href="<?php echo esc_url(admin_url('admin-ajax.php')); ?>?page=<?php if ($next_page <= $last_page) {
            echo esc_url($next_page);
          } ?>" class="past<?php if ($page >= $last_page) {
            echo ' hidden';
          } ?>"><?php printf(__("past %d records &raquo;", '43d-records'), $per_page); ?></a>
          <?php paginate_links(); ?>
        </p>

        <ul id="static_pages">
          <?php wp_list_pages('title_li=<h3>' . __('Static Pages', '43d-records') . '</h3>'); ?>
        </ul>

        <?php
        $p43d_records_categories = get_categories();
        if (count($p43d_records_categories) > 0) : ?>

          <h3 class="post_categories"><?php esc_html_e('categories', '43d-records'); ?></h3>
          <p class="post_categories">
            <?php
            $p43d_records_categories_html = array();
            foreach ($p43d_records_categories as $p43d_records_category) {
              $p43d_records_category_link = get_category_link($p43d_records_category->term_id);

              $p43d_records_categories_html[] = '<a href="' . esc_url($p43d_records_category_link) . '" title="' . esc_attr($p43d_records_category->name)
                . '" class="' . esc_attr($p43d_records_category->slug) . '">' . esc_html($p43d_records_category->name) . '</a>';
            }
            echo implode(', ', $p43d_records_categories_html);
            ?>
          </p>
          <?php
        endif;

        $p43d_records_tags = get_tags();
        if (count($p43d_records_tags) > 0) : ?>

          <h3 class="post_tags"><?php esc_html_e('tags', '43d-records'); ?></h3>
          <p class="post_tags">
            <?php
            $p43d_records_tags_html = array();
            foreach ($p43d_records_tags as $p43d_records_tag) {
              $p43d_records_tag_link = get_tag_link($p43d_records_tag->term_id);

              $p43d_records_tags_html[] = '<a href="' . esc_url($p43d_records_tag_link) . '" title="' . esc_attr($p43d_records_tag->name)
                . '" class="' . esc_attr($p43d_records_tag->slug) . '">' . esc_html($p43d_records_tag->name) . '</a>';
            }
            echo implode(', ', $p43d_records_tags_html);
            ?>
          </p>
          <?php
        endif;

        ?>

      </div>
    </div>
  </div>

  <div id="timeline">
    <ul class="buttons">
      <li class="back10s"><img src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_back10s.svg"
                               alt="10s back button"/></li>
      <li class="rewind"><img src="<?php echo esc_url(P43D_RECORDS_BASE_URL); ?>/img/icon_rewind.svg"
                              alt="rewind button"/></li>
    </ul>
    <div class="if">
      <p class="cursor"></p>

      <div class="horizontal_bar"></div>
      <p class="current_time">0:00</p>

      <p class="total_time"><?php echo esc_html($p43d_records_total_length_formatted); ?></p>
    </div>
    <div class="bg"></div>
  </div>

<?php
get_footer();