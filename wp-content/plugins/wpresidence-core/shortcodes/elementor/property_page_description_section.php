<?php
/*
 *
 * Property description section
 *
 *
 *
 */

function property_page_elementor_content_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $to_show_post = get_post($property_id);
    $content = $to_show_post->post_content;
    $content = wpautop($content, false);
      $content=apply_filters( 'the_content', $content );
    echo $content;
}

/*
 *
 * Property agent v2 details section
 *
 *
 *
 */

function property_page_agent_form_v2_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);


    include_once(ABSPATH.'wp-admin/includes/plugin.php');
    if (is_plugin_active('elementor/elementor.php') && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        global $post;
    }

    ob_start();
    $enable_global_property_page_agent_sidebar= esc_html ( wpresidence_get_option('wp_estate_global_property_page_agent_sidebar','') );
    include( locate_template('/templates/property_list_agent.php') );
    $templates = ob_get_contents();
    ob_end_clean();

    print '<div class="elementor_agent_wrapper property_page_agent_form_v2_section">' . $templates . '</div>';
}

/*
 *
 * Property agent details section
 *
 *
 *
 */

function property_page_agent_form_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);


    include_once(ABSPATH.'wp-admin/includes/plugin.php');
    if (is_plugin_active('elementor/elementor.php') && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        global $post;
    }

    ob_start();

    $property_page_context = 'custom_page_temaplate';
    include( locate_template('/templates/listing_templates/agent_section/agent_area.php') );
    $templates = ob_get_contents();
    ob_end_clean();

    print '<div class="elementor_agent_wrapper">' . $templates . '</div>';
}

/*
 *
 * Property Subunits section
 *
 *
 *
 */

function property_page_subunits_section_function($attributes, $settings) {
    global $property_id;
    $property_id = wpestate_return_property_id_elementor_builder($attributes);

    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    if ($settings['section_title2'] !== '') {
        $section_title2 = $settings['section_title2'];
    }
    include_once(ABSPATH.'wp-admin/includes/plugin.php');
    if (is_plugin_active('elementor/elementor.php') && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        global $post;
    }
    ob_start();
    $has_multi_units = intval(get_post_meta($property_id, 'property_has_subunits', true));
    $property_subunits_master = intval(get_post_meta($property_id, 'property_subunits_master', true));

    if ($has_multi_units == 1) {
 
        include( locate_template('/templates/multi_units.php') );
    } else {
        if ($property_subunits_master != 0) {
       
            include( locate_template('/templates/multi_units.php') );
        }
    }

    $templates = ob_get_contents();
    ob_end_clean();

    print $templates;
}

/*
 *
 * Property Reviews section
 *
 *
 *
 */

function property_page_similar_listings_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);

    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }


    print wpestate_show_related_listings($property_id, $settings['post_number'], $settings);
}

/*
 *
 * Property yelp section
 *
 *
 *
 */

function property_page_yelp_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $yelp_client_id = wpresidence_get_option('wp_estate_yelp_client_id', '');
    $yelp_client_secret = wpresidence_get_option('wp_estate_yelp_client_secret', '');
    $yelp_client_api_key_2018 = wpresidence_get_option('wp_estate_yelp_client_api_key_2018', '');



    $section_title = esc_html__('What\'s Nearby', 'wpresidence-core');
    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }

    print '<div class="panel-group property-panel" id="accordion_yelp">
      <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title" id="prop_ame">' . $section_title . '</h4>
          </div>

          <div class="panel-body">';
    if ($yelp_client_api_key_2018 != '' && $yelp_client_id != '') {
        wpestate_yelp_details($property_id);
    }
    print '</div>
      </div>
  </div>';
}

/*
 *
 * Property Reviews section
 *
 *
 *
 */

function property_page_review_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $label = esc_html__('Property Reviews', 'wpresidence-core');
    if ($settings['section_title'] !== '') {
        $label = $settings['section_title'];
    }
    include_once(ABSPATH.'wp-admin/includes/plugin.php');
    if (is_plugin_active('elementor/elementor.php') && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        global $post;
    }
    ob_start();
    $is_tab='';
    include( locate_template ('/templates/listing_templates/property-page-templates/property_reviews.php' ) );
        
    $templates = ob_get_contents();
    ob_end_clean();

    print $templates;
}

/*
 *
 * Property Statistics section
 *
 *
 *
 */

function property_page_statistics_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('Page Views Statistics', 'wpresidence-core');
    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    print ' <div class="panel-group property-panel" id="accordion_prop_stat">
        <div class="panel panel-default">
           <div class="panel-heading">
              <h4 class="panel-title">' . $section_title . '</h4>
           </div>
             <div class="panel-body">
                <canvas id="myChart"></canvas>
             </div>
        </div>
    </div>';
    print '<script type="text/javascript">
    //<![CDATA[
        jQuery(document).ready(function(){
            wpestate_show_stat_accordion();
        });

    //]]>
  </script>';
}

/*
 *
 * Property Calculator section
 *
 *
 *
 */

function property_page_floorplan_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('Floor Plans', 'wpresidence-core');
    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    $wpestate_prop_all_details = get_post_custom($property_id);
    $plan_title_array           = unserialize ( wpestate_return_custom_field( $wpestate_prop_all_details,'plan_title'));

    if (is_array($plan_title_array)){
        print '
        <div class="panel-group property-panel" id="accordion_prop_floor_plans">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title" id="prop_ame">' . $section_title . '</h4>
                </div>
                <div class="panel-body">';
            estate_floor_plan($property_id, 0, $wpestate_prop_all_details);
            print '</div>
            </div>
        </div>';
    }
}

/*
 *
 * Property Calculator section
 *
 *
 *
 */

function property_page_calculator_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('Payment Calculator', 'wpresidence-core');
    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    $wpestate_prop_all_details = get_post_custom($property_id);
    print '<div class="panel-group property-panel" id="accordion_morgage">
      <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title" id="prop_morg">' . $section_title . ' </h4>
          </div>

          <div class="panel-body">';
    wpestate_morgage_calculator($property_id, $wpestate_prop_all_details);
    print '</div>

      </div>
  </div>';

    print'<script type="text/javascript">
    //<![CDATA[
        jQuery(document).ready(function(){
            wpestate_show_morg_pie();
        });

    //]]>
  </script>';
}

/*
 *
 * Property Walkscore section
 *
 *
 *
 */

function property_page_walkscore_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('WalkScore', 'wpresidence-core');
    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    $walkscore_api = esc_html(wpresidence_get_option('wp_estate_walkscore_api', ''));
    $wpestate_prop_all_details = get_post_custom($property_id);
    print '<div class="panel-group property-panel" id="accordion_walkscore">
      <div class="panel panel-default">
          <div class="panel-heading">
              <h4 class="panel-title" >' . $section_title . '</h4>
          </div>

          <div class="panel-body">';
    if ($walkscore_api != '') {
        print wpestate_walkscore_details($property_id, $wpestate_prop_all_details);
    } else {
        esc_html_e('Please add a Walkscore Api Key', 'wpresidence-core');
    }
    print '</div>

      </div>
  </div>';
//  wpestate_show_stat_accordion();
    print '<script type="text/javascript">
    //<![CDATA[
        jQuery(document).ready(function(){
            wpestate_show_morg_pie();

        });

    //]]>
  </script>';
}

/*
 *
 * Property Virtual Tour section
 *
 *
 *
 */

function property_page_virtual_tour_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('Virtual Tour', 'wpresidence-core');
    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    $virtual_tour_code= get_post_meta($property_id, 'embed_virtual_tour', true);

    if($virtual_tour_code!=''){
        print '<div class="panel-group property-panel" id="accordion_virtual_tour">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title" id="prop_virtual">' . $section_title . '</h4>
                </div>

                <div class="panel-body">';
            wpestate_virtual_tour_details($property_id);
            print '</div>

            </div>
        </div>';
    }
}

/*
 *
 * Property Video section
 *
 *
 *
 */

function property_page_map_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('Map', 'wpresidence-core');
    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    print'
  <div class="panel-group property-panel" id="accordion_prop_map">
       <div class="panel panel-default">
           <div class="panel-heading">
             <h4 class="panel-title" id="prop_ame">' . $section_title . '</h4>
           </div>

           <div class="panel-body">
             ' . do_shortcode('[property_page_map propertyid="' . $property_id . '"][/property_page_map]') . '
           </div>

       </div>
   </div>';
}

/*
 *
 * Property Video section
 *
 *
 *
 */

function property_page_video_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('Video', 'wpresidence-core');
    $wpestate_prop_all_details = get_post_custom($property_id);

    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    $embed_video_id  = get_post_meta($property_id, 'embed_video_id', true);
    if($embed_video_id!=''){
        print'
            <div class="panel-group property-panel" id="accordion_video">
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <h4 class="panel-title" id="prop_video">' . $section_title . '</h4>
                  </div>

                    <div class="panel-body">
                      ' . wpestate_listing_video($property_id, $wpestate_prop_all_details) . '
                    </div>

              </div>
        </div>';
   }
}

/*
 *
 * Property Details section
 *
 *
 *
 */

function property_page_features_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('Amenities and Features', 'wpresidence-core');
    $wpestate_prop_all_details = get_post_custom($property_id);
    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
     $property_features  =   get_the_terms($property_id,'property_features');

    if($property_features){
        print'
            <div class="panel-group property-panel" id="accordion_prop_features">
              <div class="panel panel-default">
                  <div class="panel-heading">
                          <h4 class="panel-title" id="prop_ame">
                              ' . $section_title . '
                          </h4>

                  </div>
                    <div class="panel-body">
                    ' . estate_listing_features($property_id, $settings['no_colums']['size'], 0, '', $wpestate_prop_all_details) . '
                    </div>

              </div>
        </div>';
     }
}

/*
 *
 * Property Details section
 *
 *
 *
 */

function property_page_details_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $section_title = esc_html__('Property Details', 'wpresidence-core');

    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }
    $wpestate_prop_all_details = get_post_custom($property_id);
    print '<div class="panel-group property-panel" id="accordion_prop_details">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title" id="prop_det">  ' . esc_html($section_title) . '</h4>
        </div>

          <div class="panel-body">
          ' . estate_listing_details($property_id, $wpestate_prop_all_details, $settings['no_colums']['size']) . '
          </div>

    </div>
    </div>';
}

/*
 *
 * Property Adress section
 *
 *
 *
 */

function property_page_address_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);
    $wpestate_prop_all_details = get_post_custom($property_id);
    $section_title = esc_html__('Property Address', 'wpresidence-core');

    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }




    print'<div class="panel-group property-panel" id="accordion_prop_addr">
    <div class="panel panel-default">
       <div class="panel-heading">
              <h4 class="panel-title">' . esc_html($section_title) . '</h4>
       </div>

       <div class="panel-body">
          ' . estate_listing_address($property_id, $wpestate_prop_all_details, $settings['no_colums']['size']) . '
      </div>

    </div>
</div>';
}

/*
 *
 * Property details section
 *
 *
 */

function property_page_description_section_function($attributes, $settings) {
    $property_id = wpestate_return_property_id_elementor_builder($attributes);

   
    $to_show_post = get_post($property_id);
    $content = $to_show_post->post_content;
   
    $content = wpautop($content, false);
    if(isset($attributes['is_elementor_edit']) && intval($attributes['is_elementor_edit'])==1){
        // do not load shortcodes
    }else{
        $content=apply_filters( 'the_content', $content );
    }
 

    ob_start();

    $section_title = esc_html__('Description', 'wpresidence-core');

    if ($settings['section_title'] !== '') {
        $section_title = $settings['section_title'];
    }

    print '<div class="wpestate_property_description" id="wpestate_property_description_section">
        <h4 class="panel-title">' . esc_html($section_title) . '</h4>' . $content;

    $energy_index = get_post_meta($property_id, 'energy_index', true);
    $energy_class = get_post_meta($property_id, 'energy_class', true);

    if ($energy_index != '' || $energy_class != '') { //  if energy data  exists
        ?>
        <div class="property_energy_saving_info"  >
        <?php print wpestate_energy_save_features($property_id); ?>
        </div>
        <?php
    } // end if energy data  exists
    print wpestare_return_documents($property_id);
    print '</div>';




    $templates = ob_get_contents();
    ob_end_clean();
    print $templates;
}
?>
