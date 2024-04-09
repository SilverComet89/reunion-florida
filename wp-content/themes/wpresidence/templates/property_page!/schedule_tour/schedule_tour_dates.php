<?php
$slider_id = 'wpestate_schedule_tour_slider_' . rand(1, 99999);
do_action('before_wpestate_display_schedule_tour_dates');
?>

<div class="wpestate_property_schedule_dates_wrapper" id="<?php echo  esc_attr($slider_id); ?>" data-visible-items="6" data-auto="0">
       
    <?php
        $current_month  =   date("m");
        $current_day    =   date("d");
        $current_year   =   date("y");
        $number_of_days_in_advance = 10;
        $counter        =   0;
        
        while($counter<$number_of_days_in_advance){
                
            $day_name   = date_i18n('D',mktime(0,0,0,$current_month,($current_day+$counter),$current_year) ); 
            $day_number = date_i18n('d',mktime(0,0,0,$current_month,($current_day+$counter),$current_year) );
            $month      = date_i18n('M',mktime(0,0,0,$current_month,($current_day+$counter),$current_year) );
            $counter++; 
            ?>

            <div class="wpestate_property_schedule_singledate_wrapper item">
                
                <div class="wpestate_property_schedule_singledate_wrapper_display">
                    <span class="wpestate_day_unit_day_name"><?php echo esc_html($day_name);?></span>
                    <span class="wpestate_day_unit_day_number"><?php echo esc_html($day_number);?></span>
                    <span class="wpestate_day_unit_day_month"><?php echo esc_html($month);?></span>
                </div>

            </div>
        <?php    
        }
        ?>

</div>

<?php  do_action('after_wpestate_display_schedule_tour_dates'); ?>
        
<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function(){
        wpestate_schedule_tour_slider("' . $slider_id . '");
    });
    //]]>
</script>