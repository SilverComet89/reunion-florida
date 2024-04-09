<?php
/**
 * Description of ThemeImport
 *
 * @author cretu
 */
class ThemeImport {
    //put your code here
    
    public $theme;
    public $plugin_name;
    public $enviroment;
    public $encoded_values;
    /**
    * class construct
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function __construnct($plugin_name){
        $this->plugin_name      =   $plugin_name;
        $this->encoded_values   =   get_option('mlsimport_encoding_array');
    }
    
   
   
    /*
     *
     * 
     * Api Request to MLSimport APi 
     * 
     * 
     * 
     * */
    
    
    public function  global_api_request_CURL_saas($method,$values_array,$type="GET"){
        $curl = curl_init();
        $url  =   MLSIMPORT_API_URL.$method;
        global $mlsimport;
        
        $headers= array( 'Content-Type'=> 'text/plain');
        
        if($method!='token'){
            $token = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();
            $headers=array(
                'authorizationToken: '.$token,
                'Content-Type: application/json'
              );        
        }

    
            
        curl_setopt_array($curl, array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => $type,
            CURLOPT_POSTFIELDS      => json_encode($values_array),
            CURLOPT_HTTPHEADER      => $headers
        ));

        $response = curl_exec($curl);
        $to_return = json_decode($response,true);
        
        
        return $to_return;
        
    }
    
    
    
    
    /*
     *
     * 
     * Api Request to MLSimport APi 
     * 
     * 
     * 
     * */
    
    
    public static function  global_api_request_saas($method,$values_array,$type="GET"){
            global $mlsimport;
            $url                        =   MLSIMPORT_API_URL.$method;
            
            $headers= array();
            if($method!='token' && $method!='mls'){
                $token = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();
                $headers=array(
                    'authorizationToken'=>$token,
                     'Content-Type'=> 'application/json'
                );
            }
            
          
            
            
            $arguments = array(
                'method'        => $type,
                'timeout'       => 45,
                'redirection'   => 5,
                'httpversion'   => '1.0',
                'blocking'      => true,
                'headers'       => $headers,
                //'body'          => json_encode($values_array),
                'cookies'       => array()
            );
            
            
            if(is_array($values_array) && !empty($values_array)){
                $arguments['body']=json_encode($values_array);
            }
            
            $response       = wp_remote_post($url,$arguments);
     
            if (is_wp_error($response)) {
                // It is a WordPress error.
                $error_code = $response->get_error_code();
                print '<div class="mlsimport_warning">'.esc_html__('You have a Wordpress Error. Error code: ','mlsimport').$error_code.'. '.esc_html__('Error Description: ').$response->get_error_message($error_code).'</div>';
                
                $received_data['succes']=false;
                return $received_data;
            }
            

            if( isset($response['response']['code']) && $response['response']['code']=='200'){
                $received_data  = json_decode( wp_remote_retrieve_body($response) ,true);
                return $received_data;
            }else{     
                $received_data['succes']=false;
                return $received_data;
            }
            exit();
    } 
    



  
    
    
    
    /**
    * 
    * 
    * 
    * Parse Result Array
    * 
    *
    * 
    */
    
    
    public function mlsimport_saas_parse_search_array_per_item($ready_to_parse_array,$item_id_array,$batch_key){
        $logs   =   '';
           
        $counter_prop=0;
        foreach( $ready_to_parse_array['data'] as $key=>$property ){
            $counter_prop++;
            $logs = 'In parse search array, listing no '.$key.' from batch '.$batch_key.' with Listingkey: ' .$property['ListingKey'].PHP_EOL;
            mls_saas_single_write_import_custom_logs($logs,'import');
            
            $GLOBALS['wp_object_cache']->delete( 'mlsimport_force_stop_'.$item_id_array['item_id'], 'options' );
            $status =  get_option('mlsimport_force_stop_'.$item_id_array['item_id'])  ;
            $logs='on Batch '.$item_id_array['batch_counter'].'/'.$counter_prop .' check ListingKey '.$property['ListingKey'].' - stop command issued ? '.$status.PHP_EOL;
            mls_saas_single_write_import_custom_logs($logs,'import');
           
            if($status=='no'){
                //sleep(3);
                $logs ="Will proceed to import - Memory Used ".memory_get_usage().PHP_EOL;
                mls_saas_single_write_import_custom_logs($logs,'import');
           
                $this->mlsimport_saas_prepare_to_import_per_item($property,$item_id_array,'normal');  
            }else{
                update_post_meta($item_id_array['item_id'],'mlsimport_spawn_status','completed');
            }
            
        }
       
     
    }
    
    
    /**
    * 
    * 
    * Parse Result Array in CROn
    *
    * 
    */
    
    public function mlsimport_saas_cron_parse_search_array_per_item($ready_to_parse_array,$item_id_array,$batch_key){
        
        foreach( $ready_to_parse_array['data'] as $key=>$property ){
            $logs = 'In CRON parse search array, listing no '.$key.' from batch '.$batch_key.' with Listingkey: ' .$property['ListingKey'].PHP_EOL;
            mls_saas_single_write_import_custom_logs($logs,'cron');
            $this->mlsimport_saas_prepare_to_import_per_item($property,$item_id_array,'cron');  
        }
       
    }
    
    
    
    
    
    
    
    
    
    
    
    
  
    

    
    
    /**
    *
    * 
    *  check if property already imported
    *
    *
    */
    
    public function mlsimport_saas_retrive_property_by_id($key,$post_type='estate_property'){
        global $mlsimport;
      
        
        $args=array(
            'post_type'     => $post_type,
            'post_status'   => 'any',

            'meta_query'    => array(
                            array(
                                'key'     => 'ListingKey',
                                'value'   => $key,
                                'compare' => '=',
                            )
                            ),
            'fields'=>'ids'
            );


        $prop_selection  =   new WP_Query($args);  
        if( $prop_selection->have_posts() ){
            while ( $prop_selection->have_posts() ) {
                $prop_selection->the_post();
                $the_id = get_the_ID();
            }
            wp_reset_query();
            wp_reset_postdata();
            return $the_id;
        }else{
            wp_reset_query();
            wp_reset_postdata();
           return 0;
        }
        
    }
     
    
    

      
    /**
    * clear taxonomy
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    
    public function mlsimport_saas_clear_property_for_taxonomy($property_id,$taxonomies){

        if(is_array($taxonomies)):
            foreach($taxonomies as $taxonomy=>$term):
                wp_delete_object_term_relationships($property_id,$taxonomy ); 
            endforeach;
        endif;
         
       
    }
    
    
    
    
    
    
    
    
    /**
    * return non encoded encoded values
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function mlsimport_saas_return_non_encoded_value($item,$encoded_values){
        
 
        
        if(is_array($item)){
            if( !empty($encoded_values )){
                foreach($item as $key=>$value){
                    if( isset( $encoded_values [$value]) ){

                        $item[$key]=$encoded_values [$value];
                       
                    }
                }
            }
            return $item;
        }else{
              
            if( !empty($encoded_values ) &&  isset( $encoded_values [$item] ) ){
              
                return $encoded_values [$item];
            }else{
                return $item;
            }
        }
      
    }
    
    /**
    * set taxonomy
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function mlsimport_saas_update_taxonomy_for_property( $taxonomy,$property_id,$field_values,$encoded_values){
      
        
        if ( !is_array($field_values) &&  strpos($field_values,',') !== false) {
            $field_values_array= explode(',', $field_values);
            $field_values=$field_values_array;
        }
        
        if(is_array($field_values)){
            foreach ($field_values as $key=>$value){
                if($value!=''){
                    wp_set_object_terms($property_id,$this->mlsimport_saas_return_non_encoded_value($value,$encoded_values),$taxonomy,true); 
                }
            }
            
        }else{
            if(!is_null($field_values) && $field_values!=''){
                wp_set_object_terms($property_id,$this->mlsimport_saas_return_non_encoded_value($field_values,$encoded_values),$taxonomy,true); 
            }
        }         
    }
    
    
    
    /*
     * 
     * 
     *  Update Taxonomy for property
     * 
     * 
     * 
     */
    
    public function update_taxonomy_for_property( $taxonomy,$property_id,$field_values,$encoded_values){
      
        
        if ( !is_array($field_values) &&  strpos($field_values,',') !== false) {
            $field_values_array= explode(',', $field_values);
            $field_values=$field_values_array;
        }
        
        if(is_array($field_values)){
            foreach ($field_values as $key=>$value){
                if($value!=''){
                    wp_set_object_terms($property_id,$this->mlsimport_saas_return_non_encoded_value($value,$encoded_values),$taxonomy,true); 
                }
            }
            
        }else{
            if(!is_null($field_values) && $field_values!=''){
                wp_set_object_terms($property_id,$this->mlsimport_saas_return_non_encoded_value($field_values,$encoded_values),$taxonomy,true); 
            }
        }         
    }
    
    
    /**
    * Set Property Title
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    
    
    function mlsimport_saas_update_property_title($property_id,$mls_import_post_id,$property){
       
        global $mlsimport;
       
        $title_format=    esc_html(get_post_meta($mls_import_post_id, 'mlsimport_item_title_format', true));

        if($title_format==''){
            $options        =   get_option('mlsimport_admin_mls_sync');
            $title_format   =   $options['title_format'];
        }
        
        $start          =   "{";
        $end            =   "}";       
        $title_array    =   $this->str_between_all($title_format, $start, $end);
        
      
       
        foreach ($title_array as $key=>$value ){
            
            $replace            =   '';
            if($value=='Address'){
                if(isset($property['adr_title'])){
                    $replace        =   $property['adr_title'];
                }
                $title_format   =   str_replace('{Address}', $replace, $title_format);
                
                  
            }else if($value=='City'){
              
                if(isset($property['adr_city'])){
                    $replace        =   $property['adr_city'];
                }
                $title_format   =   str_replace('{City}', $replace, $title_format);
                
            }else if($value=='CountyOrParish'){
                
                if(isset($property['adr_county'])){
                    $replace        =   $property['adr_county'];
                }
                $title_format   =   str_replace('{CountyOrParish}', $replace, $title_format);
                
            }else if($value=='PropertyType'){
              
                if(isset($property['adr_type'])){
                    $replace        =   $property['adr_type'];
                }
                $title_format   =   str_replace('{PropertyType}', $replace, $title_format);
                
            }else  if($value=='Bedrooms'){
                
                if(isset($property['adr_bedrooms'])){
                    $replace        =   $property['adr_bedrooms'];
                }
                $title_format   =   str_replace('{Bedrooms}', $replace, $title_format);
                
            }else  if($value=='Bathrooms'){
                if(isset($property['adr_bathrooms'])){
                    $replace        =   $property['adr_bathrooms'];
                }
                $title_format   =   str_replace('{Bathrooms}', $replace, $title_format);
                
            }else if($value=='ListingKey'){
                $replace        =   $property['ListingKey'];
                if($replace!=''){
                    $title_format   =   str_replace('{ListingKey}', $replace, $title_format);
                }
            }else if($value=='ListingId'){
                 if(isset($property['adr_listingid'])){
                    $replace        =   $property['adr_listingid'];
                }
                if($replace!=''){
                    $title_format   =   str_replace('{ListingId}', $replace, $title_format);
                }
            }else  if($value=='StateOrProvince'){
                
                if(isset($property['extra_meta']['StateOrProvince'])){
                    $replace        =   $property['extra_meta']['StateOrProvince'];
                }
                $title_format   =   str_replace('{StateOrProvince}', $replace, $title_format);
                
            } else  if($value=='PostalCode'){

                if(isset($property['meta']['property_zip'])){
                
                    if( is_array($property['meta']['property_zip']) ){
                        $replace        =  strval( $property['meta']['property_zip'][0]);               
                    }else{
                        $replace        =  strval( $property['meta']['property_zip']);              
                    }
                
                } else if(isset($property['meta']['fave_property_zip'])){
                  
                    if( is_array($property['meta']['fave_property_zip']) ){
                        $replace        =  strval( $property['meta']['fave_property_zip'][0]);               
                    }else{
                        $replace        =  strval( $property['meta']['fave_property_zip']);              
                    }
                    
                }

                $title_format   =   str_replace('{PostalCode}', $replace, $title_format);
                
            }
            
        }
         
        
        $post = array(
            'ID'            => $property_id,
            'post_title'    => $title_format,
            'post_name'     => $title_format,
        );
          
        wp_update_post($post);  
        return $title_format;
        
    }
    
    
    
    

 
   

     /**
      * 
      * 
      * 
      * 
    * import property -prepare
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    
 
    public function mlsimport_saas_prepare_to_import_per_item($property,$item_id_array,$tip_import){
        // check if MLS id is set
        global $mlsimport;

        $mls_import_item_status = get_post_meta($item_id_array['item_id'], 'mlsimport_item_standardstatus',true);
        $mls_import_item_status=array_map('strtolower',$mls_import_item_status);
        
    
        set_time_limit(0);
        if( !isset($property['ListingKey']) ){
            $log ="ERROR : No Listing Key ".PHP_EOL;
            mls_saas_single_write_import_custom_logs($log,$tip_import);
            return;
        }
             
        ob_start();
                 
        $ListingKey                     =   $property['ListingKey'];
        $listing_post_type              =   $mlsimport->admin->env_data->get_property_post_type();
        $property_id                    =   intval($this->mlsimport_saas_retrive_property_by_id($ListingKey ,$listing_post_type ) );
        $status                         =   'Not Found';
        $property_history               =   '';
        if( isset($property['StandardStatus']) ){
            $status =   strtolower( $property['StandardStatus'] );
        }else{
            $status =   strtolower( $property['extra_meta']['MlsStatus'] );
        }
        
        if($property_id==0){
            $is_insert='no';
            if($status=='active' || $status=='active under contract' ||  
               $status=='active with contract' || $status=='activewithcontract' || 
               $status=='status' || $status=="activeundercontract" || 
               $status=="comingsoon" || $status=="coming soon" ||
               $status=="pending"){
               
                $is_insert='yes';
                if($tip_import=='cron'){
                    if( !in_array( $status,$mls_import_item_status) ){
                        // REJECTED because not selected';
                        $is_insert='no';
                    }

                }
            
            }            
        }else{
            $is_insert='no';
        }
        
        $log='We have property with $ListingKey='.$ListingKey.' id='.$property_id.' with status '.$status.' is insert? '.$is_insert.PHP_EOL;
    
        mls_saas_single_write_import_custom_logs($log,$tip_import);

        
        
        
        //content set and check
        $content            =   '';
        $submit_title       =   $ListingKey; 
        if(isset($property['content'])){
            $content=$property['content'];
        }
        
        $new_author         =   get_post_meta($item_id_array['item_id'],'mlsimport_item_property_user',true );
        $new_agent          =   esc_html(get_post_meta($item_id_array['item_id'], 'mlsimport_item_agent', true));
        $property_status    =   esc_html(get_post_meta($item_id_array['item_id'], 'mlsimport_item_property_status', true));

        if($is_insert=='yes'){           
            $post = array(
                'post_title'	=> $submit_title,
                'post_content'	=> $content,
                'post_status'	=> $property_status, 
                'post_type'     => $listing_post_type,
                'post_author'   => $new_author 
            );
            
            $property_id =  wp_insert_post($post );  
            
            if (is_wp_error($property_id)){
                $log ="ERROR : on inserting ".PHP_EOL;
                mls_saas_single_write_import_custom_logs($log,$tip_import);
            }else{
                update_post_meta($property_id,'ListingKey',$ListingKey);
                $property_history.= date("F j, Y, g:i a").': We Inserted the property with Default title :  '.$submit_title.' and received id:'.$property_id.'</br>';
              
            }
            
           
        }else{
         
            if($property_id!=0){
                $property_history=get_post_meta($property_id,'mlsimport_property_history',true);
                
                $delete_statuses =array(
                    'incomplete'=>'incomplete',
                    'hold'=>'hold',
                    'canceled'=>'canceled',
                    'closed'=>'closed',
                    'delete'=>'delete',
                    'expired'=>'expired',
                    'withdrawn'=>'withdrawn'
                );

                if( !in_array('pending', $mls_import_item_status)){
                    $delete_statuses['pending']='pending';
                }
                
                
                if(in_array($status,$delete_statuses)){
                        $log = 'Property with ID '.$property_id.' and with name '.get_the_title($property_id).' has a status of <strong>'. $status.'</strong> and will be deleted'.PHP_EOL;
                        $log='--1---> '.$log. json_encode($mls_import_item_status).PHP_EOL;                                        
                        if(in_array($status, $mls_import_item_status)){
                            $log.='-2--> canceling the delete '.PHP_EOL;
                        }else{
                            $log.='--3--> proceed with the delete '.PHP_EOL;      
                            $this->delete_property($property_id,$ListingKey);
                        }
                        
                        mls_saas_single_write_import_custom_logs($log,$tip_import);
                        
                        
        
                        return;
                }else {

                    $post = array(
                        'ID'            => $property_id,
                        //'post_title'    => $submit_title,
                        'post_content'  => $content,
                        'post_type'     => $listing_post_type,
                        'post_author'   => $new_author
                    );


                    $log =' Property with ID '.$property_id.' and with name '.get_the_title($property_id).' has a status of <strong>'.$status.'</strong> and will be Edited</br>';
                    mls_saas_single_write_import_custom_logs($log,$tip_import);
                        
                    $property_id =  wp_update_post($post );  
                    
                    if (is_wp_error($property_id)){
                        $log ="ERROR : on edit ".PHP_EOL;
                        mls_saas_single_write_import_custom_logs($log,$tip_import);
                    }else{
                       
                        $submit_title=get_the_title($property_id);
                        $property_history.= date("F j, Y, g:i a").': Property with title: '.$submit_title.', id:'.$property_id.', ListingKey:'.$ListingKey.', Status:'.$status.' will be edited.</br>';
                    }
                    
                }
            }
        }

        
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Insert or edit POST ends her - START ADDING DETAILS
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $encoded_values=array();//may be obsolote
                
                
        if(intval($property_id)==0){
            mls_saas_single_write_import_custom_logs('ERROR property id is 0'.PHP_EOL,$tip_import);
            return; // no point in going forward if no id
        }
        
        
        // Start working on Taxonomies
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $tax_log = 'Property with ID '.$property_id. ' NO taxonomies found ! '.PHP_EOL;
         
        if( isset($property['taxonomies']) && is_array($property['taxonomies'])){
            $taxonomies =   $property['taxonomies'];
            $tax_log    =   '';
            
            $this->mlsimport_saas_clear_property_for_taxonomy($property_id, $property['taxonomies'] );
            
            foreach($taxonomies as $taxonomy=>$term):
            
                $this->mlsimport_saas_update_taxonomy_for_property( $taxonomy,$property_id,$term,$encoded_values);
                $property_history.= 'Updated Taxonomy '.$taxonomy.' with terms '.json_encode($term).'</br>';
                $tax_log .= 'Property with ID '.$property_id. '  Updated Taxonomy '.$taxonomy.' with terms '.json_encode($term).PHP_EOL;  
                        
            endforeach;
           
        }
        mls_saas_single_write_import_custom_logs($tax_log,$tip_import);
        
        
        // Start working on Meta
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $meta_log = 'Property with ID '.$property_id. ' NO meta found ! '.PHP_EOL;
        
        if( isset($property['meta']) && is_array($property['meta'])){
            $meta_properties = $property['meta'];
            foreach($meta_properties as $meta_name => $meta_value ):
                if(is_array($meta_value)){
                    $meta_value= implode(',', $meta_value);
                }
                update_post_meta($property_id,$meta_name,$meta_value);
            
                $property_history.= 'Updated Meta '.$meta_name.' with meta_value '.$meta_value.'</br>';
                $meta_log .= 'Property with ID '.$property_id. '  Updated Meta '.$meta_name.' with value '.$meta_value.PHP_EOL;  
            endforeach;
             
        }
        mls_saas_single_write_import_custom_logs($meta_log,$tip_import);
         
         // Start working on EXTRA Meta
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $extra_meta_log = 'Property with ID '.$property_id. ' Start Extra meta ! '.PHP_EOL;
        $extra_meta_result =  $mlsimport->admin->env_data->mlsimport_saas_set_extra_meta($property_id,$property);
        
        if(isset($extra_meta_result['property_history'])){
            $property_history.= $extra_meta_result['property_history'];
        }        
        if(isset($extra_meta_result['extra_meta_log'])){
            $extra_meta_log.= $extra_meta_result['extra_meta_log'];
        }

        mls_saas_single_write_import_custom_logs($extra_meta_log,$tip_import);

         
        
        // Start working on Property Media
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
           
        $media = $property['Media'];
        $media_history = $this->mlsimport_sass_attach_media_to_post($property_id,$media,$is_insert);
        $property_history.= $media_history;
         

        
        
        // Updateing property title and ending
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $new_title = $this->mlsimport_saas_update_property_title($property_id,$item_id_array['item_id'],$property);
        $property_history.= 'Updated title to  '.$new_title.'</br>';
            
        
        //extra fields to be checked
        $global_extra_fields=array();
        $mlsimport->admin->env_data->correlation_update_after($is_insert,$property_id,$global_extra_fields,$new_agent);
        
        
        //saving history
        if($property_history!=''){
            $disable_history= intval( get_option('mlsimport-disable-history',1) );
            if($disable_history==1 ){
                $property_history.='---------------------------------------------------------------</br>';
                update_post_meta($property_id,'mlsimport_property_history',$property_history);
            }
        }
        
        $logs           =  'Ending on Property '.$property_id.', ListingKey: '.$ListingKey.' , is insert? '.$is_insert.' with new title: '. $new_title .'  '.PHP_EOL ;
        mls_saas_single_write_import_custom_logs($logs,$tip_import);
        
        $capture        =   ob_get_contents();ob_end_clean();
        mls_saas_single_write_import_custom_logs($capture,$tip_import);
        
        
        $post           =   null;
        $capture        =   null;
        $property_status=   null; 
        $new_agent      =   null;
        $new_author     =   null;
        $property_history=  null;
                  
    }
   

 

    

   
    
    
    
    /**
    * attach media to post
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    
    public function mlsimport_sass_attach_media_to_post($property_id,$media,$is_insert){
       
        // print 'attach_media_to_post';
        $media_history='';
        if($is_insert=='no'){
            $media_history.=' Media - We have edit - images are not replaced </br>';
            return $media_history;
        }
        
        global $mlsimport;
        include_once( ABSPATH . 'wp-admin/includes/image.php' );
        $has_featured      =   false;
        $all_images        =   array();
       
        delete_post_meta( $property_id, 'fave_property_images' );
        delete_post_meta( $property_id, 'REAL_HOMES_property_images' );
        
        add_filter('intermediate_image_sizes_advanced', array( $this,'wpc_unset_imagesizes' ) );
        
        // sorting media
        if( isset( $media[0]['Order']) ){
            $order  = array_column($media, 'Order');
            array_multisort($order, SORT_ASC,  $media);
        }
        
        
        if(is_array($media)){
            foreach($media as $key=>$image):
                
                if(isset($image['MediaCategory']) && $image['MediaCategory']!='Photo' ){
                    continue;
                }
                
                $file = $image['MediaURL'];
                
                $media_url='';
                if(isset($image['MediaURL'])){
                   
                    $attachment = array(
                        'guid'           => $image['MediaURL'], 
                        'post_status'    => 'inherit',
                        'post_content'   => '',
                        'post_parent'    => $property_id
                      );


                    if(isset( $image['MimeType'])){
                        $attachment['post_mime_type'] = $image['MimeType'];
                    }else{
                        $attachment['post_mime_type'] = 'image/jpg';
                    }

                    if( isset($image['MediaKey']) ){
                        $attachment['post_title']= $image['MediaKey'];
                    }else{
                        $attachment['post_title']= '';
                    }

                    $attach_id      =   wp_insert_attachment( $attachment, $file );
               
                    $media_history.=' Media - Added '.$image['MediaURL'].' as attachement '.$attach_id.' </br>';
                    //    wp_generate_attachment_metadata($attach_id,$image['MediaURL']);
                    $mlsimport->admin->env_data->enviroment_image_save($property_id,$attach_id);
                
                    update_post_meta($attach_id,'is_mlsimport',1);
                    if(!$has_featured){
                        set_post_thumbnail( $property_id, $attach_id );
                        $has_featured=true;
                    }
                }
            endforeach;
        }else{
            $media_history.=' Media data is blank - there are no images </br>';
           
        }
       remove_filter('intermediate_image_sizes_advanced', array( $this,'wpc_unset_imagesizes' ) );
       return $media_history;
    }
    
    
    
    function wpc_unset_imagesizes($sizes){
        $sizes=array();
    }
    
    
    
    
    
    
    
    
    
    
    /**
    * return user option
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    
     public function mlsimport_saas_theme_import_select_user($selected){
        $blog_list  =   '';
        $blogusers  =   get_users( 'blog_id=1&orderby=nicename' );
        foreach ( $blogusers as $user ) {
            $the_id=$user->ID;
            $blog_list  .=  '<option value="' . $the_id . '"  ';
                if ($the_id == $selected) {
                    $blog_list.=' selected="selected" ';
                }
            $blog_list.= '>' .$user->user_login . '</option>';
        }
        return $blog_list;
     }
    
 
     
     
     
     
     
    
    /**
    * return agent option
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    
    
    public function mlsimport_saas_theme_import_select_agent($selected){
        global $mlsimport;
        $args2 = array(
            'post_type'      => $mlsimport->admin->env_data->get_agent_post_type(),
            'post_status'    => 'publish',
            'posts_per_page' => 150
        );
    
        
        if(method_exists($mlsimport,'get_agent_post_type')){
           $args2['post_type']= $mlsimport->admin->env_data->get_agent_post_type();
        }
        
        
        $agent_selection2   =   new WP_Query($args2);
        $agent_list_sec     =   '<option value=""><option>';
        
        
        while ($agent_selection2->have_posts()){
            $agent_selection2->the_post();  
            $the_id       =  get_the_ID();

            $agent_list_sec .=  '<option value="' . $the_id . '"  ';
            if ( $selected==$the_id ) {
                $agent_list_sec.=' selected="selected" ';
            }
            $agent_list_sec.= '>' . get_the_title() . '</option>';

        }
        wp_reset_postdata();
        
        return $agent_list_sec;
    }
    
    
    /**
    *delete property
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
     public function delete_property($delete_id,$ListingKey){
        if(intval($delete_id)>0){
            $arguments = array(
                'numberposts'   =>  -1,
                'post_type'     =>  'attachment',
                'post_parent'   =>  $delete_id,
                'post_status'   =>  null,
                'orderby'       =>  'menu_order',
                'order'         =>  'ASC'
            );
            $post_attachments = get_posts($arguments);

            foreach ($post_attachments as $attachment) {
                wp_delete_post($attachment->ID);                      
            }

            wp_delete_post( $delete_id );
            $log_entry=' Property with id '.$delete_id.' and '.$ListingKey.' was deleted on '.current_time('Y-m-d\TH:i').PHP_EOL;
            mls_saas_single_write_import_custom_logs($log_entry,'delete');
        }
    }
    
    
    
    
    
    
    
    
    
    
    
     /**
    * return_array with title items
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function str_between_all(string $string, string $start, string $end, bool $includeDelimiters = false, int &$offset = 0){
        $strings = [];
        $length = strlen($string);

        while ($offset < $length)
        {
            $found =$this->str_between($string, $start, $end, $includeDelimiters, $offset);
            if ($found === null) break;

            $strings[] = $found;
            $offset += strlen($includeDelimiters ? $found : $start . $found . $end); // move offset to the end of the newfound string
        }

        return $strings;
    }
    
      
    
    
    
    
    
    
    
    /**
    * str_between
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function str_between(string $string, string $start, string $end, bool $includeDelimiters = false, int &$offset = 0){
        if ($string === '' || $start === '' || $end === '') return null;

        $startLength = strlen($start);
        $endLength = strlen($end);

        $startPos = strpos($string, $start, $offset);
        if ($startPos === false) return null;

        $endPos = strpos($string, $end, $startPos + $startLength);
        if ($endPos === false) return null;

        $length = $endPos - $startPos + ($includeDelimiters ? $endLength : -$startLength);
        if (!$length) return '';

        $offset = $startPos + ($includeDelimiters ? 0 : $startLength);

        $result = substr($string, $offset, $length);

        return ($result !== false ? $result : null);
    }
    
    
    
    
    
    
    
      
     /**
    *delete property via sql
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function mlsimport_saas_delete_property_via_mysql($delete_id,$ListingKey){
          
        $post_type= get_post_type($delete_id);
          
      
        if ( $post_type == 'estate_property' || $post_type=='property'){ 
            
            $term_obj_list = get_the_terms( $delete_id, 'property_status' );
            $delete_id_status = join(', ', wp_list_pluck($term_obj_list, 'name'));
            
             
            $ListingKey =  get_post_meta($delete_id,'ListingKey',true);
            if($ListingKey==''){ // manual added listing
                
                $log_entry='User added listing  with id '.$delete_id.' ('.$post_type.') (status '.$delete_id_status.') and '.$ListingKey.'  NOT DELETED'.PHP_EOL;
                mls_saas_single_write_import_custom_logs($log_entry,'delete');
                return;
            }
            
            
            
            
            global $wpdb;
            $wpdb->query( $wpdb->prepare("
            DELETE FROM $wpdb->postmeta 
            WHERE `post_id` = %d",
            $delete_id
            ) );

            $wpdb->query( $wpdb->prepare("
            DELETE FROM $wpdb->posts 
            WHERE `post_parent` = %d",
            $delete_id
            ) );



            $wpdb->query( $wpdb->prepare("
            DELETE FROM $wpdb->posts 
            WHERE ID = %d",
            $delete_id
            ) );

            $log_entry='MYSQL DELETE -> Property with id '.$delete_id.' ('.$post_type.') (status '.$delete_id_status.') and '.$ListingKey.' was deleted on '.current_time('Y-m-d\TH:i').PHP_EOL;
            mls_saas_single_write_import_custom_logs($log_entry,'delete');
        }
        
    }
    
    
    
    
  

    
}