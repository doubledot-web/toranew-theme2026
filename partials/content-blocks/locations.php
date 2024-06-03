<?php
global $tora_b2c;

$locations = $tora_b2c->locations['args']; ?>

<div class="locations-section">
	<div class="outer-container">
		<div class="map-container">
			<div id="map-filters">
				<div class="map-filters-inner">

					<?php get_search_form(); ?>

					<?php if ( $locations['categ_section'] ) : ?>

						<div class="categories-section grid-row">

							<div class="d-hide text-right">
								<i class="close fas fa-times"></i>
							</div>

							<div class="filters col-12">
								<div class="grid-row grid-collapse">

									<?php
									$location_categories = get_field( 'location_categories' );
									$categories = [];
									foreach ( $location_categories as $category ) :
										$categories[] = $category;
									endforeach;
									?>
									<!-- extra -->
									<input id="storesMap" type="hidden" name="categories" value="<?php echo json_encode( $categories ); ?>">

								</div>
							</div>

							<div class="d-hide text-center">
								<a class="button close" href="#"><?php _e( 'Εφαρμογή', 'tora' ); ?></a>
							</div>

						</div>

					<?php endif; ?>

				</div>
			</div>

			<div id="map-list-toggler" class="text-center">
				<a href="#" class="active show-map"><?php _e( 'ΕΜΦΑΝΙΣΗ ΧΑΡΤΗ', 'tora' ); ?></a><a href="#" class="show-list"><?php _e( 'ΕΜΦΑΝΙΣΗ ΛΙΣΤΑΣ', 'tora' ) ?></a>
			</div>

			<div class="map-wrapper">
				<div class="map-mobile-filters">
					<a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/sliders.png"></a>
				</div>
				<div id="map-markers" class="map-section">
			</div>

			</div>

			<div class="wrap list-section">

				<div class="grid-row">
					<div class="locations-pagination locations-pagination-top col-12 cf">

						<div class="locations-count-selector">
							<span>Εμφάνιση ανά</span>
							<select>
								<option value="9">9</option>
								<option value="18">18</option>
								<option value="27">27</option>
							</select>
						</div>

					</div>
				</div>

				<div id="map-locations" class="grid-row"></div>

				<div class="grid-row">
					<div class="locations-pagination locations-pagination-bottom col-12 cf">

						<div class="locations-count-selector">
							<span>Εμφάνιση ανά</span>
							<select>
								<option value="9">9</option>
								<option value="18">18</option>
								<option value="27">27</option>
							</select>
						</div>

					</div>
				</div>
			</div>

			<div id="map-loader">
				<h2>Εύρεση σημείων</h2>
				<img src="<?php echo esc_url( $locations['map_loader'] ); ?>">
			</div>

			<div id="map-no-content">
				<h2>Δε βρέθηκαν σημεία<br/>για την αναζήτησή σας</h2>
				<img width="60" src="<?php echo esc_url( $locations['map_no_content'] ); ?>">
			</div>

		</div> <!-- Map Container -->

	</div>
</div>
