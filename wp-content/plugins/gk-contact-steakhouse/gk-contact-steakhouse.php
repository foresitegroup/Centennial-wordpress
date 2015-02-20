<?php 

/*
Plugin Name:    GK Contact Steakhouse
Plugin URI:     
Description:    Simple plugin for adding simple contact form in the Steakhouse theme
Version:        100.0.0
Author:         GavickPro
Author URI:     http://www.gavick.com
 
Text Domain:   gk-contact-steakhouse
Domain Path:   /languages/
*/ 

global $pagenow;

if(!function_exists('_recaptcha_qsencode')) {
      include_once('recaptchalib.php');
}

/**
 * i18n - language files should be like gk-contact-en_GB.po and gk-contact-en_GB.mo
 */
add_action( 'plugins_loaded', 'gk_contact_steakhouse_load_textdomain' );

function gk_contact_steakhouse_load_textdomain() {
  load_plugin_textdomain('gk-contact-steakhouse', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'); 
}

// Actions
add_action('steakhouse_plugin_messages', array('GK_Contact_Steakhouse', 'action'));
add_action('admin_menu', array('GK_Contact_Steakhouse', 'admin_menu'));
// Shortcodes
add_shortcode('GK_Contact', array('GK_Contact_Steakhouse', 'shortcode'));

// Class with all plugin functionality
class GK_Contact_Steakhouse { 
    	// Code used to create a shortcode
    	static function shortcode($atts) {
        // Get the shortcode params
	      $atts = shortcode_atts(array(
        	     	'fields' => 'email,name,subject',
                'recaptcha' => 'off',
                'fg_captcha' => 'off',
        	     	'email' => '',
                'email_title' => __('Contact Form', 'gk-contact-steakhouse')
       	), $atts);

       	// Check if there is a field to render
       	if($atts['fields'] !== '') {
       		$output = '<form class="gk-contact-form" method="post">';
       		$fields = explode(',', $atts['fields']);

       		if(in_array('email', $fields) || in_array('name', $fields) || in_array('subject', $fields)) {
       			$output .= '<p class="gk-contact-fields">';
       		}

       		if(in_array('email', $fields)) {
       			$email_value = '';

       			if(isset($_POST['gk-contact-email'])) {
       				$email_value = esc_attr($_POST['gk-contact-email']);
       			}

       			$output .= '<input type="email" name="gk-contact-email" class="gk-required" placeholder="'.__('E-mail', 'gk-contact-steakhouse').'" value="'.$email_value.'" />';
       		}

       		if(in_array('name', $fields)) {
       			$name_value = '';

       			if(isset($_POST['gk-contact-name'])) {
       				$name_value = esc_attr($_POST['gk-contact-name']);
       			}

       			$output .= '<input type="text" name="gk-contact-name" class="gk-required" placeholder="'.__('Name', 'gk-contact-steakhouse').'" value="'.$name_value.'" />';
       		}

       		if(in_array('subject', $fields)) {
       			$subject_value = '';

       			if(isset($_POST['gk-contact-subject'])) {
       				$subject_value = esc_attr($_POST['gk-contact-subject']);
       			}

       			$output .= '<input type="text" name="gk-contact-subject" class="gk-required" placeholder="'.__('Subject', 'gk-contact-steakhouse').'" value="'.$subject_value.'" />';
       		}

          if($atts['fg_captcha'] == 'on') {
            $firstnum = rand(1, 15);
            $secondnum = rand(1, 15);
            $captchastr = $firstnum . ' + ' . $secondnum . ' =';
            $captchaans = $firstnum + $secondnum;

            if(isset($_POST['gk-contact-fg_captcha'])) {
              $fg_captcha_value = esc_attr($_POST['gk-contact-fg_captcha']);
            }

            $output .= '<input type="text" name="gk-contact-fg_captcha" class="gk-required" placeholder="'.__($captchastr, 'gk-contact-steakhouse').'" value="'.$fg_captcha_value.'" />';
          }

       		if(in_array('email', $fields) || in_array('name', $fields) || in_array('subject', $fields)) {
       			$output .= '</p>';
       		}
       		
       		$output .= '<p class="gk-contact-textarea">';
       		$output .= '<textarea name="gk-contact-message" class="gk-required" placeholder="'.__('Your message', 'gk-contact-steakhouse').'">';

       		if(isset($_POST['gk-contact-message'])) {
       			$output .= esc_html(esc_textarea($_POST['gk-contact-message']));
       		}

       		$output .= '</textarea>';

                  if(
                        $atts['recaptcha'] == 'on' &&
                        get_option('gk_contact_steakhouse_recaptcha_public_key', '') != '' &&
                        get_option('gk_contact_steakhouse_recaptcha_private_key', '') != ''
                  ) {
                        $publickey = get_option('gk_contact_steakhouse_recaptcha_public_key', '');
                        $output .= recaptcha_get_html($publickey);
                  }

                  if ($atts['fg_captcha'] == 'on') $output .= '<input type="hidden" name="gk-contact-fg_captcha_ans" value="'.$captchaans.'" />';

                  $output .= '<input type="submit" class="gk-submit button button-border" value="'.__('Send a message', 'gk-contact-steakhouse').'" />';

                  if($atts['email'] !== '') {
                        $output .= '<input type="hidden" name="gk-contact-to" value="'.base64_encode($atts['email']).'" />';
                  }

                  $output .= '<input type="hidden" name="gk-contact-title" value="'.$atts['email_title'].'" />';
       		$output .= '</p>';
       		$output .= '</form>';

       		return $output;
       	}
       	// Return empty string when there is no fields to render
       	return '';
	    }
      // Code used to validate and send the message from the form
      static function action() {
            if(!isset($_POST['gk-contact-message'])) {
                  return false;   
            }

            // flag used to detect if the page is validated
            $validated = true;

            // flag to detect if e-mail was sent
            $message_sent = false;

            // variable to store the errors, empty string means no error 
            $errors = array(
                  "name" => '',
                  "email" => '',
                  "subject" => '',
                  "captcha" => '',
                  "message" => '',
                  "recaptcha" => ''
            );

            // variable for the input fields output
            $output = array(
                  "name" => '',
                  "email" => '',
                  "subject" => '',
                  "message" => ''
            );

            // check the name
            if(isset($_POST['gk-contact-name'])) {
                  if(trim($_POST['gk-contact-name']) === '') {
                        $validated = false;
                        $errors['name'] = __('Please enter your name', 'gk-contact-steakhouse');
                  } else {
                        $output['name'] = esc_attr(esc_html($_POST['gk-contact-name']));
                  }
            }
            // check the e-mail
            if(isset($_POST['gk-contact-email'])) {
                  if(trim($_POST['gk-contact-email']) === '') {
                        $validated = false;
                        $errors['email'] = __('Please enter email address.', 'gk-contact-steakhouse');
                  } else {
                        $output['email'] = esc_attr(esc_html($_POST['gk-contact-email']));
                  }
            }
            // check the subject
            if(isset($_POST['gk-contact-subject'])) {
                  if(trim($_POST['gk-contact-subject']) === '') {
                        $validated = false;
                        $errors['subject'] = __('Please enter the subject', 'gk-contact-steakhouse');
                  } else {
                        $output['subject'] = esc_attr(esc_html($_POST['gk-contact-subject']));
                  }
            }
            // check the captcha
            if(isset($_POST['gk-contact-fg_captcha'])) {
                  if(trim($_POST['gk-contact-fg_captcha']) === '') {
                        $validated = false;
                        $errors['captcha'] = __('Please enter the CAPTCHA', 'gk-contact-steakhouse');
                  } else {
                        if(trim($_POST['gk-contact-fg_captcha']) != trim($_POST['gk-contact-fg_captcha_ans'])) {
                          $validated = false;
                          $errors['captcha'] = __("The CAPTCHA wasn't entered correctly. Go back and try it again.", 'gk-contact-steakhouse');
                        }
                  }
            }
            // check the message content
            if(trim($_POST['gk-contact-message']) === '') {
                  $validated = false;
                  $errors['message'] = __('Please enter a text of the message.', 'gk-contact-steakhouse');
            } else {
                  $output['message'] = esc_textarea($_POST['gk-contact-message']);
            }
            // reCAPTCHA validation
            if(
                  isset($_POST["recaptcha_challenge_field"]) &&
                  get_option('gk_contact_steakhouse_recaptcha_public_key', '') != '' &&
                  get_option('gk_contact_steakhouse_recaptcha_private_key', '') != ''
            ) {
                  $privatekey = get_option('gk_contact_steakhouse_recaptcha_private_key', '');
                  $resp = recaptcha_check_answer ($privatekey,
                                              $_SERVER["REMOTE_ADDR"],
                                              $_POST["recaptcha_challenge_field"],
                                              $_POST["recaptcha_response_field"]);
                  
                  if (!$resp->is_valid) {
                        // What happens when the CAPTCHA was entered incorrectly
                        $validated = false;
                        $errors['recaptcha'] = __("The reCAPTCHA wasn't entered correctly. Go back and try it again.", 'gk-contact-steakhouse');
                  }
            }

            // if the all fields was correct
            if($validated) {
                  // send an e-mail
                  $email = '';

                  if(isset($_POST['gk-contact-to'])) {
                        $email = base64_decode($_POST['gk-contact-to']);
                  }
                  // if the user specified blank e-mail or not specified it
                  if(trim($email) == '') {
                        $email = get_option('admin_email');
                  }
                  // e-mail structure
                  $subject = esc_attr(esc_html($_POST['gk-contact-title']));
                  
                  $body = "<html>";
                  $body .= "<body>";
                  $body .= "<h1 style=\"font-size: 24px; border-bottom: 4px solid #EEE; margin: 10px 0; padding: 10px 0; font-weight: normal; font-style: italic;\">".$subject."</strong></h1>";
                  
                  if($output['subject'] !== '') {
                        $body .= "<div>";
                        $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('Subject:', 'gk-contact-steakhouse')."</h2>";
                        $body .= "<p>".$output['subject']."</p>";
                        $body .= "</div>";
                  }

                  if($output['name'] !== '') {
                        $body .= "<div>";
                        $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('Name:', 'gk-contact-steakhouse')."</h2>";
                        $body .= "<p>".$output['name']."</p>";
                        $body .= "</div>";
                  }
                  
                  if($output['email'] !== '') {
                        $body .= "<div>";
                        $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('E-mail:', 'gk-contact-steakhouse')."</h2>";
                        $body .= "<p>".$output['email']."</p>";
                        $body .= "</div>";
                  }
                  
                  $body .= "<div>";
                  $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('Message:', 'gk-contact-steakhouse')."</h2>";
                  $body .= $output['message'];
                  $body .= "</div>";
                  $body .= "</body>";
                  $body .= "</html>";
                  
                  if($output['name'] !== '' && $output['email'] !== '') {
                        $headers[] = 'From: '.$output['name'].' <'.$output['email'].'>';
                        $headers[] = 'Reply-To: ' . $output['email'];
                        $headers[] = 'Content-type: text/html';
                  } else if($output['name'] !== '' && $output['email'] === '') {
                        $headers[] = 'From: '.$output['name'];
                        $headers[] = 'Content-type: text/html';
                  } else if($output['name'] === '' && $output['email'] !== '') {
                        $headers[] = 'From: '.$output['email'].' <'.$output['email'].'>';
                        $headers[] = 'Reply-To: ' . $output['email'];
                        $headers[] = 'Content-type: text/html';
                  } else {
                        $headers[] = 'Content-type: text/html';
                  }

                  wp_mail($email, $subject, $body, $headers);
                  
                  $message_sent = true;
            }

            if($message_sent) {
                  unset($_POST['gk-contact-name']);
                  unset($_POST['gk-contact-email']);
                  unset($_POST['gk-contact-subject']);
                  unset($_POST['gk-contact-fg_captcha']);
                  unset($_POST['gk-contact-message']);

                  echo '<div class="gk-contact-success">'.__('Your message has been sucessfully sent.', 'gk-contact-steakhouse').'</div>';
            } else {
                  if($errors['recaptcha'] != '') {
                        echo '<div class="gk-contact-error">'.$errors['recaptcha'].'</div>';
                  } else {
                        echo '<div class="gk-contact-error">'.__('Please check the fields in the contact form before sending.', 'gk-contact-steakhouse').'</div>';
                  }
            }
      }
      // Function used for adding custom settings page for the plugin
      static function admin_menu() {
            //create new top-level menu
            add_plugins_page('GK Contact Steakhouse', 'GK Contact Steakhouse', 'administrator', __FILE__, array('GK_Contact_Steakhouse', 'settings_page'));
            //call register settings function
            add_action('admin_init', array('GK_Contact_Steakhouse', 'register_settings'));
      }
      // Function used to specify the basic settings of the plugin
      static function register_settings() {
            //register our settings
            register_setting('gk-contact-steakhouse-config', 'gk_contact_steakhouse_recaptcha_public_key');
            register_setting('gk-contact-steakhouse-config', 'gk_contact_steakhouse_recaptcha_private_key');
      }
      // Code used to generate the settings page
      static function settings_page() {
      ?>
            <div class="wrap">
            <h2><?php _e('GK Contact Steakhouse Plugin Settings', 'gk-contact-steakhouse'); ?></h2>

            <form method="post" action="options.php">
                <?php settings_fields('gk-contact-steakhouse-config'); ?>
                <?php do_settings_sections('gk-contact-steakhouse-config'); ?>

                <table class="form-table">
                    <tr valign="top">
                    <th scope="row"><?php _e('reCAPTCHA public key', 'gk-contact-steakhouse'); ?></th>
                    <td><input type="text" name="gk_contact_steakhouse_recaptcha_public_key" value="<?php echo esc_attr(get_option('gk_contact_steakhouse_recaptcha_public_key')); ?>" /></td>
                    </tr>
                     
                    <tr valign="top">
                    <th scope="row"><?php _e('reCAPTCHA private key', 'gk-contact-steakhouse'); ?></th>
                    <td><input type="text" name="gk_contact_steakhouse_recaptcha_private_key" value="<?php echo esc_attr(get_option('gk_contact_steakhouse_recaptcha_private_key')); ?>" /></td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
            </div>
      <?php 
      }
}

// EOF