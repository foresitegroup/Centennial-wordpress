<?php
/**
 *
 * Steakhouse functions and definitions
 *
 */

// loading the necessary elements
get_template_part('comments', 'template');
get_template_part('theme', 'customizer');
get_template_part('addons/class.gkutils');
get_template_part('addons/class.tgm');

if ( ! function_exists( 'steakhouse_excerpt' ) ) :
/**
 *
 * Functions used to generate post excerpt
 *
 * @return HTML output
 *
 **/

function steakhouse_excerpt($text) {
    return $text . '&hellip;';
}
add_filter( 'get_the_excerpt', 'steakhouse_excerpt', 999 );
endif;

if ( ! function_exists( 'steakhouse_excerpt_more' ) ) :
function steakhouse_excerpt_more($text) {
    return '';
}

add_filter( 'excerpt_more', 'steakhouse_excerpt_more', 999 );
endif;

if ( ! function_exists( 'steakhouse_setup' ) ) :
/**
 * Steakhouse setup.
 *
 * Sets up theme defaults and registers the various WordPress features
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 *
 *
 * @return void
 */
function steakhouse_setup() {
	global $content_width;

	if ( ! isset( $content_width ) ) $content_width = 900;

	/*
	 * Makes Steakhouse available for translation.
	 *
	 */
	load_theme_textdomain( 'steakhouse', get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'gallery', 'image', 'link', 'quote', 'video'
	) );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menu( 'mainmenu_left', __( 'Main Menu Left', 'steakhouse' ) );
    register_nav_menu( 'mainmenu_right', __( 'Main Menu Right', 'steakhouse' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'steakhouse' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

    // Enabling parsing the shortcodes in the widgets
    add_filter('widget_text', 'do_shortcode');

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Support for custom header image on the frontpage
	$defaults = array(
		'default-image'          => get_template_directory_uri() . '/images/header_bg.jpg',
		'random-default'         => false,
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => true,
		'flex-width'             => true,
		'default-text-color'     => '#fff',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);

	add_theme_support( 'custom-header', $defaults );

	add_theme_support('widget-customizer');
}
add_action( 'after_setup_theme', 'steakhouse_setup' );
endif;

if ( ! function_exists( 'steakhouse_add_editor_styles' ) ) :
/**
 * Enqueue scripts for the back-end.
 *
 * @return void
 */
function steakhouse_add_editor_styles() {
    add_editor_style('editor.css');
}
add_action('init', 'steakhouse_add_editor_styles');
endif;

if ( ! function_exists( 'steakhouse_scripts' ) ) :
/**
 * Enqueue scripts for the front end.
 *
 * @return void
 */
function steakhouse_scripts() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if(is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	// Loads JavaScript file with Modernizr
	wp_enqueue_script( 'steakhouse-modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '', true );

	// Loads JavaScript file with functionality specific to Steakhouse.
	wp_enqueue_script( 'steakhouse-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '', true );

    // Loads JavaScript file with calendar functionality
    wp_enqueue_script( 'steakhouse-kalendae', get_template_directory_uri() . '/js/kalendae.js', array(), '', true );

	// Loads JavaScript file for responsive video.
	wp_enqueue_script('steakhouse-video',  get_template_directory_uri() . '/js/jquery.fitvids.js', false, false, true);

	// Loads JavaScript file for the scroll reveal
	if(get_theme_mod('steakhouse_scroll_reveal', '1') == '1') {
		wp_enqueue_script('steakhouse-scroll-reveal',  get_template_directory_uri() . '/js/scrollreveal.js', false, false, true);
	}
}

add_action( 'wp_enqueue_scripts', 'steakhouse_scripts' );
endif;

if ( ! function_exists( 'steakhouse_styles' ) ) :
/**
 * Enqueue styles for the front end.
 *
 * @return void
 */
function steakhouse_styles() {
	// Add normalize stylesheet.
	wp_enqueue_style('steakhouse-normalize', get_template_directory_uri() . '/css/normalize.css', false);

	// Add Google font from the customizer
	wp_enqueue_style('steakhouse-fonts-body', get_theme_mod('steakhouse_body_google_font', '//fonts.googleapis.com/css?family=Open+Sans:300,400,500,700'), false);
	wp_enqueue_style('steakhouse-fonts-header', get_theme_mod('steakhouse_headers_google_font', '//fonts.googleapis.com/css?family=Old+Standard+TT:400,700'), false);
	wp_enqueue_style('steakhouse-fonts-other', get_theme_mod('steakhouse_other_google_font', '//fonts.googleapis.com/css?family=Shadows+Into+Light'), false);

	// Font Awesome
	wp_enqueue_style('steakhouse-font-awesome', get_template_directory_uri() . '/css/font.awesome.css', false, '4.2.0' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'steakhouse-style', get_stylesheet_uri());

	// Loads our override.css
	wp_enqueue_style( 'steakhouse-override', get_stylesheet_directory_uri() . '/css/override.css', array('steakhouse-style'));

	// Loads RWD stylesheets
	wp_enqueue_style( 'steakhouse-small-desktop', get_stylesheet_directory_uri() . '/css/small.desktop.css', array('steakhouse-style'), false, '(max-width: '.get_theme_mod('steakhouse_theme_width', '1240').'px)');
	wp_enqueue_style( 'steakhouse-tablet', get_stylesheet_directory_uri() . '/css/tablet.css', array('steakhouse-style'), false, '(max-width: '.get_theme_mod('steakhouse_tablet_width', '1040').'px)');
	wp_enqueue_style( 'steakhouse-small-tablet', get_stylesheet_directory_uri() . '/css/small.tablet.css', array('steakhouse-style'), false, '(max-width: '.get_theme_mod('steakhouse_small_tablet_width', '840').'px)');
	wp_enqueue_style( 'steakhouse-mobile', get_stylesheet_directory_uri() . '/css/mobile.css', array('steakhouse-style'), false, '(max-width: '.get_theme_mod('steakhouse_mobile_width', '640').'px)');

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'steakhouse-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'steakhouse-style' ) );
	wp_style_add_data( 'steakhouse-ie8', 'conditional', 'lt IE 9' );

	wp_enqueue_style( 'steakhouse-ie9', get_template_directory_uri() . '/css/ie9.css', array( 'steakhouse-style' ) );
	wp_style_add_data( 'steakhouse-ie9', 'conditional', 'IE 9' );
}

add_action( 'wp_enqueue_scripts', 'steakhouse_styles' );
endif;

if ( ! function_exists( 'steakhouse_wp_title' ) ) :
/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function steakhouse_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'steakhouse' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'steakhouse_wp_title', 10, 2 );
endif;

if ( ! function_exists( 'steakhouse_widgets_init' ) ) :
/**
 * Register widget area.
 *
 * @return void
 */
function steakhouse_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Header widget area', 'steakhouse' ),
		'id'            => 'header',
		'description'   => __( 'Appears at the top of the website.', 'steakhouse' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( array(
		'name'          => __( 'Top I widget area', 'steakhouse' ),
		'id'            => 'top1',
		'description'   => __( 'Appears at the top of the website.', 'steakhouse' ),
		'before_widget' => '<div class="widget-wrap"><div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( array(
		'name'          => __( 'Top II widget area', 'steakhouse' ),
		'id'            => 'top2',
		'description'   => __( 'Appears at the top of the website.', 'steakhouse' ),
		'before_widget' => '<div class="widget-wrap"><div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( array(
		'name'          => __( 'Content Top', 'steakhouse' ),
		'id'            => 'content_top',
		'description'   => __( 'Appears at the top of the website content.', 'steakhouse' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( array(
		'name'          => __( 'Content Bottom', 'steakhouse' ),
		'id'            => 'content_bottom',
		'description'   => __( 'Appears at the bottom of the website content.', 'steakhouse' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( array(
		'name'          => __( 'Sidebar widget area', 'steakhouse' ),
		'id'            => 'sidebar',
		'description'   => __( 'Appears at the left/right side of the website.', 'steakhouse' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( array(
		'name'          => __( 'Bottom I widget area', 'steakhouse' ),
		'id'            => 'bottom1',
		'description'   => __( 'Appears at the bottom of the website.', 'steakhouse' ),
		'before_widget' => '<div class="widget-wrap"><div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( array(
		'name'          => __( 'Bottom II widget area', 'steakhouse' ),
		'id'            => 'bottom2',
		'description'   => __( 'Appears at the bottom of the website.', 'steakhouse' ),
		'before_widget' => '<div class="widget-wrap"><div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( array(
		'name'          => __( 'Bottom III widget area', 'steakhouse' ),
		'id'            => 'bottom3',
		'description'   => __( 'Appears at the bottom of the website.', 'steakhouse' ),
		'before_widget' => '<div class="widget-wrap"><div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));
}
add_action( 'widgets_init', 'steakhouse_widgets_init' );
endif;

if ( ! function_exists( 'steakhouse_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 *
 * @return void
 */
function steakhouse_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h3 class="screen-reader-text"><?php _e( 'Posts navigation', 'steakhouse' ); ?></h3>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'steakhouse' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'steakhouse' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if( ! function_exists( 'steakhouse_video_code' ) ) :

function steakhouse_video_code() {
	$video_condition = stripos(get_the_content(), '</iframe>') !== FALSE || stripos(get_the_content(), '</video>') !== FALSE;

	if($video_condition) {
		$video_code = '';

		if(stripos(get_the_content(), '</iframe>') !== FALSE) {
			$start = stripos(get_the_content(), '<iframe');
			$len = strlen(substr(get_the_content(), $start, stripos(get_the_content(), '</iframe>', $start)));
			$video_code = substr(get_the_content(), $start, $len + 9);
		} elseif(stripos(get_the_content(), '</video>') !== FALSE) {
			$start = stripos(get_the_content(), '<video');
			$len = strlen(substr(get_the_content(), $start, stripos(get_the_content(), '</video>', $start)));
			$video_code = substr(get_the_content(), $start, $len + 8);
		}

		return $video_code;
	} else {
		return FALSE;
	}
}

endif;


if (!function_exists( 'steakhouse_the_attached_image' )) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Steakhouse 1.0
 *
 * @return void
 */
function steakhouse_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Steakhouse 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'steakhouse_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if (!function_exists( 'steakhouse_register_required_plugins' )) :
/**
 * Register the required plugins for this theme.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function steakhouse_register_required_plugins() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     *
     */
     $plugins = array(
          // Plugins pre-packaged with a theme.
          array(
              'name'               => 'GK Widget Rules',
              'slug'               => 'gk-widget-rules',
              'source'             => 'http://www.gavick.com/upd/gk-widget-rules.zip',
              'required'           => true,
              'version'            => ''
          ),

          array(
              'name'               => 'GK News Show Pro',
              'slug'               => 'gk-nsp',
              'source'             => 'http://www.gavick.com/upd/gk-nsp.zip',
              'required'           => true,
              'version'            => ''
          ),
          
          array(
              'name'               => 'GK Taxonomy Images',
              'slug'               => 'gk-taxonomy-images',
              'source'             => 'http://www.gavick.com/upd/gk-taxonomy-images.zip',
              'required'           => true,
              'version'            => ''
          ),
          
          array(
              'name'               => 'GK Contact Steakhouse',
              'slug'               => 'gk-contact-steakhouse',
              'source'             => 'http://www.gavick.com/upd/gk-contact-steakhouse.zip',
              'required'           => true,
              'version'            => ''
          ),
          
          array(
              'name'               => 'GK Reservation Steakhouse',
              'slug'               => 'gk-reservation-steakhouse',
              'source'             => 'http://www.gavick.com/upd/gk-reservation-steakhouse.zip',
              'required'           => true,
              'version'            => ''
          ),

          array(
              'name'               => 'GK Tabs',
              'slug'               => 'gk-tabs',
              'source'             => 'http://www.gavick.com/upd/gk-tabs.zip',
              'required'           => false,
              'version'            => ''
          )
      );

     /**
      * Array of configuration settings.
      */
     $config = array(
         'id'           => 'tgmpa',
         'menu'         => 'tgmpa-install-plugins',
         'has_notices'  => true,
         'dismissable'  => true,
         'is_automatic' => false,
         'strings'      => array(
            'menu_title'                      => __( 'Install Plugins', 'steakhouse' ),
            'page_title'                      => __( 'Install Required Plugins', 'steakhouse' ),
            'installing'                      => __( 'Installing Plugin: %s', 'steakhouse' ),
            'oops'                            => __( 'Something went wrong with the plugin API.', 'steakhouse' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'steakhouse' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'steakhouse' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'steakhouse' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'steakhouse' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'steakhouse' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'steakhouse' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'steakhouse' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'steakhouse' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'steakhouse' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'steakhouse' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'steakhouse' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'steakhouse' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'steakhouse' ),
            'nag_type'                        => 'updated'
         )
     );

     tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'steakhouse_register_required_plugins');
endif;

// EOF
