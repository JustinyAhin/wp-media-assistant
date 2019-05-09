<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/JustinyAhin
 * @since      1.0.0
 *
 * @package    Wpmassistant
 * @subpackage Wpmassistant/admin/partials
 */
?>

<h2><?php echo get_admin_page_title(); ?></h2>

<?php
/**
 * Query to retrieve all the images uploaded in WordPress gallery
 * 
 * @since	1.0.0
 */

function image_all() {
    $query_images_args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page'  => '-1',   
    );
    
    $query_images = new WP_Query( $query_images_args );
    
    $images = $query_images;
    foreach ( $images->posts as $image_info ) {
        $image_info = wp_get_attachment_url( $image_info->ID ) . "<br>" ;
        echo the_attachment
        echo $image_info;
    }

}

image_all();
