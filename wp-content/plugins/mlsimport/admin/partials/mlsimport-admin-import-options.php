<form method="post" name="cleanup_options" action="options.php">
<?php
    settings_fields($this->plugin_name.'_admin_import_options');
    do_settings_sections($this->plugin_name.'_admin_import_options');
    $options = get_option($this->plugin_name.'_admin_import_options');
    global $mlsimport;
    $token              =   $mlsimport->get_plugin_data('server_token');
            
    $mlsimport->admin->setting_up();
    $search_url     =   $this->mls_env_data->return_general_search_url();

 
    ?>
    
    
    <fieldset class="mlsimport-fieldset">
        Since Version 3.0 the MLS import plugin supports multiple and parallel imports.
        To start an import:
        <ul>
            <li>1. Add a New Import - see the menu on left or <a href="post-new.php?post_type=mlsimport_item">click here</a> </li>
            <li>2. Set the import parameters</li>
            <li>3. Hit Publish or Save</li>
            <li>4. Click the start import button.</li>
        </ul>

        
    </fieldset>
    
    <?php 
  
    
    
    ?>
    
    

    
   

    
    
    
    
    
    
    
    
    
 
    
    
    

</form>