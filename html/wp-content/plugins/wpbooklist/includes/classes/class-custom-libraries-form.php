<?php
/**
 * WPBookList Custom Libraries Form Tab Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPBookList_Custom_Libraries_Form', false ) ) :
/**
 * WPBookList_Admin_Menu Class.
 */
class WPBookList_Custom_Libraries_Form {

	public static function output_custom_libraries_form(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
		$db_row = $wpdb->get_results("SELECT * FROM $table_name");

		$string1 = '<div id="wpbooklist-custom-libraries-container">
				<p id="wpbooklist-use-shortcodes-p">Use these Shortcodes below to display your different libraries, or create a new Library</p>';

		$string2 = '<table>
            			<tbody>
							<tr colspan="2"><td colspan="2"><p><span class="wpbooklist-jre-cover-shortcode-class">[wpbooklist_shortcode]</span> - (default shortcode for default library)</p></td></tr>
							<tr colspan="2">
								<td colspan="2" style="width: 100%;">
									<p><span class="wpbooklist-jre-cover-shortcode-class">[showbookcover]</span> - (shortcode for displaying Amazon Book Image Link)</p>
									<ul style="list-style: disc; margin-left: 20px;">
										<li><span class="wpbooklist-jre-cover-shortcode-class">Specify a book:</span> isbn="xxxxxxxxxxxxx"</li>
										<li><span class="wpbooklist-jre-cover-shortcode-class">Set alignment:</span> align="left"  <span style="font-style:italic;">or </span>align="right"</li>
										<li><span class="wpbooklist-jre-cover-shortcode-class">Specify library:</span> table="nameoflibrary" (leave out to use default library)</li>
										<li><span class="wpbooklist-jre-cover-shortcode-class">Set the size:</span> width="100"</li>
									</ul>
								</td>
							</tr>
              				<tr colspan="2">
              					<td colspan="2" style="text-align:center;"><p>So, for example, to display a book from your default library on the left side of a page or post, with a size of 100, this shortcode would do the trick: </br></br><span class="wpbooklist-jre-cover-shortcode-class">[showbookcover isbn="123456789912" align="left" width="100"]</p></span>
              					</td>
              				</tr>
						</tbody>
              			<tbody>
              				<tr colspan="2">
              					<td colspan="2">
              						<p id="wpbooklist-use-shortcodes"></p>
              					</td>
      						</tr>';

      						$counter = 0;
              
              				$string3 = '';
							foreach($db_row as $db){
								$counter++;
								if(($db->user_table_name != "") || ($db->user_table_name != null)){
									$string3 = $string3.'<tr><td><p>[wpbooklist_shortcode table="'.$db->user_table_name.'"]</p></td><td><button id="'.$db->user_table_name.'_'.$counter.'" class="wpbooklist_delete_custom_lib" type="button" >Delete Library</button></td></tr>'; 
								}
							}

							$string4 = '<tr>
											<td>
												<input type="text" value="Create a New Library Here..." class= "wpbooklist-dynamic-input" id="wpbooklist-dynamic-input-library" name="wpbooklist-dynamic-input"></input>
											</td>
											<td>
												<button id="wpbooklist-dynamic-shortcode-button" type="button" disabled="true">Create New Library</button>
											</td>
										</tr>
						            </tbody>
						        </table>
        					</div>';

		echo $string1.$string2.$string3.$string4;

	}


}

endif;