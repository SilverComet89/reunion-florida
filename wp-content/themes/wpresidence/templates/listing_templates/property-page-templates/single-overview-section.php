<?php
$wp_estate_property_overview_order = wpresidence_get_option('wp_estate_property_overview_order', '');

if($is_tab!='yes'){ 
    ?>
    <div class="single-overview-section panel-group property-panel" id="single-overview-section">
        <h4 class="panel-title" id=""><?php print   esc_html($label);  ?></h4>
    <?php 
    } 

print '<div class="property-page-overview-details-wrapper">';
if( is_array($wp_estate_property_overview_order['enabled']) ):
    foreach ($wp_estate_property_overview_order['enabled'] as $key=>$value):
        switch ($key) {


            case 'updated_on':
                ?>
                <ul class="overview_element">
                    <li class="first_overview first_overview_left">
                        <?php esc_html_e('Updated On:','wpresidence'); ?>
                    </li>
                    <li class="first_overview_date"><?php print get_the_modified_date(); ?></li>
                </ul>
                <?php
                break;


            case 'bedrooms':
                $property_bedrooms      =   get_post_meta($post->ID,'property_bedrooms',true);
                if($property_bedrooms!='' && $property_bedrooms!=0) { 
                    print wpestate_display_overview_item('bedrooms',$property_bedrooms);
                 } 
                break;


            case 'bathrooms':
                $property_bathrooms     =   get_post_meta($post->ID,'property_bathrooms',true);
                if($property_bathrooms!='' && $property_bathrooms!=0) { 
                    print wpestate_display_overview_item('bathrooms',$property_bathrooms);   
                }
                break;


                
            case 'rooms':
                $property_rooms         =   get_post_meta($post->ID,'property_rooms',true);
                if($property_rooms!='' && $property_rooms!=0) {
                    print wpestate_display_overview_item('rooms',$property_rooms);   
                } 
                break;



            case 'garages':
                $property_garage        =   get_post_meta($post->ID,'property-garage',true);
                if($property_garage!='' && $property_garage!=0) { 
                    print wpestate_display_overview_item('garages',$property_garage);   
                }
                break;


            case 'size':
                $property_size          =   wpestate_get_converted_measure( $post->ID, 'property_size' );
                if($property_size!='' &&   strval($property_size)!='0' ) { 
                    print wpestate_display_overview_item('size',$property_size);   
                }
                break;
            case 'lot_size':
                $property_lot_size         =    wpestate_get_converted_measure( $post->ID, 'property_lot_size' ) ;  
                if($property_lot_size!='' &&  strval($property_lot_size)!='0' ) {                
                    print wpestate_display_overview_item('lot_size',$property_lot_size);   
                } 
                break;

            case 'year_built':
                $property_year          =   get_post_meta($post->ID,'property-year',true);
                if($property_year!='' ) { 
                    print wpestate_display_overview_item('year_built',$property_year);   
                } 
                break;

                
            case 'property_category':
                $property_card_type_string = get_the_term_list($post->ID, 'property_category', '', ', ', '');;
                print wpestate_display_overview_item('property_category',$property_card_type_string);   
                break;

            case 'property_id':
                print wpestate_display_overview_item('property_id',$post->ID);   
                break;

            case 'map':
                $property_latitude         =    get_post_meta( $post->ID, 'property_latitude',true ) ;  
                $property_longitude        =    get_post_meta( $post->ID, 'property_longitude' ,true) ;  
                $marker_image              =    get_theme_file_uri('/css/css-images/idxpin.png');
                $what_map                  =    intval( wpresidence_get_option('wp_estate_kind_of_map') );
                $overview_map_width        =    intval( wpresidence_get_option('wpestate_overview_map_width') );
                $overview_map_height       =    intval( wpresidence_get_option('wpestate_overview_map_height') );

                if($property_latitude!=='' and $property_longitude!=''){
                    if($what_map==1){
                        $api_key                   =    wpresidence_get_option(  'wp_estate_api_key' ) ;  
                        $map_url = "https://maps.googleapis.com/maps/api/staticmap?center={$property_latitude},{$property_longitude}&zoom=11&size={$overview_map_width}x{$overview_map_height}&scale=1&format=jpg&style=feature:administrative.land_parcel|visibility:off&style=feature:landscape.man_made|visibility:off&style=feature:transit.station|hue:0xffa200&markers=icon:{$marker_image}%7C{$property_latitude},{$property_longitude}&key={$api_key}";
                        echo '<img id="overview_map" class="overview_map" src="' . $map_url . '" alt="map-entry" style="width:'.intval($overview_map_width).'px;height:'.intval($overview_map_height).'px;" height="100%" width="100%">';
                    }else{
                        $encoded_marker_image_url = urlencode($marker_image);
                        $mapbox_access_token =  wpresidence_get_option(  'wp_estate_mapbox_api_key' ) ;  
                        $map_url = "https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/url-{$encoded_marker_image_url}({$property_longitude},{$property_latitude})/{$property_longitude},{$property_latitude},11/{$overview_map_width}x{$overview_map_height}?access_token={$mapbox_access_token}";
                        echo '<img id="overview_map"  class="overview_map" src="' . $map_url . '" alt="map-entry" height="100%" width="100%">';                
                    }
                }
                print wpestate_overview_map_modal($post->ID);
                


                break;
        }
        
    endforeach;
endif;
print '</div>';

if($is_tab!='yes'){ ?>
    </div>
<?php 
} 
?>