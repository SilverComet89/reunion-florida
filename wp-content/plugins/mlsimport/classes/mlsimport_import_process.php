<?php

class MlsImport_import_process extends WP_Background_Process {
   
    protected $action = 'example_process';
    protected $counter=0;
    

    protected function task( $link ) {
            global $mlsimport;
            $token              =   $mlsimport->get_plugin_data('server_token');
            
            
            $options_import = get_option('mlsimport_admin_import_options');
            $imported       = intval( get_option('mlsimport_already_imported') );
            
            if($imported >= intval($options_import['import_number']) && intval($options_import['import_number'])!=0 ){
                $mlsimport->admin->mlsimport_stop_moving_files();
                $mlsimport->admin->mls_write_import_custom_logs('</br>'.PHP_EOL.'---- STOPPED ON TASK ');
                return;
            }
            
            $message        =   PHP_EOL."</br>Parsing link ".$link."</br>".PHP_EOL;
            $mlsimport->admin->mls_write_import_custom_logs($message);
       
         
            $imported_counter       =   intval( get_option('mlsimport_already_imported') );
            $api_call_array         =   $mlsimport->admin->theme_importer->mlswpestatex_reso_call($link,$token);
            $message.='</br>'.$mlsimport->admin->theme_importer->parse_search_array($api_call_array, intval($options_import['import_number']) , $imported_counter );
            
            
            $current_files_no = get_option('mlsimport_file_no');
            update_option ('mlsimport_file_no',$current_files_no-1);
            update_option ('mlsimport_transfer_logs_clear_interval','started');
          
            return false;
    }

    
    
    
    
    protected function complete() {
            update_option ('mlsimport_transfer_logs_clear_interval','stop');
            global $mlsimport;
            $current_log = '------------------------- COMPLETED ON '. date('l jS F Y h:i:s A').' -------------------------</br>';
            $mlsimport->admin->mls_write_import_custom_logs($current_log);
            parent::complete();
       
    }
}
