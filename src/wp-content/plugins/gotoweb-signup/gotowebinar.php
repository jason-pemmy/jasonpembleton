<?php
/*
Plugin Name: Tbk's GoToWebinar Sign Up
Plugin URI: http://www.tbkcreative.com
Description: A new way to display GoToWebinar Sign Up Pages
Author: Jonelle Carroll-Berube, Andre LeFort | tbk Creative
Version: 1.6.12
Author URI: http://www.tbkcreative.com


/*  Copyright 2013  Jonelle Carroll-Berube  (email : jonelle@tbkcreative.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include_once( plugin_dir_path( __FILE__ ) . 'lib/custom-post-types.php' );
include_once( plugin_dir_path( __FILE__ ) . 'lib/inflector-helper.php' );
$webinarErrors = new WP_Error();

$gotoweb = new TBK_GoToWeb();
class TBK_GoToWeb {

	function __construct() {

		$this->tokens = get_option( 'gtw_oauth_token' );
		add_action( 'add_meta_boxes', array( $this, 'add_webinar_meta_box' ) );
		add_action( 'save_post', array( $this, 'webinar_meta_box_save' ) );
		add_action( 'template_redirect', array( $this, 'register' ) );
		add_filter( 'template_include', array( $this, 'webinar_template' ) );
		add_filter( 'gotowebinar_post_fields', array( &$this, 'gotowebinar_post_fields' ), 1 );
		add_shortcode( 'webinar_form', array( $this, 'display_webinar_form' ) );
		add_action( 'init', array( $this, 'gotoweb_init' ), 1 );
		add_action( 'wp_print_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_notices', array( $this, 'show_admin_messages' ) );
		add_action( 'wp_head', array( &$this, 'header_js' ) );
		add_image_size( 'webinar-image', 1950, 413, true );
	}

	function gotoweb_init() {

		if ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
			wp_enqueue_style( 'bootstrap', plugins_url( '/bootstrap/css/bootstrap.css', __FILE__ ) );
			wp_enqueue_style( 'gotowebinar-css', plugins_url( '/css/style.css', __FILE__ ) );
		} else {
			global $wp_version;
			if ( floatval( $wp_version ) >= 3.5 ) {
				//Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker' );
			} else {
				//If the WordPress version is less than 3.5 load the older farbtasic color picker.
				//As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
				wp_enqueue_style( 'farbtastic' );
				wp_enqueue_script( 'farbtastic' );
			}
		}

		$custom_post_fields = array(
				'menu_icon' => plugins_url( '/images/webinar.png', __FILE__ ),
				'rewrite' => array(
						'slug' => 'gotowebinar',
				),
		);
		$custom_posts = array(
				'GoToWebinar' => apply_filters( 'gotowebinar_post_fields', $custom_post_fields ),
		);

		$custom_post = new Custom_Post();
		$custom_post->add_custom_posts( $custom_posts );
	}

	function enqueue_webinar_admin_scripts() {
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
	}

	public function enqueue_scripts() {
		if ( ! is_admin() ) {
			wp_enqueue_script( 'placeholder-js', plugins_url( 'js/jquery.placeholder.js', __FILE__ ) );
		}
	}

	function enqueue_webinar_admin_styles() {
		wp_enqueue_style( 'thickbox' );
	}

	function header_js() {
		echo '<script type="text/javascript">';
		echo 'jQuery(function($) { $("input, textarea, email").placeholder();});';
		echo '</script>';
	}

	function add_webinar_meta_box() {
		global $typenow;
		if ( $typenow == 'gotowebinar' ) {
			add_action( 'admin_print_scripts', array( $this, 'enqueue_webinar_admin_scripts' ) );
			add_action( 'admin_print_styles', array( $this, 'enqueue_webinar_admin_styles' ) );
		}
		add_meta_box( 'webinar_meta_box', 'Webinar Details', array(
				$this,
				'webinar_meta_box',
		), 'gotowebinar', 'normal', 'high' );
	}

	function webinar_meta_box( $post ) {
		include_once( plugin_dir_path( __FILE__ ) . 'views/admin-webinar-meta.php' );
	}

	function webinar_meta_box_save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( $_POST['post_type'] == 'gotowebinar' ) {
			// if our nonce isn't there, or we can't verify it, bail
			if ( ! isset( $_POST['meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) {
				return;
			}

			if ( ! current_user_can( 'edit_post' ) ) {
				return;
			}

			$webinar = array();

			foreach ( $_POST['webinar'] as $key => $value ) {
				$webinar[ $key ] = $value;
			}
			update_post_meta( $post_id, 'webinar', $webinar );
		}
	}

	function format_webinar_meta( $post_id ) {
		return array_pop( get_post_meta( $post_id, 'webinar' ) );
	}

	function webinar_template( $template_path ) {
		if ( get_post_type() == 'gotowebinar' ) {
			if ( $theme_file = locate_template( array( 'views/single-gotowebinar.php' ) ) ) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) . 'views/single-gotowebinar.php';
			}
		}

		return $template_path;
	}

	function display_webinar_form( $atts ) {
		$default = array(
				'id' => 0,
				'hide_title' => 'no',
		);
		extract( shortcode_atts( $default, $atts ) );
		if ( $id == 0 ) {
			return 'Please enter a valid Webinar ID.';
		}

		//get webinar meta and details
		$webinar_meta = get_post_meta( $id, 'webinar', true );
		if ( $webinar_meta === false ) {
			return 'There was an error, please make sure that you\'re using the correct Webinar ID.';
		}

		$webinar_fields = $this->get_webinar_fields( $webinar_meta['id'] );

		ob_start();
		include_once( plugin_dir_path( __FILE__ ) . 'views/webinar-form.php' );

		return ob_get_clean();
	}

	function get_webinar_fields( $webinar_id ) {
		$organizer_key = $this->tokens['organizer'];
		$access_token = $this->tokens['access'];
		$gtw_url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $organizer_key . '/webinars/' . $webinar_id . '/registrants/fields';
		$headers = array(
				'HTTP/1.1',
				'Accept: application/json',
				'Accept: application/vnd.citrix.g2wapi-v1.1+json',
				'Content-Type: application/json',
				'Authorization: OAuth oauth_token=' . $access_token,
		);
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_POST, 0 );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl, CURLOPT_URL, $gtw_url );
		curl_setopt( $curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$response = curl_exec( $curl );
		curl_close( $curl );

		/**
		 * answerKeys and questionKeys are being
		 * formatted to float, and being truncated.
		 * In PHP 5.4 they've introduced JSON_BIGINT_AS_STRING
		 * but we can't assume that all hosting
		 * packages will have PHP 5.4 running.
		 *
		 * Therefore, we have to include this hackish
		 * workaround to wrap all numbers within
		 * the response withh quotes.
		 */
		$response = preg_replace( '/("\w+"):(\d+)/', '\\1:"\\2"', $response );
		$request = json_decode( $response, true );

		if ( isset( $request['fields'] ) && ! empty( $request['fields'] ) ) {
			usort( $request['fields'], array( &$this, 'sort_webinar_reg_fields' ) );
		}

		return $request;
	}

	/**
	 * Sort the fields in the webinar registration form. This is a best case sort, so it only sorts fields
	 *
	 * @param unknown $a
	 * @param unknown $b
	 *
	 * @return number
	 */
	private function sort_webinar_reg_fields( $a, $b ) {
		/* let's sort the request results so that a list of common fields will be at the top */
		$sorted_keys = array(
				0 => 'firstName',
				1 => 'lastName',
				2 => 'email',
				3 => 'city',
				4 => 'phone',
				5 => 'organization',
				6 => 'jobTitle',
				7 => 'numberOfEmployees',
		);

		$aIndex = array_search( $a['field'], $sorted_keys );
		$bIndex = array_search( $b['field'], $sorted_keys );

		if ( $aIndex !== false && $bIndex === false ) {
			return - 1;
		}

		if ( $aIndex === false && $bIndex !== false ) {
			return 1;
		}

		if ( $aIndex == $bIndex ) {
			return 0;
		}

		return ( $aIndex < $bIndex ) ? - 1 : 1;
	}

	private function object_to_array( $d ) {
		if ( is_object( $d ) ) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars( $d );
		}

		if ( is_array( $d ) ) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map( __FUNCTION__, $d );
		} else {
			// Return the array
			return $d;
		}
	}

	function register() {
		global $webinarErrors, $wpdb;
		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'webinar_register' ) {
			if ( in_array( $_REQUEST['email'], $this->get_registrant_emails() ) ) {
				$webinarErrors->add( 'error', 'Sorry, this email address is already registered with this webinar' );
			} else {
				/** we need to remove the standard fields from the post. */
				$additional = $_POST;
				unset( $additional['firstName'], $additional['lastName'], $additional['email'], $additional['return_page'], $additional['webinarid'], $additional['action'], $additional['submit'], $additional['cqAns'], $additional['cqQuestion'], $additional['cqType'], $additional['cqKey'], $additional['fAns'] );

				//format questions/answers
				$questions = array();
				if ( isset( $_REQUEST['cqAns'] ) ) {
					foreach ( $_REQUEST['cqAns'] as $key => $answer ) {
						$questions[ $key ] = array(
								'q' => $_REQUEST['cqQuestion'][ $key ],
								'a' => $answer,
								'key' => $_REQUEST['cqKey'][ $key ],
								'type' => $_REQUEST['cqType'][ $key ],
						);
					}
				}

				if ( isset( $_REQUEST['fAns'] ) ) {
					foreach ( $_REQUEST['fAns'] as $key => $answer ) {
						$additional[ $key ] = $answer;
					}
				}
				$additional['questions'] = $questions;
				$registrant = array(
						'first_name' => $_REQUEST['firstName'],
						'last_name' => $_REQUEST['lastName'],
						'email' => $_REQUEST['email'],
						'webinar_id' => $_REQUEST['webinarid'],
						'return_url' => $_REQUEST['return_page'],
						'date_submitted' => date( 'Y-m-d H:i:s' ),
						'additional_fields' => serialize( $additional ),
				);

				$wpdb->insert( $wpdb->prefix . 'webinar_registration', $registrant );
				$this->send_registration( $wpdb->insert_id );
			}
		}
	}

	function get_registrant_emails() {
		$organizer_key = $this->tokens['organizer'];
		$access_token = $this->tokens['access'];
		$gtw_url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $organizer_key . '/webinars/' . $_REQUEST['webinarid'] . '/registrants';
		$headers = array(
				'HTTP/1.1',
				'Accept: application/json',
				'Accept: application/vnd.citrix.g2wapi-v1.1+json',
				'Content-Type: application/json',
				'Authorization: OAuth oauth_token=' . $access_token,
		);
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_POST, 0 );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl, CURLOPT_URL, $gtw_url );
		curl_setopt( $curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$response = curl_exec( $curl );
		curl_close( $curl );
		$request = json_decode( $response );

		$emails = array();
		foreach ( $request as $val ) {
			$emails[] = $val->email;
		}

		return $emails;
	}

	function send_registration( $id ) {
		global $wpdb, $webinarErrors;
		$s = 'select * from ' . $wpdb->prefix . 'webinar_registration where id =' . $id;
		$result = $wpdb->get_row( $s );
		$organizer_key = $this->tokens['organizer'];
		$access_token = $this->tokens['access'];

		$url = 'https://api.citrixonline.com/G2W/rest/organizers/' . $organizer_key . '/webinars/' . $result->webinar_id . '/registrants';

		$curl = curl_init( $url );
		$curl_post_data = array(
				'firstName' => $result->first_name,
				'lastName' => $result->last_name,
				'email' => $result->email,
		);

		//send over additional fields...
		$additional = maybe_unserialize( $result->additional_fields );
		foreach ( $additional as $key => $adtnl ) {
			if ( is_array( $adtnl ) ) {
				foreach ( $adtnl as $k => $a ) {
					$responses[] = array(
							'questionKey' => $a['key'],
							$a['type'] => $a['a'],
					);
				}
			} else {
				$curl_post_data[ $key ] = $adtnl;
			}
		}
		if ( isset( $responses ) ) {
			$curl_post_data['responses'] = $responses;
		}

		$options = array(
				CURLOPT_POST => true,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_POSTFIELDS => json_encode( $curl_post_data ),
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json;',
						'Accept: application/json',
						'Accept: application/vnd.citrix.g2wapi-v1.1+json',
						'Authorization: OAuth oauth_token=' . $access_token,
				),
		);
		curl_setopt_array( $curl, $options );
		$curl_response = json_decode( curl_exec( $curl ) );

		if ( array_key_exists( 'err', $curl_response ) ) {
			$webinarErrors->add( 'error', 'Error in processing your request. <br/>' . $curl_response->err . ': ' . $curl_response->message );
		} elseif ( array_key_exists( 'registrantKey', $curl_response ) ) {
			$webinarErrors->add( 'success', 'You have sucessfully registered for this webinar. ' );
			if ( isset( $result->return_url ) && $result->return_url != '' ) {
				wp_redirect( $result->return_url );
			}
		} else {
			$webinarErrors->add( 'block', $curl_response->description );
		}

	}

	function admin_menus() {
		add_submenu_page( 'edit.php?post_type=gotowebinar', 'GoToWebinar Settings', 'Webinar Settings', 'manage_options', 'webinar_settings', array(
				$this,
				'citrix_oath_page',
		) );
	}

	function citrix_oath_page() {

		if ( isset( $_POST['save'] ) ) {
			foreach ( $_POST['token'] as $key => $value ) {
				$tokens[ $key ] = $value;
			}
			update_option( 'gtw_oauth_token', $tokens );
			$this->tokens = get_option( 'gtw_oauth_token' );
		}
		include_once( plugin_dir_path( __FILE__ ) . 'views/admin-webinar-oauth.php' );
	}

	function show_admin_messages() {
		if ( $this->tokens === false || trim( $this->tokens['access'] ) == '' || trim( $this->tokens['organizer'] ) == '' ) {
			$error = 'Your Webinar Settings are incomplete. Please visit <a href="' . admin_url( 'edit.php?post_type=webinar&page=webinar_settings' ) . '">here</a> to complete.';
		}
		if ( isset( $error ) ) {
			echo '<div id="message" class="error"><p>' . $error . '</p></div>';
		}
	}

	function display_form_messages() {
		global $webinarErrors;
		$types = $webinarErrors->get_error_codes();
		foreach ( $types as $code ) {
			echo '<div class="alert alert-' . $code . '">';
			echo $webinarErrors->get_error_message( $code );
			echo '</div>';
		}
	}

	function gotowebinar_post_fields( $post_type ) {
		return $post_type;
	}
}

register_activation_hook( __FILE__, 'check_webinar_table' );
function check_webinar_table() {
	global $wpdb;
	if ( $wpdb->query( 'show tables like "' . $wpdb->prefix . 'webinar_registration"' ) == 0 ) {
		webinar_table_install();
	}

}

function webinar_table_install() {
	global $wpdb, $wp_version;

	$reg_tbl = 'CREATE TABLE ' . $wpdb->prefix . 'webinar_registration (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`first_name` varchar(30) DEFAULT NULL,
		`last_name` varchar(30) DEFAULT NULL,
		`email` varchar(50) DEFAULT NULL,
		`webinar_id` varchar(50) NOT NULL,
		`return_url` varchar(255) DEFAULT NULL,
		`additional_fields` text,
		`date_submitted` datetime DEFAULT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;';

	$wpdb->query( $reg_tbl );
}

?>