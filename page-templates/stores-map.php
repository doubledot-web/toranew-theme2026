<?php /* Template: Stores Map */ ?>

<div id="inner-content">

	<main id="main" itemprop="mainContentOfPage">

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">
				<header class="page-header stores-map-header bg-map-blue">
					<div class="wrap">
						<div class="row">
							<div class="col-sm-12 text-center">
								<?php if ( get_field( 'subtitle' ) ) : ?>
									<h1 class="stores-map-title"><?php the_field( 'subtitle' ); ?></h1>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</header>

				<section class="article-body">
					<div class="map-legacy">
						<?php get_template_part( 'partials/content-blocks/locations' ); ?>
					</div>
				</section>

			</article>

				<?php
			endwhile;
		endif;
		?>

	</main>

</div>
