<?php
/**
 * Plugin Name:       Termene Woocommerce
 * Version:           1.0.1
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'WPINC' ) ) {
    die();
}

define( 'TERMENE_PLUGIN_VERSION', '1.0.1');

require plugin_dir_path( __FILE__ ) . 'includes/termene-woocommerce.php';
require plugin_dir_path(__FILE__) . 'includes/termene-rest-client.php';


function termene_woocommerce_run() {
    $plugin = new Termene_Woocommerce();
    $plugin->run();

}
termene_woocommerce_run();



?>