var WpEstateGoogleMapsModule = (function () {
    var map, marker;
    var markersArray = [];
    let bounds;
    let infoBox;

    /**
     * Initializes the Google Map with a marker at a specific location.
     */
    function initMap() {
        var location = getMapLocation();
        var zoom = getZoomLevel();
        var mapType = getMapType();
        var mapStyles = getMapStyles();

        map = new google.maps.Map(document.getElementById('googleMap'), {
            zoom: zoom,
            center: location,
            styles: mapStyles,
            mapTypeId: mapType,
            flat: false,
            noClear: false,
            scrollwheel: false,
            draggable: true,

            streetViewControl: false,
            disableDefaultUI: true,
            gestureHandling: 'cooperative'
        });

        bounds = new google.maps.LatLngBounds();


        /* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!111
         if(mapfunctions_vars.show_g_search_status==='yes'){
             wpestate_set_google_search(map);
         }
 
         */




        // Call the function to add markers from data
        addMarkersFromData();

        console.log('after add');
        console.log(markersArray);




        // Add an event listener for the 'tilesloaded' event
        map.addListener('tilesloaded', function () {
            var gmapLoading = document.getElementById('gmap-loading');

            if (gmapLoading) {
                gmapLoading.parentNode.removeChild(gmapLoading);
            }
        });
    }
    // end INIT MAP








    /**
      * Reads marker data from the 'wpestate_google_map_code_vars2.markers2' variable
      * and adds markers to the map.
      */
    function addMarkersFromData() {
        if (
            typeof wpestate_google_map_code_vars2 !== 'undefined' &&
            wpestate_google_map_code_vars2.markers2
        ) {
            try {
                var markersData = JSON.parse(wpestate_google_map_code_vars2.markers2);
                console.log(markersData);




                if (Array.isArray(markersData)) {
                    markersData.forEach(function (markerData) {
                        const marker = createSingleMarker(markerData);
                        markersArray.push(marker);
                        bounds.extend(marker.getPosition());
                    });

                    map.fitBounds(bounds);
                }
            } catch (error) {
                console.error('Error parsing marker data:', error);
            }
        }
    }




    /**
     * 
     * Create singe marker
     * 
     * 
    */

    function createSingleMarker(markerData) {
        let createdMarker;
        if (wpestate_google_map_code_vars.useprice === 'yes') {
            createdMarker = createSingleMarker_price(markerData);
        } else {
            createdMarker = createSingleMarker_classic(markerData);
        }
        addMarkerClickEvent(createdMarker);
        return createdMarker;
    }








    /*
    * 
    Create a marker using the 'price' approach
    *
    */
    function createSingleMarker_price(markerData) {
        // ... your marker creation code for the 'price' version
    }




    /*
    *
    * Create a marker using the 'classic' approach
    *
    */
    function createSingleMarker_classic(markerData) {

        var myLatLng = new google.maps.LatLng(markerData.lat, markerData.lng);
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: markerData.title,
            icon: markerData.icon
        });


        // Add additional properties to the marker if needed
        marker.id = markerData.id;
        marker.image = markerData.image;
        marker.price = markerData.price;
        marker.category = markerData.single_first_type;
        marker.action = markerData.single_first_action;
        marker.link = markerData.link;
        marker.rooms = markerData.rooms;
        marker.baths = markerData.baths;
        marker.cleanprice = markerData.cleanprice;
        marker.size = markerData.size;
        marker.category_name = markerData.single_first_type_name;
        marker.action_name = markerData.single_first_action_name;
        return marker;
    }





    /*
    * Add a click event to the marker
    *
    */

    function addMarkerClickEvent(marker) {


        const contentString =
        '<div id="content">' +
        '<div id="siteNotice">' +
        "</div>" +
        '<h1 id="firstHeading" class="firstHeading">Uluru</h1>' +
        '<div id="bodyContent">' +
        "<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large " +
        "sandstone rock formation in the southern part of the " +
        "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
        "south west of the nearest large town, Alice Springs; 450&#160;km " +
        "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
        "features of the Uluru - Kata Tjuta National Park. Uluru is " +
        "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
        "Aboriginal people of the area. It has many springs, waterholes, " +
        "rock caves and ancient paintings. Uluru is listed as a World " +
        "Heritage Site.</p>" +
        '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
        "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
        "(last visited June 22, 2009).</p>" +
        "</div>" +
        "</div>";



        const infowindow = new google.maps.InfoWindow({
            content: wpestateMarkerGetInfoboxContent(marker),
            ariaLabel: "Uluru",
          });

        marker.addListener("click", () => {
            infowindow.open({
              anchor: marker,
              map,
            });
          });
    }
    
    
    
    /**
     *return infobox content
     */
     function wpestateMarkerGetInfoboxContent(marker) {
        var infobox_class   =   " price_infobox ";
        const info_image = marker.image ? marker.image : `<img src="${wpestate_google_map_code_vars.path}/idxdefault.jpg" />`;
        const category = decodeURIComponent(marker.category.replace(/-/g, ' '));
        const action = decodeURIComponent(marker.action.replace(/-/g, ' '));
        const category_name = decodeURIComponent(marker.category_name.replace(/-/g, ' '));
        const action_name = decodeURIComponent(marker.action_name.replace(/-/g, ' '));
        const in_type = (category === '' || action === '') ? ' ' : wpestate_google_map_code_vars.in_text;
        const infobaths = (marker.baths && marker.baths !== 0) ? `<span id="infobath">${marker.baths} ${wpestate_google_map_code_vars.ba}</span>` : '';
        const inforooms = (marker.rooms && marker.rooms !== 0) ? `<span id="inforoom">${marker.rooms} ${wpestate_google_map_code_vars.bd}</span>` : '';
        const infosize = marker.size ? `<span id="infosize">${marker.size}</span>` : '';
        const title = marker.title.length > 30 ? marker.title.substr(0, 30) + '...' : marker.title;
      
        const infobox = `
          <div  id="content">
          
            <div class="infobox_wrapper_image">
              <a href="${marker.link}">${info_image}</a>
            </div>
            <div class="infobox_title">
              <a href="${marker.link}" id="infobox_title">${title}</a>
            </div>
            <div class="prop_pricex">${wpestate_get_price_currency(marker.price, marker.cleanprice)}</div>
            <div class="infobox_details">${inforooms} ${infobaths} ${infosize}</div>
          </div>
        `;
      
        return infobox;
      }
      
    
    
    
    
    
    
       
    /**
     * get price currency
     */
    function wpestate_get_price_currency(price,clean_price){
        "use strict";
        var new_price ='';
    
        var my_custom_curr_symbol  =   decodeURIComponent ( wpestate_getCookie_map('my_custom_curr_symbol') );
        var my_custom_curr_coef    =   parseFloat( wpestate_getCookie_map('my_custom_curr_coef'));
        var my_custom_curr_pos     =   parseFloat( wpestate_getCookie_map('my_custom_curr_pos'));
        var my_custom_curr_cur_post=   wpestate_getCookie_map('my_custom_curr_cur_post');
        var slider_counter = 0;
    
    
        if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
            var temp_price =Number(clean_price*my_custom_curr_coef).toFixed(2);
            if (my_custom_curr_cur_post === 'before') {
                new_price = my_custom_curr_symbol+' '+temp_price;
            } else {
                new_price = temp_price+' '+my_custom_curr_symbol;
            }
    
        } else {
            new_price=price;
        }
    
        return new_price;
    }
    
    function wpestate_getCookie_map(cname) {
        "use strict";
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
       }
    
    
    /**
     * Returns the map styles for the Google Map.
     * Reads the styles value from the 'wpestate-google-map-code-vars.map_style' variable.
     * If the value is not available or invalid, an empty array (default styles) is used.
     * @return {Array} The map styles.
     */
    function getMapStyles() {
        if (
            typeof wpestate_google_map_code_vars !== 'undefined' &&
            wpestate_google_map_code_vars.map_style
        ) {
            console.log('return mal style');
            return JSON.parse(wpestate_google_map_code_vars.map_style);
        }

        return [];
    }




    /**
      * Returns the map type for the Google Map.
      * Reads the type value from the 'wpestate-google-map-code-vars.type' variable.
      * If the value is not available or invalid, a default map type of 'roadmap' is used.
      * @return {string} The map type.
      */
    function getMapType() {
        var defaultMapType = 'roadmap';

        if (typeof wpestate_google_map_code_vars !== 'undefined' && wpestate_google_map_code_vars.type) {
            var mapType = wpestate_google_map_code_vars.type.toLowerCase();

            if (['roadmap', 'satellite', 'hybrid', 'terrain'].includes(mapType)) {
                return mapType;
            }
        }

        return defaultMapType;
    }



    /**
     * Returns the location for the Google Map.
     * Reads the latitude and longitude values from the 'wpestate-google-map-code-vars' variables.
     * If the values are not available or invalid, default coordinates for New York City are used.
     * @return {object} The location object with 'lat' and 'lng' properties.
     */
    function getMapLocation() {
        var defaultLocation = { lat: 40.7128, lng: -74.0060 }; // New York City coordinates

        if (
            typeof wpestate_google_map_code_vars !== 'undefined' &&
            wpestate_google_map_code_vars.general_latitude &&
            wpestate_google_map_code_vars.general_longitude
        ) {
            var latitude = parseFloat(wpestate_google_map_code_vars.general_latitude);
            var longitude = parseFloat(wpestate_google_map_code_vars.general_longitude);

            if (!isNaN(latitude) && !isNaN(longitude)) {
                return { lat: latitude, lng: longitude };
            }
        }

        return defaultLocation;
    }





    /**
     * Returns the zoom level for the Google Map.
     * Reads the zoom value from the 'wpestate-google-map-code-vars.page_custom_zoom' variable.
     * If the value is not available or invalid, a default zoom level of 12 is used.
     * @return {number} The zoom level.
     */
    function getZoomLevel() {
        var defaultZoom = 12;
        if (typeof wpestate_google_map_code_vars !== 'undefined' && wpestate_google_map_code_vars.page_custom_zoom) {
            var customZoom = parseInt(wpestate_google_map_code_vars.page_custom_zoom, 10);
            return isNaN(customZoom) ? defaultZoom : customZoom;
        }
        return defaultZoom;
    }



    /**
     * Initializes the Google Map if an element with the ID 'googleMap' or 'googleMapSlider' is present on the page.
     */
    return {
        init: function () {
            var mapElement = document.getElementById('googleMap');
            var mapSliderElement = document.getElementById('googleMapSlider');

            if (mapElement || mapSliderElement) {
                initMap();
            }
        }
    };
})();

window.WpEstateGoogleMapsModule = WpEstateGoogleMapsModule;
