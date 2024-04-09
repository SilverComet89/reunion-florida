<?php
class measurement_unit_widget extends WP_Widget {
	function __construct(){
	//function Multiple_currency_widget(){
		$widget_ops = array('classname' => 'measurement_unit_widget', 'description' => 'Put Measurement Unit Widget demo on a sidebar');
		$control_ops = array('id_base' => 'measurement_unit_widget');
 
		parent::__construct('measurement_unit_widget', 'Wp Estate: Measurement Unit Widget', $widget_ops, $control_ops);
	
                
        }
	
	function form($instance){
		$defaults = array(
                            'title' => esc_html__('Measurement Unit','wpresidence-core'),
                            );
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='
                <p>
                    <label for="'.$this->get_field_id('title').'">Title:</label>
		</p>
                <p>
                    <input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" />
		</p>';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance                     = $old_instance;
		$instance['title']            = $new_instance['title'];
		
	
                if( function_exists('icl_register_string') ){
                    icl_register_string('measurement_unit_widget_widget','measurement_unit_widget_title',$new_instance['title']);
                }
                
                
               return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $display='';
                $cur_list='';
		$title = apply_filters('widget_title', $instance['title']);


                $normal_label = '';

		print $before_widget;

		if($title) {
			print $before_title.$title.$after_title;
		}
                
                $measure_array=array( 		
                        array( 'name' => esc_html__('feet','wpresidence-core'), 'unit'  => esc_html__('ft','wpresidence-core'),'unit2'  => 'ft','is_square' => 0 ),
                        array( 'name' => esc_html__('meters','wpresidence-core'), 'unit'  => esc_html__('m','wpresidence-core'),'unit2'  => 'm', 'is_square' => 0 ),
                        array( 'name' => esc_html__('acres','wpresidence-core'), 'unit'  => esc_html__('ac','wpresidence-core'),'unit2'  => 'ac', 'is_square' => 1 ),
                        array( 'name' => esc_html__('yards','wpresidence-core'), 'unit'  => esc_html__('yd','wpresidence-core'),'unit2'  => 'yd', 'is_square' => 0 ),
                        array( 'name' => esc_html__('hectares','wpresidence-core'), 'unit'  => esc_html__('ha','wpresidence-core'), 'is_square' => 1 ),
                );

                $selected_measure_unit = esc_html( wpresidence_get_option('wp_estate_measure_sys','') );
       
        
                foreach($measure_array as $single_unit ){
                  // generate output list
                        if( $single_unit['is_square'] === 1 ){
                            $cur_list.='<li  role="presentation" data-value="'.$single_unit['unit'].'">'.$single_unit['name'].' - '.$single_unit['unit'].'</li>'; 	
                        }else{
                            $cur_list.='<li  role="presentation" data-value="'.$single_unit['unit'].'">'.esc_html__('square','wpresidence-core').' '.$single_unit['name'].' - '.$single_unit['unit'].'<sup>2</sup></li>'; 
                        }
                }
        
        
                foreach($measure_array as $single_unit ){

                    // if cookie set - set selected - if no - set default
                    if( isset( $_COOKIE['my_measure_unit'] ) && $_COOKIE['my_measure_unit'] == $single_unit['unit'] ){

                            if( $single_unit['is_square'] === 1 ){
                                    $normal_label   =    $single_unit['name'].' - '.$single_unit['unit'];
                            }else{
                                    $normal_label   =    esc_html__('square','wpresidence-core').' '.$single_unit['name'].' - '.$single_unit['unit'].'<sup>2</sup>';
                            }
                         break;
                    }else{
                     if( $single_unit['is_square'] === 1 ){
                        if( $selected_measure_unit === $single_unit['unit'] ){
                            $normal_label   =    $single_unit['name'].' - '.$single_unit['unit'];
                        }
                        }else{
                            if( $selected_measure_unit === $single_unit['unit'] ){
                                   $normal_label   =    esc_html__('square','wpresidence-core').' '.$single_unit['name'].' - '.$single_unit['unit'].'<sup>2</sup>';
                            }
                        }
                    }
					
                }
			     
			
                $display.= '<div class="dropdown form-control">
                            <div data-toggle="dropdown" id="sidebar_measure_unit_list" class="sidebar_filter_menu">';
                $display.=    $normal_label;
		                   
                $display.='  <span class="caret caret_sidebar"></span> 
                                </div>           
                            
                                <input type="hidden" name="filter_curr[]" value="">
                                <ul id="list_sidebar_measure_unit" class="dropdown-menu filter_menu list_sidebar_measure_unit" role="menu" aria-labelledby="sidebar_currency_list">
                                    '.$cur_list.'
                                </ul>        
                            </div>';
  
                $ajax_nonce = wp_create_nonce( "wpestate_change_measure" );
                $display.='<input type="hidden" id="wpestate_change_measure" value="'.esc_html($ajax_nonce).'" />    ';                 
                                                 
                 
                                                 
    
	
		print $display;
		print $after_widget;
	}

}

?>