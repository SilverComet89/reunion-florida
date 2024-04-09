/*global $,Modernizr, jQuery, ajaxcalls_vars,wpestate_custom_search_start_filtering_ajax,imagesLoaded,wpestate_restart_js_after_ajax, panorama,wpestate_toggleStreetView,wpestate_start_filtering_ajax,map,google,wpestate_new_open_close_map,document,initialGeop,placeCircle,wpestate_custom_search_start_filtering_ajax,first_time_wpestate_show_inpage_ajax_half,wpestate_show_pins, wpestate_load_stats,wpestate_enable_half_map_pin_action,wpestate_change_map_type,wpestate_load_stats_tabs,control_vars,mapfunctions_vars, wpestate_map_shortcode_function,grecaptcha,window*/
var width,height;
width   = jQuery(window).width();
height  = jQuery(window).height();
var scroll_trigger  =   0;
var scroll_modal_save,scroll_modal;
var modal_url       = window.location.href;
var modal_title     = document.getElementsByTagName("title")[0];
var slider_counter = 0;




jQuery(window).bind("load", function() {
    wpestate_lazy_load_carousel_property_unit();
});


if(document.getElementById("search_wrapper")){
    var searchbar       = document.getElementById("search_wrapper");
    var sticky_search   = searchbar.offsetTop;
}



var switch_logo;
switch_logo = jQuery('.header_wrapper_inside').attr('data-sticky-logo');

if(jQuery('.header5_top_row').length > 0){
    switch_logo = jQuery('.header5_top_row').attr('data-sticky-logo');
}
if(wpestate_isRetinaDisplay()){
    switch_logo=wpestate_get_custom_retina_pin(switch_logo);
    
}


var switch_logo_original = jQuery('.header_wrapper_inside').attr('data-logo');
if(jQuery('.header5_top_row').length > 0){
    switch_logo_original = jQuery('.header5_top_row').attr('data-logo');
}

if(wpestate_isRetinaDisplay()){
    switch_logo_original=wpestate_get_custom_retina_pin(switch_logo_original);
}





jQuery(window).scroll(function () {
    "use strict";
    var scroll =scroll_modal= jQuery(window).scrollTop();

    if(control_vars.stiky_search==='yes'){
        wpestate_adv_search_sticky(scroll);
    }else{
        wpestate_header_sticky(scroll);
    }


    if (scroll >= control_vars.scroll_trigger) {
        jQuery('.contact-box').addClass('islive');
        jQuery('.backtop').addClass('islive');
    }else{
        jQuery('.contact-box ').removeClass('islive');
        jQuery('.backtop').removeClass('islive');
        jQuery('.contactformwrapper').addClass('hidden');
    }
    jQuery('.contact_close_button').on( 'click', function(event) {
        event.preventDefault();
        jQuery('.contactformwrapper').addClass('hidden');
    });

});

function  wpestate_sidebar_sticky(scroll){
    return;
}

function wpestate_adv_search_sticky(scroll){
    "use strict";
    if(!document.getElementById("search_wrapper")){
        return;
    }

    if(screen.width <1024 ){
        return;
    }




    if(scroll>20 ){
        if( jQuery('.has_header_type4').length <= 0){
            jQuery(".master_header").hide();
        }else{
            jQuery('.top_bar_wrapper').hide();
        }
    }else{
        jQuery(".master_header,.top_bar_wrapper").show();
    }



    if (window.pageYOffset > sticky_search) {
        if(jQuery('.with_search_form_float').length>0){
            if ( (window.pageYOffset >= sticky_search-100) ) {
                searchbar.classList.add("sticky_adv_anime");
            }

            if ( (window.pageYOffset >= sticky_search-10) ) {
                searchbar.classList.add("sticky_adv");
            }


        }else{
            searchbar.classList.add("sticky_adv");
        }



    } else {
        searchbar.classList.remove("sticky_adv");
         searchbar.classList.remove("sticky_adv_anime");
    }

}

function wpestate_isScrolledIntoView(scroll){
    "use strict";
    if(jQuery('#search_wrapper').length>0){
        var elemTop     =   parseInt(   jQuery('#search_wrapper').offset().top );
        var elemHeight  =   parseInt(   jQuery('#search_wrapper').height() );
        elemHeight  =0;

        if( (elemTop+elemHeight+3)<scroll){
            return true;
        }else{
            if(scroll_trigger===0){
                scroll_trigger=elemTop+elemHeight+60;
                if(scroll_trigger<500){
                    scroll_trigger=500;
                }
            }
            return false;
        }
    }

}

function isScrolledIntoView(elem){
    "use strict";
    var docViewTop = jQuery(window).scrollTop();
    var docViewBottom = docViewTop + jQuery(window).height();

    var elemTop = jQuery(elem).offset().top;
    var elemBottom = elemTop + jQuery(elem).height();
    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

function wpestate_header_sticky(scroll){

    "use strict";

    var sticky_class="master_header_sticky";

    if(control_vars.content_type!='' && control_vars.content_type!=='tabs' && jQuery('.wpestate_top_property_navigation_link').length!==0){
         sticky_class=sticky_class+" "+"sticky_property_menu"
    }
  

   
            
    if (scroll >= control_vars.scroll_trigger) {
        if (!Modernizr.mq('only all and (max-width: 1023px)')) {

            jQuery(".master_header").addClass(sticky_class);
            jQuery('.logo').addClass('miclogo');
            if( switch_logo!=='' ){
                jQuery('#logo_image').attr('src',switch_logo);
            }

            if( !jQuery(".header_wrapper").hasClass('header_type4') ){
                jQuery(".header_wrapper").addClass("navbar-fixed-top");
                jQuery(".header_wrapper").addClass("customnav");
            }
            jQuery('.barlogo').show();
            jQuery('#user_menu_open').hide();
            jQuery('.navicon-button').removeClass('opensvg');
            jQuery('#wpestate_header_shoping_cart').hide();

            jQuery('.wpestate_top_property_navigation').addClass('sticky_property_menu_visible');

        }

    } else {
        jQuery(".master_header").removeClass(sticky_class);
        jQuery(".header_wrapper").removeClass("navbar-fixed-top");
        jQuery(".header_wrapper").removeClass("customnav");

        jQuery('.barlogo').hide();
        jQuery('#user_menu_open').hide();
        jQuery('#wpestate_header_shoping_cart').hide();
        jQuery('.logo').removeClass('miclogo');

        jQuery('.wpestate_top_property_navigation').removeClass('sticky_property_menu_visible');


        if( switch_logo!=='' ){
           
            jQuery('#logo_image').attr('src',switch_logo_original);
        }
    }
}



function wpestate_isRetinaDisplay() {
    "use strict";
    if (window.matchMedia) {
        var mq = window.matchMedia("only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen  and (min-device-pixel-ratio: 1.3), only screen and (min-resolution: 1.3dppx)");
        return (mq && mq.matches || (window.devicePixelRatio > 1));
    }
}


function wpestate_property_sticky(){
    jQuery(".wpestate_top_property_navigation a").click(function (event) {
        event.preventDefault();
        jQuery("html, body").animate({
            scrollTop: jQuery(jQuery(this).attr("href")).offset().top - 80
        }, 500);
    });

    jQuery(window).on('scroll', function () {
        jQuery('.property-panel').each(function () {
            if (jQuery(window).scrollTop() >= jQuery(this).offset().top - 80) {
                var id = jQuery(this).attr('id');
                jQuery('.wpestate_top_property_navigation a').removeClass('item_active');
                jQuery('.wpestate_top_property_navigation a[href="#' + id + '"]').addClass('item_active');
            } else if (jQuery(window).scrollTop() <= 0) {
                jQuery('.wpestate_top_property_navigation a').removeClass('item_active');
            }
        });
    });
}





jQuery(window).resize(function() {
    "use strict";
    if(jQuery(window).width() != width ){
        jQuery('#mobile_menu').hide('10');
    }
    wpestate_half_map_responsive();
    wpestat_resize_wpestate_property_slider_v2();

});

function wpestate_half_map_responsive(){
    if (Modernizr.mq('only screen and (min-width: 640px)') && Modernizr.mq('only screen and (max-width: 1025px)')) {
        var half_map_header = jQuery('.master_header ').height();
    }

}

function wpestate_half_map_controls(){

    jQuery('.half_mobile_toggle_listings').on('click',function(){

        jQuery('.half_map_controllers_wrapper div').removeClass('half_control_visible');
        jQuery(this).addClass('half_control_visible');
        jQuery('#google_map_prop_list_sidebar').show();
        jQuery('.half_mobile_hide').hide();
    });


     jQuery('.half_mobile_toggle_map').on('click',function(){

        jQuery('.half_map_controllers_wrapper div').removeClass('half_control_visible');
        jQuery(this).addClass('half_control_visible');
        jQuery('#google_map_prop_list_sidebar').hide();
        jQuery('.half_mobile_hide').show();

        wpresidence_map_general_fit_to_bounds(1);
      if(wp_estate_kind_of_map===1){

    }else if(wp_estate_kind_of_map===2){
      map.invalidateSize();
        map.fitBounds(bounds_list);
    }
    });
}





Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&'+control_vars.price_separator);
};

function wpestate_element_hide(item){
    "use strict";
    jQuery(document).on( 'click', function(event) {
        if (!jQuery(item).is(event.target) && jQuery(item).has(event.target).length === 0 ){
            jQuery('#results').fadeOut();

        }
    });
}
wpestate_element_hide('.search_wrapper');

function wpestate_lazy_load_carousel_property_unit(){
    "use strict";

    jQuery('.property_unit_carousel img').each(function(event){
          var new_source='';
          new_source=jQuery(this).attr('data-lazy-load-src');
          if(typeof (new_source)!=='undefined' && new_source!==''){

            jQuery(this).attr('src',new_source);
          }
      });
}
 //recaptha


function wpestate_card_unit_contact_actions(){


    jQuery('.wpestate_property_card_contact_wrapper_phone').on('click',function(event){
        event.stopPropagation(); 
       
        var prop_id = jQuery(this).attr('data-item-id');
        var parent = jQuery(this).parent().parent();
       
        parent.find('.wpestate_card_unit_call_'+prop_id).appendTo("body");
        jQuery('body> .wpestate_card_unit_call_'+prop_id).first().modal("show");
    });

    jQuery('.wpestate_property_card_contact_wrapper_email').on('click',function(event){
        event.stopPropagation();  
        var prop_id = jQuery(this).attr('data-item-id');
        var parent = jQuery(this).parent().parent();
        parent.find('.wpestate_card_unit_email_'+prop_id).appendTo("body");
        jQuery('body> .wpestate_card_unit_email_'+prop_id).first().modal("show");
    });

    jQuery('.wpestate_property_card_contact_wrapper_whatsupp').on('click',function(event){
        event.stopPropagation();
      
    });

}




var widgetId1,widgetId2,widgetId3,widgetId4;
var wpestate_onloadCallback = function() {

    // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
    // The id of the reCAPTCHA widget is assigned to 'widgetId1'.

    if(  document.getElementById('top_register_menu') ){
        widgetId1 = grecaptcha.render('top_register_menu', {
            'sitekey' : control_vars.captchakey,
            'theme' : 'light'
        });
    }

    if(  document.getElementById('mobile_register_menu') ){
        widgetId2 = grecaptcha.render('mobile_register_menu', {
            'sitekey' : control_vars.captchakey,
            'theme' : 'light'
        });
    }


    if(  document.getElementById('widget_register_menu') ){
        widgetId3 = grecaptcha.render('widget_register_menu', {
            'sitekey' : control_vars.captchakey,
            'theme' : 'light'
        });
    }

    if(  document.getElementById('shortcode_register_menu') ){
        widgetId4 = grecaptcha.render('shortcode_register_menu', {
            'sitekey' : control_vars.captchakey,
            'theme' : 'light'
        });
    }

};






wpestate_advnced_filters_bars();

jQuery(document).ready(function () {
    "use strict";

   jQuery('#login_user_wd').focus({ preventScroll: true });

    if(jQuery('.wpestate_anime').length>0 ){
        jQuery('.wpestate_anime').each( function(){
            var element_id = jQuery(this).attr('id');
            wpestate_property_list_sh('#'+element_id+' .wpestate_item_list_sh', '#'+element_id+' .control_tax_sh');
        });

    }

    wpestate_reposion_dropdowns();
    wpestate_beds_baths_component();
    wpestate_price_component_item();
    wpestate_price_component_item_v3();

    wpestate_blog_list_widget();
    wpestate_get_location();
    wpestate_grid_list_controls();
    wpestate_enble_slick_slider_list();
    wpestate_slider_box();
    wpestate_enable_share_unit();
    wpestate_control_media_buttons();
    wpestate_card_unit_contact_actions();
    wpestate_morgate_widget_action();
    wpestate_zillow_widget_action();
    wpestate_save_search_actions();
    wpestate_delete_save_search_actions();
    wpestate_overview_map();
    
    if(jQuery('.googleMap_shortcode_class').length>0 ){
        if(  jQuery(".single-estate_property").length==0 ){
            wpestate_map_shortcode_function();
        }else{
            if(  jQuery("#googleMap").length==0 &&  jQuery("#googleMapSlider").length==0 ){
            }
        }
    }


    jQuery('body').on('click', '.add_custom_parameter', function(){
        var cloned = jQuery('.cliche_row').clone();
        cloned.removeClass('cliche_row').addClass('single_parameter_row');
        jQuery('input', cloned).val();
        jQuery('.add_custom_data_cont').before( cloned );
    });




    jQuery('body').on('click', '.remove_parameter_button', function(){
        var pnt = jQuery(this).parents( '.single_parameter_row' );
        pnt.fadeOut(500, function(){
                pnt.replaceWith('');
        });
    });


    jQuery('.buy_package_sh a').on( 'click', function(event) {
        if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {
            event.preventDefault();
            jQuery('#modal_login_wrapper').show();
             jQuery('#modal_login_wrapper').find('[autofocus]').focus();
            jQuery('#loginpop').val('1');
        }
    });

    if (typeof wpestate_enable_half_map_pin_action == 'function'){
        wpestate_enable_half_map_pin_action();
    }  

    if(control_vars.sticky_footer==='yes'){
        var footer_height=jQuery('#colophon').height();
        jQuery('.container.main_wrapper').css('margin-bottom',footer_height);
    }

    if( jQuery('.with_search_on_start').length>0 &&
        jQuery('.with_search_form_float').length<=0   &&
        Modernizr.mq('only screen and (min-width: 1023px)')
    ){
        var header_media_pad = jQuery('.master_header').height();
        jQuery('.search_wrapper').css('margin-top',header_media_pad+"px");

        if( jQuery('body').hasClass('single-estate_developer') || jQuery('body').hasClass('single-estate_agency') ){
            //do nothing for now
        }else{
            jQuery('.header_media').css('padding-top',"0px");
        }
        
    }

    var screen_width,screen_height,map_tab;

    jQuery.datepicker.setDefaults( jQuery.datepicker.regional[control_vars.datepick_lang] );




    estate_splash_slider();


    var new_height;
    if (jQuery(".full_screen_yes").length) {

        if( jQuery('.header_transparent').length > 0){
            new_height = jQuery( window ).height();
        }else{
            new_height = jQuery( window ).height() - jQuery('.master_header').height();
        }

        if( jQuery('.with_search_on_start').length>0 ){
            new_height=new_height- jQuery('.search_wrapper.with_search_on_start ').height();
        }

        jQuery('.wpestate_header_image,.wpestate_header_video,.theme_slider_wrapper,.theme_slider_classic,.theme_slider_wrapper .item_type2 ').css('height',new_height);
    }


    var handler_top;
    jQuery('.adv_handler').on( 'click', function(event) {
        event.preventDefault();

        var check_row=jQuery('.adv_search_hidden_fields');


        if(jQuery('#search_wrapper').hasClass('with_search_form_float')){
            if( !jQuery('#search_wrapper').hasClass('openmore') ){
                check_row.css('display','block');
                var height = check_row.height();
                handler_top = parseInt ( jQuery('#search_wrapper').css('top'));
                var top = parseInt ( jQuery('#search_wrapper').css('top'))-height;

                check_row.css('display','none');

                jQuery('#search_wrapper').animate({
                    'top':top
                }, { duration: 200, queue: false });
                jQuery('.adv_search_hidden_fields').slideDown( { duration: 200, queue: false });
                jQuery('#search_wrapper').addClass('openmore');
            }else{

                jQuery('#search_wrapper').animate({
                    'top':handler_top
                }, { duration: 200, queue: false });
                jQuery('.adv_search_hidden_fields').slideUp ({ duration: 200, queue: false });
                jQuery('#search_wrapper').removeClass('openmore');
            }
        }else{

           jQuery('.adv_search_hidden_fields').slideToggle();
        }



    });



    jQuery('.wp-block-residence-gutenberg-block-testimonial-slider').each(function(){

       if( jQuery(this).find('.type_class_3 ').length>0 ){
           jQuery(this).addClass('container_type_3');
       }

    })






    jQuery('#preview_view_all').on( 'click', function(event) {

        if( (mapfunctions_vars.adv_search_type==='6' || mapfunctions_vars.adv_search_type==='7' || mapfunctions_vars.adv_search_type==='8' || mapfunctions_vars.adv_search_type==='9' ) ){

            jQuery('.search_wrapper .tab-pane.active .wpresidence_button').trigger('click');
        }else{
            jQuery('.search_wrapper .wpresidence_button').trigger('click');
        }
    });


    jQuery('.theme_slider_2 .prop_new_details ').on( 'click', function(event) {

        var new_link;
        new_link =  jQuery(this).attr('data-href');
        window.open (new_link,'_self',false);
    });

    jQuery('.theme_slider_classic').on( 'click', function(event) {

       if (event.target == this)  {
            var new_link;
            new_link =  jQuery(this).attr('data-href');
            window.open (new_link,'_self',false);
        }
    });




    setTimeout(function() {   wpresidence_list_view_arrange(); }, 300);

    ////////// adv serach 6
    jQuery('.adv6_tab_head,.elementor_search_tab_head').on( 'click', function(event) {
        var tab_controls;
        var parent=jQuery(this).parent().parent();
        parent.find('.adv_search_tab_item').removeClass('active');
        jQuery(this).parent().addClass('active');
        tab_controls = jQuery(this).attr('aria-controls');
        jQuery('.adv6_price_low').removeClass('price_active');
        jQuery('.adv6_price_max').removeClass('price_active');

        jQuery('#'+tab_controls).find('.adv6_price_low').addClass('price_active');
        jQuery('#'+tab_controls).find('.adv6_price_max').addClass('price_active');

    });




    var mega_menu_width;
    if( jQuery('.header_wrapper').hasClass('header_type2')  ){
        mega_menu_width=jQuery('.header_wrapper_inside').width()-90;
        jQuery('#access ul li.with-megamenu>ul.sub-menu, #access ul li.with-megamenu:hover>ul.sub-menu').css('width',mega_menu_width+'px');
    }

    if(  jQuery('.header_wrapper').hasClass('header_type5') ){
        mega_menu_width=jQuery('.header5_top_row').width();
        jQuery('#access ul li.with-megamenu>ul.sub-menu, #access ul li.with-megamenu:hover>ul.sub-menu').css('width',mega_menu_width+'px').css('max-width','1024px');
    }


   ////////// header type 3


    ////////// map shortcode
    map_tab=0;
    jQuery('#propmaptrigger').on( 'click', function(event) {
        if(map_tab===0){

            wpestate_map_shortcode_function();
            map_tab=1;

        }
    });







    setTimeout(function(){
        jQuery('.theme_slider_2 .theme_slider_2_contact_agent,.theme_slider_2 .prop_new_detals_info').fadeIn();
    }, 1000);






     jQuery('.slider_container').css('overflow','initial');

	////////////////////////////
	// taxonomy slick slider
	////////////////////////////



    wpestate_half_map_responsive();
    wpestate_half_map_controls();

    jQuery('.show_stats').on( 'click', function(event) {
        event.preventDefault();
        var parent,listing_id;
        parent = jQuery(this).parent().parent().parent();
        listing_id = jQuery(this).attr('data-listingid');
        //jQuery('.statistics_wrapper').slideUp();

        if( parent.find('.statistics_wrapper').hasClass('is_slide')  ){
               parent.find('.statistics_wrapper').slideUp().removeClass('is_slide');
        }else{
            parent.find('.statistics_wrapper').slideDown().addClass('is_slide');
            wpestate_load_stats(listing_id);
        }




    });

     jQuery('.tabs_stats,#1462452319500-8587db8d-e959,#1462968563400-b8613baa-7092').on( 'click', function(event) {
       var parent,listing_id;
       listing_id = jQuery(this).attr('data-listingid');
       if(typeof(listing_id)==='undefined'){
           listing_id =  jQuery('.estate_property_first_row').attr('data-prp-listingid');
       }


       wpestate_load_stats_tabs(listing_id);
    });



    ////////////////////////////////////////////////////////////////////////////
    //new retina script
    ////////////////////////////////////////////////////////////////////////////

        jQuery('.retina_ready').dense({
            'ping'      : true,
            'dimension' : 'preserve'
        });
        var image_unnit = jQuery('<div data-1x="'+control_vars.path+'/css/css-images/unit.png" data-2x="'+control_vars.path+'/css/css-images/unit_2x.png" />').dense('getImageAttribute');
        var image_unnit = jQuery('<div data-1x="'+control_vars.path+'/css/css-images/unitshare.png" data-2x="'+control_vars.path+'/css/css-images/unitshare_2x.png" />').dense('getImageAttribute');

    ////////////////////////////////////////////////////////////////////////////
    //invoice filters
    ////////////////////////////////////////////////////////////////////////////


   jQuery(function() {
        jQuery("#invoice_start_date,#invoice_end_date").datepicker({
            dateFormat : "yy-mm-dd",
        }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');
    });


    ////////////////////////////////////////////////////////////////////////////
    //new mobile menu 1.10
    ////////////////////////////////////////////////////////////////////////////

    jQuery('.all-elements').animate({
            minHeight: 100+'%'
    });

    jQuery('.header-tip').addClass('hide-header-tip');

    wpestate_mobile_menu_slideout();
    wpestate_mobile_menu_open_submenu();



   


    ////////////////////////////////////////////////////////////////////////////
    // multiple cur set cookige
    ////////////////////////////////////////////////////////////////////////////

    jQuery('.list_sidebar_currency li').on( 'click', function(event) {
        var ajaxurl,data,pos,symbol,coef,curpos, pick;
        data=jQuery(this).attr('data-value');
        pos=jQuery(this).attr('data-pos');
        symbol=jQuery(this).attr('data-symbol');
        coef=jQuery(this).attr('data-coef');
        curpos=jQuery(this).attr('data-curpos');

		var parent_pointer = jQuery(this).parents('.dropdown ');
		pick = jQuery(this).text();
		jQuery('.sidebar_filter_menu', parent_pointer).text(pick).append('<span class="caret caret_sidebar"></span>');

        ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var nonce = jQuery('#wpestate_change_currency').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_set_cookie_multiple_curr',
                'curr'      :   data,
                'pos'       :   pos,
                'symbol'    :   symbol,
                'coef'      :   coef,
                'curpos'    :   curpos,
                'security'  :   nonce
            },
            success: function (data) {

               location.reload();
            },
            error: function (errorThrown) {}
        });//end ajax

    });


    ////////////////////////////////////////////////////////////////////////////
    // easure unit cookige
    ////////////////////////////////////////////////////////////////////////////

    jQuery('.list_sidebar_measure_unit li').on( 'click', function(event) {
        var ajaxurl,value, pick;
        value = jQuery(this).attr('data-value');

        var parent_pointer = jQuery(this).parents('.dropdown ');
        pick = jQuery(this).text();
        jQuery('.sidebar_filter_menu', parent_pointer).text(pick).append('<span class="caret caret_sidebar"></span>');
        var nonce = jQuery('#wpestate_change_measure').val();
        ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_set_cookie_measure_unit',
                'value'     :   value,
                'security'  : nonce
            },
            success: function (data) {

               location.reload();
            },
            error: function (errorThrown) {}
        });//end ajax

    });




    ////////////////////////////////////////////////////////////////////////////
    // map control
    ////////////////////////////////////////////////////////////////////////////
    jQuery('#map-view').on( 'click', function(event) {
        jQuery('.map-type').fadeIn(400);
    });

    jQuery('.map-type').on( 'click', function(event) {
        var map_type;
        jQuery('.map-type').hide();
        map_type=jQuery(this).attr('id');
        wpestate_change_map_type(map_type);

    });

  







    ////////////////////////////////////////////////////////////////////////////
    /// slider price
    ////////////////////////////////////////////////////////////////////////////

    var price_low_val= parseInt( jQuery('#price_low').val() );
    var price_max_val= parseInt( jQuery('#price_max').val() );
    var my_custom_curr_symbol  =   decodeURI ( wpestate_getCookie('my_custom_curr_symbol') );
    var my_custom_curr_coef    =   parseFloat( wpestate_getCookie('my_custom_curr_coef'));
    var my_custom_curr_pos     =   parseFloat( wpestate_getCookie('my_custom_curr_pos'));
    var my_custom_curr_cur_post=   wpestate_getCookie('my_custom_curr_cur_post');


    wpestate_enable_slider('slider_price', 'price_low', 'price_max', 'amount', my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef);
    jQuery( "#slider_price" ).slider({
        stop: function( event, ui ) {
            if (typeof (wpestate_show_pins) !== "undefined") {
                first_time_wpestate_show_inpage_ajax_half=1;

                wpestate_show_pins();
            }
        }
    });
    wpestate_enable_slider('slider_price_sh', 'price_low_sh', 'price_max_sh', 'amount_sh', my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef);
    wpestate_enable_slider('slider_price_widget', 'price_low_widget', 'price_max_widget', 'amount_wd', my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef);
    wpestate_enable_slider('slider_price_mobile', 'price_low_mobile', 'price_max_mobile', 'amount_mobile', my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef);

  
    wpestate_enable_slider_elementor();

    if(control_vars.adv6_taxonomy_term!==''){
        control_vars.adv6_taxonomy_term.forEach(wpestate_advtabs_function);
    }





    ////////////////////////////////////////////////////////////////////////////

    var adv_search_top;
    jQuery('.adv_extended_options_text').on( 'click', function(event) {

        jQuery('.adv-search-1.adv_extended_class').css('height','auto');
        jQuery('.adv_extended_class .adv1-holder').css('height','auto');
        jQuery(this).parent().find('.adv_extended_options_text').hide();
        var check_row=jQuery(this).parent().find('.extended_search_check_wrapper');


        if(jQuery('#search_wrapper').hasClass('with_search_form_float')){
            check_row.css('display','block');
            var height = check_row.height();
            adv_search_top = parseInt ( jQuery('#search_wrapper').css('top'));
            var top = parseInt ( jQuery('#search_wrapper').css('top'))-height;

            check_row.css('display','none');

            jQuery('#search_wrapper').animate({
                'top':top
            }, { duration: 200, queue: false });

        }
        check_row.slideDown(  { duration: 200, queue: false});

        jQuery(this).parent().find('.adv_extended_close_button').show();
    });




    jQuery('.adv_extended_close_button').on( 'click', function(event) {

        jQuery(this).hide();
        jQuery(this).parent().parent().find('.adv_extended_options_text').show();
        jQuery('.adv-search-1.adv_extended_class').removeAttr('style');
        jQuery('.adv_extended_class .adv1-holder').removeAttr('style');

        if(jQuery('#search_wrapper').hasClass('with_search_form_float')){
            jQuery('#search_wrapper').animate({
                'top':adv_search_top
            },{ duration: 200, queue: false });
        }

        jQuery(this).parent().parent().find('.extended_search_check_wrapper').slideUp({ duration: 200, queue: false });

    });


    //////////////////////////////////////////////////////////////

    jQuery('#adv_extended_options_text_widget').on( 'click', function(event) {

        jQuery(this).parent().find('.adv_extended_options_text').hide();
        jQuery(this).parent().find('.extended_search_check_wrapper').slideDown();
        jQuery(this).parent().find('#adv_extended_close_widget').show();
    });

    jQuery('#adv_extended_close_widget').on( 'click', function(event) {
        jQuery(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        jQuery(this).hide();
        jQuery(this).parent().parent().find('.adv_extended_options_text').show();
    });

    ////////////////////////////////////////////////////////////////////////////////
       jQuery('#adv_extended_options_text_short').on( 'click', function(event) {
        jQuery(this).parent().find('.adv_extended_options_text').hide();
        jQuery(this).parent().find('.extended_search_check_wrapper').slideDown();
        jQuery(this).parent().find('#adv_extended_close_short').show();
    });

    jQuery('#adv_extended_close_short').on( 'click', function(event) {
        jQuery(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        jQuery(this).hide();
        jQuery(this).parent().parent().find('.adv_extended_options_text').show();
    });


    /////////////////////////////////////////////////////////////////////////////////////
    jQuery('#adv_extended_options_text_mobile').on( 'click', function(event) {
        jQuery(this).parent().find('.adv_extended_options_text').hide();
        jQuery(this).parent().find('.extended_search_check_wrapper').slideDown();
        jQuery(this).parent().find('#adv_extended_close_mobile').show();
    });

    jQuery('#adv_extended_close_mobile').on( 'click', function(event) {
        jQuery(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        jQuery(this).hide();
        jQuery(this).parent().parent().find('.adv_extended_options_text').show();
    });
    /////////////////////////////////////////////////////////////////////////////////////////




    jQuery('#estate-carousel .slider-content h3 a,#estate-carousel .slider-content .read_more ').on( 'click', function(event) {
      var new_link;
      new_link =  jQuery(this).attr('href');
      window.open (new_link,'_self',false);
    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    ///city-area-selection
    ///////////////////////////////////////////////////////////////////////////////////////////

    wpestate_filter_city_area('filter_city','filter_area');
    wpestate_filter_city_area('sidebar-adv-search-city','sidebar-adv-search-area');
    wpestate_filter_city_area('adv-search-city','adv-search-area');
    wpestate_filter_city_area('half-adv-search-city','half-adv-search-area');
    wpestate_filter_city_area('shortcode-adv-search-city','shortcode-adv-search-area');
    wpestate_filter_city_area('mobile-adv-search-city','mobile-adv-search-area');


    ////////////////////////////////////////////////////////////////////////////////////////////
    //county-city-selection
    ///////////////////////////////////////////////////////////////////////////////////////////
    wpestate_filter_county_city( 'filter_county', 'filter_city' );
    wpestate_filter_county_city( 'sidebar-adv-search-countystate', 'sidebar-adv-search-city' );
    wpestate_filter_county_city( 'adv-search-countystate', 'adv-search-city' );
    wpestate_filter_county_city( 'half-adv-search-countystate', 'half-adv-search-city' );
    wpestate_filter_county_city( 'shortcode-adv-search-countystate', 'shortcode-adv-search-city' );
    wpestate_filter_county_city( 'mobile-adv-search-countystate', 'mobile-adv-search-city' );




    var all_browsers_stuff;

    jQuery('#property_city_submit').on('change', function(){
        var city_value, area_value;
        city_value=jQuery(this).val();

        all_browsers_stuff=jQuery('#property_area_submit_hidden').html();
        jQuery('#property_area_submit').empty().append(all_browsers_stuff);
        jQuery('#property_area_submit option').each(function(){
            area_value=jQuery(this).attr('data-parentcity');

            if( city_value ===area_value || area_value==='all'){
              //  jQuery(this).show();
            }else{
                //jQuery(this).hide();
                 jQuery(this).remove();
            }
        });
    });
	 jQuery('#property_county').on('change', function(){
        var county_value, city_value;
        county_value=jQuery(this).val();

        all_browsers_stuff=jQuery('#property_city_submit_hidden').html();
        jQuery('#property_city_submit').empty().append(all_browsers_stuff);
        jQuery('#property_city_submit option').each(function(){
            city_value=jQuery(this).attr('data-parentcounty');

            if( county_value ===city_value || city_value==='all'){
              //  jQuery(this).show();
            }else{
                //jQuery(this).hide();
                 jQuery(this).remove();
            }
        });
    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    ///mobile
    ///////////////////////////////////////////////////////////////////////////////////////////


    jQuery('#adv-search-header-mobile').on( 'click', function(event) {
        jQuery('#adv-search-mobile').fadeToggle('300');

    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    ///navigational links
    ///////////////////////////////////////////////////////////////////////////////////////////

    jQuery('.nav-prev,.nav-next ').on( 'click', function(event) {
        event.preventDefault();
        var link = jQuery(this).find('a').attr('href');
        window.open (link,'_self',false);
    });

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// featured agent
    ///////////////////////////////////////////////////////////////////////////////////////////


    jQuery('.featured_agent_details_wrapper, .agent-listing-img-wrapper').on( 'click', function(event) {
        var newl= jQuery( this ).attr('data-link');
        window.open (newl,'_self',false);
    });

    jQuery('.see_my_list_featured').on( 'click', function(event) {
            event.stopPropagation();
    });

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// featuerd property
    ///////////////////////////////////////////////////////////////////////////////////////////

    jQuery('.featured_cover').on( 'click', function(event) {
        var newl= jQuery( this ).attr('data-link');
        window.open (newl,'_self',false);
    });


    jQuery( '.agent_face' )
        .on('mouseenter', function(){   jQuery(this).find('.agent_face_details').fadeIn('500'); })
        .on('mouseleave', function(){  jQuery(this).find('.agent_face_details').fadeOut('500'); });


    ////////////////////////////////////////////////////////////////////////////////////////////
    /// listings unit navigation
    ///////////////////////////////////////////////////////////////////////////////////////////
    jQuery('.places_cover,.agent_unit, .blog_unit , .featured_widget_image,.blog3v .property_listing_blog,.featured_img_type2').on( 'click', function(event) {
        var link;
        link = jQuery(this).attr('data-link');

        window.open(link, '_self');
    });



    jQuery('.property_listing').on( 'click', function(event) {
        if (event.target.classList.contains('demo-icon') ){
            return;
        }
  
        if(control_vars.property_modal === '1' && !Modernizr.mq('only all and (max-width: 1024px)') ){
            event.preventDefault();
            event.stopPropagation();
            scroll_modal_save=scroll_modal;

            var listing_id  =   jQuery(this).parent().attr('data-listid');
            var main_img_url=   jQuery(this).parent().attr('data-main-modal');
            var main_title  =   jQuery(this).parent().attr('data-modal-title');
            var link        =   jQuery(this).parent().attr('data-modal-link');
            wpestate_enable_property_modal(listing_id,main_img_url,main_title,link);
        }else{

            if(control_vars.new_page_link==='_blank' && !jQuery(this).hasClass('places_listing')){
                return;
            }
            var link;
            link = jQuery(this).attr('data-link');

            window.open(link, '_self');
        }
    });






    jQuery('.share_unit').on( 'click', function(event) {
        event.stopPropagation();
    });

    jQuery('.related_blog_unit_image').on( 'click', function(event) {
         var link;
        link = jQuery(this).attr('data-related-link');
        window.open(link, '_self');
    });

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// user menu
    ///////////////////////////////////////////////////////////////////////////////////////////

    wpestate_open_menu();

    jQuery('#login_trigger_modal').on( 'click', function(event) {

        if (!Modernizr.mq('only all and (max-width: 768px)')) {
            jQuery('#modal_login_wrapper').show();
            jQuery('#loginpop').val('2');
        }else{
            jQuery('.mobile-trigger-user').trigger('click');
             jQuery('#loginpop').val('2');
        }
        jQuery('#modal_login_wrapper').find('[autofocus]').focus();
    });

    jQuery('#user_menu_u.user_not_loged .submit_action').on( 'click', function(event) {
        jQuery('.login-links').show();
        jQuery('#modal_login_wrapper').show();
        jQuery('#modal_login_wrapper').find('[autofocus]').focus();
    });

    jQuery('#wpresidence_elementor_register').on( 'click', function(event) {

        event.preventDefault();
        jQuery('.login-links').show();
  
        jQuery('#modal_login_wrapper').show();      
        event.preventDefault();
        jQuery('#login-div_topbar,#widget_register_topbar,#login-div-title-topbar,#forgot-div-title-topbar,#forgot-pass-div').hide();
        jQuery('#register-div-topbar,#register-div-title-topbar,#widget_login_topbar,#forgot_pass_topbar').show().find('[autofocus]').focus();

        jQuery('#modal_login_wrapper').find('[autofocus]').focus();
    });

    jQuery('#wpresidence_elementor_login').on( 'click', function(event) {

        event.preventDefault();
        jQuery('.login-links').show();
        jQuery('#modal_login_wrapper').show();
        jQuery('#login-div_topbar,#widget_register_topbar,#login-div-title-topbar,#forgot_pass_topbar').show().find('[autofocus]').focus();
        jQuery('#register-div-topbar,#register-div-title-topbar,#widget_login_topbar,#forgot-div-title-topbar,#forgot-pass-div').hide();
  

        jQuery('#modal_login_wrapper').find('[autofocus]').focus();
    });



    jQuery('#login-modal_close').on( 'click', function(event) {
        jQuery('#modal_login_wrapper').hide();
    });

    jQuery('#property_details_modal_close').on('click',function(event){
        jQuery('.website-wrapper').removeAttr('style');
        window.scrollTo(0, parseInt(scroll_modal_save) );
        jQuery('#property_details_modal_wrapper').hide();
        window.history.pushState("", modal_title,modal_url);
    });

    jQuery('#shopping-cart').on('click',function (event) {

        jQuery('#user_menu_open').removeClass('iosfixed').fadeOut(400);
        if (jQuery('#wpestate_header_shoping_cart').is(":visible")) {
            jQuery('#wpestate_header_shoping_cart').fadeOut(400);
        } else {
            jQuery('#wpestate_header_shoping_cart').fadeIn(400);
        }
        event.stopPropagation();
    });


    jQuery(document).on( 'click', function(event) {

        var clicka  =   event.target.id;
        var clicka2 =   jQuery(event.target).attr('share_unit');
        jQuery('#wpestate_header_shoping_cart').fadeOut(400);
        if ( !jQuery('#'+clicka).parents('.topmenux').length) {
            jQuery('#user_menu_open').removeClass('iosfixed').hide(400);
            jQuery('.navicon-button').removeClass('opensvg');
            jQuery('#user_menu_u .navicon-button').removeClass('open');
        }

        jQuery('.share_unit').hide();


        if (event.target.id == "header_type3_wrapper" || jQuery(event.target).parents("#header_type3_wrapper").size()) {

        } else {
            var css_right   = parseFloat( jQuery('.header_type3_menu_sidebar').css('right') );
            var css_left    = parseFloat( jQuery('.header_type3_menu_sidebar').css('left') );
            if(css_right===0 || css_left===0 ){
                jQuery('.header_type3_menu_sidebar.header_left.sidebaropen').css("right","-300px");
                jQuery('.header_type3_menu_sidebar.header_right.sidebaropen').css("left","-300px");
                jQuery('.container.main_wrapper.has_header_type3').css("padding","0px");
                jQuery('.elementor-section.elementor-top-section ').css("padding-right","0px");
                jQuery('.elementor-section.elementor-top-section ').css("padding-left","0px");
                jQuery('.master_header').removeAttr('style');

            }
        }
    });


    jQuery('#header_type3_trigger').on( 'click', function(event) {

        event.preventDefault();
        if ( !jQuery('.container').hasClass('is_boxed') ){
            if( jQuery('.header_type3_menu_sidebar').hasClass('header_left') ){
                jQuery(".header_type3_menu_sidebar").css("right","0px");
                jQuery(".container.main_wrapper ").css("padding-right","300px");
                jQuery('.elementor-section.elementor-top-section ').css("padding-right","300px");
                jQuery(".master_header").css("right","150px");
            }else{
                jQuery(".header_type3_menu_sidebar").css("left","0px");
                jQuery(".container.main_wrapper ").css("padding-left","300px");
                jQuery('.elementor-section.elementor-top-section ').css("padding-left","300px");
                jQuery(".master_header").css("left","150px");
            
            }
            jQuery(".header_type3_menu_sidebar").addClass("sidebaropen");
        }else{
             if( jQuery('.header_type3_menu_sidebar').hasClass('header_left') ){
                jQuery(".header_type3_menu_sidebar").css("right","0px");

            }else{
                jQuery(".header_type3_menu_sidebar").css("left","0px");

            }
            jQuery(".header_type3_menu_sidebar").addClass("sidebaropen");
        }
    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    /// new controls for upload pictures
    ///////////////////////////////////////////////////////////////////////////////////////////

    jQuery('#imagelist i.fa-trash-alt').on( 'click', function(event) {
          var curent='';
          jQuery(this).parent().remove();

          jQuery('#imagelist .uploaded_images').each(function(){
             curent=curent+','+jQuery(this).attr('data-imageid');
          });
          jQuery('#attachid').val(curent);

      });

    jQuery('#imagelist img').dblclick(function(){

        jQuery('#imagelist .uploaded_images .thumber').each(function(){
            jQuery(this).remove();
        });

        jQuery(this).parent().append('<i class="fa thumber fa-star"></i>');
        jQuery('#attachthumb').val(   jQuery(this).parent().attr('data-imageid') );
    });





    jQuery('#switch').on( 'click', function(event) {
        jQuery('.main_wrapper').toggleClass('wide');
    });


    jQuery('#accordion_prop_addr, #accordion_prop_details, #accordion_prop_features').on('shown.bs.collapse', function () {
        jQuery(this).find('h4').removeClass('carusel_closed');
    });

    jQuery('#accordion_prop_addr, #accordion_prop_details, #accordion_prop_features').on('hidden.bs.collapse', function () {
        jQuery(this).find('h4').addClass('carusel_closed');
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    //////// advanced search filters
    ////////////////////////////////////////////////////////////////////////////////////////////

    var elems = ['.directory_sidebar','.search_wrapper' , '#advanced_search_shortcode', '#advanced_search_shortcode_2', '.adv-search-mobile','.advanced_search_sidebar'];

    jQuery.each( elems, function( i, elem ) {

        jQuery(elem+' li').on( 'click', function(event) {
            event.preventDefault();
            var pick, value, parent,parent_replace;

            parent_replace='.filter_menu_trigger';
            if(elem === '.advanced_search_sidebar' || elem === '.directory_sidebar' ){
                parent_replace='.sidebar_filter_menu';
            }

            pick = jQuery(this).text();
            value = jQuery(this).attr('data-value');

			// agents search patch
			//if( jQuery(this).parents('.advanced_search_sidebar').hasClass('ag_ag_dev_search_widget') ){
			if( jQuery(this).parent().hasClass('aag_picker') ){
				jQuery('.ag_ag_dev_search_selector').hide();
				jQuery('.selector_for_'+value).fadeIn();
			}


            parent = jQuery(this).parent().parent();
            if(elem === '.directory_sidebar' ){
                parent.find(parent_replace).text(pick).append('<span class="caret caret_sidebar"></span>').attr('data-value',value);
            }else{
                parent.find(parent_replace).text(pick).append('<span class="caret caret_filter"></span>').attr('data-value',value);
            }
            parent.find('input').val(value);
        });
    });




    jQuery('.search_wrapper li, .extended_search_check_wrapper input[type="checkbox"]').on( 'click', function(event) {

        if(jQuery(this).hasClass('wpestate_prevent_ajax')){
            return;
        }

        if (typeof (wpestate_show_pins) !== "undefined") {
            first_time_wpestate_show_inpage_ajax_half=1;
            wpestate_show_pins();
        }
    });





    var typingTimer;                //timer identifier
    var doneTypingInterval = 1500;  //time in ms, 5 second for example
    var jQueryinput = jQuery('#adv_location,.search_wrapper input[type=text]');

    jQueryinput.on('keyup', function (event) {
        if(jQuery(this).attr('id')=='geolocation_search' || jQuery(this).attr('id')=='geolocation_search2') {
            return;
        }
        if (event.keyCode === 13) { 
            first_time_wpestate_show_inpage_ajax_half=1;
            wpestate_show_pins();
        }
    });

    //on keydown, clear the countdown
    jQueryinput.on('keydown', function () {
      clearTimeout(typingTimer);
    });



    ///////////////////////////////////////////////////////////////////////////////////////////
    //////// advanced search filters
    ////////////////////////////////////////////////////////////////////////////////////////////

    jQuery('#openmap').on( 'click', function(event) {

        if( jQuery(this).find('i').hasClass('fa-angle-down') ){
            jQuery(this).empty().append('<i class="fas fa-angle-up"></i>'+control_vars.close_map);

            if (control_vars.show_adv_search_map_close === 'no') {
                jQuery('.search_wrapper').addClass('adv1_close');
                wpestate_adv_search_click();
            }

        }else{
            jQuery(this).empty().append('<i class="fas fa-angle-down"></i>'+control_vars.open_map);

        }
        wpestate_new_open_close_map(2);

    });


    ///////////////////////////////////////////////////////////////////////////////////////////
    //////// full screen map
    ////////////////////////////////////////////////////////////////////////////////////////////
    var wrap_h;
    var map_h;

    jQuery('#gmap-full').on( 'click', function(event) {


        if(  jQuery('#gmap_wrapper').hasClass('fullmap') ){
            jQuery('#google_map_prop_list_wrapper').removeClass('fullhalf');

            jQuery('#gmap_wrapper').removeClass('fullmap').css('height',wrap_h+'px');
            jQuery('#googleMap').removeClass('fullmap').css('height',map_h+'px');
            jQuery('.master_header ').removeClass('header_full_map');
            jQuery('#search_wrapper').removeClass('fullscreen_search');
            jQuery('#search_wrapper').removeClass('fullscreen_search_open');
            jQuery('.nav_wrapper').removeClass('hidden');
                if(  !jQuery('#google_map_prop_list_wrapper').length ){
                    jQuery('.content_wrapper').show();
                }
            jQuery('body,html').animate({
                 scrollTop: 0
            }, "slow");
            jQuery('#openmap').show();
            jQuery(this).empty().append('<i class="fas fa-arrows-alt"></i>'+control_vars.fullscreen).removeClass('spanselected');

            jQuery('#google_map_prop_list_wrapper').removeClass('fullscreen');
            jQuery('#google_map_prop_list_sidebar').removeClass('fullscreen');


        }else{
            jQuery('#gmap_wrapper,#googleMap').css('height','100%').addClass('fullmap');

            jQuery('#google_map_prop_list_wrapper').addClass('fullscreen');
            jQuery('#google_map_prop_list_sidebar').addClass('fullscreen');




            jQuery('#google_map_prop_list_wrapper').addClass('fullhalf');


            wrap_h=jQuery('#gmap_wrapper').outerHeight();
            map_h=jQuery('#googleMap').outerHeight();

            jQuery('.master_header ').addClass('header_full_map');


            jQuery('#search_wrapper').addClass('fullscreen_search');
            jQuery('.nav_wrapper').addClass('hidden');
            if(  !jQuery('#google_map_prop_list_wrapper').length ){
                jQuery('.content_wrapper').hide();
            }

            jQuery('#openmap').hide();
            jQuery(this).empty().append('<i class="fas fa-square"></i>'+control_vars.default).addClass('spanselected');

        }
        wpresidence_map_resise();



    });


    jQuery('#street-view').on( 'click', function(event) {
         wpestate_toggleStreetView();
    });





    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////     caption-wrapper
    ///////////////////////////////////////////////////////////////////////////////////////////

    jQuery('.caption-wrapper').on( 'click', function(event) {
        jQuery(this).toggleClass('closed');
        jQuery('.carusel-back').toggleClass('rowclosed');
        jQuery('.post-carusel .carousel-indicators').toggleClass('rowclosed');
    });

    jQuery('#carousel-listing').on('slid.bs.carousel', function () {

        if( jQuery(this).hasClass('carouselvertical') ){
            wpestate_show_capture_vertical();
        }else{
            wpestate_show_capture();
        }

        jQuery('#carousel-listing div').removeClass('slideron');
        jQuery('#slider_enable_slider').addClass('slideron');

    });


    jQuery('.carousel-round-indicators li').on( 'click', function(event) {
        jQuery('.carousel-round-indicators li').removeClass('active');
        jQuery(this).addClass('active');
    });

    jQuery('.videoitem iframe').on( 'click', function(event) {
        jQuery('.estate_video_control').remove();
    });
    ///////////////////////////////////////////////////////////////////////////////////////
    ////// Advanced search
    /////////////////////////////////////////////////////////////////////////////////////////

    wpestate_adv_search_click();





    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   tool tips on prop unit
    ///////////////////////////////////////////////////////////////////////////////////////////
    jQuery( ".property_listing_details_v7_item,.title_share, .share_list, .icon-fav, .compare-action, .dashboad-tooltip,#slider_enable_map ,#slider_enable_slider,#slider_enable_street,#slider_enable_street_sh,.slider_enable_map ,.slider_enable_slider,.slider_enable_street,.slider_enable_street_sh").on({
        mouseenter: function () {

            jQuery( this ).tooltip('show') ;
        },
        mouseleave: function () {
           jQuery( this ).tooltip('hide');
        }
     });


  






     jQuery('.custom_details_container .send_email_agent').on( 'click', function(event) {
         event.preventDefault();

         jQuery('body,html').animate({
               scrollTop: ( jQuery("#show_contact").offset().top-100)
          }, "slow");

     });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   back to top
    ///////////////////////////////////////////////////////////////////////////////////////////


     jQuery('.backtop').on( 'click', function(event) {
         event.preventDefault();

         jQuery('body,html').animate({
                scrollTop: 0
          }, "slow");

     });

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////    footer contact
    ///////////////////////////////////////////////////////////////////////////////////////////

    jQuery('.contact-box ').on( 'click', function(event) {
        event.preventDefault();
        jQuery('.contactformwrapper').toggleClass('hidden');
        wpestate_contact_footer_starter();
    });





    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// Search widget
    ///////////////////////////////////////////////////////////////////////////////////////////
    jQuery('#searchform input').focus(function(){
      jQuery(this).val('');
    }).blur(function(){

    });



    ////////////////////////////////////////////////////////////////////////////////////////////
    /// adding total for featured listings
    ///////////////////////////////////////////////////////////////////////////////////////////
    jQuery('.extra_featured').on('change', function(){
       var parent= jQuery(this).parent().parent();
       var price_regular  = parseFloat( parent.find('.submit-price-no').text(),10 );
       var price_featured = parseFloat( parent.find('.submit-price-featured').text(),10 );
       var total= price_regular+price_featured;

       if( jQuery(this).is(':checked') ){
            parent.find('.submit-price-total').text(total);
            parent.find('.stripe_form_featured').show();
            parent.find('.stripe_form_simple').hide();
       }else{
           //substract from total
            parent.find('.submit-price-total').text(price_regular);
            parent.find('.stripe_form_featured').hide();
            parent.find('.stripe_form_simple').show();
       }
    });


     ///////////////////////////////////////////////////////////////////////////////////////////
    ///////  resise colums on compare page
    ///////////////////////////////////////////////////////////////////////////////////////////

    jQuery('.compare_wrapper').each(function() {
        var cols = jQuery(this).find('.compare_item_head').length;
        jQuery(this).addClass('compar-' + cols);
    });

    /////////////////////////////////////////////////////////////////////////////////////////
    /////// grid to list view
    ///////////////////////////////////////////////////////////////////////////////////////////


    jQuery('.col-md-12.listing_wrapper .property_unit_custom_element.image').each(function(){
       jQuery(this).parent().addClass('wrap_custom_image');
    });






    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   compare action
    ///////////////////////////////////////////////////////////////////////////////////////////
    var already_in=[];
    jQuery('#compare_close').on( 'click', function(event) {
        jQuery('.prop-compare').animate({
            right: "-240px"
        });
    });

    jQuery('.compare-action').on( 'click', function(e) {

        e.preventDefault();
        e.stopPropagation();
        jQuery('.prop-compare').animate({
                            right: "0px"
                        });

        var post_id = jQuery(this).attr('data-pid');
         for(var i = 0; i < already_in.length; i++) {
            if(already_in[i] === post_id) {
                return;
            }
        }

        already_in.push(post_id);


        var post_image = jQuery(this).attr('data-pimage');

        var to_add = '<div class="items_compare" style="display:none;"><img src="' + post_image + '"  class="img-responsive"><input type="hidden" value="' + post_id + '" name="selected_id[]" /></div>';
        jQuery('div.items_compare:first-child').css('background', 'red');
        if (parseInt(jQuery('.items_compare').length,10) > 3) {
            jQuery('.items_compare:first').remove();
        }
        jQuery('#submit_compare').before(to_add);

        jQuery('#submit_compare').on( 'click', function(event) {
            jQuery('#form_compare').trigger('submit');
        });

        jQuery('.items_compare').fadeIn(500);
    });

    jQuery('#submit_compare').on( 'click', function(event) {
        jQuery('#form_compare').trigger('submit');
    });



     /////////////////////////////////////////////////////////////////////////////////////////
     ////// form upload
     /////////////////////////////////////////////////////////////////////////////////////////

    jQuery('#form_submit_2,#form_submit_1 ').on( 'click', function(event) {
        var loading_modal;
        window.scrollTo(0, 0);
        loading_modal='<div class="modal fade" id="loadingmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit"><span>'+control_vars.addprop+'</div></div></div></div></div>';

        jQuery('body').append(loading_modal);
        jQuery('#loadingmodal').modal();
    });


    jQuery('#add-new-image').on( 'click', function(event) {
        jQuery('<p><label for="file">New Image:</label><input type="file" name="upload_attachment[]" id="file_featured"></p> ').appendTo('#files_area');
    });



    jQuery('.delete_image').on( 'click', function(event) {
        var image_id=jQuery(this).attr('data-imageid');

        var curent=jQuery('#images_todelete').val();
        if(curent===''){
              curent=image_id;
        }else{
              curent=curent+','+image_id;
        }

        jQuery('#images_todelete').val(curent) ;
        jQuery(this).parent().remove();
   });

     /////////////////////////////////////////////////////////////////////////////////////////
     ////// mouse over map tooltip
     /////////////////////////////////////////////////////////////////////////////////////////

    jQuery('#googleMap').on('mousemove', function(e){
       jQuery('.tooltip').css({'top':e.pageY,'left':e.pageX, 'z-index':'1'});
    });

    setTimeout(function(){  jQuery('.tooltip').fadeOut("fast");},10000);
});

/////////////////////////////////////////////////////
////////////////// END ready

/*
*
*
*/


function wpestate_advnced_filters_bars(){
   
  
    jQuery('.wpestate-selectpicker').selectpicker({
        styleBase: 'wpestate-multiselect-custom-style',
        size:7
    }).on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        var elememtParent = jQuery(this).closest('.tab-pane.active');

        if(elememtParent.length==0){
            elememtParent = jQuery(this).parents().eq(2);
        }


        var elementId =jQuery(this).attr('id');

        const county_relations = {
            'county-state': 'advanced_city',
            'sidebar-county-state'  :'sidebar-advanced_city',
            'shortcode-county-state':'shortcode-advanced_city',
            'mobile-county-state':'mobile-advanced_city'
        };

        const city_relations = {
            'advanced_city': 'advanced_area',
            'sidebar-advanced_city': 'sidebar-advanced_area',
            'shortcode-advanced_city': 'shortcode-advanced_area',
            'mobile-advanced_city': 'mobile-advanced_area'
        };


        var selectedOption      = jQuery(this).find('option').eq(clickedIndex);
        var attributeTaxonomy   = selectedOption.attr('data-taxonomy'); // Replace 'your-attribute-name' with the actual attribute name
        var selectedOptions     = jQuery(this).find('option:selected');


        if(attributeTaxonomy==='cities' || attributeTaxonomy==='county / state'){
   
            //var triggerChangeOn="advanced_city"
            triggerChangeOn=county_relations[elementId];
            if(attributeTaxonomy==='cities'){
              //  triggerChangeOn='advanced_area';
                triggerChangeOn=city_relations[elementId];                
            }
     
            var selectedValues = jQuery(this).find('option:selected').map(function() {
                return jQuery(this).val();
            }).get();

            var elementCousin = elememtParent.find('#'+triggerChangeOn);


            elementCousin.find('option').each(function() {
                var optionValue = jQuery(this).data('parent-value'); // Getting the data-value attribute
                // Check if the option's data-value matches any of the selected values or if no values are selected
                if (selectedValues.length === 0 || selectedValues.indexOf(optionValue) !== -1) {
                    jQuery(this).show(); // Show the option if it matches or if no options are selected
                } else {
                    jQuery(this).hide(); // Hide the option if it does not match any selected value
                }
            });
        
            // Refresh the select picker to reflect the changes
            elementCousin.selectpicker('refresh');
           
        }

        // Example action:
        first_time_wpestate_show_inpage_ajax_half=1;
        wpestate_show_pins();

    }).on('shown.bs.select',function (e, clickedIndex, isSelected, previousValue) {
        var thisButton = jQuery(this);
   
        var windowWidth = jQuery(window).width();
        var buttonOffset = thisButton.offset();
        var buttonWidth = thisButton.outerWidth();
        var $dropdownMenu = jQuery(this).parent().find('.dropdown-menu.open');

        // Calculate distances from the edges of the window
        var distanceFromLeft = buttonOffset.left;
        var distanceFromRight = windowWidth - (buttonOffset.left + buttonWidth);

        // Check if the button is within 30px of either edge
        if (distanceFromLeft <= 150) {
            // Close to the left edge
            $dropdownMenu.css('left', 0);
            $dropdownMenu.css('right', 'auto');
        } else if (distanceFromRight <= 150) {
            // Close to the right edge
         
   
            $dropdownMenu.css('left', 'auto');
            $dropdownMenu.css('right', 0);
        } else {
            // do nothing for now
           
        }

    });
      
    
 
}

/*
*
* wp_estate_baths_component_item
*
*/

function wpestate_beds_baths_component() {
   
    function handleItemClick(itemClass, inputClass) {
        var selected_item = jQuery(this);
        var parent = selected_item.parent();
        var component = selected_item.closest('.wpestate-beds-baths-popoup-component');

        parent.find(itemClass).removeClass('wp_estate_component_item_selected');
        selected_item.addClass('wp_estate_component_item_selected');

        var selected_value = selected_item.attr('data-value');
        jQuery(inputClass).val(selected_value);
        update_label(component);
    }



    function update_label(component){
        var selected_beds = component.find('.wp_estate_beds_component_item.wp_estate_component_item_selected').length > 0 ? component.find('.wp_estate_beds_component_item.wp_estate_component_item_selected').attr('data-value') : '0';
        var selected_baths = component.find('.wp_estate_baths_component_item.wp_estate_component_item_selected').length > 0 ? component.find('.wp_estate_baths_component_item.wp_estate_component_item_selected').attr('data-value') : '0';

        var update_label=parseFloat(selected_beds)+'+ '+control_vars.bd+'/'+parseFloat(selected_baths)+'+ '+control_vars.ba;
        component.find('.dropdown-toggle').text(update_label);
    }

    // Attach event handlers
    jQuery('.wp_estate_beds_component_item').on('click', function(event) {
        event.stopPropagation();
        handleItemClick.call(this, '.wp_estate_beds_component_item', '.wpresidence-componentsbeds');
    });

    jQuery('.wp_estate_baths_component_item').on('click', function(event) {
        event.stopPropagation();
        handleItemClick.call(this, '.wp_estate_baths_component_item', '.wpresidence-componentsbaths');
    });

    jQuery('.wpestate-beds-baths-popoup-reset').on('click', function(event) {
        event.stopPropagation();
        var parent = jQuery(this).closest('.wpestate-beds-baths-popoup-wrapper');
        parent.find('.wp_estate_baths_component_item').removeClass('wp_estate_component_item_selected');
        parent.find('.wp_estate_beds_component_item').removeClass('wp_estate_component_item_selected');



        parent.find('.wpresidence-componentsbeds, .wpresidence-componentsbaths').val('');
        var component = jQuery(this).closest('.wpestate-beds-baths-popoup-component');
        var update_value=jQuery(this).attr('data-default-value')+'<span class="caret caret_filter "></span>';
        component.find('.dropdown-toggle').html(update_value);
    });

    jQuery('.wpestate-beds-baths-popoup-done').on('click', function() {
        first_time_wpestate_show_inpage_ajax_half=1;
        wpestate_show_pins();
    });

  
}


/*
*
* wp estate price component_item
*
*/
function wpestate_price_component_item(){

    jQuery('.wpestate-price-popoup-wrapper').on('click', function(event) {
        event.stopPropagation();
       
    });
    jQuery('.component_adv_search_elementor_price_low,.component_adv_search_elementor_price_max').on('focus',function(){
        jQuery(this).val('');
    })

    jQuery('.component_adv_search_elementor_price_low,.component_adv_search_elementor_price_max').on('input', function() {
        // Replace non-digit characters with an empty string
        jQuery(this).val(jQuery(this).val().replace(/\D/g, ''));
      
    });


    jQuery('.component_adv_search_elementor_price_low,.component_adv_search_elementor_price_max').on('change',function(event) {
        var inputValue = jQuery(this).val();
        var parent = jQuery(this).closest('.wpestate-price-popoup-wrapper');
        var numericValue = parseFloat(inputValue)
        var slider=parent.find('.ui-slider')
        if( jQuery(this).hasClass('component_adv_search_elementor_price_low') ){      
            slider.slider('values', 0, numericValue);
            slider.slider("option", "slide").call(slider, null, { values: [numericValue, slider.slider("values")[1]] });
        }else{
            slider.slider('values', 1, numericValue); 
            slider.slider("option", "slide").call(slider, null, { values: [slider.slider("values")[0], numericValue] });
        }
    });



    jQuery('.wpestate-price-component-popoup-reset').on('click',function(event){
        event.stopPropagation();
        var parent = jQuery(this).closest('.wpestate-price-popoup-wrapper');
        var low_value_label = parent.find('.wpestate-price-popoup-field-low').attr('data-value');
        var max_value_label = parent.find('.wpestate-price-popoup-field-max').attr('data-value');
        
        if(parent.find('.adv_search_elementor_price_low').length>0 ){
            var low_value       = parent.find('.adv_search_elementor_price_low').attr('data-value');
            var max_value       = parent.find('.adv_search_elementor_price_max').attr('data-value');
            parent.find('.adv_search_elementor_price_low').val(low_value);
            parent.find('.adv_search_elementor_price_max').val(max_value);
        }else{
            if( parent.find('.adv6_price_low').length > 0 ){
                var low_value       = parent.find('.adv6_price_low').attr('data-value');
                var max_value       = parent.find('.adv6_price_max').attr('data-value');
                parent.find('.adv6_price_low').val(low_value);
                parent.find('.adv6_price_max').val(max_value);
            }else{
                var low_value       = parent.find('.single_price_low').attr('data-value');
                var max_value       = parent.find('.single_price_max').attr('data-value');
                parent.find('.adv6_price_low').val(low_value);
                parent.find('.adv6_price_max').val(max_value);
            }
  
        }

        var button_item=parent.parent().find('.dropdown-toggle');
        button_item.html( button_item.attr('data-default-value')+' <span class="caret caret_filter "></span>' ) ;

        parent.find('.wpestate-price-popoup-field-low').val(low_value_label);
        parent.find('.wpestate-price-popoup-field-max').val(max_value_label);

    

        var slider_label = parent.find('.wpresidence_slider_price').attr('data-default'); 
        parent.find('.wpresidence_slider_price').text(slider_label);

        var slider=parent.find('.ui-slider')

        slider.slider('values', 0, parseFloat(low_value)) ; // sets first handle (e.g., min value)
        slider.slider('values', 1, parseFloat(max_value)); 


    })

    jQuery('.wpestate-price-component-popoup-done').on('click',function(event){
        var parent_wrapper = jQuery('body');
        var fake_click_item= parent_wrapper.parent();
        fake_click_item.trigger('click');
    })


}

/*
*
* format a price
*
*/
function wpestate_format_a_price(priceValue){
    thousandSeparator   = control_vars.price_separator;
    decimalPoints       = control_vars.decimal_poins;
    decimalSeparator    = control_vars.decimal_poins_separator;

    if (!isNaN(priceValue)) {
        priceValue= parseFloat(priceValue);
        var formattedPrice = priceValue.toFixed(decimalPoints).replace(/\d(?=(\d{3})+\.)/g, '$&' + thousandSeparator);
        formattedPrice = formattedPrice.replace('.', decimalSeparator);
        var formattedPriceWithCurrency= wpestate_return_price_with_multi_currency(formattedPrice);
        return formattedPriceWithCurrency;
    }


}


/*
*
* add currency to a price
*
*/

function wpestate_return_price_with_multi_currency(theValue){
    var return_string='';
    var my_custom_curr_symbol  =   decodeURI ( wpestate_getCookie('my_custom_curr_symbol') );
    var my_custom_curr_coef    =   parseFloat( wpestate_getCookie('my_custom_curr_coef'));
    var my_custom_curr_pos     =   parseFloat( wpestate_getCookie('my_custom_curr_pos'));
    var my_custom_curr_cur_post=   wpestate_getCookie('my_custom_curr_cur_post');

   

    if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
        if (my_custom_curr_cur_post === 'before') {
            return_string= wpestate_replace_plus( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + theValue;
        } else {
            return_string=theValue + " " +  wpestate_replace_plus( decodeURIComponent ( my_custom_curr_symbol ) ) ;
        }
    } else {

        if (control_vars.where_curency === 'before') {      
            return_string= wpestate_replace_plus( decodeURIComponent ( control_vars.curency ) ) + " " + theValue;
        } else {     
            return_string=theValue + " " +  wpestate_replace_plus( decodeURIComponent ( control_vars.curency ) ) ;
        }
    }

    return return_string;



}
/*
*
* wp estate price component_item v3
*
*/
function wpestate_price_component_item_v3(){
    jQuery('.wpestate-price-popoup-wrapper_v3').on('click', function(event) {

        event.stopPropagation();
        jQuery(this).find('.dropdown-menu').hide();  
    });

      
    jQuery('.wpestate_child_dropdown_item').on("click", function(e) {
        jQuery(this).parent().find('.dropdown-menu').toggle();  
        e.stopPropagation();
    });

   
    jQuery('.wpestate-price-component-popoup-reset_v3').on('click',function(event){
        event.stopPropagation();
        var parent = jQuery(this).closest('.wpestate-price-popoup-wrapper_v3');
    
        parent.find('.wpestate-price-component-select').each(function() {
            jQuery(this).val(jQuery(this).find('option:first').val());
        });

        var component = parent.closest('.wpestate-beds-baths-popoup-component');
        var update_value=jQuery(this).attr('data-default-value')+'<span class="caret caret_filter"></span>';

        var item_update_value = jQuery(this).attr('data-default-value2')+'<span class="caret caret_filter"></span>';
        component.find('.dropdown-toggle').html(update_value);
        component.find('.wpestate_child_dropdown_item').html(item_update_value);
        component.find('.wpresidence-component3_input_class').val('');
        component.find('.price_label_component').val('');

    })

    jQuery('.wpestate-price-component-popoup-done_v3').on('click',function(event){
        var parent_wrapper = jQuery('body');
        var fake_click_item= parent_wrapper.parent();
        fake_click_item.trigger('click');
        first_time_wpestate_show_inpage_ajax_half=1;
        wpestate_show_pins();
    })
 
 
    jQuery('.wpestate-price-popoup-wrapper_v3 li').on("click", function(e){      
        
        var parent = jQuery(this).closest('.wpestate-price-popoup-wrapper_v3');
        var component = parent.closest('.wpestate-beds-baths-popoup-component');
        var parent_ul = jQuery(this).parent();
        var selected_value = jQuery(this).attr('data-value');

        if(parent_ul.hasClass('wpresidence-component3-min-price_class')){
            var selectedmin =selected_value;
            var selectedmax = parent.find('.wpresidence-component3-max-price_input_class').val();
        }else{
            var selectedmin = parent.find('.wpresidence-component3-min-price_input_class').val();
            var selectedmax = selected_value
        }


        var update_value=wpestate_return_price_with_multi_currency(selectedmin)+" - "+wpestate_return_price_with_multi_currency(selectedmax);

        component.find('.dropdown-toggle').html(update_value);
        component.find('.price_label_component').val(update_value);        
        parent_ul.hide();
    });

}
/*
*
*wpestate-price-popoup-wrapper_v3
*/
function wpestate_reposion_dropdowns(){
    jQuery('.wpestate-multiselect-custom-style').on('click', function() {
       
    var $popupWrapper = jQuery(this);
    var $searchWrapper = $popupWrapper.closest('.search_wrapper'); // Get the closest parent with the class '.search_wrapper'

    if($searchWrapper.length===0){
        return;
    }

    var $dropdownMenu = jQuery(this).next('.wpestate-price-popoup-wrapper_v3');

    if($dropdownMenu.length==0){
        var $dropdownMenu = jQuery(this).next('.wpestate-beds-baths-popoup-wrapper');
    }
    if($dropdownMenu.length==0){
        var $dropdownMenu = jQuery(this).next('.wpestate-price-popoup-wrapper');
    }

    var popupOffset = $popupWrapper.offset();
    var searchOffset = $searchWrapper.offset();

    // Calculate the distances
    var distanceToLeft = popupOffset.left - searchOffset.left;
    var distanceToRight = (searchOffset.left + $searchWrapper.outerWidth()) - (popupOffset.left + $popupWrapper.outerWidth());

    if (distanceToLeft <= 150) {
        // Close to the left edge
        $dropdownMenu.css('left', 0);
        $dropdownMenu.css('right', 'auto');

    } else if (distanceToRight <= 150) {
        // Close to the right edge
        $dropdownMenu.css('left', 'auto');
        $dropdownMenu.css('right', 0);

    } 

        
        

    });
}


/*
*
*
*/

function wpestate_enable_slick_places(){

    jQuery('.estate_places_slider').each(function(){
        var items   = jQuery(this).attr('data-items-per-row');
        var auto    = parseInt(  jQuery(this).attr('data-auto') );
        var slick;

        if (auto === 0 ){

            slick=jQuery(this).not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: items,
                slidesToScroll: 1,
                dots: false,

                responsive: [
                    {
                    breakpoint:1025,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            if(control_vars.is_rtl==='1'){
                jQuery(this).slick('slickSetOption','rtl',true,true);
                jQuery(this).slick('slidesToScroll','-1');
            }
        }else{

            slick= jQuery(this).not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: items,
                slidesToScroll: 1,
                dots: false,
                autoplay: true,
                autoplaySpeed: auto,

                responsive: [
                    {
                     breakpoint:1025,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            if(control_vars.is_rtl==='1'){
                jQuery(this).slick('slickSetOption','rtl',true,true);
            }
        }
	});

}


/*
*
*
*/

function wpestate_enble_slick_slider_list(){


    jQuery('.shortcode_slider_list').each(function(){
        var items   = jQuery(this).attr('data-items-per-row');
        var auto    = parseInt(  jQuery(this).attr('data-auto') );
        var slick;
        if (auto === 0 ){

            slick=jQuery(this).not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: items,
                slidesToScroll: 1,
                dots: true,

                responsive: [
                    {
                    breakpoint:1025,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            if(control_vars.is_rtl==='1'){
                jQuery(this).slick('slickSetOption','rtl',true,true);
            }
        }else{

            slick= jQuery(this).not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: items,
                slidesToScroll: 1,
                dots: true,
                autoplay: true,
                autoplaySpeed: auto,

                 responsive: [
                    {
                    breakpoint:1025,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                    breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            if(control_vars.is_rtl==='1'){
                jQuery(this).slick('slickSetOption','rtl',true,true);
            }
        }
    });
}

/*
*
*
*/
function wpestate_enable_slick_theme_slider(items_received){
    var items=3;


    if (parseInt(items_received)!=='') {
      items=parseInt(items_received);
    }
    jQuery('.theme_slider_2,.property_multi_image_slider').each(function(){

        var auto    = parseInt(  jQuery(this).attr('data-auto') );

        if (auto === 0 ){

            jQuery(this).not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: items,
                slidesToScroll: 1,
                dots: true,

                responsive: [
                    {
                    breakpoint:1025,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                    },
                    {
                    breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            if(control_vars.is_rtl==='1'){
                jQuery(this).slick('slickSetOption','rtl',true,true);
            }


        }else{

            jQuery(this).not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: items,
                slidesToScroll: 1,
                dots: true,
                autoplay: true,
                autoplaySpeed: auto,

                responsive: [
                    {
                        breakpoint:1025,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            if(control_vars.is_rtl==='1'){
                  jQuery(this).slick('slickSetOption','rtl',true,true);
            }

        }
    });

}

/*
*
*
*/
function wpestate_schedule_tour_slider(){
    jQuery('.wpestate_property_schedule_dates_wrapper').each(function(){


        var items   = parseInt( jQuery(this).attr('data-visible-items'));

        jQuery(this).not('.slick-initialized').slick({
            infinite: true,
            slidesToShow: items,
            slidesToScroll: 1,
            dots: false,

            responsive: [
               /* {
                    breakpoint:1025,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },*/
                {
                    breakpoint: 480,
                    settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                    }
                }
            ]
        });
        if(control_vars.is_rtl==='1'){
                jQuery(this).slick('slickSetOption','rtl',true,true);
        }

    });

    jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
     
        jQuery('.wpestate_property_schedule_dates_wrapper').slick('setPosition');
    })


    jQuery('.wpestate_display_schedule_tour_option').on('click',function(event){
        var parent=jQuery(this).parent();
        parent.find('.wpestate_display_schedule_tour_option').removeClass('shedule_option_selected');
        jQuery(this).addClass('shedule_option_selected');
    });


    jQuery('.wpestate_property_schedule_singledate_wrapper').on('click',function(event){
        var parent=jQuery(this).parent();
        parent.find('.wpestate_property_schedule_singledate_wrapper').removeClass('shedule_day_option_selected');
        jQuery(this).addClass('shedule_day_option_selected');
    });



}


/*
*
*
*/
function wpestate_enable_slick_testimonial(){
    jQuery('.testimonial-slider-container').each(function(){


        var items   = parseInt( jQuery(this).attr('data-visible-items'));
        var auto    = parseInt( jQuery(this).attr('data-auto') );

        if (auto === 0 ){

            jQuery(this).not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: items,
                slidesToScroll: 1,
                dots: true,

                responsive: [
                    {
                        breakpoint:1025,
                        settings: {
                          slidesToShow: 1,
                          slidesToScroll: 1
                        }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                ]
            });
            if(control_vars.is_rtl==='1'){
                  jQuery(this).slick('slickSetOption','rtl',true,true);
            }
        }else{

            jQuery(this).not('.slick-initialized').slick({
                infinite: true,
                slidesToShow: items,
                slidesToScroll: 1,
                dots: true,
                autoplay: true,
                autoplaySpeed: auto,

                 responsive: [
                    {
                     breakpoint:1025,
                     settings: {
                       slidesToShow: 1,
                       slidesToScroll: 1
                     }
                   },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                ]
            });
            if(control_vars.is_rtl==='1'){
                jQuery(this).slick('slickSetOption','rtl',true,true);
            }
        }
    });
}

/*
*
*
*/
function wpestate_grid_list_controls(){

    jQuery('#list_view').unbind('click');
    jQuery('#list_view').on( 'click', function(event) {
        jQuery(this).toggleClass('icon_selected');
        jQuery('#listing_ajax_container').addClass('ajax12');
        jQuery('#grid_view').toggleClass('icon_selected');


        jQuery('#listing_ajax_container .listing_wrapper,.wpestate_filter_list_properties_wrapper .listing_wrapper').hide().removeClass('col-md-4').removeClass('col-md-6').removeClass('col-md-3').addClass('col-md-12').fadeIn(400) ;

        jQuery('.the_grid_view').fadeOut(10,function() {
            jQuery('.the_list_view:not(.half_map_list_view)').fadeIn(300);
        });

        // custom unit code
        jQuery('#listing_ajax_container .col-md-12.listing_wrapper .property_unit_custom_element.image').each(function(){
            jQuery(this).parent().addClass('wrap_custom_image');
        });

        jQuery('.col-md-12.listing_wrapper .property_unit_custom_element.image').each(function(){
            jQuery(this).parent().addClass('wrap_custom_image');
        });

        wpresidence_list_view_arrange();
     });



    jQuery('#grid_view').unbind('click');
    jQuery('#grid_view').on( 'click', function(event) {
        var class_type;

        class_type = jQuery('#listing_ajax_container .listing_wrapper').first().attr('data-org');

        if( jQuery('.wpestate_filter_list_properties_wrapper').length >0 ){
            class_type = jQuery('.wpestate_filter_list_properties_wrapper .listing_wrapper').first().attr('data-org');
        }


        jQuery(this).toggleClass('icon_selected');
        jQuery('#listing_ajax_container').removeClass('ajax12');
        jQuery('#list_view').toggleClass('icon_selected');
        jQuery('#listing_ajax_container .listing_wrapper,.wpestate_filter_list_properties_wrapper .listing_wrapper ').hide().removeClass('col-md-12').addClass('col-md-'+class_type).fadeIn(400);
        jQuery('#listing_ajax_container .the_list_view,.wpestate_filter_list_properties_wrapper .the_list_view').fadeOut(10,function(){
             jQuery('.the_grid_view').fadeIn(300);
        });

        jQuery('#listing_ajax_container .wrap_custom_image').each(function(){
            jQuery(this).removeClass('wrap_custom_image');
            jQuery('.property_listing_custom_design').css('padding-left','0px');
        });

     });



}


/*
*
*
*/
function  wpresidence_list_view_arrange(){
        var wrap_image = parseInt( jQuery('.wrap_custom_image').width());

        if(wrap_image!=0){
           jQuery('.col-md-12>.property_listing_custom_design').css('padding-left',wrap_image);
        }
}




/*
*
*
*/
function wpestate_filter_city_area(selected_city,selected_area){
    "use strict";
    jQuery('#'+selected_city+' li').on( 'click', function(event) {
        event.preventDefault();
        var pick, value_city, parent, selected_city, is_city, area_value;
        value_city   = String( jQuery(this).attr('data-value2') ).toLowerCase();

        jQuery('#'+selected_area+' li').each(function(){
            is_city = String ( jQuery(this).attr('data-parentcity') ).toLowerCase();
            is_city = is_city.replace(" ","-");
            area_value   = String ( jQuery(this).attr('data-value') ).toLowerCase();
            if(is_city === value_city || value_city === 'all' ){
                jQuery(this).show();
            }else{
                jQuery(this).hide();
            }
        });
    });
}


/*
*filter city by county
*
*/
function wpestate_filter_county_city(selected_county,selected_city){
    "use strict";
    jQuery('#'+selected_county+' li').on( 'click', function(event) {
        event.preventDefault();
        var pick, value_county, parent, selected_county, is_county, area_value;
        value_county   = String( jQuery(this).attr('data-value2') ).toLowerCase();

        jQuery('#'+selected_city+' li').each(function(){
            is_county = String ( jQuery(this).attr('data-parentcounty') ).toLowerCase();
            is_county = is_county.replace(" ","-");
            area_value   = String ( jQuery(this).attr('data-value') ).toLowerCase();



            if(is_county === value_county || value_county === 'all' ){
                jQuery(this).show();
            }else{
                jQuery(this).hide();
            }
        });
    });
}

/*
*
*
*/
function  wpestate_show_capture_vertical(){
    "use strict";

    var  slideno, slidedif, tomove, curentleft, position;
    jQuery('#googleMapSlider').hide();
    position=parseInt( jQuery('#carousel-listing .carousel-inner .active').index(),10);
    jQuery('#carousel-indicators-vertical  li').removeClass('active');
    jQuery('#carousel-listing  .caption-wrapper span').removeClass('active');
    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');
    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');

    jQuery("#carousel-indicators-vertical  li[data-slide-to='"+position+"'] ").addClass('active');

    slideno=position+1;

    slidedif=slideno*84;


    if( slidedif > 336){
        tomove=336-slidedif;
        tomove=tomove;
        jQuery('#carousel-indicators-vertical').css('top',tomove+"px");
    }else{
        position = jQuery('#carousel-indicators-vertical').css('top',tomove+"px").position();
        curentleft = position.top;

        if( curentleft < 0 ){
            tomove = 0;
            jQuery('#carousel-indicators-vertical').css('top',tomove+"px");
        }

    }
}

/*
*
*
*/
function  wpestate_show_capture_vertical2(slide_no){
    "use strict";

    var  slideno, slidedif, tomove, curentleft, position;
    jQuery('#googleMapSlider').hide();
    position=parseInt(slide_no,10);
    jQuery('#carousel-indicators-vertical  li').removeClass('active');
    jQuery('#carousel-listing  .caption-wrapper span').removeClass('active');
    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');
    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');

    //jQuery("#carousel-indicators-vertical  li[data-slide-to='"+position+"'] ").addClass('active');

    var new_post = position+1;
    new_post=new_post*84;
    slidedif=parseInt(new_post,10);
    if( slidedif > 336){
        tomove=336-slidedif;
        tomove=tomove;
        jQuery('#carousel-indicators-vertical').css('top',tomove+"px");
    }else{
        position = jQuery('#carousel-indicators-vertical').css('top',tomove+"px").position();
        curentleft = position.top;

        if( curentleft < 0 ){
            tomove = 0;
            jQuery('#carousel-indicators-vertical').css('top',tomove+"px");
        }

    }
}

/*
*
*
*/
function wpestate_show_capture2(slide_no){
    "use strict";

    var  slideno, slidedif, tomove, curentleft, position;
    jQuery('#googleMapSlider').hide();
    position=parseInt(slide_no,10);




    jQuery('#carousel-listing  .caption-wrapper span').removeClass('active');
    jQuery('#carousel-listing  .carousel-round-indicators li').removeClass('active');

    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');
    jQuery("#carousel-listing  .carousel-round-indicators li[data-slide-to='"+position+"'] ").addClass('active');


    var new_post = position+1;
    new_post=new_post*146;

    slidedif=parseInt(new_post,10);

    if( slidedif > 810){
        tomove=810-slidedif;
        jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px");
    }else{
        position = jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px").position();
        curentleft = position.left;

        if( curentleft < 0 ){
            tomove = 0;
            jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px");
        }

    }

}


/*
*
*
*/
function wpestate_show_capture(){
    "use strict";

    var  slideno, slidedif, tomove, curentleft, position;
    jQuery('#googleMapSlider').hide();
    position=parseInt( jQuery('#carousel-listing .carousel-inner .item.active').attr('data-number'),10);

    jQuery('#carousel-listing  .caption-wrapper span').removeClass('active');
    jQuery('#carousel-listing  .carousel-round-indicators li').removeClass('active');

    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');
    jQuery("#carousel-listing  .carousel-round-indicators li[data-slide-to='"+position+"'] ").addClass('active');
    slideno=position+1;

    slidedif=slideno*146;

    if( slidedif > 810){
        tomove=810-slidedif;
        jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px");
    }else{
        position = jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px").position();
        curentleft = position.left;

        if( curentleft < 0 ){
            tomove = 0;
            jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px");
        }

    }

}

/*
*
*
*/
function wpestate_raisePower(x, y) {
    "use strict";
    return Math.pow(x, y);
}

/*
*
*
*/
function wpestate_adv_search_click(){
    "use strict";
   jQuery('.with_search_form_float #adv-search-header-1,.with_search_form_float #adv-search-header-3').on( 'click', function(event) {

        if ( jQuery('#search_wrapper').hasClass('float_search_closed') ){
            jQuery('#search_wrapper').removeClass('float_search_closed');
        }else{
            jQuery('#search_wrapper').addClass('float_search_closed');
        }

   });

}


/*
*Contact footer
*
*/
function wpestate_contact_footer_starter(){
    "use strict";
    jQuery('#btn-cont-submit').on( 'click', function(event) {
       
        var contact_name, contact_email, contact_phone, contact_coment, agent_email, property_id, nonce, ajaxurl;
        contact_name    =   jQuery('#foot_contact_name').val();
        contact_email   =   jQuery('#foot_contact_email').val();
        contact_phone   =   jQuery('#foot_contact_phone').val();
        contact_coment  =   jQuery('#foot_contact_content').val();
        nonce           =   jQuery('#agent_property_ajax_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var parent = jQuery(this).parent().parent();

       
        if(ajaxcalls_vars.use_gdpr==='yes'){
            if (!parent.find('.wpestate_agree_gdpr').is(':checked')) {
                jQuery('#footer_alert-agent-contact').empty().append(ajaxcalls_vars.gdpr_terms);
                return;
            }
        }
     
        jQuery('#footer_alert-agent-contact').empty().append(ajaxcalls_vars.sending);



        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_ajax_agent_contact_form',
                'name'      :   contact_name,
                'email'     :   contact_email,
                'phone'     :   contact_phone,
                'comment'   :   contact_coment,
                'is_footer' :   'yes',
                'nonce'     :   nonce
            },
            success: function (data) {
       
                if (data.sent) {
                    jQuery('#foot_contact_name').val('');
                    jQuery('#foot_contact_email').val('');
                    jQuery('#foot_contact_phone').val('');
                    jQuery('#foot_contact_content').val('');
                    jQuery('#footer_alert-agent-contact').empty().addClass('wpestate-agent-contact-sent').append(data.response);
                }else{
                    jQuery('#footer_alert-agent-contact').empty().removeClass('wpestate-agent-contact-sent').append(data.response);
                }
   
              
            },
            error: function (errorThrown) {

            }
        });


        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_ajax_agent_contact_form_forcrm',
                'name'      :   contact_name,
                'email'     :   contact_email,
                'phone'     :   contact_phone,
                'comment'   :   contact_coment,
                'nonce'     :   nonce
            },
            success: function (data) {


            },
            error: function (errorThrown) {

            }
        });


    });
}


/*
*
*
*/
function estate_splash_slider(){
    if(jQuery("#splash_slider_wrapper").length>0){

    }
}


/*
*
*
*/
function wpestat_resize_wpestate_property_slider_v2(){
    
    var width   = 1090;
    var window  = jQuery( document ).width();
    
    var toadd=width+(window-width)/2;

    if(toadd>1090){
        jQuery('.property_slider_carousel_elementor_v2').css('width',toadd+'px');
    }else{
        jQuery('.property_slider_carousel_elementor_v2').css('width','100%');
    }
}


/*
*
*
*/
function wpestate_hotspots_click(){
    jQuery('.wpestate_hotspot_icon_wrapper').on('click',function(){
        jQuery('.wpestate_hotspot_tooltip').hide();
        jQuery(this).parent().find('.wpestate_hotspot_tooltip').show();
    });
   
}


/*
*
*
*/
function wpestate_hotspots_hover(){
      jQuery(".wpestate_hotspot_icon_wrapper").on('mouseenter', function () {
        jQuery(this).parent().find('.wpestate_hotspot_tooltip').show();
    }).on('mouseleave', function () {
        jQuery(this).parent().find('.wpestate_hotspot_tooltip').hide();
    });
            
           
}

/*
*
*
*/
function wpestate_testimonial_slider(slider_id){

    jQuery('#'+slider_id).owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:true,
        mouseDrag:true,
        video:true,
        autoHeight: true,
        stagePadding:0,
        URLhashListener:false,
       // rtl:true,
        navText : [
            '<i class="fas fa-arrow-left"></i>',
            '<i class="fas fa-arrow-right"></i>'
        ],
    });
  
}

/*
*
*
*/
function wpestate_property_slider_v2(slider_id,items){
   wpestat_resize_wpestate_property_slider_v2();

    var rtl_value=false;
    
    if( jQuery('#'+slider_id).attr('data-rtl')==='yes'){
        rtl_value=true;   
    }
    var is_loop=true;
   
    
    jQuery('#'+slider_id).owlCarousel({
        loop:is_loop,
        margin:0,
        nav:true,
        items:6,
        dots:false,
        mouseDrag:true,
        video:true,
        autoHeight: true,
        autoWidth:true,
        stagePadding:0,
        URLhashListener:false,
        rtl:rtl_value,
        navText : [
            '<i class="fas fa-arrow-left"></i>',
            '<i class="fas fa-arrow-right"></i>'
        ]  
    });
  
}

 
/*
*
*
*/
function wpestate_property_slider_v3(slider_id,items){

 
     var rtl_value=false;
     
     if( jQuery('#'+slider_id).attr('data-rtl')==='yes'){
         rtl_value=true;   
     }
     

     
    jQuery('#'+slider_id).owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:true,
        mouseDrag:true,
        video:true,
        autoHeight: true,
        stagePadding:0,
        URLhashListener:false,
        navText : [
            '<i class="fas fa-arrow-left"></i>',
            '<i class="fas fa-arrow-right"></i>'
        ],
        
    });
   
}


/*
*
*
*/
function wpestate_property_slider(){
    var owl_slider_property = jQuery("#property_slider_carousel").owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:false,
        mouseDrag:false,
        video:true,
        autoHeight: true,
        navText : [
            '<a class="left carousel-control"  data-slide="prev"><i class="demo-icon icon-left-open-big"></i></a>',
            '<a class="right carousel-control"  data-slide="next"><i class="demo-icon icon-right-open-big"></i></a>'
        ],
        URLhashListener:true,
    });

    var hash;
    var number;
    owl_slider_property.on('translated.owl.carousel', function(event) {

        hash    = jQuery(".carousel-inner .owl-item.active .item").attr('data-hash');
        number  = jQuery(".carousel-inner .owl-item.active .item").attr('data-number');

        jQuery('.carousel-round-indicators a').removeClass('active');
        jQuery('.carousel-indicators a').removeClass('active');
        jQuery('.carousel-indicators-classic a').removeClass('active');
        jQuery('.carousel-indicators-vertical a').removeClass('active');
        jQuery('a[href="#'+hash+'"]').addClass('active');

        if(jQuery(this).hasClass('carouselvertical') ){
            wpestate_show_capture_vertical2(number);
        }else{
            wpestate_show_capture2(number);
        }

    });

}

/*
*
*
*/
function wpestate_property_slider_2(){
    var autoplayvalue=false;
    var autoplayTimeoutvalue= parseInt( jQuery(".theme_slider_3").attr('data-auto'),10);

    if(autoplayTimeoutvalue>0){
        autoplayvalue=true;
    }


   var owl = jQuery(".property_slider2_wrapper").owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:false,
        autoplay:autoplayvalue,
        autoplayTimeout:autoplayTimeoutvalue,
        navText : ["<div class='nextright'><i class='demo-icon icon-right-open-big'></i></div>","<div class='nextleft'><i class='demo-icon icon-left-open-big'></i></div>"],
        URLhashListener:true,

    });

    var hash;
    owl.on('translated.owl.carousel', function(event) {

        hash = jQuery(".property_slider2_wrapper .owl-item.active .item").attr('data-hash');

        jQuery('.property_slider2_wrapper-indicators a').removeClass('active');
        jQuery('a[href="#'+hash+'"]').addClass('active');
    });


}

/*
*
*
*/
function wpestate_theme_slider_3(){
    var autoplayvalue=false;
    var autoplayTimeoutvalue= parseInt( jQuery(".theme_slider_3").attr('data-auto'),10);

    if(autoplayTimeoutvalue>0){
        autoplayvalue=true;
    }


   var owl = jQuery(".theme_slider_3").owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:false,
        autoplay:autoplayvalue,
        autoplayTimeout:autoplayTimeoutvalue,
        navText : [
            '<svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828"><g id="Group_30" data-name="Group 30" transform="translate(-1845.086 -1586.086)"><line id="Line_2" data-name="Line 2" x1="30" transform="translate(1846.5 1596.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"></line><line id="Line_3" data-name="Line 3" x1="9" y2="9" transform="translate(1846.5 1587.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"></line><line id="Line_4" data-name="Line 4" x1="9" y1="9" transform="translate(1846.5 1596.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"></line></g></svg>',
            '<svg xmlns="http://www.w3.org/2000/svg" width="32.414" height="20.828" viewBox="0 0 32.414 20.828"><g id="Symbol_1_1" data-name="Symbol 1 – 1" transform="translate(-1847.5 -1589.086)"><line id="Line_5" data-name="Line 2" x2="30" transform="translate(1848.5 1599.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"></line><line id="Line_6" data-name="Line 3" x2="9" y2="9" transform="translate(1869.5 1590.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"></line><line id="Line_7" data-name="Line 4" y1="9" x2="9" transform="translate(1869.5 1599.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"></line></g></svg>',
            ],
        URLhashListener:true,

    });

    var hash;
    owl.on('translated.owl.carousel', function(event) {

        hash = jQuery(".theme_slider_3 .owl-item.active .item").attr('data-hash');

        jQuery('.theme_slider_3_carousel-indicators a').removeClass('active');
        jQuery('a[href="#'+hash+'"]').addClass('active');
    });


}


/*
*
*
*/
function estate_sidebar_slider_carousel(){
    "use strict";

    jQuery(".owl-featured-slider").owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:false,

        navText : ["<div class='nextleft'><i class='demo-icon icon-left-open-big'></i></div>","<div class='nextright'><i class='demo-icon icon-right-open-big'></i></div>"],

    });

}

/*
*            
*/

function  estate_start_lightbox_slickslider(){
    
    jQuery('#owl-demo').each(function(){
       
        var slick;

       
        slick=jQuery(this).not('.slick-initialized').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            autoplay: false,
            nextArrow:'<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""><div class="nextright"><i class="demo-icon icon-right-open-big"></i></div></button>',
            prevArrow:'<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style=""><div class="nextleft"><i class="demo-icon icon-left-open-big"></i></div></button>'
        });


        jQuery('.lightbox_trigger').on( 'click', function(event) {    
  
            event.preventDefault();
            jump_slide=parseInt( jQuery(this).attr('data-slider-no') );
            jump_slide=jump_slide-1;

            jQuery('#owl-demo').slick('slickGoTo', jump_slide);
            jQuery('.lightbox_property_wrapper').show();

        });

        jQuery('.lighbox-image-close').on( 'click', function(event) {
            event.preventDefault();
            jQuery('.lightbox_property_wrapper').hide();
        });
    });


}

function estate_start_lightbox(){
    "use strict";
    
    if(control_vars.wp_estate_lightbox_slider=='slick'){
        estate_start_lightbox_slickslider();
        return;
    }

    var jump_slide;
    var owl = jQuery("#owl-demo").owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:false,
        startPosition:1,
        navText : ["<div class='nextleft'><i class='demo-icon icon-left-open-big'></i></div>","<div class='nextright'><i class='demo-icon icon-right-open-big'></i></div>"],
    });

    jQuery('.lightbox_trigger').on( 'click', function(event) {
        event.preventDefault();
        jump_slide=parseInt( jQuery(this).attr('data-slider-no') );
        jump_slide=jump_slide-1;
        var carousel = jQuery("#owl-demo");
        carousel.owlCarousel();
        carousel.trigger("to.owl.carousel", [jump_slide, 1, true]);
        jQuery('.lightbox_property_wrapper').show();

    });

    jQuery('.lighbox-image-close').on( 'click', function(event) {
        event.preventDefault();
        jQuery('.lightbox_property_wrapper').hide();
    });
}


/*
*
*
*/
function estate_start_lightbox_modal(){
    "use strict";
    var jump_slide;

    var owl = jQuery("#owl-demo-modal");
    owl.trigger("destroy.owl.carousel");

  owl.owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:false,
        startPosition:1,
        navText : ["<div class='nextleft'><i class='demo-icon icon-left-open-big'></i></div>","<div class='nextright'><i class='demo-icon icon-right-open-big'></i></div>"],


    });


    jQuery('.lightbox_trigger').on( 'click', function(event) {



        event.preventDefault();
        jump_slide=parseInt( jQuery(this).attr('data-slider-no') );
        var carousel = jQuery("#owl-demo-modal");
        carousel.owlCarousel();
          carousel.trigger("refresh.owl.carousel");

        carousel.trigger("to.owl.carousel", [jump_slide, 1, true]);
        jQuery('.lightbox_property_wrapper').show();

    });

    jQuery('.lighbox-image-close').on( 'click', function(event) {
        event.preventDefault();
        jQuery('.lightbox_property_wrapper').hide();
    });
}


/*
*
*
*/
function estate_start_lightbox_floorplans(){
    "use strict";
    var jump_slide;




    jQuery('.lighbox-image-close-floor').on( 'click', function(event) {
        event.preventDefault();
         jQuery('.master_header').css('z-index','100');
        jQuery('.container').css('z-index','2');
        jQuery('.header_media').css('z-index',3);
        jQuery('.lightbox_property_wrapper_floorplans').hide();
    });


   jQuery("#owl-demo-floor").owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        items:1,
        dots:false,
        startPosition:1,
        navText : ["<div class='nextleft'><i class='demo-icon icon-left-open-big'></i></div>","<div class='nextright'><i class='demo-icon icon-right-open-big'></i></div>"],

    });


    jQuery('.lightbox_trigger_floor').on( 'click', function(event) {
        event.preventDefault();
        jQuery('.lightbox_property_wrapper_floorplans').show();
        jQuery('.master_header').css('z-index','0');
        jQuery('.container').css('z-index','1');
        jQuery('.header_media').css('z-index',1);

        jump_slide=parseInt( jQuery(this).attr('data-slider-no') );
        jump_slide=jump_slide-1;
         var carousel2 = jQuery("#owl-demo-floor");
        carousel2.owlCarousel();
        carousel2.trigger("to.owl.carousel", [jump_slide,1,true]);
    });
}

/*
*
*
*/
function wpestate_blog_list_widget(){
    "use strict"
    var    ajaxurl         =   ajaxcalls_vars.wpestate_ajax;
    jQuery('.blog_list_loader').click(function (event){
   
        var button          =   jQuery(this);
        var container       =   jQuery(this).parent().parent();
        var control_terms_id=   container.attr('data-category_ids');
        var number          =   container.attr('data-number');
        var rownumber       =   container.attr('data-row-number');
        var card_version    =   container.attr('data-card-version');
        var sort_by         =   container.attr('data-sort-by');
        var page            =   container.attr('data-page');
        var display_grid    =   container.attr('data-display-grid');
        
        page=parseInt(page);
        page=page+1;
        container.attr('data-page',page);
        
        container.find('.wpestate_listing_sh_loader').show();
        
   
        jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'                :   'wpestate_load_blog_list_widget_wrapper',
            'control_terms_id'      :   control_terms_id,
            'number'                :   number,         
            'page'                  :   page,
            'rownumber'             :   rownumber,
            'card_version'          :   card_version,
            'sort_by'               :   sort_by,
            'display_grid'          :   display_grid,
          
        },


        success: function (data) {
            if(data!==''){
                container.find('.wpestate_listing_sh_loader').hide();
                container.find('.items_shortcode_wrapper_grid').append(data);
            }else{
                container.find('.wpestate_listing_sh_loader').hide();
                button.hide();
            }
        },
        error: function (errorThrown) {

        }
    });//end ajax
    });
    
    
}


/*
*
*
*/
function wpestate_property_list_sh(ajax_loader,ajax_filters){
    "use strict";
    var    ajaxurl         =   ajaxcalls_vars.wpestate_ajax;
    jQuery(ajax_loader).click( function(event) {
        var container               =   jQuery(this).parent().parent();
        var type                    =   container.attr('data-type');
        var category_ids            =   container.attr('data-category_ids');
        var action_ids              =   container.attr('data-action_ids');
        var city_ids                =   container.attr('data-city_ids');
        var area_ids                =   container.attr('data-area_ids');
        var state_ids               =   container.attr('data-state_ids');
        var status                  =   container.attr('data-status_ids');
        var features                =   container.attr('data-features_ids');
        var number                  =   container.attr('data-number');
        var align                   =   container.attr('data-align');
        var show_featured_only      =   container.attr('data-show_featured_only');
        var random_pick             =   container.attr('data-random_pick');
        var featured_first          =   container.attr('data-featured_first');
        var page                    =   container.attr('data-page');
        var align                   =   container.attr('data-align');
        var row_number              =   container.attr('data-row-number');
        var card_version            =   container.attr('data-card-version');
        var sort_by                 =   container.attr('data-sort-by');
        var display_grid            =   container.attr('data-display-grid');


        page=parseInt(page);
        page=page+1;
        container.attr('data-page',page);
        container.find('.wpestate_listing_sh_loader').show();

        page=parseInt(page);
        var nonce = jQuery('#wpestate_ajax_filtering').val();
        jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'                :   'wpestate_load_recent_items_sh',
            'type'                  :   type,
            'category_ids'          :   category_ids,
            'action_ids'            :   action_ids,
            'city_ids'              :   city_ids,
            'area_ids'              :   area_ids,
            'state_ids'             :   state_ids,
            'status'                :   status,
            'features'              :   features,
            'number'                :   number,
            'align'                 :   align,
            'show_featured_only'    :   show_featured_only,
            'random_pick'           :   random_pick,
            'featured_first'        :   featured_first,
            'page'                  :   page,
            'row_number'            :   row_number,
            'card_version'          :   card_version,
            'sort_by'              :   sort_by,
            'display_grid'          :   display_grid,
            'security'              :   nonce
        },


        success: function (data) {


            if(data.success==true && data.html!==''){ 
              
                
                container.find('.wpestate_listing_sh_loader').hide();
                
                if(container.find('.items_shortcode_wrapper_grid').length > 0){
                    container.find('.items_shortcode_wrapper_grid').append(data.html);
                }

                if(container.find('.items_shortcode_wrapper').length > 0){
                    container.find ('.items_shortcode_wrapper').append(data.html);
                }

                wpestate_restart_js_after_ajax();
                jQuery('.col-md-12.listing_wrapper .property_unit_custom_element.image').each(function(){
                    jQuery(this).parent().addClass('wrap_custom_image');
                });
                var wrap_image = parseInt( jQuery('.wrap_custom_image').width());

                if(wrap_image!=0){
                   jQuery('.col-md-12>.property_listing_custom_design').css('padding-left',wrap_image);
                }


            }else{
                container.find('.wpestate_listing_sh_loader').hide();
                jQuery(ajax_loader).hide();
            }


        },
        error: function (errorThrown) {

        }
    });//end ajax


    });


    jQuery(ajax_filters).on( 'click', function(event) {

        var container   =   jQuery(this).parent().parent();
        var taxid       =   jQuery(this).attr('data-taxid');
        var taxonomy    =   jQuery(this).attr('data-taxonomy');

        jQuery(this).parent().parent().find('.wpestate_item_list_sh').show();

        switch(taxonomy) {
            case 'property_category':

                var category_ids            =   container.attr('data-category_ids');
                category_ids = wpestate_replace_tax_id(jQuery(this),category_ids,taxid);
                container.attr('data-category_ids',category_ids);

                break;
            case 'property_action_category':

                var action_ids            =   container.attr('data-action_ids');
                action_ids = wpestate_replace_tax_id(jQuery(this),action_ids,taxid);
                container.attr('data-action_ids',action_ids);

                break;
            case 'property_city':

                var city_ids            =   container.attr('data-city_ids');
                city_ids = wpestate_replace_tax_id(jQuery(this),city_ids,taxid);
                container.attr('data-city_ids',city_ids);

                break;
            case 'property_area':

                var area_ids            =   container.attr('data-area_ids');
                area_ids = wpestate_replace_tax_id(jQuery(this),area_ids,taxid);
                container.attr('data-area_ids',area_ids);

                break;
            case 'property_county_state':


                var state_ids            =   container.attr('data-state_ids');
                state_ids = wpestate_replace_tax_id(jQuery(this),state_ids,taxid);
                container.attr('data-state_ids',state_ids);

                break;

            case 'property_status':
                var status_ids            =   container.attr('data-status_ids');
                status_ids = wpestate_replace_tax_id(jQuery(this),status_ids,taxid);

                container.attr('data-status_ids',status_ids);

                break;
            case 'property_features':
                var status_ids            =   container.attr('data-features_ids');
                status_ids = wpestate_replace_tax_id(jQuery(this),status_ids,taxid);

                container.attr('data-features_ids',status_ids);

                break;
    

        }
        container.attr('data-page',0);
        jQuery(this).toggleClass('tax_active');
container.find('.items_shortcode_wrapper_grid').empty();
        container.find('.listing_wrapper').remove();
        container.find('.wpestate_item_list_sh').trigger('click');

    });


    function wpestate_replace_tax_id(acesta,tax_ids,taxid){


        if(!acesta.hasClass('tax_active')){
            if ( tax_ids.indexOf(taxid) >= 0){
                return taxid+",";
            }else{
                tax_ids=tax_ids+taxid+",";
            }
        }else{
            var to_replace=taxid+",";
            tax_ids=tax_ids.replace(to_replace , "");
        }
        return tax_ids;

    }

}


/*
*
*
*/
function wpestate_open_menu(){
    "use strict";

    jQuery('.header_phone').on('click',function(event){
        event.stopPropagation();
    });

    jQuery('#user_menu_u.user_loged').on( 'click', function(event) {
        jQuery('#wpestate_header_shoping_cart').fadeOut(400);
        if( jQuery('#user_menu_open').is(":visible")){
            jQuery('#user_menu_open').removeClass('iosfixed').fadeOut(400);
            jQuery('.navicon-button').removeClass('opensvg');
        }else{
            jQuery('#user_menu_open').fadeIn(400);
            jQuery('.navicon-button').addClass('opensvg');
        }
        event.stopPropagation();
    });
}

/*
*
*
*/
function wpestate_contact_us_shortcode(){
    "use strict";
    jQuery('#btn-cont-submit_sh').on( 'click', function(event) {
        var parent,contact_name, contact_email, contact_phone, contact_coment, agent_email, property_id, nonce, ajaxurl;
        contact_name    =   jQuery('#foot_contact_name_sh').val();
        contact_email   =   jQuery('#foot_contact_email_sh').val();
        contact_phone   =   jQuery('#foot_contact_phone_sh').val();
        contact_coment  =   jQuery('#foot_contact_content_sh').val();
        nonce           =   jQuery('#agent_property_ajax_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        parent          =   jQuery(this).parent().parent();
   
        if(ajaxcalls_vars.use_gdpr==='yes'){
            if (!parent.find('.wpestate_agree_gdpr').is(':checked')) {
                jQuery('#footer_alert-agent-contact_sh').empty().removeClass('wpestate-agent-contact-sent').append(ajaxcalls_vars.gdpr_terms);
                return;
            }
        }
     
        jQuery('#footer_alert-agent-contact_sh').empty().append(ajaxcalls_vars.sending);

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_ajax_agent_contact_form',
                'name'      :   contact_name,
                'email'     :   contact_email,
                'phone'     :   contact_phone,
                'comment'   :   contact_coment,
                'nonce'     :   nonce
            },
            success: function (data) {

                if (data.sent) {
                    jQuery('#foot_contact_name_sh').val('');
                    jQuery('#foot_contact_email_sh').val('');
                    jQuery('#foot_contact_phone_sh').val('');
                    jQuery('#foot_contact_content_sh').val('');
                    jQuery('#footer_alert-agent-contact_sh').empty().addClass('wpestate-agent-contact-sent').append(data.response);
                }else{
                    jQuery('#footer_alert-agent-contact_sh').empty().removeClass('wpestate-agent-contact-sent').append(data.response);
                }

            },
            error: function (errorThrown) {

            }
        });
    });

}







/*
*
*
*/
function wpestate_enable_property_modal(listing_id,main_img_url,main_title,link){
    "use strict";

    if (Modernizr.mq('only all and (max-width: 1024px)')) {
        return;
    }



    jQuery('.website-wrapper').css('position','fixed');
    jQuery('#property_modal_images').empty();
    var ajaxurl     =   ajaxcalls_vars.wpestate_ajax;
    var window_height =jQuery( window ).height();

    jQuery("#property_modal_images") .css('height', window_height+'px');
    window_height=window_height-183;
    jQuery("#property_modal_content").css('height', window_height+'px');

    jQuery('#modal_property_agent').empty();
    jQuery('.modal_content_block').empty();
    jQuery('#property_modal_content .modal_property_description').empty();
    jQuery('#property_modal_content .modal_property_adress').empty();
    jQuery('#property_modal_content .modal_property_details').empty();
    jQuery('#property_modal_content .modal_property_features').empty();
    jQuery('#property_modal_content .modal_property_video').empty();
    jQuery('#property_modal_content .modal_property_video_tour').empty();
    jQuery('#property_modal_content .modal_property_walkscore').empty();
    jQuery('#property_modal_content .modal_property_floor_plans').empty();
    jQuery('#modal_property_mortgage').empty();
    jQuery('#modal_property_maps').empty();
    jQuery('#property_details_modal_wrapper').show();

    //prepopoluate
    var to_apped    ='<img src="'+main_img_url+'" data-slider-no="1" class="img-responsive lightbox_trigger" alt="image">';

    jQuery('#property_modal_images').append(to_apped);
    jQuery('#property_modal_header .modal_property_title').html(main_title);
    jQuery('#owl-demo-modal').empty();


    wpestate_propery_preview_prepopulate();


    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_property_modal_listing_details',
            'postid'            :   listing_id,

         //   'security'          :   nonce,
        },
        success: function (data) {

            if(data.response===true){


                data.images.forEach(wpestate_populate_modal_images);
                jQuery('.property_placeholder').remove();
                data.full_images.forEach(wpestate_populate_modal_images_full);
                wpestate_populate_content(data);

            }
        },
        error: function (errorThrown) {

        }
    });//end ajax

    ///
    /// aysn request no 2
    ////////////////////////////////////////////////////////////////////////////
     jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_property_modal_listing_details_second',
            'postid'            :   listing_id,

         //   'security'          :   nonce,
        },
        success: function (data) {

            if(data.response===true){

                jQuery('#property_modal_content .modal_property_yelp').empty().append(data.yelp);
               // jQuery('#property_modal_content .modal_property_walkscore').empty().append(data.walkscore);
                jQuery('#property_modal_content .modal_property_floor_plans').empty().append(data.floor_plans);
                jQuery('#modal_property_mortgage').empty().append(data.mortgage);
                jQuery('#modal_property_maps').empty().append(data.map);


                //floor plans
                wpestate_enable_floor_plans();
                estate_start_lightbox_floorplans();

                //mortgage
                wpestate_show_morg_pie();

                // map
      
                wpestate_map_shortcode_function();

            }
        },
        error: function (errorThrown) {

        }
    });//end ajax
}


/*
*
*
*/

function wpestate_populate_content(data){
    jQuery('#property_modal_top_bar').empty();
    jQuery('#property_modal_top_bar').append(data.favorite);
    jQuery('#property_modal_top_bar').append(data.share);


    jQuery('#property_modal_header .modal_property_title').html('<a href="'+data.link+'" target="_blank">'+data.title+'</a>');
    jQuery('#property_modal_header .modal_property_price').html(data.price);
    jQuery('#property_modal_header .modal_property_bed').html(data.beds_section);
    jQuery('#property_modal_header .modal_property_addr').html(data.addr_section);

    
    jQuery('#modal_property_agent').empty().append(data.agent_section);
    jQuery('#property_modal_content .modal_property_description').empty().append(data.content);
    jQuery('#property_modal_content .modal_property_adress').empty().append(data.address);
    jQuery('#property_modal_content .modal_property_details').empty().append(data.details);
    jQuery('#property_modal_content .modal_property_features').empty().append(data.features);
    jQuery('#property_modal_content .modal_property_video').empty().append(data.video);
    jQuery('#property_modal_content .modal_property_video_tour').empty().append(data.video_tour);

    //contact
     wpestate_agent_contact_modals();
    //img
    estate_start_lightbox_modal();

    // video
    if (jQuery(".venobox").length > 0){
        jQuery('.venobox').venobox();
    }

    //favorite
    wpestate_add_to_favorites();

    //print
     wpestate_print_property_page();

}

/*
*
*
*/
function wpestate_populate_modal_images(value,index){

    if(  jQuery('.property_placeholder').length>0 ){
        var placeholder= jQuery('.property_placeholder:first');
        placeholder.attr('src',value).removeClass('property_placeholder');
    }else{
        var to_apped='<img src="'+value+'" data-slider-no="'+index+'" class="img-responsive lightbox_trigger" alt="image">';

        jQuery('#property_modal_images').append(to_apped);
    }


}

/*
*
*
*/
function wpestate_populate_modal_images_full(value,index){
   // var to_append2='<div class="item"><img src="'+value+'"></div>';
     var  to_append2='<div class="owl_holder" style="background-image:url('+value+')"></div>';
    jQuery('#owl-demo-modal').append(to_append2);
}


/*
*
*
*/
function wpestate_propery_preview_prepopulate(){

    path_image=control_vars.path+'/img/placeholder1.png';
    for (i = 0; i <14; i++) {
        var to_apped='<img src="'+path_image+'" class="img-responsive  lightbox_trigger property_placeholder" data-slider-no="'+(i+1)+'" alt="image">';
        jQuery('#property_modal_images').append(to_apped);
    }
}

/*
*
*
*/

function wpestate_agent_contact_modals(){
    wpestate_agent_submit_email();

    wpestate_enable_schedule_contact();

    jQuery( "#modal_contact_agent").unbind( "click" );
    jQuery('#modal_contact_agent').on('click',function(event){
        jQuery('.schedule_wrapper').hide();
        jQuery('#property_modal_content .agent_contanct_form').slideDown();

        jQuery('#property_modal_content').animate({
                scrollTop: 0
            },
            "slow"
        );
    });



}

/*
*
*
*/

function wpestate_get_location(){

    if(control_vars.location_animation==='no'){
      return;
    }
    if(  jQuery('.heading_over_image').length===0){
        return;
    }

    jQuery.get("https://ipapi.co/json", function(place) {
        var city = place.city;

        if(city == null ||  parseInt( jQuery('.home').length)===0 ){
             //do nothing
            }else{
                var heading = control_vars.location_animation_text;

                heading = heading.replace("%city%", city);

                jQuery('.home .heading_over_image,.home .heading_over_video').slideUp("300",function(){
                    jQuery('.home .heading_over_image,.home .heading_over_video').text(heading);
                    jQuery('.home .heading_over_image,.home .heading_over_video').slideDown();
                });

            }
        }, "json");
}


/*
*
* 
*/

function wpestate_slider_box(){
   
    jQuery( ".wpestate_sliding_box" ).mouseover(function() {
        var selected_item   = jQuery(this);
        var item_parent     = selected_item.parent();
        
        item_parent.find('.wpestate_sliding_box').removeClass('active-element')

        selected_item.addClass('active-element');
    });
}



/*
*Mobile Menu Slide out
*
*/
function wpestate_mobile_menu_slideout(){
    var vc_size;
    var var_parents=new Array();
    var var_parents_back=new Array();

  


    if(jQuery('.mobile-trigger-user').length>0){
        var slideout_user_menu = new Slideout({
            'panel': document.getElementById('all_wrapper'),
            'menu': document.getElementById('mobilewrapperuser'),
            'padding': -256,
            'tolerance': 70
        });

        slideout_user_menu.disableTouch();

        // Toggle button
        document.querySelector('.mobile-trigger-user').addEventListener('click', function() {
            slideout_user_menu.toggle();
           // jQuery('#mobilewrapperuser').show();
            if(jQuery('#mobilewrapperuser').is(':visible') ){
                jQuery('#mobilewrapperuser').hide();
            }else{
                jQuery('#mobilewrapperuser').show();
            }
        
        });
       
        jQuery('.mobilemenu-close-user').on( 'click', function(event) {
            slideout_user_menu.toggle();
            setTimeout(function() { 
                jQuery('#mobilewrapperuser').hide(); 
            }, 200);
    
        });

    }



    
    if(jQuery('.mobile-trigger').length>0){

        var slideout_link_menu = new Slideout({
            'panel': document.getElementById('all_wrapper'),
            'menu': document.getElementById('mobilewrapper_links'),
            'padding': 256,
            'tolerance': 70,
            'side': 'left',
            'easing': 'cubic-bezier(.32,2,.55,.27)'
        });
        slideout_link_menu.disableTouch();
        document.querySelector('.mobile-trigger').addEventListener('click', function() {
            slideout_link_menu.toggle();
          
            if(jQuery('#mobilewrapper_links').is(':visible') ){
                jQuery('#mobilewrapper_links').hide();
            }else{
                jQuery('#mobilewrapper_links').show();
            }
        });

        jQuery('.mobilemenu-close').on( 'click', function(event) {
            slideout_link_menu.toggle();
            setTimeout(function() { 
                jQuery('#mobilewrapper_links').hide();
            }, 200);
        });
    }
    
}

/*
* Mobile Menu open submenu
*/

function wpestate_mobile_menu_open_submenu(){
    jQuery('#menu-main-menu li').on( 'click', function(event) {
        event.stopPropagation();
        var selected;
        selected = jQuery(this).find('.sub-menu:first');
        selected.slideToggle();
    });

}




/*
* Control media buttons
*/

function wpestate_control_media_buttons(){
    var curentID;

    jQuery('.wpestate_control_media_button').on('click',function(){
        jQuery('.wpestate_control_media_button').removeClass('slideron');
        jQuery(this).addClass('slideron');
        jQuery('.wpestate_property_media_section_wrapper .status-wrapper').hide();

        jQuery('.wpestate_property_slider_thing').hide();
        var div_to_show=jQuery(this).attr('data-show');

        jQuery('.'+div_to_show).show();
        if(div_to_show=='wpestate_property_carousel'){
            jQuery('.wpestate_property_media_section_wrapper .status-wrapper').show();
        }

        if(div_to_show=='google_map_slider_wrapper'){
            wpestate_control_media_emable_map();
        } 
        
        if(jQuery(this).attr('id')=='slider_enable_street'){
            wpestate_control_media_emable_street_view();
        }

        
    });
}



/*
*
* Enable Street Map
*
*/


function wpestate_control_media_emable_street_view(){
    var cur_lat, cur_long, myLatLng;

    cur_lat     =   jQuery('#googleMapSlider').attr('data-cur_lat');
    cur_long    =   jQuery('#googleMapSlider').attr('data-cur_long');
    myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);

    jQuery('#gmapzoomplus.smallslidecontrol,#gmapzoomminus.smallslidecontrol,.google_map_poi_marker ').hide();

    panorama.setPosition(myLatLng);
    panorama.setVisible(true);
}

/*
*
* Enable Map for Slider
*
*/

function wpestate_control_media_emable_map(){
    jQuery('#googleMapSlider').show();
    jQuery('#gmapzoomplus.smallslidecontrol,#gmapzoomminus.smallslidecontrol,.google_map_poi_marker ').show();

    if(wp_estate_kind_of_map===1){
        google.maps.event.trigger(map, "resize");
    }else{
        setTimeout(function(){ map.invalidateSize(); }, 600);
    }

    cur_lat     =   jQuery('#googleMapSlider').attr('data-cur_lat');
    cur_long    =   jQuery('#googleMapSlider').attr('data-cur_long');

    if(wp_estate_kind_of_map===1){
        map.setOptions({draggable: true});
        myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);
        map.setCenter(myLatLng);
        map.panBy(10,-100);
        panorama.setVisible(false);
    }
   
}
/*
*
* Get Cookie
*
*/
function wpestate_getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
 }


 /*
*
* eanble advanced tab functions
*
*/

function wpestate_advtabs_function(item){

    var all_sliders = ['mainform','sidebar','shortcode','mobile','half'];
    var min_tab_slider=    control_vars.adv6_min_price[slider_counter];
    var max_tab_slider=    control_vars.adv6_max_price[slider_counter];

    slider_counter++;
    for (var i = 0, length = all_sliders.length; i < length; i++) {
        wpestate_enable_slider_tab_for_all(all_sliders[i],item,min_tab_slider,max_tab_slider);
    }
}


/*
*
* eanble advanced tab functions
*
*/


function wpestate_enable_slider_tab_for_all(position,item,min_tab_slider,max_tab_slider){

    var slider_id = 'slider_price_'+item+'_'+position ;
    var price_min = 'price_low_'+item;
    var price_max = 'price_max_'+item;
    var ammount   = 'amount_'+item+'_'+position;


    var my_custom_curr_symbol  =   decodeURI ( wpestate_getCookie('my_custom_curr_symbol') );
    var my_custom_curr_coef    =   parseFloat( wpestate_getCookie('my_custom_curr_coef'));
    var my_custom_curr_pos     =   parseFloat( wpestate_getCookie('my_custom_curr_pos'));
    var my_custom_curr_cur_post=   wpestate_getCookie('my_custom_curr_cur_post');

//    wpestate_enable_slider(slider_id, price_min, price_max, ammount, my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post, my_custom_curr_coef) ;
    wpestate_enable_slider_tab(min_tab_slider,max_tab_slider,'slider_price_'+item+'_'+position, 'price_low_'+item, 'price_max_'+item, 'amount_'+item+'_'+position, my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef,control_vars.adv6_min_price[slider_counter],control_vars.adv6_max_price[slider_counter]);

    jQuery( '#slider_price_'+item +'_'+position).slider({
        stop: function( event, ui ) {
            if (typeof (wpestate_show_pins) !== "undefined") {
                first_time_wpestate_show_inpage_ajax_half=1;

                wpestate_show_pins();
            }
        }
    });
}


/*
*
* eanble slider tab
*/
function wpestate_enable_slider_tab(slider_min,slider_max,slider_name, price_low, price_max, amount, my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post, my_custom_curr_coef) {
 
    "use strict";
    var price_low_val, price_max_val, temp_min, temp_max;
    price_low_val = parseInt(jQuery('#'+price_low).val(), 10);
    price_max_val = parseInt(jQuery('#'+price_max).val(), 10);


    slider_min = parseInt(slider_min,10);
    slider_max = parseInt(slider_max,10);

    if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
        slider_min =slider_min *my_custom_curr_coef;
        slider_max =slider_max *my_custom_curr_coef;
    }

    var slider_parent =  jQuery("#" + slider_name).parent();

    var parent =  jQuery("#" + slider_name).parent().parent();
    var component_price_min;
    var component_price_max;
    var dropdown_parent;
    var dropdown_label;
    var component_label_value;

    if(parent.hasClass('wpestate-price-popoup-wrapper')){
        component_price_min=parent.find('#component_'+price_low);
        component_price_max=parent.find('#component_'+price_max);
        var dropdown_parent=parent.parent().find('.dropdown-toggle');
        dropdown_label = parent.find('.price_label_component');
    
    }



    jQuery("#" + slider_name).slider({
        range: true,
        min: parseFloat(slider_min),
        max: parseFloat(slider_max),
        values: [price_low_val, price_max_val ],
        slide: function (event, ui) {
            temp_min= ui.values[0].format() ;
            temp_max= ui.values[1].format();
            if(control_vars.indian_format==="yes"){
              temp_min=wpstrea_js_indian_format(ui.values[0]);
              temp_max=wpstrea_js_indian_format(ui.values[1]);
            }



            if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
                slider_parent.find("#" + price_low).val(ui.values[0]);
                slider_parent.find("#" + price_max).val(ui.values[1]);

                jQuery("#price_low").val(ui.values[0]);
                jQuery("#price_max").val(ui.values[1]);




                if (my_custom_curr_cur_post === 'before') {
                    jQuery("#" + amount).text( wpestate_replace_plus( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + temp_min + " " + control_vars.to + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) )+ " " + temp_max);
                    if(parent.hasClass('wpestate-price-popoup-wrapper')){
                        component_price_min.val( wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + temp_min );
                        component_price_max.val( wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol) ) + " " + temp_max );
                        component_label_value = ""+ wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + wpestate_formatNumber_short(ui.values[0])+ " - " +  wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + wpestate_formatNumber_short(ui.values[1]) ;
                    
                        dropdown_parent.text(component_label_value);
                        dropdown_label.val(component_label_value);
                    }
               
                } else {
                    jQuery("#" + amount).text(temp_min + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) )+ " " + control_vars.to + " " + temp_max+ " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) );
                    if(parent.hasClass('wpestate-price-popoup-wrapper')){
                        component_price_min.val( temp_min + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) );
                        component_price_max.val( temp_max + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol)  ) );
                        component_label_value= wpestate_formatNumber_short(ui.values[0]) + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) + " - " + wpestate_formatNumber_short(ui.values[1]) + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) ;
                   
                        dropdown_parent.text(component_label_value);
                        dropdown_label.val(component_label_value);
                    }
                }
            } else {
                slider_parent.find("#" + price_low).val(ui.values[0]);
                slider_parent.find("#" + price_max).val(ui.values[1]);


                jQuery("#price_low").val(ui.values[0]);
                jQuery("#price_max").val(ui.values[1]);

                if (control_vars.where_curency === 'before') {
                    jQuery("#" + amount).text( wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + temp_min + " " + control_vars.to + " " +  wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + temp_max );
                    if(parent.hasClass('wpestate-price-popoup-wrapper')){
                        component_price_min.val( wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + temp_min );
                        component_price_max.val( wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + temp_max );
                        component_label_value = ""+ wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + wpestate_formatNumber_short(ui.values[0])+ " - " +  wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + wpestate_formatNumber_short(ui.values[1])  ;
                  
                        dropdown_parent.text(component_label_value);
                        dropdown_label.val(component_label_value);
                  
                    }
                } else {
                    jQuery("#" + amount).text(temp_min + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + control_vars.to + " " + temp_max + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) );
                    if(parent.hasClass('wpestate-price-popoup-wrapper')){
                        component_price_min.val( temp_min + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) );
                        component_price_max.val( temp_max + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) )  );
                        component_label_value = wpestate_formatNumber_short(ui.values[0]) + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " - " + wpestate_formatNumber_short(ui.values[1]) + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) ;
                   
                        dropdown_parent.text(component_label_value);
                        dropdown_label.val(component_label_value);
                    }
                }
            }
        }
    });
}





/*
*
* replace string
*
*/
function wpestate_replace_plus(string){
    return string.replace("+"," ");
}

/*
*
* js indiam format
*
*/

function wpstrea_js_indian_format(value){
    value=value.toString();
    var afterPoint = '';
    if(value.indexOf('.') > 0)
       afterPoint = value.substring(value.indexOf('.'),value.length);
    value = Math.floor(value);
    value=value.toString();
    var lastThree = value.substring(value.length-3);
    var otherNumbers = value.substring(0,value.length-3);
    if(otherNumbers != '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
    return res;
}


/*
*
* Eanble Slider
*
*/
function wpestate_enable_slider(slider_name, price_low, price_max, amount, my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post, my_custom_curr_coef) {

    var price_low_val, price_max_val, temp_min, temp_max, slider_min, slider_max;
    price_low_val = parseInt(jQuery('#'+price_low).val(), 10);
    price_max_val = parseInt(jQuery('#'+price_max).val(), 10);


    slider_min = control_vars.slider_min;
    slider_max = control_vars.slider_max;
    

    if( jQuery('#'+price_max).hasClass('adv_search_elementor_price_max') ){
        slider_max = jQuery('#'+price_max).attr('data-value');
        slider_min = jQuery('#'+price_low).attr('data-value');       
    }

    if( jQuery('#'+price_max).hasClass('wpestate_slider_in_tab') ){
        slider_max = jQuery('#'+price_max).attr('data-value');
        slider_min = jQuery('#'+price_low).attr('data-value');
       
    }



    if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
        slider_min =slider_min *my_custom_curr_coef;
        slider_max =slider_max *my_custom_curr_coef;
    }
    
    var parent =  jQuery("#" + slider_name).parent().parent();
    var component_price_min;
    var component_price_max;
    var dropdown_parent;
    var dropdown_label;
    var component_label_value;
    if(parent.hasClass('wpestate-price-popoup-wrapper')){
        component_price_min=parent.find('#component_'+price_low);
        component_price_max=parent.find('#component_'+price_max);
        var dropdown_parent=parent.parent().find('.dropdown-toggle');
        dropdown_label = parent.find('.price_label_component');
    
    }


    jQuery("#" + slider_name).slider({
        range: true,
        min: parseFloat(slider_min),
        max: parseFloat(slider_max),
        values: [price_low_val, price_max_val ],
        slide: function (event, ui) {

            jQuery("#" + price_low).val(ui.values[0]);
            jQuery("#" + price_max).val(ui.values[1]);
            temp_min= ui.values[0].format() ;
            temp_max= ui.values[1].format();
            if(control_vars.indian_format==="yes"){
              temp_min=wpstrea_js_indian_format(ui.values[0]);
              temp_max=wpstrea_js_indian_format(ui.values[1]);
            }

            if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
                if (my_custom_curr_cur_post === 'before') {
                    jQuery("#" + amount).text( wpestate_replace_plus( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + temp_min + " " + control_vars.to + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) )+ " " + temp_max);
                    if(parent.hasClass('wpestate-price-popoup-wrapper')){
                        component_price_min.val( wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + temp_min );
                        component_price_max.val( wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol) ) + " " + temp_max );
                        component_label_value = ""+ wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + wpestate_formatNumber_short(ui.values[0])+ " - " +  wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + wpestate_formatNumber_short(ui.values[1]) ;
                    
                        dropdown_parent.text(component_label_value);
                        dropdown_label.val(component_label_value);
                    }
                } else {
                    jQuery("#" + amount).text(temp_min + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) )+ " " + control_vars.to + " " + temp_max + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) );
                    if(parent.hasClass('wpestate-price-popoup-wrapper')){
                        component_price_min.val( temp_min + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) );
                        component_price_max.val( temp_max + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol)  ) );
                        component_label_value= wpestate_formatNumber_short(ui.values[0]) + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) + " - " + wpestate_formatNumber_short(ui.values[1]) + " " + wpestate_replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) ;
                   
                        dropdown_parent.text(component_label_value);
                        dropdown_label.val(component_label_value);
                    }
                }
            } else {

                if (control_vars.where_curency === 'before') {
                    jQuery("#" + amount).text(""+ wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + temp_min+ " " + control_vars.to + " " +  wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + temp_max);
                    if(parent.hasClass('wpestate-price-popoup-wrapper')){
                        component_price_min.val( wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + temp_min );
                        component_price_max.val( wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + temp_max );
                        component_label_value = ""+ wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + wpestate_formatNumber_short(ui.values[0])+ " - " +  wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + wpestate_formatNumber_short(ui.values[1])  ;
                  
                        dropdown_parent.text(component_label_value);
                        dropdown_label.val(component_label_value);
                  
                    }
                } else {
                    jQuery("#" + amount).text(temp_min + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + control_vars.to + " " + temp_max + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) );
                    if(parent.hasClass('wpestate-price-popoup-wrapper')){
                        component_price_min.val( temp_min + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) );
                        component_price_max.val( temp_max + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) )  );
                        component_label_value = wpestate_formatNumber_short(ui.values[0]) + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " - " + wpestate_formatNumber_short(ui.values[1]) + " " + wpestate_replace_plus ( decodeURIComponent ( control_vars.curency ) ) ;
                   
                        dropdown_parent.text(component_label_value);
                        dropdown_label.val(component_label_value);
                    }
                }
            }
        }
    });
}

/*
*
* enable slider for elementor
*
*/

function wpestate_enable_slider_elementor(){

    jQuery('.wpestate_elementor_search_tab_slider_wrapper').each(function(){
        var slider_id = jQuery(this).find('.wpestate_elementor_search_tab_slider').attr('id');
        var price_min = jQuery(this).find('.adv_search_elementor_price_low').attr('id');
        var price_max = jQuery(this).find('.adv_search_elementor_price_max').attr('id');
        var ammount   = jQuery(this).find('.wpresidence_slider_price').attr('id');
        var my_custom_curr_symbol  =   decodeURI ( wpestate_getCookie('my_custom_curr_symbol') );
        var my_custom_curr_coef    =   parseFloat( wpestate_getCookie('my_custom_curr_coef'));
        var my_custom_curr_pos     =   parseFloat( wpestate_getCookie('my_custom_curr_pos'));
        var my_custom_curr_cur_post=   wpestate_getCookie('my_custom_curr_cur_post');
        wpestate_enable_slider(slider_id, price_min, price_max, ammount, my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef);

    });
    
}

/*
*
* 
*
*/
function wpestate_formatNumber_short(num) {
    num=parseFloat(num);
 
    if (num >= 1000000000) {
        return (num / 1000000000).toFixed(1).replace(/\.0$/, '') + 'B';
    }
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    }
    return num.toString();
}

/*
*
* 
*
*/


function wpestate_done_typing(){
    if (typeof (wpestate_show_pins) !== "undefined") {
        first_time_wpestate_show_inpage_ajax_half=1;

        wpestate_show_pins();
    }
}


/*
*
* 
*
*/
function isFunction(possibleFunction) {
     return typeof(possibleFunction) === typeof(Function);
}



/*
*
* calculate morgage widget action
*/

function wpestate_zillow_widget_action(){
    
    jQuery('#zill_submit_estimate').on( 'click', function(event) {
        var button = jQuery(this);
        var container = button.parent();
        var zillow_adress = jQuery('#zill_estimate_adr1').val();
        var zillow_city = jQuery('#zill_estimate_city1').val();
        var zillow_state = jQuery('#zill_estimate_state1').val();

        var full_address = zillow_adress+', '+zillow_city+', '+zillow_state;

        if(zillow_adress==''|| zillow_city=='' || zillow_state==''){
            var answer=control_vars.zillow_fields;
            container.find('.wpestate_zillow_answer').empty().append(answer);
            return;
        }



        container.find('.wpestate_zillow_answer').empty().append(control_vars.zillow_wait);

        ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var nonce = jQuery('#wpestate_zillow_nonce').val();
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_zillow_estimation',
                'zillow_adress'      :   zillow_adress,
                'zillow_city'       :   zillow_city,
                'zillow_state'    :   zillow_state,
                'full_address'      :   full_address,
                'security'  :   nonce
            },
            success: function (data) {
              
                
                
                
                if(data.total===0){
                    var answer=control_vars.zillow_none+" "+full_address;
                }else{

                    var zillow_price = data.bundle[0].zestimate;
                  
                    const formattedPrice = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        useGrouping: true
                      }).format(zillow_price);
    
    
                    var answer =control_vars.wpestate_zillow_answer+" <span class='wpestate_zillow_address'>"+full_address+"</span> "+control_vars.zillow_is+" <span class='wpestate_zillow_price'>"+formattedPrice+"</span>";
                    
                }
                
            
                container.find('.wpestate_zillow_answer').empty().append(answer);
            
            },
            error: function (errorThrown) {}
        });//end ajax





       
    });
}

/*
*
* calculate morgage widget action
*/

function wpestate_morgate_widget_action(){
    jQuery('#morg_compute').on( 'click', function(event) {

        var intPayPer  = 0;
        var intMthPay  = 0;
        var intMthInt  = 0;
        var intPerFin  = 0;
        var intAmtFin  = 0;
        var intIntRate = 0;
        var intAnnCost = 0;
        var intVal     = 0;
        var salePrice  = 0;

        salePrice = jQuery('#sale_price').val();
        intPerFin = jQuery('#percent_down').val() / 100;

        intAmtFin = salePrice - salePrice * intPerFin;
        intPayPer =  parseInt (jQuery('#term_years').val(),10) * 12;
        intIntRate = parseFloat (jQuery('#interest_rate').val(),10);
        intMthInt = intIntRate / (12 * 100);
        intVal = wpestate_raisePower(1 + intMthInt, -intPayPer);
        intMthPay = intAmtFin * (intMthInt / (1 - intVal));
        intAnnCost = intMthPay * 12;

        jQuery('#am_fin').html("<strong>"+control_vars.morg1+"</strong> " + (Math.round(intAmtFin * 100)) / 100 + " ");
        jQuery('#morgage_pay').html("<strong>"+control_vars.morg2+"</strong>" + (Math.round(intMthPay * 100)) / 100 + " ");
        jQuery('#anual_pay').html("<strong>"+control_vars.morg3+"</strong>" + (Math.round(intAnnCost * 100)) / 100 + " ");
        jQuery('#morg_results').show();
        jQuery('.mortgage_calculator_div').css('height',532+'px');
    });

}

/*
*
* sanitzie string to be used as classname
*
*/
function wpestateSanitizeClassName(str) {
    // Remove leading numbers by replacing them with a prefix (e.g., 'class-')
    str = str.replace(/^\d+/, 'class-');

    // Replace invalid characters with a hyphen
    str = str.replace(/[^a-zA-Z0-9-_]/g, '-');

    // Remove multiple hyphens
    str = str.replace(/-+/g, '-');

    // Remove leading and trailing hyphens
    str = str.trim().replace(/(^-|-$)/g, '');

    return str;
}


/*
*
* 
*
*/

function wpresidenceInitializeAutocomplete(availableTags,inputID) {


    jQuery("#"+inputID).autocomplete({
        source: function(request, response) {

            var results = jQuery.ui.autocomplete.filter(availableTags, request.term);
            response(results.slice(0, 12)); // Limiting the results to 10
        },
        select: function(event,ui) {
          
            // Add a reset button next to the input field
            var $input = jQuery(this);

            var $resetBtn = jQuery('<button type="button" class="wpresidece-reset-btn"><svg width="14px" height="14px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect width="24" height="24" ></rect> <path d="M7 17L16.8995 7.10051" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M7 7.00001L16.8995 16.8995" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></button>');
            var text = ui.item.label;
            var $testSpan = jQuery('<span>').appendTo(document.body);

            // Copy text styles to match the input fields text
            $testSpan.css({
                'font-size': $input.css('font-size'),
                'font-family': $input.css('font-family'),
                'visibility': 'hidden',
                'white-space': 'pre'  // preserve spaces and tabs
            }).text(text);

            // Calculate the width and adjust the button position
            var textWidth = $testSpan.width();
            $resetBtn.css('left', textWidth + 26); // 3px after the text

            $testSpan.remove(); // Remove the test span from the document



            // Remove any existing reset button first
            $input.next('.wpresidence-reset-btn').remove();
            $input.after($resetBtn);

            // Event handler for the reset button
            $resetBtn.on('click', function() {
                $input.val("");
                jQuery(this).remove(); // Remove the reset button after use
                setTimeout(function(){
                    first_time_wpestate_show_inpage_ajax_half=1;
                    wpestate_show_pins();
                }, 1000);

            });

            setTimeout(function(){
                first_time_wpestate_show_inpage_ajax_half=1;
                wpestate_show_pins();
            }, 1000);
         
        }, change: function() {
         
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        var item_class= "wpresidence-geolocatiomarker-"+ item.labelcategory;
        var $li = jQuery("<li>").append("<div class='"+item_class+"'>" + item.label + "</div>");

        // Check if the category label needs to be added
        var lastCategory = jQuery(ul).find(".wpresidece-dropdown-category-label:last").data("category");
        if (lastCategory !== item.category) {
            var $categoryDiv = jQuery("<div>").addClass("wpresidece-dropdown-category-label").data("category", item.category).text(item.category);
            jQuery(ul).append($categoryDiv);
        }

        return $li.appendTo(ul);
    };
}




/*
*
* save search actions
*
*/
function wpestate_save_search_actions(){

    jQuery('#save_search_button').on( 'click', function(event) {
        var nonce, search, search_name, parent, ajaxurl,meta;
        search_name     =   jQuery('#search_name').val();
        search          =   jQuery('#search_args').val();
        meta            =   jQuery('#meta_args').val();
        nonce           =   jQuery('#wpestate_save_search_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        jQuery('#save_search_notice').html(control_vars.save_search);

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'        :   'wpestate_save_search_function',
                'search_name'   :   search_name,
                'search'        :   search,
                'meta'          :   meta,
                'security'         :   nonce
            },
            success: function (data) {

                jQuery('#save_search_notice').html(data);
                jQuery('#search_name').val('');
            },
            error: function (errorThrown) {
            }
        });

    });
}

/*
*
* delete save search actions
*
*/
function wpestate_delete_save_search_actions(){
    jQuery('.delete_search').on( 'click', function(event) {
        var  search_id, parent, ajaxurl,confirmtext;
        confirmtext = control_vars.deleteconfirm;

        if (confirm(confirmtext)) {
            event.preventDefault();
            ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
            search_id       =   jQuery(this).attr('data-searchid');
            parent          =   jQuery(this).parent();
            jQuery(this).html(control_vars.deleting);
            var nonce = jQuery('#wpestate_searches_actions').val();
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'        :   'wpestate_delete_search',
                    'search_id'     :   search_id,
                    'security'      :   nonce,
                },
                success: function (data) {

                    if (data==='deleted'){
                        parent.remove();
                    }

                },
                error: function (errorThrown) {
                }
            });


        }

    });
}



/*
*
* 
*
*/
function wpestate_overview_map(){
    jQuery('#overview_map').click(function(){
        jQuery('#wpestate_overview_map_modal').appendTo("body");
        jQuery('body> #wpestate_overview_map_modal').first().modal("show");
        
    });
}



