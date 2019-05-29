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

// The function to retrieve all the medias uploaded in the media library
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

// The code to display the plugin admin page
function wpma_dashboard_page() {
    ?>
    <div class="container">
        <div class="wpma-dsh-head">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <h3>This page will display a set of useful informations about the files in your media library</h3>
        </div>
        <hr>
        <div class="basic-infos">
            <h2>Basic media library informations</h2>
            <table class="basic-infos-table">
                <thead>
                    <tr>
                        <th>Variable</th>
                        <th>Value</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    
    <div>
        <?php 
        $medias_url_list = wpma_retrieve_images();
        foreach ( $medias_url_list as $single_image_url ) {
            echo $single_image_url . "<br>";
        }
        ?>
    </div>
    
    <?php
}
