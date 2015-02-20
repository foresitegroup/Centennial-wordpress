<?php
/**
 * The template for displaying Author archive pages
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content author-page" role="main">
			<?php if (is_active_sidebar('content_top')) : ?>
			<?php do_action('steakhouse_before_content_top'); ?>
			<div id="content-top" role="complementary">
				<?php dynamic_sidebar('content_top'); ?>
			</div>
			<?php do_action('steakhouse_after_content_top'); ?>
			<?php endif; ?>

			<?php do_action('steakhouse_before_content'); ?>
			<?php if ( have_posts() ) : ?>
				<?php the_post(); ?>

				<?php rewind_posts(); ?>

				<div class="author-info bigtitle">
                    <?php
                        $author_bio_avatar_size = apply_filters( 'steakhouse_author_bio_avatar_size', 130 );
                        echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
                    ?>
                    <h1 class="header"><span><?php printf( __( '%s', 'steakhouse' ), get_the_author() ); ?></span></h1>

                    <?php if ( get_the_author_meta( 'description' ) ) : ?>
                    <p>
                        <?php echo strip_tags(get_the_author_meta('description')); ?>
                    </p>
                    <?php endif; ?>

                    <?php if(get_the_author_meta('user_url')) : ?>
                    <p>
                        <?php _e('Website URL:', 'steakhouse'); ?>
                        <a href="<?php echo get_the_author_meta('user_url'); ?>"><?php echo get_the_author_meta('user_url'); ?></a>
                    </p>
                    <?php endif; ?>
                </div><!-- .author-info -->

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>

				<?php steakhouse_paging_nav(); ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
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
