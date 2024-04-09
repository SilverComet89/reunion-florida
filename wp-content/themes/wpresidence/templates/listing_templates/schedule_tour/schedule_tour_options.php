<?php
$options        =   wpresidence_get_option('wp_estate_schedule_tour_timeslots', '');
$options_array  =   explode(',',$options);
do_action('before_wpestate_display_schedule_tour_dates_options');
?>

        
<select name="wpestate_schedule_tour_time" class="form-control" id="wpestate_schedule_tour_time">

<option value="0"><?php esc_html_e('Please select the time','wpresidence');?></option>
    <?php    
    foreach($options_array as $key=>$value): ?>
        <option value="<?php echo esc_attr($value); ?>"><?php echo esc_attr($value); ?></option>
    <?php endforeach; ?>        
    
</select>

<?php
do_action('after_wpestate_display_schedule_tour_dates_option_time');
?>

<div class="wpestate_display_schedule_tour_options_wrapper">

    <div class="wpestate_display_schedule_tour_option schedule_in_person shedule_option_selected">
        <?php include (locate_template('templates/svg_icons/person_icon.html'))?>
        <?php esc_html_e('In Person','wpresidence');?>
    </div>
    
    <div class="wpestate_display_schedule_tour_option schedule_video_chat">
        <?php include (locate_template('templates/svg_icons/video_camera.html'))?>
        <?php esc_html_e('Video Chat','wpresidence');?>
    </div>

</div>
<?php
do_action('after_wpestate_display_schedule_tour_dates_options');
?>