<?php

/**
 * @link              https://segebdji.com
 * @since             1.0
 * @package           WP Media Assistant
 *
 * @wordpress-plugin
 * Plugin Name:       WP Media Assistant
 * Plugin URI:        https://github.com/JustinyAhin/wpmassistant
 * Description:       Display useful informations about WordPress media library.
 * Version:           1.0
 * Author:            Justin Sègbédji Ahinon
 * Author URI:        http://segbedji.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpmassistant
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * i18n
 */
function load_wpma_textdomain() {
	load_plugin_textdomain( 'wpmassistant', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action( 'plugin_loaded', 'load_wpma_textdomain' );

/**
 * Admin
 */
if (is_admin()) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/wpmassistant-admin.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/wpmassistant-functions.php';

	require_once plugin_dir_path( __FILE__ ) . 'admin/fusion-charts-suite-xt/fusioncharts.php';
}
/**
 * Public
 */
require_once plugin_dir_path( __FILE__ ) . 'public/wpmassistant-public.php';
