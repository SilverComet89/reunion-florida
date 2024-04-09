<?php
$logo_align_option  =   esc_html ( wpresidence_get_option('wp_estate_logo_header_align','') );
$user_menu_align    =   '';
$logo_align         =   'justify-content-center';
$menu_align         =   '';
if($logo_align_option=='right'){ 
    $header_classes['header_wrapper_inside_class'].=' wpestate-flex-row-reverse';
}
 
?>

<div class="header_wrapper_inside wpestate-flex wpestate-align-items-center wpestate-justify-content-between  
    <?php echo esc_attr($header_classes['header_wrapper_inside_class']);?>"
                 data-logo="<?php print esc_attr($header_classes['logo']);?>"
                 data-sticky-logo="<?php print esc_attr($header_classes['stikcy_logo_image']); ?>">

            <?php
            $classes="wpestate-flex wpestate-align-items-center  wpestate-align-self-center ".esc_attr($logo_align);
            print wpestate_display_logo($header_classes['logo'],$classes);           
            ?>

            <a class="navicon-button header_type3_navicon " id="header_type3_trigger">
                <div class="navicon"></div>
            </a>                   
</div>