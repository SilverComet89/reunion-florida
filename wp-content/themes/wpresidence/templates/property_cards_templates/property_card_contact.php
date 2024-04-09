<?php 
$realtor_details                    =   wpestate_return_agent_details($post->ID); 
$whatsup_mess                       =   wpestate_return_agent_whatsapp_call($post->ID,$realtor_details['realtor_mobile']);
$wp_estate_call_show_modal_unit7    =   esc_html ( wpresidence_get_option('wp_estate_call_show_modal_unit7','') );

?>
<div class="wpestate_property_card_contact_wrapper">
    <?php 
    if($wp_estate_call_show_modal_unit7=='yes'){
        print '<div class="wpestate_property_card_contact_wrapper_phone" data-item-id="'. intval($post->ID).'">';  
    }else{
        print '<a class="wpestate_property_card_contact_wrapper_phone" target="_blank" href="tel:'.esc_html($realtor_details['realtor_phone']).'">';  
    }  
        include(locate_template('css/css-images/icons/contact-call-7.svg'));
        esc_html_e('Call','wpresidence'); 
    
    if($wp_estate_call_show_modal_unit7=='yes'){
        print '</div>';
    }else{
        print '</a>';
    }
    ?>




    <div class="wpestate_property_card_contact_wrapper_email" data-item-id="<?php echo intval($post->ID);?>" >
    <i class="far fa-envelope"></i> <?php esc_html_e('Email','wpresidence'); ?>
     
    </div>

    <div class="wpestate_property_card_contact_wrapper_whatsupp">
        <a href="<?php echo esc_url($whatsup_mess);?>"> <i class="fab fa-whatsapp"></i></a>
    </div>
</div>


<div class="modal wpestate_card_unit_call wpestate_card_unit_call_<?php echo intval($post->ID);?>" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!--
                    <h5 class="modal-title"><?php esc_html_e('Call us','wpresidence'); ?></h5>
                    -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">     
                        <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg"><path d="M11.778 11.778L4 4l7.778 7.778L4 19.556l7.778-7.778zm0 0l7.778 7.778-7.778-7.778L19.556 4l-7.778 7.778z" stroke="#FFF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo  wpestate_card7_call_content($post->ID,$realtor_details ) ;?></p>
                </div>       
            </div>
        </div>
</div>
  
<div class="modal wpestate_card_unit_email wpestate_card_unit_email_<?php echo intval($post->ID);?> " tabindex="-1"  role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!--
                    <h5 class="modal-title"><?php esc_html_e('Email Agent','wpresidence'); ?></h5>
                    -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                    <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg"><path d="M11.778 11.778L4 4l7.778 7.778L4 19.556l7.778-7.778zm0 0l7.778 7.778-7.778-7.778L19.556 4l-7.778 7.778z" stroke="#FFF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                   
                    </span>
                    </button>
                </div>
                <div class="modal-body">
                   <?php 
                   
               
                   $agent_wid = $realtor_details['agent_id'];
                    if (get_the_author_meta('user_level', $agent_wid) != 10) {
                        include( locate_template('templates/agent_unit_widget_sidebar.php') );
                        $context='sidebar_page';
                        include( locate_template ( '/templates/listing_templates/contact_form/property_page_contact_form.php'));
                    }
                    if ( intval($realtor_details['one_id'])==1 and intval($realtor_details['agent_id'])==0){
                        esc_html_e('Looks like the property is assigned to an administrator. Please assign it to an agent or user with complete contact details.','wpresidence'); 
                    }


                   ?>
                </div>       
            </div>
        </div>
</div>

