<?php

global $wp_customize;

get_template_part('theme-customizer-extensions/textarea');
get_template_part('theme-customizer-extensions/color-utils');

if (isset($wp_customize)) {

	/* Add additional options to Theme Customizer */
	function steakhouse_init_customizer( $wp_customize ) {
		// Used fonts
		$body_font = '//fonts.googleapis.com/css?family=Open+Sans:300,400,500,700';
		$header_font = '//fonts.googleapis.com/css?family=Old+Standard+TT:400,700';
		$other_font = '//fonts.googleapis.com/css?family=Shadows+Into+Light';
		// Selectors for the used fonts
		$body_font_selectors = 'body,
button,
.button,
input[type="submit"],
input[type="button"],
select,
textarea,
input[type="text"],
input[type="password"],
input[type="url"],
input[type="email"],
.newsletter .header,
.one-page-layout h2,
.one-page-layout h3,
article header h1,
article header h2,
.category .item-view h2,
.item-view h1,
#comments h3,
#respond h3,
.contact-form .gk-cols h3,
.gk-menu .gk-cols h3,
.border1 .header,
.border2 .header,
.border1 .widget-title,
.border2 .widget-title,
.entry h1,
.entry h2,
.entry h3,
.entry h4,
.entry h5,
.entry h6';

		$header_font_selectors = '#gk-logo,
h1,h2,h3,h4,h5,h6,
.one-page-layout .header,
blockquote:before,
blockquote p:after';

		$other_font_selectors = '#gk-header-mod h2,
.big-icon,
.newsletter .header small,
.bigtitle .header small';

        // Add new settings sections
	    $wp_customize->add_section(
		    'steakhouse_font_options',
		    array(
		        'title'     => __('Font options', 'steakhouse'),
		        'capability' => 'edit_theme_options',
		        'priority'  => 200
	    	)
	    );

	    $wp_customize->add_section(
		    'steakhouse_layout_options',
		    array(
		        'title'     => __('Layout', 'steakhouse'),
		        'capability' => 'edit_theme_options',
		        'priority'  => 300
	    	)
	    );

	    $wp_customize->add_section(
		    'steakhouse_features_options',
		    array(
		        'title'     => __('Features', 'steakhouse'),
		        'capability' => 'edit_theme_options',
		        'priority'  => 400
	    	)
	    );

	    // Add new settings
	    $wp_customize->add_setting(
	    	'steakhouse_primary_color',
	    	array(
	    		'default' => '#d27244',
	    		'capability' => 'edit_theme_options',
	    		'transport' => 'postMessage',
	    		'sanitize_callback' => 'sanitize_hex_color'
	    	)
	    );

        $wp_customize->add_setting(
            'steakhouse_body_font',
            array(
                'default'   => 'google',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'steakhouse_sanitize_font'
                )
            );

        $wp_customize->add_setting(
            'steakhouse_body_google_font',
            array(
                'default'   => $body_font,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw'
            )
        );

        $wp_customize->add_setting(
            'steakhouse_body_font_selectors',
            array(
                'default'   => $body_font_selectors,
                'capability' => 'edit_theme_options',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_textarea'
            )
        );

		$wp_customize->add_setting(
			'steakhouse_headers_font',
			array(
			    'default'   => 'google',
			    'capability' => 'edit_theme_options',
			    'sanitize_callback' => 'steakhouse_sanitize_font'
			)
		);

		$wp_customize->add_setting(
		    'steakhouse_headers_google_font',
		    array(
		        'default'   => $header_font,
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'esc_url_raw'
		    )
		);

		$wp_customize->add_setting(
			'steakhouse_headers_font_selectors',
			array(
			    'default'   => $header_font_selectors,
			    'sanitize_callback' => 'esc_textarea'
			)
		);

        $wp_customize->add_setting(
            'steakhouse_other_font',
            array(
                'default'   => 'google',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'steakhouse_sanitize_font'
                )
            );

        $wp_customize->add_setting(
            'steakhouse_other_google_font',
            array(
                'default'   => $other_font,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw'
            )
        );

        $wp_customize->add_setting(
            'steakhouse_other_font_selectors',
            array(
                'default'   => $other_font_selectors,
                'capability' => 'edit_theme_options',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_textarea'
            )
        );

		$wp_customize->add_setting(
			'steakhouse_theme_width',
			array(
				'default'   => '1230',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_number'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_tablet_width',
			array(
				'default'   => '1040',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_number'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_small_tablet_width',
			array(
				'default'   => '840',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_number'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_mobile_width',
			array(
				'default'   => '640',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_number'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_sidebar_width',
			array(
				'default'   => '26',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_number'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_sidebar_pos',
			array(
				'default'   => 'right',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_sidebar_pos'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_logo',
			array(
				'default' => '',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

        $wp_customize->add_setting(
            'steakhouse_menu_logo',
            array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw'
            )
        );

        $wp_customize->add_setting(
            'steakhouse_word_break',
            array(
                'default'   => '0',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'steakhouse_sanitize_switch'
            )
        );

		$wp_customize->add_setting(
			'steakhouse_scroll_reveal',
			array(
				'default'   => '1',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_switch'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_related_posts',
			array(
				'default'   => '1',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_switch'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_post_social_icons',
			array(
				'default'   => '1',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_switch'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_page_social_icons',
			array(
				'default'   => '',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_switch'
			)
		);

        $wp_customize->add_setting(
            'steakhouse_frontpage_ids',
            array(
                'default'   => 'restaurant
special
menu
reservation
blog
info
location',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_textarea'
            )
        );

		$wp_customize->add_setting(
			'steakhouse_date_format',
			array(
				'default'   => 'default',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'steakhouse_sanitize_date_format'
			)
		);

		$wp_customize->add_setting(
			'steakhouse_copyright_text',
			array(
				'default'   => '&copy; 2014 GavickPro. All rights reserved.',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		// Add control for the settings
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'steakhouse_primary_color',
				array(
					'label' => __('Primary Color', 'steakhouse'),
					'section' => 'colors',
					'settings' => 'steakhouse_primary_color'
				)
			)
		);

		$wp_customize->add_control(
		    'steakhouse_body_font',
		    array(
		        'section'  => 'steakhouse_font_options',
		        'label'    => __('Body Font', 'steakhouse'),
		        'type'     => 'select',
		        'choices'  => array(
		        	'google'    		=> 'Google Font',
		        	'verdana'   		=> 'Verdana',
		        	'georgia'    		=> 'Georgia',
		        	'arial'      		=> 'Arial',
		        	'impact'     		=> 'Impact',
		        	'tahoma'     		=> 'Tahoma',
		            'times'      		=> 'Times New Roman',
		            'comic sans ms'     => 'Comic Sans MS',
		            'courier new'   	=> 'Courier New',
		            'helvetica'  		=> 'Helvetica'
		        ),
		        'priority' => 0
		   	 )
		);

		$wp_customize->add_control(
		    'steakhouse_body_google_font',
		    array(
		        'section'  => 'steakhouse_font_options',
		        'label'    => __('Google Font URL for the Body', 'steakhouse'),
		        'active_callback' => 'steakhouse_show_font_body',
		        'type'     => 'text',
		        'priority' => 1
	    	)
		);

		$wp_customize->add_control(
			new Steakhouse_Customize_Textarea_Control(
				$wp_customize,
				'steakhouse_body_font_selectors',
				array(
			    	'label' => __('Selectors for the body font', 'steakhouse'),
			    	'section' => 'steakhouse_font_options',
			    	'settings' => 'steakhouse_body_font_selectors',
			    	'priority' => 2
				)
			)
		);

        $wp_customize->add_control(
            'steakhouse_headers_font',
            array(
                'section'  => 'steakhouse_font_options',
                'label'    => __('Header Font', 'steakhouse'),
                'type'     => 'select',
                'choices'  => array(
                    'google'            => 'Google Font',
                    'verdana'           => 'Verdana',
                    'georgia'           => 'Georgia',
                    'arial'             => 'Arial',
                    'impact'            => 'Impact',
                    'tahoma'            => 'Tahoma',
                    'times'             => 'Times New Roman',
                    'comic sans ms'     => 'Comic Sans MS',
                    'courier new'       => 'Courier New',
                    'helvetica'         => 'Helvetica'
                ),
                'priority' => 3
             )
        );

        $wp_customize->add_control(
            'steakhouse_headers_google_font',
            array(
                'section'  => 'steakhouse_font_options',
                'label'    => __('Google Font URL for Header', 'steakhouse'),
                'active_callback' => 'steakhouse_show_font_headers',
                'type'     => 'text',
                'priority' => 4
            )
        );

        $wp_customize->add_control(
            new Steakhouse_Customize_Textarea_Control(
                $wp_customize,
                'steakhouse_headers_font_selectors',
                array(
                    'label' => __('Selectors for the header font', 'steakhouse'),
                    'section' => 'steakhouse_font_options',
                    'settings' => 'steakhouse_headers_font_selectors',
                    'priority' => 5
                )
            )
        );

        $wp_customize->add_control(
            'steakhouse_other_font',
            array(
                'section'  => 'steakhouse_font_options',
                'label'    => __('Other Elements Font', 'steakhouse'),
                'type'     => 'select',
                'choices'  => array(
                    'google'            => 'Google Font',
                    'verdana'           => 'Verdana',
                    'georgia'           => 'Georgia',
                    'arial'             => 'Arial',
                    'impact'            => 'Impact',
                    'tahoma'            => 'Tahoma',
                    'times'             => 'Times New Roman',
                    'comic sans ms'     => 'Comic Sans MS',
                    'courier new'       => 'Courier New',
                    'helvetica'         => 'Helvetica'
                ),
                'priority' => 6
             )
        );

        $wp_customize->add_control(
            'steakhouse_other_google_font',
            array(
                'section'  => 'steakhouse_font_options',
                'label'    => __('Google Font URL for the other elements', 'steakhouse'),
                'active_callback' => 'steakhouse_show_font_others',
                'type'     => 'text',
                'priority' => 7
            )
        );

        $wp_customize->add_control(
            new Steakhouse_Customize_Textarea_Control(
                $wp_customize,
                'steakhouse_other_font_selectors',
                array(
                    'label' => __('Selectors for the other elements font', 'steakhouse'),
                    'section' => 'steakhouse_font_options',
                    'settings' => 'steakhouse_other_font_selectors',
                    'priority' => 8
                )
            )
        );

		$wp_customize->add_control(
		    'steakhouse_theme_width',
		    array(
		        'section'  => 'steakhouse_layout_options',
		        'label'    => __('Theme width (px)', 'steakhouse'),
		        'type'     => 'text',
		        'priority' => 0
			)
		);

		$wp_customize->add_control(
		    'steakhouse_tablet_width',
		    array(
		        'section'  => 'steakhouse_layout_options',
		        'label'    => __('Tablet width (px)', 'steakhouse'),
		        'type'     => 'text',
		        'priority' => 1
			)
		);

		$wp_customize->add_control(
		    'steakhouse_small_tablet_width',
		    array(
		        'section'  => 'steakhouse_layout_options',
		        'label'    => __('Small tablet width (px)', 'steakhouse'),
		        'type'     => 'text',
		        'priority' => 2
			)
		);

		$wp_customize->add_control(
		    'steakhouse_mobile_width',
		    array(
		        'section'  => 'steakhouse_layout_options',
		        'label'    => __('Mobile width (px)', 'steakhouse'),
		        'type'     => 'text',
		        'priority' => 3
			)
		);

		$wp_customize->add_control(
		    'steakhouse_sidebar_width',
		    array(
		        'section'  => 'steakhouse_layout_options',
		        'label'    => __('Sidebar width (%)', 'steakhouse'),
		        'type'     => 'text',
		        'priority' => 4
			)
		);

		$wp_customize->add_control(
		    'steakhouse_sidebar_pos',
		    array(
		        'section'  => 'steakhouse_layout_options',
		        'label'    => __('Sidebar position', 'steakhouse'),
		        'type'     => 'select',
		        'choices'  => array(
		            'left'     => __('Left', 'steakhouse'),
		            'right'    => __('Right', 'steakhouse')
		        ),
		        'priority' => 5
		    )
		);

		$wp_customize->add_control(
		   new WP_Customize_Image_Control(
		       $wp_customize,
		       'steakhouse_logo',
		       array(
		           'label'      => __('Upload a logo (leave blank to use the CSS logo)', 'steakhouse'),
		           'section'    => 'steakhouse_features_options',
		           'settings'   => 'steakhouse_logo',
		           'priority'   => 0
		       )
		   )
		);

        $wp_customize->add_control(
           new WP_Customize_Image_Control(
               $wp_customize,
               'steakhouse_menu_logo',
               array(
                   'label'      => __('Upload a menu logo (leave blank to use the CSS logo)', 'steakhouse'),
                   'section'    => 'steakhouse_features_options',
                   'settings'   => 'steakhouse_menu_logo',
                   'priority'   => 1
               )
           )
        );

        $wp_customize->add_control(
            'steakhouse_word_break',
            array(
                'section'  => 'steakhouse_features_options',
                'label'    => __('Enable word-break', 'steakhouse'),
                'type'     => 'checkbox',
                'priority' => 2
            )
        );

		$wp_customize->add_control(
		    'steakhouse_scroll_reveal',
		    array(
		        'section'  => 'steakhouse_features_options',
		        'label'    => __('Use Scroll Reveal', 'steakhouse'),
		        'type'     => 'checkbox',
		        'priority' => 3
		    )
		);

		$wp_customize->add_control(
		    'steakhouse_related_posts',
		    array(
		        'section'  => 'steakhouse_features_options',
		        'label'    => __('Display related posts', 'steakhouse'),
		        'type'     => 'checkbox',
		        'priority' => 4
		    )
		);

		$wp_customize->add_control(
		    'steakhouse_post_social_icons',
		    array(
		        'section'  => 'steakhouse_features_options',
		        'label'    => __('Post Social Icons', 'steakhouse'),
		        'type'     => 'checkbox',
		        'priority' => 5
		    )
		);

		$wp_customize->add_control(
		    'steakhouse_page_social_icons',
		    array(
		        'section'  => 'steakhouse_features_options',
		        'label'    => __('Page Social Icons', 'steakhouse'),
		        'type'     => 'checkbox',
		        'priority' => 6
		    )
		);

        $wp_customize->add_control(
            new Steakhouse_Customize_Textarea_Control(
                $wp_customize,
                'steakhouse_frontpage_ids',
                array(
                    'label' => __('IDs for the frontpage blocks', 'steakhouse'),
                    'section' => 'steakhouse_features_options',
                    'settings' => 'steakhouse_frontpage_ids',
                    'priority' => 7
                )
            )
        );

		$wp_customize->add_control(
		    'steakhouse_date_format',
		    array(
		        'section'  => 'steakhouse_features_options',
		        'label'    => __('Date format', 'steakhouse'),
		        'type'     => 'select',
		        'choices'  => array(
		            'default'     => __('Default theme format', 'steakhouse'),
		            'wordpress'     => __('WordPress Date Format', 'steakhouse')
		        ),
		        'priority' => 8
		    )
		);

		$wp_customize->add_control(
		    'steakhouse_copyright_text',
		    array(
		        'section'  => 'steakhouse_features_options',
		        'label'    => __('Copyright text', 'steakhouse'),
		        'type'     => 'text',
		        'priority' => 9
			)
		);
	}

	add_action( 'customize_register', 'steakhouse_init_customizer' );
}

function steakhouse_customizer_fonts($group, $font, $selectors) {
    // Check the type of the font
    if (get_theme_mod('steakhouse_'.$group.'_google_font', $font) !== '' && get_theme_mod('steakhouse_'.$group.'_font', $font) == 'google') {
        // Parse the google font
        $google = esc_attr(get_theme_mod('steakhouse_'.$group.'_google_font', $font));
        $fname = array();
        preg_match('@family=(.+)$@is', $google, $fname);
        $font = "'" . str_replace('+', ' ', preg_replace('@:.+@', '', preg_replace('@&.+@', '', $fname[1]))) . "'";
    } else {
    	$font = esc_attr(get_theme_mod('steakhouse_'.$group.'_font', 'arial'));
    }
    // Set the font selectors
    $font_selectors = esc_textarea(get_theme_mod('steakhouse_'.$group.'_font_selectors', $selectors));
    // Output the CSS code
    $filtered_selectors = str_replace('&amp;', '&', $font_selectors);
    $filtered_selectors = str_replace('&quot;', '"', $filtered_selectors);
    echo $filtered_selectors . ' { font-family: '.$font.'; }';
}

function steakhouse_show_font_body($control) {
    $option = $control->manager->get_setting('steakhouse_body_font') ;
    return $option->value() == 'google';
}

function steakhouse_show_font_headers($control) {
    $option = $control->manager->get_setting('steakhouse_headers_font') ;
    return $option->value() == 'google';
}

function steakhouse_show_font_others($control) {
    $option = $control->manager->get_setting('steakhouse_other_font') ;
    return $option->value() == 'google';
}

function steakhouse_sanitize_number($value) {
	if(is_numeric($value)) {
		return $value;
	}
	
	return null;
}

function steakhouse_sanitize_switch($value) {
	if($value == '0' || $value == '1') {
		return $value;
	}
	
	return null;
}

function steakhouse_sanitize_font($value) {
	$fonts = array(
		'google', 
		'verdana', 
		'georgia', 
		'arial', 
		'impact', 
		'tahoma', 
		'times',
		'comic sans ms',
		'courier new',
		'helvetica'
	);
	
	if(in_array($value, $fonts)) {
		return $value;
	}
	
	return null;
}

function steakhouse_sanitize_sidebar_pos($value) {
	if($value === 'left' || $value === 'right') {
		return $value;
	}
	return null;
}

function steakhouse_sanitize_date_format($value) {
	if($value === 'default' || $value === 'wordpress') {
		return $value;
	}
	return null;
}

// Add CSS styles generated from GK Cusotmizer settings
function steakhouse_customizer_css() {
	// Used fonts
	$body_font = '//fonts.googleapis.com/css?family=Open+Sans:300,400,500,700';
	$header_font = '//fonts.googleapis.com/css?family=Old+Standard+TT:400,700';
	$other_font = '//fonts.googleapis.com/css?family=Shadows+Into+Light';
	// Selectors for the used fonts
	$body_font_selectors = 'body,
button,
.button,
input[type="submit"],
input[type="button"],
select,
textarea,
input[type="text"],
input[type="password"],
input[type="url"],
input[type="email"],
.newsletter .header,
.one-page-layout h2,
.one-page-layout h3,
article header h1,
article header h2,
.category .item-view h2,
.item-view h1,
#comments h3,
#respond h3,
.contact-form .gk-cols h3,
.gk-menu .gk-cols h3,
.border1 .header,
.border2 .header,
.border1 .widget-title,
.border2 .widget-title,
.entry h1,
.entry h2,
.entry h3,
.entry h4,
.entry h5,
.entry h6';

	$header_font_selectors = '#gk-logo,
h1,h2,h3,h4,h5,h6,
.one-page-layout .header,
blockquote:before,
blockquote p:after';

	$other_font_selectors = '#gk-header-mod h2,
.big-icon,
.newsletter .header small,
.bigtitle .header small';

    // get colors
    $primary_color = esc_attr(get_theme_mod('steakhouse_primary_color', '#d27244'));
    // get theme dimensions
    $theme_width = preg_replace('@[^0-9]@mi', '', esc_attr(get_theme_mod('steakhouse_theme_width', '1230')));
    $sidebar_width = preg_replace('@[^0-9]@mi', '', esc_attr(get_theme_mod('steakhouse_sidebar_width', '26')));
    $sidebar_pos = esc_attr(get_theme_mod('steakhouse_sidebar_pos', 'right'));

    ?>
    <style type="text/css">
    	/* Font settings */
    	<?php steakhouse_customizer_fonts('body', $body_font, $body_font_selectors); ?>
    	
        <?php steakhouse_customizer_fonts('headers', $header_font, $header_font_selectors); ?>
        
        <?php steakhouse_customizer_fonts('other', $other_font, $other_font_selectors); ?>

        <?php if(get_theme_mod('steakhouse_word_break', '1') == '1') : ?>
        body {
            -ms-word-break: break-all;
            word-break: break-all;
            word-break: break-word;
            -webkit-hyphens: auto;
            -moz-hyphens: auto;
            -ms-hyphens: auto;
            hyphens: auto;
        }
        <?php endif; ?>

    	/* Layout settings */
    	.site,
        .widget-area[data-cols="2"],
        .widget-area[data-cols="3"],
        .widget-area[data-cols="3"],
        .widget-area[data-cols="4"],
        .widget-area[data-cols="5"],
        .widget-area[data-cols="6"],
        .widget-area[data-cols="7"],
        .widget-area[data-cols="8"],
        .widget-area[data-cols="9"],
        .map.contact-form,
    	#gk-header-nav-wrap,
    	.frontpage-block-wrap,
    	#gk-header-widget .widget-area,
        #gk-bg .page.one-page-wide-layout > div {
            margin: 0 auto;
    		max-width: <?php echo $theme_width ?>px;
    		width: 100%;
    	}
    	<?php if(is_active_sidebar('sidebar')) : ?>
    	#content {
    		float: <?php echo ($sidebar_pos == 'right') ? 'left' : 'right' ?>;
    		width: <?php echo 100 - $sidebar_width; ?>%;
    	}
    	#sidebar {
    		float: <?php echo ($sidebar_pos == 'right') ? 'right' : 'left' ?>;
    		padding-<?php echo ($sidebar_pos == 'right') ? 'left' : 'right' ?>: 45px;
    		width: <?php echo $sidebar_width; ?>%;
    	}
    	<?php else : ?>
    	#content,
    	#sidebar {
    		width: 100%;
    	}
    	<?php endif; ?>
    	/* Header text color */
    	#gk-header-mod,
    	#gk-header-mod h1,
    	#gk-header-mod h2 {
    		color: <?php echo '#'.get_header_textcolor(); ?>;
    	}
    	
    	/* Primary color */
    	a,
    	a.inverse:active, 
    	a.inverse:focus, 
    	a.inverse:hover,
    	.nav-menu > li > a:active, 
    	.nav-menu > li > a:focus, 
    	.nav-menu > li > a:hover, 
    	/*.nav-menu > li.current_page_item > a, */
    	.nav-menu > li.current_page_item > a:active, 
    	.nav-menu > li.current_page_item > a:focus, 
    	.nav-menu > li.current_page_item > a:hover,
    	#aside-menu li a:active, 
    	#aside-menu li a:focus, 
    	#aside-menu li a:hover, 
    	#aside-menu li.current_page_item a,
    	blockquote:before,
    	blockquote p:after,
    	.gk-menu-container dd strong,
    	.bigtitle .header > a:active, 
    	.bigtitle .header > a:focus, 
    	.bigtitle .header > a:hover,
    	.bigtitle .widget-title > a:active,
    	.bigtitle .widget-title > a:focus,
    	.bigtitle .widget-title > a:hover,
    	.widget.color1 a,
    	.gk-nsp-next:hover:after,
    	.gk-nsp-prev:hover:after,
    	.gk-nsp-art .gk-nsp-star-1:before,
    	#gk-footer-nav a:active, 
    	#gk-footer-nav a:focus, 
    	#gk-footer-nav a:hover,
    	.big-icon a:active,
    	.big-icon a:focus,
    	.big-icon a:hover,
    	.gk-menu .gk-cols dd strong,
    	#close-menu {
    	  color: <?php echo $primary_color; ?>;
    	}
    	button,
    	.button,
    	.readon,
    	.button-border,
    	input[type="submit"],
    	input[type="button"],
    	input[type="reset"],
    	.nav-menu > li .sub-menu,
    	.nav-menu ul > li .children,
    	.paging-navigation a,
    	.widget.color2,
    	.gk-nsp-news_grid > a,
    	.gk-nsp-arts-nav ul li.active,
    	.gk-nsp-links-nav ul li.active,
    	.gk-special-link:active, 
    	.gk-special-link:focus, 
    	.gk-special-link:hover,
    	.gk-testimonials-pagination li.active {
    	  background: <?php echo $primary_color; ?>;
    	}
    	.button-border {
    	  border-color: <?php echo $primary_color; ?>;
    	  color: <?php echo $primary_color; ?>!important;
    	}
    	.nav-menu > li.menu-item-has-children a:before,
    	.nav-menu ul > li.menu-item-has-children a:before {
    	  border-color: <?php echo $primary_color; ?>;
    	  border-left-color: #fff;
    	  border-right-color: #fff;
    	}
    	.gk-photo-overlay-prev:active,
    	.gk-photo-overlay-prev:focus,
    	.gk-photo-overlay-prev:hover,
    	.gk-photo-overlay-next:active,
    	.gk-photo-overlay-next:focus,
    	.gk-photo-overlay-next:hover,
    	.widget.border1, 
    	.widget.border2,
    	.gk-testimonials-prev:active,
    	.gk-testimonials-prev:focus,
    	.gk-testimonials-prev:hover,
    	.gk-testimonials-next:active,
    	.gk-testimonials-next:focus,
    	.gk-testimonials-next:hover {
    	  border-color: <?php echo $primary_color; ?>;
    	}
    	.widget.border1 .header,
    	.widget.border1 .widget-title, .widget.border2 .header,
    	.widget.border2 .widget-title {
    	  border-bottom-color: <?php echo $primary_color; ?>;
    	  color: <?php echo $primary_color; ?>;
    	}
    	.gk-nsp-header a:active, 
    	.gk-nsp-header a:focus, 
    	.gk-nsp-header a:hover,
    	.gk-nsp-news_grid figcaption a:active,
    	.gk-nsp-news_grid figcaption a:focus,
    	.gk-nsp-news_grid figcaption a:hover {
    	  color: <?php echo $primary_color; ?>!important;
    	}
    	.none .gk-tabs-wrap > ol li:hover, 
    	.none .gk-tabs-wrap > ol li.active, 
    	.none .gk-tabs-wrap > ol li.active:hover {
    	  border-color: <?php echo $primary_color; ?>!important;
    	  color: <?php echo $primary_color; ?>;
    	}
    	.gk-contact-form input,
    	.gk-contact-form textarea {
    	  border-color: <?php echo $primary_color; ?>;
    	}
    	.gk-contact-form .button-border,
    	.gk-reservation-party-info .button-border {
    	  border-color: <?php echo $primary_color; ?>;
    	  color: <?php echo $primary_color; ?>!important;
    	}
    	.kalendae .k-today {
    	  background: <?php echo $primary_color; ?>!important;
    	}
    	.frontpage-block.map:before,
    	.widget-wrap.map:before {
    	  background: <?php echo Steakhouse_Color_Utils::color_rgba($primary_color, 0.8); ?>;
    	}
    </style>
    <?php
}

add_action( 'wp_head', 'steakhouse_customizer_css' );

function steakhouse_customize_register($wp_customize) {
	if ( $wp_customize->is_preview() && ! is_admin() ) {
		add_action( 'wp_footer', 'steakhouse_customize_preview', 21);
    }
}

add_action( 'customize_register', 'steakhouse_customize_register' );

function steakhouse_customize_preview() {
    ?>
    <script>
    (function($){
    	// helper color change function
    	function color_change(color, diff_r, diff_g, diff_b) {
    		// validate the string
    		color = String(color).replace(/[^0-9a-f]/gi, '');
    		if (color.length < 6) {
    			return color;
    		}
    		// convert to decimal
    		var rgb = "#";
    		var subcolor;
    		var diff = [diff_r, diff_g, diff_b];

    		for (var i = 0; i < 3; i++) {
    			subcolor = parseInt(color.substr(i*2,2), 16);
    			subcolor = (subcolor - diff[i]).toString(16);
    			rgb += ("00"+subcolor).substr(subcolor.length);
    		}

    		return rgb;
    	}
    	// helper rgba converter
    	function color_rgba(color, alpha) {
    		// validate the string
			color = String(color).replace(/[^0-9a-f]/gi, '');
			if (color.length < 6) {
				return color;
			}
			// convert to decimal
			var rgb = [];
			var subcolor;

			for (var i = 0; i < 3; i++) {
				subcolor = parseInt(color.substr(i*2,2), 16);
				rgb[i] = subcolor;
			}

			return 'rgba('+rgb[0]+','+rgb[1]+','+rgb[2]+','+alpha+')';
    	}
    	// AJAX support for the color changes
    	// The CSS code can be compressed with this tool: http://refresh-sf.com/yui/
    	wp.customize('steakhouse_primary_color', function(value) {
    	    value.bind( function( to ) {
    	    	to = to ? to : '#d27244';
    	    	// set colors:
    	    	var new_css = 'a, a.inverse:active, a.inverse:focus, a.inverse:hover, .nav-menu > li > a:active, .nav-menu > li > a:focus, .nav-menu > li > a:hover, .nav-menu > li.current_page_item > a, .nav-menu > li.current_page_item > a:active, .nav-menu > li.current_page_item > a:focus, .nav-menu > li.current_page_item > a:hover, #aside-menu li a:active, #aside-menu li a:focus, #aside-menu li a:hover, #aside-menu li.current_page_item a, blockquote:before, blockquote p:after, .gk-menu-container dd strong, .bigtitle .header > a:active, .bigtitle .header > a:focus, .bigtitle .header > a:hover, .bigtitle .widget-title > a:active, .bigtitle .widget-title > a:focus, .bigtitle .widget-title > a:hover, .widget.color1 a, .gk-nsp-next:hover:after, .gk-nsp-prev:hover:after, .gk-nsp-art .gk-nsp-star-1:before, #gk-footer-nav a:active, #gk-footer-nav a:focus, #gk-footer-nav a:hover, .big-icon a:active, .big-icon a:focus, .big-icon a:hover, .gk-menu .gk-cols dd strong, #close-menu { color: '+to+'; } button, .button, .readon, .button-border, input[type="submit"], input[type="button"], input[type="reset"], .nav-menu > li .sub-menu, .nav-menu ul > li .children, .paging-navigation a, .widget.color2, .gk-nsp-news_grid > a, .gk-nsp-arts-nav ul li.active, .gk-nsp-links-nav ul li.active, .gk-special-link:active, .gk-special-link:focus, .gk-special-link:hover, .gk-testimonials-pagination li.active { background: '+to+'; } .button-border { border-color: '+to+'; color: '+to+'!important; } .nav-menu > li.menu-item-has-children a:before, .nav-menu ul > li.menu-item-has-children a:before { border-color: '+to+'; border-left-color: #fff; border-right-color: #fff; } .gk-photo-overlay-prev:active, .gk-photo-overlay-prev:focus, .gk-photo-overlay-prev:hover, .gk-photo-overlay-next:active, .gk-photo-overlay-next:focus, .gk-photo-overlay-next:hover, .widget.border1, .widget.border2, .gk-testimonials-prev:active, .gk-testimonials-prev:focus, .gk-testimonials-prev:hover, .gk-testimonials-next:active, .gk-testimonials-next:focus, .gk-testimonials-next:hover { border-color: '+to+'; } .widget.border1 .header, .widget.border1 .widget-title, .widget.border2 .header, .widget.border2 .widget-title { border-bottom-color: '+to+'; color: '+to+'; } .gk-nsp-header a:active, .gk-nsp-header a:focus, .gk-nsp-header a:hover, .gk-nsp-news_grid figcaption a:active, .gk-nsp-news_grid figcaption a:focus, .gk-nsp-news_grid figcaption a:hover { color: '+to+'!important; } .none .gk-tabs-wrap > ol li:hover, .none .gk-tabs-wrap > ol li.active, .none .gk-tabs-wrap > ol li.active:hover { border-color: '+to+'!important; color: '+to+'; } .gk-contact-form input, .gk-contact-form textarea { border-color: '+to+'; } .gk-contact-form .button-border, .gk-reservation-party-info .button-border { border-color: '+to+'; color: '+to+'!important; } .kalendae .k-today { background: '+to+'!important; } .frontpage-block.map:before, .widget-wrap.map:before { background: '+color_rgba(to, 0.8)+'; }';

    	    	if($(document).find('#steakhouse-new-css-1').length) {
    	    		$(document).find('#steakhouse-new-css-1').remove();
    	    	}

    	    	$(document).find('head').append($('<style id="steakhouse-new-css-1">' + new_css + '</style>'));
    	    });
    	});
    })(jQuery);
    </script>
    <?php
}

// EOF
