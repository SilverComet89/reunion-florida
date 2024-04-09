<div class="container content_wrapper">
    <div class="row"><!-- START ROW container-->
        <?php
        // loading breadcrumbs
        include ( locate_template('/templates/listing_templates/property-page-templates/property-page-breadcrumbs.php') ); 

        // loading title section - not overview
        include ( locate_template('templates/listing_templates/overview_template.php')); 
        ?>
        
        <div class="wpestate_lay3_media_wrapper col-md-12">
            <?php 
                // load media like sliders , gallery etc 
                wpestate_property_page_load_media($post->ID,$wpestate_options,6); 
                wpestate_property_overview_v2($post->ID);
            ?>
        </div>

        <?php
        $wp_estate_col_layout = intval(wpresidence_get_option('wp_estate_col_layout', ''));
        $class_column_1="col-md-".intval($wp_estate_col_layout);
        $class_column_2="col-md-".intval(12-$wp_estate_col_layout);

        
        ?>

        <div class=" <?php echo esc_attr($class_column_1); ?> ">
            <div class="single-content listing-content">
                <?php                   
                    $use_column ='enabled';
                    include( locate_template ('/templates/listing_templates/accordion-template_lay_6.php') );
                ?>
            </div><!-- end single-content listing-content container-->
        </div><!-- end full_width_prop container-->

        <div class=" <?php echo esc_attr($class_column_2); ?>">
            <div class="single-content listing-content">
                <?php      
                    $use_column ='after';             
                    include( locate_template ('/templates/listing_templates/accordion-template_lay_6.php') );
                ?>
            </div><!-- end single-content listing-content container-->
        </div><!-- end full_width_prop container-->

      
    </div><!-- end ROW container-->

    <div class="col-md-12 wpestate_after_content">
        <?php      
            $use_column ='after_content';             
            include( locate_template ('/templates/listing_templates/accordion-template_lay_6.php') );
        ?>
    </div>



</div>  

<?php print wpestate_property_disclaimer_section($post->ID); ?>
