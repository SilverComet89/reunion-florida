jQuery(document).ready(function ($) {
    "use strict";
    //wpestate_enable_slider_radius('wpestate_slider_radius',geolocation_search_code_vars.min_geo_radius, geolocation_search_code_vars.max_geo_radius, geolocation_search_code_vars.initial_radius);
    wpestate_enable_slider_radius('.wpestate_slider_radius_global',geolocation_search_code_vars.min_geo_radius, geolocation_search_code_vars.max_geo_radius, geolocation_search_code_vars.initial_radius);
    wpestate_enable_slider_radius('.wpestate_slider_radius_search',geolocation_search_code_vars.min_geo_radius, geolocation_search_code_vars.max_geo_radius, geolocation_search_code_vars.initial_radius);
    console.log('on search code')
});








function wpestate_enable_slider_radius(slider_name,low_val, max_val, now_val){

    console.log('wpestate_enable_slider_radius');
    var parent =jQuery(slider_name).parent().parent();
    var geolocation_radius  =   parent.find('.geolocation_radius');
    var radius_value        =   parent.find('.radius_value');

    var geolocation_search_item =   parent.find('.geolocation_search_item');

    var geolocation_search_item =   jQuery('.geolocation_search_item');

    
    var geolocation_lat         =   parent.find('.geolocation_lat');
    var geolocation_long        =   parent.find('.geolocation_long');
    
    
    if( jQuery(slider_name).length > 0){
        jQuery(slider_name).slider({
            range: true,
            min: parseFloat(low_val),
            max: parseFloat(max_val),
            value: parseFloat(now_val),
            range: "max",
            slide: function (event, ui) {

                geolocation_radius.val( ui.value);
                if(geolocation_search_code_vars.geo_radius_measure==='miles'){
                    radius_value.text(ui.value+" "+geolocation_search_code_vars.miles);
                }else{
                    radius_value.text(ui.value+" "+geolocation_search_code_vars.km);
                }

            },
            stop: function (event, ui) {
                if(placeCircle!=''){
                    if(geolocation_search_code_vars.geo_radius_measure==='miles'){
                        placeCircle.setRadius(ui.value*1609.34);
                    }else{
                        placeCircle.setRadius(ui.value*1000);
                    }

                    wpestate_show_pins();

                }
            }
        });
    }
    geolocation_search_item.on('change', function(){

        if( jQuery(this).val()==='' ){
            geolocation_lat.val('');
            geolocation_long.val('');
            if(placeCircle!=''){
                placeCircle.setMap(null);
                placeCircle='';
            }
        }
    });


    if( geolocation_search_item.length > 0){
        var input, defaultBounds, autocomplete_normal;
        //input = (document.getElementById('geolocation_search'));
        input = geolocation_search_item;


        if( parseInt( mapfunctions_vars.geolocation_type ) == 1 ){
            defaultBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(-90, -180),
                new google.maps.LatLng(90, 180)
            );
            var options = {
                bounds: defaultBounds,
                types: ['geocode'],
               // types: ['(regions)'],
            };


            autocomplete_normal = new google.maps.places.Autocomplete(input, options);
            google.maps.event.addListener(autocomplete_normal, 'place_changed', function () {
                initialGeop=0;
                var place = autocomplete_normal.getPlace();
                var place_lat = place.geometry.location.lat();
                var place_lng = place.geometry.location.lng();

                geolocation_lat.val(place_lat);
                geolocation_long.val(place_lng);


                //wpestate_geolocation_marker(place_lat,place_lng);
                if (typeof (wpestate_show_pins) !== "undefined") {
                    first_time_wpestate_show_inpage_ajax_half=1;

                    wpestate_show_pins();
                }

            });

        } else if( parseInt( mapfunctions_vars.geolocation_type ) == 2 ){


                geolocation_search_item.autocomplete( {


                        source: function ( request, response ) {
                                jQuery.get( 'https://nominatim.openstreetmap.org/search', {
                                        format: 'json',
                                        country:'fr',
                                        q: request.term,//was q
                                        //addressdetails:'1',
                                }, function( result ) {

                                        if ( !result.length ) {
                                            response( [ {
                                                value: '',
                                                label: control_vars.geo_no_results
                                            } ] );
                                            return;
                                        }
                                        response( result.map( function ( place ) {
                                                return {
                                                        label: place.display_name,
                                                        latitude: place.lat,
                                                        longitude: place.lon,
                                                        value: place.display_name,

                                                };
                                        } ) );
                                }, 'json' );
                        },
                        select: function ( event, ui ) {
                            initialGeop=0;
                            geolocation_lat.val(ui.item.latitude);
                            geolocation_long.val(ui.item.longitude);

                            if (typeof (wpestate_show_pins) !== "undefined") {
                                first_time_wpestate_show_inpage_ajax_half=1;

                                wpestate_show_pins();
                            }

                        }
                });
                geolocation_search_item.attr('autocomplete','on');
        }

    }


}