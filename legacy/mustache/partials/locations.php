<?php
global $tora_b2c;

$locations = $tora_b2c->locations['args']; ?>

<div class="locations-section">

	<div class="wrap">
        <h2 class="locations-title">
            <?php if (get_field('map_title_tora')): the_field('map_title_tora'); endif;?>
        </h2>
	</div>

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

							<h4 class="col-12"><?php esc_html_e( $locations['service_title'], 'tora' ); ?></h4>

							<div class="filters col-12">
								<div class="grid-row grid-collapse">

									<?php foreach ( $locations['categories'] as $category ) : ?>
										<?php $current_category_name = get_term( $category['id'] ) ? get_term( $category['id'] )->name : null; ?>
                    <?php if ( $current_category_name && $current_category_name != "Εισιτήρια" && $current_category_name != "ID Scanning" ): ?>

										<div style="white-space: nowrap;" class="filter-item col-m-12 col-t-6 col-d-6 t-<?php echo $category['id'] ?>">
											<div class="switch tiny">
												<input class="switch-input" id="switch-<?php esc_attr_e( $category['id'] ) ?>"
                                                       value="<?php esc_attr_e( $category['id'] ) ?>"
                                                       type="checkbox" <?php esc_attr_e( $category['checked'] ) ?> name="categories[]">
												<label class="switch-paddle rounded" for="switch-<?php esc_attr_e( $category['id'] ) ?>">
													<span class="show-for-sr"> <?php esc_html_e( $category['name'] ) ?> </span>
												</label>
											</div>
											<span class="filter"> <?php esc_html_e( $category['name'] ) ?> </span>
										</div>
									<?php endif; endforeach; ?>
                                    <!-- extra -->

									<?php if (1==2) : // remove extra filter ?>
										<div class="filter-item col-m-12 col-t-6 col-d-6 t-1008" >
												<div class="switch tiny">
													<input class="switch-input" id="switch-1008" value="<?php esc_attr_e( '8' ) ?>"
														type="checkbox" <?php esc_attr_e( $category['checked'] ) ?> name="categories[]">
													<label class="switch-paddle rounded" for="switch-<?php esc_attr_e( '1008') ?>">
														<span class="show-for-sr"> Πληρωμή στα οnline παιχνίδια ΟΠΑΠ </span>
													</label>
												</div>
												<!-- <span class="filter"> Πληρωμή στα online παιχνίδια ΟΠΑΠ </span> -->
												<span class="filter"> Φόρτιση (Top-up)<br> Ηλεκτρονικού Παικτικού Λογαριασμού </span>
										</div>
									<?php endif; ?>

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

			<div id="store-types-filters" class="text-center">
				<div class="store-type">
					<label class="store-type-container"><img class="store-type-icon" width="26" height="26" src="<?php echo get_template_directory_uri() . '/library/images/opap-store-poi.png'; ?>" alt=""> <span><?php _e( 'Καταστήματα ΟΠΑΠ', 'tora' ); ?></span>
						<input id="is_opap_store" class="store-type-input"  value="<?php esc_attr_e( 'opap-store' ); ?>" type="checkbox" checked="checked">
						<span class="store-type-checkmark"></span>
					</label>
				</div>

				<div class="store-type">
					<label class="store-type-container"><img class="store-type-icon" width="26" height="26" src="<?php echo get_template_directory_uri() . '/library/images/retail-store.png"'; ?>" alt=""> <span><?php _e( 'Καταστήματα Λιανικής', 'tora' ); ?></span>
						<input id="is_retail_store" class="store-type-input" value="<?php esc_attr_e( 'retail-store' ); ?>" type="checkbox" checked="checked">
						<span class="store-type-checkmark"></span>
					</label>
				</div>
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
