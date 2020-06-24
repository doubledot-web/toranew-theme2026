		<footer class="footer bg-blue p-b-1" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

			<div id="inner-footer" class="wrap cf">

				<a href="#container" class="to-top" data-smooth-scroll>
					<i class="fa fa-chevron-up"></i>
				</a>

				<div class="grid-row p-t-2">
					<?php get_template_part( 'asides/footer-col-1' ); ?>
					<?php get_template_part( 'asides/footer-col-2' ); ?>
					<?php get_template_part( 'asides/footer-col-3' ); ?>

					<div class="col-12 p-t-2">
						<nav itemscope itemtype="http://schema.org/SiteNavigationElement">
							<?php
							wp_nav_menu( array(
								'container' 	  => false, // remove nav container
								'container_class' => 'menu', // class of container (should you choose to use it)
								'menu' 			  => __( 'The Social Footer Menu', 'thisisbare' ), // nav name
								'menu_class' 	  => 'nav social-nav text-center cf', // adding custom nav class
								'theme_location'  => 'social-nav', // where it's located in the theme
							) ); ?>
						</nav>

						<p class="copyright normal">Copyright &copy; <?php echo date( 'Y' ); ?> - <?php bloginfo( 'name' ); ?>. All Rights Reserved</p>

						<nav itemscope itemtype="http://schema.org/SiteNavigationElement">
							<?php
							wp_nav_menu( array(
								'container' 	  => false, // remove nav container
								'container_class' => 'menu', // class of container (should you choose to use it)
								'menu' 			  => __( 'The Footer Menu', 'thisisbare' ), // nav name
								'menu_class' 	  => 'nav cf', // adding custom nav class
								'theme_location'  => 'footer-nav', // where it's located in the theme
							) ); ?>
						</nav>
					</div>
				</div>

			</div>

		</footer>
	</div> <?php // container div - opens in header.php ?>

	<?php wp_footer(); ?>

</body>
</html>
