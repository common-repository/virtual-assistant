<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'EXLAC_VA_POSTTYPES' ) ) {
	/**
	 * EXLAC_VA_POSTTYPES Class
	 *
	 * @since	1.0
	 */
	class EXLAC_VA_POSTTYPES {


		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			//$this->init();
			add_filter( 'bb_register_posttypes', array( $this, 'register_posttypes' ), 10, 1 );
		}

		public function init() {

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );

        }

		public function adminEnqueueScripts() {
		
		}

		public function enqueueScripts() {
		
        }
        
		public function register_posttypes($posttypes) {

			if( empty($posttypes) ) {
				$posttypes = array();
			}

			$labels = array(
				'name'               => _x( 'Virtual Assistant', 'Virtual Assistant', 'virtual-assistant' ),
				'singular_name'      => _x( 'Virtual Assistant', 'Virtual Assistant', 'virtual-assistant' ),
				'menu_name'          => esc_html__( 'Virtual Assistant', 'virtual-assistant' ),
				'name_admin_bar'     => esc_html__( 'Virtual Assistant', 'virtual-assistant' ),
				'parent_item_colon'  => esc_html__( 'Parent Menu:', 'virtual-assistant' ),
				'all_items'          => esc_html__( 'All Virtual Assistants', 'virtual-assistant' ),
				'add_new_item'       => esc_html__( 'Add New Virtual Assistant', 'virtual-assistant' ),
				'add_new'            => esc_html__( 'Add New', 'virtual-assistant' ),
				'new_item'           => esc_html__( 'New Virtual Assistant', 'virtual-assistant' ),
				'edit_item'          => esc_html__( 'Edit Virtual Assistant', 'virtual-assistant' ),
				'update_item'        => esc_html__( 'Update Virtual Assistant', 'virtual-assistant' ),
				'view_item'          => esc_html__( 'View Virtual Assistant', 'virtual-assistant' ),
				'search_items'       => esc_html__( 'Search Virtual Assistant', 'virtual-assistant' ),
				'not_found'          => esc_html__( 'Not found', 'virtual-assistant' ),
				'not_found_in_trash' => esc_html__( 'Not found in Trash', 'virtual-assistant' ),
			);
			$args   = array(
				'label'               => esc_html__( 'Virtual Assistant', 'virtual-assistant' ),
				'description'         => esc_html__( 'Virtual Assistant', 'virtual-assistant' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', ),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => false,
				'show_in_menu'        => false,
				'menu_position'       => 13,
				'menu_icon'           => 'dashicons-schedule',
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'rewrite'             => false,
				'capability_type'     => 'page',
			);
			$posttypes[EXLAC_VA_POSTTYPE] = $args;
			return $posttypes;
		}
        
    }
	
	new EXLAC_VA_POSTTYPES();
}

