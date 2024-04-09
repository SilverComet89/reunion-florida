<?php
$property_size      =   wpestate_get_converted_measure( $post->ID, 'property_size' );
$property_bedrooms     =   get_post_meta($post->ID,'property_bedrooms',true);
$property_bathrooms =   get_post_meta($post->ID,'property_bathrooms',true);
$prop_id            =   $post->ID;  
?>


<div class="property_listing_details">
    <?php
    if($property_bedrooms!=''  && $property_bedrooms!=0 ){
        print '<div class="inforoom_unit_type4">'.esc_html($property_bedrooms).' '.esc_html__('Bedrooms','wpresidence').'</div>';

        if( ($property_bathrooms!=''  && $property_bathrooms!=0 ) ||
            ($property_size!='' && strval($property_size)!='0' ) ){
            
                echo ' '.trim('<span>&#183;</span>').' ';
        }

    }
    if($property_bathrooms!=''  && $property_bathrooms!=0 ){
        print '<div class="infobath_unit_type4">'.esc_html($property_bathrooms).' '.esc_html__('Baths','wpresidence').'</div>';
        if(   ($property_size!='' && strval($property_size)!='0' ) ){
            echo ' '.trim('<span>&#183;</span>').' ';
        }

    }
    if($property_size!='' && strval($property_size)!='0' ){
        print '<div class="infosize_unit_type4">'.esc_html__('Size','wpresidence').' '.$property_size.'</div>';//escaped above
    }
    ?>
</div>



 <?php global $align_class;
    if ($align_class=='the_list_view') {?>
        <div class="listing_details the_list_view" style="display:block;">
            <?php   
                echo wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
            ?>
        </div>   

        <div class="listing_details half_map_list_view" >
            <?php   
                echo wpestate_strip_excerpt_by_char(get_the_excerpt(),60,$post->ID);
            ?>
        </div>   

        
    <?php
    }else{
    ?>
        

        <div class="listing_details the_list_view">
            <?php
                echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
            ?>
        </div>
<?php } ?>   
