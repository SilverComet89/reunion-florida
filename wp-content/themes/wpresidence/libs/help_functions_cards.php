<?php
/**
*
*
* Unit selector agents
*
*
*/
if(!function_exists('wpestate_agent_card_selector')):
    function wpestate_agent_card_selector($agent_unit_card_from_shortcode='') {
        
        $template = 'agent_unit.php';

        if( intval($agent_unit_card_from_shortcode)!=0){
            $agent_unit_card = intval($agent_unit_card_from_shortcode);
        }else{
            $agent_unit_card  = intval(wpresidence_get_option('wp_estate_agent_unit_card', ''));         
        }
      

        switch ($agent_unit_card) {
            case 1:
                $template = 'agent_unit.php';
                break;
            case 2:
                $template = 'agent_unit_elementor.php';
                break;
            case 3:
                $template = 'agent_unit_featured.php';
                break;
            case 4:
                $template = 'agent_unit_4.php';
                break;
        }


        return 'templates/agent_card_templates/'.$template;

    }
endif;



/**
*
*
* Unit selector blog
*
*
*/
if(!function_exists('wpestate_places_card_selector')):
    function wpestate_places_card_selector($place_type,$is_grid=0) {
        
        
        if($is_grid==1){
            if($place_type==1){
                $template = 'places_unit_elementor.php';
            }else if($place_type==2){
                $template = 'places_unit_type2_elementor.php';  
            } else if($place_type==3){
                $template = 'places_unit_type3_elementor.php';  
            }
        }else{
            if($place_type==1){
                $template = 'places_unit.php';
            }else if($place_type==2){
                $template = 'places_unit_type2.php';
            }else if($place_type==3){
                $template = 'places_unit_type3.php';
            }else if($place_type==4){
                $template = 'places_unit_type3_elementor.php';  
            }
            
        }

        return 'templates/places_card_templates/'.$template;

    }
endif;



/**
*
*
* Unit selector blog
*
*
*/

if(!function_exists('wpestate_blog_unit_selector')):
    function wpestate_blog_unit_selector($version_from_shortcode_array = '') {
        $template= 'blog_unit2.php'; // Default fallback value

        if (is_array($version_from_shortcode_array) && isset($version_from_shortcode_array['card_version']) && $version_from_shortcode_array['card_version'] !== '') {
            $version_from_shortcode = intval($version_from_shortcode_array['card_version']);

            if ($version_from_shortcode === 1) {
                $template= 'blog_unit.php';
            } elseif ($version_from_shortcode === 2) {
                $template= 'blog_unit2.php';
            } elseif ($version_from_shortcode === 3) {
                $template= 'blog_unit3.php';
            } elseif ($version_from_shortcode === 4) {
                $template= 'blog_unit4.php';
            }
        } else {
              $blog_unit = intval(wpresidence_get_option('wp_estate_blog_unit_card', ''));

            if ($blog_unit === 'list') {
                $template= 'blog_unit.php';
            } elseif ($blog_unit === 'grid2') {
                $template= 'blog_unit3.php';
            }elseif ($blog_unit === 1) {
                $template= 'blog_unit.php';
            } elseif ($blog_unit === 2) {
                $template= 'blog_unit2.php';
            } elseif ($blog_unit === 3) {
                $template= 'blog_unit3.php';
            } elseif ($blog_unit === 4) {
                $template= 'blog_unit4.php';
            }
        }

     
    return 'templates/blog_card_templates/'.$template;
}   
endif;


/**
*
*
* Return sorting options for listings
*
*
*/
if(!function_exists('wpestate_listings_sort_options_array')):
function wpestate_listings_sort_options_array(){

    $listing_filter_array=array(
        "1"=>esc_html__('Price High to Low','wpresidence'),
        "2"=>esc_html__('Price Low to High','wpresidence'),
        "3"=>esc_html__('Newest first','wpresidence'),
        "4"=>esc_html__('Oldest first','wpresidence'),
        "11"=>esc_html__('Newest Edited','wpresidence'),
        "12"=>esc_html__('Oldest Edited ','wpresidence'),
        "5"=>esc_html__('Bedrooms High to Low','wpresidence'),
        "6"=>esc_html__('Bedrooms Low to high','wpresidence'),
        "7"=>esc_html__('Bathrooms High to Low','wpresidence'),
        "8"=>esc_html__('Bathrooms Low to high','wpresidence'),
        "0"=>esc_html__('Default','wpresidence')
    );
    return $listing_filter_array;
}
endif;

/**
*
*
*
* 
*
*/




if(!function_exists('wpestate_return_unit_class')):
    function wpestate_return_unit_class ($wpestate_no_listins_per_row,$content_class,$align,$is_shortcode,$row_number_col,$wpestate_property_unit_slider){
        $wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );

        if($wpestate_no_listins_per_row==3){
            $col_class  =   'col-md-6';
            $col_org    =   6;
        }else{
            $col_class  =   'col-md-4';
            $col_org    =   4;
        }



        if($content_class=='col-md-12' ){
            if($wpestate_no_listins_per_row==3){
                $col_class  =   'col-md-4';
                $col_org    =   4;
            }else if($wpestate_no_listins_per_row==2){
                $col_class  =   'col-md-6';
                $col_org    =   6;
            }else{
                $col_class  =   'col-md-3';
                $col_org    =   3;
            }

        }


        // if template is vertical
        if($align=='col-md-12'){
            $col_class  =  'col-md-12';
           // $col_org    =  12;
             if($wpestate_no_listins_per_row==3){
            
                $col_org    =   4;
            }else if($wpestate_no_listins_per_row==2){
               
                $col_org    =   6;
            }else{
              
                $col_org    =   3;
            }
        }


        if(isset($is_shortcode) && $is_shortcode==1 ){
            $col_class='col-md-'.$row_number_col.' shortcode-col';
        }

        if(isset($is_col_md_12) && $is_col_md_12==1){
            $col_class  =   'col-md-6';
            $col_org    =   6;
        }

        if(isset($wpestate_prop_unit) && $wpestate_prop_unit=='list' && !isset($is_shortcode)){
            $col_class= 'col-md-12';

        }


        if( $wpestate_property_unit_slider==1){
            $col_class.=' has_prop_slider ';
        }


        if($wpestate_no_listins_per_row==4){
            $col_class.=' has_4per_row ';
        }


        $return_array=array(
                    'col_class' =>  $col_class,
                    'col_org'   =>  $col_org,
                );


    return $return_array;
}
endif;




if( !function_exists('wpestate_interior_classes') ):
function wpestate_interior_classes($wpestate_uset_unit){
    $return='';
    if($wpestate_uset_unit==1) {
        $return= 'property_listing_custom_design';
    }
    return $return;
}
endif;





?>
