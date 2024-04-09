<?php
$slides             =   '';
$title              =   get_the_title($prop_id);
$link               =   get_permalink($prop_id);
$property_bathrooms =   get_post_meta($prop_id, 'property_bathrooms', true);
$property_rooms     =   get_post_meta($prop_id, 'property_bedrooms', true);
$property_size      =   wpestate_get_converted_measure( $prop_id, 'property_size' ) ;
$price              =   floatval( get_post_meta($prop_id, 'property_price', true) );
$price_label        =   '<span class="price_label">'.esc_html ( get_post_meta($prop_id, 'property_label', true) ).'</span>';
$price_label_before =   '<span class="price_label price_label_before">'.esc_html ( get_post_meta($prop_id, 'property_label_before', true) ).'</span>';

if ($price != 0) {
    $price = wpestate_show_price($prop_id,$wpestate_currency,$where_currency,1);  
}else{
    $price=$price_label_before.$price_label;
}

$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_featured_sidebar');
if($preview[0]==''){
    $preview_image= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
}else{
    $preview_image=$preview[0];
}
 
$post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
$attachment_meta    =   wp_get_attachment($post_thumbnail_id);
$active             =   '';
$title              =   get_the_title($prop_id);
$property_address   =   get_post_meta($prop_id,'property_address',true);
$agent_id           =   intval  ( get_post_meta($prop_id, 'property_agent', true) );
$thumb_id           =   get_post_thumbnail_id($agent_id);
$agent_face         =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');
$agent_face_image   = '';

if($agent_face ){
    $agent_face_image=$agent_face[0];
}
$author_id = get_post_field( 'post_author', $prop_id );

if ($agent_id==0 || ( $agent_face && $agent_face[0]=='') ){
    $agent_face[0]=$agent_face_image=get_the_author_meta( 'custom_picture',$author_id);
    if( $agent_face[0]==''){
        $agent_face[0]= $agent_face_image=get_theme_file_uri('/img/default-user_1.png');
    }
}
if($agent_face_image==''){
    $agent_face_image=get_theme_file_uri('/img/default-user_1.png');
}


$property_rooms         =   get_post_meta($prop_id, 'property_bedrooms', true);
if($property_rooms!=''){
    $property_rooms =   floatval($property_rooms);
}

$property_bathrooms     =   get_post_meta($prop_id, 'property_bathrooms', true) ;
if($property_bathrooms!=''){
    $property_bathrooms =   floatval($property_bathrooms);
}

$property_size =    wpestate_get_converted_measure( $prop_id, 'property_size' );
$featured      =    intval  ( get_post_meta($prop_id, 'prop_featured', true) );


?>
<div class="item <?php echo esc_attr($active);?>" data-number="<?php echo esc_attr($counter);?>">
        
        <div class="property_slider_carousel_elementor_v3_image_wrapper">
        
            <div class="tag-wrapper">
                <?php
                    if($featured==1){
                        print '<div class="featured_div">'.esc_html__('Featured','wpresidence').'</div>';
                    }
                ?>      
                
                <div class="status-wrapper">
                    <?php
                         $property_action            =   get_the_terms($prop_id, 'property_action_category');  
                        if(isset($property_action[0])){
                            $property_action_term = $property_action[0]->name;
                            print '<div class="action_tag_wrapper '.esc_attr($property_action_term).' ">'.wp_kses_post($property_action_term).'</div>';
                        }                      
                        print wpestate_return_property_status($prop_id,'unit');      
                    ?> 
                </div>
            </div>


            <div class="places_cover"></div>
            
            <div class="property_slider_carousel_elementor_v3_image_container" style="background-image:url('<?php echo esc_url($preview_image);?>')">
            </div> 
        </div>

        <div class="property_slider_carousel_elementor_v3_content_wrapper">
            <div class="property_slider_carousel_elementor_v3_price">
                <?php echo trim($price);?>
            </div>
            
            <a href="<?php echo esc_url($link);?>" class="property_slider_carousel_elementor_v3_title">
                <?php echo esc_html($title);?>
            </a>
          
            <div class="property_slider_carousel_elementor_v3_address">
                <?php echo esc_html($property_address);?>
            </div>


            <div class="property_slider_carousel_elementor_v3_excerpt">   
                <?php 
                    echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),210,$prop_id);
                ?>
            </div>


            <div class="property_listing_details">
 
                <?php if($property_rooms!='' && $property_rooms!=0){
                    print '<span class="inforoom">';
                    include (locate_template('templates/svg_icons/single_bedrooms.html'));
         
                    print esc_html($property_rooms).'</span>';
                }

                if($property_bathrooms!='' && $property_bathrooms!=0){
                    print '<span class="infobath">';
                    include (locate_template('templates/svg_icons/single_bath.html'));
                    print  esc_html($property_bathrooms).'</span>';
                }

                if($property_size!=''){
                    print ' <span class="infosize">';
                    include (locate_template('templates/svg_icons/single_floor_plan.html'));
                    print trim($property_size).'</span>';
                }

                ?>
            </div>











            <div class="property_agent_wrapper">
                <div class="property_agent_image" style="background-image:url('<?php print esc_attr($agent_face_image); ?>')"></div> 
                <div class="property_agent_image_sign"><i class="far fa-user-circle"></i></div>
                    <?php if($agent_id!=0){
                            echo '<a href="'.esc_url( get_permalink($agent_id) ) .'">'.get_the_title($agent_id).'</a>';
                        }else{
                            echo get_the_author_meta( 'first_name',$author_id).' '.get_the_author_meta( 'last_name',$author_id);
                        }
                    ?>
                </div>

        </div>
        
   
    
</div>
   

