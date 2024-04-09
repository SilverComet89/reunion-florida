<?php
// Single Agent
// Wp Estate Pack
get_header();
$wpestate_options           =   wpestate_page_details($post->ID);
$show_compare               =   1;
$wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$agent_page_template        =   intval( wpresidence_get_option('wp_estate_agent_layouts', '') );

if($agent_page_template===1){
    include( get_theme_file_path('templates/agent_page_templates/agent_template_1.php'));
}else if($agent_page_template===2){
    include( get_theme_file_path('templates/agent_page_templates/agent_template_2.php'));
}
    

get_footer(); 
?>