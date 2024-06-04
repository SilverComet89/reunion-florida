<?php
add_action( 'pmxi_saved_post', 'update_gallery_ids', 10, 3 );

function update_gallery_ids( $id ) {

    // Declare our variable for the image IDs.
    $image_ids = array();

    // Retrieve all attached images.
    $media = get_attached_media( 'image', $id );

    // Ensure there are images to process.
    if( !empty( $media ) ) {
        $i = 1;
        // Process each image.
        foreach( $media as $item ) {
            if($i > 60) {
                continue;
            }
            // Add each image ID to our array.
            add_post_meta( $id, 'fave_property_images', $item->ID );
            $i++;
        }

        // Convert our array of IDs to a comma separated list.
        //$image_ids_str = implode( ',',$image_ids );

        // Save the IDs to the _image_field custom field.
        //update_post_meta( $id, 'fave_property_images', $image_ids );
        
    }
}
?>