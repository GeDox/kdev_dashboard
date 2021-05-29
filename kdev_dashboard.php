<?php if( ! defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Invoices Manager
Plugin URI: https://sztosit.eu
Description: Dokłdany opis.
Version: 0.0.1
Author: Przemysław Kozłowski
Author URI: https://sztosit.eu
Text Domain: invmng
Domain Path: /lang
*/

if ( ! defined( 'INVMNG_PT_MAIN_NAME' ) ) {
	define( 'INVMNG_PT_MAIN_NAME', 'invmng' );
}

if( ! defined( 'INVMNG_PLUGIN_DIR_PATH' ) ) {
    define( 'INVMNG_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__) );
}

if( ! defined( 'INVMNG_PLUGIN_DIR_URL' ) ) {
    define( 'INVMNG_PLUGIN_DIR_URL', plugin_dir_url(__FILE__) );
}

spl_autoload_register( function( $classname ) {
    $class      = str_replace( array( '\\', '_' ), array( DIRECTORY_SEPARATOR, '-' ), strtolower($classname) ); 
    $classpath  = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'class-' . $class . '.php';
    
    if ( file_exists( $classpath ) ) {
        require_once $classpath;
    }
} );

add_action( 'init', array( 'INV_Main', 'init' ) );