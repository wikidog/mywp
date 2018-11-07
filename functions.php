
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

  wp_enqueue_script('my-theme-js', get_stylesheet_directory_uri() . '/js/scripts-bundled.js', NULL, '1.0', true);

  wp_enqueue_style( 'my-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

  wp_enqueue_style( 'my-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

  //Enqueue theme style.css
  wp_enqueue_style( 'my-theme-style',
      get_stylesheet_directory_uri() . '/style.css',
      false,
      wp_get_theme()->get('Version')
  );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
