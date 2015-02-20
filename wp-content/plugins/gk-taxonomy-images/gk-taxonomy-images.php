<?php 

/*
Plugin Name:    GK Taxonomy Images
Plugin URI:     http://wordpress.org/extend/plugins/gk-taxonomy-images/
Description:    Simple plugin for adding custom images in the category/tag pages
Version:        1.0.0
Author:         GavickPro
Author URI:     http://www.gavick.com
 
Text Domain:   gk-taxonomy-images
Domain Path:   /languages/
*/ 

global $pagenow;

/**
 * i18n - language files should be like gk-taxonomy-images-en_GB.po and gk-taxonomy-images-en_GB.mo
 */
add_action( 'plugins_loaded', 'gk_taxonomy_images_load_textdomain' );

function gk_taxonomy_images_load_textdomain() {
  load_plugin_textdomain('gk-taxonomy-images', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'); 
}

// Code for the dashboard
if(is_admin()) {
	// actions
	add_action('admin_enqueue_scripts', array('GK_Taxonomy_Images', 'load_scripts'));
	add_action('edit_category_form_fields', array('GK_Taxonomy_Images', 'render_fields'));
	add_action('edit_tag_form_fields', array('GK_Taxonomy_Images', 'render_fields'));
	add_action('edit_category', array('GK_Taxonomy_Images', 'save'));
	add_action('edit_tag', array('GK_Taxonomy_Images', 'save'));

	// Class with all plugin functionality
	class GK_Taxonomy_Images { 
		// Code used to load JS and CSS in the back-end
		static function load_scripts($hook) {
			if($hook != 'edit-tags.php') {
				return;
			}
		 
			wp_enqueue_script( 'gk-taxonomy-images-', plugins_url('gk-taxonomy-images.js', __FILE__));
			wp_enqueue_style( 'gk-taxonomy-images', plugins_url('gk-taxonomy-images.css', __FILE__));
		}
		// Rendering of the additional fields in the category page
		static function render_fields($tag) {
		    // we need to know the values of our existing entries if any
		    $category_images = unserialize(get_option('gk_taxonomy_images'));
		    $category_image = '';

		    if(isset($category_images[$tag->term_id])) {
		    	$category_image = $category_images[$tag->term_id];
		    }

		    ?>
		    <tr class="form-field">
		        <th scope="row" valign="top"><label for="category-image"><?php _e('Image', 'gk-taxonomy-images'); ?></label></th>
		        <td>
		            <input type="hidden" name="gk_taxonomy_images" class="gk_taxonomy_images" size="25" value="<?php if ($category_image != '') esc_attr_e($category_image); ?>" />
		            <button class="gk_taxonomy_images_btn button-secondary"><?php _e('Select image', 'gk-taxonomy-images'); ?></button>
		            <button class="gk_taxonomy_images_btn_remove button-secondary"><?php _e('Remove image', 'gk-taxonomy-images'); ?></button>
		     
		            <div class="gk_taxonomy_images_preview">
		            	<?php if($category_image != '') : ?>
		            		<img src="<?php esc_attr_e($category_image); ?>" alt="<?php _e('Preview image', 'gk-taxonomy-images'); ?>" class="gk_taxonomy_images_preview_img" />
		            	<?php endif; ?>
		            </div>

		            <input type="hidden" name="gk_taxonomy_images_id" value="<?php echo $tag->term_id; ?>" />
		            <p class="description"><?php _e('Select an image which will be displayed in the taxonomy page for this term.', 'gk-taxonomy-images'); ?></[>
		        </td>
		    </tr>
		    <?php
		}
		// Saving the image data
		static function save() {
		    if(isset($_POST['gk_taxonomy_images_id'])) {
		    	$category_images = unserialize(get_option('gk_taxonomy_images'));
		    	$category_images[esc_attr($_POST['gk_taxonomy_images_id'])] = esc_attr($_POST['gk_taxonomy_images']);

		    	update_option('gk_taxonomy_images', serialize($category_images));
		    }
		}
	}	
} // end of the code for the dashboard

// Cod for the front-end
if(!is_admin()) {
	// function used for displaying the category/tag image
	// $term_id - ID of the category/tag
	// $class_name - CSS class name used in the image
	// $attrs - other attributes of the image
	function gk_taxonomy_image($term_id, $class_name = '', $attrs = '', $echo = true) {
		// get the images data
		$category_images = unserialize(get_option('gk_taxonomy_images'));
		// output variable
		$output = false;
		// check the existence of the image
		if(isset($category_images[$term_id])) {
			$output = '<img src="'.esc_attr($category_images[$term_id]).'" '.($class_name != '' ? ' class="'.$class_name.'"' : '').' '.$attrs.' alt="" />';
		}
		// return the value in a requested form
		if($echo) {
			echo $output;
		} else {
			return $output;
		}
	}
}

// EOF