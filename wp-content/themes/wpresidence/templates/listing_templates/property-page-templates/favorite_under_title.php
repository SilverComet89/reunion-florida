<?php
$current_user      =   wp_get_current_user();
$userID            =   $current_user->ID;
$user_option       =   'favorites'.intval($userID);
$curent_fav        =   get_option($user_option);

$favorite_class     =   'isnotfavorite';
$fav_mes            =   esc_html__('add to favorites','wpresidence');
$fav_icon           =   'far fa-heart';
if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'isfavorite';
    $fav_mes        =   esc_html__('remove from favorites','wpresidence');
    $fav_icon           ='fas fa-heart';
    }
}

?>

<div id="add_favorites" class="title_share single_property_action <?php echo esc_attr($favorite_class);?>" data-postid="<?php echo intval($post->ID);?>" data-original-title="<?php echo esc_attr($fav_mes);?>" >
    <i class="<?php echo esc_attr($fav_icon); ?>"></i><?php esc_html_e('Favorite','wpresidence'); ?>
</div>
