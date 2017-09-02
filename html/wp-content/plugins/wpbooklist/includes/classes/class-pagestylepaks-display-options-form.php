<?php
/**
 * WPBookList PageStylePaks Display Options Form Tab Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPBookList_PageStylePaks_Display_Options_Form', false ) ) :
/**
 * WPBookList_Admin_Menu Class.
 **/
class WPBookList_PageStylePaks_Display_Options_Form {

    public static function output_add_edit_form(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'wpbooklist_jre_page_options';
        $default = $wpdb->get_row("SELECT * FROM $table_name");

        if($default->stylepak == null || $default->stylepak == 'Default'){
            $default->stylepak = 'Default Page StylePak';
        }

        $default->stylepak = str_replace('Page-', 'Page ', $default->stylepak);

        $string_table = '<div id="wpbooklist-stylepak-table-container">
                            <table>
                                <tr id="wpbooklist-stylepak-heading-row">
                                    <th>
                                        <img class="wpbooklist-stylepak-heading-img" src="'.ROOT_IMG_ICONS_URL.'librarystylepak.svg"><div class="wpbooklist-stylepak-table-heading">Active Page StylePak</div>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="wpbooklist-stylepak-table-stylepak">'.ucfirst($default->stylepak).'</div>
                                    </td>
                                </tr>';


        $string_table = $string_table.'</table></div>';



        $string1 = '<p>What\'s a <span class="wpbooklist-color-orange-italic">Page StylePak</span> you ask? <span class="wpbooklist-color-orange-italic">Page StylePaks</span> are the best way to instantly change the look and feel of your <span class="wpbooklist-color-orange-italic">WPBookList</span> Pages!</p><p>Simply <a href="www.google.com">Purchase a $2 Page StylePak Here</a>, upload it using the <span class="wpbooklist-color-orange-italic">\'Upload a New Page StylePak\'</span> button below, and assign your new Page StylePak to your WPBookList Pages - it\'s that simple!</p>

            <div id="wpbooklist-stylepak-demo-links">
                <a href="http://wpbooklist.com/index.php/1776-2/">Page StylePak1 Demo</a>
                <a href="http://wpbooklist.com/index.php/2001-a-space-odyssey-space-odyssey-1/">Page StylePak2 Demo</a>
                <a href="http://wpbooklist.com/index.php/elon-musk-tesla-spacex-and-the-quest-for-a-fantastic-future/">Page StylePak3 Demo</a>
                <a href="http://wpbooklist.com/index.php/harry-potter-and-the-goblet-of-fire-harry-potter-4/">Page StylePak4 Demo</a>
                <a href="http://wpbooklist.com/index.php/mans-search-for-meaning/">Page StylePak5 Demo</a>
            </div>

            <div id="wpbooklist-buy-library-stylepaks-div">
                <a id="wpbooklist-stylepak-buy-link" href=""><img src="'.ROOT_IMG_URL.'getstylepaks.png" /></a>
            </div>

            <div id="wpbooklist-upload-stylepaks-div">
                <input accept=".css,.zip,application/x-pointplus,text/css,application/zip" id="wpbooklist-add-new-page-stylepak" style="display:none;" type="file" name="files[]" multiple="">
                <button onclick="document.getElementById(\'wpbooklist-add-new-page-stylepak\').click();" name="add-library-stylepak" type="button">Upload a New Page StylePak</button>
                    <div class="wpbooklist-spinner" id="wpbooklist-spinner-1"></div>
            </div>';

            $string2 = '<div id="wpbooklist-stylepak-select-stylepak-label">Select a Page StylePak To Apply to Your WPBookList Pages:</div>
                            <select id="wpbooklist-select-library-stylepak">    
                                <option selected disabled>Select a Page StylePak</option>
                                <option value="Default StylePak">Default Page StylePak</option>';

            foreach(glob(POST_STYLEPAKS_UPLOAD_DIR.'*.*') as $filename){
                $filename = basename($filename);
                if((strpos($filename, '.css') || strpos($filename, '.zip')) && strpos($filename, 'Page') !== false){
                    $display_name = str_replace('.css', '', $filename);
                    $display_name = str_replace('Page-', 'Page ', $display_name);
                    $string2 = $string2.'<option id="'.$filename.'" value="'.$filename.'">'.$display_name.'</option>';
                }
            }

            $string3 = '</select><button disabled id="wpbooklist-apply-page-stylepak">Apply Page StylePak</button>
                        <div id="wpbooklist-addstylepak-success-div"></div>';


        echo $string1.$string_table.$string2.$string3;
    }


}

endif;