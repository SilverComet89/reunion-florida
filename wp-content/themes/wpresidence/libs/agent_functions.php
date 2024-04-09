<?php
/**
*  return what's up api call
*
* param   $propid = proeprty id
* @var
*/

if( !function_exists('wpestate_return_agent_whatsapp_call') ):
    function wpestate_return_agent_whatsapp_call($propId,$mobile_number){
        $whatsup_no = preg_replace("/[^0-9]/", "", $mobile_number);

        if( intval($propId)!=0 ){
         
            if( intval($propId)==-1 ){ //agent
                $text_whats       =   esc_html__('Hello I\'m interested in one of your listings.','wpresidence');
            }else if( get_post_type($propId) == 'estate_property' and $mobile_number!=''){
                $text_whats= esc_html__('Hello I\'m interested in ','wpresidence').'['.get_the_title($propId).'] '.get_permalink($propId);
            }else{
                $text_whats=  get_the_title($propId).' '. esc_url( get_permalink($propId) ) ; 
            }
        }else{
            $text_whats=  get_the_title($propId).' '. esc_url( get_permalink($propId) ) ; 
        }
        
        
        $whatsup_mess='https://wa.me/'.esc_html($whatsup_no).'?text='.($text_whats);

        return $whatsup_mess;
    }
endif;



/**
*  return agent/user picture
*
* @since
* @var
*/



if( !function_exists('wpestate_theme_slider_contact') ):
function wpestate_agent_picture($propid){
    $agent_id       =   intval( get_post_meta($propid, 'property_agent', true) );
    $thumb_id       =   get_post_thumbnail_id($agent_id);
    $preview        =   wp_get_attachment_image_src($thumb_id, 'property_listings');
    if(isset($preview[0])){
        return  $preview[0];
    }else{
      return '';
    }


}
endif;


/**
*  return agent/user details
*
* param   $propid = proeprty id
* @var
*/

if( !function_exists('wpestate_return_agent_details') ):
function wpestate_return_agent_details($propid,$singular_agent_id=''){

    if($singular_agent_id==''){
         $agent_id       =   intval( get_post_meta($propid, 'property_agent', true) );
    }else{
        $agent_id=$singular_agent_id;
    }
    $user_id        =   0;
    $counter        =   0;
    $agent_member   =   '';
    $agent_face_img =   '';

    if($agent_id!=0){
        $one_id         =    $agent_id;
        $thumb_id       =    get_post_thumbnail_id($agent_id);
        if($thumb_id==''){
            $preview_img    =   get_theme_file_uri('/img/default_user_agent.gif');
            $agent_face     =   get_theme_file_uri('/img/default-user_1.png');
        }else{
            $preview        =   wp_get_attachment_image_src($thumb_id, 'property_listings');
            $preview_img    =   get_theme_file_uri('/img/default_user_agent.gif');
            if($preview){
                $preview_img    =   $preview[0];
            }
            $agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');
            if($agent_face){
                $agent_face_img =   $agent_face[0];
            }
        }
        $title  =   get_the_title($agent_id);
        $link   =   esc_url( get_permalink($agent_id) );
        $type   =   get_post_type($agent_id);

        $agent_mobile       = '';
        $agent_email        = '';
        $agent_skype        = '';
        $agent_phone        = '';
        $agent_pitch        = '';
        $agent_facebook     = '';
        $agent_twitter      = '';
        $agent_linkedin     = '';
        $agent_pinterest    = '';
        $agent_instagram    = '';
        $agent_urlc         = '';
        $agent_member       = '';
        $agent_address      = '';

        if( $type=='estate_agent' ){
            $agent_mobile       = esc_html( get_post_meta($agent_id, 'agent_mobile', true) );
            $agent_email        = esc_html( get_post_meta($agent_id, 'agent_email', true) );
            $agent_skype        = esc_html( get_post_meta($agent_id, 'agent_skype', true) );
            $agent_phone        = esc_html( get_post_meta($agent_id, 'agent_phone', true) );
            $agent_pitch        = esc_html( get_post_meta($agent_id, 'agent_pitch', true) );
            $agent_facebook     = esc_html( get_post_meta($agent_id, 'agent_facebook', true) );
            $agent_twitter      = esc_html( get_post_meta($agent_id, 'agent_twitter', true) );
            $agent_linkedin     = esc_html( get_post_meta($agent_id, 'agent_linkedin', true) );
            $agent_pinterest    = esc_html( get_post_meta($agent_id, 'agent_pinterest', true) );
            $agent_instagram    = esc_html( get_post_meta($agent_id, 'agent_instagram', true) );
            $agent_urlc         = esc_html( get_post_meta($agent_id, 'agent_website', true) );
            $agent_member       = esc_html(  get_post_meta( $agent_id, 'agent_member' , true) );
            $agent_address      = esc_html(  get_post_meta( $agent_id, 'agent_address' , true) );
           

            $agent_youtube       = esc_html(  get_post_meta( $agent_id, 'agent_youtube' , true) );
            $agent_tiktok        = esc_html(  get_post_meta( $agent_id, 'agent_tiktok' , true) );
            $agent_telegram      = esc_html(  get_post_meta( $agent_id, 'agent_telegram' , true) );
            $agent_vimeo         = esc_html(  get_post_meta( $agent_id, 'agent_vimeo' , true) );
            $agent_private_notes = esc_html(  get_post_meta( $agent_id, 'agent_private_notes' , true) );

        }else if( $type=='estate_agency' ){
  
            $agent_mobile       = esc_html( get_post_meta($agent_id, 'agency_mobile', true) );
            $agent_email        = esc_html( get_post_meta($agent_id, 'agency_email', true) );
            $agent_skype         = esc_html( get_post_meta($agent_id, 'agency_skype', true) );
            $agent_phone         = esc_html( get_post_meta($agent_id, 'agency_phone', true) );
            $agent_pitch         = esc_html( get_post_meta($agent_id, 'agency_pitch', true) );
            $agent_posit         = esc_html( get_post_meta($agent_id, 'agency_position', true) );
            $agent_facebook      = esc_html( get_post_meta($agent_id, 'agency_facebook', true) );
            $agent_twitter       = esc_html( get_post_meta($agent_id, 'agency_twitter', true) );
            $agent_linkedin      = esc_html( get_post_meta($agent_id, 'agency_linkedin', true) );
            $agent_pinterest     = esc_html( get_post_meta($agent_id, 'agency_pinterest', true) );
            $agent_instagram     = esc_html( get_post_meta($agent_id, 'agency_instagram', true) );
            $agent_urlc          = esc_html( get_post_meta($agent_id, 'agency_website', true) );
            $agent_member        = esc_html(  get_post_meta( $agent_id, 'agent_member' , true) );
            $agent_address      = esc_html(  get_post_meta( $agent_id, 'agent_address' , true) );

            $agent_youtube       = esc_html(  get_post_meta( $agent_id, 'agency_youtube' , true) );
            $agent_tiktok        = esc_html(  get_post_meta( $agent_id, 'agency_tiktok' , true) );
            $agent_telegram      = esc_html(  get_post_meta( $agent_id, 'agency_telegram' , true) );
            $agent_vimeo         = esc_html(  get_post_meta( $agent_id, 'agency_vimeo' , true) );
            $agent_private_notes = esc_html(  get_post_meta( $agent_id, 'agency_private_notes' , true) );

        }else if($type=='estate_developer'){
            $agent_mobile       = esc_html( get_post_meta($agent_id, 'developer_mobile', true) );
            $agent_email        = esc_html( get_post_meta($agent_id, 'developer_email', true) );
            $agent_skype         = esc_html( get_post_meta($agent_id, 'developer_skype', true) );
            $agent_phone         = esc_html( get_post_meta($agent_id, 'developer_phone', true) );
            $agent_pitch         = esc_html( get_post_meta($agent_id, 'developer_pitch', true) );
            $agent_posit         = esc_html( get_post_meta($agent_id, 'developer_position', true) );
            $agent_facebook      = esc_html( get_post_meta($agent_id, 'developer_facebook', true) );
            $agent_twitter       = esc_html( get_post_meta($agent_id, 'developer_twitter', true) );
            $agent_linkedin      = esc_html( get_post_meta($agent_id, 'developer_linkedin', true) );
            $agent_pinterest     = esc_html( get_post_meta($agent_id, 'developer_pinterest', true) );
            $agent_instagram     = esc_html( get_post_meta($agent_id, 'developer_instagram', true) );
            $agent_urlc          = esc_html( get_post_meta($agent_id, 'developer_website', true) );
            $agent_member        = esc_html(  get_post_meta( $agent_id, 'agent_member' , true) );
            $agent_address      = esc_html(  get_post_meta( $agent_id, 'agent_address' , true) );

            $agent_youtube       = esc_html(  get_post_meta( $agent_id, 'agent_youtube' , true) );
            $agent_tiktok        = esc_html(  get_post_meta( $agent_id, 'agent_tiktok' , true) );
            $agent_telegram      = esc_html(  get_post_meta( $agent_id, 'agent_telegram' , true) );
            $agent_vimeo         = esc_html(  get_post_meta( $agent_id, 'agent_vimeo' , true) );
            $agent_private_notes = esc_html(  get_post_meta( $agent_id, 'agent_private_notes' , true) );

        }
        $agent_posit        = esc_html( get_post_meta($agent_id, 'agent_position', true) );

        $user_for_id = intval(get_post_meta($agent_id,'user_meda_id',true));
        if($user_for_id!=0){
            $counter            =   count_user_posts($user_for_id,'estate_property',true);
        }


    }else{
        $user_id        =    get_post_field( 'post_author', $propid );
        $one_id         =    $user_id;
        $preview_img    =$agent_face_img=    get_the_author_meta( 'custom_picture',$user_id  );

        if($preview_img==''){
            $preview_img = $agent_face_img=get_theme_file_uri('/img/default-user.png');
        }

        $title               =  get_the_author_meta( 'first_name',$user_id ).' '.get_the_author_meta( 'last_name',$user_id);
        $link                =  '';
        $agent_posit         =  get_the_author_meta( 'title' ,$user_id );
        $agent_mobile        =  get_the_author_meta( 'mobile'  ,$user_id);
        $agent_skype         =  get_the_author_meta( 'skype',$user_id  );
        $agent_phone         =  get_the_author_meta( 'phone',$user_id  );
        $counter             =  count_user_posts($user_id,'estate_property',true);
        $agent_email         =  get_the_author_meta( 'user_email',$user_id  );
        $agent_pitch         =  '';
        $agent_facebook      =  get_the_author_meta( 'facebook',$user_id  );
        $agent_twitter       =  get_the_author_meta( 'twitter',$user_id  );
        $agent_linkedin      =  get_the_author_meta( 'linkedin',$user_id  );
        $agent_pinterest     =  get_the_author_meta( 'pinterest',$user_id  );
        $agent_instagram     =  get_the_author_meta( 'instagram',$user_id  );
        $agent_urlc          =  get_the_author_meta( 'website',$user_id  );

        $agent_youtube       =  get_the_author_meta( 'agent_youtube',$user_id  );
        $agent_tiktok        =  get_the_author_meta( 'agent_tiktok',$user_id  );
        $agent_telegram      =  get_the_author_meta( 'agent_telegram',$user_id  );
        $agent_vimeo         =  get_the_author_meta( 'agent_vimeo',$user_id  );
        $agent_private_notes =  get_the_author_meta( 'agent_private_notes',$user_id  );
        $agent_address       =  get_the_author_meta( 'agent_address',$user_id  );
    }



    $all_details=array();
    $all_details['one_id']              =   $one_id;
    $all_details['agent_id']            =   $agent_id;
    $all_details['user_id']             =   $user_id;
    $all_details['realtor_image']       =   $preview_img;
    $all_details['agent_face_img']      =   $agent_face_img;
    $all_details['realtor_name']        =   $title;
    $all_details['link']                =   $link;
    $all_details['email']               =   $agent_email;
    $all_details['realtor_position']    =   $agent_posit;
    $all_details['realtor_mobile']      =   $agent_mobile;
    $all_details['realtor_skype']       =   $agent_skype;
    $all_details['realtor_phone']       =   $agent_phone;
    $all_details['realtor_pitch']       =   $agent_pitch;
    $all_details['realtor_facebook']    =   $agent_facebook;
    $all_details['realtor_twitter']     =   $agent_twitter;
    $all_details['realtor_linkedin']    =   $agent_linkedin;
    $all_details['realtor_pinterest']   =   $agent_pinterest;
    $all_details['realtor_instagram']   =   $agent_instagram;
    $all_details['realtor_urlc']        =   $agent_urlc;
    $all_details['member_of']           =   $agent_member;
    $all_details['agent_address']       =   $agent_address;

    $all_details['realtor_youtube']       =   $agent_youtube;
    $all_details['realtor_tiktok']        =   $agent_tiktok;
    $all_details['realtor_telegram']      =   $agent_telegram;
    $all_details['realtor_vimeo']         =   $agent_vimeo;
    $all_details['realtor_private_notes'] =   $agent_private_notes;
    
    $all_details['counter']         =   $counter;
    return $all_details;
}
endif;



/**
*  return agent/user details
*
* param   $propid = proeprty id
* @var
*/

if( !function_exists('wpestate_return_agent_share_social_icons') ):
    function wpestate_return_agent_share_social_icons($realtor_details,$class='',$element_class=''){

        $return_string= '<div class="'.esc_attr($class).'">';
                         
            if($realtor_details['realtor_facebook']!=''){
                $return_string.= '<a class="'.esc_attr($element_class).'" href="'. esc_url($realtor_details['realtor_facebook']).'" target="_blank"  rel="noopener" ><i class="fab fa-facebook-f"></i></a>';
            }

            if($realtor_details['realtor_twitter']!=''){
                $return_string.= '<a  class="'.esc_attr($element_class).'" href="'.esc_url($realtor_details['realtor_twitter']).'" target="_blank" rel="noopener" ><i class="fa-brands fa-x-twitter"></i></a>';
            }
            if($realtor_details['realtor_linkedin']!=''){
                $return_string.= '<a class="'.esc_attr($element_class).'" href="'.esc_url($realtor_details['realtor_linkedin']).'" target="_blank" rel="noopener" ><i class="fab fa-linkedin"></i></a>';
            }
            if($realtor_details['realtor_pinterest']!=''){
                $return_string.= '<a class="'.esc_attr($element_class).'" href="'. esc_url($realtor_details['realtor_pinterest']).'" target="_blank" rel="noopener" ><i class="fab fa-pinterest"></i></a>';
            }
            if($realtor_details['realtor_instagram']!=''){
                $return_string.= '<a class="'.esc_attr($element_class).'" href="'. esc_url($realtor_details['realtor_instagram']).'" target="_blank" rel="noopener" ><i class="fab fa-instagram"></i></a>';
            }
            
            if($realtor_details['realtor_youtube']!=''){
                $return_string.= '<a class="'.esc_attr($element_class).'"  href="'. esc_url($realtor_details['realtor_youtube']).'" target="_blank" rel="noopener" ><i class="fa-brands fa-youtube"></i></a>';
            }
             
            if($realtor_details['realtor_telegram']!=''){
                $return_string.= '<a class="'.esc_attr($element_class).'" href="'. esc_url($realtor_details['realtor_telegram']).'" target="_blank" rel="noopener"><i class="fa-brands fa-telegram"></i></a>';
            }
             
            if($realtor_details['realtor_vimeo']!=''){
                $return_string.= '<a class="'.esc_attr($element_class).'" href="'. esc_url($realtor_details['realtor_vimeo']).'" target="_blank" rel="noopener"><i class="fa-brands fa-vimeo-v"></i></a>';
            }
             
            if($realtor_details['realtor_tiktok']!=''){
                $return_string.= ' <a class="'.esc_attr($element_class).'"  href="'. esc_url($realtor_details['realtor_tiktok']).'" target="_blank" rel="noopener"><i class="fa-brands fa-tiktok"></i></a>';
            }
 
        $return_string.= '</div>';
        return $return_string;
    }

endif;




/**
*  return contact details
*
* param   $propid = proeprty id
* @var
*/



if( !function_exists('wpestate_return_agent_contact_details') ):
function wpestate_return_agent_contact_details($realtor_details){
    $return_string='';
    
    if ($realtor_details['realtor_phone']!='') {
        $return_string.= '<div class="agent_detail agent_phone_class">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5.58989 5.35298L4.00124 2L6.84747 6.44072L5.73961 7.97254C6.33837 9.03062 7.29261 9.88975 8.46524 10.4265L9.14108 10.0188L10 11.3603L9.32929 11.7649L9.32758 11.7665C9.10866 11.8994 8.85535 11.9786 8.59246 11.9962C8.32948 12.0139 8.06602 11.9694 7.82787 11.867L7.82188 11.8647C6.2241 11.1662 4.93175 10.0029 4.15181 8.56125L4.14924 8.55506C4.03588 8.34114 3.98568 8.10428 4.00352 7.86758C4.02136 7.63088 4.10663 7.40238 4.25105 7.20431L5.58989 5.35298Z"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.86005 9.91043L6.71604 6.21123L6.92964 5.88483C7.05849 5.68786 7.13665 5.46208 7.15717 5.22761C7.17769 4.99312 7.13992 4.7572 7.04724 4.54084L5.47363 0.86806V0.86646C5.3526 0.582297 5.1425 0.34516 4.87498 0.19077C4.60747 0.0363812 4.29703 -0.026898 3.99042 0.0104649H3.98562C2.88403 0.151205 1.87154 0.688769 1.13785 1.52244C0.404157 2.35612 -0.000388779 3.4287 2.80363e-07 4.53924C0.000424591 7.57897 1.20826 10.494 3.35784 12.6433C5.50743 14.7926 8.42269 16 11.4625 16C12.5726 15.9998 13.6446 15.595 14.4778 14.8614C15.311 14.1278 15.8482 13.1156 15.9889 12.0144L15.9897 12.0096C16.0267 11.7031 15.9633 11.393 15.809 11.1256C15.6546 10.8583 15.4176 10.6483 15.1337 10.5272H15.1321L11.4625 8.95364C11.2442 8.86028 11.0062 8.82284 10.7698 8.8446C10.5335 8.86644 10.3063 8.94676 10.1089 9.07843L8.86086 9.91043H8.86005ZM9.66406 11.2976L11.4625 14.4C8.84677 14.4 6.33823 13.3609 4.48866 11.5114C2.63909 9.66179 1.60001 7.1533 1.60001 4.53764C1.59998 3.83989 1.84612 3.1645 2.29508 2.63036C2.74404 2.09624 3.36705 1.73762 4.05443 1.61766L6.71604 6.21123L8.86005 9.91043L9.66406 11.2976ZM9.66406 11.2976L11.4625 14.4C12.1602 14.4 12.8356 14.1539 13.3698 13.705C13.9039 13.2559 14.2625 12.633 14.3825 11.9456L10.9185 10.4616L9.66406 11.2976Z"/>
        </svg>        
        <a href="tel:'.esc_html($realtor_details['realtor_phone']).'">'.esc_html($realtor_details['realtor_phone']).'</a></div>';
    }
    if ($realtor_details['realtor_mobile']!='') {
        $return_string.= '<div class="agent_detail agent_mobile_class">
        <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.68387 0.00976562H2.25812C1.02049 0.00976562 0.0303955 0.824015 0.0303955 1.84182V14.0556C0.0303955 15.0734 1.02049 15.8877 2.25812 15.8877H9.68387C10.9215 15.8877 11.9116 15.0734 11.9116 14.0556V1.84182C11.9116 0.824015 10.9215 0.00976562 9.68387 0.00976562ZM7.20861 13.6484H4.73337C4.31257 13.6484 3.99079 13.3839 3.99079 13.0377C3.99079 12.6917 4.31257 12.427 4.73337 12.427H7.20861C7.62941 12.427 7.95118 12.6917 7.95118 13.0377C7.95118 13.3839 7.62941 13.6484 7.20861 13.6484ZM10.4264 11.0021H1.51555V2.04539H10.4264V11.0021Z"/>
        </svg>
        <a href="tel:'.esc_html($realtor_details['realtor_mobile']). '">'.esc_html($realtor_details['realtor_mobile']).'</a></div>';
    }

    if ($realtor_details['email']!='') {
        $return_string.= '<div class="agent_detail agent_email_class">
        <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.7489 0.145508H2.2512C1.09771 0.145508 0.16748 1.0546 0.16748 2.18187V9.81823C0.16748 10.9455 1.09771 11.8546 2.2512 11.8546H13.7489C14.9024 11.8546 15.8326 10.9455 15.8326 9.81823V2.18187C15.8326 1.0546 14.9024 0.145508 13.7489 0.145508ZM13.7489 1.96369C13.7861 1.96369 13.8419 1.98187 13.8791 2.00005L8.13027 5.50914C8.05585 5.54551 7.96283 5.54551 7.88841 5.50914L2.13958 2.00005C2.17678 1.98187 2.21399 1.96369 2.26981 1.96369H13.7489ZM13.7489 10.0364H2.2512C2.12097 10.0364 2.02795 9.94551 2.02795 9.81823V4.07278L6.88376 7.0546C7.21865 7.2546 7.60934 7.36369 8.00004 7.36369C8.39074 7.36369 8.78144 7.2546 9.11632 7.0546L13.9721 4.07278V9.81823C13.9721 9.94551 13.8791 10.0364 13.7489 10.0364Z"/>
        </svg>
        <a href="mailto:' .esc_html( $realtor_details['email']) . '">' . esc_html($realtor_details['email']).'</a></div>';
    }

    if ($realtor_details['realtor_skype']!='') {
        $return_string.= '<div class="agent_detail agent_skype_class">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.45455 4C1.45455 2.59418 2.59418 1.45455 4 1.45455C4.69933 1.45455 5.33161 1.73561 5.79241 2.19263L6.08897 2.48675L6.49245 2.37884C6.97244 2.25047 7.47767 2.18182 8 2.18182C11.2133 2.18182 13.8182 4.78671 13.8182 8C13.8182 8.52233 13.7495 9.02756 13.6212 9.50756L13.5132 9.91105L13.8073 10.2076C14.2644 10.6684 14.5455 11.3007 14.5455 12C14.5455 13.4058 13.4058 14.5455 12 14.5455C11.3007 14.5455 10.6684 14.2644 10.2076 13.8073L9.91105 13.5132L9.50756 13.6212C9.02756 13.7495 8.52233 13.8182 8 13.8182C4.78671 13.8182 2.18182 11.2133 2.18182 8C2.18182 7.47767 2.25047 6.97244 2.37884 6.49245L2.48675 6.08897L2.19263 5.79241C1.73561 5.33161 1.45455 4.69933 1.45455 4ZM4 0C1.79086 0 0 1.79086 0 4C0 4.94788 0.330422 5.81964 0.881265 6.50485C0.780269 6.98793 0.727273 7.48815 0.727273 8C0.727273 12.0166 3.98338 15.2727 8 15.2727C8.51185 15.2727 9.01207 15.2197 9.49513 15.1188C10.1804 15.6696 11.0521 16 12 16C14.2092 16 16 14.2092 16 12C16 11.0521 15.6696 10.1804 15.1188 9.49513C15.2197 9.01207 15.2727 8.51185 15.2727 8C15.2727 3.98338 12.0166 0.727273 8 0.727273C7.48815 0.727273 6.98793 0.780269 6.50485 0.881265C5.81964 0.330422 4.94788 0 4 0ZM7.01236 6.05834C7.1088 5.87436 7.43891 5.63636 7.95091 5.63636C8.82829 5.63636 9.31229 5.97973 9.53484 6.14959C9.85411 6.39326 10.3105 6.33194 10.5542 6.01263C10.7979 5.69333 10.7366 5.23695 10.4172 4.99327C10.0612 4.72156 9.27084 4.18181 7.95091 4.18182C7.028 4.18182 6.12729 4.6138 5.69035 5.44741C5.37457 6.04986 5.4257 6.70727 5.74648 7.24087C6.05799 7.75898 6.59862 8.12924 7.23564 8.3008L8.36553 8.60516C8.80073 8.72233 9.46175 9.12676 9.22371 9.67164C9.08022 10.0002 8.57156 10.3636 7.8224 10.3636C7.17484 10.3636 6.60342 10.2517 6.07761 9.8504C5.7583 9.60676 5.30192 9.66807 5.05825 9.98735C4.81457 10.3067 4.87589 10.7631 5.1952 11.0067C5.89969 11.5444 6.63309 11.8182 7.6616 11.8182C8.81004 11.8182 10.0632 11.3836 10.5567 10.2539C10.8471 9.58895 10.7513 8.89193 10.3884 8.33222C9.83004 7.47091 8.86815 7.22204 7.9368 6.98102C7.82858 6.95302 7.72065 6.92509 7.61389 6.89629C7.23135 6.79324 6.78407 6.4939 7.01236 6.05834Z"/>
        </svg>
    ' . esc_html($realtor_details['realtor_skype'] ). '</div>';
    }

    if ($realtor_details['realtor_urlc']!='') {
        $return_string.= '<div class="agent_detail agent_web_class">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_332_14)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M16 8C16 12.4184 12.4184 16 8 16C3.5816 16 0 12.4184 0 8C0 3.5816 3.5816 0 8 0C12.4184 0 16 3.5816 16 8ZM7.3056 1.9456C7.5856 1.6792 7.8184 1.6 8 1.6C8.1816 1.6 8.4144 1.68 8.6944 1.9456C8.9776 2.2152 9.2696 2.6432 9.532 3.2336C10.04 4.3776 10.38 5.9984 10.3992 7.8336C9.6496 7.9408 8.844 8 8 8C7.156 8 6.3504 7.9408 5.6008 7.8328C5.62 5.9984 5.96 4.3776 6.468 3.2336C6.7304 2.6432 7.0224 2.2152 7.3056 1.9456ZM4.008 7.512C4.0608 5.6272 4.4232 3.8984 5.0072 2.584C5.05476 2.47641 5.10491 2.36998 5.1576 2.2648C4.3033 2.68909 3.55442 3.29864 2.96554 4.04902C2.37667 4.79941 1.96263 5.67172 1.7536 6.6024C2.3456 6.9608 3.1112 7.2736 4.008 7.512ZM1.608 8.34C2.3168 8.68 3.1384 8.96 4.0392 9.168C4.1512 10.7872 4.492 12.2616 5.0056 13.416C5.0536 13.5248 5.104 13.6312 5.156 13.7352C4.13954 13.231 3.27534 12.4658 2.6519 11.5178C2.02847 10.5697 1.66821 9.47304 1.608 8.34ZM5.668 9.456C6.416 9.5504 7.1976 9.6 7.9992 9.6C8.8008 9.6 9.5832 9.5504 10.3304 9.456C10.2048 10.7576 9.9168 11.8984 9.5304 12.7664C9.2688 13.3568 8.9768 13.7848 8.6936 14.0544C8.4136 14.3208 8.1808 14.4 7.9992 14.4C7.8176 14.4 7.5848 14.32 7.3048 14.0544C7.0216 13.7848 6.7296 13.3568 6.4672 12.7664C6.0816 11.8992 5.7936 10.7576 5.668 9.4568V9.456ZM11.9592 9.168C11.8472 10.7872 11.5064 12.2616 10.9928 13.416C10.9452 13.5236 10.8951 13.63 10.8424 13.7352C11.8589 13.231 12.723 12.4658 13.3465 11.5178C13.9699 10.5697 14.3302 9.47304 14.3904 8.34C13.6816 8.68 12.86 8.96 11.9592 9.168ZM14.2464 6.6024C14.0374 5.67172 13.6234 4.79941 13.0345 4.04902C12.4456 3.29864 11.6967 2.68909 10.8424 2.2648C10.8944 2.3688 10.9448 2.4752 10.9928 2.584C11.5768 3.8984 11.9384 5.6272 11.9928 7.512C12.8888 7.2736 13.6552 6.96 14.2464 6.6024Z"/>
            </g>
            <defs>
            <clipPath id="clip0_332_14">
            <rect width="16" height="16" fill="white"/>
            </clipPath>
            </defs>
        </svg>
        <a href="'.esc_url($realtor_details['realtor_urlc']).'" target="_blank">'.esc_html($realtor_details['realtor_urlc']).'</a></div>';
    }
    
    if($realtor_details['member_of']!=''){
        $return_string.= '<div class="agent_detail agent_web_member_of_class"><strong>'.esc_html__('Member of:','wpresidence').'</strong> '.esc_html($realtor_details['member_of']).'</div>';
  
    }

    return $return_string;
}
endif;


/**
*  return contact details
*
* param   $propid = proeprty id
* @var
*/



if( !function_exists('wpestate_return_agent_reviews_bar') ):
    function wpestate_return_agent_reviews_bar($postID){

        $return_string      = '';

        $args = array(
            'number' => '15',
            'post_id' => $postID, // use post_id, not post_ID
           
        );
        $comments           =   get_comments($args);   
        $coments_no         =   0;
        $stars_total        =   0;


        foreach($comments as $comment) :
            if(wp_get_comment_status($comment->comment_ID)!='unapproved'){
                $coments_no++;
                $rating= get_comment_meta( $comment->comment_ID , 'review_stars', true );
                $stars_total+=$rating;
            }
        endforeach;
        
                


        if($coments_no>0){
            $list_rating= ceil($stars_total/$coments_no);
    
            print number_format($list_rating,1,'.');
     
            $return_string .= '<span class="property_ratings">';
                 
                $counter=0; 
                while($counter<5){
                    $counter++;
                    if( $counter<=$list_rating ){
                        $return_string.= '<i class="fas fa-star"></i>';
                    }else{
                        $return_string.= '<i class="far fa-star"></i>'; 
                    }

                }
            $return_string.='</span>';
            $return_string .=  intval($coments_no).' ';
            $return_string .=  esc_html__('Reviews', 'wpresidence');
                
        
        }// end if


       return $return_string; 	
    }
endif;


/*
<h3 id="listing_reviews" class="panel-title">
<?php
print intval($coments_no).' ';
esc_html_e('Reviews', 'wpresidence');
?>
<span class="property_ratings">
     <?php 
    $counter=0; 
        while($counter<5){
            $counter++;
            if( $counter<=$list_rating ){
                print '<i class="fas fa-star"></i>';
            }else{
                print '<i class="far fa-star"></i>'; 
            }

        }
    ?>
</span>
</h3> */