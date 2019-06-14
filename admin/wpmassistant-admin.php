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
            <span class="sec-one-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-crop-square">
                </i>                 
            </span>
            <?php _e( 'Basics',  'wpmassistant' ); ?>
        </h4>

        <div class="row mb-5">
            <div class="basic-info-card col-xl-3 col-md-6 mb-4">
                <div class="card card-one basic-info shadow h-100 py-2">
                    <div class="bi-body card-body">
                        <div class="bi-one row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="basic-info-title text-uppercase mb-1"><?php _e( 'Number of images in the gallery', 'wpmassistant' ) ?></div>
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
                                    <div class="basic-info-title text-uppercase mb-1"><?php _e( 'Number of ' . $extension_occ_key . ' images', 'wpmassistant' ); ?></div>
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
                                <div class="basic-info-title text-uppercase mb-1"><?php _e( 'Total weight of the media gallery files', 'wpmassistant' ); ?></div>
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

        <h4 class="sec-title sec-one-title">
            <span class="sec-one-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-crop-square">
                </i>                 
            </span>
            <?php _e( 'Advanced',  'wpmassistant' ); ?>
        </h4>
        
        <div class="row mb-5">
            <div class="col-md-4">
                <div id="extensions-chart">
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
                        wpma_render_chart( "doughnut2d", "wpma-extensions-chart", $extensions_chart_data,
                                            $ext_chart_options, 500, 500 );
                    ?>
                </div>

                <div class="col-md-4">
                <div id="sizes-chart">
                    <?php
                        $sizes_chart_options = array(
                            "chart" => array(
                                "caption"               => "Images extensions",
                                "captionAlignmenet"     => "left",
                                "theme"                 => "fusion",
                                "captionPadding"        => "30"
                            )
                        );
                        $sizes_chart_data =  wpma_multidim_occ( wpma_regroup_images_sizes() );
                        wpma_render_chart( "doughnut2d", "wpma-sizes-chart", $sizes_chart_data,
                                            $sizes_chart_options, 500, 500 );
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
} ?>
