		<?php
		$top_padding = ! is_page( 'shmeia-proti-pliromi' ) ? ' p-t-2' : '';
		?>
		<footer class="footer bg-blue p-b-1" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

			<div id="inner-footer" class="wrap cf">
				<div class="grid-row<?php echo $top_padding; ?>">
					<?php if ( ! is_page( 'shmeia-proti-pliromi' ) ) { ?>
						<?php get_template_part( 'asides/footer-col-1' ); ?>
						<?php get_template_part( 'asides/footer-col-2' ); ?>
						<?php get_template_part( 'asides/footer-col-3' ); ?>
						<?php get_template_part( 'asides/footer-col-4' ); ?>
					<?php } ?>
					<div class="col-12 p-t-2">
						<p class="copyright normal">Copyright &copy; <?php echo date( 'Y' ); ?> - <?php bloginfo( 'name' ); ?>. All Rights Reserved</p>
						<nav class="footer-menu-bottom-left" itemscope itemtype="http://schema.org/SiteNavigationElement">
							<?php
							wp_nav_menu( array(
								'container' 	  => false,
								'container_class' => 'menu',
								'menu' 			  => __( 'The Footer Menu', 'thisisbare' ),
								'menu_class' 	  => 'nav cf',
								'theme_location'  => 'footer-nav',
							) ); ?>
                        </nav>
                        <div class="footer-menu-bottom-right">
                           <a class="tora-button-ln" href="https://www.linkedin.com/company/tora-wallet-s.a." target="_blank"  rel="noopener noreferrer">
                                    <img class="Linkedin-f" src="<?php echo get_template_directory_uri() ?>/library/images/Linkedin-f.png" alt="">
                                    LinkedIn Tora Wallet
                            </a>
                        </div>
					</div>
				</div>

			</div>
            <a href="#container" class="to-top2" data-smooth-scroll>
				    <img src="<?php echo get_template_directory_uri() ?>/library/images/Upicon.png"> <span>Κορυφή σελίδας  </span>
				</a>
		</footer>

	</div> <?php // container div - opens in header.php ?>

	<?php wp_footer(); ?>

</body>
</html>
