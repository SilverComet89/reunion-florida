<?php
if( !function_exists('wpestate_clear_cache_theme') ):
function wpestate_clear_cache_theme() {  
    wpestate_delete_cache();
    print'<div class="wrap wpresidence_clear_cache">'.esc_html__('Cache was cleared','wpresidence').'</div>';
    exit();
}
endif;



if( !function_exists('wpestate_check_google_maps_avalability') ):
    function wpestate_check_google_maps_avalability($header_type,$global_header_type,$postid=''){
        $header_type        =   intval($header_type);
        $global_header_type =   intval($global_header_type);
        $to_return          =   false; // no g maps
       
        global $post;
        $page_template='';
        if(isset($post->ID)){
           $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
        }
      
        if( $page_template=='splash_page.php' ){
            $to_return          =   false;
        }else if(  is_tax() ){
            if( wpestate_check_google_map_tax()  ){  
                $to_return  =   false;
            }else{
          
                $to_return  =   true;
            }
            
        }else if( $header_type==5 ||                                      // if local header type 
                ( $header_type==0 
                    && $global_header_type==4 
                    && $page_template!=='user_dashboard_add_adgent.php' 
                    && $page_template!=='user_dashboard_analytics.php'  
                    && $page_template!=='user_dashboard_agent_list.php'  
                    && $page_template!=='user_dashboard_favorite.php'  
                    && $page_template!=='user_dashboard_inbox.php'  
                    && $page_template!=='user_dashboard_invoices.php'
                    && $page_template!=='user_dashboard_searches.php' )  ||        //  if  local is set to global and global is google
                $page_template=='user_dashboard_add.php' ||           //  if add property page
               // $page_template=='front_property_submit.php' ||        //  if frint add property page
                $page_template=='user_dashboard_profile.php' ||       //  for cases when you are agengy
                $page_template=='property_list_half.php' ||           //  for half map 
                is_singular('estate_agency')  ||                        //  check if agency page
                is_singular('estate_developer')  ||                     //  check if developer page
                is_singular('estate_property')                           //  for cases when property page  
        ){
      
            $to_return=true; // we have g maps
        }else if($page_template=='front_property_submit.php'){

            $wpestate_submission_page_fields=   wpresidence_get_option('wp_estate_submission_page_fields','');
            if( in_array('property_map', $wpestate_submission_page_fields) ) {
                return true; // we have g maps
            }else if( wpresidence_get_option('wp_estate_enable_autocomplete','')=='yes'){
                return true; // we have g maps
            }


        }


        return $to_return;


    }
endif;




if( !function_exists('wpestate_check_google_map_tax') ):
    function wpestate_check_google_map_tax(){
        $tax_header = wpresidence_get_option('wp_estate_header_type_taxonomy','');
        
        if(is_tax() && $tax_header==4 ){
            return false;
        }
        
        if( is_tax() &&  intval(wpresidence_get_option('wp_estate_property_list_type','') )==1  ){
        
          
            $taxonmy    =   get_query_var('taxonomy');
            if( $taxonmy == 'property_category' || 
                $taxonmy == 'property_action_category' || 
                $taxonmy == 'property_city' || 
                $taxonmy == 'property_area' ||
                $taxonmy == 'property_county_state'){
                   
                    $term       =   get_query_var( 'term' );
                    $term_data  =   get_term_by('slug', $term, $taxonmy);
                    $place_id   =   $term_data->term_id;
                    $term_meta  =   get_option( "taxonomy_$place_id");
              

                    if( isset($term_meta['category_featured_image']) && $term_meta['category_featured_image']!=''){
                       return true;// no google map
                    }
            }
        }

       return false;
    }
endif;


