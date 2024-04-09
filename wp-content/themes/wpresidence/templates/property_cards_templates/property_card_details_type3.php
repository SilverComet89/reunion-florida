<?php
$link           =   esc_url( get_permalink() );
$property_bedrooms         =   get_post_meta($post->ID, 'property_bedrooms', true);
if($property_bedrooms!=''){
    $property_bedrooms =   floatval($property_bedrooms);
}

$property_bathrooms     =   get_post_meta($post->ID, 'property_bathrooms', true) ;
if($property_bathrooms!=''){
    $property_bathrooms =   floatval($property_bathrooms);
}

$property_size = wpestate_get_converted_measure( $post->ID, 'property_size' );



$property_garage_size      =   get_post_meta($post->ID, 'property-garage-size', true);
$property_lot_size = wpestate_get_converted_measure( $post->ID, 'property_lot_size' );
?>

<div class="property_listing_details">






    <?php 
        if($property_bedrooms!='' && $property_bedrooms!=0){
            print '<div class="property_listing_details_v3_item"  data-original-title="'.esc_attr__('Bedrooms','wpresidence').'" >';
                print '<div class="icon_label">';
                    include(locate_template('css/css-images/icons/bedrooms7.svg'));
                print'</div>';   
                print esc_html($property_bedrooms);
            print '</div>';
        }

        if($property_bathrooms!='' && $property_bathrooms!=0){
            print '<div class="property_listing_details_v3_item" data-original-title="'.esc_attr__('Bathrooms','wpresidence').'">';
                print '<div class="icon_label" >';
                include(locate_template('css/css-images/icons/bath7.svg'));
                print'</div>';              
                print esc_html($property_bathrooms);
            print'</div>';   
        }

        if($property_size!=''){
            print '<div class="property_listing_details_v3_item" data-original-title="'.esc_attr__('Property Size','wpresidence').'" >';
                print '<div class="icon_label" >';
                    include(locate_template('css/css-images/icons/size7.svg'));
                print'</div>';   
                print trim($property_size);
            print'</div>';   
        }


        if($property_garage_size!=''){
            print '<div class="property_listing_details_v3_item" data-original-title="'.esc_attr__('Garage Size','wpresidence').'" >';
                print '<div class="icon_label"  >';
                    include(locate_template('css/css-images/icons/car7.svg'));
                print'</div>';   
                print trim($property_garage_size);
            print'</div>';   
        }


       

    ?>
</div>