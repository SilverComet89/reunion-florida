<?php

$main_color                     =   esc_html ( wpresidence_get_option('wp_estate_main_color','') );
$second_color                   =   esc_html ( wpresidence_get_option('wp_estate_second_color','') );
$background_color               =   esc_html( wpresidence_get_option('wp_estate_background_color', '') );
$content_back_color             =   esc_html( wpresidence_get_option('wp_estate_content_back_color', '') );
$header_color                   =   esc_html( wpresidence_get_option('wp_estate_header_color', '') );
$breadcrumbs_font_color         =   esc_html(wpresidence_get_option('wp_estate_breadcrumbs_font_color', '') );
$menu_items_color               =   esc_html(wpresidence_get_option('wp_estate_menu_items_color', '') );
$font_color                     =   esc_html(wpresidence_get_option('wp_estate_font_color', '') );
$link_color                     =   esc_html(wpresidence_get_option('wp_estate_link_color', '') );
$headings_color                 =   esc_html(wpresidence_get_option('wp_estate_headings_color', '') );
$footer_back_color              =   esc_html(wpresidence_get_option('wp_estate_footer_back_color', '') );
$footer_heading_color           =   esc_html(wpresidence_get_option('wp_estate_footer_heading_color', '') );
$footer_font_color              =   esc_html(wpresidence_get_option('wp_estate_footer_font_color', '') );
$footer_copy_color              =   esc_html(wpresidence_get_option('wp_estate_footer_copy_color', '') );
$footer_copy_back_color         =   esc_html(wpresidence_get_option('wp_estate_footer_copy_back_color', '') );

$footer_social_widget_back_color    =   esc_html(wpresidence_get_option('wp_estate_footer_social_widget_back_color', '') );
$footer_social_widget_color         =   esc_html(wpresidence_get_option('wp_estate_footer_social_widget_color', '') );

$sidebar2_font_color            =   esc_html(wpresidence_get_option('wp_estate_sidebar2_font_color', '') );
$menu_font_color                =   esc_html(wpresidence_get_option('wp_estate_menu_font_color', '') );
$menu_hover_back_color          =   esc_html(wpresidence_get_option('wp_estate_menu_hover_back_color', '') );
$menu_hover_font_color          =   esc_html(wpresidence_get_option('wp_estate_menu_hover_font_color', '') );
$menu_border_color              =   esc_html ( wpresidence_get_option('wp_estate_menu_border_color','') );
$agent_color                    =   esc_html(wpresidence_get_option('wp_estate_agent_color', '') );
$top_bar_back                   =   esc_html ( wpresidence_get_option('wp_estate_top_bar_back','') );
$top_bar_font                   =   esc_html ( wpresidence_get_option('wp_estate_top_bar_font','') );
$adv_search_back_color          =   esc_html ( wpresidence_get_option('wp_estate_adv_search_back_color ','') );
$box_content_back_color         =   esc_html ( wpresidence_get_option('wp_estate_box_content_back_color','') );
$box_content_border_color       =   esc_html ( wpresidence_get_option('wp_estate_box_content_border_color','') );
$hover_button_color             =   esc_html ( wpresidence_get_option('wp_estate_hover_button_color','') );
$top_menu_hover_font_color      =  esc_html ( wpresidence_get_option('wp_estate_top_menu_hover_font_color','') );
$active_menu_font_color         =  esc_html ( wpresidence_get_option('wp_estate_active_menu_font_color','') );
$wp_estate_adv_search_tab_font_color         =  esc_html ( wpresidence_get_option('wp_estate_adv_search_tab_font_color','') );
$wp_estate_adv_search_tab_back_font_color    =  esc_html ( wpresidence_get_option('wp_estate_adv_search_tab_back_font_color','') );


$wp_estate_card_details_font_awsome_size=   esc_html ( wpresidence_get_option('wp_estate_card_details_font_awsome_size','') );
$wp_estate_card_details_image_icon_size=   esc_html ( wpresidence_get_option('wp_estate_card_details_image_icon_size','') );
$wp_estate_card_details_font_size=    ( wpresidence_get_option('wp_estate_card_details_font_size','') );
$wp_estate_card_details_alignment=   esc_html ( wpresidence_get_option('wp_estate_card_details_alignment','') );
$wp_estate_card_details_image_position=   esc_html ( wpresidence_get_option('wp_estate_card_details_image_position','') );
$wp_estate_card_details_image_color=   esc_html ( wpresidence_get_option('wp_estate_card_details_image_color','') );
$property_card_agent_show_row=   esc_html ( wpresidence_get_option('property_card_agent_show_row','') );

$wp_estate_menu_header_align=   esc_html ( wpresidence_get_option('wp_estate_menu_header_align','') );
$wp_estate_menu_header_align_abs_centers=   esc_html ( wpresidence_get_option('wp_estate_menu_header_align_abs_centers','') );

$wp_estate_card_details_gap= esc_html ( wpresidence_get_option('wp_estate_card_details_gap','') );



/// Custom Colors
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($main_color != '') {
print'
    
.wpestate_property_card_contact_wrapper_phone:hover,
.wpestate_property_card_contact_wrapper_email:hover,
.wpestate_property_card_contact_wrapper_whatsupp:hover,
#primary .widget-container.twitter_wrapper,    
.wpestate_search_tab_align_center .adv_search_tab_item.active:before,
.search_wr_8.with_search_form_float .adv_search_tab_item.active, 
.search_wr_6.with_search_form_float .adv_search_tab_item.active, 
.adv_search_tab_item.active,
#property_modal_top_bar #add_favorites:hover,
.control_tax_sh:hover,
.mobile_agent_area_wrapper .agent_detail i,
.places_type_2_listings_no,
.payment-container .perpack,
.return_woo_button,
.user_loged .wpestream_cart_counter_header,
.woocommerce #respond input#submit,
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.contact_close_button,
#send_direct_bill,
.featured_property_type1 .featured_prop_price,
.theme_slider_wrapper.theme_slider_2 .theme-slider-price,
.submit_listing,
.wpresidence_button.agency_contact_but,
.developer_contact_button.wpresidence_button,
.term_bar_item:hover:after,
.term_bar_item.active_term:after,
.agent_unit_button:hover,
.unit_type3_details,
#compare_close_modal,
#compare_close,
.adv_handler,
.agency_taxonomy a:hover,
.share_unit,
.wpresidence_button.agency_contact_but,
.developer_contact_button.wpresidence_button,
.property_listing.property_unit_type1 .featured_div,
.featured_property_type2 .featured_prop_price,
.unread_mess,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt,
.slider-property-status,
.wpestate_term_list span,
.term_bar_item.active_term,
.term_bar_item.active_term:hover,
.wpestate_theme_slider_contact_agent,
.carousel-control-theme-prev,
.carousel-control-theme-next,
.wpestream_cart_counter_header_mobile,
.wpestream_cart_counter_header,
.wp-block-search .wp-block-search__button,
.arrow_class_sideways button.slick-prev.slick-arrow:hover, 
.arrow_class_sideways button.slick-next.slick-arrow:hover,
.slider_container button:hover,
.property_title_label:hover,
.single-content input[type="submit"],
.agent_contanct_form input[type="submit"],
.comment-form #submit,
.wpresidence_button,
.wpestate_property_schedule_dates_wrapper button.slick-next.slick-arrow:hover, 
.wpestate_property_schedule_dates_wrapper button.slick-prev.slick-arrow:hover, 
.arrow_class_sideways button.slick-prev.slick-arrow:hover, 
.arrow_class_sideways button.slick-next.slick-arrow:hover,
#advanced_submit_2,
.single-estate_agent .developer_taxonomy a:hover,
.agency_taxonomy a:hover, 
.developer_taxonomy a:hover,
.wpestate-price-component-popoup-done_v3, 
.wpestate-price-component-popoup-reset_v3, 
.wpestate-price-component-popoup-done, 
.wpestate-price-component-popoup-reset, 
.wpestate-beds-baths-popoup-done, 
.wpestate-beds-baths-popoup-reset,
.wp_estate_baths_component_item:hover, 
.wp_estate_beds_component_item:hover, 
.wp_estate_component_item_selected{
    background-color: ' . $main_color . ';
}

.carousel-indicators .active,
.wpestate_control_media_button.slideron, 
.wpestate_control_media_button:active, 
.wpestate_control_media_button:hover,
.property_title_label,
.action_tag_wrapper,
.ribbon-inside{
    background-color: ' . $main_color . 'd9;
}

.ll-skin-melon td .ui-state-active,
.ll-skin-melon td .ui-state-hover {
    background-color: ' . $main_color . '1a!important;
}
.wpestate_property_card_contact_wrapper_phone,
.wpestate_property_card_contact_wrapper_email,
.wpestate_property_card_contact_wrapper_whatsupp,
.single-estate_agent .developer_taxonomy a,
.agency_taxonomy a, 
.developer_taxonomy a,
.wpestate_agent_header2{
    background-color: ' . $main_color . '1a;
}

.wpestate_property_card_contact_wrapper_phone,
.wpestate_property_card_contact_wrapper_email,
.wpestate_property_card_contact_wrapper_whatsupp,
.single-estate_agent .developer_taxonomy a,
.agency_taxonomy a, 
.developer_taxonomy a,
.wpestate-price-component-popoup-done_v3, 
.wpestate-price-component-popoup-reset_v3, 
.wpestate-price-component-popoup-done, 
.wpestate-price-component-popoup-reset, 
.wpestate-beds-baths-popoup-done, 
.wpestate-beds-baths-popoup-reset{
    border: 1px solid ' . $main_color . '1a;
}

.wpestate_property_card_contact_wrapper svg,
.header_transparent .customnav .header_phone svg, 
.header_transparent .customnav .submit_action svg,
.customnav.header_type5 .submit_action svg,
.submit_action svg,
.header_transparent .customnav .submit_action svg,
.agent_sidebar_mobile svg, .header_phone svg,
.listing_detail svg, .property_features_svg_icon{
    fill: ' . $main_color . ';
}

#tab_prpg li{
    border-right: 1px solid ' . $main_color . ';
}

.submit_container #aaiu-uploader{
    border-color: ' . $main_color . '!important;
}
    
.comment-form #submit:hover,
.shortcode_contact_form.sh_form_align_center #btn-cont-submit_sh:hover,
.single-content input[type="submit"]:hover,
.agent_contanct_form input[type="submit"]:hover,
.wpresidence_button:hover{
    border-color: ' . $main_color . ';
    background-color: transparent;
}


.page-template-front_property_submit #modal_login_wrapper .form-control:focus{
    box-shadow: inset 0 0px 1px rgb(0 0 0 / 8%), 0 0 8px ' . $main_color . '20;
    -webkit-box-shadow: inset 0 0px 1px rgb(0 0 0 / 8%), 0 0 8px ' . $main_color . '20;
}

.developer_taxonomy a:hover,
.wpresidence_button.agency_contact_but,
.developer_contact_button.wpresidence_button,
.wpresidence_button,
.comment-form #submit,
.shortcode_contact_form.sh_form_align_center #btn-cont-submit_sh:hover,
.menu_user_picture{
    border-color: ' . $main_color . ';
}

.no_more_list{
    color:#fff!important;
    border: 1px solid '.$main_color.';
}

#tab_prpg li{
    border-right: 1px solid #ffffff;
}

.wpestate_property_card_contact_wrapper_phone:hover,
.wpestate_property_card_contact_wrapper_email:hover,
.wpestate_property_card_contact_wrapper_whatsupp:hover,
.agency_taxonomy a:hover, .developer_taxonomy a:hover,
.search_wr_8.with_search_form_float .adv_search_tab_item.active, 
.search_wr_6.with_search_form_float .adv_search_tab_item.active, 
.adv_search_tab_item.active,
.carousel-indicators .active,
.featured_agent_listings.wpresidence_button,
.agent_unit_button,
.scrollon,
.wpestate_display_schedule_tour_option.shedule_option_selected,
.wpestate-price-component-popoup-done_v3:hover, 
.wpestate-price-component-popoup-reset_v3:hover, 
.wpestate-price-component-popoup-done:hover,
.wpestate-price-component-popoup-reset:hover, 
.wpestate-beds-baths-popoup-done:hover,
.wpestate-beds-baths-popoup-reset:hover,
.wp_estate_baths_component_item:hover, 
.wp_estate_beds_component_item:hover, 
.wp_estate_component_item_selected {
    border: 1px solid '.$main_color.';
}


.page-template-front_property_submit input[type=text]:focus,
.page-template-front_property_submit textarea:focus,
.mobile-trigger-user .menu_user_picture{
    border: 2px solid ' . $main_color . ';
}

blockquote{
   border-left: 2px solid '.$main_color.';
}

.featured_article_title{
    border-top: 3px solid '.$main_color.'!important;
}

.openstreet_price_marker_on_click_parent .wpestate_marker:before, 
.wpestate_marker.openstreet_price_marker_on_click:before,
.wpestate_marker.openstreet_price_marker:hover:before,
.hover_z_pin:before{
    border-top: 6px solid ' . $main_color . '!important;
}

form.woocommerce-checkout{
    border-top: 3px solid ' . $main_color . ';
}

.woocommerce-error,
.woocommerce-info,
.woocommerce-message {
    border-top-color: ' . $main_color . ';
}

.share_unit:after {
    content: " ";
    border-top: 8px solid ' . $main_color . ';
}


.openstreet_price_marker_on_click_parent .wpestate_marker, 
.wpestate_marker.openstreet_price_marker_on_click,
.wpestate_marker.openstreet_price_marker:hover,
.hover_z_pin,
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus,
.results_header,
#adv-search-header-3,
#tab_prpg>ul,
.wpcf7-form input[type="submit"],
.adv_results_wrapper #advanced_submit_2,
.wpb_btn-info,
#slider_enable_map:hover,
#slider_enable_street:hover,
#slider_enable_slider:hover,
#colophon .social_sidebar_internal a:hover,
#primary .social_sidebar_internal a:hover,
.ui-widget-header,
.slider_control_left,
.slider_control_right,
#slider_enable_slider.slideron,
#slider_enable_street.slideron,
#slider_enable_map.slideron,
#primary .social_sidebar_internal a:hover,
#adv-search-header-mobile,
#adv-search-header-1,
.featured_second_line,
.wpb_btn-info,
.ui-menu .ui-state-focus{
    background-color: ' . $main_color . '!important;
}

.tax_active{
    background-image: none!important;
    background: ' . $main_color . ';
}

.agent_unit_button:hover{
    background-image: linear-gradient(to right, ' . $main_color . ' 50%, #fff 50%);
}

.agent_unit_button:hover{
    background-image: -webkit-gradient(linear, left top, right top, color-stop(50%, ' . $main_color . ' ), color-stop(50%, #fff));
}

.property_title_label a:hover,
.agent_unit_button:hover{
    color:#ffffff!important;
}

.wpresidence_button,
.comment-form #submit{
    background-image:linear-gradient(to right, transparent 50%, ' . $main_color . ' 50%);
}

.wpresidence_button,
.comment-form #submit{
    background-image: -webkit-gradient(linear, left top, right top, color-stop(50%, transparent), color-stop(50%,' . $main_color . ' ));
}

.wpresidence_button_inverse {
    color: ' . $main_color . ';
    background-color: #ffffff;
    background-image: -webkit-gradient(linear, left top, right top, color-stop(50%, ' . $main_color . '), color-stop(50%, #ffffff));
    background-image: linear-gradient(to right, ' . $main_color . ' 50%, #ffffff 50%);
}

.wpresidence_button.wpresidence_button_inverse:hover{
    color:#ffffff!important;
}

.featured_prop_type5 h2:hover,
.pagination>li>a:focus, 
.pagination>li>a:hover, 
.pagination>li>span:focus, 
.pagination>li>span:hover,
.wpestate_property_card_contact_wrapper_whatsupp a,
.wpestate_property_card_contact_wrapper_phone,
.wpestate_property_card_contact_wrapper_email,
.wpestate_property_card_contact_wrapper_whatsupp,
.widget_latest_title a:hover,
.wpestate_top_property_navigation_link.item_active,
.lighbox-image-close-floor i:hover, 
.lighbox-image-close i:hover,
.single-estate_agent .developer_taxonomy a,
.agency_taxonomy a, 
.developer_taxonomy a,
.modal_property_features i,
.modal_property_price,
.propery_price4_grid .price_label,
.property_address_type1_wrapper .fas,
.listing_detail svg,
.property_features_svg_icon,
#google_developer_location:hover,
.newsletter_input:hover,
.property_listing.property_unit_type2 .featured_div:before,
#advanced_submit_shorcode:hover,
.wpresidence_button:hover,
.slider_control_right:hover,
.slider_control_left:hover,
.comment-form #submit:hover,
.wpb_btn-info:hover,
.submit_action:hover,
.unit_type3_details:hover,
.directory_slider #property_size,
.directory_slider #property_lot_size,
.directory_slider #property_rooms,
.directory_slider #property_bedrooms,
.directory_slider #property_bathrooms,
.header_5_widget_icon,
input[type="checkbox"]:checked:before,
.testimonial-slider-container .slick-prev.slick-arrow:hover, .testimonial-slider-container .slick-next.slick-arrow:hover,
.testimonial-slider-container .slick-dots li.slick-active button:before,
.slider_container .slick-dots li button::before,
.slider_container .slick-dots li.slick-active button:before,
.single-content p a:hover,
.agent_unit_social a:hover,
.featured_prop_price .price_label,
.featured_prop_price .price_label_before,.compare_item_head .property_price,#grid_view:hover,
#list_view:hover,
.front_plan_row:hover,.adv_extended_options_text,
.slider-content h3 a:hover,
.agent_unit_social_single a:hover ,
.adv_extended_options_text:hover ,.breadcrumb a:hover , .property-panel h4:hover,
.featured_article:hover .featured_article_right,#contactinfobox,
.featured_property:hover h2 a,
.blog_unit:hover h3 a,.blog_unit_meta .read_more:hover,
.blog_unit_meta a:hover,.agent_unit:hover h4 a,.listing_filter_select.open .filter_menu_trigger,
.wpestate_accordion_tab .ui-state-active a,.wpestate_accordion_tab .ui-state-active a:link,.wpestate_accordion_tab .ui-state-active a:visited,
.theme-slider-price, .agent_unit:hover h4 a,.meta-info a:hover,.widget_latest_price,#colophon a:hover, #colophon li a:hover,
.price_area, .property_listing:hover h4 a,a:hover, a:focus, .top_bar .social_sidebar_internal a:hover,
.featured_prop_price,.user_menu,.user_loged i,
#access .current-menu-item >a, #access .current-menu-parent>a, #access .current-menu-ancestor>a,
.social-wrapper a:hover i,
.agency_unit_wrapper .social-wrapper a i:hover,
.property_ratings i,
.listing-review .property_ratings i,
.term_bar_item:hover,
.agency_social i:hover,
.propery_price4_grid,
.pagination>li>a,
.pagination>li>span,
.wpestate_estate_property_details_section i.fa-check,
 #tab_prpg i.fa-check,
.property-panel i.fa-check,
.starselected_click, .starselected,
.icon-fav-off:hover,
.icon-fav-on,
.page-template-front_property_submit .navigation_container a.active,
.property_listing.property_unit_type3 .icon-fav.icon-fav-on:before,
#infobox_title:hover, .info_details a:hover,.company_headline a:hover i,
.header_type5 #access .sub-menu .current-menu-item >a,
.empty_star:hover:before,
.property_listing.property_unit_type4 .compare-action:hover,
.property_listing.property_unit_type4 .icon-fav-on,
.property_listing.property_unit_type4 .share_list:hover,
.property_listing.property_unit_type2 .share_list:hover,
.compare-action:hover,
.property_listing.property_unit_type2 .compare-action:hover,
.propery_price4_grid span,
.wpresidence_slider_price,
.sections__nav-item,
.section_price,
.showcoupon,
 .listing_unit_price_wrapper,
 .blog2v:hover h4 a,
 .prop_social .share_unit a:hover,
 .prop_social .share_unit a:hover:after,
 #add_favorites.isfavorite,
 #add_favorites.isfavorite i,
 .pack-price_sh,
 .property_slider2_wrapper a:hover h2,
 .agent_contanct_form_sidebar .agent_position,
 .arrow_class_sideways button.slick-prev.slick-arrow,
 .arrow_class_sideways button.slick-next.slick-arrow,
 button.slick-prev.slick-arrow, 
 button.slick-next.slick-arrow,
 .half_map_controllers_wrapper i,
 .wpestate_estate_property_details_section i.fa-check, 
.property-panel i.fa-check, #tab_prpg i.fa-check, 
.wpestate_estate_property_details_section i.fa-check-circle, 
.property-panel i.fa-check-circle, 
#tab_prpg i.fa-check-circle,
i.fas.fa-print:hover,
i.fas.fa-share-alt:hover,
i.far.fa-heart:hover,
.blog2v .read_more:hover,
.wpestate_property_schedule_dates_wrapper button.slick-prev.slick-arrow, 
.arrow_class_sideways button.slick-prev.slick-arrow,
.wpestate_property_schedule_singledate_wrapper.shedule_day_option_selected .wpestate_day_unit_day_number, 
.wpestate_property_schedule_singledate_wrapper:hover .wpestate_day_unit_day_number,
.wpestate_property_schedule_singledate_wrapper.shedule_day_option_selected, 
.wpestate_property_schedule_singledate_wrapper:hover,
.wpestate_property_schedule_dates_wrapper button.slick-next.slick-arrow, 
.arrow_class_sideways button.slick-next.slick-arrow,
.wpestate_display_schedule_tour_option.shedule_option_selected,
.info_details .infocur,
.info_details .prop_pricex,
.propery_price4_grid span,
.subunit_price,
.featured_property.featured_property_type3 .featured_secondline .featured_prop_price,
.featured_property.featured_property_type3 .featured_secondline .featured_prop_price .price_label,
.preview_details,
.preview_details .infocur,
.radius_wrap:after,
.unit_details_x:hover,
.property_slider2_info_price,
.featured_prop_type5 .featured_article_label,
.testimonial-slider-container .slick-dots li button::before,
.bootstrap-select.show-tick .dropdown-menu .selected .glyphicon-ok:before,
.wpestate-price-component-popoup-done_v3:hover, 
.wpestate-price-component-popoup-reset_v3:hover, 
.wpestate-price-component-popoup-done:hover,
.wpestate-price-component-popoup-reset:hover, 
.wpestate-beds-baths-popoup-done:hover,
.wpestate-beds-baths-popoup-reset:hover,
.wpestate_agent_unit_social i:hover,
.agent_unit_email:hover, 
.agent_unit_phone:hover,
.agent_social_share_type2 i:hover,
.company_headline i:hover {
    color: ' . $main_color . ';
}


.header_type5 #access .current-menu-item >a,
.header_type5 #access .current-menu-parent>a,
.header_type5 #access .current-menu-ancestor>a{
    color: #fff!important;
}

.property_listing.property_unit_type7 .icon-fav.icon-fav-on:before, 
.property_listing.property_unit_type3 .icon-fav.icon-fav-on:before, 
.property_listing.property_unit_type4 .icon-fav.icon-fav-on:before,
.social_email:hover,
.share_facebook:hover,
#print_page:hover, 
.prop_social a:hover i,
.single_property_action:hover,
.share_tweet:hover,
.agent_unit_button,
#amount_wd, #amount,#amount_mobile,#amount_sh,
.mobile-trigger-user:hover i, .mobile-trigger:hover i,
.mobilemenu-close-user:hover, .mobilemenu-close:hover,
.header_type5 #access .sub-menu .current-menu-item >a,
.customnav.header_type5 #access .current-menu-ancestor>a,
.icon-fav-on,
.property_listing.property_unit_type3 .icon-fav.icon-fav-on:before,
.property_listing.property_unit_type3 .share_list:hover:before,
.property_listing.property_unit_type3 .compare-action:hover:before,
.agency_socialpage_wrapper i:hover,
.advanced_search_sidebar #amount_wd,
.section_price,
.sections__nav-item,
.icon_selected{
    color: ' . $main_color . '!important;
}


.testimonial-slider-container .slick-dots li.slick-active button:before {
    opacity: .75;
    color: ' . $main_color . ' !important;
}

.submit_listing{
    border-color: ' . $main_color . ';
    background-image: -webkit-gradient(linear, left top, right top, color-stop(50%, transparent), color-stop(50%, ' . $main_color . '));
    background-image: linear-gradient(to right, transparent 50%, ' . $main_color . ' 50%);
}

a.submit_listing:hover {
    color: ' . $main_color . ';
    border-color: ' . $main_color . ';
}
';


}



if ($second_color != '') {
print'


    .unit_details_x:hover{
        background:transparent;
    }

    .unit_details_x a,
    .unit_details_x,
    .unit_details_x:hover{
        border: 1px solid ' . $second_color . ';
    }

    .unit_details_x a,
    .unit_details_x{
        background-image: -webkit-gradient(linear, left top, right top, color-stop(50%, transparent), color-stop(50%, ' . $second_color . '));
        background-image: linear-gradient(to right, transparent 50%, ' . $second_color . ' 50%);
    }

     .page-template-user_dashboard_add .wpresidence_button:hover{
        color:white;
    }

    .acc_google_maps:hover,
    .schedule_meeting:hover,
    .user_role_status,
    .agent_card_my_listings,
    .unit_details_x,
    .col-md-4 > .agent_unit .agent_card_my_listings,
    .agent_card_my_listings,
    .menu_label,
    .wpestate_marker.sales{
    	background-color: ' . $second_color . ';
    }

    .wpestate_marker.sales:before {
        border-top: 6px solid ' . $second_color . ';
    }

    .acc_google_maps,
    .schedule_meeting,
    .featured_div{
    	background-color: ' . $second_color . 'd9;
    }

    ';
}



// end $second_color


if ($background_color != '') {
print'body,.wide,#google_map_prop_list_sidebar,.estate_property-template-default.elementor-default .wpestate_content_wrapper_custom_template_wrapper, .estate_property-template-default.wpb-js-composer .wpestate_content_wrapper_custom_template_wrapper {background-color: ' . $background_color . ';} ';
} // end $background_color


if ($content_back_color != '') {
print '.content_wrapper,.agency_contact_class{ background-color: ' . $content_back_color . ';} ';
}// end content_back_color


if ($header_color != '') {
print'
    .fixed_header.header_transparent .header_wrapper,
    .header_transparent .header_wrapper.navbar-fixed-top.customnav,
    .master_header,
    .header_wrapper.header_type4,
    .customnav,
    .header5_bottom_row_wrapper,
    .header_wrapper.header_type5.customnav,
    .header_type3_menu_sidebar{
        background-color: ' . $header_color . '
    }';
} // end $header_color


if ($breadcrumbs_font_color != '') {
print '
    .featured_article_righ, .featured_article_secondline,
    .property_location .inforoom, .property_location .infobath , .agent_meta , .blog_unit_meta a, .property_location .infosize,
    .sale_line , .meta-info a, .breadcrumb > li + li:before, .blog_unit_meta,
    .meta-info,
    .breadcrumb a,
    .wpestate_dashboard_list_header .btn-group .dropdown-toggle,
    .page-template-front_property_submit select,
    .form-control,
    .adv-search-1 .form-control,
    .caret::after,
    .bootstrap-select .dropdown-menu>li>a,
    .bootstrap-select > .wpestate-multiselect-custom-style.dropdown-toggle.bs-placeholder,
    .show-tick.form-control .btn-default,
    .wpestate-beds-baths-popoup-component.open>.dropdown-toggle.btn-default,
    .filter_menu,
    .wpestate-multiselect-custom-style, .btn.wpestate-multiselect-custom-style,
    .ui-autocomplete.ui-widget-content,
    .bootstrap-select > .wpestate-multiselect-custom-style.dropdown-toggle.bs-placeholder, 
    .bootstrap-select > .wpestate-multiselect-custom-style.dropdown-toggle.bs-placeholder:hover,
    .filter_menu, .ui-autocomplete.ui-widget-content, 
    .dropdown-menu.wpestate-price-popoup-wrapper_v3, 
    .dropdown-menu.wpestate-price-popoup-wrapper, 
    .bootstrap-select .dropdown-menu,
    input[type=text], 
    input[type=password], 
    input[type=email],
    input[type=url], 
    input[type=number], 
    textarea,
    .ui-menu .ui-menu-item,
    .dropdown.bootstrap-select.show-tick.form-control.wpestate-.bs3.open button.actions-btn.bs-select-all.btn.btn-default,
    .dropdown.bootstrap-select.show-tick.form-control.wpestate-.bs3.open button.actions-btn.bs-deselect-all.btn.btn-default{
        color: ' . $breadcrumbs_font_color . ';
    }
    
    .property_unit_content_grid_big_details .blog_unit_meta{
        color:#ffffff;
    }

    .form-control::placeholder,
    input::placeholder,
    .adv-search-1 input[type=text],
    #schedule_hour,
    #agent_comment.form-control,
    #new_user_type,
    #new_user_type_mobile{
        color: ' . $breadcrumbs_font_color . '!important;
    }'
    ;

    print '.caret, .caret_sidebar, .advanced_search_shortcode .caret_filter{ border-top-color:' . $breadcrumbs_font_color . ';}';
    
} // end $breadcrumbs_font_color


if ($menu_font_color != '') {
    print '
    
    .header_type5 .submit_action svg,
    .header5_user_wrap 
    .header_phone svg, 
    .header5_user_wrap {
        fill: ' . $menu_font_color . ';
    }

    .header5_bottom_row .header_phone a,
    .header5_user_wrap .header_phone a,
    .header_phone a,
    .customnav.header_type5 #access .menu-main-menu-container>ul>li>a,
    .header_type5 #access .menu-main-menu-container>ul>li>a,
    #header4_footer,
    #header4_footer .widget-title-header4,
    #header4_footer a,
    #access ul.menu >li>a{
        color: ' . $menu_font_color . ';
    }
    
    .header5_bottom_row .header_phone svg, 
    .header5_bottom_row .submit_action svg{
        fill: ' . $menu_font_color . ';
    }
    
    .header_type5 .navicon, .header_type5 .navicon:after, 
    .header_type5 .navicon:before {
        background: ' . $menu_font_color . ';
    }

    .menu_user_picture{
        border-color:' . $menu_font_color . ';
    }

    .navicon:before,
    .navicon:after,
    .navicon{
        background: '.$menu_font_color.';
     }';
}

$transparent_menu_font_color                =  esc_html ( wpresidence_get_option('wp_estate_transparent_menu_font_color','') );
if ($transparent_menu_font_color != '') {
    print '
    .header_transparent .header_phone svg,
    .header_transparent .header_phone a,
    .header_transparent .menu_user_tools,
    .header_transparent #access ul.menu >li>a{
        color: ' . $transparent_menu_font_color . ';
    }

     .header_transparent .header_phone a, 
     .header_transparent .header_phone svg, 
     .header_transparent .submit_action svg{
        fill: ' . $transparent_menu_font_color . ';
    }

    .header_transparent .navicon:before,
    .header_transparent .navicon:after,
    .header_transparent .navicon{
        background: ' . $transparent_menu_font_color . ';
    }
    .header_transparent .menu_user_picture{
        border-color: ' . $transparent_menu_font_color . ';
    }
    ';



}


if($top_menu_hover_font_color!=''){

    print '
    .customnav.header_type5 #access .menu-main-menu-container>ul>li:hover>a,
    .header_type5 #access .menu-main-menu-container>ul>li:hover>a,
    #access .menu li:hover>a,
    .header_type3_menu_sidebar #access .menu li:hover>a,
    .header_type3_menu_sidebar #access .menu li:hover>a:active,
    .header_type3_menu_sidebar #access .menu li:hover>a:focus,
    .customnav #access ul.menu >li>a:hover,
    #access ul.menu >li>a:hover,
    .hover_type_3 #access .menu > li:hover>a,
    .hover_type_4 #access .menu > li:hover>a,
    .hover_type_6 #access .menu > li:hover>a,
    .header_type5 #access .menu li:hover>a,
    .header_type5 #access .menu li:hover>a:active,
    .header_type5 #access .menu li:hover>a:focus,
    .customnav.header_type5 #access .menu li:hover>a,
    .customnav.header_type5 #access .menu li:hover>a:active,
    .customnav.header_type5 #access .menu li:hover>a:focus,
    .header5_bottom_row_wrapper #access .sub-menu .current-menu-item >a,
    #access ul.menu .current-menu-item >a,
    #access .menu li:hover>a:active, 
    #access .menu li:hover>a:focus{
        color: ' . $top_menu_hover_font_color . ';
    }
    
    .hover_type_5 #access .menu > li:hover>a {
        border-bottom: 3px solid ' . $top_menu_hover_font_color . ';
    }
    
    .header_transparent .customnav .hover_type_6 #access .menu > li:hover>a,
    .hover_type_6 #access .menu > li:hover>a {
      border: 2px solid ' . $top_menu_hover_font_color . ';
    }
    
    .header_transparent .master_header_sticky .hover_type_2 #access .menu > li:hover>a:before,
    .hover_type_2 #access .menu > li:hover>a:before {
        border-top: 3px solid ' . $top_menu_hover_font_color . ';
    }
   
    
    .header_transparent .customnav #access ul.menu >li>a:hover,
    .customnav.header_type5 #access .menu li:hover>a{
       color: ' . $top_menu_hover_font_color . '!important;
    }';


}
$transparent_menu_hover_font_color               =  esc_html ( wpresidence_get_option('wp_estate_transparent_menu_hover_font_color','') );


if($active_menu_font_color!=''){
     print '
        .wpestate_top_property_navigation_link.item_active,
        #access .current-menu-item,
        #access ul.menu .current-menu-item >a{
            color: ' . $active_menu_font_color . ';
        }
       ';
}

if($transparent_menu_hover_font_color!=''){

    print '
    .header_transparent .customnav #access ul.menu >li>a:hover,
    .header_transparent #access ul.menu >li>a:hover,
    .header_transparent .hover_type_3 #access .menu > li:hover>a,
    .header_transparent .hover_type_4 #access .menu > li:hover>a,
    .header_transparent .hover_type_6 #access .menu > li:hover>a,
    .header_transparent .customnav #access .menu > li:hover a{
        color: ' . $transparent_menu_hover_font_color . ';
    }
    .header_transparent .hover_type_5 #access .menu > li:hover>a {
        border-bottom: 3px solid ' . $transparent_menu_hover_font_color . ';
    }
    .header_transparent .hover_type_6 #access .menu > li:hover>a {
      border: 2px solid ' . $transparent_menu_hover_font_color . ';
    }
    .header_transparent .hover_type_2 #access .menu > li:hover>a:before {
        border-top: 3px solid ' . $transparent_menu_hover_font_color . ';
    }

    .header_transparent .header_phone a:hover,
    .header_transparent #access ul.menu >li>a:hover,
    .header_transparent .hover_type_3 #access .menu > li:hover>a,
    .header_transparent .hover_type_3 #access ul.menu >li>a:hover{
        color: ' . $transparent_menu_hover_font_color . '!important;
    }
    
    .header_transparent .submit_action svg:hover{
        fill: ' . $transparent_menu_hover_font_color . ';
    }
    ';


}



$top_menu_hover_back_font_color                =  esc_html ( wpresidence_get_option('wp_estate_top_menu_hover_back_font_color','') );
if($top_menu_hover_back_font_color !=''){
    print '
     .alalx223,
       .header_type3_menu_sidebar .menu > li:hover,
    .hover_type_3 #access .menu > li:hover>a,
    .hover_type_4 #access .menu > li:hover>a {
        background: '.$top_menu_hover_back_font_color.'!important;
    }';
}


$sticky_menu_font_color                =  esc_html ( wpresidence_get_option('wp_estate_sticky_menu_font_color','') );
if($sticky_menu_font_color!=''){
    print '
        
    .customnav .header_phone a, 
    .header_transparent .customnav .header_phone a,    
    .customnav.header_type5 #access .menu-main-menu-container>ul>li>a,
    .customnav #access ul.menu >li>a,
    .customnav .header5_bottom_row .header_phone a{
        color: ' . $sticky_menu_font_color . ';
    }
    
    .customnav .header5_bottom_row .header_phone svg, 
    .customnav .header5_bottom_row .submit_action svg,
    .customnav.header_type5 .submit_action svg,
    .header_transparent .customnav .header_phone svg{
        fill: ' . $sticky_menu_font_color . ';
    }   

    .customnav .menu_user_picture{
        border-color:' . $sticky_menu_font_color . ';
    }

    .header_transparent .customnav #access ul.menu >li>a{
        color: ' . $sticky_menu_font_color . ';
    }
    
    .customnav.header_type5 .navicon, 
    .customnav.header_type5 .navicon:after, 
    .customnav.header_type5 .navicon:before,
    .customnav .navicon:before,
    .customnav .navicon:after,
    .customnav .navicon{
        background: '.$sticky_menu_font_color.';
    }';

}


$menu_item_back_color         =  esc_html ( wpresidence_get_option('wp_estate_menu_item_back_color','') );
if($menu_item_back_color!=''){
    print '
     
    .wpestate_megamenu_class:before,
    #access ul ul{
        background-color: ' . $menu_item_back_color . ';
    }';

}

if ($menu_hover_back_color != '') {
    print '
    #user_menu_open > li > a:hover,
    #user_menu_open > li > a:focus,
    .sub-menu li:hover, #access .menu li:hover>a,
    #access .menu li:hover>a:active,
    #access .menu li:hover>a:focus{
        background-color: '.$menu_hover_back_color.';
    }
     

    .customnav.header_type5 #access .menu .with-megamenu .sub-menu li:hover>a,
    .customnav.header_type5 #access .menu .with-megamenu .sub-menu li:hover>a:active,
    .customnav.header_type5 #access .menu .with-megamenu .sub-menu li:hover>a:focus,
    .header_type5 #access .menu .with-megamenu .sub-menu li:hover>a,
    .header_type5 #access .menu .sub-menu .with-megamenu li:hover>a:active,
    .header_type5 #access .menu .sub-menu .with-megamenu li:hover>a:focus,
    #access .with-megamenu .sub-menu li:hover>a,
    #access .with-megamenu .sub-menu li:hover>a:active,
    #access .with-megamenu .sub-menu li:hover>a:focus,
    .menu_user_tools{
        color: '.$menu_hover_back_color.';
    }

    .menu_user_picture {
        border: 1px solid '.$menu_hover_back_color.';
    }
    ';
} // end $menu_hover_back_color


if ($menu_hover_font_color != '') {
    print '
    #access .menu ul li:hover>a,
    #access .sub-menu li:hover>a,
    #access .sub-menu li:hover>a:active,
    #access .sub-menu li:hover>a:focus,
    .header5_bottom_row_wrapper #access .sub-menu .current-menu-item >a,
    .customnav.header_type5 #access .menu .sub-menu li:hover>a,
    .customnav.header_type5 #access .menu .sub-menu li:hover>a:active,
    .customnav.header_type5 #access .menu .sub-menu li:hover>a:focus,
    .header_type5 #access .menu .sub-menu li:hover>a,
    .header_type5 #access .menu .sub-menu li:hover>a:active,
    .header_type5 #access .menu .sub-menu li:hover>a:focus,
    #user_menu_open > li > a:hover,
    #user_menu_open > li > a:focus{
        color: '.$menu_hover_font_color.';
    }
    
    #user_menu_open  > li > a:hover svg circle,
    #user_menu_open  > li > a:focus svg circle,
    #user_menu_open  > li > a:hover svg path,
    #user_menu_open  > li > a:focus svg path,
    #user_menu_open a svg:hover{
        color: '.$menu_hover_font_color.';
        stroke:'.$menu_hover_font_color.';  
    }

    .header_transparent .customnav #access .sub-menu li:hover>a,
    .customnav.header_type5 #access .menu .sub-menu li:hover>a{
        color: '.$menu_hover_font_color.'!important;
    }
    ';
} // end $menu_hover_font_color


if($menu_border_color!=''){
    print'#access ul ul {
        border-left: 1px solid   #'.$menu_border_color.'!important;
        border-right: 1px solid  #'.$menu_border_color.'!important;
        border-bottom: 1px solid #'.$menu_border_color.'!important;
        border-top: 1px solid #'.$menu_border_color.'!important;
    }
    #access ul ul a {
        border-bottom: 1px solid '.$menu_border_color.';
    }';
}

$wp_estate_top_menu_font_size     = wpresidence_get_option('wp_estate_top_menu_font_size','');
if($wp_estate_top_menu_font_size!=''){
    print '
        .submit_listing,
        .header_phone,
        #access ul.menu >li>a{
        font-size:' . $wp_estate_top_menu_font_size . 'px;
    }';
}

$wp_estate_menu_item_font_size     = wpresidence_get_option('wp_estate_menu_item_font_size','');

if($wp_estate_menu_item_font_size!=''){
    print '
        #access ul ul a,
        #access ul ul li.wpestate_megamenu_col_1,
        #access ul ul li.wpestate_megamenu_col_2,
        #access ul ul li.wpestate_megamenu_col_3,
        #access ul ul li.wpestate_megamenu_col_4,
        #access ul ul li.wpestate_megamenu_col_5,
        #access ul ul li.wpestate_megamenu_col_6,
        #access ul ul li.wpestate_megamenu_col_1 a,
        #access ul ul li.wpestate_megamenu_col_2 a,
        #access ul ul li.wpestate_megamenu_col_3 a,
        #access ul ul li.wpestate_megamenu_col_4 a,
        #access ul ul li.wpestate_megamenu_col_5 a,
        #access ul ul li.wpestate_megamenu_col_6 a,
        #access ul ul li.wpestate_megamenu_col_1 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link{
            font-size:' . $wp_estate_menu_item_font_size . 'px;
    }';
}




if ($menu_items_color != '') {
    print '
        #access a,
        #access ul ul a,
        #access ul ul li.wpestate_megamenu_col_1,
        #access ul ul li.wpestate_megamenu_col_2,
        #access ul ul li.wpestate_megamenu_col_3,
        #access ul ul li.wpestate_megamenu_col_4,
        #access ul ul li.wpestate_megamenu_col_5,
        #access ul ul li.wpestate_megamenu_col_6,
        #access ul ul li.wpestate_megamenu_col_1 a,
        #access ul ul li.wpestate_megamenu_col_2 a,
        #access ul ul li.wpestate_megamenu_col_3 a,
        #access ul ul li.wpestate_megamenu_col_4 a,
        #access ul ul li.wpestate_megamenu_col_5 a,
        #access ul ul li.wpestate_megamenu_col_6 a,
        #access ul ul li.wpestate_megamenu_col_1 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link,
        .header_type5 #access .sub-menu a, 
        .wpestate_top_property_navigation a{
           color:'.$menu_items_color.';
        }';

   print '

       #access .with-megamenu .megamenu-title a,
       #access ul ul li.wpestate_megamenu_col_1 .megamenu-title:hover a,
       #access ul ul li.wpestate_megamenu_col_2 .megamenu-title:hover a,
       #access ul ul li.wpestate_megamenu_col_3 .megamenu-title:hover a,
       #access ul ul li.wpestate_megamenu_col_4 .megamenu-title:hover a,
       #access ul ul li.wpestate_megamenu_col_5 .megamenu-title:hover a,
       #access ul ul li.wpestate_megamenu_col_6 .megamenu-title:hover a,
       #access .current-menu-item >a,
       #access .current-menu-parent>a,
       #access .current-menu-ancestor>a{
        color: ' . $menu_items_color . ';
    }

    .header_transparent .customnav #access .sub-menu li a{
        color: ' . $menu_items_color . '!important;
    }
            ';




}





if ($font_color != '') {
print'
body,a,label,
.slider-content, 
.listing-details, 
#user_menu_open i,
#grid_view, #list_view, 
.listing_details a, 
.adv_search_slider label,
.extended_search_checker label,
.slider_radius_wrap,
 #tab_prpg .tab-pane li,
 #tab_prpg .tab-pane li:first-of-type,
.notice_area, 
.social-agent-page a, 
.prop_detailsx, 
#reg_passmail_topbar,
#reg_passmail, 
.testimonial-text,
.wpestate_tabs 
.ui-widget-content,
.wpestate_tour 
.ui-widget-content, 
.wpestate_accordion_tab .ui-widget-content,
.wpestate_accordion_tab .ui-state-default, 
.wpestate_accordion_tab .ui-widget-content .ui-state-default,
.wpestate_accordion_tab .ui-widget-header .ui-state-default,
.property_listing_details .infosize,
.property_listing_details .infobath,
.property_listing_details .inforoom,
.directory_sidebar label,
.agent_detail a,
.agent_unit .agent_detail a,
.agent_detail,
.agent_position,
.property_listing.property_unit_type8 .property_card_categories_wrapper a,
.agent_unit_social_single a,
.agent_social_share_type2 i,
.company_headline i,
#inforoom,
#infobath,
#infosize{ 
    color: ' . $font_color . ';}

.single-estate_agency .agent_detail svg,
.single-agent .agent_detail svg,
.inforoom path, .infobath path, .infosize path,
.agent_detail svg{
    fill: ' . $font_color . ';}';
}

 // end $font_color #a0a5a8



if ($link_color != '') {

print '
.pagination > li > a,
.pagination > li > span,
.single-content p a,
.featured_article:hover h2 a,
.user_dashboard_listed a,
.blog_unit_meta .read_more,
.slider-content .read_more,
.blog2v .read_more,
.breadcrumb .active,
.unit_more_x a, .unit_more_x,
#login_trigger_modal{
    color: '.$link_color.';
}

.single-content p a,
.contact-wrapper p a{
color: '.$link_color.'!important;
}

';

} // end $link_color



if ($headings_color != '') {
print '
h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
.featured_property h2 a,
.featured_property h2,
.blog_unit h3,
.blog_unit h3 a,
.submit_container_header,
.info_details #infobox_title,
#tab_prpg.wpestate_elementor_tabs li a,
.pack_content,
.property_agent_wrapper a,
.testimonial-container.type_class_3 .testimonial-author-line,
.dashboard_hi_text,
.invoice_unit_title,
.dashbard_unit_title,
.property_dashboard_status,
.property_dashboard_types,
.featured_prop_type5 h2,
#wpestate_sidebar_property_contact_tabs li a{
    color: '.$headings_color.';
}

.featured_property_type2 h2 a {
        color: #fff;
}';
} // end $headings_color



if ($footer_back_color != '') {
print '#colophon {background-color: '.$footer_back_color.';}';
} // end


if ($footer_font_color != '') {
print '#colophon, #colophon a, #colophon li a, #colophon .widget_latest_price {color: '.$footer_font_color.';}';
}

if($footer_heading_color !=''){
    print '#colophon .widget-title-footer{ color: '.$footer_heading_color .';}';
}


if ($footer_copy_color != '') {
    print '.sub_footer, .subfooter_menu a, .subfooter_menu li a {color: '.$footer_copy_color.'!important;}';
}

if($footer_copy_back_color!=''){
    print '.sub_footer{background-color:'.$footer_copy_back_color.';}';
}

if($footer_social_widget_back_color!=''){
    print '#colophon .social_sidebar_internal a{background-color:'.$footer_social_widget_back_color.';}';
}

if($footer_social_widget_color!=''){
    print '#colophon .social_sidebar_internal a{color:'.$footer_social_widget_color.';}';
}



if($top_bar_back!=''){
    print '.top_bar_wrapper{background-color:'.$top_bar_back.';}';
}

if($top_bar_font!=''){
    print '.top_bar,.top_bar a{color:'.$top_bar_font.';}';
}

if ($adv_search_back_color != '') {
    print '
    wpresidence_button advanced_submit_4,
    #advanced_submit_3, 
    .adv-search-1 .wpresidence_button, 
    .adv_handler{
        background-color:'.$adv_search_back_color.';
        border-color:'.$adv_search_back_color.';
        background-image: linear-gradient(to right, transparent 50%, '.$adv_search_back_color.' 50%);
        background-image: -webkit-gradient(linear, left top, right top, color-stop(50%, transparent), color-stop(50%,'.$adv_search_back_color.' ));
     }

    #advanced_submit_3:hover, 
    .adv-search-1 .wpresidence_button:hover,
    .wpresidence_button.advanced_submit_4:hover{
        background-color: transparent;
        color: '.$adv_search_back_color.';
    }

	';
}

if($wp_estate_adv_search_tab_font_color   !=''){
        print '.advanced_search_sidebar .adv_search_tab_item a, 
         .adv_search_tab_item a {
            color: ' . $wp_estate_adv_search_tab_font_color . ';
        }
        
        .adv_search_tab_item.active a{
            color: #ffffff;
        }
';
}

if($wp_estate_adv_search_tab_back_font_color   !=''){
        print '
            .adv_search_tab_item{
                border-color: ' . $wp_estate_adv_search_tab_back_font_color . ';
        }
        
            .adv_search_tab_item{
                background-color: ' . $wp_estate_adv_search_tab_back_font_color . ';
        }
';
}

if ($box_content_back_color != '') {
    print '
        
        .featured_article_title,
        .testimonial-text,
        .advanced_search_shortcode,
        .featured_secondline ,
        .property_listing ,
        .agent_unit, .blog_unit,
        .testimonial-container.type_class_3,
        .testimonial-container.type_class_3 .testimonial-text{
            background-color:'.$box_content_back_color.';
        }

    .testimonial-text:after {
        border-right: 10px solid '.$box_content_back_color.';
    }

';
}

if ($box_content_border_color != '') {
    print '
    .featured_article,.mortgage_calculator_div, .loginwd_sidebar, .advanced_search_sidebar,
    .advanced_search_shortcode, .testimonial-text,
    .featured_property, .property_listing ,.agent_unit,.blog_unit,property_listing{
        border-color:'.$box_content_border_color.';
    }
    
    .testimonial-text:before{
        border-right: 10px solid '.$box_content_border_color.';
    }
    
    .company_headline,
    .listing_filters_head,
    .listing_filters{
        border-bottom: 1px solid '.$box_content_border_color.';
    }

    .listing_filters_head, .listing_filters{
        border-top: 1px solid '.$box_content_border_color.';
    }


    ';
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// End colors


if ($hover_button_color!=''){
    print '

    .with_search_form_float #advanced_submit_2:hover,
    .with_search_form_float #advanced_submit_3:hover, 
    .with_search_form_float .adv-search-1 .wpresidence_button, 
    .adv_handler:hover,
    .with_search_form_float .wpresidence_button.advanced_submit_4:hover{
        color: #fff;
    }
    
    .submit_container #aaiu-uploader:hover,
    .row_user_dashboard .wpresidence_button:hover,
    .with_search_form_float #advanced_submit_3:hover, 
    .with_search_form_float .adv-search-1 .wpresidence_button:hover,
    .with_search_form_float .wpresidence_button.advanced_submit_4:hover{
        background-color: '.$hover_button_color.'!important;
        border-color: '.$hover_button_color.'!important;
    }

    .wpestate_dashboard_content_wrapper .wpresidence_button:hover{
        background-color: '.$hover_button_color.'!important;
    }
    

    .wpresidence_button.developer_contact_button:hover,
    .wpresidence_button.agency_contact_but:hover,
    .woo_pay_submit:hover, 
    .woo_pay:hover,
    .wpestate_crm_lead_actions .btn-group>.btn:active, 
    .wpestate_crm_lead_actions .btn-group>.btn:focus, 
    .wpestate_crm_lead_actions .btn-group>.btn:hover,
    .wpestate_crm_lead_actions .btn-default:focus, 
    .wpestate_crm_lead_actions .btn-default:hover,
    .wpresidence_button.mess_send_reply_button:hover,
    .wpresidence_button.mess_send_reply_button2:hover,
    #floor_submit:hover,
    #register_agent:hover,
    #update_profile_agency:hover,
    #update_profile_developer:hover,
    .wpresidence_success:hover,
    #update_profile:hover,
    #search_form_submit_1:hover,
    .view_public_profile:hover,
    #google_developer_location:hover,
    .wpresidence_button.add_custom_parameter:hover,
    .wpresidence_button.remove_parameter_button:hover,
    .wpresidence_button.view_public_profile:hover,
    .property_dashboard_action .btn-default:hover,
    .property_dashboard_action .btn-group.open .dropdown-toggle.active,
    .property_dashboard_action .btn-group.open .dropdown-toggle:focus,
    .property_dashboard_action .btn-group.open .dropdown-toggle:hover,
    .property_dashboard_action .btn-group.open .dropdown-toggle:active,
    .property_dashboard_action .btn-group.open .dropdown-toggle,
    .carousel-control-theme-prev:hover,
    .carousel-control-theme-next:hover,
    .wpestate_theme_slider_contact_agent:hover,
    .slider_container button:hover,
    .page-template-user_dashboard_add .wpresidence_button:hover,
    #change_pass:hover,
    #register_agent:hover,
    #update_profile_agency:hover,
    #update_profile_developer:hover,
    .wpresidence_success:hover,
    #update_profile:hover,
    #search_form_submit_1:hover,
    .view_public_profile:hover,
    #google_developer_location:hover,
    #delete_profile:hover,
    #aaiu-uploader:hover,
    .wpresidence_button.add_custom_parameter:hover,
    .wpresidence_button.remove_parameter_button:hover,
    .wpresidence_button.view_public_profile:hover,
    #advanced_submit_2:hover{
        background-color: ' . $hover_button_color . ';
    }


    .wpestate_dashboard_content_wrapper .wpresidence_button:hover,
    .wpresidence_button.mess_send_reply_button:hover,
    .wpresidence_button.mess_send_reply_button2:hover,
    #floor_submit:hover,
    #register_agent:hover,
    #update_profile_agency:hover,
    #update_profile_developer:hover,
    .wpresidence_success:hover,
    #update_profile:hover,
    #search_form_submit_1:hover,
    .view_public_profile:hover,
    #google_developer_location:hover,
    #delete_profile:hover,
    #aaiu-uploader:hover,
    .wpresidence_button.add_custom_parameter:hover,
    .wpresidence_button.remove_parameter_button:hover,
    .wpresidence_button.view_public_profile:hover,
    .property_dashboard_action .btn-default:hover,
    .property_dashboard_action .btn-group.open .dropdown-toggle.active,
    .property_dashboard_action .btn-group.open .dropdown-toggle:focus,
    .property_dashboard_action .btn-group.open .dropdown-toggle:hover,
    .property_dashboard_action .btn-group.open .dropdown-toggle:active,
    .property_dashboard_action .btn-group.open .dropdown-toggle{
        border-color: '.$hover_button_color.';
    }

    .slider_control_right:hover,
    .slider_control_left:hover,
    .wpb_btn-info:hover,
    .unit_type3_details:hover{
        background-color: ' . $hover_button_color . '!important;
    }

    .wpestate_crm_lead_actions .btn-group>.btn:active, 
    .wpestate_crm_lead_actions .btn-group>.btn:focus, 
    .wpestate_crm_lead_actions .btn-group>.btn:hover,
    .wpestate_crm_lead_actions .btn-default:focus, 
    .wpestate_crm_lead_actions .btn-default:hover,
    .header5_bottom_row_wrapper .submit_listing:hover {
        border: 2px solid ' . $hover_button_color . '!important;
    }

    .no_more_list:hover{
        background-color: #fff!important;
        border: 1px solid '. $hover_button_color.';
        color:' . $hover_button_color . '!important;
    }

    .icon_selected,.featured_prop_label{
        color: ' . $hover_button_color . '!important;
    }
    
    .wpresidence_button.developer_contact_button:hover,
    .wpresidence_button.agency_contact_but:hover,
    .page-template-user_dashboard_add .wpresidence_button:hover,
    #change_pass:hover,
    #register_agent:hover,
    #update_profile_agency:hover,
    #update_profile_developer:hover,
    .wpresidence_success:hover,
    #update_profile:hover,
    #search_form_submit_1:hover,
    .view_public_profile:hover,
    #google_developer_location:hover,
    #delete_profile:hover,
    .wpresidence_button.add_custom_parameter:hover,
    .wpresidence_button.remove_parameter_button:hover,
    .wpresidence_button.view_public_profile:hover{
        border: 1px solid ' . $hover_button_color . ';
    } ';

    if ($hover_button_color!='' && $main_color!=''){
        print '
        .header_transparent a.submit_listing:hover{
            border-color: ' . $hover_button_color . ';
            background-image: -webkit-gradient(linear, left top, right top, color-stop(50%, ' . $hover_button_color.'), color-stop(50%, ' . $main_color . '));
            background-image: linear-gradient(to right, ' . $hover_button_color.' 50%, ' . $main_color . ' 50%);
        }';
    }

}



//
$user_dashboard_menu_color      =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_menu_color','') );
if( $user_dashboard_menu_color  !=''){
    print'.user_dashboard_links a,.dashboard_username{  color: ' . $user_dashboard_menu_color . ';}';
    print'.ui-autocomplete .ui-menu-item .ui-state-focus, .ui-menu .ui-state-focus {  color: ' . $user_dashboard_menu_color . '!important;}';
    print'.user_dashboard_links a svg path,.user_dashboard_links a svg circle{  stroke: ' . $user_dashboard_menu_color . ';}';
}

$user_dashboard_menu_hover_color      =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_menu_hover_color','') );
if( $user_dashboard_menu_hover_color  !=''){
    print'.user_dashboard_links a:hover,.dropdown-menu>li>a:hover{  color: ' . $user_dashboard_menu_hover_color . ';}';
    print'.user_dashboard_links a:hover svg path, .user_dashboard_links a:hover svg circle{ stroke: ' . $user_dashboard_menu_hover_color . ';}';
}

$user_dashboard_menu_color_hover  =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_menu_color_hover','') );
if( $user_dashboard_menu_color_hover  !=''){
    print '#open_packages:hover .fa,.secondary_menu_sidebar a.secondary_select, #open_packages:hover{color:'.$user_dashboard_menu_color_hover.'}';
    print'.user_dashboard_links .user_tab_active{  background-color: ' . $user_dashboard_menu_color_hover . ';}';
 }

$user_dashboard_menu_back      =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_menu_back ','') );
if( $user_dashboard_menu_back   !=''){
    print'.col-md-3.user_menu_wrapper{ background-color: ' . $user_dashboard_menu_back  . ';}';
}

$user_dashboard_package_back      =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_package_back ','') );
if( $user_dashboard_package_back   !=''){
    print'.dashboard_package_row { background-color: ' . $user_dashboard_package_back. ';}';
}

$user_dashboard_package_color     =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_package_color ','') );
if( $user_dashboard_package_color   !=''){
    print'.submit-price,.pack_description_unit.pack_description_details,.open_pack_on, #open_packages:hover .fa, #open_packages:hover,.pack-name,.property_dashboard_price { color: ' . $user_dashboard_package_color. ';}';
}

$user_dashboard_buy_package     =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_buy_package ','') );
if( $user_dashboard_buy_package   !=''){
    print '.package_selected { border: 1px solid '.$user_dashboard_buy_package.'2e;}';
    print'.package_selected .buypackage { background-color: ' . $user_dashboard_buy_package. ';}';
    print'#open_packages:hover .fa,#open_packages:hover,.buypackage input[type="checkbox"]:checked:before,input[type="checkbox"]:checked:before { color: ' . $user_dashboard_buy_package. ';}';
}

$user_dashboard_package_select     =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_package_select ','') );
if( $user_dashboard_package_select   !=''){
    print'.buypackage,.buypackage input[type="checkbox"] { background-color: ' . $user_dashboard_package_select. ';}';
    print'.pack-unit h4 { color: ' . $user_dashboard_package_select. ';}';
}

$user_dashboard_content_back     =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_content_back ','') );
if( $user_dashboard_content_back   !=''){
    print'.dashboard-margin { background-color: ' . $user_dashboard_content_back . ';}';
}

$user_dashboard_content_button_back     =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_content_button_back  ','') );
if( $user_dashboard_content_button_back    !=''){
    print'
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus,
    .property_dashboard_action .btn-default:focus,
    .print_invoice, .property_dashboard_actions_button,
    #stripe_cancel,#update_profile, #change_pass,
    .wpresidence_success,
    .page-template-user_dashboard_add .wpresidence_button,
    .page-template-user_dashboard .wpresidence_button,
    .wpb_btn-success,#register_agent,
    #update_profile_agency,
    #update_profile_developer, #update_profile,
    #delete_profile,.dashboard-margin .wpresidence_button.view_public_profile,
    #search_form_submit_1,
    .add_custom_data_cont button.add_custom_parameter,
    .add_custom_data_cont button.remove_parameter_button,
    .page-template-user_dashboard_add .wpresidence_button,
    #change_pass,
    .mess_delete,
    .mess_reply,
    .woo_pay_submit{
        background-color: ' . $user_dashboard_content_button_back  . ';
    }

    .wpestate_dashboard_content_wrapper .wpresidence_button{
        background-color: ' . $user_dashboard_content_button_back  . ';
    }
    
    .wpestate_dashboard_content_wrapper input[type=text]:focus, 
    .wpestate_dashboard_content_wrapper input[type=password]:focus, 
    .wpestate_dashboard_content_wrapper input[type=email]:focus, 
    .wpestate_dashboard_content_wrapper input[type=url]:focus, 
    .wpestate_dashboard_content_wrapper input[type=number]:focus, 
    .wpestate_dashboard_content_wrapper textarea:focus,
    .btn-group.wpestate_dashhboard_filter.open,
    .btn-group.wpestate_dashhboard_filter.visited,
    .btn-group.wpestate_dashhboard_filter.active,
    .btn-group.wpestate_dashhboard_filter.focus,
    .btn-group.wpestate_dashhboard_filter:hover,
    #prop_name:focus{
        border: 2px solid ' . $user_dashboard_content_button_back  . '!important;
    }

    .page-template-user_dashboard_add .wpresidence_button,
    #change_pass,
    .wpestate_dashboard_content_wrapper .wpresidence_button,
    #search_form_submit_1 {
        border-color: ' . $user_dashboard_content_button_back  . ';
    }

    .page-template-user_dashboard_add .wpresidence_button,
    #change_pass,
    .wpestate_dashboard_content_wrapper .wpresidence_button{
        background-image: -webkit-gradient(linear, left top, right top, color-stop(50%, transparent), color-stop(50%, ' . $user_dashboard_content_button_back  . '));
        background-image: linear-gradient(to right, transparent 50%, ' . $user_dashboard_content_button_back  . ' 50%);
    }

    .row_user_dashboard .pagination>li>a,
    .row_user_dashboard .pagination>li>span{
        color: ' . $user_dashboard_content_button_back  . ';
    }';

    if ($user_dashboard_content_button_back!=''){
        print ' .row_user_dashboard .pagination > .active > a{
            color:#fff;
        }';
    }


    print '
    .wpestate_dashboard_content_wrapper .featured_div{
        background-color: ' . $user_dashboard_content_button_back  . 'd9;
    }

    .dashboard_agent_listing_image:after,
    .dashbard_unit_image:after{
        background-color: ' . $user_dashboard_content_button_back  . '80;
    }';
}

$user_dashboard_content_color     =  esc_html ( wpresidence_get_option('wp_estate_user_dashboard_content_color','') );
if( $user_dashboard_content_color    !=''){
    print'
    .wpestate_dashboard_table_list_header, 
    .wpestate_dashboard_content_wrapper label,
    .dashboard-margin .entry-title,.user_details_row, 
    .change_pass,.user_details_row, 
    .change_pass,.user_profile_explain, 
    .profile-page label, 
    .pass_note, 
    .upload_explain, 
    .full_form_image,
    .invoice_totals,
    .invoice_unit_title,
    .invoice_unit,
    .col-md-12.row_dasboard-prop-listing h4 { 
        color: ' . $user_dashboard_content_color . ';
    }';
}

$mobile_header_background_color       =  esc_html ( wpresidence_get_option('wp_estate_mobile_header_background_color','') );
if($mobile_header_background_color   !=''){
    print'.mobile_header {background-color: '.$mobile_header_background_color.';}';
}

$mobile_header_icon_color          =  esc_html ( wpresidence_get_option('wp_estate_mobile_header_icon_color','') );
if($mobile_header_icon_color  !=''){
    print'.mobilemenu-close-user, .mobilemenu-close, .mobile_header i  {color: '.$mobile_header_icon_color.';}';

}

$mobile_menu_font_color          =  esc_html ( wpresidence_get_option('wp_estate_mobile_menu_font_color','') );
if($mobile_menu_font_color  !=''){
    print'
    .mobilex-menu li a,
    .mobilewrapper .header_phone a,
    .sub-menu li a,
    #login-div-title-mobile, 
    #register-div-title-mobile, 
    #forgot-div-title-mobile,
    .mobilewrapper-user label, 
    .mobilewrapper-user a, 
    .mobilewrapper-user .widget-title-sidebar{
        color:'.$mobile_menu_font_color .' ;}';
    print'.mobilex-menu li svg path, .mobilex-menu li svg circle {stroke:'.$mobile_menu_font_color .' ;}';
}

$mobile_menu_hover_font_color    =esc_html( wpresidence_get_option('wp_estate_mobile_menu_hover_font_color',''));

if($mobile_menu_hover_font_color  !=''){
    print'.mobilex-menu li a:hover, .mobilex-menu .sub-menu li:hover a{color:'.$mobile_menu_hover_font_color. ';}';
}

$mobile_item_hover_back_color         =  esc_html ( wpresidence_get_option('wp_estate_mobile_item_hover_back_color','') );
if($mobile_item_hover_back_color  !=''){
    print' .mobile_user_menu li:hover, .mobilex-menu li a:hover, .mobilex-menu .sub-menu li:hover {background-color:'.$mobile_item_hover_back_color .';}';
}

 $mobile_menu_backgound_color = esc_html(wpresidence_get_option('wp_estate_mobile_menu_backgound_color', ''));
 if( $mobile_menu_backgound_color !=''){
    print' .mobilex-menu, .snap-drawer { background-color: '.$mobile_menu_backgound_color.' ;}';
 }

$mobile_menu_border_color = esc_html(wpresidence_get_option('wp_estate_mobile_menu_border_color', ''));
if($mobile_menu_border_color !=''){
    print' .mobilex-menu li {border-bottom-color: '.$mobile_menu_border_color.';}';
}




if($wp_estate_card_details_font_awsome_size!=''){
    print '.property_listing_details_v2_item i{
        font-size:'.intval($wp_estate_card_details_font_awsome_size).'px;
    }';
}

if($wp_estate_card_details_image_icon_size!=''){
    print '.property_listing_details_v2_item img{
        max-height:'.intval($wp_estate_card_details_image_icon_size).'px;
    }';
}

if(!empty( $wp_estate_card_details_font_size)){
    print '.property_listing_details_v2_item{';
        if(isset($wp_estate_card_details_font_size['font-size'])){
            print 'font-size:'.intval($wp_estate_card_details_font_size['font-size']).'px;';
        }
        if(isset($wp_estate_card_details_font_size['color'])){
          print' color :'. $wp_estate_card_details_font_size['color'].';';
        }
        if(isset($wp_estate_card_details_font_size['font-size'])){
            print 'font-weight:'.$wp_estate_card_details_font_size['font-weight'].';';
        }
    print '}';
}


if($wp_estate_card_details_alignment!=''){
    print '.property_listing_details_v2{
        justify-content:'.esc_html($wp_estate_card_details_alignment).';
        gap:5px;
    }';
}

if($wp_estate_card_details_gap!=''){
    print '.property_listing_details_v2{      
        gap:'.intval($wp_estate_card_details_gap).'px;
    }';
}


if($wp_estate_card_details_image_position!=''){
    print '.property_listing_details_v2_item {
        flex-direction: '.esc_html($wp_estate_card_details_image_position).';
    }';
}

if($wp_estate_card_details_image_color!=''){
    print '.property_listing_details_v2_item i {
        color: '.esc_html($wp_estate_card_details_image_color).';
    }';
}

if($property_card_agent_show_row=='no'){
    print '.property-unit-information-wrapper {
        padding-bottom: 10px;
    }';
}

if($wp_estate_menu_header_align=='abscenter'){
    print '.has_header_type1 .logo,
        .has_header_type1 .user_menu_wrapper{
        width:'.intval($wp_estate_menu_header_align_abs_centers).'px;
    }

    .has_header_type1 .user_menu_wrapper .wpestate-text-end {
        float: right;
    }';
}




?>
