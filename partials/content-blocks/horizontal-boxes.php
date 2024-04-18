<?php
$boxes = json_decode( $args );

if ( empty( $boxes ) ) {
	return;
}
?>

<div class="page-section horz-boxes">
	<div class="horz-boxes-content wrap flex">
		<?php
		foreach ( $boxes as $box ) :
			$box_icon_url    = ! empty( $box->icon->url ) ? esc_url( $box->icon->url ) : '';
			$box_icon_alt    = ! empty( $box->icon->alt ) ? esc_attr( $box->icon->alt ) : '';
			$box_icon_width  = ! empty( $box->icon->width ) ? esc_attr( $box->icon->width ) : '';
			$box_icon_height = ! empty( $box->icon->height ) ? esc_attr( $box->icon->height ) : '';

			$box_title = ! empty( $box->title ) ? esc_html( $box->title ) : '';
			$box_text  = ! empty( $box->text ) ? wp_kses_post( $box->text ) : '';
			?>
			<div class="horz-box text-center col-md-6 d-flex align-items-stretch">
				<div class="horz-box-inner d-flex flex-column flex-sm-row">
					<div class="horz-box-img text-center text-sm-left">
						<img class="horz-box-icon" src="<?php echo $box_icon_url; ?>" alt="<?php echo $box_icon_alt; ?>" width="<?php echo $box_icon_width; ?>" height="<?php echo $box_icon_height; ?>">
					</div>
					<div class="horz-box-content text-center text-sm-left">
						<h3 class="horz-box-title mb-3"><?php echo $box_title; ?></h3>
						<div class="horz-box-text"><?php echo $box_text; ?></div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
