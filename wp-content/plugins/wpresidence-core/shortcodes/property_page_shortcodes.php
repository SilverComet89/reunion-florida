<?php
// shortcode is estate_property_design_other_agents

if( !function_exists('wpestate_property_design_other_agents') ):
function wpestate_property_design_other_agents($attributes,$content = null,$columns=''){
    global $post;
    global $propid;
    $return_string  =   '';
    $maxwidth       =   '';
    $margin         =   '';
    $image_no       =   '';
    $css_class      =   '';

    $agent_unit = wpestate_agent_card_selector();
    extract(shortcode_atts(array(
            'css'              =>   '',
            'maxwidth'         =>   '200',
            'margin'           =>   '10',
            'image_no'         =>   '4',
            'is_elementor'     =>   ''
    ), $attributes));

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();

    }



    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

    $agents_secondary   =   get_post_meta($propid, 'property_agent_secondary', true);

    if( is_array($agents_secondary) && !empty($agents_secondary) && $agents_secondary[0]!=''  ){

        $return_string.='<div class="mylistings">
        <h3 class="agent_listings_title_similar">'.esc_html__('Other Agents','wpresidence-core').'</h3>';

    $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_agent_listings_per_row', '') );

if( $columns==''){
        global $wpestate_options;
        $col_class=4;
        if($wpestate_options['content_class']=='col-md-12'){
            $col_class=3;
        }

        if($wpestate_no_listins_per_row==3){
            $col_class  =   '6';
            $col_org    =   6;
            if($wpestate_options['content_class']=='col-md-12'){
                $col_class  =   '4';
                $col_org    =   4;
            }
        }else{
            $col_class  =   '4';
            $col_org    =   4;
            if($wpestate_options['content_class']=='col-md-12'){
                $col_class  =   '3';
                $col_org    =   3;
            }
        }

}else{

  if($columns==2){
    $col_class  =   '6';
    $col_org    =   6;
  }else if($columns==3){
    $col_class  =   '4';
    $col_org    =   4;
  }else if($columns==4){
    $col_class  =   '3';
    $col_org    =   3;
  }
}


        $agents_sec_list = implode(',',$agents_secondary);
        $args = array(
            'post_type'         => 'estate_agent',
            'posts_per_page'    => -1 ,
            'post__in'         =>  $agents_secondary
            );


        $agent_selection = new WP_Query($args);
        $per_row_class='';
        $agent_listings_per_row = wpresidence_get_option('wp_estate_agent_listings_per_row');
        if( $agent_listings_per_row==4){
            $per_row_class =' agents_4per_row ';
        }


        ob_start();

        while ($agent_selection->have_posts()): $agent_selection->the_post();
            include( locate_template($agent_unit) ) ;    
        endwhile;
        $temp=  ob_get_contents();
        ob_end_clean();

        $return_string.=$temp.'</div>';

        wp_reset_postdata();
        wp_reset_query();
    }
    return $return_string;
}
endif;



/*
 *  Masonary gallery for bakery - using same function as elementor
 * 
*/

if( !function_exists('wpestate_estate_property_design_masonary_gallery') ):
function wpestate_estate_property_design_masonary_gallery($attributes,$content = null){
    
    global $propid;
 
    ob_start();
    wpestate_header_masonry_gallery_type2($propid);
    $return_string= ob_get_contents();
    ob_end_clean();
    
    return $return_string;
}
endif;



/*
 *  Masonary gallery for bakery - using same function as elementor
 * 
*/

if( !function_exists('wpestate_estate_property_design_masonary_gallery_2') ):
function wpestate_estate_property_design_masonary_gallery_2($attributes,$content = null){
    global $propid;
 
    ob_start();
    wpestate_header_masonry_gallery($propid);
    $return_string= ob_get_contents();
    ob_end_clean();
    
    return $return_string;
}
endif;









if( !function_exists('wpestate_estate_property_design_agent_details_intext_details') ):
function wpestate_estate_property_design_agent_details_intext_details($attributes,$content = null){
    global $post;
    global $propid;


    $original_prop_id=$propid;

    $return_string  =   '';
    $maxwidth       =   '';
    $margin         =   '';
    $image_no       =   '';
    $css_class      =   '';
    $detail='';
    $propid='';

    $original_content = $content;
    $original_content_elementor ='';

    if( isset($attributes['content'])){
        $original_content_elementor = $attributes['content'];
    }

    extract(shortcode_atts(array(
            'css'              =>   '',
            'is_elementor'     =>   '',
            'content'          =>   '',
    ), $attributes));



    if(intval($original_prop_id)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){

        $original_prop_id = wpestate_return_elementor_id();
        $original_content=$original_content_elementor;
    }


    if( isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
       $original_content=$original_content_elementor;
    }


    $detail =$original_content;
    $propid=$original_prop_id;

    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

    $agent_id       = intval( get_post_meta($propid, 'property_agent', true) );
    $author_id      = wpsestate_get_author($propid);

    $agent_single_details = array(
        'Name'          =>  'name',
        'Description'   =>  'description',
        'Main Image'    =>  'image',
        'Page Link'     =>  'page_link',
        'Agent Skype'   =>  'agent_skype',
        'Agent Phone'   =>  'agent_phone',
        'Agent Mobile'  =>  'agent_mobile',
        'Agent email'   =>  'agent_email',
        'Agent position'                =>  'agent_position',
        'Agent Facebook'                =>  'agent_facebook',
        'Agent Twitter'                 =>  'agent_twitter',
        'Agent Linkedin'                => 'agent_linkedin',
        'Agent Pinterest'               => 'agent_pinterest',
        'Agent Instagram'               => 'agent_instagram',
        'Agent Website'                 => 'agent_website',
        'Agent Category'                => 'property_category_agent',
        'Agent action category'         => 'property_action_category_agent',
        'Agent city category'           => 'property_city_agent',
        'Agent Area category'           => 'property_area_agent',
        'Agent County/State category'   => 'property_county_state_agent'
    );
    preg_match_all("/\{[^\}]*\}/", $detail, $matches);
    $return_string =   '<div class="wpestate_estate_property_design_agent_details_intext_details '.$css_class.'"> ';


    foreach($matches[0] as $key=>$value){

        $element=    substr($value, 1);
        $element=    substr($element, 0, -1);

        if($element =='name'){
            $replace=get_the_title($agent_id);
        }else if($element =='description'){
            //$replace=get_the_content($agent_id);
            ob_start();
            $page_object = get_post( $agent_id );
            echo $page_object->post_content;
            $replace=  ob_get_contents();
            ob_end_clean();

        }else if($element =='image'){
            $thumb_id           = get_post_thumbnail_id($agent_id);
            $preview            = wp_get_attachment_image_src(get_post_thumbnail_id($agent_id), 'property_listings');
            $preview_img        = $preview[0];
            if($preview_img==''){
               $preview_img  = WPESTATE_PLUGIN_DIR_URL.'/img/default_user.png';
            }
            $replace            = '<img src="'.$preview_img.'" alt="'.get_the_title($agent_id).'">';
        }else if($element =='page_link'){
            $replace=get_the_permalink($agent_id);
        }else if($element =='property_category_agent' || $element =='property_action_category_agent' || $element =='property_city_agent' || $element =='property_area_agent' || $element =='property_county_state_agent'){
            $replace=  get_the_term_list($agent_id, $element, '', ', ', '') ;
        }else{
            $replace        =esc_html( get_post_meta($agent_id, $element, true) );
        }


        $detail=str_replace($value,$replace,$detail);
    }



    $return_string .=  do_shortcode( $detail ).'</div>';
    return $return_string;




}
endif;





if( !function_exists('wpestate_estate_property_design_gallery') ):
function wpestate_estate_property_design_gallery($attributes,$content = null){
    global $post;
    global $propid;
    $return_string  =   '';
    $maxwidth       =   '';
    $margin         =   '';
    $image_no       =   '';
    $css_class      =   '';

    extract(shortcode_atts(array(
            'css'              =>   '',
            'maxwidth'         =>   '200',
            'margin'           =>   '10',
            'image_no'         =>   '4',
            'is_elementor'     =>   '1',
    ), $attributes));

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }

    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

   $image_no=$image_no-1;

    $counter_lightbox=0;
    $arguments      = array(
                'page'       =>  1,
                'post_type'         =>  'attachment',
                'posts_per_page'    =>  $image_no,
                'post_mime_type'    =>  'image',
                'post_parent'       =>  $propid,
                'exclude'           => get_post_thumbnail_id($propid),
                'post_status'       =>  'any',
                'orderby'           =>  'menu_order',
                'order'             =>  'ASC'
            );
    $post_attachments   = get_posts($arguments);

    $counter_lightbox++;
    $return_string.='<ul class="wpestate_estate_property_design_gallery '.$css_class.'" style="margin:0px -'.$margin.'px;padding: 0px '.($margin/2).'px;">';
            $thumb_id           =   get_post_thumbnail_id($propid);
            $preview            =   wp_get_attachment_image_src($thumb_id, 'property_listings');
            $full_prty          =   wp_get_attachment_image_src($thumb_id, 'full');

            $full_prty_img = '';
            if(isset($full_prty[0])){
                $full_prty_img=$full_prty[0];
            }

 $return_string.= '<li class="" style="margin:0px '.($margin/2).'px '.$margin.'px '.($margin/2).'px;">
                            <a href="'.esc_url($full_prty_img).'" rel="prettyPhoto" class="prettygalery"   >
                                <img  class="lightbox_trigger" data-slider-no="'.$counter_lightbox.'"  src="'.$preview[0].'" style="max-width:'.$maxwidth.'px;" />
                            </a>
                            </li>';


    foreach ($post_attachments as $attachment) {
            $counter_lightbox++;
            $preview            = wp_get_attachment_image_src($attachment->ID, 'property_listings');
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'full');

            $return_string.= '<li class="" style="margin:0px '.($margin/2).'px '.$margin.'px '.($margin/2).'px;">
                            <a href="'.$full_prty[0].'" rel="prettyPhoto" class="prettygalery"  title="'.$attachment->post_excerpt.'"  >
                                <img  class="lightbox_trigger" data-slider-no="'.$counter_lightbox.'"  src="'.$preview[0].'" alt="'.$attachment->post_excerpt.'" style="max-width:'.$maxwidth.'px;" />
                            </a>
                            </li>';

    }// end foreach
    $return_string.='</ul>';
    return $return_string;
}
endif;









if( !function_exists('wpestate_estate_property_design_intext_details') ):
function wpestate_estate_property_design_intext_details($attributes,$content=''){


    global $post;
    global $propid;
    $back_prop_id = $propid;
    $return_string='';
    $detail='';

    $css = '';

    $detail =$content;
    extract(shortcode_atts(array(
        'css' => '',
        'is_elementor'=>'',
        'content'   =>''
    ), $attributes));




    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
        $detail=$attributes['content'];
    }

    if( isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
           $detail=$attributes['content'];
    }

    $css_class='';
    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

   $feature_terms        =   get_terms( array(
                                'taxonomy' => 'property_features',
                                'hide_empty' => false,
                            ));
    $features_details=array();
    if(is_array($feature_terms)){
        foreach($feature_terms as $key => $term){
            $features_details[$term->slug] =      $term->name;
        }
    }




    preg_match_all("/\{[^\}]*\}/", $detail, $matches);
    //var_dump($matches[0]);

    $return_string =  '<div class="wpestate_estate_property_design_intext_details '.$css_class.'">';

    $replace='';
    foreach($matches[0] as $key=>$value){
        // $element =   substr($value,  1);
        $element    =    substr($value, 1);
        $element    =    substr($element, 0, -1);
        //$return_string.=  $value.'/'.$element.'*';

        if( is_array($features_details) && in_array ($element,$features_details) ){
            if( has_term( $element, 'property_features',$propid )){
                $replace='yes';
            }else{
                $replace='no';
            }
        }else{
            if($element =='prop_id'){
                $replace=$propid;
            }else if($element =='prop_url'){
                $replace=  esc_url( get_permalink($propid) );
            }else if($element =='favorite_action'){
                $curent_fav     =    wpestate_return_favorite_listings_per_user();
                $favorite_class             =   'isnotfavorite';
                $favorite_text              =   esc_html__('add to favorites','wpresidence-core');
                if($curent_fav){
                    if ( in_array ($propid,$curent_fav) ){
                        $favorite_class =   'isfavorite';
                        $favorite_text  =   esc_html__('favorite','wpresidence-core');
                    }
                }


                $replace='<span id="add_favorites" class="'.esc_html($favorite_class).'" data-postid="'.$propid.'">'.$favorite_text.'</span>';
            }else if($element =='property_status'){
                $replace=get_the_term_list($propid,'property_status','',',','');
                if($replace=='normal'){
                    $replace='';
                }
            }else if($element =='property_pdf'){
                  $replace=wpestate_property_sh_download_pdf($propid);
            }else if($element =='page_views'){
                $replace='<span class="no_views dashboad-tooltip" data-original-title="'.esc_html__('Number of Page Views','wpresidence-core').'"><i class="fas fa-eye-slash "></i>'.intval( get_post_meta($propid, 'wpestate_total_views', true) ).'</span>';
            }else if($element =='print_action'){
                $replace='<i class="fas fa-print" id="print_page" data-propid="'.$propid.'"></i>';
            }else if($element =='facebook_share'){
                $replace='<a href="http://www.facebook.com/sharer.php?u='.get_the_permalink($propid).'&amp;t='.urlencode(get_the_title($propid)).'" target="_blank" class="share_facebook"><i class="fab fa-facebook-f"></i></a>';
            }else if($element =='twiter_share'){
                $replace='<a href="https://twitter.com/intent/tweet?text='.urlencode(get_the_title($propid).' '.get_the_permalink($propid)).'" class="share_tweet" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>';

                }else if($element =='google_share'){
                $replace='<a href="https://plus.google.com/share?url='.get_the_permalink($propid).'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;" target="_blank" class="share_google"><i class="fab fa-google-plus-g"></i></a>';
            }else if($element =='pinterest_share'){
                $pinterest=array();
                $pinterest[0]='';
                if (has_post_thumbnail($propid)){
                    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id($propid),'property_full_map');
                }


                $replace='<a href="http://pinterest.com/pin/create/button/?url='.get_the_permalink($propid).'&amp;media='.esc_url($pinterest[0]).'&amp;description='.urlencode(get_the_title($propid)).'" target="_blank" class="share_pinterest"> <i class="fab fa-pinterest-p"></i> </a>';
            }else if( $element =='whatsapp_share'){
                $replace='<a href="https://api.whatsapp.com/send?text='. urlencode( get_the_title($propid).' '. esc_url( get_permalink($propid) )).'" class="social_email"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>';
            }else if( $element =='email_share'){

                $link           =   esc_url ( get_permalink($propid) );
                $title          =   get_the_title($propid);
                $email_link     =   'subject='.urlencode ( $title ) .'&body='. urlencode( esc_url($link));
                $replace='<a href="mailto:email@email.com?'.trim(esc_html($email_link)).'" data-action="share email"  class="social_email"><i class="far fa-envelope"></i></a>';
            }else if($element=='title'){

               $replace=get_the_title($propid);
            }else if($element =='property_price'){
                $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
                $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
                $replace =  wpestate_show_price($propid,$wpestate_currency,$where_currency,1);
            }else if($element =='property_second_price'){
                $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
                $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
                //$meta_value = get_post_meta($propid,$element,true);
                $price = floatval(get_post_meta($propid, 'property_second_price', true));
                $th_separator = stripslashes(wpresidence_get_option('wp_estate_prices_th_separator', ''));
                $meta_value = wpestate_format_number_price($price, $th_separator);
                   
                 if ($where_currency == 'before') {
                    $replace = $wpestate_currency . ' ' . $meta_value;
                } else {
                    $replace = $meta_value . ' ' . $wpestate_currency;
                }
                
              
            
            }else if($element =='description'){
                $replace= estate_listing_content($propid);
            }else if($element =='property_category' || $element =='property_action_category' || $element =='property_city' || $element =='property_area' || $element =='property_county_state' ){
                $replace=  get_the_term_list($propid, $element, '', ', ', '') ;
            }else{
                $meta_value = get_post_meta($propid,$element,true);
                $replace = apply_filters( 'wpml_translate_single_string', $meta_value, 'wpresidence-core', 'wp_estate_property_custom_s_'.$meta_value );
                
                
              
                if( $element =='property_size' || $element =='property_lot_size'  ){
                    
                    if( $element =='property_size' ){
                        $replace          =   wpestate_get_converted_measure( $propid, 'property_size' );
                    }else if($element =='property_lot_size'){
                        $replace          =   wpestate_get_converted_measure( $propid, 'property_lot_size' );
                    }

                    if( $meta_value==0 || $meta_value=='0'){
                        $replace='';
                    }
                }
                
              //  $replace= get_post_meta($propid,$element,true);
            }

        }


        $detail=str_replace($value,$replace,$detail);
    }



    $return_string .=  do_shortcode( $detail ).'</div>';
    wp_reset_query();
    wp_reset_postdata();
    $propid =  $back_prop_id;
    if($replace=='' || $replace== esc_html__('Not Available','wpresidence-core') ){
        return '';
    }else{
        return $return_string;
    }

}
endif;




if( !function_exists('wpestate_estate_property_design_related_listings') ):
function wpestate_estate_property_design_related_listings($attributes,$content = null){

    global $post;
    global $propid;

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }
    $return_string =    '<div class="wpestate_estate_property_design_related_listings">';
    $return_string .=   wpestate_show_related_listings($propid);
    $return_string .=   '</div>';
    return $return_string;
}
endif;



if( !function_exists('wpestate_estate_property_schedule_tour') ):
function wpestate_estate_property_schedule_tour($attributes,$content = null){
    global $post;
    global $propid;
    global $prop_id;
    
    extract(shortcode_atts(array(
        'css' => '',
        'is_elementor'=>''
    ), $attributes));

    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }
    
    $agent_context='property_page';
    
    $enable_global_property_page_agent_sidebar= esc_html ( wpresidence_get_option('wp_estate_global_property_page_agent_sidebar','') );
    
    include( locate_template ('/templates/listing_templates/property_page_schedule_tour.php') );
     
     
}
endif;





if( !function_exists('wpestate_estate_property_design_agent_contact') ):
function wpestate_estate_property_design_agent_contact($attributes,$content = null){

    global $post;
    global $propid;
    global $prop_id;
    $css_class='';

    extract(shortcode_atts(array(
        'css' => '',
        'is_elementor'=>''
    ), $attributes));

    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }

    $return_string ='<div class="wpestate_estate_property_design_agent  '.$css_class.'">';


    $agent_id   = intval( get_post_meta($propid, 'property_agent', true) );
    $prop_id    = $propid;
    $author_id           =  wpsestate_get_author($propid);

    $contact_form_7_agent   =   stripslashes( ( wpresidence_get_option('wp_estate_contact_form_7_agent','') ) );
    $contact_form_7_contact =   stripslashes( ( wpresidence_get_option('wp_estate_contact_form_7_contact','') ) );
    if (function_exists('icl_translate') ){
        $contact_form_7_agent     =   icl_translate('wpresidence-core','contact_form7_agent', $contact_form_7_agent ) ;
        $contact_form_7_contact   =   icl_translate('wpresidence-core','contact_form7_contact', $contact_form_7_contact ) ;
    }


    $return_string .='<div class="agent_contanct_form">';





    $return_string .=' <h4 id="show_contact">'.esc_html__('Contact Me', 'wpresidence-core').'</h4>';

    if( $contact_form_7_agent ==''){
         $return_string .='<div class="schedule_meeting">'.esc_html__('Schedule a showing?','wpresidence-core').'</div>';
    }


    if ( $contact_form_7_agent==''){

        $return_string .='
        <div class="alert-box error">
          <div class="alert-message" id="alert-agent-contact"></div>
        </div>

        <div class="schedule_wrapper "  style="display: none;">
            
            <input name="schedule_day" id="schedule_day" type="text"  placeholder="'.esc_html__('Day', 'wpresidence-core').'" aria-required="true" class="form-control">

            <select name="schedule_hour" id="schedule_hour" class="form-control">
                <option value="0">'.esc_html__('Time','wpresidence-core').'</option>';

                for ($i=7; $i <= 19; $i++){
                    for ($j = 0; $j <= 45; $j+=15){
                        $show_j=$j;
                        if($j==0){
                            $show_j='00';
                        }

                        $val =$i.':'.$show_j;
                          $return_string .='<option value="'.$val.'">'.$val.'</option>';
                    }
                }
             $return_string .='
            </select>
           
        </div>

        <div class="contact_form_flex_wrapper">
            <input name="contact_name" id="agent_contact_name" type="text"  placeholder="'. esc_html__('Your Name', 'wpresidence-core').'" aria-required="true" class="form-control">
            <input type="text" name="email" class="form-control" id="agent_user_email" aria-required="true" placeholder="'.esc_html__('Your Email', 'wpresidence-core').'" >
            <input type="text" name="phone"  class="form-control" id="agent_phone" placeholder="'.esc_html__('Your Phone', 'wpresidence-core').'" >
        </div>
        <textarea id="agent_comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true">'.esc_html__("I'm interested in ","wpresidence-core").'[ '.get_the_title($propid).' ]</textarea>';

        ob_start();
        wpestate_check_gdpr_case();
        $temp= ob_get_contents();
        ob_end_clean();

        $return_string .=$temp;
        $return_string .='
        <input type="submit" class="wpresidence_button agent_submit_class"  id="agent_submit" value="'. esc_html__('Send Email', 'wpresidence-core').'">';

        if( wpresidence_get_option('wp_estate_enable_direct_mess')=='yes'){
            $return_string .='<input type="submit" class="wpresidence_button message_submit"   value="'.esc_html__('Send Private Message', 'wpresidence-core').'">
            <div class=" col-md-12 message_explaining">'.esc_html__('You can reply to private messages from "Inbox" page in your user account.','wpresidence-core').'</div>';
         }

        $return_string .='
        <input name="prop_id" type="hidden"  id="agent_property_id" value="'.intval($propid).'">
        <input name="prop_id" type="hidden"  id="agent_id" value="'.intval($agent_id).'">
        <input type="hidden" name="contact_ajax_nonce" id="agent_property_ajax_nonce"  value="'. wp_create_nonce( 'ajax-property-contact' ).'" />';


    }else{
        ob_start();
        echo do_shortcode($contact_form_7_agent);
        $temp=  ob_get_contents();
        ob_end_clean();
        $return_string .=$temp;
    }

    $return_string .='</div>';
    $return_string .='</div>';
    return $return_string;
}
endif;




if( !function_exists('wpestate_estate_property_design_agent') ):
function wpestate_estate_property_design_agent($attributes,$content = null){
    global $post;
    global $propid;
    global $prop_id;
    global $agent_urlc;
    global $link;
    global $agent_facebook;
    global $agent_posit;
    global $agent_twitter;
    global $agent_linkedin;
    global $agent_instagram;
    global $agent_pinterest;
    global $agent_member;
    global $preview_img;
    extract(shortcode_atts(array(
        'css' => '',
        'columns'=> 'one column',
        'is_elementor'=>''
    ), $attributes));

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }
    $css_class='';
    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }
    
    
    if( $columns =="one column"){
        $css_class .=" property_desing_agent_one_col ";
    }else{
         $css_class .=" property_desing_agent_two_col ";
    }
    $prop_id    = $propid;
    $agent_id   = intval( get_post_meta($propid, 'property_agent', true) );

    $return_string ='<div class="wpestate_estate_property_design_agent wpestate_property_widget '.$css_class.'">';
        ob_start();
        $agent_context='agent_card';
        $realtor_details =  wpestate_return_agent_details($propid);
        include( locate_template('templates/listing_templates/agent_section/agentdetails.php'));

        $return_string .=  ob_get_contents();
        ob_end_clean();
    $return_string .='</div>';
    return $return_string;

}
endif;











if( !function_exists('wpestate_estate_property_slider_section') ):
function wpestate_estate_property_slider_section($attributes,$content = null){
    global $post;
    global $propid ;

    $return_string  ='';
    $detail         ='';
    $label          ='';

    extract(shortcode_atts(array(
        'css'       =>  '',
        'detail'    =>  'horizontal',
        'showmap'   =>  'no',
        'is_elementor'=> '',
        ), $attributes));

    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }

    if ( isset($attributes['detail']) ){
        $detail  = $attributes['detail'];
    }

    if($detail==='horizontal'){
        return '<div class="wpestate_estate_property_slider_section_wrapper '.$css_class.' ">'.wpestate_shortcode_listing_slider($propid,$showmap).'</div>';
    }else{
        return '<div class="wpestate_estate_property_slider_section_wrapper '.$css_class.'">'.wpestate_shortcode_listing_slider_vertical($propid,$showmap).'</div>';
    }
}
endif;







function wpestate_shortcode_listing_slider_vertical($propid,$showmap){
    $return_string  =   '';
    global $slider_size;
    $video_id       =   '';
    $video_thumb    =   '';
    $video_alone    =   0;
    $full_img       =   '';
    $arguments      = array(
                        'numberposts' => -1,
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'post_parent' => $propid,
                        'post_status' => null,
                        'exclude' => get_post_thumbnail_id($propid),
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    );

    $post_attachments   = get_posts($arguments);
    $video_id           = esc_html( get_post_meta($propid, 'embed_video_id', true) );
    $video_type         = esc_html( get_post_meta($propid, 'embed_video_type', true) );


    if ($post_attachments || has_post_thumbnail($propid) || get_post_meta($propid, 'embed_video_id', true)) {

        $return_string.='
        <div id="carousel-listing" class="carousel slide post-carusel carouselvertical" data-ride="carousel" data-interval="false">';


        $return_string.=   wpestate_return_property_status($propid,'verticalstatus');


        $indicators         ='';
        $round_indicators   ='';
        $slides             ='';
        $captions           ='';
        $counter            =0;
        $counter_lightbox   =0;
        $has_video          =0;
        if($video_id!=''){
            $has_video  =   1;
            $counter    =   1;
            $videoitem  =   'videoitem';
            if ($slider_size    ==  'full'){
                $videoitem  =  'videoitem_full';
            }


            $indicators.='<li data-target="#carousel-listing"  data-video_data="'.$video_type.'" data-video_id="'.$video_id.'"  data-slide-to="0" class="active video_thumb_force">
                         <img src= "'.wpestate_get_video_thumb($propid).'" alt="video_thumb" class="img-responsive"/>
                         <span class="estate_video_control"><i class="fas fa-play"></i> </span>
                         </li>';

            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="0" class="active"></li>';

            $slides .= '<div class="item active '.$videoitem.'">';

             if($video_type=='vimeo'){
                 $slides .= wpestate_custom_vimdeo_video($video_id);
             }else{
                  $slides.= wpestate_custom_youtube_video($video_id);
             }

             $slides   .= '</div>';
             $captions .= '<span data-slide-to="0" class="active" >'.esc_html__('Video','wpresidence-core').'</span>';
        }

        if( has_post_thumbnail($propid) ){
            $counter++;
            $counter_lightbox++;
            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $post_thumbnail_id  = get_post_thumbnail_id($propid );
            $preview            = wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');

            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider');
            }

            $full_prty          = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            $attachment_meta    = wp_get_attachment($post_thumbnail_id);

            $indicators.= '<li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'">
                                <img  src="'.$preview[0].'"  alt="slider" />
                           </li>';

            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'" ></li>';
            $slides .= '<div class="item '.$active.' ">
                           <a href="'.$full_prty[0].'" title="'.get_post($post_thumbnail_id)->post_excerpt.'"  rel="prettyPhoto" class="prettygalery">
                                <img  src="'.$full_img[0].'" data-slider-no="'.$counter_lightbox.'" alt="'.$attachment_meta['alt'].'" class="img-responsive lightbox_trigger" />
                           </a>
                        </div>';

            $captions .= '<span data-slide-to="'.($counter-1).'" class="'.$active.'" >'. $attachment_meta['caption'].'</span>';

        }



        foreach ($post_attachments as $attachment) {
            $counter++;
            $counter_lightbox++;
            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $preview            = wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
            }
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'full');
            $attachment_meta    = wp_get_attachment($attachment->ID);

            $indicators.= ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'">
                                <img  src="'.$preview[0].'"  alt="slider" />
                            </li>';
            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'"></li>';

            $slides .= '<div class="item '.$active.'">
                        <a href="'.$full_prty[0].'" rel="prettyPhoto" class="prettygalery" title="'.$attachment_meta['caption'].'"  >
                            <img  src="'.$full_img[0].'" data-slider-no="'.$counter_lightbox.'"  alt="'.$attachment_meta['alt'].'"  class="img-responsive lightbox_trigger" />
                         </a>
                        </div>';

            $captions .= '<span data-slide-to="'.($counter-1).'" class="'.$active.'">'. $attachment_meta['caption'].'</span>';
        }// end foreach

        $header_type                =   get_post_meta ( $propid, 'header_type', true);
        $global_header_type         =   wpresidence_get_option('wp_estate_header_type','');


        if ( $header_type == 0 ){ // global
            if ($global_header_type != 4){
                $gmap_lat                   =   esc_html( get_post_meta($propid, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($propid, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.$propid.'" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';

                if($showmap=='yes'){
                    $return_string.='<div id="slider_enable_map" data-placement="bottom" data-original-title="'.esc_html__('Map','wpresidence-core').'">  <i class="fas fa-map-marker-alt"></i>        </div>';
                }

                $no_street=' no_stret ';
                if ( $showmap=='yes' && get_post_meta($propid, 'property_google_view', true) ==1){
                    $return_string.='  <div id="a"> <i class="fas fa-location-arrow"></i>    </div>';
                    $no_street='';
                }
                if($showmap=='yes'){
                    $return_string.='<div id="slider_enable_slider" data-placement="bottom" data-original-title="'.esc_html__('Image Gallery','wpresidence-core').'" class="slideron '.$no_street.'"><i class="far fa-image"></i>         </div>
                    <div id="gmapzoomplus"  class="smallslidecontrol"><i class="fas fa-plus"></i> </div>
                    <div id="gmapzoomminus" class="smallslidecontrol"><i class="fas fa-minus"></i></div>';
                    $return_string.=wpestate_show_poi_onmap();

                    $return_string.='<div id="googleMapSlider" '.$property_add_on.' ></div>';
                }
            }


        }else{
            if($header_type!=5){
                $gmap_lat                   =   esc_html( get_post_meta($propid, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($propid, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.$propid.'" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';

                if($showmap=='yes'){
                    $return_string.='<div id="slider_enable_map" data-placement="bottom" data-original-title="'.esc_html__('Map','wpresidence-core').'">    <i class="fas fa-map-marker-alt"></i>        </div>';
                }

                $no_street=' no_stret ';

                if (  $showmap=='yes' && get_post_meta($propid, 'property_google_view', true) ==1){
                    $return_string.= '  <div id="slider_enable_street" data-placement="bottom" data-original-title="'.esc_html__('Street View','wpresidence-core').'"> <i class="fas fa-location-arrow"></i>    </div>';
                    $no_street  ='';
                }

                if($showmap=='yes'){
                    $return_string.='<div id="slider_enable_slider" data-placement="bottom" data-original-title="'.esc_html__('Image Gallery','wpresidence-core').'" class="slideron '.$no_street.'"> <i class="far fa-image"></i></div>
                    <div id="gmapzoomplus"  class="smallslidecontrol" ><i class="fas fa-plus"></i> </div>
                    <div id="gmapzoomminus" class="smallslidecontrol" ><i class="fas fa-minus"></i></div>';
                    $return_string.=wpestate_show_poi_onmap();
                    $return_string.='<div id="googleMapSlider" '.$property_add_on.' ></div>';
                }


            }

        }



    $return_string.='
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        '.$slides.'
    </div>

    <!-- Indicators -->
    <!-- <div class="carusel-back"></div>  -->
    <ol  id="carousel-indicators-vertical">
        '.$indicators.'
    </ol>

    <!--
    <ol class="carousel-round-indicators">
       '.$round_indicators.'
    </ol>
    -->

    <div class="caption-wrapper vertical-wrapper">
        <div class="vertical-wrapper-back"></div>
        '.$captions.'
     <!--   <div class="caption_control"></div> -->
    </div>

    <!-- Controls -->
    <a class="left vertical carousel-control" href="#carousel-listing" data-slide="prev">
      <i class="demo-icon icon-left-open-big"></i>
    </a>
    <a class="right vertical carousel-control" href="#carousel-listing" data-slide="next">
      <i class="demo-icon icon-right-open-big"></i>
    </a>
    </div>';


    } // end if post_attachments

    return $return_string;
}





















function wpestate_shortcode_listing_slider($propid,$showmap){
    global $slider_size;
    $return_string  =   '';
    $video_id       =   '';
    $video_thumb    =   '';
    $video_alone    =   0;
    $counter_lightbox   =   0;
    $full_img       =   '';
    $arguments      = array(
                        'numberposts' => -1,
                        'post_type' => 'attachment',
                        'post_mime_type' => 'image',
                        'post_parent' => $propid,
                        'post_status' => null,
                        'exclude' => get_post_thumbnail_id($propid),
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    );

    $post_attachments   = get_posts($arguments);

    $video_id           = esc_html( get_post_meta($propid, 'embed_video_id', true) );
    $video_type         = esc_html( get_post_meta($propid, 'embed_video_type', true) );



    if ($post_attachments || has_post_thumbnail($propid) || get_post_meta($propid, 'embed_video_id', true)) {
        $return_string.='<div id="carousel-listing" class="carousel slide post-carusel" data-ride="carousel" data-interval="false">';


        $return_string.=  wpestate_return_property_status($propid,'horizontalstatus');


        $indicators='';
        $round_indicators='';
        $slides ='';
        $captions='';
        $counter=0;
        $has_video=0;

        if($video_id!=''){
            $has_video  =   1;
            $counter    =   1;
            $videoitem  =   'videoitem';
            if ($slider_size    ==  'full'){
                $videoitem  =  'videoitem_full';
            }


            $indicators.='<li data-target="#carousel-listing"  data-video_data="'.$video_type.'" data-video_id="'.$video_id.'"  data-slide-to="0" class="active video_thumb_force">
                         <img src= "'.wpestate_get_video_thumb($propid).'" alt="video_thumb" class="img-responsive"/>
                         <span class="estate_video_control"><i class="fas fa-play"></i> </span>
                         </li>';

            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="0" class="active"></li>';

            $slides .= '<div class="item active '.$videoitem.'" data-number="'.$counter.'">';

            if($video_type=='vimeo'){
                $slides .= wpestate_custom_vimdeo_video($video_id);
            }else{
                $slides.= wpestate_custom_youtube_video($video_id);
            }

            $slides   .= '</div>';
            $captions .= '<span data-slide-to="0" class="active" >'.esc_html__('Video','wpresidence-core').'</span>';
        }

        if( has_post_thumbnail($propid) ){
            $counter++;
            $counter_lightbox++;
            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $post_thumbnail_id  = get_post_thumbnail_id( $propid );
            $preview            = wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');

            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider');
            }

            $full_prty          = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            $attachment_meta    = wp_get_attachment($post_thumbnail_id);

            $indicators.= '<li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'">
                                <img  src="'.$preview[0].'"  alt="slider" />
                           </li>';

            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'" ></li>';
            $slides .= '<div class="item '.$active.' " data-number="'.$counter.'" >
                           <a href="'.$full_prty[0].'" title="'.get_post($post_thumbnail_id)->post_excerpt.'"  rel="prettyPhoto" class="prettygalery">
                                <img  src="'.$full_img[0].'" data-slider-no="'.$counter_lightbox.'" alt="'.$attachment_meta['alt'].'" class="img-responsive lightbox_trigger" />
                           </a>
                        </div>';

            $captions .= '<span data-slide-to="'.($counter-1).'" class="'.$active.'" >'. $attachment_meta['caption'].'</span>';

        }



        foreach ($post_attachments as $attachment) {
            $counter++;
            $counter_lightbox++;
            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $preview            = wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
            }
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'full');
            $attachment_meta    = wp_get_attachment($attachment->ID);

            $indicators.= ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'">
                                <img  src="'.$preview[0].'"  alt="slider" />
                            </li>';
            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'"></li>';

            $slides .= '<div class="item '.$active.'" data-number="'.$counter.'">
                        <a href="'.$full_prty[0].'" rel="prettyPhoto" class="prettygalery" title="'.$attachment_meta['caption'].'"  >
                            <img  src="'.$full_img[0].'" data-slider-no="'.$counter_lightbox.'" alt="'.$attachment_meta['alt'].'" class="img-responsive lightbox_trigger" />
                         </a>
                        </div>';

            $captions .= '<span data-slide-to="'.($counter-1).'" class="'.$active.'"> '. $attachment_meta['caption'].'</span>';
        }// end foreach

        $header_type                =   get_post_meta ( $propid, 'header_type', true);
        $global_header_type         =   wpresidence_get_option('wp_estate_header_type','');



    if ( $header_type == 0 ){ // global
        if ($global_header_type != 4){
                $gmap_lat                   =   esc_html( get_post_meta($propid, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($propid, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.$propid.'" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';

                if($showmap=='yes'){
                    $return_string.='<div id="slider_enable_map" data-placement="bottom" data-original-title="'.esc_html__('Map','wpresidence-core').'">    <i class="fas fa-map-marker-alt"></i>        </div>';
                }

                $no_street=' no_stret ';
                if ( $showmap=='yes' && get_post_meta($post->ID, 'property_google_view', true) ==1){
                    $return_string.= '  <div id="slider_enable_street" data-placement="bottom" data-original-title="'.esc_html__('Street View','wpresidence-core').'" > <i class="fas fa-location-arrow"></i>    </div>';
                    $no_street='';
                }

                if($showmap=='yes'){
                    $return_string.='<div id="slider_enable_slider" data-placement="bottom" data-original-title="'.esc_html__('Image Gallery','wpresidence-core').'" class="slideron '.$no_street.'"><i class="far fa-image"></i>        </div>';

                    $return_string.='<div id="gmapzoomplus"  class="smallslidecontrol"><i class="fas fa-plus"></i> </div>
                    <div id="gmapzoomminus" class="smallslidecontrol"><i class="fas fa-minus"></i></div>';
                    $return_string.=wpestate_show_poi_onmap();
                    $return_string.='<div id="googleMapSlider" '.$property_add_on.' > </div>';
                }


        }
    }else{
        if($header_type!=5){
                $gmap_lat                   =   esc_html( get_post_meta($propid, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($propid, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.$propid.'" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';
                if($showmap=='yes'){
                    $return_string.='<div id="slider_enable_map" data-placement="bottom" data-original-title="'.esc_html__('Map','wpresidence-core').'">  <i class="fas fa-map-marker-alt"></i>        </div>';
                }

                $no_street=' no_stret ';
                if ($showmap=='yes' && get_post_meta($propid, 'property_google_view', true) ==1){
                    $return_string.= '  <div id="slider_enable_street" data-placement="bottom" data-original-title="'.esc_html__('Street View','wpresidence-core').'" > <i class="fas fa-location-arrow"></i>    </div>';
                    $no_street='';
                }

                if($showmap=='yes'){
                    $return_string.='
                    <div id="slider_enable_slider" data-placement="bottom" data-original-title="'.esc_html__('Image Gallery','wpresidence-core').'" class="slideron  '.$no_street.'"><i class="far fa-image"></i>         </div>

                    <div id="gmapzoomplus"  class="smallslidecontrol" ><i class="fas fa-plus"></i> </div>
                    <div id="gmapzoomminus" class="smallslidecontrol" ><i class="fas fa-minus"></i></div>';
                    $return_string.=wpestate_show_poi_onmap();
                    $return_string.='<div id="googleMapSlider" '.$property_add_on.' ></div> ';
                }



        }
    }


    $return_string.='
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      '.$slides.'
    </div>

    <!-- Indicators -->
    <div class="carusel-back"></div>
    <ol class="carousel-indicators">
      '.$indicators.'
    </ol>

    <ol class="carousel-round-indicators">
       '.$round_indicators.'
    </ol>

    <div class="caption-wrapper">
        '.$captions.'
        <div class="caption_control"></div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-listing" data-slide="prev">
        <i class="demo-icon icon-left-open-big"></i>
    </a>
    <a class="right carousel-control" href="#carousel-listing" data-slide="next">
        <i class="demo-icon icon-right-open-big"></i>
    </a>
    </div>';


    } // end if post_attachments

    return $return_string;
}






if( !function_exists('wpestate_estate_property_details_section') ):
function wpestate_estate_property_details_section($attributes,$content = null){
    global $post;
    global $propid ;

    $return_string  ='';
    $detail         ='';
    $label          ='';
    $css_class      ='';


    extract(shortcode_atts(array(
            'css'              =>   '',
            'detail'           =>   'none',
            'columns'          =>   '3',
            'is_elementor'     =>   '',
    ), $attributes));

    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }

    switch ($detail) {
        case  'Energy Certificate':
            $return_string.=   '<div class="property_energy_saving_info">'.wpestate_energy_save_features($propid).'</div> ';
            break;
        case 'Description':
            $return_string.=   estate_listing_content($propid);
            break;
        case  'Property Address':
            $return_string.=   estate_listing_address($propid,'',$attributes['columns']);
            break;
         case  'Property Details':
            $wpestate_prop_all_details  =   get_post_custom($propid);
            $return_string.=  estate_listing_details($propid,$wpestate_prop_all_details,$attributes['columns']);
            break;

        case  'Amenities and Features':
            $return_string.='<div class="wpestate_estate_property_details_section">'.   estate_listing_features($propid,3,0,$attributes['columns']).'</div>';
            break;
        case  'Map':
            $return_string.=do_shortcode('[property_page_map propertyid="'.$propid.'" istab="1"][/property_page_map]');
            break;
         case  'Virtual Tour':
            ob_start();
            wpestate_virtual_tour_details($propid);
            $return_string= ob_get_contents();
            ob_end_clean();
            break;
        case  'Walkscore':
            ob_start();
            wpestate_walkscore_details($propid);
            $return_string= ob_get_contents();
            ob_end_clean();
            break;
        case 'Reviews':
            ob_start();
            if(wpresidence_get_option('wp_estate_show_reviews_prop','')=='yes'){
                include( locate_template ('/templates/listing_templates/property-page-templates/property_reviews.php' ) );
        
            }
            $return_string= ob_get_contents();
            ob_end_clean();
            break;
        case  'Floor Plans':
            ob_start();
            estate_floor_plan($propid);
            $return_string.=  ob_get_contents();
            ob_end_clean();
            break;
        case  'Page Views':
            $return_string.='<canvas id="myChart"></canvas>';
            $return_string.='<script type="text/javascript">
                //<![CDATA[
                    jQuery(document).ready(function(){
                         wpestate_show_stat_accordion();
                    });

                //]]>
            </script>';
            break;


        case 'What\'s Nearby':
            ob_start();
            wpestate_yelp_details($propid);
            $return_string= ob_get_contents();
            ob_end_clean();
            break;

        case  'Subunits':
            ob_start();
            wpestate_subunits_details($propid);
            $return_string= ob_get_contents();
            ob_end_clean();
            break;

        case 'Video':
            ob_start();
           print wpestate_listing_video($propid);
            $return_string= ob_get_contents();
            ob_end_clean();
            break;

    }

    return '<div class="wpestate_estate_property_details_section '.$css_class.'">'.$return_string.'</div>';
}
endif;








if( !function_exists('wpestate_estate_property_simple_detail') ):
function wpestate_estate_property_simple_detail($attributes,$content = null){
    global $post;
    global $propid ;

    $return_string  ='';
    $detail         ='';
    $label          ='';


    $features_details   =   array();


    $feature_terms        =   get_terms( array(
                                'taxonomy' => 'property_features',
                                'hide_empty' => false,
                            ));

    if(is_array($feature_terms)){
        foreach($feature_terms as $key => $term){
            $features_details[$term->slug] =      $term->name;
        }
    }


    $attributes = shortcode_atts(
        array(
            'detail'           =>   'none',
            'label'            =>   'Label:',
            'is_elementor'      =>    ''
        ), $attributes );



    if ( isset($attributes['detail']) ){
        $detail  = $attributes['detail'];
    }
    if ( isset($attributes['label']) ){
        $label  = $attributes['label'];
    }

    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }




    if(in_array ($detail,$features_details) ){
         if( has_term( $detail, 'property_features',$propid )){
            $return_string.='yes';
        }else{
            $return_string.='no';
        }
    }else{
        if($detail=='title'){
            $return_string.=get_the_title($propid);
        }else if($detail =='property_agent'){
             $return_string.=get_the_title(get_post_meta($propid,$detail,true));
        }else if($detail =='property_price'){
            $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
            $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
            $return_string.= wpestate_show_price($propid,$wpestate_currency,$where_currency,1);

        }else if($detail =='description'){
            $return_string.= estate_listing_content($propid);
        }else if($detail =='energy_certificate'){
           $return_string.=  '<div class="property_energy_saving_info">'.wpestate_energy_save_features($propid).'</div>';
        }else if($detail =='property_pdf'){
               $return_string.=''. wpestate_property_sh_download_pdf($propid);
        }else if($detail=='property_status'){
            $return_string.= get_the_term_list($propid,'property_status','',',','');
        }else if( $detail=='property_size' ){
            $return_string.=    wpestate_get_converted_measure( $propid, 'property_size' );
        }else if( $detail=='property_lot_size' ){
            $return_string.=    wpestate_get_converted_measure( $propid, 'property_lot_size' );
        }else if($detail =='property_category' || $detail =='property_action_category' || $detail =='property_city' || $detail =='property_area' || $detail =='property_county_state' ){
            $return_string .=  get_the_term_list($propid, $detail, '', ', ', '') ;
        }else if( $detail=='property_video'){
            $return_string .= wpestate_listing_video($propid);
        }else{
            $meta_value = get_post_meta($propid,$detail,true);
            $meta_value = apply_filters( 'wpml_translate_single_string', $meta_value, 'wpresidence-core', 'wp_estate_property_custom_'.$meta_value );
            if( $meta_value!= esc_html__('Not Available','wpresidence-core') ){
                $return_string.=$meta_value;
            }
        }

    }

    if($return_string!=''){
        $return_string_final='<div class="property_custom_detail_wrapper"><span class="property_custom_detail_label">'.$label.' </span>';
        $return_string_final.=$return_string;
        $return_string_final.='</div>';
        return $return_string_final;
    }else{
        return '';
    }

}
endif;




if( !function_exists('wpestate_property_sh_download_pdf') ):
function wpestate_property_sh_download_pdf($prop_id){
    $args = array(
            'post_mime_type'    => 'application/pdf',
            'post_type'         => 'attachment',
            'numberposts'       => -1,
            'post_status'       => null,
            'post_parent'       => $prop_id
        );

    $return_string='';
    $attachments = get_posts($args);

    if ($attachments) {

        $return_string.= '<div class="download_docs">'.esc_html__('Documents','wpresidence-core').'</div>';
        foreach ( $attachments as $attachment ) {
                $return_string .= '<div class="document_down">';
                ob_start();
                include (locate_template('templates/svg_icons/pdf_icon.html'));
                $icon=ob_get_contents();
                ob_clean();

                $return_string .= $icon.'<a href="' . esc_url(wp_get_attachment_url($attachment->ID)) . '" target="_blank">' . esc_html($attachment->post_title) . '</a></div>';
            
            
           // $return_string.=  '<div class="document_down"><a href="'. wp_get_attachment_url($attachment->ID).'" target="_blank">'.$attachment->post_title.'<i class="fas fa-download"></i></a></div>';
        }
    }
    return $return_string;
}
endif;


if( !function_exists('wpestate_property_page_design_acc') ):
function wpestate_property_page_design_acc($attributes,$content = null){
    global $post;
    global $propid ;
    $return_string='';

    $description        =   '';
    $property_address   =   '';
    $property_details   =   '';
    $amenities_features =   '';
    $map                =   '';
    $virtual_tour       =   '';
    $walkscore          =   '';
    $floor_plans        =   '';
    $page_views         =   '';
    $yelp_details       =   '';
    $virtual_tour       =   '';
    $style              =   1;


    extract(shortcode_atts(array(
            'css'                   =>   '',
            'description'           => esc_html__("Description","wpresidence-core"),
            'property_address'      => esc_html__("Property Address","wpresidence-core"),
            'property_details'      => esc_html__("Property Details","wpresidence-core"),
            'amenities_features'    => esc_html__("Amenities and Features","wpresidence-core"),
            'map'                   => esc_html__("Map","wpresidence-core"),
            'virtual_tour'          => esc_html__("Virtual Tour","wpresidence-core"),
            'walkscore'             => esc_html__("Walkscore","wpresidence-core"),
            'floor_plans'           => esc_html__("Floor Plans","wpresidence-core"),
            'page_views'            => esc_html__("Page Views","wpresidence-core"),
            'yelp_details'          => esc_html__("Yelp Details","wpresidence-core"),
            'style'                 => esc_html__("all open","wpresidence-core"),
            'is_elementor'          =>  ''
    ), $attributes));


    if(intval($propid)==0 && isset( $attributes['is_elementor']) &&  intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }
    $css_class='';
    if(function_exists('vc_shortcode_custom_css_class')){
        $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'', $attributes );
    }

    $return_string.='<div class="'.$css_class.'">';
    $return_string.= estate_property_page_generated_acc($css_class,$propid,$style,$description,$property_address,$property_details,$amenities_features,$map,$virtual_tour,$walkscore,$floor_plans,$page_views,$yelp_details);
    $return_string.='</div>';

    return $return_string;
}
endif;



if( !function_exists('estate_property_page_generated_acc') ):
function estate_property_page_generated_acc($css_class,$propid,$style,$description,$property_address,$property_details,$amenities_features,$map,$virtual_tour,$walkscore,$floor_plans,$page_views,$yelp_details){
    $walkscore_api      =   esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );
    $show_graph_prop_page   = esc_html( wpresidence_get_option('wp_estate_show_graph_prop_page', '') );
    $random             =   rand(0,99999);
    $return             =   '';

    $expand             =   "true";
    $active_class       =   "";
    $active_class_tab   =   " in ";


    if( $style==esc_html__("all closed","wpresidence-core")  ){
        $expand             =   ' aria-expanded"false" ';
        $active_class       =   " collapsed ";
        $active_class_tab   =   " collapse ";
    }

    if(  $style==esc_html__("only the first one open","wpresidence-core") ){
        $expand             =   "true";
        $active_class       =   "";
        $active_class_tab   =   " in ";
    }


    if($description!=''){
        $return.='
        <div class="panel-group property-panel  " id="accordion_prop_description'.$random.'">
            <div class="panel panel-default">
               <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_prop_description'.$random.'" href="#collapseDesc'.$random.'" class="'.$active_class.'">
                        <h4 class="panel-title">'.$description.'</h4>
                    </a>
               </div>
               <div id="collapseDesc'.$random.'" class="panel-collapse collapse '.$active_class_tab.' ">
                 <div class="panel-body">';
                    $return.=   estate_listing_content($propid);
                    $return.= '
                 </div>
               </div>
            </div>
        </div>';

        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }

    }

    if($property_address!=''){
        $return.= '
        <div class="panel-group property-panel" id="accordion_prop_addr'.$random.'">
            <div class="panel panel-default">
               <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_prop_addr'.$random.'" href="#collapseTwo'.$random.'" class="'.$active_class.'">
                        <h4 class="panel-title">'.$property_address.'</h4>
                    </a>
               </div>
               <div id="collapseTwo'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                 <div class="panel-body">
                    '.estate_listing_address($propid).'
                 </div>
               </div>
            </div>
        </div>';
        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }
    }

    if($property_details!=''){
        $wpestate_prop_all_details  =   get_post_custom($propid);
        $return.= '
        <div class="panel-group property-panel" id="accordion_prop_details'.$random.'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_prop_details'.$random.'" href="#collapseOne'.$random.'" class="'.$active_class.'">
                        <h4 class="panel-title"  id="prop_det">'.$property_details.'  </h4>
                    </a>
                </div>
                <div id="collapseOne'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                  <div class="panel-body">
                  '.estate_listing_details($propid,$wpestate_prop_all_details,'').'
                  </div>
                </div>
            </div>
        </div>';
        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }
    };

    if($amenities_features!=''){
        $return.= '
        <div class="panel-group property-panel" id="accordion_prop_features'.$random.'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_prop_features'.$random.'" href="#collapseThree'.$random.'" class="'.$active_class.'">
                       <h4 class="panel-title" id="prop_ame">'. $amenities_features.'</h4>
                    </a>
                </div>
                <div id="collapseThree'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                    <div class="panel-body">
                     '.estate_listing_features($propid,'',0,'',$wpestate_prop_all_details).'
                    </div>
                </div>
            </div>
        </div> ';
        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }
    }


    if($map!=''){
        $tab_flag=1;
        if($style==esc_html__("all open","wpresidence-core")){
             $tab_flag=2;
        }
        $return.='
        <div class="panel-group property-panel" id="accordion_prop_map'.$random.'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_prop_map'.$random.'" href="#collapsemap'.$random.'" class="shacctab '.$active_class.'">
                        <h4 class="panel-title" id="prop_ame">'.$map.'</h4>
                    </a>
                </div>
                <div id="collapsemap'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                  <div class="panel-body">'
                    .do_shortcode('[property_page_map propertyid="'.$propid.'" istab="'.$tab_flag.'"][/property_page_map]').
                  '</div>
                </div>
            </div>
        </div>';


        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }

    }

    $virtual_tour_content                  =   trim(get_post_meta($propid, 'embed_virtual_tour', true));
    if($virtual_tour!='' && $virtual_tour_content!=''){
        $return.='
        <div class="panel-group property-panel" id="accordion_virtual_tour'.$random.'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_virtual_tour'.$random.'" href="#collapseNine'.$random.'" class="'.$active_class.'">
                        <h4 class="panel-title" id="prop_ame">'.$virtual_tour.'</h4>
                    </a>
                </div>

                <div id="collapseNine'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                    <div class="panel-body">';
                        $temp='';
                        if ( $virtual_tour!=''){
                            ob_start();
                            wpestate_virtual_tour_details($propid);
                            $temp=ob_get_contents();
                            ob_end_clean();
                        }
                      $return.=$temp.'
                    </div>
                </div>
            </div>
        </div>';
        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }
    }




    $walkscore_api= esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );

    if($walkscore!='' && $walkscore_api!=''){
        $return.='
        <div class="panel-group property-panel" id="accordion_walkscore'.$random.'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_walkscore'.$random.'" href="#collapseFour'.$random.'" class="'.$active_class.'">
                        <h4 class="panel-title" id="prop_ame">'.$walkscore.'</h4>
                    </a>
                </div>

                <div id="collapseFour'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                    <div class="panel-body">';
                        $temp='';
                        if ( $walkscore_api!=''){
                            ob_start();
                            wpestate_walkscore_details($propid);
                            $temp=ob_get_contents();
                            ob_end_clean();
                        }
                      $return.=$temp.'
                    </div>
                </div>
            </div>
        </div>';
        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }
    }





    $plan_title_array   = get_post_meta($propid, 'plan_title', true);

    if ( $floor_plans!='' && is_array($plan_title_array) ){
        $return.='
        <div class="panel-group property-panel" id="accordion_prop_floor_plans'.$random.'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_prop_floor_plans'.$random.'" href="#collapseflplan'.$random.'" class="'.$active_class.'">
                       <h4 class="panel-title" id="prop_floor">'.$floor_plans.'</h4>
                    </a>
                </div>

                <div id="collapseflplan'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                    <div class="panel-body">';
                        ob_start();
                        estate_floor_plan($propid);
                        $temp=  ob_get_contents();
                        ob_end_clean();
                    $return.=$temp.'
                    </div>
                </div>
            </div>
        </div>';
        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }
    }


    if($page_views!=''){

        $return.='
        <div class="panel-group property-panel accordion_prop_stat" id="accordion_prop_stat'.$random.'">
            <div class="panel panel-default">
               <div class="panel-heading">
                   <a data-toggle="collapse" '.$expand.' data-parent="#accordion_prop_stat'.$random.'" href="#collapseSeven'.$random.'" class="'.$active_class.' property_design_page_views">
                    <h4 class="panel-title">'.$page_views.'</h4>
                   </a>
               </div>
               <div id="collapseSeven'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                 <div class="panel-body">
                    <canvas id="myChart" style="min-height:400px;width:100%;"></canvas>
                 </div>
               </div>
            </div>
        </div>';
        if($style==esc_html__("all open","wpresidence-core")){
            $return.='<script type="text/javascript">
                //<![CDATA[
                    jQuery(document).ready(function(){
                        wpestate_show_stat_accordion();
                    });

                //]]>
             </script>';
        }

        $return.='<script type="text/javascript">
                //<![CDATA[
                    jQuery(document).ready(function(){
                     wpestate_show_stat_accordion();
                        jQuery("#accordion_prop_stat'.$random.'").on("shown.bs.collapse", function () {

                        setTimeout(function(){   wpestate_show_stat_accordion(); }, 200);
                    });
                });
                //]]>
            </script>';

        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }
    }


    $yelp_client_id             =   wpresidence_get_option('wp_estate_yelp_client_id','');
    $yelp_client_api_key_2018   =   wpresidence_get_option('wp_estate_yelp_client_api_key_2018','');

    if($yelp_details!='' && $yelp_client_api_key_2018!='' && $yelp_client_id!=''  ){
        $return.='
        <div class="panel-group property-panel" id="accordion_yelp'.$random.'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a data-toggle="collapse" '.$expand.' data-parent="#accordion_yelp'.$random.'" href="#collapseTen'.$random.'" class="'.$active_class.'">
                        <h4 class="panel-title" id="prop_yelp">'.$yelp_details.'</h4>
                    </a>
                </div>

                <div id="collapseTen'.$random.'" class="panel-collapse collapse '.$active_class_tab.'">
                    <div class="panel-body">';
                        $temp='';
                        ob_start();
                        wpestate_yelp_details($propid);
                        $temp=  ob_get_contents();
                        ob_end_clean();

                      $return.=$temp.'
                    </div>
                </div>
            </div>
        </div>';
        if($style==esc_html__("only the first one open","wpresidence-core")){
            $expand             =   ' aria-expanded"false" ';
            $active_class       =   " collapsed ";
            $active_class_tab   =   " collapse ";
        }
    }
    return $return;

}
endif;




function wpestate_property_page_design_tab($attributes,$content = null){
    global $post;
    global $propid ;
    $return_string='';

    $description        =   '';
    $property_address   =   '';
    $property_details   =   '';
    $amenities_features =   '';
    $map                =   '';
    $walkscore          =   '';
    $floor_plans        =   '';
    $page_views         =   '';
    $yelp_details       =   '';


    $attributes = shortcode_atts(
        array(
            'description'           =>esc_html__("Description","wpresidence-core"),
            'property_address'      => esc_html__("Property Address","wpresidence-core"),
            'property_details'      => esc_html__("Property Details","wpresidence-core"),
            'amenities_features'    => esc_html__("Amenities and Features","wpresidence-core"),
            'map'                   => esc_html__("Map","wpresidence-core"),
            'virtual_tour'          => esc_html__("Virtual Tour","wpresidence-core"),
            'walkscore'             => esc_html__("Walkscore","wpresidence-core"),
            'floor_plans'           => esc_html__("Floor Plans","wpresidence-core"),
            'page_views'            => esc_html__("Page Views","wpresidence-core"),
            'yelp_details'          => esc_html__("Yelp Details","wpresidence-core"),
             'is_elementor'         =>  ''
        ), $attributes );




    if(intval($propid)==0 && isset( $attributes['is_elementor']) && intval($attributes['is_elementor']==1) ){
        $propid = wpestate_return_elementor_id();
    }


    if ( isset($attributes['description']) ){
       $description= $attributes['description'];
    }

    if ( isset($attributes['property_address']) ){
       $property_address=$attributes['property_address'];
    }

    if ( isset($attributes['property_details']) ){
        $property_details=$attributes['property_details'];
    }

    if ( isset($attributes['amenities_features']) ){
        $amenities_features=$attributes['amenities_features'];
    }

    if ( isset($attributes['map']) ){
        $map=$attributes['map'];
    }
    if ( isset($attributes['virtual_tour']) ){
        $virtual_tour=$attributes['virtual_tour'];
    }
    if ( isset($attributes['walkscore']) ){
        $walkscore=$attributes['walkscore'];
    }

    if ( isset($attributes['floor_plans']) ){
        $floor_plans=$attributes['floor_plans'];
    }

    if ( isset($attributes['page_views']) ){
        $page_views=$attributes['page_views'];
    }

     if ( isset($attributes['subunits']) ){
        $subunits=$attributes['subunits'];
    }



    if ( isset($attributes['yelp_details']) ){
        $yelp_details=$attributes['yelp_details'];
    }



    // $return_string.='//'.$propid.'//';

    $return_string.= estate_property_page_generated_tab($propid,$description,$property_address,$property_details,$amenities_features,$map,$virtual_tour,$walkscore,$floor_plans,$page_views,$yelp_details);

    return $return_string;
}


if( !function_exists('estate_property_page_generated_tab') ):
function estate_property_page_generated_tab($propid,$description,$property_address,$property_details,$amenities_features,$map,$virtual_tour,$walkscore,$floor_plans,$page_views,$yelp_details){
    $walkscore_api      =   esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );
    $show_graph_prop_page   = esc_html( wpresidence_get_option('wp_estate_show_graph_prop_page', '') );
    $random             =   rand(0,99999);
    $return             =   '<div role="tabpanel" id="tab_prpg"> <ul class="nav nav-tabs custom_template_tab" role="tablist">';
    $active_class       =   " active ";
    $active_class_tab   =   " active ";
    $yelp_client_id             =   wpresidence_get_option('wp_estate_yelp_client_id','');
    $yelp_client_api_key_2018   =   wpresidence_get_option('wp_estate_yelp_client_api_key_2018','');


    if($description!=''){
        $return.='<li role="presentation" class="'.$active_class.'" >
        <a href="#description'.$random.'" aria-controls="description'.$random.'" role="tab" data-toggle="tab">
        '.$description.'
        </a>
        </li>';
        $active_class= '';
    }

    if($property_address!=''){
        $return.='<li role="presentation" class="'.$active_class.'">
        <a href="#address'.$random.'" aria-controls="address'.$random.'" role="tab" data-toggle="tab">
        '.$property_address.'
        </a>
        </li>';
        $active_class= '';
    }

    if($property_details!=''){
        $return.='<li role="presentation" class="'.$active_class.'">
        <a href="#details'.$random.'" aria-controls="details'.$random.'" role="tab" data-toggle="tab">
        '.$property_details.'
        </a>
        </li>';
        $active_class= '';
    }

    if($amenities_features!=''){
        $return.='<li role="presentation" class="'.$active_class.'">
        <a href="#features'.$random.'" aria-controls="features'.$random.'" role="tab" data-toggle="tab">
        '.$amenities_features.'
        </a>
        </li>';
        $active_class= '';
    }

    if($map!=''){
        $return.='<li role="presentation" class="shtabmap '.$active_class.'">
        <a href="#propmap'.$random.'" aria-controls="propmap'.$random.'" role="tab" data-toggle="tab">
        '.$map.'
        </a>
        </li>';
        $active_class= '';
    }

    $virtual_tour_content                  =   trim(get_post_meta($propid, 'embed_virtual_tour', true));

    if($virtual_tour!='' && $virtual_tour_content!=''){
        $active_class= '';
        $return.='<li role="presentation" class="'.$active_class.'">
        <a href="#virtual_tour'.$random.'" aria-controls="virtual_tour'.$random.'" role="tab" data-toggle="tab">
        '.$virtual_tour.'
        </a>
        </li>';
        $active_class= '';
    }


    if($walkscore!='' && $walkscore_api!=''){
        $active_class= '';
        $return.='<li role="presentation" class="'.$active_class.'">
        <a href="#walkscore'.$random.'" aria-controls="walkscore'.$random.'" role="tab" data-toggle="tab">
        '.$walkscore.'
        </a>
        </li>';
        $active_class= '';
    }

    $plan_title_array   = get_post_meta($propid, 'plan_title', true);

    if($floor_plans!='' && is_array($plan_title_array) ){
        $return.='<li role="presentation" class=" '.$active_class.'" >
        <a href="#floor'.$random.'" aria-controls="floor'.$random.'" role="tab" data-toggle="tab">
        '.$floor_plans.'
        </a>
        </li>';
        $active_class= '';
    }

    $ajax_nonce = wp_create_nonce( "wpestate_tab_stats" );
    if($page_views!=''){
        $return.='<li role="presentation" class="tabs_stats '.$active_class.'" data-listingid="'. intval($propid).'">
        <a href="#stats'.$random.'" aria-controls="stats'.$random.'" role="tab" data-toggle="tab">
        <input type="hidden" id="wpestate_tab_stats" value="'.esc_html($ajax_nonce).'" />
        '.$page_views.'
        </a>
        </li>';
        $active_class= '';
    }



    if($yelp_client_api_key_2018!='' && $yelp_client_id!='' && $yelp_details!='' ){
        $return.='<li role="presentation" class="tabs_stats '.$active_class.'" data-listingid="'. intval($propid).'">
        <a href="#yelp'.$random.'" aria-controls="yelp'.$random.'" role="tab" data-toggle="tab">
        '.$yelp_details.'
        </a>
        </li>';
        $active_class= '';
    }






    $return .=' </ul>';

    ///////////////////////////////////////////////////////////////////////////

    $return .='<div class="tab-content">';
    if($description!=''){
        $return.='<div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="description'.$random.'">';
        $return.=   estate_listing_content($propid);

        $return.='</div>';
        $active_class_tab ='';
    }

    if($property_address!=''){
        $return.='<div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="address'.$random.'">
        '.estate_listing_address($propid).'
        </div>';
        $active_class_tab ='';
    }

    if($property_details!=''){
        $wpestate_prop_all_details  =   get_post_custom($propid);
        $return.='<div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="details'.$random.'">
        '.estate_listing_details($propid,$wpestate_prop_all_details,'').'
        </div>';
        $active_class_tab ='';
    }

 
    if($amenities_features!=''){
        $wpestate_prop_all_details  =   get_post_custom($propid);
        $return.='<div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="features'.$random.'">
       
        '.estate_listing_features($propid,'',0,'',$wpestate_prop_all_details).'
        </div>';
        $active_class_tab ='';
    }
    
    if($map!=''){
        $return.='<div role="propmap" class="tab-pane   '.$active_class_tab.'" id="propmap'.$random.'">'
        .do_shortcode('[property_page_map propertyid="'.$propid.'" istab="1"][/property_page_map]').
        '</div>';

        $active_class_tab ='';
    }


    if($virtual_tour!='' && $virtual_tour_content!=''){
        $return.='<div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="virtual_tour'.$random.'">';
        if($virtual_tour!=''){
            ob_start();
            wpestate_virtual_tour_details($propid);
            $temp=  ob_get_contents();
            ob_end_clean();
            $return.=$temp;
        }
        $return.='</div>';
        $active_class_tab ='';
    }

    if($walkscore!='' && $walkscore_api!=''){
        $return.='<div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="walkscore'.$random.'">';
        if($walkscore_api!=''){
            ob_start();
            wpestate_walkscore_details($propid);
            $temp=  ob_get_contents();
            ob_end_clean();
            $return.=$temp;
        }
        $return.='</div>';
        $active_class_tab ='';
    }

    if($floor_plans!='' && is_array($plan_title_array) ){
        $return.='<div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="floor'.$random.'">';
        ob_start();
        estate_floor_plan($propid);
        $temp=  ob_get_contents();
        ob_end_clean();

        $return.=$temp.'</div>';
        $active_class_tab ='';
    }

    if($page_views!=''){
        $return.='  <div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="stats'.$random.'">
             <div class="panel-body">
                <canvas id="myChart"></canvas>
             </div>
        </div>';
        $active_class_tab ='';
    }





    if($yelp_client_api_key_2018!='' && $yelp_client_id!=''  ){

        $return.='  <div role="tabpanel" class="tab-pane '.$active_class_tab.'" id="yelp'.$random.'">';
            $yelp_client_id         =   wpresidence_get_option('wp_estate_yelp_client_id','');
            $yelp_client_secret     =   wpresidence_get_option('wp_estate_yelp_client_secret','');
            $yelp_client_api_key_2018  =   wpresidence_get_option('wp_estate_yelp_client_api_key_2018','');
            if($yelp_client_api_key_2018!=='' && $yelp_client_id!==''  ){
                ob_start();
                wpestate_yelp_details($propid);
                $temp=  ob_get_contents();
                ob_end_clean();
                $return.=$temp;

            }
        $return.='</div>';
        $active_class_tab ='';
    }

    $return.=' </div></div>';



    return $return;
}
endif;


if( !function_exists('wpestate_test_sh') ):
function wpestate_test_sh( $attributes,$content = null) {
    global $post;
    global $propid ;
    $return_string='das is cxx '.$post->ID.' das is good '.$propid ;
    return $return_string;
}
endif;


if( !function_exists('wpestate_subunits_details') ):
function  wpestate_subunits_details($propid){
    
     $has_multi_units = intval(get_post_meta($propid, 'property_has_subunits', true));
    $property_subunits_master = intval(get_post_meta($propid, 'property_subunits_master', true));

    if ($has_multi_units == 1) {
        include( locate_template('/templates/multi_units.php') );
    } else {
        if ($property_subunits_master != 0) {
            include( locate_template('/templates/multi_units.php') );
        }
    }

  
    
//    
//    $has_multi_units=intval(get_post_meta($propid, 'property_has_subunits', true));
//    $property_subunits_master=intval(get_post_meta($propid, 'property_subunits_master', true));
//
//    if($has_multi_units==1){
//        wpestate_shortcode_multi_units($propid,$property_subunits_master);
//    }else{
//        if($property_subunits_master!=0){
//            wpestate_shortcode_multi_units($propid,$property_subunits_master);
//        }
//    }
}
endif;



if( !function_exists('wpestate_shortcode_multi_units') ):
function wpestate_shortcode_multi_units($propid,$property_subunits_master,$is_print=0){

    $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $prop_id=$propid;

    if (function_exists('icl_translate') ){
        $wp_estate_property_multi_text          =   icl_translate('wpresidence-core','wp_estate_property_multi_text', esc_html( wpresidence_get_option('wp_estate_property_multi_text') ) );
        $wp_estate_property_multi_child_text    =   icl_translate('wpresidence-core','wp_estate_property_multi_child_text', esc_html( wpresidence_get_option('wp_estate_property_multi_child_text') ) );
    }else{
        $wp_estate_property_multi_text          =   stripslashes ( esc_html( wpresidence_get_option('wp_estate_property_multi_text') ) );
        $wp_estate_property_multi_child_text    =   stripslashes ( esc_html( wpresidence_get_option('wp_estate_property_multi_child_text') ) );
    }

    $has_multi_units            =   intval(get_post_meta($prop_id, 'property_has_subunits', true));
    $property_subunits_master   =   intval(get_post_meta($prop_id, 'property_subunits_master', true));

    $display=0;
    if ($has_multi_units==1){
        $display=1;
    }else{
        if( intval($property_subunits_master)!=0 ){
            $has_multi_units=intval(get_post_meta($property_subunits_master, 'property_has_subunits', true));
            if ($has_multi_units==1){
                $display=1;
            }

        }else{
            $display=0;
        }
    }



    if( $display==1 ){
        print '<div class="multi_units_wrapper">';
        if( intval($property_subunits_master)!=0 && $property_subunits_master!=$propid){
            $prop_id=intval($property_subunits_master);

            print '<h4 class="panel-title">';
            if($wp_estate_property_multi_child_text!=''){
                echo $wp_estate_property_multi_child_text;
            }else{
               _e('Other units in','wpresidence-core');
            }
            echo ' <a href="'. esc_url( get_permalink($property_subunits_master) ).'" target="_blank">'.get_the_title($property_subunits_master).'</a>';
            print'</h4>';

        }else{

            print '<h4 class="panel-title">';

                if($wp_estate_property_multi_text!=''){
                    echo $wp_estate_property_multi_text;
                }else{
                    esc_html__('Available Units','wpresidence-core');
                }
            print '</h4>';

        }



        $measure_sys            = esc_html ( wpresidence_get_option('wp_estate_measure_sys','') );


        $property_subunits_list_manual =  get_post_meta($prop_id, 'property_subunits_list_manual', true);

        if($property_subunits_list_manual!=''){
            $property_subunits_list= explode(',', $property_subunits_list_manual);
        }else{
            $property_subunits_list   =  get_post_meta($prop_id, 'property_subunits_list', true);
        }

            if(is_array($property_subunits_list)){
                foreach($property_subunits_list as $prop_id_unit){
                    $status = get_post_status($prop_id);
                    if($prop_id!=$prop_id_unit && $status=='publish'){
                        print '<div class="subunit_wrapper">';
                        $compare                =   wp_get_attachment_image_src(get_post_thumbnail_id($prop_id_unit), 'slider_thumb');
                        $property_rooms         =   get_post_meta($prop_id_unit, 'property_rooms', true);
                        $property_bathrooms     =   get_post_meta($prop_id_unit, 'property_bathrooms', true) ;
                        $property_bedrooms         =   get_post_meta($prop_id_unit, 'property_bedrooms', true);
						/*
						$property_size          =   get_post_meta($prop_id_unit, 'property_size', true) ;
                        $property_size          =   wpestate_sizes_no_format(floatval($property_size));
						*/
						$property_size       = wpestate_get_converted_measure( $prop_id_unit, 'property_size' );

                        $property_type          =   get_the_term_list($prop_id_unit, 'property_category', '', ', ', '') ;


                        if($is_print==1){
                            $property_type_array  =   wp_get_object_terms($prop_id, 'property_category', '');
                            $property_type='';
                            foreach($property_type_array as $term){
                                if($term->name!=''){
                                    $property_type.=$term->name.' ' ;
                                }
                            }
                        }

                        $title                  =   get_the_title($prop_id_unit);
                        $link                   =    esc_url( get_permalink($prop_id_unit) );

                        if($is_print!=1){
                            print '<div class="subunit_thumb"><a href="'.$link.'" target="_blank"><img src="'.$compare[0].'" alt="'.$title.'" /></a></div>';
                        }else{
                              print '<div class="subunit_thumb"><img src="'.$compare[0].'" alt="'.$title.'" /></div>';
                        }
                            print '<div class="subunit_details">';

                                if($is_print==1){
                                    print '<img class="print_qrcode_subunit" src="https://chart.googleapis.com/chart?cht=qr&chs=110x110&chl='. urlencode( $link) .'&choe=UTF-8" title="'.urlencode($title).'" />';
                                }
                                if($is_print!=1){
                                    print '<div class="subunit_title"><a a href="'.$link.'" target="_blank">'.$title.'</a>  ';
                                }else{
                                    print '<div class="subunit_title">'.$title;
                                }
                                print '<div class="subunit_price">'; wpestate_show_price($prop_id_unit,$wpestate_currency,$where_currency);
                                print '</div></div>';
                                print '<div class="subunit_type"><strong>'.esc_html__('Category: ','wpresidence-core').'</strong> '.$property_type.', </div>';
                                print '<div class="subunit_rooms"><strong>'.esc_html__('Rooms: ','wpresidence-core').'</strong> '.$property_rooms.', </div>';
                                 print '<div class="subunit_rooms"><strong>'.esc_html__('Bedrooms: ','wpresidence-core').'</strong> '.$property_bedrooms.', </div>';
                             
                                print '<div class="subunit_bathrooms"><strong>'.esc_html__('Baths: ','wpresidence-core').'</strong> '.$property_bathrooms.', </div>';
                                print '<div class="subunit_size"><strong>'.esc_html__('Size: ','wpresidence-core').'</strong> '.$property_size.'</div>';
                            print '</div>';


                        print '</div>';
                    }

                }
            }



        print '</div>';
        }
    }
endif;


function wpestate_return_elementor_id(){
    $id = wpresidence_get_option('wp_estate_elementor_id');
    if ( intval($id) ==0){

        $latest_post = get_posts("post_type='estate_property'&numberposts=1&fields='ids'");
        $id=$latest_post[0]->ID;

    }

    return $id;

}
