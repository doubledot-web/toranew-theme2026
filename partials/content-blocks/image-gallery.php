<?php
$image_gallery = json_decode( $args );

if ( empty( $image_gallery ) ) {
	return;
}

?>

<div class="page-section image-gallery new-section">
	<div class="image-gallery-content wrap">
		<div class="image-gallery-text">
			<?php echo ! empty( $image_gallery->text ) ? wp_kses_post( $image_gallery->text ) : ''; ?>
		</div>
		<div>
			<div class="image-gallery-imgs d-flex justify-content-center align-items-center">
				<?php
				if ( ! empty( $image_gallery->images ) ) {
					foreach ( $image_gallery->images as $image ) {
						$logos_icon_url    = ! empty( $image->url ) ? esc_url( $image->url ) : '';
						$logos_icon_alt    = ! empty( $image->alt ) ? esc_attr( $image->alt ) : '';
						$logos_icon_width  = ! empty( $image->width ) ? esc_attr( $image->width ) : '';
						$logos_icon_height = ! empty( $image->height ) ? esc_attr( $image->height ) : '';

						// get url custom acf field attache to image
						$logos_icon_link = get_field( 'url', $image->id );
						?>
						<div class="image-gallery-img">
							<?php echo ! empty( $logos_icon_link ) ? '<a href="' . esc_url( $logos_icon_link ) . '" target="_blank">' : ''; ?>
								<img src="<?php echo $logos_icon_url; ?>" alt="<?php echo $logos_icon_alt; ?>" width="<?php echo $logos_icon_width; ?>" height="<?php echo $logos_icon_height; ?>">
							<?php echo ! empty( $logos_icon_link ) ? '</a>' : ''; ?>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
