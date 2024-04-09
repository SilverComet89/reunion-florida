<?php



/*
*
*
* Return property title for elementor
*
*
*
*/


function wpestate_estate_property_page_title_section($attributes){
  $property_id= wpestate_return_property_id_elementor_builder($attributes);
  return '<h1 class="entry_prop">'.get_the_title($property_id) .'</h1>';
}



/*
*
*
* Return property breadcrumbs for elementor
*
*
*
*/

function wpestate_estate_property_page_breadcrumb_section($attributes){
    $property_id    =   wpestate_return_property_id_elementor_builder($attributes);
    include ( locate_template('/templates/listing_templates/property-page-templates/property-page-breadcrumbs.php') ); 
    return '';
}


/*
*
*
* Return property price for elementor
*
*
*
*/

function wpestate_estate_property_page_price_section($attributes){
  $property_id            =   wpestate_return_property_id_elementor_builder($attributes);
  $price                  =   floatval ( get_post_meta($property_id, 'property_price', true) );
  $price_label            =   esc_html ( get_post_meta($property_id, 'property_label', true) );
  $price_label_before     =   esc_html ( get_post_meta($property_id, 'property_label_before', true) );
  $wpestate_currency      =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
  $where_currency         =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

  if ($price != 0) {
      $price = wpestate_show_price($property_id,$wpestate_currency,$where_currency,1);
  }else{
      $price='<span class="price_label price_label_before">'.esc_html($price_label_before).'</span><span class="price_label ">'.esc_html($price_label).'</span>';
  }


  $return='<div class="price_area elementor-widget-container_price_area">'.wp_kses_post($price).'</div>';

  return $return.'';
}


/*
*
*
* Return property price for elementor
*
*
*
*/

function wpestate_estate_property_page_price_info_section($attributes){
  $property_id            =   wpestate_return_property_id_elementor_builder($attributes);
  $price                  =   floatval ( get_post_meta($property_id, 'property_second_price', true) );
  $price_label            =   esc_html ( get_post_meta($property_id, 'property_second_price_label', true) );
  $price_label_before     =   esc_html ( get_post_meta($property_id, 'property_label_before_second_price', true) );
  $wpestate_currency      =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
  $where_currency         =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

  if ($price != 0) {
      $price = wpestate_show_price($property_id,$wpestate_currency,$where_currency,1,"yes");
  }else{
      $price='<span class="price_label price_label_before">'.esc_html($price_label_before).'</span><span class="price_label ">'.esc_html($price_label).'</span>';
  }


  $return='<div class="price_area elementor-widget-container_price_area">'.wp_kses_post($price).'</div>';

  return $return.'';
}

/*
*
*
* Return property address for elementor
*
*
*
*/
function wpestate_estate_property_page_address_section($attributes){
    $property_id            =   wpestate_return_property_id_elementor_builder($attributes);
    $property_address       =   esc_html( get_post_meta($property_id, 'property_address', true) );
    $property_address_show  =   '';
    $property_city              =   get_the_term_list($property_id, 'property_city', '', ', ', '') ;
    $property_area              =   get_the_term_list($property_id, 'property_area', '', ', ', '');

    if($property_address!=''){
        $property_address_show.= esc_html($property_address);
    }

    if($property_city!=''){
        if($property_address!=''){
            $property_address_show.= ', ';
        }
        $property_address_show.= wp_kses_post($property_city);
    }

    if($property_area!=''){
        if($property_address!='' || $property_city!=''){
            $property_address_show.= ', ';
        }
        $property_address_show.= wp_kses_post($property_area);
    }


    $return='<div class="property_categs property_categs_elementor"><i class="fas fa-map-marker-alt"></i>
         '.wp_kses_post($property_address_show).'
    </div>';

    return $return.'';
}

/*
*
*
* Return property add to favorites for elementor
*
*
*
*/

function wpestate_estate_property_page_add_to_favorites_section($attributes){
    $property_id            =   wpestate_return_property_id_elementor_builder($attributes);
    $favorite_class     =   'isnotfavorite';
    $fav_mes            =   esc_html__('add to favorites','wpresidence-core');
    $fav_icon           =   'far fa-heart';
    $current_user       =   wp_get_current_user();
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.intval($userID);
    $curent_fav         =   get_option($user_option);

    if($curent_fav){
        if ( in_array ($property_id,$curent_fav) ){
        $favorite_class =   'isfavorite';
        $fav_mes        =   esc_html__('remove from favorites','wpresidence-core');
        $fav_icon           ='fas fa-heart';
        }
    }


    $return='<div class="prop_social elementor_prop_social">';
         $return.= wpestate_share_unit_desing($property_id,1);
         $return.='
         <div class="title_share share_list single_property_action"  data-original-title="'. esc_attr__('share this page','wpresidence-core').'" >
             <i class="fas fa-share-alt"></i>'.esc_html__('Share','wpresidence-core').'
         </div>

         <div id="add_favorites" class="title_share single_property_action '.esc_attr($favorite_class).'" data-postid="'.intval($property_id).'" data-original-title="'.esc_attr($fav_mes).'" >
             <i class="'.esc_attr($fav_icon).'"></i>'. esc_html__('Favorite','wpresidence-core').'
         </div>

         <div id="print_page" class="title_share single_property_action"   data-propid="'.intval($property_id).'" data-original-title="'. esc_attr__('print page','wpresidence-core').'" >
             <i class="fas fa-print"></i>'. esc_html__('Print','wpresidence-core').'
         </div>
     </div>';

  return $return.'';
}

/*
*
*
* Return property status for elementor
*
*
*
*/
function wpestate_estate_property_page_status_section($attributes){
    $property_id    =   wpestate_return_property_id_elementor_builder($attributes);
    $return         =   wpestate_return_property_status($property_id,'');
    return $return;
}

?>
