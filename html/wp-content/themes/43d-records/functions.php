<?php
/**
 * p43d-records functions and definitions
 *
 * @package p43d-records
 */

if (!function_exists('p43d_records_setup')) {

  define('P43D_RECORDS_BASE_URL', esc_url(get_template_directory_uri()));
  define('P43D_RECORDS_VERSION', '0.9.6');
  define('P43D_RECORDS_WEBSITE', 'https://records.43d.jp/'); // for the credit and link
  define('P43D_RECORDS_LIST_NUM', intval(get_option('posts_per_page')));

  if (!isset($content_width)) {
    $content_width = 640;
  }

  function p43d_records_setup()
  {
    load_theme_textdomain('43d-records', get_template_directory() . '/languages');
    add_theme_support('post-thumbnails', array('post', 'page'));
    add_theme_support('automatic-feed-links');
    add_theme_support('html5');
    add_theme_support('title-tag');

    $custom_background_defaults = array(
      'default-color' => 'cccccc',
      'default-repeat' => 'no-repeat',
      'default-position-x' => 'center',
      'default-attachment' => 'fixed',
      'default-image' => esc_url(get_template_directory_uri()) . '/img/default_logo.png',
    );
    add_theme_support('custom-background', $custom_background_defaults);
  }

  add_action('after_setup_theme', 'p43d_records_setup');

  function p43d_records_scripts()
  {

    wp_enqueue_style('43d-records-normalize', get_template_directory_uri() . '/css/normalize.min.css');
    wp_enqueue_style('43d-records-style', get_stylesheet_uri(), array(), P43D_RECORDS_VERSION);

    wp_enqueue_script('jquery');
    if (is_singular() && comments_open()) {
      wp_enqueue_script('comment-reply');
    }

    global $p43d_records_recorded_sound_url_mp3,
           $p43d_records_recorded_sound_url_ogg,
           $p43d_records_total_length,
           $p43d_records_cover_image_id,
           $p43d_records_cover_image_src_1440,
           $p43d_records_cover_image_src_2560,
           $p43d_records_cover_image_src_3200,
           $p43d_records_cover_image_src_4096,
           $p43d_records_cover_image_src_5120,
           $category_name, $tag;

    wp_enqueue_script('43d-records-script-index', get_template_directory_uri() . '/js/index.js', array('jquery'), false, true);
    $php_vars = array(
      'recorded_sound_url_mp3' => $p43d_records_recorded_sound_url_mp3,
      'recorded_sound_url_ogg' => $p43d_records_recorded_sound_url_ogg,
      'total_length' => $p43d_records_total_length,
      'cover_image_id' => $p43d_records_cover_image_id,
      'cover_image_src_1440' => $p43d_records_cover_image_src_1440[0],
      'cover_image_src_2560' => $p43d_records_cover_image_src_2560[0],
      'cover_image_src_3200' => $p43d_records_cover_image_src_3200[0],
      'cover_image_src_4096' => $p43d_records_cover_image_src_4096[0],
      'cover_image_src_5120' => $p43d_records_cover_image_src_5120[0],
      'category_name' => $category_name,
      'tag' => $tag,
      'ajaxurl' => admin_url('admin-ajax.php'),
      'is_archive' => is_archive() ? 'true' : 'false'
    );
    wp_localize_script('43d-records-script-index', 'php_vars', $php_vars);
  }

  add_action('wp_enqueue_scripts', 'p43d_records_scripts');


  function p43d_records_add_custom_image_sizes()
  {
    global $p43d_records_my_custom_image_sizes;
    $p43d_records_my_custom_image_sizes = array(
      'thumbnail_320' => array(
        'name' => 'Thumbnail 320',
        'width' => 320,
        'height' => 320,
        'crop' => false,
        'selectable' => true
      ),
      'thumbnail_640' => array(
        'name' => 'Thumbnail 640',
        'width' => 640,
        'height' => 640,
        'crop' => false,
        'selectable' => true
      ),
      'landscape_960' => array(
        'name' => 'Landscape width 960',
        'width' => 960,
        'height' => 0,
        'crop' => false,
        'selectable' => true
      ),
      'landscape_1440' => array(
        'name' => 'Landscape width 1440',
        'width' => 1440,
        'height' => 0,
        'crop' => false,
        'selectable' => true
      ),
      'landscape_1920' => array(
        'name' => 'Landscape width 1920',
        'width' => 1920,
        'height' => 0,
        'crop' => false,
        'selectable' => true
      ),
      'landscape_2560' => array(
        'name' => 'Landscape width 2560',
        'width' => 2560,
        'height' => 0,
        'crop' => false,
        'selectable' => true
      ),
      'landscape_3200' => array(
        'name' => 'Landscape width 3200',
        'width' => 3200,
        'height' => 0,
        'crop' => false,
        'selectable' => true
      ),
      'landscape_4096' => array(
        'name' => 'Landscape width 4096',
        'width' => 4096,
        'height' => 0,
        'crop' => false,
        'selectable' => true
      ),
      'landscape_5120' => array(
        'name' => 'Landscape width 5120',
        'width' => 5120,
        'height' => 0,
        'crop' => false,
        'selectable' => true
      )
    );
    foreach ($p43d_records_my_custom_image_sizes as $slug => $size) {
      add_image_size($slug, $size['width'], $size['height'], $size['crop']);
    }
  }

  add_action('after_setup_theme', 'p43d_records_add_custom_image_sizes');


  function p43d_records_add_custom_image_size_select($t)
  {
    global $p43d_records_my_custom_image_sizes;
    $size_names = $t;

    foreach ($p43d_records_my_custom_image_sizes as $key => $val) {
      if (isset($val['selectable']) && $val['selectable']) {
        $size_names[$key] = $val['name'];
      }
    }
    return $size_names;
  }

  add_filter('image_size_names_choose', 'p43d_records_add_custom_image_size_select');


  function post_list($page = 0, $per_page = P43D_RECORDS_LIST_NUM, $echo = true, $category_name = '', $tag = '')
  {

    if (isset($_REQUEST['page'])) {
      $page = intval($_REQUEST['page']);
    }
    if (isset($_REQUEST['pp'])) {
      $per_page = intval($_REQUEST['pp']);
    }
    if (isset($_REQUEST['category_name'])) {
      $category_name = trim($_REQUEST['category_name']);
    }
    if (isset($_REQUEST['tag'])) {
      $tag = trim($_REQUEST['tag']);
    }

    $p43d_records_args = array(
      'post_type' => 'post',
      'numberposts' => 10000
    );
    if ($category_name != '') {
      $p43d_records_args['category_name'] = $category_name;
    }
    if ($tag != '') {
      $p43d_records_args['tax_query'] = array(
        array(
          'taxonomy' => 'post_tag',
          'field' => 'slug',
          'terms' => array($tag),
          'operator' => 'IN'
        )
      );
    }

    $p43d_records_tmp = get_posts($p43d_records_args);
    $numposts = count($p43d_records_tmp);
    $offset = $page * $per_page;
    $last_index = min($offset + $per_page, $numposts);
    $html = '';

    if (count($p43d_records_tmp) > 0) {
      for ($i = $offset; $i < $last_index; $i++) {
        $p43d_records_rec = $p43d_records_tmp[$i];
        setup_postdata($p43d_records_rec);

        $html .= '<li><span class="label">' . __('Posted On', '43d-records') . '</span><span class="subinfo">'
          . date('F j, Y H:i', strtotime($p43d_records_rec->post_date))
          . '</span><span class="title"><a href="' . esc_url(get_permalink($p43d_records_rec->ID)) . '">'
          . esc_html($p43d_records_rec->post_title) . '</a></span></li>';
      }
    }

    $retval = array($numposts, $page, $per_page, $html);

    if ($echo === true) {
      echo json_encode($retval);
      die();
    }

    return $retval;
  }

  add_action('wp_ajax_post_list', 'post_list');
  add_action('wp_ajax_nopriv_post_list', 'post_list');

  function p43d_records_filesize_format($b)
  {
    $b = intval($b);

    if ($b > 0) {
      $units = array('B', 'KB', 'MB', 'GB');
      $unit_index = intval(log($b, 1024));

      return sprintf('%.2f%s', $b / pow(1024, $unit_index), $units[$unit_index]);
    }

    return $b;
  }


  function p43d_records_audio_meta_stringify($metas, $array = false)
  {
    $specs = array();
    if (array_key_exists('filesize', $metas)) {
      $specs[] = 'Size: ' . p43d_records_filesize_format($metas['filesize']);
    }
    if (array_key_exists('length_formatted', $metas)) {
      $specs[] = 'Length: ' . $metas['length_formatted'];
    }
    if (array_key_exists('sample_rate', $metas)) {
      $specs[] = 'Sampling Rate: ' . number_format($metas['sample_rate']) . 'Hz';
    }
    if (array_key_exists('bitrate', $metas)) {
      $specs[] = 'Bitrate: ' . number_format($metas['bitrate'] / 1000) . 'kbps';
    }
    if (array_key_exists('channels', $metas)) {
      if ($metas['channels'] == 2) {
        $specs[] = 'Stereo';
      } else if ($metas['channels'] == 1) {
        $specs[] = 'Monaural';
      }
    }

    if (!$array) {
      if (count($specs) > 0) {
        return implode(', ', $specs);
      }
      return '';
    }

    return $specs;
  }


  function p43d_records_geo_stringify($lat, $lng)
  {
    $lat = p43d_records_dec2dms($lat);
    $str = abs($lat['deg']) . '°' . $lat['min'] . '′' . round($lat['sec']) . '″';
    $str .= ($lat['deg'] >= 0) ? 'N ' : 'S ';

    $lng = p43d_records_dec2dms($lng);
    $str .= abs($lng['deg']) . '°' . $lng['min'] . '′' . round($lng['sec']) . '″';
    $str .= ($lng['deg'] >= 0) ? 'E' : 'W';

    return $str;
  }


  function p43d_records_dec2dms($dec)
  {
    $tmp = explode('.', $dec);
    $tmp[1] = floatval('0.' . $tmp[1]) * 3600;
    $min = floor($tmp[1] / 60);
    $sec = $tmp[1] - ($min * 60);

    return array("deg" => intval($tmp[0]), "min" => $min, "sec" => $sec);
  }

}
