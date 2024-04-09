<?php
$logo_align_option  =   esc_html ( wpresidence_get_option('wp_estate_logo_header_align','') );
$menu_align_option = esc_html(wpresidence_get_option('wp_estate_text_header_align'));

$user_menu_align    =   '';
$logo_align         =   'justify-content-center';

$menu_align         =   '';


if($logo_align_option=='right'){ 
    $header_classes['header_wrapper_inside_class'].=' wpestate-flex-row-reverse ';
}
 
?>

<div class="header_wrapper_inside wpestate-flex flex-column wpestate-align-items-center wpestate-justify-content-between   <?php //echo esc_attr($header_classes['header_wrapper_inside_class']);?>"
                 data-logo="<?php print esc_attr($header_classes['logo']);?>"
                 data-sticky-logo="<?php print esc_attr($header_classes['stikcy_logo_image']); ?>">

        <?php
        $classes="wpestate-flex wpestate-align-items-center  wpestate-align-self-center  ".esc_attr($logo_align);
        print wpestate_display_logo($header_classes['logo'],$classes);           
        ?>

        <nav id="access" class="nav col-12 wpestate-justify-content-md-between <?php echo esc_attr('header4_align_'.$menu_align_option)?>">
        <?php
            wp_nav_menu(
                array(  'theme_location'    => 'primary' ,
                        'walker'            => new wpestate_custom_walker
                    )
            );
        ?>
        </nav><!-- #access -->

        <div id="header4_footer">
            <ul class="xoxo">
                <?php dynamic_sidebar('header4-widget-area'); ?>
            </ul>
        </div>


</div>