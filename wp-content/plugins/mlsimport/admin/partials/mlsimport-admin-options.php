<form method="post" name="cleanup_options" action="options.php">
<?php
    settings_fields($this->plugin_name.'_admin_options');
    do_settings_sections($this->plugin_name.'_admin_options');
    $options = get_option($this->plugin_name.'_admin_options');
  
    global $mlsimport;
     
   
 
   
    

    $settings_list=array(
      
        'mlsimport_username'=>array(
                            'name'      =>  esc_html__( 'MLSImport Username', $this->plugin_name ),
                            'details'   =>  'to be added', 
                        ),
        'mlsimport_password'=>array(
                            'name'      =>  esc_html__( 'MLSImport Password', $this->plugin_name ),
                            'details'   =>  'to be added', 
                        ),
        
        
        'mlsimport_mls_name'=>array(
                            'type'      =>  'select',
                            'name'      =>  esc_html__( 'Your MLS', $this->plugin_name ),
                            'details'   =>  'to be added', 
                        ),
        
        'mlsimport_mls_token'=>array(
                            'name'      =>  esc_html__( 'Your API Server token -  provided by your MLS', $this->plugin_name ),
                            'details'   =>  'to be added', 
                        ),
        'mlsimport_tresle_client_id'=>array(
                            'name'      =>  esc_html__( 'Your Trestle Client ID - provided by your MLS', $this->plugin_name ),
                            'details'   =>  'to be added', 
                        ),
        
        'mlsimport_tresle_client_secret'=>array(
                            'name'      =>  esc_html__( 'Your Trestle Client Secret - provided by your MLS', $this->plugin_name ),
                            'details'   =>  'to be added', 
                        ),
        
        'mlsimport_rapattoni_client_id' => array(
            'name' => esc_html__('MLSImport Rapattoni Client id', $this->plugin_name),
            'details' => 'to be added',
        ),
        
        'mlsimport_rapattoni_client_secret' => array(
            'name' => esc_html__('MLSImport Rapattoni Client Secret', $this->plugin_name),
            'details' => 'to be added',
        ),
        
        'mlsimport_rapattoni_username' => array(
            'name' => esc_html__('MLSImport Rapattoni Username', $this->plugin_name),
            'details' => 'to be added',
        ),
        
        'mlsimport_rapattoni_password' => array(
            'name' => esc_html__('MLSImport Rapattoni Client Password', $this->plugin_name),
            'details' => 'to be added',
        ),

            
            


        
        
        'mlsimport_theme_used'=>array(
                            'type'      =>  'select',
                            'name'      =>  esc_html__( 'Your Wordpress Theme', $this->plugin_name ),
                            'details'   =>  'to be added', 
                        ),
        
    );
   
    
    
?>
    




<?php 
$token = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();
$is_mls_connected = get_option('mlsimport_connection_test','');
$mlsimport->admin->mlsimport_saas_setting_up();
       


if($is_mls_connected!='yes'){
     $mlsimport->admin->mlsimport_saas_check_mls_connection(); 
     $is_mls_connected = get_option('mlsimport_connection_test','');

}






if(trim($token)==''){
    mlsimport_show_signup();
    print '<div class="mlsimport_warning">'. esc_html__('You are not connected to MlsImport - Please check your Username and Password.','mlsimport').'</div>';
}else{
    print '<div class="mlsimport_warning mlsimport_validated">'. esc_html__('You are connected to your MlsImport account!','mlsimport').'</div>';
    
}


if($is_mls_connected=='yes'){
    print '<div class="mlsimport_warning mlsimport_validated">'. esc_html__('The connection to your MLS was successful','mlsimport').'</div>'; 
}else{
    print '<div class="mlsimport_warning">'. esc_html__('The connection to your MLS was NOT succesful. Please check the authentication token is correct and check your MLS Data Access Application is approved. ','mlsimport').'</div>';   
}



foreach($settings_list as $key=>$setting ){
        $value = ( isset( $options[$key] ) && ! empty( $options[$key] ) ) ? esc_attr( $options[$key] ) : '';
        ?>
        <fieldset class="mlsimport-fieldset <?php echo 'fieldset_'.esc_attr($key); ?>">
            <label class="mlsimport-label" for="<?php echo $this->plugin_name.'_admin_options'; ?>-<?php echo $key; ?>" >
              <?php echo esc_html($setting['name']); ?>
            </label>
            
            
            <?php 
            if( $key =='mlsimport_mls_name' && isset($setting['type']) and $setting['type']=='select' ){ 
               
                $mls_import_list = mls_import_saas_request_list();
               // print_r($mls_import_list);
                
              
                print '<div class="mls_explanations">';
                
                print 'If your MLS is not on this list yet please <a href="https://mlsimport.com" target="_blank">contact us</a> in order to check it and enable it';
                
                print '</div>';
               //print mlsiport_mls_select_list($key,$value,$mls_import_list);
                
                print '<input type="text" id="mlsimport_mls_name_front"   name="mlsimport_admin_options[mlsimport_mls_name_front]" placeholder="search your MLS" value="';
                if( ! empty( $options['mlsimport_mls_name_front'] ) ){ 
                    echo $options['mlsimport_mls_name_front']; 
                }else { 
                    echo '';
                }
                print '">';
                
                
                print '<input type="hidden" id="mlsimport_mls_name" name="mlsimport_admin_options[mlsimport_mls_name]"  value="';
                if( ! empty( $value ) ){ 
                    echo $value; 
                }else { 
                    echo '';
                }
                print '">';
                
                print '<script type="text/javascript">
                //<![CDATA[
                    jQuery(document).ready(function(){
                        var autofill='.$mls_import_list.'
                        jQuery( "#mlsimport_mls_name_front" ).autocomplete({
                            source: autofill,
                            minLength: 3,
                            change( event, ui ){
                                console.log(ui);
                                jQuery("#mlsimport_mls_name_front").val(ui.item.label);
                                jQuery("#mlsimport_mls_name").val(ui.item.value);
                                mlsimport_token_on_load();
                            },
                            focus: function(event, ui) {
                                jQuery("#mlsimport_mls_name_front").val(ui.item.label);
                                jQuery("#mlsimport_mls_name").val(ui.item.value);  mlsimport_token_on_load();
                                return false;
                            },
                            select: function(event, ui) {
                                jQuery("#mlsimport_mls_name_front").val(ui.item.label);
                                jQuery("#mlsimport_mls_name").val(ui.item.value);  mlsimport_token_on_load();
                                return false;
                            },
                            response: function(event, ui) {
                                if (!ui.content.length) {
                                    var noResult = { value:"",label:"No results found" };
                                    ui.content.push(noResult);
                                    //$("#message").text("No results found");
                                } else {
            //                        $("#message").empty();
                                }
                            }
                        });
                });
                //]]>
                </script>';
                
            }else  if($key =='mlsimport_theme_used' &&  isset($setting['type']) and $setting['type']=='select' ){ 
               print mlsiport_mls_select_list($key,$value,MLSIMPORT_THEME);
            }else{
            ?>
            
            <input <?php 
                    if($key=='mlsimport_password'){
                        print ' type="password" ';
                    }else{
                        print ' type="text" ';
                    }
                    ?> 
                   class="mlsimport-input" autocomplete="off" id="<?php echo $this->plugin_name.'_admin_options'; ?>-<?php echo $key; ?>" name="<?php echo $this->plugin_name.'_admin_options'; ?>[<?php echo $key; ?>]" 
                   value="<?php if( ! empty( $value ) ) echo $value; else echo ''; ?>"/>
            <?php } ?>
        </fieldset>
<?php } ?>
    
 
<input type="hidden" name="<?php echo $this->plugin_name.'_admin_options'; ?>[force_rand]" value="<?php echo rand();?>">
    
<?php 
$attributes = array( 'data-style' => 'mlsimport_but' );
submit_button( __( 'Save Changes', $this->plugin_name ), 'mlsimport_button','submit', TRUE ,$attributes); 
?>
</form>



<?php









/*
 * 
 * create dropdown list 
 *  
 * 
 */
function mlsiport_mls_select_list($key,$value,$data_array){
    $select='<select id="'.esc_attr($key).'" name="mlsimport_admin_options['.$key.']">';
    if(is_array($data_array)):
        foreach($data_array as $key=>$mls_item){
            $select.=   '<option value="'.$key.'"'; 
                if(intval($value) === intval($key) ){
                    $select.=' selected ';
                }
            $select.=   '>'.$mls_item.'</option>';
        }
    endif;
    $select.='</select>';
    return $select;
}







/*
 * 
 * Request list of ready to go MLS 
 * 
 *  
 */
function mls_import_saas_request_list(){
         
    
    $mls_data=get_transient('ready_to_go_mlsimport_data');
   
    if($mls_data==false){
        $theme_Start=   new ThemeImport();
        $values     =   array();

        $answer     =   $theme_Start::global_api_request_saas('mls', $values, "GET");


        if( isset($answer['succes']) && $answer['succes']==true){
            $mls_data = $answer['mls_list'];            
            $mls_data['0']=esc_html__('My MLS is not on this list','mlsimport');

            $autofill_array   =   array();
            foreach($mls_data as $key=>$value){
                  $temp_array =   array('label'=>$value,'value'=>$key);
                  $autofill_array[] =   $temp_array;


            }


            $mls_data=json_encode($autofill_array);

            set_transient('ready_to_go_mlsimport_data',$mls_data,60*60*24);
            
        }else{
            $mls_data   =   array();
            $mls_data['0']=esc_html__('We could not connect to MLSimport Api','mlsimport');
        }
    }
    
    return $mls_data;
}


//MLSIMPORT_THEME

?>