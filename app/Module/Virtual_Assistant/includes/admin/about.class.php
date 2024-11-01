<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}
if (!class_exists('About_Exlac_VirtualAssistant')) {

	/**
	 * About_Exlac_VirtualAssistant Class
	 *
	 * @since	1.0 
	 */

	class About_Exlac_VirtualAssistant{
		/**
		 * Constructor
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct()
		{
            $this->init();
        }
        public function init() {
			//add_action('admin_menu',array($this,'about'), 11 );
			if(is_admin()) {
				add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueueScripts' ) );

				$bb_license = get_option('bb_license_bbva', 0);
				if($bb_license != 1) {
					//add_action( 'admin_notices', array( $this, 'notice_license' ) );
				}
			}
        }

		public function notice_license()
		{
			?>
			<div class="notice notice-warning is-dismissible">
				<p>Add your <?php echo esc_html(EXLAC_VA_CATEGORY) ?>'s License Key <a href="<?php echo admin_url('admin.php?page=virtual_assistant_settings#bbTabActive=product_license') ?>">HERE</a> to get Premium Support and Auto check update.</p>
			</div>
			<?php
		}

		public function adminEnqueueScripts(){
			wp_enqueue_script('script', EXLAC_CORE_URL . '/assets/js/script.js', array(), null, true );

			if(isset($_GET['page']) && $_GET['page'] == 'bbva_about') {
				wp_enqueue_script( 'popper', EXLAC_CORE_URL . '/assets/admin/libs/tippy/popper.min.js', array(), EXLAC_CORE_VERSION, true );
				wp_enqueue_script( 'tippy', EXLAC_CORE_URL . '/assets/admin/libs/tippy/tippy-bundle.iife.min.js', array(), EXLAC_CORE_VERSION, true );
			}
		}
        public function about() {
			$bb_available_version = get_option('bb_version_bbva', EXLAC_VA_VERSION);
			$count = 1;
			if(version_compare( EXLAC_VA_VERSION, $bb_available_version, '>=') ) {
				$count = 0;
			}
			add_submenu_page(
				EXLAC_VA_SLUG,
				esc_html__('About' , 'virtual-assistant'),
				$count ? sprintf( esc_html__('About' , 'virtual-assistant') . ' <span class="awaiting-mod">%d</span>', $count  ) : esc_html__('About' , 'virtual-assistant'),
				'manage_options',
				'bbva_about',
				array(&$this, 'plugin_about')
			);
        }
        public function plugin_about() {
			?>
			<div class="wpbb_about_page">
				<div class="wpbb_about_title">
					<div class="wpbb-container">
						<div class="wpbb-left-section">
							<!-- <h3>Hey, <span></span></h3> -->
							<h1>Welcome to <?php echo esc_html(EXLAC_VA_CATEGORY) ?> <?php echo esc_html(EXLAC_VA_VERSION) ?></h1>
							
							<h4>Installed Version <strong><?php echo esc_html(EXLAC_VA_VERSION) ?></strong></h4>
							<?php
								$bb_available_version = get_option('bb_version_bbva', EXLAC_VA_VERSION);
							?>
							<h4>Available Version <strong><?php echo esc_html($bb_available_version) ?></strong></h4>
							<?php if(version_compare( EXLAC_VA_VERSION, $bb_available_version, '>=') ): ?>
								<p>You are using the latest version.</p>
							<?php else: ?>
								<p>You need update newest version. <span class="bb-awaiting-mod">1</span></p>
								<a href="https://wordpress.org/plugins/virtual-assistant"  target="_blank" class="hero-button">Get the Newest Version</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="wpbb_about_title wpbb_about_title_white">
					<div class="wpbb-container">
						<div class="wpbb-left-section">
							<!-- <h3>Hey, <span></span></h3> -->
							<h1>Support & FAQs</h1>
							
							<h4>Thanks for choosing our plugins for your website!</h4>
							<p>If you are concerned/ confused about your purchase, plugin and theme compatibility, installation, customization, update, or encounter any kind of problems during the use of our plugins, feel free to submit a ticket on our <a href="https://bestbug.ticksy.com/"  target="_blank">Support Forum</a>.</p>
							<ul>
								<li>In case of serious or complicated technical issues, we might need you to provide the admin login information.</li>
								<li>If you’re worried about security or privacy, then please create a dev/ staging site which best describes your current issue and give us the login account to look into the problem. Read more about sending secure login information here. The more details, the faster we can get you a valid solution.</li>
								<li>We strongly recommend users to write tickets in plain English.</li>
							</ul>
							<a href="https://bestbug.ticksy.com/"  target="_blank" class="hero-button">Get Support</a><a href="https://bestbug.ticksy.com/articles/" target="_blank" class="how-to-use">Learn How To Use</a>
						</div>
					</div>
				</div>
				<div class="wpbb_about_plugin">
					<div class="wpbb-container">
						<div class="wpbb-plugin-title">
							
						</div>
						<div class="wpbb-plugin-content">
							<ul class="wpbb-list-ul">
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php
        }
	}
	new About_Exlac_VirtualAssistant();
}