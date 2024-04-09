<div class=" wpestate_single_agent_details_wrapper wpestate_single_agent_details_wrapper_type2" >
    <div class="agentpic-wrapper">
            <div class="agent-listing-img-wrapper" data-link="<?php print esc_attr($realtor_details['link']); ?>">
                <div class="agentpict" style="background-image:url(<?php echo esc_url($realtor_details['realtor_image']); ?>)"> </div>
            </div>
    </div>  

    <div class="agent_details">    
           
            <?php   
            
            $author         = get_post_field( 'post_author', $post->ID) ;
            $agency_post    = get_the_author_meta('user_agent_id',$author);
     
            
            print  wpestate_return_agent_reviews_bar($post->ID);


            print '<h3><a href="'.esc_url($realtor_details['link']).'">'.esc_html($realtor_details['realtor_name']).'</a></h3>
            <div class="agent_position">'.esc_html($realtor_details['realtor_position']);
            if(is_singular('estate_agent') && $agency_post!=''){
                print ',<a href="'.esc_url(get_permalink($agency_post)).'"> '.get_the_title($agency_post).'</a>';
            }
            print'</div>';
            
            if($realtor_details['member_of']!=''){
                print '<div class="agent_detail agent_web_member_of_class"><strong>'.esc_html__('Member of:','wpresidence').'</strong> '.esc_html($realtor_details['member_of']).'</div>';
            }
           
            if($realtor_details['agent_address']!=''){
                print '<div class="agent_detail agent_address"> '.esc_html($realtor_details['agent_address']).'</div>';
            }


            print wpestate_return_agent_share_social_icons($realtor_details,'agent_social_share_type2'); 
        
            get_template_part('templates/realtor_templates/agent_contact_bar');

            ?>

    </div>
   
    
  
</div>

 
<div class="wpestate_agent_details_container_wrapper wpestate_agent_details_container_wrapper_type_2">

 
        <div class="wpestate_agent_details_container">
            <h4><?php esc_html_e('About Me ','wpresidence'); ?></h4>    
            <?php the_content();?>

            <?php 
                if(wpresidence_get_option('wp_estate_agent_page_show_speciality_service','')==='yes'){
                    get_template_part('templates/realtor_templates/agent_taxonomies');
                }
                get_template_part('templates/realtor_templates/agent_custom_data'); 
  
            ?>

         
          
        </div>  

        
    

        <div class="wpestate_agent_details_container">
            <h4><?php echo esc_html__('Contact Me','wpresidence'); ?></h4>
           <div class="wpestate_agent_contact_details_type2"> 
                <?php 
                print wpestate_return_agent_contact_details($realtor_details);
                ?>
            </div>
            <?php
            $context='';
            include( locate_template ( '/templates/listing_templates/contact_form/property_page_contact_form.php'));
            ?>
        </div>

    


 </div>
