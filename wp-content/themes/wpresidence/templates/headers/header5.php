<?php
$show_top_bar_user_login    =   esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_login','') );
$logo                       =   wpresidence_get_option('wp_estate_logo_image','url');  
$stikcy_logo_image          =   esc_html( wpresidence_get_option('wp_estate_stikcy_logo_image','url') );
$logo_align_option          =   esc_html ( wpresidence_get_option('wp_estate_logo_header_align','') );
$menu_align_option          =   esc_html ( wpresidence_get_option('wp_estate_menu_header_align','') );
$user_menu_align            =   '';
$logo_align                 =   '';
$menu_align_for_logo        =   '';
$menu_align_for_user_menu   =   '';
$header_5_widget            =   "wpestate-justify-content-flex-end";

if($logo_align_option=='right'){
    $logo_align         =   'wpestate-order-last';
    $header_5_widget    =   '';
}

if($menu_align_option == 'left'){
    $menu_align_for_user_menu='ms-auto p-2';
}else if($menu_align_option=='right'){
    $menu_align_for_user_menu="wpestate-order-first";
}


?>

<div class="header_5_inside">
    <div class="header5_top_row wpestate-flex wpestate-flex-wrap wpestate-align-items-stretch
     wpestate-justify-content-between" data-logo="<?php print  esc_attr($logo);?>" data-sticky-logo="<?php print esc_attr($stikcy_logo_image); ?>">
      
        <?php
            $classes="wpestate-flex wpestate-flex-wrap wpestate-align-items-stretch wpestate-justify-content-md-between 
            wpestate-align-self-center ".esc_attr($logo_align)." ".esc_attr($menu_align_for_logo);
            print wpestate_display_logo($header_classes['logo'],$classes);           
        ?>


        <div class="header_5_widget_wrap col-md-8 wpestate-flex wpestate-flex-wrap  
        justify-content-end  wpestate-align-items-stretch  wpestate-align-self-center ">
            <?php
            $header5_info_widget1_icon   =   wpresidence_get_option('wp_estate_header5_info_widget1_icon','');
            $header5_info_widget1_text1   =   wpresidence_get_option('wp_estate_header5_info_widget1_text1','');
            $header5_info_widget1_text2   =   wpresidence_get_option('wp_estate_header5_info_widget1_text2','');
            if($header5_info_widget1_icon!='' || $header5_info_widget1_text1!=''){
            ?>
            
            <div class="header_5_widget <?php echo esc_attr($header_5_widget); ?> col-md-4">
                <div class="header_5_widget_icon">
                    <i class="<?php print esc_attr($header5_info_widget1_icon);?>"></i>
                </div>
                
                <div class="header_5_widget_text_wrapper">
                    <div class="header_5_widget_text">
                        <?php print trim($header5_info_widget1_text1);?>
                    </div>
                    <div class="header_5_widget_text">
                        <?php print trim($header5_info_widget1_text2);?>
                    </div>
                </div>
                
            </div>
            
            <?php } ?>
            
             <?php
            $header5_info_widget2_icon   =   wpresidence_get_option('wp_estate_header5_info_widget2_icon','');
            $header5_info_widget2_text1   =   wpresidence_get_option('wp_estate_header5_info_widget2_text1','');
            $header5_info_widget2_text2   =   wpresidence_get_option('wp_estate_header5_info_widget2_text2','');
            if($header5_info_widget2_icon!='' || $header5_info_widget2_text1!=''){
            ?>
            
            <div class="header_5_widget <?php echo esc_attr($header_5_widget); ?> col-md-4">
                <div class="header_5_widget_icon">
                    <i class="<?php print esc_attr($header5_info_widget2_icon);?>"></i>
                </div>
                
                <div class="header_5_widget_text_wrapper">
                    <div class="header_5_widget_text">
                        <?php print trim($header5_info_widget2_text1);?>
                    </div>
                    <div class="header_5_widget_text">
                        <?php print trim($header5_info_widget2_text2);?>
                    </div>
                </div>
                
            </div>
            
            <?php } ?>
            
            
            
            <?php
            $header5_info_widget3_icon   =   wpresidence_get_option('wp_estate_header5_info_widget3_icon','');
            $header5_info_widget3_text1   =   wpresidence_get_option('wp_estate_header5_info_widget3_text1','');
            $header5_info_widget3_text2   =   wpresidence_get_option('wp_estate_header5_info_widget3_text2','');
            if($header5_info_widget3_icon!='' || $header5_info_widget3_text1!=''){
            ?>
            
            <div class="header_5_widget <?php echo esc_attr($header_5_widget); ?> col-md-4">
                <div class="header_5_widget_icon">
                    <i class="<?php print esc_attr($header5_info_widget3_icon);?>"></i>
                </div>
                
                <div class="header_5_widget_text_wrapper">
                    <div class="header_5_widget_text">
                        <?php print trim($header5_info_widget3_text1);?>
                    </div>
                    <div class="header_5_widget_text">
                        <?php print trim($header5_info_widget3_text2);?>
                    </div>
                </div>
                
            </div>
            
            <?php } ?>
            
        </div>    
    </div>    
       
    <div class="header5_bottom_row_wrapper ">
        <div class="header5_bottom_row wpestate-flex wpestate-flex-wrap wpestate-align-items-stretch wpestate-justify-content-between">
            <nav id="access" class="nav col-12 col-md-auto mb-2 wpestate-justify-content-md-between mb-md-0 ">
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
    </div>
</div>