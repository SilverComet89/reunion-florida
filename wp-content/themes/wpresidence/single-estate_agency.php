<?php
// Single Agency
// Wp Estate Pack
get_header();
$wpestate_options           =   wpestate_page_details($post->ID);
$show_compare               =   1;
$wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$wpestate_options['content_class']='col-md-12';
?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> ">
  
        <div id="content_container"> 
        <?php 
        while (have_posts()) : the_post(); 
            $agency_id              = get_the_ID();
            $thumb_id               = get_post_thumbnail_id($post->ID);
            $preview                = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
            $preview_img            = $preview[0];
            $agency_skype           = esc_html( get_post_meta($post->ID, 'agency_skype', true) );
            $agency_phone           = esc_html( get_post_meta($post->ID, 'agency_phone', true) );
            $agency_mobile          = esc_html( get_post_meta($post->ID, 'agency_mobile', true) );
            $agency_email           = is_email( get_post_meta($post->ID, 'agency_email', true) );
            $agency_posit           = esc_html( get_post_meta($post->ID, 'agency_position', true) );
            $agency_urlc            = esc_html( get_post_meta($post->ID, 'agency_website', true) );
            $agency_opening_hours   = esc_html( get_post_meta($post->ID, 'agency_opening_hours', true) );
            $name                   = get_the_title();

            $realtor_details=   wpestate_return_agent_details($post->ID,$post->ID); 


        ?>
        <?php endwhile; // end of the loop.    ?>
         
        <div class="single-content single-agent">    
           
            <div class="agency_content_wrapper">
                <div class="col-md-8 agency_content">
                    <h4 class=""><?php esc_html_e('About Us','wpresidence');?></h4>
                    <?php 
                    the_content();

                    print wpestate_return_agent_share_social_icons($realtor_details,'agency_socialpage_wrapper','agency_social'); 
                    ?>
                 
                </div>
            
                <div class="col-md-4 agency_tax">

                    <div class="agency_taxonomy">
                        <?php
                            print   get_the_term_list($post->ID, 'county_state_agency', '', '', '') ;
                            print   get_the_term_list($post->ID, 'city_agency', '', '', '') ;
                            print   get_the_term_list($post->ID, 'area_agency', '', '', '');
                            print   get_the_term_list($post->ID, 'category_agency', '', '', '') ;
                            print   get_the_term_list($post->ID, 'action_category_agency', '', '', '');  
                        ?>
                    </div>
                </div>
            </div>
            
            <?php  include( locate_template('templates/agency_templates/agency_listings.php'));  ?>
            <?php  include( locate_template('templates/agency_templates/agency_agents.php'));  ?>               
   
                <?php 
                $wp_estate_show_reviews     =    wpresidence_get_option('wp_estate_show_reviews_block','');         
                if(is_array($wp_estate_show_reviews) && in_array('agency', $wp_estate_show_reviews)){
                    include( locate_template('templates/agency_templates/agency_reviews.php'));  
                }
                ?>
                
          </div> 
        </div>  
       
        </div>
    </div><!-- end 9col container-->    
</div>  


<div class="col-md-12 agency_contact_class" >  
    <div class="agency_contact_container" >
        <div class="agency_contact_wrapper">
            <div class="col-md-8"  id="agency_contact">
                <div class="agent_contanct_form ">
                <?php  
                    $context='agency_page';
                    include( locate_template ( '/templates/listing_templates/contact_form/property_page_contact_form.php'));
                ?>
                </div>
            </div>
            <div class="col-md-4 agency_contact_padding">
             <?php 
                    if($agency_addres!=''){
                        echo '<div class="agency_detail agency_address"><strong>'.esc_html__('Address:','wpresidence').'</strong> '.esc_html($agency_addres).'</div>';
                    }
                    ?>
                    <?php 
                    if($agency_email!=''){
                        echo '<div class="agency_detail agency_email"><strong>'.esc_html__('Email:','wpresidence').'</strong> <a href="mailto:'.esc_html($agency_email).'">'.esc_html($agency_email).'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_mobile!=''){
                        echo '<div class="agency_detail agency_mobile"><strong>'.esc_html__('Mobile:','wpresidence').'</strong> <a href="tel:'.esc_html($agency_mobile).'">'.esc_html($agency_mobile).'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_phone!=''){
                        echo '<div class="agency_detail agency_phone"><strong>'.esc_html__('Phone:','wpresidence').'</strong> <a href="tel:'.esc_html($agency_phone).'">'.esc_html($agency_phone).'</a></div>';
                    }
                    ?>

                    <?php 
                    if($agency_skype!=''){
                        echo '<div class="agency_detail agency_skype"><strong>'.esc_html__('Skype:','wpresidence').'</strong> '.esc_html($agency_skype).'</div>';
                    }
                    ?>
            </div>
        </div>
    </div>
</div>

<?php  
include( locate_template('templates/agency_templates/agency_map.php')); 
get_footer(); 
?>