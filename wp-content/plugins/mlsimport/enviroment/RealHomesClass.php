<?php
/**
 * Description of WpResidenceClass
 *
 * @author mlsimport
 */
class RealHomesClass {
    
    public function __construct()    {
    }

   
    /** 
    * return custom post field
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function get_property_post_type(){
        return 'property';
    }
    
    
    
     /**
    * return custom post field
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function get_agent_post_type(){
        return 'agent';
    }
    
      /**
    *  image save
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function enviroment_image_save($property_id,$attach_id){
        add_post_meta( $property_id, 'REAL_HOMES_property_images', intval($attach_id) );
		
    }
    
    
    /**
    * Deal with extra meta
    *
    * 
    */
    
    public function mlsimport_saas_set_extra_meta($property_id,$property){
        $property_history   =   '';
        $extra_meta_log     =   '';
        $answer             =   array();
        $extra_fields       =   array();
        $options           =    get_option('mlsimport_admin_fields_select'); 
        $permited_meta      =   $options['mls-fields'];

        
      
         //save geo coordinates
        
        if( isset($property['meta']['property_longitude']) && isset($property['meta']['property_latitude']) ){
            $savingx=$property['meta']['property_latitude'].','.$property['meta']['property_longitude'];
            update_post_meta($property_id,'REAL_HOMES_property_location',$savingx); 
            $property_history.= 'Update Coordinates Meta with '.$savingx.'</br>';
            $extra_meta_log .= 'Property with ID '.$property_id. '  Update Coordinates Meta with '.$savingx.PHP_EOL;  
        }
        
        
        
        if( isset($property['extra_meta']) && is_array($property['extra_meta'])){
            $meta_properties = $property['extra_meta'];
            foreach($meta_properties as $meta_name => $meta_value ):
                
                // check if extra meta is set to import
                if( !isset($permited_meta[$meta_name]) ){
                    // we do not have the extra meta
                    continue;
                }else if( isset($permited_meta[$meta_name]) && intval($permited_meta[$meta_name])==0 ){
                    //meta exists but is set to no
                    continue;
                }


                if(is_array($meta_value)){
                    $meta_value= implode(',', $meta_value);
                }

               
                if ($meta_value != '' && isset($options['mls-fields-label'][$meta_name]) && 
                    $options['mls-fields-label'][$meta_name] != '' && 
                    isset($options['mls-fields'][$meta_name]) && 
                    intval($options['mls-fields'][$meta_name]) == 1  ) {

                
                        $feature_name=$options['mls-fields-label'][$meta_name];
                        if($feature_name==''){
                            $feature_name=$meta_name;
                        }
                
                        if( isset($options['mls-fields-admin'][$meta_name]) && 
                            
                            intval($options['mls-fields-admin'][$meta_name]) == 0 ){
                            $extra_fields[  $feature_name ]=$meta_value;
                            
                        }else if( isset($options['mls-fields-admin'][$meta_name]) && 
                            intval($options['mls-fields-admin'][$meta_name]) == 1 ){                            
                            update_post_meta($property_id, strtolower($feature_name), $meta_value); 
                        }
                
                }
                
                $property_history.= 'Updated EXTRA Meta '.$meta_name.' with label '. $feature_name .' and value '.$meta_value.'</br>';
                $extra_meta_log .= 'Property with ID '.$property_id. '  Update EXTRA Meta '.$meta_name.' with value '.$meta_value.PHP_EOL;  
            endforeach;
            
            
          
            update_post_meta($property_id,'REAL_HOMES_additional_details',$extra_fields);
            update_post_meta($property_id,'REAL_HOMES_additional_details_list',$extra_fields );
            
            $answer['property_history']=$property_history;
            $answer['extra_meta_log']=$extra_meta_log;
        }
        
        return $answer;
        
        
    }
    
    
    
    
    
    /**
    * set hardcode fields after updated
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function correlation_update_after($is_insert,$property_id,$global_extra_fields,$new_agent){
        if($is_insert=='yes'){
            update_post_meta($property_id, 'REAL_HOMES_featured', 0);
            update_post_meta($property_id, 'REAL_HOMES_agent_display_option', 'agent_info');
            
            $options_mls = get_option('mlsimport_admin_mls_sync');
            //update_post_meta($property_id, 'REAL_HOMES_agents', $options_mls['property_agent']);
            update_post_meta($property_id, 'REAL_HOMES_agents', $new_agent);
            
            update_post_meta($property_id,'REAL_HOMES_property_map',0);
            update_post_meta($property_id,'inspiry_property_label_color','#fb641c');
          
                  
            
            $fave_property_size_prefix=get_post_meta( $property_id, 'REAL_HOMES_property_size_postfix', true );
            if($fave_property_size_prefix==''){
                update_post_meta( $property_id, 'REAL_HOMES_property_size_postfix', 'Sq Ft' );
            }
                
            $fave_property_land_postfix=get_post_meta( $property_id, 'REAL_HOMES_property_lot_size_postfix', true );
            if($fave_property_land_postfix==''){
                update_post_meta( $property_id, 'REAL_HOMES_property_lot_size_postfix', 'Sq Ft' );
            }
            
//            $global_extra_fields_new=array();
//            
//            foreach($global_extra_fields as $key=>$value){
//                $temp=array( $key,$value);
//                array_push($global_extra_fields_new,$temp);
//                
//            }
    
//            update_post_meta($property_id,'REAL_HOMES_additional_details',$global_extra_fields);
//            update_post_meta($property_id,'REAL_HOMES_additional_details_list',$global_extra_fields );
          
        }
    }
    
    
    
    
    
    /**
    * save custom fields per environment
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    public function enviroment_custom_fields($option_name){

        $theme_options  =   get_option('wpresidence_admin');
        $custom_fields  =   $theme_options['wpestate_custom_fields_list'];
        $custom_field_no=   100;
      
        $options        =   get_option($option_name.'_admin_fields_select');
             
        $custom_fields_admin    =   array();
        
        
        $test=0;
        foreach($options['mls-fields'] as $key => $value){
            $test++;
         
       
            if($value == 1 && $options['mls-fields-admin'][$key]==0){
                
                if( !in_array( $key, $custom_fields['add_field_name'] ) && $key !='' ) {                    
                    $custom_field_no++;
                    $custom_fields['add_field_name'][]        =   $key;
                    $custom_fields['add_field_label'][]       =   $key;
                    $custom_fields['add_field_type'][]        =   'short text';
                    $custom_fields['add_field_order'][]       =   $custom_field_no;
                    $custom_fields['add_dropdown_order'][]    =   '';
                }

                
            }else{
                if(is_array($custom_fields['add_field_name'])):
                    //remove item from custom fields               
                    $key_remove = array_search ($key, $custom_fields['add_field_name']);
                    
                    unset( $custom_fields['add_field_name'][$key_remove] );       
                    unset( $custom_fields['add_field_label'][$key_remove ]);      
                    unset( $custom_fields['add_field_type'][$key_remove]);
                    unset( $custom_fields['add_field_order'][$key_remove]);
                    unset( $custom_fields['add_dropdown_order'][$key_remove]);
                endif;
            }
       
        }

        
        
        $theme_options['wpestate_custom_fields_list']=$custom_fields;
        update_option('wpresidence_admin',$theme_options);
      
    }
    
    
    
    
    
    
    /**
    * return theme schema
    *
    * @since    1.0.0
    * @access   protected
    * @var      string    $plugin_name   
    */
    
    public function return_theme_schema(){
        return;
    }
    
    
}
