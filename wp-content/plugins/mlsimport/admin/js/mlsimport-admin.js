jQuery(document).ready(function ($) {
	'use strict';

        var log_refresh_interval;
        var log_refresh_interval_per_item;
        var timer=2000;
        var timer_per_item=4000;
        
        if(jQuery('#nav-tab-import').hasClass('nav-tab-active')){
            log_refresh_interval = setInterval(mlsimport_log_interval, timer);
        }
        
         if(jQuery('#mlsimport-start_item').length > 0){
            log_refresh_interval_per_item = setInterval(mlsimport_log_interval_per_item, timer_per_item);
        }
        
              
        /**
        * Show / hide input tokens on load
        * 
        */
        mlsimport_token_on_load();
        
        
              
        /**
        * Show / hide input tokens on change
        * 
        */
       
       
        jQuery('#mlsimport_mls_name').on('change',function(event){
          
            var selected_value =  jQuery('#mlsimport_mls_name').val();
            selected_value = parseInt(selected_value);

            console.log("selected value "+selected_value);
          

            if( selected_value > 5000){
                console.log('rapttoni')
                jQuery('.fieldset_mlsimport_mls_token').hide();
                jQuery('.fieldset_mlsimport_tresle_client_id,.fieldset_mlsimport_tresle_client_secret').hide();
                jQuery('.mlsimport_rapattoni_client_id,.mlsimport_rapattoni_client_secret,.mlsimport_rapattoni_username,.mlsimport_rapattoni_password ').show();
  

            }else if( selected_value > 900 && selected_value<3000){
                console.log('in trestle '); 
                jQuery('.fieldset_mlsimport_mls_token').hide();
                jQuery('.mlsimport_rapattoni_client_id,.mlsimport_rapattoni_client_secret,.mlsimport_rapattoni_username,.mlsimport_rapattoni_password ').hide();
  

                jQuery('.fieldset_mlsimport_tresle_client_id').show();
                jQuery('.fieldset_mlsimport_tresle_client_secret').show();               
            }else{
                console.log('smalller');
                jQuery('.fieldset_mlsimport_mls_token').show();
                jQuery('.mlsimport_rapattoni_client_id,.mlsimport_rapattoni_client_secret,.mlsimport_rapattoni_username,.mlsimport_rapattoni_password ').hide();
                jQuery('.fieldset_mlsimport_tresle_client_id').hide();
                jQuery('.fieldset_mlsimport_tresle_client_secret').hide();              
            }
           
        });
       
          
          
          
        /**
        * Stop Import per item
        * 
        */
        
        jQuery('#mlsimport_stop_item').on('click',function() {
            console.log('mlsimport-stop');
            var post_id     =   jQuery(this).attr('data-post_id');
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'            :   'mlsimport_stop_import_per_item',
                    'post_id'           :   post_id,
                 
                },
                success: function (data) {  
                    console.log(data);
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });//end ajax     
        });
        
          
          
          
          
        /**
        * Start Import per item
        * 
        */
        
        jQuery('#mlsimport-start_item').on('click',function() {
            console.log('mlsimport-start');
            var ajaxurl     =   mlsimport_vars.ajax_url;
            var post_id     =   jQuery(this).attr('data-post_id');
            var post_number =   jQuery(this).attr('data-post-number');
            var how_many    =   jQuery('#mlsimport_item_how_many').val();
              
              
            jQuery('#mlsimport_item_status').empty();  
            jQuery('#mlsimport_item_status').append("Starting the import. Please stand by!");

            clearInterval(log_refresh_interval_per_item);
            log_refresh_interval_per_item = setInterval(mlsimport_log_interval_per_item, timer_per_item);
                      
                      
            console.log('mlsimport_move_files_per_item');
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'            :   'mlsimport_move_files_per_item',
                    'post_id'           :   post_id,
                    'how_many'          :   how_many,
                    'post_number'       :   post_number
                },
                success: function (data) {  
                    console.log(data);


                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });//end ajax     

        });
    
        /**
        * delete cache
        * 
        */
       
        jQuery('#mlsimport-clear-cache').on('click',function(){
            var ajaxurl     =   mlsimport_vars.ajax_url;

            jQuery('#mlsimport-clear-cache').val('Deleting...');
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'            :   'mlsimport_delete_cache'
                },
                success: function (data) {  
                  console.log(data);
                 jQuery('#mlsimport-clear-cache').val('Deleted!');

                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });//end ajax     
        });  
        
        
        
        /**
        * delete properties
        * 
        */
       
        jQuery('#mlsimport-delete-prop').on('click',function(){
            var ajaxurl     =   mlsimport_vars.ajax_url;

            var mlsimport_delete_category =jQuery('#mlsimport_delete_category').val();
            var mlsimport_delete_category_term =jQuery('#mlsimport_delete_category_term').val();
            var mlsimport_delete_timeout =jQuery('#mlsimport_delete_timeout').val();
            
             console.log('start the delete');
            
            if(mlsimport_delete_category===''){
                jQuery('#mlsimport-delete-notification').text('Please add the category ');
                return;
            }
            if(mlsimport_delete_category_term==='' ){
                jQuery('#mlsimport-delete-notification').text('Please add the category term ');
                return;
            }
            
            
            jQuery('#mlsimport-delete-notification').text('Deleting...If you have many properties this may take a while');
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType:'json',
                data: {
                    'action'                            :   'mlsimport_delete_properties',
                    'mlsimport_delete_category'         :    mlsimport_delete_category,
                    'mlsimport_delete_category_term'    :   mlsimport_delete_category_term,
                    'mlsimport_delete_timeout'          :   mlsimport_delete_timeout
                },
                success: function (data) {  
                    console.log(data);
                    jQuery('#mlsimport-delete-notification').text(data.message);

                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });//end ajax     
        });  
        
        
 
        /**
        * Stop import
        * 
        */
       
        jQuery('#mlsimport_stop').on('click',function(){
            var ajaxurl     =   mlsimport_vars.ajax_url;


            console.log('stop files');
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'            :   'mlsimport_stop_moving_files',
                },
                success: function (data) {  
                  console.log(data);
                 jQuery('#aws-move-start').show();
                  clearInterval(log_refresh_interval);

                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });//end ajax     
        });  
        
        /**
        * Start Import
        * 
        */
        
        jQuery('#mlsimport-start').on('click',function() {
            console.log('mlsimport-start');
              var ajaxurl     =   mlsimport_vars.ajax_url;
              aws_show_progress();
              
              jQuery.ajax({
                  type: 'POST',
                  url: ajaxurl,
                  data: {
                      'action'            :   'mlsimport_move_files'
                  },
                  success: function (data) {  
                      console.log(data);
                      console.log('starting loggers');
                      clearInterval(log_refresh_interval);
                      log_refresh_interval = setInterval(mlsimport_log_interval, timer);

                  },
                  error: function (errorThrown) {
                      console.log(errorThrown);
                  }
              });//end ajax     

        });
    
    
    
    
    
    
    
        /**
        * Log import
        * 
        */
    
        function mlsimport_log_interval() {


            var progress_total  = jQuery('#mlsimport_monster_myProgress').attr('data-total');
            progress_total      = parseInt(progress_total);
            var remain_images   = progress_total;
            var done_images     =  0;
            var bar_width       =  0;
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    'action'            :   'mlsimport_move_files_to_aws_logger',
                },
                success: function (data) {  
                    console.log(data);
                   if(data.is_done==='done' && data.logs==='' ){
                        jQuery('#log_container').prepend('COMPLETED');
                        jQuery('#log_container').append('COMPLETED');
                        clearInterval(log_refresh_interval);
                    }else if(data.logs!==''){                      
                       

                        jQuery('#log_container').empty().prepend(data.logs);
                        jQuery('#aws_more_files').empty().text(data.current_files_no);

                        remain_images=parseInt(data.current_files_no);
                        done_images=progress_total-remain_images;

                        bar_width = done_images*100/progress_total;
                        bar_width = parseFloat(bar_width);

                       jQuery('#mlsimport_myBar').css('width',bar_width+'%');

                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });//end ajax     
        }



        /**
        * Log import per item
        * 
        */

        function mlsimport_log_interval_per_item(){
              console.log('mlsimport_log_interval_per_item');
              var item_id=jQuery('#mlsimport-start_item').attr('data-post_id');
              jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    'action'            :   'mlsimport_logger_per_item',
                    'post_id'           :   item_id,
                },
                success: function (data) {  
                    console.log(data);
                   if(data.is_done==='done' || data.logs==='' ){
                       console.log('kill interval');
                       
                        clearInterval(log_refresh_interval_per_item);
                         jQuery('#mlsimport_item_status').append("Import stopped or completed!");
                    }else if(data.logs!==''){                      
                        jQuery('#mlsimport_item_status').empty().append(data.logs);

                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });//end ajax     
        }

        /**
        * SHow progress bar - 
        * 
        */

        function aws_show_progress(){
        
            jQuery('#log_container').empty();

            var files_to_move=jQuery('#aws_move').text();
            files_to_move=parseInt(files_to_move);

            console.log('files_to_move '+files_to_move);

            if( isNaN( parseFloat( files_to_move ))  ){
                files_to_move=jQuery('#aws_more_files').text();
            }
             console.log('files_to_move2 '+files_to_move);
            files_to_move=parseInt(files_to_move);

            jQuery('#mlsimport_myProgress_wrapper').show();
            jQuery('.aws_to_move').empty().html('<strong>We start importing. Please wait.</strong>');
            jQuery('#aws-move-start').hide();
        } 




  
             
        /**
        * Check / unchechek fields
        * 
        */

	jQuery('.mls_import_selec_all_class').on('click',function(){
            var trigger_type=jQuery(this).attr('data-import');
            console.log('trigger type '+trigger_type);
            
            if(trigger_type==='import_select'){
                console.log('fac asll');
                jQuery('.mlsimport_select_import_all').prop('checked', true);
            }else if(trigger_type==='import_select_none'){
                console.log('fac uncheck ');
                jQuery('.mlsimport_select_import_all').prop('checked', false);
            }else if(trigger_type==='import_admin'){
                jQuery('.mlsimport_select_import_admin_all').prop('checked', true);
            }else if(trigger_type==='import_admin_none'){
                jQuery('.mlsimport_select_import_admin_all').prop('checked', false);
            }
        });

});






function mlsimport_saas_get_metadata(){
             
    console.log('mlsimport_saas_get_metadata');
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'mlsimport_saas_get_metadata_function'                  
        },
        success: function (data) {  
            console.log(data);
            jQuery('.mlsimport_populate_warning').remove();
            location.reload(true);
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });//end ajax     
      
}


function mlsimport_token_on_load(){
    var selected_value =  jQuery('#mlsimport_mls_name').val();
    selected_value = parseInt(selected_value);

    console.log("selected value "+selected_value);

    if(selected_value>5000){
        console.log('rapattoni');
        jQuery('.fieldset_mlsimport_rapattoni_client_id,.fieldset_mlsimport_rapattoni_client_secret,.fieldset_mlsimport_rapattoni_username,.fieldset_mlsimport_rapattoni_password ').show();
        jQuery('.fieldset_mlsimport_mls_token').hide();
        jQuery('.fieldset_mlsimport_tresle_client_id').hide();
        jQuery('.fieldset_mlsimport_tresle_client_secret').hide(); 
    }else if( selected_value > 900 && selected_value<3000){
        console.log('bigger tresetle');
        jQuery('.fieldset_mlsimport_mls_token').hide();
        jQuery('.fieldset_mlsimport_tresle_client_id').show();
        jQuery('.fieldset_mlsimport_tresle_client_secret').show();             
        jQuery('.fieldset_mlsimport_rapattoni_client_id,.fieldset_mlsimport_rapattoni_client_secret,.fieldset_mlsimport_rapattoni_username,.fieldset_mlsimport_rapattoni_password ').hide();
                
    }else{
        console.log('smalller');
        jQuery('.fieldset_mlsimport_mls_token').show();
        jQuery('.fieldset_mlsimport_tresle_client_id').hide();
        jQuery('.fieldset_mlsimport_tresle_client_secret').hide();            
        jQuery('.fieldset_mlsimport_rapattoni_client_id,.fieldset_mlsimport_rapattoni_client_secret,.fieldset_mlsimport_rapattoni_username,.fieldset_mlsimport_rapattoni_password ').hide();
        console.log('hide');
    }
}