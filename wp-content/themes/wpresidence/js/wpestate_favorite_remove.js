/*
*
* Add remove favorites button for card in front end favorite list
*
*/

function wpestate_enable_front_end_remove_favorites(){

    jQuery('.wpestate_latest_listings_sh .listing_wrapper').each(function(event){

        var property_card=jQuery(this);
        var property_id = jQuery(this).attr('data-listid');

        var to_append='<div class="remove_fav_dash  wpresidence_button " data-postid="'+property_id+'">Remove From Favorites</div>';

        property_card.prepend(to_append);
        
    });

}
