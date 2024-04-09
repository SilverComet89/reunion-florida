<?php
// Template Name: WpEstate CRM Leads
// Wp Estate Pack
wpestate_dashboard_header_permissions();

$current_user    =  wp_get_current_user();
$userID          =  $current_user->ID;
$agent_list      =  wpestate_return_agent_list();
$user_agent_id  =   intval( get_user_meta($userID,'user_agent_id',true));
$status          =  get_post_status($user_agent_id);

if( $status==='pending' || $status==='disabled' ){
    wp_redirect(  esc_url(home_url('/')));
    exit;
}

add_filter('wp_kses_allowed_html', 'wpestate_add_allowed_tags');
$allowed_html                     =   array();
$wpestate_submission_page_fields  =   wpresidence_get_option('wp_estate_submission_page_fields','');
$errors                           =   array();
if( isset( $_GET['lead_edit'] ) && is_numeric( $_GET['lead_edit'] ) ){
    $edit_id                        =  intval ($_GET['lead_edit']);
    $action                         =   'edit';
}else{
    $action                         =   'view';
}



///////////////////////////////////////////////////////////////////////////////////////////
/////// Submit Code
///////////////////////////////////////////////////////////////////////////////////////////


if( isset($_POST) && isset($_POST['action'])  && $_POST['action']=='view' ) {
    // get user dashboard link
    $redirect = wpestate_get_template_link('wpestate-crm-dashboard.php');
    $redirect = add_query_arg( 'actions', 0, $redirect );
    wpestate_create_crm_lead_dashboard($_POST,$agent_list,'');
    wp_reset_query();
    wp_redirect( $redirect);
    exit;

} // end post

///////////////////////////////////////////////////////////////////////////////////////////
/////// Edit Part Code
///////////////////////////////////////////////////////////////////////////////////////////
if( isset($_POST) && isset($_POST['action'])  &&  $_POST['action']=='edit' ) {
      $contact_edit   = intval($_GET['lead_edit']);
      wpestate_create_crm_lead_dashboard($_POST,$agent_list,$contact_edit);
      $redirect = wpestate_get_template_link('wpestate-crm-dashboard.php');
      $redirect = add_query_arg( 'actions', 0, $redirect );
      wp_reset_query();
      wp_redirect( $redirect);
      exit;

}

get_header();
$wpestate_options=wpestate_page_details($post->ID);



///////////////////////////////////////////////////////////////////////////////////////////
/////// Html Form Code below
///////////////////////////////////////////////////////////////////////////////////////////
?>

<div id="cover"></div>
<div class="row row_user_dashboard">

    <?php  get_template_part('templates/dashboard-templates/dashboard-left-col'); ?>

    <div class="col-md-9 dashboard-margin">
        <?php
        wpestate_show_dashboard_title(get_the_title());

        if( isset( $_GET['lead_edit'] ) && is_numeric( $_GET['lead_edit'] ) ){

            $contact_edit   = intval($_GET['lead_edit']);
            $post_author_id = get_post_field( 'post_author', $contact_edit );
            if( in_array($post_author_id,$agent_list) || current_user_can('administrator') ){
                include( locate_template('crm_functions/templates/crm_add_lead.php') );
            }else{

                print '<div class="col-md-7 wpestate_dash_coluns">  <div class="wpestate_dashboard_content_wrapper">
                    '.esc_html__("You are not allowed to edit this!","wpestate-crm").
                '</div></div>';
            }

        }else{
          include( locate_template('crm_functions/templates/crm_add_lead.php') );
        }
        ?>

    </div>
</div>
<?php
if(function_exists('wpestate_disable_filtering')){
    wpestate_disable_filtering('wp_kses_allowed_html', 'wpestate_add_allowed_tags');
}
get_footer();
?>
