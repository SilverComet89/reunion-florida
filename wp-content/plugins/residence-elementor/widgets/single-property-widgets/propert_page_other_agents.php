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


class Wpresidence_Property_Page_Other_Agents extends Widget_Base {

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
		return 'Other_Agents';
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
		return __( 'Other Agents', 'residence-elementor' );
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
		return 'eicon-handle';
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




		$agent_card=array(
				'2'=>'two per row',
				'3'=>'three per row',
				'4'=>'four per row'
				);


		$this->add_control(
		 'columns',
		 [
							 'label' => __( 'Items per row', 'residence-elementor' ),
							 'type' => \Elementor\Controls_Manager::SELECT,
							 'default' => 'one column'  ,
							 'options' => $agent_card
		 ]
		);

		$this->add_control(
				 'hide_section_phone',
				 [
						 'label' => esc_html__( 'Hide Phone ', 'residence-elementor' ),
						 'type' => Controls_Manager::SWITCHER,
						 'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
						 'label_off' => esc_html__( 'No', 'residence-elementor' ),
						 'return_value' => 'none',
						 'default' => '',
						 'selectors' => [
								 '{{WRAPPER}}  .agent_unit_phone' => 'display: {{VALUE}};',
						 ],
				 ]
		 );


		$this->add_control(
			 'hide_section_email',
			 [
					 'label' => esc_html__( 'Hide Email ', 'residence-elementor' ),
					 'type' => Controls_Manager::SWITCHER,
					 'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
					 'label_off' => esc_html__( 'No', 'residence-elementor' ),
					 'return_value' => 'none',
					 'default' => '',
					 'selectors' => [
							 '{{WRAPPER}}  .agent_unit_email' => 'display: {{VALUE}};',
					 ],
			 ]
		);


		$this->add_control(
			 'hide_section_facebook',
			 [
					 'label' => esc_html__( 'Hide Facebook ', 'residence-elementor' ),
					 'type' => Controls_Manager::SWITCHER,
					 'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
					 'label_off' => esc_html__( 'No', 'residence-elementor' ),
					 'return_value' => 'none',
					 'default' => '',
					 'selectors' => [
							 '{{WRAPPER}}  .agent_unit_facebook' => 'display: {{VALUE}};',
					 ],
			 ]
		);
		$this->add_control(
			 'hide_section_twiter',
			 [
					 'label' => esc_html__( 'Hide Twitter ', 'residence-elementor' ),
					 'type' => Controls_Manager::SWITCHER,
					 'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
					 'label_off' => esc_html__( 'No', 'residence-elementor' ),
					 'return_value' => 'none',
					 'default' => '',
					 'selectors' => [
							 '{{WRAPPER}}  .agent_unit_twitter' => 'display: {{VALUE}};',
					 ],
			 ]
		);

		$this->add_control(
			 'hide_section_linkedin',
			 [
					 'label' => esc_html__( 'Hide Linkedin ', 'residence-elementor' ),
					 'type' => Controls_Manager::SWITCHER,
					 'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
					 'label_off' => esc_html__( 'No', 'residence-elementor' ),
					 'return_value' => 'none',
					 'default' => '',
					 'selectors' => [
							 '{{WRAPPER}}  .agent_unit_linkedin' => 'display: {{VALUE}};',
					 ],
			 ]
		);


		$this->add_control(
			 'hide_section_pinterest',
			 [
					 'label' => esc_html__( 'Hide Pinterest ', 'residence-elementor' ),
					 'type' => Controls_Manager::SWITCHER,
					 'label_on' => esc_html__( 'Yes', 'residence-elementor' ),
					 'label_off' => esc_html__( 'No', 'residence-elementor' ),
					 'return_value' => 'none',
					 'default' => '',
					 'selectors' => [
							 '{{WRAPPER}}  .agent_unit_pinterest' => 'display: {{VALUE}};',
					 ],
			 ]
		);


		        $this->add_responsive_control(
		            'item_height',
		            [
		                                    'label' => esc_html__('Item Height', 'residence-elementor'),
		                                    'type' => Controls_Manager::SLIDER,
		                                    'range' => [
		                                            'px' => [
		                                                    'min' => 150,
		                                                    'max' => 700,
		                                            ],
		                                    ],
		                                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
		                                    'desktop_default' => [
		                                            'size' => 400,
		                                            'unit' => 'px',
		                                    ],
		                                    'tablet_default' => [
		                                            'size' => '',
		                                            'unit' => 'px',
		                                    ],
		                                    'mobile_default' => [
		                                            'size' => '',
		                                            'unit' => 'px',
		                                    ],
		                                    'selectors' => [
		                                        '{{WRAPPER}} .agent_unit' => 'height: {{SIZE}}{{UNIT}}!important;',
                                             '{{WRAPPER}} .agent_unit' => 'min-height: {{SIZE}}{{UNIT}}!important;'
		                            ],
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
																							 'selector' => '{{WRAPPER}} .agent_unit',
																					 ]
																			 );

																			 $this->end_controls_section();
																		 /*
																		 *-------------------------------------------------------------------------------------------------
																		 * End shadow section
																		 */


																		 /*-------------------------------------------------------------------------------------------------
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
																	 								'label'    => esc_html__( 'Agent Name', 'residence-elementor' ),
																	 								'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
																	 								'selector' => '{{WRAPPER}} h4 a',
																	 						]
																	 				);

																					$this->add_group_control(
																			 				Group_Control_Typography::get_type(),
																			 				[
																			 						'name'     => 'property_desc',
																			 						'label'    => esc_html__( 'Description', 'residence-elementor' ),
																			 						'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
																			 						'selector' => '{{WRAPPER}} .agent_card_content',
																			 				]
																			 		);


																	 	$this->end_controls_section();
																	 	/*
																	 	*-------------------------------------------------------------------------------------------------
																	 	* End shadow section
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


            echo  wpestate_property_design_other_agents($attributes,'',$settings['columns']);
	}


}
