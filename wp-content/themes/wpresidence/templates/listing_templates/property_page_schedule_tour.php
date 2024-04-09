<?php
$use_schedule_tour                      = wpresidence_get_option('wp_estate_show_schedule_tour', '');
$wp_estate_exclude_show_schedule_tour   = wpresidence_get_option('wp_estate_exclude_show_schedule_tour','');



$section_title = esc_html(wpresidence_get_option('wp_estate_property_schedule_tour_text'));
if (!isset($section_title)):
    $section_title = esc_html__('Schedule a tour','wpresidence');
endif;
 

if( is_array($wp_estate_exclude_show_schedule_tour) && !empty($wp_estate_exclude_show_schedule_tour) ):
    $result                 =   array();
   
    $terms_category         =   get_the_terms($post->ID,    'property_category');
    $terms_action_category  =   get_the_terms($post->ID,    'property_action_category');
    if($terms_category!==false  ){
      $result = array_merge($result, $terms_category);
    }
    if($terms_action_category!==false  ){
        $result = array_merge($result, $terms_action_category);
    }


    foreach ($result as $key => $term) {
        $temp=(array) $term;
        $term_id=intval($temp['term_id']);
        if( in_array($term_id, $wp_estate_exclude_show_schedule_tour ) ){
            $use_schedule_tour = 'no';
        }
    }

endif;


if ( $use_schedule_tour=='yes'){
    do_action('before_wpestate_schedule_tour');
    ?>

    <div class="wpestate_schedule_tour_wrapper">
        <h4><?php echo trim($section_title); ?></h4>
        <?php  
        
        include( locate_template ( '/templates/listing_templates/schedule_tour/schedule_tour_dates.php'));
        include( locate_template ( '/templates/listing_templates/schedule_tour/schedule_tour_options.php'));
        ?>
        <h5 class="wpestate_tour_info_headline"><?php esc_html_e('Your information','wpresidence');?></h5>
        <?php
        $context='schedule_section';
        include( locate_template ( '/templates/listing_templates/contact_form/property_page_contact_form.php'));
        ?>
    </div>

<?php
    do_action('after_wpestate_schedule_tour');
}
?> 
<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function(){
        wpestate_schedule_tour_slider("' . $slider_id . '");
    });
    //]]>
</script>