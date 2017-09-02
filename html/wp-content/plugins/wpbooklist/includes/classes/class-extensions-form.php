<?php
/**
 * WPBookList Add-Edit-Book-Form Tab Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPBookList_Add_Book_Form', false ) ) :
/**
 * WPBookList_Admin_Menu Class.
 */
class WPBookList_Add_Book_Form {

	public static function output_add_book_form(){

		// Perform check for previously-saved Amazon Authorization
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
		$opt_results = $wpdb->get_row("SELECT * FROM $table_name");

		$table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
		$db_row = $wpdb->get_results("SELECT * FROM $table_name");

		// For grabbing an image from media library
		wp_enqueue_media();
	 	$string1 = '<div id="wpbooklist-addbook-container">
				<p>Extensions are the easiest way to add additional functionality to your <span class="wpbooklist-color-orange-italic">WPBookList</span> plugin. Simply purchase the extension of your choice and install it just like you’d install any other WordPress plugin. That’s all there is to it!<br/><br/>
<div class="section group">
	<div class="col span_1_of_2">
	   <p class="wpbooklist-extension-title"><img class="wpbooklist-extension-icon-img" src="http://www.wpbooklist.com/wp-content/uploads/wpbooklist/icons/book.svg" />StoreFront Extension</p>
           <a id="wpbooklist-extensions-page-img-link" href="http://wpbooklist.com/index.php/downloads/storefront-extension/">
            <div class="wpbooklist-extension-page-ext-div" id="wpbooklist-extension-page-ext-div-1">
           <img class="wpbooklist-extension-img" src="http://wpbooklist.com/wp-content/uploads/2017/08/svgs/book.svg"  />
           <p class="wpbooklist-extension-p">StoreFront</p>
           </div>
           </a>
           <p class="wpbooklist-extension-excerpt"><span class="wpbooklist-excerpt-span">Got books to sell? Then you need the <span class="wpbooklist-color-orange-italic">WPBookList StoreFront Extension!</span></span><span class="wpbooklist-top-line-span"></span></p>
           <div class="wpbooklist-above-purchase-line"></div>
           <p class="wpbooklist-to-download-page"><a href="http://wpbooklist.com/index.php/downloads/storefront-extension/">More Details</a></p>
           <div class="wpbooklist-extensions-purchase-button-link"><a href="http://wpbooklist.com/index.php/downloads/storefront-extension/">$9.99 - Purchase Now</a></div>
	</div>
	<div class="col span_1_of_2">
	 <p class="wpbooklist-extension-title"><img class="wpbooklist-extension-icon-img" src="http://www.wpbooklist.com/wp-content/uploads/wpbooklist/icons/affiliate.svg" />Affiliates Extension</p>
          <a id="wpbooklist-extensions-page-img-link" href="http://wpbooklist.com/index.php/downloads/affiliate-extension/">
            <div class="wpbooklist-extension-page-ext-div" id="wpbooklist-extension-page-ext-div-2">
           <img class="wpbooklist-extension-img" src="http://wpbooklist.com/wp-content/uploads/2017/08/svgs/profits.svg"  />
           <p class="wpbooklist-extension-p">Affiliate</p>
          </div>
          </a>
           <p class="wpbooklist-extension-excerpt"><span class="wpbooklist-excerpt-span">Let WPBookList work for you with the <span class="wpbooklist-color-orange-italic">WPBookList Affiliates Extension!</span></span><span class="wpbooklist-top-line-span"></span></p>
           <div class="wpbooklist-above-purchase-line"></div>
           <p class="wpbooklist-to-download-page"><a href="http://wpbooklist.com/index.php/downloads/affiliate-extension/">More Details</a></p>
           <div class="wpbooklist-extensions-purchase-button-link"><a href="http://wpbooklist.com/index.php/downloads/affiliate-extension/">$5.00 - Purchase Now</a></div>
	</div>
	</div>
	<div class="section group">
  <div class="col span_1_of_2">
   <p class="wpbooklist-extension-title"><img class="wpbooklist-extension-icon-img" src="http://www.wpbooklist.com/wp-content/uploads/wpbooklist/icons/server.svg" />Bulk-Upload Extension</p>
          <a id="wpbooklist-extensions-page-img-link" href="http://wpbooklist.com/index.php/downloads/bulk-upload-extension/">
            <div class="wpbooklist-extension-page-ext-div" id="wpbooklist-extension-page-ext-div-3">
           <img class="wpbooklist-extension-img" src="http://wpbooklist.com/wp-content/uploads/2017/08/svgs/server.svg"  />
           <p class="wpbooklist-extension-p">Bulk-Upload</p>
           </div>
           </a>
           <p class="wpbooklist-extension-excerpt"><span class="wpbooklist-excerpt-span">Tons of books but no time? Then get the <span class="wpbooklist-color-orange-italic">WPBookList Bulk-Upload Extension!</span></span><span class="wpbooklist-top-line-span"></span></p>
           <div class="wpbooklist-above-purchase-line"></div>
           <p class="wpbooklist-to-download-page"><a href="http://wpbooklist.com/index.php/downloads/bulk-upload-extension/">More Details</a></p>
           <div class="wpbooklist-extensions-purchase-button-link"><a href="http://wpbooklist.com/index.php/downloads/bulk-upload-extension/">$5.00 - Purchase Now</a></div>
  </div>
	<div class="col span_1_of_2">
	  <p class="wpbooklist-extension-title"><img class="wpbooklist-extension-icon-img" src="http://www.wpbooklist.com/wp-content/uploads/wpbooklist/icons/ereader.svg" />Mobile App Extension</p>
            <a id="wpbooklist-extensions-page-img-link" href="http://wpbooklist.com/index.php/downloads/mobile-app-extension/">
             <div class="wpbooklist-extension-page-ext-div" id="wpbooklist-extension-page-ext-div-4">
             <img class="wpbooklist-extension-img" src="http://wpbooklist.com/wp-content/uploads/2017/08/svgs/ereader.svg"  />
             <p class="wpbooklist-extension-p">Mobile App</p>
             </div>
           </a>
           <p class="wpbooklist-extension-excerpt"><span class="wpbooklist-excerpt-span">Add books quickly and easily with the <span class="wpbooklist-color-orange-italic">WPBookList Mobile App Extension!</span></span><span class="wpbooklist-top-line-span"></span></p>
           <div class="wpbooklist-above-purchase-line"></div>
           <p class="wpbooklist-to-download-page"><a href="http://wpbooklist.com/index.php/downloads/mobile-app-extension/">More Details</a></p>
           <div class="wpbooklist-extensions-purchase-button-link"><a href="http://wpbooklist.com/index.php/downloads/mobile-app-extension/">$5.00 - Purchase Now</a></div>
	</div>
	</div>
	<div class="section group">
	<div class="col span_1_of_2">
	 <p class="wpbooklist-extension-title"><img class="wpbooklist-extension-icon-img" src="http://www.wpbooklist.com/wp-content/uploads/wpbooklist/icons/goodreads.svg" />Goodreads Extension</p>
            <a id="wpbooklist-extensions-page-img-link" href="http://wpbooklist.com/index.php/downloads/goodreads-extension/">
             <div class="wpbooklist-extension-page-ext-div" id="wpbooklist-extension-page-ext-div-5">
             <img class="wpbooklist-extension-img" src="http://wpbooklist.com/wp-content/uploads/2017/08/svgs/goodreads-letter-logo.svg"  />
             <p class="wpbooklist-extension-p">Goodreads</p>
             </div>
           </a>
           <p class="wpbooklist-extension-excerpt"><span class="wpbooklist-excerpt-span">Got a Goodreads account? Then check out the <span class="wpbooklist-color-orange-italic">WPBookList Goodreads Extension!</span></span><span class="wpbooklist-top-line-span"></span></p>
           <div class="wpbooklist-above-purchase-line"></div>
           <p class="wpbooklist-to-download-page"><a href="http://wpbooklist.com/index.php/downloads/goodreads-extension/">More Details</a></p>
           <div class="wpbooklist-extensions-purchase-button-link"><a href="http://wpbooklist.com/index.php/downloads/goodreads-extension/">$5.00 - Purchase Now</a></div>
    </div>
  </div>
</div>

				';

    		return $string1;
	}


}

endif;