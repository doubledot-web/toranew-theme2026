<?php get_header(); ?>
		<div id="content">
			<div id="inner-content" class="wrap cf">
				<header class="article-header">
					<h1><?php _e( 'Η σελίδα δεν βρέθηκε', 'thisisbare' ); ?></h1>
				</header>

				<section class="entry-content">
					<p><a href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php _e( 'Επιστροφή στην ΑΡΧΙΚΗ ΣΕΛΙΔΑ', 'thisisbare' ); ?></a></p>
				</section>
			</div>
		</div>
<?php get_footer(); ?>
