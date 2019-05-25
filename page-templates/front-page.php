<?php /* Template: Front Page */ ?>

<div id="inner-content">

	<main id="main" role="main" itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php get_template_part( 'library/includes/layout-elements' ); ?>

			</div>

		<?php endwhile; endif; ?>

	</main>

</div>
