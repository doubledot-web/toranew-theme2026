<?php
$boxes = json_decode( $args );

if ( empty( $boxes ) ) {
	return;
}
?>

<div class="page-section rich-boxes">
	<div class="rich-boxes-content wrap flex">
		<?php
		foreach ( $boxes as $box ) :
			$box_icon_url    = ! empty( $box->icon->url ) ? esc_url( $box->icon->url ) : '';
			$box_icon_alt    = ! empty( $box->icon->alt ) ? esc_attr( $box->icon->alt ) : '';
			$box_icon_width  = ! empty( $box->icon->width ) ? esc_attr( $box->icon->width ) : '';
			$box_icon_height = ! empty( $box->icon->height ) ? esc_attr( $box->icon->height ) : '';

			$box_title = ! empty( $box->title ) ? esc_html( $box->title ) : '';
			$box_text  = ! empty( $box->text ) ? wp_kses_post( $box->text ) : '';
			?>
			<div class="rich-box text-center col-sm-6 col-md-3 d-flex align-items-stretch">
				<div class="rich-box-content d-flex flex-column justify-content-between">
					<div class="rich-box-top">
						<img class="rich-box-icon mb-3" src="<?php echo $box_icon_url; ?>" alt="<?php echo $box_icon_alt; ?>" width="<?php echo $box_icon_width; ?>" height="<?php echo $box_icon_height; ?>">
						<h3 class="rich-box-title mb-3"><?php echo $box_title; ?></h3>
					</div>
					<div class="rich-box-text"><?php echo $box_text; ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
