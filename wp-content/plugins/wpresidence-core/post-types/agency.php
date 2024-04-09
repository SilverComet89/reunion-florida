<?php
// register the custom post type
add_action( 'setup_theme', 'wpestate_create_agency_type',20);

if( !function_exists('wpestate_create_agency_type') ):
    function wpestate_create_agency_type() {
        $rewrites   =   wpestate_safe_rewite();
        $slug='agency';
        if(isset( $rewrites[22])){
            $slug=$rewrites[22];
        }
        register_post_type( 'estate_agency',
                array(
                        'labels' => array(
                                'name'          => esc_html__( 'Agency','wpresidence-core'),
                                'singular_name' => esc_html__( 'Agency','wpresidence-core'),
                                'add_new'       => esc_html__('Add New Agency','wpresidence-core'),
                'add_new_item'          =>  esc_html__('Add Agency','wpresidence-core'),
                'edit'                  =>  esc_html__('Edit' ,'wpresidence-core'),
                'edit_item'             =>  esc_html__('Edit Agency','wpresidence-core'),
                'new_item'              =>  esc_html__('New Agency','wpresidence-core'),
                'view'                  =>  esc_html__('View','wpresidence-core'),
                'view_item'             =>  esc_html__('View Agency','wpresidence-core'),
                'search_items'          =>  esc_html__('Search Agency','wpresidence-core'),
                'not_found'             =>  esc_html__('No Agency found','wpresidence-core'),
                'not_found_in_trash'    =>  esc_html__('No Agency found','wpresidence-core'),
                'parent'                =>  esc_html__('Parent Agency','wpresidence-core'),
                'featured_image'        => esc_html__('Featured Image','wpresidence-core'),
                'set_featured_image'    => esc_html__('Set Featured Image','wpresidence-core'),
                'remove_featured_image' => esc_html__('Remove Featured Image','wpresidence-core'),
                'use_featured_image'    => esc_html__('Use Featured Image','wpresidence-core'),
                            
                        ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => $slug),
                'supports' => array('title', 'editor', 'thumbnail','comments','excerpt'),
                'can_export' => true,
                'register_meta_box_cb' => 'wpestate_add_agency_metaboxes',
                'menu_icon'=> WPESTATE_PLUGIN_DIR_URL.'/img/agency.png',
                'show_in_rest'=>true,
                )
        );
        // add custom taxonomy

        // add custom taxonomy
       
        if(!isset($rewrites[12]) || $rewrites[12]==''){
            $category_rewrite='agency-category';
        }else{
            $category_rewrite =  $rewrites[12];
        }
        
        register_taxonomy('category_agency', array('estate_agency'), array(
            'labels' => array(
                'name'              => esc_html__('Agency Categories','wpresidence-core'),
                'add_new_item'      => esc_html__('Add New Agency Category','wpresidence-core'),
                'new_item_name'     => esc_html__('New Agency Category','wpresidence-core')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
             'show_in_rest'      => true,
             'rewrite'       => array( 'slug' => $category_rewrite )
            )
        );

        if(!isset($rewrites[13]) || $rewrites[13]==''){
            $action_category_agency='agency-action-category';
        }else{
            $action_category_agency =  $rewrites[13];
        }

        register_taxonomy('action_category_agency', 'estate_agency', array(
            'labels' => array(
                'name'              => esc_html__('Agency Action Categories','wpresidence-core'),
                'add_new_item'      => esc_html__('Add New Agency Action','wpresidence-core'),
                'new_item_name'     => esc_html__('New Agency Action','wpresidence-core')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'      => true,
            'rewrite'       => array( 'slug' => $action_category_agency )
           )      
        );


        if(!isset($rewrites[14]) || $rewrites[14]==''){
            $city_agency    =   'agency-city';
        }else{
            $city_agency    =  $rewrites[14];
        }
        // add custom taxonomy
        register_taxonomy('city_agency','estate_agency', array(
            'labels' => array(
                'name'              => esc_html__('Agency City','wpresidence-core'),
                'add_new_item'      => esc_html__('Add New Agency City','wpresidence-core'),
                'new_item_name'     => esc_html__('New Agency City','wpresidence-core')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'      => true,
            'rewrite'       => array( 'slug' => $city_agency )
            )
        );


        if(!isset($rewrites[15]) || $rewrites[15]==''){
            $area_agency    =   'agency-area';
        }else{
            $area_agency    =  $rewrites[15];
        }

        // add custom taxonomy
        register_taxonomy('area_agency', 'estate_agency', array(
            'labels' => array(
                'name'              => esc_html__('Agency Neighborhood','wpresidence-core'),
                'add_new_item'      => esc_html__('Add New Agency Neighborhood','wpresidence-core'),
                'new_item_name'     => esc_html__('New Agency Neighborhood','wpresidence-core')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
            'show_in_rest'      => true,
            'rewrite'       => array( 'slug' => $area_agency )

            )
        );
        
        
        if(!isset($rewrites[16]) || $rewrites[16]==''){
            $county_state_agency    =   'agency-county';
        }else{
            $county_state_agency   =  $rewrites[16];
        }

        // add custom taxonomy
        register_taxonomy('county_state_agency', array('estate_agency'), array(
            'labels' => array(
                'name'              => esc_html__('Agency County / State','wpresidence-core'),
                'add_new_item'      => esc_html__('Add New Agency County / State','wpresidence-core'),
                'new_item_name'     => esc_html__('New Agency County / State','wpresidence-core')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
             'show_in_rest'      => true,
             'rewrite'       => array( 'slug' => $county_state_agency )

            )
        );
    }
endif; // end   wpestate_create_agency_type  


////////////////////////////////////////////////////////////////////////////////////////////////
// Add agent metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_agency_metaboxes') ):
function wpestate_add_agency_metaboxes() {	
    add_meta_box(  'estate_agency-sectionid', esc_html__( 'Agency Settings', 'wpresidence-core' ), 'estate_agency', 'estate_agency' ,'normal','default');
}
endif; // end   wpestate_add_agency_metaboxes  



////////////////////////////////////////////////////////////////////////////////////////////////
// Agency details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_agency') ):
    function estate_agency( $post ) {
        wp_nonce_field( plugin_basename( __FILE__ ), 'estate_agency_noncename' );
        global $post;
        $userID                 =   intval( get_post_meta($post->ID, 'user_meda_id',true ));
        $agency_email           =   get_the_author_meta( 'user_email' , $userID );
        print'
        <p class="meta-options third-meta-options">
        <label for="agency_address third-meta-options">'.esc_html__('Address:','wpresidence-core').' </label><br />
        <input type="text" id="agency_address"  name="agency_address" value="'.  esc_html(get_post_meta($post->ID, 'agency_address', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="agency_email">'.esc_html__('Email: ','wpresidence-core').'</label><br />
        <input type="text" id="agency_email" name="agency_email" value="'.  esc_html(get_post_meta($post->ID, 'agency_email', true)).'">
        </p>


        <p class="meta-options third-meta-options">
        <label for="agency_phone">'.esc_html__('Phone: ','wpresidence-core').'</label><br />
        <input type="text" id="agency_phone" name="agency_phone" value="'.  esc_html(get_post_meta($post->ID, 'agency_phone', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="agency_mobile">'.esc_html__('Mobile:','wpresidence-core').' </label><br />
        <input type="text" id="agency_mobile" name="agency_mobile" value="'.  esc_html(get_post_meta($post->ID, 'agency_mobile', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="agency_skype">'.esc_html__('Skype: ','wpresidence-core').'</label><br />
        <input type="text" id="agency_skype"  name="agency_skype" value="'.  esc_html(get_post_meta($post->ID, 'agency_skype', true)).'">
        </p>


        <p class="meta-options third-meta-options">
        <label for="agency_facebook">'.esc_html__('Facebook: ','wpresidence-core').'</label><br />
        <input type="text" id="agency_facebook"  name="agency_facebook" value="'.  esc_html(get_post_meta($post->ID, 'agency_facebook', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="agency_twitter">'.esc_html__('Twitter: ','wpresidence-core').'</label><br />
        <input type="text" id="agency_twitter"  name="agency_twitter" value="'.  esc_html(get_post_meta($post->ID, 'agency_twitter', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="agency_linkedin">'.esc_html__('Linkedin: ','wpresidence-core').'</label><br />
        <input type="text" id="agency_linkedin"  name="agency_linkedin" value="'.  esc_html(get_post_meta($post->ID, 'agency_linkedin', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="agency_pinterest">'.esc_html__('Pinterest: ','wpresidence-core').'</label><br />
        <input type="text" id="agency_pinterest"  name="agency_pinterest" value="'.  esc_html(get_post_meta($post->ID, 'agency_pinterest', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="agency_instagram">'.esc_html__('Instagram: ','wpresidence-core').'</label><br />
        <input type="text" id="agency_instagram"  name="agency_instagram" value="'.  esc_html(get_post_meta($post->ID, 'agency_instagram', true)).'">
        </p>



        <p class="meta-options third-meta-options">
            <label for="agency_website">'.esc_html__('Website (without http): ','wpresidence-core').'</label><br />
            <input type="text" id="agency_website"  name="agency_website" value="'.  esc_html(get_post_meta($post->ID, 'agency_website', true)).'">
        </p>
        
        <p class="meta-options third-meta-options">
            <label for="agency_website">'.esc_html__('Languages: ','wpresidence-core').'</label><br />
            <input type="text" id="agency_languages"  name="agency_languages" value="'.  esc_html(get_post_meta($post->ID, 'agency_languages', true)).'">
        </p>
        
        <p class="meta-options third-meta-options">
            <label for="agency_website">'.esc_html__('License: ','wpresidence-core').'</label><br />
            <input type="text" id="agency_license"  name="agency_license" value="'.  esc_html(get_post_meta($post->ID, 'agency_license', true)).'">
        </p>
        
        <p class="meta-options third-meta-options">
            <label for="agency_opening_hours">'.esc_html__('Agency opening hours: ','wpresidence-core').'</label><br />
            <input type="text" id="agency_opening_hours"  name="agency_opening_hours" value="'.  esc_html(get_post_meta($post->ID, 'agency_opening_hours', true)).'">
        </p>
      
        <p class="meta-options third-meta-options">
            <label for="agency_website">'.esc_html__('Taxes: ','wpresidence-core').'</label><br />
            <input type="text" id="agency_taxes"  name="agency_taxes" value="'.  esc_html(get_post_meta($post->ID, 'agency_taxes', true)).'">
        </p>
        
        <p class="meta-options third-meta-options">
            <label for="user_meda_id">'.esc_html__('The user id for this profile: ','wpresidence-core').'</label><br />
            <input type="text" id="user_meda_id"  name="user_meda_id" value="'. intval( get_post_meta($post->ID, 'user_meda_id',true ) ).'">
        </p>
    
            
        <p class="meta-options">
            <label for="agency_website">'.esc_html__('Location on Map: ','wpresidence-core').'</label><br />
                 <a class="button" href="#" id="admin_place_pin">'.esc_html__('Place Pin with Property Address','wpresidence-core').'</a>
            <div id="googleMap" style="width:100%;height:380px;margin-bottom:30px;"></div>  
            <input type="hidden" name="agency_lat" id="agency_lat" value="'.esc_html(get_post_meta($post->ID, 'agency_lat', true)).'">
            <input type="hidden" name="agency_long" id="agency_long"  value="'.esc_html(get_post_meta($post->ID, 'agency_long', true)).'">
        </p>
        ';            
    }
endif; // end   estate_agency  




add_action('save_post', 'wpestate_update_agency_post', 1, 2);

if( !function_exists('wpestate_update_agency_post') ):
    function wpestate_update_agency_post($post_id,$post){

        if(!is_object($post) || !isset($post->post_type)) {
            return;
        }

         if($post->post_type!='estate_agency'){
            return;    
         }

         if( !isset($_POST['agency_email']) ){
             return;
         }
         if('yes' ==  esc_html ( wpresidence_get_option('wp_estate_user_agency','') )){  
                $allowed_html   =   array();
                $user_id    = get_post_meta($post_id, 'user_meda_id', true);
                $email      = wp_kses($_POST['agency_email'],$allowed_html);
                $phone      = wp_kses($_POST['agency_phone'],$allowed_html);
                $skype      = wp_kses($_POST['agency_skype'],$allowed_html);
                $position   = wp_kses($_POST['agency_address'],$allowed_html);
                $mobile     = wp_kses($_POST['agency_mobile'],$allowed_html);
                $desc       = wp_kses($_POST['content'],$allowed_html);
                $image_id   = get_post_thumbnail_id($post_id);
                $full_img   = wp_get_attachment_image_src($image_id, 'property_listings');           
                $facebook   = wp_kses($_POST['agency_facebook'],$allowed_html);
                $twitter    = wp_kses($_POST['agency_twitter'],$allowed_html);
                $linkedin   = wp_kses($_POST['agency_linkedin'],$allowed_html);
                $pinterest  = wp_kses($_POST['agency_pinterest'],$allowed_html);
                $instagram  = wp_kses($_POST['agency_instagram'],$allowed_html);
                $agency_website  = wp_kses($_POST['agency_website'],$allowed_html);
                $agency_opening_hours  = wp_kses($_POST['agency_opening_hours'],$allowed_html);
              
                update_user_meta( $user_id, 'aim', '/'.$full_img[0].'/') ;
                update_user_meta( $user_id, 'phone' , $phone) ;
                update_user_meta( $user_id, 'mobile' , $mobile) ;
                update_user_meta( $user_id, 'description' , $desc) ;
                update_user_meta( $user_id, 'skype' , $skype) ;
                update_user_meta( $user_id, 'title', $position) ;
                update_user_meta( $user_id, 'custom_picture', $full_img[0]) ;
                update_user_meta( $user_id, 'facebook', $facebook) ;
                update_user_meta( $user_id, 'twitter', $twitter) ;
                update_user_meta( $user_id, 'linkedin', $linkedin) ;
                update_user_meta( $user_id, 'pinterest', $pinterest) ;
                update_user_meta( $user_id, 'instagram', $pinterest) ;
                update_user_meta( $user_id, 'website', $agency_website) ;
                update_user_meta( $user_id, 'agency_opening_hours', $agency_opening_hours) ;
                update_user_meta( $user_id, 'small_custom_picture', $image_id) ;

                $new_user_id    =   email_exists( $email ) ;
                if ( $new_user_id){
                } else{
                    $args = array(
                         'ID'         => $user_id,
                         'user_email' => $email
                    ); 
                    wp_update_user( $args );
                } 
        }//end if
    }
endif;




add_filter( 'manage_edit-estate_agency_columns', 'wpestate_my_columns_agency' );

if( !function_exists('wpestate_my_columns_agency') ):
    function wpestate_my_columns_agency( $columns ) {
        $slice=array_slice($columns,2,2);
        unset( $columns['comments'] );
        unset( $slice['comments'] );
        $splice=array_splice($columns, 2);
        $columns['estate_ID']               = esc_html__('ID','wpresidence-core');
        $columns['estate_agency_thumb']      = esc_html__('Image','wpresidence-core');
        $columns['estate_agency_city']       = esc_html__('City','wpresidence-core');
        $columns['estate_agency_action']     = esc_html__('Action','wpresidence-core');
        $columns['estate_agency_category']   = esc_html__( 'Category','wpresidence-core');
        $columns['estate_agency_email']      = esc_html__('Email','wpresidence-core');
        $columns['estate_agency_phone']      = esc_html__('Phone','wpresidence-core');

        return  array_merge($columns,array_reverse($slice));
    }
endif; // end   wpestate_my_columns  


$restrict_manage_posts = function($post_type, $taxonomy) {
    return function() use($post_type, $taxonomy) {
        global $typenow;

        if($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);

            wp_dropdown_categories(array(
                'show_option_all'   => esc_html__("Show All {$info_taxonomy->label}"),
                'taxonomy'          => $taxonomy,
                'name'              => $taxonomy,
                'orderby'           => 'name',
                'selected'          => $selected,
                'show_count'        => TRUE,
                'hide_empty'        => TRUE,
                'hierarchical'      => true
            ));

        }

    };

};

$parse_query = function($post_type, $taxonomy) {

    return function($query) use($post_type, $taxonomy) {
        global $pagenow;

        $q_vars = &$query->query_vars;

        if( $pagenow == 'edit.php'
            && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type
            && isset($q_vars[$taxonomy])
            && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0
        ) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }

    };

};

add_action('restrict_manage_posts', $restrict_manage_posts('estate_agency', 'category_agency') );
add_filter('parse_query', $parse_query('estate_agency', 'category_agency') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_agency', 'action_category_agency') );
add_filter('parse_query', $parse_query('estate_agency', 'action_category_agency') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_agency', 'city_agency') );
add_filter('parse_query', $parse_query('estate_agency', 'city_agency') );


?>