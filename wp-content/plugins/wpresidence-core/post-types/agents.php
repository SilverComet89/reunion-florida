<?php
// register the custom post type
add_action( 'setup_theme', 'wpestate_create_agent_type',20);

if( !function_exists('wpestate_create_agent_type') ):

function wpestate_create_agent_type() {
    $rewrites   =   wpestate_safe_rewite();
    register_post_type( 'estate_agent',
            array(
                    'labels' => array(
                            'name'          => esc_html__( 'Agents','wpresidence-core'),
                            'singular_name' => esc_html__( 'Agent','wpresidence-core'),
                            'add_new'       => esc_html__('Add New Agent','wpresidence-core'),
            'add_new_item'          =>  esc_html__('Add Agent','wpresidence-core'),
            'edit'                  =>  esc_html__('Edit' ,'wpresidence-core'),
            'edit_item'             =>  esc_html__('Edit Agent','wpresidence-core'),
            'new_item'              =>  esc_html__('New Agent','wpresidence-core'),
            'view'                  =>  esc_html__('View','wpresidence-core'),
            'view_item'             =>  esc_html__('View Agent','wpresidence-core'),
            'search_items'          =>  esc_html__('Search Agent','wpresidence-core'),
            'not_found'             =>  esc_html__('No Agents found','wpresidence-core'),
            'not_found_in_trash'    =>  esc_html__('No Agents found','wpresidence-core'),
            'parent'                =>  esc_html__('Parent Agent','wpresidence-core'),
            'featured_image'        => esc_html__('Featured Image','wpresidence-core'),
            'set_featured_image'    => esc_html__('Set Featured Image','wpresidence-core'),
            'remove_featured_image' => esc_html__('Remove Featured Image','wpresidence-core'),
            'use_featured_image'    => esc_html__('Use Featured Image','wpresidence-core'),
                        
                    ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => $rewrites[6]),
            'supports' => array('title', 'editor', 'thumbnail','comments','excerpt'),
            'can_export' => true,
            'register_meta_box_cb' => 'wpestate_add_agents_metaboxes',
            'menu_icon'=> WPESTATE_PLUGIN_DIR_URL.'/img/agents.png',
            'show_in_rest'=>true,
            )
    );
    // add custom taxonomy

    // add custom taxonomy
    register_taxonomy('property_category_agent', array('estate_agent'), array(
        'labels' => array(
            'name'              => esc_html__('Agent Categories','wpresidence-core'),
            'add_new_item'      => esc_html__('Add New Agent Category','wpresidence-core'),
            'new_item_name'     => esc_html__('New Agent Category','wpresidence-core')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
         'show_in_rest'      => true,
        'rewrite'       => array( 'slug' => $rewrites[7] )
        )
    );



    register_taxonomy('property_action_category_agent', 'estate_agent', array(
        'labels' => array(
            'name'              => esc_html__('Agent Action Categories','wpresidence-core'),
            'add_new_item'      => esc_html__('Add New Agent Action','wpresidence-core'),
            'new_item_name'     => esc_html__('New Agent Action','wpresidence-core')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
         'show_in_rest'      => true,
        'rewrite'       => array( 'slug' => $rewrites[8] )
       )
    );



    // add custom taxonomy
    register_taxonomy('property_city_agent','estate_agent', array(
        'labels' => array(
            'name'              => esc_html__('Agent City','wpresidence-core'),
            'add_new_item'      => esc_html__('Add New Agent City','wpresidence-core'),
            'new_item_name'     => esc_html__('New Agent City','wpresidence-core')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
         'show_in_rest'      => true,
        'rewrite'       => array( 'slug' => $rewrites[9],'with_front' => false)
        )
    );




    // add custom taxonomy
    register_taxonomy('property_area_agent', 'estate_agent', array(
        'labels' => array(
            'name'              => esc_html__('Agent Neighborhood','wpresidence-core'),
            'add_new_item'      => esc_html__('Add New Agent Neighborhood','wpresidence-core'),
            'new_item_name'     => esc_html__('New Agent Neighborhood','wpresidence-core')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
         'show_in_rest'      => true,
        'rewrite'       => array( 'slug' => $rewrites[10] )

        )
    );

    // add custom taxonomy
    register_taxonomy('property_county_state_agent', array('estate_agent'), array(
        'labels' => array(
            'name'              => esc_html__('Agent County / State','wpresidence-core'),
            'add_new_item'      => esc_html__('Add New Agent County / State','wpresidence-core'),
            'new_item_name'     => esc_html__('New Agent County / State','wpresidence-core')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
         'show_in_rest'      => true,
        'rewrite'       => array( 'slug' =>  $rewrites[11] )

        )
    );
}
endif; // end   wpestate_create_agent_type


////////////////////////////////////////////////////////////////////////////////////////////////
// Add agent metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_agents_metaboxes') ):
function wpestate_add_agents_metaboxes() {
  add_meta_box(  'estate_agent-sectionid', esc_html__( 'Agent Settings', 'wpresidence-core' ), 'estate_agent', 'estate_agent' ,'normal','default');
}
endif; // end   wpestate_add_agents_metaboxes



////////////////////////////////////////////////////////////////////////////////////////////////
// Agent details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_agent') ):
function estate_agent( $post ) {
    wp_nonce_field( plugin_basename( __FILE__ ), 'estate_agent_noncename' );
    global $post;



    print'
    <p class="meta-options third-meta-options">
    <label for="agent_position third-meta-options">'.esc_html__('Agent First Name:','wpresidence-core').' </label><br />
    <input type="text" id="first_name"  name="first_name" value="'.  esc_html(get_post_meta($post->ID, 'first_name', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_position third-meta-options">'.esc_html__('Agent Last Name:','wpresidence-core').' </label><br />
    <input type="text" id="last_name"  name="last_name" value="'.  esc_html(get_post_meta($post->ID, 'last_name', true)).'">
    </p>


    <p class="meta-options third-meta-options">
    <label for="agent_position third-meta-options">'.esc_html__('Position:','wpresidence-core').' </label><br />
    <input type="text" id="agent_position"  name="agent_position" value="'.  esc_html(get_post_meta($post->ID, 'agent_position', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_email">'.esc_html__('Email:','wpresidence-core').' </label><br />
    <input type="text" id="agent_email" name="agent_email" value="'.  esc_html(get_post_meta($post->ID, 'agent_email', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_phone">'.esc_html__('Phone: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_phone" name="agent_phone" value="'.  esc_html(get_post_meta($post->ID, 'agent_phone', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_mobile">'.esc_html__('Mobile:','wpresidence-core').' </label><br />
    <input type="text" id="agent_mobile" name="agent_mobile" value="'.  esc_html(get_post_meta($post->ID, 'agent_mobile', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_skype">'.esc_html__('Skype: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_skype"  name="agent_skype" value="'.  esc_html(get_post_meta($post->ID, 'agent_skype', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_member">'.esc_html__('Member of: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_member"  name="agent_member" value="'.  esc_html(get_post_meta($post->ID, 'agent_member', true)).'">
    </p>
    
    <p class="meta-options third-meta-options">
    <label for="agent_address">'.esc_html__('Address: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_address"  name="agent_address" value="'.  esc_html(get_post_meta($post->ID, 'agent_address', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_facebook">'.esc_html__('Facebook: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_facebook"  name="agent_facebook" value="'.  esc_html(get_post_meta($post->ID, 'agent_facebook', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_twitter">'.esc_html__('Twitter: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_twitter"  name="agent_twitter" value="'.  esc_html(get_post_meta($post->ID, 'agent_twitter', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_linkedin">'.esc_html__('Linkedin: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_linkedin"  name="agent_linkedin" value="'.  esc_html(get_post_meta($post->ID, 'agent_linkedin', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_pinterest">'.esc_html__('Pinterest: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_pinterest"  name="agent_pinterest" value="'.  esc_html(get_post_meta($post->ID, 'agent_pinterest', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_instagram">'.esc_html__('Instagram: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_instagram"  name="agent_instagram" value="'.  esc_html(get_post_meta($post->ID, 'agent_instagram', true)).'">
    </p>

<p class="meta-options third-meta-options">
    <label for="agent_youtube">'.esc_html__('Youtube: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_youtube"  name="agent_youtube" value="'.  esc_html(get_post_meta($post->ID, 'agent_youtube', true)).'">
    </p>
    
<p class="meta-options third-meta-options">
    <label for="agent_tiktok">'.esc_html__('TikTok: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_tiktok"  name="agent_tiktok" value="'.  esc_html(get_post_meta($post->ID, 'agent_tiktok', true)).'">
    </p>
    
<p class="meta-options third-meta-options">
    <label for="agent_telegram">'.esc_html__('Telegram: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_telegram"  name="agent_telegram" value="'.  esc_html(get_post_meta($post->ID, 'agent_telegram', true)).'">
    </p>
    
<p class="meta-options third-meta-options">
    <label for="agent_vimeo">'.esc_html__('Vimeo: ','wpresidence-core').'</label><br />
    <input type="text" id="agent_vimeo"  name="agent_vimeo" value="'.  esc_html(get_post_meta($post->ID, 'agent_vimeo', true)).'">
    </p>


    <p class="meta-options third-meta-options">
        <label for="agent_website">'.esc_html__('Website (without http): ','wpresidence-core').'</label><br />
        <input type="text" id="agent_website"  name="agent_website" value="'.  esc_html(get_post_meta($post->ID, 'agent_website', true)).'">
    </p>

<p class="meta-options third-meta-options">
        <label for="agent_private_notes">'.esc_html__('Private Notes ','wpresidence-core').'</label><br />
        <input type="text" id="agent_private_notes"  name="agent_private_notes" value="'.  esc_html(get_post_meta($post->ID, 'agent_private_notes', true)).'">
    </p>

    <p class="meta-options third-meta-options">
        <label for="user_meda_id">'.esc_html__('The user id for this profile: ','wpresidence-core').'</label><br />
        <input type="text" id="user_meda_id"  name="user_meda_id" value="'. intval( get_post_meta($post->ID, 'user_meda_id',true ) ).'">
    </p>';
    $author = get_post_field( 'post_author', $post->ID) ;
    $agency_post = get_the_author_meta('user_agent_id',$author);
    print'
    <p class="meta-options third-meta-options">
        <label for="owner_author_id">'.esc_html__('The Agency id/Developer USER ID that has this agent: ','wpresidence-core').'</label><br />
        <strong>'.esc_html__('Current Agency/Developer','wpresidence-core').':</strong>'.get_the_title($agency_post).'</br>
        <input type="text" id="owner_author_id"  name="owner_author_id" value="'. $author.'">
    </p>


    ';


    print '<div class="add_custom_data_cont">
            <div class="">'.esc_html__('Agent Custom fields','wpresidence-core').'</div>
            <div class="">
                 <p class="meta-options third-meta-options">
                      <input type="button" class="button-primary add_custom_parameter" value="'.esc_html__('Add Custom Field','wpresidence-core').'"   >
                  </p>
            </div>';


			  print '
				<div class="single_parameter_row cliche_row">
				<div class="meta-options third-meta-options">
					<label for="agent_custom_label">'.esc_html__('Field Label: ','wpresidence-core').'</label><br />
					<input type="text" name="agent_custom_label[]" value="">
				</div>
				<div class="meta-options third-meta-options">
					<label for="agent_custom_value">'.esc_html__('Field Value: ','wpresidence-core').'</label><br />
					<input type="text" name="agent_custom_value[]" value="">
				</div>
				<div class="meta-options third-meta-options">
					<label for="agent_website">&nbsp;</label><br />
					<input type="button" class="button-primary remove_parameter_button" value="'.esc_html__('Remove','wpresidence-core').'"   >
				</div>
				</div>
				';


    $agent_custom_data = get_post_meta( $post->ID, 'agent_custom_data', true );



    if( is_array($agent_custom_data) && count( $agent_custom_data )  > 0  && is_array( $agent_custom_data) ){
		for( $i=0; $i<count( $agent_custom_data ); $i++ ){
		print '
		<div class="single_parameter_row  ">
		<div class="meta-options third-meta-options">
			<label for="agent_website">'.esc_html__('Field Label: ','wpresidence-core').'</label><br />
			<input type="text"   name="agent_custom_label[]" value="'.  esc_html( $agent_custom_data[$i]['label'] ).'">
		</div>
		<div class="meta-options third-meta-options">
			<label for="agent_website">'.esc_html__('Field Value: ','wpresidence-core').'</label><br />
			<input type="text"    name="agent_custom_value[]" value="'.  esc_html( $agent_custom_data[$i]['value'] ).'">
		</div>
		<div class="meta-options third-meta-options">
			<label for="agent_website">&nbsp;</label><br />
			<input type="button" class="button-primary remove_parameter_button" value="'.esc_html__('Remove','wpresidence-core').'"   >
		</div>
		</div>
		';


		}
    }



    print '</div>';
}
endif; // end   estate_agent




add_action('save_post', 'wpsx_5688_update_post', 1, 2);

if( !function_exists('wpsx_5688_update_post') ):
function wpsx_5688_update_post($post_id,$post){

    if(!is_object($post) || !isset($post->post_type)) {
        return;
    }

    if($post->post_type!='estate_agent'){
       return;
    }

    if( !isset($_POST['agent_email']) ){
        return;
    }

    if( isset($_POST['owner_author_id']) ){
        remove_action('save_post', 'estate_save_postdata', 1, 2);
        remove_action('save_post', 'wpsx_5688_update_post', 1, 2);

        $old_author =   get_post_field( 'post_author', $post->ID) ;
        $new_author =   intval($_POST['owner_author_id']);
        $agent_id = intval( get_post_meta($post->ID, 'user_meda_id',true ) );
        //echo  $agent_id.'$old_authocccr '.$old_author.' / '.$new_author;

        //$agency_post = get_the_author_meta('user_agent_id',$author);
        if( $old_author != $new_author){
            $arg = array(
                'ID'            => $post_id,
                'post_author'   => $new_author,
            );
            wp_update_post( $arg );

            // remove from old agency
            $current_agent_list=(array)get_user_meta($old_author,'current_agent_list',true) ;
            $agent_list=array();
            if(is_array($current_agent_list)){
                $agent_list     = array_unique ( $current_agent_list );
            }

            if (is_array($agent_list) && ($key = array_search($agent_id, $agent_list)) !== false) {
                unset($agent_list[$key]);
            }

            if(is_array($agent_list)){
               $agent_list= array_unique($agent_list);
            }

            update_user_meta($old_author,'current_agent_list',$agent_list);


            $agent_list     =    ((array) get_user_meta($new_author,'current_agent_list',true) );
            if(is_array($agent_list)){
               $agent_list= array_unique($agent_list);
            }
            $agent_list[]   =   $agent_id;

            update_user_meta($new_author,'current_agent_list',array_unique($agent_list) );
        }


        add_action('save_post', 'estate_save_postdata', 1, 2);
        add_action('save_post', 'wpsx_5688_update_post', 1, 2);


    }


    if('yes' ==  'yes' ){
            $allowed_html   =   array();
            $first_name    = wp_kses($_POST['first_name'],$allowed_html);
            $last_name    = wp_kses($_POST['last_name'],$allowed_html);
            $user_id    = get_post_meta($post_id, 'user_meda_id', true);
            $email      = wp_kses($_POST['agent_email'],$allowed_html);
            $phone      = wp_kses($_POST['agent_phone'],$allowed_html);
            $skype      = wp_kses($_POST['agent_skype'],$allowed_html);
            $position   = wp_kses($_POST['agent_position'],$allowed_html);
            $mobile     = wp_kses($_POST['agent_mobile'],$allowed_html);
            $desc       = wp_kses($_POST['content'],$allowed_html);
            $image_id   = get_post_thumbnail_id($post_id);
            $full_img   = wp_get_attachment_image_src($image_id, 'property_listings');
            $facebook   = wp_kses($_POST['agent_facebook'],$allowed_html);
            $twitter    = wp_kses($_POST['agent_twitter'],$allowed_html);
            $linkedin   = wp_kses($_POST['agent_linkedin'],$allowed_html);
            $pinterest  = wp_kses($_POST['agent_pinterest'],$allowed_html);
            $instagram  = wp_kses($_POST['agent_instagram'],$allowed_html);
            $youtube    = wp_kses($_POST['agent_youtube'],$allowed_html);
            $tiktok     = wp_kses($_POST['agent_tiktok'],$allowed_html);
            $telegram   = wp_kses($_POST['agent_telegram'],$allowed_html);
            $vimeo      = wp_kses($_POST['agent_vimeo'],$allowed_html);
            $private_notes = wp_kses($_POST['agent_private_notes'],$allowed_html);
            $agent_website  = wp_kses($_POST['agent_website'],$allowed_html);
            $agent_member   = wp_kses($_POST['agent_member'],$allowed_html);
            $agent_address  = wp_kses($_POST['agent_address'],$allowed_html);
            
            
            $agent_custom_label    = array_map( 'esc_attr', $_POST['agent_custom_label']);
            $agent_custom_value    = array_map( 'esc_attr', $_POST['agent_custom_value']);

            // prcess fields data
            $agent_fields_array = array();

            for( $i=1; $i<count( $agent_custom_label  ); $i++ ){
                $agent_fields_array[] = array( 'label' => sanitize_text_field($agent_custom_label[$i] ), 'value' => sanitize_text_field($agent_custom_value[$i] ) );
            }
//update_post_meta($user_id, 'agent_custom_data',   $agent_fields_array);
            update_post_meta($post->ID, 'agent_custom_data',   $agent_fields_array);

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
            update_user_meta( $user_id, 'instagram', $instagram) ;
            update_user_meta( $user_id, 'website', $agent_website) ;
            update_user_meta( $user_id, 'agent_member', $agent_member) ;
            update_user_meta( $user_id, 'agent_address', $agent_address) ;
            update_user_meta( $user_id, 'small_custom_picture', $image_id) ;
            update_user_meta( $user_id, 'first_name', $first_name) ;
            update_user_meta( $user_id, 'last_name', $last_name) ;

            update_user_meta( $user_id, 'youtube', $youtube) ;
            update_user_meta( $user_id, 'tiktok', $tiktok) ;
            update_user_meta( $user_id, 'telegram', $telegram) ;
            update_user_meta( $user_id, 'vimeo', $vimeo) ;
            update_user_meta( $user_id, 'private_notes', $private_notes) ;
            // custom fields for agent cf reprocess


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




add_filter( 'manage_edit-estate_agent_columns', 'wpestate_my_columns_agent' );

if( !function_exists('wpestate_my_columns_agent') ):
function wpestate_my_columns_agent( $columns ) {
    $slice=array_slice($columns,2,2);
    unset( $columns['comments'] );
    unset( $slice['comments'] );
    $splice=array_splice($columns, 2);
    $columns['estate_ID']               = esc_html__('ID','wpresidence-core');
    $columns['estate_agent_thumb']      = esc_html__('Image','wpresidence-core');
    $columns['estate_agent_city']       = esc_html__('City','wpresidence-core');
    $columns['estate_agent_action']     = esc_html__('Action','wpresidence-core');
    $columns['estate_agent_category']   = esc_html__( 'Category','wpresidence-core');
    $columns['estate_agent_email']      = esc_html__('Email','wpresidence-core');
    $columns['estate_agent_phone']      = esc_html__('Phone','wpresidence-core');

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

add_action('restrict_manage_posts', $restrict_manage_posts('estate_agent', 'property_category_agent') );
add_filter('parse_query', $parse_query('estate_agent', 'property_category_agent') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_agent', 'property_action_category_agent') );
add_filter('parse_query', $parse_query('estate_agent', 'property_action_category_agent') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_agent', 'property_city_agent') );
add_filter('parse_query', $parse_query('estate_agent', 'property_city_agent') );


?>
