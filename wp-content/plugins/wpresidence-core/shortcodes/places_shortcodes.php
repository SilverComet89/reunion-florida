<?php
/*
* Display PLaces/Categories Slider function
*
*
*/


if( !function_exists('wpestate_places_slider') ):

function wpestate_places_slider($attributes, $content=null){

    global $full_page;
    global $is_shortcode;
    global $row_number_col;
    global $place_id;
    global $place_per_row;


    $is_shortcode       =1;
    $place_list         ='';
    $return_string      ='';
    $extra_class_name   ='';



    $attributes = shortcode_atts(
        array(
            'place_list'                       => '',
            'place_per_row'                    => 3,
            'extra_class_name'                 => '',

        ), $attributes) ;
    wp_enqueue_script('slick.min');
    $post_number_total = $attributes['place_per_row'];


    if ( isset($attributes['place_list']) ){
        $place_list=$attributes['place_list'];
    }
    if ( isset($attributes['place_per_row']) ){
        $place_per_row=$attributes['place_per_row'];
    }



    if($place_per_row>5){
        $place_per_row=5;
    }

    if( isset($attributes['extra_class_name'])){
        $extra_class_name = $attributes['extra_class_name'];
    }



    $all_places_array =  explode(',', $place_list);

	$slide_cont = '';
    foreach( $all_places_array as $single_term){
        $place_id =intval( $single_term  );

		ob_start();
                include( locate_template('templates/places_unit_type2.php' ) );
		$slide_cont_tmp =  ob_get_clean();
		if( $slide_cont_tmp && trim($slide_cont_tmp) != '' ){
			$slide_cont .=  '<div class="single_slide_container">';
			$slide_cont .= $slide_cont_tmp;
			$slide_cont .= '</div>';
		}


    }

    $return_string = '<div class="estate_places_slider '.$extra_class_name.'"  data-items-per-row="'.$place_per_row.'" data-auto="0" >'. $slide_cont.'</div>';
    //ob_end_clean();
    $is_shortcode       =0;

     $return_string.= '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   wpestate_enable_slick_places();
                });
                //]]>
            </script>';
    return $return_string;


}
endif;



/*
* Display PLaces/Categories function
*
*
*/

if( !function_exists('wpestate_places_list_function') ):
function wpestate_places_list_function($attributes, $content = null) {
    global $full_page;
    global $is_shortcode;
    global $row_number_col;
    global $place_id;
    global $place_per_row;
    $is_shortcode       =1;
    $place_list         ='';
    $return_string      ='';
    $extra_class_name   ='';
    $place_type         = '';
    $item_height        = '';

    $attributes = shortcode_atts(
        array(
            'place_list'                       => '',
            'item_height'                        =>  '',
            'place_per_row'                    => 4,
            'extra_class_name'                 => '',
            'place_type'                       =>  1,
            'place_type1_align'                 =>  'one row',
            'display_grid'              => 'no'
        ), $attributes) ;


    $post_number_total = $attributes['place_per_row'];
    if ( isset($attributes['place_per_row']) ){
        $row_number        = $attributes['place_per_row'];
    }
    if ( isset($attributes['place_type']) ){
        $place_type        = $attributes['place_type'];
    }

    $place_type1_align='';
    if ( isset($attributes['place_type1_align']) ){
        $place_type1_align        = str_replace(' ','_',$attributes['place_type1_align']);
    }



    // max 4 per row
    if($row_number>6){
        $row_number=4;
    }

    if( $row_number == 6 ){
        $row_number_col = 2; // col value is 3
    } else if( $row_number == 4 ){
        $row_number_col = 3; // col value is 3
    }else if( $row_number==3 ){
        $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
        $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
        $row_number_col =  12;// col value is 12
        if( isset($attributes['align']) && $attributes['align']=='vertical'){
             $row_number_col =  0;
        }
    }


    if ( isset($attributes['place_list']) ){
        $place_list=$attributes['place_list'];
    }
    if ( isset($attributes['place_per_row']) ){
        $place_per_row=$attributes['place_per_row'];
    }
    if ( isset($attributes['item_height']) ){
        $item_height=$attributes['item_height'];
    }

    $item_height_style='';


    if($place_per_row>5){
        $place_per_row=5;
    }

    if( isset($attributes['extra_class_name'])){
        $extra_class_name=$attributes['extra_class_name'];
    }



    $all_places_array=  explode(',', $place_list);
    
    
    if( isset($attributes['display_grid'])){
        $display_grid=$attributes['display_grid'];
    }
      
    $wrap_class='';
    if($display_grid=='yes'){
            $wrap_class.=' article_container_grid ';
            $item_length='';
            $col_org = '';
            $row_number_col='';
    }

    ob_start();
    if($display_grid=='yes'){
        print '<div class="items_shortcode_wrapper_grid"> ';
    }
    $card_type      = wpestate_places_card_selector($place_type,0);
             
             
    foreach($all_places_array as $place_id){
        $place_id=intval($place_id);
        if($place_id!=0){
            if($display_grid=='yes'){
                print '<div class="shortcode_wrapper_grid_item shortcode_wrapper_grid_item">';
            }
            
            include( locate_template($card_type ) );
    
            if($display_grid=='yes'){
                print '</div>';
            }
        }
    }
    if($display_grid=='yes'){
        print '</div>';
    }
    $return_string ='<div class="article_container '.esc_attr($wrap_class).' places_list_'.esc_attr($place_type).' '.esc_attr($place_type1_align).' ">'. ob_get_contents().'</div>';
    ob_end_clean();
    $is_shortcode       =0;
    return $return_string;

}
endif;



/*
* Display PLaces/Categories function as Tabs
*
*
*/

if( !function_exists('wpestate_places_list_functionas_tabs') ):
function wpestate_places_list_functionas_tabs($attributes, $content = null) {
  
    

    $attributes = shortcode_atts(
        array(
            'form_fields'                      =>'',
            'place_per_row'                    => 4,
            'show_zero_terms'                  => true
        ), $attributes) ;

     

    if ( isset($attributes['place_per_row']) ){
        $row_number        = $attributes['place_per_row'];
    }
   



    // max 4 per row
    if($row_number>6){
        $row_number=6;
    }

    if( $row_number == 6 ){
        $row_number_col = 2; // col value is 3
    } else if( $row_number == 4 ){
        $row_number_col = 3; // col value is 3
    }else if( $row_number==3 ){
        $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
        $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
        $row_number_col =  12;// col value is 12
        if( isset($attributes['align']) && $attributes['align']=='vertical'){
             $row_number_col =  0;
        }
    }



    
    $all_places_array=$attributes['form_fields'];
    $tab_items      =   '<ul class="nav nav-tabs wpestate_categories_as_tabs_ul" role="tablist">';
    $tab_content    =   '<div class="tab-content">';
    $return_string  =   '<div role="tabpanel" class="wpestate_categories_as_tabs_wrapper" >';
    $class_active   =   'active';
    
    if(is_array($all_places_array)):
        foreach($all_places_array as $key=>$place_tax){
            $tab_items.='<li role="presentation" class="wpestate_categories_as_tabs_item '.esc_attr($class_active).'" >';
               $item_icon='';
                if(isset($place_tax['icon']) && $place_tax['icon']!=''){
                    ob_start();
                    \Elementor\Icons_Manager::render_icon( $place_tax['icon'], [ 'aria-hidden' => 'true' ] );
                    $item_icon= ob_get_contents();
                    ob_end_clean();
                    
                }
                $tab_items.='<a href="#'.sanitize_title(trim($place_tax['field_type'])).'" role="tab" data-toggle="tab">'.$item_icon.esc_html($place_tax['field_label']).'</a>
             </li>';
        
            $tab_content.='<div role="tabpanel" class=" wpestate_categories_as_tabs_panel tab-pane '.esc_attr($class_active).'" id="'.sanitize_title($place_tax['field_type']).'">
            '.wpestate_show_tax_items($place_tax['field_type'],$row_number_col,$attributes['show_zero_terms']).'
            </div>';
            $class_active='';
        }
    endif;
    
    $tab_items.='</ul>';    
    $tab_content.='</div>';   
    
    $return_string .=$tab_items.$tab_content.'</div>';


    return $return_string;

}
endif;


/*
* Display PLaces/Categories function as Tabs
*
*
*/


if( !function_exists('wpestate_show_tax_items') ):
function wpestate_show_tax_items($taxonomy,$row_number_col="4",$show_zero=true){
    $return_string='';
    
    $terms = get_terms( array(
        'taxonomy' => trim($taxonomy),
        'hide_empty' => $show_zero,
    ) );

    
    if(!is_wp_error($terms)){ 
    
        foreach( $terms as $term ) {
            $return_string.='<div class="col-md-'.esc_attr($row_number_col).'">'
                    . '<a class="wpestate_categories_as_tabs_term" href="'. esc_url( get_term_link( $term ) ).'">'.esc_attr( $term->name ).'</a> '
                    . '<span class="places_list_tab_term-count">'.$term->count.' '.esc_html__('properties','wpresidence-core').'</span></div>';
                 
        }
    }
    return $return_string;
    
   
}
endif;