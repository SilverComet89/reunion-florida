<?php
$enable_show_breadcrumbs           =    wpresidence_get_option('wp_estate_show_breadcrumbs');
$wpestate_property_breadcrumbs     =    wpresidence_get_option('wpestate_property_breadcrumbs');

// $property_id comes from custom page builder
if(isset($property_id)){
    $postID=$property_id;
    $enable_show_breadcrumbs='yes';//force showing breadcrumbs for elementro blocks
}else{
    $postID=$post->ID;
}


if($enable_show_breadcrumbs=='yes'){
    $item_custom='';

    if(is_array($wpestate_property_breadcrumbs) && !empty($wpestate_property_breadcrumbs)):

        foreach($wpestate_property_breadcrumbs as $key=>$value){
            $terms= get_the_term_list($postID, $value, '', ', ', '');
            if($terms!=''){
                $item_custom.=  '<li>'. $terms.'</li>';
            }
          
        }

    endif;



?>
<div class="col-xs-12 col-md-12 breadcrumb_container">
    <ol class="breadcrumb">
        <li>
            <a href=" <?php echo esc_url(home_url('/'));?> "><?php print esc_html__('Home','wpresidence');?></a>
        </li>
        <?php
            if($item_custom!=''){
                print trim($item_custom);
            }
        ?>
        <li class="active">
            <?php echo get_the_title($postID);?>
        </li>
    </ol>
</div>


<?php 
} 
?>