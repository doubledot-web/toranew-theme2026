
<div class="page-section background image-background dark service-section faq-section" style="background-image: url(<?php echo esc_url( $services_settings['faq_section_style']['faq_image'] ); ?>); background-color: <?php esc_attr_e( $services_settings['faq_section_style']['faqs_background_color'] ) ?>; ">

	<div class="wrap background-content grid-row">
		<div class="outer-container col-12">

			<h2 class="section-title light">
				<?php echo wp_kses( $services_settings['faq_title'], array( 'br' => array() ) ); ?>
			</h2>

			<div class="section-content">
				<p><a class="button button-white" href="<?php echo esc_url( $services_settings['faq_section_link'] ); ?>"><?php _e( 'Συχνές Ερωτήσεις', 'tora_ddot' ) ?></a></p>
			</div>

		</div>
	</div>
</div>
