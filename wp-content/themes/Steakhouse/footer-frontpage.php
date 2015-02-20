<?php
/**
 * The template for displaying the footer
 *
 */

?>
    	<?php do_action('steakhouse_before_footer'); ?>
    	<footer id="gk-footer" role="contentinfo">
    		<div id="gk-footer-nav">
    			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footer-menu' ) ); ?>
    		</div>

        <div id="social">
          <a href="https://www.facebook.com/pages/Centennial-Bar-Grille/151825094858585" target="new" id="facebook"></a>
          <a href="https://twitter.com/TheCentennial" target="new" id="twitter"></a>
        </div>

    		<div id="gk-copyrights">
    			<p class="copyright">
                    <?php echo get_theme_mod('steakhouse_copyright_text', '&copy; 2014 GavickPro. All rights reserved.'); ?>

                    &nbsp; | &nbsp;

                    Website Created and Maintained by <a href="http://www.foresitegrp.com" target="new">Foresite Group</a>
                </p>
    		</div>
    	</footer><!-- end of #gk-footer -->
    	<?php do_action('steakhouse_after_footer'); ?>
    </div><!-- #gk-bg -->

	<?php do_action('steakhouse_before_asidemenu'); ?>
	<i id="close-menu" class="fa fa-times"></i>
	<aside id="aside-menu">
		<nav id="aside-navigation" class="main-navigation" role="navigation">
			<h3><?php _e( 'Menu', 'steakhouse' ); ?></h3>
			<?php wp_nav_menu( array( 'theme_location' => 'mainmenu_left', 'menu_class' => 'nav-aside-menu' ) ); ?>
            <?php wp_nav_menu( array( 'theme_location' => 'mainmenu_right', 'menu_class' => 'nav-aside-menu' ) ); ?>
		</nav><!-- #aside-navigation -->
	</aside><!-- #aside-menu -->
	<?php do_action('steakhouse_after_asidemenu'); ?>

	<?php wp_footer(); ?>
</body>
</html>
