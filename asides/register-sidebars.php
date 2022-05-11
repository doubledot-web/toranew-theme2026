<?php
function register_sidebars_init() {
	register_sidebar(array(
		'id' => 'footer-col-1',
		'name' => __( 'Footer Column 1', 'thisisbare' ),
		'description' => __( 'The column 1 footer sidebar.', 'thisisbare' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'footer-col-2',
		'name' => __( 'Footer Column 2', 'thisisbare' ),
		'description' => __( 'The column 1 footer sidebar.', 'thisisbare' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'footer-col-3',
		'name' => __( 'Footer Column 3', 'thisisbare' ),
		'description' => __( 'The column 3 footer sidebar.', 'thisisbare' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'footer-col-4',
		'name' => __( 'Footer Column 4', 'thisisbare' ),
		'description' => __( 'The column 4 footer sidebar.', 'thisisbare' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}

add_action( 'widgets_init', 'register_sidebars_init' );
