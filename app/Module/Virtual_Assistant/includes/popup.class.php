<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'EXLAC_VA_POPUP' ) ) {
	/**
	 * EXLAC_VA_POPUP Class
	 *
	 * @since	1.0
	 */
	class EXLAC_VA_POPUP {


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
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
			add_action( 'wp_footer', [$this,'bb_va_popup_view']);
        }

		public function enqueueScripts() {
			wp_enqueue_style( 'font-awesome', EXLAC_VA_URL . '/assets/libr/font-awesome/css/font-awesome.min.css' );
        }
		

		public function bb_va_popup_view() {
			include_once "views/button_assistant.view.php";
        }

        
    }
	
	new EXLAC_VA_POPUP();
}

