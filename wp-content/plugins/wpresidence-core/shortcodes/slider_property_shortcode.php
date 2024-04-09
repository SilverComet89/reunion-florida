<?php

/*
*
* slider - recent itenms
*
*
*
*
*/
if( !function_exists('wpestate_slider_recent_posts_pictures') ):

function wpestate_slider_recent_posts_pictures($attributes) {
    global $options;
    global $align;
    global $align_class;
    global $post;
    global $wpestate_currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;
    global $curent_fav;
    global $current_user;
    global $wpestate_property_unit_slider;
    global $wpestate_prop_unit;
    global $wpestate_no_listins_per_row;
    global $wpestate_uset_unit;
    global $wpestate_custom_unit_structure;

    $wpestate_custom_unit_structure    =   wpresidence_get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit       =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
    $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
    $wpestate_prop_unit          =   'grid';
    $options            =   wpestate_page_details_sh($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $wpestate_currency           =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';
    $show_featured_only =   '';
    $autoscroll         =   '';
    $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider','');
    $templates          =   '';
    $featured_first     =   'no';
    $blog_unit                   =   wpestate_blog_unit_selector(); 
    $curent_fav         =  wpestate_return_favorite_listings_per_user();
    $title              =   '';
    $agent_unit = wpestate_agent_card_selector();


    $attributes = shortcode_atts(
                array(
                    'title'                 =>  '',
                    'type'                  => 'properties',
                    'arrows'                =>  'top',
                    'category_ids'          =>  '',
                    'action_ids'            =>  '',
                    'city_ids'              =>  '',
                    'area_ids'              =>  '',
                    'state_ids'             =>  '',
                    'status_ids'            =>  '',
                    'number'                =>  4,
                    'show_featured_only'    =>  'no',
                    'random_pick'           =>  'no',
                    'autoscroll'            =>  0,
                    'featured_first'        =>  'no',
                    'systemx'               =>  '',
                    'sort_by'               =>   0,
                    'card_version'          =>   '',
                  //  'price_min'             =>  0,
                //  'price_max'             =>  9999999999
                ), $attributes) ;

            
     wp_enqueue_script('slick.min');
     $shortcode_arguments  =  wpestate_prepare_arguments_shortcode($attributes);
     //$row_number_col       =  wpestate_shortocode_return_column($shortcode_arguments['row_number']);



     $property_card_type         =   intval(wpresidence_get_option('wp_estate_unit_card_type'));
     if(isset( $shortcode_arguments['card_version']) && is_numeric( $shortcode_arguments['card_version']) ){
           $property_card_type  =  intval($shortcode_arguments['card_version']);
     }

     $property_card_type_string  =   '';
     if($property_card_type==0){
         $property_card_type_string='';
     }else{
         $property_card_type_string='_type'.$property_card_type;
     }



    $align        = '';
    $align_class  = '';
    if(isset($shortcode_arguments['align']) && $shortcode_arguments['align']=='horizontal'){
        $align          = 'col-md-12';
        $align_class    = 'the_list_view';
        $row_number_col = '12';
    }



    $args = wpestate_recent_posts_shortocodes_create_arg($shortcode_arguments);
    $class = "nobutton";







    $return_string .= '<div class="article_container slider_container bottom-'.$shortcode_arguments['type'].' '.$class.' '.$shortcode_arguments['systemx'].' " >';
    if($shortcode_arguments['title']!=''){
         $return_string .= '<h2 class="shortcode_title title_slider">'.$shortcode_arguments['title'].'</h2>';
    }
    $is_autoscroll  =   ' data-auto="'.$shortcode_arguments['autoscroll'].'" ';

    $items_per_row         =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
    if($shortcode_arguments['type'] != 'estate_property'){
        $items_per_row  =    intval( wpresidence_get_option('wp_estate_blog_listings_per_row', '') );
    }

    $three_per_row_class = ' three_per_row ';



    $return_string .=  '<div class="shortcode_slider_wrapper" >';


    $transient_name= 'wpestate_recent_posts_slider_' . $shortcode_arguments['type']. '_' . $shortcode_arguments['category'] . '_' . $shortcode_arguments['action'] . '_' . $shortcode_arguments['city'] . '_' . $shortcode_arguments['area']. '_' . $shortcode_arguments['state'] ;
    $transient_name.='_'.$shortcode_arguments['number'].'_'.$shortcode_arguments['featured_first'].'_'.$shortcode_arguments['show_featured_only'].'_'.$shortcode_arguments['autoscroll'];

    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $transient_name.='_'. ICL_LANGUAGE_CODE;
    }
    if ( isset($_COOKIE['my_custom_curr_symbol'] ) ){
        $transient_name.='_'.$_COOKIE['my_custom_curr_symbol'];
    }
    if(isset($_COOKIE['my_measure_unit'])){
        $transient_name.= $_COOKIE['my_measure_unit'];
    }



    $templates=false;
    if(function_exists('wpestate_request_transient_cache')){
        $templates = wpestate_request_transient_cache( $transient_name);
    }


    if($templates === false ){
        if ($shortcode_arguments['type'] == 'properties') {
            $recent_posts =wpestate_return_filtered_query($args,$shortcode_arguments['featured_first'] );
        }else {
            $recent_posts = new WP_Query($args);
        }
        $count = 1;


        ob_start();
        $rand_class='slider_no'.rand(0,99999);

        print '<div class="shortcode_slider_list '.$rand_class.' arrow_class_'.$shortcode_arguments['arrows'].' " data-items-per-row="'.$items_per_row.'" '.$is_autoscroll.'>';


        while ($recent_posts->have_posts()): $recent_posts->the_post();
            print '<div class=" slider_prop_wrapper  '.$three_per_row_class.' " >';

            if ($shortcode_arguments['type'] == 'properties') {
               include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
            }else if ($shortcode_arguments['type'] == 'agents') {
                 // to be used in agent unit
        $col_org= $row_number_col;
        $per_row_class='';

                include( locate_template($agent_unit) ) ;    
            }else {
                include( locate_template($blog_unit) ) ;
            }
            print '</div>';
        endwhile;



        $templates = ob_get_contents();
        ob_end_clean();
        if(function_exists('wpestate_set_transient_cache')){
            wpestate_set_transient_cache ($transient_name,wpestate_html_compress($templates),4*60*60);
        }
    }



    $return_string .=$templates;
    $return_string .= '</div></div>';// end shrcode wrapper
    $return_string .= '</div>';

    wp_reset_query();
    wp_reset_postdata();
    $is_shortcode       =   0;


    return $return_string;


}
endif; // end   wpestate_slider_recent_posts_pictures
