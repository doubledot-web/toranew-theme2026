<?php
function carousel_init( $atts, $content = null ) {
	ob_start(); ?>

	<div class="carousel-list">
		<?php echo wp_kses( $content, array(
			'ul' => array(),
			'ol' => array(),
			'li' => array(),
			'a'  => array(
				'href' => array(),
				'target' => array(),
			),
		) ); ?>
	</div>

	<?php
	return ob_get_clean();
}
add_shortcode( 'carousel', 'carousel_init' );
