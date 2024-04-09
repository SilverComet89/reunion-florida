<?php


/**
*
*
*
*
*
*/



if ( !function_exists("wpestate_filter_list_properties") ):
function wpestate_filter_list_properties($attributes, $content = null){

    $category_ids='';
    if(isset($attributes['category_ids'])){
        $category_ids       =   $attributes['category_ids'];
    }

    $action_ids='';
    if(isset($attributes['action_ids'])){
        $action_ids       =   $attributes['action_ids'];
    }

    $city_ids='';
    if(isset($attributes['city_ids'])){
        $city_ids       =   $attributes['city_ids'];
    }

    $area_ids='';
    if(isset($attributes['area_ids'])){
        $area_ids       =   $attributes['area_ids'];
    }

    $state_ids='';
    if(isset($attributes['state_ids'])){
        $state_ids      =   $attributes['state_ids'];
    }
    
    $sort_by='';
    if(isset($attributes['sort_by'])){
        $sort_by    =   $attributes['sort_by'];
    }

    $align='';
    if(isset($attributes['align'])){
        $align=$attributes['align'];
    }

    $city       =   wpestate_return_first_term($city_ids,'property_city');
    $area       =   wpestate_return_first_term($area_ids,'property_area');
    $category   =   wpestate_return_first_term($category_ids,'property_category');
    $types      =   wpestate_return_first_term($action_ids,'property_action_category');
    $county     =   wpestate_return_first_term($state_ids,'property_county_state');

    // build filters
    $filter_selection=array(
        'city'      =>  $city,
        'area'      =>  $area,
        'types'     =>  $types,
        'category'  =>  $category,
        'county'    =>  $county,
        'sort_by'   =>  $sort_by

    );

    $filter_data                    =   wpestate_return_filter_data( $filter_selection );
    $filter_data['sort_by']=$sort_by;
    $filter_data['listing_filter']  =   0;
    $return_string                  =   wpestate_filter_bar($filter_data);
    $attributes['type']             =   'properties';

    $card_version='';
    if(isset($attributes['card_version']))$card_version=$attributes['card_version'];

    $return_string.= '<div class="wpestate_filter_list_properties_wrapper" data-ishortcode="1" data-number="'.$attributes['number'].'"  data-rownumber="'.$attributes['rownumber'].'" data-card_version="'.esc_attr($card_version).'" data-align="'.esc_attr($align).'">'.wpestate_shortcode_build_list($attributes).'
        <div class="spinner" id="listing_loader2">
            <div class="new_prelader"></div>
        </div>
    </div>';
    return $return_string;
}
endif;





/**
*
* Use to show prop list for filter list properties shortcode
*
*
*
*/



if( !function_exists('wpestate_shortcode_build_list') ):
function wpestate_shortcode_build_list($attributes){

    global $is_shortcode;
    global $row_number_col;
    global $align;
    global $post;

    $orderby                    =   'meta_value';
    $is_shortcode               =   1;
    $return_string              =   '';
  global $wpestate_property_unit_slider;
      
    $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider','');
    $wpestate_uset_unit         =   intval ( wpresidence_get_option('wpestate_uset_unit','') );

    $shortcode_arguments            =   wpestate_prepare_arguments_shortcode($attributes);
    $property_card_type_string      =   wpestate_return_property_card_type($attributes);
    $args                           =   wpestate_recent_posts_shortocodes_create_arg($shortcode_arguments);

      $order            =  intval( $shortcode_arguments['sort_by'] );



    $show_featured_only='';
    if ( isset($attributes['show_featured_only']) ){
        $show_featured_only=$attributes['show_featured_only'];
    }

    if( isset($attributes['control_terms_id'])){
        $control_terms_id=$attributes['control_terms_id'];
    }

    if (isset($attributes['featured_first'])){
        $featured_first=   $attributes['featured_first'];
    }

    $random_pick='';
    if ( isset($attributes['$random_pick']) ){
        $random_pick        = $attributes['$random_pick'];
    }



    $post_number_total = $attributes['number'];
    if ( isset($attributes['rownumber']) ){
        $row_number        = $attributes['rownumber'];
    }
    $wpestate_no_listins_per_row=$row_number;



    $row_number_col       =  wpestate_shortocode_return_column($shortcode_arguments['row_number']);

    $align='';
    $align_class='';
    if(isset($attributes['align']) && $attributes['align']=='horizontal'){
        $align="col-md-12";
        $align_class='the_list_view';
        $row_number_col='12';

    }


  
    isset( $shortcode_arguments['category'] )  ? $category = $shortcode_arguments['category'] : $category   = '';
    isset( $shortcode_arguments['action'] )  ? $action = $shortcode_arguments['action'] : $action   = '';
    isset( $shortcode_arguments['city'] )  ? $city = $shortcode_arguments['city'] : $city   = '';
    isset( $shortcode_arguments['area'] )  ? $area = $shortcode_arguments['area'] : $area   = '';
    isset( $shortcode_arguments['state'] )  ? $state = $shortcode_arguments['state'] : $state   = '';
    isset( $shortcode_arguments['status'] )  ? $status = $shortcode_arguments['status'] : $status   = '';
    $type           =   'estate_property';
    $featured_first =   'no';




    $transient_name= 'wpestate_properties_list_filter_query_' . $type . '_' . $category . '_' . $action . '_' . $city . '_' . $area.'_'.$state.'_'.$row_number.'_'.$post_number_total.'_'.$featured_first.'_'.$align;
    $transient_name=wpestate_add_global_details_transient($transient_name);

    $templates=false;
    if(function_exists('wpestate_request_transient_cache')){
        $templates = wpestate_request_transient_cache( $transient_name);
    }

     if( $templates === false || $random_pick=='yes' ) {
       $recent_posts =wpestate_return_filtered_query($args,$featured_first );

        ob_start();
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
        endwhile;

        wpestate_pagination_ajax_newver($recent_posts->max_num_pages, 2,1,'pagination_ajax',$order);
        $templates = ob_get_contents();
        ob_end_clean();
        if($orderby!=='rand'){
            if(function_exists('wpestate_set_transient_cache')){
                wpestate_set_transient_cache( $transient_name,wpestate_html_compress( $templates ), 60*60*4 );
            }
        }


        wp_reset_query();
    }
    
    
    
    $return_string .=$templates;
    return $return_string;
}
endif;
