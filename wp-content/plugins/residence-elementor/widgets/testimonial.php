<?php
namespace ElementorWpResidence\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Wpresidence_Testimonial extends Widget_Base {

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
		return 'WpResidence_Testimonial';
	}

        public function get_categories() {
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
	public function get_title() {
		return __( 'WpResidence Testimonial', 'residence-elementor' );
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
		return 'eicon-testimonial';
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



                $featured_listings  =   array('no'=>'no','yes'=>'yes');
                $items_type         =   array('properties'=>'properties','articles'=>'articles');
                $alignment_type     =   array('vertical'=>'vertical','horizontal'=>'horizontal');
                $testimonials_types=array(1=>1,2=>2,3=>3,4=>4);


		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'residence-elementor' ),
			]
		);



                $this->add_control(
			'client_name',
			[
                            'label' => __( 'Client Name', 'residence-elementor' ),
                            'type' => Controls_Manager::TEXT,
			]
		);

                $this->add_control(
			'title_client',
			[
                            'label' => __( 'Title Client', 'residence-elementor' ),
                            'type' => Controls_Manager::TEXT,
			]
		);

                $this->add_control(
			'imagelinks',
			[
                            'label' => __( 'Image', 'residence-elementor' ),
                            'type' => Controls_Manager::MEDIA,
			]
		);


                $this->add_control(
			'testimonial_text',
			[
                            'label' => __( 'Testimonial Text ', 'residence-elementor' ),
                            'type' => Controls_Manager::TEXTAREA,
			]
		);

                $this->add_control(
			'testimonials_type',
			[
                            'label' => __('Testimonial Type', 'residence-elementor' ),
                            'type' => \Elementor\Controls_Manager::SELECT,

                            'options' => $testimonials_types
			]
		);

                $this->add_control(
			'stars_client',
			[
                            'label' => __( 'Stars ', 'residence-elementor' ),
                            'type' => Controls_Manager::TEXT,
			]
		);

                $this->add_control(
			'testimonial_title',
			[
                            'label' => __( 'Testimonial Title - Only for type3', 'residence-elementor' ),
                            'type' => Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
        /*
         * -------------------------------------------------------------------------------------------------
         * Start shadow section
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
            'selector' => '{{WRAPPER}} .testimonial-container.type_class_1 .testimonial-text, {{WRAPPER}} .testimonial-image, {{WRAPPER}} .testimonial-container.type_class_3, {{WRAPPER}} .testimonial-container.type_class_4 ',
                ]
        );

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

                $attributes['client_name']          =   $settings['client_name'];
                $attributes['title_client']         =   $settings['title_client'];
                $attributes['imagelinks']           =   $settings['imagelinks']['url'];
                $attributes['testimonial_text']     =   $settings['testimonial_text'];
                $attributes['testimonial_type']    =   $settings['testimonials_type'];
                $attributes['testimonial_title']    =   $settings['testimonial_title'];
                $attributes['stars_client']         =   $settings['stars_client'];


              echo  wpestate_testimonial_function($attributes);
	}

	
}
