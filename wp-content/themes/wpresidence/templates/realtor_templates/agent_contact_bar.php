<?php
global $propid;
$realtor_details=null;
$whatsup_mess =null;
if(is_singular('estate_agent')){
    $realtor_details    =   wpestate_return_agent_details('',$post->ID);
    if(!isset($realtor_details['realtor_mobile']))$realtor_details['realtor_mobile']='';
   
  
    $whatsup_mess       =   wpestate_return_agent_whatsapp_call(-1,$realtor_details['realtor_mobile']);
    ?>
    <a  class="wpresidence_button send_email_agent"  href="#show_contact" >
        <?php esc_html_e('Send Email', 'wpresidence');?>
    </a>

<?php }else if(is_singular('estate_property')){

     $realtor_details    =   wpestate_return_agent_details($propid);
     if(!isset($realtor_details['realtor_mobile']))$realtor_details['realtor_mobile']='';
     $whatsup_mess       =   wpestate_return_agent_whatsapp_call($propid,$realtor_details['realtor_mobile']);

  
}


?>



<a class="wpresidence_button wpresidence_button_inverse realtor_call" href="tel:<?php echo esc_html($realtor_details['realtor_mobile']);?> ">
    <i class="fas fa-phone"></i>
    <?php esc_html_e('Call','wpresidence');echo ' <span class="agent_call_no">'.esc_html($realtor_details['realtor_mobile']).'</span>';?>
</a>

<a class="wpresidence_button wpresidence_button_inverse realtor_whatsapp" href="<?php echo esc_url($whatsup_mess);?>">
    <i class="fab fa-whatsapp"></i>
    <?php esc_html_e('WhatsApp','wpresidence');?>
</a>
