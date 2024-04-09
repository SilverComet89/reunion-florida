<?php

/*
*
* Wpestate control media buttongs
*
*
*/
 
if( !function_exists('wpestate_control_media_buttons') ):
    function wpestate_control_media_buttons($postID){
        $return=null;    
        $wp_estate_media_buttons_order_items           =     wpresidence_get_option('wp_estate_media_buttons_order_items','') ;
    
        $return.=' <div class="wpestate_control_media_buttons_wrapper">';
        $first_class = "slideron";

        unset($wp_estate_media_buttons_order_items['enabled']['placebo']);
        unset($wp_estate_media_buttons_order_items['enabled'][0]);
        
        if( count( $wp_estate_media_buttons_order_items['enabled']) <= 1 ){
            return;
        }

  
        if( isset($wp_estate_media_buttons_order_items['enabled']) && is_array($wp_estate_media_buttons_order_items['enabled']) ){
            foreach($wp_estate_media_buttons_order_items['enabled'] as $key=>$value):
                switch ($key) {
                    case 'image':
                        $return.=' <div id="slider_enable_slider" data-show="wpestate_property_carousel" data-placement="bottom" data-original-title="'.esc_attr__('Image Gallery','wpresidence').'" class="wpestate_control_media_button '.esc_attr( $first_class).' "> <i class="far fa-image"></i></div>';
                        break;
                    case 'map':
                        $return.=' <div id="slider_enable_map"   data-show="google_map_slider_wrapper" class="wpestate_control_media_button '.esc_attr( $first_class).'" data-placement="bottom" data-original-title="'. esc_attr__('Map','wpresidence').'"> <i class="fas fa-map-marker-alt"></i> </div>'; 
                        break;
                    case 'street':
                        if( get_post_meta($postID, 'property_google_view', true) == 1 ) {
                            $return.=' <div id="slider_enable_street"   data-show="google_map_slider_wrapper" class="wpestate_control_media_button  '.esc_attr( $first_class).' '.wpresidence_return_class_leaflet().'" data-placement="bottom" data-original-title="'.esc_attr__('Street View','wpresidence').'"> <i class="fas fa-location-arrow"></i>    </div>';
                        }
                        break;
                    case 'video':
                        if( get_post_meta($postID, 'embed_video_id', true) != '' ) {
                            $return.=' <div id="slider_enable_video" data-show="wpestate_slider_enable_video_wrapper" data-placement="bottom" data-original-title="'.esc_attr__('Video','wpresidence').'" class="wpestate_control_media_button '.esc_attr( $first_class).'"> <i class="fas fa-video"></i></div>';    
                        }
                        break;
                    case 'virtual_tour':
                        if(get_post_meta($postID, 'embed_virtual_tour', true) !='' ){
                            $return.='<div id="slider_enable_virtual"  data-show="wpestate_slider_enable_virtual_wrapper" data-placement="bottom" data-original-title="'.esc_attr__('Virtual Tour','wpresidence').'" class="wpestate_control_media_button '.esc_attr( $first_class).'"><i class="fas fa-photo-video"></i></div>';
                        }
                        break;
                }

                if (  $first_class == "slideron"){
                    $first_class='';
                }

            endforeach;
        }
    
        $return.='</div>';
    
        return $return;
    }
    endif;
    
    
    
    
    
    /*
    *
    * build the media section
    *
    *
    */
    
    if( !function_exists('wpestate_slider_pieces_buider') ):
    function wpestate_slider_pieces_buider($postID,$slider_size,$slider_type){
        $return = '';
        $map_flag=0;
        $wp_estate_media_buttons_order_items           =     wpresidence_get_option('wp_estate_media_buttons_order_items','') ;
        $tyle_css       =   "block";
        $map_included   =   "no";
        unset($wp_estate_media_buttons_order_items['enabled']['placebo']);
        unset($wp_estate_media_buttons_order_items['enabled']['0']);
    
    
    
        if( isset($wp_estate_media_buttons_order_items['enabled']) && is_array($wp_estate_media_buttons_order_items['enabled']) ){
            foreach($wp_estate_media_buttons_order_items['enabled'] as $key=>$value):
                switch ($key) {
                    case 'image':
    
                        if($slider_type=='vertical'){
                            $return .=   wpestate_vertical_slider_content($postID,$slider_size,$tyle_css);
                        }  elseif($slider_type=='horizontal'){
                            $return .=  wpestate_horizontal_slider_content($postID,$slider_size,$tyle_css);
                        }   elseif($slider_type=='classic'){
                            $return .=  wpestate_classic_slider_content($postID,$slider_size,$tyle_css);
                        }   elseif($slider_type=='full_slider'){
                            $return .=  wpestate_listing_full_width_slider_content($postID,$slider_size,$tyle_css);
                        }     
                        
    
                        $tyle_css='none';  
                        break;
                    case 'map':
                        if($map_included=="no"){
                            $return         .=  wpestate_slider_enable_maps_v2($postID,$tyle_css);
                            $tyle_css       =   "none";
                            $map_included   =   "yes";
                        }
                        break;
                    case 'street':
                        if($map_included=="no"){
                            $return         .=  wpestate_slider_enable_maps_v2($postID,$tyle_css);
                            $tyle_css       =   "none";
                            $map_included   =   "yes";
                        }
                        break;
                    case 'video':
                        $return .= wpestate_slider_enable_video($postID,$tyle_css);
                        $tyle_css='none';
                        break;
                    case 'virtual_tour':
                        $return .= wpestate_slider_enable_virtual($postID,$tyle_css);
                        $tyle_css='none';
                        break;
                }
            endforeach;
        }
    
    
        if( 'map'==array_key_first($wp_estate_media_buttons_order_items['enabled']) ){
    
            $return.= '
            <script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   
                    wpestate_control_media_emable_map();
                });
                //]]>
            </script>';
        
        } elseif( 'street'==array_key_first($wp_estate_media_buttons_order_items['enabled']) ){
            $return.= '
            <script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                    setTimeout(function() {jQuery("#slider_enable_street").trigger("click");}, 1000);
                });
                //]]>
            </script>';
        }
    
    
        return $return;   
    }
    endif;
    





/*
*
* Full width slider
*
*
*/


if( !function_exists('wpestate_listing_full_width_slider') ):
    function wpestate_listing_full_width_slider($postID,$slider_size="listing_full_slider_1"){
        print '<div class="wpestate_property_media_section_wrapper wpestate_full_width_slider_wrapper wpestate_'.$slider_size.'">';  
            print wpestate_return_property_status($postID,'horizontalstatus');
            print wpestate_control_media_buttons($postID);
            print wpestate_slider_pieces_buider($postID,$slider_size,'full_slider');
        print '</div>';
    }
endif;



/*
*
* Full width slider content
*
*
*/


if( !function_exists('wpestate_listing_full_width_slider_content') ):
function wpestate_listing_full_width_slider_content($postId,$slider_size='full',$style_css=''){
    $background_image_style =    '';
    $counter_lightbox       =   0;
    $thumb                  =   '';
    $return_string          =   '';

    if( has_post_thumbnail($postId) ){
        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $postId );
        $full_prty          =   wp_get_attachment_image_src($post_thumbnail_id, $slider_size);
        $thumb              =   wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');
    }
    
    $full_image='';
    if(isset($full_prty[0])){
        $full_image=$full_prty[0];
    }
    if(isset($thumb[0])){
        $thumb=$thumb[0];
    }
    
    $items = '<div class="item active">
                <div class="propery_listing_main_image lightbox_trigger" style="background-image:url('.esc_url($full_image).')" data-slider-no="'.$counter_lightbox.'"></div>
                <div class="carousel-caption">
                </div>
            </div>';
    $indicator = '<li data-target="#carousel-property-page-header" data-slide-to="0" class="active"><div class="carousel-property-page-header-overalay"></div><img src="'.esc_url($thumb).'"></li>';

    $post_attachments   =   wpestate_return_property_images($postId);
    $slides='';

    $no_slides = 0;
    foreach ($post_attachments as $attachment) {
        $no_slides++;
        $counter_lightbox++;
        $preview    =   wp_get_attachment_image_src($attachment->ID, $slider_size);
        $thumb      =   wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
        $indicator .= '<li data-target="#carousel-property-page-header" data-slide-to="'.$no_slides.'" class=""><div class="carousel-property-page-header-overalay"></div><img src="'.$thumb[0].'"></li>';
        $items .= '<div class="item ">
            <div class="propery_listing_main_image lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$preview[0].')" ></div>
            <div class="carousel-caption">
            </div>
        </div>';
    }


 
     $return_string  = '<div class="wpestate_property_slider_v3 wpestate_property_carousel wpestate_property_slider_thing" style="display:'.esc_attr($style_css).'" >';
     $return_string  .=  '<div id="carousel-property-page-header" class="carousel slide propery_listing_main_image" data-interval="false" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            '.$items.'
        </div>

        <div class="carousel-indicators-wrapper-header-prop">
            <ol class="carousel-indicators">
                '.$indicator.'
            </ol>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-property-page-header" role="button" data-slide="prev">
        <i class="demo-icon icon-left-open-big"></i>
        </a>
        <a class="right carousel-control" href="#carousel-property-page-header" role="button" data-slide="next">
        <i class="demo-icon icon-right-open-big"></i>
        </a>

        </div>
    </div>';
    return  $return_string  ;

}
endif;




/*
*
* Multi image slider
*
*
*/

if( !function_exists('wpestate_multi_image_slider') ):
function wpestate_multi_image_slider($prop_id,$slider_size,$display_slides=3){

    wp_enqueue_script('slick.min');
    $post_attachments   =   wpestate_return_property_images($prop_id);
    $counter_lightbox   =   0;
    $slides             =   '';
    $items              =   '';
    $no_slides          =   0;
    $attach_src        =    '';
    $post_thumbnail_id=0;
    if( has_post_thumbnail($prop_id) ){
        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
        $full_prty          =   wp_get_attachment_image_src($post_thumbnail_id, $slider_size);
        $attach_src         =   $full_prty[0];

    }


    $items .= '<div class="item ">
            <div class="multi_image_slider_image  lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$attach_src.')" ></div>
            <div class="carousel-caption">';

    if ( has_excerpt( $post_thumbnail_id ) ) {
                   $caption=get_the_excerpt($post_thumbnail_id);
                } else {
                    $caption='';
                }

                if($caption!=''){
                    $items .= '<div class="carousel-caption_underlay"></div>
                    <div class="carousel_caption_text">'.$caption.'</div>';
                }
    $items .= '
            </div>
        </div>';

    foreach ($post_attachments as $attachment) {
        $no_slides++;

        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
        $preview            =   wp_get_attachment_image_src($attachment->ID, $slider_size);
        //$thumb              =   wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
        $attachment_meta    =   wp_get_attachment($post_thumbnail_id);
        $items .= '<div class="item ">
            <div class="multi_image_slider_image  lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$preview[0].')" ></div>
            <div class="carousel-caption">';
            if($attachment->post_excerpt !=''){
                $items .='<div class="carousel-caption_underlay"></div>
                <div class="carousel_caption_text">'.$attachment->post_excerpt.'</div>';
            }
        $items .='
            </div>
        </div>';
    }

    echo '<div class="property_multi_image_slider" data-auto="0">'.$items.'</div>';

    print '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   wpestate_enable_slick_theme_slider('.$display_slides.');
                });
                //]]>
            </script>';
}
endif;











/*
*
* Classic Slider
*
*
*/


if( !function_exists('wpestate_classic_slider') ):
    function wpestate_classic_slider($postID,$slider_size="listing_full_slider_1"){
        print '<div class="wpestate_property_media_section_wrapper wpestate_classic_slider_wrapper wpestate_'.$slider_size.' ">';  
            print wpestate_return_property_status($postID,'horizontalstatus');
            print wpestate_control_media_buttons($postID);
            print wpestate_slider_pieces_buider($postID,$slider_size,'classic');
        print '</div>';
    }
endif;




/*
*
* Vertical Slider
*
*
*/

if( !function_exists('wpestate_vertical_slider') ):
function wpestate_vertical_slider($postID,$slider_size="full"){ 

    print '<div class="wpestate_property_media_section_wrapper">';  
        print wpestate_return_property_status($postID,'verticalstatus');
        print wpestate_control_media_buttons($postID);
        print wpestate_slider_pieces_buider($postID,$slider_size,'vertical');
    print '</div>';
  

}
endif;


/*
*
* Horizontal Slider
*
*
*/

if( !function_exists('wpestate_horizontal_slider') ):
    function wpestate_horizontal_slider($postID,$slider_size="full"){
    
        print '<div class="wpestate_property_media_section_wrapper wpestate_horizontal_slider_wrapper wpestate_'.$slider_size.'">';  
            print wpestate_return_property_status($postID,'horizontalstatus');
            print wpestate_control_media_buttons($postID);
            print wpestate_slider_pieces_buider($postID,$slider_size,'horizontal');
        print '</div>';
    }
endif;



/*
*
* Vertical Slider Builder
*
*
*/

if( !function_exists('wpestate_vertical_slider_content') ):
function wpestate_vertical_slider_content($postId,$slider_size,$style_css){

    $slider_components          =   wpestate_slider_slide_generation($postId,$slider_size);
    $wp_estate_kind_of_map  = esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );
    if($wp_estate_kind_of_map==2){
        $wp_estate_kind_of_map='open_street';
    }
    $wp_estate_kind_of_map_class= $wp_estate_kind_of_map.'_carousel';


    $return_string= '<div id="carousel-listing" style="display:'.esc_attr($style_css).'" class=" wpestate_property_carousel wpestate_property_slider_thing slide post-carusel carouselvertical  '.esc_attr($wp_estate_kind_of_map_class).'" data-touch="true" data-interval="false">';


    $return_string.= '
    <!-- Wrapper for slides -->
    <div class="carousel-inner owl-carousel owl-theme carouselvertical" id="property_slider_carousel">
     '.trim($slider_components['slides']).'
    </div>

    <!-- Indicators -->
    <ol  id="carousel-indicators-vertical" class="carousel-indicators-vertical">
       '.trim($slider_components['indicators']).'
    </ol>

    <div class="caption-wrapper vertical-wrapper">
        <div class="vertical-wrapper-back"></div>
        '.trim($slider_components['captions']).'
    </div>';

    $return_string.= '</div>
    <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready(function(){
            wpestate_property_slider();
        });
        //]]>
    </script>';

    return $return_string;
}
endif;




/*
*
* Horizontal Slider Builder
*
*
*/
if( !function_exists('wpestate_horizontal_slider_content') ):
    function wpestate_horizontal_slider_content($postId,$slider_size,$style_css){
    
      
        $slider_components          =   wpestate_slider_slide_generation($postId,$slider_size);
        $wp_estate_kind_of_map      =   esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );
        if($wp_estate_kind_of_map==2){
            $wp_estate_kind_of_map='open_street';
        }
    
        $wp_estate_kind_of_map_class=$wp_estate_kind_of_map.'_carousel';
    
    
        $return_string= '<div id="carousel-listing" style="display:'.esc_attr($style_css).'" class="slide post-carusel wpestate_property_carousel wpestate_property_slider_thing '.esc_attr($wp_estate_kind_of_map_class).' carouselhorizontal" data-interval="false">';
        $return_string.= '
            <!-- Wrapper for slides -->
            <div class="carousel-inner owl-carousel owl-theme" id="property_slider_carousel">
              '.trim($slider_components['slides']).'
            </div>
    
            <!-- Indicators -->
            <div class="carusel-back"></div>
            <ol class="carousel-indicators">
              '.trim($slider_components['indicators']).'
            </ol>
    
            <ol class="carousel-round-indicators">
                '.trim($slider_components['round_indicators']).'
            </ol>
    
            <div class="caption-wrapper">
              '. trim($slider_components['captions']).'
                <div class="caption_control"></div>
            </div>
    
            </div>';
    
            $return_string.= '
            <script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   wpestate_property_slider();
                });
                //]]>
            </script>';
    
            return $return_string;
       
    
    }
endif;








/*
*
* Classic Slider builder
*
*
*/

if( !function_exists('wpestate_classic_slider_content') ):
  
function wpestate_classic_slider_content($postId,$slider_size="listing_full_slider_1",$style_css=''){

    $post_attachments       =   wpestate_return_property_images($postId);
    $slider_components      =   wpestate_slider_slide_generation($postId,$slider_size,'yes');
    $wp_estate_kind_of_map  =   esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );
    if($wp_estate_kind_of_map==2){
        $wp_estate_kind_of_map='open_street';
    }

    $wp_estate_kind_of_map_class=$wp_estate_kind_of_map.'_carousel';
    if ( $post_attachments || has_post_thumbnail($postId) ) {

        
        $return_string= ' <div id="carousel-listing"  style="display:'.esc_attr($style_css).'" class="classic-carousel slide wpestate_property_carousel wpestate_property_slider_thing post-carusel '.esc_attr($wp_estate_kind_of_map_class).' " data-interval="false">';
   
        $return_string.= ' 
            <!-- Wrapper for slides -->
            <div class="carousel-inner owl-carousel owl-theme" id="property_slider_carousel">
            '. trim($slider_components['slides']).'
            </div>

            <!-- Indicators -->
            <ol class="carousel-indicators carousel-indicators-classic ">
            '.trim($slider_components['indicators']).'
            </ol>

        </div>';

        $return_string.= '
        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready(function(){
                wpestate_property_slider();
            });
            //]]>
        </script>';
        return $return_string;

  } // end if post_attachments
}
endif;


/*
*
* Header masonary type 2
*
*
*/

if( !function_exists('wpestate_header_masonry_gallery_type2') ):
function wpestate_header_masonry_gallery_type2($prop_id,$main_image_masonry='listing_full_slider',$second_image_masonry='listing_full_slider',$is_shortcode=""){
  print'<div class="gallery_wrapper">';

    $post_attachments   =   wpestate_return_property_images($prop_id);
    $count              =   0;
    $total_pictures     =   count ($post_attachments);
    if($count == 0 ){
        $full_prty          = wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), $main_image_masonry);

        $full_prty_src='';
        if(isset($full_prty[0])){
            $full_prty_src=$full_prty[0];
        }
        print wpestate_return_property_status($prop_id,'horizontalstatus');
        print '<div class="col-md-8 image_gallery lightbox_trigger special_border" data-slider-no="1" style="background-image:url('.esc_attr($full_prty_src).')  ">   <div class="img_listings_overlay" ></div></div>';
    }


      foreach ($post_attachments as $attachment) {
          $count++;
          $special_border='  ';
          if($count==0){
              $special_border=' special_border ';
          }

          if($count==1){
              $special_border=' special_border_top ';
          }

          if($count==3){
              $special_border=' special_border_left ';
          }

          if($count <= 4 && $count !=0){
              $full_prty          = wp_get_attachment_image_src($attachment->ID, $second_image_masonry);
              print '<div class="col-md-4 image_gallery lightbox_trigger '.esc_attr($special_border).' " data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')"> <div class="img_listings_overlay" ></div> </div>';
          }

          if($count ==5 ){
              $full_prty          = wp_get_attachment_image_src($attachment->ID, $second_image_masonry);
              print '<div class="col-md-4 image_gallery last_gallery_item lightbox_trigger" data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')  ">
                  <div class="img_listings_overlay img_listings_overlay_last" ></div>
                  <span class="img_listings_mes">'.esc_html__( 'See all','wpresidence').' '.esc_html($total_pictures).' '.esc_html__( 'photos','wpresidence').'</span></div>';
          }
      }

  print '</div>';
}
endif;

/*
*
* Header masonary type 1
*
*
*/

if( !function_exists('wpestate_header_masonry_gallery') ):
function wpestate_header_masonry_gallery($prop_id,$main_image_masonry='listing_full_slider_1',$second_image_masonry='listing_full_slider',$is_shortcode=""){
    print'<div class="gallery_wrapper property_header_gallery_wrapper">';


    $post_attachments   =   wpestate_return_property_images($prop_id);
    print wpestate_return_property_status($prop_id,'horizontalstatus');

    $count              =   0;
    $total_pictures     =   count ($post_attachments);

    if($count == 0 ){
        $full_prty          = wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), $main_image_masonry);
        print '<div class="col-md-6 image_gallery lightbox_trigger special_border" data-slider-no="1" style="background-image:url('.esc_attr($full_prty[0]).')  ">   <div class="img_listings_overlay" ></div></div>';
    }


    foreach ($post_attachments as $attachment) {
        $count++;
        $special_border='  ';
        if($count==0){
            $special_border=' special_border ';
        }

        if($count>=1 && $count<=2){
            $special_border=' special_border_top ';
        }



        if($count <= 3 && $count !=0){
            $full_prty          = wp_get_attachment_image_src($attachment->ID, $second_image_masonry);
            print '<div class="col-md-3 image_gallery lightbox_trigger '.esc_attr($special_border).' " data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')"> <div class="img_listings_overlay" ></div> </div>';
        }

        if($count == 4 ){
            $full_prty          = wp_get_attachment_image_src($attachment->ID, $second_image_masonry);
            print '<div class="col-md-3 image_gallery last_gallery_item lightbox_trigger" data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')  ">
                <div class="img_listings_overlay img_listings_overlay_last" ></div>';

     
                if($is_shortcode!='yes'){
                    print '<span class="img_listings_mes">'.esc_html__( 'See all','wpresidence').' '.esc_html($total_pictures).' '.esc_html__( 'photos','wpresidence').'</span>';
                }

                print '</div>';
        }
        if($count >=5 ){
            break;
        }
    }

    print '</div>';

}
endif;


/*
*
* Slider data
*
*
*
*/
if( !function_exists('wpestate_slider_slide_generation') ):
function wpestate_slider_slide_generation($prop_id,$slider_size,$use_captions_on_slide=''){


        $post_attachments   =   wpestate_return_property_images($prop_id);
        $has_video          =   0;
        $indicators         =   '';
        $round_indicators   =   '';
        $slides             =   '';
        $captions           =   '';
        $counter            =    0;
        $slider_components =    array();
        $slider_components['has_info']=0;


        if( has_post_thumbnail($prop_id) ){
            $counter++;

            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $post_thumbnail_id  = get_post_thumbnail_id( $prop_id );
            $preview            = wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');

           
            $full_img           = wp_get_attachment_image_src($post_thumbnail_id, $slider_size);
           

            $full_prty          = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            $attachment_meta    = wp_get_attachment($post_thumbnail_id);

            $captions_on_slide='';
            if($attachment_meta['caption']!='' && $use_captions_on_slide=='yes'){
                $captions_on_slide='<div class="caption_on_slide">'.$attachment_meta['caption'].'</div>';
            }


            $indicators.= ' <li  data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. esc_attr($active).'">
                                <a href="#item'.esc_attr($counter).'">'
                                .'<img  src="'.esc_url($preview[0]).'"  alt="'.esc_html__('image','wpresidence').'" /></a>
                            </li>';

            $round_indicators   .= '<a  href="#item'.esc_attr($counter).'"  data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. $active.'"></a>';

            $slides .= '<div class="item '.esc_attr($active).'" data-number="'.$counter.'" data-hash="item'.esc_attr($counter).'" >
                            <a href="'.esc_url($full_prty[0]).'" title="'.esc_attr($attachment_meta['caption']).'" rel="prettyPhoto" class="prettygalery" >
                                <img  src="'.esc_url($full_img[0]).'" data-slider-no="'.esc_attr($counter).'"  alt="'.esc_attr($attachment_meta['alt']).'" class="img-responsive lightbox_trigger" />
                                '.$captions_on_slide.'
                            </a>
                        </div>';

            if( trim ( $attachment_meta['caption']=='') ){
                $active.=' blank_caption ';
            }

            $captions .= '<span data-slide-to="'.esc_attr($counter).'" class="'.esc_attr($active).'"> '. $attachment_meta['caption'].'</span>';
        }



        if($post_attachments){
          $slider_components['has_info']=1;
        }

        foreach ($post_attachments as $attachment) {
            $counter++;

            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $preview            = wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
         
            $full_img           = wp_get_attachment_image_src($attachment->ID, $slider_size);
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'full');
            $attachment_meta    = wp_get_attachment($attachment->ID);



            $captions_on_slide='';
            if($attachment_meta['caption']!='' && $use_captions_on_slide=='yes'){
                $captions_on_slide='<div class="caption_on_slide">'.$attachment_meta['caption'].'</div>';
            }

            $indicators.= ' <li  data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. esc_attr($active).'">
                                <a href="#item'.esc_attr($counter).'">'
                                .'<img  src="'.esc_url($preview[0]).'"  alt="'.esc_html__('image','wpresidence').'" /></a>
                            </li>';
            $round_indicators   .= '<a  href="#item'.esc_attr($counter).'"  data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. $active.'"></a>';

            $slides .= '<div class="item '.esc_attr($active).'" data-number="'.$counter.'" data-hash="item'.esc_attr($counter).'" >
                            <a href="'.esc_url($full_prty[0]).'" title="'.esc_attr($attachment_meta['caption']).'" rel="prettyPhoto" class="prettygalery" >
                                <img  src="'.esc_url($full_img[0]).'" data-slider-no="'.esc_attr($counter).'"  alt="'.esc_attr($attachment_meta['alt']).'" class="img-responsive lightbox_trigger" />
                                '.$captions_on_slide.'
                            </a>
                        </div>';

            if( trim ( $attachment_meta['caption']=='') ){
                $active.=' blank_caption ';
            }

            $captions .= '<span data-slide-to="'.esc_attr($counter).'" class="'.esc_attr($active).'"> '. $attachment_meta['caption'].'</span>';
        }// end foreach




        $slider_components['indicators']        =   $indicators;
        $slider_components['round_indicators']  =   $round_indicators;
        $slider_components['slides']            =   $slides;
        $slider_components['captions']          =   $captions;

        return $slider_components;
}
endif;



/*
*
* return poperty attachemnts
*
*
*/

if( !function_exists('wpestate_return_property_images') ):
function wpestate_return_property_images($prop_id){

        $arguments      = array(
            'numberposts'       => 100,
            'post_type'         => 'attachment',
            'post_mime_type'    => 'image',
            'post_parent'       => $prop_id,
            'post_status'       => null,
            'exclude'           => get_post_thumbnail_id($prop_id),
            'orderby'           => 'menu_order',
            'order'             => 'ASC'
        );

        if(function_exists('activate_mlsimport')){
            $arguments['orderby']='id';
        }

        $post_attachments   =   get_posts($arguments);

        return $post_attachments;
}
endif;


 ?>
