<?php

$main_image = wp_get_attachment_image_src(get_post_thumbnail_id($itemID), 'blog_thumb');
$main_image_url = isset($main_image[0]) ? $main_image[0] : wpresidence_get_option('wp_estate_prop_list_slider_image_palceholder', 'url');

$title = get_the_title($itemID); // Assuming wpestate_return_property_card_title() is not required
$link = esc_url(get_permalink($itemID));

$property_address = esc_html(get_post_meta($itemID, 'property_address', true));
$property_city = get_the_term_list($itemID, 'property_city', '', ', ', '');
$property_area = get_the_term_list($itemID, 'property_area', '', ', ', '');
$address_parts = array_filter([$property_address, $property_city, $property_area]);

$property_size = wpestate_get_converted_measure($itemID, 'property_size');
$property_rooms = get_post_meta($itemID, 'property_rooms', true);
$property_bathrooms = get_post_meta($itemID, 'property_bathrooms', true);

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

$details = array_filter([
    $property_rooms ? $property_rooms . ' ' . esc_html__('Rooms', 'wpresidence') : '',
    $property_bathrooms ? $property_bathrooms . ' ' . esc_html__('Baths', 'wpresidence') : '',
    $property_size
]);
$details_string = implode('<span class="wpestate_separator_dot">&#183;</span>', $details);

?>

<div class="wpestate_content_grid_wrapper_second_col_item_wrapper">
    <div class="wpestate_content_grid_wrapper_second_col_image property_listing" style="background-image:url('<?php echo $main_image_url; ?>')" data-link="<?php echo $link; ?>"></div>

    <div class="property_unit_content_grid_small_details">
        <div class="listing_unit_price_wrapper">
            <?php echo wpestate_show_price($itemID, $wpestate_currency, $where_currency); ?>
        </div>
        <h4>
            <a href="<?php echo $link; ?>" <?php echo $target; ?>>
                <?php echo wp_kses($title, $allowed_html); ?>
            </a>
        </h4>
        <div class="property_unit_content_grid_small_details_location property_unit_content_grid_small_address ">
            <?php echo implode(', ', $address_parts); ?>
        </div>
        <div class="property_unit_content_grid_small_details_location">
            <?php echo $details_string; ?>
        </div>
    </div>
</div>
