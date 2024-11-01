<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Exlac_Update_VirtualAssistant' ) ) {
	/**
	 * Exlac_Update_VirtualAssistant Class
	 *
	 * @since	1.0
	 */
	class Exlac_Update_VirtualAssistant {


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
			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}

            add_filter( 'wp_ajax_bb_update_license',array( $this, 'update_license') );
            add_filter( 'wp_ajax_bb_update_version',array( $this, 'update_version') );
            add_filter( 'wp_ajax_bb_get_code',array( $this, 'get_code') );
        }

		public function adminEnqueueScripts() {
            wp_enqueue_script( 'jquery-cookie', EXLAC_CORE_URL . '/assets/js/jquery.cookie.js', array( 'jquery' ), EXLAC_CORE_VERSION, true );
			wp_enqueue_script( 'bb-update-bbva'  , EXLAC_VA_URL . '/assets/admin/js/update.js', array('jquery'), false, true );
		}
       
        function update_license(){
			$slug = sanitize_text_or_array_field($_REQUEST['slug']);
			$license = sanitize_text_or_array_field($_REQUEST['license']);
			Exlac_Helper::update_option('bb_license_'.$slug, $license);
			die('ok');
		}

		function update_version(){
			$slug = sanitize_text_or_array_field($_REQUEST['slug']);
			$version = sanitize_text_or_array_field($_REQUEST['version']);
			
			if(empty($version)) {
				die;
			}
			Exlac_Helper::update_option('bb_version_'.$slug, $version);
			die('ok');
		}

		public function get_code(){
			$slug = sanitize_text_or_array_field($_REQUEST['slug']);
			echo json_encode(array(
				'result' => 1,
				'code' => get_option($slug),
			));
			die;
		}
        
    }
	
	new Exlac_Update_VirtualAssistant();
}

