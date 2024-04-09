<?php
$price                  =   floatval ( get_post_meta($post->ID, 'property_price', true) );
$price_label            =   esc_html ( get_post_meta($post->ID, 'property_label', true) );
$price_label_before     =   esc_html ( get_post_meta($post->ID, 'property_label_before', true) );
if ($price != 0) {
    $price = wpestate_show_price(get_the_ID(),$wpestate_currency,$where_currency,1);
}else{
    $price='<span class="price_label price_label_before">'.esc_html($price_label_before).'</span><span class="price_label ">'.esc_html($price_label).'</span>';
}

$property_second_price                  =   floatval ( get_post_meta($post->ID, 'property_second_price', true) );
$property_second_price_label            =   esc_html ( get_post_meta($post->ID, 'property_second_price_label', true) );
$property_label_before_second_price     =   esc_html ( get_post_meta($post->ID, 'property_label_before_second_price', true) );
if ($property_second_price != 0) {
    $property_second_price = wpestate_show_price(get_the_ID(),$wpestate_currency,$where_currency,1,"yes");
}else{
    $property_second_price='<span class="price_label price_label_before">'.esc_html($property_label_before_second_price).'</span><span class="price_label ">'.esc_html($property_second_price_label).'</span>';
}



?>


<div class="single_property_labels">
    <?php
        print '<div class="property_title_label">'.wp_kses_post($property_action).'</div>';
        print '<div class="property_title_label actioncat">'.wp_kses_post($property_category).'</div>';
    ?>
</div>

<h1 class="entry-title entry-prop"><?php the_title(); ?></h1>

<div class="price_area">
<div class="second_price_area"><?php print wp_kses_post($property_second_price); ?></div>    
<?php print wp_kses_post($price); ?></div>
