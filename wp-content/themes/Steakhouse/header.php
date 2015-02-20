<?php
/**
 * The Header template for our theme
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title('|', true, 'right'); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php do_action('steakhouse_head'); ?>
	<?php wp_head(); ?>
	<!-- BEGIN new Google Analytics (12/2/13) -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  ga('create', 'UA-46111073-1', 'centennialbg.com');
	  ga('send', 'pageview');
	</script>
	<!-- END new Google Analytics -->
</head>
<body <?php body_class(get_theme_mod('steakhouse_blocks_color', 'steakhouse-light-blocks')); ?>>
	<!--[if lte IE 8]>
	<div id="ie-toolbar"><div><?php _e('You\'re using an unsupported version of Internet Explorer. Please <a href="http://windows.microsoft.com/en-us/internet-explorer/products/ie/home">upgrade your browser</a> for the best user experience on our site. Thank you.', 'steakhouse') ?></div></div>
	<![endif]-->
	<div id="gk-bg">
		<header id="gk-header" class="menu-visible" role="banner">
			<div id="gk-header-nav" class="static">
				<div id="gk-header-nav-wrap">
					<?php if(get_theme_mod('steakhouse_menu_logo', '') == '') : ?>
					<a class="gk-logo gk-logo-small gk-logo-css" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
					<?php else : ?>
					<a class="gk-logo gk-logo-small" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<img src="<?php echo get_theme_mod('steakhouse_menu_logo', ''); ?>" alt="<?php bloginfo( 'name' ); ?>" />
					</a>
					<?php endif; ?>

                    <a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'steakhouse' ); ?>"><?php _e( 'Skip to content', 'steakhouse' ); ?></a>

					<?php do_action('steakhouse_before_mainmenu'); ?>
                    <nav class="main-navigation main-navigation-left" role="navigation">
                        <?php wp_nav_menu( array( 'theme_location' => 'mainmenu_left', 'menu_class' => 'nav-menu' ) ); ?>
                    </nav><!-- #site-navigation -->
                    <?php do_action('steakhouse_after_mainmenu'); ?>

                    <?php do_action('steakhouse_before_mainmenu'); ?>
                    <nav class="main-navigation main-navigation-right" role="navigation">
                        <?php wp_nav_menu( array( 'theme_location' => 'mainmenu_right', 'menu_class' => 'nav-menu' ) ); ?>
                    </nav><!-- #site-navigation -->
                    <?php do_action('steakhouse_after_mainmenu'); ?>

					<a href="#" id="aside-menu-toggler"><i class="fa fa-bars"></i></a>
				</div>
			</div>

            <?php do_action('steakhouse_plugin_messages'); ?>

			<?php if (is_active_sidebar('header')) : ?>
			<div id="gk-header-widget" role="complementary">
				<div class="widget-area">
					<?php do_action('steakhouse_before_header'); ?>
					<?php dynamic_sidebar('header'); ?>
					<?php do_action('steakhouse_after_header'); ?>
				</div>
			</div>
			<?php endif; ?>
		</header><!-- #masthead -->

		<div id="page" class="hfeed site<?php if(is_page_template('template.one-page.php') || is_page_template('template.one-page-wide.php')) : ?> page-wide<?php endif; ?>">
			<div id="main" class="site-main">
				<?php if (is_active_sidebar('top1')) : ?>
				<?php do_action('steakhouse_before_top1'); ?>
				<div id="gk-top1" role="complementary">
					<div class="widget-area gk-3-cols" data-cols="<?php echo GK_Utils::count_sidebar_widgets('top1', 3); ?>">
						<?php dynamic_sidebar('top1'); ?>
					</div>
				</div>
				<?php do_action('steakhouse_after_top1'); ?>
				<?php endif; ?>

				<?php if (is_active_sidebar('top2')) : ?>
				<?php do_action('steakhouse_before_top2'); ?>
				<div id="gk-top2" role="complementary">
					<div class="widget-area gk-3-cols" data-cols="<?php echo GK_Utils::count_sidebar_widgets('top2', 3); ?>">
						<?php dynamic_sidebar('top2'); ?>
					</div>
				</div>
				<?php do_action('steakhouse_after_top2'); ?>
				<?php endif; ?>
