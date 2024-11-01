<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'EXLAC_VA_OPTIONS' ) ) {
	/**
	 * EXLAC_VA_OPTIONS Class
	 *
	 * @since	1.0
	 */
	class EXLAC_VA_OPTIONS {


		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			$this->init();
		}

		public function init() {
			
			add_filter('bb_register_options', array( $this, 'options'), 10, 1 );

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
        }

		public function adminEnqueueScripts() {
			if(isset($_GET['page']) && ($_GET['page'] == EXLAC_VA_SLUG || $_GET['page'] == EXLAC_VA_SLUG_SETTINGS || $_GET['page'] == EXLAC_VA_ALL_VIRTUAL_ASSISTANT_SLUG || $_GET['page'] == EXLAC_VA_ADD_VIRTUAL_ASSISTANT_SLUG)) {
				EXLAC_CORE_OPTIONS::adminEnqueueScripts();
			}
		}

		public function enqueueScripts() {
		
        }
        
        public function options($options) {
			if( empty($options) ) {
				$options = array();
			}
			$prefix = EXLAC_VA_PREFIX;
			$options[] = array(
				'type' => 'options_fields',
				//'ajax_action' => EXLAC_VA_SAVE_SETTINS,
				'menu' => array(
					// add_submenu_page || add_menu_page
					'type' => 'add_submenu_page',
					'parent_slug' => EXLAC_VA_SLUG,
					'page_title' => esc_html('Settings', 'virtual-assistant'),
					'menu_title' => esc_html('Settings', 'virtual-assistant'),
					'capability' => 'manage_options',
					'menu_slug' => EXLAC_VA_SLUG_SETTINGS,
				),
				'fields' => array(
					// tabs
					array(
						'type'       => 'tab',
						'param_name' => $prefix . 'tab',
						'value'      => array(
						  'general' => esc_html__( 'General', 'virtual-assistant' ),
						  'chat_gpt' => esc_html__( 'Ghat GPT (Pro)', 'virtual-assistant' ), 
						//   'product_license' => esc_html__( 'Product License', 'virtual-assistant' ),
						),
						'std' => 'general',
						'description' => esc_html__('', 'virtual-assistant'),
					),
					// array(
					// 	'type'       => 'textfield',
					// 	'heading'    => esc_html__( 'Connect API', 'virtual-assistant' ),
					// 	'param_name' => $prefix . 'chat_gpt_api',
					// 	'value'      => '',
					// 	'description' => '
					// 	<p>1. Sign up <a target="_blank" href="https://beta.openai.com/signup">here</a>. You can use your Google or Microsoft account to sign up if you don`t want to create using an email/password combination. You may need a valid mobile number to verify your account.</p>
					// 	<p>2. Now, visit your <a target="_blank" href="https://beta.openai.com/account/api-keys">OpenAI key page.</a></p>
					// 	<p>3. Create a new key by clicking the "Create new secret key" button.</p>
					// 	<p>4. Copy the key and paste it here</p>
					// 	<p>5. Click "Save Changes" button</p>
					// 	',
					// 	'tab' => array(
					// 		'element' =>  $prefix . 'tab',
					// 		'value' => array('chat_gpt')
					// 	),
					// ),
					array(
						'type'       => 'password',
						'heading'    => esc_html__( 'Purchase code', 'virtual-assistant' ),
						'param_name' => $prefix . 'purchase_code',
						'value'      => '',
						'description' => '<p><a target="_blank" href="https://exlac.com/products/virtual-assistant">Get it now</a></p>',
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('product_license')
						),
					),
					array(
						'type'       => 'text',
						'heading'    => '',
						'param_name' => $prefix . 'verify_now',
						'value'      => '<button type="button" class="button primary bb-vertify-button" data-slug="bbva" data-target="#'.$prefix .'purchase_code">Vertify Now</button>',
						'description' => 'Enter purchase code and press "Vertify Now" button',
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('product_license')
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Text Instruction', 'virtual-assistant' ),
						'param_name' => $prefix . 'text_instruction',
						'value'      => '',
						'description' => esc_html__( 'Default is Say something...', 'virtual-assistant' ),
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('general')
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Speak Instruction', 'virtual-assistant' ),
						'param_name' => $prefix . 'speak_instruction',
						'value'      => '',
						'description' => esc_html__( 'Speak after clients load this site', 'virtual-assistant' ),
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('general')
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Virtual Assistant voice', 'virtual-assistant' ),
						'param_name' => $prefix . 'va_voice',
						'std' => 'en-US',
						'value'      => array(
							"UK English Female" => "UK English Female",
							"UK English Male" => "UK English Male",
							"US English Female" => "US English Female",
							"Arabic Male" => "Arabic Male",
							"Armenian Male" => "Armenian Male",
							"Australian Female" => "Australian Female",
							"Brazilian Portuguese Female" => "Brazilian Portuguese Female",
							"Chinese Female" => "Chinese Female",
							"Czech Female" => "Czech Female",
							"Danish Female" => "Danish Female",
							"Deutsch Female" => "Deutsch Female",
							"Dutch Female" => "Dutch Female",
							"Finnish Female" => "Finnish Female",
							"French Female" => "French Female",
							"Greek Female" => "Greek Female",
							"Hatian Creole Female" => "Hatian Creole Female",
							"Hindi Female" => "Hindi Female",
							"Hungarian Female" => "Hungarian Female",
							"Indonesian Female" => "Indonesian Female",
							"Italian Female" => "Italian Female",
							"Japanese Female" => "Japanese Female",
							"Korean Female" => "Korean Female",
							"Latin Female" => "Latin Female",
							"Norwegian Female" => "Norwegian Female",
							"Polish Female" => "Polish Female",
							"Portuguese Female" => "Portuguese Female",
							"Romanian Male" => "Romanian Male",
							"Russian Female" => "Russian Female",
							"Slovak Female" => "Slovak Female",
							"Spanish Female" => "Spanish Female",
							"Spanish Latin American Female" => "Spanish Latin American Female",
							"Swedish Female" => "Swedish Female",
							"Tamil Male" => "Tamil Male",
							"Thai Female" => "Thai Female",
							"Turkish Female" => "Turkish Female",
							"Afrikaans Male" => "Afrikaans Male",
							"Albanian Male" => "Albanian Male",
							"Bosnian Male" => "Bosnian Male",
							"Catalan Male" => "Catalan Male",
							"Croatian Male" => "Croatian Male",
							"Czech Male" => "Czech Male",
							"Danish Male" => "Danish Male",
							"Esperanto Male" => "Esperanto Male",
							"Finnish Male" => "Finnish Male",
							"Greek Male" => "Greek Male",
							"Hungarian Male" => "Hungarian Male",
							"Icelandic Male" => "Icelandic Male",
							"Latin Male" => "Latin Male",
							"Latvian Male" => "Latvian Male",
							"Macedonian Male" => "Macedonian Male",
							"Moldavian Male" => "Moldavian Male",
							"Montenegrin Male" => "Montenegrin Male",
							"Norwegian Male" => "Norwegian Male",
							"Serbian Male" => "Serbian Male",
							"Serbo-Croatian Male" => "Serbo-Croatian Male",
							"Slovak Male" => "Slovak Male",
							"Swahili Male" => "Swahili Male",
							"Swedish Male" => "Swedish Male",
							"Vietnamese Male" => "Vietnamese Male",
							"Welsh Male" => "Welsh Male",
							"US English Male" => "US English Male",
							"Fallback UK Female" => "Fallback UK Female",
						),
						'description' => esc_html__( 'Voice Virtual Assistant will say', 'virtual-assistant' ),
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('general')
						),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Language Speak in', 'virtual-assistant' ),
						'param_name' => $prefix . 'lang_speak_in',
						'std'		 => 'en-US',
						'value'      => array(
							"af" => "Afrikaans",
							"eu" => "Basque",
							"bg" => "Bulgarian",
							"ca" => "Catalan",
							"ar-EG" => "Arabic (Egypt)",
							"ar-JO" => "Arabic (Jordan)",
							"ar-KW" => "Arabic (Kuwait)",
							"ar-LB" => "Arabic (Lebanon)",
							"ar-QA" => "Arabic (Qatar)",
							"ar-AE" => "Arabic (UAE)",
							"ar-MA" => "Arabic (Morocco)",
							"ar-IQ" => "Arabic (Iraq)",
							"ar-DZ" => "Arabic (Algeria)",
							"ar-BH" => "Arabic (Bahrain)",
							"ar-LY" => "Arabic (Lybia)",
							"ar-OM" => "Arabic (Oman)",
							"ar-SA" => "Arabic (Saudi Arabia)",
							"ar-TN" => "Arabic (Tunisia)",
							"ar-YE" => "Arabic (Yemen)",
							"cs" => "Czech",
							"nl-NL" => "Dutch",
							"en-AU" => "English (Australia)",
							"en-CA" => "English (Canada)",
							"en-IN" => "English (India)",
							"en-NZ" => "English (New Zealand)",
							"en-ZA" => "English (South Africa)",
							"en-GB" => "English(UK)",
							"en-US" => "English(US)",
							"fi" => "Finnish",
							"fr-FR" => "French",
							"gl" => "Galician",
							"de-DE" => "German",
							"el-GR" => "Greek",
							"he" => "Hebrew",
							"hu" => "Hungarian",
							"is" => "Icelandic",
							"it-IT" => "Italian",
							"id" => "Indonesian",
							"ja" => "Japanese",
							"ko" => "Korean",
							"la" => "Latin",
							"zh-CN" => "Mandarin Chinese",
							"zh-TW" => "Traditional Taiwan",
							"zh-CN" => "Simplified China",
							"zh-HK" => "Simplified Hong Kong",
							"zh-yue" => "Yue Chinese (Traditional Hong Kong)",
							"ms-MY" => "Malaysian",
							"no-NO" => "Norwegian",
							"pl" => "Polish",
							"xx-piglatin" => "Pig Latin",
							"pt-PT" => "Portuguese",
							"pt-BR" => "Portuguese (Brasil)",
							"ro-RO" => "Romanian",
							"ru" => "Russian",
							"sr-SP" => "Serbian",
							"sk" => "Slovak",
							"es-AR" => "Spanish (Argentina)",
							"es-BO" => "Spanish (Bolivia)",
							"es-CL" => "Spanish (Chile)",
							"es-CO" => "Spanish (Colombia)",
							"es-CR" => "Spanish (Costa Rica)",
							"es-DO" => "Spanish (Dominican Republic)",
							"es-EC" => "Spanish (Ecuador)",
							"es-SV" => "Spanish (El Salvador)",
							"es-GT" => "Spanish (Guatemala)",
							"es-HN" => "Spanish (Honduras)",
							"es-MX" => "Spanish (Mexico)",
							"es-NI" => "Spanish (Nicaragua)",
							"es-PA" => "Spanish (Panama)",
							"es-PY" => "Spanish (Paraguay)",
							"es-PE" => "Spanish (Peru)",
							"es-PR" => "Spanish (Puerto Rico)",
							"es-ES" => "Spanish (Spain)",
							"es-US" => "Spanish (US)",
							"es-UY" => "Spanish (Uruguay)",
							"es-VE" => "Spanish (Venezuela)",
							"sv-SE" => "Swedish",
							"tr" => "Turkish",
							"zu" => "Zulu",
						),
						'description' => esc_html__( 'Set the language the user will speak in. If this method is not called, defaults to en-US.', 'virtual-assistant' ),
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('general')
						),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Main Color', 'virtual-assistant' ),
						'param_name' => $prefix . 'main_color',
						'value'      => '#2980B9',
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('general')
						),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Secondary Color', 'virtual-assistant' ),
						'param_name' => $prefix . 'secondary_color',
						'value'      => '#3498DB',
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('general')
						),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Text Color', 'virtual-assistant' ),
						'param_name' => $prefix . 'text_color',
						'value'      => '#FFFFFF',
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('general')
						),
					),
					array(
						'type'       => 'toggle',
						'heading'    => esc_html__( 'Enable in Backend', 'virtual-assistant' ),
						'param_name' => $prefix . 'use_in_backend',
						'value'      => 'no',
						'description' => esc_html('You can use Virtual Assisant in Backend', 'virtual-assistant'),
						'tab' => array(
							'element' =>  $prefix . 'tab',
							'value' => array('general')
						),
					),
				),
			);
			
			return $options;
        }
        
    }
	
	new EXLAC_VA_OPTIONS();
}

