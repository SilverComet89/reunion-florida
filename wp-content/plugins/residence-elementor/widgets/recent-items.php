<?php
namespace ElementorWpResidence\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


class Wpresidence_Recent_Items extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'WpResidence_Items_List';
    }

    public function get_categories()
    {
        return [ 'wpresidence' ];
    }


    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('WpResidence Items List', 'residence-elementor');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-posts-masonry';
    }



    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return [ '' ];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    public function elementor_transform($input)
    {
        $output=array();
        if (is_array($input)) {
            foreach ($input as $key=>$tax) {
                $output[$tax['value']]=$tax['label'];
            }
        }
        return $output;
    }


    protected function register_controls()
    {
        global $all_tax;

        $all_tax_elemetor=$this->elementor_transform($all_tax);



        $property_category_values       =   wpestate_generate_category_values_shortcode();
        $property_city_values           =   wpestate_generate_city_values_shortcode();
        $property_area_values           =   wpestate_generate_area_values_shortcode();
        $property_county_state_values   =   wpestate_generate_county_values_shortcode();
        $property_action_category_values=   wpestate_generate_action_values_shortcode();
        $property_status_values         =   wpestate_generate_status_values_shortcode();


        $property_category_values           =   $this->elementor_transform($property_category_values);
        $property_city_values               =   $this->elementor_transform($property_city_values);
        $property_area_values               =   $this->elementor_transform($property_area_values);
        $property_county_state_values       =   $this->elementor_transform($property_county_state_values);
        $property_action_category_values    =   $this->elementor_transform($property_action_category_values);
        $property_status_values             =   $this->elementor_transform($property_status_values);



        $featured_listings  =   array('no'=>'no','yes'=>'yes');
        $items_type         =   array('properties'=>'properties','articles'=>'articles','agents'=>'agents');
        $alignment_type     =   array('vertical'=>'vertical','horizontal'=>'horizontal');

        $sort_options = array();
        if( function_exists('wpestate_listings_sort_options_array')){
          $sort_options			= wpestate_listings_sort_options_array();
        }

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'residence-elementor'),
            ]
        );

        $this->add_control(
            'title_residence',
            [
                'label' => __('Title', 'residence-elementor'),
                              'type' => Controls_Manager::TEXT,
                                'Label Block'

            ]
        );

        $this->add_control(
            'type',
            [
                            'label' => __('What type of items', 'residence-elementor'),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'properties',
                            'options' => $items_type
            ]
        );

        $this->add_control(
            'control_terms_id',
            [
                            'label' => __('List of terms for the filter bar (*applies only for properties, not articles/posts)', 'residence-elementor'),
                            'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'default' => '',
                            'options' => $all_tax_elemetor,
            ]
        );

        $this->add_control(
            'number',
            [
                            'label' => __('No of items', 'residence-elementor'),
                            'type' => Controls_Manager::TEXT,
                            'default'=>9,
            ]
        );

        $this->add_control(
            'rownumber',
            [
                'label' => __('No of items per row', 'residence-elementor'),
                'type' => Controls_Manager::TEXT,
                'default'=>3,
            ]
        );


        $this->add_control(
            'align',
            [
                            'label' => __('What type of property alignment ?', 'residence-elementor'),
                    'condition' => [
                        'type' => 'properties'
                    ],
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'vertical',
                            'options' => $alignment_type
            ]
        );

        $this->add_control(
            'random_pick',
            [
                            'label' => __('Random Pick ?', 'residence-elementor'),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'no',
                            'options' => $featured_listings
            ]
        );


        $this->add_control(
            'sort_by',
            [
                            'label' => __('Sort By ?', 'residence-elementor'),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 0,
                            'options' => $sort_options
            ]
        );

        $this->add_control(
                'display_grid',
                [
                    'label' => esc_html__('Display as grid ?', 'residence-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'residence-elementor'),
                    'label_off' => esc_html__('No', 'residence-elementor'),
                    'return_value' => 'yes',
                    'default' => esc_html__('No', 'residence-elementor'),
                    'description'=> esc_html__('There is no fixed number of units. The grid will auto adjust to display units with a minimum width set by the control below.?', 'residence-elementor'),
                ]
        );

        $this->add_responsive_control(
                'display_grid_unit_width',
                [
                    'label' => esc_html__('Unit Minimum Width', 'residence-elementor'),
                    'condition' => [
                        'display_grid' => 'yes'
                    ],
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 220,
                            'max' => 400,
                        ],
                    ],
                    'devices' => ['desktop', 'tablet', 'mobile'],
                    'desktop_default' => [
                        'size' => '250',
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => '250',
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => '250',
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .items_shortcode_wrapper_grid' => '  grid-template-columns: repeat(auto-fit, minmax({{SIZE}}{{UNIT}}, auto));',
                    ],
                    
                ]
        );

        $this->add_responsive_control(
                'display_grid_unit_gap',
                [
                    'label' => esc_html__('Gap between units in px', 'residence-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'condition' => [
                        'display_grid' => 'yes'
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'devices' => ['desktop', 'tablet', 'mobile'],
                    'desktop_default' => [
                        'size' => '10',
                        'unit' => 'px',
                    ],
                    'tablet_default' => [
                        'size' => '10',
                        'unit' => 'px',
                    ],
                    'mobile_default' => [
                        'size' => '10',
                        'unit' => 'px',
                    ],
                    'default' => [
					'unit' => 'px',
					'size' => 10,
				],
                    'selectors' => [
                        '{{WRAPPER}} .items_shortcode_wrapper_grid' => 'gap: {{SIZE}}{{UNIT}};',
                    ],
                ]
        );

        $this->end_controls_section();


        /*
        * Start filters
        */
        $this->start_controls_section(
                   'filters_section',
                   [
                       'label'     => esc_html__( 'Filters', 'residence-elementor' ),
                       'tab'       => Controls_Manager::TAB_CONTENT,
                   ]
               );





        $this->add_control(
            'category_ids',
            [
                            'label' => __('List of categories (*only for properties)', 'residence-elementor'),
                            'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'default'=>'',
                            'options' => $property_category_values,
            ]
        );

        $this->add_control(
            'action_ids',
            [
                            'label' => __('List of action categories (*only for properties)', 'residence-elementor'),
                             'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'default'=>'',
                            'options' => $property_action_category_values,
            ]
        );

        $this->add_control(
            'city_ids',
            [
                            'label' => __('List of city  (*only for properties)', 'residence-elementor'),
                             'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'default'=>'',
                            'options' => $property_city_values,
            ]
        );
        $this->add_control(
            'area_ids',
            [
                            'label' => __('List of areas (*only for properties)', 'residence-elementor'),
                             'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'default'=>'',
                            'options' => $property_area_values,
            ]
        );
        $this->add_control(
            'state_ids',
            [
                            'label' => __('List of Counties/States (*only for properties)', 'residence-elementor'),
                            'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                              'default'=>'',
                            'options' => $property_county_state_values,
            ]
        );

        $this->add_control(
            'status_ids',
            [
                            'label' => __('List of Property Status (*only for properties)', 'residence-elementor'),
                            'label_block'=>true,
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'default'=>'',
                            'options' => $property_status_values,
            ]
        );


        $this->add_control(
            'show_featured_only',
            [
                            'label' => __('Show featured listings only?', 'residence-elementor'),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'no',
                            'options' => $featured_listings
            ]
        );


        $this->end_controls_section();
        
        
        
        /*
         * Box Shadow
         */
        
        $this->start_controls_section(
        'section_grid_box_shadow', [
        'label' => esc_html__('Box Shadow', 'residence-elementor'),
        'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(), [
            'name' => 'box_shadow',
            'label' => esc_html__('Box Shadow', 'residence-elementor'),
            'selector' => '{{WRAPPER}} .property_listing, {{WRAPPER}} .agent_unit, {{WRAPPER}} .property_listing_blog',
                ]
        );

        $this->end_controls_section();
  
     
                      /*
              *-------------------------------------------------------------------------------------------------
              * Start typography section
              */
              $this->start_controls_section(
                         'typography_section',
                         [
                             'label'     => esc_html__( 'Typography', 'residence-elementor' ),
                             'tab'       => Controls_Manager::TAB_STYLE,
                         ]
                     );

                     $this->add_group_control(
                         Group_Control_Typography::get_type(),
                         [
                             'name'     => 'property_title',
                             'label'    => esc_html__( 'Title', 'residence-elementor' ),
                             'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                             'selector' => '{{WRAPPER}} .property_listing h4, {{WRAPPER}} .blog2v h4, {{WRAPPER}} .agent_unit h4',
                         ]
                     );

                     $this->add_group_control(
                         Group_Control_Typography::get_type(),
                         [
                             'name'     => 'property_address',
                             'label'    => esc_html__( 'Address', 'residence-elementor' ),
                           'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                             'selector' => '{{WRAPPER}} .property_location_image',
                         ]
                     );

                     $this->add_group_control(
                         Group_Control_Typography::get_type(),
                         [
                             'name'     => 'property_info',
                             'label'    => esc_html__( 'Info Text', 'residence-elementor' ),
                            'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                             'selector' => '{{WRAPPER}} .property_listing_details span, {{WRAPPER}} .blog_unit_meta, {{WRAPPER}} .agent_position',
                         ]
                     );

                     $this->add_group_control(
                         Group_Control_Typography::get_type(),
                         [
                             'name'     => 'propert_price',
                             'label'    => esc_html__( 'Price', 'residence-elementor' ),
                            'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                             'selector' => '{{WRAPPER}} .listing_unit_price_wrapper',
                         ]
                     );

                     $this->add_group_control(
                         Group_Control_Typography::get_type(),
                         [
                             'name'     => 'propert_price_label',
                             'label'    => esc_html__( 'Price Label', 'residence-elementor' ),
                         'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                             'selector' => '{{WRAPPER}} .price_label',
                         ]
                     );

                     $this->add_group_control(
                         Group_Control_Typography::get_type(),
                         [
                             'name'     => 'property_description',
                             'label'    => esc_html__( 'Description', 'residence-elementor' ),
                            'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                             'selector' => '{{WRAPPER}} .listing_details, {{WRAPPER}} .agent_card_content, {{WRAPPER}} .property_listing_blog ',
                         ]
                     );



                     $this->add_group_control(
                         Group_Control_Typography::get_type(),
                         [
                             'name'     => 'details_button',
                             'label'    => esc_html__( 'Detail Link', 'residence-elementor' ),
                           'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                             'selector' => '{{WRAPPER}} .unit_details_x, {{WRAPPER}} .blog2v .read_more ' ,
                         ]
                     );

                     $this->add_group_control(
                         Group_Control_Typography::get_type(),
                         [
                             'name'     => 'property_agent',
                             'label'    => esc_html__( 'Agent', 'residence-elementor' ),
                             'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                             'selector' => '{{WRAPPER}} .property_agent_wrapper a,.property_agent_wrapper',
                         ]
                     );

                    $this->end_controls_section();

              /*
              *-------------------------------------------------------------------------------------------------
              * End typography section
              */
        
    }
    
    
    
    
    
    

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */

    public function wpresidence_send_to_shortcode($input)
    {
        $output='';
        if ($input!=='') {
            $numItems = count($input);
            $i = 0;

            foreach ($input as $key=>$value) {
                $output.=$value;
                if (++$i !== $numItems) {
                    $output.=', ';
                }
            }
        }
        return $output;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();


        $attributes['title']                =   $settings['title_residence'];
        $attributes['type']                 =   $settings['type'];
        $attributes['category_ids']         =   $this -> wpresidence_send_to_shortcode($settings['category_ids']);
        $attributes['action_ids']           =   $this -> wpresidence_send_to_shortcode($settings['action_ids']);
        $attributes['city_ids']             =   $this -> wpresidence_send_to_shortcode($settings['city_ids']);
        $attributes['area_ids']             =   $this -> wpresidence_send_to_shortcode($settings['area_ids']);
        $attributes['state_ids']            =   $this -> wpresidence_send_to_shortcode($settings['state_ids']);
        $attributes['status_ids']           =   $this -> wpresidence_send_to_shortcode($settings['status_ids']);

        $attributes['number']               =   $settings['number'];
        $attributes['rownumber']            =   $settings['rownumber'];
        $attributes['align']                =   $settings['align'];
        $attributes['control_terms_id']     =   $this -> wpresidence_send_to_shortcode($settings['control_terms_id']);
        $attributes['show_featured_only']   =   $settings['show_featured_only'];
        $attributes['random_pick']          =   $settings['random_pick'];
      

        $attributes['sort_by']       				=   $settings['sort_by'];
    //    $attributes['price_min']       			=   $settings['price_min'];
      //  $attributes['price_max']       			=   $settings['price_max'];
        
        $attributes['display_grid']         =   $settings['display_grid'];
        echo  wpestate_recent_posts_pictures_new($attributes);
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */

}
