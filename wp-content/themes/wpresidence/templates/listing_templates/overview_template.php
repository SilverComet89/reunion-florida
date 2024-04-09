<?php
$show_print        =   esc_html ( wpresidence_get_option('wp_estate_show_hide_print_button','') );
$show_favorite     =   esc_html ( wpresidence_get_option('wp_estate_show_hide_fav_button','') );
$show_share        =   esc_html ( wpresidence_get_option('wp_estate_show_hide_share_button','') );
$show_address      =   esc_html ( wpresidence_get_option('wp_estate_show_hide_address_details','') );
?>


<div class="notice_area col-md-12 ">
    <?php  
    include(locate_template('templates/listing_templates/property-page-templates/title_section.php')); 
    
    if($show_address=='yes'){ 
       include(locate_template('templates/listing_templates/property-page-templates/address_under_title.php')); 
    } 
    ?> 


    <div class="prop_social">
        <?php   
        if($show_share =='yes'){
            
            print wpestate_share_unit_desing($post->ID,1);?>
            <div class="title_share share_list single_property_action"  data-original-title="<?php esc_attr_e('share this page','wpresidence');?>" >
                <i class="fas fa-share-alt"></i><?php esc_html_e('Share','wpresidence'); ?>
            </div>
        <?php  } 

        if($show_favorite=='yes'){
            include(locate_template('templates/listing_templates/property-page-templates/favorite_under_title.php')); 
        } 
        
        if($show_print=='yes'){ ?>
            <div id="print_page" class="title_share single_property_action"   data-propid="<?php echo intval($post->ID);?>" data-original-title="<?php esc_attr_e('print page','wpresidence');?>" >
                <i class="fas fa-print"></i><?php esc_html_e('Print','wpresidence'); ?>
            </div>
        <?php } ?>


    </div>
</div>