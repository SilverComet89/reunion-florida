<?php
if (isset($slider_property_id) && intval($slider_property_id) != 0) {
    $propid = $slider_property_id;
}
if( isset($property_page_context) && $property_page_context=='custom_page_temaplate' ){
   
    $propid=$prop_id;
} 


if($context=='theme_slider' || 
    isset($property_page_context) && $property_page_context=='custom_page_temaplate'){
        $agent_id = intval(get_post_meta($propid, 'property_agent', true));

}else{
   
    $agent_id = intval(get_post_meta($post->ID, 'property_agent', true));
}

if (is_singular('estate_agent') || is_singular('estate_agency') || is_singular('estate_developer')) {
    $agent_id = get_the_ID();
}

$contact_form_7_agent = stripslashes(( wpresidence_get_option('wp_estate_contact_form_7_agent', '')));
$contact_form_7_contact = stripslashes(( wpresidence_get_option('wp_estate_contact_form_7_contact', '')));
if (function_exists('icl_translate')) {
    $contact_form_7_agent = icl_translate('wpestate', 'contact_form7_agent', $contact_form_7_agent);
    $contact_form_7_contact = icl_translate('wpestate', 'contact_form7_contact', $contact_form_7_contact);
}

$current_page_template  = basename(get_page_template());



    // display section title 

    if($context!='schedule_section'):
        $title = wpestate_display_contact_form_title( $current_page_template,$contact_form_7_agent);
        print trim($title);
    endif;
    if(isset($prop_id)){
    $propid=$prop_id;
    }

    if ( (  $contact_form_7_agent == '' && $current_page_template  != 'contact_page.php') || 
        ( $contact_form_7_contact == '' && $current_page_template  == 'contact_page.php')) { 
            print' <div class="alert-message" id="alert-agent-contact"></div>';
        if($context!='schedule_section'):
            print wpestate_display_simple_schedule_form();
        endif;

        include( locate_template ( '/templates/listing_templates/contact_form/contact_form_simple.php'));

    }else{

        include( locate_template ( '/templates/listing_templates/contact_form/contact_form_via_contact7.php'));
        
    }
?>