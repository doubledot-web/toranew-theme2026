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
			$card_icon_url    = ! empty( $card->middle_icon->url ) ? esc_url( $card->middle_icon->url ) : get_template_directory_uri() . '/library/images/card-icon.png';
			$card_icon_alt    = ! empty( $card->middle_icon->alt ) ? esc_attr( $card->middle_icon->alt ) : esc_attr( $card->title );
			$card_icon_width  = ! empty( $card->middle_icon->width ) ? esc_attr( $card->middle_icon->width ) : '64';
			$card_icon_height = ! empty( $card->middle_icon->height ) ? esc_attr( $card->middle_icon->height ) : '64';

			$card_link  = ! empty( $card->link ) ? esc_url( $card->link ) : '';
			$card_title = ! empty( $card->title ) ? wp_kses_post( $card->title ) : '';
			$card_text  = ! empty( $card->text ) ? wp_kses_post( $card->text ) : '';
			?>
			<div class="text-center col-sm-6 col-md-4 d-flex align-items-stretch">
				<div class="card card-custom card-content uk-height-1-1">
					<img class="card-icon" src="<?php echo $card_icon_url; ?>" alt="<?php echo $card_icon_alt; ?>" width="<?php echo $card_icon_width; ?>" height="<?php echo $card_icon_height; ?>" style="--card-img-height:<?php echo $card_icon_height; ?>px">
					<a class="card-link" href="<?php echo $card_link; ?>">
						<div class="card-top" style="--card-text-padding-top: <?php echo $card_icon_height; ?>px">
							<h2 class="card-title"><?php echo $card_title; ?></h2>
						</div>
						<div class="card-text"><?php echo $card_text; ?></div>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

