<?php

add_action( 'wp_body_open', 'wpresidence_wp_body_open' );

if(!function_exists('wpresidence_wp_body_open')):
function wpresidence_wp_body_open(){

  
}
endif;


/*
*
* Load the header
*
*/

if(!function_exists('wpresidence_show_header_wrapper')):
    function wpresidence_show_header_wrapper($header_classes,$logo_header_type){
      ?>
      <div class="master_header  wpestate-flex wpestate-flex-wrap wpestate-align-items-center wpestate-justify-content-md-between <?php echo esc_attr($header_classes['master_header_class']); ?>">
          <?php
              if(esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_menu','') )=="yes" && !is_page_template( 'splash_page.php' ) ){
                  get_template_part( 'templates/top_bar' );
              }
              get_template_part('templates/mobile_menu_header' );
          ?>
  
  
          <div  class="header_wrapper <?php echo esc_attr($header_classes['header_wrapper_class']);?> ">
              <?php
  
              if( !wpestate_is_user_dashboard()){
                  switch ($logo_header_type) {
                      case 'type1':
                          include( locate_template('templates/headers/header1.php') );
                          break;
                      case 'type2':
                          include( locate_template('templates/headers/header2.php') );
                          break;
                      case 'type3':
                          include( locate_template('templates/headers/header3.php') );
                          break;
                      case 'type4':
                          include( locate_template('templates/headers/header4.php') );
                          break;
                      case 'type5':
                          include( locate_template('templates/headers/header5.php') );
                          break;
                      case 'type6':
                          include( locate_template('templates/headers/header6.php') );
                          break;
                  }
              }else{
                  include( locate_template('templates/headers/header1.php') );
              }
              ?>            
          </div>
       </div>
              
            
     <?php
        global $post;
        if(is_singular('estate_property') && isset($post->ID)){
            $local_pgpr_content_type_status     =   get_post_meta($post->ID, 'local_pgpr_content_type', true);
            $global_prpg_content_type_status    =   esc_html ( wpresidence_get_option('wp_estate_global_prpg_content_type','') );
            $content_type                       =   wpestate_property_page_load_content($local_pgpr_content_type_status ,  $global_prpg_content_type_status); 

            if($content_type!='tabs'){
                // sticky top bar for property
                print wpresidence_property_build_sticky_top_bar($post->ID);
                print '<script type="text/javascript">
                //<![CDATA[
                    jQuery(document).ready(function(){
                        wpestate_property_sticky();
                    });
            
                //]]>
                </script>';
            }
        }

    }
  endif;
  


/*
*
* Load the header
*
*/

if(!function_exists('wpestate_return_all_labels_data')):
function wpestate_return_all_labels_data($item=''){
    $section_ids=array(
        'overview'              => array(
            "accordion_id"          =>  'single-overview-section',
            "tab_id"                =>  'tab_property_overview',
            "label_default"         =>  esc_html__('Overview','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_overview_text'),


        'description'           => array(
            "accordion_id"          =>  'wpestate_property_description_section',
            "tab_id"                =>  'tab_property_description',
            "label_default"         =>  esc_html__('Description','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_description_text'),

        'documents'             => array(
            "accordion_id"          =>  'accordion_property_documents',
            "tab_id"                =>  'tab_property_documens',
            "label_default"         =>  esc_html__('Documents','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_documents_text'),
        'multi-units'           =>  array(
            "accordion_id"          =>  'accordion_property_multi_units',
            "tab_id"                =>  'tab_property_multi_units',
            "label_default"         =>  esc_html__('Available Units','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_multi_text'),
        'energy-savings'        => array(
            "accordion_id"          =>  'accordion_property_energy_savings',
            "tab_id"                =>  'tab_property_energy_savings',
            "label_default"         =>  esc_html__('Enery Savings','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_energy_savings_text'),
        'address'               =>  array(
            "accordion_id"          =>  'accordion_property_address',
            "tab_id"                =>  'tab_property_address',
            "label_default"         =>  esc_html__('Property Address','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_adr_text'),
        'listing_details'       =>  array(
            "accordion_id"          =>  'accordion_property_details',
            "tab_id"                =>  'tab_property_listing_details',
            "label_default"         =>  esc_html__('Property Details','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_details_text'),
        'features'              =>  array(
            "accordion_id"          =>  'accordion_features_details',
            "tab_id"                =>  'tab_property_features',
            "label_default"         =>  esc_html__('Amenities and Features','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_features_text'),
        'video'                 =>  array(
            "accordion_id"          =>  'accordion_property_video',
            "tab_id"                =>  'tab_property_video',
            "label_default"         =>  esc_html__('Video','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_video_text'),
        'map'                   => array(
            "accordion_id"          =>  'accordion_property_details_map',
            "tab_id"                =>  'tab_property_map',
            "label_default"         =>  esc_html__('Map','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_map_text'),
        'virtual_tour'          => array(
            "accordion_id"          =>  'accordion_property_virtual_tour',
            "tab_id"                =>  'tab_property_virtual_tour',
            "label_default"         =>  esc_html__('Virtual Tour','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_virtual_tour_text'),
        'walkscore'             => array(
            "accordion_id"          =>  'accordion_property_walkscore',
            "tab_id"                =>  'tab_property_walkscore',
            "label_default"         =>  esc_html__('WalkScore','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_walkscorer_text'),
        'nearby'                => array(
            "accordion_id"          =>  'accordion_property_near_by',
            "tab_id"                =>  'tab_property_near_by',
            "label_default"         =>  esc_html__('What\'s Nearby','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_near_by_text'),
        'payment_calculator'    => array(
            "accordion_id"          =>  'accordion_property_payment_calculator',
            "tab_id"                =>  'tab_property_calculator',
            "label_default"         =>  esc_html__('Payment Calculator','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_calculator_text'),
        'floor_plans'           => array(
            "accordion_id"          =>  'accordion_property_floor_plans',
            "tab_id"                =>  'tab_property_floor_plan',
            "label_default"         =>  esc_html__('Floor Plans','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_floor_plan_text'),
        'page_views'            =>  array(
            "accordion_id"          =>  'accordion_property_page_views',
            "tab_id"                =>  'tab_property_page_views',
            "label_default"         =>  esc_html__('Page Views Statistics','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_page_views_text'),
        'schedule_tour'         => array(
            "accordion_id"          =>  'accordion_property_schedule_tour',
            "tab_id"                =>  'tab_property_schedule',
            "label_default"         =>  esc_html__('Schedule a tour','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_schedule_tour_text'),
        'agent_area'            => array(
            "accordion_id"          =>  'wpestate_single_agent_details_wrapper',
            "tab_id"                =>  'tab_property_agent_area',
            "label_default"         =>  esc_html__('Agent','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_sitcky_agent_text'),
        'other_agents'          => array(
            "accordion_id"          =>  'property_other_agents',
            "tab_id"                =>  'tab_property_other_agents',
            "label_default"         =>  esc_html__('Other Agents','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_other_agents_text'),

        'reviews'               => array(
            "accordion_id"          =>  'property_reviews_area',
            "tab_id"                =>  'tab_property_reviews',
            "label_default"         =>  esc_html__('Property Reviews','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_reviewstext'),
        'similar'               => array(
            "accordion_id"          =>  'property_similar_listings',
            "tab_id"                =>  'tab_property_similar_listings',
            "label_default"         =>  esc_html__('Similar Listings','wpresidence'),
            "label_theme_option"    =>  'wp_estate_property_similart_listings_text'),
    );

    if($item !='' && isset($section_ids[$item]) ){
        return $section_ids[$item];
    }else{
        return $section_ids;
    }

   
}
endif;



/*
*
* Load the sticky top bar
*
*/

if(!function_exists('wpresidence_property_build_sticky_top_bar')):
    function wpresidence_property_build_sticky_top_bar($postID){


        $wp_estate_show_property_sticky_top_bar=wpresidence_get_option('wp_estate_show_property_sticky_top_bar');

        if($wp_estate_show_property_sticky_top_bar!='yes'){
            return;
        }

        $wp_estate_global_page_template               = intval  ( wpresidence_get_option('wp_estate_global_property_page_template') );
        $wp_estate_local_page_template                = intval  ( get_post_meta($postID, 'property_page_desing_local', true));
        if($wp_estate_global_page_template!=0 || $wp_estate_local_page_template!=0 ){
            return '';
        }



        $wp_estate_property_layouts = intval  ( wpresidence_get_option('wp_estate_property_layouts') );
        if(  $wp_estate_property_layouts ==6 ||    $wp_estate_property_layouts ==7 ){
            $layout =   wpresidence_get_option('wp_estate_property_page_acc_lay6_order') ;
            $to_parse   =   $layout['enabled'];   
            if(is_array( $layout['after'])){
                $to_parse =array_merge($to_parse,$layout['after']);
            }
            if(is_array( $layout['after_content'])){
                $to_parse =array_merge($to_parse,$layout['after_content']);
            }
       
        }else{
            $layout     =   wpresidence_get_option('wp_estate_property_page_acc_order') ;
            $to_parse   =   $layout['enabled'];    
        }
        
        $return     =   '';
        $data       =   wpestate_return_all_labels_data();
        $all_data   =   get_post_meta($postID,'',true);

        foreach (  $to_parse as $key=>$label):
            if(isset($data[$key]) ){
                $label      =   wpestate_property_page_prepare_label( $data[$key]['label_theme_option'],$data[$key]['label_default'] );

                $show = 'yes';


                switch ($key) {
                    case "video":
                        if( !isset($all_data[ 'embed_video_id']) || $all_data[ 'embed_video_id'][0] == ''){
                            $show ='no';
                        }
                        break;
                    case "virtual_tour":
                        if( !isset($all_data['embed_virtual_tour']) || $all_data['embed_virtual_tour'][0] == '') {      
                            $show='no';
                        }
                        break;
                    case "floor_plans":
                        if( !isset($all_data['use_floor_plans'][0]) || $all_data['use_floor_plans'][0] != 1  ){
                            $show='no';
                        }
                        break;
                    case "multi-units" :
                        if(!isset($all_data['property_has_subunits'][0]) || $all_data['property_has_subunits'][0] != 1){
                            $show='no';
                        }
                        break;
                    case "energy-savings":
                        if( 
                            ( !isset( $all_data['energy_index'][0])          || $all_data['energy_index'][0] ==''    ) && 
                            ( !isset( $all_data['energy_class'][0])          || $all_data['energy_class'][0] ==''   ) && 
                            ( !isset( $all_data['co2_index'][0])             || $all_data['co2_index'][0] ==''      ) && 
                            ( !isset( $all_data['co2_class'][0])             || $all_data['co2_class'][0] ==''       ) && 
                            ( !isset( $all_data['epc_current_rating'][0])    || $all_data['epc_current_rating'][0] =='')  && 
                            ( !isset( $all_data['epc_potential_rating'][0]) || $all_data['epc_potential_rating'][0] =='') ) {

                        $show='no';
                        }
                        break;
                    case "payment_calculator":
                        if (wpestate_check_category_for_morgage($postID) !='yes'){
                            $show='no';
                        }
                        break;

                    case "features":
                        if( !is_array( get_the_terms($postID,'property_features') ) ){
                            $show='no';
                        }
                        break;


                    case "documents":
                        if(wpestare_return_documents($postID)=='' ){
                            $show='no';
                        }
                     break;
                }

              
          
                
                if($show =='yes' ):
                    $return.='<a class="wpestate_top_property_navigation_link" href="#'.esc_attr($data[$key]['accordion_id']).'">'.esc_html($label).'</a>';
                endif;
               
 

             
            }
        endforeach;

        return '<div class="wpestate_top_property_navigation">'.trim($return).'</div>';

    }
endif;