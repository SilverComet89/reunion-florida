
<?php
global $align_class;
$wp_estate_unit_card_excerpt_grid = wpresidence_get_option('wp_estate_unit_card_excerpt_grid', '');//90
$wp_estate_unit_card_excerpt_list = wpresidence_get_option('wp_estate_unit_card_excerpt_list', '');//160
$display_style_list ='none';
$display_style_grid ='block';
if($align_class=='the_list_view'){
    $display_style_list ='block';
    $display_style_grid ='none';
}
?>

<div class="listing_details the_grid_view" style="display:<?php echo esc_attr($display_style_grid);?>">
    <?php 
        if(intval($wp_estate_unit_card_excerpt_grid>0)) {
            echo wpestate_strip_excerpt_by_char(get_the_excerpt(), $wp_estate_unit_card_excerpt_grid, $post->ID); 
        }else{
            echo get_the_excerpt();
        }
    ?>
</div>

<div class="listing_details the_list_view" style="display:<?php echo esc_attr($display_style_list);?>">
    <?php 
        if( $wp_estate_unit_card_excerpt_list>0) {
            echo  wpestate_strip_excerpt_by_char(get_the_excerpt(), $wp_estate_unit_card_excerpt_list, $post->ID);
        }else{
            echo get_the_excerpt();
        }
    ?>
</div>