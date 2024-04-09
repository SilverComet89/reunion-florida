<div class="container content_wrapper">
    <div class="row"><!-- START ROW container-->
        <?php
        // loading breadcrumbs
        include ( locate_template('/templates/listing_templates/property-page-templates/property-page-breadcrumbs.php') ); 

        // loading title section - not overview
        include ( locate_template('templates/listing_templates/overview_template.php')); 
        ?>

        <div class=" <?php print esc_html($wpestate_options['content_class']);?> full_width_prop">
            <div class="single-content listing-content">
                
                <?php 
                    // load media like sliders , gallery etc 
                    
                    wpestate_property_page_load_media($post->ID,$wpestate_options,1); 
                ?>

                <?php 
                    // load content in tabs or accordion format          
                    if($content_type=='tabs'){
                        include( locate_template ('/templates/listing_templates/tabs-template.php') );
                    }else{
                        include( locate_template ('/templates/listing_templates/accordion-template.php') );
                    }
                ?>

            </div><!-- end single-content listing-content container-->
        </div><!-- end full_width_prop container-->


        <?php
        // load the sidebar
        include( locate_template ('sidebar.php') );
        ?>
    </div><!-- end ROW container-->
</div>  

<?php print wpestate_property_disclaimer_section($post->ID); ?>
