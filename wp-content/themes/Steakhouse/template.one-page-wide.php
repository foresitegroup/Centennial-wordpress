<?php
/*
Template Name: One-page (wide)
*/

$video_code = steakhouse_video_code();

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
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('one-page-layout one-page-wide-layout'); ?>>
                    <header class="bigtitle<?php if(has_post_thumbnail()) : ?> has-bg<?php endif; ?>"<?php if(has_post_thumbnail()) : ?> style="background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>');"<?php endif; ?>>
                        <h1 class="header">
                            <?php
                                $title_parts = explode('&#8212;', get_the_title());

                                if(count($title_parts) == 1) {
                                    $title_parts = explode('&#8211;', get_the_title());
                                }
                            ?>
                            <span><?php echo trim($title_parts[0]); ?></span>
                            <?php if(isset($title_parts[1])) : ?>
                            <small><?php echo trim($title_parts[1]); ?></small>
                            <?php endif; ?>
                        </h1>
                    </header>

                    <div>
                        <div class="entry entry-content">
                            <?php the_content(); ?>

                            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'steakhouse' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                        </div><!-- .entry-content -->

                        <?php get_template_part( 'content', 'footer' ); ?>
                    </div>
                </article><!-- #post -->

                <?php comments_template(); ?>
            <?php endwhile; ?>
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
