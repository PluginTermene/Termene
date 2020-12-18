<?php
/**
 * Plugin Name:       Termene Woocommerce
 * Version:           1.0.2
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'WPINC' ) ) {
    die();
}

define( 'TERMENE_PLUGIN_VERSION', '1.0.2');

require plugin_dir_path( __FILE__ ) . 'includes/termene-woocommerce.php';
require plugin_dir_path(__FILE__) . 'includes/termene-rest-client.php';


function termene_woocommerce_run() {
    $plugin = new Termene_Woocommerce();
    $plugin->run();

}
termene_woocommerce_run();


function activate_termene_woocommerce() {
    if ( ! termene_check_compatibility()) {
        termene_show_version_err();
    }
}
register_activation_hook( __FILE__, 'activate_termene_woocommerce' );
function termene_show_version_err() {
    wp_die(__('<strong>Termene WooCommerce</strong> necesita WordPress 4.7-5.5.3 si WooCommerce 3.0-4.7.<br/> <a href="#" onclick="window.history.back();">Inapoi</a>.', 'termene-woocommerce'));
}

/**
 * Check WordPress and WooCommerce versions
 */
function termene_check_compatibility() {
    $min_wp_ver = '4.7.0';
    $max_wp_ver = '5.5.3';
    $min_woo_ver = '3.0.0';
    $max_woo_ver = '4.7';

    // check woocommerce version to be higher than 4.7
    if ( version_compare( $GLOBALS['wp_version'], $min_wp_ver, '<' ) &&
        version_compare( $GLOBALS['wp_version'], $max_wp_ver, '>' )
    ) {
        return false;
    }
    if ( class_exists( 'WooCommerce' ) ) {
        global $woocommerce;
        if( version_compare( $woocommerce->version, $min_woo_ver, "<=" ) ) {
            return false;
        }
    }
    else {
        return false;
    }

    // Add sanity checks for other version requirements here
    return true;
}

?>