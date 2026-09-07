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
	<?php
	$environment_host = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
	$is_live_environment = in_array( $environment_host, array( 'tora.gr', 'www.tora.gr' ), true );
	$is_uat_environment  = 'uat.tora.gr' === $environment_host;
	?>

	<?php if ( $is_live_environment ) : ?>
	<!-- Google Tag Manager - tora.gr -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-PJ85B42');</script>
	<!-- End Google Tag Manager -->
	<?php endif; ?>

	<?php if ( $is_uat_environment ) : ?>
	<!-- Clarity.microsoft - tora.gr -->
	<script type="text/javascript">(function(c,l,a,r,i,t,y){c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);})(window,document,"clarity","script","wja2bkgoeo");</script>
	<!-- End Clarity.microsoft -->
	<?php endif; ?>
</head>

<?php
$general_settings = get_field( 'general_settings', 'option' ); ?>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

	<?php if ( $is_live_environment ) : ?>
	<!-- Google Tag Manager (noscript) - tora.gr -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PJ85B42"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php endif; ?>

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

					<?php /* if ( $general_settings['secondary_logo'] ) : ?>
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
					<?php endif; */ ?>

				</div>

			</div>

		</header>

