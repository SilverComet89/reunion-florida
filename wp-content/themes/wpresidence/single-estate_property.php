<?php
// Index Page
// Wp Estate Pack
$status = get_post_status($post->ID);

if ( !is_user_logged_in() ) {
    if($status==='expired'){
        wp_redirect(  esc_url( home_url('/') ) );
        exit;
    }
}else{
    if(!current_user_can('administrator') ){
        if(  $status==='expired'){
            wp_redirect(  esc_url( home_url('/') ) );
            exit;
        }
    }
}

get_header();
$show_compare_only          =   'no';
$current_user               =   wp_get_current_user();
$userID                     =   $current_user->ID;
$user_option                =   'favorites'.intval($userID);
$wpestate_options           =   wpestate_page_details($post->ID);
if($wpestate_options['content_class']=='col-md-12'){
    $slider_size='full';
}

$wpestate_prop_all_details  = get_post_custom($post->ID) ;
// count the views
wp_estate_count_page_stats($post->ID);
$propid                     =   $post->ID;

/*
*
* custom template loading
*
*/

$wp_estate_global_page_template               = intval  ( wpresidence_get_option('wp_estate_global_property_page_template') );
$wp_estate_local_page_template                = intval  ( get_post_meta($post->ID, 'property_page_desing_local', true));
if($wp_estate_global_page_template!=0 || $wp_estate_local_page_template!=0 ){
    global $wp_estate_global_page_template;
    global $wp_estate_local_page_template;
    global $wpestate_options;


    $wpestate_wide_elememtor_page_class='';
    if( wpresidence_get_option('wpestate_wide_elememtor_page') === 'yes'){
        $wpestate_wide_elememtor_page_class="wpestate_wide_elememtor_page";
    }

    print '  <div class="container content_wrapper wpestate_content_wrapper_custom_template '.esc_attr($wpestate_wide_elememtor_page_class).'">';
        print '<div class="wpestate_content_wrapper_custom_template_wrapper">';
        include( locate_template('templates/property_desing_loader.php') );

}



/*
*
* Theme template loading
*
*/


if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {   
    $wp_estate_property_layouts = intval  ( wpresidence_get_option('wp_estate_property_layouts') );
    wpestate_load_property_page_layout($wp_estate_property_layouts);

} // end elementor location 





/*
*
* Map Arguments loading
*
*/

$mapargs = array(
        'post_type'         =>  'estate_property',
        'post_status'       =>  'publish',
        'p'                 =>  $post->ID ,
        'fields'            =>    'ids');

$selected_pins  =   wpestate_listing_pins('blank_single',0,$mapargs,1);

wp_localize_script('googlecode_property', 'googlecode_property_vars2',
            array('markers2'          =>  $selected_pins));




/*
*
* Footer
*
*/          
get_footer(); 
?>
