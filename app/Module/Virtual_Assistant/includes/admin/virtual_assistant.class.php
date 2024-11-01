<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'EXLAC_VA_VIRTUAL_ASSISTANT' ) ) {
	/**
	 * EXLAC_VA_VIRTUAL_ASSISTANT Class
	 *
	 * @since	1.0
	 */
	class EXLAC_VA_VIRTUAL_ASSISTANT {
		
		public $page_title;
		
		public $orderby;
		public $order;
		
		public $shortcodes;

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
			
			add_action( 'admin_menu', array( $this, 'all_virtual_assistant' ) );
			add_action( 'admin_menu', array( $this, 'pro_menu' ) );
			add_filter('bb_register_options', array( $this, 'virtual_assistant'), 10, 1 );

			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
			add_action( 'wp_ajax_rc_delete_shortcode', array($this, 'delete') );

			add_action( 'wp_ajax_bbsm_delete_checked_as', array( $this, 'delete_checked' ) );
        }

		public function pro_menu() {
			global $submenu;
	
			$capability = 'manage_options';
			$slug       = EXLAC_VA_SLUG;
	
			if ( current_user_can( $capability ) ) {
				$submenu[$slug][] = [ '<a id="eva_pro_menu" style="color: #f06060; font-weight: bold;" href="https://exlac.com/downloads/virtual-assistant" target="_blank"> ' . __( 'Go Pro', 'virtual-assistant' ) . ' </a>', $capability, "#"]; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			}
		}

		public function adminEnqueueScripts() {
			
		}

		public function enqueueScripts() {
		
        }
		
		public function delete(){
			if(isset($_POST['id'])) {
				$del = wp_delete_post( $_POST['id'], true );
				if($del) {
					echo json_encode(array(
						'status' => 'notice',
						'title' => esc_html('Deleted', 'virtual-assistant'),
						'message' => esc_html('Command is deleted!', 'virtual-assistant'),
					));
					exit;
				}
			}
			echo json_encode(array(
				'status' => 'error',
				'title' => esc_html('Error', 'virtual-assistant'),
				'message' => esc_html('Can not delete!', 'virtual-assistant'),
			));
			exit;
		}

		public function delete_checked(){
			global $wpdb;

			$queried_object = $wpdb->get_results ("
	    		SELECT * FROM $wpdb->posts WHERE post_status = 'publish' and post_type = 'post'",OBJECT_K);

			if(isset($_POST['ids'])) {
				$arr_ids = explode(",", $_POST['ids']);
				foreach($arr_ids as $ids){
					foreach($queried_object as $post){
						if( isset($post->ID) == $ids ) {
							$del = wp_delete_post( $ids, true );
						}
					}
				}
				exit;
			}

			echo json_encode(array(
				'status' => 'error',
				'title' => esc_html('Error', 'virtual-assistant'),
				'message' => esc_html('Can not delete!', 'virtual-assistant'),
			));
			exit;
		}
		
		public function all_virtual_assistant(){
			$menu = array(
				'page_title' => esc_html('All Commands', 'virtual-assistant'),
				'menu_title' => esc_html('Virtual Assistants', 'virtual-assistant'),
				'capability' => 'manage_options',
				'menu_slug' => EXLAC_VA_SLUG,
				'icon' => EXLAC_VA_URL . '/assets/admin/images/logo-20x20.png',
				'position' =>  4,
			);
			$this->page_title = $menu['page_title'];
			add_menu_page($menu['page_title'],
						$menu['menu_title'],
						$menu['capability'],
						$menu['menu_slug'],
						array(&$this, 'view'),
						$menu['icon'],
						$menu['position']
					);
			add_submenu_page(
				EXLAC_VA_SLUG,
				esc_html__('All Commands' , 'virtual-assistant'),
				esc_html__('All Commands' , 'virtual-assistant'),
				$menu['capability'],
				$menu['menu_slug'],
				array(&$this, 'view')
		    );
		}
		
		public function view() {
			
			$this->shortcodes = get_posts(array(
				'numberposts' => -1,
				'post_type' => EXLAC_VA_POSTTYPE,
				'orderby' => $this->orderby,
				'order'   => $this->order,
			));
			
			EXLAC_HELPER::begin_wrap_html($this->page_title);
			include 'templates/virtual_assistant.view.php';
			EXLAC_HELPER::end_wrap_html();
		}
		
		public function sortform(){
			?>
			<div class="bb-row">
			    <div class="bb-col">
			        <a href="<?php echo admin_url( 'admin.php?page=' . EXLAC_VA_ADD_VIRTUAL_ASSISTANT_SLUG ) ?>" class="button success"><span class="dashicons dashicons-plus-alt"></span><?php esc_html_e('Add New', 'virtual-assistant') ?></a>
			    </div>
				<div class="bb-col">
					<div class="bb_remove_all"><a class="button danger delete_checked_ids"><span class="dashicons dashicons-trash"></span><?php esc_html_e('Delete Command(s)', 'virtual-assistant') ?></a>	
						<input type="hidden" name="ids_checked_remove" id="ids_checked_remove" value="">
					</div>
				</div>
			</div>
			<?php
		}
        
        public function virtual_assistant($options) {
			if( empty($options) ) {
				$options = array();
			}
			
			$prefix = EXLAC_VA_PREFIX;
			
			$general = array(
				array(
					'type'       => 'hidden',
					'param_name' => 'ID',
					'value'      => (isset($_REQUEST['ID']) && !empty($_REQUEST['ID']))?$_REQUEST['ID']:'',
				),
				array(
					'type'       => 'hidden',
					'param_name' => 'post_type',
					'value'      => EXLAC_VA_POSTTYPE,
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Voice Command (*)', 'virtual-assistant' ),
					'param_name' => 'post_title',
					'value'      => '',
					'description' => esc_html__( 'Just enter your text client will say.', 'virtual-assistant' ),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Activity', 'virtual-assistant' ),
					'value'       => array(
						'speak' => esc_html__( 'Speak', 'virtual-assistant' ),
						'read' => esc_html__( 'Read', 'virtual-assistant' ),
						'go_to_link' => esc_html__( 'Go to link', 'virtual-assistant' ),
						'scroll' => esc_html__( 'Scroll', 'virtual-assistant' ),
						'add_to_cart' => esc_html__( 'Add To Cart (Woocommerce)', 'virtual-assistant' ),
						'time' => esc_html__( 'Time', 'virtual-assistant' ),
						'click' => esc_html__( 'Click', 'virtual-assistant' ),
						'custom' => esc_html__( 'Custom', 'virtual-assistant' ),
					),
					'param_name'  => $prefix . 'activity',
					'std' => 'speak',
					'description' => esc_html__( 'Choose activity to Virtual Assistant do.', 'virtual-assistant' ),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);
			
			$speak = array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Speak Content (*)', 'virtual-assistant' ),
					'param_name' => $prefix . 'speak_content',
					'value'      => '',
					'description' => esc_html__( 'The content Virtual Assistant will say.', 'virtual-assistant' ),
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'speak' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
				array(
					'type'       => 'toggle',
					'heading'    => esc_html__( 'Get from ChatGPT', 'virtual-assistant' ),
					'param_name' => $prefix . 'ask_chat_gpt',
					'value'      => '',
					'pro'	=> true,
					'description' => '<span style="color: red;">Need to upgrade to <a href="https://exlac.com/downloads/virtual-assistant/" target="_blank">Pro Version</a></span>',
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'speak' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Time Speak Content (*)', 'virtual-assistant' ),
					'param_name' => $prefix . 'time_speak_content',
					'value'      => '',
					'description' => "The content Virtual Assistant will say you can use shortcode<br/><b>[YEAR] [MONTH] [DATE] [HOUR] [MINUTE] [SECOND] [DAY] [PERIOD]</b>.<br/>Example: <b>[HOUR]:[MINUTE] [PERIOD]</b>",
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'time' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);
			
			$read = array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Element Selector (*)', 'virtual-assistant' ),
					'param_name' => $prefix . 'read_selector',
					'value'      => '',
					'description' => 'The <a href="https://www.w3schools.com/jquery/jquery_ref_selectors.asp" target="_blank">Jquery Selector</a> (.class-name or #id-name) of element need to read content',
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'read' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);
			
			$link = array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Link URL (*)', 'virtual-assistant' ),
					'param_name' => $prefix . 'link',
					'value'      => '',
					'description' => 'Enter target link and you can use [data] from client say.',
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'go_to_link' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Target', 'virtual-assistant' ),
					'value'       => array(
						'_self' => esc_html__( 'Current Tab', 'virtual-assistant' ),
						'_blank' => esc_html__( 'New Tab', 'virtual-assistant' ),
						'_new' => esc_html__( 'New Window', 'virtual-assistant' ),
					),
					'param_name'  => $prefix . 'target',
					'std' => 'current',
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'go_to_link' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Spacing', 'virtual-assistant' ),
					'value'       => array(
						'' => esc_html__( 'Keep spacing between each words', 'virtual-assistant' ),
						'remove' => esc_html__( 'Remove all spacing', 'virtual-assistant' ),
						'replace' => esc_html__( 'Replace all spacing', 'virtual-assistant' ),
					),
					'param_name'  => $prefix . 'link_spacing',
					'std' => '',
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'go_to_link' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Replace to', 'virtual-assistant' ),
					'param_name' => $prefix . 'link_replace',
					'value'      => '',
					'description' => esc_html__('Characters you want use to replace all spacing', 'virtual-assistant'),
					'dependency'  => array( 
						'element' => $prefix . 'link_spacing',
						'value' => array( 'replace' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);
			
			$scroll = array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Scroll', 'virtual-assistant' ),
					'value'       => array(
						'top' => esc_html__( 'Top', 'virtual-assistant' ),
						'bottom' => esc_html__( 'Bottom', 'virtual-assistant' ),
						'middle' => esc_html__( 'Middle', 'virtual-assistant' ),
						'up' => esc_html__( 'Up', 'virtual-assistant' ),
						'down' => esc_html__( 'Down', 'virtual-assistant' ),
						'custom' => esc_html__( 'Custom', 'virtual-assistant' ),
						'element' => esc_html__( 'To Element', 'virtual-assistant' ),
					),
					'param_name'  => $prefix . 'scroll_target',
					'std' => 'top',
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'scroll' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Space Scrolling', 'virtual-assistant' ),
					'param_name' => $prefix . 'custom_scroll',
					'value'      => '',
					'description' => 'unit px',
					'dependency'  => array( 
						'element' => $prefix . 'scroll_target',
						'value' => array( 'custom', 'up', 'down' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Element Selector (*)', 'virtual-assistant' ),
					'param_name' => $prefix . 'scroll_selector',
					'value'      => '',
					'description' => 'The <a href="https://www.w3schools.com/jquery/jquery_ref_selectors.asp" target="_blank">Jquery Selector</a> (.class-name or #id-name) of element need scroll to',
					'dependency'  => array( 
						'element' => $prefix . 'scroll_target',
						'value' => array( 'element' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);
			
			$click = array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Element Selector (*)', 'virtual-assistant' ),
					'param_name' => $prefix . 'click_selector',
					'value'      => '',
					'description' => 'The <a href="https://www.w3schools.com/jquery/jquery_ref_selectors.asp" target="_blank">Jquery Selector</a> (.class-name or #id-name) of element need to click on',
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'click' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);
			
			$add_to_cart = array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Product ID', 'virtual-assistant' ),
					'param_name' => $prefix . 'product_id',
					'value'      => '',
					'description' => esc_html__( 'Enter Product ID', 'virtual-assistant' ),
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'add_to_cart' ) 
					),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);
			
			$custom_js = array(
				array(
					'type'       => 'javascript',
					'heading'    => esc_html__( 'Custom JS', 'virtual-assistant' ),
					'param_name' => $prefix . 'custom_js',
					'value'      => '',
					'dependency'  => array( 
						'element' => $prefix . 'activity',
						'value' => array( 'custom' ) 
					),
					'description' => esc_html__( 'The content Virtual Assistant will say finally.', 'virtual-assistant' ),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);
			
			$finally = array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Speak Content Finally', 'virtual-assistant' ),
					'param_name' => $prefix . 'speak_content_finally',
					'value'      => '',
					'description' => esc_html__( 'The content Virtual Assistant will say finally.', 'virtual-assistant' ),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('general')
					),
				),
			);

			$show_on_popup = array(
				array(
					'type'       => 'toggle',
					'heading'    => esc_html__( 'Show on Popup', 'virtual-assistant' ),
					'param_name' => $prefix . 'show_on_popup',
					'value'      => 'no',
					'description' => esc_html('Enable/disable Show command on Popup', 'virtual-assistant'),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('bubble')
					),
				),
			);

			$title_popup = array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'virtual-assistant' ),
					'param_name' => $prefix . 'title_popup',
					'value'      => '',
					'description' => esc_html__( '', 'virtual-assistant' ),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('bubble')
					),
				),
			);
			$description_popup = array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Description', 'virtual-assistant' ),
					'param_name' => $prefix . 'description_popup',
					'value'      => '',
					'description' => esc_html__( '', 'virtual-assistant' ),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('bubble')
					),
				),
			);
			$sample_command = array(
				// array(
				// 	'type'       => 'textfield',
				// 	'heading'    => esc_html__( 'Sample command', 'virtual-assistant' ),
				// 	'param_name' => $prefix . 'sample_command',
				// 	'value'      => '',
				// 	'description' => esc_html__( '', 'virtual-assistant' ),
				// 	'tab' => array(
				// 		'element' => $prefix . 'tab',
				// 		'value' => array('bubble')
				// 	),
				// ),
			);

			$tab = array(
				array(
					'type'       => 'tab',
					'heading'    => esc_html__( 'Dark theme', 'virtual-assistant' ),
					'param_name' => $prefix . 'tab',
					'value'      => array(
					  'general' => esc_html__( 'General', 'virtual-assistant' ),
					  'bubble' => esc_html__( 'Bubble', 'virtual-assistant' ),
					),
					'std' => 'general',
					'description' => esc_html__('', 'virtual-assistant'),
					'tab' => array(
						'element' => $prefix . 'tab',
						'value' => array('bubble')
					),
				  ),
			);


			$options[] = array(
				'type' => 'post_fields',
				'ajax_action' => 'bb_save_post',
				'menu' => array(
					// add_submenu_page || add_menu_page
					'type' => 'add_submenu_page',
					'parent_slug' => EXLAC_VA_SLUG,
					'page_title' => esc_html('Add Command', 'virtual-assistant'),
					'menu_title' => esc_html('Add Command', 'virtual-assistant'),
					'capability' => 'manage_options',
					'menu_slug' => EXLAC_VA_ADD_VIRTUAL_ASSISTANT_SLUG
				),
				'fields' => array_merge(
					$tab,
					$general, 
					$speak,
					$read,
					$link,
					$scroll,
					$add_to_cart,
					$click,
					$custom_js,
					$finally,
					$show_on_popup,
					$title_popup,
					$description_popup,
					$sample_command
				)
			);
			
			return $options;
        }
        
    }
	
	new EXLAC_VA_VIRTUAL_ASSISTANT();
}

