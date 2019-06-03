<?php

/**
 * @link              https://segebdji.com
 * @since             1.0.0
 * @package           WP Media Assistant
 *
 * @wordpress-plugin
 * Plugin Name:       WP Media Assistant
 * Plugin URI:        https://segbedji.com
 * Description:       Display useful informations about WordPress media library.
 * Version:           1.0.0
 * Author:            Justin Ahinon
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
load_plugin_textdomain( 'wpmassistant', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 

/**
 * Admin
 */
if (is_admin()) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/wpmassistant-admin.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/wpmassistant-functions.php';

	require_once plugin_dir_path( __FILE__ ) . 'fusioncharts-suite-xt/integrations/php/fusioncharts-wrapper/fusioncharts.php';
}
/**
 * Public
 */
require_once plugin_dir_path( __FILE__ ) . 'public/wpmassistant-public.php';
