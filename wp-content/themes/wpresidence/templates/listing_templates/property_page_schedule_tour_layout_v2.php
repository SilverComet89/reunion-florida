<?php
global $post;
$propid                                 =   $post->ID;
$use_schedule_tour                      =   wpresidence_get_option('wp_estate_show_schedule_tour', '');
$wp_estate_exclude_show_schedule_tour   =   wpresidence_get_option('wp_estate_exclude_show_schedule_tour','');


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
    $wp_estate_show_schedule_tour_type=intval(wpresidence_get_option('wp_estate_show_schedule_tour_type',''));
    do_action('before_wpestate_schedule_tour');

    if($wp_estate_show_schedule_tour_type==0){
    ?>

    <div class="wpestate_schedule_tour_wrapper_content">
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
    }else{ 
        
        $main_image     =   wpestate_return_property_card_main_image($post->ID, 'property_featured_sidebar');
        
        
        ?>

        <div class="wpestate_shedule_tour_wrapper_type2" >
            <div class="wpestate_shedule_tour_wrapper_type2_image col-md-6" style="background-image:url(<?php print esc_url($main_image);?>)"></div>
            <div class="wpestate_shedule_tour_wrapper_type2_content col-md-6">

                <?php      
        
                include( locate_template ( '/templates/listing_templates/schedule_tour/schedule_tour_dates.php'));
                include( locate_template ( '/templates/listing_templates/schedule_tour/schedule_tour_options.php'));
             
                $context='schedule_section';
                include( locate_template ( '/templates/listing_templates/contact_form/property_page_contact_form.php'));
                ?>

            </div>

        </div>


    <?php }


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