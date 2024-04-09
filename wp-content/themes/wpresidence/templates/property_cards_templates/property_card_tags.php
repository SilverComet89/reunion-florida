<?php
$featured               =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );?>
<div class="tag-wrapper">
    <?php
        if($featured==1 && wpresidence_get_option('property_card_agent_show_featured', '')=='yes' ){
            print '<div class="featured_div">'.esc_html__('Featured','wpresidence').'</div>';
        }
    ?>      
    
    <?php 
    if(wpresidence_get_option('property_card_agent_show_status', '')=='yes'){
        get_template_part('templates/property_cards_templates/property_card_status');
    } 
    ?>
</div>

