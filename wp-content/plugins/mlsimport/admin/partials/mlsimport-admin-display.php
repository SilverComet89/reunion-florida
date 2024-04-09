<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link      http://mlsimport.com/
 * @since      1.0.0
 *
 * @package    mlsimport
 * @subpackage mlsimport/admin/partials
 */
?>

<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2><?php _e('MLS Import Options', $this->plugin_name); ?></h2>

    <?php
        //Grab all options
        $options = get_option($this->plugin_name);
                
        $active_tab='display_options';
        if( isset( $_GET[ 'tab' ] ) ) {
            $active_tab = esc_html($_GET[ 'tab' ]);
        }

    ?>



    <h2 class="nav-tab-wrapper mlsimport-tab-wrapper">
        <a href="?page=mlsimport_plugin_options&tab=display_options" class="nav-tab  <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('MLS/RESO Api Options',$this->plugin_name);?></a>
        <a href="?page=mlsimport_plugin_options&tab=field_options"   class="nav-tab    <?php echo $active_tab == 'field_options'   ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Select Import fields',$this->plugin_name);?></a>
        <a href="?page=mlsimport_plugin_options&tab=administrative_options"  class="nav-tab   <?php echo $active_tab == 'administrative_options'  ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Tools',$this->plugin_name);?></a>
    </h2>
    
     
   
    <div class="content-nav-tab <?php echo $active_tab == 'display_options' ? 'content-nav-tab-active' : ''; ?>">
        <?php 
        if($active_tab=='display_options'){
            include_once( '' . $this->plugin_name . '-admin-options.php' );
        }
        ?>
    </div>
        
    
    
    <div class="content-nav-tab <?php echo $active_tab == 'field_options' ? 'content-nav-tab-active' : ''; ?>">    
        <?php 
        if($active_tab=='field_options'){
            include_once( '' . $this->plugin_name . '-admin-fields-select.php' );  
        }
        ?>
    </div>
        
  
    
    <div class="content-nav-tab <?php echo $active_tab == 'administrative_options' ? 'content-nav-tab-active' : ''; ?>">
        <?php 
        if($active_tab=='administrative_options'){
            include_once( '' . $this->plugin_name . '-administrative-options.php' );  
        }
        ?>
    </div>
    
       
    
</div>