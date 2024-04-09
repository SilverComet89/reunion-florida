<?php

function wpestate_crm_show_details($source_array,$edit_id=''){
    $return='';
    foreach($source_array as $key=>$item ){
        $return.='<div class="half-content ';
            if(isset( $item['length'] ) && $item['length']=='full'){
              $return.=' col-md-12 ';
            }else{
                $return.=' col-md-6 ';
            }
            $return.=' "> ';

            if($item['type']=='input'){
                $return.= wpestate_crm_return_input_metabox($key,$item,$edit_id);
            }else if($item['type']=='textarea'){
                $return.= wpestate_crm_return_textarea_metabox($key,$item,$edit_id);
            }else if($item['type']=='select'){

            }else if($item['type']=='post_type'){
                 $return.= wpestate_crm_return_post_type_items($key,$item,$edit_id);
            }else if($item['type']=='taxonomy'){
                  $return.= wpestate_crm_return_taxonomy_metabox($key,$item,$edit_id);
            }else if($item['type']=='content'){
                if(trim($edit_id)!=''){
                  $return.= '<label style="margin-top:10px;" for="content">'.esc_html($item['label']).'</label>';
                  $return.= get_post_field('post_content', $edit_id);
                }
            }
        $return.='</div>';
    }

    return $return;
}




function wpestate_crm_return_post_type_items($key,$item,$edit_id=''){

    global $post;
    $args = array(
            'post_type'        =>  $item['source'],
            'posts_per_page'    => -1,
            'post_status'      =>  array( 'any' )
    );

    if($key=='crm_handler'):
         $current_user =   wp_get_current_user();
         if(!current_user_can('administrator')){
             $args[ 'author'] =  $current_user->ID;
         }
     endif;

    $select_value   =   '<option value=""></option>';
    $return         =   '';
    $value  =   get_post_meta($post->ID,$key,true);
    $agent_selection =  get_posts($args);
    $agent_id=intval( get_post_meta($edit_id , 'crm_handler', true) );

    foreach ( $agent_selection as $agent ) :
        $select_value.='<option value="'. $agent->ID.'" ';
        if($agent_id==$agent->ID){
            $select_value.=' selected ';
        }
        $select_value.= ' >'.$agent->post_title.'</option>';
    endforeach;



    $return.=   '<label for="'.$key.'">'.esc_html($item['label']).'</label>';
    $return.=   '<select id="'.esc_attr($key).'" class="form-control" name="'.esc_attr($key).'"> ';
    $return.=   $select_value;
    $return.=   '</select>';
    return $return;
}






function wpestate_crm_return_input_metabox($key,$item,$edit_id=''){
    global $post;
    $return         =   '';
    $value  =   get_post_meta($post->ID,$key,true);
    if( intval($edit_id)!=0 ){
      $value  =   get_post_meta(  $edit_id,$key,true);
    }
    $return.=   '<label for="'.$key.'">'.esc_html($item['label']).'</label>';
    if( isset( $item['editable']) && $item['editable']=='false' ){

      if($key=='crm_lead_permalink'){
        $return.=   '<a href="'.esc_url($value).'" target="_blank" >'.esc_url($value).'</a>';
        if($value==''){
          $return.=esc_html__('added manually','wpestate-crm');
        }
      }else{
        $return.=   esc_html($value);
      }


    }else{
      $return.=   '<input type="text" id="'.esc_attr($key).'" class="form-control" name="'.esc_attr($key).'" value="'.esc_attr($value).'" >';
    }
    return $return;
}



function wpestate_crm_return_textarea_metabox($key,$item,$edit_id=''){
    global $post;
    $return         =   '';
    $value  =   get_post_meta($post->ID,$key,true);
    if( intval($edit_id)!=0 ){
      $value  =   get_post_meta(  $edit_id,$key,true);
    }
    $return.=   '<label for="'.$key.'">'.esc_html($item['label']).'</label>';
    $return.=   '<textarea id="'.esc_attr($key).'" name="'.esc_attr($key).'"> '.esc_attr($value).'</textarea>';

    return $return;
}


function wpestate_crm_return_taxonomy_metabox($key,$item,$edit_id=''){
    global $post;
    $select_value   =  '<option value=""></option>';
    $return         =   '';

    $terms = get_terms( array(
        'taxonomy' => $item['source'],
        'hide_empty' => false,
    ));



    foreach($terms as $term){
        $select_value.='<option value="'.$term->name.'" ';
        if( intval($edit_id)!=0 ){
            if(has_term($term->name,$item['source'],$edit_id )){
                $select_value.=' selected ';
              }
        }
        $select_value.='>'.$term->name.'</option>';
    }

    $value  =   get_post_meta($post->ID,$key,true);
    $return.=   '<label for="'.$key.'">'.esc_html($item['label']).'</label>';
    $return.=   '<select id="'.esc_attr($key).'" name="'.esc_attr($key).'"> ';
    $return.=   $select_value;
    $return.=   '</select>';

    return $return;
}

function wpestate_crm_display_add_note($post_id){
    $return='';
    $current_user       = wp_get_current_user();
    $return .='<div class="add_comments_wrapper">'
            . '<h2>'.esc_html__('Add a new comment','wpestate-crm').'</h2>';
    $return.='<textarea id="crm_new_commnet"></textarea>';
    $return.='<div  id="crm_insert_comment" class="wpresidence_button" data-who="'.$current_user->user_nicename.'" data-date="'.current_time('mysql').'" data-postid="'.intval($post_id).'">'.esc_html__('Add Comment','wpestate-crm').'</div>';

    $ajax_nonce = wp_create_nonce( "wpestate_crm_insert_note" );
    $return.='<input type="hidden" id="wpestate_crm_insert_note" value="'.esc_html($ajax_nonce).'" />    ';

    $return .='</div>';
    return $return;
}



function wpestate_show_lead_per_contact($contact_id){
    $lead_id= get_post_meta($contact_id,'lead_contact',true);

    $return = '<div class="lead_content"><h2>'.esc_html__('Lead','wpestate-crm').'</h2>'. get_post_field('post_content', $lead_id).'</div>';
    return $return;


}




function wpestate_crm_show_notes($post_id){
    $return='<div id="show_notes_wrapper">';
    $all_comments = get_comments( array(
                            'post_id'   => $post_id,
                            )
                    );

    if(is_array($all_comments)):
        foreach($all_comments as $item){
            $return.= '<div class="comment_item">';
                $return.= '<i data-delete="'.$item->comment_ID.'" class="fa fa-trash-o wpestate-crm_delete" aria-hidden="true"></i>';
                $return.= '<div class="comment_name">'.esc_html__('from','wpestate-crm').' '.$item->comment_author.'</div>';
                $return.= '<div class="comment_date">on '.$item->comment_date.'</div>';
                $return.= '<div class="comment_content">'.$item->comment_content.'</div>';
            $return.= '</div>';
        }
    endif;
    $return.='</div>';

    return $return;

}


add_action( 'wp_ajax_wpestate_crm_add_comment', 'wpestate_crm_add_comment' );
function wpestate_crm_add_comment(){
    check_ajax_referer( 'wpestate_crm_insert_note', 'security' );
    if ( !is_user_logged_in() ) {
        exit('out pls');
    }

    $current_user       = wp_get_current_user();
    $content    = esc_html($_POST['content']);
    $post_id    = intval($_POST['item_id']);

    $comment_arg = array(
            'comment_post_ID'      => $post_id,
            'user_id'              => $current_user->ID,
            'comment_author'       => $current_user->user_nicename,
            'comment_author_email' => $current_user->user_email,
            'comment_content'      => $content,
            'comment_date'         => current_time('mysql'),
            'comment_approved'     => 1,
    );

    wp_insert_comment( $comment_arg );
    die();
}



add_action( 'wp_ajax_wpestate_crm_delete_comment', 'wpestate_crm_delete_comment' );
function wpestate_crm_delete_comment(){
     check_ajax_referer( 'wpestate_crm_insert_note', 'security' );
    if ( !is_user_logged_in() ) {
        exit('out pls');
    }

    $current_user       = wp_get_current_user();
    $item_id            = intval($_POST['item_id']);

    $comment = get_comment($item_id);


    if($comment_author_email->email != $current_user->email){
        print'no rights';
    }else{
      wp_delete_comment($item_id,true);
    }

    die();
}



function wpestate_crm_get_user_picture($contact_id){

    $email  = get_post_meta($contact_id,'crm_email',true);
    $image  =   '';
    if($email!=''){
        $user= get_user_by('email',$email);
        if(isset($user->ID)){
            $image = get_the_author_meta( 'custom_picture' , $user->ID  );
        }else{
            $image = get_avatar_url($email);
        }
    }

    return $image;
}
