<?php
/**
* The maker-4ym core functions.
*
* @link       https://4youmaker.com
* @since      1.0.0
*
* @package    Maker_4ym
* @subpackage Maker_4ym/includes
*/

//Enqueuing admin styles
function maker_4ym_admin_styles() {
    wp_register_style( 'maker_4ym_admin_stylesheet', plugins_url( '/css/style.css',__FILE__ ) );
    wp_enqueue_style( 'maker_4ym_admin_stylesheet' );
}

add_action( 'maker_enqueue_scripts', 'maker_4ym_admin_styles' );

//Footer text 
function maker_4ym_admin_footer_text {
  echo '<img src="' . plugins_url( 'images/4youmakerlogo.png', __FILE__ ) . '"> Estos tutoriales son hechos para ti por <a href="https://4youmaker.com">4youmaker</a>.';
}

add_filter( 'maker_footer_text', 'maker_4ym_admin_footer_text');
