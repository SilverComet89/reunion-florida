<?php
/**
 * Plugin Name:       MlsImport
 * Plugin URI:        https://mlsimport.com/
 * Description:       MlS Import - Import and synchronize MLS listings 
 * Version:           5.6.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            MlsImport
 * Author URI:        https://mlsimport.com/
 * Text Domain:       mlsimport
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'MLSIMPORT_VERSION', '5.6.2' );
define( 'MLSIMPORT_CLUBLINK', 'mlsimport.com');
define( 'MLSIMPORT_CLUBLINKSSL', 'https');

define( 'MLSIMPORT_CRON_STEP', 20 );
define( 'MLSIMPORT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define( 'MLSIMPORT_PLUGIN_URL',  plugin_dir_url(__FILE__) );
define( 'MLSIMPORT_API_URL','https://eyk8ppieaj.execute-api.us-east-1.amazonaws.com/v1/');



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mlsimport-activator.php
 */
function activate_mlsimport() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mlsimport-activator.php';
	Mlsimport_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mlsimport-deactivator.php
 */
function deactivate_mlsimport() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mlsimport-deactivator.php';
	Mlsimport_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mlsimport' );
register_deactivation_hook( __FILE__, 'deactivate_mlsimport' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require      plugin_dir_path( __FILE__ ) . 'includes/help_functions.php';
require      plugin_dir_path( __FILE__ ) . 'includes/class-mlsimport.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/ThemeImport.php';

require_once plugin_dir_path( __FILE__ ) . 'includes/plugin_updates.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/WpResidenceClass.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/WpEstateClass.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/HouzezClass.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/RealHomesClass.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/ResoBase.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/SparkResoClass.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/BridgeResoClass.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/TresleResoClass.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/MlsgridResoClass.php';
require_once plugin_dir_path( __FILE__ ) . 'enviroment/MlsgridResoClass.php';
require_once plugin_dir_path( __FILE__ ) . '/action-scheduler/action-scheduler.php';


if ( !wp_next_scheduled( 'event_mls_import_auto' ) ) {
    wp_schedule_event( time(), 'hourly', 'event_mls_import_auto');
}



add_action( 'event_mls_import_auto', 'mlsimport_saas_event_mls_import_auto_function' );
function mlsimport_saas_event_mls_import_auto_function(){
  
    global $mlsimport; 
 

    $token = $mlsimport->admin->mlsimport_saas_get_mls_api_token_from_transient();
    if(trim($token)==''){
        return;
    }
    
    $is_mls_connected = get_option('mlsimport_connection_test','');
    if($is_mls_connected!=='yes'){
        return;
    }
    
    
    
    
    $logs=" event_mls_import_auto_function ".PHP_EOL;
    mlsimport_debuglogs_per_plugin($logs);

    $args = array(
      'post_type'         => 'mlsimport_item',
      'post_status'       => 'any',
      'posts_per_page'    => -1,
      'meta_query' => array(
            array(
                    'key'     => 'mlsimport_item_stat_cron',
                    'value'   => 1,
                    'compare' => '=',
            ),
        ),
    );
    
    $prop_selection= new WP_Query($args);
       if ($prop_selection->have_posts()){    
            while ($prop_selection->have_posts()): $prop_selection->the_post();
                $prop_id=get_the_ID();
               
                $logs=" Loop custom post : ".$prop_id.PHP_EOL;
                mlsimport_debuglogs_per_plugin($logs);
                $mlsimport->admin->mlsimport_saas_start_cron_links_per_item( $prop_id);
              
            endwhile;
       }
    
    
}





/*
 *  Reconciliation Mechanism
 * 
 * 
 * 
 **/
if ( !wp_next_scheduled( 'mlsimport_reconciliation_event' ) ) {
    wp_schedule_event( time(), 'daily', 'mlsimport_reconciliation_event');
}

add_action( 'mlsimport_reconciliation_event', 'mlsimport_saas_reconciliation_event_function' );



/*
 * Force use of transient
 * 
 * 
 * 
 **/
function mlsimport_force_use_transient($value){
    
    return $value;
   // return false;
}




        
        
global $mlsimport;
$mlsimport = new Mlsimport();
$mlsimport->run();



$supported_theme=array(
    991 =>'WpResidence',
    992 =>'Houzez',
    993 => 'Real Homes',
    994 => 'Wpestate'
);
define( 'MLSIMPORT_THEME', $supported_theme );


add_filter( 'action_scheduler_failure_period', 'mlsimport_saas_filter_timelimit' );
function mlsimport_saas_filter_timelimit( $time_limit ){
    return 3000;
}


/*
 * 
 * Write logs 
 * 
 **/

function mls_saas_single_write_import_custom_logs($message,$tip_import='normal') { 
    
        $enable_logs= intval(get_option('mlsimport_disable_logs'));
        if($enable_logs!==1 ){
            return;
        }
        
    
        if(is_array($message)) { 
            $message = json_encode($message); 
        } 
        
        $message = date("F j, Y, g:i a").' -> '. $message;

        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }
        if($tip_import=='cron'){
             $path=WP_PLUGIN_DIR."/mlsimport/logs/cron_logs.log";
        } else if($tip_import=='delete'){
            $path=WP_PLUGIN_DIR."/mlsimport/logs/delete_logs.log";
        } else if($tip_import=='server_cron'){
            $path=WP_PLUGIN_DIR."/mlsimport/logs/server_cron_logs.log";
        }else{
            $path=WP_PLUGIN_DIR."/mlsimport/logs/import_logs.log";
        }
        
        $date    =   '-'.date("Y-m-d").'.log';
        $path    =   str_replace(".log", $date , $path);
        file_put_contents ($path, $message,FILE_APPEND | LOCK_EX);

    }
    
   
    
/*
 *
 * 
 * Write Status logs 
 *
 *  
 **/  

function mlsimport_debuglogs_per_plugin($message) { 
    if(is_array($message)) { 
        $message = json_encode($message); 
    } 
   
    
    global $wp_filesystem;
    if (empty($wp_filesystem)) {
        require_once (ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }

    $path_status=WP_PLUGIN_DIR."/mlsimport/logs/status_logs.log";
    file_put_contents ($path_status, $message, LOCK_EX );
}



/*
 * Cron job trigger
 *  
 * 
 * 
 **/

///*/5 * * * * wget http://example.com/check  */2
add_action('init','mlsimport_trigger_cron_job');
function mlsimport_trigger_cron_job() { 
    //?mlsimport_cron=yes
    if( isset( $_REQUEST[ 'mlsimport_cron' ]) && $_REQUEST[ 'mlsimport_cron' ]=='yes' ) {
        
        $last_run   = intval( get_option('mlsimport_last_server_cron'));
        $now        = time();  
        
        if($last_run==0){
            update_option('mlsimport_last_server_cron',$now );
        }
        
        
        if($last_run  < $now-(60*60*2) ){
          
            $log = 'Server Cron Job triggered on '.date('l jS \of F Y h:i:s A',$last_run).' vs '.date('l jS \of F Y h:i:s A',$now). PHP_EOL;
            //mlsimport_saas_event_mls_import_auto_function();
            update_option('mlsimport_last_server_cron',$now );
        }else{
             $log = 'Server Cron Job Called but not triggered. Last run on '.date('l jS \of F Y h:i:s A',$last_run).' vs '.date('l jS \of F Y h:i:s A',$now).  PHP_EOL;
        }
          
        mls_saas_single_write_import_custom_logs($log,'server_cron');
              
    }
}

function mlsimport_show_signup(){
    $affiliate_url='https://mlsimport.com';

    if(function_exists('wp_estate_init')){
       $affiliate_url='https://mlsimport.com/ref/1/?campaign=wpresidence'; 
    }
    
    print '<div class="mlsimport_signup">';
    
    print '<h3>'.esc_html__('Import MLS Listings into your Real Estate website','mlsimport').'</h3>';

    print '<p>'.esc_html__('Signup now and get 30-Days Free trial, no setup fee & cancel anytime at  ','mlsimport').'<a href="'.esc_url($affiliate_url).'" target="_blank">MlsImport.com</a></p>';
  

    print '<a href="'.esc_url($affiliate_url).'" class="button mlsimport_button mlsimport_signup_button" target="_blank">'.esc_html__('Create My Account','mlsimport').'</a>';

    print '</div>';
}