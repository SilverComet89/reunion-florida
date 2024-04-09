<?php
/*
*
* User for grid elementor widget only
*
*/

$col_class                      =   'col-md-6';
$col_org                        =   4;

if (isset($is_shortcode) && $is_shortcode==1) {
    $col_class='col-md-'.esc_attr($row_number_col).' shortcode-col';
}

if (isset($is_widget) && $is_widget==1) {
    $col_class='col-md-12';
    $col_org    =   12;
}


$place_id                       =   intval($place_id);
$category_attach_id             =   '';
$category_featured_image        =   '';
$category_featured_image_url    =   '';
$category_tagline               =   '';
$term_meta                      =   get_option( "taxonomy_$place_id");


if(isset($term_meta['category_featured_image'])){
    $category_featured_image=$term_meta['category_featured_image'];
}

if(isset($term_meta['category_attach_id'])){
    $category_attach_id=$term_meta['category_attach_id'];
    $category_tagline = $term_meta['category_tagline'];
    $category_featured_image= wp_get_attachment_image_src( $category_attach_id, 'property_full');
    $category_featured_image_url='';
    if(isset($category_featured_image[0])){
        $category_featured_image_url = $category_featured_image[0];
    }
}

$category_name='';
$category_count=0;
$category_tax='';
$term_link='';
if (isset($term_meta['category_tax'])) {
    $category_tax=$term_meta['category_tax'];
    $term= get_term($place_id, $category_tax);
    $category_name=$term->name;
    $category_count=$term->count;
    $category_description = $term->description;
}




$term_link =  get_term_link( $place_id, $category_tax );
if ( is_wp_error( $term_link ) ) {
    $term_link='';
}

$inline_style=" background-image: url(".esc_attr($category_featured_image_url).");";
if($category_featured_image_url==''){
  $inline_style=" background-color: #ddd;";
}


if(isset($clear_col_size)&&$clear_col_size==1){
    $col_class='';
}


?>
<div class="<?php echo esc_html($col_class);?>  " >
    <div class="places_wrapper_type_3 elementor_places_wrapper" style="<?php echo trim($inline_style); ?>">
        <div class="places_cover" data-link="<?php echo esc_attr($term_link);?>" ></div>
    </div>

    <div class="places_type_3_content"  >
        <h4><a href="<?php echo esc_url($term_link); ?>">
            <?php
                echo mb_substr( $category_name,0,44);
                if(mb_strlen($category_name)>44){
                    echo '...';
                }
            ?>
            </a>
        </h4>

        <div class="places_type_3_tagline">
            <?php //print esc_html($category_tagline);?>
        </div>

        <div class="places_type_3_listings_no">
            <?php 
                printf(  _n('%d listing', '%d listings', $category_count, 'wpresidence'), $category_count );
            ?>
        </div>

    </div>
</div>