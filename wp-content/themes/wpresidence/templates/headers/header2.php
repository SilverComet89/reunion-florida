<?php
$logo_align_option  =   esc_html ( wpresidence_get_option('wp_estate_logo_header_align','') );
$menu_align_option  =   esc_html ( wpresidence_get_option('wp_estate_menu_header_align','') );
$user_menu_align            =   '';
$logo_align                 =   'wpestate-justify-content-center';
$menu_align_for_logo        =   '';
$menu_align_for_user_menu   =   'wpestate-order-3';
$menu_align                 =   'wpestate-order-2';

$menu_align_for_user_menu   =   '';
$menu_align                 =   '';


if($logo_align_option=='right'){
    $logo_align ='wpestate-justify-content-flex-end';
    $user_menu_align='';
}else if($logo_align_option=='left'){
    $logo_align ='wpestate-justify-content-start';
}

if($menu_align_option=='right'){
    $menu_align_for_user_menu='wpestate-order-2';
    $menu_align = 'wpestate-order-3';
}

?>

<div class="header_wrapper_inside wpestate-flex wpestate-flex-wrap wpestate-align-items-center 
wpestate-justify-content-between <?php echo esc_attr($header_classes['header_wrapper_inside_class']);?>"
                 data-logo="<?php print esc_attr($header_classes['logo']);?>"
                 data-sticky-logo="<?php print esc_attr($header_classes['stikcy_logo_image']); ?>">

            <?php
            $classes="wpestate-flex col-md-12 wpestate-align-items-center  wpestate-align-self-center  ".esc_attr($logo_align)." ".esc_attr($menu_align_for_logo);
            print wpestate_display_logo($header_classes['logo'],$classes);           
            ?>

            <nav id="access" class="nav col-12  wpestate-justify-content-md-between  <?php echo esc_attr($menu_align)?>">
                <?php
                    wp_nav_menu(
                        array(  'theme_location'    => 'primary' ,
                                'walker'            => new wpestate_custom_walker
                            )
                    );
                ?>
            </nav><!-- #access -->
           
           <div class="user_menu_wrapper text-end <?php echo esc_attr($user_menu_align).' '.esc_attr($menu_align_for_user_menu); ?>">          
                <?php
                    get_template_part('templates/top_user_menu');
                ?>
            </div>
</div>