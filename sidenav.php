<?php
/**
 * Plugin Name:       SideNav
 * Plugin URI:        http://themes.tradesouthwest.com/wordpress/plugins/
 * Description:       Slide-out navigation for pull-out left or right side slide out menu.
 * Version:           1.0.1
 * Author:            Larry Judd
 * Author URI:        https://tradesouthwest.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sidenav
 * Domain Path:       /languages
 * @wordpress-plugin
 * @link              https://tradesouthwest.com
 * @package           SideNav
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/** Important constants
 *
 * @since   1.0.1
 *
 * @version - reserved
 * @plugin_url
 * @text_domain - reserved
 *
 */

define( 'SIDENAV_URL', plugin_dir_url(__FILE__));

//activate/deactivate hooks
function sidenav_plugin_activation() {

    return false;
}

//activate/deactivate hooks
function sidenav_plugin_deactivation() {

    return false;
}

/**
 * Initialise - load in translations
 * @since 1.0.0
 */
function sidenav_loadtranslations () {

    $plugin_dir = basename(dirname(__FILE__)).'/languages';
    load_plugin_textdomain( 'sidenav', false, $plugin_dir );

}
add_action('plugins_loaded', 'sidenav_loadtranslations');


/**
 * Plugin Scripts
 *
 * Register and Enqueues plugin scripts
 *
 * @since 1.0.0
 */
function sidenav_scripts() {

    // Register Scripts
    wp_register_script( 'sidenav-plugin', plugins_url( 'js/sidenav-plugin.js' , __FILE__ ), array( 'jquery' ), true );
    // Register Styles
    wp_register_style( 'sidenav-style', SIDENAV_URL . 'css/sidenav-style.css' );
    //let WP handle ver and loading
    wp_enqueue_style(  'sidenav-style' );
    wp_enqueue_script( 'sidenav-plugin' );

}
add_action( 'wp_enqueue_scripts', 'sidenav_scripts' );

//load admin scripts as well
add_action( 'admin_init', 'sidenav_scripts' );

//activate and deactivate registered
register_activation_hook( __FILE__, 'sidenav_plugin_activation');
register_deactivation_hook( __FILE__, 'sidenav_plugin_deactivation');

//include admin and public views
require ( plugin_dir_path( __FILE__ ) . 'includes/sidenav-adminpage.php' ); 
?>
