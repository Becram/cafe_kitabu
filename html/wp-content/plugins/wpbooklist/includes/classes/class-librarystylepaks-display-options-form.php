<?php
/**
 * WPBookList LibraryStylePaks Display Options Form Tab Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPBookList_LibraryStylePaks_Display_Options_Form', false ) ) :
/**
 * WPBookList_Admin_Menu Class.
 **/
class WPBookList_LibraryStylePaks_Display_Options_Form {

	public static function output_add_edit_form(){
		global $wpdb;

        $table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
        $db_row = $wpdb->get_results("SELECT * FROM $table_name");

        $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
        $default = $wpdb->get_row("SELECT * FROM $table_name");

        if($default->stylepak == null || $default->stylepak == 'Default StylePak'){
            $default->stylepak = 'Default StylePak';
        }

        $string_table = '<div id="wpbooklist-stylepak-table-container">
                            <table>
                                <tr id="wpbooklist-stylepak-heading-row">
                                    <th>
                                        <img class="wpbooklist-stylepak-heading-img" src="'.ROOT_IMG_ICONS_URL.'library-options.svg"><div id="wpbooklist-stylepak-heading-left" class="wpbooklist-stylepak-table-heading">Library Name</div>
                                    </th>
                                    <th>
                                        <img class="wpbooklist-stylepak-heading-img" src="'.ROOT_IMG_ICONS_URL.'librarystylepak.svg"><div class="wpbooklist-stylepak-table-heading">Active Library StylePak</div>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="wpbooklist-stylepaks-col1">
                                        <div class="wpbooklist-stylepak-table-lib"><span class="wpbooklist-stylepak-table-num">#1:</span> Default Library</div>
                                    </td>
                                    <td>
                                        <div class="wpbooklist-stylepak-table-stylepak">'.ucfirst($default->stylepak).'</div>
                                    </td>
                                </tr>';

        foreach($db_row as $key=>$db){

            if($db->stylepak == null){
                $db->stylepak = 'Default Library StylePak';
            }

            $string_table = $string_table.'<tr>
                                            <td class="wpbooklist-stylepaks-col1">
                                                <div class="wpbooklist-stylepak-table-lib"><span class="wpbooklist-stylepak-table-num">#'.($key+2).':</SPAN> '.ucfirst($db->user_table_name).' Library</div>
                                            </td>
                                            <td>
                                                <div class="wpbooklist-stylepak-table-stylepak">'.ucfirst($db->stylepak).'</div>
                                            </td>
                                        </tr>';
        }

        $string_table = $string_table.'</table></div>';



        $string1 = '<p>What\'s a <span class="wpbooklist-color-orange-italic">Library StylePak</span> you ask? <span class="wpbooklist-color-orange-italic">Library StylePaks</span> are the best way to instantly change the look and feel of your <span class="wpbooklist-color-orange-italic">WPBookList</span> Libraries!</p><p>Simply <a href="http://wpbooklist.com/index.php/stylepaks-2/">Purchase a $2 Library StylePak Here</a>, upload it using the <span class="wpbooklist-color-orange-italic">\'Upload a New Library StylePak\'</span> button below, and assign your new Library StylePak to a Library - it\'s that simple!</p>

            <div id="wpbooklist-stylepak-demo-links">
                <a href="http://wpbooklist.com/index.php/downloads/library-stylepak-1/">Library StylePak1 Demo</a>
                <a href="http://wpbooklist.com/index.php/downloads/library-stylepak-2/">Library StylePak2 Demo</a>
                <a href="http://wpbooklist.com/index.php/downloads/library-stylepak-3/">Library StylePak3 Demo</a>
                <a href="http://wpbooklist.com/index.php/downloads/library-stylepak-4/">Library StylePak4 Demo</a>
                <a href="http://wpbooklist.com/index.php/downloads/library-stylepak-5/">Library StylePak5 Demo</a>
            </div>

            <div id="wpbooklist-buy-library-stylepaks-div">
                <a id="wpbooklist-stylepak-buy-link" href="http://wpbooklist.com/index.php/stylepaks-2/"><img src="'.ROOT_IMG_URL.'getstylepaks.png" /></a>
            </div>

            <div id="wpbooklist-upload-stylepaks-div">
                <input id="wpbooklist-add-new-library-stylepak" style="display:none;" type="file" name="files[]" multiple="">
                <button id="wpbooklist-add-new-library-stylepak-button" onclick="document.getElementById(\'wpbooklist-add-new-library-stylepak\').click();" name="add-library-stylepak" type="button">Upload a New Library StylePak</button>
                    <div class="wpbooklist-spinner" id="wpbooklist-spinner-1"></div>
            </div>';

            $string2 = '<div id="wpbooklist-stylepak-select-stylepak-label">Select a Library StylePak:</div>
                            <select id="wpbooklist-select-library-stylepak">    
                                <option selected disabled>Select a Library StylePak</option>
                                <option value="Default StylePak">Default StylePak</option>';

            foreach(glob(LIBRARY_STYLEPAKS_UPLOAD_DIR.'*.*') as $filename){
                $filename = basename($filename);
                $display_name = str_replace('.css', '', $filename);
                if(strpos($filename, '.css') || strpos($filename, '.zip')){
                    $string2 = $string2.'<option id="'.$filename.'" value="'.$filename.'">'.$display_name.'</option>';
                }
            }

            $string2 = $string2.'</select>';

            $string3 = '<div id="wpbooklist-stylepak-select-library-label" for="wpbooklist-stylepak-select-library">Select a Library to Apply This StylePak to:</div>
                    <select class="wpbooklist-stylepak-select-default" id="wpbooklist-stylepak-select-library">
                        <option value="'.$wpdb->prefix.'wpbooklist_jre_saved_book_log">Default Library</option> ';

                    $string4 = '';
                    foreach($db_row as $db){
                        if(($db->user_table_name != "") || ($db->user_table_name != null)){
                            $string4 = $string4.'<option value="'.$wpdb->prefix.'wpbooklist_jre_'.$db->user_table_name.'">'.ucfirst($db->user_table_name).'</option>';
                        }
                    }
            $string5 = '</select>
                        <button disabled id="wpbooklist-apply-library-stylepak">Apply Library StylePak</button>
                        <div id="wpbooklist-addstylepak-success-div"></div>';


        echo $string1.$string_table.$string2.$string3.$string4.$string5;
	}


}

endif;