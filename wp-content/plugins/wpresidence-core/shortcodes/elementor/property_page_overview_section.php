<?php
function property_show_overview_section_function($attributes,$settings){

 

  $property_id            =   wpestate_return_property_id_elementor_builder($attributes);
  $property_size          =   wpestate_get_converted_measure( $property_id, 'property_size' );
  $property_bedrooms      =   get_post_meta($property_id,'property_bedrooms',true);
  $property_bathrooms     =   get_post_meta($property_id,'property_bathrooms',true);
  $property_rooms         =   get_post_meta($property_id,'property_rooms',true);
  $property_year          =   get_post_meta($property_id,'property-year',true);
  $property_garage        =   get_post_meta($property_id,'property-garage',true);

  $default_svg=array(
    'property_bedrooms'=>'single_bedrooms.html',
    'property_bathrooms'=>'single_bath.html',
    'property_size'=>'single_floor_plan.html',
    'property_year'=>'single_calendar.html',
    'property_garage'=>'single_garage.html',
    'property-garage'=>'single_garage.html',
  );

  ob_start();

  $section_title= esc_html__('Overview','wpresidence-core');

  if($settings['section_title']!==''){
    $section_title=$settings['section_title'];
  }


  ?>

  <div class="single-overview-section panel-group property-panel">
      <h4 class="panel-title" id=""><?php echo esc_html($section_title);?></h4>

      <ul class="overview_element overview_updatd_on">
          <li class="first_overview">
              <?php esc_html_e('Updated On:','wpresidence-core'); ?>
          </li>
          <li class="first_overview_date"><?php print  get_the_modified_date('F j, Y',$property_id); ?></li>

      </ul>


      <?php
        $wpestate_currency      =   esc_html ( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency         =   esc_html ( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
       
        foreach ($settings['overview_fields'] as $key => $item) {

            $item_value= get_post_meta($property_id,$item['field_type'],true);
            if($item['field_type']=='property_size'){
                $item_value=wpestate_get_converted_measure( $property_id, 'property_size' );
            }else if( $item['field_type']=='property_lot_size' ){
                $item_value=wpestate_get_converted_measure( $property_id, 'property_lot_size' );
            }else if( $item['field_type']=='property_price' ){
                $price                  =   floatval ( get_post_meta($property_id, 'property_price', true) );
                $price_label            =   esc_html ( get_post_meta($property_id, 'property_label', true) );
                $price_label_before     =   esc_html ( get_post_meta($property_id, 'property_label_before', true) );
                $price = wpestate_show_price($property_id,$wpestate_currency,$where_currency,1);

                $item_value=$price;
            }else if( $item['field_type']=='property_id' ){
                  $item_value=$property_id;
            }else if( $item['field_type']=='property_year' ){
                $item_value= esc_html__('Year Built:','wpresidence-core').' '.esc_html(get_post_meta($property_id,'property-year',true));
            }else if( $item['field_type']=='property_status' ){
                $item_value  = get_the_term_list( $property_id, $item['field_type'], '', ', ', '');
            }else if( $item['field_type']=='property_city' || $item['field_type']=='property_area' || $item['field_type']=='property_county_state'  || $item['field_type']=='property_category'  || $item['field_type']=='property_action_category' ){
                  $item_value  =   get_the_term_list( $property_id, $item['field_type'], '', ', ', '');
            }



            $label=$item['label_plural'];
            
            
            
            if( (is_numeric($item_value) && $item_value==1) || $label=='' ){
              $label=$item['label_singular'];
            }

            print '<ul class="overview_element">';

              if($item['icon_type']!=='none'){
                print '<li class="first_overview">';
                  if($item['icon_type']=='theme_options'){
                    include ( locate_template('templates/svg_icons/'.$default_svg[$item['field_type']] ));
                  }
                  if($item['icon_type']=='custom'){
                    if ( $item['meta_icon']['library']  === 'svg'  ) {
                      print '<img src="'.$item['meta_icon']['value']['url'].'" alt="'.$item['field_type'].'">';
                    }else{
                      print '<i class="'.$item['meta_icon']['value'].'  "></i>';
                    }

                  }
                print '</li>';
              }

            print  '<li>'. ($item_value).' '.$label.'</li>';
            print '</ul>';
        }
      ?>






  </div>
  <?php
  $templates=ob_get_contents();
  ob_end_clean();
  print $templates;

}
?>
