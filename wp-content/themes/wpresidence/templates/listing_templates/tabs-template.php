<?php
$layout=wpresidence_get_option('wp_estate_property_page_tab_order') ;
$tab_active_class='active';
$tab_data=array();
// Build Tabs

foreach ($layout['enabled'] as $key=>$label):

    switch ($key) {
            case 'overview':
                $partial_data = wpestate_property_overview_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'description':
                $partial_data =  wpestate_property_description_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'documents':
                $partial_data = wpestate_property_documents_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'energy-savings':
                $partial_data = wpestate_property_energy_savings_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'multi-units':
                $partial_data = wpestate_property_multi_units_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
          case 'address':
                $partial_data =wpestate_property_address_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'listing_details':
                $partial_data = wpestate_property_listing_details_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'features':
                $partial_data = wpestate_property_features_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'video':
                $partial_data = wpestate_property_video_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'map':
                $partial_data = wpestate_property_map_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'virtual_tour':
                $partial_data = wpestate_property_virtual_tour_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'walkscore':
                $partial_data = wpestate_property_walkscore_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'nearby':
                $partial_data = wpestate_property_nearby_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'payment_calculator':
                $partial_data =wpestate_property_payment_calculator_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'floor_plans':
                $partial_data =wpestate_property_floor_plans_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'page_views':
                $partial_data =wpestate_property_page_views_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'schedule_tour':
                $partial_data =wpestate_property_schedule_tour_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'agent_area':
                $partial_data =wpestate_property_agent_area_v2($post->ID,$wpestate_options,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'other_agents':
                $partial_data =wpestate_property_other_agents_v2($post->ID,$wpestate_options,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
            case 'reviews':
                $partial_data =wpestate_property_reviews_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;               
            case 'similar':
                $partial_data =wpestate_property_similar_listings_v2($post->ID,'yes',$tab_active_class);
                $tab_active_class           =   '';
            break;
    }

    if(isset($partial_data['list'])){
        $tab_data['list'][]         =   $partial_data['list'];
        $tab_data['tab_panel'][]    =   $partial_data['tab_panel'];
        unset($partial_data);
    }
  

endforeach;    
?>




<div role="tabpanel" id="tab_prpg">

    <ul class="nav nav-tabs" role="tablist">
        <?php
        foreach(  $tab_data['list'] as $key=>$item):
            print trim($item);
        endforeach;    
        ?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <?php
        foreach(  $tab_data['tab_panel'] as $key=>$item):
            print trim($item);
        endforeach;    
        ?>
    </div>
</div>





<?php
// After Tabs
foreach ($layout['after'] as $key=>$label):

    switch ($key) {
            case 'overview':
                include(locate_template('templates/listing_templates/single-overview-section.php'));
            break;
            case 'description':
                wpestate_property_description_v2($post->ID);
            break;
            case 'documents':
                wpestate_property_documents_v2($post->ID);
            break;
            case 'energy-savings':
                wpestate_property_energy_savings_v2($post->ID);
            break;
            case 'multi-units':
                wpestate_property_multi_units_v2($post->ID);
            break;
            case 'address':
                wpestate_property_address_v2($post->ID);
            break;
            case 'listing_details':
                wpestate_property_listing_details_v2($post->ID);
            break;
            case 'features':
                wpestate_property_features_v2($post->ID);
            break;
            case 'video':
                wpestate_property_video_v2($post->ID);
            break;
            case 'map':
                wpestate_property_map_v2($post->ID);
            break;
            case 'virtual_tour':
                wpestate_property_virtual_tour_v2($post->ID);
            break;
            case 'walkscore':
                wpestate_property_walkscore_v2($post->ID);
            break;
            case 'nearby':
                wpestate_property_nearby_v2($post->ID);
            break;
            case 'payment_calculator':
                wpestate_property_payment_calculator_v2($post->ID);
            break;
            case 'floor_plans':
                wpestate_property_floor_plans_v2($post->ID);
            break;
            case 'page_views':
                wpestate_property_page_views_v2($post->ID);
            break;
            case 'schedule_tour':
                wpestate_property_schedule_tour_v2($post->ID);
            break;
            case 'agent_area':
                wpestate_property_agent_area_v2($post->ID,$wpestate_options);
            break;
            case 'other_agents':
                wpestate_property_other_agents_v2($post->ID,$wpestate_options);
            break;
            case 'reviews':
                wpestate_property_reviews_v2($post->ID);
            break;               
            case 'similar':
                wpestate_property_similar_listings_v2($post->ID);
            break;
    }


endforeach;    
?>