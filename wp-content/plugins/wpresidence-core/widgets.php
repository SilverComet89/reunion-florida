<?php
require('widgets/twiter.php');
require('widgets/facebook.php');
require('widgets/mortgage_widget.php');
require('widgets/contact_widget.php');
require('widgets/social_widget.php');
require('widgets/featured_widget.php');
require('widgets/footer_latest_widget.php');
require('widgets/advanced_search.php');
require('widgets/agents_agencies_dev_search.php');
require('widgets/login_widget.php');
require('widgets/social_widget_top_bar.php');
require('widgets/featured_agent.php');
require('widgets/measurement_unit.php');
require('widgets/multiple_currency.php');
require('widgets/property_categories.php');
require('widgets/zillow_estimate.php');
if( !function_exists('register_wpestate_widgets') ): 
    function register_wpestate_widgets() {    
       
        register_widget('Tweet_Widget');
        register_widget('Facebook_Widget');
        register_widget('Mortgage_widget');
        register_widget('Contact_widget');
        register_widget('Social_widget');
        register_widget('Featured_widget');
        register_widget('Footer_latest_widget');
        register_widget('Advanced_Search_widget');
        register_widget('Agents_Agencies_Dev_Search_widget');
        register_widget('measurement_unit_widget');
        register_widget('Login_widget');
        register_widget('Social_widget_top');
        register_widget('Featured_Agent');
        register_widget('Multiple_currency_widget');
        register_widget('Property_Categories');
                
        register_widget('Zillow_Estimate_Widget');
    
    }  
endif; // end   register_wpestate_widgets  


if( !function_exists('register_wpestate_widgets_imported') ):
function register_wpestate_widgets_imported(){
    $data = get_option('estate_imported_sidebars');
   
    if($data){
        foreach($data as $sidebar_id){
            register_sidebar(array(
                    'id'    =>  sanitize_title($sidebar_id),
                    'name'  =>  $sidebar_id,
                    'before_widget' => '<li id="%1$s" class="widget widget-container sbg_widget '.$sidebar_id.' %2$s">',
                    'after_widget'  => '</li>',
                    'before_title'  => '<h3 class="widget-title-sidebar">',
                    'after_title'   => '</h3>',
            ));
         
        }
    }
}
endif;




?>