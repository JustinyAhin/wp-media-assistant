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
                                    <div class="basic-info-title text-uppercase mb-1"><?php _e( 'Number of ' . strtoupper( $extension_occ_key ) . ' images', 'wpmassistant' ); ?></div>
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
            <?php _e( 'Basics',  'wpmassistant' ); ?>
        </h4>
        
        <div class="row mb-5">
            <div id="chart-container">Chart will render here!</div>
        </div>

        <div id="chart-container">Chart will render here!</div>
    </div>

    <?php
        // Chart Configuration stored in Associative Array
        $arrChartConfig = array(
            "chart" => array(
                "caption" => "Countries With Most Oil Reserves [2017-18]",
                "subCaption" => "In MMbbl = One Million barrels",
                "xAxisName" => "Country",
                "yAxisName" => "Reserves (MMbbl)",
                "numberSuffix" => "K",
                "theme" => "fusion"
            )
        );
        // An array of hash objects which stores data
        $arrChartData = wpma_multidim_occ();
        $arrLabelValueData = array();
    
        // Pushing labels and values
        for($i = 0; $i < count($arrChartData); $i++) {
            array_push($arrLabelValueData, array(
                "label" => $arrChartData[$i][0], "value" => $arrChartData[$i][1]
            ));
        }
    
        $arrChartConfig["data"] = $arrLabelValueData;

        print_r($arrChartData);
        
    
        // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
        $jsonEncodedData = json_encode($arrChartConfig);
    
        // chart object
        $Chart = new FusionCharts("pie2d", "MyFirstChart" , "700", "400", "chart-container", "json", $jsonEncodedData);
    
        // Render the chart
        $Chart->render();
} ?>
