
<?php 
$options = get_option($this->plugin_name.'_admin_options');
$mlsimport_mls_metadata_populated =  get_option('mlsimport_mls_metadata_populated','');





if ($mlsimport_mls_metadata_populated=='yes') { ?>

<form method="post" name="cleanup_options" action="options.php">
    <?php
        settings_fields($this->plugin_name.'_admin_fields_select');
        do_settings_sections($this->plugin_name.'_admin_fields_select');
        $options                               =    get_option($this->plugin_name.'_admin_fields_select'); 
        
        $mlsimport_mls_metadata_theme_schema   =    get_option('mlsimport_mls_metadata_theme_schema','');
        $mlsimport_mls_metadata_mls_data       =    get_option('mlsimport_mls_metadata_mls_data','' );
        $mlsimport_mls_metadata_mls_data       =    json_decode($mlsimport_mls_metadata_mls_data,true);
        
        $theme_schema                               =   $mlsimport_mls_metadata_theme_schema;
        $metadata_api_call_data_service_property    =   $mlsimport_mls_metadata_mls_data;
     
            
        global $mlsimport;
        $mlsimport->admin->mlsimport_saas_setting_up();
        $mandatory_fields       =   '';
        $non_mandatory_fields   =   '';
        

        
        foreach($metadata_api_call_data_service_property as $key=>$value){
          
            $description    =   'no description ';
            $mandatory      =   0;
            
            $is_checkbox        =   0;
            $is_checkbox_admin  =   0;
                    
            if ( isset( $options['mls-fields'][$key] ) &&  $options['mls-fields'][$key]==1  ) {
               $is_checkbox =1;
            }else if ( !isset( $options['mls-fields'][$key]) ) {
                  $is_checkbox =1;
            }
            
            if ( isset( $options['mls-fields-admin'][$key] ) &&  $options['mls-fields-admin'][$key]==1  ) {
                $is_checkbox_admin =1;
            }
            
            
            if( array_key_exists($key,$theme_schema) ){
                $mandatory_fields      .=  '<strong>'.$key.'</strong><div class="mls_mandatory_fields">'.stripslashes($value).'</div>' ;
            }else{
            
            $label_value=''; 
            if(isset($options['mls-fields-label'][$key])){       
                $label_value=$options['mls-fields-label'][$key];
            }
            if($label_value==''){
                $label_value=$key;
            }
                
              $non_mandatory_fields.='
                <fieldset class="mlsimport-fieldset">
                    <label for="'. $this->plugin_name.'-example_checkbox">
                        <h4 class="mlsfield_import_title">'.$key.' </h4>'.
           
                        '<div class="mandatory_fields_wrapper_exp"><strong>'.esc_html('Explanation','mlsimport').':</strong> '.stripslashes($value).'</div>   '.
                      
                        '<strong>'.esc_html('Label','mlsimport').':</strong> <input type="text" class="mlsimport-fieldset mlsfield_label" name="'.$this->plugin_name.'_admin_fields_select[mls-fields-label]['.$key.']"  value="'.$label_value.'">'.
                        '<strong>Import?</strong><input type="hidden" id="'.$this->plugin_name.'_admin_fields_select-mls_field_'.$key.'" name="'.$this->plugin_name.'_admin_fields_select[mls-fields]['.$key.']" value="0"/>
                        <input type="checkbox"  class="mlsimport_select_import_all" id="'.$this->plugin_name.'_admin_fields_select-mls_field_'.$key.'" name="'.$this->plugin_name.'_admin_fields_select[mls-fields]['.$key.']" value="1"'.checked( $is_checkbox, 1,0 ).'/>
                            
                        <strong>Visible only in admin ?</strong><input type="hidden" id="'.$this->plugin_name.'_admin_fields_select-visible-mls_field_'.$key.'" name="'.$this->plugin_name.'_admin_fields_select[mls-fields-admin]['.$key.']" value="0"/>
                        <input type="checkbox" class="mlsimport_select_import_admin_all" id="'.$this->plugin_name.'_admin_fields_select-visible-mls_field_'.$key.'" name="'.$this->plugin_name.'_admin_fields_select[mls-fields-admin]['.$key.']" value="1"'.checked( $is_checkbox_admin, 1,0 ).'/>                        
                    </label>
                </fieldset>';
            }
            
        }
        
        print '<div class="mandatory_fields_wrapper"><h3>'.esc_html__('These fields will be imported (if found) by default:',$this->plugin_name).'</h3> '.$mandatory_fields.'</h4';
        
        print '<div class="mandatory_fields_wrapper"><h3>'.esc_html__('Select the extra fields you want to import',$this->plugin_name).':</h3>';
        print '<div id="mls_import_select_all"        class="mls_import_selec_all_class"  data-import="import_select">'.esc_html('Import - Select All',$this->plugin_name).'</div>';
        print '<div id="mls_import_select_none"       class="mls_import_selec_all_class"  data-import="import_select_none">'.esc_html('Import - Select None',$this->plugin_name).'</div>';
        print '<div id="mls_import_admin_select_all"  class="mls_import_selec_all_class"  data-import="import_admin" >'.esc_html('Admin Only - Select All',$this->plugin_name).'</div>';
        print '<div id="mls_import_admin_select_none" class="mls_import_selec_all_class"  data-import="import_admin_none" >'.esc_html('Admin Only - Select None',$this->plugin_name).'</div>';
        print $non_mandatory_fields;
        print '</div>';
        
        
        ?>
    <input type="hidden" name="<?php echo $this->plugin_name.'_admin_fields_select[mls-fields-admin][force_rand]'; ?>" value="<?php echo rand();?>">
 
    <?php submit_button( __( 'Save Changes', $this->plugin_name ), 'mlsimport_button','submit', TRUE ); ?>
</form>
        
<?php
}else{
    global $mlsimport;
    $token = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();
    if(trim($token)!==''){
?>

<div class="mlsimport_populate_warning">
    <?php esc_html_e('We need to gather some information about your MLS. Please Stand By! ','mlsimport');?>
    <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready(function(){
            mlsimport_saas_get_metadata();
        });
        //]]>
    </script>
</div>

<?php    
    }else{
        esc_html_e('Your are not connected to MLS Import','mlsimport');
    }
}
?>        