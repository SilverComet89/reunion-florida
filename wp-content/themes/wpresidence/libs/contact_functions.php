<?php



/*
*
* Display  the actual contact form
*
*/


if (!function_exists('wpestate_display_actual_contact_form')):
function wpestate_display_actual_contact_form($propid,$agent_id,$slider_property_id,$context){
    

}
endif;






/*
*
* Display  simple shedule form
*
*/


if (!function_exists('wpestate_display_simple_schedule_form')):
    function wpestate_display_simple_schedule_form(){
        $return_string='
        <div class="schedule_wrapper" style="display: none;">
            <input name="schedule_day" class="schedule_day form-control" type="text"  placeholder="'.esc_html__('Day', 'wpresidence').'" aria-required="true" class="form-control">
            
            <select name="schedule_hour" class="schedule_hour form-control">
                <option value="0">'.esc_html__('Time', 'wpresidence').'</option>';

                for ($i = 7; $i <= 19; $i++) {
                    for ($j = 0; $j <= 45; $j += 15) {
                        $show_j = $j;
                        if ($j == 0) {
                            $show_j = '00';
                        }

                        $val = $i . ':' . $show_j;
                        $return_string.= '<option value="' . esc_attr($val) . '">' . esc_html($val) . '</option>';
                    }
                }

            $return_string.='</select>
        </div>';

        return $return_string;
    }
endif;






/*
*
* Display  contact form title
*
*/


if (!function_exists('wpestate_display_contact_form_title')):
function wpestate_display_contact_form_title( $current_page_template,$contact_form_7_agent){


    $return_string          =   '';

    if ($current_page_template   != 'contact_page.php') { 

        if (is_singular('estate_agency') || is_singular('estate_developer')) {
            $return_string .= '<h4 id="show_contact">' . esc_html__('Contact Us', 'wpresidence') . '</h4>';
        } else {
            $return_string .= '<h4 id="show_contact">' . esc_html__('Contact Me', 'wpresidence') . '</h4>';
        }
       
        if ($contact_form_7_agent == '' && wpresidence_get_option('wp_estate_use_classic_schedule','')=='yes') {
            $return_string .='<div  class="schedule_meeting">'.esc_html__('Schedule a showing?', 'wpresidence').'</div>';        
        }
    


    } else { 
        $return_string .='<h4 id="show_contact">'.esc_html__('Contact Us', 'wpresidence').'</h4>';
    } 

    return $return_string;
}

endif;



/*
*
* Display  contact form title
*
*/

if (!function_exists('wpestate_check_gdpr_case')):

    function wpestate_check_gdpr_case($extra = '') {
        $return_string='';
        if($extra!=''){
            $extra.='_'.$extra;
        }
        if (wpresidence_get_option('wp_estate_use_gdpr', '') == 'yes') {

            $return_string.='
            <div class="gpr_wrapper">
                <input type="checkbox" role="checkbox" aria-checked="false" id="wpestate_agree_gdpr' . $extra . '" class="wpestate_agree_gdpr" name="wpestate_agree_gdpr" />
                <label class="wpestate_gdpr_label" for="wpestate_agree_gdpr' . $extra . '">' . esc_html__('I consent to the', 'wpresidence') . ' <a target="_blank" href="' . wpestate_get_template_link('gdpr_terms.php') . '">' . esc_html__('GDPR Terms', 'wpresidence') . '</a></label></div>';
        }
        return $return_string;
    }

endif;








/*
 * Before wpestate schedule function
 *
 *
 *
 *
 */
add_action( 'before_wpestate_schedule_tour', 'before_wpestate_schedule_tour_function', 10 );
if( !function_exists('before_wpestate_schedule_tour_function') ):
    function before_wpestate_schedule_tour_function(){
      
    }
endif;



/*
 * After wpestate schedule function
 *
 *
 *
 *
 */
add_action( 'after_wpestate_schedule_tour', 'after_wpestate_schedule_tour_function', 10 );
if( !function_exists('after_wpestate_schedule_tour_function') ):
    function after_wpestate_schedule_tour_function(){
        
    }
endif;

/*
 * Before wpestate schedule tour dates function
 *
 *
 *
 *
 */
add_action( 'before_wpestate_display_schedule_tour_dates', 'before_wpestate_display_schedule_tour_dates_function', 10 );
if( !function_exists('before_wpestate_display_schedule_tour_dates_function') ):
    function before_wpestate_display_schedule_tour_dates_function(){
        
    }
endif;

/*
 * Before wpestate schedule tour dates function
 *
 *
 *
 *
 */
add_action( 'after_wpestate_display_schedule_tour_dates', 'after_wpestate_display_schedule_tour_dates_function', 10 );
if( !function_exists('after_wpestate_display_schedule_tour_dates_function') ):
    function after_wpestate_display_schedule_tour_dates_function(){
        
    }
endif;

/*
 * Before wpestate schedule tour dates options
 *
 *
 *
 *
 */
add_action( 'before_wpestate_display_schedule_tour_dates_options', 'before_wpestate_display_schedule_tour_dates_options_function', 10 );
if( !function_exists('before_wpestate_display_schedule_tour_dates_options_function') ):
    function before_wpestate_display_schedule_tour_dates_options_function(){
        
    }
endif;

/*
 * After wpestate schedule tour dates options
 *
 *
 *
 *
 */
add_action( 'after_wpestate_display_schedule_tour_dates_option_time', 'after_wpestate_display_schedule_tour_dates_option_time_function', 10 );
if( !function_exists('after_wpestate_display_schedule_tour_dates_option_time_function') ):
    function after_wpestate_display_schedule_tour_dates_option_time_function(){
        
    }
endif;
/*
 * After  wpestate schedule tour dates options
 *
 *
 *
 *
 */
add_action( 'after_wpestate_display_schedule_tour_dates_options', 'after_wpestate_display_schedule_tour_dates_options_function', 10 );
if( !function_exists('after_wpestate_display_schedule_tour_dates_options_function') ):
    function after_wpestate_display_schedule_tour_dates_options_function(){
        
    }
endif;


/*
 * Before  wpestate contact form simple
 *
 *
 *
 *
 */
add_action( 'before_wpestate_display_contact_form_simple', 'before_wpestate_display_contact_form_simple_function', 10 );
if( !function_exists('before_wpestate_display_contact_form_simple_function') ):
    function before_wpestate_display_contact_form_simple_function(){
        
    }
endif;

/*
 * After  wpestate contact form simple
 *
 *
 *
 *
 */
add_action( 'after_wpestate_display_contact_form_simple', 'after_wpestate_display_contact_form_simple_function', 10 );
if( !function_exists('after_wpestate_display_contact_form_simple_function') ):
    function after_wpestate_display_contact_form_simple_function(){
        
    }
endif;

?>