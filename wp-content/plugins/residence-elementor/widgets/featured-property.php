<?php
namespace ElementorWpResidence\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class Wpresidence_Featured_Property extends Widget_Base {

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
		return 'WpResidence_Featured_Property';
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
		return __( 'WpResidence Featured Property', 'residence-elementor' );
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
		return 'eicon-image-rollover';
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


        protected function register_controls() {
                $featured_prop_type         =   array(1=>1,2=>2,3=>3,4=>4,5=>5);
                $article_array              =   wpestate_return_article_array();
                $article_array_elementor    = $article_array;


		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'residence-elementor' ),
			]
		);



                $this->add_control(
			'idul',
			[
                            'label' => __( 'Property Id', 'residence-elementor' ),
                            'type' => Controls_Manager::TEXT,
			]
		);
                $this->add_control(
			'sale_line',
			[
                            'label' => __( 'Second Line', 'residence-elementor' ),
                            'type' => Controls_Manager::TEXT,
			]
		);

                $this->add_control(
			'design_type',
			[
                            'label' => __('Design Type', 'residence-elementor' ),
                            'type' => \Elementor\Controls_Manager::SELECT,

                            'options' => $featured_prop_type,
                            'default'=>1
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
            'selector' => '{{WRAPPER}} .featured_property ,{{WRAPPER}} .featured_article_type2 ',
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



	protected function render() {
            $settings = $this->get_settings_for_display();
            $attributes['id']               =   $settings['idul'];
            $attributes['sale_line']        =   $settings['sale_line'];
            $attributes['design_type']      =   $settings['design_type'];
            echo  wpestate_featured_property($attributes);
	}

}
