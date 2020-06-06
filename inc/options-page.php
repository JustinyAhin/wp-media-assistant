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

    <div id="wpbody-content">
        <div class="wpma-dash">
            <div class="wpma-dash-head">
                <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
            </div>
            <hr>

            <h3 class="sec-title sec-one-title">
                <?php _e( 'Basics',  'wp-media-assistant' ); ?>
            </h3>

            <div class="wpma-basic-infos">
                <div class="wpma-basic-info-content notice notice-info">
                    <div class="wpma-basic-info-stat">
                        <p class="wpma-basic-info-number"><?php echo $medias_number; ?></p>
                        <p class="wpma-basic-info-text"><?php _e( 'Number of images in the gallery', 'wp-media-assistant' ) ?></p>
                    </div>
                </div>

                <?php foreach ( $extensions_occ as $extension_occ_key => $extension_occ_value ) { ?>
                <div class="wpma-basic-info-content notice notice-info">
                    <div class="wpma-basic-info-stat">
                        <p class="wpma-basic-info-number"><?php echo $extension_occ_value; ?></p>
                        <p class="wpma-basic-info-text"><?php _e( 'Number of ' . $extension_occ_key . ' images', 'wp-media-assistant' ); ?></p>
                    </div>
                </div>
                <?php } ?>

                <div class="wpma-basic-info-content notice notice-info">
                    <div class="wpma-basic-info-stat">
                        <p class="wpma-basic-info-number"><?php echo size_format( array_sum( wpma_images_size() ), 1 ); ?></p>
                        <p class="wpma-basic-info-text"><?php _e( 'Total size of the media gallery files', 'wp-media-assistant' ); ?></p>
                    </div>
                </div>
            </div>

            <h3 class="sec-title sec-one-title mb-4">
                <?php _e( 'Advanced',  'wp-media-assistant' ); ?>
            </h3>
            
            <div class="wpma-charts-infos">
                <div id="extensions-chart" class="notice notice-info">
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

                <div id="sizes-chart" class="notice notice-info">
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


            <?php $summary_table = wpma_isd_array(); ?>
            <h3 class="sec-title sec-one-title mb-4">
                <?php _e( 'Recents images',  'wp-media-assistant' ); ?>
            </h3>

            
            <div class="wpma-summary-table">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th scope="col"><?php _e( 'Title', 'wp-media-assistant' ); ?></th>
                            <th scope="col"><?php _e( 'Weight', 'wp-media-assistant' ); ?></th>
                            <th scope="col"><?php _e( 'Upload date', 'wp-media-assistant' ); ?></th>
                            <th scope="col"><?php _e( 'Last updated', 'wp-media-assistant' ); ?></th>
                            <th scope="col"></th>
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
                            <th scope="col"><?php _e( 'Title', 'wp-media-assistant' ); ?></th>
                            <th scope="col"><?php _e( 'Weight', 'wp-media-assistant' ); ?></th>
                            <th scope="col"><?php _e( 'Upload date', 'wp-media-assistant' ); ?></th>
                            <th scope="col"><?php _e( 'Last updated', 'wp-media-assistant' ); ?></th>
                            <th scope="col"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>

    <?php
}
