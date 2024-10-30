<?php

/*
Plugin Name: Block RSS Reading
Version: 1.0
Plugin URI: http://wordpress.org/plugins/block-rss-reading/
Description: A simple WordPress plugin that let you to set another RSS Feed Url to be displayed for one or a list of many IP's.
Author: Madalin Adrian
Author URI: http://profiles.wordpress.org/smbdstopme
*/

/**
 * Define some useful constants
 **/
 
define('FUNCTION_VERSION', '1.0');

if ( !defined( 'FUNCTION_URL' ) )
	define( 'FUNCTION_URL', plugin_dir_url( __FILE__ ) );
	
if ( !defined( 'FUNCTION_DIR' ) )
	define( 'FUNCTION_DIR', plugin_dir_path( __FILE__ ) );
	
if ( !defined( 'FUNCTION_BASENAME' ) )
	define( 'FUNCTION_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Load files
 * 
 **/

function block_rss_reading_load(){
		
    if ( is_admin() ) //load admin files only in admin
        require_once(FUNCTION_DIR.'includes/admin.php');
        
    require_once(FUNCTION_DIR.'includes/core.php');
}

block_rss_reading_load();

/**
 * Activation, Deactivation and Uninstall Functions
 * 
 **/
 
register_activation_hook(__FILE__, 'block_rss_reading_activation');
register_deactivation_hook(__FILE__, 'block_rss_reading_deactivation');

function block_rss_reading_activation() {
    
	//actions to perform once on plugin activation go here    
    
	
    //register uninstaller
    register_uninstall_hook(__FILE__, 'block_rss_reading_uninstall');
}

function block_rss_reading_deactivation() {
    
	// actions to perform once on plugin deactivation go here
	    
}

function block_rss_reading_uninstall(){
    
    //actions to perform once on plugin uninstall go here
	
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

delete_option('custom_rss_url');
delete_option('blocked_ip_list');
	    
}

?>