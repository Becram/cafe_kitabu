<?php

$string1 = '';
$string2 = '';
$string3 = '';
$string4 = '';
$string5 = '';
$string6 = '';
$string7 = '';
$string8 = '';
$string9 = '';
$string10 = '';
$string11 = '';
$string12 = '';
$string13 = '';
$string14 = '';
$string15 = '';
$string16 = '';
$string17 = '';
$string18 = '';
$string19 = '';
$string20 = '';
$string21 = '';
$string22 = '';
$string23 = '';
$string24 = '';
$string25 = '';
$string26 = '';
$string27 = '';
$string28 = '';
$string29 = '';
$string30 = '';
$string31 = '';
$string32 = '';
$string33 = '';
$string34 = '';
$string35 = '';
$string36 = '';
$string37 = '';
$string38 = '';
$string39 = '';
$string40 = '';
$string41 = '';
$string42 = '';
$string43 = '';
$string44 = '';
$string45 = '';
$string46 = '';
$string47 = '';

$string1 =  '<div id="wpbl-pagetd-top-container">
	<div id="wpbl-pagetd-left-row">
		<div id="wpbl-pagetd-image">';
			if($options_page_row->hidebookimage == null || $options_page_row->hidebookimage == 0){ 

				if($book_row->image == null){
							$string2 =  '<img id="wpbl-pagetd-img" src="'.ROOT_IMG_URL.'image_unavaliable.png"/>';
				} else {
							$string2 =  '<img id="wpbl-pagetd-img" src="'.$book_row->image.'"/>';
				} 
			}


		$string3 =  '</div>
		<div id="wpbl-pagetd-details-div">';

			if(($options_page_row->hiderating == null) && ($book_row->rating != 0)){ 

				if($book_row->rating == 5){
				    $string4 =  '<img id="wpbl-pagetd-rating-img" src="'.ROOT_IMG_URL.'5star.png'.'" />';
				}    

				if($book_row->rating == 4){
				    $string4 =  '<img id="wpbl-pagetd-rating-img" src="'.ROOT_IMG_URL.'4star.png'.'" />';
				}    

				if($book_row->rating == 3){
				    $string4 =  '<img id="wpbl-pagetd-rating-img" src="'.ROOT_IMG_URL.'3star.png'.'" />';
				}    

				if($book_row->rating == 2){
				    $string4 =  '<img id="wpbl-pagetd-rating-img" src="'.ROOT_IMG_URL.'2star.png'.'" />';
				}    

				if($book_row->rating == 1){
				    $string4 =  '<img id="wpbl-pagetd-rating-img" src="'.ROOT_IMG_URL.'1star.png'.'" />';
				}    
			} 

			if(($options_page_row->hidefacebook == null || $options_page_row->hidefacebook == 0) || ($options_page_row->hidetwitter == null || $options_page_row->hidetwitter == 0) || ($options_page_row->hidegoogleplus == null || $options_page_row->hidegoogleplus == 0) || ($options_page_row->hidemessenger == null || $options_page_row->hidemessenger == 0) || ($options_page_row->hidepinterest == null || $options_page_row->hidepinterest == 0) || ($options_page_row->hideemail == null || $options_page_row->hideemail == 0)){ 

			    $string5 =  '<div><p class="wpbl-pagetd-share-text">Share This Book</p>';

			    if($options_page_row->hidefacebook == null || $options_page_row->hidefacebook == 0){
			    	$string6 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_facebook"></a></div>';
				}

				if($options_page_row->hidetwitter == null || $options_page_row->hidetwitter == 0){
			    	$string7 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_twitter"></a></div>';
				}

				if($options_page_row->hidegoogleplus == null || $options_page_row->hidegoogleplus == 0){
			    	$string8 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_google_plusone_share"></a></div>';
				}

				if($options_page_row->hidemessenger == null || $options_page_row->hidemessenger == 0){
			    	$string9 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_messenger"></a></div>';
				}

				if($options_page_row->hidepinterest == null || $options_page_row->hidepinterest == 0){
                	$string10 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_pinterest_share"></a></div>';
				}

				if($options_page_row->hideemail == null || $options_page_row->hideemail == 0){
			    	$string11 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_gmail"></a></div>';
				}

				$string12 =  '</div>';
			} 

			if($options_page_row->hidesimilar != 1 && $similar_string != '<div id="wpbl-page-similar-div"><p class="wpbl-pagetd-share-text">Similar Titles</p></div>'){
				$string13 =  $similar_string;
			}

			if($options_page_row->hidequote == null || $options_page_row->hidequote == 0){
				$string14 =  '<div id="wpbl-pagetd-page-quote">'.stripslashes($quote).'</div>';
			}
		$string15 =  '</div>
	</div>
	<div id="wpbl-pagetd-right-row">';
		if($options_page_row->hidetitle == null || $options_page_row->hidetitle == 0){
			$string16 =  '<h3 id="wpbl-pagetd-book-title">'.$book_row->title.'</h3>';
		}
		$string17 =  '<div id="wpbl-pagetd-book-details-div">';
			if($options_page_row->hideauthor == null || $options_page_row->hideauthor == 0){
				$string18 =  '<div id="wpbl-pagetd-book-details-1">
						<span>Author: </span> '.$book_row->author.'
					</div>';
			}

			if(($options_page_row->enablepurchase != null && $options_page_row->enablepurchase != 0) && ($options_page_row->hideauthorurl == null || $options_page_row->hideauthorurl == 0) && $book_row->price != null && $book_row->author_url != null){
				$string19 =  '<div id="wpbl-pagetd-book-details-9">
					<span>Price: </span>'.$book_row->price;
				$string20 =  '</div>';
			}

			if($options_page_row->hidepages == null || $options_page_row->hidepages == 0){
				$string21 =  '<div id="wpbl-pagetd-book-details-2">
					<span>Pages: </span>'.$book_row->pages.'
				</div>';
			}

			if($options_page_row->hidecategory == null || $options_page_row->hidecategory == 0){
				$string22 =  '<div id="wpbl-pagetd-book-details-3">
					<span>Category: </span>'.$book_row->category.'
				</div>';
			}

			if($options_page_row->hidepublisher == null || $options_page_row->hidepublisher == 0){
				$string23 =  '<div id="wpbl-pagetd-book-details-4">
					<span>Publisher: </span>'.$book_row->publisher.'
				</div>';
			}

			if($options_page_row->hidepubdate == null || $options_page_row->hidepubdate == 0){
				$string24 =  '<div id="wpbl-pagetd-book-details-5">
					<span>Publication Date: </span>'.$book_row->pub_year.'
				</div>';
			}

			if($options_page_row->hidefinished == null || $options_page_row->hidefinished == 0){
				if($book_row->finished != false){
					$string25 =  '<div id="wpbl-pagetd-book-details-6">
						<span>Finished?</span> Yes';

						if($book_row->date_finished != 'undefined-undefined-'){ 
							$string26 =  ', on '.$book_row->date_finished; 
						}
					
					$string27 =  '</div>';
				}
			}

			if($options_page_row->hidesigned == null || $options_page_row->hidesigned == 0){
				$string28 =  '<div id="wpbl-pagetd-book-details-7">
					<span>Signed?</span>'; 
				if($book_row->signed == 'false'){
					$string29 =  ' No'; 
				} else {
					$string29 =  ' Yes'; 
				}

				$string30 =  '</div>';
			}

			if($options_page_row->hidesigned == null || $options_page_row->hidesigned == 0){
				$string31 =  '<div id="wpbl-pagetd-book-details-8">
				<span>First Edition?</span>';
				if($book_row->first_edition == 'false'){ 
					$string32 =  ' No'; 
				} else { 
					$string32 =  ' Yes'; 
				}
				$string33 =  '</div>';
			}
		$string34 = '</div>';

		if(($options_page_row->enablepurchase != null && $options_page_row->enablepurchase != 0) && ($options_page_row->hideauthorurl == null || $options_page_row->hideauthorurl == 0) && $book_row->price != null && $book_row->author_url != null){ 

			  if(has_filter('wpbooklist_add_storefront_calltoaction_page')) {
			    $string35 =  $var = apply_filters('wpbooklist_add_storefront_calltoaction_page', $book_row->author_url);
			  }

		}

		if(($options_page_row->hideamazonpurchase == null || $options_page_row->hideamazonpurchase == 0) || ($options_page_row->hidebnpurchase == null || $options_page_row->hidebnpurchase == 0) || ($options_page_row->hidegooglepurchase == null || $options_page_row->hidegooglepurchase == 0) || ($options_page_row->hideitunespurchase == null || $options_page_row->hideitunespurchase == 0) || (($options_page_row->enablepurchase != null && $options_page_row->enablepurchase != 0) && ($options_page_row->hideauthorurl == null || $options_page_row->hideauthorurl == 0) && $book_row->price != null && $book_row->author_url != null) ){ 
			$string36 =  '<div id="wpbl-pagetd-top-purchase-div">
				<h4 id="wpbl-pagetd-purchase-title">Purchase this title at: </h4>
				<div id="wpbl-pagetd-line-under-purchase"></div>';
				if (($book_row->amazon_detail_page != null) && ($options_page_row->hideamazonpurchase == null || $options_page_row->hideamazonpurchase == 0 )){
					$string37 =  '<a class="wpbl-pagetd-wpbooklist-purchase-img" href="'.$book_row->amazon_detail_page.'" target="_blank"><img src="'.ROOT_IMG_URL.'amazon.png" /></a>';
				}

				if (($book_row->isbn != null) && ($options_page_row->hidebnpurchase == null || $options_page_row->hidebnpurchase == 0 )){
					$string38 =  '<a class="wpbl-pagetd-wpbooklist-purchase-img" href="http://www.barnesandnoble.com/s/'.$book_row->isbn.'" target="_blank"><img src="'.ROOT_IMG_URL.'bn.png" /></a>';
				}

				if (($book_row->google_preview != null) && ($options_page_row->hidegooglepurchase == null || $options_page_row->hidegooglepurchase == 0 )){
					$string39 =  '<a class="wpbl-pagetd-wpbooklist-purchase-img" href="'.$book_row->google_preview.'" target="_blank"><img src="'.ROOT_IMG_URL.'googlebooks.png" /></a>';
				}

				if (($book_row->itunes_page != null) && ($options_page_row->hideitunespurchase == null || $options_page_row->hideitunespurchase == 0 )){
					$string40 =  '<a class="wpbl-pagetd-wpbooklist-purchase-img" href="'.$book_row->itunes_page.'" target="_blank"><img id="wpbl-pagetd-itunes-img" src="'.ROOT_IMG_URL.'ituneslink.png" /></a>';
				}

				if(($options_page_row->enablepurchase != null && $options_page_row->enablepurchase != 0) && ($book_row->author_url != null) && ($options_page_row->hideauthorurl == null || $options_page_row->hideauthorurl == 0 )){
					if(has_filter('wpbooklist_add_storefront_bookimg_page')) {
					    $string41 =  $var = apply_filters('wpbooklist_add_storefront_bookimg_page', $book_row->author_url);
					}
				}
			$string42 = '</div>';
		} 
		if(($options_page_row->hidedescription == null || $options_page_row->hidedescription == 0) && $book_row->description != null){
			$string43 =  '<div id="wpbl-pagetd-book-description-div">
				<h5 id="wpbl-pagetd-book-description-h5">Description</h5>
				<div id="wpbl-pagetd-book-description-contents">'.$book_row->description.'</div>
			</div>';
		}
		if(($options_page_row->hidenotes == null || $options_page_row->hidenotes == 0) && $book_row->notes != null){
		$string44 =  '<div id="wpbl-pagetd-book-notes-div">
			<h5 id="wpbl-pagetd-book-notes-h5">Notes</h5>
			<div id="wpbl-pagetd-book-notes-contents">'.html_entity_decode(stripslashes($book_row->notes)) .'</div>
		</div>';
		} 
		if(($options_page_row->hideamazonreview == null || $options_page_row->hideamazonreview == 0) && $book_row->review_iframe != null){
		$string45 =  '<div id="wpbl-pagetd-book-amazon-review-div">
			<h5 id="wpbl-pagetd-book-amazon-review-h5">Amazon Reviews</h5>
			<iframe id="wpbl-pagetd-book-amazon-review-contents" src="'.$book_row->review_iframe.'"></iframe>
		</div>';
		} 

		$append_string = '';
		if(has_filter('wpbooklist_append_to_default_page_template_right_column')) {
			$append_string = apply_filters('wpbooklist_append_to_default_page_template_right_column', $append_string);
		}
		$string46 =  $append_string;

        
	$string47 = '</div>

</div>';


