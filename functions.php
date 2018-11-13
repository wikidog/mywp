
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
  register_nav_menus(array('footerLocationOne' => 'Footer Location One'));
  register_nav_menus(array('footerLocationTwo' => 'Footer Location Two'));
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

/**
 * register custom post types
 **   the wp-content/mu-plugins directory probably is a better place
 */
function my_theme_post_types() {

  // Event post type
  //
  register_post_type('event', [
    'supports' => ['title', 'editor', 'excerpt'],
    'rewrite' => ['slug' => 'events'],
    'has_archive' => true,
    'public' => true,
    'labels' => [
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event',
    ],
    'menu_icon' => 'dashicons-calendar', // WordPress dash icons
  ]);

  // Program post type
  //
  register_post_type('program', [
    'supports' => ['title', 'editor'],
    'rewrite' => ['slug' => 'programs'],
    'has_archive' => true,
    'public' => true,
    'labels' => [
      'name' => 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program',
    ],
    'menu_icon' => 'dashicons-awards', // WordPress dash icons
  ]);

}

add_action('init', 'my_theme_post_types');

/**
 *  customize WordPress's main query
 */
function my_theme_adjust_queries($query) {

  // adjust query for Program post type
  if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'asc');
    $query->set('post_per_page', -1);
  }

  // adjust query for Event post type
  if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'desc');
  }
}

add_action('pre_get_posts', 'my_theme_adjust_queries');
