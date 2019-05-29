<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://segbedji.com
 * @author     justinahinon <justiny.ahinon@gmail.com>
 * @since      1.0
 *
 * @package    wpmassistant
 * @subpackage wpmassistant/admin
 */

/**
 *
 * Plugin options in the dashboard menu
 *
 */

 // Enqueue styles


 // Enqueue scripts

// Add the plugin admin menu
add_action( 'admin_menu', 'wpmassistant_admin_menu' );
function wpmassistant_admin_menu() {
    add_menu_page(
        __( 'WP Media Assistant Dashboard', 'wpmassistant' ),
        'WPMA Dashboard',
        'manage_options',
        'wpma_dashboard',
        'wpma-dashboard-page',
        'dashicons-welcome-widgets-menus'
    );
}