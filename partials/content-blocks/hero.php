<?php
// get post id
$post = get_post();

// get the post thumbnail url, alt, width and height
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$img          = wp_get_attachment_image_src( $thumbnail_id, 'full' );
$img_src      = ! empty( $img[0] ) ? esc_url( $img[0] ) : '';
$img_width    = ! empty( $img[1] ) ? esc_attr( $img[1] ) : '';
$img_height   = ! empty( $img[2] ) ? esc_attr( $img[2] ) : '';
$img_alt      = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
?>

<div class="hero-section">
	<div class="hero-container container-fluid">
		<div class="hero-row row w-1350">
			<div class="hero-col col-sm-12 col-md-12 col-lg-6 flex-col">
				<div class="hero-col-left">
					<h1 class="hero-title"><?php get_field( 'header_title' ) ? the_field( 'header_title' ) : the_title(); ?></h1>
					<div class="hero-content">
						<?php if ( get_field( 'subtitle' ) ) : ?>
							<p class="hero-content-text"><?php the_field( 'subtitle' ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-12 col-lg-6">
				<img class="img-fluid a-pos" src="<?php echo $img_src; ?>" alt="<?php echo $img_alt; ?>" width="<?php echo $img_width; ?>" height="<?php echo $img_height; ?>">
			</div>
		</div>
	</div>
</div>
