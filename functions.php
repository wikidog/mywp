
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


/**
 * Theme Setup
 */
function my_theme_setup() {
  // enables plugins and themes to manage the document <title> tag
  add_theme_support('title-tag');

  // register navigation menus
  register_nav_menus(array('headerMenuLocation' => 'Header Menu Location'));
}

add_action('after_setup_theme', 'my_theme_setup');

/**
 * Load front-end CSS styles and js
 */
function my_theme_scripts() {

  // CSS
  //
  wp_enqueue_style( 'my-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

  wp_enqueue_style( 'my-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

  //Enqueue theme style.css
  wp_enqueue_style( 'my-theme-style', get_theme_file_uri('/style.css'), false, wp_get_theme()->get('Version'));

  // js
  //
  wp_enqueue_script('my-theme-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
}

add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );
