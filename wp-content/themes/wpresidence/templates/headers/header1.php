<?php
$logo_align_option  =   esc_html ( wpresidence_get_option('wp_estate_logo_header_align','') );
$menu_align_option  =   esc_html ( wpresidence_get_option('wp_estate_menu_header_align','') );
$user_menu_align            =   '';
$logo_align                 =   '';
$menu_align_for_logo        =   '';
$menu_align_for_user_menu   =   '';
$nav_menu_align             =   '';


if($logo_align_option=='right'){
    $logo_align ='wpestate-order-last';
    $user_menu_align='wpestate-order-first';
    
}

if($menu_align_option == 'left'){
    $menu_align_for_user_menu='ms-auto';

    if($logo_align_option=='right'){
        $logo_align .=' ms-auto ';
        $menu_align_for_user_menu='';
    }

}else if($menu_align_option=='right'){
    $menu_align_for_logo='me-auto ';
    if($logo_align_option=='right'){
        $menu_align_for_user_menu='me-auto '; 
        $menu_align_for_logo='';
    }
}

?>

<div class="header_wrapper_inside wpestate-flex wpestate-flex-wrap wpestate-align-items-center wpestate-justify-content-between  
        <?php echo esc_attr($header_classes['header_wrapper_inside_class']);?>"
        data-logo="<?php print esc_attr($header_classes['logo']);?>"
        data-sticky-logo="<?php print esc_attr($header_classes['stikcy_logo_image']); ?>">

        <?php
        $classes="wpestate-flex wpestate-flex-wrap wpestate-align-items-center wpestate-justify-content-md-between wpestate-align-self-center ".esc_attr($logo_align)." ".esc_attr($menu_align_for_logo);
        print wpestate_display_logo($header_classes['logo'],$classes);           
        ?>

        <nav id="access" class="nav col-12 col-md-auto wpestate-justify-content-md-between ">
            <?php
                wp_nav_menu(
                    array(  'theme_location'    => 'primary' ,
                            'walker'            => new wpestate_custom_walker
                        )
                );
            ?>
        </nav><!-- #access -->
        
        <div class="user_menu_wrapper wpestate-text-end <?php echo esc_attr($user_menu_align).' '.esc_attr($menu_align_for_user_menu); ?>">          
            <?php
                get_template_part('templates/top_user_menu');
            ?>
        </div>
</div>