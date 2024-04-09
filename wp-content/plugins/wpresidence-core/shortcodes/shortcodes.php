<?php

include_once('property_list_shortcode.php');
include_once('slider_property_shortcode.php');
include_once('grids_shortcode.php');
include_once('filter_list_shortcode.php');
include_once('advanced_filter_list_shortcode.php');
include_once('places_shortcodes.php');

include_once('elementor/property_page_title.php');
include_once('elementor/property_header_section_function.php');
include_once('elementor/property_page_overview_section.php');
include_once('elementor/property_page_description_section.php');

/*
 * Widget wpresidence grids function
 *
 *
 */

if (!function_exists('wpresidence_display_agents_grid')):

    function wpresidence_display_agents_grid($args) {
        $display_grids = wpresidence_display_grids_setup();

        $type = intval($args['type']);
        $place_type = intval($args['wpresidence_design_type']);
        $use_grid = $display_grids[$type];

        $item_height_style = '';
        $item_height = 300;

        $category_tax = $args['grid_taxonomy'];
        $agents = $args['grid_taxonomy'];

        if (!is_array($agents)) {
            return;
        }

        if ($args['order'] == 'ASC') {
            asort($agents);
        } else {
            arsort($agents);
        }



        $agents_ids = array_values($agents);
      
        $container = '<div class="row elementor_wpresidece_grid">';
        $agent_unit = wpestate_agent_card_selector(2);
        foreach ($use_grid['position'] as $key => $item_length) {
           
         
            if (isset($agents_ids[$key - 1])) {
              //  $container .= '<div class="' . esc_attr($item_length) . ' col-sm-12 elementor_residence_grid">';
                    ob_start();         
                        $agent_id = $agents_ids[$key - 1];
                        include( locate_template($agent_unit) ) ;      
                    $container .= ob_get_contents();
                    ob_end_clean();
               
            }

        }
        $container .= '</div>';

        return $container;
    }

endif;

/*
 * 
 * 
 * Get list agents for agent grid 
 * 
 * 
 * 
 * 
 * */

function get_list_agents_elementor() {
    $args = array(
        'post_type' => 'estate_agent',
        'paged' => 1,
        'posts_per_page' => 50);
    $return_array = array();
    $agent_selection = new WP_Query($args);
    while ($agent_selection->have_posts()): $agent_selection->the_post();
        $return_array[get_the_ID()] = get_the_title();
    endwhile;
    wp_reset_postdata();
    wp_reset_query();
    return $return_array;
}

/*
 * 
 * 
 *  Testimonial sloder function
 * 
 * 
 * 
 * 
 * */

function wpestate_testimonial_slider($settings) {
    wp_enqueue_script('owl_carousel');
    $return_string = '';

    if (isset($settings['list']) && is_array($settings['list'])) {
        $items_list = '';
        foreach ($settings['list'] as $key => $testimonial):
            $items_list .= '<div class="item">';
            $items_list .= '<div class="item_testimonial_content">
                    <div class="item_testimonial_title">' . trim($testimonial['testimonial_title']) . '</div>
                    <div class="item_testimonial_text">' . trim($testimonial['testimonial_text']) . '</div>
                    <div class="item_testimonial_stars">' . wpestate_starts_reviews_core(floatval($testimonial['testimonial_stars'])) . '</div>
                    <div class="item_testimonial_name">' . trim($testimonial['testimonial_name']) . '</div>
                    <div class="item_testimonial_job">' . trim($testimonial['testimonial_job']) . '</div>
            
                    </div>';
            $items_list .= '<div class="item_testimonal_image" style="background-image:url(' . $testimonial['testimonial_image']['url'] . ');"></div>';

            $items_list .= '</div>';
        endforeach;

        $slider_id = 'wpestate_testimonial_slider_' . rand(1, 99999);

        $return_string .= '<div class="owl-carousel owl-theme wpestate_testimonial_slider" id="' . $slider_id . '" data-auto="0">' . $items_list . '</div>';

        $return_string .= '
         <script type="text/javascript">
             //<![CDATA[
             jQuery(document).ready(function(){
                wpestate_testimonial_slider("' . $slider_id . '");
             });
             //]]>
         </script>';
    }
    return $return_string;
}

/*
 *
 * return property id for elementor builder
 *
 *
 *
 *
 */

function wpestate_return_property_id_elementor_builder($attributes) {

    // wpresidence temaplte system
    $wp_estate_global_page_template = intval(wpresidence_get_option('wp_estate_global_property_page_template'));
    if ($wp_estate_global_page_template != 0) {
        if (isset($attributes['is_elementor_edit']) && $attributes['is_elementor_edit'] == 1) {
            $property_id = wpestate_return_elementor_id();
            return $property_id;
        }
        global $propid;
        return $propid;
    } else {
        // wpresidence temaplte system per item
        global $propid;
        $wp_estate_local_page_template = intval(get_post_meta($propid, 'property_page_desing_local', true));
        if ($wp_estate_local_page_template != 0) {
            return $propid;
        }
    }







    // elementor template system
    $property_id = get_the_ID();
    if (isset($attributes['is_elementor_edit']) && $attributes['is_elementor_edit'] == 1) {
        $property_id = wpestate_return_elementor_id();
    }
    return $property_id;
}

/*
 *
 * return bootstrap column number
 *
 *
 *
 *
 */

if (!function_exists('wpestate_shortocode_return_column')):

    function wpestate_shortocode_return_column($row_number) {
        if ($row_number > 4) {
            $row_number = 4;
        }
        if ($row_number == 4) {
            $row_number_col = 3; // col value is 3
        } else if ($row_number == 3) {
            $row_number_col = 4; // col value is 4
        } else if ($row_number == 2) {
            $row_number_col = 6; // col value is 6
        } else if ($row_number == 1) {
            $row_number_col = 12; // col value is 12
        }
        return $row_number_col;
    }

endif;

/*
 *
 * create arguments array for proeprties list and shortlist slider
 *
 *
 *
 *
 */
if (!function_exists('wpestate_recent_posts_shortocodes_create_arg')):

    function wpestate_recent_posts_shortocodes_create_arg($shortcode_arguments) {

        if ($shortcode_arguments['type'] == 'properties' || $shortcode_arguments['type'] == 'estate_property') {
            /*
             * if we have properties
             */
            $type = 'estate_property';
            $tax_arguments = array(
                'by_field' => 'term_id',
                'property_action_category' => isset($shortcode_arguments['action']) ? explode(',', $shortcode_arguments['action']) : '',
                'property_category' => isset($shortcode_arguments['category']) ? explode(',', $shortcode_arguments['category']) : '',
                'property_area' => isset($shortcode_arguments['area']) ? explode(',', $shortcode_arguments['area']) : '',
                'property_city' => isset($shortcode_arguments['city']) ? explode(',', $shortcode_arguments['city']) : '',
                'property_county_state' => isset($shortcode_arguments['state']) ? explode(',', $shortcode_arguments['state']) : '',
                'property_status' => isset($shortcode_arguments['status']) ? explode(',', $shortcode_arguments['status']) : '',
                'property_features' => isset($shortcode_arguments['features']) ? explode(',', $shortcode_arguments['features']) : '',
            );

            $meta_data = array();
            if (isset($shortcode_arguments['show_featured_only']) && $shortcode_arguments['show_featured_only'] == 'yes') {
                $meta_data['prop_featured'] = array(
                    'key' => 'prop_featured',
                    'value' => 1,
                    'compare' => '=',
                );
            }



            $meta_query = wpestate_create_query_meta_by_array($meta_data);

            $order = intval($shortcode_arguments['sort_by']);
            if (isset($shortcode_arguments['random_pick']) && $shortcode_arguments['random_pick'] == 'yes') {
                $order = 99;
            }
            $paged = (isset($shortcode_arguments['paged'])) ? $shortcode_arguments['paged'] : 1;

            $temp_arguments = array(
                'post_type' => 'estate_property',
                'post_status' => 'publish',
                'paged' => $paged,
                'order' => $order,
                'posts_per_page' => $shortcode_arguments['number'],
                'tax_arguments' => $tax_arguments,
                'meta_query' => $meta_data
            );

            $arguments_array = wpestate_create_query_arguments($temp_arguments);
            $args = $arguments_array['query_arguments'];
        } else if ($shortcode_arguments['type'] == 'agents') {

            /*
             * if we have agents
             */
            $paged = (isset($shortcode_arguments['paged'])) ? $shortcode_arguments['paged'] : 1;
            $type = 'estate_agent';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'paged' => $paged,
                'posts_per_page' => $shortcode_arguments['number'],
            );
        } else {
            /*
             * if we have simple blog posts
             */
            $paged = (isset($shortcode_arguments['paged'])) ? $shortcode_arguments['paged'] : 1;
            $type = 'post';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'paged' => $paged,
                'posts_per_page' => $shortcode_arguments['number'],
                'cat' => $shortcode_arguments['category'],
            );
        }

        return $args;
    }

endif;

if (!function_exists("wpestate_return_filter_data")):

    function wpestate_return_filter_data($filter_selection) {

        $values_array = array(
            'types' => array(
                'label' => esc_html__('Types', 'wpresidence-core'),
                'meta' => 'Types',
            ),
            'category' => array(
                'label' => esc_html__('Categories', 'wpresidence-core'),
                'meta' => 'Categories',
            ),
            'county' => array(
                'label' => esc_html__('States', 'wpresidence-core'),
                'meta' => 'States',
            ),
            'city' => array(
                'label' => esc_html__('Cities', 'wpresidence-core'),
                'meta' => 'Cities',
            ),
            'area' => array(
                'label' => esc_html__('Areas', 'wpresidence-core'),
                'meta' => 'Areas',
            ),
        );

        $return_arrray = array();
        foreach ($filter_selection as $key => $value) {

            if ($value == 'all') {

                if (isset($values_array[$key]['label'])) {
                    $return_arrray[$key]['label'] = $values_array[$key]['label'];
                } else {
                    $return_arrray[$key]['label'] = '';
                }

                if (isset($values_array[$key]['meta'])) {
                    $return_arrray[$key]['meta'] = $values_array[$key]['meta'];
                } else {
                    $values_array[$key]['meta'] = '';
                }
            } else {
                $return_arrray[$key]['label'] = ucwords(str_replace('-', ' ', $value));
                $return_arrray[$key]['meta'] = sanitize_title($value);
            }
        }
        return $return_arrray;
    }

endif;

///////////////////////////////////////////////////////////////////////////////////////////
// advanced search function
///////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists("wpestate_advanced_search_function")):

    function wpestate_advanced_search_function($attributes, $content = null) {
        $return_string = '';
        $random_id = '';
        $custom_advanced_search = wpresidence_get_option('wp_estate_custom_advanced_search', '');
        $actions_select = '';
        $categ_select = '';
        $title = '';
        $search_col = 3;
        $search_col_but = 3;
        $search_col_price = 6;
        if (isset($attributes['title'])) {
            $title = $attributes['title'];
        }

        $args = wpestate_get_select_arguments();
        $action_select_list = wpestate_get_action_select_list($args);
        $categ_select_list = wpestate_get_category_select_list($args);
        $select_city_list = wpestate_get_city_select_list($args);
        $select_area_list = wpestate_get_area_select_list($args);
        $select_county_state_list = wpestate_get_county_state_select_list($args);

        $adv_submit = wpestate_get_template_link('advanced_search_results.php');

        if ($title != '') {
            
        }

        $return_string .= '<h2 class="shortcode_title_adv">' . $title . '</h2>';
        $return_string .= '<div class="advanced_search_shortcode" id="advanced_search_shortcode">
        <form role="search" method="get"   action="' . $adv_submit . '" >';

        if (function_exists('icl_translate')) {
            $return_string .= do_action('wpml_add_language_form_field');
        }
        $adv_search_type = wpresidence_get_option('wp_estate_adv_search_type', '');
        if ($adv_search_type == 6) {
            $return_string = '<div class="advanced_search_shortcode" id="advanced_search_shortcode">' . wpestate_show_advanced_search_tabs($adv_submit, 'shortcode') . '</div>';
            return $return_string;
        }



        if ($custom_advanced_search == 'yes') {

            $adv_search_what = wpresidence_get_option('wp_estate_adv_search_what', '');
            $adv_search_label = wpresidence_get_option('wp_estate_adv_search_label', '');
            $adv_search_how = wpresidence_get_option('wp_estate_adv_search_how', '');
            $count = 0;
            ob_start();
            $search_field = '';
            $adv_search_fields_no_per_row = ( floatval(wpresidence_get_option('wp_estate_search_fields_no_per_row')) );

            if ($adv_search_type == 10) {
                $adv_actions_value = esc_html__('Types', 'wpresidence-core');
                $adv_actions_value1 = 'all';

                print '<div class="col-md-9">
                        <input type="text" id="adv_location" class="form-control" name="adv_location"  placeholder="' . esc_html__('Type address, state, city or area', 'wpresidence-core') . '" value="">
                    </div>';

                print'
                    <div class="col-md-3">
                        <div class="dropdown form-control listing_filter_select" >
                            <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="' . strtolower(rawurlencode($adv_actions_value1)) . '">
                                ' . $adv_actions_value . '
                            <span class="caret caret_filter"></span> </div>
                            <input type="hidden" name="filter_search_action[]" value="">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                                ' . $action_select_list . '
                            </ul>
                        </div>
                    </div>';
                print '<input type="hidden" name="is10" value="10">';
            }



            if ($adv_search_type == 11) {
                $adv_actions_value = esc_html__('Types', 'wpresidence-core');
                $adv_actions_value1 = 'all';
                $adv_categ_value = esc_html__('Categories', 'wpresidence-core');
                $adv_categ_value1 = 'all';

                print'
                    <div class="col-md-6">
                    <input type="text" id="keyword_search" class="form-control" name="keyword_search"  placeholder="' . esc_html__('Type Keyword', 'wpresidence-core') . '" value="">
                    </div>';

                print '
                    <div class="col-md-3">
                        <div class="dropdown form-control listing_filter_select" >
                            <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger"  data-value="' . strtolower(rawurlencode($adv_categ_value1)) . '">
                                ' . $adv_categ_value . '
                            <span class="caret caret_filter"></span> </div>
                            <input type="hidden" name="filter_search_type[]" value="">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                                ' . $categ_select_list . '
                            </ul>
                        </div>
                    </div>';

                print'
                    <div class="col-md-3">
                        <div class="dropdown form-control listing_filter_select" >
                            <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="' . strtolower(rawurlencode($adv_actions_value1)) . '">
                                ' . $adv_actions_value . '
                            <span class="caret caret_filter"></span> </div>
                            <input type="hidden" name="filter_search_action[]" value="">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                                ' . $action_select_list . '
                            </ul>
                        </div>
                    </div>';

                print ' <input type="hidden" name="is11" value="11">';
            }



            foreach ($adv_search_what as $key => $search_field) {

                $search_col = 3;
                $search_col_but = 3;
                $search_col_price = 6;
                if ($adv_search_fields_no_per_row == 2) {
                    $search_col = 6;
                    $search_col_but = 6;
                    $search_col_price = 12;
                } else if ($adv_search_fields_no_per_row == 3) {
                    $search_col = 4;
                    $search_col_but = 4;
                    $search_col_price = 8;
                }
                if ($search_field == 'property price' && wpresidence_get_option('wp_estate_show_slider_price', '') == 'yes') {
                    $search_col = $search_col_price;
                }

                print '<div class="col-md-' . $search_col . ' ' . str_replace(" ", "_", $search_field) . '">';
                wpestate_show_search_field($adv_search_label[$key], 'shortcode', $search_field, $action_select_list, $categ_select_list, $select_city_list, $select_area_list, $key, $select_county_state_list);
                print '</div>';
            } // end foreach
            $templates = ob_get_contents();
            ob_end_clean();
            $return_string .= $templates;
        } else {
            $return_string .= wpestate_show_search_field_classic_form('shortcode', $action_select_list, $categ_select_list, $select_city_list, $select_area_list);
        }
        $extended_search = wpresidence_get_option('wp_estate_show_adv_search_extended', '');
        if ($extended_search == 'yes') {
            ob_start();
            show_extended_search('short');
            $templates = ob_get_contents();
            ob_end_clean();
            $return_string = $return_string . $templates;
        }
        $search_field = "submit";
        $return_string .= '<div class="col-md-' . $search_col_but . ' ' . str_replace(" ", "_", $search_field) . '">
            <button class="wpresidence_button" id="advanced_submit_shorcode">' . esc_html__('Search', 'wpresidence-core') . '</button>
        ' . wp_nonce_field('wpestate_regular_search', 'wpestate_regular_search_nonce', true, false) . '
        </div>

    </form>
</div>';

        return $return_string;
    }

endif;

if (!function_exists('wpestate_full_map_shortcode')):

    function wpestate_full_map_shortcode($attributes, $content = null) {

        $attributes = shortcode_atts(
                array(
                    'map_shortcode_for' => 'no',
                    'map_shorcode_show_contact_form' => 'yes',
                    'map_height' => 600,
                    'map_snazy' => '',
                    'map_zoom' => 20,
                    'category_ids' => '',
                    'action_ids' => '',
                    'city_ids' => '',
                    'area_ids' => '',
                    'state_ids' => '',
                    'status_ids' => '',
                    'is_elementor' => 0,
                ), $attributes);

        if (isset($attributes['map_shortcode_for'])) {
            $map_shortcode_for = $attributes['map_shortcode_for'];
        }

        if (isset($attributes['map_shorcode_show_contact_form'])) {
            $map_shorcode_show_contact_form = $attributes['map_shorcode_show_contact_form'];
        }

        if (isset($attributes['map_height'])) {
            $map_height = $attributes['map_height'];
        }


        $map_style = '';
        if (isset($attributes['map_snazy'])) {
            $map_style = $attributes['map_snazy'];
        }

        if (isset($attributes['map_zoom'])) {
            $map_zoom = $attributes['map_zoom'];
        }
        if (isset($attributes['category_ids'])) {
            $category = $attributes['category_ids'];
        }

        if (isset($attributes['action_ids'])) {
            $action = $attributes['action_ids'];
        }

        if (isset($attributes['city_ids'])) {
            $city = $attributes['city_ids'];
        }

        if (isset($attributes['area_ids'])) {
            $area = $attributes['area_ids'];
        }

        if (isset($attributes['state_ids'])) {
            $state = $attributes['state_ids'];
        }

        if (isset($attributes['status_ids'])) {
            $status = $attributes['status_ids'];
        }

        $category_array = '';
        $action_array = '';
        $city_array = '';
        $area_array = '';
        $state_array = '';
        $status_array = '';

        // build category array
        if ($category != '') {
            $category_of_tax = array();
            $category_of_tax = explode(',', $category);
            $category_array = array(
                'taxonomy' => 'property_category',
                'field' => 'term_id',
                'terms' => $category_of_tax
            );
        }


        // build action array
        if ($action != '') {
            $action_of_tax = array();
            $action_of_tax = explode(',', $action);
            $action_array = array(
                'taxonomy' => 'property_action_category',
                'field' => 'term_id',
                'terms' => $action_of_tax
            );
        }

        // build city array
        if ($city != '') {
            $city_of_tax = array();
            $city_of_tax = explode(',', $city);
            $city_array = array(
                'taxonomy' => 'property_city',
                'field' => 'term_id',
                'terms' => $city_of_tax
            );
        }

        // build city array
        if ($area != '') {
            $area_of_tax = array();
            $area_of_tax = explode(',', $area);
            $area_array = array(
                'taxonomy' => 'property_area',
                'field' => 'term_id',
                'terms' => $area_of_tax
            );
        }

        if ($state != '') {
            $state_of_tax = array();
            $state_of_tax = explode(',', $state);
            $state_array = array(
                'taxonomy' => 'property_county_state',
                'field' => 'term_id',
                'terms' => $state_of_tax
            );
        }
        if ($status != '') {
            $state_of_tax = array();
            $state_of_tax = explode(',', $status);
            $status_array = array(
                'taxonomy' => 'property_status',
                'field' => 'term_id',
                'terms' => $state_of_tax
            );
        }



        $args = array(
            'post_type' => 'estate_property',
            'post_status' => 'publish',
            'paged' => 1,
            'fields' => 'ids',
            'posts_per_page' => intval(wpresidence_get_option('wp_estate_map_max_pins', '')),
            'tax_query' => array(
                $category_array,
                $action_array,
                $city_array,
                $area_array,
                $state_array,
                $status_array
            ),
        );

        $selected_pins = wpestate_listing_pins('full_shortcode', 1, $args, 1, '', ''); //call the new pins




        $is_contact = 'yes';
        $map_style_encoded = '';
        if (isset($attributes['is_elementor']) && $attributes['is_elementor'] == 1) {
            $map_style_encoded = $map_style;
        } else {
            $map_style_encoded = rawurldecode(base64_decode($map_style));
        }


        ob_start();

        include( locate_template('templates/google_maps_base.php') );
        $return_string = ob_get_contents();
        $return_string .= '<div id="wpestate_full_map_control_data"  data-zoom="' . $map_zoom . '"></div>';
        ob_end_clean();

        if (!wp_script_is('googlemap', 'enqueued')) {
            $is_map_shortcode = 1;
            wpestate_load_google_map();
        }




        if ($map_shortcode_for == 'contact') {
            $return_string .= '<script type="text/javascript">
                    //<![CDATA[
                    var is_map_shortcode=1;
                    var map_style_shortcode="";';
            if ($map_style_encoded != '') {
                $return_string .= ' map_style_shortcode=' . $map_style_encoded . ';';
            }

            $return_string .= 'jQuery(document).ready(function(){

                        if (typeof google === "object" && typeof google.maps === "object") {
                            google.maps.event.addDomListener(window, "load", wpresidence_initialize_map_contact);
                        }else{
                            wpresidence_initialize_map_contact_leaflet();
                             setTimeout(function(){map.invalidateSize();  },1000)
                        }
                    });
                    //]]>
                </script>';
        } else {
            $return_string .= '<script type="text/javascript">
                //<![CDATA[
                var is_map_shortcode=1;
                var map_style_shortcode="";';
            if ($map_style_encoded != '') {
                $return_string .= ' map_style_shortcode=' . $map_style_encoded . ';';
            }

            $return_string .= 'jQuery(document).ready(function(){
                    googlecode_regular_vars.generated_pins="0";
                    googlecode_regular_vars.markers=' . json_encode($selected_pins) . '
                    if (typeof google === "object" && typeof google.maps === "object") {
                        google.maps.event.addDomListener(window, "load", wpresidence_initialize_map);
                    }else{
             
                        wpresidence_initialize_map();
                        setTimeout(function(){map.invalidateSize();  },1000)
                    }
                });
                //]]>
            </script>';
        }


        return $return_string;
    }

endif;

if (!function_exists('wpestate_taxonomy_list')):

    function wpestate_taxonomy_list($attributes, $content = null) {
        $return_string = '<ul class="wpestate_term_list">';
        $taxonomy_list_type_array = array(
            'category' => 'property_category',
            'action category' => 'property_action_category',
            'city' => 'property_city',
            'area' => 'property_area',
            'county/state' => 'property_county_state',
            'status' => 'property_status',
            'features and ammenities' => 'property_features'
        );

        $attributes = shortcode_atts(
                array(
                    'taxonomy_list_type' => 'category',
                    'taxonomy_list_type_show' => 'yes'
                ), $attributes);

        if (isset($attributes['taxonomy_list_type'])) {
            $taxonomy_list_type = $attributes['taxonomy_list_type'];
        }
        if (isset($attributes['taxonomy_list_type_show'])) {
            $taxonomy_list_type_show = $attributes['taxonomy_list_type_show'];
        }

        $terms = get_terms(array(
            'taxonomy' => $taxonomy_list_type_array[$taxonomy_list_type],
            'hide_empty' => false,
        ));

        foreach ($terms as $item) {
            $return_string .= '<li><a href="' . get_term_link($item->term_id) . '">' . $item->name . '</a>';
            if ($taxonomy_list_type_show == 'yes') {
                $return_string .= '<span>' . $item->count . '</span>';
            }
            $return_string .= '</li>';
        }

        $return_string .= '</ul>';
        return $return_string;
    }

endif;

function wpestate_design_property_slider_2($ids_array) {

    wp_enqueue_script('owl_carousel');
    $counter = 0;
    $slides = '';
    $indicators = '';
    $prices = '';

    $ex_cont = '';
    $args = array(
        'post_type' => 'estate_property',
        'paged' => 1,
        'posts_per_page' => sizeof($ids_array),
        'post_status' => 'publish',
        'post__in' => $ids_array,
        'orderby' => 'post__in'
    );
    $recent_posts = new WP_Query($args);

    $return_string      = '';
    $wpestate_currency  = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
    $where_currency     = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));


    while ($recent_posts->have_posts()): $recent_posts->the_post();

        $theid      = get_the_ID();
        $preview    = wp_get_attachment_image_src(get_post_thumbnail_id($theid), 'listing_full_slider');
        if ($preview[0] == '') {
            $preview[0] = get_theme_file_uri('/img/defaults/default_property_featured.jpg');
        }

        $property_size      =   wpestate_get_converted_measure($theid, 'property_size');
        $property_bedrooms  =   get_post_meta($theid, 'property_bedrooms', true);
        $property_bathrooms =   get_post_meta($theid, 'property_bathrooms', true);
        $realtor_details    =   wpestate_return_agent_details($theid);
        $agent_id           =   $realtor_details['agent_id'];
        $agent_face         =   $realtor_details['agent_face_img'];
        $featured           =   intval(get_post_meta($theid, 'prop_featured', true));

        if ($counter == 0) {
            $active = " active ";
        } else {
            $active = " ";
        }

        $slides .= '
            <div class="item  '.$active.'" data-hash="item'.esc_attr($counter).'" data-href="'.esc_url(get_permalink()).'">
                <div class="image_div" style="background-image:url('.esc_url($preview[0]).');">
                    <div class="featured_gradient"></div>';

                    if ($featured == 1) {
                        $slides .= '<div class="featured_div">' . esc_html__('Featured', 'wpresidence-core') . '</div>';
                    }

                    $slides .= wpestate_return_property_status($theid);

                    $slides .= '<div class="featured_secondline">';
                        if ($agent_id != '') {
                            $slides .= '<div class="agent_face" style="background-image:url(' . esc_url($agent_face) . ')"></div>';
                        }
                        $slides .= '<a href="' . esc_url(get_permalink($agent_id)) . '">' . esc_html(get_the_title($agent_id)) . '</a>';
                    $slides .= '</div>';
                    
                $slides .= '</div>';


                $slides .= '<div class="property_slider2_info_wrapper">';
                        $slides .= '<div class="property_slider2_info_price">
                            '.wpestate_show_price($theid, $wpestate_currency, $where_currency, 1).'
                        </div>
                        <a href="' . esc_url(get_permalink($theid)) . '" target="_blank"><h2>' . get_the_title($theid) . '</h2></a>';



                        $slides .= ' <div class="property_slider_sec_row">';
                            if ($property_bedrooms != '') {
                                $slides .= '<div class="inforoom_unit_type5">' . esc_html($property_bedrooms) . ' ' . esc_html__('BD', 'wpresidence-core') . '</div>';
                            }

                            if ($property_bathrooms != '') {
                                $slides .= '<div class="inforoom_unit_type5">' . esc_html($property_bathrooms) . ' ' . esc_html__('BA', 'wpresidence-core') . '<span></span></div>';
                            }

                            if ($property_size != '') {
                                $slides .= '<div class="inforoom_unit_type5">' . trim($property_size) . '</div>'; //escaped above
                            }
                        $slides .= ' </div>';
        
                        
                        
                        
                          $slides .=  '<div class="property_slider2_content">' . wpestate_strip_excerpt_by_char(get_the_excerpt(), 170, $theid) . '</div>';
                $slides .= '</div>';
            $slides .= '</div>';

        $indicators .= '
            <a data-target="#estate-property_slider2" href="#item' . esc_attr($counter) . '" class="button secondary url ' . esc_attr($active) . '">
                ' . $ex_cont . '
            </a>';

        $counter++;

    endwhile;
    $return_string .= '<div class="property_slider2_wrapper owl-carousel owl-theme " id="estate-property_slider2" >';
    $return_string .= trim($slides);
   // $return_string .= '</div>';
    
    $return_string .= '<ol class="theme_slider_3_carousel-indicators">' . $indicators . '</ol>';
    
    $return_string .= '<script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready(function(){
               wpestate_property_slider_2();
            });
            //]]>
    </script>';

    $return_string .= '</div>';

    wp_reset_query();

    return $return_string;
}

/*
 * 
 * Properties Slider v1 
 * 
 * 
 * 
 * 
 * 
 * 
 * */

if (!function_exists('wpestate_slider_properties')):

    function wpestate_slider_properties($attributes, $content = null) {

        global $post;
        global $align;
        global $show_compare_only;
        global $wpestate_currency;
        global $where_currency;
        global $col_class;
        global $is_shortcode;
        global $row_number_col;
        global $wpestate_property_unit_slider;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;
        global $wpestate_prop_unit;

        $wpestate_custom_unit_structure = wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit = intval(wpresidence_get_option('wpestate_uset_unit', ''));
        $wpestate_currency = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
        $where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
        $show_compare_only = 'no';
        $return_string = '';
        $ids = '';
        $ids_array = array();

        global $current_user;
        global $curent_fav;
        $curent_fav = wpestate_return_favorite_listings_per_user();
        $title = '';

        $attributes = shortcode_atts(
                array(
                    'propertyid' => '',
                    'design_type' => 1,
                ), $attributes);

        $transient_ids = '';
        if (isset($attributes['propertyid'])) {
            $ids = $transient_ids = $attributes['propertyid'];
            $ids_array = explode(',', $ids);
        }

        if (isset($attributes['design_type'])) {
            $design_type = $attributes['design_type'];
        }


        if ($design_type == 2) {
          
            return wpestate_design_property_slider_2($ids_array);
        }


        $return_string .= '<div class="sections"><div class="facts">
                        <div class="facts__toggle">
                                <span class="facts__toggle-inner facts__toggle-inner--more">
                                    <span class="facts__toggle-text">' . esc_html__('see more facts', 'wpresidence-core') . '</span>
                                </span>
                                <span class="facts__toggle-inner facts__toggle-inner--less">
                                    <span class="facts__toggle-text">' . esc_html__('see less facts', 'wpresidence-core') . '</span>
                                </span>
                        </div>

                    </div>';

        $return_string .= '<!-- index -->
    <div class="sections__index">
            <span class="sections__index-current">
                 <span class="sections__index-inner">01</span>
            </span>
            <span class="sections__index-total">0' . sizeof($ids_array) . '</span>
    </div>';

        $return_string .= ' <nav class="sections__nav">
            <button class="sections__nav-item sections__nav-item--prev">

            </button>
            <button class="sections__nav-item sections__nav-item--next">

            </button>
    </nav>';
        $initial_section = ' section--current ';

        $templates = false;

        wp_enqueue_style('wpestate_sh5', get_theme_file_uri('/css/wpestate_sh5.css'), array(), '1.0', 'all');
        wp_enqueue_script('imagesloaded.pkgd.min', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), '1.0', false);
        wp_enqueue_script('charming.min', get_template_directory_uri() . '/js/charming.min.js"', array('jquery'), '1.0', false);
        wp_enqueue_script('anime.min', get_template_directory_uri() . '/js/anime.min.js', array('jquery'), '1.0', false);
        wp_enqueue_script('wpestate_featured5', get_template_directory_uri() . '/js/featured5.js', array('jquery', 'imagesloaded.pkgd.min', 'anime.min', 'charming.min'), '1.0', false);

        $args = array(
            'post_type' => 'estate_property',
            'paged' => 1,
            'posts_per_page' => sizeof($ids_array),
            'post_status' => 'publish',
            'post__in' => $ids_array,
            'orderby' => 'post__in'
        );

        if ($templates === false) {
            $recent_posts = new WP_Query($args);

            ob_start();
            while ($recent_posts->have_posts()): $recent_posts->the_post();
                $prop_id = get_the_ID();
                include( locate_template('templates/property_slider_shortcode.php') );
                $initial_section = '';
            endwhile;
            $templates = ob_get_contents();
            ob_end_clean();
        }




        $return_string .= $templates;
        $return_string .= '</div>';
        wp_reset_query();

        return $return_string;
    }

endif;

/*
 * 
 * Properties Slider v2 
 * 
 * 
 * 
 * 
 * 
 * 
 * */

if (!function_exists('wpestate_slider_properties_v2')):

    function wpestate_slider_properties_v2($attributes, $slider_id, $content = null) {

        wp_enqueue_script('owl_carousel');
        $return_string = '';
        $templates = '';
        $wpestate_custom_unit_structure = wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit = intval(wpresidence_get_option('wpestate_uset_unit', ''));
        $wpestate_currency = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
        $where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
        $curent_fav = wpestate_return_favorite_listings_per_user();

        $is_rtl = "no";
        if ($attributes['slider_orientation'] == '') {
            $is_rtl = 'yes';
        }


        $transient_ids = '';
        if (isset($attributes['propertyid']) && $attributes['propertyid'] != '') {

            $attributes = shortcode_atts(
                    array(
                        'propertyid' => '',
                    ), $attributes);

            $ids = $transient_ids = $attributes['propertyid'];
            $ids_array = explode(',', $ids);

            $args = array(
                'post_type' => 'estate_property',
                'paged' => 1,
                'posts_per_page' => sizeof($ids_array),
                'post_status' => 'publish',
                'post__in' => $ids_array,
                'orderby' => 'post__in'
            );
        } else {
            //
            $attributes = shortcode_atts(
                    array(
                        'title' => '',
                        'type' => 'properties',
                        'arrows' => 'top',
                        'category_ids' => '',
                        'action_ids' => '',
                        'city_ids' => '',
                        'area_ids' => '',
                        'state_ids' => '',
                        'status_ids' => '',
                        'number' => 7,
                        'show_featured_only' => 'no',
                        'autoscroll' => 0,
                        'sort_by' => 0,
                    ), $attributes);

            $shortcode_arguments = wpestate_prepare_arguments_shortcode($attributes);

            $args = wpestate_recent_posts_shortocodes_create_arg($shortcode_arguments);
        }

        $recent_posts = new WP_Query($args);

        $counter = 0;
        $active = "";

        ob_start();
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            $prop_id = get_the_ID();
            $counter++;
            if ($counter == 1) {
                $active = "active";
            }
            include( locate_template('templates/property_slider_shortcode_v2.php') );
        endwhile;
        $templates = ob_get_contents();
        ob_end_clean();

        $return_string .= '<div class="owl-carousel owl-theme property_slider_carousel_elementor_v2 slider_orientation_' . esc_attr($is_rtl) . ' " id="' . $slider_id . '" data-rtl="' . esc_attr($is_rtl) . '" data-auto="0">' . $templates . '</div>';

        wp_reset_query();

        return array(
            'return' => $return_string,
            'items' => $recent_posts->post_count);
    }

endif;

/*
 * 
 * Properties Slider v2 
 * 
 * 
 * 
 * 
 * 
 * 
 * */

if (!function_exists('wpestate_slider_properties_v3')):

    function wpestate_slider_properties_v3($attributes, $slider_id, $content = null) {

        wp_enqueue_script('owl_carousel');
        $return_string = '';
        $templates = '';
        $wpestate_custom_unit_structure = wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit = intval(wpresidence_get_option('wpestate_uset_unit', ''));
        $wpestate_currency = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
        $where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
        $curent_fav = wpestate_return_favorite_listings_per_user();

        $is_rtl = "no";
      

        $transient_ids = '';
        if (isset($attributes['propertyid']) && $attributes['propertyid'] != '') {

            $attributes = shortcode_atts(
                    array(
                        'propertyid' => '',
                    ), $attributes);

            $ids = $transient_ids = $attributes['propertyid'];
            $ids_array = explode(',', $ids);

            $args = array(
                'post_type' => 'estate_property',
                'paged' => 1,
                'posts_per_page' => sizeof($ids_array),
                'post_status' => 'publish',
                'post__in' => $ids_array,
                'orderby' => 'post__in'
            );
        } else {
            //
            $attributes = shortcode_atts(
                    array(
                        'title' => '',
                        'type' => 'properties',
                        'arrows' => 'top',
                        'category_ids' => '',
                        'action_ids' => '',
                        'city_ids' => '',
                        'area_ids' => '',
                        'state_ids' => '',
                        'status_ids' => '',
                        'number' => 7,
                        'show_featured_only' => 'no',
                        'autoscroll' => 0,
                        'sort_by' => 0,
                    ), $attributes);

            $shortcode_arguments = wpestate_prepare_arguments_shortcode($attributes);

            $args = wpestate_recent_posts_shortocodes_create_arg($shortcode_arguments);
        }

        $recent_posts = new WP_Query($args);

        $counter = 0;
        $active = "";
   
        ob_start();
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            $prop_id = get_the_ID();
            $counter++;
            if ($counter == 1) {
                $active = "active";
            }
            
            include( locate_template('templates/property_slider_shortcode_v3.php') );
        endwhile;
        $templates = ob_get_contents();
        ob_end_clean();?>

     <?php   $return_string .= '<div class="owl-carousel owl-theme property_slider_carousel_elementor_v3 slider_orientation_' . esc_attr($is_rtl) . ' " id="' . $slider_id . '" data-rtl="' . esc_attr($is_rtl) . '" data-auto="0">' . $templates . '</div>';

        wp_reset_query();

        return array(
            'return' => $return_string,
            'items' => $recent_posts->post_count);
    }

endif;

/*
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * */

function wpestate_insert_elementor($post_id) {
    if (!class_exists('Elementor\Plugin')) {
        return '';
    }


    $pluginElementor = \Elementor\Plugin::instance();
    $response = $pluginElementor->frontend->get_builder_content($post_id);

    return $response;
}

/*
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * */
if (!function_exists('wpestate_contact_us_form')):

    function wpestate_contact_us_form($attributes, $content = null) {
        $return_string = '';
        $text_align = '';
        $form_back_color = '';
        $form_text_color = '';
        $form_border_color = '';
        $form_button_size = '';

        $attributes = shortcode_atts(
                array(
                    'text_align' => 'left',
                    'form_back_color' => '',
                    'form_text_color' => '',
                    'form_border_color' => '',
                    'form_button_size' => 'normal',
                ), $attributes);

        if ($attributes['text_align']) {
            $text_align = $attributes['text_align'];
        }

        if ($attributes['form_back_color']) {
            $form_back_color = $attributes['form_back_color'];
        }
        if ($attributes['form_text_color']) {
            $form_text_color = $attributes['form_text_color'];
        }

        if ($attributes['form_border_color']) {
            $form_border_color = $attributes['form_border_color'];
        }

        if ($attributes['form_button_size']) {
            $form_button_size = $attributes['form_button_size'];
        }



        $custom_css = 'style="';
        if ($form_back_color != '') {
            $custom_css .= "color:" . $form_text_color . "!important;";
        }
        if ($form_back_color != '') {
            $custom_css .= "background:" . $form_back_color . "!important;";
        }

        if ($form_border_color != '') {
            $custom_css .= "border:1px solid " . $form_border_color . "!important;";
        }
        $custom_css .= '"';

        $return_string .= '<div class="shortcode_contact_form sh_form_align_' . $text_align . '">

       
            <div class="alert-message" id="footer_alert-agent-contact_sh"></div>
     

        <input type="text" ' . $custom_css . ' placeholder="' . esc_html__('Your Name', 'wpresidence-core') . '" required="required"   id="foot_contact_name_sh"  name="contact_name" class="form-control" value="" tabindex="373">
        <input type="email" ' . $custom_css . ' required="required" placeholder="' . esc_html__('Your Email', 'wpresidence-core') . '"  id="foot_contact_email_sh" name="contact_email" class="form-control wpestate-form-control-sh" value="" tabindex="374">
        <input type="email" ' . $custom_css . ' required="required" placeholder="' . esc_html__('Your Phone', 'wpresidence-core') . '"  id="foot_contact_phone_sh" name="contact_phone" class="form-control wpestate-form-control-sh" value="" tabindex="374">
        <textarea ' . $custom_css . ' placeholder="' . esc_html__('Type your message...', 'wpresidence-core') . '" required="required" id="foot_contact_content_sh" name="contact_content" class="form-control wpestate-form-control-sh" rows="4" tabindex="375"></textarea>
        <input type="hidden" name="contact_ajax_nonce"        id="agent_property_ajax_nonce"     value="'. wp_create_nonce('ajax-property-contact').'" />';

      
  
        $return_string .=       wpestate_check_gdpr_case();
       
        $return_string .= '  <div class="btn-cont">
            <button type="submit" id="btn-cont-submit_sh" class="wpresidence_button sh_but_' . $form_button_size . '">' . esc_html__('Send Message', 'wpresidence-core') . '</button>

            <input type="hidden" value="" name="contact_to">
            <div class="bottom-arrow"></div>
        </div>
    </div>';
        $return_string .= '<style>
    .shortcode_contact_form textarea::-webkit-input-placeholder,
    .shortcode_contact_form input::-webkit-input-placeholder {
     color:' . $form_text_color . '!important;";
}
</style><script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                  wpestate_contact_us_shortcode();
                });
                //]]>
            </script>';

        return $return_string;
    }

endif;

/*
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * */


if (!function_exists('wpestate_property_page_map_function')):


  function wpestate_property_page_map_function($attributes, $content = null) {
        global $post;
        $use_mimify = wpresidence_get_option('wp_estate_use_mimify', '');
        $mimify_prefix = '';
        if ($use_mimify === 'yes') {
            $mimify_prefix = '.min';
        }

        if (!wp_script_is('googlemap', 'enqueued')) {
            wpestate_load_google_map();
        }


        $return_string = '';
        $istab = 0;
        $attributes = shortcode_atts(
                array(
                    'propertyid' => '',
                    'istab' => '',
                ), $attributes);

        if (isset($attributes['propertyid'])) {
            $the_id = $propertyid = $attributes['propertyid'];
        }

        if (isset($attributes['istab'])) {
            $istab = $attributes['istab'];
        }

        if (isset($attributes['single_marker'])) {
            $nooflisting = $attributes['single_marker'];
        }


        $wpestate_currency = wpresidence_get_option('wp_estate_currency_symbol', '');
        $where_currency = wpresidence_get_option('wp_estate_where_currency_symbol', '');
        $title_orig = get_the_title($the_id);
        $title_orig = str_replace('%', '', $title_orig);
        $types = get_the_terms($the_id, 'property_category');
        if ($types && !is_wp_error($types)) {
            foreach ($types as $single_type) {
                $prop_type[] = $single_type->name; //$single_type->slug;
                $prop_type_name[] = $single_type->name;
                $slug = $single_type->slug;
                $parent_term = $single_type->parent;
            }

            $single_first_type = $prop_type[0];
            $single_first_type_pin = $prop_type[0];
            if ($parent_term != 0) {
                $single_first_type = $single_first_type . wpestate_add_parent_infobox($parent_term, 'property_category');
            }
            $single_first_type_name = $prop_type_name[0];
        } else {
            $single_first_type = '';
            $single_first_type_name = '';
            $single_first_type_pin = '';
        }


        $types_act = get_the_terms($the_id, 'property_action_category');
        if ($types_act && !is_wp_error($types_act)) {
            foreach ($types_act as $single_type) {
                $prop_action[] = $single_type->name; //$single_type->slug;
                $prop_action_name[] = $single_type->name;
                $slug = $single_type->slug;
                $parent_term = $single_type->parent;
            }
            $single_first_action = $prop_action[0];
            $single_first_action_pin = $prop_action[0];

            if ($parent_term != 0) {
                $single_first_action = $single_first_action . wpestate_add_parent_infobox($parent_term, 'property_action_category');
            }
            $single_first_action_name = $prop_action_name[0];
        } else {
            $single_first_action = '';
            $single_first_action_name = '';
            $single_first_action_pin = '';
        }


        if ($single_first_action == '' || $single_first_action == '') {
            $pin = sanitize_key(wpestate_limit54($single_first_type_pin . $single_first_action_pin));
        } else {
            $pin = sanitize_key(wpestate_limit27($single_first_type_pin)) . sanitize_key(wpestate_limit27($single_first_action_pin));
        }

        //// get price
        $price = floatval(get_post_meta($the_id, 'property_price', true));
        $price_label = esc_html(get_post_meta($the_id, 'property_label', true));
        $price_label_before = esc_html(get_post_meta($the_id, 'property_label_before', true));
        $clean_price = floatval(get_post_meta($the_id, 'property_price', true));
        if ($price == 0) {
            $price = $price_label_before . '' . $price_label;
            $pin_price = '';
        } else {
            $th_separator = stripslashes(wpresidence_get_option('wp_estate_prices_th_separator', ''));
            $pin_price = $price;

            $price = wpestate_format_number_price($price, $th_separator);

            if ($where_currency == 'before') {
                $price = $wpestate_currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $wpestate_currency;
            }

            if (wpresidence_get_option('wp_estate_use_price_pins_full_price', '') == 'no') {

                $pin_price = wpestate_price_pin_converter($pin_price, $where_currency, $wpestate_currency);
            } else {
                $pin_price == "<span class='infocur infocur_first'>" . $price_label_before . "</span>" . $price . "<span class='infocur'>" . $price_label . "</span>";
            }

            $price = "<span class='infocur infocur_first'>" . $price_label_before . "</span>" . $price . "<span class='infocur'>" . $price_label . "</span>";
        }

        $rooms = get_post_meta($the_id, 'property_bedrooms', true);
        $bathrooms = get_post_meta($the_id, 'property_bathrooms', true);

        $size = wpestate_get_converted_measure($the_id, 'property_size');

        $gmap_lat = esc_html(get_post_meta($propertyid, 'property_latitude', true));
        $gmap_long = esc_html(get_post_meta($propertyid, 'property_longitude', true));
        $property_add_on = ' data-post_id="' . $propertyid . '" data-cur_lat="' . $gmap_lat . '" data-cur_long="' . $gmap_long . '" ';
        $property_add_on .= ' data-title="' . $title_orig . '"  data-pin="' . $pin . '" data-thumb="' . rawurlencode(get_the_post_thumbnail($the_id, 'agent_picture_thumb')) . '" ';
        $property_add_on .= ' data-price="' . rawurlencode($price) . '" ';
        $property_add_on .= ' data-single-first-type="' . rawurlencode($single_first_type) . '"  data-single-first-action="' . rawurlencode($single_first_action) . '" ';
        $property_add_on .= ' data-rooms="' . rawurlencode($rooms) . '" data-size="' . rawurlencode($size) . '" data-bathrooms="' . rawurlencode($bathrooms) . '" ';
        $property_add_on .= ' data-prop_url="' . rawurlencode(esc_url(get_permalink($the_id))) . '" ';
        $property_add_on .= ' data-pin_price="' . rawurlencode($pin_price) . '" ';
        $property_add_on .= ' data-clean_price="' . rawurlencode($clean_price) . '" ';

        wpestate_load_google_map();
        $unique_id=rand(1,9999);
        $return_string = '<div class="google_map_shortcode_wrapper  ' . wpresidence_return_class_leaflet() . '">
                <div id="gmapzoomplus_sh_'.intval($unique_id).'"  class="smallslidecontrol gmapzoomplus_sh shortcode_control" ><i class="fas fa-plus"></i> </div>
                <div id="gmapzoomminus_sh_'.intval($unique_id).'" class="smallslidecontrol gmapzoomminus_sh shortcode_control" ><i class="fas fa-minus"></i></div>';
        $return_string .= wpestate_show_poi_onmap('sh');
        $return_string .= '<div id="slider_enable_street_sh_'.intval($unique_id).'" class="slider_enable_street_sh" data-placement="bottom" data-original-title="' . esc_html__('Street View', 'wpresidence-core') . '"> <i class="fas fa-location-arrow"></i>    </div>';
        $return_string .= '<div class="googleMap_shortcode_class" id="googleMap_shortcode_'.intval($unique_id).'" ' . $property_add_on . ' ></div></div>';

        if ($istab != 1) {
            
        }
        return $return_string;
    }

endif;

/*
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * */

if (!function_exists('wpestate_property_page_map_modal_function')):

    function wpestate_property_page_map_modal_function($the_id) {

        $use_mimify = wpresidence_get_option('wp_estate_use_mimify', '');
        $mimify_prefix = '';
        if ($use_mimify === 'yes') {
            $mimify_prefix = '.min';
        }

        if (!wp_script_is('googlemap', 'enqueued')) {
            wpestate_load_google_map();
        }


        $return_string = '';
        $istab = 0;

        $wpestate_currency = wpresidence_get_option('wp_estate_currency_symbol', '');
        $where_currency = wpresidence_get_option('wp_estate_where_currency_symbol', '');
        $title_orig = get_the_title($the_id);
        $title_orig = str_replace('%', '', $title_orig);
        $types = get_the_terms($the_id, 'property_category');
        if ($types && !is_wp_error($types)) {
            foreach ($types as $single_type) {
                $prop_type[] = $single_type->name; //$single_type->slug;
                $prop_type_name[] = $single_type->name;
                $slug = $single_type->slug;
                $parent_term = $single_type->parent;
            }

            $single_first_type = $prop_type[0];
            $single_first_type_pin = $prop_type[0];
            if ($parent_term != 0) {
                $single_first_type = $single_first_type . wpestate_add_parent_infobox($parent_term, 'property_category');
            }
            $single_first_type_name = $prop_type_name[0];
        } else {
            $single_first_type = '';
            $single_first_type_name = '';
            $single_first_type_pin = '';
        }


        $types_act = get_the_terms($the_id, 'property_action_category');
        if ($types_act && !is_wp_error($types_act)) {
            foreach ($types_act as $single_type) {
                $prop_action[] = $single_type->name; //$single_type->slug;
                $prop_action_name[] = $single_type->name;
                $slug = $single_type->slug;
                $parent_term = $single_type->parent;
            }
            $single_first_action = $prop_action[0];
            $single_first_action_pin = $prop_action[0];

            if ($parent_term != 0) {
                $single_first_action = $single_first_action . wpestate_add_parent_infobox($parent_term, 'property_action_category');
            }
            $single_first_action_name = $prop_action_name[0];
        } else {
            $single_first_action = '';
            $single_first_action_name = '';
            $single_first_action_pin = '';
        }


        if ($single_first_action == '' || $single_first_action == '') {
            $pin = sanitize_key(wpestate_limit54($single_first_type_pin . $single_first_action_pin));
        } else {
            $pin = sanitize_key(wpestate_limit27($single_first_type_pin)) . sanitize_key(wpestate_limit27($single_first_action_pin));
        }

        //// get price
        $price = floatval(get_post_meta($the_id, 'property_price', true));
        $price_label = esc_html(get_post_meta($the_id, 'property_label', true));
        $price_label_before = esc_html(get_post_meta($the_id, 'property_label_before', true));
        $clean_price = floatval(get_post_meta($the_id, 'property_price', true));
        if ($price == 0) {
            $price = $price_label_before . '' . $price_label;
            $pin_price = '';
        } else {
            $th_separator = stripslashes(wpresidence_get_option('wp_estate_prices_th_separator', ''));
            $pin_price = $price;

            $price = wpestate_format_number_price($price, $th_separator);

            if ($where_currency == 'before') {
                $price = $wpestate_currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $wpestate_currency;
            }

            if (wpresidence_get_option('wp_estate_use_price_pins_full_price', '') == 'no') {

                $pin_price = wpestate_price_pin_converter($pin_price, $where_currency, $wpestate_currency);
            } else {
                $pin_price == "<span class='infocur infocur_first'>" . $price_label_before . "</span>" . $price . "<span class='infocur'>" . $price_label . "</span>";
            }

            $price = "<span class='infocur infocur_first'>" . $price_label_before . "</span>" . $price . "<span class='infocur'>" . $price_label . "</span>";
        }

        $rooms = get_post_meta($the_id, 'property_bedrooms', true);
        $bathrooms = get_post_meta($the_id, 'property_bathrooms', true);
        $zoom = get_post_meta($the_id, 'page_custom_zoom', true);
        $size = wpestate_get_converted_measure($the_id, 'property_size');

        $gmap_lat = esc_html(get_post_meta($the_id, 'property_latitude', true));
        $gmap_long = esc_html(get_post_meta($the_id, 'property_longitude', true));
        $property_add_on = ' data-post_id="' . $the_id . '" data-cur_lat="' . $gmap_lat . '" data-cur_long="' . $gmap_long . '" data-prop-zoom="'.$zoom.'"';
        $property_add_on .= ' data-title="' . $title_orig . '"  data-pin="' . $pin . '" data-thumb="' . rawurlencode(get_the_post_thumbnail($the_id, 'agent_picture_thumb')) . '" ';
        $property_add_on .= ' data-price="' . rawurlencode($price) . '" ';
        $property_add_on .= ' data-single-first-type="' . rawurlencode($single_first_type) . '"  data-single-first-action="' . rawurlencode($single_first_action) . '" ';
        $property_add_on .= ' data-rooms="' . rawurlencode($rooms) . '" data-size="' . rawurlencode($size) . '" data-bathrooms="' . rawurlencode($bathrooms) . '" ';
        $property_add_on .= ' data-prop_url="' . rawurlencode(esc_url(get_permalink($the_id))) . '" ';
        $property_add_on .= ' data-pin_price="' . rawurlencode($pin_price) . '" ';
        $property_add_on .= ' data-clean_price="' . rawurlencode($clean_price) . '" ';

        wpestate_load_google_map();
        $unique_id=rand(1,9999);
        $return_string = '<div class="google_map_shortcode_wrapper  ' . wpresidence_return_class_leaflet() . '">
                <div id="gmapzoomplus_sh_'.intval($unique_id).'"  class="smallslidecontrol gmapzoomplus_sh shortcode_control" ><i class="fas fa-plus"></i> </div>
                <div id="gmapzoomminus_sh_'.intval($unique_id).'" class="smallslidecontrol gmapzoomminus_sh shortcode_control" ><i class="fas fa-minus"></i></div>';
        $return_string .= wpestate_show_poi_onmap('sh');
        $return_string .= '<div id="slider_enable_street_sh_'.intval($unique_id).'" class="slider_enable_street_sh" data-placement="bottom" data-original-title="' . esc_html__('Street View', 'wpresidence-core') . '"> <i class="fas fa-location-arrow"></i>    </div>';
        $return_string .= '<div class="googleMap_shortcode_class" id="googleMap_shortcode_'.intval($unique_id).'" ' . $property_add_on . ' ></div></div>';

        

      
        
        
        return $return_string;
    }

endif;

/*
 * 
 * 
 * shortcode - Listings per agent
 * 
 * 
 * 
 * 
 * */


if (!function_exists('wplistingsperagent_shortcode_function')):

    function wplistingsperagent_shortcode_function($attributes, $content = null) {
        global $post;
        global          $wpestate_property_unit_slider;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;
        $wpestate_property_unit_slider       =   wpresidence_get_option('wp_estate_prop_list_slider','');
        $wpestate_custom_unit_structure = wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit = intval(wpresidence_get_option('wpestate_uset_unit', ''));
        $wpestate_no_listins_per_row = intval(wpresidence_get_option('wp_estate_listings_per_row', ''));
        $return_string = '';

        $property_card_type = intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string = '';
        if ($property_card_type == 0) {
            $property_card_type_string = '';
        } else {
            $property_card_type_string = '_type' . $property_card_type;
        }

        $attributes = shortcode_atts(
                array(
                    'agentid' => '',
                    'nooflisting' => '',
                    'type' => 'estate_property',
                    'display_grid'=>'no'
                ), $attributes);

        if (isset($attributes['agentid'])) {
            $agentid = $attributes['agentid'];
        }

        if (isset($attributes['nooflisting'])) {
            $nooflisting = $attributes['nooflisting'];
        }
        if (isset($attributes['type'])) {
            $type = $attributes['type'];
        }

        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'meta_key' => 'prop_featured',
            'orderby' => 'meta_value',
            'order' => 'DESC',
            'paged' => 0,
            'posts_per_page' => $nooflisting,
            'meta_query' => array(
                array(
                    'key' => 'property_agent',
                    'value' => $agentid,
                    'compare' => '=',
                )
            )
        );
        global $row_number_col;
        global $is_shortcode;
        $is_shortcode = 1;
        $wpestate_no_listins_per_row = 3;
        $display_grid_class='';
        $row_number_col = 4;

            if( isset($attributes['display_grid'])){
               $display_grid=$attributes['display_grid'];
           }
           $full_row='';
           if($display_grid=='yes'){
                   $display_grid_class.= 'items_shortcode_wrapper_grid';
                   $row_number='x';
                   $rownumber='x';
                   $row_number_col='x';
                   $wpestate_row_number_col='x';
           }else{

                $display_grid_class.= 'items_shortcode_wrapper ';
                if($full_row==='yes'){
                    $display_grid_class.= ' items_shortcode_wrapper_full ';
                }
            

           }

    
    
    
        add_filter('posts_orderby', 'wpestate_my_order');
        $listings_per_agent = new WP_Query($args);
        remove_filter('posts_orderby', 'wpestate_my_order');
        ob_start();
        $unit_counter=1;

        while ($listings_per_agent->have_posts()): $listings_per_agent->the_post();
            if($display_grid=='yes'){
                print '<div class="shortcode_wrapper_grid_item shortcode_wrapper_grid_item">';
                $unit_counter++;
            }
            
            include( locate_template('templates/property_unit' . $property_card_type_string . '.php') );
            
            if($display_grid=='yes'){
                print '  </div>';
            }
            
        endwhile;

        $return_string = '<div class="article_container listings_flex '.esc_attr($display_grid_class).'">' . ob_get_contents() . '</div>';
        ob_end_clean();
        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
    }

endif;

/*
 * 
 * 
 * shortcode - agent list
 * 
 * 
 * 
 * 
 * */

if (!function_exists('wpestate_list_agents_function')):

    function wpestate_list_agents_function($attributes, $content = null) {
        global $options;
        global $align;
        global $align_class;
        global $post;
        global $wpestate_currency;
        global $where_currency;
        global $is_shortcode;
        global $show_compare_only;
        global $row_number_col;
        global $current_user;
        global $curent_fav;
        global $wpestate_property_unit_slider;

        // get_currentuserinfo();
        $current_user = wp_get_current_user();

        $title = '';
        if (isset($attributes['title'])) {
            $title = $attributes['title'];
        }

        $attributes = shortcode_atts(
                array(
                    'title' => '',
                    'type' => 'estate_agent',
                    'category_ids' => '',
                    'action_ids' => '',
                    'city_ids' => '',
                    'area_ids' => '',
                    'number' => 4,
                    'rownumber' => 4,
                    'align' => 'vertical',
                    'link' => '',
                    'random_pick' => 'no',
                    'order' => 'ASC',
                    'unit_type'=>1,
                     'display_grid'          =>  'no'
                ), $attributes);

        $userID = $current_user->ID;
        $user_option = 'favorites' . $userID;
        $curent_fav = get_option($user_option);
        $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider', '');

        $options = wpestate_page_details($post->ID);
        $return_string = '';
        $pictures = '';
        $button = '';
        $class = '';
        $category = $action = $city = $area = '';

        $wpestate_currency = esc_html(get_option('wp_estate_currency_symbol', ''));
        $where_currency = esc_html(get_option('wp_estate_where_currency_symbol', ''));
        $is_shortcode = 1;
        $show_compare_only = 'no';
        $row_number_col = '';
        $row_number = '';
        $show_featured_only = '';
        $random_pick = '';
        $orderby = 'ID';
        $transient_name = 'wpestate_sh_agent_list';
        $agent_unit = wpestate_agent_card_selector();
        $order='ASC';
        if (isset($attributes['order'])) {
            $order = $attributes['order'];
        }
        if( isset($attributes['display_grid'])){
            $display_grid=$attributes['display_grid'];
        }
      
        
        
        if (isset($attributes['category_ids'])) {
            $category = $attributes['category_ids'];
            $transient_name .= '_' . $category;
        }


        if (isset($attributes['action_ids'])) {
            $action = $attributes['action_ids'];
            $transient_name .= '_' . $action;
        }

        if (isset($attributes['city_ids'])) {
            $city = $attributes['city_ids'];
            $transient_name .= '_' . $city;
        }

        if (isset($attributes['area_ids'])) {
            $area = $attributes['area_ids'];
            $transient_name .= '_' . $area;
        }



        if (isset($attributes['random_pick'])) {
            $random_pick = $attributes['random_pick'];
            if ($random_pick === 'yes') {
                $orderby = 'rand';
                $transient_name .= '_rand';
            }
        }

        $post_number_total = $attributes['number'];
        if (isset($attributes['rownumber'])) {
            $row_number = $attributes['rownumber'];
        }

        // max 4 per row
        if ($row_number > 4) {
            $row_number = 4;
        }
        $transient_name .= '_row' . $row_number . '_' . $post_number_total;

        if ($row_number == 4) {
            $row_number_col = 3; // col value is 3
        } else if ($row_number == 3) {
            $row_number_col = 4; // col value is 4
        } else if ($row_number == 2) {
            $row_number_col = 6; // col value is 6
        } else if ($row_number == 1) {
            $row_number_col = 12; // col value is 12
            if ($attributes['align'] == 'vertical') {
                $row_number_col = 0;
            }
        }
        
        // to be used in agent unit
        $col_org= $row_number_col;
        $per_row_class='';
        $item_length='col-md-'.intval($col_org);

        $align = '';
        $align_class = '';
        if (isset($attributes['align']) && $attributes['align'] == 'horizontal') {
            $align = "col-md-12";
            $align_class = 'the_list_view';
            $row_number_col = '12';
        }



        $type = 'estate_agent';

        $category_array = '';
        $action_array = '';
        $city_array = '';
        $area_array = '';

        // build category array
        if ($category != '') {
            $category_of_tax = array();
            $category_of_tax = explode(',', $category);
            $category_array = array(
                'taxonomy' => 'property_category_agent',
                'field' => 'term_id',
                'terms' => $category_of_tax
            );
        }


        // build action array
        if ($action != '') {
            $action_of_tax = array();
            $action_of_tax = explode(',', $action);
            $action_array = array(
                'taxonomy' => 'property_action_category_agent',
                'field' => 'term_id',
                'terms' => $action_of_tax
            );
        }

        // build city array
        if ($city != '') {
            $city_of_tax = array();
            $city_of_tax = explode(',', $city);
            $city_array = array(
                'taxonomy' => 'property_city_agent',
                'field' => 'term_id',
                'terms' => $city_of_tax
            );
        }

        // build city array
        if ($area != '') {
            $area_of_tax = array();
            $area_of_tax = explode(',', $area);
            $area_array = array(
                'taxonomy' => 'property_area_agent',
                'field' => 'term_id',
                'terms' => $area_of_tax
            );
        }


        $meta_query = array();
        if ($show_featured_only == 'yes') {
            $compare_array = array();
            $compare_array['key'] = 'prop_featured';
            $compare_array['value'] = 1;
            $compare_array['type'] = 'numeric';
            $compare_array['compare'] = '=';
            $meta_query[] = $compare_array;
        }


        $args = array(
            'post_type' => 'estate_agent',
            'post_status' => 'publish',
            'paged' => 0,
            'posts_per_page' => $post_number_total,
            'orderby' => $orderby,
            'order' => $order,
            'tax_query' => array(
                $category_array,
                $action_array,
                $city_array,
                $area_array
            )
        );
        
        $wrap_class='';
        if($display_grid=='yes'){
            $wrap_class.=' article_container_grid ';
            $item_length='';
            $col_org = '';
        }
   
        if (isset($attributes['link']) && $attributes['link'] != '') {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">' . esc_html__('more agents', 'wpresidence-core') . ' </span></a>
               </div>';
        } else {
            $class = "nobutton";
        }

        $return_string .= '<div class="article_container bottom-' . esc_attr($type) . ' ' . esc_attr($class).' '.esc_attr($wrap_class). '" >';
        if ($title != '') {
            $return_string .= '<h2 class="shortcode_title">' . $title . '</h2>';
        }


        if (defined('ICL_LANGUAGE_CODE')) {
            $transient_name .= '_' . ICL_LANGUAGE_CODE;
        }

        $templates = false;
        if (function_exists('wpestate_request_transient_cache')) {
            $templates = wpestate_request_transient_cache($transient_name);
        }

        if ($templates === false || $random_pick == 'yes') {
            $recent_posts = new WP_Query($args);
 
            ob_start();
            if($display_grid=='yes'){
                print '<div class="items_shortcode_wrapper_grid"> ';
            }
            while ($recent_posts->have_posts()): $recent_posts->the_post();
                if($display_grid=='yes'){
                    print '<div class="shortcode_wrapper_grid_item shortcode_wrapper_grid_item">';
                }
                include( locate_template($agent_unit) ) ;   
                if($display_grid=='yes'){
                    print '</div>';
                }
            endwhile;
            if($display_grid=='yes'){
                print '</div>';
            }
            $templates = ob_get_contents();
            ob_end_clean();
            if ($random_pick != 'yes') {
                if (function_exists('wpestate_set_transient_cache')) {
                    wpestate_set_transient_cache($transient_name, wpestate_html_compress($templates), 60 * 60 * 24);
                }
            }
        }


        $return_string .= $templates;
        $return_string .= $button;
        $return_string .= '</div>';
        wp_reset_query();
        $is_shortcode = 0;
        return $return_string;
    }

endif; // end
////////////////////////////////////////////////////////////////////////////////////
/// wpestate_icon_container_function
////////////////////////////////////////////////////////////////////////////////////

if (!function_exists("wpestate_icon_container_function")):

    function wpestate_icon_container_function($attributes, $content = null) {
        $return_string = '';
        $link = '';
        $title = '';
        $image = '';
        $content_box = '';
        $haseffect = '';

        $title = '';
        if (isset($attributes['title'])) {
            $title = $attributes['title'];
        }



        $attributes = shortcode_atts(
                array(
                    'title' => 'title',
                    'image' => '',
                    'content_box' => 'Content of the box goes here',
                    'image_effect' => 'yes',
                    'link' => ''
                ), $attributes);

        if (isset($attributes['image'])) {
            $image = $attributes['image'];
        }
        if (isset($attributes['content_box'])) {
            $content_box = $attributes['content_box'];
        }

        if (isset($attributes['link'])) {
            $link = $attributes['link'];
        }

        if (isset($attributes['image_effect'])) {
            $haseffect = $attributes['image_effect'];
        }

        $return_string .= '<div class="iconcol">';
        if ($image != '') {
            $return_string .= '<div class="icon_img">';

            if ($haseffect == 'yes') {
                $return_string .= ' <div class="listing-cover"> </div>
                 <a href="' . $link . '"> <span class="listing-cover-plus">+</span> </a>';
            }
            $return_string .= '  <a href="' . $link . '"><img src="' . $image . '"  class="img-responsive" alt="thumb"/ ></a>
            </div>';
        }

        $return_string .= '<h3><a href="' . $link . '">' . $title . '</a></h3>';
        $return_string .= '<p>' . do_shortcode($content_box) . '</p>';
        $return_string .= '</div>';

        return $return_string;
    }

endif;

////////////////////////////////////////////////////////////////////////////////////
/// spacer
////////////////////////////////////////////////////////////////////////////////////

if (!function_exists("wpestate_spacer_shortcode_function")):

    function wpestate_spacer_shortcode_function($attributes, $content = null) {
        $height = '';
        $type = 1;

        $attributes = shortcode_atts(
                array(
                    'type' => '1',
                    'height' => '40',
                ), $attributes);

        if (isset($attributes['type'])) {
            $type = $attributes['type'];
        }

        if (isset($attributes['height'])) {
            $height = $attributes['height'];
        }


        $return_string = '';
        $return_string .= '<div class="spacer" style="height:' . $height . 'px;">';
        if ($type == 2) {
            $return_string .= '<span class="spacer_line"></span>';
        }
        $return_string .= '</div>';
        return $return_string;
    }

endif;

///////////////////////////////////////////////////////////////////////////////////////////
// font awesome function
///////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists("wpestate_font_awesome_function")):

    function wpestate_font_awesome_function($attributes, $content = null) {
        $icon = $attributes['icon'];
        $size = $attributes['size'];
        $return_string = '<i class="' . $icon . '" style="' . $size . '"></i>';
        return $return_string;
    }

endif;

///////////////////////////////////////////////////////////////////////////////////////////
// list items by ids function
///////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_list_items_by_id_function')):

    function wpestate_list_items_by_id_function($attributes, $content = null) {
        global $post;
        global $align;
        global $show_compare_only;
        global $wpestate_currency;
        global $where_currency;
        global $col_class;
        global $is_shortcode;
        global $row_number_col;
        global $wpestate_property_unit_slider;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;
        global $wpestate_prop_unit;

        $wpestate_custom_unit_structure = wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit = intval(wpresidence_get_option('wpestate_uset_unit', ''));
        $wpestate_no_listins_per_row = intval(wpresidence_get_option('wp_estate_listings_per_row', ''));
        $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider', '');
        $wpestate_currency = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
        $where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
        $show_compare_only = 'no';
        $return_string = '';
        $pictures = '';
        $button = '';
        $class = '';
        $rows = 1;
        $ids = '';
        $ids_array = array();
        $post_number = 1;
        $title = '';
        $is_shortcode = 1;
        $row_number = '';
        $wpestate_prop_unit = '';
        $blog_unit                   =   wpestate_blog_unit_selector(); 
        global $current_user;
        global $curent_fav;
        $curent_fav = wpestate_return_favorite_listings_per_user();
        $title = '';

        $property_card_type = intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string = '';
        if ($property_card_type == 0) {
            $property_card_type_string = '';
        } else {
            $property_card_type_string = '_type' . $property_card_type;
        }

        if (isset($attributes['title'])) {
            $title = $attributes['title'];
        }



        $attributes = shortcode_atts(
                array(
                    'title' => '',
                    'type' => 'properties',
                    'ids' => '',
                    'number' => 3,
                    'rownumber' => 4,
                    'align' => 'vertical',
                    'link' => '#',
                    'display_grid'          =>  'no'
                ), $attributes);

        $transient_ids = '';
        if (isset($attributes['ids'])) {
            $ids = $transient_ids = $attributes['ids'];
            $ids_array = explode(',', $ids);
        }

        if( isset($attributes['display_grid'])){
            $display_grid=$attributes['display_grid'];
        }

        $post_number_total = $attributes['number'];

        if (isset($attributes['rownumber'])) {
            $row_number = $attributes['rownumber'];
        }

        // max 4 per row
        if ($row_number > 4) {
            $row_number = 4;
        }

        if ($row_number == 4) {
            $row_number_col = 3; // col value is 3
        } else if ($row_number == 3) {
            $row_number_col = 4; // col value is 4
        } else if ($row_number == 2) {
            $row_number_col = 6; // col value is 6
        } else if ($row_number == 1) {
            $row_number_col = 12; // col value is 12
        }

        $align = '';
        if (isset($attributes['align']) && $attributes['align'] == 'horizontal') {
            $wpestate_prop_unit = 'list';
            $align = "col-md-12";
            $align_class = 'the_list_view';
            $row_number_col = '12';
        }

        if ($attributes['type'] == 'properties') {
            $type = 'estate_property';
        } else {
            $type = 'post';
        }

        if ($attributes['link'] != '') {
            if ($attributes['type'] == 'properties') {
                $button .= '<div class="listinglink-wrapper">
                           <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">' . esc_html__(' more listings', 'wpresidence-core') . ' </span></a>
                       </div>';
            } else {
                $button .= '<div class="listinglink-wrapper">
                           <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">' . esc_html__(' more articles', 'wpresidence-core') . '</span></a>
                        </div>';
            }
        } else {
            $class = "nobutton";
        }





        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'paged' => 0,
            'posts_per_page' => $post_number_total,
            'post__in' => $ids_array,
            'orderby' => 'post__in'
        );
        
        $wrap_class='';
        if($display_grid=='yes'){
            $wrap_class.=' article_container_grid';
        }
    

        $return_string .= '<div class="article_container '.esc_attr($wrap_class).' ">';
        if ($title != '') {
            $return_string .= '<h2 class="shortcode_title">' . $title . '</h2>';
        }
        
        
      
        $full_row='';
        $grid_class='';
        if($display_grid=='yes'){
            $grid_class.= "items_shortcode_wrapper_grid";
            $row_number='x';
            $rownumber='x';
            $row_number_col='x';
            $wpestate_row_number_col='x';
        }else{

            $grid_class.= 'items_shortcode_wrapper';
            if($full_row==='yes'){
                $grid_class.= ' items_shortcode_wrapper_full ';
            }

        }

        
        $return_string .= '<div class="wpestate_list_items_by_id_wrapper '.esc_attr($grid_class).'">';

        
        
        
        
        
        $transient_name = 'wpestate_list_items_by_id_' . $transient_ids;
        if (defined('ICL_LANGUAGE_CODE')) {
            $transient_name .= '_' . ICL_LANGUAGE_CODE;
        }
        if (isset($_COOKIE['my_custom_curr_symbol'])) {
            $transient_name .= '_' . $_COOKIE['my_custom_curr_symbol'];
        }
        if (isset($_COOKIE['my_measure_unit'])) {
            $transient_name .= $_COOKIE['my_measure_unit'];
        }



        $templates = false;
        if (function_exists('wpestate_request_transient_cache')) {
            $templates = wpestate_request_transient_cache($transient_name);
        }



        if ($templates === false) {
            $recent_posts = new WP_Query($args);
         $unit_counter=1;
            ob_start();
            while ($recent_posts->have_posts()): $recent_posts->the_post();
         
                if($display_grid=='yes'){
                    print '<div class="shortcode_wrapper_grid_item shortcode_wrapper_grid_item">';
                   $unit_counter++;
                }
        
            
                if ($type == 'estate_property') {
                    if (isset($attributes['align']) && $attributes['align'] == 'horizontal') {
                        $col_class = 'col-md-12';
                    }
                    include( locate_template('templates/property_unit' . $property_card_type_string . '.php') );
                } else {
                    include( locate_template($blog_unit) ) ;
                }
                
                if($display_grid=='yes'){
                    print '  </div>';
                }
            
            
            endwhile;

            $templates = ob_get_contents();
            ob_end_clean();
            if (function_exists('wpestate_set_transient_cache')) {
                wpestate_set_transient_cache($transient_name, wpestate_html_compress($templates), 4 * 60 * 60);
            }
        }




        $return_string .= $templates;
        $return_string .= $button;
        $return_string .= '</div></div>';
        wp_reset_query();
        $is_shortcode = 0;
        return $return_string;
    }

endif; // end   wpestate_list_items_by_id_function
///////////////////////////////////////////////////////////////////////////////////////////
// login form  function
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_login_form_function')):

    function wpestate_login_form_function($attributes, $content = null) {
        // get user dashboard link
        global $wpdb;
        $redirect = '';
        $mess = '';
        $allowed_html = array();

        $attributes = shortcode_atts(
                array(
                    'register_label' => '',
                    'register_url' => '',
                ), $attributes);

        $post_id = get_the_ID();
        $login_nonce = wp_nonce_field('login_ajax_nonce', 'security-login', true, false);
        $security_nonce = wp_nonce_field('forgot_ajax_nonce', 'security-forgot', true, false);
        $return_string = '<div class="login_form shortcode-login" id="login-div">
         <div class="loginalert" id="login_message_area" >' . $mess . '</div>

                <div class="loginrow">
                    <input type="text" class="form-control" name="log" id="login_user"  placeholder="' . esc_html__('Username', 'wpresidence-core') . '" size="20" />
                </div>
                <div class="loginrow password_holder">
                    <input type="password" class="form-control" name="pwd" id="login_pwd"  placeholder="' . esc_html__('Password', 'wpresidence-core') . '" size="20" />
                    <i class=" far fa-eye-slash show_hide_password"></i>
                     
                </div>
                <input type="hidden" name="loginpop" id="loginpop" value="0">

                <input type="hidden" id="security-login" name="security-login" value="' . estate_create_onetime_nonce('login_ajax_nonce') . '">


                <button id="wp-login-but" class="wpresidence_button">' . esc_html__('Login', 'wpresidence-core') . '</button>
                <div class="login-links shortlog">';

        if (isset($attributes['register_label']) && $attributes['register_label'] != '') {
            $return_string .= '<a href="' . $attributes['register_url'] . '">' . $attributes['register_label'] . '</a> | ';
        }
        $return_string .= '<a href="#" id="forgot_pass">' . esc_html__('Forgot Password?', 'wpresidence-core') . '</a>
                </div>';
        global $wpestate_social_login;
        if (class_exists('Wpestate_Social_Login')) {
            $return_string .= $wpestate_social_login->display_form('', 1);
        }
        $return_string .= '
         </div>
         <div class="login_form  shortcode-login" id="forgot-pass-div-sh">
            <div class="loginalert" id="forgot_pass_area"></div>
            <div class="loginrow">
                    <input type="text" class="form-control" name="forgot_email" id="forgot_email" placeholder="' . esc_html__('Enter Your Email Address', 'wpresidence-core') . '" size="20" />
            </div>
            ' . $security_nonce . '
            <input type="hidden" id="postid" value="' . $post_id . '">
            <button class="wpresidence_button" id="wp-forgot-but" name="forgot" >' . esc_html__('Reset Password', 'wpresidence-core') . '</button>
            <div class="login-links shortlog">
            <a href="#" id="return_login">' . esc_html__('Return to Login', 'wpresidence-core') . '</a>
            </div>
         </div>

            ';
        return $return_string;
    }

endif; // end   wpestate_login_form_function
///////////////////////////////////////////////////////////////////////////////////////////
// register form  function
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_register_form_function')):

    function wpestate_register_form_function($attributes, $content = null) {

        $register_nonce = wp_nonce_field('register_ajax_nonce', 'security-register', true, false);
        $return_string = '
          <div class="login_form shortcode-login">
               <div class="loginalert" id="register_message_area" ></div>

                <div class="loginrow">
                    <input type="text" name="user_login_register" id="user_login_register" class="form-control"  placeholder="' . esc_html__('Username', 'wpresidence-core') . '" size="20" />
                </div>
                <div class="loginrow">
                    <input type="email" name="user_email_register" id="user_email_register" class="form-control" placeholder="' . esc_html__('Email', 'wpresidence-core') . '" size="20" />
                </div>';

        $enable_user_pass_status = esc_html(wpresidence_get_option('wp_estate_enable_user_pass', ''));
        if ($enable_user_pass_status == 'yes') {
            $return_string .= '
                    <div class="loginrow password_holder">
                        <input type="password" name="user_password" id="user_password" class="form-control" placeholder="' . esc_html__('Password', 'wpresidence-core') . '"/>
                        <i class=" far fa-eye-slash show_hide_password"></i>
                    </div>
                    <div class="loginrow password_holder">
                        <input type="password" name="user_password_retype" id="user_password_retype" class="form-control" placeholder="' . esc_html__('Retype Password', 'wpresidence-core') . '"  />
                        <i class=" far fa-eye-slash show_hide_password"></i>
                    </div>
                    ';
        }
        if (1 == 1) {
            if (function_exists('wpestate_user_types_list_array')) {
                $user_types = wpestate_user_types_list_array();
            }

            $permited_roles = wpresidence_get_option('wp_estate_visible_user_role');
            $visible_user_role_dropdown = wpresidence_get_option('wp_estate_visible_user_role_dropdown');

            if ($visible_user_role_dropdown == 'yes') {
                $return_string .= '<select id="new_user_type" name="new_user_type" class="form-control" >';
                $return_string .= '<option value="0">' . esc_html__('Select User Type', 'wpresidence-core') . '</option>';
                foreach ($user_types as $key => $name) {
                    if (is_array($permited_roles) && in_array($name, $permited_roles)) {
                        $return_string .= '<option value="' . esc_attr($key + 1) . '">' . esc_html($name) . '</option>';
                    }
                }
                $return_string .= '</select>';
            }
        }

        $return_string .= '
                <input type="checkbox" name="terms" id="user_terms_register_sh">
                <label id="user_terms_register_sh_label" for="user_terms_register_sh">' . esc_html__('I agree with ', 'wpresidence-core') . '<a href="' . wpestate_get_template_link('terms_conditions.php') . '" target="_blank" id="user_terms_register_topbar_link">' . esc_html__('terms & conditions', 'wpresidence-core') . '</a> </label>';

        if (wpresidence_get_option('wp_estate_use_captcha', '') == 'yes') {
            $return_string .= '<div id="shortcode_register_menu"  style="float: left;margin-top: 10px;transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>';
        }


        if ($enable_user_pass_status != 'yes') {
            $return_string .= '<p id="reg_passmail">' . esc_html__('A password will be e-mailed to you', 'wpresidence-core') . '</p>';
        }

        $return_string .= '
                <input type="hidden" id="security-register" name="security-register" value="' . estate_create_onetime_nonce('register_ajax_nonce_sh') . '">

                <p class="submit">
                    <button id="wp-submit-register"  class="wpresidence_button">' . esc_html__('Register', 'wpresidence-core') . '</button>
                </p>

        </div>

    ';
        return $return_string;
    }

endif; // end   wpestate_register_form_function
///////////////////////////////////////////////////////////////////////////////////////////
/// featured article
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_featured_article')):

    function wpestate_featured_article($attributes, $content = null) {
        $return_string = '';
        $article = 0;
        $second_line = '';

        $attributes = shortcode_atts(
                array(
                    'id' => '',
                    'second_line' => '',
                    'design_type' => 1
                ), $attributes);

        if (isset($attributes['id'])) {
            $article = intval($attributes['id']);
        }

        if (isset($attributes['second_line'])) {
            $second_line = $attributes['second_line'];
        }

        if (isset($attributes['design_type'])) {
            $desgin_type = $attributes['design_type'];
        }


        $args = array('post_type' => 'post',
            'p' => $article
        );

        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
            while ($my_query->have_posts()) {
                $my_query->the_post();
                $thumb_id = get_post_thumbnail_id($article);
                $preview = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_featured');
                $previewh = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_featured');

                if (!isset($preview[0]) || $preview[0] == '') {
                    $previewh[0] = $preview[0] = WPESTATE_PLUGIN_DIR_URL . '/img/default_property_featured.jpg';
                }

                $avatar = wpestate_get_avatar_url(get_avatar(get_the_author_meta('email'), 55));
                $content = get_the_excerpt();
                $title = get_the_title();
                $link = esc_url(get_permalink());

                if ($desgin_type == 1) {
                    $return_string .= '
                <div class="featured_article">


                    <div class="featured_img">
                        <a href="' . $link . '"> <img src="' . $preview[0] . '" data-original="' . $preview[0] . '" alt="featured image" class="lazyload img-responsive" /></a>

                    </div>

                    <div class="featured_article_title" data-link="' . $link . '">
                        <div class="blog_author_image" style="background-image: url(' . esc_url($avatar) . ');"></div>
                        <h2 class="featured_type_2"> <a href="' . esc_url($link) . '">';
                    $title = get_the_title();
                    $return_string .= mb_substr($title, 0, 35);
                    if (mb_strlen($title) > 35) {
                        $return_string .= '...';
                    }

                    $return_string .= '</a></h2>
                        <div class="featured_article_secondline">' . $second_line . '</div>
                   

                        <div class="featured_article_content">
                        ' . $content . '
                        </div>
                    </div>

                 </div>';
                } else if ($desgin_type == 2) {
                    $preview = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                    $return_string .= '<div class="featured_article_type2">
                       <div class="featured_img_type2" style="background-image:url(' . $preview[0] . ')">

                            <div class="featured_gradient"></div>
                            <div class="featured_article_type2_title_wrapper">
                                <div class="featured_article_label">' . esc_html__('Featured Article', 'wpresidence-core') . '</div>
                                <h2>' . $title . '</h2>
                                <div class="featured_read_more"><a href="' . $link . '">' . esc_html__('read more', 'wpresidence-core') . '</a> <i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }

        wp_reset_query();
        wp_reset_postdata();
        return $return_string;
    }

endif; // end   featured_article


if (!function_exists('wpestate_get_avatar_url')):

    function wpestate_get_avatar_url($get_avatar) {
        preg_match("/src='(.*?)'/i", $get_avatar, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return'';
        }
    }

endif; // end   wpestate_get_avatar_url
////////////////////////////////////////////////////////////////////////////////////
/// featured property
////////////////////////////////////////////////////////////////////////////////////


if (!function_exists('wpestate_featured_property')):

    function wpestate_featured_property($attributes, $content = null) {
        $return_string = '';
        $prop_id = '';
        $design_type = '';

        $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider', '');
        $attributes = shortcode_atts(
                array(
                    'id' => '',
                    'sale_line' => '',
                    'design_type' => 1
                ), $attributes);

        if (isset($attributes['id'])) {
            $prop_id = $attributes['id'];
        }

        if (isset($attributes['design_type'])) {
            $design_type = $attributes['design_type'];
        }


        $sale_line = '';
        if (isset($attributes['sale_line'])) {
            $sale_line = $attributes['sale_line'];
        }

        $transient_name = 'wpestate_featured_prop_' . $prop_id;
        if (defined('ICL_LANGUAGE_CODE')) {
            $transient_name .= '_' . ICL_LANGUAGE_CODE;
        }
        if (isset($_COOKIE['my_custom_curr_symbol'])) {
            $transient_name .= '_' . $_COOKIE['my_custom_curr_symbol'];
        }
        if (isset($_COOKIE['my_measure_unit'])) {
            $transient_name .= $_COOKIE['my_measure_unit'];
        }
        $transient_name .= '_type' . $design_type;

        $return_string = false;
        if (function_exists('wpestate_request_transient_cache')) {
            $return_string = wpestate_request_transient_cache($transient_name);
        }


        if ($return_string === false) {
            $args = array('post_type' => 'estate_property',
                'post_status' => 'publish',
                'p' => $prop_id
            );

            $my_query = new WP_Query($args);
            if ($my_query->have_posts()) {
                ob_start();
                while ($my_query->have_posts()) {
                    $my_query->the_post();

                    if ($design_type == 1) {
                        include( locate_template('templates/featured_property_1.php') );
                    } else if ($design_type == 2) {
                        include( locate_template('templates/featured_property_2.php') );
                    } else if ($design_type == 3) {
                        include( locate_template('templates/featured_property_3.php') );
                    } else if ($design_type == 4) {
                        include( locate_template('templates/featured_property_4b.php') );
                    } else if ($design_type == 5) {
                        include( locate_template('templates/featured_property_5.php') );
                    }
                }
                $return_string = ob_get_contents();
                ob_end_clean();
            }

            wp_reset_query();
            if (function_exists('wpestate_set_transient_cache')) {
                wpestate_set_transient_cache($transient_name, wpestate_html_compress($return_string), 60 * 60 * 4);
            }
        }


        return $return_string;
    }

endif; // end   wpestate_featured_property
////////////////////////////////////////////////////////////////////////////////////
/// featured agent
////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_featured_agent')):

    function wpestate_featured_agent($attributes, $content = null) {
        global $notes;
        $return_string = '';
        $notes = '';

        $attributes = shortcode_atts(
                array(
                    'id' => 0,
                    'notes' => '',
                ), $attributes);

        $agent_id = $attributes['id'];

        if (isset($attributes['notes'])) {
            $notes = $attributes['notes'];
        }

        $args = array(
            'post_type' => 'estate_agent',
            'p' => $agent_id
        );

        $my_query = new WP_Query($args);
        ob_start();
        while ($my_query->have_posts()): $my_query->the_post();
            include( locate_template('templates/agent_card_templates/agent_unit_featured.php') );
        endwhile;
        $return_string = ob_get_contents();
        ob_end_clean();
        wp_reset_query();
        return $return_string;
    }

endif; // end   wpestate_featured_agent
////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - recent post with picture
////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_recent_posts_pictures')):

    function wpestate_recent_posts_pictures($attributes, $content = null) {
        global $options;
        global $align;
        global $align_class;
        global $post;
        global $wpestate_currency;
        global $where_currency;
        global $is_shortcode;
        global $show_compare_only;
        global $row_number_col;
        global $current_user;
        global $curent_fav;
        global $wpestate_property_unit_slider;
        global $wpestate_no_listins_per_row;
        global $wpestate_uset_unit;
        global $wpestate_custom_unit_structure;

        $wpestate_custom_unit_structure = wpresidence_get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit = intval(wpresidence_get_option('wpestate_uset_unit', ''));
        $wpestate_no_listins_per_row = intval(wpresidence_get_option('wp_estate_listings_per_row', ''));
        $blog_unit                   =   wpestate_blog_unit_selector(); 
        $current_user = wp_get_current_user();

        $title = '';
        if (isset($attributes['title'])) {
            $title = $attributes['title'];
        }

        $attributes = shortcode_atts(
                array(
                    'title' => '',
                    'type' => 'properties',
                    'category_ids' => '',
                    'action_ids' => '',
                    'city_ids' => '',
                    'area_ids' => '',
                    'state_ids' => '',
                    'number' => 4,
                    'rownumber' => 4,
                    'align' => 'vertical',
                    'link' => '',
                    'show_featured_only' => 'no',
                    'random_pick' => 'no',
                    'featured_first' => 'no'
                ), $attributes);

        $userID = $current_user->ID;
        $user_option = 'favorites' . $userID;
        $curent_fav = get_option($user_option);
        $wpestate_property_unit_slider = wpresidence_get_option('wp_estate_prop_list_slider', '');

        $options = wpestate_page_details_sh($post->ID);
        $return_string = '';
        $pictures = '';
        $button = '';
        $class = '';
        $category = $action = $city = $area = $state = '';

        $wpestate_currency = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
        $where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
        $is_shortcode = 1;
        $show_compare_only = 'no';
        $row_number_col = '';
        $row_number = '';
        $show_featured_only = '';
        $random_pick = '';
        $featured_first = '';
        $orderby = 'meta_value';

        $property_card_type = intval(wpresidence_get_option('wp_estate_unit_card_type'));
        $property_card_type_string = '';
        if ($property_card_type == 0) {
            $property_card_type_string = '';
        } else {
            $property_card_type_string = '_type' . $property_card_type;
        }

        if (isset($attributes['category_ids'])) {
            $category = $attributes['category_ids'];
        }

        if (isset($attributes['action_ids'])) {
            $action = $attributes['action_ids'];
        }

        if (isset($attributes['city_ids'])) {
            $city = $attributes['city_ids'];
        }

        if (isset($attributes['area_ids'])) {
            $area = $attributes['area_ids'];
        }

        if (isset($attributes['state_ids'])) {
            $state = $attributes['state_ids'];
        }

        if (isset($attributes['show_featured_only'])) {
            $show_featured_only = $attributes['show_featured_only'];
        }

        if (isset($attributes['random_pick'])) {
            $random_pick = $attributes['random_pick'];
            if ($random_pick === 'yes') {
                $orderby = 'rand';
            }
        }


        if (isset($attributes['featured_first'])) {
            $featured_first = $attributes['featured_first'];
        }


        $post_number_total = $attributes['number'];
        if (isset($attributes['rownumber'])) {
            $row_number = $attributes['rownumber'];
        }

        // max 4 per row
        if ($row_number > 4) {
            $row_number = 4;
        }

        if ($row_number == 4) {
            $row_number_col = 3; // col value is 3
        } else if ($row_number == 3) {
            $row_number_col = 4; // col value is 4
        } else if ($row_number == 2) {
            $row_number_col = 6; // col value is 6
        } else if ($row_number == 1) {
            $row_number_col = 12; // col value is 12
            if ($attributes['align'] == 'vertical') {
                $row_number_col = 0;
            }
        }

        $align = '';
        $align_class = '';
        if (isset($attributes['align']) && $attributes['align'] == 'horizontal') {
            $align = "col-md-12";
            $align_class = 'the_list_view';
            $row_number_col = '12';
        }


        if ($attributes['type'] == 'properties') {
            $type = 'estate_property';

            $category_array = '';
            $action_array = '';
            $city_array = '';
            $area_array = '';
            $state_array = '';

            // build category array
            if ($category != '') {
                $category_of_tax = array();
                $category_of_tax = explode(',', $category);
                $category_array = array(
                    'taxonomy' => 'property_category',
                    'field' => 'term_id',
                    'terms' => $category_of_tax
                );
            }


            // build action array
            if ($action != '') {
                $action_of_tax = array();
                $action_of_tax = explode(',', $action);
                $action_array = array(
                    'taxonomy' => 'property_action_category',
                    'field' => 'term_id',
                    'terms' => $action_of_tax
                );
            }

            // build city array
            if ($city != '') {
                $city_of_tax = array();
                $city_of_tax = explode(',', $city);
                $city_array = array(
                    'taxonomy' => 'property_city',
                    'field' => 'term_id',
                    'terms' => $city_of_tax
                );
            }

            // build city array
            if ($area != '') {
                $area_of_tax = array();
                $area_of_tax = explode(',', $area);
                $area_array = array(
                    'taxonomy' => 'property_area',
                    'field' => 'term_id',
                    'terms' => $area_of_tax
                );
            }

            if ($state != '') {
                $state_of_tax = array();
                $state_of_tax = explode(',', $state);
                $state_array = array(
                    'taxonomy' => 'property_county_state',
                    'field' => 'term_id',
                    'terms' => $state_of_tax
                );
            }
            $meta_query = array();
            if ($show_featured_only == 'yes') {
                $compare_array = array();
                $compare_array['key'] = 'prop_featured';
                $compare_array['value'] = 1;
                $compare_array['type'] = 'numeric';
                $compare_array['compare'] = '=';
                $meta_query[] = $compare_array;
            }

            if ($featured_first == "no") {
                $orderby = 'ID';
            }

            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'paged' => 1,
                'posts_per_page' => $post_number_total,
                'meta_key' => 'prop_featured',
                'orderby' => $orderby,
                'order' => 'DESC',
                'meta_query' => $meta_query,
                'tax_query' => array(
                    $category_array,
                    $action_array,
                    $city_array,
                    $area_array,
                    $state_array
                )
            );
        } else {
            $type = 'post';

            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'paged' => 0,
                'posts_per_page' => $post_number_total,
                'cat' => $category
            );
        }


        if (isset($attributes['link']) && $attributes['link'] != '') {
            if ($attributes['type'] == 'properties') {
                $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">' . esc_html__('more listings', 'wpresidence-core') . ' </span></a>
               </div>';
            } else {
                $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">  ' . esc_html__('more articles', 'wpresidence-core') . ' </span></a>
               </div>';
            }
        } else {
            $class = "nobutton";
        }

        if ($attributes['type'] != 'properties') {
            $class .= " blogs_wrapper ";
        }

        if ($attributes['type'] == 'properties') {
            if ($random_pick !== 'yes') {
                if ($featured_first == 'yes') {
                    add_filter('posts_orderby', 'wpestate_my_order');
                }

                $recent_posts = new WP_Query($args);
                $count = 1;
                if ($featured_first == 'yes') {
                    remove_filter('posts_orderby', 'wpestate_my_order');
                }
            } else {

                $args['orderby'] = 'rand';
                $recent_posts = new WP_Query($args);
                $count = 1;
            }
        } else {
            $recent_posts = new WP_Query($args);
            $count = 1;
        }

        $return_string .= '<div class="article_container bottom-' . $type . ' ' . $class . '" >';
        if ($title != '') {
            $return_string .= '<h2 class="shortcode_title">' . $title . '</h2>';
        }

        ob_start();
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            if ($type == 'estate_property') {
                include( locate_template('templates/property_unit' . $property_card_type_string . '.php') );
            } else {
                include( locate_template($blog_unit) ) ;
            }
        endwhile;

        $templates = ob_get_contents();
        ob_end_clean();
        $return_string .= $templates;
        $return_string .= $button;
        $return_string .= '</div>';
        wp_reset_query();
        $is_shortcode = 0;
        return $return_string;
    }

endif; // end   wpestate_recent_posts_pictures


if (!function_exists('wpestate_limit_words')):

    function wpestate_limit_words($string, $max_no) {
        $words_no = explode(' ', $string, ($max_no + 1));

        if (count($words_no) > $max_no) {
            array_pop($words_no);
        }

        return implode(' ', $words_no);
    }

endif; // end   wpestate_limit_words
////////////////////////////////////////////////////////////////////////////////////////////////////////////////..
///  shortcode - testimonials
////////////////////////////////////////////////////////////////////////////////////////////////////////////////..


if (!function_exists('wpestate_testimonial_function')):

    function wpestate_testimonial_function($attributes, $content = null) {
        $return_string = '';
        $title_client = '';
        $client_name = '';
        $imagelinks = '';
        $testimonial_text = '';
        $type = 1;
        $stars_client = '';
        $testimonial_title = '';
        $attributes = shortcode_atts(
                array(
                    'client_name' => 'Name Here',
                    'title_client' => "happy client",
                    'imagelinks' => '',
                    'testimonial_text' => '',
                    'testimonial_type' => '1',
                    'stars_client' => '5',
                    'testimonial_title' => ''
                ), $attributes);

        if ($attributes['client_name']) {
            $client_name = $attributes['client_name'];
        }

        if ($attributes['title_client']) {
            $title_client = $attributes['title_client'];
        }

        if ($attributes['imagelinks']) {
            $imagelinks = $attributes['imagelinks'];
        }

        if ($attributes['testimonial_text']) {
            $testimonial_text = $attributes['testimonial_text'];
        }

        if ($attributes['testimonial_type']) {
            $type = 'type_class_' . $attributes['testimonial_type'];
        }
        if ($attributes['stars_client']) {
            $stars_client = floatval($attributes['stars_client']);
        }
        if ($attributes['testimonial_title']) {
            $testimonial_title = $attributes['testimonial_title'];
        }




        if ($type == 'type_class_1') {
            $return_string .= '     <div class="testimonial-container ' . $type . ' ">';
            $return_string .= '     <div class="testimonial-image" style="background-image:url(' . $imagelinks . ')"></div>';
            $return_string .= '     <div class="testimonial-text">' . $testimonial_text . '</div>';
            $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name . '</span>, ' . $title_client . ' </div>';
            $return_string .= '     </div>';
        } else if ($type == 'type_class_2') {
            $return_string .= '     <div class="testimonial-container ' . $type . ' ">';
            $return_string .= '     <div class="testimonial-text">' . $testimonial_text . '</div>';
            $return_string .= '     <div class="testimonial-image" style="background-image:url(' . $imagelinks . ')"></div>';
            $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name . '</span>, ' . $title_client . ' </div>';
            $return_string .= '     </div>';
        } else if ($type == 'type_class_3') {
            $return_string .= '     <div class="testimonial-container ' . $type . ' ">';
            $return_string .= '     <div class="testimonial-image" style="background-image:url(' . $imagelinks . ')"></div>';
            $return_string .= '     <div class="testimonial_title">' . $testimonial_title . '</div>';

            $return_string .= '     <div class="testimmonials_starts">' . wpestate_starts_reviews_core($stars_client) . '</div>';
            $return_string .= '     <div class="testimonial-text">' . $testimonial_text . '</div>';

            $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name . '</span>, ' . $title_client . ' </div>';
            $return_string .= '     </div>';
        } else if ($type == 'type_class_4') {
            $return_string .= '     <div class="testimonial-container ' . $type . ' ">';
            $return_string .= '     <div class="testimonial-image" style="background-image:url(' . $imagelinks . ')"></div>';
            $return_string .= '     <div class="testimonial-author-line">' . $client_name . ' </div>';
            $return_string .= '     <div class="testimonial-location-line"> ' . $title_client . ' </div>';

            $return_string .= '     <div class="testimonial-text">' . $testimonial_text . '</div>';
            $return_string .= '     <div class="testimmonials_starts">' . wpestate_starts_reviews_core($stars_client) . '</div>';

            $return_string .= '     </div>';
        }





        return $return_string;
    }

endif; // end   wpestate_testimonial_function


if (!function_exists('wpestate_testimonial_function2')):

    function wpestate_testimonial_function2($attributes, $content = null) {
        $return_string = '';
        $title_client = '';
        $client_name = '';
        $imagelinks = '';
        $testimonial_text = '';
        $type = 1;
        $stars_client = '';
        $testimonial_title = '';
        $attributes = shortcode_atts(
                array(
                    'client_name' => 'Name Here',
                    'title_client' => "happy client",
                    'imagelinks' => '',
                    'testimonial_text' => '',
                    'testimonial_type' => '1',
                    'stars_client' => '5',
                    'testimonial_title' => ''
                ), $attributes);

        if ($attributes['client_name']) {
            $client_name = $attributes['client_name'];
        }

        if ($attributes['title_client']) {
            $title_client = $attributes['title_client'];
        }

        if ($attributes['imagelinks']) {
            $imagelinks = $attributes['imagelinks'];
        }

        if ($attributes['testimonial_text']) {
            $testimonial_text = $attributes['testimonial_text'];
        }

        if ($attributes['testimonial_type']) {
            $type = 'type_class_' . $attributes['testimonial_type'];
        }
        if ($attributes['stars_client']) {
            $stars_client = floatval($attributes['stars_client']);
        }
        if ($attributes['testimonial_title']) {
            $testimonial_title = $attributes['testimonial_title'];
        }




        if ($type == 'type_class_1') {
            $return_string .= '     <div class="testimonial-container ' . $type . ' ">';
            $return_string .= '     <div class="testimonial-image" style="background-image:url(' . $imagelinks . ')"></div>';
            $return_string .= '     <div class="testimonial-text">' . $testimonial_text . '</div>';
            $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name . '</span>, ' . $title_client . ' </div>';
            $return_string .= '     </div>';
        } else if ($type == 'type_class_2') {
            $return_string .= '     <div class="testimonial-container ' . $type . ' ">';
            $return_string .= '     <div class="testimonial-text">' . $testimonial_text . '</div>';
            $return_string .= '     <div class="testimonial-image" style="background-image:url(' . $imagelinks . ')"></div>';
            $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name . '</span>, ' . $title_client . ' </div>';
            $return_string .= '     </div>';
        } else if ($type == 'type_class_3') {
            $return_string .= '     <div class="testimonial-container ' . $type . ' ">';
            $return_string .= '     <div class="testimonial-image" style="background-image:url(' . $imagelinks . ')"></div>';
            $return_string .= '     <div class="testimonial_title">' . $testimonial_title . '</div>';

            $return_string .= '     <div class="testimmonials_starts">' . wpestate_starts_reviews_core($stars_client) . '</div>';
            $return_string .= '     <div class="testimonial-text">' . $testimonial_text . '</div>';

            $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name . '</span>, ' . $title_client . ' </div>';
            $return_string .= '     </div>';
        }





        print $return_string;
    }

endif; // end   wpestate_testimonial_function

function wpestate_starts_reviews_core($stars) {
    $stars=floatval($stars);
    $whole = floor($stars);
    $fraction = $stars - $whole;
    $return_string = '';

    for ($i = 1; $i <= $whole; $i++) {
        $return_string .= '<i class="fas fa-star"></i>';
    }
    if ($fraction > 0) {
        $return_string .= '<i class="fas fa-star-half"></i>';
    }
    return $return_string;
}

if (!function_exists('wpestate_testimonial_slider_function_gutenberg')):

    function wpestate_testimonial_slider_function_gutenberg($attributes, $content = null) {
        $return_string = '';
        $title = '';
        $visible_items = '';
        $slider_types = '';
        $attributes = shortcode_atts(
                array(
                    'title' => '',
                    'visible_items' => '1',
                    'slider_types' => '1',
                ), $attributes);

        wp_enqueue_script('slick.min');

        if ($attributes['title']) {
            $title = $attributes['title'];
        }

        if ($attributes['visible_items']) {
            $visible_items = $attributes['visible_items'];
        }

        if ($attributes['slider_types']) {
            $slider_types = $attributes['slider_types'];
        }


        $return_string .= '<div class="testimonial-slider-container container_type_' . $slider_types . '" data-visible-items="' . $visible_items . '" data-auto="0">';
        $return_string .= $title . $content;
        $return_string .= '</div>';

        $return_string .= '<script type="text/javascript">
                //<![CDATA[

                jQuery(document).ready(function(){
                   wpestate_enable_slick_testimonial();
                });
                //]]>
            </script>';

        return $return_string;
    }

endif; // end   wpestate_testimonial_function


if (!function_exists('wpestate_testimonial_slider_function')):

    function wpestate_testimonial_slider_function($attributes, $content = null) {
        $return_string = '';
        $title = '';
        $visible_items = '';
        $slider_types = '';
        $attributes = shortcode_atts(
                array(
                    'title' => '',
                    'visible_items' => '1',
                    'slider_types' => '1',
                ), $attributes);

        wp_enqueue_script('slick.min');
        if ($attributes['title']) {
            $title = $attributes['title'];
        }

        if ($attributes['visible_items']) {
            $visible_items = $attributes['visible_items'];
        }

        if ($attributes['slider_types']) {
            $slider_types = $attributes['slider_types'];
        }


        $return_string .= '<div class="testimonial-slider-container container_type_' . $slider_types . '" data-visible-items="' . $visible_items . '" data-auto="0">';
        $return_string .= $title . do_shortcode($content);
        $return_string .= '</div>';

        $return_string .= '<script type="text/javascript">
                //<![CDATA[

                jQuery(document).ready(function(){
                   wpestate_enable_slick_testimonial();
                });
                //]]>
            </script>';

        return $return_string;
    }

endif; // end   wpestate_testimonial_function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - reccent post function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_recent_posts_function')):

    function wpestate_recent_posts_function($attributes, $heading = null) {
        $return_string = '';
        extract(shortcode_atts(array(
            'posts' => 1,
                        ), $attributes));

        query_posts(array('orderby' => 'date', 'order' => 'DESC', 'showposts' => $posts));
        $return_string = '<div id="recent_posts"><ul><h3>' . $heading . '</h3>';
        if (have_posts()) :
            while (have_posts()) : the_post();
                $return_string .= '<li><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></li>';
            endwhile;
        endif;

        $return_string .= '</div></ul>';
        wp_reset_query();

        return $return_string;
    }

endif; // end   wpestate_recent_posts_function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - memerbership packages function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_membership_packages_function')):

    function wpestate_membership_packages_function($atts, $content = null) {
        $package_id = '';
        $pack_featured_sh = array('no', 'yes');
        $package_content = '';
        $return_string = '';

        $attributes = shortcode_atts(
                array(
                    'package_id' => '',
                    'pack_featured_sh' => 'no',
                    'package_content' => ''
                ), $atts);

        if (isset($attributes['package_id'])) {
            $package_id = $attributes['package_id'];
        }
        if (isset($attributes['pack_featured_sh'])) {
            $pack_featured_sh = $attributes['pack_featured_sh'];
        }
        if (isset($attributes['package_content'])) {
            if (is_array($attributes['package_content'])) {
                $package_content = $attributes['package_content'][0];
            } else {
                $package_content = $attributes['package_content'];
            }
        }



        if ($pack_featured_sh == 'yes') {
            $pack_featured_sh = 'featured_pack_sh';
        } else {
            $pack_featured_sh = '';
        }

        $pack_price = get_post_meta($package_id, 'pack_price', true);
        $biling_period = get_post_meta($package_id, 'biling_period', true);
        $billing_freq = get_post_meta($package_id, 'billing_freq', true);
        $pack_image_included = get_post_meta($package_id, 'pack_image_included', true);
        $pack_featured = get_post_meta($package_id, 'pack_featured_listings', true);
        $wpestate_currency = esc_html(wpresidence_get_option('wp_estate_submission_curency', ''));
        $where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));
        if ($billing_freq > 1) {
            $biling_period .= 's';
        }




        switch (strtolower($biling_period)) {
            case 'day':
                $biling_period = esc_html__('Day', 'wpresidence-core');
                break;
            case 'days':
                $biling_period = esc_html__('Days', 'wpresidence-core');
                break;
            case 'week':
                $biling_period = esc_html__('Week', 'wpresidence-core');
                break;
            case 'weeks':
                $biling_period = esc_html__('Weeks', 'wpresidence-core');
                break;
            case 'month':
                $biling_period = esc_html__('Month', 'wpresidence-core');
                break;
            case 'months':
                $biling_period = esc_html__('Months', 'wpresidence-core');
                break;
            case 'year':
                $biling_period = esc_html__('Year', 'wpresidence-core');
                break;
            case 'years':
                $biling_period = esc_html__('Years', 'wpresidence-core');
                break;
        }






        if (intval($pack_image_included) == 0) {
            $pack_image_included = esc_html__('Unlimited', 'wpresidence-core');
        }


        $pack_list = get_post_meta($package_id, 'pack_listings', true);
        $unlimited_listings = get_post_meta($package_id, 'mem_list_unl', true);
        if ($unlimited_listings == 1) {
            $unlimited_listings_sh = '<div><strong>' . esc_html__('Unlimited', 'wpresidence-core') . ' </strong> ' . esc_html__('Listings', 'wpresidence-core') . ' </div>';
        } else {
            $unlimited_listings_sh = '<div>' .sprintf(_n( '<strong> %s</strong> Listing', '<strong>%s</strong> Listings', $pack_list, 'wpresidence-core' ),number_format_i18n($pack_list)). ' </div>';
        }

        $wpestate_currency = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
        $where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));

        $link = wpestate_get_template_link('user_dashboard_profile.php');
        $link = add_query_arg('packet', $package_id, $link);
        $return_string .= '<div class="membership_package_product ' . $pack_featured_sh . '">'
                . '<div class="pack-price_title"><h4>' . get_the_title($package_id) . '</h4></div>'
                . '<div class="pack-price_sh">' . wpestate_show_price_floor($pack_price, $wpestate_currency, $where_currency, 1) . '</div>'
                . '<div class="pack_content">' . $package_content . '</div>'
                . '<div class="pack-bill_freg_sh"><strong>' . $billing_freq . '</strong> ' . $biling_period . '</div>'
                . '<div class="pack-listing_sh"> ' . $unlimited_listings_sh . '</div>'
                . '<div class="pack-listing-period_sh"><strong> ' . $pack_image_included . '</strong>  ' . esc_html__('Images / listing', 'wpresidence-core') . '</div> '
                . '<div class="pack-listing_feat_sh">'. sprintf( _n( '<strong> %s</strong> Featured Listing', '<strong>%s</strong> Featured Listings', $pack_featured, 'wpresidence-core' ),number_format_i18n($pack_featured)). '</div> '
                . '<div class="buy_package_sh"><a href="' . $link . '" class="wpresidence_button';
        if ($pack_featured_sh == '') {
            $return_string .= ' wpresidence_button_inverse ';
        }
        $return_string .= '">' . esc_html__('Get started', 'wpresidence-core') . '</a></div>'
                . '</div>';

        return '<div class="">' . $return_string . '</div>';
    }

endif; //end memerbership packages function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - featured user role function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_featured_user_role_shortcode')):

    function wpestate_featured_user_role_shortcode($atts, $content = null) {
        $user_role_id = '';
        $status = '';
        $return_string = '';
        $user_shortcode_imagelink = '';

        $attributes = shortcode_atts(
                array(
                    'user_role_id' => '',
                    'status' => '',
                    'user_shortcode_imagelink' => ''
                ), $atts);

        if (isset($attributes['user_role_id'])) {
            $user_role_id = $attributes['user_role_id'];
        }

        if (isset($attributes['status'])) {
            $status = $attributes['status'];
        }
        if (isset($attributes['user_shortcode_imagelink'])) {
            $user_shortcode_imagelink = $attributes['user_shortcode_imagelink'];
        }

        $post = get_post($user_role_id);
        $user_id = get_post_meta($post->ID, 'user_meda_id', true);
        $user_role = get_user_meta($user_id, 'user_estate_role', true);

        if ($user_role == 3 || get_post_type($user_role_id) == 'estate_agency') {
            $agency_phone = esc_html(get_post_meta($user_role_id, 'agency_phone', true));
            $agent_email = esc_html(get_post_meta($user_role_id, 'agency_email', true));
        } else {
            $agency_phone = esc_html(get_post_meta($user_role_id, 'developer_phone', true));
            $agent_email = esc_html(get_post_meta($user_role_id, 'developer_email', true));
        }



        $return_string .= '<div class="user_role_unit">'
                . '<div class="featured_user_role_unit_details">'
                . '<div class="user_role_status">' . $status . '</div>'
                . '<div class="user_role_image" style="background-image:url(' . wp_get_attachment_thumb_url(get_post_thumbnail_id($user_role_id)) . ')"></div>'
                . '<h4><a href="' . esc_url(get_permalink($user_role_id)) . '">' . get_the_title($user_role_id) . '</a></h4>'
                . '<div class="user_role_phone"><i class="fas fa-phone"></i> <a href="tel:' . urlencode($agency_phone) . '">' . $agency_phone . '</a></div>'
                . '<div class="user_role_email"><i class="far fa-envelope"></i> <a href="mailto:' . esc_html($agent_email) . '">' . esc_html($agent_email) . '</a></div>'
                . '<div class="user_role_content">' . wpestate_strip_excerpt_by_char($post->post_content, 180, $user_role_id) . '</div>'
                . '<a class="wpresidence_button button_user_role" href="' . esc_url(get_permalink($user_role_id)) . '">' . esc_html__('View Profile', 'wpresidence-core') . '</a>'
                . '</div>'
                . '<div class="user_role_featured_image">'
                . '<div class="user_role" style="background-image:url(' . $user_shortcode_imagelink . ')"></div>'
                . '<div class="prop_new_details"><div class="prop_new_details_back"></div></div>'
                . '</div>'
                . '</div>';

        wp_reset_query();
        return $return_string;
    }

endif; // end   featured user role function




if (!function_exists('wpestate_page_details_sh')):

    function wpestate_page_details_sh($post_id) {

        $return_array = array();

        if ($post_id != '' && !is_home() && !is_tax()) {
            $sidebar_name = esc_html(get_post_meta($post_id, 'sidebar_select', true));
            $sidebar_status = esc_html(get_post_meta($post_id, 'sidebar_option', true));
        } else {
            $sidebar_name = esc_html(wpresidence_get_option('wp_estate_blog_sidebar_name', ''));
            $sidebar_status = esc_html(wpresidence_get_option('wp_estate_blog_sidebar', ''));
        }

        if ('estate_agent' == get_post_type() && $sidebar_name == '' & $sidebar_status == '') {
            $sidebar_status = esc_html(wpresidence_get_option('wp_estate_agent_sidebar', ''));
            $sidebar_name = esc_html(wpresidence_get_option('wp_estate_agent_sidebar_name', ''));
        }

        if ($post_id != '') {
            if ('estate_property' == get_post_type() && ($sidebar_status == '' || $sidebar_status == 'global' )) {
                $sidebar_status = esc_html(wpresidence_get_option('wp_estate_property_sidebar', ''));
                $sidebar_name = esc_html(wpresidence_get_option('wp_estate_property_sidebar_name', ''));
            }
        }


        if ('' == $sidebar_name) {
            $sidebar_name = 'primary-widget-area';
        }
        if ('' == $sidebar_status) {
            $sidebar_status = 'right';
        }



        if ('left' == $sidebar_status) {
            $return_array['content_class'] = 'col-md-9 col-md-push-3 rightmargin';
            $return_array['sidebar_class'] = 'col-md-3 col-md-pull-9 ';
        } else if ($sidebar_status == 'right') {
            $return_array['content_class'] = 'col-md-9 rightmargin';
            $return_array['sidebar_class'] = 'col-md-3';
        } else {
            $return_array['content_class'] = 'col-md-12';
            $return_array['sidebar_class'] = 'none';
        }

        $return_array['sidebar_name'] = $sidebar_name;

        return $return_array;
    }

endif; // end   wpestate_page_details
?>
