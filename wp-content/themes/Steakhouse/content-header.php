<?php

	/*
		Template for the entry header
	*/

?>
<header class="entry-header">
    <?php
        if ('post' == get_post_type() ) {
            $date_format = esc_html(get_the_date('D j M, Y'));

            if(get_theme_mod('steakhouse_date_format', 'default') == 'wordpress') {
                $date_format = get_the_date(get_option('date_format'));
            }

            echo sprintf('<time class="entry-date" datetime="'. esc_attr(get_the_date('c')) . '">'. $date_format . '</time>');
        }
    ?>

    <h<?php echo is_single() ? '1' : '2'; ?> class="entry-title<?php if(is_sticky()) : ?> sticky<?php endif; ?>">
		<?php if(!is_single()) : ?><a href="<?php the_permalink(); ?>" rel="bookmark" class="inverse"><?php endif; ?>
		<?php the_title(); ?>
		<?php if(!is_single()) : ?></a><?php endif; ?>
	</h<?php echo is_single() ? '1' : '2'; ?>>
</header>

<?php if ( 'post' == get_post_type() && (is_singular() || is_category()) ) : ?>
<p class="item-author">
    <span>
    <?php
        $avatar_size = apply_filters('steakhouse_author_bio_avatar_size', 32);
        echo get_avatar( get_the_author_meta( 'user_email' ), $avatar_size );

        echo '<span>' . __( 'Written by ', 'steakhouse' ) . '</span>';
        printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'steakhouse' ), get_the_author() ) ),
            get_the_author()
        );
    ?>
    </span>
</p>
<?php else : ?>
    <?php
        // Translators: used between list items, there is a space after the comma.
        $categories_list = get_the_category_list( __( ', ', 'steakhouse' ) );
        if ( $categories_list ) :
    ?>
    <p class="item-author">
        <span>
        <?php
            echo __('Published in ', 'steakhouse');
            echo '<span class="categories-links">' . $categories_list . '</span>';
        ?>
        </span>
    </p>
    <?php endif; ?>
<?php endif; ?>

<?php if(is_single()) : ?>
<ul class="item-info">
    <?php if(get_post_format() != '') : ?>
    <li>
        <span class="format gk-format-<?php echo get_post_format(); ?>"></span>
    </li>
    <?php endif; ?>
    <?php
        // Translators: used between list items, there is a space after the comma.
        $categories_list = get_the_category_list( __( ', ', 'steakhouse' ) );
        if ( $categories_list ) :
    ?>
    <li>
        <?php
            echo __('Published in ', 'steakhouse');
            echo '<span class="categories-links">' . $categories_list . '</span>';
        ?>
    </li>
    <?php endif; ?>

    <?php if (!post_password_required() && (comments_open() || get_comments_number())) : ?>
    <li class="comments-link">
        <?php comments_popup_link( __( 'Leave a comment', 'steakhouse' ), __( '1 Comment', 'steakhouse' ), __( '% Comments', 'steakhouse' ) ); ?>
    </li>
    <?php endif; ?>

    <?php if(current_user_can('edit_posts') || current_user_can('edit_pages')) : ?>
    <li>
        <?php edit_post_link(__( 'Edit', 'perfetta'), '<span class="edit-link">', '</span>'); ?>
    </li>
    <?php endif; ?>
</ul>
<?php endif; ?>
