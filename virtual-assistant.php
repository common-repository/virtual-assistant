<?php
/**
 * EWVA
 *
 * @package           EWVA
 * @author            Exlac
 * @copyright         2022 Exlac
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Virtual Assistant - Build your own Google Now, Siri or Cortana
 * Plugin URI:        https://wordpress.org/plugins/virtual-assistant/
 * Description:       A self hosted AI voice assistant for your WordPress site
 * Version:           0.4
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Exlac
 * Author URI:        https://exlac.com/
 * Text Domain:       virtual-assistant
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

require dirname( __FILE__ ) . '/vendor/autoload.php';
require dirname( __FILE__ ) . '/app.php';

if ( ! function_exists( 'EWVA' ) ) {
    function EWVA() {
        return EWVA::get_instance();
    }
}
EWVA();

