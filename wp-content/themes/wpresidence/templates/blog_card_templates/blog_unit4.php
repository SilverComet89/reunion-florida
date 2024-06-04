<?php
$col_class  =   'col-md-4';
if(isset($wpestate_options) && $wpestate_options['content_class']=='col-md-12' ){
    $col_class  =   'col-md-3';
    $col_org    =   3;
}

if(isset($wpestate_no_listins_per_row) && $wpestate_no_listins_per_row==3){
    $col_class  =   'col-md-6';
    $col_org    =   6;
    if(isset($wpestate_options) && $wpestate_options['content_class']=='col-md-12'){
        $col_class  =   'col-md-4';
        $col_org    =   4;
    }
    
}else{   
    $col_class  =   'col-md-4';
    $col_org    =   4;
    if( isset($wpestate_options) && $wpestate_options['content_class']=='col-md-12'){
        $col_class  =   'col-md-3';
        $col_org    =   3;
    }
}

// if template is vertical
if(isset($align) && $align=='col-md-12'){
    $col_class  =  'col-md-12';
    $col_org    =  12;
}

$preview        =   array();
$preview[0]     =   '';
$words          =   55;
$link           =   esc_url ( get_permalink());
$title          =   get_the_title();

if (mb_strlen ($title)>90 ){
    $title          =   mb_substr($title,0,90).'...';
}

if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
}
$postID= get_the_ID();
?>  

<div  class="<?php echo esc_html($col_class);?>  listing_wrapper blog4v"> 
    <div class="property_listing_blog" data-link="<?php echo esc_attr($link); ?>">
        <?php
  
       
            $pinterest  =   wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
            $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
            $compare    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
           
            
            $extra= array(
                'class'	=> 'lazyload img-responsive',    
            );
            
            if(isset($preview[0])){
               $extra['data-original']=$preview[0];
            }else{
                $extra['data-original']= get_theme_file_uri('/img/defaults/default_blog_unit.jpg');
            }
         
            $thumb_prop = get_the_post_thumbnail( $postID, 'property_listings',$extra ); 
      
            if($thumb_prop ==''){

                $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_property_listings.jpg');
                $thumb_prop         =  '<img src="'.esc_url($thumb_prop_default).'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="'.esc_html__('user image','wpresidence').'" />';   
            }
            $featured   = intval  ( get_post_meta( $postID, 'prop_featured', true ) );
        
            
            if( $thumb_prop!='' ){
                print '<div class="blog_unit_image">';
                print  '<a href="'.esc_url($link ).'" >'.trim($thumb_prop).'</a>';
                print '</div>'; 
            }
           
     
        ?>

           <h4>
               <a href="<?php the_permalink(); ?>" class="blog_unit_title"><?php 
                    $title=get_the_title();
                    echo mb_substr( $title,0,44); 
                    if(mb_strlen($title)>44){
                        echo '...';   
                    } 
                ?></a> 
           </h4>
        
         
           
            <div class="listing_details the_grid_view">
                <?php   
               
                if( has_post_thumbnail() ){
                   //echo wpestate_strip_words( get_the_excerpt(),18).' ...';
                   echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),80,$postID,'...');
                } else{
                    // echo wpestate_strip_words( get_the_excerpt(),40).' ...';
                    echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),200,$postID,'...');
                } ?>
            </div>

            <div class="blog_unit_meta">
                <span class="span_widemeta">
                    <?php $agent = get_field('agent')[0]; ?>
                    <?php
                    if ($agent != null) {
                        print '<a href="' . get_permalink($agent->ID) . '">';
                        //print get_the_post_thumbnail($agent->ID, 'post-thumbnail', ['class' => 'rounded author-icon']);
                        print ' by ' . $agent->post_title . ' ';
                        print '</a>';
                    } else {
                        print esc_html('by ', 'wpresidence') . ' ' . get_the_author_meta('display_name');

                    }
                    print esc_html(' - ', 'wpresidence') . ' ' . get_the_date();
                    ?>
                </span>  
            </div>

        </div>          
    </div>