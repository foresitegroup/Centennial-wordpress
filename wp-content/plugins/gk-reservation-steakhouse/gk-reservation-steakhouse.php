<?php 

/*
Plugin Name:    GK Reservation Steakhouse
Plugin URI:     
Description:    Simple plugin for adding simple reservation form in the Steakhouse theme
Version:        1.0.0
Author:         GavickPro
Author URI:     http://www.gavick.com
 
Text Domain:   gk-reservation-steakhouse
Domain Path:   /languages/
*/ 

global $pagenow;

if(!function_exists('_recaptcha_qsencode')) {
      include_once('recaptchalib.php');
}

/**
 * i18n - language files should be like gk-reservation-en_GB.po and gk-reservation-en_GB.mo
 */
add_action( 'plugins_loaded', 'gk_reservation_steakhouse_load_textdomain' );

function gk_reservation_steakhouse_load_textdomain() {
  load_plugin_textdomain('gk-reservation-steakhouse', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'); 
}

// Actions
add_action('steakhouse_plugin_messages', array('GK_Reservation_Steakhouse', 'action'));
add_action('admin_menu', array('GK_Reservation_Steakhouse', 'admin_menu'));
// Shortcodes
add_shortcode('GK_Reservation', array('GK_Reservation_Steakhouse', 'shortcode'));

// Class with all plugin functionality
class GK_Reservation_Steakhouse { 
    	// Code used to create a shortcode
    	static function shortcode($atts) {
        // Get the shortcode params
	      $atts = shortcode_atts(array(
        	     	'fields' => 'date,time,size,email,name,phone,special',
                'recaptcha' => 'off',
                'info' => '',
        	     	'email' => '',
                'email_title' => __('Reservation Form', 'gk-reservation-steakhouse')
       	), $atts);

       	// Check if there is a field to render
       	if($atts['fields'] !== '') {
       		$output = '<form class="gk-reservation-form" method="post">';
       		$fields = explode(',', $atts['fields']);

       		if(in_array('date', $fields) || in_array('time', $fields) || in_array('size', $fields)) {
       			$output .= '<div class="gk-reservation-party-details">';
       		}

           		if(in_array('date', $fields)) {
           			$date_value = '';

           			if(isset($_POST['gk-reservation-date'])) {
           				$date_value = esc_attr($_POST['gk-reservation-date']);
           			}

           			$output .= '<div class="gk-reservation-date"><input type="text" name="gk-reservation-date" class="auto-kal gk-required" placeholder="'.__('Date', 'gk-reservation-steakhouse').'" value="'.$date_value.'" /></div>';
           		}

           		if(in_array('time', $fields)) {
           			$time_value = '';

           			if(isset($_POST['gk-reservation-time'])) {
           				$time_value = esc_attr($_POST['gk-reservation-name']);
           			}

           			$output .= '<div class="gk-reservation-time"><input type="text" name="gk-reservation-time" class="gk-required" placeholder="'.__('Time', 'gk-reservation-steakhouse').'" value="'.$time_value.'" /></div>';
           		}

           		if(in_array('size', $fields)) {
           			$size_value = '';

           			if(isset($_POST['gk-reservation-size'])) {
           				$size_value = esc_attr($_POST['gk-reservation-size']);
           			}

           			$output .= '<input type="text" name="gk-reservation-subject" class="gk-required" placeholder="'.__('Party Size*', 'gk-reservation-steakhouse').'" value="'.$size_value.'" />';
           		}

       		if(in_array('date', $fields) || in_array('time', $fields) || in_array('size', $fields)) {
       			$output .= '</div>';
       		}
       		
          if(in_array('name', $fields) || in_array('email', $fields) || in_array('phone', $fields) || in_array('special', $fields)) {
       		  $output .= '<div class="gk-reservation-party-info">';
          }
       		
              if(in_array('name', $fields)) {
                $name_value = '';

                if(isset($_POST['gk-reservation-name'])) {
                  $name_value = esc_attr($_POST['gk-reservation-name']);
                }

                $output .= '<input type="text" name="gk-reservation-name" class="gk-required" placeholder="'.__('Name', 'gk-reservation-steakhouse').'" value="'.$name_value.'" />';
              }

              if(in_array('email', $fields)) {
                $email_value = '';

                if(isset($_POST['gk-reservation-email'])) {
                  $email_value = esc_attr($_POST['gk-reservation-email']);
                }

                $output .= '<input type="email" name="gk-reservation-email" class="gk-required" placeholder="'.__('E-mail', 'gk-reservation-steakhouse').'" value="'.$email_value.'" />';
              }

              if(in_array('phone', $fields)) {
                $phone_value = '';

                if(isset($_POST['gk-reservation-phone'])) {
                  $phone_value = esc_attr($_POST['gk-reservation-phone']);
                }

                $output .= '<input type="text" name="gk-reservation-phone" class="gk-required" placeholder="'.__('Phone', 'gk-reservation-steakhouse').'" value="'.$phone_value.'" />';
              }

              if(in_array('special', $fields)) {
                $output .= '<textarea name="gk-reservation-special" placeholder="'.__('Special instructions', 'gk-reservation-steakhouse').'">';

             		if(isset($_POST['gk-reservation-special'])) {
             			$output .= esc_html(esc_textarea($_POST['gk-reservation-special']));
             		}

             		$output .= '</textarea>';
              }

              if($atts['info'] != '') {
                $output .= '<small>' . $atts['info'] . '</small>';
              }

              if(
                    $atts['recaptcha'] == 'on' &&
                    get_option('gk_reservation_steakhouse_recaptcha_public_key', '') != '' &&
                    get_option('gk_reservation_steakhouse_recaptcha_private_key', '') != ''
              ) {
                    $publickey = get_option('gk_reservation_steakhouse_recaptcha_public_key', '');
                    $output .= recaptcha_get_html($publickey);
              }

              $output .= '<input type="submit" class="gk-submit button button-border" value="'.__('Make reservation', 'gk-reservation-steakhouse').'" />';

              if($atts['email'] !== '') {
                    $output .= '<input type="hidden" name="gk-reservation-to" value="'.base64_encode($atts['email']).'" />';
              }

              $output .= '<input type="hidden" name="gk-reservation-title" value="'.$atts['email_title'].'" />';

          if(in_array('name', $fields) || in_array('email', $fields) || in_array('phone', $fields) || in_array('special', $fields)) {
       		  $output .= '</div>';
          }

       		$output .= '</form>';

       		return $output;
       	}
       	// Return empty string when there is no fields to render
       	return '';
	    }
      // Code used to validate and send the message from the form
      static function action() {
            if(!isset($_POST['gk-reservation-title'])) {
                  return false;   
            }

            // flag used to detect if the page is validated
            $validated = true;

            // flag to detect if e-mail was sent
            $message_sent = false;

            // variable for the input fields output
            $output = array(
                  "date" => '',
                  "time" => '',
                  "size" => '',
                  "name" => '',
                  "email" => '',
                  "phone" => '',
                  "special" => ''
            );

            // check the fields
            $fields = array('date', 'time', 'size', 'name', 'email', 'phone', 'special');
            $fields_len = count($fields);

            for($i = 0; $i < $fields_len; $i++) {
              if(isset($_POST['gk-reservation-' . $fields[$i]])) {
                if(trim($_POST['gk-reservation-' . $fields[$i]]) === '') {
                  $validated = false;
                } else {
                  $output[$fields[$i]] = esc_attr(esc_html($_POST['gk-reservation-' . $fields[$i]]));
                }
              }
            }
        
            // reCAPTCHA validation
            if(
                  isset($_POST["recaptcha_challenge_field"]) &&
                  get_option('gk_reservation_steakhouse_recaptcha_public_key', '') != '' &&
                  get_option('gk_reservation_steakhouse_recaptcha_private_key', '') != ''
            ) {
                  $privatekey = get_option('gk_reservation_steakhouse_recaptcha_private_key', '');
                  $resp = recaptcha_check_answer ($privatekey,
                                                  $_SERVER["REMOTE_ADDR"],
                                                  $_POST["recaptcha_challenge_field"],
                                                  $_POST["recaptcha_response_field"]);
                  
                  if (!$resp->is_valid) {
                        // What happens when the CAPTCHA was entered incorrectly
                        $validated = false;
                  }
            }

            // if the all fields was correct
            if($validated) {
                  // send an e-mail
                  $email = '';

                  if(isset($_POST['gk-reservation-to'])) {
                        $email = base64_decode($_POST['gk-reservation-to']);
                  }
                  // if the user specified blank e-mail or not specified it
                  if(trim($email) == '') {
                        $email = get_option('admin_email');
                  }
                  // e-mail structure
                  $subject = esc_attr(esc_html($_POST['gk-reservation-title']));
                  
                  $body = "<html>";
                  $body .= "<body>";
                  $body .= "<h1 style=\"font-size: 24px; border-bottom: 4px solid #EEE; margin: 10px 0; padding: 10px 0; font-weight: normal; font-style: italic;\">".$subject."</strong></h1>";
                  
                  if($output['date'] !== '' || $output['time'] !== '' || $output['size'] !== '') {
                        $body .= "<div>";
                        $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('Party details:', 'gk-reservation-steakhouse')."</h2>";
                        $body .= "<p>";
                        if($output['date'] !== '') {
                           $body .= $output['date'];
                        }
                        $body .= ' ';
                        if($output['time'] !== '') {
                           $body .= $output['time'];
                        }
                        $body .= ' ';
                        if($output['size'] !== '') {
                           $body .= __('Party size: ', 'gk-reservation-steakhouse') . $output['size'];
                        }
                        $body .= "</p>";
                        $body .= "</div>";
                  }

                  if($output['name'] !== '') {
                        $body .= "<div>";
                        $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('Name: ', 'gk-reservation-steakhouse')."</h2>";
                        $body .= "<p>".$output['name']."</p>";
                        $body .= "</div>";
                  }
                  
                  if($output['email'] !== '') {
                        $body .= "<div>";
                        $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('E-mail: ', 'gk-reservation-steakhouse')."</h2>";
                        $body .= "<p>".$output['email']."</p>";
                        $body .= "</div>";
                  }

                  if($output['phone'] !== '') {
                        $body .= "<div>";
                        $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('Phone: ', 'gk-reservation-steakhouse')."</h2>";
                        $body .= "<p>".$output['phone']."</p>";
                        $body .= "</div>";
                  }
                  
                  if($output['special'] !== '') {
                        $body .= "<div>";
                        $body .= "<h2 style=\"font-size: 16px; font-weight: normal; border-bottom: 1px solid #EEE; padding: 5px 0; margin: 10px 0;\">".__('Special instructions:', 'gk-reservation-steakhouse')."</h2>";
                        $body .= $output['special'];
                        $body .= "</div>";
                  }

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
                  unset($_POST['gk-reservation-date']);
                  unset($_POST['gk-reservation-time']);
                  unset($_POST['gk-reservation-size']);
                  unset($_POST['gk-reservation-name']);
                  unset($_POST['gk-reservation-email']);
                  unset($_POST['gk-reservation-phone']);
                  unset($_POST['gk-reservation-special']);

                  echo '<div class="gk-reservation-success">'.__('Your reservation has been sucessfully sent.', 'gk-reservation-steakhouse').'</div>';
            } else {
                  if($errors['recaptcha'] != '') {
                        echo '<div class="gk-reservation-error">'.__("The reCAPTCHA wasn't entered correctly. Go back and try it again.", 'gk-reservation-steakhouse').'</div>';
                  } else {
                        echo '<div class="gk-reservation-error">'.__('Please check the fields in the reservation form before sending.', 'gk-reservation-steakhouse').'</div>';
                  }
            }
      }
      // Function used for adding custom settings page for the plugin
      static function admin_menu() {
            //create new top-level menu
            add_plugins_page('GK Reservation Steakhouse', 'GK Reservation Steakhouse', 'administrator', __FILE__, array('GK_Reservation_Steakhouse', 'settings_page'));
            //call register settings function
            add_action('admin_init', array('GK_Reservation_Steakhouse', 'register_settings'));
      }
      // Function used to specify the basic settings of the plugin
      static function register_settings() {
            //register our settings
            register_setting('gk-reservation-steakhouse-config', 'gk_reservation_steakhouse_recaptcha_public_key');
            register_setting('gk-reservation-steakhouse-config', 'gk_reservation_steakhouse_recaptcha_private_key');
      }
      // Code used to generate the settings page
      static function settings_page() {
      ?>
            <div class="wrap">
            <h2><?php _e('GK Reservation Steakhouse Plugin Settings', 'gk-reservation-steakhouse'); ?></h2>

            <form method="post" action="options.php">
                <?php settings_fields('gk-reservation-steakhouse-config'); ?>
                <?php do_settings_sections('gk-reservation-steakhouse-config'); ?>

                <table class="form-table">
                    <tr valign="top">
                    <th scope="row"><?php _e('reCAPTCHA public key', 'gk-reservation-steakhouse'); ?></th>
                    <td><input type="text" name="gk_reservation_steakhouse_recaptcha_public_key" value="<?php echo esc_attr(get_option('gk_reservation_steakhouse_recaptcha_public_key')); ?>" /></td>
                    </tr>
                     
                    <tr valign="top">
                    <th scope="row"><?php _e('reCAPTCHA private key', 'gk-reservation-steakhouse'); ?></th>
                    <td><input type="text" name="gk_reservation_steakhouse_recaptcha_private_key" value="<?php echo esc_attr(get_option('gk_reservation_steakhouse_recaptcha_private_key')); ?>" /></td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
            </div>
      <?php 
      }
}

// EOF