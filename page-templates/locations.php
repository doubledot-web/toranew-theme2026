<?php /* Template: Locations */ ?>

<div id="inner-content">

	<main id="main" itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

				<header class="page-header flex">
					<div class="featured-image flex-col flex-col-1of2" style="background: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>') no-repeat center; background-size: cover;">
					</div>
					<div class="intro-text flex-col flex-col-1of2 flex justify-content-center p-3">
						<h1 class="page-title" itemprop="headline"><?php get_field( 'header_title' ) ? the_field( 'header_title' ) : the_title(); ?></h1>

						<?php if ( get_field( 'subtitle' ) ) : ?>
							<p class="page-intro h3"><?php the_field( 'subtitle' ); ?></p>
						<?php endif; ?>
					</div>
				</header>

				<section class="article-body">
					<?php get_template_part( 'library/includes/layout-elements' ); ?>

					<div class="map-legacy">
						<?php get_template_part( 'legacy/mustache/partials/locations' ); ?>
					</div>
				</section>

			</article>

		<?php endwhile; endif; ?>

	</main>

</div>
