<?php
/**
 * PopularFX functions and definitions
 *
 * @link https://popularfx.com/docs/
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PopularFX
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

//Enqueue styles
function popularfx_child_enqueue_styles() {
    wp_enqueue_style( 'custom-game-css', get_stylesheet_directory_uri() . '/css/game.css' );
    
	wp_enqueue_style( 'popularfx-theme-css', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'popularfx_child_enqueue_styles', 10 );
//Enqueue styles end

// admin menu item adding 
function register_my_custom_menu_page() {
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  add_menu_page( '', 'Admin OTP Generate', 'manage_options', '/game-admin', '', 'dashicons-text', 3 );
  add_menu_page( '', 'Game Admin', 'manage_options', '/game-content', '', 'dashicons-admin-generic', 3 );
}
add_action( 'admin_menu', 'register_my_custom_menu_page' );

function hello( $user_id ){
    um_fetch_user( $user_id );
    UM()->user()->auto_login( $user_id );
    wp_redirect( '/game' ); exit;
}
add_action( 'um_registration_complete', 'hello' ,1 );
?>