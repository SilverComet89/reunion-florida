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
    <div class="agent_unit agent_unit_type_4" data-link="<?php print esc_attr($agent_details['link']);?>">
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
        ?>
      
    </div>
</div>   
<!-- </div>    -->