<?php 
$agent_id       =   intval  ( get_post_meta($post->ID, 'property_agent', true) );
if (function_exists('icl_translate')) {
    $agent_id       = apply_filters( 'wpml_object_id', $agent_id, 'estate_agent' );
}

$thumb_id       =   get_post_thumbnail_id($agent_id);
$agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');
$agent_face_image = '';

if($agent_face ){
    $agent_face_image=$agent_face[0];
}


if ($agent_id == 0 || ( $agent_face && empty($agent_face[0]) )) {
    $author_picture_meta = get_the_author_meta('custom_picture', $post->post_author);
    $agent_face=array();
    if (empty($author_picture_meta)) {
        $agent_face[0] = $agent_face_image = get_theme_file_uri('/img/default-user_1.png');
    } else {
        $agent_face[0] = $agent_face_image = $author_picture_meta;
    }
   
    
}
if (empty($agent_face_image)) {
    $agent_face_image = get_theme_file_uri('/img/default-user_1.png');
}
$property_card_agent_section_tab_show_agent_image = wpresidence_get_option('property_card_agent_section_tab_show_agent_image', '');
$property_card_agent_section_tab_show_agent_name = wpresidence_get_option('property_card_agent_section_tab_show_agent_name', '');

?>
<div class="property_agent_wrapper">
    <?php
    if($property_card_agent_section_tab_show_agent_image=='yes'){
    ?>
        <div class="property_agent_image" style="background-image:url('<?php print esc_attr($agent_face_image); ?>')"></div> 
        <div class="property_agent_image_sign"><i class="far fa-user-circle"></i></div>
    <?php
    }
    ?>


    <?php 
    if($property_card_agent_section_tab_show_agent_name=='yes'){
        if($agent_id!=0){
            echo '<a class="wpestate_card_agent_link" href="'.esc_url( get_permalink($agent_id) ) .'">'.get_the_title($agent_id).'</a>';
        }else{
            echo get_the_author_meta( 'first_name',$post->post_author).' '.get_the_author_meta( 'last_name',$post->post_author);
        }
    }
    ?>
</div>
                