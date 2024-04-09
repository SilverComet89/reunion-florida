<?php
$pict_size=5;
$content_size=7;


?>
<div class="wpestate_agent_details_wrapper wpestate_single_agent_details_wrapper" id="wpestate_single_agent_details_wrapper">
    <div class="col-md-<?php print esc_attr($pict_size);?> agentpic-wrapper">
            <div class="agent-listing-img-wrapper" data-link="<?php print esc_attr($realtor_details['link']); ?>">
                <div class="agentpict" style="background-image:url(<?php echo esc_url($realtor_details['realtor_image']); ?>)"> </div>
            </div>

            <?php 
            print wpestate_return_agent_share_social_icons($realtor_details,'agent_unit_social_single'); 
            ?>
    </div>  

    <div class="col-md-<?php print esc_html($content_size);?> agent_details">    
           
            <?php   
            
            $author         = get_post_field( 'post_author', $post->ID) ;
            $agency_post    = get_the_author_meta('user_agent_id',$author);
             
            print '<h3><a href="'.esc_url($realtor_details['link']).'">'.esc_html($realtor_details['realtor_name']).'</a></h3>
            <div class="agent_position">'.esc_html($realtor_details['realtor_position']);
            if( is_singular('estate_agent')  &&  $agency_post!=''){
                print ',<a href="'.esc_url(get_permalink($agency_post)).'"> '.get_the_title($agency_post).'</a>';
            }
            print'</div>';
 
            print wpestate_return_agent_contact_details($realtor_details);
            ?>

    </div>
    
    <div class="row custom_details_container">
     
        
        <?php 
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if( !is_singular('estate_property')) {
            if( class_exists( 'Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
               
                // do nothing
            }else{
                get_template_part('templates/realtor_templates/agent_contact_bar');
                get_template_part('templates/realtor_templates/agent_custom_data'); 
                if(wpresidence_get_option('wp_estate_agent_page_show_speciality_service','')==='yes'){
                    get_template_part('templates/realtor_templates/agent_taxonomies');
                }
            }
        }
        ?> 
  
    </div>
    
    <?php
   
    if($agent_context=='property_page'){
        $context='property_page_form';
        include( locate_template ( '/templates/listing_templates/contact_form/property_page_contact_form.php'));
    }
    ?>
</div>


<?php  get_template_part('templates/realtor_templates/agent_about_me'); ?>


