<?php
/**
 *
 * 404 Page
 *
 **/

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php if (is_active_sidebar('content_top')) : ?>
			<?php do_action('steakhouse_before_content_top'); ?>
			<div id="content-top" role="complementary">
				<?php dynamic_sidebar('content_top'); ?>
			</div>
			<?php do_action('steakhouse_after_content_top'); ?>
			<?php endif; ?>

			<?php do_action('steakhouse_before_content'); ?>
			<article id="post" <?php post_class(); ?>>
				<div>
					<header class="bigtitle no-desc">
						<h1 class="header">
                            <span>
                                <?php _e( 'Not Found', 'steakhouse' ); ?>
                            </span>
                        </h1>
					</header>

					<div class="page-wrapper">
						<div class="page-content">
							<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'steakhouse' ); ?></h2>
							<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'steakhouse' ); ?></p>

							<?php get_search_form(); ?>
						</div><!-- .page-content -->
					</div><!-- .page-wrapper -->
				</div>
			</article><!-- #post -->
			<?php do_action('steakhouse_after_content'); ?>

			<?php if (is_active_sidebar('content_bottom')) : ?>
			<?php do_action('steakhouse_before_content_bottom'); ?>
			<div id="content-bottom" role="complementary">
				<?php dynamic_sidebar('content_bottom'); ?>
			</div>
			<?php do_action('steakhouse_after_content_bottom'); ?>
			<?php endif; ?>
		</div><!-- #content -->

		<?php if (is_active_sidebar('sidebar')) : ?>
		<?php do_action('steakhouse_before_sidebar'); ?>
		<aside id="sidebar" role="complementary">
			<?php dynamic_sidebar('sidebar'); ?>
		</aside>
		<?php do_action('steakhouse_after_sidebar'); ?>
		<?php endif; ?>
	</div><!-- #primary -->

<?php get_footer(); ?>
