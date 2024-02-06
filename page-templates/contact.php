<?php /* Template: Contact */ ?>

<div id="inner-content">

	<main id="main" itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

				<header class="page-header flex">
					<div class="featured-image flex-col flex-col-1of2" style="background: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>') no-repeat center; background-size: cover;">
					</div>
					<div class="intro-text flex-col flex-col-1of2 flex justify-content-center p-3">
						<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
						<p class="page-intro"><?php the_field( 'subtitle' ); ?></p>
					</div>
				</header>

				<section class="page-body wrap">

					<?php if ( have_rows( 'contact_boxes' ) ) : ?>

						<div class="flex page-section contact-boxes-section">

							<?php if ( count( get_field( 'contact_boxes' ) ) == 1 ) : ?>

								<div class="col-12 contact-box">
									<?php while ( have_rows( 'contact_boxes' ) ) : the_row();
										the_sub_field( 'contact_box' );
									endwhile; ?>
								</div>

							<?php else : ?>
								<?php $count = 0; ?>
								<?php while ( have_rows( 'contact_boxes' ) ) : the_row(); ?>
									<?php if ( $count <= 2 ) : ?>
									<div class="col-m-12 col-t-4 col-d-4 contact-box mb-4">
										<?php the_sub_field( 'contact_box' ); ?>
									</div>
									<?php else : ?>
									<div class="col-m-12 col-t-6 col-d-6 contact-box mb-4 bg-gray">
										<?php the_sub_field( 'contact_box' ); ?>
									</div>
									<?php endif; ?>
									<?php $count++; ?>
								<?php endwhile; ?>

							<?php endif; ?>

						</div>

					<?php endif; ?>

					<?php get_template_part( 'library/includes/layout-elements' ); ?>

					<?php the_content(); ?>
				</section>

				<section>
					<?php
					$services_settings = get_field( 'services_settings', 'option' );
					include( locate_template( 'library/includes/service-sections/faq-section.php' ) );
					?>
				</section>

			</article>

		<?php endwhile; endif; ?>

	</main>

	<?php get_template_part( 'asides/sidebar' ); ?>

</div>
