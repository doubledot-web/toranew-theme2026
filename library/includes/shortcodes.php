<?php
// Carousel
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


// YouTube Video Embed
function yt_video_init( $atts ) {
	$a = shortcode_atts( array(
		'id' 	   => '',
		'controls' => 'on',
	), $atts );

	$controls = 'off' === $a['controls'] ? '0' : '1';

	ob_start(); ?>

	<style>
		.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; }
		.embed-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
	</style>

	<div class='embed-container'>
		<iframe src='https://www.youtube.com/embed/<?php esc_attr_e( $a['id'] ); ?>?rel=0&showinfo=0&controls=<?php esc_attr_e( $controls ); ?>' frameborder='0' allowfullscreen></iframe>
	</div>

	<?php
	return ob_get_clean();
}
add_shortcode( 'yt_video', 'yt_video_init' );


// Native Video Embed
function native_video_embed_init( $atts ) {
	$a = shortcode_atts( array(
		'url' 	 => '',
		'width'  => '100%',
		'height' => 'auto',
		'poster' => '',
	), $atts );

	ob_start(); ?>

	<video width="<?php esc_attr_e( $a['width'] ); ?>" height="<?php esc_attr_e( $a['height'] ); ?>" controls poster="<?php echo esc_url( $a['poster'] ); ?>">
		<source src="<?php echo esc_url( $a['url'] ) ?>" type="video/mp4">
		Your browser does not support the video tag.
	</video>

	<?php
	return ob_get_clean();
}
add_shortcode( 'video_embed', 'native_video_embed_init' );
