<?php get_header(); ?>

	<div id="content">

		<?php
		switch ( get_field( 'page_template' ) ) {
			case 'front_page':
				get_template_part( 'page-templates/front-page' );
				break;
			case 'locations':
				get_template_part( 'page-templates/locations' );
				break;
			case 'contact':
				get_template_part( 'page-templates/contact' );
				break;
			default:
				get_template_part( 'page-templates/default' );
				break;
		} ?>

	</div>

<?php get_footer(); ?>
