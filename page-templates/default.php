<?php /* Template: Default */ ?>

<div id="inner-content">

	<main id="main" itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

				<header class="page-header flex">
					<div class="featured-image flex-col flex-col-1of2" style="background: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>') no-repeat center; background-size: cover;">
					</div>
					<div class="intro-text flex-col flex-col-1of2 flex justify-content-center p-1">
						<h1 class="page-title" itemprop="headline"><?php get_field( 'header_title' ) ? the_field( 'header_title' ) : the_title(); ?></h1>

						<?php if ( get_field( 'subtitle' ) ) : ?>
							<p class="page-intro h3"><?php the_field( 'subtitle' ); ?></p>
						<?php endif; ?>
					</div>
				</header>

				<section class="page-body wrap">
					<?php get_template_part( 'library/includes/layout-elements' ); ?>
					<?php the_content(); ?>

					<?php $terms_versions = get_field( 'versions' ); ?>
					<?php if ( $terms_versions ) : ?>
						<div class="terms-archive">
							<select>
								<option value="" disabled selected>Αρχείο</option>
								<?php
								foreach ( $terms_versions as $version ) :
									$version = $version['version'] ?>
									<option value="<?php esc_attr_e( $version['file'] ); ?>"><?php esc_html_e( $version['date'] ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php endif; ?>

				</section>

			</article>

		<?php endwhile; endif; ?>

	</main>

	<?php get_template_part( 'asides/sidebar' ); ?>

</div>
