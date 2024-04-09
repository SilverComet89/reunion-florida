 <?php
$property_address  =   esc_html( get_post_meta($post->ID, 'property_address', true) );
$property_address_show='';

if($property_address!=''){
    $property_address_show.= esc_html($property_address);
}

if($property_city!=''){
    if($property_address!=''){
        $property_address_show.= ', ';
    }
    $property_address_show.= wp_kses_post($property_city);
}

if($property_area!=''){
    if($property_address!='' || $property_city!=''){
        $property_address_show.= ', ';
    }
    $property_address_show.= wp_kses_post($property_area);
}
?>
<div class="property_categs">
    <i class="fas fa-map-marker-alt"></i>
    <?php print wp_kses_post($property_address_show); ?>
</div>