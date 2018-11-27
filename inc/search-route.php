<?php

function my_theme_register_search() {
  register_rest_route('my-theme/v1', 'search', [
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'my_theme_search_results',
  ]);

}

add_action('rest_api_init', 'my_theme_register_search');

function my_theme_search_results() {
  return 'you reached a route';
}
