<?php
$page_template = get_field( 'page_template' );

if ( 'redirect_proxy' === $page_template ) {
	get_template_part( 'page-templates/redirect-proxy' );
}
?>

<?php
if ( 'stores_map' !== $page_template ) {
	get_header();
} else {
	get_header( 'map' );
}
?>
	<div id="content">

		<?php
		switch ( $page_template ) {
			case 'front_page':
				get_template_part( 'page-templates/front-page' );
				break;
			case 'locations':
				get_template_part( 'page-templates/locations' );
				break;
			case 'contact':
				get_template_part( 'page-templates/contact' );
				break;
			case 'pudo_page':
				get_template_part( 'page-templates/pudo-page' );
				break;
			case 'stores_map':
				get_template_part( 'page-templates/stores-map' );
				break;
			default:
				get_template_part( 'page-templates/default' );
				break;
		}
		?>

	</div>

<?php get_footer(); ?>
