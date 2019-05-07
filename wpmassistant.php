<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/JustinyAhin
 * @since             1.0.0
 * @package           Wpmassistant
 *
 * @wordpress-plugin
 * Plugin Name:       WP Media Assistant
 * Plugin URI:        https://github.com/JustinyAhin/wpmassistant
 * Description:       Display useful informations about WordPress media library
 * Version:           1.0.0
 * Author:            Justin Ahinon
 * Author URI:        https://github.com/JustinyAhin
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
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'WPMASSISTANT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpmassistant-activator.php
 */
function activate_wpmassistant() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpmassistant-activator.php';
	Wpmassistant_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpmassistant-deactivator.php
 */
function deactivate_wpmassistant() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpmassistant-deactivator.php';
	Wpmassistant_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpmassistant' );
register_deactivation_hook( __FILE__, 'deactivate_wpmassistant' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpmassistant.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpmassistant() {

	$plugin = new Wpmassistant();
	$plugin->run();

}
run_wpmassistant();
