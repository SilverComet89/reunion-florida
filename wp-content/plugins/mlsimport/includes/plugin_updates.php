<?php

add_filter('pre_set_site_transient_update_plugins', 'mlsimport_check_update');
  
function mlsimport_check_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }
    
        
        $path=MLSIMPORT_PLUGIN_PATH.'mlsimport.php';
 
 
        
        
        $remote_version = json_decode( mlsimport_getRemote_version() ); 
        $plugin_data = get_plugin_data( $path,'false');
          
        // If a newer version is available, add the update
        if (version_compare($plugin_data['Version'] , $remote_version->version, '<')) {
        
            $obj = new stdClass();
            $obj->slug          =   'mlsimport';
            $obj->plugin        =   'mlsimport/mlsimport.php';
            $obj->new_version   =   $remote_version->version;   
            $obj->url           =   'mlsimport.com';
            $obj->package       =   $remote_version->download_url;
            $obj->banners       =   json_decode(json_encode($remote_version->banners), true); 
            $obj->sections      =   json_decode(json_encode($remote_version->sections), true);            
            $transient->response['mlsimport/mlsimport.php'] = $obj;
        }
       
        return $transient;
    }
 
    
    
function mlsimport_getRemote_version() {
    $url =MLSIMPORT_API_URL.'plugin';
    $request = wp_remote_get(MLSIMPORT_API_URL.'plugin',
                                   array(
                                           'timeout' => 10,
                                           'headers' => array(
                                                   'Accept' => 'application/json'
                                           )
                                   ));
    if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
        return $request['body'];
    }
    return false;
} 



add_filter('plugins_api', 'mlsimport_saas_check_info', 10, 3);
function mlsimport_saas_check_info($false, $action, $arg){

        if (isset($arg->slug) && $arg->slug === 'mlsimport') {
            $remote_version = json_decode( mlsimport_getRemote_version() );
 
            
            $obj = new stdClass();
            $obj->slug          =   'mlsimport';
            $obj->plugin        =   'mlsimport/mlsimport.php';
            $obj->new_version   =   $remote_version->version;   
            $obj->url           =   'mlsimport.com';
            $obj->package       =   $remote_version->download_url;
            
            $obj->sections      =   json_decode(json_encode($remote_version->sections), true);   
            
            $obj->banners = array(
		'low' => $remote_version->banners->low,
		'high' => $remote_version->banners->high
            );
            
            return $obj;
            
            
           
        }
        return false;
}