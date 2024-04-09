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


$postID     = get_the_ID();
$thumb_prop = get_the_post_thumbnail_url( $postID, 'property_listings' ); 
if($thumb_prop ==''){
    $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_property_listings.jpg');
}         

?>  

<div  class="<?php echo esc_html($col_class);?>  listing_wrapper blog3v"> 
    <div class="property_listing_blog" data-link="<?php echo esc_attr($link); ?>">
        <?php

        if( $thumb_prop!='' ){
            print '<div class="featured_gradient"></div>';
            print '<div class="blog_unit_image" style="background-image:url('.$thumb_prop.');"></div>';
        }
        ?>
        
        
        <div class="blog_unit_content_v3">
            <div class="blog_unit_meta">
                <?php print get_the_date();?>
            </div>

            <h4>
               <a href="<?php the_permalink(); ?>" class="blog_unit_title"><?php 
                    $title=get_the_title();
                    echo mb_substr( $title,0,44); 
                    if(mb_strlen($title)>44){
                        echo '...';   
                    } 
                ?></a> 
            </h4>
            <a class="read_more" href="<?php the_permalink(); ?>"> <?php esc_html_e('Continue reading','wpresidence'); ?><i class="fas fa-angle-right"></i> </a>

        </div>
            
    </div>          
</div>  