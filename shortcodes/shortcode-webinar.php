<?php
/**
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
function cws_signup_shortcode_webinar( $atts ) {
		
	// Get user credentials and prefs from database
	$options = get_option( 'cws_signup_options' );
        $success = $_GET['success'];
        
        $output = '';
        
        $output .= '<form class="cws-form" method="post" action="'.$options['w_form_post_address'].'" parsley-validate novalidate>';
        
        $output .= '<div style="display: none;">
                        <input type="hidden" value="251dd19c9b" name="_wpnonce">
                        <input type="hidden" value="'.$options['w_account_code'].'" name="sC1"><!-- Account Code -->
                        <input type="text" value="'.$options['w_mailing_list_code'].'" name="sC2"><!-- Mailing list Code -->
                        <input type="hidden" value="'.$options['w_send_notification_email'].'" name="notify_subscriber">
                        <input type="hidden" value="'.$options['w_send_admin_notification_email'].'" name="notify_admin">
                        <input type="hidden" value="'.$options['w_return_url_success'].'" name="strRedirect">
                        <input type="hidden" value="'.$options['w_return_url_fail'].'" name="strFailRedirect">
                    </div>';
        
        $output .= '<ul>
                        <li>
                                <label for="name">Name:</label><input type="text" name="strFirstName" placeholder="John" parsley-required="true" class="parsley-validated" required>
                        </li>
                        <li>
                                <label for="name">Surname:</label><input type="text" name="strSurname" placeholder="Doe">
                        </li>
                        <li>
                                <label for="name">Email:</label><input type="email" name="strEmail" placeholder="john_doe@example.com" parsley-trigger="change"  parsley-required="true" class="parsley-validated" required>
                        </li>
                        <li>
                                <label for="name">Company:</label><input type="text" name="strCompany" placeholder="ACME Pencils" required>
                        </li>	
                        <li>
                                <label for="name">Telephone:</label><input type="text" name="strCF_1704" placeholder="0161 777222" required>
                        </li>
                        <li><input type="submit" class="wpcf7-form-control  cws-submit" value="Send"></li>';
        
        $output .= '</ul>';
        $ouptut .='</form>';
        
        if($success == 1) {
            return '<p>Thanks for subscribing.</p>';
        }
        else {
            return $output;  
        }       
}