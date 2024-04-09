<?php
// Template Name: WpEstate CRM List
// Wp Estate Pack
wpestate_dashboard_header_permissions();

global $wpestate_social_login;
$current_user    =  wp_get_current_user();
$userID          =  $current_user->ID;
$agent_list      = wpestate_return_agent_list();

if(function_exists('wpestate_crm_return_all_admin_ids') && current_user_can('administrator') ){
  $agent_list =array();
}
if(isset($_GET['delete_contact_id']) && intval($_GET['delete_contact_id']) !=0 ){
  wpestate_crm_delete_contact(intval($_GET['delete_contact_id']),$agent_list  );
}
if(isset($_GET['delete_lead_id']) && intval($_GET['delete_lead_id']) !=0 ){
  wpestate_crm_delete_contact(intval($_GET['delete_lead_id']),$agent_list  );
   $base_crm        =   wpestate_get_template_link('wpestate-crm-dashboard.php');
   $redirect_url    =   esc_url_raw(add_query_arg('actions', '0', $base_crm) );

    wp_redirect( $redirect_url);
    exit;
}


get_header();
?>

<div class="row row_user_dashboard">
    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
          <?php
          wpestate_show_dashboard_title(get_the_title());
          ?>

          <div class="col-md-12 wpestate_dash_coluns">
            <div class="wpestate_dashboard_content_wrapper dashboard_property_list">
              <?php
                  wpestate_show_crm_data_split($agent_list);
              ?>
            </div>
          </div>



    </div>
</div>

<?php get_footer(); ?>
