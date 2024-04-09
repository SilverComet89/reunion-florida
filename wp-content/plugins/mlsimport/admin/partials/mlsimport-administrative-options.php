<form method="post" name="cleanup_options" action="">
<?php
global $mlsimport;
settings_fields($this->plugin_name.'_administrative_options');
do_settings_sections($this->plugin_name.'_administrative_options');
$options            =   get_option($this->plugin_name.'_administrative_options');


$mlsimport->admin->mlsimport_saas_setting_up();


//mlsimport_saas_event_mls_import_auto_function();
//mlsimport_saas_reconciliation_event_function();


print '<h1> Administrative Tools</h1>';



if( isset($_POST['mlsimport-disable-logs']) ){
    $disable_logs=intval($_POST['mlsimport-disable-logs']);
    update_option('mlsimport_disable_logs', $disable_logs );    
}
if( isset($_POST['mlsimport-disable-history']) ){
    $disable_history=intval($_POST['mlsimport-disable-history']);
    update_option('mlsimport-disable-history', $disable_history );    
}

$disable_logs= intval(get_option('mlsimport_disable_logs'));
$selected_no=$selected_yes="";

if($disable_logs===0){
    $selected_no=" selected ";
}else{
    $selected_yes=" selected ";
}


$disable_history= intval( get_option('mlsimport-disable-history',1) );
$selected_history_no=$selected_history_yes="";

if($disable_history===0){
    $selected_history_no=" selected ";
}else{
    $selected_history_yes=" selected ";
}



?>      

<div class="mlsimport_tool_field_item_wrapper">    
    <h4 style="margin-bottom:0px;"> Disable System Logs (logs should only be enabled during debug process) </h4>  
    <select name="mlsimport-disable-logs" id="mlsimport-disable-logs"> 
        <option value="0" <?php echo esc_html($selected_no); ?> >logs disabled</option>
        <option value="1" <?php echo esc_html($selected_yes); ?>>logs enabled</option>

</select>
</div>


<div class="mlsimport_tool_field_item_wrapper">    
    <h4 style="margin-bottom:0px;"> Disable Property History (can be seen by editing a property in Wordpress admin) </h4>  
    <select name="mlsimport-disable-history" id="mlsimport-disable-history"> 
    
        <option value="1" <?php echo esc_html($selected_history_yes); ?>>history enabled</option>
        <option value="0" <?php echo esc_html($selected_history_no); ?> >history disabled</option>

</select>
</div>


        
<?php submit_button( __( 'Save Changes', $this->plugin_name ), 'mlsimport_button','submit', TRUE ); ?>

<div class="mlsimport_tool_field_item_wrapper"  style="background-color: #eee;padding: 10px;border-radius: 5px;">    
    <h3 style="margin-bottom:0px;"> Clear cached data </h3>
    <input class="mlsimport_button"  type="button" id="mlsimport-clear-cache" value="Clear Plugin Cached Data" />
</div>
    
    
<div class="mlsimport_tool_field_item_wrapper">     
    <h3 style="margin-bottom:0px;">Cron Jobs </h3>
    <div class="cron_job_explainin">
        By default a syncronization event runs every hour. The action will be triggered when someone visits your site if the scheduled time has passed. This is the default, "out of the box" way to do things in Wordpress and it works very well in 99% of the cases.

        </br></br>If, for some reason, you want to force the syncronization event to run every two hours(minimum time frame permitted by this plugin) you can set a cron job on your server enviroment and call this url : http://yourwebsite.com/?mlsimport_cron=yes.
        </br></br><strong>Example : 0	*/2	*	*	*	wget https://yourwebsite.com/?mlsimport_cron=yes</strong> .   
    </div>
<div>
    
<fieldset class="mlsimport-fieldset" style="background-color: #eee;padding: 10px;border-radius: 5px;">
       
    <h3>Delete Properties</h3>
            
    <div id="mlsimport-delete-notification" >Please fill all the forms </div>
    
    
    <label class="mlsimport-label" for="<?php echo $this->plugin_name.'_administrative_options'; ?>-import" >
       <?php echo esc_html__('Delete from Category',$this->plugin_name); ?>
    </label></br>
    <input type="text" lass="mlsimport-input" id="mlsimport_delete_category"></br>
    </br>
    <label class="mlsimport-label" for="<?php echo $this->plugin_name.'_administrative_options'; ?>-import" >
       <?php echo esc_html__('Delete the term from category(use term slug)',$this->plugin_name); ?>
    </label></br>
    <input type="text" lass="mlsimport-input" id="mlsimport_delete_category_term"></br>
    </br>
    <label class="mlsimport-label" for="<?php echo $this->plugin_name.'_administrative_options'; ?>-import" >
        Pause the script between property delete processes (1=1 sec . For slow hosting use a number between 1 and 5) 
    </label>
    
    <input type="text" lass="mlsimport-input" id="mlsimport_delete_timeout" value="0">

    </br>
    <input class="button mlsimport_button"  type="button" id="mlsimport-delete-prop" value="Delete" />
</fieldset>

</form>