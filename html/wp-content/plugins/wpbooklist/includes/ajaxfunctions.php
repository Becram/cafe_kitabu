<?php



// Function for adding a book 
function wpbooklist_dashboard_add_book_action_javascript() { 
	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		// For the book cover image upload
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
		var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
		jQuery('#wpbooklist-addbook-upload_image_button, #wpbooklist-storefront-img-button-1, #wpbooklist-storefront-img-button-2').on('click', function( event ){
		var buttonid = $(this).attr('id');
		$(this).attr('data-active', true);
		console.log(buttonid);
		event.preventDefault();
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			// Set the post ID to what we want
			file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
			// Open frame
			file_frame.open();
			return;
		} else {
			// Set the wp.media post id so the uploader grabs the ID we want when initialised
			wp.media.model.settings.post.id = set_to_post_id;
		}
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select a image to upload',
			button: {
			text: 'Use this image',
			},
			multiple: false // Set to true to allow multiple files to be selected
		});
		console.log(buttonid);
		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			var attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here

			// Add preview image to dom
			if($('#wpbooklist-addbook-upload_image_button').attr('data-active') == 'true'){
				$( '#wpbooklist-addbook-image' ).val(attachment.url);
				$( '#wpbooklist-addbook-preview-img' ).attr('src', attachment.url);
				$('#wpbooklist-addbook-preview-img').attr('data-active', false);
			}

			// Add preview image to dom for storefront extension
			if($('#wpbooklist-storefront-img-button-1').attr('data-active') == 'true'){
				$( '#wpbooklist-storefront-preview-img-1' ).attr('src', attachment.url);
				$('#wpbooklist-storefront-img-button-1').attr('data-active', false);
			}

			// Add second preview image to dom for storefront extension
			if($('#wpbooklist-storefront-img-button-2').attr('data-active') == 'true'){
				$( '#wpbooklist-storefront-preview-img-2' ).attr('src', attachment.url);
				$('#wpbooklist-storefront-img-button-2').attr('data-active', false);
			}

			// Restore the main post ID
			wp.media.model.settings.post.id = wp_media_post_id;
		});
			// Finally, open the modal
			file_frame.open();
		});
		// Restore the main ID when the add media button is pressed
		jQuery( 'a.add_media' ).on( 'click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		});

		// When the Add A Book form submits
	  	$("#wpbooklist-addbook-form").submit(function(e){
	  		var successDiv = $('#wpbooklist-addbook-success-div');
	  		successDiv.html('');
	  		$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'40px'}, 500);
			$('#wpbooklist-success-view-post').animate({'opacity':'0'}, 500);

	  		e.preventDefault(e);
    		wpbooklist_add_book_validator();
    		var error = $('#wpbooklist-add-book-error-check').attr('data-add-book-form-error');

    		var amazonAuthYes = $( "input[name='authorize-amazon-yes']" ).prop('checked');
			var library = $('#wpbooklist-addbook-select-library').val();
			var useAmazonYes = $("input[name='use-amazon-yes']").prop('checked');
			var isbn = $( "input[name='book-isbn']" ).val();
			var title = $( "input[name='book-title']" ).val();
			var author = $( "input[name='book-author']" ).val();
			var authorUrl = $( "input[name='book-sale-author-link']" ).val();
			var category = $( "input[name='book-category']" ).val();
			var price = $( "input[name='book-price']" ).val();
			var pages = $( "input[name='book-pages']" ).val();
			var pubYear = $( "input[name='book-pubdate']" ).val();
			var publisher = $( "input[name='book-publisher']" ).val();
			var description = $( "textarea[name='book-description']" ).val();
			var notes = $( "textarea[name='book-notes']" ).val();
			var rating = $('#wpbooklist-addbook-rating').val();
			var image = $("input[name='book-image']").val();
			var finished = $("input[name='book-finished-yes']").prop('checked');
			var dateFinished = $("input[name='book-date-finished-text']").val();
			var signed = $("input[name='book-signed-yes']").prop('checked');
			var firstEdition = $("input[name='book-firstedition-yes']").prop('checked');
			var pageYes = $("input[name='book-indiv-page-yes']").prop('checked');
			var postYes = $("input[name='book-indiv-post-yes']").prop('checked');

			// Flipping the date
			if(dateFinished.indexOf('-')){
				var finishedtemp = dateFinished.split('-');
				var dateFinished = finishedtemp[1]+'-'+finishedtemp[2]+'-'+finishedtemp[0]
			}	

    		if(error === 'false'){
    			// Show working spinner
    			$('#wpbooklist-spinner-1').animate({'opacity':'1'}, 500);
    			
	    		var data = {
					'action': 'wpbooklist_dashboard_add_book_action',
					'security': '<?php echo wp_create_nonce( "wpbooklist_dashboard_add_book_action_callback" ); ?>',
					'amazonAuthYes':amazonAuthYes,
					'library':library,
					'useAmazonYes':useAmazonYes,
					'isbn':isbn,
					'title':title,
					'author':author,
					'authorUrl':authorUrl,
					'category':category,
					'price':price,
					'pages':pages,
					'pubYear':pubYear,
					'publisher':publisher,
					'description':description,
					'notes':notes,
					'rating':rating,
					'image':image,
					'finished':finished,
					'dateFinished':dateFinished,
					'signed':signed,
					'firstEdition':firstEdition,
					'pageYes':pageYes,
					'postYes':postYes
				};
				console.log(data);

		     	var request = $.ajax({
				    url: ajaxurl,
				    type: "POST",
				    data:data,
				    timeout: 0,
				    success: function(response) {
				    	response = response.split('sep');
				    	if(response[0] == 1){

				    		var addBookSuccess1 = '<p><span id="wpbooklist-add-book-success-span">Success!</span><br/> You\'ve just added a new book to your library! Remember, to display your library, simply place this shortcode on a page or post: <span id="wpbooklist-addbook-success-shortcode">'; 

				    		if(library.includes('wpbooklist_jre_saved_book_log')){
				    			var shortcode = '[wpbooklist_shortcode]'
				    		} else {
				    			library = library.split('_');
				    			library = library[library.length-1];
				    			var shortcode = '[wpbooklist_shortcode table="'+library+'"]'
				    		}
				    		
				    		var addBookSuccess2 = shortcode+'</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox">Click Here to View Your New Book</a>';

				    		var addBookSuccess3 = '';

				    		// If book addition was succesful and user chose to create a post
				    		if(response[4] == 'true' && response[3] == 'false'){
				    			var addBookSuccess3 = '<p id="wpbooklist-addbook-success-post-p"><a href="'+response[6]+'">Click Here to View This Book\'s Post</a></p></div>';
				    			$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'70px'}, 500);
				    			$('#wpbooklist-success-view-post').animate({'opacity':'1'}, 500);
				    		} 

				    		// If book addition was succesful and user chose to create a page
				    		if(response[3] == 'true' && response[4] == 'false'){
				    			var addBookSuccess3 = '<p id="wpbooklist-addbook-success-page-p"><a href="'+response[5]+'">Click Here to View This Book\'s Page</a></p></div>';
				    			$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'70px'}, 500);
				    			$('#wpbooklist-success-view-page').animate({'opacity':'1'}, 500);
				    		} 

				    		// If book addition was succesful and user chose to create a post and a page
				    		if(response[3] == 'true' && response[4] == 'true'){
				    			var addBookSuccess3 = '<p id="wpbooklist-addbook-success-page-p"><a href="'+response[5]+'">Click Here to View This Book\'s Page</a></p><p id="wpbooklist-addbook-success-post-p"><a href="'+response[6]+'">Click Here to View This Book\'s Post</a></p></div>';
				    			$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'100px'}, 500);
				    			$('#wpbooklist-success-view-page').animate({'opacity':'1'}, 500);
				    			$('#wpbooklist-success-view-post').animate({'opacity':'1'}, 500);
				    		} 

				    		// Add response message to DOM
				    		var endMessage = '<div id="wpbooklist-addbook-success-thanks">Thanks for using WPBookList, and <a href="http://wpbooklist.com/index.php/extensions/">be sure to check out the WPBookList Extensions!</a><br/><br/> If you happen to be thrilled with WPBookList, then by all means, <a id="wpbooklist-addbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5" >Feel Free to Leave a 5-Star Review Here!</a><img id="wpbooklist-smile-icon-1" src="<?php echo ROOT_IMG_ICONS_URL; ?>smile.png"></div>';
				    		successDiv.html(addBookSuccess1+addBookSuccess2+addBookSuccess3+endMessage);

				    		$('#wpbooklist-spinner-1').animate({'opacity':'0'}, 500);
				    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
				    		$('#wpbooklist-success-1').attr('data-bookid', response[1]);
				    		$('#wpbooklist-success-1').attr('data-booktable', response[2]);
				    	} else {
				    		$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'65px'}, 500);
				    		$('#wpbooklist-success-1').html('Whoops! Looks like there was an error trying to add your book! Please check the information you provided (especially that ISBN number), and try again.');
				    		$('#wpbooklist-spinner-1').animate({'opacity':'0'}, 500);
				    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
				    	}
				    },
					error: function(jqXHR, textStatus, errorThrown) {
						$('#wpbooklist-success-1').html('Whoops! Looks like there was an error trying to add your book! Please check the information you provided (especially that ISBN number), and try again.');
			    		$('#wpbooklist-spinner-1').animate({'opacity':'0'}, 500);
			    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
						console.log(errorThrown);
			            console.log(textStatus);
			            console.log(jqXHR);
			            // TODO: Log the console errors here
					}
				});
	     	}
	  	});
	});
	</script>
	<?php
}

// Callback function for adding a book 
function wpbooklist_dashboard_add_book_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_dashboard_add_book_action_callback', 'security' );
	$amazon_auth_yes = filter_var($_POST['amazonAuthYes'],FILTER_SANITIZE_STRING);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
	$use_amazon_yes = filter_var($_POST['useAmazonYes'],FILTER_SANITIZE_STRING);
	$isbn = filter_var($_POST['isbn'],FILTER_SANITIZE_STRING);
	$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
	$author = filter_var($_POST['author'],FILTER_SANITIZE_STRING);
	$author_url = filter_var($_POST['authorUrl'],FILTER_SANITIZE_URL);
	$category = filter_var($_POST['category'],FILTER_SANITIZE_STRING);
	$price = filter_var($_POST['price'],FILTER_SANITIZE_STRING);
	$pages = filter_var($_POST['pages'],FILTER_SANITIZE_STRING);
	$pub_year = filter_var($_POST['pubYear'],FILTER_SANITIZE_STRING);
	$publisher = filter_var($_POST['publisher'],FILTER_SANITIZE_STRING);
	$description = filter_var($_POST['description'],FILTER_SANITIZE_SPECIAL_CHARS);
	$notes = filter_var(htmlentities($_POST['notes']),FILTER_SANITIZE_STRING);
	$rating = filter_var($_POST['rating'],FILTER_SANITIZE_STRING);
	$image = filter_var($_POST['image'],FILTER_SANITIZE_URL);
	$finished = filter_var($_POST['finished'],FILTER_SANITIZE_STRING);
	$date_finished = filter_var($_POST['dateFinished'],FILTER_SANITIZE_STRING);
	$signed = filter_var($_POST['signed'],FILTER_SANITIZE_STRING);
	$first_edition = filter_var($_POST['firstEdition'],FILTER_SANITIZE_STRING);
	$page_yes = filter_var($_POST['pageYes'],FILTER_SANITIZE_STRING);
	$post_yes = filter_var($_POST['postYes'],FILTER_SANITIZE_STRING);
	$book_array = array(
		'amazon_auth_yes' => $amazon_auth_yes,
		'library' => $library,
		'use_amazon_yes' => $use_amazon_yes,
		'isbn' => $isbn,
		'title' => $title,
		'author' => $author,
		'author_url' => $author_url,
		'category' => $category,
		'price' => $price,
		'pages' => $pages,
		'pub_year' => $pub_year,
		'publisher' => $publisher,
		'description' => $description,
		'notes' => $notes,
		'rating' => $rating,
		'image' => $image,
		'finished' => $finished,
		'date_finished' => $date_finished,
		'signed' => $signed,
		'first_edition' => $first_edition,
		'page_yes' => $page_yes,
		'post_yes' => $post_yes,
	);

	require_once(CLASS_DIR.'class-book.php');
	$book_class = new WPBookList_Book('add', $book_array, null);
	$insert_result = $book_class->add_result;

	// If book added succesfully, get the ID of the book we just inserted, and return the result and that ID
	if($insert_result == 1){
		$book_table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
  		$id_result = $wpdb->get_var("SELECT MAX(ID) from $library");
  		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $library WHERE ID = %d", $id_result));

  		// Get saved page URL
		$table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  		$page_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s AND type = 'page'" , $row->book_uid));

  		// Get saved post URL
		$table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  		$post_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s AND type = 'post'", $row->book_uid));

  		echo $insert_result.'sep'.$id_result.'sep'.$library.'sep'.$page_yes.'sep'.$post_yes.'sep'.$page_results->post_url.'sep'.$post_results->post_url;
	}

	wp_die();
}


// Function for displaying a book in the colorbox window
function wpbooklist_show_book_in_colorbox_action_javascript() { 
	?>
  	<script type="text/javascript">
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click",".wpbooklist-show-book-colorbox", function(event){
  			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  		var bookId = $(this).attr('data-bookid');
	  		var bookTable = $(this).attr('data-booktable');

		  	var data = {
				'action': 'wpbooklist_show_book_in_colorbox_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_show_book_in_colorbox_action_callback" ); ?>',
				'bookId':bookId,
				'bookTable':bookTable
			};
			console.log(data);

			$.colorbox({
		        iframe:true,
		        title: "Loading, Please wait", 
		        width: "50%", 
		        height: "80%", 
		        html: "&nbsp;", 
		        fastIframe:false,
		        onComplete:function(){
		          $('#cboxLoadingGraphic').show();
		          $('#cboxLoadingGraphic').css({'display':'block'})
		        }
		    });

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	$.colorbox({
						open: true,
						preloading: true,
						scrolling: true,
						width:'70%',
						height:'70%',
						html: response,
						onClosed:function(){
						  //Do something on close.
						},
						onComplete:function(){

							// Hide blank 'Similar Titles' images
							$('.wpbooklist-similar-image').load(function() {
								var image = new Image();
								image.src = $(this).attr("src");
								if(image.naturalHeight == '1'){
									$(this).parent().parent().css({'display':'none'})
								}
							});
				        	
							var color = $('#wpbooklist_display_table_2 #wpbooklist_bold').css("color");
							var container = $('#wpbooklist_display_table_2 #wpbooklist_bold').first().parent();
							var color2 = container.css("background-color");
							var test = $('#wpbooklist_display_table_2 #wpbooklist_bold').first().attr('data-modifycolor');
							if( test != 'false' ){
							  console.log('inside!')
							  //color = wpbooklist_get_background_color(color, color2, container);
							}
							$('#wpbooklist_display_table_2 #wpbooklist_bold').css({'color':color});
							$('#wpbooklist_display_table_2 td').css({'color':color});
							$('.wpbooklist_desc_p_class').css({'color':color});
							$('.wpbooklist-share-text').css({'color':color});
							$('.wpbooklist-purchase-title').css({'color':color});

							addthis.toolbox(
							  $(".addthis_sharing_toolbox").get()
							);
							addthis.toolbox(
							  $(".addthis_sharing_toolbox").get()
							);
							addthis.counter(
							  $(".addthis_counter").get()
							);
						}
					});
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});
	  	});
	});
	</script>
	<?php
}

// Callback function for showing books in the colorbox window
function wpbooklist_show_book_in_colorbox_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_show_book_in_colorbox_action_callback', 'security' );
	$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_NUMBER_INT);
	$book_table = filter_var($_POST['bookTable'],FILTER_SANITIZE_STRING);

	// Double-check that Amazon review isn't expired
	require_once(CLASS_DIR.'class-book.php');
	$book = new WPBookList_Book($book_id, $book_table);
	$book->refresh_amazon_review($book_id, $book_table);

	// Instantiate the class that shows the book in colorbox
	require_once(CLASS_DIR.'class-show-book-in-colorbox.php');
	$colorbox = new WPBookList_Show_Book_In_Colorbox($book_id, $book_table);

	echo $colorbox->output;
	wp_die();
}


function wpbooklist_new_lib_shortcode_action_javascript() { ?>
 <script type="text/javascript">
 "use strict";
  jQuery(document).ready(function($) {
    $("#wpbooklist-dynamic-shortcode-button").click(function(event){
      var currentVal;
      currentVal = ($("#wpbooklist-dynamic-input-library").val()).toLowerCase();
      var data = {
        'action': 'wpbooklist_new_lib_shortcode_action',
        'currentval': currentVal,
        'security': '<?php echo wp_create_nonce( "wpbooklist-jre-ajax-nonce-newlib" ); ?>'
      };

      $.post(ajaxurl, data, function(response) {
        document.location.reload(true);
      });
    });

    $(document).on("click",".wpbooklist_delete_custom_lib", function(event){
      var table = $(this).attr('id');
      console.log(table);
      var data = {
        'action': 'wpbooklist_new_lib_shortcode_action',
        'table': table,
        'security': '<?php echo wp_create_nonce( "wpbooklist-jre-ajax-nonce-newlib" ); ?>'
      };
      $.post(ajaxurl, data, function(response) {
        document.location.reload(true);
      });
    });
  });
  </script> <?php
}

function wpbooklist_new_lib_shortcode_action_callback() {
  // Grabbing the existing options from DB
  global $wpdb;
  global $charset_collate;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  check_ajax_referer( 'wpbooklist-jre-ajax-nonce-newlib', 'security' );
  $table_name_dynamic = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
  $db_name;

  function wpbooklist_clean($string) {
      $string = str_replace(' ', '_', $string); // Replaces all spaces with underscores.
      $string = str_replace('-', '_', $string);
      return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }
 
  // Create a new custom table
  if(isset($_POST['currentval'])){
      $db_name = sanitize_text_field($_POST['currentval']);
      $db_name = wpbooklist_clean($db_name);
  }

  // Delete the table
  if(isset($_POST['table'])){ 
      $table = $wpdb->prefix."wpbooklist_jre_".sanitize_text_field($_POST['table']);
      $pos = strripos($table,"_");
      $table = substr($table, 0, $pos);
      echo $table;
      $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table", $table));

      $delete_from_list = sanitize_text_field($_POST['table']);
      $pos2 = strripos($delete_from_list,"_");
      $delete_id = substr($delete_from_list, ($pos2+1));
      $wpdb->delete( $table_name_dynamic, array( 'ID' => $delete_id ), array( '%d' ) );
         
      // Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
      $table_name_dynamic = str_replace('\'', '`', $table_name_dynamic);
      $wpdb->query($wpdb->prepare("ALTER TABLE %s MODIFY ID bigint(255) NOT NULL" , $table_name_dynamic));

      $query2 = $wpdb->prepare( "ALTER TABLE %s DROP PRIMARY KEY", $table_name_dynamic);
      $query2 = str_replace('\'', '`', $query2);
      $wpdb->query($wpdb->prepare($query2));

      // Adjusting ID values of remaining entries in database
      $my_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_dynamic", $table_name_dynamic ));
      $title_count = $wpdb->num_rows;

      for ($x = $delete_id ; $x <= $title_count; $x++) {
        $data = array(
            'ID' => $delete_id 
        );
        $format = array( '%s'); 
        $delete_id ++;  
        $where = array( 'ID' => ($delete_id ) );
        $where_format = array( '%d' );
        $wpdb->update( $table_name_dynamic, $data, $where, $format, $where_format );
      }  
        
      // Adding primary key back to database 
      $query3 = $wpdb->prepare( "ALTER TABLE %s ADD PRIMARY KEY (`ID`)", $table_name_dynamic);
      $query3 = str_replace('\'', '`', $query3);
      $wpdb->query($wpdb->prepare($query3));    

      $query4 = $wpdb->prepare( "ALTER TABLE %s MODIFY ID bigint(255) AUTO_INCREMENT", $table_name_dynamic);
      $query4 = str_replace('\'', '`', $query4);
      $wpdb->query($wpdb->prepare($query4));

      // Setting the AUTO_INCREMENT value based on number of remaining entries
      $title_count++;
      $query5 = $wpdb->prepare( "ALTER TABLE %s AUTO_INCREMENT=%d", $table_name_dynamic,$title_count);
      $query5 = str_replace('\'', '`', $query5);
      $wpdb->query($wpdb->prepare($query5));
      
  }

  if(isset($db_name)){
      if(($db_name != "")  ||  ($db_name != null)){
          $wpdb->wpbooklist_jre_dynamic_db_name = "{$wpdb->prefix}wpbooklist_jre_{$db_name}";
          $wpdb->wpbooklist_jre_dynamic_db_name_settings = "{$wpdb->prefix}wpbooklist_jre_settings_{$db_name}";
          $wpdb->wpbooklist_jre_list_dynamic_db_names = "{$wpdb->prefix}wpbooklist_jre_list_dynamic_db_names";
          $sql_create_table = "CREATE TABLE {$wpdb->wpbooklist_jre_dynamic_db_name} 
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
          dbDelta( $sql_create_table );


          $sql_create_table2 = "CREATE TABLE {$wpdb->wpbooklist_jre_dynamic_db_name_settings} 
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
		  dbDelta( $sql_create_table2 );

		  	$table_name = $wpdb->wpbooklist_jre_dynamic_db_name_settings;
  			$wpdb->insert( $table_name, array('ID' => 1));

          $wpdb->insert( $table_name_dynamic, array('user_table_name' => $db_name ));
      }
  }
      
  wp_die();
}

// function for saving library display options
function wpbooklist_dashboard_save_library_display_options_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-save-backend").click(function(event){

	  		var enablepurchase = $("input[name='enable-purchase-link']" ).prop('checked');
			var hidesearch = $("input[name='hide-search']" ).prop('checked');
			var hidefacebook = $("input[name='hide-facebook']" ).prop('checked');
			var hidetwitter = $("input[name='hide-twitter']" ).prop('checked');
			var hidegoogleplus = $("input[name='hide-googleplus']" ).prop('checked');
			var hidemessenger = $("input[name='hide-messenger']" ).prop('checked');
			var hidepinterest = $("input[name='hide-pinterest']" ).prop('checked');
			var hideemail = $("input[name='hide-email']" ).prop('checked');
			var hidestats = $("input[name='hide-stats']" ).prop('checked');
			var hidesortby = $("input[name='hide-sort-by']" ).prop('checked');
			var hidegoodreadswidget = $("input[name='hide-goodreads']" ).prop('checked');
			var hideamazonreview = $("input[name='hide-amazon-review']" ).prop('checked');
			var hidedescription = $("input[name='hide-description']" ).prop('checked');
			var hidesimilar = $("input[name='hide-similar']" ).prop('checked');
			var hidebooktitle = $("input[name='hide-book-title']" ).prop('checked');
			var hidebookimage = $("input[name='hide-book-image']" ).prop('checked');
			var hidefinished = $("input[name='hide-finished']" ).prop('checked');
			var hidelibrarytitle = $("input[name='hide-library-title']" ).prop('checked');
			var hideauthor = $("input[name='hide-author']" ).prop('checked');
			var hidecategory = $("input[name='hide-category']" ).prop('checked');
			var hidepages = $("input[name='hide-pages']" ).prop('checked');
			var hidebookpage = $("input[name='hide-book-page']" ).prop('checked');
			var hidebookpost = $("input[name='hide-book-post']" ).prop('checked');
			var hidepublisher = $("input[name='hide-publisher']" ).prop('checked');
			var hidepubdate = $("input[name='hide-pub-date']" ).prop('checked');
			var hidesigned = $("input[name='hide-signed']" ).prop('checked');
			var hidefirstedition = $("input[name='hide-first-edition']" ).prop('checked');
			var hidefeaturedtitles = $("input[name='hide-featured-titles']" ).prop('checked');
			var hidenotes = $("input[name='hide-notes']" ).prop('checked');
			var hidebottompurchase = $("input[name='hide-bottom-purchase']" ).prop('checked');
			var hidequotebook = $("input[name='hide-quote-book']" ).prop('checked');
			var hidequote = $("input[name='hide-quote']" ).prop('checked');
			var hideratingbook = $("input[name='hide-rating-book']" ).prop('checked');
			var hiderating = $("input[name='hide-rating']" ).prop('checked');
			var hidegooglepurchase = $("input[name='hide-google-purchase']" ).prop('checked');
			var hideamazonpurchase = $("input[name='hide-amazon-purchase']" ).prop('checked');
			var hidebnpurchase = $("input[name='hide-bn-purchase']" ).prop('checked');
			var hideitunespurchase = $("input[name='hide-itunes-purchase']" ).prop('checked');
			var hidefrontendbuyimg = $("input[name='hide-frontend-buy-img']" ).prop('checked');
			var hidefrontendbuyprice = $("input[name='hide-frontend-buy-price']" ).prop('checked');
			var hidecolorboxbuyimg = $("input[name='hide-colorbox-buy-img']" ).prop('checked');
			var hidecolorboxbuyprice = $("input[name='hide-colorbox-buy-price']" ).prop('checked');
			var sortoption = $("#wpbooklist-jre-sorting-select" ).val();
			var booksonpage = $("input[name='books-per-page']").val();
			var library = $("#wpbooklist-library-settings-select").val();

		  	var data = {
				'action': 'wpbooklist_dashboard_save_library_display_options_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_dashboard_save_library_display_options_action_callback" ); ?>',
				'enablepurchase' : enablepurchase,
				'hidesearch' : hidesearch,
				'hidefacebook' : hidefacebook,
				'hidetwitter' : hidetwitter,
				'hidegoogleplus' : hidegoogleplus,
				'hidemessenger' : hidemessenger,
				'hidepinterest' : hidepinterest,
				'hideemail' : hideemail,
				'hidestats' : hidestats,
				'hidesortby' : hidesortby,
				'hidegoodreadswidget' : hidegoodreadswidget,
				'hideamazonreview' : hideamazonreview,
				'hidedescription' : hidedescription,
				'hidesimilar' : hidesimilar,
				'hidebooktitle': hidebooktitle,
				'hidebookimage' : hidebookimage,
				'hidefinished': hidefinished,
				'hidelibrarytitle': hidelibrarytitle,
				'hideauthor': hideauthor,
				'hidecategory': hidecategory,
				'hidepages': hidepages,
				'hidebookpage': hidebookpage,
				'hidebookpost': hidebookpost,
				'hidepublisher': hidepublisher,
				'hidepubdate': hidepubdate,
				'hidesigned': hidesigned,
				'hidefirstedition': hidefirstedition,
				'hidefeaturedtitles' : hidefeaturedtitles,
				'hidenotes' : hidenotes,
				'hidebottompurchase' : hidebottompurchase,
				'hidequotebook' : hidequotebook,
				'hidequote' : hidequote,
				'hideratingbook' : hideratingbook,
				'hiderating' : hiderating,
				'hidegooglepurchase' : hidegooglepurchase,
				'hideamazonpurchase' : hideamazonpurchase,
				'hidebnpurchase' : hidebnpurchase,
				'hideitunespurchase' : hideitunespurchase,
				'hidefrontendbuyimg' : hidefrontendbuyimg,
				'hidecolorboxbuyimg' : hidecolorboxbuyimg,
				'hidecolorboxbuyprice' : hidecolorboxbuyprice,
				'hidefrontendbuyprice' : hidefrontendbuyprice,
				'sortoption' : sortoption,
				'booksonpage' : booksonpage,
				'library': library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload(true);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving library display options
function wpbooklist_dashboard_save_library_display_options_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_dashboard_save_library_display_options_action_callback', 'security' );

	$enablepurchase = filter_var($_POST['enablepurchase'],FILTER_SANITIZE_STRING);
	$hidesearch = filter_var($_POST['hidesearch'],FILTER_SANITIZE_STRING);
	$hidefacebook = filter_var($_POST['hidefacebook'],FILTER_SANITIZE_STRING);
	$hidetwitter = filter_var($_POST['hidetwitter'],FILTER_SANITIZE_STRING);
	$hidegoogleplus = filter_var($_POST['hidegoogleplus'],FILTER_SANITIZE_STRING);
	$hidemessenger = filter_var($_POST['hidemessenger'],FILTER_SANITIZE_STRING);
	$hidepinterest = filter_var($_POST['hidepinterest'],FILTER_SANITIZE_STRING);
	$hideemail = filter_var($_POST['hideemail'],FILTER_SANITIZE_STRING);
	$hidestats = filter_var($_POST['hidestats'],FILTER_SANITIZE_STRING);
	$hidesortby = filter_var($_POST['hidesortby'],FILTER_SANITIZE_STRING);
	$hidegoodreadswidget = filter_var($_POST['hidegoodreadswidget'],FILTER_SANITIZE_STRING);
	$hideamazonreview = filter_var($_POST['hideamazonreview'],FILTER_SANITIZE_STRING);
	$hidedescription = filter_var($_POST['hidedescription'],FILTER_SANITIZE_STRING);
	$hidesimilar = filter_var($_POST['hidesimilar'],FILTER_SANITIZE_STRING);
	$hidebooktitle = filter_var($_POST['hidebooktitle'],FILTER_SANITIZE_STRING);
	$hidebookimage = filter_var($_POST['hidebookimage'],FILTER_SANITIZE_STRING);
	$hidefinished = filter_var($_POST['hidefinished'],FILTER_SANITIZE_STRING);
	$hidelibrarytitle = filter_var($_POST['hidelibrarytitle'],FILTER_SANITIZE_STRING);
	$hideauthor = filter_var($_POST['hideauthor'],FILTER_SANITIZE_STRING);
	$hidecategory = filter_var($_POST['hidecategory'],FILTER_SANITIZE_STRING);
	$hidepages = filter_var($_POST['hidepages'],FILTER_SANITIZE_STRING);
	$hidebookpage = filter_var($_POST['hidebookpage'],FILTER_SANITIZE_STRING);
	$hidebookpost = filter_var($_POST['hidebookpost'],FILTER_SANITIZE_STRING);	
	$hidepublisher = filter_var($_POST['hidepublisher'],FILTER_SANITIZE_STRING);
	$hidepubdate = filter_var($_POST['hidepubdate'],FILTER_SANITIZE_STRING);
	$hidesigned = filter_var($_POST['hidesigned'],FILTER_SANITIZE_STRING);
	$hidefirstedition= filter_var($_POST['hidefirstedition'],FILTER_SANITIZE_STRING); 
	$hidefeaturedtitles = filter_var($_POST['hidefeaturedtitles'],FILTER_SANITIZE_STRING);
	$hidenotes = filter_var($_POST['hidenotes'],FILTER_SANITIZE_STRING);
	$hidebottompurchase = filter_var($_POST['hidebottompurchase'],FILTER_SANITIZE_STRING);
	$hidequotebook = filter_var($_POST['hidequotebook'],FILTER_SANITIZE_STRING);
	$hidequote = filter_var($_POST['hidequote'],FILTER_SANITIZE_STRING);
	$hideratingbook = filter_var($_POST['hideratingbook'],FILTER_SANITIZE_STRING);
	$hiderating = filter_var($_POST['hiderating'],FILTER_SANITIZE_STRING);
	$hidegooglepurchase = filter_var($_POST['hidegooglepurchase'],FILTER_SANITIZE_STRING);
	$hideamazonpurchase = filter_var($_POST['hideamazonpurchase'],FILTER_SANITIZE_STRING);
	$hidebnpurchase = filter_var($_POST['hidebnpurchase'],FILTER_SANITIZE_STRING);
	$hideitunespurchase = filter_var($_POST['hideitunespurchase'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyimg = filter_var($_POST['hidefrontendbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyimg = filter_var($_POST['hidecolorboxbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyprice = filter_var($_POST['hidecolorboxbuyprice'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyprice = filter_var($_POST['hidefrontendbuyprice'],FILTER_SANITIZE_STRING);
	$sortoption = filter_var($_POST['sortoption'],FILTER_SANITIZE_STRING);
	$booksonpage = filter_var($_POST['booksonpage'], FILTER_SANITIZE_NUMBER_INT);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	$settings_array = array(
		'enablepurchase' => $enablepurchase,
		'hidesearch' => $hidesearch,
		'hidefacebook' => $hidefacebook,
		'hidetwitter' => $hidetwitter,
		'hidegoogleplus' => $hidegoogleplus,
		'hidemessenger' => $hidemessenger,
		'hidepinterest' => $hidepinterest,
		'hideemail' => $hideemail,
		'hidestats' => $hidestats,
		'hidequote' => $hidequote,
		'hidesortby' => $hidesortby,
		'hidegoodreadswidget' => $hidegoodreadswidget,
		'hideamazonreview' => $hideamazonreview,
		'hidedescription' => $hidedescription,
		'hidesimilar' => $hidesimilar,
		'hidebooktitle'=> $hidebooktitle,
		'hidebookimage' => $hidebookimage,
		'hidefinished'=> $hidefinished,
		'hidelibrarytitle'=> $hidelibrarytitle,
		'hideauthor'=> $hideauthor,
		'hidecategory'=> $hidecategory,
		'hidepages'=> $hidepages,
		'hidebookpage'=> $hidebookpage,
		'hidebookpost'=> $hidebookpost,
		'hidepublisher'=> $hidepublisher,
		'hidepubdate'=> $hidepubdate,
		'hidesigned'=> $hidesigned,
		'hidefirstedition'=> $hidefirstedition,
		'hidefeaturedtitles' => $hidefeaturedtitles,
		'hidenotes' => $hidenotes,
		'hidebottompurchase' => $hidebottompurchase,
		'hidequotebook' => $hidequotebook,
		'hiderating' => $hiderating,
		'hideratingbook' => $hideratingbook,
		'hidegooglepurchase' => $hidegooglepurchase,
		'hideamazonpurchase' => $hideamazonpurchase,
		'hidebnpurchase' => $hidebnpurchase,
		'hideitunespurchase' => $hideitunespurchase,
		'hidefrontendbuyimg' => $hidefrontendbuyimg,
		'hidecolorboxbuyimg' => $hidecolorboxbuyimg,
		'hidecolorboxbuyprice' => $hidecolorboxbuyprice,
		'hidefrontendbuyprice' => $hidefrontendbuyprice,
		'sortoption' => $sortoption,
		'booksonpage' => $booksonpage
	);

	require_once(CLASS_DIR.'class-display-options.php');
	$settings_class = new WPBookList_Display_Options();
	$settings_class->save_library_settings($library, $settings_array);
	wp_die();
}

// function for saving post display options
function wpbooklist_dashboard_save_post_display_options_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-save-post-backend").click(function(event){

	  		var enablepurchase = $("input[name='enable-purchase-link']" ).prop('checked');
			var hidefacebook = $("input[name='hide-facebook']" ).prop('checked');
			var hidetwitter = $("input[name='hide-twitter']" ).prop('checked');
			var hidegoogleplus = $("input[name='hide-googleplus']" ).prop('checked');
			var hidemessenger = $("input[name='hide-messenger']" ).prop('checked');
			var hidepinterest = $("input[name='hide-pinterest']" ).prop('checked');
			var hideemail = $("input[name='hide-email']" ).prop('checked');
			var hideamazonreview = $("input[name='hide-amazon-review']" ).prop('checked');
			var hidedescription = $("input[name='hide-description']" ).prop('checked');
			var hidesimilar = $("input[name='hide-similar']" ).prop('checked');
			var hidetitle = $("input[name='hide-book-title']" ).prop('checked');
			var hidebookimage = $("input[name='hide-book-image']" ).prop('checked');
			var hidefinished = $("input[name='hide-finished']" ).prop('checked');
			var hideauthor = $("input[name='hide-author']" ).prop('checked');
			var hidecategory = $("input[name='hide-category']" ).prop('checked');
			var hidepages = $("input[name='hide-pages']" ).prop('checked');
			var hidepublisher = $("input[name='hide-publisher']" ).prop('checked');
			var hidepubdate = $("input[name='hide-pub-date']" ).prop('checked');
			var hidesigned = $("input[name='hide-signed']" ).prop('checked');
			var hidefirstedition = $("input[name='hide-first-edition']" ).prop('checked');
			var hidefeaturedtitles = $("input[name='hide-featured-titles']" ).prop('checked');
			var hidenotes = $("input[name='hide-notes']" ).prop('checked');
			var hidequote = $("input[name='hide-quote']" ).prop('checked');
			var hiderating = $("input[name='hide-rating']" ).prop('checked');
			var hidegooglepurchase = $("input[name='hide-google-purchase']" ).prop('checked');
			var hideamazonpurchase = $("input[name='hide-amazon-purchase']" ).prop('checked');
			var hidebnpurchase = $("input[name='hide-bn-purchase']" ).prop('checked');
			var hideitunespurchase = $("input[name='hide-itunes-purchase']" ).prop('checked');
			var hidefrontendbuyimg = $("input[name='hide-frontend-buy-img']" ).prop('checked');
			var hidecolorboxbuyimg = $("input[name='hide-colorbox-buy-img']" ).prop('checked');
			var hidecolorboxbuyprice = $("input[name='hide-colorbox-buy-price']" ).prop('checked');
			var hidefrontendbuyprice = $("input[name='hide-frontend-buy-price']" ).prop('checked');
		  	var data = {
				'action': 'wpbooklist_dashboard_save_post_display_options_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_dashboard_save_post_display_options_action_callback" ); ?>',
				'enablepurchase' : enablepurchase,
				'hidefacebook' : hidefacebook,
				'hidetwitter' : hidetwitter,
				'hidegoogleplus' : hidegoogleplus,
				'hidemessenger' : hidemessenger,
				'hidepinterest' : hidepinterest,
				'hideemail' : hideemail,
				'hideamazonreview' : hideamazonreview,
				'hidedescription' : hidedescription,
				'hidesimilar' : hidesimilar,
				'hidetitle': hidetitle,
				'hidebookimage' : hidebookimage,
				'hidefinished': hidefinished,
				'hideauthor': hideauthor,
				'hidecategory': hidecategory,
				'hidepages': hidepages,
				'hidepublisher': hidepublisher,
				'hidepubdate': hidepubdate,
				'hidesigned': hidesigned,
				'hidefirstedition': hidefirstedition,
				'hidefeaturedtitles' : hidefeaturedtitles,
				'hidenotes' : hidenotes,
				'hidequote' : hidequote,
				'hiderating' : hiderating,
				'hidegooglepurchase' : hidegooglepurchase,
				'hideamazonpurchase' : hideamazonpurchase,
				'hidebnpurchase' : hidebnpurchase,
				'hideitunespurchase' : hideitunespurchase,
				'hidefrontendbuyimg' : hidefrontendbuyimg,
				'hidecolorboxbuyimg' : hidecolorboxbuyimg,
				'hidecolorboxbuyprice' : hidecolorboxbuyprice,
				'hidefrontendbuyprice' : hidefrontendbuyprice,
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload(true);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving post display options
function wpbooklist_dashboard_save_post_display_options_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_dashboard_save_post_display_options_action_callback', 'security' );

	$enablepurchase = filter_var($_POST['enablepurchase'],FILTER_SANITIZE_STRING);
	$hidefacebook = filter_var($_POST['hidefacebook'],FILTER_SANITIZE_STRING);
	$hidetwitter = filter_var($_POST['hidetwitter'],FILTER_SANITIZE_STRING);
	$hidegoogleplus = filter_var($_POST['hidegoogleplus'],FILTER_SANITIZE_STRING);
	$hidemessenger = filter_var($_POST['hidemessenger'],FILTER_SANITIZE_STRING);
	$hidepinterest = filter_var($_POST['hidepinterest'],FILTER_SANITIZE_STRING);
	$hideemail = filter_var($_POST['hideemail'],FILTER_SANITIZE_STRING);
	$hideamazonreview = filter_var($_POST['hideamazonreview'],FILTER_SANITIZE_STRING);
	$hidedescription = filter_var($_POST['hidedescription'],FILTER_SANITIZE_STRING);
	$hidesimilar = filter_var($_POST['hidesimilar'],FILTER_SANITIZE_STRING);
	$hidetitle = filter_var($_POST['hidetitle'],FILTER_SANITIZE_STRING);
	$hidebookimage = filter_var($_POST['hidebookimage'],FILTER_SANITIZE_STRING);
	$hidefinished = filter_var($_POST['hidefinished'],FILTER_SANITIZE_STRING);
	$hideauthor = filter_var($_POST['hideauthor'],FILTER_SANITIZE_STRING);
	$hidecategory = filter_var($_POST['hidecategory'],FILTER_SANITIZE_STRING);
	$hidepages = filter_var($_POST['hidepages'],FILTER_SANITIZE_STRING);
	$hidepublisher = filter_var($_POST['hidepublisher'],FILTER_SANITIZE_STRING);
	$hidepubdate = filter_var($_POST['hidepubdate'],FILTER_SANITIZE_STRING);
	$hidesigned = filter_var($_POST['hidesigned'],FILTER_SANITIZE_STRING);
	$hidefirstedition= filter_var($_POST['hidefirstedition'],FILTER_SANITIZE_STRING); 
	$hidefeaturedtitles = filter_var($_POST['hidefeaturedtitles'],FILTER_SANITIZE_STRING);
	$hidenotes = filter_var($_POST['hidenotes'],FILTER_SANITIZE_STRING);
	$hidequote = filter_var($_POST['hidequote'],FILTER_SANITIZE_STRING);
	$hiderating = filter_var($_POST['hiderating'],FILTER_SANITIZE_STRING);
	$hidegooglepurchase = filter_var($_POST['hidegooglepurchase'],FILTER_SANITIZE_STRING);
	$hideamazonpurchase = filter_var($_POST['hideamazonpurchase'],FILTER_SANITIZE_STRING);
	$hidebnpurchase = filter_var($_POST['hidebnpurchase'],FILTER_SANITIZE_STRING);
	$hideitunespurchase = filter_var($_POST['hideitunespurchase'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyimg = filter_var($_POST['hidefrontendbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyimg = filter_var($_POST['hidecolorboxbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyprice = filter_var($_POST['hidecolorboxbuyprice'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyprice = filter_var($_POST['hidefrontendbuyprice'],FILTER_SANITIZE_STRING);

	$settings_array = array(
		'enablepurchase' => $enablepurchase,
		'hidefacebook' => $hidefacebook,
		'hidetwitter' => $hidetwitter,
		'hidegoogleplus' => $hidegoogleplus,
		'hidemessenger' => $hidemessenger,
		'hidepinterest' => $hidepinterest,
		'hideemail' => $hideemail,
		'hidequote' => $hidequote,
		'hideamazonreview' => $hideamazonreview,
		'hidedescription' => $hidedescription,
		'hidesimilar' => $hidesimilar,
		'hidetitle'=> $hidetitle,
		'hidebookimage' => $hidebookimage,
		'hidefinished'=> $hidefinished,
		'hideauthor'=> $hideauthor,
		'hidecategory'=> $hidecategory,
		'hidepages'=> $hidepages,
		'hidepublisher'=> $hidepublisher,
		'hidepubdate'=> $hidepubdate,
		'hidesigned'=> $hidesigned,
		'hidefirstedition'=> $hidefirstedition,
		'hidefeaturedtitles' => $hidefeaturedtitles,
		'hidenotes' => $hidenotes,
		'hiderating' => $hiderating,
		'hidegooglepurchase' => $hidegooglepurchase,
		'hideamazonpurchase' => $hideamazonpurchase,
		'hidebnpurchase' => $hidebnpurchase,
		'hideitunespurchase' => $hideitunespurchase,
		'hidefrontendbuyimg' => $hidefrontendbuyimg,
		'hidecolorboxbuyimg' => $hidecolorboxbuyimg,
		'hidecolorboxbuyprice' => $hidecolorboxbuyprice,
		'hidefrontendbuyprice' => $hidefrontendbuyprice,
	);

	require_once(CLASS_DIR.'class-display-options.php');
	$settings_class = new WPBookList_Display_Options();
	$settings_class->save_post_settings($settings_array);
	wp_die();
}


// function for saving page display options
function wpbooklist_dashboard_save_page_display_options_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-save-page-backend").click(function(event){

	  		var enablepurchase = $("input[name='enable-purchase-link']" ).prop('checked');
			var hidefacebook = $("input[name='hide-facebook']" ).prop('checked');
			var hidetwitter = $("input[name='hide-twitter']" ).prop('checked');
			var hidegoogleplus = $("input[name='hide-googleplus']" ).prop('checked');
			var hidemessenger = $("input[name='hide-messenger']" ).prop('checked');
			var hidepinterest = $("input[name='hide-pinterest']" ).prop('checked');
			var hideemail = $("input[name='hide-email']" ).prop('checked');
			var hideamazonreview = $("input[name='hide-amazon-review']" ).prop('checked');
			var hidedescription = $("input[name='hide-description']" ).prop('checked');
			var hidesimilar = $("input[name='hide-similar']" ).prop('checked');
			var hidetitle = $("input[name='hide-book-title']" ).prop('checked');
			var hidebookimage = $("input[name='hide-book-image']" ).prop('checked');
			var hidefinished = $("input[name='hide-finished']" ).prop('checked');
			var hideauthor = $("input[name='hide-author']" ).prop('checked');
			var hidecategory = $("input[name='hide-category']" ).prop('checked');
			var hidepages = $("input[name='hide-pages']" ).prop('checked');
			var hidepublisher = $("input[name='hide-publisher']" ).prop('checked');
			var hidepubdate = $("input[name='hide-pub-date']" ).prop('checked');
			var hidesigned = $("input[name='hide-signed']" ).prop('checked');
			var hidefirstedition = $("input[name='hide-first-edition']" ).prop('checked');
			var hidefeaturedtitles = $("input[name='hide-featured-titles']" ).prop('checked');
			var hidenotes = $("input[name='hide-notes']" ).prop('checked');
			var hidequote = $("input[name='hide-quote']" ).prop('checked');
			var hiderating = $("input[name='hide-rating']" ).prop('checked');
			var hidegooglepurchase = $("input[name='hide-google-purchase']" ).prop('checked');
			var hideamazonpurchase = $("input[name='hide-amazon-purchase']" ).prop('checked');
			var hidebnpurchase = $("input[name='hide-bn-purchase']" ).prop('checked');
			var hideitunespurchase = $("input[name='hide-itunes-purchase']" ).prop('checked');
			var hidefrontendbuyimg = $("input[name='hide-frontend-buy-img']" ).prop('checked');
			var hidecolorboxbuyimg = $("input[name='hide-colorbox-buy-img']" ).prop('checked');
			var hidecolorboxbuyprice = $("input[name='hide-colorbox-buy-price']" ).prop('checked');
			var hidefrontendbuyprice = $("input[name='hide-frontend-buy-price']" ).prop('checked');

		  	var data = {
				'action': 'wpbooklist_dashboard_save_page_display_options_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_dashboard_save_page_display_options_action_callback" ); ?>',
				'enablepurchase' : enablepurchase,
				'hidefacebook' : hidefacebook,
				'hidetwitter' : hidetwitter,
				'hidegoogleplus' : hidegoogleplus,
				'hidemessenger' : hidemessenger,
				'hidepinterest' : hidepinterest,
				'hideemail' : hideemail,
				'hideamazonreview' : hideamazonreview,
				'hidedescription' : hidedescription,
				'hidesimilar' : hidesimilar,
				'hidetitle': hidetitle,
				'hidebookimage' : hidebookimage,
				'hidefinished': hidefinished,
				'hideauthor': hideauthor,
				'hidecategory': hidecategory,
				'hidepages': hidepages,
				'hidepublisher': hidepublisher,
				'hidepubdate': hidepubdate,
				'hidesigned': hidesigned,
				'hidefirstedition': hidefirstedition,
				'hidefeaturedtitles' : hidefeaturedtitles,
				'hidenotes' : hidenotes,
				'hidequote' : hidequote,
				'hiderating' : hiderating,
				'hidegooglepurchase' : hidegooglepurchase,
				'hideamazonpurchase' : hideamazonpurchase,
				'hidebnpurchase' : hidebnpurchase,
				'hideitunespurchase' : hideitunespurchase,
				'hidefrontendbuyimg' : hidefrontendbuyimg,
				'hidecolorboxbuyimg' : hidecolorboxbuyimg,
				'hidecolorboxbuyprice' : hidecolorboxbuyprice,
				'hidefrontendbuyprice' : hidefrontendbuyprice,
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload(true);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving page display options
function wpbooklist_dashboard_save_page_display_options_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_dashboard_save_page_display_options_action_callback', 'security' );

	$enablepurchase = filter_var($_POST['enablepurchase'],FILTER_SANITIZE_STRING);
	$hidefacebook = filter_var($_POST['hidefacebook'],FILTER_SANITIZE_STRING);
	$hidetwitter = filter_var($_POST['hidetwitter'],FILTER_SANITIZE_STRING);
	$hidegoogleplus = filter_var($_POST['hidegoogleplus'],FILTER_SANITIZE_STRING);
	$hidemessenger = filter_var($_POST['hidemessenger'],FILTER_SANITIZE_STRING);
	$hidepinterest = filter_var($_POST['hidepinterest'],FILTER_SANITIZE_STRING);
	$hideemail = filter_var($_POST['hideemail'],FILTER_SANITIZE_STRING);
	$hideamazonreview = filter_var($_POST['hideamazonreview'],FILTER_SANITIZE_STRING);
	$hidedescription = filter_var($_POST['hidedescription'],FILTER_SANITIZE_STRING);
	$hidesimilar = filter_var($_POST['hidesimilar'],FILTER_SANITIZE_STRING);
	$hidetitle = filter_var($_POST['hidetitle'],FILTER_SANITIZE_STRING);
	$hidebookimage = filter_var($_POST['hidebookimage'],FILTER_SANITIZE_STRING);
	$hidefinished = filter_var($_POST['hidefinished'],FILTER_SANITIZE_STRING);
	$hideauthor = filter_var($_POST['hideauthor'],FILTER_SANITIZE_STRING);
	$hidecategory = filter_var($_POST['hidecategory'],FILTER_SANITIZE_STRING);
	$hidepages = filter_var($_POST['hidepages'],FILTER_SANITIZE_STRING);
	$hidepublisher = filter_var($_POST['hidepublisher'],FILTER_SANITIZE_STRING);
	$hidepubdate = filter_var($_POST['hidepubdate'],FILTER_SANITIZE_STRING);
	$hidesigned = filter_var($_POST['hidesigned'],FILTER_SANITIZE_STRING);
	$hidefirstedition= filter_var($_POST['hidefirstedition'],FILTER_SANITIZE_STRING); 
	$hidefeaturedtitles = filter_var($_POST['hidefeaturedtitles'],FILTER_SANITIZE_STRING);
	$hidenotes = filter_var($_POST['hidenotes'],FILTER_SANITIZE_STRING);
	$hidequote = filter_var($_POST['hidequote'],FILTER_SANITIZE_STRING);
	$hiderating = filter_var($_POST['hiderating'],FILTER_SANITIZE_STRING);
	$hidegooglepurchase = filter_var($_POST['hidegooglepurchase'],FILTER_SANITIZE_STRING);
	$hideamazonpurchase = filter_var($_POST['hideamazonpurchase'],FILTER_SANITIZE_STRING);
	$hidebnpurchase = filter_var($_POST['hidebnpurchase'],FILTER_SANITIZE_STRING);
	$hideitunespurchase = filter_var($_POST['hideitunespurchase'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyimg = filter_var($_POST['hidefrontendbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyimg = filter_var($_POST['hidecolorboxbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyprice = filter_var($_POST['hidecolorboxbuyprice'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyprice = filter_var($_POST['hidefrontendbuyprice'],FILTER_SANITIZE_STRING);

	$settings_array = array(
		'enablepurchase' => $enablepurchase,
		'hidefacebook' => $hidefacebook,
		'hidetwitter' => $hidetwitter,
		'hidegoogleplus' => $hidegoogleplus,
		'hidemessenger' => $hidemessenger,
		'hidepinterest' => $hidepinterest,
		'hideemail' => $hideemail,
		'hidequote' => $hidequote,
		'hideamazonreview' => $hideamazonreview,
		'hidedescription' => $hidedescription,
		'hidesimilar' => $hidesimilar,
		'hidetitle'=> $hidetitle,
		'hidebookimage' => $hidebookimage,
		'hidefinished'=> $hidefinished,
		'hideauthor'=> $hideauthor,
		'hidecategory'=> $hidecategory,
		'hidepages'=> $hidepages,
		'hidepublisher'=> $hidepublisher,
		'hidepubdate'=> $hidepubdate,
		'hidesigned'=> $hidesigned,
		'hidefirstedition'=> $hidefirstedition,
		'hidefeaturedtitles' => $hidefeaturedtitles,
		'hidenotes' => $hidenotes,
		'hiderating' => $hiderating,
		'hidegooglepurchase' => $hidegooglepurchase,
		'hideamazonpurchase' => $hideamazonpurchase,
		'hidebnpurchase' => $hidebnpurchase,
		'hideitunespurchase' => $hideitunespurchase,
		'hidefrontendbuyimg' => $hidefrontendbuyimg,
		'hidecolorboxbuyimg' => $hidecolorboxbuyimg,
		'hidecolorboxbuyprice' => $hidecolorboxbuyprice,
		'hidefrontendbuyprice' => $hidefrontendbuyprice,
	);

	require_once(CLASS_DIR.'class-display-options.php');
	$settings_class = new WPBookList_Display_Options();
	$settings_class->save_page_settings($settings_array);
	wp_die();
}









































































function wpbooklist_update_display_options_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-library-settings-select").on('change', function(event){

	  		var optionsTable = $('#wpbooklist-jre-backend-options-table');
	  		var lowerTable = $('#wpbooklist-library-options-lower-table');
	  		var lowerTableInput = $('#wpbooklist-library-options-lower-table input');
	  		var optionsTableInput = $('#wpbooklist-jre-backend-options-table input');
	  		var spinner = $('#wpbooklist-spinner-2');
	  		var library = $('#wpbooklist-library-settings-select').val();
	  		var saveChanges = $('#wpbooklist-save-backend');
	  		spinner.animate({'opacity':'1'}, 200);
	  		optionsTable.animate({'opacity':'0.3'}, 500);
	  		lowerTable.animate({'opacity':'0.3'}, 500);
	  		lowerTable.animate({'opacity':'0.3'}, 500);
	  		saveChanges.animate({'opacity':'0.3'}, 500);
	  		saveChanges.attr('disabled', true);
	  		lowerTableInput.attr('disabled', true);

	  		var settingsArray = {
				'enablepurchase' : 'enable-purchase-link',
				'hidesearch' : 'hide-search',
				'hidefacebook' : 'hide-facebook',
				'hidetwitter' : 'hide-twitter',
				'hidegoogleplus' : 'hide-googleplus',
				'hidemessenger' : 'hide-messenger',
				'hidepinterest' : 'hide-pinterest',
				'hideemail' : 'hide-email',
				'hidestats' : 'hide-stats',
				'hidesortby' : 'hide-sort-by',
				'hidegoodreadswidget' : 'hide-goodreads',
				'hideamazonreview' : 'hide-amazon-review',
				'hidedescription' : 'hide-description',
				'hidesimilar' : 'hide-similar',
				'hidebooktitle' : 'hide-book-title',
				'hidebookimage'  : 'hide-book-image',
				'hidefinished' : 'hide-finished',
				'hidelibrarytitle' : 'hide-library-title',
				'hideauthor' : 'hide-author',
				'hidecategory' : 'hide-category',
				'hidepages' : 'hide-pages',
				'hidebookpage' : 'hide-book-page',
				'hidebookpost' : 'hide-book-post',
				'hidepublisher' : 'hide-publisher',
				'hidepubdate' : 'hide-pub-date',
				'hidesigned' : 'hide-signed',
				'hidefirstedition' : 'hide-first-edition',
				'hidefeaturedtitles' : 'hide-featured-titles',
				'hidenotes' : 'hide-notes',
				'hidebottompurchase' : 'hide-bottom-purchase',
				'hidequotebook' : 'hide-quote-book',
				'hidequote' : 'hide-quote',
				'hideratingbook' : 'hide-rating-book',
				'hiderating' : 'hide-rating',
				'hidegooglepurchase' : 'hide-google-purchase',
				'hideamazonpurchase' : 'hide-amazon-purchase',
				'hidebnpurchase' : 'hide-bn-purchase',
				'hideitunespurchase' : 'hide-itunes-purchase',
				'hidefrontendbuyimg' : 'hide-frontend-buy-img',
				'hidecolorboxbuyimg' : 'hide-colorbox-buy-img',
				'hidecolorboxbuyprice' : 'hide-colorbox-buy-price',
				'hidefrontendbuyprice' : 'hide-frontend-buy-price',
				'sortoption' : 'sortoption',
				'booksonpage' : 'booksonpage',
				'library': 'library',
				'booksonpage': 'books-per-page'
			};

			console.log(settingsArray);

		  	var data = {
				'action': 'wpbooklist_update_display_options_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_update_display_options_action_callback" ); ?>',
				'library':library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = JSON.parse(response);
			    	console.log(response)
			    	optionsTable.animate({'opacity':'1'}, 500);
			    	lowerTable.animate({'opacity':'1'}, 500);
			    	saveChanges.animate({'opacity':'1'}, 500);
	  				saveChanges.attr('disabled', false);
			    	optionsTableInput.attr('disabled', false);
			    	lowerTableInput.attr('disabled', false);
			    	spinner.animate({'opacity':'0'}, 200);
			    	for (var key in response) {
					  if (response.hasOwnProperty(key)) {
					  	if(response[key] == 1){
					  		var obj = $( "input[name='"+settingsArray[key]+"']" ).prop('checked', true);
					  	}

					  	if(response[key] == 0 || response[key] == null){
					  		var obj = $( "input[name='"+settingsArray[key]+"']" ).prop('checked', false);
					  	}

					  	if(key == 'booksonpage'){
					  		var obj = $( "input[name='books-per-page']" ).val(response[key]);
					  	}

					  	if(key == 'sortoption'){
					  		var obj = $( "#wpbooklist-jre-sorting-select" ).val(response[key]);
					  	}

					  }
					}
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving library display options
function wpbooklist_update_display_options_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_update_display_options_action_callback', 'security' );
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
	$table_name = '';
	if($library == $wpdb->prefix.'wpbooklist_jre_saved_book_log'){
		$table_name = $wpdb->prefix.'wpbooklist_jre_user_options';
	} else {
		$library = explode('_', $library);
		$library = array_pop($library);
		$table_name = $wpdb->prefix.'wpbooklist_jre_settings_'.$library;
	}
	//$var2 = filter_var($_POST['var'],FILTER_SANITIZE_NUMBER_INT);
	$table_name;
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", 1));
	echo $jsonData = json_encode($row); 
	wp_die();
}

// Function for showing the Edit Book form
function wpbooklist_edit_book_show_form_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click",".wpbooklist-edit-actions-edit-button", function(event){

	  		// Gather info needed to return book data
	  		var bookId = $(this).attr('data-book-id');
	  		var table = $(this).attr('data-table');
	  		var key = $(this).attr('data-key');

	  		// Clear any edit book forms that may already be in dom
			$('.wpbooklist-edit-form-div').html('');

			// Show spinner
			$('#wpbooklist-spinner-'+key).animate({'opacity':'1'})

		  	var data = {
				'action': 'wpbooklist_edit_book_show_form_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_show_form_action_callback" ); ?>',
				'bookId':bookId,
				'table':table
			};

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	// Parse out the response
			    	response = response.split('‘–sep-seperator-sep–');
			    	var bookInfo = JSON.parse(response[0]);
			    	var editForm = response[1];
			    	console.log(bookInfo)
			    	// Add the edit book form into dom and show
			    	$('#wpbooklist-edit-form-div-'+key).html(editForm);
			    	$('#wpbooklist-edit-form-div-'+key).animate({'opacity':'1'});

			    	$('#wpbooklist-admin-cancel-button').attr('data-key', key);

			    	// Hide spinner
					$('#wpbooklist-spinner-'+key).animate({'opacity':'0'})

			    	// Populate all edit book form fields
			    	$('#wpbooklist-editbook-isbn').val(bookInfo.isbn);
			    	$('#wpbooklist-editbook-title').val(bookInfo.title);
			    	$('#wpbooklist-editbook-author').val(bookInfo.author);
			    	$('#wpbooklist-editbook-category').val(bookInfo.category);
			    	$('#wpbooklist-editbook-price').val(bookInfo.price);
			    	$('#wpbooklist-editbook-pages').val(bookInfo.pages);
			    	$('#wpbooklist-editbook-pubdate').val(bookInfo.pub_year);
			    	$('#wpbooklist-editbook-publisher').val(bookInfo.publisher);
			    	$('#wpbooklist-editbook-sale-author-link').val(bookInfo.author_url);

			    	if(bookInfo.page_yes == 'false' || bookInfo.page_yes == null || bookInfo.page_yes == undefined){
			    		$('#wpbooklist-editbook-page-no').prop('checked', true);
			    		$('#wpbooklist-editbook-page-yes').attr('data-page-id', bookInfo.page_yes);
			    	} else {
			    		$('#wpbooklist-editbook-page-yes').prop('checked', true);
			    		$('#wpbooklist-editbook-page-yes').attr('data-page-id', bookInfo.page_yes);
			    	}

			    	if(bookInfo.post_yes == 'false' || bookInfo.post_yes == null || bookInfo.post_yes == undefined){
			    		$('#wpbooklist-editbook-post-no').prop('checked', true);
			    		$('#wpbooklist-editbook-post-yes').attr('data-post-id', bookInfo.post_yes);
			    	} else {
			    		$('#wpbooklist-editbook-post-yes').prop('checked', true);
			    		$('#wpbooklist-editbook-post-yes').attr('data-post-id', bookInfo.post_yes);
			    	}

			    	$('#wpbooklist-editbook-description').val(bookInfo.description);
			    	$('#wpbooklist-editbook-notes').val(bookInfo.notes);

			    	if(bookInfo.rating != null && bookInfo.rating != 0){
			    		$('#wpbooklist-editbook-rating').val(bookInfo.rating)
			    	}

			    	$('#wpbooklist-editbook-image').val(bookInfo.image);
			    	$('#wpbooklist-editbook-preview-img').attr('src', bookInfo.image)

			    	$('#wpbooklist-admin-editbook-button').attr('data-book-id', bookId);
			    	$('#wpbooklist-admin-editbook-button').attr('data-book-uid', bookInfo.book_uid);

			    	if(bookInfo.finished == 'true'){
			    		$('#wpbooklist-editbook-finished-yes').prop('checked', true);

			    		var dateFinished = bookInfo.date_finished.split('-');
			    		dateFinished = dateFinished[2]+'-'+dateFinished[0]+'-'+dateFinished[1];

			    		$('#wpbooklist-editbook-date-finished').val(dateFinished)
			    		$('#wpbooklist-editbook-date-finished').css({'opacity':'1'});
			    	} else {
			    		$('#wpbooklist-editbook-finished-no').prop('checked', true);
			    	}

			    	if(bookInfo.signed == 'true'){
			    		$('#wpbooklist-editbook-signed-yes').prop('checked', true);
			    	} else {
			    		$('#wpbooklist-editbook-signed-no').prop('checked', true);
			    	}

			    	if(bookInfo.first_edition == 'true'){
			    		$('#wpbooklist-editbook-firstedition-yes').prop('checked', true);
			    	} else {
			    		$('#wpbooklist-editbook-firstedition-no').prop('checked', true);
			    	}


			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});

		// If the 'Cancel' button is clicked, reset all UI/Dom elements
		$(document).on("click","#wpbooklist-admin-cancel-button", function(event){

			var key = $(this).attr('data-key');
			var scrollTop = $("#wpbooklist-edit-book-indiv-div-id-"+key).offset().top-50

			// Clear any edit book forms that may already be in dom and hide edit form
			$('.wpbooklist-edit-form-div').animate({'opacity':'0'})
			$('.wpbooklist-edit-book-indiv-div-class').animate({'height':'100'},500)

			$('.wpbooklist-edit-book-indiv-div-class').animate({
			    'height':'100'
			}, {
			    queue: false,
			    duration: 500,
			    complete: function() {
			    	$('.wpbooklist-edit-form-div').html('');
					$('.wpbooklist-edit-book-indiv-div-class').css({'height':'auto'})

					// Scrolls back to the top of the title 
				    if(scrollTop != 0){
				      $('html, body').animate({
				        scrollTop: scrollTop
				      }, 500);
				      scrollTop = 0;
				    }


			    }
			});
		});
	});
	</script>
	<?php
}

// Callback Function for showing the Edit Book form
function wpbooklist_edit_book_show_form_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_show_form_action_callback', 'security' );
	$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_NUMBER_INT);
	$table = filter_var($_POST['table'],FILTER_SANITIZE_STRING);
	$book_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE ID = %d",$book_id));

	require_once(CLASS_DIR.'class-book.php');
	$form = new WPBookList_Book;
	$edit_form = $form->display_edit_book_form();

	$book_data = json_encode($book_data);
	echo $book_data.'‘–sep-seperator-sep–'.$edit_form;

	wp_die();
}


function wpbooklist_edit_book_pagination_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// Set initial offset in dom
  		$('.wpbooklist-admin-tp-top-title').attr('data-offset', 0);
		
		// Get offset value from wpbooklist.php, convert to int
		var offset = '<?php echo EDIT_PAGE_OFFSET; ?>';
		offset = parseInt(offset);


		$(document).on("click","#wpbooklist-edit-next-100, #wpbooklist-edit-previous-100", function(event){

			// Grabbing library
			var library =  $("#wpbooklist-editbook-select-library").val();

			// Grabbing offset from dom
			var currentOffset = parseInt($('.wpbooklist-admin-tp-top-title').attr('data-offset'));

			// Grabbing total number of books in library
			var limit = parseInt($(this).attr('data-limit'));

			// Ensuring we don't go backwards if we're already on the first set results
			if($(this).attr('id') == 'wpbooklist-edit-previous-100'){
				var direction = 'back';
			} else {
				var direction = 'forward';
			}

			// Ensuring we don't go backwards if we're already on the first set results
			if(direction == 'back' &&  (currentOffset-offset) < 0){
				console.log('returnback');
				return;
			}

			// Ensuring we don't go over the total # of books in library
			if(direction == 'forward' &&  (currentOffset+offset) > limit){
				console.log('returnforward');
				return;
			}

			// Initial UI Stuff
			$('.wpbooklist-edit-book-indiv-div-class').animate({'opacity':'0.3'}, 500);
			$('#wpbooklist-spinner-pagination').animate({'opacity':'1'},500);

			if(direction == 'forward'){
				currentOffset = currentOffset+offset;
				$('.wpbooklist-admin-tp-top-title').attr('data-offset', currentOffset);
			} else {
				currentOffset = currentOffset-offset;
				$('.wpbooklist-admin-tp-top-title').attr('data-offset', currentOffset);
			}

			var data = {
				'action': 'wpbooklist_edit_book_pagination_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_pagination_action_callback" ); ?>',
				'currentOffset':currentOffset,
				'library':library
			};

			var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data: data,
			    timeout: 0,
			    success: function(response) {

			    	response = response.split('_Separator_');

			    	// Resetting iniail UI stuff
			    	$('.wpbooklist-edit-book-indiv-div-class').animate({'opacity':'1'}, 500);
					$('#wpbooklist-spinner-pagination').animate({'opacity':'0'},500);

			    	// Clear existing books and replace with the response
			    	$('.wpbooklist-admin-tp-inner-container').html('');
			    	$('.wpbooklist-admin-tp-inner-container').html(response[0]);

			    	// Resetting table drop-down
			    	$("#wpbooklist-editbook-select-library").val(response[1]);

			    	if(direction == 'back' &&  (currentOffset-offset) < 0){
						$('#wpbooklist-edit-previous-100').css({'pointer-events':'none', 'opacity':'0.3'});
					} else {
						$('#wpbooklist-edit-previous-100').css({'pointer-events':'all', 'opacity':'1'});
					}

					if(direction == 'forward' &&  (currentOffset+offset) > limit){
						$('#wpbooklist-edit-next-100').css({'pointer-events':'none', 'opacity':'0.3'});
					} else {
						$('#wpbooklist-edit-next-100').css({'pointer-events':'all', 'opacity':'1'});
					}

					$('html, body').animate({
				        scrollTop: $("#wpbooklist-bulk-edit-mode-on-button").offset().top-100
				    }, 1000);
			    }

			});
		});
	});
	</script>
	<?php
}

// Callback function for the Edit Book pagination 
function wpbooklist_edit_book_pagination_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_pagination_action_callback', 'security' );
	$currentOffset = filter_var($_POST['currentOffset'],FILTER_SANITIZE_NUMBER_INT);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-edit-book-form.php');
	$form = new WPBookList_Edit_Book_Form;
	echo $form->output_edit_book_form($library, $currentOffset).'_Separator_'.$library;
	wp_die();
}

// Function for switching libraries on the Edit Book tab
function wpbooklist_edit_book_switch_lib_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("change","#wpbooklist-editbook-select-library", function(event){

  			var library =  $("#wpbooklist-editbook-select-library").val();

  			if(window.location.href.includes('library=') && window.location.href.includes('tab=') && window.location.href.includes('WPBookList')){
  				var newUrl = (window.location.href.substr(0, window.location.href.lastIndexOf("&")))+'&library='+library;
  			} else {
  				var newUrl = window.location.href+'&library='+library;
  			}

  			window.history.pushState(null,null,newUrl);

  			// Reset offset
  			$('.wpbooklist-admin-tp-top-title').attr('data-offset', 0);

  			// Initial UI Stuff
  			$('#wpbooklist-search-results-info').css({'opacity':'0'});
  			$('.wpbooklist-edit-book-indiv-div-class').animate({'opacity':'0.3'}, 500);
			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'},500);

		  	var data = {
				'action': 'wpbooklist_edit_book_switch_lib_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_switch_lib_action_callback" ); ?>',
				'library':library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	response = response.split('_Separator_');
			    	$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'},500);

			    	// Clear existing books and replace with the response
			    	$('.wpbooklist-admin-tp-inner-container').html('');
			    	$('.wpbooklist-admin-tp-inner-container').html(response[0]);
			    	$("#wpbooklist-editbook-select-library").val(response[1]);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback Function for switching libraries on the Edit Book tab
function wpbooklist_edit_book_switch_lib_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_switch_lib_action_callback', 'security' );
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-edit-book-form.php');
	$form = new WPBookList_Edit_Book_Form;
	echo $form->output_edit_book_form($library, 0).'_Separator_'.$library;

	wp_die();
}

// Function for searching for a title to edit
function wpbooklist_edit_book_search_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$(document).on('click', "#wpbooklist-edit-book-search-button", function(event){

	  		// Initial UI Stuff
	  		$('#wpbooklist-search-results-info').css({'opacity':'0'});
  			$('.wpbooklist-edit-book-indiv-div-class').animate({'opacity':'0.3'}, 500);
			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'},500);

	  		var searchTerm = $('#wpbooklist-edit-book-search-input').val();
	  		var authorCheck = $('#wpbooklist-search-author-checkbox').prop('checked');
	  		var titleCheck = $('#wpbooklist-search-title-checkbox').prop('checked');
	  		var library =  $("#wpbooklist-editbook-select-library").val();

		  	var data = {
				'action': 'wpbooklist_edit_book_search_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_search_action_callback" ); ?>',
				'searchTerm':searchTerm,
				'authorCheck':authorCheck,
				'titleCheck':titleCheck,
				'library':library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split('_Separator_');
			    	$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'},500);

			    	// Clear existing books and replace with the response
			    	$('.wpbooklist-admin-tp-inner-container').html('');
			    	$('.wpbooklist-admin-tp-inner-container').html(response[0]);
			    	$("#wpbooklist-editbook-select-library").val(response[1]);

			    	// UI Stuff
			    	var library = $("#wpbooklist-editbook-select-library").children("option:selected").text();
			    	if(library == 'Default Library'){
			    		library = 'Default';
			    	}

			    	if(response[2] == 1 || response[2] == '1'){
			    		var responseText = '<span class="wpbooklist-color-orange-italic">'+response[2]+' Result</span> Found from the '+library+' Library';
			    	} else {
			    		var responseText = '<span class="wpbooklist-color-orange-italic">'+response[2]+' Results</span> Found from the '+library+' Library';
			    	}

			    	$('#wpbooklist-search-results-info').html(responseText);
			    	$('#wpbooklist-search-results-info').css({'opacity':'1'});
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback Function for searching for a title to edit
function wpbooklist_edit_book_search_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_search_action_callback', 'security' );
	$search_term = filter_var($_POST['searchTerm'],FILTER_SANITIZE_STRING);
	$author_check = filter_var($_POST['authorCheck'],FILTER_SANITIZE_STRING);
	$title_check = filter_var($_POST['titleCheck'],FILTER_SANITIZE_STRING);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	if($title_check == 'true'){
		$search_mode = 'title';
	}

	if($author_check == 'true'){
		$search_mode = 'author';
	}

	if($author_check == 'true' && $title_check == 'true'){
		$search_mode = 'both';
	}

	if($author_check != 'true' && $title_check != 'true'){
		$search_mode = 'both';
	}

	require_once(CLASS_DIR.'class-edit-book-form.php');
	$form = new WPBookList_Edit_Book_Form;
	echo $form->output_edit_book_form($library, 0, $search_mode, $search_term).'_Separator_'.$library.'_Separator_'.$form->limit;
	wp_die();
}

function wpbooklist_edit_book_actual_action_javascript() { 
	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// For the book cover image upload
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
		var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

		$(document).on("click","#wpbooklist-editbook-upload_image_button", function(event){
			event.preventDefault();
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
			  // Set the post ID to what we want
			  file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
			  // Open frame
			  file_frame.open();
			  return;
			} else {
			  // Set the wp.media post id so the uploader grabs the ID we want when initialised
			  wp.media.model.settings.post.id = set_to_post_id;
			}
			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
			  title: 'Select a image to upload',
			  button: {
			    text: 'Use this image',
			  },
			  multiple: false // Set to true to allow multiple files to be selected
			});
			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
			  // We set multiple to false so only get one image from the uploader
			  var attachment = file_frame.state().get('selection').first().toJSON();
			  // Do something with attachment.id and/or attachment.url here
			  $( '#wpbooklist-editbook-image' ).val(attachment.url);
			  $( '#wpbooklist-editbook-preview-img' ).attr('src', attachment.url);
			  // Restore the main post ID
			  wp.media.model.settings.post.id = wp_media_post_id;
			});
			  // Finally, open the modal
			  file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		});

  		$(document).on("click","#wpbooklist-admin-editbook-button", function(event){
			var successDiv = $('#wpbooklist-editbook-success-div');
	  		successDiv.html('');
	  		$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'40px'}, 500);
			$('#wpbooklist-success-view-post').animate({'opacity':'0'}, 500);

    		wpbooklist_add_book_validator();
    		var error = $('#wpbooklist-add-book-error-check').attr('data-add-book-form-error');

    		var amazonAuthYes = $( "input[name='authorize-amazon-yes']" ).prop('checked');
			var library = $('#wpbooklist-editbook-select-library').val();
			var useAmazonYes = $("input[name='use-amazon-yes']").prop('checked');
			var isbn = $( "input[name='book-isbn']" ).val();
			var title = $( "input[name='book-title']" ).val();
			var author = $( "input[name='book-author']" ).val();
			var authorUrl = $( "input[name='book-sale-author-link']" ).val();
			var category = $( "input[name='book-category']" ).val();
			var price = $( "input[name='book-price']" ).val();
			var pages = $( "input[name='book-pages']" ).val();
			var pubYear = $( "input[name='book-pubdate']" ).val();
			var publisher = $( "input[name='book-publisher']" ).val();
			var description = $( "textarea[name='book-description']" ).val();
			var notes = $( "textarea[name='book-notes']" ).val();
			var rating = $('#wpbooklist-editbook-rating').val();
			var image = $("input[name='book-image']").val();
			var finished = $("input[name='book-finished-yes']").prop('checked');
			var dateFinished = $("input[name='book-date-finished-text']").val();
			var signed = $("input[name='book-signed-yes']").prop('checked');
			var firstEdition = $("input[name='book-firstedition-yes']").prop('checked');
			var pageYes = $("input[name='book-indiv-page-yes']").prop('checked');
			var postYes = $("input[name='book-indiv-post-yes']").prop('checked');

			// Flipping the date
			if(dateFinished.indexOf('-')){
				var finishedtemp = dateFinished.split('-');
				var dateFinished = finishedtemp[1]+'-'+finishedtemp[2]+'-'+finishedtemp[0]
			}

			var pageId = $('#wpbooklist-editbook-page-yes').attr('data-page-id');
			var postId = $('#wpbooklist-editbook-post-yes').attr('data-post-id');
			var bookId = $(this).attr('data-book-id');
			var bookUid = $(this).attr('data-book-uid');

    		if(error === 'false'){
    			// Show working spinner
    			$('.wpbooklist-spinner').animate({'opacity':'1'}, 500);
    			
	    		var data = {
					'action': 'wpbooklist_edit_book_actual_action',
					'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_actual_action_callback" ); ?>',
					'amazonAuthYes':amazonAuthYes,
					'library':library,
					'useAmazonYes':useAmazonYes,
					'isbn':isbn,
					'title':title,
					'author':author,
					'authorUrl':authorUrl,
					'category':category,
					'price':price,
					'pages':pages,
					'pubYear':pubYear,
					'publisher':publisher,
					'description':description,
					'notes':notes,
					'rating':rating,
					'image':image,
					'finished':finished,
					'dateFinished':dateFinished,
					'signed':signed,
					'firstEdition':firstEdition,
					'pageYes':pageYes,
					'postYes':postYes,
					'pageId':pageId,
					'postId':postId,
					'bookId':bookId,
					'bookUid':bookUid
				};
				console.log(data);

		     	var request = $.ajax({
				    url: ajaxurl,
				    type: "POST",
				    data:data,
				    timeout: 0,
				    success: function(response) {
				    	console.log(response);
				    	response = response.split('sep');
						
				    	if(response[0] == 1){

				    		var editbookSuccess1 = '<p><span id="wpbooklist-add-book-success-span">Success!</span><br/> You\'ve just edited your book! Remember, to display your library, simply place this shortcode on a page or post: <span id="wpbooklist-editbook-success-shortcode">'; 

				    		if(library == 'wp_wpbooklist_jre_saved_book_log'){
				    			var shortcode = '[wpbooklist_shortcode]'
				    		} else {
				    			library = library.split('_');
				    			library = library[library.length-1];
				    			var shortcode = '[wpbooklist_shortcode table="'+library+'"]'
				    		}
				    		
				    		var editbookSuccess2 = shortcode+'</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox">Click Here to View Your Edited Book</a>';

				    		var editbookSuccess3 = '';

				    		// If book addition was succesful and user chose to create a post
				    		if(response[4] == 'true' && response[3] == 'false'){
				    			var editbookSuccess3 = '<p id="wpbooklist-editbook-success-post-p"><a href="'+response[6]+'">Click Here to View This Book\'s Post</a></p></div>';
				    			$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'70px'}, 500);
				    			$('#wpbooklist-success-view-post').animate({'opacity':'1'}, 500);
				    		} 

				    		// If book addition was succesful and user chose to create a page
				    		if(response[3] == 'true' && response[4] == 'false'){
				    			var editbookSuccess3 = '<p id="wpbooklist-editbook-success-page-p"><a href="'+response[5]+'">Click Here to View This Book\'s Page</a></p></div>';
				    			$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'70px'}, 500);
				    			$('#wpbooklist-success-view-page').animate({'opacity':'1'}, 500);
				    		} 

				    		// If book addition was succesful and user chose to create a post and a page
				    		if(response[3] == 'true' && response[4] == 'true'){
				    			var editbookSuccess3 = '<p id="wpbooklist-editbook-success-page-p"><a href="'+response[5]+'">Click Here to View This Book\'s Page</a></p><p id="wpbooklist-editbook-success-post-p"><a href="'+response[6]+'">Click Here to View This Book\'s Post</a></p></div>';
				    			$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'100px'}, 500);
				    			$('#wpbooklist-success-view-page').animate({'opacity':'1'}, 500);
				    			$('#wpbooklist-success-view-post').animate({'opacity':'1'}, 500);
				    		} 

				    		// Add response message to DOM
				    		var endMessage = '<div id="wpbooklist-editbook-success-thanks">Thanks for using WPBookList, and <a href="http://wpbooklist.com/index.php/extensions/">be sure to check out the WPBookList Extensions!</a><br/><br/> If you happen to be thrilled with WPBookList, then by all means, <a id="wpbooklist-editbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5" >Feel Free to Leave a 5-Star Review Here!</a><img id="wpbooklist-smile-icon-1" src="<?php echo ROOT_IMG_ICONS_URL; ?>smile.png"></div>';
				    		successDiv.html(editbookSuccess1+editbookSuccess2+editbookSuccess3+endMessage);

				    		$('.wpbooklist-spinner').animate({'opacity':'0'}, 500);
				    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
				    		$('#wpbooklist-success-1').attr('data-bookid', response[1]);
				    		$('#wpbooklist-success-1').attr('data-booktable', response[2]);
				    	} else {
				    		$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'65px'}, 500);
				    		$('#wpbooklist-success-1').html('Whoops! Looks like there was an error trying to add your book! Please check the information you provided (especially that ISBN number), and try again.');
				    		$('#wpbooklist-spinner-1').animate({'opacity':'0'}, 500);
				    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
				    	}
				    },
					error: function(jqXHR, textStatus, errorThrown) {
						$('#wpbooklist-success-1').html('Whoops! Looks like there was an error trying to add your book! Please check the information you provided (especially that ISBN number), and try again.');
			    		$('#wpbooklist-spinner-1').animate({'opacity':'0'}, 500);
			    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
						console.log(errorThrown);
			            console.log(textStatus);
			            console.log(jqXHR);
			            // TODO: Log the console errors here
					}
				});
	     	}
	  	});
	});
	</script>
	<?php
}

// Callback function editing a book
function wpbooklist_edit_book_actual_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_actual_action_callback', 'security' );
	$amazon_auth_yes = filter_var($_POST['amazonAuthYes'],FILTER_SANITIZE_STRING);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);


	$use_amazon_yes = filter_var($_POST['useAmazonYes'],FILTER_SANITIZE_STRING);
	$isbn = filter_var($_POST['isbn'],FILTER_SANITIZE_STRING);
	$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
	$author = filter_var($_POST['author'],FILTER_SANITIZE_STRING);
	$author_url = filter_var($_POST['authorUrl'],FILTER_SANITIZE_URL);
	$category = filter_var($_POST['category'],FILTER_SANITIZE_STRING);
	$price = filter_var($_POST['price'],FILTER_SANITIZE_STRING);
	$pages = filter_var($_POST['pages'],FILTER_SANITIZE_STRING);
	$pub_year = filter_var($_POST['pubYear'],FILTER_SANITIZE_STRING);
	$publisher = filter_var($_POST['publisher'],FILTER_SANITIZE_STRING);
	$description = filter_var($_POST['description'],FILTER_SANITIZE_SPECIAL_CHARS);
	$notes = filter_var(htmlentities($_POST['notes']),FILTER_SANITIZE_STRING);
	$rating = filter_var($_POST['rating'],FILTER_SANITIZE_STRING);
	$image = filter_var($_POST['image'],FILTER_SANITIZE_URL);
	$finished = filter_var($_POST['finished'],FILTER_SANITIZE_STRING);
	$date_finished = filter_var($_POST['dateFinished'],FILTER_SANITIZE_STRING);
	$signed = filter_var($_POST['signed'],FILTER_SANITIZE_STRING);
	$first_edition = filter_var($_POST['firstEdition'],FILTER_SANITIZE_STRING);
	$page_yes = filter_var($_POST['pageYes'],FILTER_SANITIZE_STRING);
	$post_yes = filter_var($_POST['postYes'],FILTER_SANITIZE_STRING);
	$page_id = filter_var($_POST['pageId'],FILTER_SANITIZE_STRING);
	$post_id = filter_var($_POST['postId'],FILTER_SANITIZE_STRING);
	$book_uid = filter_var($_POST['bookUid'],FILTER_SANITIZE_STRING);
	$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_NUMBER_INT);


	$book_array = array(
		'amazon_auth_yes' => $amazon_auth_yes,
		'library' => $library,
		'use_amazon_yes' => $use_amazon_yes,
		'isbn' => $isbn,
		'title' => $title,
		'author' => $author,
		'author_url' => $author_url,
		'category' => $category,
		'price' => $price,
		'pages' => $pages,
		'pub_year' => $pub_year,
		'publisher' => $publisher,
		'description' => $description,
		'notes' => $notes,
		'rating' => $rating,
		'image' => $image,
		'finished' => $finished,
		'date_finished' => $date_finished,
		'signed' => $signed,
		'first_edition' => $first_edition,
		'page_yes' => $page_yes,
		'post_yes' => $post_yes,
		'page_id' => $page_id,
		'post_id' => $post_id,
		'book_uid' => $book_uid
	);

	require_once(CLASS_DIR.'class-book.php');
	$book_class = new WPBookList_Book('edit', $book_array, $book_id);

	$edit_result = $book_class->edit_result;

	// If book was succesfully edited, and return the page/post results
	if($edit_result == 1){
  		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $library WHERE ID = %d", $book_id));

  		// Get saved page URL
		$table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  		$page_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s AND type = 'page'" , $row->book_uid));

  		// Get saved post URL
		$table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  		$post_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s AND type = 'post'", $row->book_uid));

  		echo $edit_result.'sep'.$book_id.'sep'.$library.'sep'.$page_yes.'sep'.$post_yes.'sep'.$page_results->post_url.'sep'.$post_results->post_url;

  	}

	wp_die();
}

// For deleting a book
function wpbooklist_delete_book_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click",".wpbooklist-edit-actions-delete-button", function(event){

  			// UI Stuff
  			var key = $(this).attr('data-key');
  			$('#wpbooklist-spinner-'+key).animate({'opacity':'1'});

  			var deleteString = '';
  			// Grabbing the post and page ID's, if they exist
  			$(this).parent().find('input').each(function(index){
  				if($(this).attr('data-id') != undefined && $(this).attr('data-id') != null){
  					deleteString = deleteString+'-'+$(this).attr('data-id');
  				}
  			});

  			var bookId = $(this).attr('data-book-id');
  			var library = $('#wpbooklist-editbook-select-library').val();

		  	var data = {
				'action': 'wpbooklist_delete_book_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_book_action_callback" ); ?>',
				'deleteString':deleteString,
				'bookId':bookId,
				'library':library

			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split('-');
			    	console.log(response);
			    	var resultString = '';
			    	if(response[0] == 1){
			    		resultString = '<span class="wpbooklist-color-orange-italic">Title was succesfully deleted!</span><img id="wpbooklist-smile-icon-1" src="<?php echo ROOT_IMG_ICONS_URL; ?>smile.png"><br/>';
			    		$('#wpbooklist-spinner-'+key).animate({'opacity':'0'});

				    	$('#wpbooklist-delete-result-'+key).html(resultString);

				    	setTimeout(function(){
				    		document.location.reload(true);
				    	}, 3000)
			    	}

			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for deleting books 
function wpbooklist_delete_book_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_delete_book_action_callback', 'security' );
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
	$delete_string = filter_var($_POST['deleteString'],FILTER_SANITIZE_STRING);
	$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_NUMBER_INT);


	require_once(CLASS_DIR.'class-book.php');
	$book_class = new WPBookList_Book;
	$delete_result = $book_class->delete_book($library, $book_id, $delete_string);
	echo $delete_result;
	wp_die();
}

// Function for svings user's API info
function wpbooklist_user_apis_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-save-api-settings").click(function(event){

	  		var amazonapipublic = $('#wpbooklist-amazon-api-public').val();
	  		var amazonapisecret = $('#wpbooklist-amazon-api-secret').val();
	  		var googleapi = $('#wpbooklist-google-api').val();
	  		var appleapi = $('#wpbooklist-apple-api').val();
	  		var openlibraryapi = $('#wpbooklist-openlibrary-api').val();

		  	var data = {
		  		'amazonapipublic':amazonapipublic,
		  		'amazonapisecret':amazonapisecret,
		  		'googleapi':googleapi,
		  		'appleapi':appleapi,
		  		'openlibraryapi':openlibraryapi,
				'action': 'wpbooklist_user_apis_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_user_apis_action_callback" ); ?>',
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for svings user's API info
function wpbooklist_user_apis_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_user_apis_action_callback', 'security' );
	$amazonapipublic = filter_var($_POST['amazonapipublic'],FILTER_SANITIZE_STRING);
	$amazonapisecret = filter_var($_POST['amazonapisecret'],FILTER_SANITIZE_STRING);
	$googleapi = filter_var($_POST['googleapi'],FILTER_SANITIZE_STRING);
	$appleapi = filter_var($_POST['appleapi'],FILTER_SANITIZE_STRING);
	$openlibraryapi = filter_var($_POST['openlibraryapi'],FILTER_SANITIZE_STRING);

	$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
	$data = array(
        'amazonapipublic' => $amazonapipublic, 
        'amazonapisecret' => $amazonapisecret, 
        'googleapi' => $googleapi, 
        'appleapi' => $appleapi, 
        'openlibraryapi' => $openlibraryapi, 
    );
    $format = array( '%s');  
    $where = array( 'ID' => ( 1 ) );
    $where_format = array( '%d' );
    $result = $wpdb->update( $table_name, $data, $where, $format, $where_format );

	echo $result;
	wp_die();
}

// Function for frontend library pagination
function wpbooklist_library_pagination_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click",".wpbooklist-pagination-page-div", function(event){

  			// Grabbing stuff from search area, if any of it is set
  			var searchTitle = $('#wpbooklist-book-title-search').prop('checked');
	  		var searchAuthor = $('#wpbooklist-author-search').prop('checked');
	  		var searchCategory = $('#wpbooklist-cat-search').prop('checked');
	  		var sortSelect = $('#wpbooklist-sort-select-box').val();
	  		var searchTerm = $('#wpbooklist-search-text').val();

  			$('.wpbooklist-top-container').css({'pointer-events':'none'});
  			$('.wpbooklist-top-container').animate({'opacity':'0.3'}, 500);

	  		var page = $(this).attr('data-page');
	  		var perPage = $(this).attr('data-per-page');
	  		var library = $(this).attr('data-library');

		  	var data = {
				'action': 'wpbooklist_library_pagination_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_library_pagination_action_callback" ); ?>',
				'page':page,
				'perPage':perPage,
				'library':library,
				'searchTitle':searchTitle,
				'searchAuthor':searchAuthor,
				'searchCategory':searchCategory,
				'searchTerm':searchTerm,
				'sortSelect':sortSelect
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	response = response.split('--seperator--');
			    	$('.wpbooklist-top-container').html(response[0])

			    	// Setting the sort drop-down to the active value
			    	$('#wpbooklist-sort-select-box').val(response[2]);

			    	console.log(response);
			    	// Re-add the search stuff to the dom
			    	if(response[1].includes('title')){
			    		$('#wpbooklist-book-title-search').prop('checked', true);
			    	}
			    	if(response[1].includes('author')){
			    		$('#wpbooklist-author-search').prop('checked', true);
			    	}
			    	if(response[1].includes('category')){
			    		$('#wpbooklist-cat-search').prop('checked', true);
			    	}
			    	$('#wpbooklist-search-text').val(searchTerm);
			    	$('#wpbooklist-search-sub-button').prop('disabled', false);

  					$('#wpbooklist-pagination-page-'+page).css({'font-size':'14px', 'font-weight':'bold', 'padding':'4px;'});


			    	$('.wpbooklist-top-container').animate({'opacity':'1'}, 500);
			    	$('.wpbooklist-top-container').css({'pointer-events':'all'});
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for frontend library pagination
function wpbooklist_library_pagination_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_library_pagination_action_callback', 'security' );
	$page = filter_var($_POST['page'],FILTER_SANITIZE_NUMBER_INT);
	$per_page = filter_var($_POST['perPage'],FILTER_SANITIZE_NUMBER_INT);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	// Handling the search area stuff, if anything is present
	$title = filter_var($_POST['searchTitle'],FILTER_SANITIZE_STRING);
	$author = filter_var($_POST['searchAuthor'],FILTER_SANITIZE_STRING);
	$cat = filter_var($_POST['searchCategory'],FILTER_SANITIZE_STRING);
	$searchTerm = filter_var($_POST['searchTerm'],FILTER_SANITIZE_STRING);
	$sortSelect = filter_var($_POST['sortSelect'],FILTER_SANITIZE_STRING);
	$searchType = '';
	// Build search type string
	if($title == 'true'){
		$searchType = $searchType.'-title';
	}

	if($author == 'true'){
		$searchType = $searchType.'-author';
	}

	if($cat == 'true'){
		$searchType = $searchType.'-category';
	}

	include_once( ROOT_INCLUDES_UI . 'class-frontend-library-ui.php');
  	$front_end_library_ui = new WPBookList_Front_End_Library_UI($library ,$searchType, $searchTerm, $sortSelect);

  	echo $front_end_library_ui->build_library_actual($page*$per_page).'--seperator--'.$searchType.'--seperator--'.$sortSelect;

	wp_die();
}

function wpbooklist_library_search_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-search-sub-button", function(event){
	  		$('.wpbooklist-top-container').css({'pointer-events':'none'});
  			$('.wpbooklist-top-container').animate({'opacity':'0.3'}, 500);

	  		var searchTitle = $('#wpbooklist-book-title-search').prop('checked');
	  		var searchAuthor = $('#wpbooklist-author-search').prop('checked');
	  		var searchCategory = $('#wpbooklist-cat-search').prop('checked');
	  		var sortSelect = $('#wpbooklist-sort-select-box').val();
	  		var searchTerm = $('#wpbooklist-search-text').val();
	  		var table = $(this).attr('data-table');

		  	var data = {
				'action': 'wpbooklist_library_search_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_library_search_action_callback" ); ?>',
				'searchTitle':searchTitle,
				'searchAuthor':searchAuthor,
				'searchCategory':searchCategory,
				'searchTerm':searchTerm,
				'table':table
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split('--seperator--');
			    	$('.wpbooklist-top-container').html(response[0])

			    	var searchType = response[1].split('-');

			    	// Re-add the search stuff to the dom
			    	if(searchType.includes('title')){
			    		$('#wpbooklist-book-title-search').prop('checked', true);
			    	}
			    	if(searchType.includes('author')){
			    		$('#wpbooklist-author-search').prop('checked', true);
			    	}
			    	if(searchType.includes('category')){
			    		$('#wpbooklist-cat-search').prop('checked', true);
			    	}
			    	$('#wpbooklist-search-text').val(searchTerm);
			    	$('#wpbooklist-search-sub-button').prop('disabled', false);

			    	// Highlight the pagination
  					$('.wpbooklist-pagination-page-div').first().css({'font-size':'14px', 'font-weight':'bold', 'padding':'4px;'});

  					// Show and enable the UI
			    	$('.wpbooklist-top-container').animate({'opacity':'1'}, 500);
			    	$('.wpbooklist-top-container').css({'pointer-events':'all'});
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for searching the frontend library
function wpbooklist_library_search_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_library_search_action_callback', 'security' );
	$title = filter_var($_POST['searchTitle'],FILTER_SANITIZE_STRING);
	$author = filter_var($_POST['searchAuthor'],FILTER_SANITIZE_STRING);
	$cat = filter_var($_POST['searchCategory'],FILTER_SANITIZE_STRING);
	$searchTerm = filter_var($_POST['searchTerm'],FILTER_SANITIZE_STRING);
	$library = filter_var($_POST['table'],FILTER_SANITIZE_STRING);

	$searchType = '';

	// Build search type string
	if($title == 'true'){
		$searchType = $searchType.'-title';
	}

	if($author == 'true'){
		$searchType = $searchType.'-author';
	}

	if($cat == 'true'){
		$searchType = $searchType.'-category';
	}

	include_once( ROOT_INCLUDES_UI . 'class-frontend-library-ui.php');
  	$front_end_library_ui = new WPBookList_Front_End_Library_UI($library ,$searchType, $searchTerm);
  	echo $front_end_library_ui->build_library_actual(0).'--seperator--'.$searchType;


	wp_die();
}

function wpbooklist_library_sort_select_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("change","#wpbooklist-sort-select-box", function(event){

  			$('.wpbooklist-top-container').css({'pointer-events':'none'});
  			$('.wpbooklist-top-container').animate({'opacity':'0.3'}, 500);

  			var sort = $(this).val();
  			var searchTitle = $('#wpbooklist-book-title-search').prop('checked');
	  		var searchAuthor = $('#wpbooklist-author-search').prop('checked');
	  		var searchCategory = $('#wpbooklist-cat-search').prop('checked');
	  		var sortSelect = $('#wpbooklist-sort-select-box').val();
	  		var searchTerm = $('#wpbooklist-search-text').val();
	  		var table = $('.wpbooklist-table-for-app').html();

		  	var data = {
				'action': 'wpbooklist_library_sort_select_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_library_sort_select_action_callback" ); ?>',
				'searchTitle':searchTitle,
				'searchAuthor':searchAuthor,
				'searchCategory':searchCategory,
				'searchTerm':searchTerm,
				'table':table,
				'sort':sortSelect
			};

			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	response = response.split('--seperator--');
			    	$('.wpbooklist-top-container').html(response[0])

			    	var searchType = response[1].split('-');
console.log(response);
			    	// set the sort drop-down to the active valueg
			    	$('#wpbooklist-sort-select-box').val(response[2]);

			    	console.log(searchType);

			    	// Re-add the search stuff to the dom
			    	if(searchType.includes('title')){
			    		$('#wpbooklist-book-title-search').prop('checked', true);
			    	}
			    	if(searchType.includes('author')){
			    		$('#wpbooklist-author-search').prop('checked', true);
			    	}
			    	if(searchType.includes('category')){
			    		$('#wpbooklist-cat-search').prop('checked', true);
			    	}
			    	$('#wpbooklist-search-text').val(searchTerm);
			    	$('#wpbooklist-search-sub-button').prop('disabled', false);

			    	// Highlight the pagination
  					$('.wpbooklist-pagination-page-div').first().css({'font-size':'14px', 'font-weight':'bold', 'padding':'4px;'});

  					// Show and enable the UI
			    	$('.wpbooklist-top-container').animate({'opacity':'1'}, 500);
			    	$('.wpbooklist-top-container').css({'pointer-events':'all'});
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function wpbooklist_library_sort_select_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_library_sort_select_action_callback', 'security' );
	$title = filter_var($_POST['searchTitle'],FILTER_SANITIZE_STRING);
	$author = filter_var($_POST['searchAuthor'],FILTER_SANITIZE_STRING);
	$cat = filter_var($_POST['searchCategory'],FILTER_SANITIZE_STRING);
	$searchTerm = filter_var($_POST['searchTerm'],FILTER_SANITIZE_STRING);
	$sort = filter_var($_POST['sort'],FILTER_SANITIZE_STRING);
	$library = filter_var($_POST['table'],FILTER_SANITIZE_STRING);

	$searchType = '';

	// Build search type string
	if($title == 'true'){
		$searchType = $searchType.'-title';
	}

	if($author == 'true'){
		$searchType = $searchType.'-author';
	}

	if($cat == 'true'){
		$searchType = $searchType.'-category';
	}

	include_once( ROOT_INCLUDES_UI . 'class-frontend-library-ui.php');
  	$front_end_library_ui = new WPBookList_Front_End_Library_UI($library ,$searchType, $searchTerm, $sort);
  	echo $front_end_library_ui->build_library_actual(0).'--seperator--'.$searchType.'--seperator--'.$sort;
	wp_die();
}

// For uploading a new StylePak after purchase
function wpbooklist_upload_new_stylepak_action_javascript() { 
	wp_enqueue_media();
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		// Enabling the 'Apply StylePak' button when first drop-down is changed
		$(document).on("change","#wpbooklist-select-library-stylepak", function(event){
			$('#wpbooklist-addstylepak-success-div').html('');
			$('#wpbooklist-apply-library-stylepak').prop('disabled', false);
		});

		// For uploading a new StylePak
  		$(document).on("change","#wpbooklist-add-new-library-stylepak", function(event){

  			$('.wpbooklist-spinner').animate({'opacity':'1'});

			var files = event.target.files; // FileList object
		    var theFile = files[0];
		    // Open Our formData Object
		    var formData = new FormData();
		    formData.append('action', 'wpbooklist_upload_new_stylepak_action');
		    formData.append('my_uploaded_file', theFile);
		    var nonce = '<?php echo wp_create_nonce( "wpbooklist_upload_new_stylepak_action_callback" ); ?>';
		    formData.append('security', nonce);

		    // If it's a zip file or a css file, proceed with uploading the file
		    if(theFile.name.includes('.zip') || theFile.name.includes('.css')){
			    jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					data: formData,
					contentType:false,
					processData:false,
					success: function(response){
						console.log(response);
						response = response.split('sep');
						if(response[2] == 1){
							$('.wpbooklist-spinner').animate({'opacity':'0'});
							$('#wpbooklist-addstylepak-success-div').html('<span id="wpbooklist-add-book-success-span">Success!</span><br/><br/> You\'ve added a new StylePak!<div id="wpbooklist-addstylepak-success-thanks">Thanks for using WPBookList, and <a href="http://wpbooklist.com/index.php/extensions/">be sure to check out the WPBookList Extensions!</a><br/><br/> If you happen to be thrilled with WPBookList, then by all means, <a id="wpbooklist-addbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5">Feel Free to Leave a 5-Star Review Here!</a><img id="wpbooklist-smile-icon-1" src="http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png"></div>');

							$('html, body').animate({
						        scrollTop: $("#wpbooklist-addstylepak-success-div").offset().top-100
						    }, 1000);
						} else {

						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					    console.log(textStatus);
					    console.log(jqXHR);
					}	
			    }); 

			} else {
				// If the file isn't a zip or css file...
				$('.wpbooklist-spinner').animate({'opacity':'0'});
				$('#wpbooklist-addstylepak-success-div').html('<span id="wpbooklist-add-book-success-span">Uh-Oh!</span><br/><br/> Looks like there was a problem uploading your StylePak! Are you sure you selected the right file? It should end with either a ".zip" or a ".css" - you could also try unzipping the file <em>before</em> uploading it.');

				$('html, body').animate({
			        scrollTop: $("#wpbooklist-addstylepak-success-div").offset().top-100
			    }, 1000);
			}

			//event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});

		// Actually assigning a StylePak to a library
		$(document).on("click","#wpbooklist-apply-library-stylepak", function(event){
		    var stylePak = $("#wpbooklist-select-library-stylepak").val();
		    var library = $('#wpbooklist-stylepak-select-library').val();

		    var data = {
		      'action': 'wpbooklist_upload_new_stylepak_action',
		      'security': '<?php echo wp_create_nonce("wpbooklist_upload_new_stylepak_action_callback" ); ?>',
		      'stylepak': stylePak,
		      'library':library
		    };

		    console.log(data);

		    var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				    console.log(textStatus);
				    console.log(jqXHR);
				}
			});

	  	});

	});
	</script>
	<?php
}

// Callback function for creating backups
function wpbooklist_upload_new_stylepak_action_callback(){

	global $wpdb;
	check_ajax_referer( 'wpbooklist_upload_new_stylepak_action_callback', 'security' );

	// For assigning a StylePak to a Library
	if(isset($_POST["stylepak"])){
		$stylepak = filter_var($_POST["stylepak"],FILTER_SANITIZE_STRING);
  		$library = filter_var($_POST["library"],FILTER_SANITIZE_STRING);

  		$stylepak = str_replace('.css', '', $stylepak);
  		$stylepak = str_replace('.zip', '', $stylepak);

  		// Build table name to store StylePak in
  		if(strpos($library, 'wpbooklist_jre_saved_book_log') !== false){
  			$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
	  		$data = array(
		      'stylepak' => $stylepak,
		    );
		    $format = array( '%s');   
		    $where = array( 'ID' => 1 );
		    $where_format = array( '%d' );
		    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );
  		} else {
  			$table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
  			$library = substr($library, strrpos($library, '_') + 1);
  			$data = array(
		      'stylepak' => $stylepak,
		    );
		    $format = array( '%s');   
		    $where = array( 'user_table_name' => $library );
		    $where_format = array( '%s' );
		    echo $stylepak.' '.$library;
		    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );
  		}

	} else {
		// Create file structure in the uploads dir 
		$mkdir1 = null;
		if (!file_exists(UPLOADS_BASE_DIR."wpbooklist")) {
			// TODO: create log file entry 
			$mkdir1 = mkdir(UPLOADS_BASE_DIR."wpbooklist", 0777, true);
		}

		// Create file structure in the uploads dir 
		$mkdir2 = null;
		if (!file_exists(LIBRARY_STYLEPAKS_UPLOAD_DIR)) {
			// TODO: create log file entry 
			$mkdir2 = mkdir(LIBRARY_STYLEPAKS_UPLOAD_DIR, 0777, true);
		}

		// TODO: create log file entry 
		$move_result = move_uploaded_file($_FILES['my_uploaded_file']['tmp_name'], LIBRARY_STYLEPAKS_UPLOAD_DIR."{$_FILES['my_uploaded_file'] ['name']}");

		// Unzip the file if it's zipped
		if(strpos($_FILES['my_uploaded_file']['name'], '.zip') !== false){
			$zip = new ZipArchive;
			$res = $zip->open(LIBRARY_STYLEPAKS_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			if ($res === TRUE) {
			  $zip->extractTo(LIBRARY_STYLEPAKS_UPLOAD_DIR);
			  $zip->close();
			  unlink(LIBRARY_STYLEPAKS_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			}
		}

		echo $mkdir1.'sep'.$mkdir2.'sep'.$move_result;
	}
	wp_die();
}






// For uploading a new post StylePak after purchase
function wpbooklist_upload_new_post_stylepak_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		// Enabling the 'Apply StylePak' button when first drop-down is changed
		$(document).on("change","#wpbooklist-select-library-stylepak", function(event){
			$('#wpbooklist-apply-post-stylepak').prop('disabled', false);
		});

		// For uploading a new StylePak
  		$(document).on("change","#wpbooklist-add-new-post-stylepak", function(event){

  			$('.wpbooklist-spinner').animate({'opacity':'1'});

			var files = event.target.files; // FileList object
		    var theFile = files[0];
		    // Open Our formData Object
		    var formData = new FormData();
		    formData.append('action', 'wpbooklist_upload_new_post_stylepak_action');
		    formData.append('my_uploaded_file', theFile);
		    var nonce = '<?php echo wp_create_nonce( "wpbooklist_upload_new_post_stylepak_action_callback" ); ?>';
		    formData.append('security', nonce);

		    // If it's a zip file or a css file, proceed with uploading the file
		    if(theFile.name.includes('.zip') || theFile.name.includes('.css')){
			    jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					data: formData,
					contentType:false,
					processData:false,
					success: function(response){
						console.log(response);
						response = response.split('sep');
						if(response[2] == 1){
							$('.wpbooklist-spinner').animate({'opacity':'0'});
							$('#wpbooklist-addstylepak-success-div').html('<span id="wpbooklist-add-book-success-span">Success!</span><br/><br/> You\'ve added a new StylePak!<div id="wpbooklist-addstylepak-success-thanks">Thanks for using WPBookList, and <a href="http://wpbooklist.com/index.php/extensions/">be sure to check out the WPBookList Extensions!</a><br/><br/> If you happen to be thrilled with WPBookList, then by all means, <a id="wpbooklist-addbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5">Feel Free to Leave a 5-Star Review Here!</a><img id="wpbooklist-smile-icon-1" src="http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png"></div>');

							$('html, body').animate({
						        scrollTop: $("#wpbooklist-addstylepak-success-div").offset().top-100
						    }, 1000);
							document.location.reload();
						} else {

						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					    console.log(textStatus);
					    console.log(jqXHR);
					}	
			    }); 

			} else {
				// If the file isn't a zip or css file...
				$('.wpbooklist-spinner').animate({'opacity':'0'});
				$('#wpbooklist-addstylepak-success-div').html('<span id="wpbooklist-add-book-success-span">Uh-Oh!</span><br/><br/> Looks like there was a problem uploading your StylePak! Are you sure you selected the right file? It should end with either a ".zip" or a ".css" - you could also try unzipping the file <em>before</em> uploading it.');

				$('html, body').animate({
			        scrollTop: $("#wpbooklist-addstylepak-success-div").offset().top-100
			    }, 1000);
			}

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});

		// Actually assigning a StylePak to a library
		$(document).on("click","#wpbooklist-apply-post-stylepak", function(event){
		    var stylePak = $("#wpbooklist-select-library-stylepak").val();

		    var data = {
		      'action': 'wpbooklist_upload_new_post_stylepak_action',
		      'security': '<?php echo wp_create_nonce("wpbooklist_upload_new_post_stylepak_action_callback" ); ?>',
		      'stylepak': stylePak
		    };

		    console.log(data);

		    var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				    console.log(textStatus);
				    console.log(jqXHR);
				}
			});

	  	});

	});
	</script>
	<?php
}

// Callback function for creating backups
function wpbooklist_upload_new_post_stylepak_action_callback(){

	global $wpdb;
	check_ajax_referer( 'wpbooklist_upload_new_post_stylepak_action_callback', 'security' );

	// For assigning a StylePak to a Library
	if(isset($_POST["stylepak"])){
		$stylepak = filter_var($_POST["stylepak"],FILTER_SANITIZE_STRING);

  		$stylepak = str_replace('.css', '', $stylepak);
  		$stylepak = str_replace('.zip', '', $stylepak);

  		$table_name = $wpdb->prefix . 'wpbooklist_jre_post_options';

  		$data = array(
	      'stylepak' => $stylepak,
	    );
	    $format = array( '%s');   
	    $where = array( 'ID' => 1 );
	    $where_format = array( '%d' );
	    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );

	} else {
		// Create file structure in the uploads dir 
		$mkdir1 = null;
		if (!file_exists(UPLOADS_BASE_DIR."wpbooklist")) {
			// TODO: create log file entry 
			$mkdir1 = mkdir(UPLOADS_BASE_DIR."wpbooklist", 0777, true);
		}

		// Create file structure in the uploads dir 
		$mkdir2 = null;
		if (!file_exists(POST_STYLEPAKS_UPLOAD_DIR)) {
			// TODO: create log file entry 
			$mkdir2 = mkdir(POST_STYLEPAKS_UPLOAD_DIR, 0777, true);
		}

		// TODO: create log file entry 
		$move_result = move_uploaded_file($_FILES['my_uploaded_file']['tmp_name'], POST_STYLEPAKS_UPLOAD_DIR."{$_FILES['my_uploaded_file'] ['name']}");

		// Unzip the file if it's zipped
		if(strpos($_FILES['my_uploaded_file']['name'], '.zip') !== false){
			$zip = new ZipArchive;
			$res = $zip->open(POST_STYLEPAKS_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			if ($res === TRUE) {
			  $zip->extractTo(POST_STYLEPAKS_UPLOAD_DIR);
			  $zip->close();
			  unlink(POST_STYLEPAKS_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			}
		}

		echo $mkdir1.'sep'.$mkdir2.'sep'.$move_result;
	}
	wp_die();
}

// For uploading a new page StylePak after purchase
function wpbooklist_upload_new_page_stylepak_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		// Enabling the 'Apply StylePak' button when first drop-down is changed
		$(document).on("change","#wpbooklist-select-library-stylepak", function(event){
			$('#wpbooklist-apply-page-stylepak').prop('disabled', false);
		});

		// For uploading a new StylePak
  		$(document).on("change","#wpbooklist-add-new-page-stylepak", function(event){

  			$('.wpbooklist-spinner').animate({'opacity':'1'});

			var files = event.target.files; // FileList object
		    var theFile = files[0];
		    // Open Our formData Object
		    var formData = new FormData();
		    formData.append('action', 'wpbooklist_upload_new_page_stylepak_action');
		    formData.append('my_uploaded_file', theFile);
		    var nonce = '<?php echo wp_create_nonce( "wpbooklist_upload_new_page_stylepak_action_callback" ); ?>';
		    formData.append('security', nonce);

		    // If it's a zip file or a css file, proceed with uploading the file
		    if(theFile.name.includes('.zip') || theFile.name.includes('.css')){
			    jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					data: formData,
					contentType:false,
					processData:false,
					success: function(response){
						console.log(response);
						response = response.split('sep');
						if(response[2] == 1){
							$('.wpbooklist-spinner').animate({'opacity':'0'});
							$('#wpbooklist-addstylepak-success-div').html('<span id="wpbooklist-add-book-success-span">Success!</span><br/><br/> You\'ve added a new StylePak!<div id="wpbooklist-addstylepak-success-thanks">Thanks for using WPBookList, and <a href="http://wpbooklist.com/index.php/extensions/">be sure to check out the WPBookList Extensions!</a><br/><br/> If you happen to be thrilled with WPBookList, then by all means, <a id="wpbooklist-addbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5">Feel Free to Leave a 5-Star Review Here!</a><img id="wpbooklist-smile-icon-1" src="http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png"></div>');

							$('html, body').animate({
						        scrollTop: $("#wpbooklist-addstylepak-success-div").offset().top-100
						    }, 1000);
						} else {

						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					    console.log(textStatus);
					    console.log(jqXHR);
					}	
			    }); 

			} else {
				// If the file isn't a zip or css file...
				$('.wpbooklist-spinner').animate({'opacity':'0'});
				$('#wpbooklist-addstylepak-success-div').html('<span id="wpbooklist-add-book-success-span">Uh-Oh!</span><br/><br/> Looks like there was a problem uploading your StylePak! Are you sure you selected the right file? It should end with either a ".zip" or a ".css" - you could also try unzipping the file <em>before</em> uploading it.');

				$('html, body').animate({
			        scrollTop: $("#wpbooklist-addstylepak-success-div").offset().top-100
			    }, 1000);
			}

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});

		// Actually assigning a StylePak to a library
		$(document).on("click","#wpbooklist-apply-page-stylepak", function(event){
		    var stylePak = $("#wpbooklist-select-library-stylepak").val();

		    var data = {
		      'action': 'wpbooklist_upload_new_page_stylepak_action',
		      'security': '<?php echo wp_create_nonce("wpbooklist_upload_new_page_stylepak_action_callback" ); ?>',
		      'stylepak': stylePak
		    };

		    console.log(data);

		    var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				    console.log(textStatus);
				    console.log(jqXHR);
				}
			});

	  	});

	});
	</script>
	<?php
}

// Callback function for creating backups
function wpbooklist_upload_new_page_stylepak_action_callback(){

	global $wpdb;
	check_ajax_referer( 'wpbooklist_upload_new_page_stylepak_action_callback', 'security' );

	// For assigning a StylePak to a Library
	if(isset($_POST["stylepak"])){
		$stylepak = filter_var($_POST["stylepak"],FILTER_SANITIZE_STRING);

  		$stylepak = str_replace('.css', '', $stylepak);
  		$stylepak = str_replace('.zip', '', $stylepak);

  		$table_name = $wpdb->prefix . 'wpbooklist_jre_page_options';

  		$data = array(
	      'stylepak' => $stylepak,
	    );
	    $format = array( '%s');   
	    $where = array( 'ID' => 1 );
	    $where_format = array( '%d' );
	    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );

	} else {
		// Create file structure in the uploads dir 
		$mkdir1 = null;
		if (!file_exists(UPLOADS_BASE_DIR."wpbooklist")) {
			// TODO: create log file entry 
			$mkdir1 = mkdir(UPLOADS_BASE_DIR."wpbooklist", 0777, true);
		}

		// Create file structure in the uploads dir 
		$mkdir2 = null;
		if (!file_exists(PAGE_STYLEPAKS_UPLOAD_DIR)) {
			// TODO: create log file entry 
			$mkdir2 = mkdir(PAGE_STYLEPAKS_UPLOAD_DIR, 0777, true);
		}

		// TODO: create log file entry 
		$move_result = move_uploaded_file($_FILES['my_uploaded_file']['tmp_name'], PAGE_STYLEPAKS_UPLOAD_DIR."{$_FILES['my_uploaded_file'] ['name']}");

		// Unzip the file if it's zipped
		if(strpos($_FILES['my_uploaded_file']['name'], '.zip') !== false){
			$zip = new ZipArchive;
			$res = $zip->open(PAGE_STYLEPAKS_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			if ($res === TRUE) {
			  $zip->extractTo(PAGE_STYLEPAKS_UPLOAD_DIR);
			  $zip->close();
			  unlink(PAGE_STYLEPAKS_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			}
		}

		echo $mkdir1.'sep'.$mkdir2.'sep'.$move_result;
	}
	wp_die();
}

// For creating a spreasheet backup of a Library
function wpbooklist_create_db_library_backup_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// Enabling the 'Backup Library' button when first drop-down is changed
		$(document).on("change","#wpbooklist-backup-select-library", function(event){
			$('#wpbooklist-apply-library-backup').prop('disabled', false);
		});

  		$(document).on("click","#wpbooklist-apply-library-backup", function(event){

  			$('#wpbooklist-spinner-backup').animate({'opacity':'1'}, 500);

  			var library = $('#wpbooklist-backup-select-library').val();

		  	var data = {
				'action': 'wpbooklist_create_db_library_backup_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_create_db_library_backup_action_callback" ); ?>',
				'library':library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	if(response == 1){
			    		$('#wpbooklist-spinner-backup').animate({'opacity':'0'}, 500);
			    		$('#wpbooklist-addbackup-success-div').html('<span id="wpbooklist-add-book-success-span">Success!</span><br/><br/> You\'ve Created a New Backup!<div id="wpbooklist-addstylepak-success-thanks">Thanks for using WPBookList, and <a href="http://wpbooklist.com/index.php/extensions/">be sure to check out the WPBookList Extensions!</a><br/><br/> If you happen to be thrilled with WPBookList, then by all means, <a id="wpbooklist-addbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5">Feel Free to Leave a 5-Star Review Here!</a><img id="wpbooklist-smile-icon-1" src="http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png"></div>');

						$('html, body').animate({
					        scrollTop: $("#wpbooklist-addbackup-success-div").offset().top-100
					    }, 1000);
			    		console.log('success!)');
			    	}
	
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating a spreasheet backup of a Library
function wpbooklist_create_db_library_backup_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_create_db_library_backup_action_callback', 'security' );
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-backup.php');
	$backup_class = new WPBookList_Backup('library_database_backup', $library);
	echo $backup_class->create_backup_result;
	wp_die();
}

// For restoring a backup of a Library
function wpbooklist_restore_db_library_backup_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

	  	// Enabling the 'Select a Backup' drop-down when first drop-down is changed
		$(document).on("change","#wpbooklist-select-library-backup", function(event){
			var table = $(this).val();
			$('#wpbooklist-select-actual-backup').val('Select a Backup...')
			$('#wpbooklist-apply-library-restore').prop('disabled', true)
			$('.wpbooklist-backup-actual-option').each(function(){
				if( $(this).attr('data-table') != table){
					$(this).css({'display':'none'});
				} else {
					$(this).css({'display':'block'});
				}
			})
			$('#wpbooklist-select-actual-backup').prop('disabled', false);
		});

		// Enabling the 'Restore Library' button when 'select a backup' drop-down is changed
		$(document).on("change","#wpbooklist-select-actual-backup", function(event){
			$('#wpbooklist-apply-library-restore').prop('disabled', false);
		});


  		$(document).on("click","#wpbooklist-apply-library-restore", function(event){

  			$('#wpbooklist-spinner-restore-backup').animate({'opacity':'1'}, 500);

  			var table = $('#wpbooklist-select-library-backup').val();
  			var backup = $('#wpbooklist-select-actual-backup').val();

		  	var data = {
				'action': 'wpbooklist_restore_db_library_backup_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_restore_db_library_backup_action_callback" ); ?>',
				'table':table,
				'backup':backup
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	$('#wpbooklist-spinner-restore-backup').animate({'opacity':'0'}, 500);
			    	$('#wpbooklist-addbackup-success-div').html('<span id="wpbooklist-add-book-success-span">Success!</span><br/><br/> You\'ve Restored Your Library!<div id="wpbooklist-addstylepak-success-thanks">Thanks for using WPBookList, and <a href="http://wpbooklist.com/index.php/extensions/">be sure to check out the WPBookList Extensions!</a><br/><br/> If you happen to be thrilled with WPBookList, then by all means, <a id="wpbooklist-addbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5">Feel Free to Leave a 5-Star Review Here!</a><img id="wpbooklist-smile-icon-1" src="http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png"></div>');

					$('html, body').animate({
				        scrollTop: $("#wpbooklist-addbackup-success-div").offset().top-100
				    }, 1000);
		    		console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for restoring a backup of a Library
function wpbooklist_restore_db_library_backup_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_restore_db_library_backup_action_callback', 'security' );
	$table = filter_var($_POST['table'],FILTER_SANITIZE_STRING);
	$backup = filter_var($_POST['backup'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-backup.php');
	$backup_class = new WPBookList_Backup('library_database_restore', $library, $backup);

	wp_die();
}

// For setting the Amazon Localization
function wpbooklist_amazon_localization_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-save-localization", function(event){

  			var country;
		    var boxes = jQuery(".wpbooklist-localization-checkbox");
		    for (var i=0; i<boxes.length; i++) {
			    if (boxes[i].checked) {
			    	country = boxes[i].value;
			    }
		    }

		  	var data = {
				'action': 'wpbooklist_amazon_localization_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_amazon_localization_action_callback" ); ?>',
				'country':country
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function wpbooklist_amazon_localization_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_amazon_localization_action_callback', 'security' );
	$country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
	$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';

	$data = array(
	    'amazoncountryinfo' => $country
	);
	$format = array( '%s');  
	$where = array( 'ID' => 1 );
	$where_format = array( '%d' );
	$wpdb->update( $table_name, $data, $where, $format, $where_format );
	wp_die();
}


function wpbooklist_delete_book_bulk_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// For swtiching into bulk delete mode
  		$(document).on("click","#wpbooklist-bulk-edit-mode-on-button", function(event){
  			$('#wpbooklist-bulk-edit-div').animate({'height':'150px'})
  			$('.wpbooklist-edit-actions-edit-button').css({'opacity':'0.2', 'pointer-events':'none'});
  			$('.wpbooklist-edit-actions-delete-button').css({'opacity':'0.2', 'pointer-events':'none'});
  			$('.wpbooklist-edit-img-author-div').css({'opacity':'0.2', 'pointer-events':'none'});
  			$('.wpbooklist-bulk-delete-checkbox-div').css({'display':'block'})
  		});

  		// For cancelling bulk delete mode
  		$(document).on("click","#wpbooklist-bulk-edit-mode-delete-all-in-lib-cancel", function(event){
  			$('#wpbooklist-bulk-edit-div').animate({'height':'25px'})
  			$('.wpbooklist-edit-actions-edit-button').css({'opacity':'1', 'pointer-events':'all'});
  			$('.wpbooklist-edit-actions-delete-button').css({'opacity':'1', 'pointer-events':'all'});
  			$('.wpbooklist-edit-img-author-div').css({'opacity':'1', 'pointer-events':'all'});
  			$('.wpbooklist-bulk-delete-checkbox-div').css({'display':'none'})
  		});

  		// For enabling/disabling the 'Delete Checked Books' button
  		$(document).on("change",".wpbooklist-bulk-delete-checkbox", function(event){
  			$('#wpbooklist-bulk-edit-mode-delete-checked').attr('disabled', true);
  			$('.wpbooklist-bulk-delete-checkbox').each(function(){
  				if($(this).prop('checked') == true){
  					$('#wpbooklist-bulk-edit-mode-delete-checked').removeAttr('disabled');
  				}
  			})
  		});

  		// For deleting all books in library
  		$(document).on("click","#wpbooklist-bulk-edit-mode-delete-all-in-lib", function(event){

  			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'}, 500);

  			var library = $('#wpbooklist-editbook-select-library').val();

  			var data = {
				'action': 'wpbooklist_delete_book_bulk_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_book_bulk_action_callback" ); ?>',
				'library':library,
				'deleteallbooks':true
			};

			var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

  		});

  		// For deleting all books, pages, and posts in library
  		$(document).on("click","#wpbooklist-bulk-edit-mode-delete-all-plus-pp-in-lib", function(event){

  			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'}, 500);

  			var library = $('#wpbooklist-editbook-select-library').val();

  			var data = {
				'action': 'wpbooklist_delete_book_bulk_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_book_bulk_action_callback" ); ?>',
				'library':library,
				'deleteallbooksandpostandpages':true
			};

			var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

  		});
  		
  		// For deleting all titles that are checked
  		$(document).on("click","#wpbooklist-bulk-edit-mode-delete-checked", function(event){

  			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'}, 500);

  			var bookId = '';
  			var library = '';
  			var deleteString = '';
  			$('.wpbooklist-bulk-delete-checkbox').each(function(){
  				if($(this).prop('checked') == true){
  					bookId = bookId+'sep'+$(this).attr('data-book-id');

  					// Grabbing the post and page ID's, if they exist
		  			$(this).parent().parent().parent().find('.wpbooklist-edit-actions-div .wpbooklist-edit-book-delete-page-post-div input').each(function(index){
		  				if($(this).prop('checked')){
		  					if($(this).attr('data-id') != undefined && $(this).attr('data-id') != null){
		  						deleteString = deleteString+'-'+$(this).attr('data-id');
		  					}
		  				}
		  			});

		  			deleteString = deleteString+'sep';

  				}
  			})

  			var library = $('#wpbooklist-editbook-select-library').val();

		  	var data = {
				'action': 'wpbooklist_delete_book_bulk_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_book_bulk_action_callback" ); ?>',
				'deleteString':deleteString,
				'bookId':bookId,
				'library':library,
				'deletechecked':true
			};

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload();
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function wpbooklist_delete_book_bulk_action_callback(){
	global $wpdb;
	require_once(CLASS_DIR.'class-book.php');
	$book_class = new WPBookList_Book;
	check_ajax_referer( 'wpbooklist_delete_book_bulk_action_callback', 'security' );

	if(isset($_POST['deletechecked'])){
		$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
		$delete_string = filter_var($_POST['deleteString'],FILTER_SANITIZE_STRING);
		$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_STRING);
		$delete_array = explode('sep', $book_id);

		$new_array = array();
		$counter = 0;
		foreach($delete_array as $key=>$delete){
			if($delete != '' && $delete != null){
				for($i = 0; $i < $key; $i++){
					if($delete_array[$i] < $delete){
						$counter++;
					}
				}
			}

			if($delete_array[$key] != 1){
				$delete_array[$key] = ($delete_array[$key]-$counter+1);
			} else {
				$delete_array[$key] = ($delete_array[$key]-$counter);
			}
			$counter = 0;

		}

		

		$delete_page_post_array = explode('sep', $delete_string);
		var_dump($delete_page_post_array);
		foreach($delete_array as $key=>$delete){
			if($key!=0){
				$delete_result = $book_class->delete_book($library, $delete, $delete_page_post_array[$key-1]);

			}
		}
	}

	if(isset($_POST['deleteallbooks'])){

		$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
		$delete_result = $book_class->empty_table($library);
	}

	if(isset($_POST['deleteallbooksandpostandpages'])){

		$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
		$delete_result = $book_class->empty_everything($library);
	}

	wp_die();
}

/*
// For adding a book from the admin dashboard
add_action( 'admin_footer', 'wpbooklist_boilerplate_action_javascript' );
add_action( 'wp_ajax_wpbooklist_boilerplate_action', 'wpbooklist_boilerplate_action_callback' );
add_action( 'wp_ajax_nopriv_wpbooklist_boilerplate_action', 'wpbooklist_boilerplate_action_callback' );


function wpbooklist_boilerplate_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-select-sort-div", function(event){

		  	var data = {
				'action': 'wpbooklist_boilerplate_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_boilerplate_action_callback" ); ?>',
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function wpbooklist_boilerplate_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_boilerplate_action_callback', 'security' );
	//$var1 = filter_var($_POST['var'],FILTER_SANITIZE_STRING);
	//$var2 = filter_var($_POST['var'],FILTER_SANITIZE_NUMBER_INT);
	echo 'hi';
	wp_die();
}*/




?>