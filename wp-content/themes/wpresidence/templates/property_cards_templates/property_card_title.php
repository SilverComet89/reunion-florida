<?php

$allowed_html=array(
  'br'        =>  array(),
  'em'        =>  array(),
  'strong'    =>  array(),
  'b'        =>  array(),
  
);


$title           = wpestate_return_property_card_title($post->ID);
$link            = get_permalink();
$new_page_option = wpresidence_get_option('wp_estate_unit_card_new_page', '');
$target = $new_page_option === '_self' ? '' : 'target="' . esc_attr($new_page_option) . '"';
?>
<h4>
  <a href="<?php echo esc_url($link); ?>" <?php echo $target; ?>><?php echo  wp_kses( $title,$allowed_html); ?></a>
</h4>
