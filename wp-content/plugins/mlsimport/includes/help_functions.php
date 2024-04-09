<?php
/*
 *  Lopp troght the listings and get Listing key
 * 
 * 
 * 
 * 
 * 
 * */

function mlsimport_saas_reconciliation_event_function(){

    global $mlsimport; 
    $token = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();
    $options    =   get_option('mlsimport_admin_options');
     
    if( isset($options['mlsimport_mls_name']) && $options['mlsimport_mls_name']!='' ){
        $mlsimport->admin->mlsimport_saas_start_doing_reconciliation();
    }
}

/*
 *  Admin extra columns for MlsImport Items
 * 
 * 
 * 
 * 
 * 
 * */

add_filter('manage_edit-mlsimport_item_columns', 'mlsimport_items_columns_admin');

if (!function_exists('mlsimport_items_columns_admin')):

    function mlsimport_items_columns_admin($columns) {
        $slice = array_slice($columns, 2, 2);
        unset($columns['comments']);
        unset($slice['comments']);
        $splice = array_splice($columns, 2);
        
        $columns['mlsimport_items_params'] = esc_html__('Import Parameters', 'wpresidence-core');
        $columns['mlsimport_last_action'] = esc_html__('Last action', 'wpresidence-core');
        $columns['mlsimport_autoupdates'] = esc_html__('Auto Update Enabled', 'wpresidence-core');
    
        return array_merge($columns, array_reverse($slice));
    }

endif; // end   wpestate_my_columns




/*
 *  Admin extra columns for MlsImport Items - Populate with data display value
 * 
 * 
 * 
 * 
 * 
 * */
function mlsimport_populate_columns_params_display_value($value){
    $display_value='';
    if(is_array($value)){
      
        foreach($value as $key_item=>$item_name):
            $display_value .=$item_name.',';
           
        endforeach;
        $display_value=rtrim($display_value,',');
    }else{
        $display_value = $value;
    }

    return $display_value;
}
/*
 *  Admin extra columns for MlsImport Items - Populate with data
 * 
 * 
 * 
 * 
 * 
 * */

function mlsimport_populate_columns_params_display($postID){
    global $mlsimport;
    $field_import               =   $mlsimport->admin->mlsimport_saas_return_mls_fields();

    $select_all_none = array(
        'InternetAddressDisplayYN',
        'InternetEntireListingDisplayYN',
        'PostalCode',
        'ListAgentKey',
        'ListAgentMlsId',
        'ListOfficeKey',
        'ListOfficeMlsId',
        'StandardStatus'
        
    );
    foreach ($field_import as $key => $field):

      
            
        $display_value  ='';
        $name_check     = strtolower("mlsimport_item_" . $key . "_check");
        $name           = strtolower("mlsimport_item_" . $key);

        $value          = get_post_meta($postID, $name, true);
        $value_check    = get_post_meta($postID, $name_check, true);

        $is_checkbox_admin = 0;
        if ($value_check == 1) {
            $is_checkbox_admin = 1;
        }

        if (!in_array($key, $select_all_none)) {
            if($is_checkbox_admin==1){
                $display_value = esc_html('ALL','mlsimport');
            }else{
                $display_value = mlsimport_populate_columns_params_display_value($value);
            }
        }else{
            $display_value = mlsimport_populate_columns_params_display_value($value);
        }


        if($display_value!=''){
            print '<strong>'.ucfirst(str_replace('Select ','',$field['label'])).':</strong> '; 
            print $display_value;
            print '</br>';
        }
    
      


    endforeach;
}



add_action('manage_posts_custom_column', 'mlsimport_populate_columns');
if (!function_exists('mlsimport_populate_columns')):

    function mlsimport_populate_columns($column) {

        global $post;
       

        if ('mlsimport_items_params' == $column) {
           $mlsimport_item_min_price = floatval(get_post_meta($post->ID, 'mlsimport_item_min_price', true));
           $mlsimport_item_max_price = floatval(get_post_meta($post->ID, 'mlsimport_item_max_price', true));



            print '<strong>'.esc_html__('Minimum price:').'</strong> '.$mlsimport_item_min_price .'</br>';
            print '<strong>'.esc_html__('Maximum price:').'</strong> '.$mlsimport_item_max_price .'</br>';
           
           mlsimport_populate_columns_params_display($post->ID);

        } else if ('mlsimport_last_action' == $column) {
            $last_date                  =   get_post_meta($post->ID, 'mlsimport_last_date', true);
            if($last_date!=''){
                print $last_date.' </br>';
                esc_html_e('On this date we found new or edited listings.','mlsimport');
            }else{
                esc_html_e('Not available - sync option may be off.','mlsimport');
            }


        }else if('mlsimport_autoupdates'== $column){
            $mlsimport_item_stat_cron   =   esc_html(get_post_meta($post->ID, 'mlsimport_item_stat_cron', true));
            
            if(intval($mlsimport_item_stat_cron)>0){
                print 'yes';
            }else{
                print 'no';
            }
        }
    }
endif;  