<?php

/*
*
* Return layouts data
*
*/


if(!function_exists('wpestate_return_layout_array')):
function wpestate_return_layout_array($version=''){
    $global_layouts=array(
        1   => array(
                'title'     =>  array(
                                    'size'=>'col-md-12'
                                ),
                'media'     =>  array(
                                    'size'=>'col-md-9'
                                ),
                'content'   =>  array(
                                    'size'=>'col-md-9'
                                ),
                'sidebar'   =>  array(
                                    'size'=>'col-md-3'
                                ),

            ),

        2   => array(
            'media'     =>  array(
                '               size'=>'col-md-12'
                            ),
            'title'     =>  array(
                                'size'=>'col-md-12'
                            ),     
            'content'   =>  array(
                                'size'=>'col-md-9'
                            ),
            'sidebar'   =>  array(
                                'size'=>'col-md-3'
                            ),

        ), 
    );

    if( intval($version) ==0 ){
        return $global_layouts;
    }else{
        return $global_layouts[$version];
    }

  
}
endif;





/*
*
* Layout Loader
*
*/

if(!function_exists('wpestate_load_property_page_layout')):
function wpestate_load_property_page_layout($version){
    global $post;
    //$version        =   1;
    //$layout_details =   wpestate_return_layout_array($version);

    // data need down the line
    
    $wpestate_options           =   wpestate_page_details($post->ID);
    $property_city              =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
    $property_area              =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
    $property_category          =   get_the_term_list($post->ID, 'property_category', '', ', ', '') ;
    $property_action            =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '');
    $wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $wpestate_prop_all_details  =   get_post_custom($post->ID) ;
 
    
    // content type(acc or tabs) variables
    $local_pgpr_content_type_status     =   get_post_meta($post->ID, 'local_pgpr_content_type', true);
    $global_prpg_content_type_status    =   esc_html ( wpresidence_get_option('wp_estate_global_prpg_content_type','') );
    $content_type                       =   wpestate_property_page_load_content($local_pgpr_content_type_status ,  $global_prpg_content_type_status); 

    if (function_exists('icl_translate') ){
        $where_currency             =   icl_translate('wpestate','wp_estate_where_currency_symbol', esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') ) );
    }else{
        $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    }
    
   
    include ( locate_template('templates/listing_templates/layout_design_templates/property_layout_'.intval($version).'.php') ); 

}
endif;





/*
*
* Load Media for property - sliders , gallery , etc
*
*/

if(!function_exists('wpestate_property_page_load_media')):
function wpestate_property_page_load_media($postID,$wpestate_options,$layout_version=1){
    
    // get media type
    $media_type  =   get_post_meta($postID, 'local_pgpr_slider_type', true);
    if($media_type=='global'){
        $media_type  =   esc_html ( wpresidence_get_option('wp_estate_global_prpg_slider_type','') );
    }


    // load media type
 
    
    // slider size can be full - depnding on layout
    $slider_size                =   'listing_full_slider';
    $main_image_masonry         =   'property_listings'; 
    $second_image_masonry       =   'blog_thumb';
    

    if( ($layout_version==1 && $wpestate_options['content_class']=='col-md-12') 
        || $layout_version==3 
        || $layout_version==4
        || $layout_version==6 ){
        $slider_size                =   'listing_full_slider_1'; 
        $main_image_masonry         =   'listing_full_slider'; 
        $second_image_masonry       =   'property_listings';
    }else if($layout_version==2 || $layout_version==5 ){
        $slider_size                =   'property_full_map'; 
        $main_image_masonry         =   'listing_full_slider_1'; 
        $second_image_masonry       =   'property_listings';
        if($media_type=='gallery'){
            $second_image_masonry       =   'listing_full_slider';
        }
    }


    switch ($media_type) {
        case 'classic':
            wpestate_classic_slider($postID,$slider_size);
            break;

        case 'horizontal':
            wpestate_horizontal_slider($postID,$slider_size);
            break;

        case 'vertical':
            wpestate_vertical_slider($postID,$slider_size);
            break;

        case 'full width header':
            wpestate_listing_full_width_slider($postID,  $slider_size );
            break;
        
        case 'gallery':
            wpestate_header_masonry_gallery_type2($postID,$main_image_masonry,$second_image_masonry);
            break;
        
        case 'multi image slider':
            wpestate_multi_image_slider($postID,$slider_size);
            break;

        case 'header masonry gallery':
            wpestate_header_masonry_gallery($postID,$main_image_masonry,$second_image_masonry);
            break;
        
        }

    
}
endif;





/*
*
* Load content as tabs or accordions
*
*/
if(!function_exists('wpestate_property_page_load_content')):
function wpestate_property_page_load_content( $local_pgpr_content_type_status ,  $global_prpg_content_type_status ){
    // content type -> tabs or accordion
   
    if($local_pgpr_content_type_status =='global'){
        return $global_prpg_content_type_status;
    }else {
       return $local_pgpr_content_type_status;
    }
  
}
endif;


?>