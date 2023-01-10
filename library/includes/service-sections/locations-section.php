<?php
$services = get_the_terms( get_queried_object(), 'location-category' );

$bill_payment_id = '8';

if ( strpos( $_SERVER['SERVER_NAME'], 'uat' ) !== false ) {
	$top_up_id = '52';
} else {
	$top_up_id = '38';
}

$is_top_up_term = in_array( $top_up_id, wp_list_pluck( $services, 'term_id' ) );

$args = array(
	'post_type'   => 'location',
	'post_status' => 'publish',
	'tax_query'   => array(
		array(
			'taxonomy' => 'location-category',
			'field'	   => 'id',
			'terms'	   => $is_top_up_term ? array( $bill_payment_id ) : wp_list_pluck( $services, 'term_id' ),
		),
	),
);

$query = new WP_Query( $args ); ?>

<div class="page-section one-column-section has-bg-color service-section location-section" style="background-color: <?php esc_attr_e( $services_settings['section_style']['locations_background_color'] ); ?>">
	<div class="wrap grid-row">
		<div class="column col-12" <?php echo $services_settings['section_style']['locations_image'] ? 'style="background-image: url(' . esc_url( $services_settings['section_style']['locations_image'] ) . '); min-height: ' . esc_attr( $services_settings['section_style']['locations_min_height'] ) . 'px;"' : ''; ?> >

				<h2>
					<?php if ( get_field( 'locations_text' ) ) :
						the_field( 'locations_text' );
					else :
						echo wp_kses( $services_settings['locations_title'], array( 'br' => array() ) );
					endif; ?>
				</h2>

				<p class="counter h1"><span data-count="<?php esc_attr_e( $query->found_posts ); ?>">0</span></p>

				<?php $query_key = $is_top_up_term ? '1008' : $services[0]->term_id; ?>

				<a class="button button-white" href="<?php echo esc_url( add_query_arg( 'categories[0]', $query_key, $services_settings['locations_section_link'] ) ) ?>">
					<?php _e( 'Βρες ένα κοντινό σημείο', 'tora_ddot' ) ?>
				</a>

		</div>
	</div>
</div>
