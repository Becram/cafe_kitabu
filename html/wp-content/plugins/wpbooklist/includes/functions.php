<?php

/*
 * Adds the WordPress Ajax Library.
*/

// Code for adding the form checks js file
function wpbooklist_form_checks_js() {
    wp_register_script( 'wpbooklist_form_checks_js', JAVASCRIPT_URL.'formchecks.js', array('jquery') );
    wp_enqueue_script('wpbooklist_form_checks_js');
}

// Code for adding the jquery masked input file
function wpbooklist_jquery_masked_input_js() {
    wp_register_script( 'wpbooklist_jquery_masked_input_js', JAVASCRIPT_URL.'jquery-masked-input/jquery-masked-input.js', array('jquery') );
    wp_enqueue_script('wpbooklist_jquery_masked_input_js');
}

// Code for adding the jquery readmore file for text blocks like description and notes
function wpbooklist_jquery_readmore_js() {
    wp_register_script( 'wpbooklist_jquery_readmore_js', JAVASCRIPT_URL.'jquery-readmore/readmore.min.js', array('jquery') );
    wp_enqueue_script('wpbooklist_jquery_readmore_js');
}

// Code for adding the colorbox js file
function wpbooklist_jre_plugin_colorbox_script() {
    wp_register_script( 'colorboxjsforwpbooklist', JAVASCRIPT_URL.'jquery-colorbox/jquery.colorbox.js', array('jquery') );
    wp_enqueue_script('colorboxjsforwpbooklist');
}

// Code for adding the addthis js file
function wpbooklist_jre_plugin_addthis_script() {
    wp_register_script( 'addthisjsforwpbooklist', JAVASCRIPT_URL.'jquery-addthis/addthis.js', array('jquery') );
    wp_enqueue_script('addthisjsforwpbooklist');
}

// Code for adding the colorbox CSS file
function wpbooklist_jre_plugin_colorbox_style() {
    wp_register_style( 'colorboxcssforwpbooklist', ROOT_CSS_URL.'colorbox.css' );
    wp_enqueue_style('colorboxcssforwpbooklist');
}

// Adding the front-end library ui css file
function wpbooklist_jre_frontend_library_ui_default_style() {
  global $wpdb;
  $id = get_the_ID();
  $post = get_post($id);
  $content = '';
  if($post){
    $content = $post->post_content;
  }
  $stylepak = '';

  $table_name2 = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
  $db_row = $wpdb->get_results("SELECT * FROM $table_name2");
   foreach($db_row as $table){
    $shortcode = 'wpbooklist_shortcode table="'.$table->user_table_name.'"';

    if(stripos($content, $shortcode) !== false){
      $stylepak = $table->stylepak;
    }
  }

  if(stripos($content, '[wpbooklist_shortcode]') !== false){
      $table_name2 = $wpdb->prefix . 'wpbooklist_jre_user_options';
      $row = $wpdb->get_results("SELECT * FROM $table_name2");
      $stylepak = $row[0]->stylepak;
  }

  if($stylepak == '' || $stylepak == null || $stylepak == 'Default'){
    $stylepak = 'default';
  }

  if($stylepak == 'default' || $stylepak == 'Default StylePak'){
    wp_register_style( 'frontendlibraryui', ROOT_CSS_URL.'frontend-library-ui.css' );
    wp_enqueue_style('frontendlibraryui');
  }

  if($stylepak == 'StylePak1'){
    wp_register_style( 'StylePak1', LIBRARY_STYLEPAKS_UPLOAD_URL.'StylePak1.css' );
    wp_enqueue_style('StylePak1');
  }

  if($stylepak == 'StylePak2'){
    wp_register_style( 'StylePak2', LIBRARY_STYLEPAKS_UPLOAD_URL.'StylePak2.css' );
    wp_enqueue_style('StylePak2');
  }

  if($stylepak == 'StylePak3'){
    wp_register_style( 'StylePak3', LIBRARY_STYLEPAKS_UPLOAD_URL.'StylePak3.css' );
    wp_enqueue_style('StylePak3');
  }

  if($stylepak == 'StylePak4'){
    wp_register_style( 'StylePak4', LIBRARY_STYLEPAKS_UPLOAD_URL.'StylePak4.css' );
    wp_enqueue_style('StylePak4');
  }

  if($stylepak == 'StylePak5'){
    wp_register_style( 'StylePak5', LIBRARY_STYLEPAKS_UPLOAD_URL.'StylePak5.css' );
    wp_enqueue_style('StylePak5');
  }


}


// Code for adding the default posts & pages CSS file
function wpbooklist_jre_posts_pages_default_style() {
  
    global $wpdb;
    $id = get_the_ID();
    $stylepak = '';

    $table_name = $wpdb->prefix . 'wpbooklist_jre_saved_page_post_log';

    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d", $id));

    if($row != null){
      if($row->type == 'post'){
        $table_name_post = $wpdb->prefix . 'wpbooklist_jre_post_options';
      } else {
        $table_name_post = $wpdb->prefix . 'wpbooklist_jre_page_options';
      }

      $row = $wpdb->get_row("SELECT * FROM $table_name_post");
      $stylepak = $row->stylepak;
    }

    if($stylepak == '' || $stylepak == null || $stylepak == 'Default StylePak'){
      $stylepak = 'default';
    }

    if($stylepak == 'Default' || $stylepak == 'default' || $stylepak == 'Default StylePak'){
      wp_register_style( 'postspagesdefaultcssforwpbooklist', ROOT_CSS_URL.'posts-pages-default.css' );
      wp_enqueue_style('postspagesdefaultcssforwpbooklist');
    }

    if($stylepak == 'Post-StylePak1'){
      wp_register_style( 'Post-StylePak1', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak1.css' );
      wp_enqueue_style('Post-StylePak1');
    }

    if($stylepak == 'Post-StylePak2'){
      wp_register_style( 'Post-StylePak2', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak2.css' );
      wp_enqueue_style('Post-StylePak2');
    }

    if($stylepak == 'Post-StylePak3'){
      wp_register_style( 'Post-StylePak3', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak3.css' );
      wp_enqueue_style('Post-StylePak3');
    }

    if($stylepak == 'Post-StylePak4'){
      wp_register_style( 'Post-StylePak4', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak4.css' );
      wp_enqueue_style('Post-StylePak4');
    }

    if($stylepak == 'Post-StylePak5'){
      wp_register_style( 'Post-StylePak5', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak5.css' );
      wp_enqueue_style('Post-StylePak5');
    }

    
}

// Code for adding the general admin CSS file
function wpbooklist_jre_plugin_general_admin_style() {
  if(current_user_can( 'administrator' )){
      wp_register_style( 'wpbooklist_ui_style', ROOT_CSS_URL.'admin.css');
      wp_enqueue_style('wpbooklist_ui_style');
  }
}

// Code for adding the general admin CSS file
function wpbooklist_jre_plugin_book_in_colorbox_style() {
      wp_register_style( 'wpbooklist_book_in_colorbox_style', ROOT_CSS_URL.'book-in-colorbox.css');
      wp_enqueue_style('wpbooklist_book_in_colorbox_style');
} 

// Code for adding the admin template CSS file
function wpbooklist_jre_plugin_admin_template_style() {
  if(current_user_can( 'administrator' )){
      wp_register_style( 'wpbooklist_admin_template_style', ROOT_CSS_URL.'admin-template.css');
      wp_enqueue_style('wpbooklist_admin_template_style');
    }
}


function wpbooklist_jre_prem_add_ajax_library() {
 
    $html = '<script type="text/javascript">';

    // checking $protocol in HTTP or HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        // this is HTTPS
        $protocol  = "https";
    } else {
        // this is HTTP
        $protocol  = "http";
    }
    $tempAjaxPath = admin_url( 'admin-ajax.php' );
    $goodAjaxUrl = $protocol.strchr($tempAjaxPath,':');

    $html .= 'var ajaxurl = "' . $goodAjaxUrl . '"';
    $html .= '</script>';
    echo $html;
    
} // End add_ajax_library

// Function to add table names to the global $wpdb
function wpbooklist_jre_register_table_name() {
    global $wpdb;
    $wpdb->wpbooklist_jre_saved_book_log = "{$wpdb->prefix}wpbooklist_jre_saved_book_log";
    $wpdb->wpbooklist_jre_saved_page_post_log = "{$wpdb->prefix}wpbooklist_jre_saved_page_post_log";
    $wpdb->wpbooklist_jre_saved_books_for_featured = "{$wpdb->prefix}wpbooklist_jre_saved_books_for_featured";
    $wpdb->wpbooklist_jre_user_options = "{$wpdb->prefix}wpbooklist_jre_user_options";
    $wpdb->wpbooklist_jre_page_options = "{$wpdb->prefix}wpbooklist_jre_page_options";
    $wpdb->wpbooklist_jre_post_options = "{$wpdb->prefix}wpbooklist_jre_post_options";
    $wpdb->wpbooklist_jre_list_dynamic_db_names = "{$wpdb->prefix}wpbooklist_jre_list_dynamic_db_names";
    $wpdb->wpbooklist_jre_book_quotes = "{$wpdb->prefix}wpbooklist_jre_book_quotes";
    $wpdb->wpbooklist_jre_purchase_stylepaks = "{$wpdb->prefix}wpbooklist_jre_purchase_stylepaks";
    $wpdb->wpbooklist_jre_color_options = "{$wpdb->prefix}wpbooklist_jre_color_options";
    $wpdb->wpbooklist_jre_active_extensions = "{$wpdb->prefix}wpbooklist_jre_active_extensions";
}


// Runs once upon plugin activation and creates tables
function wpbooklist_jre_create_tables() {
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  global $wpdb;
  global $charset_collate; 

  // Call this manually as we may have missed the init hook
  wpbooklist_jre_register_table_name();
  //Creating the table

  $default_table = $wpdb->prefix."wpbooklist_jre_saved_book_log";
  if($wpdb->get_var("SHOW TABLES LIKE '$default_table'") != $default_table) {
    $sql_create_table1 = "CREATE TABLE {$wpdb->wpbooklist_jre_saved_book_log} 
    (
          ID bigint(255) auto_increment,
          title varchar(255),
          isbn bigint(255),
          author varchar(255),
          author_url varchar(255),
          price varchar(255),
          finished varchar(255),
          date_finished varchar(255),
          signed varchar(255),
          first_edition varchar(255),
          image varchar(255),
          pages bigint(255),
          pub_year bigint(255),
          publisher varchar(255),
          category varchar(255),
          description MEDIUMTEXT, 
          notes MEDIUMTEXT,
          itunes_page varchar(255),
          google_preview varchar(255),
          amazon_detail_page varchar(255),
          rating bigint(255),
          review_iframe varchar(255),
          similar_products MEDIUMTEXT,
          page_yes varchar(255),
          post_yes varchar(255),
          book_uid varchar(255),
          PRIMARY KEY  (ID),
            KEY title (title)
    ) $charset_collate; ";
    dbDelta( $sql_create_table1 );
  }else{

    

      $existing_array_1 = array(
        'book_title',
        'isbn',
        'author',
        'authorurl',
        'purchaseprice',
        'currentdate',
        'finishedyes',
        'finishedno',
        'booksignedyes',
        'booksignedno',
        'firsteditionyes',
        'firsteditionno',
        'yearfinished',
        'coverimage',
        'pagenum',
        'pubdate',
        'publisher',
        'weight',
        'category',
        'description',
        'notes',
        'itunespage',
        'googlepreview',
        'amazondetailpage',
        'bookrating',
        'reviewiframe',
        'similarproducts'
      );

      $new_array_1 = array(
        'title',
        'isbn',
        'author',
        'author_url',
        'price',
        'finished',
        'date_finished',
        'signed',
        'first_edition',
        'image',
        'pages',
        'pub_year',
        'publisher',
        'category',
        'description',
        'notes',
        'itunes_page',
        'google_preview',
        'amazon_detail_page',
        'rating',
        'review_iframe',
        'similar_products',
        'page_yes',
        'post_yes',
        'book_uid'
      );

      // Change column names from old version to new version
      $wpdb->query("ALTER TABLE $default_table CHANGE coverimage image varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE book_title title varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE authorurl author_url varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE purchaseprice price varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE finishedyes finished varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE booksignedyes signed varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE firsteditionyes first_edition varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE yearfinished date_finished varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE pagenum pages bigint(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE pubdate pub_year bigint(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE itunespage itunes_page varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE googlepreview google_preview varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE amazondetailpage amazon_detail_page varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE bookrating rating bigint(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE reviewiframe review_iframe varchar(255)");
      $wpdb->query("ALTER TABLE $default_table CHANGE similarproducts similar_products MEDIUMTEXT");
      $wpdb->query("ALTER TABLE $default_table ADD page_yes varchar(255)");
      $wpdb->query("ALTER TABLE $default_table ADD post_yes varchar(255)");
      $wpdb->query("ALTER TABLE $default_table ADD book_uid varchar(255)");

    
      // deleting old columns from old version
      foreach($existing_array_1 as $existing_table){
        $search_result = array_search($existing_table, $new_array_1);

        if($search_result){

        } else {
          $wpdb->query("ALTER TABLE $default_table DROP $existing_table");
        }
      } 

    $table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
    $db_row = $wpdb->get_results("SELECT * FROM $table_name");
    foreach($db_row as $table){
      $dyna_table_name = $wpdb->prefix . 'wpbooklist_jre_'.$table->user_table_name;
      // Change column names from old version to new version
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE coverimage image varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE book_title title varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE authorurl author_url varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE purchaseprice price varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE finishedyes finished varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE booksignedyes signed varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE firsteditionyes first_edition varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE yearfinished date_finished varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE pagenum pages bigint(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE pubdate pub_year bigint(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE itunespage itunes_page varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE googlepreview google_preview varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE amazondetailpage amazon_detail_page varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE bookrating rating bigint(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE reviewiframe review_iframe varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name CHANGE similarproducts similar_products MEDIUMTEXT");
      $wpdb->query("ALTER TABLE $dyna_table_name ADD page_yes varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name ADD post_yes varchar(255)");
      $wpdb->query("ALTER TABLE $dyna_table_name ADD book_uid varchar(255)");

      // deleting old columns from old version
      foreach($existing_array_1 as $existing_table){
        $search_result = array_search($existing_table, $new_array_1);

        if($search_result){

        } else {
          $wpdb->query("ALTER TABLE $dyna_table_name DROP $existing_table");
        }
      }

      $wpdb->wpbooklist_jre_dynamic_db_name_settings = "{$wpdb->prefix}wpbooklist_jre_settings_{$table->user_table_name}";
      $sql_create_table_settings = "CREATE TABLE {$wpdb->wpbooklist_jre_dynamic_db_name_settings} 
      (
          ID bigint(255) auto_increment,
          username varchar(255),
          version varchar(255) NOT NULL DEFAULT '3.3',
          amazonaff varchar(255) NOT NULL DEFAULT 'wpbooklistid-20',
          amazonauth varchar(255),
          itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
          enablepurchase bigint(255),
          hidestats bigint(255),
          hidesortby bigint(255),
          hidesearch bigint(255),
          hidebooktitle bigint(255),
          hidebookimage bigint(255),
          hidefinished bigint(255),
          hidelibrarytitle bigint(255),
          hideauthor bigint(255),
          hidecategory bigint(255),
          hidepages bigint(255),
          hidebookpage bigint(255),
          hidebookpost bigint(255),
          hidepublisher bigint(255),
          hidepubdate bigint(255),
          hidesigned bigint(255),
          hidefirstedition bigint(255),
          hidefacebook bigint(255),
          hidemessenger bigint(255),
          hidetwitter bigint(255),
          hidegoogleplus bigint(255),
          hidepinterest bigint(255),
          hideemail bigint(255),
          hidefrontendbuyimg bigint(255),
          hidefrontendbuyprice bigint(255),
          hidecolorboxbuyimg bigint(255),
          hidecolorboxbuyprice bigint(255),
          hidegoodreadswidget bigint(255),
          hidedescription bigint(255),
          hidesimilar bigint(255),
          hideamazonreview bigint(255),
          hidenotes bigint(255),
          hidebottompurchase bigint(255),
          hidegooglepurchase bigint(255),
          hidefeaturedtitles bigint(255),
          hidebnpurchase bigint(255),
          hideitunespurchase bigint(255),
          hideamazonpurchase bigint(255),
          hiderating bigint(255),
          hideratingbook bigint(255),
          hidequote bigint(255),
          hidequotebook bigint(255),
          sortoption varchar(255),
          booksonpage bigint(255) NOT NULL DEFAULT 12,
          amazoncountryinfo varchar(255) NOT NULL DEFAULT 'US',
          stylepak varchar(255) NOT NULL DEFAULT 'Default',
          admindismiss bigint(255) NOT NULL DEFAULT 1,
          adminmessage varchar(10000) NOT NULL DEFAULT '".ADMIN_MESSAGE."',
          PRIMARY KEY  (ID),
            KEY username (username)
      ) $charset_collate; ";
      dbDelta( $sql_create_table_settings );
      $table_name = $wpdb->wpbooklist_jre_dynamic_db_name_settings;
      $wpdb->insert( $table_name, array('ID' => 1));
    }

    $table_user_opt = $wpdb->prefix."wpbooklist_jre_user_options";
    $wpdb->query("DROP TABLE IF EXISTS $table_user_opt");

  }
    
  $sql_create_table2 = "CREATE TABLE {$wpdb->wpbooklist_jre_user_options} 
  (
        ID bigint(255) auto_increment,
        username varchar(255),
        version varchar(255) NOT NULL DEFAULT '3.3',
        amazonaff varchar(255) NOT NULL DEFAULT 'wpbooklistid-20',
        amazonauth varchar(255),
        itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
        enablepurchase bigint(255),
        amazonapipublic varchar(255),
        amazonapisecret varchar(255),
        googleapi varchar(255),
        appleapi varchar(255),
        openlibraryapi varchar(255),
        hidestats bigint(255),
        hidesortby bigint(255),
        hidesearch bigint(255),
        hidebooktitle bigint(255),
        hidebookimage bigint(255),
        hidefinished bigint(255),
        hidelibrarytitle bigint(255),
        hideauthor bigint(255),
        hidecategory bigint(255),
        hidepages bigint(255),
        hidebookpage bigint(255),
        hidebookpost bigint(255),
        hidepublisher bigint(255),
        hidepubdate bigint(255),
        hidesigned bigint(255),
        hidefirstedition bigint(255),
        hidefacebook bigint(255),
        hidemessenger bigint(255),
        hidetwitter bigint(255),
        hidegoogleplus bigint(255),
        hidepinterest bigint(255),
        hideemail bigint(255),
        hidefrontendbuyimg bigint(255),
        hidefrontendbuyprice bigint(255),
        hidecolorboxbuyimg bigint(255),
        hidecolorboxbuyprice bigint(255),
        hidegoodreadswidget bigint(255),
        hidedescription bigint(255),
        hidesimilar bigint(255),
        hideamazonreview bigint(255),
        hidenotes bigint(255),
        hidebottompurchase bigint(255),
        hidegooglepurchase bigint(255),
        hidefeaturedtitles bigint(255),
        hidebnpurchase bigint(255),
        hideitunespurchase bigint(255),
        hideamazonpurchase bigint(255),
        hiderating bigint(255),
        hideratingbook bigint(255),
        hidequote bigint(255),
        hidequotebook bigint(255),
        sortoption varchar(255),
        booksonpage bigint(255) NOT NULL DEFAULT 12,
        amazoncountryinfo varchar(255) NOT NULL DEFAULT 'US',
        stylepak varchar(255) NOT NULL DEFAULT 'Default',
        admindismiss bigint(255) NOT NULL DEFAULT 1,
        adminmessage varchar(10000) NOT NULL DEFAULT '".ADMIN_MESSAGE."',
        PRIMARY KEY  (ID),
          KEY username (username)
  ) $charset_collate; ";
  dbDelta( $sql_create_table2 );

  $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
  $wpdb->insert( $table_name, array('ID' => 1)); 

  $sql_create_table3 = "CREATE TABLE {$wpdb->wpbooklist_jre_page_options} 
  (
        ID bigint(255) auto_increment,
        username varchar(255),
        amazonaff varchar(255) NOT NULL DEFAULT 'wpbooklistid-20',
        amazonauth varchar(255),
        barnesaff varchar(255),
        itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
        enablepurchase bigint(255),
        hidetitle bigint(255),
        hidebooktitle bigint(255),
        hidebookimage bigint(255),
        hidefinished bigint(255),
        hideauthor bigint(255),
        hidefrontendbuyimg bigint(255),
        hidefrontendbuyprice bigint(255),
        hidecolorboxbuyimg bigint(255),
        hidecolorboxbuyprice bigint(255),
        hidecategory bigint(255),
        hidepages bigint(255),
        hidepublisher bigint(255),
        hidepubdate bigint(255),
        hidesigned bigint(255),
        hidefirstedition bigint(255),
        hidefacebook bigint(255),
        hidemessenger bigint(255),
        hidetwitter bigint(255),
        hidegoogleplus bigint(255),
        hidepinterest bigint(255),
        hideemail bigint(255),
        hidedescription bigint(255),
        hidesimilar bigint(255),
        hideamazonreview bigint(255),
        hidenotes bigint(255),
        hidegooglepurchase bigint(255),
        hidefeaturedtitles bigint(255),
        hidebnpurchase bigint(255),
        hideitunespurchase bigint(255),
        hideamazonpurchase bigint(255),
        hiderating bigint(255),
        hidequote bigint(255),
        amazoncountryinfo varchar(255) NOT NULL DEFAULT 'US',
        stylepak varchar(255) NOT NULL DEFAULT 'Default',
        PRIMARY KEY  (ID),
          KEY username (username)
  ) $charset_collate; ";
  dbDelta( $sql_create_table3 );

  $table_name = $wpdb->prefix . 'wpbooklist_jre_page_options';
  $wpdb->insert( $table_name, array('ID' => 1)); 

  $sql_create_table4 = "CREATE TABLE {$wpdb->wpbooklist_jre_post_options} 
  (
        ID bigint(255) auto_increment,
        username varchar(255),
        amazonaff varchar(255) NOT NULL DEFAULT 'wpbooklistid-20',
        amazonauth varchar(255),
        barnesaff varchar(255),
        itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
        enablepurchase bigint(255),
        hidetitle bigint(255),
        hidebooktitle bigint(255),
        hidebookimage bigint(255),
        hidefinished bigint(255),
        hideauthor bigint(255),
        hidefrontendbuyimg bigint(255),
        hidefrontendbuyprice bigint(255),
        hidecolorboxbuyimg bigint(255),
        hidecolorboxbuyprice bigint(255),
        hidecategory bigint(255),
        hidepages bigint(255),
        hidepublisher bigint(255),
        hidepubdate bigint(255),
        hidesigned bigint(255),
        hidefirstedition bigint(255),
        hidefacebook bigint(255),
        hidemessenger bigint(255),
        hidetwitter bigint(255),
        hidegoogleplus bigint(255),
        hidepinterest bigint(255),
        hideemail bigint(255),
        hidedescription bigint(255),
        hidesimilar bigint(255),
        hideamazonreview bigint(255),
        hidenotes bigint(255),
        hidegooglepurchase bigint(255),
        hidefeaturedtitles bigint(255),
        hidebnpurchase bigint(255),
        hideitunespurchase bigint(255),
        hideamazonpurchase bigint(255),
        hiderating bigint(255),
        hidequote bigint(255),
        amazoncountryinfo varchar(255) NOT NULL DEFAULT 'US',
        stylepak varchar(255) NOT NULL DEFAULT 'Default',
        PRIMARY KEY  (ID),
          KEY username (username)
  ) $charset_collate; ";
  dbDelta( $sql_create_table4 );

  $table_name = $wpdb->prefix . 'wpbooklist_jre_post_options';
  $wpdb->insert( $table_name, array('ID' => 1)); 

  $sql_create_table5 = "CREATE TABLE {$wpdb->wpbooklist_jre_list_dynamic_db_names} 
  (
        ID bigint(255) auto_increment,
        user_table_name varchar(255) NOT NULL,
        stylepak varchar(255),
        PRIMARY KEY  (ID),
          KEY user_table_name (user_table_name)
  ) $charset_collate; ";
  dbDelta( $sql_create_table5 ); 

  $sql_create_table6 = "CREATE TABLE {$wpdb->wpbooklist_jre_book_quotes} 
  (
        ID bigint(255) auto_increment,
        placement varchar(255),
        quote varchar(255),
        PRIMARY KEY  (ID),
          KEY quote (quote)
  ) $charset_collate; ";
  dbDelta( $sql_create_table6 );

  // Get the default quotes for adding to database
  $quote_string = file_get_contents(QUOTES_DIR.'defaultquotes.txt');
  $quote_array = explode(';', $quote_string);
  $table_name = $wpdb->prefix . 'wpbooklist_jre_book_quotes';
  foreach($quote_array as $quote){
    if(strlen($quote) > 100){
      $placement = 'ui';
    } else {
      $placement = 'book';
    }
    if(strlen($quote) > 1){
      $wpdb->insert( $table_name, array('quote' => $quote, 'placement' => $placement)); 
    }
  }

  $sql_create_table7 = "CREATE TABLE {$wpdb->wpbooklist_jre_saved_page_post_log} 
  (
        ID bigint(255) auto_increment,
        book_uid varchar(255),
        book_title varchar(255),
        post_id bigint(255),
        type varchar(255),
        post_url varchar(255),
        author bigint(255),
        active_template varchar(255),
        PRIMARY KEY  (ID),
          KEY book_uid (book_uid)
  ) $charset_collate; ";
  dbDelta( $sql_create_table7 );

  

  //Creating the table
  $sql_create_table8 = "CREATE TABLE {$wpdb->wpbooklist_jre_saved_books_for_featured} 
  (
        ID bigint(255) auto_increment,
        book_title varchar(255),
        isbn bigint(255),
        author varchar(255),
        authorurl varchar(255),
        purchaseprice varchar(255),
        currentdate varchar(255),
        finishedyes varchar(255),
        finishedno varchar(255),
        booksignedyes varchar(255),
        booksignedno varchar(255),
        firsteditionyes varchar(255),
        firsteditionno varchar(255),
        yearfinished bigint(255),
        coverimage varchar(255),
        pagenum bigint(255),
        pubdate bigint(255),
        publisher varchar(255),
        weight bigint(255),
        category varchar(255),
        description MEDIUMTEXT, 
        notes MEDIUMTEXT,
        itunespage varchar(255),
        googlepreview varchar(255),
        amazondetailpage varchar(255),
        bookrating bigint(255),
        reviewiframe varchar(255),
        similarproducts MEDIUMTEXT,
        PRIMARY KEY  (ID),
          KEY book_title (book_title)
  ) $charset_collate; ";
  dbDelta( $sql_create_table8 );

  $sql_create_table9 = "CREATE TABLE {$wpdb->wpbooklist_jre_active_extensions} 
  (
        ID bigint(255) auto_increment,
        extension_name varchar(255),
        active varchar(255),
        PRIMARY KEY  (ID),
          KEY extension_name (extension_name)
  ) $charset_collate; ";
  dbDelta( $sql_create_table9 );
}

// Function for deleting tables upon deletion of plugin
function wpbooklist_jre_delete_tables() {
    global $wpdb;
    $table1 = $wpdb->prefix."wpbooklist_jre_saved_book_log";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table1", $table1));
    
    $table2 = $wpdb->prefix."wpbooklist_jre_saved_page_post_log";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table2", $table2));

    $table4 = $wpdb->prefix."wpbooklist_jre_saved_books_for_featured";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table4", $table4));

    $table5 = $wpdb->prefix."wpbooklist_jre_user_options";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table5", $table5));

    $table6 = $wpdb->prefix."wpbooklist_jre_page_options";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table6", $table6));

    $table7 = $wpdb->prefix."wpbooklist_jre_post_options";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table7", $table7));

    $table8 = $wpdb->prefix."wpbooklist_jre_book_quotes";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table8", $table8));

    $table9 = $wpdb->prefix."wpbooklist_jre_book_quotes";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table9", $table9));
    
    $table3 = $wpdb->prefix."wpbooklist_jre_list_dynamic_db_names";
    $user_created_tables = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table3", $table3), $table3);
    foreach($user_created_tables as $utable){
      $table = $wpdb->prefix."wpbooklist_jre_".$utable->user_table_name;
      $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table", $table));
    }
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table3", $table3));
}

//Function to add the admin menu
function wpbooklist_jre_my_admin_menu() {
  add_menu_page( 'WPBookList Options', 'WPBookList', 'manage_options', 'WPBookList-Options', 'wpbooklist_jre_admin_page_function', ROOT_IMG_URL.'icon-256x256.png', 6  );

  $submenu_array = array(
    "Books",
    "Display Options",
    "Settings",
    "Extensions"
  );

  // Filter to allow the addition of a new subpage
  if(has_filter('wpbooklist_add_sub_menu')) {
    $submenu_array = apply_filters('wpbooklist_add_sub_menu', $submenu_array);
  }

  foreach($submenu_array as $key=>$submenu){
    $menu_slug = strtolower(str_replace(' ', '-', $submenu));
    add_submenu_page('WPBookList-Options', 'WPBookList', $submenu, 'manage_options', 'WPBookList-Options-'.$menu_slug, 'wpbooklist_jre_admin_page_function');
  }

  remove_submenu_page('WPBookList-Options', 'WPBookList-Options');


}

function wpbooklist_jre_admin_page_function(){
  global $wpdb;
  require_once(ROOT_INCLUDES_UI_ADMIN_DIR.'class-admin-master-ui.php');
}


// Function to allow users to specify which table they want displayed by passing as an argument in the shortcode
function wpbooklist_jre_plugin_dynamic_shortcode_function($atts){
  global $wpdb;

  extract(shortcode_atts(array(
          'table' => $wpdb->prefix."saved_book_log",
  ), $atts));

  $which_table = $wpdb->prefix . 'wpbooklist_jre_'.$table;

  if($atts == null){
    $which_table = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
  }

  $offset = 0;

  ob_start();
  include_once( ROOT_INCLUDES_UI . 'class-frontend-library-ui.php');
  $front_end_library_ui = new WPBookList_Front_End_Library_UI($which_table);
  $front_end_library_ui->build_library_actual($offset);
  return ob_get_clean();
}
 

// The function that determines which template to load for WPBookList Pages
function wpbooklist_set_page_post_template( $content ) {
  global $wpdb;

  $id = get_the_id();
  $blog_url = get_permalink( get_option( 'page_for_posts' ) );
  $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if($blog_url == $actual_link){
  
  }

  $table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  $page_post_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d", $id));

  // If current page/post is a WPBookList Page or Post...
  if($page_post_row != null){

    if($page_post_row->type == 'page'){
      $table_name = $wpdb->prefix.'wpbooklist_jre_page_options';
      $options_page_row = $wpdb->get_row("SELECT * FROM $table_name");
    }

    if($page_post_row->type == 'post'){
      $table_name = $wpdb->prefix.'wpbooklist_jre_post_options';
      $options_post_row = $wpdb->get_row("SELECT * FROM $table_name");
    }

    $options_table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
    $options_row = $wpdb->get_row("SELECT * FROM $options_table_name");
    $amazon_country_info = $options_row->amazoncountryinfo;

    $table_name = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
    $book_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s", $page_post_row->book_uid));


    // If book wasn't found in default library, loop through and search custom libraries
    if($book_row == null){
      $table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
      $db_row = $wpdb->get_results("SELECT * FROM $table_name");
      
      foreach($db_row as $row){
        $table_name = $wpdb->prefix.'wpbooklist_jre_'.$row->user_table_name;
        $book_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s", $page_post_row->book_uid));
        if($book_row == null){
          continue;
        } else {
          break;
        }
      }
    }

    switch ($amazon_country_info) {
          case "au":
              $book_row->amazon_detail_page = str_replace(".com",".com.au", $book_row->amazon_detail_page);
              $book_row->$review_iframe = str_replace(".com",".com.au", $this->$review_iframe);
              break;
          case "br":
              $book_row->amazon_detail_page = str_replace(".com",".com.br", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".com.br", $book_row->review_iframe);
              break;
          case "ca":
              $book_row->amazon_detail_page = str_replace(".com",".ca", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".ca", $book_row->review_iframe);
              break;
          case "cn":
              $book_row->amazon_detail_page = str_replace(".com",".cn", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".cn", $book_row->review_iframe);
              break;
          case "fr":
              $book_row->amazon_detail_page = str_replace(".com",".fr", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".fr", $book_row->review_iframe);
              break;
          case "de":
              $book_row->amazon_detail_page = str_replace(".com",".de", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".de", $book_row->review_iframe);
              break;
          case "in":
              $book_row->amazon_detail_page = str_replace(".com",".in", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".in", $book_row->review_iframe);
              break;
          case "it":
              $book_row->amazon_detail_page = str_replace(".com",".it", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".it", $book_row->review_iframe);
              break;
          case "jp":
              $book_row->amazon_detail_page = str_replace(".com",".co.jp", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".co.jp", $book_row->review_iframe);
              break;
          case "mx":
              $book_row->amazon_detail_page = str_replace(".com",".com.mx", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".com.mx", $book_row->review_iframe);
              break;
          case "nl":
              $book_row->amazon_detail_page = str_replace(".com",".nl", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".nl", $book_row->review_iframe);
              break;
          case "es":
              $book_row->amazon_detail_page = str_replace(".com",".es", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".es", $book_row->review_iframe);
              break;
          case "uk":
              $book_row->amazon_detail_page = str_replace(".com",".co.uk", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".co.uk", $book_row->review_iframe);
              break;
          default:
              //$book_row->amazon_detail_page = $saved_book->amazon_detail_page;//filter_var($saved_book->amazon_detail_page, FILTER_SANITIZE_URL);
    }

    

    // Getting/creating quotes
    $quotes = file_get_contents(QUOTES_DIR.'defaultquotes.txt');
    $quotes_array = explode(';', $quotes);
    $quote = $quotes_array[array_rand($quotes_array)];
    $quote_array_2 = explode('-', $quote);

    if(sizeof($quote_array_2) == 2){
      $quote = '<span id="wpbooklist-quote-italic">'.$quote_array_2[0].'</span> - <span id="wpbooklist-quote-bold">'.$quote_array_2[1].'</span>';
    }

    // Getting Similar titles
    if($page_post_row->type == 'post'){
      $similar_string = '<div id="wpbl-similar-div"><p class="wpbl-posttd-share-text">Similar Titles</p>';
    }

    if($page_post_row->type == 'page'){
      $similar_string = '<div id="wpbl-similar-div"><p class="wpbl-pagetd-share-text">Similar Titles</p>';
    }

    $similarproductsarray = explode(';bsp;',$book_row->similar_products);
    $similarproductsarray = array_unique($similarproductsarray);
    $similar_products_array = array_values($similarproductsarray);
    foreach($similar_products_array as $key=>$prod){
      $arr = explode("---", $prod, 2);
      $asin = $arr[0];

      $image = 'http://images.amazon.com/images/P/'.$asin.'.01.LZZZZZZZ.jpg';
      $url = 'https://www.amazon.com/dp/'.$asin.'?tag='.$options_row->amazonaff;
      if(strlen($image) > 51 ){
        if($page_post_row->type == 'page'){
          $similar_string = $similar_string.'<a class="wpbooklist-similar-link-post" target="_blank" href="'.$url.'"><img class="wpbooklist-similar-image-page" src="'.$image.'" /></a>';
        }
        if($page_post_row->type == 'post'){
          $similar_string = $similar_string.'<a class="wpbooklist-similar-link-post" target="_blank" href="'.$url.'"><img class="wpbooklist-similar-image-post" src="'.$image.'" /></a>';
        }
      }
    }

    $similar_string = $similar_string.'</div>';
    $page_post_row->active_template;

    switch ($page_post_row->active_template) {
      case 'template1':
        if($page_post_row->type == 'page'){
          include(PAGE_TEMPLATES_UPLOAD_DIR.'page-template-1.php');
          //return $content;
        } else {
          include(PAGE_TEMPLATES_UPLOAD_DIR.'post-template-1.php');
          //return $content;
        }
        break;
      case 'template2':
        if($page_post_row->type == 'page'){
          include(PAGE_TEMPLATES_UPLOAD_DIR.'page-template-2.php');
         // return $content;
        } else {
          include(PAGE_TEMPLATES_UPLOAD_DIR.'post-template-2.php');
          //return $content;
        }
        break;
      case 'default':
        if($page_post_row->type == 'page'){
          include(PAGE_TEMPLATES_DEFAULT_DIR.'page-template-default.php');

          // Double-check that Amazon review isn't expired
          require_once(CLASS_DIR.'class-book.php');
          $book = new WPBookList_Book($book_row->ID, $table_name);
          $book->refresh_amazon_review($book_row->ID, $table_name);

          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;

        } else {
          include(PAGE_TEMPLATES_DEFAULT_DIR.'post-template-default.php');

          // Double-check that Amazon review isn't expired
          require_once(CLASS_DIR.'class-book.php');
          $book = new WPBookList_Book($book_row->ID, $table_name);
          $book->refresh_amazon_review($book_row->ID, $table_name);

          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        }
        break;
      default:
        //return $content;
        break;
    }

  }

  // Making double-sure content gets returned.
  return $content; 
}

// Handles various aestetic functions for the front end
function wpbooklist_various_aestetic_bits_front_end(){
  ?>
  <script type="text/javascript" >
  "use strict";
  jQuery(document).ready(function($) {

    // Handles the saerch functions
    if($('#wpbooklist-search-text').val() != 'Search...'){
      $('#wpbooklist-search-sub-button').prop('disabled', false);
    }
    $(document).on("click","#wpbooklist-search-text", function(event){
      $(this).val('');
      $('#wpbooklist-search-sub-button').prop('disabled', false);
    });



    
    // Enables the 'Read More' link for the description block in a post utilizing the readmore.js file
    $('.wpbl-posttd-book-description-contents').readmore({
      speed: 175,
      heightMargin: 16,
      collapsedHeight: 100,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });

    // Enables the 'Read More' link for the notes block in a post utilizing the readmore.js file
    $('#wpbl-posttd-book-notes-contents').readmore({
      speed: 75,
      heightMargin: 16,
      collapsedHeight: 100,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });

    // Enables the 'Read More' link for the description block in a post utilizing the readmore.js file
    $('#wpbl-pagetd-book-description-contents').readmore({
      speed: 175,
      heightMargin: 16,
      collapsedHeight: 100,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });

    // Enables the 'Read More' link for the notes block in a post utilizing the readmore.js file
    $('#wpbl-pagetd-book-notes-contents').readmore({
      speed: 75,
      heightMargin: 16,
      collapsedHeight: 100,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });
  });
  </script>
  <?php
}

// Handles various aestetic functions for the back end
function wpbooklist_various_aestetic_bits_back_end(){
  wp_enqueue_media();
  ?>
  <script type="text/javascript" >
  "use strict";
  jQuery(document).ready(function($) {

    // Making the last active library the viewed library after page reload
    if(window.location.href.includes('library=') && window.location.href.includes('tab=edit-books') && window.location.href.includes('WPBookList')){
          $('#wpbooklist-editbook-select-library').val(window.location.href.substr( window.location.href.lastIndexOf("=")+1));
          $('#wpbooklist-editbook-select-library').trigger("change");
    }

    // Highlight active tab
    console.log(window.location.href);
    if(window.location.href.includes('&tab=')){
      $('.nav-tab').each(function(){
        console.log('<?php echo admin_url();?>'+$(this).attr('href'));
        if(window.location.href == '<?php echo admin_url();?>admin.php'+$(this).attr('href')){
          $(this).first().css({'background-color':'#F05A1A', 'color':'white'})
        }
      })
      console.log('a tab')
    } else {
      $('.nav-tab').first().css({'background-color':'#F05A1A', 'color':'white'})
    }

    // Only allow one localization checkbox to be checked
    $(".wpbooklist-localization-checkbox").change(function(){
      $('[name=us-based-book-info]').attr('checked', false);
      $('[name=uk-based-book-info]').attr('checked', false);
      $('[name=au-based-book-info]').attr('checked', false);
      $('[name=br-based-book-info]').attr('checked', false);
      $('[name=ca-based-book-info]').attr('checked', false);
      $('[name=cn-based-book-info]').attr('checked', false);
      $('[name=fr-based-book-info]').attr('checked', false);
      $('[name=de-based-book-info]').attr('checked', false);
      $('[name=in-based-book-info]').attr('checked', false);
      $('[name=it-based-book-info]').attr('checked', false);
      $('[name=jp-based-book-info]').attr('checked', false);
      $('[name=mx-based-book-info]').attr('checked', false);
      $('[name=es-based-book-info]').attr('checked', false); 
      $('[name=nl-based-book-info]').attr('checked', false);
      $(this).attr('checked', true);
    });

    // Handles the enabling/disabling of the 'Create a Library' button and input placeholder text
    $(".wpbooklist-dynamic-input").on('click', function() { 
      var currentVal = $(".wpbooklist-dynamic-input").val();
      if(currentVal == 'Create a New Library Here...'){
        $(".wpbooklist-dynamic-input").val('');
      }
    });
    $(".wpbooklist-dynamic-input").bind('input', function() { 
      var currentVal = $(".wpbooklist-dynamic-input").val();
      if((currentVal.length > 0) && (currentVal != 'Create a New Library Here...')){
        $("#wpbooklist-dynamic-shortcode-button").attr('disabled', false);
      }
    });

    // Handles the 'check all' and 'uncheck all' function of the display options
    $("#wpbooklist-check-all").on('click', function() { 
      $("#wpbooklist-uncheck-all").prop('checked', false);
      $('#wpbooklist-jre-backend-options-table input').each(function(){
        $(this).prop('checked', true);
      })
    });
    $("#wpbooklist-uncheck-all").on('click', function() { 
      $("#wpbooklist-check-all").prop('checked', false);
      $('#wpbooklist-jre-backend-options-table input').each(function(){
        $(this).prop('checked', false);
      })
    });

  });
  </script>
  <?php
}


// Shortcode function for displaying book cover image/link
function wpbooklist_book_cover_shortcode($atts) {
  global $wpdb;

  extract(shortcode_atts(array(
          'table' => $wpdb->prefix."saved_book_log",
          'isbn' => '',
          'width' => '100',
          'align' => 'left',
          'margin' => '5px'
  ), $atts));

  if($atts == null){
    $table = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
    $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table  LIMIT %d",1));
    $isbn = $options_row[0]->isbn;
    $width = '100';
    //echo 'table: '.$table.PHP_EOL.'isbn: '.$isbn;
  }

  if(!isset($atts['isbn']) && !isset($atts['table']) ){
    $table = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
    $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table LIMIT %d",1));
    $isbn = $options_row[0]->isbn;
  }

  if(!isset($atts['isbn']) && isset($atts['table']) ){
    $table = $wpdb->prefix.'wpbooklist_jre_'.$table;
    $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table  LIMIT %d",1));
    $isbn = $options_row[0]->isbn;

  }

  if(isset($atts['isbn']) && !isset($atts['table']) ){
    $table = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
  }

  if(isset($atts['isbn']) && isset($atts['table'])){
    $table = $wpdb->prefix.'wpbooklist_jre_'.$table;
  }

  $isbn = str_replace('-','', $isbn);
  $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE isbn = %d", $isbn));
  if(sizeof($options_row) == 0){
    echo "This book isn't in your Library! Please check the ISBN number you provided.";
  } else {
    $image = $options_row[0]->image;
    $link = $options_row[0]->amazon_detail_page;
    $table_name_options = $wpdb->prefix . 'wpbooklist_jre_user_options';
    $options_results = $wpdb->get_row("SELECT * FROM $table_name_options");
    $amazoncountryinfo = $options_results->amazoncountryinfo;
    switch ($amazoncountryinfo) {
        case "au":
            $link = str_replace(".com",".com.au", $link);
            break;
        case "br":
            $link = str_replace(".com",".com.br", $link);
            break;
        case "ca":
            $link = str_replace(".com",".ca", $link);
            break;
        case "cn":
            $link = str_replace(".com",".cn", $link);
            break;
        case "fr":
            $link = str_replace(".com",".fr", $link);
            break;
        case "de":
            $link = str_replace(".com",".de", $link);
            break;
        case "in":
            $link = str_replace(".com",".in", $link);
            break;
        case "it":
            $link = str_replace(".com",".it", $link);
            break;
        case "jp":
            $link = str_replace(".com",".co.jp", $link);
            break;
        case "mx":
            $link = str_replace(".com",".com.mx", $link);
            break;
        case "nl":
            $link = str_replace(".com",".nl", $link);
            break;
        case "es":
            $link = str_replace(".com",".es", $link);
            break;
        case "uk":
            $link = str_replace(".com",".co.uk", $link);
            break;
        default:
            $link;
    }//end switch 
    return '<a style="float:'.$align.'; margin:'.$margin.';" class="wpbooklist_jre_book_cover_shortcode_link" target="_blank" href="'.$link.'"><img width='.$width.' src="'.$image.'"/></a>';
  }
 
}



?>