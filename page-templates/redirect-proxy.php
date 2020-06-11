<?php
$general_settings = get_field( 'redirect_urls', 'option' );

if ( strstr( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) || strstr( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) ) {
	header( 'Location: ' . esc_url( $general_settings['ios'] ) );
	exit();
} elseif ( strstr( $_SERVER['HTTP_USER_AGENT'], 'Android' ) ) {
	header( 'Location: ' . esc_url( $general_settings['android'] ) );
	exit();
} else {
	header( 'Location: ' . esc_url( $general_settings['onsite'] ) );
	exit();
}
