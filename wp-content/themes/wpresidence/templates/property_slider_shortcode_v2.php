<?php
$slides             =   '';
$title              =   get_the_title($prop_id);
$link               =   get_permalink($prop_id);
$property_bathrooms =   get_post_meta($prop_id, 'property_bathrooms', true);
$property_rooms     =   get_post_meta($prop_id, 'property_bedrooms', true);
$property_size      =   wpestate_get_converted_measure( $prop_id, 'property_size' ) ;
$price              =   floatval( get_post_meta($prop_id, 'property_price', true) );
$price_label        =   '<span class="price_label">'.esc_html ( get_post_meta($prop_id, 'property_label', true) ).'</span>';
$price_label_before =   '<span class="price_label price_label_before">'.esc_html ( get_post_meta($prop_id, 'property_label_before', true) ).'</span>';

if ($price != 0) {
    $price = wpestate_show_price($prop_id,$wpestate_currency,$where_currency,1);  
}else{
    $price=$price_label_before.$price_label;
}

$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
if($preview[0]==''){
    $preview_image= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
}else{
    $preview_image=$preview[0];
}
 
$post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
$attachment_meta    =   wp_get_attachment($post_thumbnail_id);

$active='';
$title = get_the_title($prop_id);
?>


   <?php 
   
    print '<div class="item '.esc_attr($active).'" data-number="'.$counter.'"   >
        
    <div class="property_slider_carousel_elementor_v2_image_wrapper">
        <div class="property_slider_carousel_elementor_v2_price">'.trim($price).'</div>
        <div class="places_cover"></div>
        <div class="property_slider_carousel_elementor_v2_image_container" style="background-image:url('.esc_url($preview_image).');">
        </div> 
    </div>
    
    <a href="'.get_permalink($prop_id).'" class="property_slider_carousel_elementor_v2_title">'.$title.'</a>
    
        
    </div>';
   
   ?>

