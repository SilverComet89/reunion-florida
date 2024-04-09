<?php
$order_class            =   ' order_filter_single ';  
$selected_order         =   esc_html__('Sort by','wpresidence');
$listing_filter         =   '';

if( is_tax() ){
    $listing_filter =  intval(wpresidence_get_option('wp_estate_property_list_type_tax_order',''));
}else if( isset($post->ID) ){
    if(is_page_template( 'advanced_search_results.php' ) ){
        $listing_filter =  intval(wpresidence_get_option('wp_estate_property_list_type_adv_order',''));
    }else{
        $listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
    }
}
  



$listing_filter_array   = wpestate_listings_sort_options_array();




$listings_list='';
$selected_order_num='';
foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.esc_html($key).'">'.esc_html($value).'</li>';//escaped above

    if($key==$listing_filter){
        $selected_order     =   $value;
        $selected_order_num =   $key;
    }
} 

?>

  
<div class="dropdown listing_filter_select order_filter <?php print esc_attr($order_class);?>">
    <div data-toggle="dropdown" id="a_filter_order" class="filter_menu_trigger" data-value="<?php echo esc_attr($selected_order_num);?>"> <?php echo esc_html($selected_order); ?> <span class="caret caret_filter"></span> </div>           
     <ul id="filter_order" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_order">
         <?php print trim($listings_list); ?>                   
     </ul>        
</div> 