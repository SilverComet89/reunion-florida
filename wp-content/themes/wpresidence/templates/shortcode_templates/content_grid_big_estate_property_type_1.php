<?php

$main_image = wp_get_attachment_image_src(get_post_thumbnail_id($itemID), 'listing_full_slider');
$main_image_url = isset($main_image[0]) ? $main_image[0] : wpresidence_get_option('wp_estate_prop_list_slider_image_palceholder', 'url');

$title = get_the_title($itemID); // Assuming wpestate_return_property_card_title() is not required
$link = esc_url(get_permalink($itemID));

$property_address = esc_html(get_post_meta($itemID, 'property_address', true));
$property_city = get_the_term_list($itemID, 'property_city', '', ', ', '');
$property_area = get_the_term_list($itemID, 'property_area', '', ', ', '');

$address_parts = array_filter([$property_address, $property_city, $property_area]);

$wpestate_currency = esc_html(wpresidence_get_option('wp_estate_currency_symbol', ''));
$where_currency = esc_html(wpresidence_get_option('wp_estate_where_currency_symbol', ''));

$allowed_html = [
    'br' => [],
    'em' => [],
    'strong' => [],
    'b' => []
];

$new_page_option = wpresidence_get_option('wp_estate_unit_card_new_page', '');
$target = $new_page_option === '_self' ? '' : 'target="' . esc_attr($new_page_option) . '"';

?>

<div class="property_unit_type5_content_wrapper property_listing" data-link="<?php echo $link; ?>">

    <div class="property_unit_type5_content" style="background-image:url('<?php echo $main_image_url; ?>')"></div>
    <div class="featured_gradient"></div>

    <div class="property_unit_content_grid_big_details">
        <div class="listing_unit_price_wrapper">
            <?php echo wpestate_show_price($itemID, $wpestate_currency, $where_currency); ?>
        </div>
        <h4>
            <a href="<?php echo $link; ?>" <?php echo $target; ?>>
                <?php echo wp_kses($title, $allowed_html); ?>
            </a>
        </h4>
        <div class="property_unit_content_grid_big_details_location">
            <?php echo implode(', ', $address_parts); ?>
        </div>
    </div>
</div>
