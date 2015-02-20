<?php
/**
 * The template for displaying image attachments
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php do_action('steakhouse_before_content'); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
				<?php get_template_part( 'content', 'header'); ?>

				<div class="entry-content entry-attachment">
					<div class="attachment">
						<?php steakhouse_the_attached_image(); ?>

						<?php if ( has_excerpt() ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>
					</div><!-- .attachment -->

					<?php if ( ! empty( $post->post_content ) ) : ?>
					<div class="entry-description">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'steakhouse' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-description -->
					<?php endif; ?>

					<nav id="image-navigation" class="paging-navigation" role="navigation">
						<span class="nav-previous"><?php previous_image_link( false, __( '<span class="meta-nav">&larr;</span> Previous', 'steakhouse' ) ); ?></span>
						<span class="nav-next"><?php next_image_link( false, __( 'Next <span class="meta-nav">&rarr;</span>', 'steakhouse' ) ); ?></span>
					</nav><!-- #image-navigation -->
				</div>
			</article><!-- #post -->
			<?php do_action('steakhouse_after_content'); ?>

			<?php comments_template(); ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
