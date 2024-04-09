<?php







if( !function_exists('wpestate_property_size_number_format') ):
function wpestate_property_size_number_format($value){
    $th_separator   =  stripslashes(  wpresidence_get_option('wp_estate_size_thousand_separator','') );
    $dc_separator   =  stripslashes(  wpresidence_get_option('wp_estate_size_decimal_separator','') );
    $decimals       =  stripslashes(  wpresidence_get_option('wp_estate_size_decimals','') );

    $value = number_format($value,$decimals,$dc_separator,$th_separator);
    return $value;
}
endif;






if( !function_exists('wpestate_show_price_label_slider') ):
function wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$wpestate_currency,$where_currency){

    $th_separator       =  stripslashes(  wpresidence_get_option('wp_estate_prices_th_separator','') );

    $min_price_slider=floatval($min_price_slider);
    $max_price_slider=floatval($max_price_slider);

    $custom_fields = wpresidence_get_option( 'wp_estate_multi_curr', '');

    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
        $i=intval($_COOKIE['my_custom_curr_pos']);

        if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
            $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
            $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
        }

        $wpestate_currency               =   $custom_fields[$i][0];
        $min_price_slider    =   wpestate_format_number_price($min_price_slider,$th_separator);
        $max_price_slider    =   wpestate_format_number_price($max_price_slider,$th_separator);

        if ($custom_fields[$i][3] == 'before') {
            $price_slider_label = $wpestate_currency .' '. $min_price_slider.' '.esc_html__('to','wpresidence').' '.$wpestate_currency .' '. $max_price_slider;
        } else {
            $price_slider_label =  $min_price_slider.' '.$wpestate_currency.' '.esc_html__('to','wpresidence').' '.$max_price_slider.' '.$wpestate_currency;
        }

    }else{

        $min_price_slider    =   wpestate_format_number_price($min_price_slider,$th_separator);
        $max_price_slider    =   wpestate_format_number_price($max_price_slider,$th_separator);

        if ($where_currency == 'before') {
            $price_slider_label = $wpestate_currency .' '.($min_price_slider).' '.esc_html__('to','wpresidence').' '.$wpestate_currency .' ' .$max_price_slider;
        } else {
            $price_slider_label =  $min_price_slider.' '.$wpestate_currency.' '.esc_html__('to','wpresidence').' '.$max_price_slider.' '.$wpestate_currency;
        }
    }

    return $price_slider_label;


}
endif;

if( !function_exists('wpestate_show_price_label_slider_v2') ):
    function wpestate_show_price_label_slider_v2($min_price_slider,$max_price_slider,$wpestate_currency,$where_currency){
    
        $th_separator       =  stripslashes(  wpresidence_get_option('wp_estate_prices_th_separator','') );
    
        $min_price_slider=floatval($min_price_slider);
        $max_price_slider=floatval($max_price_slider);
    
        $custom_fields = wpresidence_get_option( 'wp_estate_multi_curr', '');
    
        if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
            $i=intval($_COOKIE['my_custom_curr_pos']);
    
            if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
                $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
            }
    
            $wpestate_currency               =   $custom_fields[$i][0];
            $min_price_slider    =   wpestate_format_number_price($min_price_slider,$th_separator);
            $max_price_slider    =   wpestate_format_number_price($max_price_slider,$th_separator);
    
            if ($custom_fields[$i][3] == 'before') {
                $price_slider_label     = $wpestate_currency .' '. $min_price_slider.' '.esc_html__('to','wpresidence').' '.$wpestate_currency .' '. $max_price_slider;
                $price_slider_label_min = $wpestate_currency .' '. $min_price_slider;
                $price_slider_label_max = $wpestate_currency .' '. $max_price_slider;
                
            } else {
                $price_slider_label     =  $min_price_slider.' '.$wpestate_currency.' '.esc_html__('to','wpresidence').' '.$max_price_slider.' '.$wpestate_currency;
                $price_slider_label_min =  $min_price_slider.' '.$wpestate_currency;
                $price_slider_label_max =  $max_price_slider.' '.$wpestate_currency;
            }
    
        }else{
    
            $min_price_slider    =   wpestate_format_number_price($min_price_slider,$th_separator);
            $max_price_slider    =   wpestate_format_number_price($max_price_slider,$th_separator);
    
            if ($where_currency == 'before') {
                $price_slider_label = $wpestate_currency .' '.($min_price_slider).' '.esc_html__('to','wpresidence').' '.$wpestate_currency .' ' .$max_price_slider;
                $price_slider_label_min = $wpestate_currency .' '. $min_price_slider;
                $price_slider_label_max = $wpestate_currency .' '. $max_price_slider;
            } else {
                $price_slider_label =  $min_price_slider.' '.$wpestate_currency.' '.esc_html__('to','wpresidence').' '.$max_price_slider.' '.$wpestate_currency;
                $price_slider_label_min =  $min_price_slider.' '.$wpestate_currency;
                $price_slider_label_max =  $max_price_slider.' '.$wpestate_currency;
            }
        }

        $return_array=array(
            'label'     =>  $price_slider_label,
            'label_min' =>  $price_slider_label_min,
            'label_max' =>  $price_slider_label_max
        );
    
        return $return_array;
    
    
    }
    endif;
    

///////////////////////////////////////////////////////////////////////////////////////////
/////// Define thumb sizes
///////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_image_size') ):
    function wpestate_image_sizexx(){
        
        add_image_size('user_picture_profile', 255, 143, true);
        add_image_size('agent_picture_thumb' , 120, 120, true);
        add_image_size('blog_thumb'          , 272, 189, true);
        add_image_size('blog_unit'           , 1110, 385, true);
        add_image_size('slider_thumb'        , 143,  83, true);
        add_image_size('property_featured_sidebar',768,662,true);
        add_image_size('property_listings'   , 525, 328, true); // 1.62 was 265/163 until v1.12
        add_image_size('property_full'       , 980, 777, true);
        add_image_size('listing_full_slider' , 835, 467, true);
        add_image_size('listing_full_slider_1', 1110, 623, true);
        add_image_size('property_featured'   , 940, 390, true);
        add_image_size('property_full_map'   , 1920, 790, true);
        add_image_size('widget_thumb'        , 105, 70, true);
        add_image_size('user_thumb'          , 45, 45, true);
        add_image_size('custom_slider_thumb'          , 36, 36, true);

        set_post_thumbnail_size(  250, 220, true);
    }
endif;

if( !function_exists('wpestate_image_size') ):
    function wpestate_image_size(){
        $default_image_size = wpestate_return_default_image_size_theme();

        foreach($default_image_size as $key=>$value ){
            $option_name = 'wp_estate_'.$key;
            $wpresidence_admin =  get_option('wpresidence_admin','') ;
    
           
            if(isset($wpresidence_admin[$option_name])){
                $saved_option =$wpresidence_admin[$option_name];
                $crop=true;
                if( isset($saved_option['add_field_width']) && intval($saved_option['add_field_width'])> 0 &&
                    isset($saved_option['add_field_height']) && intval($saved_option['add_field_height'])> 0 ){  
                        $width = intval($saved_option['add_field_width']);
                        $height = intval($saved_option['add_field_height']);
                }else{
                    $width  =   $value['width'];
                    $height =   $value['height'];
                }

                if( isset($saved_option['add_field_width']) && $saved_option['add_field_crop']=='no' ){
                    $crop=false;
                }
            }else{
                $width  =   $value['width'];
                $height =   $value['height'];
                $crop   =   true;
            }
          //  print '</br> fac'.$key.' '.$width.' '.$height.' '.$crop;

            add_image_size($key, $width, $height , $crop);
        }


       set_post_thumbnail_size(  250, 220, true);
    }
endif;



function wpestate_return_default_image_size_theme(){
    $default_image_size = array(
     'user_picture_profile' => array(
         'name' => esc_html__('User profile picture', 'wpesidence-core'),
         'width' => 255,
         'height' => 143,
         'crop' => true,
     ),
     'agent_picture_thumb' => array(
         'name' => esc_html__('Agent picture thumb', 'wpesidence-core'),
         'width' => 120,
         'height' => 120,
         'crop' => true,
     ),
     'blog_thumb' => array(
         'name' => esc_html__('Blog thumb', 'wpesidence-core'),
         'width' => 272,
         'height' => 189,
         'crop' => true,
     ),
     'blog_unit' => array(
         'name' => esc_html__('Blog unit', 'wpesidence-core'),
         'width' => 1110,
         'height' => 385,
         'crop' => true,
     ),
     'slider_thumb' => array(
         'name' => esc_html__('Slider thumb', 'wpesidence-core'),
         'width' => 143,
         'height' => 83,
         'crop' => true,
     ),
     'property_featured_sidebar' => array(
         'name' => esc_html__('Property featured sidebar', 'wpesidence-core'),
         'width' => 768,
         'height' => 662,
         'crop' => true,
     ),
     'property_listings' => array(
         'name' => esc_html__('Property listings', 'wpesidence-core'),
         'width' => 525,
         'height' => 328,
         'crop' => true,
     ),
     'property_full' => array(
         'name' => esc_html__('Property full', 'wpesidence-core'),
         'width' => 980,
         'height' => 777,
         'crop' => true,
     ),
     'listing_full_slider' => array(
         'name' => esc_html__('Listing full slider', 'wpesidence-core'),
         'width' => 835,
         'height' => 467,
         'crop' => true,
     ),
     'listing_full_slider_1' => array(
         'name' => esc_html__('Listing full slider 1', 'wpesidence-core'),
         'width' => 1110,
         'height' => 623,
         'crop' => true,
     ),
     'property_featured' => array(
         'name' => esc_html__('Property featured', 'wpesidence-core'),
         'width' => 940,
         'height' => 390,
         'crop' => true,
     ),
     'property_full_map' => array(
         'name' => esc_html__('Property full map', 'wpesidence-core'),
         'width' => 1920,
         'height' => 790,
         'crop' => true,
     ),
     'widget_thumb' => array(
         'name' => esc_html__('Widget thumb', 'wpesidence-core'),
         'width' => 105,
         'height' => 70,
         'crop' => true,
     ),
     'user_thumb' => array(
         'name' => esc_html__('User thumb', 'wpesidence-core'),
         'width' => 45,
         'height' => 45,
         'crop' => true,
     ),
     'custom_slider_thumb' => array(
         'name' => esc_html__('Custom slider thumb', 'wpesidence-core'),
         'width' => 36,
         'height' => 36,
         'crop' => true,
     ),
     'post_thumbnail_size' => array(
         'name' => esc_html__('Post thumbnail size', 'wpesidence-core'),
         'width' => 250,
         'height' => 220,
         'crop' => true,
     ),
 );
 
    return $default_image_size;
    
 }



///////////////////////////////////////////////////////////////////////////////////////////
/////// register sidebars
///////////////////////////////////////////////////////////////////////////////////////////




/////////////////////////////////////////////////////////////////////////////////////////
///// custom excerpt
/////////////////////////////////////////////////////////////////////////////////////////



if( !function_exists('wp_estate_excerpt_length') ):
    function wp_estate_excerpt_length($length) {
        return 64;
    }
endif; // end   wp_estate_excerpt_length


/////////////////////////////////////////////////////////////////////////////////////////
///// custom excerpt more
/////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_new_excerpt_more') ):
    function wpestate_new_excerpt_more( $more ) {
        return ' ...';
    }
endif; // end   wpestate_new_excerpt_more



/////////////////////////////////////////////////////////////////////////////////////////
///// strip words
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_strip_words') ):
    function wpestate_strip_words($text, $words_no) {


        $temp = explode(' ', $text, ($words_no + 1));
        if (count($temp) > $words_no) {
            array_pop($temp);
        }
        return implode(' ', $temp);
          }
endif; // end   wpestate_strip_words


if( !function_exists('wpestate_strip_excerpt_by_char') ):
    function wpestate_strip_excerpt_by_char($text, $chars_no,$post_id,$more='') {
        $return_string  = '';
        $return_string  =  mb_substr( $text,0,$chars_no);
            if(mb_strlen($text)>$chars_no){
                if($more==''){
                    $return_string.= ' <a href="'.esc_url ( get_permalink($post_id)).'" class="unit_more_x">'.esc_html__(' ...','wpresidence').'</a>';
                }else{
                    $return_string.= ' <a href="'.esc_url(get_permalink($post_id)).'" class="unit_more_x">'.$more.'</a>';
                }

            }
        return $return_string;
        }

endif; // end   wpestate_strip_words

if( !function_exists('wpestate_strip_excerpt_by_char_places') ):
    function wpestate_strip_excerpt_by_char_places($text, $chars_no,$link) {
        $return_string  = '';
        $return_string  =  mb_substr( $text,0,$chars_no);
            if(mb_strlen($text)>$chars_no){
                $return_string.= ' <a href="'.esc_url($link).'" class="unit_more_x">'.esc_html__(' ...','wpresidence').'</a>';
            }
        return $return_string;
        }

endif; // end   wpestate_strip_words




/////////////////////////////////////////////////////////////////////////////////////////
///// add extra div for wp embeds
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_embed_html') ):
    function wpestate_embed_html( $html ) {
        if (strpos($html,'twitter') !== false) {
            return '<div class="video-container-tw">' . $html . '</div>';
        }else{
            return '<div class="video-container">' . $html . '</div>';
        }

    }
endif;
add_filter( 'embed_oembed_html', 'wpestate_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'wpestate_embed_html' ); // Jetpack

/////////////////////////////////////////////////////////////////////////////////////////
///// html in conmment
/////////////////////////////////////////////////////////////////////////////////////////
//add_action('init', 'wpestate_html_tags_code', 10);

if( !function_exists('wpestate_html_tags_code') ):
    function wpestate_html_tags_code() {

      global $allowedposttags, $allowedtags;
      $allowedposttags = array(
          'strong' => array(),
          'em' => array(),
          'pre' => array(),
          'code' => array(),
          'a' => array(
            'href' => array (),
            'title' => array (),
            'class'=>array(),
            )
      );

      $allowedtags = array(
          'strong' => array(),
          'em' => array(),
          'pre' => array(),
          'code' => array(),
          'a' => array(
            'href' => array (),
            'title' => array (),
            'class'=>array(),  )
      );
    }
endif;


add_action( 'widgets_init', 'wpestate_widgets_init' );
if( !function_exists('wpestate_widgets_init') ):
function wpestate_widgets_init() {
    register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'wpresidence' ) );
    register_nav_menu( 'mobile', esc_html__( 'Mobile Menu', 'wpresidence' ) );
    register_nav_menu( 'footer_menu', esc_html__( 'Footer Menu', 'wpresidence' ) );
    register_nav_menu( 'header_6_second_menu', esc_html__( 'Header 6 Second Menu', 'wpresidence' ) );
    register_sidebar(array(
        'name' => esc_html__('Primary Widget Area', 'wpresidence'),
        'id' => 'primary-widget-area',
        'description' => esc_html__('The primary widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Secondary Widget Area', 'wpresidence'),
        'id' => 'secondary-widget-area',
        'description' => esc_html__('The secondary widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => esc_html__('First Footer Widget Area', 'wpresidence'),
        'id' => 'first-footer-widget-area',
        'description' => esc_html__('The first footer widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title-footer">',
        'after_title' => '</h4>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Second Footer Widget Area', 'wpresidence'),
        'id' => 'second-footer-widget-area',
        'description' => esc_html__('The second footer widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title-footer">',
        'after_title' => '</h4>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Third Footer Widget Area', 'wpresidence'),
        'id' => 'third-footer-widget-area',
        'description' => esc_html__('The third footer widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title-footer">',
        'after_title' => '</h4>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Fourth Footer Widget Area', 'wpresidence'),
        'id' => 'fourth-footer-widget-area',
        'description' => esc_html__('The fourth footer widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title-footer">',
        'after_title' => '</h4>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Top Bar Left Widget Area', 'wpresidence'),
        'id' => 'top-bar-left-widget-area',
        'description' => esc_html__('The top bar left widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Top Bar Right Widget Area', 'wpresidence'),
        'id' => 'top-bar-right-widget-area',
        'description' => esc_html__('The top bar right widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
      register_sidebar(array(
        'name' => esc_html__('Sidebar Menu Widget Area - Before Menu', 'wpresidence'),
        'id' => 'sidebar-menu-widget-area-before',
        'description' => esc_html__('Sidebar for header type 3 - before menu', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Sidebar Menu Widget Area - After Menu', 'wpresidence'),
        'id' => 'sidebar-menu-widget-area-after',
        'description' => esc_html__('Sidebar for header type 3 - after menu', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));



    register_sidebar(array(
        'name' => esc_html__('Header4 Widget Area', 'wpresidence'),
        'id' => 'header4-widget-area',
        'description' => esc_html__('Header4 widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-header4">',
        'after_title' => '</h3>',
    ));


     register_sidebar(array(
        'name' => esc_html__('Dashboard Top Bar Left Widget Area', 'wpresidence'),
        'id' => 'dashboard-top-bar-left-widget-area',
        'description' => esc_html__('User Dashboard - The top bar left widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Dashboard Top Bar Right Widget Area', 'wpresidence'),
        'id' => 'dashboard-top-bar-right-widget-area',
        'description' => esc_html__('User Dashboard - The top bar right widget area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Splash Page Bottom Right Widget Area', 'wpresidence'),
        'id' => 'splash-page_bottom-right-widget-area',
        'description' => esc_html__('Splash Page - Bottom right area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="splash_page_widget widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Splash Page Bottom Left Widget Area', 'wpresidence'),
        'id' => 'splash-page_bottom-left-widget-area',
        'description' => esc_html__('Splash Page - Bottom left area', 'wpresidence'),
        'before_widget' => '<li id="%1$s" class="splash_page_widget widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
}
endif; // end   wpestate_widgets_init




?>
