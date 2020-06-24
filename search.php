<?php get_header(); ?>

		<div id="content">

			<div id="inner-content" class="wrap cf">

				<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

					<h1 class="search-title"><span><?php _e( 'Search Results for:', 'thisisbare' ); ?></span> <?php echo esc_attr( get_search_query() ); ?></h1>

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">

							<header class="article-header">
								<h1 class="post-title">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								</h1>
								
								<p class="post-meta">
									<?php echo __( 'Posted ', 'thisisbare' ); ?><time datetime="<?php echo get_the_time( 'Y-m-d' ); ?>" itemprop="datePublished"><?php echo get_the_time( get_option( 'date_format' ) ); ?></time>

									<span><?php echo __( 'by', 'thisisbare' ); ?></span> <span itemprop="author" itemscope itemptype="http://schema.org/Person"><?php echo get_the_author_link( get_the_author_meta( 'ID' ) ); ?></span>
								</p>
							</header>

							<section class="article-body">
								<?php // the_post_thumbnail( 'thumbnail' ); ?>
								<?php the_excerpt(); ?>
							</section>

							<footer class="article-footer">
								<p><?php comments_number( __( '<span>No</span> Comments', 'thisisbare' ), __( '<span>One</span> Comment', 'thisisbare' ), __( '<span>%</span> Comments', 'thisisbare' ) );?></p>

								<?php printf( '<p class="footer-category">' . __( 'filed under', 'thisisbare' ) . ': %1$s</p>' , get_the_category_list( ', ' ) ); ?>

								<?php the_tags( '<p class="footer-tags tags"><span class="tags-title">' . __( 'Tags:', 'thisisbare' ) . '</span> ', ', ', '</p>' ); ?>
							</footer>

						</article>

					<?php endwhile; ?>

					<?php echo paginate_links(); ?>

					<?php else : ?>
						<article id="post-not-found" class="hentry cf">
							<header class="article-header">
								<h1><?php _e( 'Post Not Found!', 'thisisbare' ); ?></h1>
							</header>
							<section class="article-body">
								<p><?php _e( 'Something is missing. Try double checking things.', 'thisisbare' ); ?></p>
							</section>
						</article>
					<?php endif; ?>

				</main>

				<?php get_template_part( 'asides/sidebar' ); ?>

			</div>

		</div>

<?php get_footer(); ?>
