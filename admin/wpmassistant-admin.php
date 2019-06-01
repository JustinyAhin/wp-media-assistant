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
add_action( 'admin_enqueue_scripts', 'wpma_enqueue_admin_styles' );
function wpma_enqueue_admin_styles() {
wp_enqueue_style( 'wpma-admin-style', plugin_dir_url( __FILE__ ) . 'css/admin/wpmassistant-admin.css', array(), '', 'all' );
//wp_enqueue_style( 'boostrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );
}

// Enqueue scripts

// Global variables
$medias_url_list = [];

// Add the plugin admin main menu
add_action( 'admin_menu', 'wpmassistant_admin_menu' );
function wpmassistant_admin_menu() {
    add_menu_page(
        __( 'WP Media Assistant Dashboard', 'wpmassistant' ),
        'WPMA',
        'manage_options',
        'wpma_dashboard',
        'wpma_dashboard_page',
        'dashicons-welcome-widgets-menus'
    );
}

// The function that retrieve all the medias uploaded in the media library
function wpma_retrieve_images() {
    $query_images_args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page'  => '-1',   
    );
    
    $query_images = new WP_Query( $query_images_args );
    
    $wpma_medias_url_list = [];
    foreach ( $query_images->posts as $image_info ) {
        $wpma_medias_url_list [] = wp_get_attachment_url( $image_info->ID );
    }
    return $wpma_medias_url_list;
}

// The function that retrieve the extensions of medias uploaded in the media gallery
function wpma_images_extensions() {
    $medias_url_list = wpma_retrieve_images();
    $single_image_extension = '';
    $images_extension_list = [];

    foreach ( $medias_url_list as $single_image_url ) {
        $single_image_extension = wp_check_filetype( $single_image_url );
        $images_extension_list[] = $single_image_extension['ext'];
    }

    return $images_extension_list;
}

// The function that count the occurence of different images extensions
function wpma_extensions_occ() {
    return array_count_values( wpma_images_extensions() );
}

// The function to display the plugin admin page
function wpma_dashboard_page() {
    $medias_number = sizeof( wpma_retrieve_images() );
    $extensions_occ = wpma_extensions_occ();
    ?>
    <div class="container">
        <div class="wpma-dsh-head">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <h3><?php _e( 'This page will display a set of useful informations about the files in your media library', 'wpmassistant' ); ?></h3>
        </div>
        <hr>
        <div class="basic-infos">
            <h2><?php _e( 'Basic media library informations', 'wpmassistant' ); ?></h2>
            <table class="basic-infos-table">
                <thead>
                    <tr>
                        <th class="table-title"><?php _e( 'Variable', 'wpmassistant' ); ?></th>
                        <th class="table-title"><?php _e( 'Value', 'wpmassistant' ); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="table-title"><?php _e( 'Variable', 'wpmassistant' ); ?></th>
                        <th class="table-title"><?php _e( 'Value', 'wpmassistant' ); ?></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <th class="var-name"><?php _e( 'Number of images in the media gallery', 'wpmassistant' ); ?></th>
                        <th class="var-value"><?php echo $medias_number; ?></th>
                    </tr>
                    <?php
                    foreach ( $extensions_occ as $extension_occ_key => $extension_occ_value ) { ?>
                        <tr>
                            <th class="var-name"><?php _e( 'Number of ' . strtoupper( $extension_occ_key ) . ' images', 'wpmassistant' ); ?></th>
                            <th class="var-value"><?php echo $extension_occ_value; ?></th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php
}
