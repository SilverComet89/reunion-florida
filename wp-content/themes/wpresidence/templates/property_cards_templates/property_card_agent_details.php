<?php 
$agent_id       =   intval  ( get_post_meta($post->ID, 'property_agent', true) );
$thumb_id       =   get_post_thumbnail_id($agent_id);
$agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');

if (isset($agent_face[0]) && $agent_face[0]==''){
   $agent_face[0]= get_theme_file_uri('/img/default-user_1.png');
}

$property_card_agent_section_tab_show_agent_image = wpresidence_get_option('property_card_agent_section_tab_show_agent_image', '');
$property_card_agent_section_tab_show_agent_name = wpresidence_get_option('property_card_agent_section_tab_show_agent_name', '');


?>

<div class="property_agent_wrapper property_agent_wrapper_type1">
                   
    <?php 
    echo'<span><strong>'. esc_html__('Agent','wpresidence').':'.'</strong></span>';
    if($agent_id!=0){
            echo '<a href="' . esc_url ( get_permalink($agent_id) ) . '">';
                if($property_card_agent_section_tab_show_agent_image=='yes'){
                    echo '<i class="far fa-user-circle unit3agent"></i> ';
                }
                if($property_card_agent_section_tab_show_agent_name=='yes'){
                    echo get_the_title($agent_id); 
                }
            echo '</a>';
        }else{
            echo get_the_author_meta( 'first_name',$post->post_author).' '.get_the_author_meta( 'last_name',$post->post_author);
        }
    ?>
</div>

