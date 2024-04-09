<?php

/*
*
*
* Return property header section for elementor
*
*
*
*/


function wpestate_estate_property_page_header_section($attributes){

  $property_id      = wpestate_return_property_id_elementor_builder($attributes);
  $property_address = esc_html( get_post_meta($property_id, 'property_address', true) );

   $current_user           =   wp_get_current_user();
   $userID                 =   $current_user->ID;
   $user_option            =   'favorites'.intval($userID);
   $curent_fav             =   get_option($user_option);

   $favorite_class     =   'isnotfavorite';
   $fav_mes            =   esc_html__('add to favorites','wpresidence-core');
   $fav_icon           =   'far fa-heart';
   if($curent_fav){
       if ( in_array ($property_id,$curent_fav) ){
       $favorite_class =   'isfavorite';
       $fav_mes        =   esc_html__('remove from favorites','wpresidence-core');
       $fav_icon           ='fas fa-heart';
       }
   }
   $pinteres                   =   array();
   $property_city              =   get_the_term_list($property_id, 'property_city', '', ', ', '') ;
   $property_area              =   get_the_term_list($property_id, 'property_area', '', ', ', '');
   $property_category          =   get_the_term_list($property_id, 'property_category', '', ', ', '') ;
   $property_action            =   get_the_term_list($property_id, 'property_action_category', '', ', ', '');
   $wpestate_currency                 =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
   $where_currency           =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

 $property_address_show='';

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
     $email_link     =   'subject='.urlencode ( get_the_title() ) .'&body='. urlencode( esc_url(get_permalink($property_id)));



  print '<div class="notice_area col-md-12 ">';
  $price                  =   floatval ( get_post_meta($property_id, 'property_price', true) );
  $price_label            =   esc_html ( get_post_meta($property_id, 'property_label', true) );
  $price_label_before     =   esc_html ( get_post_meta($property_id, 'property_label_before', true) );
  if ($price != 0) {
     $price = wpestate_show_price($property_id,$wpestate_currency,$where_currency,1);
  }else{
     $price='<span class="price_label price_label_before">'.esc_html($price_label_before).'</span><span class="price_label ">'.esc_html($price_label).'</span>';
  }


  print '<div class="single_property_labels">';
         print '<div class="property_title_label">'.wp_kses_post($property_action).'</div>';
         print '<div class="property_title_label actioncat">'.wp_kses_post($property_category).'</div>';
  print '</div>';

  print '<h1 class="entry-title entry-prop">'.get_the_title($property_id).'</h1>';
  print '<div class="price_area">'.wp_kses_post($price).'</div>';
  print '<div class="property_categs">
          <i class="fas fa-map-marker-alt"></i>
           '.wp_kses_post($property_address_show).'
      </div>';


          print '<div class="prop_social">';
           
              print wpestate_share_unit_desing($property_id,1);

              print'<div class="title_share share_list single_property_action"  data-original-title="'.esc_attr__('share this page','wpresidence-core').'" >
                  <i class="fas fa-share-alt"></i>'.esc_html__('Share','wpresidence-core').'
              </div>

              <div id="add_favorites" class="title_share single_property_action '.esc_attr($favorite_class).'" data-postid="'.intval($property_id).'" data-original-title="'.esc_attr($fav_mes).'" >
                  <i class="'.esc_attr($fav_icon).'"></i>'.esc_html__('Favorite','wpresidence-core').'
              </div>

              <div id="print_page" class="title_share single_property_action"   data-propid="'.intval($property_id).'" data-original-title="'.esc_attr__('print page','wpresidence-core').'">
                  <i class="fas fa-print"></i>'.esc_html__('Print','wpresidence-core').'
              </div>
          </div>
  </div>';

}
