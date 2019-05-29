<?php
if ( is_singular( 'service' ) ) :
	$services_settings = get_field( 'services_settings', 'option' );
endif; ?>

<?php get_header(); ?>

		<div id="content">

			<div id="inner-content">

				<main id="main" itemprop="mainContentOfPage" itemscope itemtype="http://schema.org/Blog">

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

							<!-- <header class="service-header flex">
								<div class="featured-image flex-col flex-col-1of2" style="background: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>') no-repeat right center; background-size: cover;">
								</div>
								<div class="intro-text flex-col flex-col-1of2 flex justify-content-center p-1">
									<h1 class="service-title" itemprop="headline">
										<?php get_field( 'header_title' ) ? the_field( 'header_title' ) : the_title(); ?>
									</h1>
									<?php if ( get_field( 'subtitle' ) ) : ?>
										<p class="service-intro normal h3"><?php the_field( 'subtitle' ); ?></p>
									<?php endif; ?>
								</div>
							</header> -->

							<header class="service-header">
								<div class="featured-image intro-text flex-col flex justify-content-center p-1" style="background: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>') no-repeat right center; background-size: cover;">
									<h1 class="service-title" itemprop="headline">
										<?php get_field( 'header_title' ) ? the_field( 'header_title' ) : the_title(); ?>
									</h1>
									<?php if ( get_field( 'subtitle' ) ) : ?>
										<p class="service-intro normal h3"><?php the_field( 'subtitle' ); ?></p>
									<?php endif; ?>
								</div>
							</header>

							<section class="service-body">

								<?php
								get_template_part( 'library/includes/layout-elements' );

								if ( in_array( 'yes', get_field( 'faqs_section' ) ) ) :
									include( locate_template( 'library/includes/service-sections/faq-section.php' ) );
								endif;

								if ( in_array( 'yes', get_field( 'locations_section' ) ) ) :
									include( locate_template( 'library/includes/service-sections/locations-section.php' ) );
								endif; ?>

							</section>

						</article>

					<?php endwhile; ?>

					<?php else : ?>

						<article id="post-not-found" class="hentry cf">
							<header class="article-header">
								<h1><?php _e( 'Post Not Found!', 'thisisbare' ); ?></h1>
							</header>
							<section class="entry-content">
								<p><?php _e( 'Something is missing. Try double checking things.', 'thisisbare' ); ?></p>
							</section>
						</article>

					<?php endif; ?>

				</main>

			</div>

		</div>

<?php get_footer(); ?>
