<?php

namespace Tora\Theme;

// Block direct access
if ( ! defined( 'ABSPATH' ) ) { exit ; }


// Remove automatic WordPress redirection
// remove_action( 'template_redirect', 'redirect_canonical' );


// Check if Core plugin is enabled

if ( ! class_exists( 'Tora\Core\Plugin' ) ) {
	add_action( 'admin_notices', function () {
		$class   = 'notice notice-error';
		$message = 'Tora Core plugin is not active. The theme cannot be activated!';

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	});

	return;
}


// Define constants

if ( ! defined( 'TORA_B2C_TEXTDOMAIN' ) ) {
	define( 'TORA_B2C_TEXTDOMAIN', 'tora_b2c_textdomain' );
}

define( 'TORA_B2C_URL', trailingslashit( get_stylesheet_directory_uri() ) );
define( 'TORA_B2C_PATH', trailingslashit( get_stylesheet_directory() ) );

define( 'TORA_B2CINC_URL', trailingslashit( TORA_B2C_URL . 'includes' ) );
define( 'TORA_B2CINC_PATH', trailingslashit( TORA_B2C_PATH . 'includes' ) );

define( 'TORA_B2CJS_URL', trailingslashit( TORA_B2C_URL . 'javascripts' ) );
define( 'TORA_B2CJS_PATH', trailingslashit( TORA_B2C_PATH . 'javascripts' ) );

define( 'TORA_B2CCSS_URL', trailingslashit( TORA_B2C_URL . 'stylesheets' ) );
define( 'TORA_B2CCSS_PATH', trailingslashit( TORA_B2C_PATH . 'stylesheets' ) );

define( 'TORA_B2CIMG_URL', trailingslashit( TORA_B2C_URL . 'images' ) );
define( 'TORA_B2CIMG_PATH', trailingslashit( TORA_B2C_PATH . 'images' ) );

define( 'TORA_B2CTMPL_URL', trailingslashit( TORA_B2C_URL . 'mustache' ) );
define( 'TORA_B2CTMPL_PATH', trailingslashit( TORA_B2C_PATH . 'mustache' ) );

define( 'TORA_B2CPART_URL', trailingslashit( TORA_B2CTMPL_URL . 'partials' ) );
define( 'TORA_B2CPART_PATH', trailingslashit( TORA_B2CTMPL_PATH . 'partials' ) );

define( 'TORA_B2CELEM_URL', trailingslashit( TORA_B2CTMPL_URL . 'elements' ) );
define( 'TORA_B2CELEM_PATH', trailingslashit( TORA_B2CTMPL_PATH . 'elements' ) );


/**
* Base class for Tora theme
*/

class Theme
{

	public function __construct() {
		spl_autoload_register( array( $this, 'autoload' ) );

		global $tora_b2c; $tora_b2c = $this;

		$this->site_url  = get_bloginfo( 'url' );
		$this->site_name = get_bloginfo( 'name' );
		$this->site_desc = get_bloginfo( 'description' );
		$this->per_page  = get_option( 'posts_per_page' );

		$this->templates_path = TORA_B2CTMPL_PATH;
		$this->partials_path  = TORA_B2CPART_PATH;

		$this->register_actions();
		$this->init();
	}

	public function init() {
		load_theme_textdomain( TORA_B2C_TEXTDOMAIN, TORA_B2C_PATH .'languages' );

		$this->elements   = new Elements;
		$this->components = new Components;

		$this->locations = $this->components->locations();
	}

	public function autoload( $class ) {
		$file     = str_replace( __NAMESPACE__ . '\\', null, $class );
		$filename = TORA_B2CINC_PATH . $file . '.php';

		if ( is_readable( $filename ) ) {
			require_once $filename;
		}
	}

	public function logo_url( $name = 'logo' ) {
		$logos = array(
			'logo'         => 'logo.svg',
			'logo-dark'    => 'logo-dark.svg',
			'apple-icon'   => 'apple-icon.png',
			'windows-icon' => 'windows-icon.png',
			'favicon'      => 'favicon.png',
		);

		$logo = isset( $logos[ $name ] ) ? $logos[ $name ] : null;
		$logo = TORA_B2CIMG_URL . $logo;

		return $logo;
	}

	public function opap_logo_url() {
		return TORA_B2CIMG_URL . 'opap-logo.png';
	}

	public function body_class( $classes ) {
		if ( is_singular( 'page' ) ) {
			global $post;
			$classes[] = 'template-'. get_post_meta( $post->ID, 'custom_page_template', true );
		}

		if ( is_singular( 'service' ) ) {
			global $post;
			$classes[] = 'template-'. get_post_meta( $post->ID, 'custom_service_template', true );
		}

		return $classes;
	}

	public function register_actions() {
		// add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		// add_action( 'wp_head', array( $this, 'site_icons' ) );
		// add_action( 'admin_head', array( $this, 'site_icons' ) );
		add_action( 'customize_register', array( $this, 'customizer_controls' ) );

		// add_filter( 'body_class', array( $this, 'body_class' ) );
		// add_filter( 'wp_nav_menu_objects', array( $this, 'extra_menu_classes' ) );

		// add_filter( 'newsletter_form_button_class', array( $this, 'newsletter_form_button_class' ) );
		add_filter( 'register_page_templates', array( $this, 'page_templates' ) );
		add_filter( 'register_service_templates', array( $this, 'service_templates' ) );
	}

	public function register_assets() {
		wp_enqueue_script( 'mustache' );
		//wp_enqueue_script( 'moment' );

		// wp_enqueue_script( 'moment-el' );
		// wp_enqueue_script( 'jquery-clndr' );
		// wp_enqueue_script( 'jquery-vide' );
		// wp_enqueue_script( 'sly' );
		// wp_enqueue_script( 'swiper' );

		wp_enqueue_script( 'google-maps-api' );
		wp_enqueue_script( 'markerclusterer' );

		// wp_enqueue_style( 'swiper' );
		wp_enqueue_style( 'tora-b2c-theme', TORA_B2C_URL . 'style.css', null, null, 'screen' );
		// wp_enqueue_style( 'tora-b2c-theme-additional', TORA_B2C_URL . 'additional.css', null, null, 'screen' );

		wp_enqueue_script( 'foundation', TORA_B2CJS_URL . 'foundation.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'tora-b2c-theme', TORA_B2CJS_URL . 'theme_modified.js', array( 'foundation' ), null, true );

		// wp_deregister_script( 'jquery-core' );
		// wp_register_script( 'jquery-core', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), '3.3.1' );
		// wp_deregister_script( 'jquery-migrate' );
		// wp_register_script( 'jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.0.1.js', array(), '3.0.1' );
		// wp_deregister_script( 'moment' );
		// wp_enqueue_script( 'moment', TORA_B2CJS_URL . 'moment.min.js', array(), '2.24' );

		$this->localize_scripts();
	}

	public function localize_scripts() {
		$options = get_option( 'locations_api_settings' );

		$data = array(
			'ajax_url'             => admin_url( 'admin-ajax.php' ),
			'events_title'         => __( 'Events Today', TORA_B2C_TEXTDOMAIN ),
			'map_marker'           => get_stylesheet_directory_uri() .'/images/map-marker-small.png',
			'cluster_icon'         => get_stylesheet_directory_uri() .'/images/cluster.svg',
			'events_url'           => get_rest_url( null, '/posts/events' ),
			'event_categories_url' => get_rest_url( null, '/categories/events' ),
			'locations_url'        => get_rest_url( null, '/posts/locations' ),
			'map_link_text'        => __( 'Get directions', TORA_B2C_TEXTDOMAIN ),
			'map_tel_text'         => __( 'Tel', TORA_B2C_TEXTDOMAIN ),
			'zoom_out_of_greece'   => $options['locations_map_zoom_out_of_greece'],
		);

		wp_localize_script( 'tora-b2c-theme', 'localize', $data );
	}

	public function setup_theme() {
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( /* 'aside', 'link', 'gallery', 'status', 'quote', 'image' */ ) );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

		$this->register_menus();
	}

	public function site_icons() {
		$icons_meta = array(
			'<link rel="shortcut icon" type="image/png" href="'. $this->logo_url( 'favicon' ) .'" />',
			'<link rel="apple-touch-icon" href="'. $this->logo_url( 'apple-icon' ) .'" />',
			'<meta name="msapplication-TileColor" content="#333333" />',
			'<meta name="msapplication-TileImage" content="'. $this->logo_url( 'windows-icon' ) .'" />',
		);

		echo join( "\n", $icons_meta );
	}

	public function extra_menu_classes( $objects ) {
		$objects[1]->classes[] = 'first';
		$objects[ count( $objects ) ]->classes[] = 'last';

		return $objects;
	}

	public function register_menus() {
		register_nav_menu( 'main-menu', __( 'Main Menu', TORA_B2C_TEXTDOMAIN ) );
		register_nav_menu( 'footer-menu', __( 'Footer Menu', TORA_B2C_TEXTDOMAIN ) );
		register_nav_menu( 'copyright-menu', __( 'Copyright Menu', TORA_B2C_TEXTDOMAIN ) );
		register_nav_menu( 'mobile-menu', __( 'Mobile Menu', TORA_B2C_TEXTDOMAIN ) );
	}

	public function newsletter_form_button_class( $class ) {
		$class = "$class small hollow";
		return $class;
	}

	public function page_templates( $templates ) {
		$templates['locations'] = __( 'Locations', TORA_B2C_TEXTDOMAIN );
		$templates['terms']     = __( 'Terms & Conditions', TORA_B2C_TEXTDOMAIN );
		$templates['faq']       = __( 'FAQ', TORA_B2C_TEXTDOMAIN );
		$templates['contact']   = __( 'Contact', TORA_B2C_TEXTDOMAIN );

		return $templates;
	}

	public function service_templates( $templates ) {
		$templates['bills']   = __( 'Bills', TORA_B2C_TEXTDOMAIN );
		$templates['prepaid'] = __( 'Prepaid', TORA_B2C_TEXTDOMAIN );
		$templates['tickets'] = __( 'Tickets', TORA_B2C_TEXTDOMAIN );
		$templates['airtime'] = __( 'Airtime', TORA_B2C_TEXTDOMAIN );

		return $templates;
	}

	public function customizer_controls( $wp_customize ) {
		$wp_customize->add_section('tora_theme', array(
			'title' => 'Theme Settings',
		));

		$wp_customize->add_setting('show_header_search', array(
			'default' => false,
		));

		$wp_customize->add_control('show_header_search', array(
			'label'   => 'Show header search input',
			'section' => 'tora_theme',
			'type'    => 'checkbox',
		));

		$wp_customize->add_section('map_filters', array(
			'title' => 'Map Filters',
		));

		// dump( location_categories_data() );

		if ( $categories = location_categories_data() ) {
			foreach ( $categories as $category ) {
				$wp_customize->add_setting('show_map_filter_' . $category['id'], array(
					'default' => true,
				));

				$wp_customize->add_control('show_map_filter_' . $category['id'], array(
					'label'   => $category['name'],
					'section' => 'map_filters',
					'type'    => 'checkbox',
				));
			}
		}
	}
}

new Theme;
