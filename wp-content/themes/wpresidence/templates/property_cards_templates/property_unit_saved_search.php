<?php
$propId   =get_the_ID();
 
$property_size      =   wpestate_get_converted_measure( $propId, 'property_size' );
$property_bedrooms  =   get_post_meta($propId,'property_bedrooms',true);
$property_bathrooms =   get_post_meta($propId,'property_bathrooms',true); 
$wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$title              =   get_the_title();
$link               =   esc_url( get_permalink() );
$image              =   wpestate_return_property_card_thumb_email($propId,'slider_thumb');

?>
<div style="display:flex;margin-bottom: 10px;gap:10px;">
    <div style="max-width: 143px;">
        <a href="<?php echo esc_url($link); ?>" target="_blank">
            <img  style="max-width:143px;" src="<?php echo esc_url($image);  ?>" alt="image">
        </a>
    </div>
    <div style="width:100%;padding-left:10px;">
        <div style="width:100%;color: #718096;font-size:15px;"><?php  wpestate_show_price($propId,$wpestate_currency,$where_currency);  ?></div>
        <div style="width:100%;"><a href="<?php echo esc_url($link); ?>" target="_blank" style="font-size: 15px;font-weight: 600;color: #211465!important;text-decoration: none;"><?php echo esc_html($title);?></a></div>
        <div style="width:100%;display:flex;line-height:1em;gap:10px;">
            <?php 
                if($property_bedrooms!='' && $property_bedrooms!=0 ){
                    print '<div style="margin-right:10px;color: #718096;font-size:14px;">'.esc_html($property_bedrooms).' '.esc_html__('BD','wpresidence').'</div>';
                }
                if($property_bathrooms!='' && $property_bathrooms!=0 ){
                    print '<div style="margin-right:10px;color: #718096;font-size:14px;">'.esc_html($property_bathrooms).' '.esc_html__('BA','wpresidence').'</div>';
                }
              
            ?>
        </div>
    </div>
</div>