<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'EXLAC_VA_SHORTCODE' ) ) {
	/**
	 * EXLAC_VA_SHORTCODE Class
	 *
	 * @since	1.0
	 */
	class EXLAC_VA_SHORTCODE {

		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			
			add_shortcode( EXLAC_VA_SHORTCODE, array( $this, 'shortcode' ) );
			add_shortcode( 'cryptocompare', array( $this, 'shortcode' ) );
			add_shortcode( EXLAC_CRYPTOCOMPARE_SHORTCODE, array( $this, 'shortcode' ) );

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
			add_action( 'init', array( $this, 'init' ) );
		}

		public function init() {
			if ( defined( 'WPB_VC_VERSION' ) && function_exists( 'vc_add_param' ) ) {
				$this->vc_shortcode();
			}
        }

		public function adminEnqueueScripts() {
			// wp_enqueue_style( 'css', EXLAC_VA_URL . '/assets/admin/css/style.css' );
			// wp_enqueue_script( 'js', EXLAC_VA_URL . '/assets/admin/js/script.js', array( 'jquery' ), '1.0', true );
		}

		public function enqueueScripts() {
			// wp_enqueue_style( 'css', EXLAC_VA_URL . '/assets/css/style.css' );
			// wp_enqueue_script( 'js', EXLAC_VA_URL . '/assets/js/script.js', array( 'jquery' ), '1.0', true );
		}
        
        public function vc_shortcode() {
			
			$shortcodes = get_posts(array(
				'numberposts' => -1,
				'post_type' => EXLAC_VA_POSTTYPE,
				'orderby' => 'title',
				'order'   => 'ASC',
			));
			$values = array();
			if(is_array($shortcodes)) {
				foreach ($shortcodes as $id => $shortcode) {
					$values[$shortcode->post_title . ' '] = $shortcode->ID;
				}
			}
			
			vc_map( array(
			    "name" => esc_html__( "Ultimate Crypto Widgets", 'virtual-assistant' ),
			    "base" => EXLAC_CRYPTOCOMPARE_SHORTCODE,
			    "content_element" => true,
				"icon" => "icon-" . EXLAC_CRYPTOCOMPARE_SHORTCODE,
				"description" => esc_html__( "Display Ultimate Crypto Widgets Shortcode", 'virtual-assistant' ),
				'category' => esc_html( sprintf( esc_html__( 'by %s', 'virtual-assistant' ), EXLAC_VA_CATEGORY ) ),
			    "params" => array(
					array(
				        'type'        => 'dropdown',
				        'heading'     => esc_html__( 'Choose Ultimate Crypto Widgets Shortcode', 'virtual-assistant' ),
				        'value'       => $values,
				        'param_name'  => 'id',
						'admin_label' => true,
						'save_always' => true,
			        ),
			    ),
			) );
        }
		
		public function shortcode( $atts, $content = null ) {
			shortcode_atts( array(
				'id' => '',
				'css' => '',
				'el_class' => '',
			), $atts );
			
			$shortcode = get_post( $atts['id'] ); 
			
			if(!$shortcode || !isset($shortcode->ID)) {
				return esc_html__('Not found the shortcode!', 'virtual-assistant');
			}
			
			$layout = get_post_meta($shortcode->ID, EXLAC_VA_PREFIX . 'layout', true);
			$attsData = '';
			return;
		}
        
    }
	
	new EXLAC_VA_SHORTCODE();
}

