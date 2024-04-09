<div class="header_wrapper_inside  wpestate-flex wpestate-flex-wrap wpestate-align-items-stretch 
    wpestate-justify-content-between 
    <?php echo esc_attr($header_classes['header_wrapper_inside_class']);?>"
    data-logo="<?php print esc_attr($header_classes['logo']);?>"
    data-sticky-logo="<?php print esc_attr($header_classes['stikcy_logo_image']); ?>">


    <nav id="access"  class="nav col-12 col-md-auto mb-2 justify-content-start mb-md-0 ">
        <?php
            wp_nav_menu(
                array(  'theme_location'    => 'primary' ,
                        'walker'            => new wpestate_custom_walker
                    )
            );
        ?>
    </nav><!-- #access -->


    <?php
    // display logo
    print wpestate_display_logo($header_classes['logo']); 
    ?>
      
    <div class="header_6_secondary_menu">  
        <nav id="access">
            <?php
            if(has_nav_menu('header_6_second_menu')):
                wp_nav_menu(
                    array(  'theme_location'    => 'header_6_second_menu' ,
                            'walker'            => new wpestate_custom_walker
                        )
                );
            endif;
            ?>
        </nav><!-- #access -->


        <?php
        // user menu 
        get_template_part('templates/top_user_menu');
        ?>
    </div>
        
</div>