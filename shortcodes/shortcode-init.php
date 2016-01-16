<?php
/**
 * Shortcodes init
 * 
 * Init main shortcodes
 *
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

include_once('shortcode-newsletter.php');
include_once('shortcode-webinar.php');

// Enquiry Form for landing page from email capmpaign
include_once('shortcode-landingpage.php');

/**
 * Shortcode creation
 **/
add_shortcode( 'cws_signup_newsletter', 'cws_signup_shortcode_newsletter' );
add_shortcode( 'cws_signup_webinar', 'cws_signup_shortcode_webinar' );
add_shortcode( 'cws_signup_landingpage', 'cws_shortcode_landingpage' );