<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://segbedji.com
 * @author     justinahinon <justiny.ahinon@gmail.com>
 * @since      1.0
 *
 * @package    wpmassistant
 * @subpackage wpmassistant/admin
 */

// The function to display the plugin admin page
function wpma_dashboard_page() {
    $medias_number = sizeof( wpma_retrieve_images() );
    $extensions_occ = wpma_extensions_occ();
    ?>
    <div class="container wpma-dash">
        <div class="wpma-dash-head">
            <h2 class="page-title"><?php echo esc_html( get_admin_page_title() ); ?></h2>
        </div>
        <hr>

        <h4 class="sec-title sec-one-title">
            <?php _e( 'Basics',  'wp-media-assistant' ); ?>
        </h4>

        <div class="row mb-5">
            <div class="basic-info-card col-xl-3 col-md-6 mb-4">
                <div class="card card-one basic-info shadow h-100 py-2">
                    <div class="bi-body card-body">
                        <div class="bi-one row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="basic-info-title text-uppercase mb-1"><?php _e( 'Number of images in the gallery', 'wp-media-assistant' ) ?></div>
                                <div class="basic-info-value h5 mb-0"><?php echo $medias_number; ?></div>
                            </div>
                            <div class="col-auto">
                                <span class="basic-info-icon text-white">
                                    <i class="mdi mdi-numeric">
                                    </i>                 
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php foreach ( $extensions_occ as $extension_occ_key => $extension_occ_value ) { ?>
                <div class="basic-info-card col-xl-3 col-md-6 mb-4">
                    <div class="card card-two basic-info shadow h-100 py-2">
                        <div class="bi-body card-body">
                            <div class="bi-two row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="basic-info-title text-uppercase mb-1"><?php _e( 'Number of ' . $extension_occ_key . ' images', 'wp-media-assistant' ); ?></div>
                                    <div class="basic-info-value h5 mb-0"><?php echo $extension_occ_value; ?></div>
                                </div>
                                <div class="col-auto">
                                    <span class="basic-info-icon text-white">
                                    <i class="mdi mdi-image-area"></i>              
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="basic-info-card col-xl-3 col-md-6 mb-4">
                <div class="card card-three basic-info shadow h-100 py-2">
                    <div class="bi-body card-body">
                        <div class="bi-three row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="basic-info-title text-uppercase mb-1"><?php _e( 'Total weight of the media gallery files', 'wp-media-assistant' ); ?></div>
                                <div class="basic-info-value h5 mb-0"><?php echo size_format( array_sum( wpma_images_size() ), 1 ); ?></div>
                            </div>
                            <div class="col-auto">
                                <span class="basic-info-icon text-white">
                                    <i class="mdi mdi-weight">
                                    </i>                 
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="sec-title sec-one-title mb-4">
            <?php _e( 'Advanced',  'wp-media-assistant' ); ?>
        </h4>
        
        <div class="row mb-5 mt-4">
            <div class="col-md-5 chart-wrapper">
                <div id="extensions-chart" class="shadow">
                    <?php
                        $ext_chart_options = array(
                            "chart" => array(
                                "caption"               => "Images extensions",
                                "captionAlignmenet"     => "left",
                                "theme"                 => "fusion",
                                "captionPadding"        => "30"
                            )
                        );
                        $extensions_chart_data = wpma_multidim_occ( wpma_extensions_occ() );
                        wpma_render_ext_chart( "doughnut2d", $extensions_chart_data,
                                            $ext_chart_options, "100%", "400" );
                    ?>
                </div>
            </div>

            <div class="col-md-7 chart-wrapper">
                <div id="sizes-chart" class="shadow">
                    <?php
                        $sizes_chart_options = array(
                            "chart" => array(
                                "caption"                   => "Images sizes",
                                "captionAlignmenet"         => "left",
                                "theme"                     => "fusion",
                                "captionPadding"            => "30",
                                "showZeroPlaneValue"        => "0"
                            )
                        );
                        $sizes_chart_data =  wpma_multidim_occ( wpma_regroup_images_sizes() );
                        wpma_render_sizes_chart( "doughnut2d", $sizes_chart_data,
                                            $sizes_chart_options, "100%", "400" );
                    ?>
                </div>
            </div>
        </div>
        
        <?php $summary_table = wpma_isd_array(); ?>
        <h4 class="sec-title sec-one-title mb-4">
            <?php _e( 'Recents images',  'wp-media-assistant' ); ?>
        </h4>
        <div class="row summary-table-row">
            <div class="col-12">
                <div class="card summary-card" style="max-width:100%;">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php _e( 'Title', 'wp-media-assistant' ); ?></th>
                                        <th><?php _e( 'Weight', 'wp-media-assistant' ); ?></th>
                                        <th><?php _e( 'Upload date', 'wp-media-assistant' ); ?></th>
                                        <th><?php _e( 'Last updated', 'wp-media-assistant' ); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 0;
                                    foreach( $summary_table as $summary_row ) {
                                        // Display only last ten uploaded images in the gallery
                                        if( $counter < 10 ){
                                            echo '<tr>';
                                            foreach ( $summary_row as $summary_element ) {
                                                echo '<td>' . $summary_element . '</td>';
                                            }
                                            echo '</tr>';
                                        }
                                        $counter++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><?php _e( 'Title', 'wp-media-assistant' ); ?></th>
                                        <th><?php _e( 'Weight', 'wp-media-assistant' ); ?></th>
                                        <th><?php _e( 'Upload date', 'wp-media-assistant' ); ?></th>
                                        <th><?php _e( 'Last updated', 'wp-media-assistant' ); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}
