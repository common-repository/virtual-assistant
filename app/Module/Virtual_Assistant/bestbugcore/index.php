<?php
/* EXLAC CORE 1.4.6 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'EXLAC_CORE_VERSION' ) or define('EXLAC_CORE_VERSION', '1.4.6') ;

defined( 'EXLAC_CORE_URL' ) or define('EXLAC_CORE_URL', plugins_url( '/', __FILE__ )) ;
defined( 'EXLAC_CORE_PATH' ) or define('EXLAC_CORE_PATH', basename( dirname( __FILE__ ))) ;
defined( 'EXLAC_CORE_TEXTDOMAIN' ) or define('EXLAC_CORE_TEXTDOMAIN', 'virtual-assistant') ;

if ( ! class_exists( 'Exlac_Core_Class' ) ) {
	/**
	 * Exlac_Core_Class Class
	 *
	 * @since	1.0
	 */
	class Exlac_Core_Class {


		/**
		 * Constructor, core of EXLAC
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			add_action( 'plugins_loaded', array( $this, 'loadTextDomain' ) );
			add_action( 'admin_footer', array( $this, 'ajax_loading') );
			include_once 'classes/helper.class.php';

			if( is_admin() ){
				add_action( 'wp_default_scripts', 'wp_default_custom_scripts' );
				function wp_default_custom_scripts( $scripts ){
					$scripts->add( 'wp-color-picker', admin_url('js/color-picker.js'), array( 'iris' ), false, 1 );
					did_action( 'init' ) && $scripts->localize(
						'wp-color-picker',
						'wpColorPickerL10n',
						array(
							'clear'            => esc_html__( 'Clear', 'virtual-assistant' ),
							'clearAriaLabel'   => esc_html__( 'Clear color', 'virtual-assistant' ),
							'defaultString'    => esc_html__( 'Default', 'virtual-assistant' ),
							'defaultAriaLabel' => esc_html__( 'Select default color', 'virtual-assistant' ),
							'pick'             => esc_html__( 'Select Color', 'virtual-assistant' ),
							'defaultLabel'     => esc_html__( 'Color value', 'virtual-assistant' ),
						)
					);
				}
			}
		}
		public static function adminEnqueueScripts() {
			wp_enqueue_style( 'bb-core', EXLAC_CORE_URL . '/assets/admin/css/style.css', array(), EXLAC_CORE_VERSION );
			wp_enqueue_script( 'bb-core-admin', EXLAC_CORE_URL . '/assets/admin/js/script.js', array( 'jquery', 'wp-color-picker' ), EXLAC_CORE_VERSION, true );
		}

		public static function enqueueScripts() {
			wp_enqueue_style( 'bb-css', EXLAC_CORE_URL . '/assets/css/style.css', array(), EXLAC_CORE_VERSION );
		}
		
		public static function support($lib = '', $options = ''){
			switch ($lib) {
				case 'vc-params':
					include_once 'extend/index.php';
					if($options !='' && is_array($options)) {
						foreach ($options as $key => $type) {
							include_once 'extend/vc-params/' . $type . '.class.php';
						}
					} else {
						include_once 'extend/vc-params/index.php';
					}
					break;
				case 'options':
					include_once 'classes/options.class.php';
					break;
				case 'posttypes':
					include_once 'classes/posttypes.class.php';
					break;
				case 'htmldom':
					include_once 'libs/simple_html_dom.php';
					break;
				default:
					break;
			}
		}
		public function loadTextDomain() {
			load_plugin_textdomain( EXLAC_CORE_TEXTDOMAIN, false, EXLAC_CORE_PATH . '/languages/' );
		}
		
		public function ajax_loading(){
			echo '<div class="bb-ajax-loading">
					<div class="bb-ajax-box">
						<div class="bb-spinner">
						  <div class="cube1"></div>
						  <div class="cube2"></div>
						</div>
					</div>
				</div>';
		}

	}
	new Exlac_Core_Class();
}
