<?php
/*
*
*  blog list widget
*
*
*
*
*/



if( !function_exists('wpestate_blog_list_widget') ):
function wpestate_blog_list_widget($attributes,$is_ajax){
    global $is_shortcode;
    global $row_number_col;
    
    $is_shortcode   =   1;
    $return_string  =   '';
    $is_ajax        =   intval($is_ajax);  
    $attributes = shortcode_atts(
                array(
                    'title'                 =>  '',
                    'number'                =>  4,
                    'rownumber'             =>  4,
                    'control_terms_id'      =>  '',
                    'sort_by'               =>   0,
                    'card_version'          =>   '',
                    'page'                  =>  1,
                    'display_grid'          =>  'no',
                    'display_grid_wrapper'  =>  '',
                ), $attributes) ;


      
    $orderby    =   'ID';
    $order      =   'DESC';
      
    if( isset( $attributes['sort_by']) && $attributes['sort_by']!=0 ) {
          
        switch( $attributes['sort_by']){
            case 1:
                $orderby='title';
                $order='ASC';
                break;
            case 2:
               $orderby='title';
               $order='DESC';
               break;
            case 3:
               $orderby='ID';
               $order='DESC';
               break;
            case 4:
               $orderby='ID';
               $order='ASC';
               break;
        }
        
    }
      
    $posts_per_page=$attributes['number'];
    $paged=1;
    if(isset($attributes['page'])){
        $paged=intval($attributes['page']);
    }
    
      
    $row_number_col       =  wpestate_shortocode_return_column($attributes['rownumber']);
    if($attributes['rownumber'] ==1){
        $row_number_col =  0;
    }
   

    $args=array(
        'post_type'     => 'post',
        'post_status'   =>  'publish',
        'orderby'       => $orderby,
        'order'         => $order,
        'posts_per_page'=>$posts_per_page,
        'paged'         => $paged
    );


  if( isset( $attributes['control_terms_id']) and $attributes['control_terms_id']!=''){
        $categories_array       =   explode(',', $attributes['control_terms_id']);
        $args['cat']  =   $attributes['control_terms_id'];
        
    } 

    $display_grid_class='';
    if($attributes['display_grid']=='yes'){
        $display_grid_class='article_container_grid';
    }
 
      
    $button = '<div class="listinglink-wrapper_sh_listings">
        <span class="wpresidence_button wpestate_item_list_sh blog_list_loader">  '.esc_html__('load articles','wpresidence-core').' </span>
        </div>';
       
    if($is_ajax==0){    
        $return_string .= '<div class="article_container '.esc_attr($display_grid_class).' wpestate_latest_listings_sh bottom-post blogs_wrapper"  '

            . 'data-category_ids="'.esc_attr($attributes['control_terms_id']).'" '     
            . 'data-number="'.intval($posts_per_page).'" '
            . 'data-row-number="'.intval($attributes['rownumber']).'" '
            . 'data-card-version="'.esc_attr($attributes['card_version']).'" '
            . 'data-sort-by="'.esc_attr($attributes['sort_by']).'"'
            . 'data-display-grid="'.esc_attr($attributes['display_grid']).'"'
            . 'data-page="'.intval($paged).'" >';

        if($attributes['title']!=''){
            $return_string .= '<h2 class="shortcode_title">'.$attributes['title'].'</h2>';
        }
    }

    $recent_posts=new Wp_Query($args);
 

    if($attributes['display_grid']=='yes'){
        $return_string .='<div class="items_shortcode_wrapper_grid">';
    }
          ob_start();
    
            $blog_unit                   =   wpestate_blog_unit_selector($attributes); 
            while ($recent_posts->have_posts()): $recent_posts->the_post();
                if($attributes['display_grid']=='yes'){
                    print '<div class="shortcode_wrapper_grid_item">';
                }
                include( locate_template($blog_unit) ) ;    
                if($attributes['display_grid']=='yes'){
                    print '</div>';
                }
            endwhile;

          

    wp_reset_query();     
    wp_reset_postdata();
            
  
    
    $templates = ob_get_contents();
    ob_end_clean();
   
    if(isset($attributes['display_grid_wrapper']) && $attributes['display_grid_wrapper']=='no' ){
        return $templates;
    }
    
    
        
        
    $return_string .=$templates;
    
      if($attributes['display_grid']=='yes'){
           $return_string .= '</div>';
    }    
    
    
    if($is_ajax==0){  
        $return_string.='<div class="wpestate_listing_sh_loader">
           <div class="new_prelader"></div>
        </div>';
        $return_string .=$button;
        $return_string .= '</div>';
    }

    

    $is_shortcode       =   0;
    return $return_string;
}
endif;




/*
*
*  recent itenms list
*
*
*
*
*/
if( !function_exists('wpestate_recent_posts_pictures_new') ):

function wpestate_recent_posts_pictures_new($attributes, $content = null) {
    global $options;
    global $align;
    global $align_class;
    global $post;
    global $wpestate_currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;
    global $current_user;
    global $curent_fav;
    global $wpestate_property_unit_slider;
    global $wpestate_no_listins_per_row;
    global $wpestate_uset_unit;
    global $wpestate_custom_unit_structure;

    $wpestate_custom_unit_structure    =   wpresidence_get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit                =   intval ( wpresidence_get_option('wpestate_uset_unit','') );
    $wpestate_no_listins_per_row       =   intval( wpresidence_get_option('wp_estate_listings_per_row', '') );
    $curent_fav                        =    wpestate_return_favorite_listings_per_user();

    $attributes = shortcode_atts(
                array(
                    'title'                 =>  '',
                    'type'                  => 'properties',
                    'category_ids'          =>  '',
                    'action_ids'            =>  '',
                    'city_ids'              =>  '',
                    'area_ids'              =>  '',
                    'state_ids'             =>  '',
                    'status_ids'            =>  '',
                    'features_ids'          =>  '',
                    'number'                =>  4,
                    'rownumber'             =>  4,
                    'align'                 =>  'vertical',
                    'link'                  =>  '',
                    'control_terms_id'      =>  '',
                    'form_fields'           =>  '',
                    'show_featured_only'    =>  'no',
                    'random_pick'           =>  'no',
                    'featured_first'        =>  'no',
                    'sort_by'               =>   0,
                    //'price_min'             =>  0,
                  //  'price_max'             =>  9999999999,
                    'card_version'          =>   '',
                    'only_favorites'        =>  '',
                    'display_grid'          =>  'no'
                ), $attributes) ;


    $shortcode_arguments            =   wpestate_prepare_arguments_shortcode($attributes);
    $wpestate_property_unit_slider  =   wpresidence_get_option('wp_estate_prop_list_slider','');


    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $control_terms_id   =   '';
    $wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';
    $show_featured_only =   '';
    $random_pick        =   '';
    $featured_first     =   '';
    if(isset($shortcode_arguments['featured_first']))  $featured_first =$shortcode_arguments['featured_first'];
    $orderby            =   'meta_value';
    $per_row_class='';



    $property_card_type_string = wpestate_return_property_card_type($shortcode_arguments);



    if ($shortcode_arguments['type'] == 'properties') {
      $type = 'estate_property';
    } else if ($shortcode_arguments['type'] == 'agents') {
        $type = 'agents';
    
        $col_org= wpestate_shortocode_return_column($shortcode_arguments['row_number']);
        if( isset($attributes['display_grid']) && $attributes['display_grid'] =='yes' ){
           print $col_org='';
        }
      
    }else{
      $type = 'post';
    }

    if (isset($shortcode_arguments['random_pick'])){
        $random_pick=   $shortcode_arguments['random_pick'];
        if($random_pick==='yes'){
            $orderby    =   'rand';
        }
    }



   $row_number_col       =  wpestate_shortocode_return_column($shortcode_arguments['row_number']);
   if($shortcode_arguments['row_number']==1 && $shortcode_arguments['align']=='vertical'){
        $row_number_col =  0;
   }
    $align        = '';
    $align_class  = '';
    if(isset($shortcode_arguments['align']) && $shortcode_arguments['align']=='horizontal'){
        $align          = "col-md-12";
        $align_class    = 'the_list_view';
        $row_number_col = '12';
    }


    $args = wpestate_recent_posts_shortocodes_create_arg($shortcode_arguments);

    
    
    $display_favorites='';
    if(isset($attributes['only_favorites']) && $attributes['only_favorites']=='yes'){
        $curent_fav     = wpestate_return_favorite_listings_per_user();
        if(empty($curent_fav)){
            $curent_fav=array();
            $curent_fav[]=0;
        }
        $args = array(
                       'post_type'        => 'estate_property',
                       'post_status'      => 'publish',
                       'posts_per_page'   => -1 ,
                       'post__in'         => $curent_fav,
                       'order_by'        => 'ID',
                   );
        $display_favorites='yes';
        $class.=" front-end-favorite-wrapper ";
    }
    
    
   

    if($display_favorites==''):
        if ($shortcode_arguments['type'] == 'properties') {
            $button .= '<div class="listinglink-wrapper_sh_listings">
               <span class="wpresidence_button wpestate_item_list_sh">'.esc_html__('load more listings','wpresidence-core').' </span>
               </div>';
        }else if ($shortcode_arguments['type'] == 'agents') {
            $button .= '<div class="listinglink-wrapper_sh_listings">
               <span class="wpresidence_button wpestate_item_list_sh">'.esc_html__('load agents','wpresidence-core').' </span>
               </div>';
        } else {
            $button .= '<div class="listinglink-wrapper_sh_listings">
               <span class="wpresidence_button wpestate_item_list_sh">  '.esc_html__('load articles','wpresidence-core').' </span>
               </div>';
             $class.=" blogs_wrapper ";
        }
    endif;

    $category = $shortcode_arguments['category'];
    $action   = $shortcode_arguments['action'];
    $city     = $shortcode_arguments['city'];
    $area     = $shortcode_arguments['area'];
    $state    = $shortcode_arguments['state'];
    $status   = $shortcode_arguments['status'];
    
    $features='';
    if(isset($shortcode_arguments['features'])){
        $features = $shortcode_arguments['features'];
    }
    if($category!=''){
        $category.=',';
    }
    if($action!=''){
        $action.=',';
    }
    if($city!=''){
        $city.=',';
    }
    if($area!=''){
        $area.=',';
    }
    if($state!=''){
        $state.=',';
    }

    if($status!=''){
        $status.=',';
    }
    if($features!=''){
        $features.=',';
    }  
    if( isset($attributes['display_grid'])){
        $display_grid=$attributes['display_grid'];
    }
    if($display_grid=='yes'){
        $class.=' article_container_grid';
    }

    $anime_id='wpestate_sh_anime_'.rand(1,999);
    $return_string .= '<div id="'.$anime_id.'" class="article_container ddccdc wpestate_anime wpestate_latest_listings_sh bottom-'.$type.' '.$class.'"  '
            . 'data-type="'.$type.'" '
            . 'data-category_ids="'.$category.'" '
            . 'data-action_ids="'.$action.'" '
            . 'data-city_ids="'.$city.'" '
            . 'data-area_ids="'.$area.'" '
            . 'data-state_ids="'.$state.'" '
            . 'data-status_ids="'.$status.'" '
            . 'data-features_ids="'.$features.'" '
            . 'data-number="'.$shortcode_arguments['number'].'" '
            . 'data-row-number="'.$shortcode_arguments['row_number'].'" '
            . 'data-card-version="'.$shortcode_arguments['card_version'].'" '
            . 'data-align="';
    if(isset($shortcode_arguments['align'])){
        $return_string.=$shortcode_arguments['align'];
    }
    $return_string.='" '
            . 'data-show_featured_only="'.$shortcode_arguments['show_featured_only'].'"  '
            . 'data-random_pick="'.$shortcode_arguments['random_pick'].'"  '
            . 'data-featured_first="'.$featured_first.'" '
            . 'data-sort-by="'.$shortcode_arguments['sort_by'].'"'
            . 'data-display-grid="'.$attributes['display_grid'].'"'
            . 'data-page="1" >';

    if($shortcode_arguments['title']!=''){
         $return_string .= '<h2 class="shortcode_title">'.$shortcode_arguments['title'].'</h2>';
    }

    
   
    
  
    

    if($shortcode_arguments['control_terms_id'] !=''){
        $control_taxonomy_array     =   explode (',',$shortcode_arguments['control_terms_id']);

        $return_string.='<div class="control_tax_wrapper">';
        foreach($control_taxonomy_array as $key=>$term_name){
            $term_data      =   get_term($term_name);
            if(isset($term_data->term_id)){
                $return_string .=   '<div  class="control_tax_sh" data-taxid="'.$term_data->term_id.'" data-taxonomy="'.$term_data->taxonomy.'">'.$term_data->name.'</div>';
            }
        }
        $return_string.='</div>';

    }
    
  

    if(isset($attributes['form_fields']) and is_array($attributes['form_fields'])  ){
        $return_string.='<div class="control_tax_wrapper">';
        foreach ( $attributes['form_fields'] as $key=>$field ){
            $term_data      =   get_term($field['field_type']);

            if(isset($term_data->term_id)){
                
                $is_item_active_class = wpestate_topbar_sh_is_item_active($attributes,$term_data->term_id);
                
                $return_string .=   '<div  class="control_tax_sh '.esc_attr($is_item_active_class).'" data-taxid="'.$term_data->term_id.'" data-taxonomy="'.$term_data->taxonomy.'">';
                
                if(isset($field['icon']) && $field['icon']!=''){
                    ob_start();
                    \Elementor\Icons_Manager::render_icon( $field['icon'], [ 'aria-hidden' => 'true' ] );
                    $item_icon= ob_get_contents();
                    ob_end_clean();
                    $return_string .= $item_icon;
                }
                
                $return_string .=   $field['field_label'].'</div>';
            }
        }
        $return_string.='</div>';
    }
    
    
  
    $full_row='';
    if($display_grid=='yes'){
            $return_string.= '<div class="items_shortcode_wrapper_grid"> ';
            $row_number='x';
            $rownumber='x';
            $row_number_col='x';
            $wpestate_row_number_col='x';
    }else{
            
        $return_string.= '<div class="items_shortcode_wrapper';
          if($full_row==='yes'){
              $return_string.= ' items_shortcode_wrapper_full ';
          }
          $return_string.='  ">';
    
    }
    $transient_name= 'wpestate_recent_posts_pictures_query_' . $type . '_' . $category . '_' . $action . '_' . $city . '_' . $area.'_'.$state.'_'.$shortcode_arguments['row_number'].'_'.$shortcode_arguments['number'].'_'.$featured_first;
       if(isset($shortcode_arguments['align'])){
           $transient_name.='_'.$shortcode_arguments['align'];
       }
    
    $transient_name.='_'.$shortcode_arguments['random_pick'];
    $transient_name=wpestate_add_global_details_transient($transient_name);

    $templates=false;
    if(function_exists('wpestate_request_transient_cache')){
        $templates = wpestate_request_transient_cache( $transient_name);
    }





    if( $templates === false || $random_pick=='yes' || $display_favorites=='yes') {

        if ( $shortcode_arguments['type'] == 'properties' && $display_favorites=='' ) {
              $recent_posts =wpestate_return_filtered_query($args,$featured_first );
        }else{
            $recent_posts = new WP_Query($args);
        }

        
 
        
        $count = 1;
        $unit_counter=1;
        $blog_unit                   =   wpestate_blog_unit_selector(); 
        $agent_unit                   =   wpestate_agent_card_selector(); 
        ob_start();

     
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            if($display_grid=='yes'){
                print '<div class="shortcode_wrapper_grid_item shortcode_wrapper_grid_item">';
                $unit_counter++;
            }
        
                if($type == 'estate_property'){
                    include( locate_template('templates/property_unit'.$property_card_type_string.'.php') );
                }else if($type=='agents'){
                    include( locate_template($agent_unit) ) ;
                }else {
                    include( locate_template($blog_unit) ) ;
                }

            if($display_grid=='yes'){
                print '  </div>';
            }
        
        endwhile;
         print '</div>';// end grod wrapper
        if( !$recent_posts->have_posts() && $display_favorites=='yes' ){
            print '<h4 class="wpestate_no_favorites">'.esc_html__('You don\'t have any favorite properties yet!','wpresidence').'</h4>';
        }
        

        $templates = ob_get_contents();
        ob_end_clean();
        if($orderby!=='rand'){
            if(function_exists('wpestate_set_transient_cache')){
                wpestate_set_transient_cache( $transient_name,wpestate_html_compress( $templates ), 60*60*4 );
            }
        }
    }


    $return_string .=$templates;
    $return_string.='<div class="wpestate_listing_sh_loader">
       <div class="new_prelader"></div>
    </div>';
    $return_string .=$button;
    $return_string .= '</div>';



    wp_reset_query();
    $is_shortcode       =   0;
    return $return_string;


}
endif; // end   wpestate_recent_posts_pictures





function wpestate_topbar_sh_is_item_active($attributes,$term_id){
    $return_class   =   '';
    $term_id_string =   strval($term_id);
    
     
    
    if( 
        strpos(strval($attributes['category_ids']),$term_id_string) !== false ||
        strpos(strval($attributes['action_ids']),$term_id_string)   !== false ||
        strpos(strval($attributes['city_ids']),$term_id_string)     !== false ||
        strpos(strval($attributes['area_ids']),$term_id_string)     !== false ||
        strpos(strval($attributes['state_ids']),$term_id_string)    !== false ||
        strpos(strval($attributes['status_ids']),$term_id_string)   !== false ||
        strpos(strval($attributes['features_ids']),$term_id_string) !== false ){
     
        $return_class='tax_active';
        
    }
    
    return $return_class;
    
}