<?php
global $args;
global $wpestate_prop_unit;
$current_name      =   '';
$current_slug      =   '';
$listings_list     =   '';
$selected_order         = esc_html__('Sort by','wpresidence');
$listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
$listing_filter_array   = wpestate_listings_sort_options_array();


if( isset($_GET['order_search']) ){
    $listing_filter = intval($_GET['order_search']);
}
if(is_page_template( 'advanced_search_results.php' ) ){
    $listing_filter =  intval(wpresidence_get_option('wp_estate_property_list_type_adv_order',''));
}

foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.esc_attr($key).'">'.esc_html($value).'</li>';//escped above

    if($key==$listing_filter){
        $selected_order=$value;
    }
}   

$order_class=' order_filter_single ';  

?>


    <div class="adv_listing_filters_head advanced_filters"> 
        <input type="hidden" id="page_idx" value="<?php print intval($post->ID);?>">
        <input type="hidden" id="searcharg" value='<?php echo json_encode ($args); ?>'>
        <?php
        $ajax_nonce = wp_create_nonce( "wpestate_search_nonce" );
        print'<input type="hidden" id="wpestate_search_nonce" value="'.esc_html($ajax_nonce).'" />    ';
        ?>
        
        <div class="dropdown listing_filter_select order_filter <?php print esc_attr($order_class);?>">
             <div data-toggle="dropdown" id="a_filter_order" class="filter_menu_trigger" data-value="1"> <?php print esc_html($selected_order); ?> <span class="caret caret_filter"></span> </div>           
             <ul id="filter_order" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_order">
                 <?php print trim($listings_list); ?>                   
             </ul>        
        </div> 


        <?php
        $prop_unit_grid_class    =   'icon_selected';
        $prop_unit_list_class    =    "";
        if($wpestate_prop_unit=='list'){
            $prop_unit_grid_class="";
            $prop_unit_list_class="icon_selected";
        }

        ?>    
        
        <div class="listing_filter_select listing_filter_views">
            <div id="grid_view" class="<?php echo esc_html($prop_unit_grid_class); ?>"> 
            <i class="fa-solid fa-grip-vertical"></i>
            </div>
        </div>

        <div class="listing_filter_select listing_filter_views">
             <div id="list_view" class="<?php echo esc_html($prop_unit_list_class); ?>">
                <i class="fas fa-bars"></i>                  
             </div>
        </div>
        
    </div>  