<?php
/*********************
* CLEAN UP WORDPRESS
*********************/

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
    wp_register_script( 'theme_new_script', get_stylesheet_directory_uri() . '/library/js/new-script.js', false , '', true );
    wp_enqueue_script('theme_new_script');

	// localize script to pass usefull variables to theme scripts
	// https://codex.wordpress.org/Function_Reference/wp_localize_script
	$global_vars = array(
		'site_url' 	   => get_bloginfo( 'url' ),
		'template_url' => get_template_directory_uri(),
	);
	wp_localize_script( 'theme_script', 'global_vars', $global_vars );
	wp_enqueue_script( 'theme_script' );

	if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1 ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'font-awesome-5', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css' );
}

/**  load bootstrap css */
function load_css () {
    wp_register_style('bootstrap' , get_template_directory_uri() .  '/library/css/bootstrap.min.css' ,  array(), false , 'all');
    wp_enqueue_style('bootstrap');
}
add_action( 'wp_enqueue_scripts', 'load_css' );

/** Load bootstrap js */
function load_js() {
   
    // wp_register_script( 'jquery3', get_template_directory_uri() .  '/library/js/jquery3.4.1.slim.min.js' ,  '' , true , true);
    wp_register_script( 'popper', get_template_directory_uri() .  '/library/js/popper.min.js' ,  '' , false , true);
    wp_register_script( 'bootstrapjs', get_template_directory_uri() .  '/library/js/bootstrap.min.js' ,  '' , false , true);
    // wp_enqueue_script('jquery3');
    wp_enqueue_script('popper');
    wp_enqueue_script('bootstrapjs');
 
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
