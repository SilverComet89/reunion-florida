<?php 
/*
$property_id=23010;
$all_metadata = get_post_meta($property_id);
//print_r($all_metadata);

$all_metadata_function = wpestate_get_property_metadata($property_id);
print_R($all_metadata_function );

*/


/*
*
*
*
*
*
*
*
*/
function wpestate_api_default_fields(){
    $return_array=array(
        'property_bathrooms'
    );

    return $return_array;
}























/*
*
*
*
*
*property_featured_sidebar
*
*
*/


function wpestate_api_return_property_fields_base($property_request){


    $property_id    =   $property_request['id'];
    $image_size     =   $property_request['image_size'];

    $property_fields_raw=array(
        'post_data'     =>  wpestate_api_return_property_fields_base_post_data($property_id),
        'default-fields'=>  wpestate_get_property_metadata($property_id,1),
        'media'         =>  wpestate_api_return_property_fields_media($property_id,$image_size),
        'custom-fields' =>  wpestate_api_return_property_fields_media($property_id,$image_size),
        'taxonomies'    =>  array(),
        'author'        =>  array(),
        

    );

    return $property_fields_raw;
}

/*
*
*  $fields = 0 - all fields (default and custom)
*  $fields = 1 - only default
*  $fields = 2 - only custom fields
*
*
*/


function wpestate_get_property_metadata($property_id,$fields=0){
    $return_data=array();
    $all_metadata = get_post_meta($property_id);

    //we load default fields when $fields is 0 or 1
    if($fields==1 || $fields==0 ){
        $fields=wpestate_api_default_fields_for_property();
        foreach($fields as $key=>$value):
            if(isset($all_metadata[$value])){
                $temp_array=$all_metadata[$value];
                $return_data[$value]=array_pop($temp_array);
            }else{
                $return_data[$value]='';
            }
        endforeach; 

        $return_data = wpestate_get_property_metadata_check_on($return_data);
    }

    //we load custom fields when $fields is 0 or 2
    if($fields==2 || $fields==0 ){
    
    }



    return $return_data;
}
/*
*
*
* Check on defualt fields
*
*
*
*
*/

function wpestate_get_property_metadata_check_on($default_fields){
    if($default_fields['property_bedrooms']!=''){
        $default_fields['property_bedrooms']=floatval($default_fields['property_bedrooms']);
    }

    if($default_fields['property_bathrooms']!=''){
        $default_fields['property_bathrooms']=floatval($default_fields['property_bedrooms']);
    }

    if($default_fields['prop_featured']!=''){
        $default_fields['prop_featured']=floatval($default_fields['prop_featured']);
    }

    $default_fields['property_size']=wpestate_get_converted_measure2($default_fields['property_size']);

    $default_fields['property_price']=floatval( $default_fields['property_price']);


    // price adjustment
    $price_label        =   '<span class="price_label">'.esc_html (  $default_fields['property_label'] ).'</span>';
    $price_label_before =   '<span class="price_label price_label_before">'.esc_html (  $default_fields['property_label_before'] ).'</span>';

    if ( $default_fields['property_price'] != 0) {
        $default_fields['property_price_formated'] = wpestate_show_price2( $default_fields['property_price'],$price_label,$price_label_before) ; 
    }else{
        $default_fields['property_price_formated']=$price_label_before.$price_label;
    }




    return $default_fields;
}





/*
*
*
*
*
*
*
*
*/
function wpestate_api_return_property_fields_media($property_id,$image_size){
    $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_featured_sidebar');
    if($preview[0]==''){
        $preview_image= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
    }else{
        $preview_image=$preview[0];
    }


    $all_media['thumb']=$preview_image;

    //should all all the media

    return $all_media;

}

/*
*
*
*
*
*
*
*
*/

function wpestate_api_return_property_fields_base_post_data($property_id){
    $all_post_data= (array)get_post($property_id);
    $unset_array=array(
        'comment_status',
        'ping_status',
        'post_password',
        'to_ping',
        'pinged',
        'post_content_filtered',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count',
        'filter'
    );
    
    foreach ($unset_array as $key):
        unset($all_post_data[$key]);
    endforeach;

    $all_post_data['permalink']=get_permalink($property_id);
    
    return $all_post_data;
}




/*
*
*
*
*
*
*
*
*/



function wpestate_api_default_fields_for_property(){
    $default_fields=array(
        'property_address',
        'property_zip',
        'property_state',
        'property_country',
        'property_status',
        'prop_featured',
        'property_price',
        'property_label',
        'property_label_before',
        'property_second_price_label',
        'property_second_price',
        'property_label_before_second_price',
        'property_year_tax',
        'property_hoa',
        'property_size',
        'property_lot_size',
        'property_rooms',
        'property_bedrooms',
        'property_bathrooms',
        'embed_video_type',
        'embed_video_id',
        'owner_notes',
        'property_latitude',
        'property_longitude',
        'property_google_view',
        'property_hide_map_marker',
        'google_camera_angle',
        'page_custom_zoom',
        'property_agent',
        'property_user',
        'property_agent_secondary',
        'use_floor_plans',
        'property_page_desing_local',
        'property_list_second_content',
	    'energy_class',
        'energy_index',
        'property_custom_video',
        'prop_featured',
        'property_agent'
    );
    return $default_fields;
}





if (!function_exists('wpestate_get_converted_measure2')):

    function wpestate_get_converted_measure2($size_value) {

       

        if ($size_value == '' || !$size_value) {
            return false;
        }
        $size_value = floatval($size_value);
        $measure_array = array(
            array('name' => esc_html__('feet', 'wpresidence'), 'unit' => esc_html__('ft', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('meters', 'wpresidence'), 'unit' => esc_html__('m', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('acres', 'wpresidence'), 'unit' => esc_html__('ac', 'wpresidence'), 'is_square' => 1),
            array('name' => esc_html__('yards', 'wpresidence'), 'unit' => esc_html__('yd', 'wpresidence'), 'is_square' => 0),
            array('name' => esc_html__('hectares', 'wpresidence'), 'unit' => esc_html__('ha', 'wpresidence'), 'is_square' => 1),
        );


        $recalculation_table = array(
            esc_html__('ft', 'wpresidence') . esc_html__('ft', 'wpresidence') => 1,
            esc_html__('ft', 'wpresidence') . esc_html__('m', 'wpresidence') => 0.092903,
            esc_html__('ft', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000022957,
            esc_html__('ft', 'wpresidence') . esc_html__('yd', 'wpresidence') => 0.111111,
            esc_html__('ft', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.0000092903,
            esc_html__('m', 'wpresidence') . esc_html__('m', 'wpresidence') => 1,
            esc_html__('m', 'wpresidence') . esc_html__('ft', 'wpresidence') => 10.7639,
            esc_html__('m', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000247105,
            esc_html__('m', 'wpresidence') . esc_html__('yd', 'wpresidence') => 1.19599,
            esc_html__('m', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.0001,
            esc_html__('ac', 'wpresidence') . esc_html__('ac', 'wpresidence') => 1,
            esc_html__('ac', 'wpresidence') . esc_html__('ft', 'wpresidence') => 43560,
            esc_html__('ac', 'wpresidence') . esc_html__('m', 'wpresidence') => 4046.86,
            esc_html__('ac', 'wpresidence') . esc_html__('yd', 'wpresidence') => 4840,
            esc_html__('ac', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.404686,
            esc_html__('yd', 'wpresidence') . esc_html__('yd', 'wpresidence') => 1,
            esc_html__('yd', 'wpresidence') . esc_html__('ft', 'wpresidence') => 9,
            esc_html__('yd', 'wpresidence') . esc_html__('m', 'wpresidence') => 0.836127,
            esc_html__('yd', 'wpresidence') . esc_html__('ac', 'wpresidence') => 0.000206612,
            esc_html__('yd', 'wpresidence') . esc_html__('ha', 'wpresidence') => 0.000083613,
            esc_html__('ha', 'wpresidence') . esc_html__('ha', 'wpresidence') => 1,
            esc_html__('ha', 'wpresidence') . esc_html__('ft', 'wpresidence') => 107639,
            esc_html__('ha', 'wpresidence') . esc_html__('m', 'wpresidence') => 10000,
            esc_html__('ha', 'wpresidence') . esc_html__('ac', 'wpresidence') => 2.47105,
            esc_html__('ha', 'wpresidence') . esc_html__('yd', 'wpresidence') => 11959.9,
        );


        $basic_measure = esc_html(wpresidence_get_option('wp_estate_measure_sys', ''));
        if (isset($_COOKIE['my_measure_unit'])) {
            $selected_measure = esc_html($_COOKIE['my_measure_unit']);
        } else {
            $selected_measure = $basic_measure;
        }

        // getting unit
        $measure_unit = '';
        foreach ($measure_array as $single_unit) {
            if ($single_unit['unit'] == $selected_measure) {
                if ($single_unit['is_square'] === 1) {
                    $measure_unit = $single_unit['unit'];
                } else {
                    $measure_unit = $single_unit['unit'] . '<sup>2</sup>';
                }
            }
        }
        if (isset($recalculation_table[$basic_measure . $selected_measure])) {
            $size_value = $size_value * $recalculation_table[$basic_measure . $selected_measure];
        }

        $size_value = wpestate_property_size_number_format($size_value);

        return $size_value . ' ' . $measure_unit;
    }

endif;



/**
 *
 * FUnction to display price all over the tempalte
 *
 *
 *
 */
if (!function_exists('wpestate_show_price2')):

    function wpestate_show_price2( $price,$price_label,$price_label_before,$second='no') {
       $post_id='';
        $wpestate_currency       =   esc_html ( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency          =   esc_html ( wpresidence_get_option('wp_estate_where_currency_symbol', '') );


        if($second=='yes'){
            $price_label = '<span class="price_label">' . esc_html(get_post_meta($post_id, 'property_second_price_label', true)) . '</span>';
            $price_label_before = get_post_meta($post_id, 'property_label_before_second_price', true);
            if ($price_label_before != '') {
                $price_label_before = '<span class="price_label price_label_before">' . esc_html($price_label_before) . '</span>';
            }
            $price = floatval(get_post_meta($post_id, 'property_second_price', true));
        }



        $th_separator   = stripslashes(wpresidence_get_option('wp_estate_prices_th_separator', ''));
        $custom_fields  = wpresidence_get_option('wp_estate_multi_curr', '');

        if (!empty($custom_fields) && isset($_COOKIE['my_custom_curr']) && isset($_COOKIE['my_custom_curr_pos']) && isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos'] != -1) {
            $i = intval($_COOKIE['my_custom_curr_pos']);
            $custom_fields = wpresidence_get_option('wp_estate_multi_curr', '');
            if ($price != 0) {

                $price = $price * $custom_fields[$i][2];
                $price = wpestate_format_number_price($price, $th_separator);
                $wpestate_currency = $custom_fields[$i][0];

                if ($custom_fields[$i][3] == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        } else {
            if ($price != 0) {
                $price = wpestate_format_number_price($price, $th_separator);
                if ($where_currency == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        }



        
        return trim($price_label_before . ' ' . $price . ' ' . $price_label);
        
    }

endif;

?>