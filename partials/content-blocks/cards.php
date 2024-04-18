<?php
$cards = json_decode( $args );

// echo '<pre>';
// print_r( $cards );
// echo '</pre>';

if ( empty( $cards ) ) {
	return;
}

?>

<div class="page-section cards">
	<div class="cards-content wrap flex justify-content-center">
		<?php
		foreach ( $cards as $card ) :
			$card_img_url    = ! empty( $card->image->url ) ? esc_url( $card->image->url ) : '';
			$card_img_alt    = ! empty( $card->image->alt ) ? esc_attr( $card->image->alt ) : '';
			$card_img_width  = ! empty( $card->image->width ) ? esc_attr( $card->image->width ) : '';
			$card_img_height = ! empty( $card->image->height ) ? esc_attr( $card->image->height ) : '';

			$card_icon_url    = ! empty( $card->middle_icon->url ) ? esc_url( $card->middle_icon->url ) : '';
			$card_icon_alt    = ! empty( $card->middle_icon->alt ) ? esc_attr( $card->middle_icon->alt ) : '';
			$card_icon_width  = ! empty( $card->middle_icon->width ) ? esc_attr( $card->middle_icon->width ) : '64';
			$card_icon_height = ! empty( $card->middle_icon->height ) ? esc_attr( $card->middle_icon->height ) : '64';

			$card_link = ! empty( $card->link ) ? esc_url( $card->link ) : '';
			$card_text = ! empty( $card->text ) ? wp_kses_post( $card->text ) : '';
			?>
			<div class="text-center col-sm-6 col-md-4 d-flex align-items-stretch">
				<div class="card card-custom card-content d-flex flex-column justify-content-between">
					<div>
						<div class="card-top">
							<img class="card-image" src="<?php echo $card_img_url; ?>" alt="<?php echo $card_img_alt; ?>" width="<?php echo $card_img_width; ?>" height="<?php echo $card_img_height; ?>">
							<img class="card-icon" src="<?php echo $card_icon_url; ?>" alt="<?php echo $card_icon_alt; ?>" width="<?php echo $card_icon_width; ?>" height="<?php echo $card_icon_height; ?>" style="--card-img-height:<?php echo $card_icon_height; ?>px">
						</div>
						<div class="card-text" style="--card-text-padding-top: <?php echo $card_icon_height; ?>px"><?php echo $card_text; ?></div>
					</div>
					<div class="card-more-link">
						<a class="dark-blue h-s-b" href="<?php echo $card_link; ?>" class="card-link"><?php echo __( 'Περισσότερα', 'tora' ); ?></a>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

