<?php
// register the custom post type
add_action( 'setup_theme', 'wpestate_create_invoice_type' );

if( !function_exists('wpestate_create_invoice_type') ):
function wpestate_create_invoice_type() {
register_post_type( 'wpestate_invoice',
		array(
			'labels' => array(
				'name'          => esc_html__( 'Invoices','wpresidence-core'),
				'singular_name' => esc_html__( 'Invoices','wpresidence-core'),
				'add_new'       => esc_html__('Add New Invoice','wpresidence-core'),
                'add_new_item'          =>  esc_html__('Add Invoice','wpresidence-core'),
                'edit'                  =>  esc_html__('Edit Invoice' ,'wpresidence-core'),
                'edit_item'             =>  esc_html__('Edit Invoice','wpresidence-core'),
                'new_item'              =>  esc_html__('New Invoice','wpresidence-core'),
                'view'                  =>  esc_html__('View Invoices','wpresidence-core'),
                'view_item'             =>  esc_html__('View Invoices','wpresidence-core'),
                'search_items'          =>  esc_html__('Search Invoices','wpresidence-core'),
                'not_found'             =>  esc_html__('No Invoices found','wpresidence-core'),
                'not_found_in_trash'    =>  esc_html__('No Invoices found','wpresidence-core'),
                'parent'                =>  esc_html__('Parent Invoice','wpresidence-core')
			),
		'public' => false,
                'show_ui'=>true,
                'show_in_nav_menus'=>true,
                'show_in_menu'=>true,
                'show_in_admin_bar'=>true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'invoice'),
		'supports' => array('title'),
		'can_export' => true,
		'register_meta_box_cb' => 'wpestate_add_pack_invoices',
                'menu_icon'=>WPESTATE_PLUGIN_DIR_URL.'/img/invoices.png',
                'exclude_from_search'   => true
		)
	);
}
endif; // end   wpestate_create_invoice_type

////////////////////////////////////////////////////////////////////////////////////////////////
// Add Invoice metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_pack_invoices') ):
function wpestate_add_pack_invoices() {
        add_meta_box(  'estate_invoice-sectionid',  esc_html__( 'Invoice Details', 'wpresidence-core' ),'wpestate_invoice_details','wpestate_invoice' ,'normal','default');
}
endif; // end   wpestate_add_pack_invoices



////////////////////////////////////////////////////////////////////////////////////////////////
// Invoice Details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_invoice_details') ):

function wpestate_invoice_details( $post ) {
    global $post;
    wp_nonce_field( plugin_basename( __FILE__ ), 'estate_invoice_noncename' );

    $invoice_types      =   array('Listing','Upgrade to Featured','Publish Listing with Featured','Package');
    $invoice_saved      =   esc_html(get_post_meta($post->ID, 'invoice_type', true));

    $purchase_type  =   0;
    if($invoice_saved=='Listing'){
        $purchase_type=1;
    }else if( $invoice_saved == 'Upgrade to Featured'){
        $purchase_type=2;
    }else if($invoice_saved =='Publish Listing with Featured' ){
        $purchase_type=3;
    }


    $invoice_period            =  array('One Time','Recurring');
    $invoice_period_saved      =  esc_html(get_post_meta($post->ID, 'biling_type', true));

    $txn_id=esc_html(get_post_meta($post->ID, 'txn_id', true));

    print'
    <p class="meta-options">
        <strong>'.esc_html__('Invoice Id:','wpresidence-core').' </strong>'.$post->ID.'
    </p>';

    if( get_post_meta($post->ID, 'pay_status', true) ==0){
        if($invoice_saved=='Package'){
            print '<div id="activate_pack" data-invoice="'.$post->ID.'" data-item="'.get_post_meta($post->ID, 'item_id', true).'"> Wire Payment Received - Activate the purchase</div>';
            $ajax_nonce = wp_create_nonce( "wpestate_activate_pack" );
            print'<input type="hidden" id="wpestate_activate_pack" value="'.esc_html($ajax_nonce).'" />    ';

        }else{
            print '<div id="activate_pack_listing" data-invoice="'.$post->ID.'" data-item="'.get_post_meta($post->ID, 'item_id', true).' " data-type="'.$purchase_type.'"> Wire Payment Received - Activate the purchase</div>';
            $ajax_nonce = wp_create_nonce( "wpestate_activate_pack_listing" );
            print'<input type="hidden" id="wpestate_activate_pack_listing" value="'.esc_html($ajax_nonce).'" />    ';
        }


        print'
        <p class="meta-options" id="invnotpaid">
            <strong>'.esc_html__('Invoice NOT paid','wpresidence-core').' </strong>
        </p>';

    }else{
        print'
        <p class="meta-options">
            <strong>'.esc_html__('Invoice PAID','wpresidence-core').' </strong>
        </p>';

    }


    print'

    <p class="meta-options">
        <label for="biling_period">'.esc_html__('Billing For :','wpresidence-core').'</label><strong> '. $invoice_saved .' </strong>
    </p>

    <p class="meta-options">
        <label for="biling_type">'.esc_html__('Billing Type :','wpresidence-core').'</label><strong>'.$invoice_period_saved.'</strong>
    </p>

    <p class="meta-options">
        <label for="item_id">'.esc_html__('Item Id (Listing or Package id)','wpresidence-core').'</label><br />
        <input type="text" id="item_id" size="58" name="item_id" value="'.  esc_html(get_post_meta($post->ID, 'item_id', true)).'">
    </p>

    <p class="meta-options">
        <label for="item_price">'.esc_html__('Item Price','wpresidence-core').'</label><br />
        <input type="text" id="item_price" size="58" name="item_price" value="'.  esc_html(get_post_meta($post->ID, 'item_price', true)).'">
    </p>

   <p class="meta-options">
        <label for="purchase_date">'.esc_html__('Purchase Date','wpresidence-core').'</label><br />
        <input type="text" id="purchase_date" size="58" name="purchase_date" value="';


        $purchase_date  = esc_html(get_post_meta($post->ID, 'purchase_date', true));
        $time_unix      = strtotime($purchase_date);
        echo gmdate( 'Y-m-d H:i:s', ( $time_unix+ ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ) );

        print'">
    </p>

    <p class="meta-options">
        <label for="buyer_id">'.esc_html__('User Id','wpresidence-core').'</label><br />
        <input type="text" id="buyer_id" size="58" name="buyer_id" value="'.  esc_html(get_post_meta($post->ID, 'buyer_id', true)).'">
    </p>

    ';
    if($txn_id!=''){
        print esc_html__('Paypal - Reccuring Payment ID: ','wpresidence-core').$txn_id;
    }
}

endif; // end   wpestate_invoice_details



/////////////////////////////////////////////////////////////////////////////////////
/// populate the invoice list with extra columns
/////////////////////////////////////////////////////////////////////////////////////

add_filter( 'manage_edit-wpestate_invoice_columns', 'wpestate_invoice_my_columns' );

if( !function_exists('wpestate_invoice_my_columns') ):
function wpestate_invoice_my_columns( $columns ) {
    $slice=array_slice($columns,2,2);
    unset( $columns['comments'] );
    unset( $slice['comments'] );
    $splice=array_splice($columns, 2);
    $columns['invoice_price']   = esc_html__('Price','wpresidence-core');
    $columns['invoice_for']     = esc_html__('Billing For','wpresidence-core');
    $columns['invoice_type']    = esc_html__('Invoice Type','wpresidence-core');
    $columns['invoice_user']    = esc_html__('Purchased by User','wpresidence-core');
    $columns['invoice_status']  = esc_html__('Status','wpresidence-core');
    return  array_merge($columns,array_reverse($slice));
}
endif; // end   wpestate_invoice_my_columns


add_action( 'manage_posts_custom_column', 'wpestate_invoice_populate_columns' );

if( !function_exists('wpestate_invoice_populate_columns') ):
function wpestate_invoice_populate_columns( $column ) {
     $the_id=get_the_ID();
     if ( 'invoice_price' == $column ) {
        echo get_post_meta($the_id, 'item_price', true);
    }

    if ( 'invoice_for' == $column ) {
         echo get_post_meta($the_id, 'invoice_type', true);
    }

    if ( 'invoice_type' == $column ) {
        echo get_post_meta($the_id, 'biling_type', true);
    }

    if ( 'invoice_user' == $column ) {
        $user_id= get_post_meta($the_id, 'buyer_id', true);
        $user_info = get_userdata($user_id);
        if(isset($user_info->user_login)){
            echo esc_html($user_info->user_login);
        }
    }
    if ( 'invoice_status' == $column ) {
        $stat=get_post_meta($the_id, 'pay_status', 1);
        if($stat==0){
            esc_html_e('Not Paid','wpresidence-core');
        }else{
            esc_html_e('Paid','wpresidence-core');
        }
    }

}
endif; // end   wpestate_invoice_populate_columns


add_filter( 'manage_edit-wpestate_invoice_sortable_columns', 'wpestate_invoice_sort_me' );

if( !function_exists('wpestate_invoice_sort_me') ):
function wpestate_invoice_sort_me( $columns ) {
    $columns['invoice_price']   = 'invoice_price';
    $columns['invoice_user']    = 'invoice_user';
    $columns['invoice_for']     = 'invoice_for';
    $columns['invoice_type']    = 'invoice_type';
    $columns['invoice_status']    = 'invoice_status';
    return $columns;
}
endif; // end   wpestate_invoice_sort_me






/////////////////////////////////////////////////////////////////////////////////////
/// insert invoice
/////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_insert_invoice') ):
 function wpestate_insert_invoice($billing_for,$type,$pack_id,$date,$user_id,$is_featured,$is_upgrade,$paypal_tax_id){
    $post = array(
               'post_title'	=> 'Invoice ',
               'post_status'	=> 'publish',
               'post_type'     => 'wpestate_invoice'
           );
    
    if(intval($user_id)!=0){
        $post['post_author']=intval($user_id);
    }
    
    
    $post_id =  wp_insert_post($post );


    if($type==2){
        $type='Recurring';
    }else{
        $type='One Time';
    }

    $price_submission               =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
    $price_featured_submission      =   floatval( wpresidence_get_option('wp_estate_price_featured_submission','') );

    if($billing_for=='Package'){
        $price= get_post_meta($pack_id, 'pack_price', true);
    }else{
        if($is_upgrade==1){
             $price=$price_featured_submission;
        }else{
            if($is_featured==1){
                $price=$price_featured_submission+$price_submission;
            }else{
                 $price=$price_submission;
            }
        }


    }

    update_post_meta($post_id, 'invoice_type', $billing_for);
    update_post_meta($post_id, 'biling_type', $type);
    update_post_meta($post_id, 'item_id', $pack_id);
    update_post_meta($post_id, 'item_price',$price);
    update_post_meta($post_id, 'purchase_date', $date);
    update_post_meta($post_id, 'buyer_id', $user_id);
    update_post_meta($post_id, 'txn_id', $paypal_tax_id);
    $my_post = array(
       'ID'             => $post_id,
       'post_title'     => esc_html__('Invoice','wpresidence-core').' '.$post_id,
    );
    wp_update_post( $my_post );
    return $post_id;
}
endif; // end   wpestate_insert_invoice





add_action( 'wp_ajax_wpestate_ajax_create_print_invoice', 'wpestate_ajax_create_print_invoice' );

if( !function_exists('wpestate_ajax_create_print_invoice') ):
function wpestate_ajax_create_print_invoice(){
	check_ajax_referer( 'wpestate_invoices_actions', 'security' );
	if(!isset($_POST['propid'])|| !is_numeric($_POST['propid'])){
			exit('out pls1');
	}

	$post_id	= intval($_POST['propid']);
	$the_post	= get_post( $post_id);

	if($the_post->post_type!='wpestate_invoice' || $the_post->post_status!='publish'){
			exit('out pls2');
	}
	$title              = get_the_title($post_id);


	$current_user                   =   wp_get_current_user();

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// end get agent details
	/////////////////////////////////////////////////////////////////////////////////////////////////////

	print  '<html><head><title>'.$title.'</title><link href="'.get_stylesheet_uri().'" rel="stylesheet" type="text/css" />';


	if(is_child_theme()){
			print '<link href="'.get_template_directory_uri().'/css/dashboard/dashboard_style.css" rel="stylesheet" type="text/css" />';
	}

	if(is_rtl()){
			print '<link href="'.get_template_directory_uri().'/rtl.css" rel="stylesheet" type="text/css" />';
	}
	print '</head>';
	$protocol = is_ssl() ? 'https' : 'http';
	print  '<body class="print_body" >';

	$logo=wpresidence_get_option('wp_estate_logo_image','url');
	if ( $logo!='' ){
		 print '<img src="'.$logo.'" class="img-responsive printlogo" alt="logo"/>';
	} else {
		 print '<img class="img-responsive printlogo" src="'. get_theme_file_uri('/img/logo.png').'" alt="logo"/>';
	}

	$invoce_to_name  =  get_user_meta(	$current_user->ID,'first_name',true).' '.get_user_meta(	$current_user->ID,'last_name',true);
	$invoce_to_email =  $current_user->user_email;

	$invoce_company_name   =	esc_html( wpresidence_get_option('wp_estate_company_name', '') );
	$invoce_receiver_email =	esc_html( wpresidence_get_option('wp_estate_email_adr', '') );
	$invoce_receiver_phone =	esc_html( wpresidence_get_option('wp_estate_telephone_no', '') );
	$invoce_receiver_addres =	esc_html( wpresidence_get_option('wp_estate_co_address', '') );


        $invoice_saved      		=   esc_html(get_post_meta($post_id, 'invoice_type', true));
        $invoice_period_saved           =   esc_html(get_post_meta($post_id, 'biling_type', true));
	$invoice_total 			=   esc_html(get_post_meta($post_id, 'item_price', true));
	$invoice_payment_method         =   '';
        
        
        $translations = array(
            'Upgrade to Featured'           =>  esc_html__('Upgrade to Featured','wpresidence-core'),
            'Publish Listing with Featured' =>  esc_html__('Publish Listing with Featured','wpresidence-core'),
            'Package'                       =>  esc_html__('Package','wpresidence-core'),
            'Listing'                       =>  esc_html__('Listing','wpresidence-core'),
            'One Time'                      =>  esc_html__('One Time','wpresidence-core'),
            'Recurring'                     =>  esc_html__('Recurring','wpresidence-core')
        );
        
        
   

	$invoice_exra_details =	esc_html( wpresidence_get_option('wp_estate_invoice_extra_details_print', '') );

	$purchase_date  = esc_html(get_post_meta($post->ID, 'purchase_date', true));
	$time_unix      = strtotime($purchase_date);
	$print_date			= gmdate( 'Y-m-d H:i:s', ( $time_unix+ ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ) );

	print '<h1 class="invoice_print_title">'.$title.'</h1>';
	if($purchase_date!=''){
		print '<div class="wpestate_invoice_date">'.$print_date.'</div>';
	}

	print '<div class="wpestate_print_invoice_to_section">';
		print '<strong>'.esc_html__('To','wpresidence-core').':</strong> '.$invoce_to_name.'</br>';
		print '<strong>'.esc_html__('Email','wpresidence-core').':</strong> '.$invoce_to_email;
	print '</div>';

	print '<div class="wpestate_print_invoice_from_whom_section">';
	print '<strong>'.esc_html__('Name','wpresidence-core').':</strong> '.$invoce_company_name.'</br>';
	print '<strong>'.esc_html__('Email','wpresidence-core').':</strong> '.$invoce_receiver_email.'</br>';
	print '<strong>'.esc_html__('Phone','wpresidence-core').':</strong> '.$invoce_receiver_phone.'</br>';

	print $invoce_receiver_addres;

	print '</div>';


	print '<div class="wpestate_print_invoice_details_wrapper">';
		print '<div class="wpestate_print_invoice_details_detail"><label>'.esc_html__('Billing for','wpresidence-core').': </label>'.$translations[$invoice_saved]. '</div>';
		print '<div class="wpestate_print_invoice_details_detail"><label>'.esc_html__('Billing type','wpresidence-core').': </label>'.$translations[$invoice_period_saved].'</div>';
		//print '<div class="wpestate_print_invoice_details_detail"><label>'.esc_html__('Payment Method','wpresidence-core').': </label>'.$invoice_payment_method.'</div>';
		print '<div class="wpestate_print_invoice_details_detail"><label>'.esc_html__('Total Price','wpresidence-core').': </label>'.wpestate_show_price_custom_invoice($invoice_total).'</div>';
	print '<div>';


	print '<div class="wpestate_print_invoice_details_wrapperex_details">'.$invoice_exra_details.'</div>';
	print '<div class="wpestate_print_invoice_end">'.esc_html__('Thank you for your business!','wpresidence-core').'</div>';
	print'</div>';

	print '<div class="print_spacer"></div>';
	print '</body></html>';
	die();
}

endif;








?>
