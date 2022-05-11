<div id="footer-col-4" class="col-m-12 col-t-4 col-d-4" role="complementary">

	<?php if ( is_active_sidebar( 'footer-col-4' ) ) : ?>

		<?php dynamic_sidebar( 'footer-col-4' ); ?>

	<?php else : ?>

		<div class="no-widgets">
			<p><?php _e( 'This is a widget ready area. Add some and they will appear here.', 'thisisbare' );  ?></p>
		</div>

	<?php endif; ?>

</div>
