<?php
/*
Template Name: Frontpage
*/

// get frontpage IDs
$frontpage_IDs = get_theme_mod('steakhouse_frontpage_ids', '');

if($frontpage_IDs != '') {
    $frontpage_IDs = explode(PHP_EOL, $frontpage_IDs);
}

//create arguments for custom main loop
$args_global = array(
	'post_type' => 'page',
	'post_parent' => get_the_ID(),
	'order' => 'ASC',
	'orderby' => 'menu_order',
	'posts_per_page' => 100
);
$loop_global = new WP_Query( $args_global );

get_header('frontpage'); ?>

	<?php do_action('steakhouse_before_content'); ?>
		<div id="frontpage-wrap" role="main">
			<?php if ( $loop_global->have_posts() ) : ?>
                <?php $frontpage_iterator = 0; ?>
				<?php while ( $loop_global->have_posts() ) : $loop_global->the_post(); ?>
					<?php
						$frontpage_id = '';

                        if(isset($frontpage_IDs[$frontpage_iterator])) {
                            $frontpage_id = ' id="' . $frontpage_IDs[$frontpage_iterator] . '"';
                        }

                        $background_image = '';
						// check if there is a featured image - it willbe used as a parallax background
						if(has_post_thumbnail()) {
							$background_image = ' style="background-image: url(\''.wp_get_attachment_url(get_post_thumbnail_id()).'\');"';
						}

						$additional_classes = '';

						if(stripos(get_the_content(), 'gk-color-bg') !== FALSE) {
							$additional_classes .= ' gk-color-bg';
						}

                        if(stripos(get_the_content(), 'gk-description-wrap') !== FALSE) {
                            $additional_classes .= ' gk-description';
                        }

                        if(stripos(get_the_content(), 'class="map') !== FALSE) {
                            $additional_classes .= ' map';
                        }

                        if(stripos(get_the_content(), 'gk-smaller-margins') !== FALSE) {
                            $additional_classes .= ' gk-smaller-margins';
                        }

                        if(has_post_thumbnail()) {
                            $additional_classes .= ' gk-parallax';
                        }

					?>
					<div <?php echo $frontpage_id; ?> class="frontpage-block<?php echo $additional_classes; ?>" <?php echo $background_image; ?>>
						<div class="frontpage-block-wrap">
							<?php if(substr(get_the_title(), 0, 1) != '!') : ?>
                            <div class="bigtitle">
                                <h3 class="header">
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
                                </h3>
                            </div>
                            <?php endif; ?>

							<?php echo do_shortcode(str_replace(array('<p></p>'), '', get_the_content())); ?>
						</div>
					</div>
                    <?php $frontpage_iterator++; ?>
				<?php endwhile; ?>

				<?php wp_reset_query(); ?>
			<?php endif; ?>
		</div><!-- frontpage-wrap -->
	<?php do_action('steakhouse_after_content'); ?>
<?php get_footer('frontpage'); ?>
