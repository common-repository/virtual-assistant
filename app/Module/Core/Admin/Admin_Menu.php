<?php

namespace EWVA\Module\Core\Admin;

use EWVA\Base\Helper;

class Admin_Menu {

    public function __construct() {
        // add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    public function admin_menu() {
        add_menu_page( __( 'Virtual Assistant', 'virtual-assistant' ), __( 'Virtual Assistant', 'virtual-assistant' ), 'manage_options', 'virtual-assistant', [$this, 'onetap_config'], 'dashicons-google', 77 );

        // add_submenu_page( 'virtual-assistant', __( 'Go Pro', 'virtual-assistant' ), __( 'Go Pro', 'virtual-assistant' ), 'manage_options', 'goolist-pro', [$this, 'pro'] );
    }

    public function onetap_config() {
        Helper\get_the_view( 'admin-ui/settings' );
    }

    public function pro() {
        Helper\get_the_view( 'admin-ui/integrations' );
    }

}
