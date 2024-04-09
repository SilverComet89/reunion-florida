<?php
/*
*
* Return card content
*
*/
if(!function_exists('wpestate_card7_call_content')):
    function wpestate_card7_call_content($postID,$realtor_details ){
        $wp_estate_call_text_unit7= wpresidence_get_option('wp_estate_call_text_unit7','');
        $replace=array(
            'property_id'                =>  $postID,
            'title'             =>  get_the_title($postID),
            'realtor_name'      =>  $realtor_details['realtor_name'],
            'realtor_phone'     =>  $realtor_details['realtor_phone'],
            'realtor_mobile'    =>  $realtor_details['realtor_mobile'],
            
        );


        foreach($replace as $key=>$value):
            $wp_estate_call_text_unit7=str_replace('%'.$key, $value,$wp_estate_call_text_unit7);
        endforeach;

        return  $wp_estate_call_text_unit7;


    }
endif;


/*
*
* Return card content
*
*/

if(!function_exists('wpestate_return_property_card_content')):
    function wpestate_return_property_card_content($postID,$unit_type=''){
        $wp_estate_property_card_rows = wpresidence_get_option('wp_estate_property_card_rows', '');

     

        unset($wp_estate_property_card_rows['enabled'] ['placebo']);
        unset($wp_estate_property_card_rows['disabled'] ['placebo']);
        foreach ($wp_estate_property_card_rows['enabled'] as $key=>$value):
            switch ($key) {
                case 'title':
                    get_template_part('templates/property_cards_templates/property_card_title'); 
                    break;
                
                case 'price':
                    get_template_part('templates/property_cards_templates/property_card_price');
                    break;

                case 'excerpt':
                    get_template_part('templates/property_cards_templates/property_card_content');
                    break;   

                case 'details':
                    print  wpestate_return_property_card_details($postID);
                    break;

                case 'address':
                    print wpestate_return_property_card_address($postID);
                    break;
                        
                case 'categories':
                    print  wpestate_return_property_card_categories($postID);
                    break;

                case 'contact':
                    if($unit_type!==7):
                        get_template_part('templates/property_cards_templates/property_card_contact');
                    endif;
                    break;
                
                case 'mlsdata':
                        print  wpestate_return_property_card_mls_data($postID);
                        break;    
                    
                    
            }
        endforeach;



    }
endif;



/*
*
* Return card details content
*
*/

if(!function_exists('wpestate_return_property_card_details')):
    function wpestate_return_property_card_details($postID,$unit_type=''){
        $wp_estate_property_card_rows_details = wpresidence_get_option('wp_estate_property_card_rows_details', '');
      

        $return_string = '<div class="property_listing_details_v2">';

        $i=0;
        while($i<5):
        
            if( $wp_estate_property_card_rows_details['unit_field_value'][$i] !='none' ){
          

                $value_to_show = wpestate_return_property_card_details_value_to_show($wp_estate_property_card_rows_details['unit_field_value'][$i],$postID);

                if($value_to_show!='' || ( is_numeric($value_to_show) && $value_to_show!=0)  ){
                    $return_string .= '<div class="property_listing_details_v2_item">';
                        $return_string .= '<div class="icon_label">';
                            if( $wp_estate_property_card_rows_details['property_unit_field_name'][$i]!=''   ){
                                $return_string .=   esc_html( $wp_estate_property_card_rows_details['property_unit_field_name'][$i] );
                            }else{
                                if(  $wp_estate_property_card_rows_details['property_unit_field_icon'][$i]!='' ){
                                    $return_string .=  '<i class="'.esc_attr($wp_estate_property_card_rows_details['property_unit_field_icon'][$i] ).'"></i>';
                                }else if( $wp_estate_property_card_rows_details['property_unit_field_image'][$i]!='' ){
                                    $return_string .= '<img src="'. $wp_estate_property_card_rows_details['property_unit_field_image'][$i].'" >'; 
                                }
                            }  
                        $return_string .= '</div>';
                        $return_string .=  $value_to_show;
                    $return_string .= '</div>';
                }



            }

       
            $i++;
        endwhile;

        $return_string .= '</div>';

        return $return_string;
    }
endif;







/*
*
* Return detail value
*
*/

if(!function_exists('wpestate_return_property_card_details_value_to_show')):
    function wpestate_return_property_card_details_value_to_show($field,$postID){

        $value='';
        if(
            $field=='property_category' ||
            $field=='property_action_category' ||
            $field=='property_city' ||
            $field=='property_area' ||
            $field=='property_county_state' ||
            $field=='property_status'   ){
                $value = get_the_term_list($postID, $field, '', ', ', '');

        }else if(     
            $field=='property_size' ||
            $field=='property_lot_size'  ){
            $value = wpestate_get_converted_measure( $postID,$field );

        }else{
            $value = get_post_meta($postID, $field, true);         
        }

        return $value;
    }
endif;






/*
*
* Return address field
*
*/

if(!function_exists('wpestate_return_property_card_address')):
    function wpestate_return_property_card_address($postID){
        $wp_estate_property_card_rows_address = wpresidence_get_option('wp_estate_property_card_rows_address', '');

        unset($wp_estate_property_card_rows_address['enabled']['placebo']);
        $address_to_show    =   '';
        $separator          =   ', ';

      
        foreach ( $wp_estate_property_card_rows_address['enabled'] as $key=>$value ):
            switch ($key) {
                case 'property_address':
                    $property_address   =   get_post_meta($postID,'property_address',true);
                    if($property_address!=''){
                        $address_to_show    =   $address_to_show.$property_address.$separator;
                    }
                    break;                
                
                case 'property_country':
                    $property_country   =   get_post_meta($postID,'property_country',true);
                    if($property_country!=''){
                        $address_to_show    =   $address_to_show.$property_country.$separator;
                    }
                   
                    break; 

                case 'property_zip':                 
                    $property_zip   =   get_post_meta($postID,'property_zip',true);
                    if($property_zip!=''){
                        $address_to_show    =   $address_to_show.$property_zip.$separator;
                    }
                    break;                

                case 'property_city':
                    $property_city      =   get_the_term_list($postID, 'property_city', '', ', ', '') ;
                    if( $property_city !=''){
                        $address_to_show    =   $address_to_show.$property_city.$separator;
                    }
                    break;
                
                case 'property_county_state':
                    $property_county_state      =   get_the_term_list($postID, 'property_county_state', '', ', ', '') ;
                    if($property_county_state!=''){
                        $address_to_show            =   $address_to_show.$property_county_state.$separator;
                    }
                    break;
                
                case 'property_area':
                    $property_area      =   get_the_term_list($postID, 'property_area', '', ', ', '');
                    if($property_area!=''){
                        $address_to_show    =   $address_to_show.$property_area.$separator;
                    }                   
                    break;
            }

        endforeach;

        $return_address_to_show='<div class="property_card_categories_wrapper">'.rtrim($address_to_show,$separator).'</div>';
        return $return_address_to_show;


    }
endif;



/*
*
* Return categories 
*
*/


if(!function_exists('wpestate_return_property_card_categories')):
    function wpestate_return_property_card_categories($postID,$separator_type=''){
        $wp_estate_property_card_rows_categories = wpresidence_get_option('wp_estate_property_card_rows_categories', '');
    
        unset($wp_estate_property_card_rows_categories['enabled']['placebo']);
        $categories_to_show    =   '';
        $separator          =   ', ';
        if($separator_type==1){
            $separator          =   ' '.trim('&#183;').' ';
        }


        foreach ( $wp_estate_property_card_rows_categories['enabled'] as $key=>$value ):
            switch ($key) {
                case 'property_category':
                    $property_category      =   get_the_term_list($postID, 'property_category', '', $separator, '');
                    if($property_category!=''){
                        $categories_to_show    =   $categories_to_show.$property_category.$separator;
                    }                   
                    break;

                case 'property_action_category':
                    $property_action_category      =   get_the_term_list($postID, 'property_action_category', '', $separator, '');
                    if($property_action_category!=''){
                        $categories_to_show    =   $categories_to_show.$property_action_category.$separator;
                    }                   
                    break;

                case 'property_status':
                    $property_status      =   get_the_term_list($postID, 'property_status', '', $separator, '');
                    if($property_status!=''){
                        $categories_to_show    =   $categories_to_show.$property_status.$separator;
                    }                   
                    break;


            }
        endforeach;    

        $return_categories_to_show='<div class="property_card_categories_wrapper">'.rtrim($categories_to_show,$separator).'</div>';
        return $return_categories_to_show;
    }
endif;

/*
*
* Return mls data 
*
*/


if(!function_exists('wpestate_return_property_card_mls_data')):
    function wpestate_return_property_card_mls_data(){
        $return_string= '<div class="wpestate_property_card_mls_data_wrapper">';
        $mls_logo   = wpresidence_get_option('wp_estate_property_card_rows_mls_logo', 'url');
        $mls_name   = wpresidence_get_option('wp_estate_property_card_rows_mls_name', '');
        if($mls_logo!==''){
            $return_string.='<img src="'.esc_attr($mls_logo).'" alt="mls_logo">';
        }
        if($mls_name!=''){
            $return_string.=esc_html($mls_name);
        }

        $return_string.='</div>';

        return $return_string;
    }
endif;

/*
*
* Return card unit title
*
*/

if(!function_exists('wpestate_return_property_card_title')):
    function wpestate_return_property_card_title($postID){
        $title           = get_the_title($postID);
        $title_length   = mb_strlen($title);
        $substr_value   = intval(wpresidence_get_option('wp_estate_unit_card_title', ''));
        $display_title = $substr_value > 0 ? mb_substr($title, 0, $substr_value) . ($title_length > $substr_value ? '...' : '') : esc_html($title);

        return $display_title;
    }
endif;



/*
*
* Return card unit thumb
* 
*/
if(!function_exists('wpestate_return_property_card_thumb')):
    function wpestate_return_property_card_thumb($postID,$size='property_listings'){
        $preview_src    =   '';
        $preview        =    wp_get_attachment_image_src($postID, 'property_listings');
        if(isset($preview[0])){
            $preview_src=$preview[0];
        }

        $extra= array(
            'data-original' =>  $preview_src,
            'class'         =>  'lazyload img-responsive',
        );

        
        $thumb_prop             =   get_the_post_thumbnail($postID, $size,$extra);
        if($thumb_prop ==''){
            $thumb_prop_default =  wpresidence_get_option('wp_estate_prop_list_slider_image_palceholder','url');
            if($thumb_prop_default==''){
                $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_property_listings.jpg');
            }
            
            $thumb_prop         =  '<img src="'.esc_url($thumb_prop_default).'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="'.esc_html__('user image','wpresidence').'" />';
        }
        
        return $thumb_prop;
    }
endif;





/*
*
* Return card unit main image
* 
*/
if(!function_exists('wpestate_return_property_card_main_image')):
    function wpestate_return_property_card_main_image($postID,$size='property_listings'){
        $main_image     =   wp_get_attachment_image_src(get_post_thumbnail_id($postID), 'listing_full_slider');
        if(isset( $main_image [0] )){
            return $main_image[0];
        }else{
            $thumb_prop_default =  wpresidence_get_option('wp_estate_prop_list_slider_image_palceholder','url');
            if($thumb_prop_default==''){
                $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_property_listings.jpg');
            }
            return $thumb_prop_default;
        }
    }
endif;
    
if(!function_exists('wpestate_return_property_card_thumb_email')):
    function wpestate_return_property_card_thumb_email($postID,$size='property_listings'){
        $main_image     =   wp_get_attachment_image_src(get_post_thumbnail_id($postID), $size);
        if(isset( $main_image [0] )){
            return $main_image[0];
        }else{
            $thumb_prop_default =  wpresidence_get_option('wp_estate_prop_list_slider_image_palceholder','url');
            if($thumb_prop_default==''){
                $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_property_listings.jpg');
            }
            return $thumb_prop_default;
        }
    }
endif;
    


?>
