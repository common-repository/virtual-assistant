<?php

namespace EWVA\Module\Core\Asset;

use EWVA\Utility\Enqueuer\Enqueuer;

class Admin_Asset extends Enqueuer {

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->asset_group = 'admin';
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_scripts'] );
    }

    /**
     * Load Admin CSS Scripts
     *
     * @return void
     */
    public function load_scripts() {
        $this->add_css_scripts();
        $this->add_js_scripts();
    }

    /**
     * Load Admin CSS Scripts
     *
     * @Example
      $scripts['dhgi-core-admin-core-admin-style'] = [
          'file_name' => 'admin',
          'base_path' => EWVA_CSS_PATH,
          'deps'      => [],
          'ver'       => $this->script_version,
          'group'     => 'admin',
      ];
     *
     * @return void
     */
    public function add_css_scripts() {
        $scripts = [];

        $scripts['dhgi-core-admin-core-admin-style'] = [
            'file_name' => 'core-admin',
            'base_path' => EWVA_CSS_PATH,
            'deps'      => [],
            'ver'       => $this->script_version,
            'group'     => 'admin',
        ];

        $scripts           = array_merge( $this->css_scripts, $scripts );
        $this->css_scripts = $scripts;
    }

    /**
     * Load Admin JS Scripts
     *
     * @Example
      $scripts['exlac-customer-support-app-core-admin-script'] = [
          'file_name' => 'admin',
          'src_path'  => EWVA_ASSET_SRC_PATH . 'modules/core/js/admin/',
          'base_path' => EWVA_JS_PATH,
          'group'     => 'admin',
          'data'      => [ 'object-key' => [] ],
      ];
     *
     * @return void
     */
    public function add_js_scripts() {
        $scripts = [];

        $scripts['dhgi-core-admin-script'] = [
            'file_name' => 'core-admin',
            'base_path' => EWVA_JS_PATH,
            'group'     => 'admin',
            'data'      => [
                'oneTap_CoreScriptData' => [
                    'apiEndpoint' => rest_url( 'exlac_cs/v1' ),
                    'apiNonce'    => wp_create_nonce( 'wp_rest' ),
                    'wp_pages'    => [],
                ],
            ],
        ];

        $scripts          = array_merge( $this->js_scripts, $scripts );
        $this->js_scripts = $scripts;
    }
}