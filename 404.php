<?php get_header(); ?>
		<div id="content">
			<div id="inner-content" class="wrap cf">
				<header class="article-header">
					<h1><?php _e( 'Article Not Found', 'thisisbare' ); ?></h1>
				</header>

				<section class="entry-content">
					<p><?php _e( 'The article you were looking for was not found, but maybe try looking again!', 'thisisbare' ); ?></p>
				</section>

				<section class="search">
					<p><?php get_search_form(); ?></p>
				</section>
			</div>
		</div>
<?php get_footer(); ?>
