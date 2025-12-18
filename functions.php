<?php
/*********************
* CLEAN UP WORDPRESS
*********************/

define( 'ERROR_LOG_PATH', './errorlog.log' );

add_action( 'init', 'dd_cleanup_wp' );

function dd_cleanup_wp() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );

	// wp version from css and js
	add_filter( 'style_loader_src', 'remove_wp_ver_css_js', 9999 );
	add_filter( 'script_loader_src', 'remove_wp_ver_css_js', 9999 );

	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );

	// disable wordpress auto oEmbed scripts
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );

	/*********************************** TORA LEGACY ***************************************/
	require_once( 'legacy/includes/Elements.php' );
	require_once( 'legacy/includes/Components.php' );
	require_once( 'legacy/functions.php' );
}


add_filter( 'xmlrpc_enabled', '__return_false', -100000000 );

function remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}

function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
// end of clean up



/********************
 ***** INCLUDES *****
 ********************/

require_once( 'library/includes/browser-body-classes.php' ); // Add User Browser and OS Classes in WordPress Body Class
require_once( 'asides/register-sidebars.php' ); // REGISTER SIDEBARS
require_once( 'library/includes/shortcodes.php' ); // SHORTCODES



/*****************************************************
 ***** ADD THEME SUPPORT AND THEME RELATED STUFF *****
 *****************************************************/

add_action( 'after_setup_theme', 'dd_setup_theme' );

function dd_setup_theme() {

	/* https://codex.wordpress.org/Function_Reference/add_theme_support */
	add_theme_support( 'title-tag' );
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	// add_theme_support( 'automatic-feed-links' );
	// add_theme_support( 'post-formats', array() );
	// add_theme_support( 'html5', array() );
	// add_theme_support( 'custom-logo' );

	// register menus function
	register_nav_menus(
		array(
			'main-nav' 	 => __( 'The Main Menu', 'thisisbare' ),
			'mobile-nav' => __( 'The Mobile Menu', 'thisisbare' ),
			'footer-nav' => __( 'The Footer Menu', 'thisisbare' ),
			'social-nav' => __( 'Social Menu', 'thisisbare' ),
		)
	);

	load_theme_textdomain( 'thisisbare', get_template_directory() . '/library/languages' );

	add_filter( 'the_content', 'filter_ptags_on_images' );
}

function filter_ptags_on_images( $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}
// end theme support and theme related stuff



/***************************
THUMBNAIL SIZES
***************************/
/*
add_image_size( 'thumb-600', 600, 150, true );

add_filter( 'image_size_names_choose', 'custom_image_sizes' );

function custom_image_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'thumb-600' => __( '600px by 150px' ),
	) );
}
*/



/***************************
ENQUEUEING SCRIPTS & STYLES
***************************/

add_action( 'wp_enqueue_scripts', 'dd_scripts_and_styles', 999 );

function dd_scripts_and_styles() {
	wp_deregister_script( 'google-maps-api' );

	$maps_key = geocode_api_key();

	wp_register_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?libraries=places,geometry&language=el&key=' . $maps_key, null, null, true );

	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/library/js/slick/slick.css' );
	wp_enqueue_style( 'slick_theme', get_stylesheet_directory_uri() . '/library/js/slick/slick-theme.css' );
	wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/library/js/slick/slick.min.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'slicknav', get_stylesheet_directory_uri() . '/library/js/slicknav/jquery.slicknav.min.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'pagination', get_stylesheet_directory_uri() . '/library/js/pagination.min.js', array( 'jquery' ), '', true );

	wp_enqueue_style( 'theme_style', get_stylesheet_directory_uri() . '/library/css/style.css' );
	wp_register_script( 'theme_script', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'slick', 'pagination' ), '', true );

	/** New Css File */
	wp_enqueue_style( 'theme_new_style', get_stylesheet_directory_uri() . '/library/css/new-style.css' );
	/** New Script */
	wp_register_script( 'theme_new_script', get_stylesheet_directory_uri() . '/library/js/new-script.js', false, '', true );
	wp_enqueue_script( 'theme_new_script' );

	// localize script to pass usefull variables to theme scripts
	// https://codex.wordpress.org/Function_Reference/wp_localize_script

	$global_vars = array(
		// get url for functions.php
		'site_url'     => get_bloginfo( 'url' ),
		'template_url' => get_template_directory_uri(),
	);

	$services_options       = get_field( 'complaint_form_services', 'option' );
	$services_options_array = array();
	if ( ! empty( $services_options ) ) {
		foreach ( $services_options as $services_option ) {
			if ( empty( $services_option['service']['transaction_details'] ) || ! is_array( $services_option['service']['transaction_details'] ) ) {
				continue;
			}
			foreach ( $services_option['service']['transaction_details'] as $transaction_detail ) {
				if ( ! empty( $transaction_detail['value'] ) || 0 === $transaction_detail['value'] ) {
					if ( empty( $services_options_array[ $services_option['service']['name'] ] ) ) {
						$services_options_array[ $services_option['service']['name'] ] = array();
					}
					$services_options_array[ $services_option['service']['name'] ][] = $transaction_detail['value'];
				}
			}
		}
	}

	$global_vars['services'] = $services_options_array;

	wp_localize_script( 'theme_script', 'global_vars', $global_vars );
	wp_enqueue_script( 'theme_script' );

	if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1 ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'font-awesome-5', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css' );
}

/**  load bootstrap css */
function load_css() {
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/library/css/bootstrap.min.css', array(), false, 'all');
	wp_enqueue_style( 'bootstrap' );
}
add_action( 'wp_enqueue_scripts', 'load_css' );

/** Load bootstrap js */
function load_js() {

	// wp_register_script( 'jquery3', get_template_directory_uri() .  '/library/js/jquery3.4.1.slim.min.js' ,  '' , true , true);
	wp_register_script( 'popper', get_template_directory_uri() . '/library/js/popper.min.js', '', false, true );
	wp_register_script( 'bootstrapjs', get_template_directory_uri() . '/library/js/bootstrap.min.js', '', false, true );
	// wp_enqueue_script('jquery3');
	wp_enqueue_script( 'popper' );
	wp_enqueue_script( 'bootstrapjs' );

	// wp_deregister_script( 'contact-form-7' ); // deregister contact form 7 js

}
add_action( 'wp_enqueue_scripts', 'load_js' );

/*************************************************
ADD DEFER & ASYNC ATTRIBUTES TO WORDPRESS SCRIPTS
*************************************************/

function dd_async_defer_attribute( $tag, $handle ) {
	if ( 'font-awesome' === $handle ) {
		$tag = str_replace( ' src', ' defer="defer" src', $tag );
	}

	return $tag;
}
// add_filter( 'script_loader_tag', 'dd_async_defer_attribute', 10, 2 );



/*******************
OEMBED SIZE OPTIONS
*******************/

if ( ! isset( $content_width ) ) {
	$content_width = 975;
}



/**********************
SET THE EXCERPT LENGTH
**********************/

function mtl_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'mtl_excerpt_length', 999 );



/***********************************
ALLOW SVG FILES FROM MEDIA UPLOADER
***********************************/

// function mtl_mime_types( $mimes ) {
// 	$mimes['svg'] = 'image/svg+xml';
// 	return $mimes;
// }
// add_filter( 'upload_mimes', 'mtl_mime_types' );



/***********
* HIDE NAGS
************/

function hide_update_notice_to_all_but_admin_users() {
	if ( ! current_user_can( 'update_core' ) ) {
		remove_action( 'admin_notices', 'update_nag', 3 );
	}
}

add_action( 'admin_head', 'hide_update_notice_to_all_but_admin_users', 1 );



/*************************
A BETTER VAR_DUMP
*************************/

function dump( $att ) {
	echo '<pre>';
	var_dump( $att );
	echo '</pre>';
}



/************************
 ***** OPTIONS PAGE *****
 ************************/

 if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( array(
		'page_title' => 'Theme Options',
		'icon_url'   => 'dashicons-edit',
		'position'	 => '2.1',
	) );
}



/**********************
 ***** LOGIN LOGO *****
 **********************/

 function tora_login_logo() {
	?>
	<style type="text/css">
		#login h1 a,
		.login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/library/images/login-logo.svg);
			height: 104px;
			width: 200px;
			background-size: 200px 104px;
			background-repeat: no-repeat;
			padding-bottom: 0;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'tora_login_logo' );


function my_login_logo_url() {
	return esc_url( 'https://www.opap.gr/' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );


function my_login_logo_url_title() {
	return 'opap Group';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );



/************************************
 ***** DASHBOARD COLOR PALLETTE *****
 ************************************/

 function tora_additional_admin_color_schemes() {
	//Get the theme directory
	$theme_dir = get_stylesheet_directory_uri();

	//Tora
	wp_admin_css_color(
		'tora-blue',
		__( 'Tora Blue', 'tora' ),
		$theme_dir . '/library/css/admin/admin-colors/tora-blue/colors.css',
		array( '#163a79', '#2d9edf', '#ffffff' ),
		array( 'base' => '#163a79', 'focus' => '#2d9edf', 'current' => '#ffffff' )
	);
}
add_action( 'admin_init', 'tora_additional_admin_color_schemes' );



/*********************************
 ***** CHANGE DASHBOARD LOGO *****
 *********************************/

 function tora_remove_wp_dashboard_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'wp-logo' );
	$wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'tora_remove_wp_dashboard_logo' );


function tora_dashboard_logo( $wp_admin_bar ) {
	$wp_admin_bar->add_node( array(
		'id' 	=> 'opap-group',
		'title' => '<span class="opap-icon"></span>OPAP Group',
		'href' 	=> esc_url( 'https://www.opap.gr/' ),
		'meta' 	=> array(
			'target' => '_blank',
		),
	) );
}
add_action( 'admin_bar_menu', 'tora_dashboard_logo', 1 );


function tora_admin_scripts() {
	wp_enqueue_style( 'add_custom_wp_toolbar_css', get_stylesheet_directory_uri() . '/library/css/admin/style.css' );
}
add_action( 'admin_enqueue_scripts', 'tora_admin_scripts' );



/*************
* WOOCOMMERCE
**************/

// Declare Woocommerce Support
add_action( 'after_setup_theme', 'woocommerce_support' );

function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}


// Disable the default stylesheet
// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


/**
* Remove checkout fields
*/
add_filter( 'woocommerce_checkout_fields' , 'ddot_override_checkout_fields' );

function ddot_override_checkout_fields( $fields ) {

	// unset( $fields['billing']['billing_first_name'] );
	// unset( $fields['billing']['billing_last_name'] );
	// unset( $fields['billing']['billing_company'] );
	// unset( $fields['billing']['billing_address_1'] );
	// unset( $fields['billing']['billing_address_2'] );
	// unset( $fields['billing']['billing_city'] );
	// unset( $fields['billing']['billing_postcode'] );
	// unset( $fields['billing']['billing_country'] );
	// unset( $fields['billing']['billing_state'] );
	// unset( $fields['billing']['billing_phone'] );
	// unset( $fields['order']['order_comments'] );
	// unset( $fields['billing']['billing_email'] );
	// unset( $fields['account']['account_username'] );
	// unset( $fields['account']['account_password'] );
	// unset( $fields['account']['account_password-2'] );

	return $fields;
}


/**
* Remove woocommerce breadcrumbs
*/
add_action( 'init', 'ddot_remove_wc_breadcrumbs' );

function ddot_remove_wc_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}



/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );
// end WOOCOMMERCE


// function remove_spans_from_cf( $content ) {
// 	$content = preg_replace( '/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content );
// 	return $content;
// }
// add_filter( 'wpcf7_form_elements', 'remove_spans_from_cf' );

function custom_form_validation( $result, $tags ) {
	$e_mail          = trim( $_POST['e-mail'] );
	$tel             = trim( $_POST['tel'] );
	$response_method = trim( $_POST['response-method'] );

	if ( ! empty( $tags ) ) {
		foreach ( $tags as $tag ) {
			if ( 'fullname' === $tag->name ) {
				$fullname = trim( $_POST['fullname'] );
				if ( empty( $fullname ) ) {
					$result->invalidate( $tag, __( 'Αυτο το πεδίο είναι υποχρεωτικό.', 'tora' ) );
				} elseif ( ! preg_match( '/^[\p{Greek}a-zA-Zα-ωΑ-ΩίϊΐόάέύϋΰήώΊΪΌΆΈΎΫΉΏ.\s]+$/u', $fullname ) ) {
					$result->invalidate( $tag, __( 'Εχετε εισάγει ειδικούς χαρακτήρες', 'tora' ) );
				}
			}
			if ( 'afm' === $tag->name ) {
				$afm = trim( $_POST['afm'] );
				if ( ! preg_match( '/^[0-9]{9}$/', $afm ) ) {
					$result->invalidate( $tag, __( 'Το ΑΦΜ δεν είναι έγκυρο', 'tora' ) );
				}
			}
			if ( 'zipcode' === $tag->name ) {
				$zipcode = trim( $_POST['zipcode'] );
				if ( ! preg_match( '/^[0-9]{3}[ ]{0,1}[0-9]{2}$/', $zipcode ) ) {
					$result->invalidate( $tag, __( 'Ο Τ.Κ. δεν είναι έγκυρος', 'tora' ) );
				}
			}
			if ( 'address' === $tag->name ) {
				$address = trim( $_POST['address'] );
				if ( ! preg_match( '/^[\p{Greek}a-zA-Zα-ωΑ-ΩίϊΐόάέύϋΰήώΊΪΌΆΈΎΫΉΏ. ]+[0-9-]{0,7}$/u', $address ) ) {
					$result->invalidate( $tag, __( 'Η διεύθυνση έδρας δεν είναι έγκυρη', 'tora' ) );
				}
			}
			if ( 'city' === $tag->name ) {
				$city = trim( $_POST['city'] );
				if ( ! preg_match( '/^[\p{Greek}a-zA-Zα-ωΑ-ΩίϊΐόάέύϋΰήώΊΪΌΆΈΎΫΉΏ.\s]+$/u', $city ) ) {
					$result->invalidate( $tag, __( 'Εχετε εισάγει ειδικούς χαρακτήρες', 'tora' ) );
				}
			}
			if ( 'phone' === $tag->name ) {
				$phone = trim( $_POST['phone'] );
				if ( ! preg_match( '/^(\+30){0,3}[ ]{0,1}69[0-9 ]{8,11}$/', $phone ) && ! preg_match( '/^(\+30){0,3}[ ]{0,1}2[0-9 ]{8,11}$/', $phone ) ) {
					$result->invalidate( $tag, __( 'Το τηλέφωνο δεν είναι έγκυρο', 'tora' ) );
				}
			}
			if ( 'tel' === $tag->name ) {
				$tel             = trim( $_POST['tel'] );
				$e_mail          = trim( $_POST['e-mail'] );
				$response_method = trim( $_POST['response-method'] );

				if ( empty( $e_mail ) && empty( $tel ) ) {
					$result->invalidate( $tag, __( 'Πρέπει να συμπληρωθεί τουλάχιστον ένα από τα δύο πεδία, "email" και "τηλέφωνο"', 'tora' ) );
				} elseif ( ! empty( $tel ) ) {
					if ( ! preg_match( '/^(\+30){0,3}[ ]{0,1}69[0-9 ]{8,11}$/', $tel ) && ! preg_match( '/^(\+30){0,3}[ ]{0,1}2[0-9 ]{8,11}$/', $tel ) ) {
						$result->invalidate( $tag, __( 'Το τηλέφωνο δεν είναι έγκυρο', 'tora' ) );
					}
				} else {
					if ( 'Μέσω τηλεφωνικής επικοινωνίας' === $response_method ) {
						$result->invalidate( $tag, __( 'Παρακαλώ πολύ, καταχωρήστε το τηλέφωνό σας ή αλλάξτε τρόπο απάντησης', 'tora' ) );
					}
				}
			}
			if ( 'other-legalform' === $tag->name ) {
				$other_legalform = trim( $_POST['other-legalform'] );
				$legalform       = trim( $_POST['legalform'] );
				if ( 'Άλλο' === $legalform && empty( $other_legalform ) ) {
					$result->invalidate( $tag, __( 'Αυτο το πεδίο είναι υποχρεωτικό.', 'tora' ) );
				}
			}
			// if tag name is tan, then allow only 9 numbers
			if ( 'tan' === $tag->name ) {
				$tan = trim( $_POST['tan'] );
				if ( ! empty( $tan) && ! preg_match( '/^[0-9]{9}$/', $tan ) ) {
					$result->invalidate( $tag, __( 'Ο Αριθμός συναλλαγής (ΤΑΝ) δεν είναι έγκυρος', 'tora' ) );
				}
			}

			// if tag name is card-transaction-auth-num allow only 6 numbers
			if ( 'card-transaction-auth-num' === $tag->name ) {
				$card_transaction_auth_num = trim( $_POST['card-transaction-auth-num'] );
				if ( ! empty( $card_transaction_auth_num ) && ! preg_match( '/^[0-9]{6}$/', $card_transaction_auth_num ) ) {
					$result->invalidate( $tag, __( 'Ο Αριθμός δεν είναι έγκυρος', 'tora' ) );
				}
			}

			if ( 'e-mail' === $tag->name ) {
				$e_mail          = trim( $_POST['e-mail'] );
				$tel             = trim( $_POST['tel'] );
				$response_method = trim( $_POST['response-method'] );

				if ( empty( $e_mail ) && empty( $tel ) ) {
					$result->invalidate( $tag, __( 'Πρέπει να συμπληρωθεί τουλάχιστον ένα από τα δύο πεδία, "email" και "τηλέφωνο"', 'tora' ) );
				}

				if ( empty( $e_mail ) && 'Μέσω Εmail' === $response_method ) {
					$result->invalidate( $tag, __( 'Παρακαλώ πολύ, καταχωρήστε το e-mail σας ή αλλάξτε τρόπο απάντησης', 'tora' ) );
				}
			}
			if ( 'response-method' === $tag->name ) {
				if ( ( empty( $e_mail ) && 'Μέσω Εmail' === $response_method ) || ( empty( $tel ) && 'Μέσω τηλεφωνικής επικοινωνίας' === $response_method ) ) {
					$result->invalidate( $tag, __( 'Παρακαλώ πολύ καταχωρήστε τα αντίστοιχα στοιχεία επικοινωνίας σας ή αλλάξτε τρόπο απάντησης', 'tora' ) );
				}
			}

			if ( 'upload-file' === $tag->name ) {
				if ( 'dndError' === $_POST['upload-file-val'] ) {
					$result->invalidate( $tag, __( '', 'tora' ) );
				}
			}
		}
	}

	return $result;
}
add_filter( 'wpcf7_validate', 'custom_form_validation', 10, 2 );


function populate_services_options( $n, $options, $args ) {
	if ( in_array( 'service_values', $options, true ) ) {

		$services_options = get_field( 'complaint_form_services', 'option' );

		$test = 1;

		return array_map(
			function( $el ) {
				return $el['service']['name'];
			},
			$services_options
		);
	}

	return $n;
}
add_filter( 'wpcf7_form_tag_data_option', 'populate_services_options', 10, 3 );


add_filter( 'wpcf7_autop_or_not', '__return_false' );


// function remove_limited_flamingo_role() {
//     remove_role('limited_flamingo_viewer');
//     delete_option('limited_flamingo_role_created'); // Αν χρησιμοποίησες option
// }
// add_action('init', 'remove_limited_flamingo_role');



function dd_register_limited_flamingo_role() {
	$role = get_role( 'limited_flamingo_viewer' );

	if ( ! $role ) {
		$role = add_role(
			'limited_flamingo_viewer',
			'Limited Form Viewer',
			array(
				'read'      => true,
				'edit_users'=> true,
				'read'                             => true,
				'flamingo_manage_inbound_messages' => true,
				'flamingo_edit_contact'            => false,
				'flamingo_edit_contacts'           => false,
				'flamingo_delete_contact'          => false,
				'flamingo_edit_inbound_message'    => true,
				'flamingo_edit_inbound_messages'   => true,
				'flamingo_delete_inbound_message'  => true,
				'flamingo_delete_inbound_messages' => true,
				'flamingo_spam_inbound_message'    => true,
				'flamingo_unspam_inbound_message'  => true,
				'flamingo_edit_outbound_message'   => true,
				'flamingo_delete_outbound_message' => true,
			)
		);
	}

	if ( $role && ! $role->has_cap( 'edit_users' ) ) {
		$role->add_cap( 'edit_users' );
	}
}
add_action( 'init', 'dd_register_limited_flamingo_role' );


function dd_restrict_user_management_for_limited_viewer( $caps, $cap, $user_id, $args ) {
	$user = get_user_by( 'id', $user_id );

	if ( ! $user ) {
		return $caps;
	}

	if ( ! in_array( 'limited_flamingo_viewer', (array) $user->roles, true ) ) {
		return $caps;
	}

	$blocked_caps = array(
		'edit_user',
		'promote_user',
		'delete_user',
		'remove_user',
		'list_users',
	);

	if ( in_array( $cap, $blocked_caps, true ) ) {
		return array( 'do_not_allow' );
	}

	return $caps;
}
add_filter( 'map_meta_cap', 'dd_restrict_user_management_for_limited_viewer', 10, 4 );


function dd_limit_admin_menu_for_limited_flamingo_viewer() {
	$user = wp_get_current_user();

	if ( ! $user || ! in_array( 'limited_flamingo_viewer', (array) $user->roles, true ) ) {
		return;
	}

	if ( in_array( 'administrator', (array) $user->roles, true ) ) {
		return;
	}

	remove_menu_page( 'index.php' ); // Dashboard
	remove_menu_page( 'edit.php' ); // Posts
	remove_menu_page( 'upload.php' ); // Media
	remove_menu_page( 'edit.php?post_type=page' ); // Pages
	remove_menu_page( 'edit-comments.php' ); // Comments
	remove_menu_page( 'themes.php' ); // Appearance
	remove_menu_page( 'plugins.php' ); // Plugins
	remove_menu_page( 'users.php' ); // Users
	remove_menu_page( 'tools.php' ); // Tools
	remove_menu_page( 'options-general.php' ); // Settings
	remove_menu_page( 'profile.php' ); // Profile
	remove_menu_page( 'wpcf7' ); // Contact Form 7.

	remove_menu_page( 'Security Settings' );

	remove_submenu_page( 'flamingo', 'flamingo' );
}
add_action( 'admin_menu', 'dd_limit_admin_menu_for_limited_flamingo_viewer', 999 );


function dd_filter_flamingo_messages_by_form( $query ) {
	if ( ! is_admin() ) {
		return;
	}

	if ( ! isset( $_GET['page'] ) || 'flamingo_inbound' !== $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	$user = wp_get_current_user();

	if ( ! $user || ! in_array( 'limited_flamingo_viewer', (array) $user->roles, true ) ) {
		return;
	}

	$allowed_form = 'Uploads Form';

	$query->set(
		'meta_query',
		array(
			array(
				'key'     => '_subject',
				'value'   => $allowed_form,
				'compare' => '=',
			),
		)
	);
}
add_action( 'pre_get_posts', 'dd_filter_flamingo_messages_by_form' );


function dd_redirect_limited_flamingo_viewer_after_login( $redirect_to, $request, $user ) {
	if ( ! $user instanceof WP_User ) {
		return $redirect_to;
	}

	// error_log( gmdate( 'Y-m-d h:i:sa', strtotime( 'NOW' ) ) . ' - **** DEBUG MODE ****' . PHP_EOL . json_encode( $redirect_to, JSON_UNESCAPED_UNICODE ) . PHP_EOL . PHP_EOL, 3, ERROR_LOG_PATH );

	if ( in_array( 'limited_flamingo_viewer', (array) $user->roles, true ) ) {
		wp_safe_redirect( admin_url() );
		exit;
	}

	return $redirect_to;
}
add_filter( 'login_redirect', 'dd_redirect_limited_flamingo_viewer_after_login', 999, 3 );


function dd_block_security_settings_page() {

	$user = wp_get_current_user();
	if ( ! $user || ! in_array( 'limited_flamingo_viewer', (array) $user->roles, true ) ) {
		return;
	}

	$current_page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	// If the user tries to access the XML-RPC Security page, redirect them to the dashboard
	if ( 'Security Settings' === $current_page ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
}
add_action( 'admin_init', 'dd_block_security_settings_page' );

function dd_remove_edit_profile_from_admin_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'edit-profile' );
	$wp_admin_bar->remove_node( 'user-info' );
	$wp_admin_bar->remove_node( 'my-account' );
}
add_action( 'admin_bar_menu', 'dd_remove_edit_profile_from_admin_bar', 999 );


function tora_cf7_attach_all_uploaded_files( $components ) {

	$submission = WPCF7_Submission::get_instance();

	if ( ! $submission ) {
		return $components;
	}

	$uploaded_files = $submission->uploaded_files();
	$attachments    = array();

	foreach ( $uploaded_files as $files ) {

		if ( is_array( $files ) ) {

			foreach ( $files as $file ) {

				if ( is_string( $file ) && file_exists( $file ) ) {
					$attachments[] = $file;
				}
			}
		} elseif ( is_string( $files ) && file_exists( $files ) ) {
			$attachments[] = $files;
		}
	}

	if ( ! empty( $attachments ) ) {
		$components['attachments'] = array_unique(
			array_merge(
				(array) $components['attachments'],
				$attachments
			)
		);
	}

	return $components;
}

add_filter( 'wpcf7_mail_components', 'tora_cf7_attach_all_uploaded_files' );

// DEBUG INFO DISPLAY
// add_action( 'admin_notices', function() {
// 	$user = wp_get_current_user();
// 	if ( in_array( 'limited_flamingo_viewer', (array) $user->roles, true ) ) {
// 		echo '<div style="background: yellow; padding: 20px; margin: 20px;">';
// 		echo '<strong>DEBUG INFO:</strong><br>';
// 		echo 'User ID: ' . $user->ID . '<br>';
// 		echo 'Roles: ' . implode( ', ', $user->roles ) . '<br>';
// 		echo 'Has flamingo_edit_inbound_messages: ' . ( $user->has_cap( 'flamingo_edit_inbound_messages' ) ? 'YES' : 'NO' ) . '<br>';
// 		echo 'Has read: ' . ( $user->has_cap( 'read' ) ? 'YES' : 'NO' ) . '<br>';
// 		echo 'Has edit_posts: ' . ( $user->has_cap( 'edit_posts' ) ? 'YES' : 'NO' ) . '<br>';
// 		echo '</div>';
// 	}

// 	global $menu;
// 	echo '<div style="background: yellow; padding: 20px; margin: 20px;">';
//     foreach ( $menu as $item ) {
//         echo json_encode( $item ) . '<br>';
//     }
// 	echo '</div>';
// });

