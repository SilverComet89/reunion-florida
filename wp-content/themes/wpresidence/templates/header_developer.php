<?php
 
$thumb_id               =   get_post_thumbnail_id($post->ID);
$preview                =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
if(isset($preview[0])){
    $preview_img            =   $preview[0];
}else{
    $preview_img  = get_theme_file_uri('/img/default_user_agent.gif');
}


$agency_skype           =   esc_html( get_post_meta($post->ID, 'developer_skype', true) );
$agency_phone           =   esc_html( get_post_meta($post->ID, 'developer_phone', true) );
$agency_mobile          =   esc_html( get_post_meta($post->ID, 'developer_mobile', true) );
$agency_email           =   is_email( get_post_meta($post->ID, 'developer_email', true) );
$agency_posit           =   esc_html( get_post_meta($post->ID, 'developer_position', true) );
$agency_opening_hours   =   esc_html( get_post_meta($post->ID, 'developer_opening_hours', true) );
$name                   =   get_the_title($post->ID);
$link                   =   esc_url ( get_permalink($post->ID) );
$agency_addres          =    esc_html( get_post_meta($post->ID, 'developer_address', true) );
$agency_languages       =    esc_html( get_post_meta($post->ID, 'developer_languages', true) );
$agency_license         =    esc_html( get_post_meta($post->ID, 'developer_license', true) );
$agency_taxes           =    esc_html( get_post_meta($post->ID, 'developer_taxes', true) );
$agency_website         =    esc_html( get_post_meta($post->ID, 'developer_website', true) );
$realtor_details=   wpestate_return_agent_details($post->ID,$post->ID); 


?>

<div class="header_agency_wrapper">
    <div class="header_agency_container">
        <div class="row">
            
           
            
            <div class="col-md-4">
                <a href="<?php print esc_url($link);?>">
                    <img src="<?php print esc_url($preview_img);?>"  alt="<?php esc_html_e('image','wpresidence'); ?>" class="img-responsive"/>
                </a>
            </div>
            
            
            <div class="col-md-8">
                <h1 class="agency_title"><?php echo esc_html($name);?></h1>
                
                
                
                <div class="col-md-6 agency_details">
                    <?php
                          print wpestate_return_agent_share_social_icons($realtor_details,'','agency_social'); 
                    ?>
                    
                    <?php 
                    if($agency_addres!=''){
                        echo '<div class="agency_detail agency_address"><strong>'.esc_html__('Address:','wpresidence').'</strong> '.esc_html($agency_addres).'</div>';
                    }
                    ?>
                    
                    <?php 
                    if($agency_email!=''){
                        echo '<div class="agency_detail agency_email"><strong>'.esc_html__('Email:','wpresidence').'</strong> <a href="mailto:'.esc_html($agency_email).'">'.esc_html($agency_email).'</a></div>';
                    }
                    ?>
                 

                    <?php 
                    if($agency_mobile!=''){
                        echo '<div class="agency_detail agency_mobile"><strong>'.esc_html__('Mobile:','wpresidence').'</strong> <a href="tel:'.esc_html($agency_mobile).'">'.esc_html($agency_mobile).'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_phone!=''){
                        echo '<div class="agency_detail agency_phone"><strong>'.esc_html__('Phone:','wpresidence').'</strong> <a href="tel:'.esc_html($agency_phone).'">'.esc_html($agency_phone).'</a></div>';
                    }
                    ?>
                    
                    <a href="#agency_contact" class=" developer_contact_button wpresidence_button"  ><?php esc_html_e('Contact Us','wpresidence');?></a>
                      
                </div>   
                
                <div class="col-md-6 agency_details">
                    <div class="developer_taxonomy">
                    <?php
                    print  get_the_term_list($post->ID, 'property_county_state_developer', '', '', '') ;
                    print  get_the_term_list($post->ID, 'property_city_developer', '', '', '') ;
                    print  get_the_term_list($post->ID, 'property_area_developer', '', '', '');
                    print  get_the_term_list($post->ID, 'property_category_developer', '', '', '') ;
                    print  get_the_term_list($post->ID, 'property_action_developer', '', '', '');  
                    ?>
                    </div>                  
                </div>
            </div>
            
            
            <div class="col-md-12 developer_content">
                <div class="col-md-8 ">
                    <?php
                    $content_post = get_post($post->ID);
                    $content = $content_post->post_content;
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    print trim($content);
                    ?>
                  
                </div>
                
                <div class="col-md-4">
                    <?php 
                    
                    if($agency_website!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.esc_html__('Website:','wpresidence').'</strong> <a href="'.esc_url($agency_website).'" target="_blank">'.esc_html($agency_website).'</a></div>';
                    }
                    ?>  
                    <?php 
                    if($agency_skype!=''){
                        echo '<div class="agency_detail agency_skype"><strong>'.esc_html__('Skype:','wpresidence').'</strong> '.esc_html($agency_skype).'</div>';
                    }
                    ?>
                    <?php 
                    if($agency_license!=''){
                        echo '<div class="agency_detail agency_license"><strong>'.esc_html__('License:','wpresidence').'</strong> '.esc_html($agency_license).'</div>';
                    }
                    ?>
                    <?php 
                    if($agency_taxes!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.esc_html__('Our Taxes:','wpresidence').'</strong> '.esc_html($agency_taxes).'</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>