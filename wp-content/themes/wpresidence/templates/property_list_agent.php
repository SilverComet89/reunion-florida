<?php
global $agent_email;
global $propid;
global $agent_wid;


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(class_exists( 'Elementor\Plugin')){
    if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        $prop_id = $post->ID;
    } else {
        $prop_id = $property_id;
    }
} else {
    $prop_id = $post->ID;
}

if (get_page_template_slug() == 'page_property_design.php') {
    $prop_id = $property_id;
}

$realtor_details                 =  wpestate_return_agent_details($prop_id);
$contact_details_tabs            =  'yes';
$contact_sidebar                 =  '';
$contact_schedule                =  '';
$wp_estate_sidebar_contact_group =  wpresidence_get_option('wp_estate_sidebar_contact_group','');
$use_schedule_tour               =  wpresidence_get_option('wp_estate_show_schedule_tour', '');

?>






 
<?php
wp_reset_query();

$agent_wid = $realtor_details['agent_id'];

if (get_the_author_meta('user_level', $agent_wid) != 10) {
    ob_start();
    ?>
    <div class="agent_contanct_form_sidebar widget-container">
        <?php
        include( locate_template('templates/agent_unit_widget_sidebar.php') );
        $context='sidebar_page';
        include( locate_template ( '/templates/listing_templates/contact_form/property_page_contact_form.php'));
        ?>
    </div>
    <?php 
    $contact_sidebar=ob_get_contents();
    ob_end_clean();
}

// SCHEDULE TOUR

ob_start();
$schedule_on_sidebar='yes';
include( locate_template ('/templates/listing_templates/property_page_schedule_tour.php') );
$contact_schedule=ob_get_contents();
ob_end_clean();





if ($wp_estate_sidebar_contact_group=='yes' && $use_schedule_tour=='yes' && trim($contact_sidebar)!=''){
?>


    <div role="tabpanel" id="wpestate_sidebar_property_contact_tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#sidebar_contact" aria-controls="sidebar_contact" role="tab" data-toggle="tab"><?php esc_html_e('Request Info','wpresidence');?></a>
            </li>
            <li role="presentation" class="">
                <a href="#sidebar_schedule" aria-controls="sidebar_schedule" role="tab" data-toggle="tab"><?php esc_html_e('Schedule a tour','wpresidence');?></a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="sidebar_contact">
                <?php   print trim($contact_sidebar); ?>
            </div>

            <div role="tabpanel" class="tab-pane " id="sidebar_schedule">
                <?php   print trim($contact_schedule); ?>
            </div>
        </div>

    </div>

    


<?php
}else{

    print trim($contact_sidebar);
    print trim($contact_schedule);
    
}




?>
