<?php
/**
 * WPBookList PostStylePaks Display Options Form Tab Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPBookList_PostStylePaks_Display_Options_Form', false ) ) :
/**
 * WPBookList_Admin_Menu Class.
 **/
class WPBookList_PostStylePaks_Display_Options_Form {

    public static function output_add_edit_form(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'wpbooklist_jre_post_options';
        $default = $wpdb->get_row("SELECT * FROM $table_name");

        if($default->stylepak == null || $default->stylepak == 'Default'){
            $default->stylepak = 'Default Post StylePak';
        }

        $default->stylepak = str_replace('Post-', 'Post ', $default->stylepak);

        $string_table = '<div id="wpbooklist-stylepak-table-container">
                            <table>
                                <tr id="wpbooklist-stylepak-heading-row">
                                    <th>
                                        <img class="wpbooklist-stylepak-heading-img" src="'.ROOT_IMG_ICONS_URL.'librarystylepak.svg"><div class="wpbooklist-stylepak-table-heading">Active Post StylePak</div>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="wpbooklist-stylepak-table-stylepak">'.ucfirst($default->stylepak).'</div>
                                    </td>
                                </tr>';


        $string_table = $string_table.'</table></div>';



        $string1 = '<p>What\'s a <span class="wpbooklist-color-orange-italic">Post StylePak</span> you ask? <span class="wpbooklist-color-orange-italic">Post StylePaks</span> are the best way to instantly change the look and feel of your <span class="wpbooklist-color-orange-italic">WPBookList</span> Posts!</p><p>Simply <a href="www.google.com">Purchase a $2 Post StylePak Here</a>, upload it using the <span class="wpbooklist-color-orange-italic">\'Upload a New Post StylePak\'</span> button below, and assign your new Post StylePak to your WPBookList Posts - it\'s that simple!</p>

            <div id="wpbooklist-stylepak-demo-links">
                <a href="http://wpbooklist.com/index.php/2017/08/23/steve-jobs/">Post StylePak1 Demo</a>
                <a href="http://wpbooklist.com/index.php/2017/08/23/rise-of-the-rocket-girls-the-women-who-propelled-us-from-missiles-to-the-moon-to-mars/">Post StylePak2 Demo</a>
                <a href="http://wpbooklist.com/index.php/2017/08/23/atlas-shrugged/">Post StylePak3 Demo</a>
                <a href="http://wpbooklist.com/index.php/2017/08/23/youre-never-weird-on-the-internet-almost/">Post StylePak4 Demo</a>
                <a href="http://wpbooklist.com/index.php/2017/08/23/turings-cathedral-the-origins-of-the-digital-universe/">Post StylePak5 Demo</a>
            </div>

            <div id="wpbooklist-buy-library-stylepaks-div">
                <a id="wpbooklist-stylepak-buy-link" href=""><img src="'.ROOT_IMG_URL.'getstylepaks.png" /></a>
            </div>

            <div id="wpbooklist-upload-stylepaks-div">
                <input id="wpbooklist-add-new-post-stylepak" style="display:none;" type="file" name="files[]" multiple="">
                <button onclick="document.getElementById(\'wpbooklist-add-new-post-stylepak\').click();" name="add-library-stylepak" type="button">Upload a New Post StylePak</button>
                    <div class="wpbooklist-spinner" id="wpbooklist-spinner-1"></div>
            </div>';

            $string2 = '<div id="wpbooklist-stylepak-select-stylepak-label">Select a Post StylePak To Apply to Your WPBookList Posts:</div>
                            <select id="wpbooklist-select-library-stylepak">    
                                <option selected disabled>Select a Post StylePak</option>
                                <option value="Default StylePak">Default Post StylePak</option>';

            foreach(glob(POST_STYLEPAKS_UPLOAD_DIR.'*.*') as $filename){
                $filename = basename($filename);
                if((strpos($filename, '.css') || strpos($filename, '.zip')) && strpos($filename, 'Post') !== false){
                    $display_name = str_replace('.css', '', $filename);
                    $display_name = str_replace('Post-', 'Post ', $display_name);
                    $string2 = $string2.'<option id="'.$filename.'" value="'.$filename.'">'.$display_name.'</option>';
                }
            }

            $string3 = '</select><button disabled id="wpbooklist-apply-post-stylepak">Apply Post StylePak</button>
                        <div id="wpbooklist-addstylepak-success-div"></div>';


        echo $string1.$string_table.$string2.$string3;
    }


}

endif;