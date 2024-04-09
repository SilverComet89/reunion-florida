<?php
global $wpestate_options;
$agent_details =wpestate_return_agent_details('',$post->ID);
$extra= array(
        'class'	=> 'lazyload img-responsive',    
        );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'property_listings',$extra);


if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_theme_file_uri('/img/default_user.png').'" alt="'.esc_html__('user image','wpresidence').'">';
}
?>

<div class=" ccvagnet col-md-<?php echo esc_attr($col_org.$per_row_class);?> listing_wrapper">         
    <div class="agent_unit" data-link="<?php print esc_attr($agent_details['link']);?>">
        <div class="agent-unit-img-wrapper">
            <?php 
            if($agent_details['counter']!=0 ){
            ?>
                <div class="agent_card_my_listings">
                    <?php print intval($agent_details['counter']).' '; 
                        if($agent_details['counter']!=1){
                            esc_html_e('listings','wpresidence');
                        }else{
                            esc_html_e('listing','wpresidence');
                        }
                    ?>
                </div>
            <?php             
            } 
            ?>
      
            
            
         
            <?php 
                print trim($thumb_prop); 
            ?>
        </div>    
            

        <?php
        print '<h4> <a href="'.esc_url($agent_details['link']).'">'.esc_html($agent_details['realtor_name']).'</a></h4>
        <div class="agent_position">'.esc_html($agent_details['realtor_position']).'</div>';

        print '<div class="agent_card_content">'. wpestate_strip_excerpt_by_char(get_the_excerpt(),90,$post->ID,'...').'</div>';
        ?>

     
       
        <div class="agent_unit_social agent_list">
        
               
               <?php
               
            
                print wpestate_return_agent_share_social_icons($agent_details,'wpestate_agent_unit_social',''); 
                
                if($agent_details['realtor_phone']!=''){
                    print '<div class="agent_unit_phone"><a href="tel:'.esc_html( $agent_details['realtor_phone']).'" rel="noopener" ><i class="fas fa-phone"></i></a></div>';
                }
                
                if($agent_details['email']!=''){
                    //'.esc_html($agent_details['email']).'</a>
                    print '<div class="agent_unit_email"><a href="mailto:'.esc_html($agent_details['email']).'" rel="noopener" ><i class="fas fa-envelope"></i></a></div>';
                }
                
                ?>
           
        </div>
    </div>
</div>   
<!-- </div>    -->