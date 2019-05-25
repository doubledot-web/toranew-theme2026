<?php
global $tora_b2c;

$locations = $tora_b2c->locations['args']; ?>

<div class="page-section light-gray locations-section">

	<div class="row outer-container">
		<h2 class="margin-bottom-3"><?php esc_html_e( $locations['map_title'], 'tora' ); ?></h2>
	</div>

	<div class="row outer-container">
		<div class="shadow margin-bottom-3">

			<button id="map-controls" class="hide" data-toggle="map-filters">
				<span class="show-for-large"><?php esc_html_e( $locations['filter_text'], 'tora' ); ?></span>
				<i class="fa fa-sliders"></i>
			</button>

			<div class="map-container">

				<div id="map-markers"></div>

				<div id="map-loader">
					<h2>Εύρεση σημείων</h2>
					<img src="<?php echo esc_url( $locations['map_loader'] ); ?>">
				</div>

				<div id="map-no-content">
					<h2>Δε βρέθηκαν σημεία<br/>για την αναζήτησή σας</h2>
					<img src="<?php echo esc_url( $locations['map_no_content'] ); ?>">
				</div>

				<div id="map-filters" data-toggler=".hide">
					<div class="margin-bottom-2">
						<?php get_search_form(); ?>
					</div>

					<h4><?php esc_html_e( $locations['province_title'], 'tora' ); ?></h4>

					<div class="filters">
						<select name="province" id="select-province" class="margin-bottom-2 black">
							<option value=""><?php esc_html_e( $locations['all_provinces'], 'tora' ); ?></option>
							<?php foreach ( $locations['provinces'] as $province ) : ?>
								<option value="<?php esc_attr_e( $province['name'] ) ?>" data-formatted="<?php esc_attr_e( $province['formatted'] ) ?>"><?php esc_html_e( $province['display'] ) ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<?php if ( $locations['categ_section'] ) : ?>
						<h4 class="margin-bottom-2"><?php esc_html_e( $locations['service_title'], 'tora' ); ?></h4>
						<div class="filters">
							<?php foreach ( $locations['categories'] as $category ) : ?>
								<div class="filter-item margin-bottom-1">
									<div class="switch tiny">
										<input class="switch-input" id="switch-<?php esc_attr_e( $category['id'] ) ?>" value="<?php esc_attr_e( $category['id'] ) ?>" type="checkbox" <?php esc_attr_e( $category['checked'] ) ?> name="categories[]">
										<label class="switch-paddle rounded" for="switch-<?php esc_attr_e( $category['id'] ) ?>">
											<span class="show-for-sr"> <?php esc_html_e( $category['name'] ) ?> </span>
										</label>
									</div>
									<span class="filter"> <?php esc_html_e( $category['name'] ) ?> </span>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

			</div> <!-- Map Container -->

			<div id="map-locations" class="hide"></div>
		</div>
	</div>
</div>
