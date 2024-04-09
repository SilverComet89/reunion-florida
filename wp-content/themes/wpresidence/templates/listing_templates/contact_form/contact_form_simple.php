    <?php 
    do_action('before_wpestate_display_contact_form_simple');
    $textarea_text='';
    if (is_singular('estate_property') || isset($slider_property_id)) {
        $textarea_text= esc_html__("I'm interested in", "wpresidence");
        $textarea_text .= esc_html(' [ ' . get_the_title($propid) . ' ] ');
    }

    if($context=='schedule_section'){
        $textarea_text= esc_html__("I would like to schedule a tour for ", "wpresidence");
        $textarea_text .= esc_html(' " ' . get_the_title($propid) . ' ". ');
    }

    ?>
    <div class="contact_form_flex_wrapper">
        <input name="contact_name" id="agent_contact_name" type="text"  placeholder="<?php esc_html_e('Your Name', 'wpresidence');?>" aria-required="true" class="form-control">
        <input type="text" name="email" class="form-control" id="agent_user_email" aria-required="true" placeholder="<?php esc_html_e('Your Email', 'wpresidence');?>">
        <input type="text" name="phone"  class="form-control" id="agent_phone" placeholder="<?php esc_html_e('Your Phone', 'wpresidence');?>">
    </div>

    <textarea id="agent_comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true"><?php print trim($textarea_text);?></textarea>

    <?php print wpestate_check_gdpr_case($context); ?>

    <input type="submit" class="wpresidence_button agent_submit_class "   value="<?php  esc_html_e('Send Email', 'wpresidence');?>">

    <?php 
 
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_singular('estate_property')) {
        if (class_exists( 'Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode()) {
            //do nothing

        } else if($context!='schedule_section'){
            include( locate_template ( 'templates/realtor_templates/agent_contact_bar.php'));
        }
    }
    ?>

    <?php 
    if (wpresidence_get_option('wp_estate_enable_direct_mess') == 'yes' &&  $context!='schedule_section' ) { 
    ?>
        <input type="submit" class="wpresidence_button message_submit"   value="<?php esc_html_e('Send Private Message', 'wpresidence');?>">
        <div class=" message_explaining"><?php esc_html_e('You can reply to private messages from "Inbox" page in your user account.', 'wpresidence');?></div>
    <?php
    }

    ?>

    <input name="prop_id" type="hidden"  id="agent_property_id" value="<?php 
            if($context!='theme_slider'){ 
                if( get_post_type($post->ID)=='estate_property'){
                    echo intval($post->ID);
                }else if(isset($propid)){
                    echo intval($propid);
                }
            }else{
                echo intval($propid);
            }
    ?>">
    <input name="prop_id" type="hidden"  id="agent_id" value="<?php echo intval($agent_id);?>">
    <input type="hidden" name="contact_ajax_nonce" id="agent_property_ajax_nonce"  value="<?php echo wp_create_nonce('ajax-property-contact');?>" />

    <?php do_action('after_wpestate_display_contact_form_simple'); ?>