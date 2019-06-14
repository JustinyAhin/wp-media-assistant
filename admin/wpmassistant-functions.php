<?php
/**
 * The functions of the plugin.
 *
 * @link       https://segbedji.com
 * @author     justinahinon <justiny.ahinon@gmail.com>
 * @since      1.0
 *
 * @package    wpmassistant
 * @subpackage wpmassistant/admin
 */

// Enqueue styles
add_action( 'admin_enqueue_scripts', 'wpma_enqueue_admin_styles' );
function wpma_enqueue_admin_styles() {
    wp_enqueue_style( 'wpma-admin-style', plugin_dir_url( __FILE__ ) . 'css/admin/wpmassistant-admin.css', array(), '', 'all' );
    wp_enqueue_style( 'boostrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );
    wp_enqueue_style( 'mdi-icons', 'https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.min.css' );

    wp_enqueue_script( 'fusion-charts' , 'https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js' );
    wp_enqueue_script( 'fusion-charts-theme' , 'https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js' );
}

// Enqueue scripts

/**
 * Add the plugin menu to WordPress dashboard
 */
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

/**
 * The function that retrieve all the medias uploaded in the media library
*/
function wpma_retrieve_images() {
    $query_images_args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page'  => '-1',   
    );
    
    $query_images = new WP_Query( $query_images_args );
    
    foreach ( $query_images->posts as $image_info ) {
        $wpma_medias_url_list [] = wp_get_attachment_url( $image_info->ID );
    }
    return $wpma_medias_url_list;
}

/** 
 * The function that retrieve the medias size
*/
 function wpma_images_size() {
    $images_size_args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page'  => '-1',   
    );
    
    $attachments = get_posts( $images_size_args );
    
    foreach( $attachments as $attachment ) {
        $wpma_medias_size_list[] =  filesize( get_attached_file( $attachment->ID ) );
    }

    return $wpma_medias_size_list;
}

/** 
 * The function that retrieve the extensions of medias uploaded in the media gallery
*/
 function wpma_images_extensions() {
    $medias_url_list = wpma_retrieve_images();
    $single_image_extension = '';
    $images_extension_list = [];
    
    foreach ( $medias_url_list as $single_image_url ) {
        $single_image_extension = wp_check_filetype( $single_image_url );
        $images_extension_list[] = strtoupper( $single_image_extension['ext'] );
    }

    return $images_extension_list;
}

/** 
 * The function that count the occurence of different images extensions
*/
 function wpma_extensions_occ() {
    return array_count_values( wpma_images_extensions() );
}

/**
 * Transform an unidimentional array into a multidimensional one
*/
 function wpma_multidim_occ( $array_to_multidim ) {
    $multidim_occ = array();

    for( $i = 0; $i < sizeof($array_to_multidim); $i++ ) {
        $multidim_occ[$i][0] = array_keys($array_to_multidim)[$i];
    }
    for( $i = 0; $i < sizeof($array_to_multidim); $i++ ) {
        $multidim_occ[$i][1] = array_values($array_to_multidim)[$i];
    }

    return $multidim_occ;
}

/**
 * Convert bytes to the unit specified by the $to parameter.
 */
function wpma_convert_bytes_to_specified($bytes, $to, $decimal_places = 1) {
    $formulas = array(
        'K' => number_format($bytes / 1024, $decimal_places),
        'M' => number_format($bytes / 1048576, $decimal_places),
        'G' => number_format($bytes / 1073741824, $decimal_places)
    );
    return isset($formulas[$to]) ? $formulas[$to] : 0;
}

/**
 * Classify media gallery images size in an array
 * The function create different classes and insert images in depending on their sizes
 */
function wpma_regroup_images_sizes() {
    $images_sizes_array = wpma_images_size();

    $less_one_mb = 0;
    $one_to_three_mb = 0;
    $three_to_five_mb = 0;
    $five_to_ten_mb = 0;
    $more_than_ten_mb = 0;

    foreach( $images_sizes_array as $image_size ) {
        $image_size = wpma_convert_bytes_to_specified( $image_size, 'M', 2 );

        if( $image_size <= 1 ) {
            $less_one_mb++;
        } elseif ( $image_size > 1 and $image_size <= 3 ) {
            $one_to_three_mb++;
        } elseif ( $image_size > 3 and $image_size <= 5 ) {
            $three_to_five_mb++;
        } elseif ( $image_size > 5 and $image_size<= 10 ) {
            $five_to_ten_mb++;
        } elseif ( $image_size > 10 ) {
            $more_than_ten_mb++;
        }
    }

    return $images_bysize_array = array(
        "Less than 1 MB"    => $less_one_mb,
        "1 to 3 MB"         => $one_to_three_mb,
        "3 to 5 MB"         => $three_to_five_mb,
        "5 to 10 MB"        => $five_to_ten_mb,
        "More than 10 mb"   => $more_than_ten_mb,
    );
}

/**
 * Creating and rendering the chart based on an array and options
 */
function wpma_render_chart( $chart_type, $chart_name, $array_to_push, $chart_options, $chart_height, $chart_width ) {
    $data_array = array();
    
    // Create an associative array with label and values derived from a data array
    for($i = 0; $i < count($array_to_push); $i++) {
        array_push($data_array, array(
            "label" => $array_to_push[$i][0], "value" => $array_to_push[$i][1]
        ));
    }

    // Create a data object within the chart configurations to assign the associative data array to it
    $chart_options["data"] = $data_array;

    // JSON Encode the data to obtain the string containing the JSON representation of the data in the array.
    $json_encoded_data = json_encode($chart_options);
    
    // chart object
    $chart_ext = new FusionCharts( $chart_type, $chart_name, $chart_height, $chart_width, "extensions-chart", "json", $json_encoded_data);
    $chart_ext->render();

    $chart_sizes = new FusionCharts( $chart_type, $chart_name, $chart_height, $chart_width, "sizes-chart", "json", $json_encoded_data);
    $chart_sizes->render();
}