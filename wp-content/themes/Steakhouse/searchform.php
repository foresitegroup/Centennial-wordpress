<?php
/**
 *
 * The template for displaying search form
 *
 **/
?>

<form role="search" method="get" id="searchform" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <div><label class="screen-reader-text" for="s"><?php _e('Search for:','steakhouse'); ?></label>
        <input type="text" value="" name="s" id="s" class="search-field" placeholder="<?php _e('Search...','steakhouse'); ?>"/>
        <input type="submit" class="search-submit" value="<?php _e('Search','steakhouse'); ?>" />
    </div>
</form>