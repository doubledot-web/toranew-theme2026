<?php

namespace Tora\Theme;

// Block direct access
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
* Component renderer for themes
*/

class Components
{
	public function __construct() {
		global $tora_b2c;

		$this->theme    = $tora_b2c;
		$this->elements = $tora_b2c->elements;
	}

	public function header() {
		$hotline     = get_contact_settings();
		$show_search = get_theme_mod( 'show_header_search', false );

		$args = array(
			'actions' => 'wp_header',
			'partial' => 'header',
			'args'    => array(
				'site_url'       => $this->theme->site_url,
				'site_name'      => $this->theme->site_name,
				'site_logo'      => $this->theme->logo_url(),
				'opap_logo'      => $this->theme->opap_logo_url(),
				'social'         => $this->elements->social_accounts( 'header' ),
				'menu'           => $this->elements->main_menu(),
				'hotline_number' => $hotline['hotline'],
				'search_form'    => $show_search ? $this->elements->search_form() : null,
			),
		);

		return $args;
	}

	public function footer() {
		$year    = date( 'Y' );
		$hotline = get_contact_settings();

		$args = array(
			'actions' => 'wp_footer',
			'partial' => 'footer',
			'args'    => array(
				'menu'           => $this->elements->footer_menu(),
				'copyright'      => "Copyright &copy; $year tora. All Rights Reserved.",
				'copyright_menu' => $this->elements->copyright_menu(),
				'hotline'        => __( 'Hotline', TORA_B2C_TEXTDOMAIN ),
				'hotline_number' => $hotline['hotline'],
				'social_media'   => __( 'Social Media', TORA_B2C_TEXTDOMAIN ),
				'social'         => $this->elements->social_accounts(),
			),
		);

		return $args;
	}

	public function page() {
		if ( is_front_page() ) { return; }
		if ( ! page_has_template( 'default' ) ) { return; }
		if ( ! is_singular( 'page' ) ) { return; }

		global $post;

		$args = array(
			'actions' => 'main_content',
			'partial' => 'page',
			'args'    => array(
				'title'   => $post->post_title,
				'content' => apply_filters( 'the_content', $post->post_content ),
				'image'   => featured_media( $post->ID, 'background', 'large' ),
			),
		);

		return $args;
	}

	public function service() {
		if ( ! is_singular( 'service' ) ) { return; }

		global $post;

		$description = post_description( $post->ID );
		$subservices = $this->elements->service_subservices( $post->ID );
		$section     = $description || $subservices;

		$args = array(
			'actions' => 'main_content',
			'partial' => 'service',
			'args'    => array(
				'title'             => $post->post_title,
				'image'             => featured_media( $post->ID, 'background', 'large' ),
				'content'           => apply_filters( 'the_content', $post->post_content ),
				'description'       => $description,
				'services'          => $this->elements->additional_services( $post->ID ),
				'faq_section'       => $this->elements->faq_section(),
				'locations_section' => $this->elements->locations_section( $post->ID ),
				'subservices'       => $subservices,
				'section'           => $section,
				'events'            => service_has_template( 'tickets' ),
				'events_title'      => __( 'Event Calendar', TORA_B2C_TEXTDOMAIN ),
			),
		);

		return $args;
	}

	public function home() {
		if ( ! is_front_page() ) { return; }

		global $wp_query;

		$home     = get_page( get_option( 'page_on_front' ) );
		$location = get_page_by_template( 'locations' );
		$more     = __( 'More', TORA_B2C_TEXTDOMAIN );

		$args = array(
			'actions' => 'main_content',
			'partial' => 'home',
			'args'    => array(
				'header' => array(
					'title'    => $home->post_title,
					'content'  => apply_filters( 'widget_text_content', get_post_excerpt( $home ) ),
					'image'    => featured_media( $home->ID, 'background', 'large' ),
				),
				'services' => $this->elements->services_home_sections(),
			),
		);

		if ( $location ) {
			$count = number_format( locations_count(), 0, ',', '.' );

			$args['args']['location'] = array(
				'title'      => $count .' '. __( 'Total TORA points in Greece', TORA_B2C_TEXTDOMAIN ),
				'content'    => apply_filters( 'widget_text_content', get_post_excerpt( $location ) ),
				'link'       => get_permalink( $location->ID ),
				'button'     => __( 'Find your location', TORA_B2C_TEXTDOMAIN ),
				'image'      => get_stylesheet_directory_uri() .'/images/map.png',
				'map_marker' => get_stylesheet_directory_uri() .'/images/map-marker.png',
			);
		}

		return $args;
	}

	public function locations() {
		// if ( ! is_singular( 'page' ) ) { return; }
		// if ( ! page_has_template( 'locations' ) ) { return; }

		$categ_data = location_categories_data();

		// TEMP FIX (map/switches empty on translated pages): WPML filters get_terms() to the current
		// language via its own 'get_terms' hook (not covered by suppress_filters), so untranslated
		// location-category terms vanish entirely instead of falling back. Temporarily switch to the
		// default language via WPML's official API, re-fetch, then switch back.
		if ( empty( $categ_data ) && has_action( 'wpml_switch_language' ) ) {
			$default_lang = apply_filters( 'wpml_default_language', null );
			do_action( 'wpml_switch_language', $default_lang );

			$original_terms = get_terms( array(
				'taxonomy'   => 'location-category',
				'hide_empty' => true,
			) );

			do_action( 'wpml_switch_language', null ); // restore the request's original language

			$categ_data = array();
			foreach ( $original_terms as $term ) {
				$active = ! isset( $_GET['categories'] ) || in_array( $term->term_id, $_GET['categories'] );

				$categ_data[] = array(
					'id'      => $term->term_id,
					'name'    => $term->name,
					'checked' => $active ? 'checked="checked"' : false,
				);
			}
		}

		$categories = array();

		if ( $categ_data ) {
			foreach ( $categ_data as $category ) {
				$enabled = get_theme_mod( 'show_map_filter_' . $category['id'], false );

				// dump( $enabled );

				if ( $enabled ) { $categories[] = $category; }
			}
		}

		// TEMP DEBUG (locations map/switches missing on /en/) - remove once root cause is confirmed
		do_debug( 'Components::locations() - REQUEST_URI=' . $_SERVER['REQUEST_URI']
			. ' | categ_data_count=' . count( (array) $categ_data )
			. ' | categories_count=' . count( $categories )
			. ' | categ_data=' . print_r( $categ_data, true ) );

		$args = array(
			'actions' => 'main_content',
			'partial' => 'locations',
			'args'    => array(
				// 'title'          => $post->post_title,
				// 'content'        => apply_filters( 'the_content', $post->post_content ),
				// 'image'          => featured_media( $post->ID, 'background', 'large' ),
				'map_marker'     => get_stylesheet_directory_uri() .'/images/map-marker.png',
				'map_loader'     => get_stylesheet_directory_uri() .'/images/loader.svg',
				'map_no_content' => get_stylesheet_directory_uri() .'/images/sorry.png',
				'map_title'      => __( 'Find the closest tora spot', TORA_B2C_TEXTDOMAIN ),
				'filter_text'    => __( 'Filter results', TORA_B2C_TEXTDOMAIN ),
				'search_form'    => $this->elements->search_form( array( 'group_class' => 'filters-search' ) ),
				'province_title' => __( 'Select province', TORA_B2C_TEXTDOMAIN ),
				'all_provinces'  => __( 'All provinces', TORA_B2C_TEXTDOMAIN ),
				'service_title'  => __( 'Select service', TORA_B2C_TEXTDOMAIN ),
				'provinces'      => locations_post_meta( 'province', true ),
				'categ_section'  => ! empty( $categories ),
				'categories'     => $categories,
			),
		);

		return $args;
	}

	public function faq() {
		if ( ! is_singular( 'page' ) ) { return; }
		if ( ! page_has_template( 'faq' ) ) { return; }

		global $post;

		$args = array(
			'actions' => 'main_content',
			'partial' => 'faq',
			'args'    => array(
				'title'     => $post->post_title,
				'content'   => apply_filters( 'the_content', $post->post_content ),
				'image'     => featured_media( $post->ID, 'background', 'large' ),
				'questions' => $this->elements->questions_accordion(),
			),
		);

		return $args;
	}

	public function terms() {
		if ( ! is_singular( 'page' ) ) { return; }
		if ( ! page_has_template( 'terms' ) ) { return; }

		global $post;

		$args = array(
			'actions' => 'main_content',
			'partial' => 'terms',
			'args'    => array(
				'title'   => $post->post_title,
				'content' => apply_filters( 'the_content', $post->post_content ),
				'image'   => featured_media( $post->ID, 'background', 'large' ),
				'terms'   => $this->elements->terms_accordion(),
			),
		);

		return $args;
	}

	public function contact() {
		if ( ! is_singular( 'page' ) ) { return; }
		if ( ! page_has_template( 'contact' ) ) { return; }

		global $post;

		$args = array(
			'actions' => 'main_content',
			'partial' => 'contact',
			'args'    => array(
				'title'   => $post->post_title,
				'content' => apply_filters( 'the_content', $post->post_content ),
				'image'   => featured_media( $post->ID, 'background', 'large' ),
				'details' => $this->elements->contact_section(),
			),
		);

		return $args;
	}

	public function search() {
		if ( ! is_search() ) { return; }

		global $wp_query;

		$args = array(
			'actions' => 'main_content',
			'partial' => 'search',
			'args'    => array(
				'title'         => get_the_archive_title(),
				'posts'         => $this->elements->search_list( $wp_query->posts ),
				'no_results'    => __( 'Sorry, no results match your criteria.', TORA_B2C_TEXTDOMAIN ),
				'search_widget' => $this->elements->search_widget(),
				'faq_section'   => $this->elements->faq_section(),
			),
		);

		return $args;
	}

	public function error_404() {
		if ( ! is_404() ) { return; }

		$args = array(
			'actions' => 'main_content',
			'partial' => 'error-404',
			'args'    => array(
				'title'         => __( 'That page could not be found', TORA_B2C_TEXTDOMAIN ),
				'not_found'     => __( 'Sorry, the page you are looking for for does not exist.', TORA_B2C_TEXTDOMAIN ),
				'search_widget' => $this->elements->search_widget(),
				'faq_section'   => $this->elements->faq_section(),
			),
		);

		return $args;
	}

	public function main() {
		ob_start();
			do_action( 'main_content' );
		$content = ob_get_clean();

		$args = array(
			'actions' => 'wp_body',
			'partial' => 'main',
			'args'    => array(
				'content' => $content,
			),
		);

		return $args;
	}
}
