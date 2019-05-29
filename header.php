<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="480">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
	<meta name="theme-color" content="#fff">

	<?php wp_head(); ?>
</head>

<?php
$general_settings = get_field( 'general_settings', 'option' ); ?>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

	<!-- <script id="analytics">
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		(function(){
			ga('create', 'UA-74433337-4', 'tora.gr');
			ga('require', 'displayfeatures');
			ga('send', 'pageview');
		})();
	</script> -->

	<div id="container"> <?php // closes in footer.php ?>

		<header id="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

			<div id="inner-header">

				<div class="logos wrap grid-row flex">

					<div class="main-logo flex align-items-center <?php echo $general_settings['secondary_logo']['image'] ? 'col-6 col-t-6 col-d-6' : 'col-12'; ?>">
						<?php
						if ( $general_settings['main_logo'] ) : ?>
							<a href="<?php echo home_url(); ?>" rel="home"><img width="135" src="<?php echo esc_url( $general_settings['main_logo'] ); ?>" /></a>
						<?php
						elseif ( function_exists( 'the_custom_logo' ) && the_custom_logo() ) :
							the_custom_logo();
						else : ?>
							<h1 id="logo" class="h1" itemscope itemtype="http://schema.org/Organization">
								<a href="<?php echo home_url(); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h1>
						<?php
						endif; ?>
					</div>

					<?php if ( $general_settings['secondary_logo'] ) : ?>
						<div class="secondary-logo flex align-items-center justify-content-end col-6">
							<div class="m-hide">
								<?php if ( $general_settings['secondary_logo']['link'] ) : ?>
									<a href="<?php echo esc_url( $general_settings['secondary_logo']['link'] ); ?>" target="<?php echo $general_settings['secondary_logo']['link_target'] ? '_blank' : '_self'; ?>">
										<img width="115" src="<?php echo esc_url( $general_settings['secondary_logo']['image'] ); ?>" />
									</a>
								<?php else : ?>
									<img width="115" src="<?php echo esc_url( $general_settings['secondary_logo']['image'] ); ?>" />
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

				</div>

				<div class="menu-container bg-blue text-right">

					<nav itemscope itemtype="http://schema.org/SiteNavigationElement" class="wrap">
						<?php
						// https://developer.wordpress.org/reference/functions/wp_nav_menu/
						wp_nav_menu( array(
							'container' 	  => false, // remove nav container
							'container_class' => 'menu cf', // class of container (should you choose to use it)
							'menu' 			  => __( 'The Main Menu', 'thisisbare' ), // nav name
							'menu_class' 	  => 'nav top-nav wrap cf', // adding custom nav class
							'theme_location'  => 'main-nav', // where it's located in the theme
						) ); ?>
					</nav>

				</div>

			</div>

			<nav itemscope itemtype="http://schema.org/SiteNavigationElement">
				<?php
				// https://developer.wordpress.org/reference/functions/wp_nav_menu/
				wp_nav_menu( array(
					'container' 	  => false, // remove nav container
					'container_class' => 'menu cf', // class of container (should you choose to use it)
					'menu' 			  => __( 'The Main Menu', 'thisisbare' ), // nav name
					'menu_class' 	  => 'nav mobile-nav cf', // adding custom nav class
					'theme_location'  => 'mobile-nav', // where it's located in the theme
				) ); ?>
			</nav>

		</header>
