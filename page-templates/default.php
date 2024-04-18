<?php /* Template: Default */ ?>

<div id="inner-content">

	<main id="main" itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php
				$has_contact_form   = get_field( 'has_contact_form' );
				$contact_form_class = ! empty( $has_contact_form ) ? ' has-contact-form' : '';

				$has_new_hero = get_field( 'new_hero' );
				?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' . $contact_form_class ); ?> role="article">

				<?php if ( empty( $has_new_hero ) ) : ?>
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
					<?php
					else :
						get_template_part( 'partials/content-blocks/hero' );
					endif;
					?>

				<section class="page-body">
					<div class="wrap"><?php get_template_part( 'library/includes/terms-archive-select' ); ?></div>
					<?php get_template_part( 'library/includes/layout-elements' ); ?>
					<div class="wrap">
						<?php the_content(); ?>
						<?php get_template_part( 'library/includes/terms-archive-select' ); ?>
					</div>
				</section>

			</article>

		<?php endwhile; endif; ?>

	</main>

	<?php get_template_part( 'asides/sidebar' ); ?>

</div>
