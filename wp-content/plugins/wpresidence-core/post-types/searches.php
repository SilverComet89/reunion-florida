<?php
// register the custom post type
add_action( 'setup_theme', 'wpestate_create_saved_search' );

if( !function_exists('wpestate_create_saved_search') ):
function wpestate_create_saved_search() {
register_post_type( 'wpestate_search',
		array(
			'labels' => array(
				'name'          => esc_html__( 'Searches','wpresidence-core'),
				'singular_name' => esc_html__( 'Searches','wpresidence-core'),
				'add_new'       => esc_html__('Add New Searches','wpresidence-core'),
                'add_new_item'          =>  esc_html__('Add Searches','wpresidence-core'),
                'edit'                  =>  esc_html__('Edit Searches' ,'wpresidence-core'),
                'edit_item'             =>  esc_html__('Edit Searches','wpresidence-core'),
                'new_item'              =>  esc_html__('New Searches','wpresidence-core'),
                'view'                  =>  esc_html__('View Searches','wpresidence-core'),
                'view_item'             =>  esc_html__('View Searches','wpresidence-core'),
                'search_items'          =>  esc_html__('Search Searches','wpresidence-core'),
                'not_found'             =>  esc_html__('No Searches found','wpresidence-core'),
                'not_found_in_trash'    =>  esc_html__('No Searches found','wpresidence-core'),
                'parent'                =>  esc_html__('Parent Searches','wpresidence-core')
			),
		'public'        =>  false,
                'show_ui'       =>  true,
		'has_archive'   =>  false,
		'rewrite'       =>  array('slug' => 'searches'),
		'supports'      =>  array('title'),
		'can_export'    =>  true,
		'register_meta_box_cb' => 'wpestate_add_searches',
                 'menu_icon'=>WPESTATE_PLUGIN_DIR_URL.'/img/searches.png'
		)
	);
}
endif; // end   wpestate_create_invoice_type  

////////////////////////////////////////////////////////////////////////////////////////////////
// Add Invoice metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_searches') ):
function wpestate_add_searches() {	
        add_meta_box(  'estate_invoice-sectionid',  esc_html__( 'Search Details', 'wpresidence-core' ),'wpestate_search_details','wpestate_search' ,'normal','default');
}
endif; // end   wpestate_add_pack_invoices  



////////////////////////////////////////////////////////////////////////////////////////////////
// Invoice Details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_search_details') ):

function wpestate_search_details( $post ) {
    global $post;
    wp_nonce_field( plugin_basename( __FILE__ ), 'estate_invoice_noncename' );

    
}

endif; // end   wpestate_invoice_details  




/////////////////////////////////////////////////////////////////////////////////////
/// populate the invoice list with extra columns
/////////////////////////////////////////////////////////////////////////////////////

add_filter( 'manage_edit-wpestate_search_columns', 'wpestate_search_my_columns' );

if( !function_exists('wpestate_search_my_columns') ):
function wpestate_search_my_columns( $columns ) {
 
    $columns['by_email']        = esc_html__('Email to','wpresidence-core');
    $columns['parameters']      = esc_html__('Search parameters','wpresidence-core');
  
    return  $columns;
}
endif; // end   wpestate_invoice_my_columns  



add_action( 'manage_posts_custom_column', 'wpestate_search_populate_columns' );

if( !function_exists('wpestate_search_populate_columns') ):
function wpestate_search_populate_columns( $column ) {
    $the_id=get_the_ID();
    if ( 'by_email' == $column ) {
        echo get_post_meta($the_id, 'user_email', true);
    } 
    if ( 'parameters' == $column ) {
        $search_arguments           =  get_post_meta($the_id, 'search_arguments', true) ;
        $search_arguments_decoded   = (array)json_decode($search_arguments,true);
        $meta_arguments             =  get_post_meta($the_id, 'meta_arguments', true) ;
        $meta_arguments             = (array)json_decode($meta_arguments,true);
        $custom_advanced_search         =   wpresidence_get_option('wp_estate_custom_advanced_search','');
        $adv_search_what                =   wpresidence_get_option('wp_estate_adv_search_what','');
        $adv_search_how                 =   wpresidence_get_option('wp_estate_adv_search_how','');
        $adv_search_label               =   wpresidence_get_option('wp_estate_adv_search_label','');     
       print wpestate_show_search_params_new($meta_arguments,$search_arguments_decoded,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label);
    } 

    
}  
endif;    
?>