<div class="property_details_type1_wrapper">
    <?php
    $property_size      =   wpestate_get_converted_measure( $post->ID, 'property_size' );
 
    $property_bedrooms  =   get_post_meta($post->ID,'property_bedrooms',true);
    $property_bathrooms =   get_post_meta($post->ID,'property_bathrooms',true);
    $prop_id            =   $post->ID;

    if($property_bedrooms!=''  && $property_bedrooms!=0){
        $string=sprintf( ( _n( '<span class="property_details_type1_value">%d</span> Bedroom', '<span class="property_details_type1_value">%d</span> Bedrooms', $property_bedrooms, 'wpresidence'  ) ), $property_bedrooms );
        print ' <span class="property_details_type1_rooms">'.$string.'</span>';
        if($property_bathrooms!=0 or $property_size!=0 ){
            echo ' '.trim('<span>&#183;</span>').' ';
        }
    }

    if($property_bathrooms!=''  && $property_bathrooms!=0){
        $string=sprintf( ( _n( '<span class="property_details_type1_value">%d</span> Bathroom', '<span class="property_details_type1_value">%d</span> Bathrooms', $property_bathrooms, 'wpresidence'  ) ), $property_bathrooms );
        print '<span class="property_details_type1_baths">'.$string.'</span>';
        if( $property_size!=0 ){
            echo ' '.trim('<span>&#183;</span>').' ';
        }
    }

    if($property_size!=''  && strval($property_size)!='0' ){
        print ' <span class="property_details_type1_size"><span class="property_details_type1_value">'.esc_html__('Size','wpresidence').' ' .$property_size.'</span>';
    }

    ?>

</div>
