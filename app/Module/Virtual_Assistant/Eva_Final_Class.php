<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'EXLAC_VA_URL' ) or define('EXLAC_VA_URL', plugins_url( '/', __FILE__ ));
defined( 'EXLAC_VA_PATH' ) or define('EXLAC_VA_PATH', basename( dirname( __FILE__ )));
defined( 'EXLAC_VA_FULLPATH' ) or define('EXLAC_VA_FULLPATH', plugins_url( '/', __FILE__ ));
defined( 'EXLAC_VA_TEXTDOMAIN' ) or define('EXLAC_VA_TEXTDOMAIN', plugins_url( '/', __FILE__ ));

defined( 'EXLAC_VA_VERSION' ) or define('EXLAC_VA_VERSION', '2.3.3');
defined( 'EXLAC_VA_CATEGORY' ) or define('EXLAC_VA_CATEGORY', 'Virtual Assistant');
defined( 'EXLAC_VA_PREFIX' ) or define('EXLAC_VA_PREFIX', 'virtual_assistant_');

// POSTTYPES
defined( 'EXLAC_VA_POSTTYPE' ) or define('EXLAC_VA_POSTTYPE', 'virtual_assistant');

// PAGE SLUG
defined( 'EXLAC_VA_SLUG' ) or define('EXLAC_VA_SLUG', 'virtual_assistant');
defined( 'EXLAC_VA_SLUG_SETTINGS' ) or define('EXLAC_VA_SLUG_SETTINGS', 'virtual_assistant_settings');
defined( 'EXLAC_VA_ALL_VIRTUAL_ASSISTANT_SLUG' ) or define('EXLAC_VA_ALL_VIRTUAL_ASSISTANT_SLUG', 'all_commands');
defined( 'EXLAC_VA_ADD_VIRTUAL_ASSISTANT_SLUG' ) or define('EXLAC_VA_ADD_VIRTUAL_ASSISTANT_SLUG', 'add_command');

// SHORTCODES
defined( 'EXLAC_VA_SHORTCODE' ) or define('EXLAC_VA_SHORTCODE', 'virtual_assistant');

// AJAX
defined( 'EXLAC_VA_SAVE_SETTINS' ) or define('EXLAC_VA_SAVE_SETTINS', 'virtual_assistant_save_settings');
defined( 'EXLAC_VA_AJAX_EXCHANGE_RATES' ) or define('EXLAC_VA_AJAX_EXCHANGE_RATES', 'virtual_assistant_exchange_rates');


if ( ! class_exists( 'EXLAC_VA_CLASS' ) ) {
	/**
	 * EXLAC_VA_CLASS Class
	 *
	 * @since	1.0
	 */
	class EXLAC_VA_CLASS {
		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Load core
			if(!class_exists('Exlac_Core_Class')) {
				include_once 'bestbugcore/index.php';
			}
			//Exlac_Core_Class::support('vc-params');
			Exlac_Core_Class::support('options');
			Exlac_Core_Class::support('posttypes');

			include_once 'includes/index.php';
			
			if(is_admin()) {
				include_once 'includes/admin/index.php';
			}
			
            add_action( 'init', array( $this, 'init' ) );
			
			// Editor
			// add_filter("mce_external_plugins", array( $this, "enqueue_plugin_scripts"));
			// add_filter("mce_buttons", array( $this, "register_buttons_editor"));
			
			// add_action( 'wp_footer', array( $this, 'virtual_assistant') );
		}

		public function init() {
			
			// Load enqueueScripts
			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
				if(bb_option(EXLAC_VA_PREFIX . 'use_in_backend') == 'yes') {
					add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );
				}
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }
		
		public function adminEnqueueScripts() {

			// e_var_dump($this->get_response_from_openai('are you?'));
			// die;

			Exlac_Core_Class::adminEnqueueScripts();
			wp_enqueue_script( 'sweetalert', EXLAC_CORE_URL . '/assets/admin/js/sweetalert.min.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'virtual-assistant-admin', EXLAC_VA_URL . '/assets/admin/js/script.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'checked-js', EXLAC_VA_URL . 'assets/admin/js/removeChecked.js' );
			wp_enqueue_style( 'font-awesome', EXLAC_VA_URL . '/assets/libr/font-awesome/css/font-awesome.min.css' );
			wp_enqueue_style( 'style', EXLAC_VA_URL . '/assets/css/style.css' );
		}

		public function enqueueScripts() {
			Exlac_Core_Class::enqueueScripts();
			wp_enqueue_style( 'virtual-assistant', EXLAC_VA_URL . '/assets/css/style.css', array(), EXLAC_VA_VERSION );
			// wp_enqueue_style( 'virtual-assistant-kitt-flat', EXLAC_VA_URL . '/assets/css/flat.css' );
			
			wp_enqueue_script( 'responsivevoice', '//code.responsivevoice.org/responsivevoice.js?key=ZtJFiuqV', array( 'jquery' ), null, true );
			
			wp_enqueue_script( 'annyang', EXLAC_VA_URL . '/assets/js/annyang.min.js', array( 'jquery' ), '2.6.0', true );
			// wp_enqueue_script( 'speechkitt', EXLAC_VA_URL . '/assets/js/speechkitt.min.js', array( 'jquery' ), '1.0.0', true );
			
			wp_enqueue_script( 'virtual-assistant', EXLAC_VA_URL . '/assets/js/script.js', array( 'jquery' ), '1.1.3', true );
			
			$textIntro = bb_option(EXLAC_VA_PREFIX . 'text_instruction');
			$speakIntro = bb_option(EXLAC_VA_PREFIX . 'speak_instruction');
			$speakIn = bb_option(EXLAC_VA_PREFIX . 'lang_speak_in');
			$vaVoice = bb_option(EXLAC_VA_PREFIX . 'va_voice');
			
			$mainColor = bb_option(EXLAC_VA_PREFIX . 'main_color');
			$secColor = bb_option(EXLAC_VA_PREFIX . 'secondary_color');
			$textColor = bb_option(EXLAC_VA_PREFIX . 'text_color');

			$mainColor = ($mainColor != '')?$mainColor:'#2980B9';
			$secColor = ($secColor != '')?$secColor:'#3498DB';
			$textColor = ($textColor != '')?$textColor:'#FFFFFF';
			
			$custom_css = "
                .skitt-ui--not-listening #skitt-toggle-button {
                        background-color: {$mainColor};
				}
				.skitt-ui--listening #skitt-listening-box {
						color: {$textColor};
				}
				@-webkit-keyframes 'listen_pulse' {
				    0% {
				        background-color: {$mainColor};
				    }
				    50% {
				        background-color: {$secColor};
				    }
				    100% {
				        background-color: {$mainColor};
				    }
				}
				.skitt-ui--not-listening #skitt-toggle-button:hover, .skitt-ui--listening #skitt-toggle-button:hover, #skitt-ui {
				    background-color: {$secColor};
				}
				";
        	wp_add_inline_style( 'virtual-assistant-kitt-flat', $custom_css );
			
			wp_localize_script( 'annyang', 'VA_SETTINGS',
			    array( 
			        'ajaxurl'   => admin_url( 'admin-ajax.php' ),
					'TEXT_INTRO' => (isset($textIntro) && !empty($textIntro))?$textIntro:esc_html__('Say somethings...'),
					'SPEAK_INTRO' => (isset($speakIntro) && !empty($speakIntro))?$speakIntro:'',
					'USER_LANG' => (isset($speakIn) && !empty($speakIn))?$speakIn:'en-US',
					'VA_VOICE' => (isset($vaVoice) && !empty($vaVoice))?$vaVoice:'UK English Female',
			        // 'ajaxnonce' => wp_create_nonce( 'itr_ajax_nonce' ),
			    )
			);
			$commands = array();
			$commands_posts = get_posts(array(
				'numberposts' => -1,
				'post_type' => EXLAC_VA_POSTTYPE,
			));
			
			ob_start();
			?>
				var va_d = new Date();
				var va_date = va_d.getDate();
				var va_day = va_d.getDay();
				var va_year = va_d.getFullYear();
				var va_hour = va_d.getHours();
				var va_minute = va_d.getMinutes();
				var va_month = va_d.getMonth();
				var va_second = va_d.getSeconds();
				var va_period = (va_hour<=12)?'<?php esc_attr_e('AM',' bestbug') ?>':'<?php esc_attr_e('PM',' bestbug') ?>';
				
				var va_dofw = new Array(
					'<?php esc_attr_e('Monday', 'virtual-assistant') ?>',
					'<?php esc_attr_e('Tuesday', 'virtual-assistant') ?>',
					'<?php esc_attr_e('Wednesday', 'virtual-assistant') ?>',
					'<?php esc_attr_e('Thursday', 'virtual-assistant') ?>',
					'<?php esc_attr_e('Friday', 'virtual-assistant') ?>',
					'<?php esc_attr_e('Saturday', 'virtual-assistant') ?>',
					'<?php esc_attr_e('Sunday', 'virtual-assistant') ?>'
				);
				va_day = va_dofw[va_dofw];
				
				var va_mofy = new Array(
					'<?php esc_attr_e('January', 'virtual-assistant') ?>',
					'<?php esc_attr_e('February', 'virtual-assistant') ?>',
					'<?php esc_attr_e('March', 'virtual-assistant') ?>',
					'<?php esc_attr_e('April', 'virtual-assistant') ?>',
					'<?php esc_attr_e('May', 'virtual-assistant') ?>',
					'<?php esc_attr_e('June', 'virtual-assistant') ?>',
					'<?php esc_attr_e('July', 'virtual-assistant') ?>',
					'<?php esc_attr_e('August', 'virtual-assistant') ?>',
					'<?php esc_attr_e('September', 'virtual-assistant') ?>',
					'<?php esc_attr_e('October', 'virtual-assistant') ?>',
					'<?php esc_attr_e('November', 'virtual-assistant') ?>',
					'<?php esc_attr_e('December', 'virtual-assistant') ?>'
				);
				va_month = va_mofy[va_month];
				
				var va_commands = {
					<?php foreach ($commands_posts as $id => $commands_post): ?>
					"<?php echo strtolower(esc_attr($commands_post->post_title)) ?>": function(data) {
						<?php
						$activity = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'activity', true);
						$speak_content_finally = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'speak_content_finally', true);
						switch ($activity) {
							case 'speak':
								$speak_content = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'speak_content', true);
								$ask_chat_gpt = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'ask_chat_gpt', true);
								if( $ask_chat_gpt ) {
									$speak_content = $this->get_response_from_openai( $commands_post->post_title );
								}

								if(!empty($speak_content)) {
								?>
								responsiveVoice.speak("<?php echo esc_attr(ucfirst($speak_content)) ?>", VA_SETTINGS.VA_VOICE);
								<?php
								}
								break;
							case 'read':
								$read_selector = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'read_selector', true);
								?>
								if(jQuery("<?php echo esc_attr($read_selector) ?>").length > 0) {
									responsiveVoice.speak(jQuery("<?php echo esc_attr(ucfirst($read_selector)) ?>").text(), VA_SETTINGS.VA_VOICE);
								}
								<?php
								break;
							case 'go_to_link':
								$link = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'link', true);
								$target = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'target', true);
								$link_spacing = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'link_spacing', true);
								$link_replace = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'link_replace', true);
								$size = ($target == '_new')?'width=200,height=200':'';
								
								if(isset($link_spacing) && !empty($link_spacing)):
									if($link_spacing == 'remove'):
								?>
										data = data.replace(" ", "");
									<?php elseif($link_spacing == 'replace'): ?>
										data = data.replace(" ", "<?php echo esc_attr($link_replace) ?>");
									<?php endif; ?>
								<?php endif; ?>
								window.open("<?php echo esc_html($link) ?>".replace("[data]", data) , "<?php echo esc_attr($target) ?>", "<?php echo esc_attr($size) ?>");
								<?php
								break;	
							case 'scroll':
								$scroll = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'scroll_target', true);
								$custom_scroll = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'custom_scroll', true);
								$scroll_selector = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'scroll_selector', true);
								?>
								var scrollTo = 0;
								<?php 
								switch ($scroll) {
									case 'top':
										?>scrollTo = 0;<?php
										break;
									case 'bottom':
										?>scrollTo = jQuery('html').outerHeight();<?php
										break;
									case 'middle':
										?>scrollTo = jQuery('html').outerHeight() /2;<?php
										break;
									case 'down':
										?>scrollTo = jQuery(window).scrollTop() + parseInt("<?php echo esc_attr($custom_scroll) ?>");<?php
										break;
									case 'up':
										?>scrollTo = jQuery(window).scrollTop() - parseInt("<?php echo esc_attr($custom_scroll) ?>");<?php
										break;
									case 'element':
									?>
									if(jQuery("<?php echo esc_attr($scroll_selector) ?>").length > 0) {
										scrollTo = jQuery("<?php echo esc_attr($scroll_selector) ?>").offset().top;
									}
									<?php
										break;
									case 'custom':
										?>scrollTo = '<?php echo esc_attr($custom_scroll) ?>';<?php
										break;	
									default:
										$scrollTo = 0;
										break;
								} 
								?>
								jQuery('html, body').animate({
									scrollTop: scrollTo
								});
								<?php
								break;	
							case 'add_to_cart':
								$product_id = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'product_id', true);
								?>
								jQuery.get('<?php echo home_url() ?>?post_type=product&add-to-cart=<?php echo esc_attr($product_id) ?>', function() {
									
								});
								<?php
								break;
							case 'click':
								$click_selector = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'click_selector', true);
								?>
								if(jQuery("<?php echo esc_attr($click_selector) ?>").length > 0) {
									jQuery("<?php echo esc_attr($click_selector) ?>").trigger('click');
								}
								<?php
								break;
							case 'time':
								$time_speak_content = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'time_speak_content', true);
								?>
								var va_time_speak = "<?php echo esc_attr($time_speak_content) ?>";
								va_time_speak = va_time_speak.replace("[YEAR]", va_year);
								va_time_speak = va_time_speak.replace("[MONTH]", va_month);
								va_time_speak = va_time_speak.replace("[DATE]", va_date);
								va_time_speak = va_time_speak.replace("[HOUR]", va_hour);
								va_time_speak = va_time_speak.replace("[MINUTE]", va_minute);
								va_time_speak = va_time_speak.replace("[SECOND]", va_second);
								va_time_speak = va_time_speak.replace("[DAY]", va_day);
								va_time_speak = va_time_speak.replace("[PERIOD]", va_period);
								responsiveVoice.speak(va_time_speak, VA_SETTINGS.VA_VOICE);
								<?php
								break;	
							case 'custom':
								$custom_js = get_post_meta($commands_post->ID, EXLAC_VA_PREFIX . 'custom_js', true);
								echo esc_js( $custom_js );
								break;	
							default:
								# code...
								break;
						} // End switch
						
						if( $speak_content_finally != '') {
							?>responsiveVoice.speak("<?php echo esc_attr(ucfirst($speak_content_finally)) ?>", VA_SETTINGS.VA_VOICE);<?php
						}
						?>
					},
					<?php endforeach; ?>
				};
			<?php
			$commands = trim(preg_replace('/(\t+|\n+|\r+)/', '', ob_get_contents())); 
			ob_end_clean();
			wp_add_inline_script('virtual-assistant', $commands);
		}

		public function get_response_from_openai( $command ) {

			$url     = 'https://api.openai.com/v1/completions';
			$key = bb_option(EXLAC_VA_PREFIX . 'chat_gpt_api');

			$headers = array(
				'user-agent' => md5( esc_url( home_url() ) ),
				'Accept'     => 'application/json',
				'Authorization' => 'Bearer ' . $key,
				'Content-Type' => 'application/json'
			);

			$body = [
				'model' => "text-davinci-002", 
				'prompt' => "Converse as if you were an AI assistant. Answer the question as truthfully as possible. $command.",
				'temperature' => 0.7,
				'max_tokens' => 1500,
				'frequency_penalty' => 0.01,
				'presence_penalty' =>  0.01,
				'best_of' => 1,
			];

			$config = array(
				'method'      => 'POST',
				'timeout'     => 30,
				'redirection' => 5,
				'httpversion' => '1.0',
				'headers'     => $headers,
				'cookies'     => array(),
				'body' 		  => json_encode($body),

			);

			$response_body = array();

			try {
				$response = wp_remote_post( $url, $config );

				if ( ! is_wp_error( $response ) ) {
					$response_body = ( 'string' === gettype( $response['body'] ) ) ? json_decode( $response['body'], true ) : $response['body'];
					return $response_body['choices'][0]['text'];
				}
			} catch ( Exception $e ) {

			}
		}

		public function loadTextDomain() {
			load_plugin_textdomain( EXLAC_VA_TEXTDOMAIN, false, EXLAC_VA_PATH . '/languages/' );
		}

	}
	new EXLAC_VA_CLASS();
}