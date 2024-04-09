<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://mlsimport.com/
 * @since      1.0.0
 *
 * @package    Mlsimport
 * @subpackage Mlsimport/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mlsimport
 * @subpackage Mlsimport/admin
 * @author     MlsImport <office@mlsimport.com>
 */
class Mlsimport_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
    public $main;
    public $theme_importer;
    public $env_data;
    public $mls_env_data;
    protected $process_all;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    
        $this->field_import = array(
            'City',
            'CountyOrParish',
            'MlsStatus',
            'PropertySubType',
            'PropertyType',
            'StandardStatus',
            'InternetEntireListingDisplayYN',
            'InternetAddressDisplayYN'
        );
        
        $this->themes=array(
            991 =>  'WpResidence',
            992 =>  'Houzez',
            993 =>  'RealHomes',
            994 =>  'Wpestate'
        );
    }
    /**
     * 
     * 
     * 
     * Admin Setup
     *
     * @since    1.0.0
     * 
     * 
     * 
     * 
     */
    public function admin_setup($plugin_name, $mls_enviroment, $theme_enviroment) {

        $options    =   get_option($this->plugin_name.'_admin_options');
        $theme_id   =   0;
        if(isset($options['mlsimport_theme_used'])){
            $theme_id   =   intval($options['mlsimport_theme_used']);
        }
        $themes     =   $this->themes;
        
        $theme_enviroment='';
        if( isset( $themes[$theme_id])){
            $theme_enviroment = $themes[$theme_id];
        }
        
        $this->theme_importer   = new ThemeImport($plugin_name);
     

        $options_api            = get_option($this->plugin_name . '_admin_options');

        if ($theme_enviroment != '') {
            $classname = $theme_enviroment . 'Class';
            $this->env_data = new $classname;
        } else {
            $this->env_data = new stdClass();
        }

        if ($mls_enviroment != '') {
            $mls_classname = $mls_enviroment . 'Class';
          
            $this->mls_env_data = new $mls_classname($this->theme_importer);
        } else {
            $this->mls_env_data = new stdClass();
        }
    }

    /**
     * 
     * 
     * 
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     * 
     * 
     * 
     * 
     */
    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mlsimport-admin.css', array(), $this->version, 'all');
    }

    
    
    
    /**
     * 
     * 
     * 
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     * 
     * 
     * 
     */
    public function enqueue_scripts() {
        wp_enqueue_script("jquery-ui-autocomplete");
          
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mlsimport-admin.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'mlsimport_vars', array('ajax_url' => admin_url('admin-ajax.php'),
                )
        );
    }
    
    
    
    

    /**
     * 
     * 
     * 
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     * 
     * 
     * 
     * 
     */
    public function add_plugin_admin_menu() {
        add_menu_page(
                __('MLS Import Settings', $this->plugin_name),
                __('MLS Import Settings', $this->plugin_name), 
                'administrator', 
                'mlsimport_plugin_options',
                array($this, 'display_plugin_setup_page'),
                MLSIMPORT_PLUGIN_URL.'/img/mlsimport_menu.png',
                22);
    }

    
    
    
    
    
    
    
    /**
     * 
     * 
     * 
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     * 
     * 
     * 
     */
    public function add_action_links($links) {
        $settings_link = array(
            '<a href="' . admin_url('admin.php?page=mlsimport_plugin_options') . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    
    
    
    
    
    
    
    /**
     * 
     * 
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     * 
     * 
     */
    public function display_plugin_setup_page() {
        include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );
    }

    
    
    
    
    
    /**
     * 
     * 
     * Validate plugin options fields
     *
     * @since    1.0.0
     * 
     * 
     * 
     */
    public function validate_admin_options($input) {

        $valid = array();
        $settings_list = array(
            'auth_username' => array(
                'name' => esc_html__('Api auth_username ', $this->plugin_name),
                'details' => 'to be added',
            ),
            'auth_password' => array(
                'name' => esc_html__('Api auth_password', $this->plugin_name),
                'details' => 'to be added',
            ),
            'client_id' => array(
                'name' => esc_html__('Api client_id', $this->plugin_name),
                'details' => 'to be added',
            ),
            'client_secret' => array(
                'name' => esc_html__('client_secret', $this->plugin_name),
                'details' => 'to be added',
            ),
            'redirect_uri' => array(
                'name' => esc_html__('redirect_uri', $this->plugin_name),
                'details' => 'to be added',
            ),
            'title_format' => array(
                'name' => esc_html__('title_format', $this->plugin_name),
                'details' => 'to be added',
            ),
            'force_rand' => array(
                'name' => esc_html__('title_format', $this->plugin_name),
                'details' => 'to be added',
            ),
            'mlsimport_username' => array(
                'name' => esc_html__('MLSImport Username', $this->plugin_name),
                'details' => 'to be added',
            ),
            'mlsimport_password' => array(
                'name' => esc_html__('MLSImport Password', $this->plugin_name),
                'details' => 'to be added',
            ),
             'mlsimport_mls_name' => array(
                'name' => esc_html__('MLSImport Name', $this->plugin_name),
                'details' => 'to be added',
            ),
            'mlsimport_mls_token' => array(
                'name' => esc_html__('MLSImport Token', $this->plugin_name),
                'details' => 'to be added',
            ),
            
            'mlsimport_tresle_client_id' => array(
                'name' => esc_html__('MLSImport Tresle Client id', $this->plugin_name),
                'details' => 'to be added',
            ),
            
            'mlsimport_tresle_client_secret' => array(
                'name' => esc_html__('MLSImport Client Secret', $this->plugin_name),
                'details' => 'to be added',
            ),

            
        
             
            'mlsimport_rapattoni_client_id' => array(
                'name' => esc_html__('MLSImport Rapattoni Client id', $this->plugin_name),
                'details' => 'to be added',
            ),
            
            'mlsimport_rapattoni_client_secret' => array(
                'name' => esc_html__('MLSImport Rapattoni Secret', $this->plugin_name),
                'details' => 'to be added',
            ),
            
            'mlsimport_rapattoni_username' => array(
                'name' => esc_html__('MLSImport Rapattoni Username', $this->plugin_name),
                'details' => 'to be added',
            ),
            
            'mlsimport_rapattoni_password' => array(
                'name' => esc_html__('MLSImport Rapattoni Password', $this->plugin_name),
                'details' => 'to be added',
            ),








            'mlsimport_theme_used'=>array(
                            'name'      =>  esc_html__( 'Your Wordpress Theme', $this->plugin_name ),
                            'details'   =>  'to be added', 
                        ),
            'mlsimport_mls_name_front'=>array(
                            'name'      =>  '',
                            'details'   =>  'to be added', 
                        ),
              'mlsimport-disable-logs'=>array(
                            'name'      =>  '',
                            'details'   =>  'to be added', 
                        ),
        );

        foreach ($settings_list as $key => $setting) {
            $valid[$key] = ( isset($input[$key]) && !empty($input[$key]) ) ? esc_attr($input[$key]) : '';
        }
        
        delete_option('mlsimport_connection_test');
        delete_option('mlsimport_mls_metadata_populated');
 
        update_option('mlsimport_encoding_array', '');
        delete_transient('mlsimport_token_request');
        delete_transient('mlsimport_schema');
        delete_transient('mlsimport_plugin_data_schema');

        delete_transient('mlsimport_saas_token');
        return $valid;
    }

    
    
    
    
    /**
     * 
     * 
     * Validate admin fields
     *
     * @since    1.0.0
     * 
     * 
     * 
     */
    public function validate_admin_fields_select($input) {
        $valid = array();


     
        $mlsimport_mls_metadata_mls_data       =    get_option('mlsimport_mls_metadata_mls_data','' );
        $metadata_api_call       =    json_decode($mlsimport_mls_metadata_mls_data,true);
        
        foreach ($metadata_api_call as $key => $value) {
            if (isset($input['mls-fields'][$key])) {
                $valid['mls-fields'][$key] = esc_attr($input['mls-fields'][$key]);
            }

            if (isset($input['mls-fields-admin'][$key])) {
                $valid['mls-fields-admin'][$key] = esc_attr($input['mls-fields-admin'][$key]);
                $valid['mls-fields-label'][$key] = esc_attr($input['mls-fields-label'][$key]);
            }
        }
        $valid['mls-fields-admin']['force_rand'] = esc_attr($input['mls-fields-admin']['force_rand']);
        return $valid;
    }

    /**
     * 
     * 
     * Validate Mls Sync fields
     *
     * @since    1.0.0
     * 
     * 
     * 
     */
    public function validate_admin_mls_sync($input) {
        $valid = array();

        $field_import = array('force_rand', 'min_price', 'max_price', 'title_format', 'property_agent', 'property_user', 'City', 'City_check', 'CountyOrParish', 'CountyOrParish_check', 'MlsStatus', 'MlsStatus_check', 'PropertySubType', 'PropertySubType_check', 'PropertyType', 'PropertyType_check', 'StandardStatus', 'StandardStatus_check', 'InternetEntireListingDisplayYN', 'InternetAddressDisplayYN');
        foreach ($field_import as $key) {
            $valid[$key] = $input[$key];
        }

        return $valid;
    }

    
     /**
     * 
     * 
     * Validate Administrative options
     *
     * @since    1.0.0
     * 
     * 
     * 
     */
    
    public function validate_administrative_options($input) {


        $valid = array();

        $field_import = array('import');
        foreach ($field_import as $key) {
            $valid[$key] = $input[$key];
        }


        return $valid;
    }

    /**
     * 
     * 
     * 
     * Validate Import Options fields
     *
     * @since    1.0.0
     * 
     * 
     * 
     */
    public function validate_admin_import_options($input) {
        $valid = array();

        $field_import = array('import_number');
        foreach ($field_import as $key) {
            $valid[$key] = intval($input[$key]);
        }

        if (isset($input['import']) && $input['import'] != '') {
            $decode = json_decode($input['import']);
            update_option('mlsimport_admin_fields_select', $decode['mlsimport_admin_fields_select']);
            update_option('mlsimport_admin_mls_sync', $decode['mlsimport_admin_mls_sync']);
            update_option('mlsimport_admin_import_options', $decode['mlsimport_admin_import_options']);
            update_option('mlsimport_admin_use_transients', $decode['mlsimport_admin_use_transients']);
        }


        return $valid;
    }
    
    
    
    
    

    /**
     * 
     * 
     * plugin options update
     * 
     * 
     * 
     * 
     */
    public function options_update() {
        register_setting($this->plugin_name . '_admin_options', $this->plugin_name . '_admin_options', array($this, 'validate_admin_options'));
        register_setting($this->plugin_name . '_admin_fields_select', $this->plugin_name . '_admin_fields_select', array($this, 'validate_admin_fields_select'));
        register_setting($this->plugin_name . '_admin_mls_sync', $this->plugin_name . '_admin_mls_sync', array($this, 'validate_admin_mls_sync'));
        register_setting($this->plugin_name . '_admin_import_options', $this->plugin_name . '_admin_import_options', array($this, 'validate_admin_import_options'));
        register_setting($this->plugin_name . '_administrative_options', $this->plugin_name . '_administrative_options', array($this, 'validate_administrative_options'));
    }



    /**
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */

    public function update_option_mlsimport_administrative_options() {
        $import = get_option('mlsimport_administrative_options');
        if ($import != '') {
            $decode = json_decode($import['import'], true);
            update_option('mlsimport_admin_fields_select', $decode['mlsimport_admin_fields_select']);
            update_option('mlsimport_admin_mls_sync', $decode['mlsimport_admin_mls_sync']);
            update_option('mlsimport_admin_import_options', $decode['mlsimport_admin_import_options']);
        }
    }

    /**
     * 
     * 
     * plugin options update
     * 
     * 
     */
    public function update_option_mlsimport_admin_fields_select() {
        $this->env_data->enviroment_custom_fields($this->plugin_name);
      
    }

    
    /**
     * 
     * 
     * plugin options update
     * 
     * 
     */
    public function mlsimport_meta_options() {
        if (method_exists($this->env_data, 'get_property_post_type')) {
            add_meta_box('mlsimport_hidden_fields', esc_html__('Mls Import Hidden Fields', $this->plugin_name), array($this, 'mlsimport_hidden_fields'), $this->env_data->get_property_post_type(), 'normal', 'low');
        }
    }

    /**
     * 
     * 
     * plugin options update
     * 
     * 
     */
    public function mlsimport_hidden_fields() {
        global $post;
        $options = get_option($this->plugin_name . '_admin_fields_select');


        foreach ($options['mls-fields-admin'] as $key => $value) {
            if ($options['mls-fields-admin'][$key] == 1) {
                 
                if( isset($options['mls-fields-label'][$key]) && $options['mls-fields-label'][$key]!='') {
                    $key=$options['mls-fields-label'][$key];
                }


                if($key!='ListingKey'){
                    $meta_key=strtolower($key);
                }else{
                    $meta_key=$key;
                }
                
                print '<strong>' . $key . ': </strong>' . get_post_meta($post->ID, $meta_key, true) . '</br>';
            }
        }
        print '<h2 style="font-weight:bold;padding-left:0px;">Mls Import History</h2>';
        $meta=get_post_meta($post->ID,'mlsimport_property_history',true);
        if(trim($meta)==''){
            print ' <strong>Property history is blank - you can enable it in Settings/ Tools page </strong>';
        }else{
            print $meta;
        }
    }

 


    /**
     * delete cache
     * 
     */
    function mlsimport_delete_cache() {

        delete_transient('mlsimport_token_request');
        delete_transient('metadata_api_call_data_service_property');
        delete_transient('mls_import_meta_enums');
        delete_transient('mls_import_meta');
        delete_transient('mlsimport_plugin_data_schema');
        delete_transient('ready_to_go_mlsimport_data');
        delete_transient('mlsimport_saas_token');
        
        delete_option('mlsimport_mls_metadata_populated');
        die('deleted');
    }

    /**
     * 
     * 
     * 
     * 
     * delete properties
     * 
     * 
     * 
     * 
     * 
     */
    function mlsimport_delete_properties() {
        $error=false;
        global $mlsimport;
        if( current_user_can('administrator')  ):
            $mlsimport_delete_category = sanitize_text_field($_POST['mlsimport_delete_category']);
            $mlsimport_delete_category_term = sanitize_title(sanitize_text_field($_POST['mlsimport_delete_category_term']));
            $mlsimport_delete_timeout = intval($_POST['mlsimport_delete_timeout']);

            if ($mlsimport_delete_category == '') {
                $error_message  =   'Category cannot be blank';
                $error          =   true;
            }

            if ($mlsimport_delete_category_term == '') {
                $error_message =  'Category Term cannot be blank';
                $error          =   true;
            }
            
            
            $category = get_term_by('slug', $mlsimport_delete_category_term, $mlsimport_delete_category);
            
            if($error){
                
                print json_encode(
                array(
                    'message'=>$error_message
                    )
                );  
                
            }else{    
                $mlsimport_delete_category_term_array = array();

                $mlsimport_delete_category_term_array[] = $mlsimport_delete_category_term;
                $tax_array = array(
                    'taxonomy' => $mlsimport_delete_category,
                    'field' => 'slug',
                    'terms' => $mlsimport_delete_category_term_array
                );

                $args = array(
                    'post_type' => array('estate_property','property'),
                    'post_status' => 'any',
                    'paged' => 1,
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        $tax_array,
                    ),
                    'fields' => 'ids'
                );

                $prop_selection = new WP_Query($args);
           
                foreach ($prop_selection->posts as $key => $delete_get_id) {

                    if ($mlsimport_delete_timeout != 0) {
                        set_timeout($mlsimport_delete_timeout);
                    }
                   
                    $mlsimport->admin->theme_importer->mlsimport_saas_delete_property_via_mysql($delete_get_id,' delete from tools ');
                
                }
                  
            wp_update_term_count_now(array($category->term_id),$mlsimport_delete_category);
            
            print json_encode(
                array(
                    '$category' =>  $category->term_id,
                    'arguments' =>  $args,
                    'posts'     =>  $prop_selection->posts,
                    'found'     =>   $prop_selection->found_posts,
                    'message'   =>  'Done...'
                    ));
            }

        endif;
        die();
    }

   

    
    /**
    *
    * 
    *  Testing enviroment variables
    *
    * 
    * 
    * 
    */
    

    public function mlsimport_saas_setting_up() {
     
        if ( intval(WP_MEMORY_LIMIT) < 256 ) {
             print '<div  class="mlsimport_warning long_warning">
                    <strong>WordPress Memory Limit</strong> is set to <strong>'.WP_MEMORY_LIMIT.'</strong>. Allocated Memory should be at least <strong>256MB</strong>. Please refer to: <a href="https://wordpress.org/support/article/editing-wp-config-php/#increasing-memory-allocated-to-php" target="_blank">Increasing memory allocated to PHP</a>
                </div>';
        }
        
        
        $max_input_vars=ini_get("max_input_vars");
        if($max_input_vars<2000 ) {
            print '<div class="mlsimport_warning long_warning">Your <strong>max_input_vars</strong> setting in php is set to <strong>'.$max_input_vars.'</strong>. When importing real estate listings from an MLS we work with a lot of data that needs to be saved. Please increase this value to at least <strong>2000</strong> or higher in order to save all details. Please refer to  <a href="https://themezly.com/docs/how-to-increase-the-max-input-vars-limit/" target="_blank">How to Increase the Max Input Vars Limit </a> </div>';
        }

        
        $max_time = ini_get("max_execution_time");
        if($max_time<600 && $max_time!=0 ){
            print '<div class="mlsimport_warning long_warning">Your <strong>max_execution_time</strong> setting in php is set to <strong>'.$max_time.'</strong>. Importing hundreds of listings requires extra time. Please set max_execution_time to <strong>0 (unlimited)</strong>. If that is not possible, set it to a minimum of <strong>600 (10 minutes)</strong>. </div>';
        }

    
    
       
    }

     /**
     * Check if token validates with MLS
     *
     * @since    4.0.1
     * returns token fron mlsimport
     */
    
    public function mlsimport_saas_check_mls_connection(){
       
    
        $values     =   array();
        $options    =   get_option($this->plugin_name . '_admin_options');
        
        $mls_id     =   '';
        if(isset($options['mlsimport_mls_name'])){
            $mls_id   = sanitize_text_field(trim($options['mlsimport_mls_name']) );
        }
        
        $mls_token  =   '';
        if(isset($options['mlsimport_mls_name'])){
            $mls_token  = sanitize_text_field( trim ($options['mlsimport_mls_token']) );
        }
        
        $mlsimport_tresle_client_id  =   '';
        if(isset($options['mlsimport_tresle_client_id'])){
            $mlsimport_tresle_client_id  = sanitize_text_field( trim( $options['mlsimport_tresle_client_id']) );
        }
        
        $mlsimport_tresle_client_secret  =   '';
        if(isset($options['mlsimport_tresle_client_secret'])){
            $mlsimport_tresle_client_secret  = sanitize_text_field( trim ($options['mlsimport_tresle_client_secret']) );
        }

        $mlsimport_rapattoni_client_id='';
        if(isset($options['mlsimport_rapattoni_client_id'])){
            $mlsimport_rapattoni_client_id  = sanitize_text_field( trim ($options['mlsimport_rapattoni_client_id']) );
        }
        $mlsimport_rapattoni_client_secret='';
        if(isset($options['mlsimport_rapattoni_client_secret'])){
            $mlsimport_rapattoni_client_secret  = sanitize_text_field( trim ($options['mlsimport_rapattoni_client_secret']) );
        }
        
        $mlsimport_rapattoni_username='';
        if(isset($options['mlsimport_rapattoni_username'])){
            $mlsimport_rapattoni_username  = sanitize_text_field( trim ($options['mlsimport_rapattoni_username']) );
        }

        $mlsimport_rapattoni_password='';
        if(isset($options['mlsimport_rapattoni_password'])){
            $mlsimport_rapattoni_password  = sanitize_text_field( trim ($options['mlsimport_rapattoni_password']) );
        }


        
        if (trim($mls_token) === '') {
            if (intval($mls_id) > 900 && intval($mls_id) < 3000) {
                if (trim($mlsimport_tresle_client_id) === '' || trim($mlsimport_tresle_client_secret) === '') {
                    return;
                }
            } elseif (intval($mls_id) >= 5000) {
                if (trim($mlsimport_rapattoni_client_id) === '' ||
                    trim($mlsimport_rapattoni_client_secret) === '' ||
                    trim($mlsimport_rapattoni_username) === '' ||
                    trim($mlsimport_rapattoni_password) === '') {
                    return;
                }
            }
        }


        $values['mls_token']                        =   $mls_token;
        $values['mls_id']                           =   $mls_id;
        $values['mlsimport_tresle_client_id']       =   $mlsimport_tresle_client_id;
        $values['mlsimport_tresle_client_secret']   =   $mlsimport_tresle_client_secret;

        $values['mlsimport_rapattoni_client_id']       =   $mlsimport_rapattoni_client_id;
        $values['mlsimport_rapattoni_client_secret']   =   $mlsimport_rapattoni_client_secret;
        $values['mlsimport_rapattoni_username']        =   $mlsimport_rapattoni_username;
        $values['mlsimport_rapattoni_password']        =   $mlsimport_rapattoni_password;
        

        $answer = $this->theme_importer->global_api_request_saas('clients', $values, "PATCH");
 
        
        if (isset($answer['succes']) && $answer['succes']==true ){
                if (isset($answer['tested']) && $answer['tested']==true ){
                    update_option('mlsimport_connection_test','yes');
                }else{
                    delete_option('mlsimport_connection_test');
                    delete_option('mlsimport_mls_metadata_populated');
                }
        }else{
            delete_option('mlsimport_connection_test');
            delete_option('mlsimport_mls_metadata_populated');
        }
        
        
        return $answer;
        
    }
    
    
    
    
    
    
    /**
     * Request auth token from mlsimport.net
     *
     * @since    4.0.1
     * returns token fron mlsimport
     */
    
    public function mlsimport_saas_get_mls_api_token_from_transient(){
      
        $token = get_transient('mlsimport_saas_token');

        if (false === $token || $token === '') {
          
            $token_json_answer = $this->mlsimport_saas_get_mls_api_token();
           
            if(isset($token_json_answer['succes']) && $token_json_answer['succes']===true ){
                $token = $token_json_answer['token'];
               
                set_transient('mlsimport_saas_token',$token, 6*60*60);
            }
        }

        return $token;
    }
    
    
    /**
     * call for token
     *
     * @since    4.0.1
     * returns token fron mlsimport
     */
    
    
    
    protected function mlsimport_saas_get_mls_api_token(){
        $values     =   array();
        $options    =   get_option($this->plugin_name . '_admin_options');
        
        $username   =   '';
        if(isset($options['mlsimport_username'])){
            $username   = sanitize_text_field (trim($options['mlsimport_username']));
        }
        
        $password   =   '';
        if(isset($options['mlsimport_password'])){
            $password   = sanitize_text_field (trim( $options['mlsimport_password']) );
        }
        $mls_name   =   '';
        if(isset($options['mlsimport_mls_name'])){
            $mls_name   = sanitize_text_field (trim( $options['mlsimport_mls_name']) );
        }
        
        $mls_token  =   '';
        if(isset($options['mlsimport_mls_token'])){
            $mls_token  = sanitize_text_field( trim( $options['mlsimport_mls_token']) );
        }
        
        $values['username']     =   $username;
        $values['password']     =   $password;

        if($username=='' || $password == ''){
            return '';
        }

    
        
        $theme_Start= new ThemeImport();
        $answer = $theme_Start::global_api_request_saas('token', $values, "POST");
        
        
        return $answer;
    }
    
    
   
    
    
    
    /**
     * save meta options
     *
     * @since    3.0.1
     * 
     * 
     * 
     * 
     */
    public function mlsimport_item_product_metaboxes() {
        add_meta_box('mlsimport_item_metaboxes-sectionid', __('Set Import data', 'wpstream'), array($this, 'mlsimport_saas_display_meta_options'), 'mlsimport_item', 'normal', 'default');
    }

    
    
    /**
     * 
     * 
     * 
     * save meta options
     *
     * @since    3.0.1
     * 
     * 
     * 
     */
    public function mlsimport_item_product_save_metaboxes($post_id, $post) {

        if (!is_object($post) || !isset($post->post_type)) {
            return;
        }

        if ($post->post_type != 'mlsimport_item') {
            return;
        }


        $allowed_keys = array(
            'mlsimport_item_how_many',
            'mlsimport_item_title_format',
            'mlsimport_item_agent',
            'mlsimport_item_property_status',
            'mlsimport_item_property_user',
            'mlsimport_item_min_price',
            'mlsimport_item_max_price',
            'mlsimport_item_city_check',
            'mlsimport_item_city',
            'mlsimport_item_city[]',
            'mlsimport_item_countyorparish_check',
            'mlsimport_item_countyorparish',
            'mlsimport_item_mlsstatus_check',
            'mlsimport_item_mlsstatus',
            'mlsimport_item_propertysubtype_check',
            'mlsimport_item_propertysubtype',
            'mlsimport_item_propertytype_check',
            'mlsimport_item_propertytype',
            'mlsimport_item_standardstatus_check',
            'mlsimport_item_standardstatus',
            'mlsimport_item_internetentirelistingdisplayyn',
            'mlsimport_item_internetaddressdisplayyn',
            'mlsimport_item_stat_cron',
            'mlsimport_item_listagentkey',
            'mlsimport_item_listagentmlsid',
            'mlsimport_item_listofficekey',
            'mlsimport_item_postalcode',
            'mlsimport_item_listofficemlsid',
        );


        foreach ($_POST as $key => $value) {

            if (in_array($key, $allowed_keys)) {
                $postmeta = ( $value );
                update_post_meta($post_id, sanitize_key($key), $postmeta);
            }
        }

        
        $blank_keys = array(
            'mlsimport_item_standardstatus',
            'mlsimport_item_city',
            'mlsimport_item_countyorparish',
            'mlsimport_item_propertysubtype',
            'mlsimport_item_propertytype',
            'mlsimport_item_standardstatus'
            
        );
        
        foreach ($blank_keys as $key){
            if( !isset($_POST[$key]) ){
                update_post_meta($post_id, $key, '');
            }
        }
        
        
        
        $mlsimport_item_stat_cron = intval(get_post_meta($post_id, 'mlsimport_item_stat_cron', true));
        if ($mlsimport_item_stat_cron == 1) {
           // print 'we should cron';
            
          //  $this->mlsimport_saas_start_cron_links_per_item( $post_id);
        } else {
            
        }

        //die();
    }
    
    
    

    /**
     * 
     * 
     *  Display Meta options
     * 
     * 
     * 
     */
    public function mlsimport_saas_display_meta_options($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'estate_agent_noncename');
        global $post;
        global $mlsimport;
        $token = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();


        $post_id                    =   $post->ID;     
        $search_url                 =   '';       
        $search_filter              =   '';
        $cron_links                 =   '';
        $found_items                =   'none';
        $mlsimport_item_how_many    =   esc_html(get_post_meta($post_id, 'mlsimport_item_how_many', true));
        $mlsimport_item_stat_cron   =   esc_html(get_post_meta($post_id, 'mlsimport_item_stat_cron', true));
        $last_date                  =   get_post_meta($post_id, 'mlsimport_last_date', true);
        $status                     =   get_option('mlsimport_force_stop_' . $post_id);
        $field_import               =   $this->mlsimport_saas_return_mls_fields();
      
      

        $mlsrequest= $this->mlsimport_make_listing_requests($post_id);


        if(isset($mlsrequest['success']) && !$mlsrequest['success']){
            print '<div class="mlsimport_warning">'.esc_html($mlsrequest['message']).'</div>';
        }

       
        //print_r($mlsrequest['api_meta_url']); 
        //    print_r($mlsrequest);


        if( isset($mlsrequest['results']) ){
            $found_items = intval($mlsrequest['results']);
        }else{
           // delete_transient('mlsimport_saas_token');
            $mlsimport->admin->mlsimport_saas_check_mls_connection(); 
            print ' Your Token was expired. Please refresh the page to renew it wait while we renew it.';
    
        }




        
 
        
        print '<div class="mlsimport_item_search_url" style="display:xnone;">Last date/time we check : ' . $last_date . ' </div>';
        
        print '<ul>
                    <li>1. Set the import parameters.</li>
                    <li>2. Hit Publish or Update, otherwise import will not work correctly.</li>
                    <li>3. Click the Start Import button. Most MLS limit the import number to 1000. If you need to import more create additional import items.</li>
                    <li>4. Press the Update button after you make any change in the import settings.</li>
                    
                </ul>';


     

        if( is_numeric($found_items) and $found_items>=500){
            print '<div class="mlsimport_notification">'.esc_html__('You found a large number of listings. While MlsImport import can handle such a large number, you need to make sure that your server can do this operation. This import will take some time. Make sure your server has the capacity, there are no time limits for a long-running process and consider spliting the import betwen multimple MLS Import items.','mlsimport').'</div>';
        } 
                
        print '<div class="mlsimport_import_no">We found <strong>' . $found_items . '</strong> listings. If you decide to import all of them make sure your server database can handle the load. Please do a database backup before initial import.</div>';

        
        print'
                <fieldset class="mlsimport-fieldset">
                <label class="mlsimport-label" for="mlsimport_item_how_many" >
                    ' . esc_html_e('How Many to import. Use 0 if you want to import all listings found.', 'mlsimport') . '
                </label>
                <input type="text" class="" id="mlsimport_item_how_many" name="mlsimport_item_how_many" 
                value="' . $mlsimport_item_how_many . '"/>
                </fieldset> ';


        print '
                <fieldset class="mlsimport-fieldset mlsimport_auto_switch">
                    <label class="mlsimport_switch"> ' . esc_html_e('Enable Auto Update every hour?', 'mlsimport') . '
                        <input type="hidden" class="" value="0" name="mlsimport_item_stat_cron">
                        <input type="checkbox" class="" value="1" name="mlsimport_item_stat_cron"';

        if (intval($mlsimport_item_stat_cron) !== 0) {
            print ' checked ';
        }

        print '> 
                        <span class="slider round"></span>
                    </label>
                </fieldset>';


        if ($mlsimport_item_stat_cron != '') {
            print '<div id="mlsimport_item_status" ></div>';
            
            print '<input class="button mlsimport_button" type="button" id="mlsimport-start_item" data-post-number="'.intval($found_items). '" data-post_id="' . intval($post_id) . '" value="Start Import">';
            print '<input class="button mlsimport_button" type="button" id="mlsimport_stop_item" data-post-number="'.intval($found_items). '" data-post_id="' . intval($post_id) . '" value="Stop Import">';
        }

      



        print '<div class="mlsimport_param_wrapper"><h2>Import Parameters</h2>';

        $mlsimport_item_title_format = esc_html(get_post_meta($post_id, 'mlsimport_item_title_format', true));
        print'
        <fieldset class="mlsimport-fieldset">
            <label class="mlsimport-label" for="mlsimport_item_title_format" >
                ' . esc_html__('Title Format', 'mlsimport') . '
            </label>
            
            <p class="mlsimport-exp">You can use {Address}, {City}, {CountyOrParish}, {StateOrProvince}, {PostalCode}, {PropertyType}, {Bedrooms}, {Bathrooms}, {ListingKey} or {ListingId}</p>
            <input type="text" class="" id="mlsimport_item_title_format" name="mlsimport_item_title_format" 
                value="';
                    if ($mlsimport_item_title_format != '') {
                        echo trim($mlsimport_item_title_format);
                    } else {
                        echo '{Address},{City},{CountyOrParish},{PropertyType}';
                    }
        print '"/>
        </fieldset> ';


        
        
        
        
        

        $mlsimport_item_agent = esc_html(get_post_meta($post_id, 'mlsimport_item_agent', true));
        print'
        <fieldset class="mlsimport-fieldset">
            <label  class="mlsimport-label"  for="mlsimport_item_agent" >
                ' . esc_html__('Select Agent', 'mlsimport') . '
            </label>
            <select class="mlsimport-select" name="mlsimport_item_agent" id="mlsimport_item_agent">
                ' . $this->theme_importer->mlsimport_saas_theme_import_select_agent($mlsimport_item_agent) . '
            </select>
        </fieldset>';


        
        $mlsimport_item_property_status = esc_html(get_post_meta($post_id, 'mlsimport_item_property_status', true));
        if($mlsimport_item_property_status=='') $mlsimport_item_property_status='publish';
        $status_array=array('publish','draft');
        print'
            <fieldset class="mlsimport-fieldset">
                <label  class="mlsimport-label"  for="mlsimport_item_property_status" >
                    ' . esc_html__('Select Property Status on import', 'mlsimport') . '
                </label>
                <select class="mlsimport-select" name="mlsimport_item_property_status" id="mlsimport_item_property_status">';
                  foreach($status_array as $value){
                       print'<option value="'.$value.'" ';
                       if($value===$mlsimport_item_property_status){
                           print' selected ';
                       }
                       print '>'.$value.'</option>';       
                  }

               print' </select>
            </fieldset>';
               
               
               
               

        $mlsimport_item_property_user = esc_html(get_post_meta($post_id, 'mlsimport_item_property_user', true));
        print '
            <fieldset class="mlsimport-fieldset">
                    <label  class="mlsimport-label"  for="mlsimport_item_property_user" >
                       ' . esc_html__('User', 'mlsimport') . '
                    </label>
                    <select class="mlsimport-select" id="mlsimport_item_property_user" name="mlsimport_item_property_user">
                         ' . $this->theme_importer->mlsimport_saas_theme_import_select_user($mlsimport_item_property_user) . '
                    </select>
            </fieldset> ';


        $mlsimport_item_min_price = floatval(get_post_meta($post_id, 'mlsimport_item_min_price', true));
        $mlsimport_item_max_price = floatval(get_post_meta($post_id, 'mlsimport_item_max_price', true));
        if ($mlsimport_item_max_price == 0) {
            $mlsimport_item_max_price = 10000000;
        }
        


        print'
        <fieldset class="mlsimport-fieldset">
              <label  class="mlsimport-label" >
                 ' . esc_html__('Price Between', 'mlsimport') . '
              </label>
              <input type="text" class="mlsimport-select" id="mlsimport_item_min_price" name="mlsimport_item_min_price" value="' . $mlsimport_item_min_price . '"> and
              <input type="text" class="mlsimport-select" id="mlsimport_item_max_price" name="mlsimport_item_max_price" value="' . $mlsimport_item_max_price . '">

        </fieldset>';
        
        
     

        $options    =   get_option($this->plugin_name . '_admin_options');
        
        $mls_id     =   '';
        if(isset($options['mlsimport_mls_name'])){
            $mls_id   = sanitize_text_field(trim($options['mlsimport_mls_name']) );
        }
        

        if($mls_id>5000){
            $field_import['PropertyType']['multiple']='no';
        }


        foreach ($field_import as $key => $field):

          
            
            $name_check = strtolower("mlsimport_item_" . $key . "_check");
            $name = strtolower("mlsimport_item_" . $key);

            $value = get_post_meta($post_id, $name, true);
            $value_check = get_post_meta($post_id, $name_check, true);


            print'
            <fieldset class="mlsimport-fieldset">
                <label class="mlsimport-label"  for="' . $name . '" >
                    ' . $field['label'] . '
                </label>
                <p class="mlsimport-exp">' . $field['description'];
            $is_checkbox_admin = 0;
            if ($value_check == 1) {
                $is_checkbox_admin = 1;
            }


            $select_all_none = array(
                'InternetAddressDisplayYN',
                'InternetEntireListingDisplayYN',
                'PostalCode',
                'ListAgentKey',
                'ListAgentMlsId',
                'ListOfficeKey',
                'ListOfficeMlsId',
                'StandardStatus'
                
            );

            if($mls_id>5000){
                $select_all_none[]='PropertyType';
            }
          
            if (!in_array($key, $select_all_none)) {
                echo esc_html__('- Or Select All ', $this->plugin_name) . '<input type="hidden"  name="' . $name_check . '" value="0"  /><input type="checkbox"  name="' . $name_check . '" value="1" ' . checked($is_checkbox_admin, 1, 0) . ' />';
            }
            print '</p>';

            
            $permited_status=array('active','active under contract','coming soon','activeundercontract','comingsoon','pending');
                

            if ($field['type'] == 'select') {
                $multiple = '';

                if ($field['multiple'] == 'yes') {
                    $multiple = 'multiple';
                    $name = $name . '[]';
                }

               
                if( $key=="StandardStatus" && $value==''){
                    $value=array(0=>'Active');
                }
                
                print' <select  class="mlsimport-select" id="' . $name . '" name="' . $name . '"  ' . $multiple . ' >';

                
                
                foreach ($field['values'] as $select_key) {
                    if($select_key!=''){
                        print '<option value="' . $select_key . '" ';

                        if( $key=="StandardStatus" && !in_array(strtolower($select_key), $permited_status) ){
                            print 'disabled';
                        }

                        if (is_array($value)) {
                            if (in_array($select_key, $value))
                                print 'selected';
                        }else {
                            if ($value == $select_key)
                                print 'selected';
                        }




                        print'>';
                        print $select_key;
                        print'</option>';
                    }
                }

                print'</select>';
            }else if ($field['type'] == 'input') {
                print' <input type="text"  class="mlsimport-select" id="' . $name . '" name="' . $name . '"  value="' . esc_html($value) . '" >';
                print '</input>';
            }

            print'</fieldset>';
        endforeach;
        print '</div>';
    }
  
    
    /**
    * 
     * 
     * Get Last date
     * 
     * 
     *  
    */
    public function mlsimport_saas_get_last_date($item_id){
        $last_date          =    get_post_meta($item_id,'mlsimport_last_date',true);
         
        if($last_date==''){
            $last_date =  $this->mlsimport_saas_update_last_date($item_id);
        }
        
        return $last_date;
    }
 
       
    /**
    * 
     * 
     * Save Last date
     * 
     * 
     *  
    */
    public function mlsimport_saas_update_last_date($item_id){
         
        $unix_time          = current_time( 'timestamp', 0 ) - (2*60*60);
        $last_date_to_save  = date( 'Y-m-d\TH:i', $unix_time ); 
        update_post_meta($item_id,'mlsimport_last_date',$last_date_to_save );
        
        return $last_date_to_save;
    }
    
    
    
    /**
    * 
     * 
     * Check if there are modified items in the last 2h  
     * 
     * 
     *  
    */
        
    
    public function mlsimport_saas_start_cron_links_per_item($item_id){
        
        $last_date          =    $this->mlsimport_saas_get_last_date($item_id);
      
        print 'we work with '.$last_date.PHP_EOL;
            
        $mlsrequest= $this->mlsimport_make_listing_requests($item_id,$last_date);
        $found_items=0;
        if(isset($mlsrequest['results']) ){
            $found_items = intval($mlsrequest['results']);
        }else{
            delete_transient('mlsimport_saas_token');
        }
        
        //print $mlsrequest['api_meta_url'];
        print 'we found '.$found_items.'</br>'.PHP_EOL;
        
        $attachments_to_move=array();
        
        if($found_items>0){
            $item_id_array = array(
                'item_id'       => $item_id,
                'how_many'      => 0,
                'max_number'    => $found_items,
                'batch_counter' => 1
            );

            $attachments_to_move = (array) $this->mlsimport_saas_generate_import_requests_per_item($item_id_array,$last_date);
         
            update_post_meta($item_id, 'mlsimport_spawn_status_cron_job', 'started');
            update_post_meta($item_id, 'mlsimport_cron_attach_to_move_'.$item_id, $attachments_to_move);

            
            // save last date for next run
            $this->mlsimport_saas_update_last_date($item_id);

            
       
            $attachments_to_send = array(
            'args' => array(
                'attachments_to_move'   => $item_id,
                'item_id_array'         => $item_id_array
                )
            );

       
            
            $this->mlsimport_background_process_per_item_cron_function($attachments_to_send['args']);
            //print 'am spawn';
        
        
        }
        
       
        
    }
    
    
    
      
    /**
    * 
     * 
     * Reconciliation log
     * 
     * 
     *  
    */
    public function mlsimport_saas_start_doing_reconciliation (){
        global $mlsimport;
        $listingKey_in_Local    =   $this->mlsimport_saas_get_all_meta_values('ListingKey');
       // print_r($listingKey_in_Local);
        if( empty($listingKey_in_Local)){
            return;
        }  
        
       // print '*************************************************************************';
        $mls_data           =   $this->mlsimport_saas_get_mls_reconciliation_data();
        $listingKey_in_MLS  =   $mls_data['all_data'];
        //print_r($listingKey_in_MLS);
       
        if( empty($listingKey_in_MLS)){
            return;
        }   
        
        
        
        $to_delete=0;
        $counter = 0;
        foreach($listingKey_in_Local as $key=>$item){
               
                $listingkey     = $item->meta_value;
                $property_id    = $item->iD;
                $counter++;
                print '</br>'.$counter.'. Checking '.$listingkey.' *********************';
                if(in_array($listingkey, $listingKey_in_MLS)){
                   print '</br>'.$listingkey.' IS FOUND ';
                }else{
                    $to_delete++;
                    print '</br>'.$listingkey.' ------------------------- NOT FOUND delete '.$property_id.' <-';
                    $mlsimport->admin->theme_importer->mlsimport_saas_delete_property_via_mysql($property_id,$listingkey);
                     
                    
                     
               }
        }
           
        print ' to delete '.$to_delete;
        return;
        
    }
    
    
     /**
    * 
     * 
     * Requestq Reconciliation log
     * 
     * 
     *  
    */
    public function mlsimport_saas_get_mls_reconciliation_data (){
        
        $arguments=array();
        $answer     = $this->theme_importer->global_api_request_CURL_saas('reconciliation', $arguments, "GET");
       return $answer;
    }
    
    /**
    * 
    * 
    * Reconciliation get local data
    * 
    * 
    */  
    
    function mlsimport_saas_get_all_meta_values($key){
        global $wpdb;
          

        $result = $wpdb->get_results( 
           $wpdb->prepare( "
                        SELECT DISTINCT pm.meta_value,p.iD FROM {$wpdb->postmeta} pm
                        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                        WHERE pm.meta_key = '%s' 
                        AND p.post_status = 'publish'",
                   $key
            ) 
        );

                           
	return $result;
    }
      
      
    
    
    
    /*
    *  Do api Listing Requests
     * 
     * 
     * 
     * 
     * 
     * */
    public function mlsimport_make_listing_requests($item_id, $last_date='',$skip='',$top=''){
        $options    =   get_option($this->plugin_name . '_admin_options');
        $mls_id     =   '';
        if(isset($options['mlsimport_mls_name'])){
            $mls_id   = sanitize_text_field(trim($options['mlsimport_mls_name']) );
        }

        $arguments = $this->mlsimport_saas_make_listing_requests_arguments($item_id, $last_date ,$skip,$top);
      


        if( $mls_id>5000  && 
                (   !isset($arguments['property_type'] ) or
                    ( isset($arguments['property_type'] ) && $arguments['property_type']==''  ) or
                    ( isset($arguments['property_type'][0] ) && $arguments['property_type'][0]==''  ) 
                )
            ){
            return array( 
                'success'=>false ,
                'type'=>'rapattoni',             
                'message' => esc_html__('This MLS requires to have one item selected from "Property Action Category" dropdown','mlsimport') 
            );
        }

        

        $potential_leght = strlen(json_encode($arguments));
        if($potential_leght > 1750){
            return array( 
                'success'=>false ,
                'potential_leght'=>$potential_leght,
                'message' => esc_html__('You have too many parameters selected. Split the import beween multiple MLS Import items: For ex : Import per County instead of selecting 10 cities or import listing between certain price range.','mlsimport') 
            );
        }








        $answer     = $this->theme_importer->global_api_request_CURL_saas('listings', $arguments, "GET");
        $answer['potential_leght']=$potential_leght;
        return ($answer);
    }
    
    
    
    
    
    
    /*
     * Create Api query arguments 
     * 
     * 
     * 
     * 
     * 
     * */
    
    public function mlsimport_saas_make_listing_requests_arguments($item_id, $last_date='',$skip='',$top=''){

            
        $options    =   get_option($this->plugin_name . '_admin_options');
        if(isset($options['mlsimport_mls_name'])){
             $mls_id     =   intval($options['mlsimport_mls_name']);
        }else{
            return '';
        }
        
        if(isset($options['mlsimport_theme_used'])){
            $theme_id   =   intval($options['mlsimport_theme_used']);
        }else{
            return '';
        }
        
        $values             =   array();
        $values['mls_id']   =   $mls_id;
        $values['theme_id'] =   $theme_id;
        
        

        if($top!=''){
            $values['top'] =   $top;
            $values['skip'] =   intval($skip);
        }
        
        
        // // add price
        $mlsimport_item_min_price = get_post_meta($item_id, 'mlsimport_item_min_price', true);
        $mlsimport_item_max_price = get_post_meta($item_id, 'mlsimport_item_max_price', true);        
        if ($mlsimport_item_min_price!='' && $mlsimport_item_max_price!=''){
             $values['list_price_min'] =   floatval($mlsimport_item_min_price);
             $values['list_price_max'] =   floatval($mlsimport_item_max_price);
        }
        
        
        // add city
        $values = $this->mls_import_return_multiple_param_value('city',$item_id,'city',$values);
       
        //add county 
        $values = $this->mls_import_return_multiple_param_value('countyorparish',$item_id,'county_or_parish',$values);
        
        //add postal code
        $values= $this->mls_import_saas_add_to_parms_input('PostalCode',$item_id,'postal_code',$values);
        
        
        //add status
        $values= $this->mls_import_return_multiple_param_value('StandardStatus',$item_id,'status',$values);
        
        //add property_subtype
        $values= $this->mls_import_return_multiple_param_value('PropertySubType',$item_id,'property_subtype',$values);
        
         //add property_type
        $values= $this->mls_import_return_multiple_param_value('PropertyType',$item_id,'property_type',$values);
        

        // rapattoni exception
        if(   $mls_id >5000){
            $values= $this->mls_import_saas_add_to_parms_input('PropertyType',$item_id,'property_type',$values);
            $temp =  $values['property_type'];
            $temp = str_replace(' ','',$temp);
            $values['property_type']=array();
            $values['property_type'][]=$temp;
        }
        

        //add internet_entirelisting_displayyn
        $values= $this->mls_import_saas_add_to_parms_input('InternetEntireListingDisplayYN',$item_id,'internet_entirelisting_displayyn',$values);
        
        //add internet_address_displayyn
        $values= $this->mls_import_saas_add_to_parms_input('InternetAddressDisplayYN',$item_id,'internet_address_displayyn',$values);
        
    
         //add ListAgentKey
        $values= $this->mls_import_saas_add_to_parms_input('ListAgentKey',$item_id,'list_agentkey',$values);
        //add ListAgentKey
        $values= $this->mls_import_saas_add_to_parms_input('ListAgentMlsId',$item_id,'list_agentmlsid',$values);
        //add ListOfficeKey
        $values= $this->mls_import_saas_add_to_parms_input('ListOfficeKey',$item_id,'list_officekey',$values);
        //add ListOfficeMlsId
        $values= $this->mls_import_saas_add_to_parms_input('ListOfficeMlsId',$item_id,'list_officemlsid',$values);
        
        if($last_date!=''){
            $values['modification_time']=$last_date;
        }
        

        return($values);
              
    }
    
    
      
     /*
     * 
     * add input  items to parameters array
     * 
     */
    
    function mls_import_saas_add_to_parms_input($key,$post_id,$new_name,$all_values){
        $name = strtolower("mlsimport_item_" . $key);
        $value = get_post_meta($post_id, $name, true);
        if($value!=''){
            $all_values[$new_name]=$value;
        }
        
        return $all_values;
        
    }
    
    
     /*
     * 
     * add list items to parameters array
     *      $values= $this->mls_import_return_multiple_param_value('StandardStatus',$item_id,'status',$values);
        
     */
    
    function mls_import_return_multiple_param_value($key,$post_id,$new_name,$all_values){
        $name_check = strtolower("mlsimport_item_" . $key . "_check");
        $name = strtolower("mlsimport_item_" . $key);

        $value = get_post_meta($post_id, $name, true);
      
        $value_check = get_post_meta($post_id, $name_check, true);
        
        if($value_check==0 && $value!=''){
             $all_values[$new_name]=$value;
        }
       
        
        //status exception
        if($new_name=='status'){
            $all_values[$new_name]=$value;
        }
        
        
        return $all_values;
        
    }
    
    
    
    /*
     * 
     * All Enums fiels to be used on MLS import Item 
     * 
     * 
     * 
     * 
     * 
     * 
     * */

    public function mlsimport_saas_return_mls_fields() {
       
        $mlsimport_mls_metadata_mls_enums       =   get_option('mlsimport_mls_metadata_mls_enums','' );
        
        if($mlsimport_mls_metadata_mls_enums==''){
            print '<div class="mlsimport_warning long_warning">Please select the import fields(from MLS Import Settings) before starting a MLS import process.</div>';    
        }
        
        $metadata_api_call_full                 =   json_decode($mlsimport_mls_metadata_mls_enums,true);
      
        if( isset($metadata_api_call_full['global_array'])){
            $metadata_api_call                      =   $metadata_api_call_full['global_array'];
        }
        
        $city_array = array();
        if (isset($metadata_api_call['PropertyEnums']['City']) && is_array($metadata_api_call['PropertyEnums']['City'])) {
            $city_array = array_keys($metadata_api_call['PropertyEnums']['City']);
        }

        $county_array = array();
        if (isset($metadata_api_call['PropertyEnums']['CountyOrParish']) && is_array($metadata_api_call['PropertyEnums']['CountyOrParish'])) {
            $county_array = array_keys($metadata_api_call['PropertyEnums']['CountyOrParish']);
        }

        $mlsstatus_array = array();
        if (isset($metadata_api_call['PropertyEnums']['MlsStatus']) && is_array($metadata_api_call['PropertyEnums']['MlsStatus'])) {
            $mlsstatus_array = array_keys($metadata_api_call['PropertyEnums']['MlsStatus']);
        }

        $propertysubtype_array = array();
        if (isset($metadata_api_call['PropertyEnums']['PropertySubType']) && is_array($metadata_api_call['PropertyEnums']['PropertySubType'])) {
            $propertysubtype_array = array_keys($metadata_api_call['PropertyEnums']['PropertySubType']);
        }

        $propertytype_array = array();
        if (isset($metadata_api_call['PropertyEnums']['PropertyType']) && is_array($metadata_api_call['PropertyEnums']['PropertyType'])) {
            $propertytype_array = array_keys($metadata_api_call['PropertyEnums']['PropertyType']);
        }

        $standardstatus_array = array();
        if (isset($metadata_api_call['PropertyEnums']['StandardStatus']) && is_array($metadata_api_call['PropertyEnums']['StandardStatus'])) {
            $standardstatus_array = array_keys($metadata_api_call['PropertyEnums']['StandardStatus']);
        }

        // if we do not have standart status
        if(empty($standardstatus_array)){
            $standardstatus_array=$mlsstatus_array;
        }



        $field_import = array(
            'City' => array(
                'label' => esc_html__('Select cities', $this->plugin_name),
                'description' => esc_html__('Select the cities from where we will import data.', $this->plugin_name),
                'type' => 'select',
                'multiple' => 'yes',
                'values' => $city_array
            ),
            'CountyOrParish' => array(
                'label' => esc_html__('Select Counties', $this->plugin_name),
                'description' => esc_html__('Select the counties from where we will import data.', $this->plugin_name),
                'type' => 'select',
                'multiple' => 'yes',
                'values' => $county_array
            ),
            'PostalCode' => array(
                'label' => esc_html__('Select Postal Code', $this->plugin_name),
                'description' => esc_html__('Select the PostalCode from where to import listings. Works with only one PostalCode.', $this->plugin_name),
                'type' => 'input',
                'multiple' => 'no',
            ),

            'PropertySubType' => array(
                'label' => esc_html__('Select Property Category', $this->plugin_name),
                'description' => esc_html__('Property Category', $this->plugin_name),
                'type' => 'select',
                'multiple' => 'yes',
                'values' => $propertysubtype_array
            ),
            'PropertyType' => array(
                'label' => esc_html__('Select Property Action Category', $this->plugin_name),
                'description' => esc_html__('Property Action Category', $this->plugin_name),
                'type' => 'select',
                'multiple' => 'yes',
                'values' => $propertytype_array
            ),
            'StandardStatus' => array(
                'label' => esc_html__('Select Status', $this->plugin_name),
                'description' => __('The list is auto-populated with MLS available statuses BUT you can import only these statuses: <strong>Active, Active Under Contract or Coming Soon</strong>.', $this->plugin_name),
                'type' => 'select',
                'multiple' => 'yes',
                'values' => $standardstatus_array
            ),
            'InternetEntireListingDisplayYN' => array(
                'label' => esc_html__('Internet Entire Listing Display ', $this->plugin_name),
                'description' => esc_html__('A yes/no field that states the seller has allowed the listing to be displayed on Internet sites.', $this->plugin_name),
                'type' => 'select',
                'multiple' => 'no',
                'values' => array(
                    'yes',
                    'no',
                ),
            ),
            'InternetAddressDisplayYN' => array(
                'label' => esc_html__('Internet Address display', $this->plugin_name),
                'description' => esc_html__('A yes/no field that states the seller has allowed the listing address to be displayed on Internet sites.', $this->plugin_name),
                'type' => 'select',
                'multiple' => 'no',
                'values' => array(
                    'yes',
                    'no',
                ),
            ),
            'ListAgentKey' => array(
                'label' => esc_html__('ListAgentKey', $this->plugin_name),
                'description' => esc_html__('Import listings from a specific Agent (contact your MLS for this information)', $this->plugin_name),
                'type' => 'input',
                'multiple' => 'no',
            ),
            'ListAgentMlsId' => array(
                'label' => esc_html__('ListAgentMlsId', $this->plugin_name),
                'description' => esc_html__('Import listings from a specific Agent (contact your MLS for this information)', $this->plugin_name),
                'type' => 'input',
                'multiple' => 'no',
            ),
            'ListOfficeKey' => array(
                'label' => esc_html__('ListOfficeKey', $this->plugin_name),
                'description' => esc_html__('Import listings from a specific Office (contact your MLS for this information)', $this->plugin_name),
                'type' => 'input',
                'multiple' => 'no',
            ),
             'ListOfficeMlsId' => array(
                'label' => esc_html__('ListOfficeMlsId', $this->plugin_name),
                'description' => esc_html__('Import listings from a specific Office (contact your MLS for this information)', $this->plugin_name),
                'type' => 'input',
                'multiple' => 'no',
            ),
        );
        return $field_import;
    }







    /**
     * 
     * 
     * AYsnc Test
     * 
     * 
     */


    public function mlsimport_move_files_per_item() {

      

        $post_id        =   intval($_POST['post_id']);
        $how_many       =   intval($_POST['how_many']);
        $max_number     =   intval($_POST['post_number']);
      
        update_option('mlsimport_force_stop_' . $post_id, 'no', false);

        $item_id_array = array(
            'item_id'       => $post_id,
            'how_many'      => $how_many,
            'max_number'    => $max_number,
            'batch_counter' => 1
        );
        
        update_post_meta($post_id, 'mlsimport_attach_to_move_' . $post_id, '');
        $attachments_to_move = (array) $this->mlsimport_saas_generate_import_requests_per_item($item_id_array);

        update_post_meta($post_id, 'mlsimport_attach_to_move_' . $post_id, $attachments_to_move);

        $attachments_to_send = array(
            'args' => array(
                'attachments_to_move'   => $post_id,
                'item_id_array'         => $item_id_array
                )
        );

        
        mls_saas_single_write_import_custom_logs('Preparing the import. Please hold on.' . PHP_EOL);
        mlsimport_debuglogs_per_plugin('Preparing the import. Please hold on.' . PHP_EOL);
        
        update_post_meta($post_id, 'mlsimport_spawn_status', 'started');
        as_enqueue_async_action('mlsimport_background_process_per_item', $attachments_to_send);
        spawn_cron();


        die();
    }

     /**
     * 
     * 
     * Processing Cron 
     * 
     * 
     * 
     * 
     * 
     */


    function mlsimport_background_process_per_item_cron_function($input_arg) {
        $log='In cron processing function   ->' . json_encode($input_arg['item_id_array']) . PHP_EOL;
        mls_saas_single_write_import_custom_logs($log,'cron');
        global $mlsimport;
   
        // Get from MLS Import it the big argument arrat
        $attachments_to_move = get_post_meta($input_arg['item_id_array']['item_id'], 'mlsimport_cron_attach_to_move_' . $input_arg['item_id_array']['item_id'], true);

        $log = 'In processing function  mlsimport_cron_attach_to_move_ ->' . json_encode($attachments_to_move) . PHP_EOL;
        mls_saas_single_write_import_custom_logs($log);
        //mlsimport_debuglogs_per_plugin($log);
        //print $log;


        //  foreach($input_arg['attachments_to_move'] as $key=>$import_link){
        foreach ($attachments_to_move as $key => $import_arguments) {
            $GLOBALS['wp_object_cache']->delete('mlsimport_force_stop_' . $input_arg['item_id_array']['item_id'], 'options');
            
         

                $log =PHP_EOL . ' Cron Parsing importing batch  : ' . $key . ' = ' . json_encode($import_arguments) . PHP_EOL;
                mls_saas_single_write_import_custom_logs($log,'cron');
                 
                $api_call_array     = $this->theme_importer->global_api_request_CURL_saas('listings', $import_arguments, "GET");
             
             
                $mlsimport->admin->theme_importer->mlsimport_saas_cron_parse_search_array_per_item($api_call_array, $input_arg['item_id_array'],$key);
           
        }

        mls_saas_single_write_import_custom_logs('CRON JOB Import Completed ' . PHP_EOL);
        mlsimport_debuglogs_per_plugin('CRON JOB Import Completed ' . PHP_EOL);
        update_post_meta($input_arg['item_id_array']['item_id'], 'mlsimport_spawn_status', 'completed');
    }

    /**
     * 
     * 
     * Generate import Requests per item
     * 
     * 
     * 
     * 
     * 
     */
    
    public function mlsimport_saas_generate_import_requests_per_item($item_id_array,$last_date='') {
        $import_step=25;
        
        $prop_id            =   $item_id_array['item_id'];
        $max_found          =   $item_id_array['max_number'];
        $how_many           =   $item_id_array['how_many'];
        if($how_many==0){
            $how_many=$max_found;
        }
        if($how_many>$max_found){
            $how_many=$max_found;
        }


        $search_url_step=   '';
        $urls_array     =   array();


        $skip           =   0;
        if($how_many>10000){
            $how_many=10000;
        }

        if($how_many<$import_step){
            $import_step=$how_many;
        }

        while( $skip<$how_many  ){
            $search_url_step    =   $this->mlsimport_saas_make_listing_requests_arguments($prop_id,$last_date, $skip,$import_step); 
            $skip               =   $skip+$import_step;
            $urls_array[]       =   $search_url_step;

        }
        return $urls_array;
    }

    
    
    
    
    /**
     *  Process Async function
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */


    function mlsimport_background_process_per_item_function($input_arg) {
        mls_saas_single_write_import_custom_logs('In processing function   ->' . json_encode($input_arg['item_id_array']) . PHP_EOL);

        global $mlsimport;
   
        // Get from MLS Import it the big argument arrat
        $attachments_to_move = get_post_meta($input_arg['item_id_array']['item_id'], 'mlsimport_attach_to_move_' . $input_arg['item_id_array']['item_id'], true);

        $log = 'In processing function  $attachments_to_move ->' . json_encode($attachments_to_move) . PHP_EOL;
        mls_saas_single_write_import_custom_logs($log);
        mlsimport_debuglogs_per_plugin($log);
        print $log;


        $total_batches=count($attachments_to_move);

        foreach ($attachments_to_move as $key => $import_arguments) {
            $GLOBALS['wp_object_cache']->delete('mlsimport_force_stop_' . $input_arg['item_id_array']['item_id'], 'options');
            $status = get_option('mlsimport_force_stop_' . $input_arg['item_id_array']['item_id']);
         
            if ($status == 'no') {
                wp_cache_flush();
                $mem_usage      =   memory_get_usage(true);
                $mem_usage_show =   round($mem_usage/1048576,2);
                

                $log =PHP_EOL . 'Parsing import batch  : ' . ($key+1) . ' of '.$total_batches. '. Memory used: '.$mem_usage_show.' mb = ' . json_encode($import_arguments) . PHP_EOL;
                print $log;
                $log2 =PHP_EOL . 'Parsing import batch  : ' . ($key+1) . ' of '.$total_batches. '. Memory used: '.$mem_usage_show.' mb.' . PHP_EOL;
            
                mls_saas_single_write_import_custom_logs($log);
                mlsimport_debuglogs_per_plugin($log2);
                
                $api_call_array     = $this->theme_importer->global_api_request_CURL_saas('listings', $import_arguments, "GET");        
                $mlsimport->admin->theme_importer->mlsimport_saas_parse_search_array_per_item($api_call_array, $input_arg['item_id_array'],$key);
            } else {
                update_post_meta($input_arg['item_id_array']['item_id'], 'mlsimport_spawn_status', 'completed');
                delete_post_meta($input_arg['item_id_array']['item_id'], 'mlsimport_attach_to_move_' . $input_arg['item_id_array']['item_id']);

               mls_saas_single_write_import_custom_logs(PHP_EOL . 'Parsing importing link  FORCE STOP : ');
               mlsimport_debuglogs_per_plugin('Parsing importing link  FORCE STOP : ');
            }
        }

        mls_saas_single_write_import_custom_logs('Import Completed ' . PHP_EOL);
        mlsimport_debuglogs_per_plugin('Import Completed ' . PHP_EOL);
        update_post_meta($input_arg['item_id_array']['item_id'], 'mlsimport_spawn_status', 'completed');
        delete_post_meta($input_arg['item_id_array']['item_id'], 'mlsimport_attach_to_move_' . $input_arg['item_id_array']['item_id']);

    }

    
    

    
    
    
    
    /**
     * 
     * 
     * 
     * update log function
     * 
     * 
     * 
     * 
     */
    function mlsimport_logger_per_item() {
        $post_id    = intval($_POST['post_id']);
        $status     = get_post_meta($post_id, 'mlsimport_spawn_status', true);
        $path       = WP_PLUGIN_DIR . "/mlsimport/logs/status_logs.log";
        $logs       = file_get_contents($path);

        $force_status = intval(get_post_meta($post_id, 'mlsimport_force_stop', true));
        $force_status = get_option('mlsimport_force_stop_' . $post_id);

        if ($force_status != 'no') {
            echo json_encode(array('is_done' => 'done', 'status' => $status, 'logs' => $logs));
            die();
        }

        if ($status == '' || $status == 'completed') {
            echo json_encode(array('is_done' => 'done', 'status' => $status, 'logs' => $logs));
        } else {
            // return from log
            echo json_encode(array('is_done' => 'wip', 'status' => $status, 'logs' => $logs));
        }
        die();
    }

    
    
    
    
    
    /**
     * 
     * 
     * 
     * 
     * Force Stop Import
     * 
     * 
     * 
     * 
     * 
     */
    public function mlsimport_stop_import_per_item() {
        $post_id = intval($_POST['post_id']);
        update_option('mlsimport_force_stop_' . $post_id, 'yes', false);
        mls_saas_single_write_import_custom_logs('Stopeed for ' . $post_id . PHP_EOL);
        mlsimport_debuglogs_per_plugin('Stopeed for ' . $post_id . PHP_EOL);

        die();
    }

    
    
    /*
     * 
     *  Get MLS Metadata 
     * 
     * 
     * 
     * 
     **/
    
    public function mlsimport_saas_get_metadata_function(){
        $theme_Start=   new ThemeImport();
       
        $values     =   array();
        $options    =   get_option($this->plugin_name.'_admin_options');
        $url        =   "clients?theme_id=".intval($options['mlsimport_theme_used']);
                
        $answer = $theme_Start::global_api_request_saas($url, $values, "GET");
        
       
        
        update_option('mlsimport_mls_metadata_populated','yes');
      
        
        update_option('mlsimport_mls_metadata_theme_schema',$answer['theme_schema']);
        update_option('mlsimport_mls_metadata_mls_data',$answer['mls_data']['mls_meta_data'] );
        update_option('mlsimport_mls_metadata_mls_enums',$answer['mls_data']['mls_meta_enums'] );
        
    }
    
    
    
    
    
    
    
    
    


    
     /**
      * 
      * 
     * write debug logs
      * 
      * 
      * 
     * 
     */
    function mlsimport_debuglog_cron($message) {
        if (is_array($message)) {
            $message = json_encode($message);
        }
        $message = date("F j, Y, g:i a") . ' -> ' . $message;
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $path = WP_PLUGIN_DIR . "/mlsimport/logs/cron_logs.log";
  

        file_put_contents($path, $message, FILE_APPEND | LOCK_EX);
    }
    
        /**
    *
    * 
    * 
    *  write custom logs
    *
    * 
    * 
    */
    
    
    
 
    
    
}
