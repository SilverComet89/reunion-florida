<?php
$wpestate_options['content_class']='col-md-12';
$wpestate_options['sidebar_class']='';


?>
<div class="row wpestate_agent_header2_content">

    <div class=" col-md-12 ">
        <?php   get_template_part('templates/ajax_container'); ?>
        <div id="content_container" > 
          
            <?php 
            while (have_posts()) : the_post(); 
                $agent_id           = get_the_ID();
                $realtor_details    = wpestate_return_agent_details('',$agent_id);
         
            ?>
          
            <div class="container_agent">
                <div class="single-content single-agent">

                    <?php  
                    $agent_context="agent_page";
                    include( get_theme_file_path('templates/listing_templates/agent_section/agent_details_2.php'));
                    ?>

                </div>

              
            </div>   
            <?php endwhile; // end of the loop.   ?>


            
            
            <?php  

            if(wpresidence_get_option('wp_estate_agent_page_show_my_listings','')==='yes'){
                include( locate_template('templates/agent_listings.php')); 
            }      
               
            $wp_estate_show_reviews     =    wpresidence_get_option('wp_estate_show_reviews_block','');         
            if(is_array($wp_estate_show_reviews) && in_array('agent', $wp_estate_show_reviews)){
               include( locate_template('templates/agent_reviews.php') );  
            }
            ?>
     
        </div>
    </div><!-- end 9col container-->    

</div>