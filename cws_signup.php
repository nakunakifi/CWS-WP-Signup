<?php
/*
Plugin Name: CWS Signup
Plugin URI: http://nakunakifi.com
Description: Webinar Signup form.
Version: 1.0
Author: Ian Kennerley
Author URI: http://nakunakifi.com
License:
    
     This program is free software; you can redistribute it and/or
     modify it under the terms of the GNU General Public License
     as published by the Free Software Foundation; either version 2
     of the License, or (at your option) any later version.
    
     This program is distributed in the hope that it will be useful,
     but WITHOUT ANY WARRANTY; without even the implied warranty of
     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     GNU General Public License for more details.
    
     You should have received a copy of the GNU General Public License
     along with this program; if not, write to the Free Software
     Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
?>
<?php
  define( 'CWS_SIGNUP_PLUGIN_URL', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );

  /**
  *
  *     Main CWS Signup Plugin Class
  *
  */
  class WPCWSSignup {
        
    public $plugin_version = '';     // Define the Version of the Plugin
          
      // Define some environment settings
      public function __construct() {
          
           $this->pluginPath = dirname( __FILE__ );
           $this->pluginUrl = WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), "", plugin_basename( __FILE__ ) );
          
           add_action( 'wp_print_scripts', array($this,'add_header_scripts') );
           add_action( 'wp_print_styles', array($this,'add_header_styles') );
           
           // Include required files
           $this->includes();
      }
         
  /**
	 *
	 * Include required core files
	 *
	 */
	function includes() {
		// Include any admin specific stuff here...
        // if ( is_admin() ) $this->admin_includes();
		include_once( 'shortcodes/shortcode-init.php' );			// Init the shortcodes
	}
          
         // Enqueue scripts for front-end
          public function add_header_scripts() {
              
               if ( ! is_admin() ) {
              
                    if( function_exists( 'wp_register_script' ) ) {
                         wp_register_script( 'parsley_js', CWS_SIGNUP_PLUGIN_URL . 'lib/js/parsley.js', array('jquery'), 1 );
                   
                         if( function_exists( 'wp_enqueue_script' ) ) {
                              //wp_enqueue_script( 'base_js' );
                              wp_enqueue_script( 'parsley_js' );
                         }
                    }
               }
          }
          
         // Enqueue styles for front-end
          public function add_header_styles() {
              
               if ( ! is_admin() ) {
              
                    if( function_exists( 'wp_register_script' ) ) {
                        
                         // http://codex.wordpress.org/Function_Reference/wp_enqueue_script
                         wp_register_style( 'style_css', CWS_SIGNUP_PLUGIN_URL . 'css/style.css', __FILE__ );
                   
                         if( function_exists( 'wp_enqueue_script' ) ) {
                              wp_enqueue_style( 'style_css' );
                         }
                    }
               }
          }          
                   
     }


     // Add menu for options page
     add_action( 'admin_menu', 'cws_signup_add_page' );
     function cws_signup_add_page() {
          // http://codex.wordpress.org/Function_Reference/add_options_page
          add_options_page( 'CWS Signup', 'CWS Signup', 'manage_options', 'cws_signup', 'cws_signup_options_page' );
     }


     // Draw the options page
     function cws_signup_options_page() {
    
          // global $get_page;
    
          if ( !current_user_can( 'manage_options') ){ wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); }
         
          ?>
               <div class="wrap">
                    <?php screen_icon(); ?>
                    <h2>CWS Signup Settings Page</h2>
                    <form method="post" action="options.php">
                         <?php
                              if( function_exists('settings_fields') ) {
                                   settings_fields( 'cws_signup_options' );
                              }
                             
                              //
                              if( function_exists( 'do_settings_sections' ) )     {
                                   do_settings_sections( 'cws_signup' );
                              }
                             
                              // Grab the form
                              cws_signup_setting_input();
                         ?>
                    </form>
               </div>
     <?php
     }


     // Register and define the settings
     add_action( 'admin_init', 'cws_signup_admin_init' );
     function cws_signup_admin_init() {
          register_setting(
               'privacy',
               'cws_signup_options',
               'cws_signup_validate_options'
          );
              
          add_settings_field(
               'cws_signup_text_stringcunt',
               'Enter text here',
               'cws_signup_setting_input',
               'privacy',
               'default'
          );    
         
          register_setting( 'cws_signup_options', 'cws_signup_options', 'cws_signup_validate_options' ); // settings_fields
     }


     // Display and fill the form field
     function cws_signup_setting_input() {
    
          global $get_page;
         
          // get option 'text_string' value from the database
          $options = get_option( 'cws_signup_options' );
          // print_r($options);
          ?>
         
          <div style="width: 65%;" class="postbox-container">
              <h2>Newsletter</h2>
               <div class="metabox-holder">
              
                    <div class="postbox" id="settings">
         
                         <table class="form-table">
                              <tr valign="top">
                                   <th scope="row">Account Code: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[nl_account_code]" value="<?php echo $options['nl_account_code']; ?>" size="50%" />
                                   </td>
                              </tr>
                              <tr>    
                                   <th scope="row">Mailing List Code: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[nl_mailing_list_code]" value="<?php echo $options['nl_mailing_list_code']; ?>" size="50%" />
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Post Form to: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[nl_form_post_address]" value="<?php echo $options['nl_form_post_address']; ?>" size="50%" />
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Return URL Success</th>
                                   <td>
                                        <input type="text" name="cws_signup_options[nl_return_url_success]" value="<?php echo $options['nl_return_url_success']; ?>" size="50%" />
                                        <small><?php _e( 'On Success', 'cws_signup'); ?></small>
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Return URL Failure</th>
                                   <td>
                                        <input type="text" name="cws_signup_options[nl_return_url_fail]" value="<?php echo $options['nl_return_url_fail']; ?>" size="50%" />
                                        <small><?php _e( 'On Failure', 'cws_signup'); ?></small>
                                   </td>                                  
                              </tr>                              
                            <tr>
                                    <th scope="row"><?php _e( 'Send Notification Email', 'cws_signup'); ?></th>
                                    <td>
                                            <input type="checkbox" name="cws_signup_options[nl_send_notification_email]" value="1" <?php if ( $options['nl_send_notification_email'] == 1) { echo 'checked'; } ?> />
                                            <small><?php _e( 'Sends an email notification to the subscriber', 'cws_signup'); ?></small>
                                    </td>
                            </tr>
                            <tr>
                                    <th scope="row"><?php _e( 'Send Admin Notification Email', 'cws_signup'); ?></th>
                                    <td>
                                            <input type="checkbox" name="cws_signup_options[nl_send_admin_notification_email]" value="1" <?php if ( $options['nl_send_admin_notification_email'] == 1) { echo 'checked'; } ?> />
                                            <small><?php _e( 'Sends an email notification to the admin', 'cws_signup'); ?></small>
                                    </td>
                            </tr>
                            <tr>
                                <th>Shortcode Usage: </th>
                                <td>Place this shortcode on page or in text widget <strong>[cws_signup_newsletter]</strong></td>
                            </tr>
                         </table>
                        
                    </div>
                   
                    <input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

               </div>

              
              <h2>Webinar</h2>
               <div class="metabox-holder">
              
                    <div class="postbox" id="settings">
         
                         <table class="form-table">
                              <tr valign="top">
                                   <th scope="row">Account Code: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_account_code]" value="<?php echo $options['w_account_code']; ?>" size="50%" />
                                   </td>
                              </tr>
                              <tr>    
                                   <th scope="row">Mailing List Code: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_mailing_list_code]" value="<?php echo $options['w_mailing_list_code']; ?>" size="50%" />
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Post Form to: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_form_post_address]" value="<?php echo $options['w_form_post_address']; ?>" size="50%" />
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Return URL Success</th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_return_url_success]" value="<?php echo $options['w_return_url_success']; ?>" size="50%" />
                                        <small><?php _e( 'On Success', 'cws_signup'); ?></small>
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Return URL Failure</th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_return_url_fail]" value="<?php echo $options['w_return_url_fail']; ?>" size="50%" />
                                        <small><?php _e( 'On Failure', 'cws_signup'); ?></small>
                                   </td>                                  
                              </tr>                              
                            <tr>
                                    <th scope="row"><?php _e( 'Send Notification Email', 'cws_signup'); ?></th>
                                    <td>
                                            <input type="checkbox" name="cws_signup_options[w_send_notification_email]" value="1" <?php if ( $options['w_send_notification_email'] == 1) { echo 'checked'; } ?> />
                                            <small><?php _e( 'Sends an email notification to the subscriber', 'cws_signup'); ?></small>
                                    </td>
                            </tr>
                            <tr>
                                    <th scope="row"><?php _e( 'Send Admin Notification Email', 'cws_signup'); ?></th>
                                    <td>
                                            <input type="checkbox" name="cws_signup_options[w_send_admin_notification_email]" value="1" <?php if ( $options['w_send_admin_notification_email'] == 1) { echo 'checked'; } ?> />
                                            <small><?php _e( 'Sends an email notification to the admin', 'cws_signup'); ?></small>
                                    </td>
                            </tr>
                            <tr>
                                <th>Shortcode Usage: </th>
                                <td>Place this shortcode on page or in text widget <strong>[cws_signup_webinar]</strong></td>
                            </tr>                            
                         </table>
                        
                    </div>
                   
                    <input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

               </div> 
			  
              <h2>Landing Page</h2>
               <div class="metabox-holder">
              
                    <div class="postbox" id="settings">
         
                         <table class="form-table">
                              <tr valign="top">
                                   <th scope="row">Account Code: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_account_code]" value="<?php echo $options['w_account_code']; ?>" size="50%" />
                                   </td>
                              </tr>
                              <tr>    
                                   <th scope="row">Mailing List Code: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_mailing_list_code]" value="<?php echo $options['w_mailing_list_code']; ?>" size="50%" />
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Post Form to: </th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_form_post_address]" value="<?php echo $options['w_form_post_address']; ?>" size="50%" />
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Return URL Success</th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_return_url_success]" value="<?php echo $options['w_return_url_success']; ?>" size="50%" />
                                        <small><?php _e( 'On Success', 'cws_signup'); ?></small>
                                   </td>                                  
                              </tr>
                              <tr>    
                                   <th scope="row">Return URL Failure</th>
                                   <td>
                                        <input type="text" name="cws_signup_options[w_return_url_fail]" value="<?php echo $options['w_return_url_fail']; ?>" size="50%" />
                                        <small><?php _e( 'On Failure', 'cws_signup'); ?></small>
                                   </td>                                  
                              </tr>                              
                            <tr>
                                    <th scope="row"><?php _e( 'Send Notification Email', 'cws_signup'); ?></th>
                                    <td>
                                            <input type="checkbox" name="cws_signup_options[w_send_notification_email]" value="1" <?php if ( $options['w_send_notification_email'] == 1) { echo 'checked'; } ?> />
                                            <small><?php _e( 'Sends an email notification to the subscriber', 'cws_signup'); ?></small>
                                    </td>
                            </tr>
                            <tr>
                                    <th scope="row"><?php _e( 'Send Admin Notification Email', 'cws_signup'); ?></th>
                                    <td>
                                            <input type="checkbox" name="cws_signup_options[w_send_admin_notification_email]" value="1" <?php if ( $options['w_send_admin_notification_email'] == 1) { echo 'checked'; } ?> />
                                            <small><?php _e( 'Sends an email notification to the admin', 'cws_signup'); ?></small>
                                    </td>
                            </tr>
                            <tr>
                                <th>Shortcode Usage: </th>
                                <td>Place this shortcode on page or in text widget <strong>[cws_landingpage]</strong></td>
                            </tr>                            
                         </table>
                        
                    </div>
                   
                    <input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

               </div>			  
			  
          </div>
         
          <?php
     }


// Validate user input
function cws_signup_validate_options( $input ) {

     $errors = array();
    
     // Newletter
     $valid['nl_account_code']       = esc_attr( $input['nl_account_code'] );
     $valid['nl_mailing_list_code'] = esc_attr( $input['nl_mailing_list_code'] );
     $valid['nl_return_url_success'] = esc_attr( $input['nl_return_url_success'] );
     $valid['nl_return_url_fail'] = esc_attr( $input['nl_return_url_fail'] );
     $valid['nl_form_post_address'] = esc_attr( $input['nl_form_post_address'] );
     
    // Validation of checkboxes
    $valid[nl_send_notification_email] 		= ( isset( $input[nl_send_notification_email] ) && true == $input[nl_send_notification_email] ? true : false );     
    $valid[nl_send_admin_notification_email] 	= ( isset( $input[nl_send_admin_notification_email] ) && true == $input[nl_send_admin_notification_email] ? true : false );     

     // Webinar
     $valid['w_account_code']       = esc_attr( $input['w_account_code'] );
     $valid['w_mailing_list_code'] = esc_attr( $input['w_mailing_list_code'] );
     $valid['w_return_url_success'] = esc_attr( $input['w_return_url_success'] );
     $valid['w_return_url_fail'] = esc_attr( $input['w_return_url_fail'] );
     $valid['w_form_post_address'] = esc_attr( $input['w_form_post_address'] );
     
    // Validation of checkboxes
    $valid[w_send_notification_email] 		= ( isset( $input[w_send_notification_email] ) && true == $input[w_send_notification_email] ? true : false );     
    $valid[w_send_admin_notification_email] 	= ( isset( $input[w_send_admin_notification_email] ) && true == $input[w_send_admin_notification_email] ? true : false );      

     // Display all errors together
     if( count( $errors ) > 0 ) {
              
          $err_msg = '';
              
          // Display errors
          foreach( $errors as $err ) {
               $err_msg .= "$err<br><br>";
          }

          add_settings_error(
               'nap_gp_text_string',
               'nak_gp_texterror',
               $err_msg,
               'error'
          );
     }

     return $valid;
}

     // Instantiate a Class    
     $WPCWSSignup = new WPCWSSignup();
     $WPCWSSignup->plugin_version = '1.0.0';

?>