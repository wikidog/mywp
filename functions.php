
<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function my_theme_enqueue_styles() {

  //Enqueue theme style.css
  wp_enqueue_style( 'my-theme-style',
      get_stylesheet_directory_uri() . '/style.css',
      false,
      wp_get_theme()->get('Version')
  );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
