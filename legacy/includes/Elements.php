<?php

namespace Tora\Theme;

// use \Mustache_Engine as Mustache;
// use \Mustache_Loader_FilesystemLoader as FilesystemLoader;

// Block direct access
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
* Element renderer for themes
*/

class Elements
{
	public function __construct() {
		global $tora_b2c; $this->theme = $tora_b2c;

		// $this->loader = new FilesystemLoader( TORA_B2CELEM_PATH, array( 'extension' => '.hbs' ) );
		// $this->engine = new Mustache( array( 'loader' => $this->loader ) );

		add_filter( 'widget_post_html', array( $this, 'widget_post_card' ), 10, 2 );
	}

	public function render( $partial, $args ) {
		// return $this->engine->render( $partial, $args );
	}

	public function social_accounts() {
		$args = array(
			'container'       => 'ul',
			'container_class' => 'menu social-accounts',
			'item_class'      => 'social-account',
			'item_before'     => '<li>',
			'item_after'      => '</li>',
			'echo'            => false,
		);

		return social_accounts_icons( $args );
	}

	public function main_menu() {
		$args = array(
			'theme_location'  => 'main-menu',
			'menu_class'      => 'dropdown expanded menu',
			'container_class' => 'menu-wrapper',
			'echo'            => false,
			'items_wrap'      => '<ul id="%1$s" data-dropdown-menu class="%2$s">%3$s</ul>',
			'walker'          => new DropdownMenuWalker,
		);

		if ( has_nav_menu( 'main-menu' ) ) {
			return wp_nav_menu( $args );
		}
	}

	public function footer_menu() {
		$args = array(
			'theme_location'  => 'footer-menu',
			'menu_class'      => 'expanded menu',
			'container_class' => 'menu-wrapper',
			'echo'            => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'walker'          => new NestedMenuWalker,
		);

		if ( has_nav_menu( 'footer-menu' ) ) {
			return wp_nav_menu( $args );
		}
	}

	public function copyright_menu() {
		$args = array(
			'theme_location'  => 'copyright-menu',
			'container_class' => 'copyright-menu',
			'echo'            => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		);

		if ( has_nav_menu( 'copyright-menu' ) ) {
			return wp_nav_menu( $args );
		}
	}

	public function mobile_menu() {
		$args = array(
			'theme_location'  => 'mobile-menu',
			'menu_class'      => 'vertical menu accordion-menu',
			'container_class' => 'menu-wrapper',
			'echo'            => false,
			'items_wrap'      => '<ul id="%1$s" data-accordion-menu class="%2$s">%3$s</ul>',
			'walker'          => new AccordionMenuWalker,
		);

		if ( has_nav_menu( 'mobile-menu' ) ) {
			return wp_nav_menu( $args );
		}
	}

	public function pagination( $pages = '', $range = 2, $echo = false ) {
		$nav   = pagination_nav( $pages, $range, $echo );
		$links = $this->render( 'pagination', array( 'links' => $nav ) );

		return $links;
	}

	public function post_content_image( $post = null ) {
		return featured_image( $post->ID, 'background', 'medium', false );
	}

	public function search_form( $args = array() ) {
		$defaults = array(
			'sr_text'     => __( 'Submit search query', TORA_B2C_TEXTDOMAIN ),
			'group_class' => 'input-group',
		);

		$args = wp_parse_args( $args, $defaults );
		$form = $this->render( 'search-form', $args );

		return $form;
	}

	public function search_widget( $args = array() ) {
		$defaults = array(
			'title' => __( 'Maybe try a new search', TORA_B2C_TEXTDOMAIN ),
			'form'  => $this->search_form(),
		);

		$args   = wp_parse_args( $args, $defaults );
		$widget = $this->render( 'search-widget', $args );

		return $widget;
	}

	public function search_list( $posts = array(), $args = array() ) {
		$items = array();
		$non_public = array( 'question', 'subservice' );

		foreach ( $posts as $post ) {
			$excerpt = get_post_excerpt( $post );
			$link    = get_permalink( $post->ID );

			if ( in_array( $post->post_type, $non_public ) ) {
				$excerpt = apply_filters( 'the_content', $post->post_content );
				$link    = false;
			}

			$items[] = array(
				'title'   => $post->post_title,
				'excerpt' => $excerpt,
				'link'    => $link,
			);
		}

		$defaults = array( 'results' => $items, 'read_more' => __( 'More', TORA_B2C_TEXTDOMAIN ) );
		$args     = wp_parse_args( $args, $defaults );
		$results  = $this->render( 'search-list', $args );

		return $results;
	}

	public function offcanvas_menu( $args = array() ) {
		$show_search = get_theme_mod( 'show_header_search', false );

		$defaults = array(
			'search' => $show_search ? $this->search_form() : null,
			'menu'   => $this->mobile_menu(),
		);

		$args = wp_parse_args( $args, $defaults );
		$menu = $this->render( 'offcanvas-menu', $args );

		return $menu;
	}

	public function services_home_sections( $args = array() ) {
		$items = array();
		$posts = get_home_services();
		if ( ! $posts ) { return; }

		foreach ( $posts as $post ) {
			$title       = get_post_meta( $post->ID, 'section_title', true );
			$content     = get_post_meta( $post->ID, 'section_content', true );
			$show_items  = get_post_meta( $post->ID, 'subservices', true ) === 'yes';
			$subservices = $show_items ? $this->home_subservices( $post ) : false;
			$show_logo   = get_post_meta( $post->ID, 'show_logo', true ) === 'yes';
			$show_button = '' === $title ? false : true;

			$image       = featured_image( $post->ID, 'background', 'large' );
			$section_img = get_secondary_image( $post->ID, 'medium' );
			$color       = get_post_meta( $post->ID, 'section_color', true );
			$logo        = get_service_logo( $post->ID, 'large' );

			$image        = 'gray' === $color ? false : $image;
			$image        = 'purple' === $color ? secondary_image( $post->ID, 'background', 'large' ) : $image;
			$section_img  = 'purple' === $color ? false : $section_img;
			$section_logo = $show_logo ? $logo : false;

			$template    = get_post_meta( $post->ID, 'custom_service_template', true );
			$position    = get_post_meta( $post->ID, 'section_layout', true );
			$reverse     = 'left' === $position;
			$layout      = $reverse ? 'content-left' : 'content-right';
			$layout      = $section_img ? "$layout has-image" : $layout;

			$items[] = array(
				'title'         => $title,
				'content'       => apply_filters( 'the_content', $content ),
				'image'         => $image,
				'link'          => get_permalink( $post->ID ),
				'color'         => 'background-' . $color,
				'layout'        => $layout,
				'section_image' => $section_img,
				'show_button'   => $show_button,
				'button'        => __( 'More', TORA_B2C_TEXTDOMAIN ),
				'reverse'       => $reverse,
				'show_items'    => $show_items,
				'subservices'   => $subservices,
				'section_logo'  => $section_logo,
				'template'      => 'section-template-'. $template,
			);
		}

		$defaults = array( 'services' => $items );
		$args     = wp_parse_args( $args, $defaults );
		$sections = $this->render( 'services-home-sections', $args );

		return $sections;
	}

	public function home_subservices( $service = null ) {
		$items = array();
		$posts = get_service_items( $service->ID );

		foreach ( $posts as $post ) {
			$items[] = array(
				'title' => $post->post_title,
				'image' => featured_image( $post->ID, 'background', 'thumbnail' ),
				'url'   => add_query_arg( array( 'ss' => $post->post_name ), get_permalink( $service->ID ) ),
			);
		}

		return $items;
	}

	public function faq_section() {
		$faq    = get_page_by_template( 'faq' );
		$faq_id = isset( $faq->ID ) ? $faq->ID : null;

		$args = array(
			'title'      => get_post_excerpt( $faq ),
			'link'       => get_permalink( $faq_id ),
			'button'     => __( 'Frequent Questions', TORA_B2C_TEXTDOMAIN ),
			'background' => get_stylesheet_directory_uri() .'/images/faq.jpg',
			'balloon'    => get_stylesheet_directory_uri() .'/images/balloon.png',
		);

		$section = $this->render( 'faq-section', $args );
		return $section;
	}

	public function locations_section( $service_id = null ) {
		$locations    = get_page_by_template( 'locations' );
		$title        = get_post_meta( $service_id, 'locations_title', true );
		$title        = $title ? $title : __( 'Where you can find this service', TORA_B2C_TEXTDOMAIN );
		$subtitle     = get_post_meta( $service_id, 'locations_subtitle', true );
		$subtitle     = $subtitle ? $subtitle : __( 'Locations in Greece', TORA_B2C_TEXTDOMAIN );
		$locations_id = isset( $locations->ID ) ? $locations->ID : null;
		$categories   = wp_get_post_terms( $service_id, 'location-category', array( 'fields' => 'ids' ) );
		$link         = add_query_arg( array( 'categories' => $categories ), get_permalink( $locations_id ) );
		$count        = number_format( locations_count( $categories ), 0, ',', '.' );

		$args = array(
			'title'    => $title,
			'subtitle' => $subtitle,
			'map'      => get_stylesheet_directory_uri() .'/images/map.png',
			'marker'   => get_stylesheet_directory_uri() .'/images/map-marker.png',
			'store'    => get_stylesheet_directory_uri() .'/images/store-image.png',
			'link'     => $link,
			'button'   => __( 'Find your spot', TORA_B2C_TEXTDOMAIN ),
			'count'    => $count,
		);

		$section = $this->render( 'locations-section', $args );
		return $section;
	}

	public function service_subservices( $service_id = null ) {
		$items  = array();
		$args   = array();
		$posts  = get_service_items( $service_id );
		$single = count( $posts ) === 1;

		foreach ( $posts as $post ) {
			$subitems       = get_subservice_items( $post->ID );
			$subitems_title = get_post_meta( $post->ID, 'subservice_items_title', true );
			$is_active      = isset( $_GET['ss'] ) ? $_GET['ss'] == $post->post_name : false;

			$items[] = array(
				'title'          => $post->post_title,
				'image'          => featured_image( $post->ID, 'background', 'thumbnail' ),
				'content'        => apply_filters( 'the_content', $post->post_content ),
				'subitems_title' => $subitems_title,
				'subitems'       => $subitems,
				'count'          => count( get_post_meta( $post->ID, 'attachments', false ) ),
				'active'         => $is_active ? 'is-active' : null,
			);
		}

		$defaults = array( 'available' => ! empty( $posts ), 'single' => $single, 'subservices' => $items );
		$args     = wp_parse_args( $args, $defaults );
		$services = $this->render( 'subservices-accordion', $args );

		return $services;
	}

	public function additional_services( $exclude_id = null ) {
		$items = array();
		$args  = array();
		$posts = get_additional_services( $exclude_id );

		if ( count( $posts ) < 5 ) {
			return;
		}

		foreach ( $posts as $post ) {
			$items[] = array(
				'title' => $post->post_title,
				'link'  => get_permalink( $post->ID ),
				'image' => featured_image( $post->ID, 'background', 'medium' ),
			);
		}

		$defaults = array(
			'services'      => $items,
			'section_title' => __( 'Additional Services', TORA_B2C_TEXTDOMAIN ),
		);

		$args     = wp_parse_args( $args, $defaults );
		$services = $this->render( 'additional-services', $args );
		return $services;
	}

	public function questions_accordion() {
		$items = array();
		$terms = get_question_categories();

		foreach ( $terms as $term ) {
			$posts = get_questions_by_category( $term );
			$item  = array( 'title' => $term->name, 'questions' => array() );

			foreach ( $posts as $index => $post ) {
				$item['questions'][] = array(
					'title'   => ($index + 1) .'. '. $post->post_title,
					'content' => apply_filters( 'the_content', $post->post_content ),
				);
			}

			$items[] = $item;
		}

		$defaults  = array( 'categories' => $items );
		$args      = wp_parse_args( $args, $defaults );
		$questions = $this->render( 'questions-accordion', $args );

		return $questions;
	}

	public function terms_accordion() {
		$items = array();
		$terms = get_term_categories();

		foreach ( $terms as $term ) {
			$posts = get_terms_by_category( $term );
			$item  = array( 'title' => $term->name, 'terms' => array() );

			foreach ( $posts as $post ) {
				$item['terms'][] = array(
					'title'   => $post->post_title,
					'content' => apply_filters( 'the_content', $post->post_content ),
				);
			}

			$items[] = $item;
		}

		$defaults = array( 'categories' => $items );
		$args     = wp_parse_args( $args, $defaults );
		$terms    = $this->render( 'terms-accordion', $args );

		return $terms;
	}

	public function contact_section() {
		$section = array();
		$info    = get_contact_settings();

		$section['service'] = array(
			'title'      => __( 'Tora Customer Service', TORA_B2C_TEXTDOMAIN ),
			'address'    => $info['address'],
			'email_text' => __( 'email', TORA_B2C_TEXTDOMAIN ) .': ',
			'email'      => $info['email'],
		);

		$section['support'] = array(
			'title'      => __( 'Phone Support', TORA_B2C_TEXTDOMAIN ),
			'phone_text' => __( 'Phone', TORA_B2C_TEXTDOMAIN ) .': ',
			'phone'      => $info['phone'],
			'hours_text' => __( 'Business Hours', TORA_B2C_TEXTDOMAIN ),
			'hours'      => $info['hours'],
		);

		return $section;
	}
}
