<?php
/*
*
* User for grid elementor widget only
*
*/


$agent_details =wpestate_return_agent_details('',$agent_id);

$extra= array(
        'class'	=> 'lazyload img-responsive',    
        );



$inline_style=" background-image: url(".esc_attr($agent_details['realtor_image']).");";

if ($agent_details['realtor_image']=='') {
    $inline_style=" background-color: #ddd;";
}

$term_link=$agent_details['link'];
?>



<div class="listing_wrapper elementor_places_wrapper"  <?php echo esc_attr($item_height_style);?> >

    <div class="property_listing places_wrapper_type_1 places_listing" data-link="<?php echo esc_attr($term_link);?>"    style="<?php echo trim($inline_style);?>" >
  <div class="places_cover agent_grid_elementor" data-link="<?php echo esc_attr($term_link);?>" ></div>
        <h4 class="realtor_name""><a href="<?php echo esc_url($term_link); ?>">
            <?php
                echo esc_html($agent_details['realtor_name']);
            ?>
            </a>
        </h4>

        <div class="property_location realtor_position">
            <?php
           echo esc_html($agent_details['realtor_position']);
            ?>
        </div>



    </div>
</div>
