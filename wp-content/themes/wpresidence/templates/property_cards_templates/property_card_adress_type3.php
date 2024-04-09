<?php
$property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
$property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
$property_address   =   get_post_meta($post->ID,'property_address',true);
$property_category              =   get_the_term_list($post->ID, 'property_category', '', ', ', '') ;
$property_action_category       =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '') ;
?> 
<div class="property_card_categories_wrapper">
    <?php
        if($property_address!=''){
            print esc_html($property_address);
        }
        if($property_city!=''){
            print ', '.wp_kses_post($property_city);
        }

    ?>
</div>
