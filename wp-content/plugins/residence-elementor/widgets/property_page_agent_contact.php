<?php
namespace ElementorWpResidence\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Repeater;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Wpresidence_Property_Page_Agent_Contact extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Agent_Contact_Form';
	}

        public function get_categories() {
		return [ 'wpresidence_property' ];
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
	public function get_title() {
		return __( 'Agent Contact Form', 'residence-elementor' );
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
	public function get_icon() {
		return 'eicon-form-horizontal';
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
	public function get_script_depends() {
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
         public function elementor_transform($input){
            $output=array();
            if( is_array($input) ){
                foreach ($input as $key=>$tax){
                    $output[$tax['value']]=$tax['label'];
                }
            }
            return $output;
        }




        protected function register_controls() {
                $text_align=array('left'=>'left','right'=>'right','center'=>'center');
                $this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'residence-elementor' ),
			]
		);


		$this->end_controls_section();

/*-------------------------------------------------------------------------------------------------
        * Start shadow section
        */
        $this->start_controls_section(
          'section_grid_box_shadow',
          [
              'label' => esc_html__( 'Box Shadow', 'residence-elementor' ),
              'tab'   => Controls_Manager::TAB_STYLE,
          ]
          );
          $this->add_group_control(
              Group_Control_Box_Shadow::get_type(),
              [
                  'name'     => 'box_shadow',
                  'label'    => esc_html__( 'Box Shadow', 'residence-elementor' ),
                  'selector' => '{{WRAPPER}} .agent_contanct_form',
              ]
          );

          $this->end_controls_section();
        /*
        *-------------------------------------------------------------------------------------------------
        * End shadow section
        */

          $this->start_controls_section(
                               'section_spacing_margin_section',
                               [
                                               'label'     => esc_html__( 'Spaces & Sizes', 'residence-elementor' ),
                                               'tab'       => Controls_Manager::TAB_STYLE,
                               ]
               );

           

               $this->add_responsive_control(
                        'property_content_padding',
                        [
                                        'label'      => esc_html__( 'Content Area Padding', 'residence-elementor' ),
                                        'type'       => Controls_Manager::DIMENSIONS,
                                        'size_units' => [ 'px', '%', 'em' ],
                                        'selectors'  => [
                                                        '{{WRAPPER}} .agent_contanct_form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                        ],
                        ]
                 );

                $this->add_responsive_control(
                   'border_radius',
                   [
                       'label' => esc_html__( 'Border Radius', 'residence-elementor' ),
                       'type' => Controls_Manager::DIMENSIONS,
                       'size_units' => [ 'px', '%' ],
                       'selectors' => [
                            '{{WRAPPER}} .agent_contanct_form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                       ],
                   ]
               );

               $this->end_controls_section();
               
               
               
         
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
                                'name'     => 'contact_form_title',
                                'label'    => esc_html__( 'Contact Form Title', 'residence-elementor' ),
                                'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                                'selector' => '{{WRAPPER}} #show_contact',
                ]
        );

         $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                                'name'     => 'form_font',
                                'label'    => esc_html__( 'Form Font', 'residence-elementor' ),
                                'scheme'   =>     \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                                'selector' => '{{WRAPPER}} .form-control',
                ]
        );
      
     $this->end_controls_section();
               
               
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

        public function wpresidence_send_to_shortcode($input){
            $output='';
            if($input!==''){
                $numItems = count($input);
                $i = 0;

                foreach ($input as $key=>$value){
                    $output.=$value;
                    if(++$i !== $numItems) {
                      $output.=', ';
                    }
                }
            }
            return $output;
        }
	protected function render() {
            $settings = $this->get_settings_for_display();
            $attributes['is_elementor']      =   1;


            echo  wpestate_estate_property_design_agent_contact($attributes);
	}


}
