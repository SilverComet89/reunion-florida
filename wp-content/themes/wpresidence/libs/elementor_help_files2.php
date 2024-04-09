<?php
/*
*
*
*
*/
if(!function_exists('wpestate_show_dropdown_taxonomy_v21')):
function wpestate_show_dropdown_taxonomy_v21($search_field, $label, $appendix,$active='') {
    $field_options = [
        'categories' => [
            'option_name' => 'wp_estate_categ_select_list_multiple', 
            'select_list_function' => 'wpestate_get_category_select_list',
            'term' => 'property_category', 
            'default_label' => esc_html__('Categories','wpresidence'),
            'ul_id'=>'categlist',
            'toogle_id'=>'adv_categ',
            'get_var'=>'filter_search_type'
        ],
        'types' => [
            'option_name' => 'wp_estate_action_select_list_multiple', 
            'select_list_function' => 'wpestate_get_action_select_list',
            'term' => 'property_action_category', 
            'default_label' => esc_html__('Types','wpresidence'),
            'ul_id'=>'actionslist',
            'toogle_id'=>'adv_actions',
            'get_var'=>'filter_search_action'
        ],
        'cities' => [
            'option_name' => 'wp_estate_city_select_list_multiple', 
            'select_list_function' => 'wpestate_get_city_select_list',
            'term' => 'property_city', 
            'default_label' => esc_html__('Cities','wpresidence'),
            'ul_id'=>'adv-search-city',
            'toogle_id'=>'advanced_city',
            'get_var'=>'advanced_city',
            'is_array' => false
        ],
        'areas' => [
            'option_name' => 'wp_estate_area_select_list_multiple', 
            'select_list_function' => 'wpestate_get_area_select_list',
            'term' => 'property_area', 
            'default_label' => esc_html__('Areas','wpresidence'),
            'ul_id'=>'adv-search-area',
            'toogle_id'=>'advanced_area',
            'get_var'=>'advanced_area',
            'is_array' => false
        ],
        'county / state' => [
            'option_name' => 'wp_estate_county_select_state_list_multiple', 
            'select_list_function' => 'wpestate_get_county_state_select_list',
            'term' => 'property_county_state', 
            'default_label' => esc_html__('States','wpresidence'),
            'ul_id'=>'adv-search-countystate',
            'toogle_id'=>'county-state',
            'get_var'=>'advanced_contystate',
            'is_array' => false
        ],
        'property status' => [
            'option_name' => 'wp_estate_status_select_list_multiple', 
            'select_list_function' => 'wpestate_get_status_select_list',
            'term' => 'property_status', 
            'default_label' => esc_html__('Status','wpresidence'),
            'ul_id'=>'statuslist',
            'toogle_id'=>'adv_status',
            'get_var'=>'property_status'
        ]
    ];

    $args                       =   wpestate_get_select_arguments();
    if (!array_key_exists($search_field, $field_options)) {
        return ''; // Return empty string if search field is not defined
    }

    $options        = $field_options[$search_field];
    $getField       = $options['get_var'];
    $term           = $options['term'];
    $optionName     = $options['option_name'];
    $defaultLabel   = $options['default_label'];
    $ulId           = $options['ul_id'];
    $toggleId       = $options['toogle_id'];

    $is_array = isset($options['is_array']) ? $options['is_array'] : true;

    $value = $value1 = 'all';
   
    $multiple_selected_values=null;
    
    if(isset($_GET[$getField]) && is_array( $_GET[$getField]) && $active=='active' ){
        $multiple_selected_values=wpestate_sanitize_text_array ($_GET[$getField]);
       
        if(isset($multiple_selected_values[0])){
            $full_name = get_term_by('slug', sanitize_text_field( $multiple_selected_values[0] ), $term);
            if($full_name){
                $value = $value1 = $full_name->name;
            }
        }

    }
        
     
    if( isset($_GET[$getField]) && !is_array( $_GET[$getField]) && trim($_GET[$getField]) != '' && $_GET[$getField] != 'all' && $active=='active') {
    

        $full_name = get_term_by('slug', sanitize_text_field($_GET[$getField]), $term);
        if( isset( $full_name->name)) {
            $value = $value1 = $full_name->name;
        }
       
    } else{
        $value = $label;
        if ($label == '') {
                $value =$defaultLabel;
        }

    }

    

    $value = $label == '' ? $defaultLabel : $label;
    $selectListFunc = $field_options[$search_field]['select_list_function'];

    if (wpresidence_get_option($optionName, '') == 'yes') {
        $select_list = wpestate_get_taxonomy_select_list_for_dropdown($args, $search_field, 'yes', 'maca',$multiple_selected_values);
        
        return wpestate_build_dropdown_multiple($appendix, $ulId, $toggleId, $value, $value1, $getField, $select_list);
    } else {
      
        $select_list = call_user_func($selectListFunc, $args);
  
        
        return  wpestate_build_dropdown_adv_new($appendix, $ulId, $toggleId, $value, $value1, $getField, $select_list,$active);
    }
}
endif;

/*
*
*
*
*/
function wpestate_search_generate_custom_field( $adv_search_what_key, $search_field,$label, $adv_search_label, $placeholder, $position, $slug, $allowed_html, $appendix, $item_field_how, $elementor_label,$key) {
    $custom_fields = wpresidence_get_option('wp_estate_custom_fields', '');
    $i = 0;
    $found_dropdown = 0;
    $return_string = '';


    if (!empty($custom_fields)) {
        while ($i < count($custom_fields)) {
            $name = $custom_fields[$i][0];
            $slug_drop = str_replace(' ', '-', $name);
           
           
        
            if (($slug_drop == $adv_search_what_key || $slug_drop == $search_field) && $custom_fields[$i][2] == 'dropdown') {
                $found_dropdown = 1;
                $front_name = '';
                if (isset($adv_search_label[$key])) {
                    $front_name = sanitize_title($adv_search_label[$key]);
                }

                if (function_exists('icl_translate')) {
                    if ($placeholder != '') {
                        $initial_key = apply_filters('wpml_translate_single_string', trim($placeholder), 'custom field value', 'custom_field_value' . $placeholder);
                    } else {
                        $initial_key = apply_filters('wpml_translate_single_string', trim($adv_search_label[$key]), 'custom field value', 'custom_field_value' . $adv_search_label[$key]);
                    }
                    $action_select_list = ' <li role="presentation" data-value="all"> ' . $initial_key . '</li>';
                } else {
                    if ($placeholder != '') {
                        $action_select_list = ' <li role="presentation" data-value="all">' . $placeholder . '</li>';
                    } else {
                        $action_select_list = ' <li role="presentation" data-value="all">';
                        if( isset($adv_search_label[$key] ) ){
                            $action_select_list .= $adv_search_label[$key] ;
                        }
                        $action_select_list .=  '</li>';
                    }
                }

                $dropdown_values_array = explode(',', $custom_fields[$i][4]);
                foreach ($dropdown_values_array as $drop_key => $value_drop) {
                    $original_value_drop = $value_drop;
                    if (function_exists('icl_translate')) {
                        $value_drop = apply_filters('wpml_translate_single_string', trim($value_drop), 'custom field value', 'custom_field_value' . $value_drop);
                    }
                    $action_select_list .= '<li role="presentation" data-value="' . trim(esc_attr($original_value_drop)) . '">' . trim($value_drop) . '</li>';
                }

                if ($placeholder != '') {
                    $front_name = wpestate_limit45(sanitize_title($elementor_label));
                }

                if (isset($_GET[$front_name]) && $_GET[$front_name] != '' && $_GET[$front_name] != 'all') {
                    $advanced_drop_value = esc_attr(wp_kses($_GET[$front_name], $allowed_html));
                    $advanced_drop_value1 = '';
                } else {
                    $advanced_drop_value = $label;
                    $advanced_drop_value1 = 'all';
                    if ($placeholder != '') {
                        $advanced_drop_value = $placeholder;
                    }
                }
                $front_name = wpestate_limit45($front_name);
                $return_string = wpestate_build_dropdown_adv($appendix, $front_name, $front_name, $advanced_drop_value, $advanced_drop_value1, $front_name, $action_select_list);
            }
            $i++;
        }
    }

    if ($found_dropdown == 0) {
        $return_string = '';
        if ($position == 'half') {
            $return_string .= '<div class="col-md-3">';
            $appendix = '';
        }

        if ($placeholder != '') {
            $label = $placeholder;
        }
        $return_string .= '<input type="text" id="' . wp_kses($appendix . $slug, $allowed_html) . '"  name="' . wp_kses($slug, $allowed_html) . '" placeholder="' . wp_kses($label, $allowed_html) . '" value="';
        if (isset($_GET[$slug])) {
            $return_string .= esc_attr($_GET[$slug]);
        }
        $return_string .= '" class="advanced_select form-control" >';

        if ($position == 'half') {
            $return_string .= '</div>';
        }

        if (isset($adv_search_how[$i]) || $item_field_how != '') {
            if (isset($adv_search_how[$i]) && ($adv_search_how[$i] == 'date bigger' || $adv_search_how[$i] == 'date smaller' || $item_field_how == 'date bigger' || $item_field_how == 'date smaller')) {
                wpestate_date_picker_translation($appendix . $slug);
            }
        }
    }

    return $return_string;
}

/*
*
*
*/


function wpestate_get_select_list($args, $is_multiple, $field_type, $placeholder) {
 
    $select_list = wpestate_get_taxonomy_select_list_for_dropdown($args,$field_type, $is_multiple,$placeholder);

    return $select_list;
}





/*
*
*
*
*/



function wpestate_build_dropdown_multiple($appendix,$ul_id,$toogle_id,$values,$values1,$get_var,$select_list,$active=''){
    $extraclass='';
    $caret_class='';
    $wrapper_class='';
    $return_string='';
    $is_half=0;
    $allowed_html =array();

   
    if($get_var=='advanced_categories'){
        $get_var='filter_search_type';
    }
    if($get_var=='advanced_types'){
        $get_var='filter_search_action';
    }


    switch ($appendix) {
        case 'half-':   
            $appendix = '';
            $is_half = 1;
            $return_string='<div class="col-md-3">';
            break;
    }
    $get_var_sanitized = sanitize_key($get_var);
    $adv_search_type    =   wpresidence_get_option('wp_estate_adv_search_type','');
    if($adv_search_type==6){
        $return_string='';
    }

    $live_search='';
    if( "yes" === wpresidence_get_option('wp_estate_select_list_multiple_show_search','') ){
        $live_search='data-live-search="true" ';
    }

    $return_string.='
    <select class="form-control selectpicker wpestate-selectpicker" multiple
        
        name="' . esc_attr($get_var_sanitized) . '[]"
        id="'.esc_attr($appendix.$toogle_id).'"
        title="'.esc_attr($values).'" 
        '.esc_html($live_search).'
        data-selected-text-format="count"
        data-count-Selected-Text="{0} '.esc_html__('items selected','wpresidence').'"
        data-select-all-text="'.esc_html__('Select All','wpresidence').'"
        data-deselect-all-text="'.esc_html__('Select None','wpresidence').'"
        data-actions-box="true"
        aria-labelledby="'.esc_attr($appendix.$toogle_id).'">
        '.$select_list.'
    </select>';
 
    if($is_half==1 && $adv_search_type!=6 ){
        $return_string.='</div>';
    }

    return $return_string;
}





/*
*
*      $taxonomy = 'property_action_category';
*
*/


function wpestate_get_taxonomy_select_list_for_dropdown($args,$field_type,$multiple,$placeholder,$multiple_selected_values) {
 

    $transient_appendix = '';
    if (defined('ICL_LANGUAGE_CODE')) {
        $transient_appendix .= '_' . ICL_LANGUAGE_CODE;
    }
    

    $field_options = [
        'categories' => [         
            'taxonomy' => 'property_category', 
            'label' => esc_html__('Categories', 'wpresidence')
        ],
        'types' => [          
            'taxonomy' => 'property_action_category', 
            'label' => esc_html__('Types', 'wpresidence')           
        ],
        'cities' => [         
            'taxonomy' => 'property_city', 
            'label' => esc_html__('Cities', 'wpresidence')
        ],
        'areas' => [
     
            'taxonomy' => 'property_area', 
            'label' => esc_html__('Areas', 'wpresidence')
        
        ],
        'county / state' => [
            'taxonomy' => 'property_county_state', 
            'label' => esc_html__('States', 'wpresidence')
          
        ],
        'property status' => [
            'taxonomy' => 'property_status', 
            'label' => esc_html__('Status', 'wpresidence')
          
        ]
    ];

 

    $taxonomy    =  $field_options[$field_type]['taxonomy'];
    $label       =  $field_options[$field_type]['label'];
    if($placeholder!=''){
        $label=$placeholder;
    }



    $selection_list = wpestate_request_transient_cache('wpestate_get_dropdown_multiple_select_list_'.$taxonomy.'_'.$transient_appendix);
    $selection_list =false;
    if ($selection_list === false) {
  
        $categories = get_terms($taxonomy, $args);

        $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
        $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');

        $label = wpestate_return_default_label($adv_search_what, $adv_search_label, 'types',$label);



      

        if($multiple=='yes'){
            //$selection_list = ' <option role="presentation" value="all" data-value="all">' . $label . '</option>';
        }else{
            $selection_list = ' <li role="presentation" data-value="all">' . $label . '</li>';
        }



        if (is_array($categories)) {
            foreach ($categories as $categ) {
                $received = wpestate_hierarchical_category_childen_v2($multiple_selected_values,$taxonomy,$multiple, $categ->term_id, $args);
                $counter = $categ->count;
                if (isset($received['count'])) {
                    $counter = $counter + $received['count'];
                }

             
                if($multiple=='yes'){

                    $parent_value = '';
                    if($field_type=='cities'){
                 
                        $term_meta = get_option("taxonomy_$categ->term_id");
                        if (isset($term_meta['stateparent'])) {
                            $parent_value = sanitize_title($term_meta['stateparent']) ;
                        }
                    }else if($field_type=='areas'){
                 
                        $term_meta = get_option("taxonomy_$categ->term_id");
                        if (isset($term_meta['cityparent'])) {
                          
                            $parent_value = sanitize_title($term_meta['cityparent']) ;
                        }
                    }


                    $selection_list .= '<option role="presentation" value="'. esc_attr($categ->slug).'" data-taxonomy="'.esc_attr($field_type).'" 
                                        data-parent-value="'.esc_attr($parent_value).'" data-value="'. esc_attr($categ->slug).'" ';
                    
                    if( is_array($multiple_selected_values) && in_array($categ->slug,$multiple_selected_values) ||
                        is_array($multiple_selected_values) && in_array(urldecode($categ->slug),$multiple_selected_values)                     
                    ){
                        $selection_list.= 'selected';
                    }
                    $selection_list.='>' . ucwords(urldecode($categ->name))  . '</option>';

                }else{
                    $selection_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '">' . ucwords(urldecode($categ->name)) . '</li>';
                }
               
               
               
               
                if (isset($received['html'])) {
                    $selection_list .= $received['html'];
                }
            }
        }
        wpestate_set_transient_cache('wpestate_get_dropdown_multiple_select_list_'.$taxonomy .'_'.$transient_appendix, $categories, 4 * 60 * 60);
    }
    return $selection_list;
}


/*
*
*
*
*/




if (!function_exists('wpestate_hierarchical_category_childen_v2')):

    function wpestate_hierarchical_category_childen_v2($multiple_selected_values,$taxonomy,$multiple, $cat, $args, $base = 1, $level = 1) {
        $level++;
        $args['parent'] = $cat;
        $children = get_terms($taxonomy, $args);
        $return_array = array();
        $total_main[$level] = 0;
        $children_categ_select_list = '';
        foreach ($children as $categ) {

            $area_addon = '';
            $city_addon = '';
            $county_addon='';

            if ($taxonomy == 'property_city') {

                $term_meta = get_option("taxonomy_$categ->term_id");

                $string_county = '';
                if (isset($term_meta['stateparent'])) {
                    $string_county = wpestate_limit45(sanitize_title($term_meta['stateparent']));
                }
                $slug_county = sanitize_key($string_county);


                $string = wpestate_limit45(sanitize_title($categ->slug));
                $slug = sanitize_key($string);
                $city_addon = '  data-parentcounty="' . esc_attr($slug_county) . '" data-value2="' . esc_attr($slug) . '" ';
            }

            if ($taxonomy == 'property_county_state') {

               

                $string = wpestate_limit45(sanitize_title($categ->slug));
                $slug = sanitize_key($string);
                $county_addon = '  data-value2="' . esc_attr($slug) . '" ';
            }



            if ($taxonomy == 'property_area') {
                $term_meta = get_option("taxonomy_$categ->term_id");
                $string = wpestate_limit45(sanitize_title($term_meta['cityparent']));
                $slug = sanitize_key($string);
                $area_addon = ' data-parentcity="' . esc_attr($slug) . '" ';
            }

            $hold_base = $base;
            $base_string = '';
            $base++;
            $hold_base = $base;

            if ($level == 2) {
                $base_string = '-';
            } else {
                $i = 2;
                $base_string = '';
                while ($i <= $level) {
                    $base_string .= '-';
                    $i++;
                }
            }


            if ($categ->parent != 0) {
                $received = wpestate_hierarchical_category_childen_v2($multiple_selected_values,$taxonomy, $multiple,$categ->term_id, $args, $base, $level);
            }


            $counter = $categ->count;
            if (isset($received['count'])) {
                $counter = $counter + $received['count'];
            }

            $children_categ_select_list .= '<option role="presentation" value="' . esc_attr($categ->slug) . '"   data-value="' . esc_attr($categ->slug) . '"  '.$county_addon.' '.$city_addon.' '.$area_addon;
            
            if( is_array($multiple_selected_values) && in_array($categ->slug,$multiple_selected_values) ||
            is_array($multiple_selected_values) && in_array(urldecode($categ->slug),$multiple_selected_values) ){
                $children_categ_select_list.= 'selected';
            }


            $children_categ_select_list .= '>' . $base_string . ' ' . ucwords(urldecode($categ->name)) . '</option>';

            if (isset($received['html'])) {
                $children_categ_select_list .= $received['html'];
            }

            $total_main[$level] = $total_main[$level] + $counter;

            $return_array['count'] = $counter;
            $return_array['html'] = $children_categ_select_list;
        }
        $return_array['count'] = $total_main[$level];


        return $return_array;
    }

endif;



/*
*
* Beds and bathh component markup
*
*/
if (!function_exists('wpestate_show_beds_baths_component')):

function wpestate_show_beds_baths_component($appendix, $placeholder, $elementor_label, $term_counter_elementor, $position,$active='') {
    $beds_values     = wpresidence_get_option('wp_estate_beds_component_values', '');
    $baths_values    = wpresidence_get_option('wp_estate_baths_component_values', '');
    $beds_selection  = wpestate_get_component_selection($beds_values, 'wp_estate_beds_component',$active);
    $baths_selection = wpestate_get_component_selection($baths_values, 'wp_estate_baths_component',$active);

    $default_value=esc_html__('Beds/Baths', 'wpresidence');
    if($placeholder!='') $default_value=$placeholder;

    $return_string='';
    $is_half=null;
    switch ($appendix) {
        case 'half-':   
            $appendix = '';
            $is_half = 1;
            $return_string='<div class="col-md-3">';
            break;
    }

    $adv_search_type    =   wpresidence_get_option('wp_estate_adv_search_type','');
    if($adv_search_type==6){
        $return_string='';
    }
    
    
    $componentsbeds='';
    $componentsbaths='';
    if($active=='active' && ( isset($_REQUEST['componentsbeds']) || isset($_REQUEST['componentsbaths']))  ){
        if( isset($_REQUEST['componentsbeds']) ){
            $componentsbeds  = floatval( $_REQUEST['componentsbeds'] );
        }

        if( isset($_REQUEST['componentsbaths']) ){
            $componentsbaths = floatval($_REQUEST['componentsbaths']);
        }       
        $default_value= floatval( $componentsbeds) .'+ '.esc_html__('bd','wpresidence').'/'.floatval($componentsbaths).'+ '.esc_html__('ba','wpresidence');
    }

  
    $componentsbeds_value ='';
    if(isset( $_REQUEST['componentsbeds'])){
        $componentsbeds_value =$_REQUEST['componentsbeds'];
    }
    $componentsbaths_value ='';
    if(isset( $_REQUEST['componentsbaths'])){
        $componentsbeds_value =$_REQUEST['componentsbaths'];
    }


    $return_string .= '
        <div class="btn-group  wpestate-beds-baths-popoup-component" style="width:100%;">
            <button type="button" class="btn btn-default dropdown-toggle wpestate-multiselect-custom-style" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%;">
                ' . esc_html($default_value) . '
                <span class="caret caret_filter "></span>
            </button>
            <div class="dropdown-menu wpestate-beds-baths-popoup-wrapper">
                <h3>' . esc_html('Beds', 'wpresidence') . '</h3>
                <div>' . $beds_selection . '</div>
                <h3>' . esc_html('Baths', 'wpresidence') . '</h3>
                <div>' . $baths_selection . '</div>
                <div>
                    <div  class="wpestate-beds-baths-popoup-reset" data-default-value="'.esc_attr($default_value).'">' . esc_html('Reset', 'wpresidence') . '</div>
                    <div  class="wpestate-beds-baths-popoup-done">' . esc_html('Done', 'wpresidence') . '</div>
                </div>
                <input type="hidden" name="componentsbeds"   class="wpresidence-componentsbeds"  value="'.esc_html( $componentsbeds_value).'">
                <input type="hidden" name="componentsbaths"  class="wpresidence-componentsbaths" value="'.esc_html ($componentsbaths_value).'">
            </div>
        </div>';

    if($is_half==1   && $adv_search_type!=6 ){
      
        $return_string.='</div>';
    }

    return $return_string;
}

endif;



/*
*
*
*
*/

if (!function_exists('wpestate_get_component_selection')):
function wpestate_get_component_selection($component_values, $class_prefix,$active) {
    $component_values_array = explode(',', $component_values);

  
 
    $component_selection = array_map(function($value) use ($class_prefix,$active) {
            $selected_class = '';

            if($active =='active'):
                if ($class_prefix === 'wp_estate_beds_component' && isset($_REQUEST['componentsbeds']) && $value == $_REQUEST['componentsbeds']) {
                    $selected_class = ' wp_estate_component_item_selected';
                } elseif ( $class_prefix === 'wp_estate_baths_component' && isset($_REQUEST['componentsbaths']) && $value == $_REQUEST['componentsbaths']) {
                    $selected_class = ' wp_estate_component_item_selected';
                }
            endif;

            return '<div class="' . esc_attr($class_prefix) . '_item' . $selected_class . '" data-value="' . floatval($value) . '">' . esc_html($value) . '</div>';
        }, $component_values_array);




    return implode('', $component_selection);
}
endif;





/*
*
*
*
*/
if (!function_exists('wpestate_show_price_v2_component')):
    function  wpestate_show_price_v2_component($appendix,$slug,$label,$placeholder,$elementor_label, $term_counter_elementor,$position,$price_array_data){
        $default_value=esc_html__('Price', 'wpresidence');
        if($placeholder!='') $default_value=$placeholder;
        if($label!='') $default_value=$label;
        $return_string='';
        $is_half=null;

        switch ($appendix) {
            case 'half-':   
                $appendix = '';
                $is_half = 1;
                $return_string='<div class="col-md-3">';
                break;
        }

        if(isset($_REQUEST['price_label_component']) && $_REQUEST['price_label_component']!=''  ){
            $default_value= sanitize_text_field( $_REQUEST['price_label_component'] );
        }

        if ( isset($price_array_data['term_id'])) {
            $label_name= 'price_label_component_'.$price_array_data['term_id'];
        }else{
            $label_name= 'price_label_component';
        }


        if(isset($_REQUEST[$label_name]) && $_REQUEST[$label_name]!=''  ){
            $default_value= sanitize_text_field( $_REQUEST[$label_name] );
        }


        $return_string.='
        <div class="btn-group wpestate-beds-baths-popoup-component" style="width:100%;">
            <button type="button" class="btn btn-default dropdown-toggle  wpestate-multiselect-custom-style" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-default-value="'.esc_attr($default_value).'" style="width:100%;">
            ' . esc_html($default_value) . '
            <span class="caret caret_filter "></span>
            </button>

            <div class="dropdown-menu wpestate-price-popoup-wrapper">
                <h3>' . esc_html('Price selector', 'wpresidence') . '</h3>';
        
                    if (is_array($price_array_data)) {
                        $return_string .=  wpestate_price_form_adv_search_with_tabs_elementor($position, $slug, $label, '', $price_array_data['term_id'], $price_array_data['term_slug'], $price_array_data['min_price'], $price_array_data['max_price'],'visible');
                    } else {
                        $return_string .=  wpestate_price_form_adv_search($position, $slug, $label,'visible');
                    }

                $return_string .='
                <div  class="wpestate-price-component-popoup-reset">' . esc_html('Reset', 'wpresidence') . '</div>
                <div  class="wpestate-price-component-popoup-done">' . esc_html('Done', 'wpresidence') . '</div>
            </div>
        </div>';

        if($is_half==1 ){
            // && $adv_search_type!=6
            $return_string.='</div>';
        }

        return $return_string;


    }
endif;





/*
*
*
*
*/
if (!function_exists('wpestate_show_price_v2_component_theme_search')):
    function  wpestate_show_price_v2_component_theme_search($position, $slug, $label, $use_name, $term_id, $adv6_taxonomy_terms, $adv6_min_price, $adv6_max_price,$is_tabs=''){
        $default_value=esc_html__('Price', 'wpresidence');
        if($label!='') $default_value=$label;




        if ($is_tabs=='yes') {
            $label_name= 'price_label_component_'.$term_id;
        }else{
            $label_name= 'price_label_component';
        }
        if(isset($_REQUEST[$label_name]) && $_REQUEST[$label_name]!=''  ){
            $default_value= sanitize_text_field( $_REQUEST[$label_name] );
        }



        $return_string='
        <div class="btn-group wpestate-beds-baths-popoup-component" style="width:100%;">
            <button type="button" class="btn btn-default dropdown-toggle  wpestate-multiselect-custom-style" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-default-value="'.esc_attr($default_value).'" style="width:100%;">
            ' . esc_html($default_value) . '
            <span class="caret caret_filter "></span>
            </button>

            <div class="dropdown-menu wpestate-price-popoup-wrapper">
                <h3>' . esc_html('Price selector', 'wpresidence') . '</h3>';
        
                    if ($is_tabs=='yes') {
                        $return_string .= wpestate_price_form_adv_search_with_tabs($position, $slug, $label, $use_name, $term_id, $adv6_taxonomy_terms, $adv6_min_price, $adv6_max_price,'visible');
                    } else {
                        $return_string .= wpestate_price_form_adv_search($position, $slug, $label);
                    }

                $return_string .='
                <div  class="wpestate-price-component-popoup-reset">' . esc_html('Reset', 'wpresidence') . '</div>
                <div  class="wpestate-price-component-popoup-done">' . esc_html('Done', 'wpresidence') . '</div>
            </div>
        </div>';


        return $return_string;


    }
endif;

/*
*
*
*
*/
if (!function_exists('wpestate_show_price_v3_component')):
    function  wpestate_show_price_v3_component($appendix,$slug,$label,$placeholder,$elementor_label, $term_counter_elementor,$position,$price_array_data){
        $default_value=esc_html__('Price', 'wpresidence');
        if($placeholder!='') $default_value=$placeholder;
        if($label!='') $default_value=$label;
        
        $original_value =$default_value;
        
        $string = '';
        if ($placeholder != '') {
            $string = wpestate_limit45(sanitize_title($elementor_label)); //is elementor
            $label = $placeholder;
        } else {
           // if (isset($adv_search_label[$key])) {
            //    $string = wpestate_limit45(sanitize_title($adv_search_label[$key]));
            //    $label = $adv_search_label[$key];
           // }
        }
        $slug = sanitize_key($string);

        $return_string='';
        $is_half=null;
        switch ($appendix) {
            case 'half-':   
                $appendix = '';
                $is_half = 1;
                $return_string='<div class="col-md-3">';
                break;
        }

        $adv_search_type    =   wpresidence_get_option('wp_estate_adv_search_type','');
        if($adv_search_type==6){
            $return_string='';
        }
        if( !isset( $price_array_data['term_id'] ) || intval(   $price_array_data['term_id']  )===0){
            $price_low_name   =   'price_low';
            $price_max_name   =   'price_max';
            $label_name       =    'price_label_component';
        }else{
            $price_low_name   =   'price_low_'. $price_array_data['term_id']  ;
            $price_max_name   =   'price_max_'. $price_array_data['term_id']  ;
            $label_name       =    'price_label_component_'.$price_array_data['term_id']  ;
        }

        $label_value='';
        if(isset($_REQUEST[$label_name]) && $_REQUEST[$label_name]!==''   ){
            $label_value=sanitize_text_field( $_REQUEST[$label_name] );
            if($label_value!=''){
                $default_value=$label_value;
            }
        }


        $return_string.='
        <div class="btn-group wpestate-beds-baths-popoup-component" style="width:100%;">
            <button type="button" class="btn btn-default dropdown-toggle  wpestate-multiselect-custom-style" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-default-value="'.esc_attr($default_value).'" style="width:100%;">
            ' . esc_html($default_value) . '
            <span class="caret caret_filter "></span>
            </button>

            <div class="dropdown-menu wpestate-price-popoup-wrapper_v3">
                <h3>' . esc_html('Price selector', 'wpresidence') . '</h3>';

                $return_string.='<div class="wpestate_pricev3_component_adv_search_wrapper">';
                    $return_string.=wpresidence_generate_2nlevel_dropdown(     $price_array_data['min_price_values'],$price_low_name,'wpresidence-component3-min-price' );  
                    $return_string.=wpresidence_generate_2nlevel_dropdown(     $price_array_data['max_price_values'],$price_max_name ,'wpresidence-component3-max-price');

                    
                $return_string.='</div>';

                $return_string .='
                <div  class="wpestate-price-component-popoup-reset_v3" data-default-value2="'.esc_html('No Value','wpresidence').'" data-default-value="' . esc_html($original_value) . '">' . esc_html('Reset', 'wpresidence') . '</div>
                <div  class="wpestate-price-component-popoup-done_v3">' . esc_html('Done', 'wpresidence') . '</div>
                <input type="hidden"  class="price_label_component" name="'.esc_attr($label_name).'"  value="'.esc_html($label_value).'" />
            </div>
        </div>';

        if($is_half==1 && $adv_search_type!=6 ){
            $return_string.='</div>';
        }
        return $return_string;


    }
endif;
/*
*
*
*
*/


function wpresidence_generateSelectDropdown($numbersString,$name,$class) {
    $numbers = explode(',', $numbersString);

    $selected_value='';
    if( isset($_REQUEST[$name]) ){
        $selected_value=floatval($_REQUEST[$name]);
    }

    $dropdownHtml = '<select  name="'.esc_attr($name).'" class=" wpestate-price-component-select '.esc_attr($class).'" ><option value="" >'.esc_html('No Value','wpresidence').'</option>';

    foreach ($numbers as $number) {
        $label      = wpresidence_formatNumberLabel($number);
        $dropdownHtml .= '<option value="'.floatval($number).'"'; 
        if($selected_value==$number){
            $dropdownHtml .= ' selected ';
        }
        $dropdownHtml .= '>'.esc_html($label).'</option>';
    }

    $dropdownHtml .= '</select>';
    return $dropdownHtml;
}


function wpresidence_generate_2nlevel_dropdown($numbersString,$name,$class) {
    $numbers = explode(',', $numbersString);

    $selected_value=esc_html__('No Value','wpresidence');
    if( isset($_REQUEST[$name]) ){
        $selected_value=floatval($_REQUEST[$name]);
    }

    $dropdownHtml = '<div class="dropdown form-control open">
    
    <div data-toggle="dropdown" id="'.esc_attr($name).'_wrapper" class="wpestate_child_dropdown_item filter_menu_trigger sidebar_filter_menu '.esc_attr($class).'" data-value="all" aria-expanded="true">'.esc_html($selected_value).'
        <span class="caret  caret_filter "></span>
    </div>
    <input type="hidden" name="'.esc_attr($name).'" class=" '.esc_attr($class).'_input_class   wpresidence-component3_input_class" value="'.esc_attr($selected_value).'"> 
    <ul id="'.esc_attr($name).'" class="dropdown-menu filter_menu '.esc_attr($class).'_class " role="menu" aria-labelledby="'.esc_attr($name).'_wrapper">
    <li class="wpestate_prevent_ajax"  data-value="'.esc_html__('No Value','wpresidence').'">'.esc_html__('No Value','wpresidence').'</li>';
    

    foreach ($numbers as $number) {
        $label      = wpresidence_formatNumberLabel($number);
        $dropdownHtml .= '<li class="wpestate_prevent_ajax" data-value="'.floatval($number).'"'; 
        if($selected_value==$number){
            $dropdownHtml .= ' selected ';
        }
        $dropdownHtml .= '>'.esc_html($label).'</li>';
    }

    $dropdownHtml .= '   </ul>
    </div>';
    return $dropdownHtml;
}







/*
*
*
*
*/

function wpresidence_formatNumberLabel($number) {
    if ($number >= 1000000) {
        return round($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return round($number / 1000, 1) . 'K';
    }
    return $number;
}


/*
*
*
*
*/


function wpestate_process_taxonomy_search($tip,$term,$key){
    $taxonomies_array=array(
        'types'         =>  array(
                            'input_name'=>'filter_search_action',
                            'taxonomy'=>'property_action_category'
        ),
        'categories'    =>  array(
                                'input_name'=>'filter_search_type',
                                'taxonomy'=>'property_category'
        ),
        'cities'        =>  array(
                                'input_name'=>'advanced_city',
                                'taxonomy'=>'property_city'
        ),
        'areas'        =>  array(
                                'input_name'=>'advanced_area',
                                'taxonomy'=>'property_area'
        ),
        'property status'=>  array(
                                'input_name'=>'property_status',
                                'taxonomy'=>'property_status'
        ),
        'county / state'=>  array(
                                'input_name'=>'advanced_contystate',
                                'taxonomy'=>'property_county_state'
        ),
    );



    $categ_array=array();

    $input_name         =   $taxonomies_array[$term]['input_name'];
    $taxonomy           =   $taxonomies_array[$term]['taxonomy'];
    
    
    if( $tip === 'ajax' ){
        $input_value        =    ($_POST['val_holder'][$key]);
    }else{ 
        if( isset($_REQUEST[$input_name]) ){
            $input_value        =  $_REQUEST[$input_name];
        }
    }

    if ( (isset($_REQUEST[$input_name]) || isset($_POST['val_holder'][$key]) )  ){
        $taxcateg_include   =   array();
   
        $taxcateg_include=  wpestate_sanitize_text_array( $input_value);
        if( (   is_array($taxcateg_include)  && !empty($taxcateg_include)) ||
            (   is_string($taxcateg_include) &&  $taxcateg_include!='' ) ){

                
                    $categ_array=array(
                        'taxonomy'  => $taxonomy,
                        'field'     => 'slug',
                        'terms'     => $taxcateg_include
                    );
        }
        
    }

    return $categ_array;


}


/*
*
*
*
*/

function wpestate_sanitize_text_array($input_array) {
    if(is_array($input_array)){
        $sanitized_array = array();
     

        foreach ($input_array as $key => $value) {
            // Sanitize each element of the array
            $decoded_value = urldecode($value);
            if($decoded_value!=='' && strtolower($decoded_value)!=='all'  ){
                $sanitized_array[$key] = sanitize_text_field($decoded_value);
            }        
        }

        return $sanitized_array;
    }else{
        if( strtolower($input_array)=='all'){
            return '';
        }
        $decoded_value = urldecode($input_array);
        return sanitize_text_field($decoded_value);

    }
}
/*
*
*
*
*/


/*
*
*
*
*/


/*
*
*
*
*/


/*
*
*
*
*/


/*
*
*
*
*/


/*
*
*
*
*/


/*
*
*
*
*/










?>