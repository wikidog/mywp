<?php

function my_theme_register_search() {
  register_rest_route('my-theme/v1', 'search', [
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'my_theme_search_results',
  ]);

}

add_action('rest_api_init', 'my_theme_register_search');

//* We only need to output array
//* WordPress will convert array to JSON format
function my_theme_search_results() {
  // return ['red', 'yellow', 'blue'];
  $the_query = new WP_Query([
    'post_type' => 'professor'
  ]);

  $rtn = [];

  while ($the_query->have_posts()) {
    $the_query->the_post();
    array_push($rtn, [
      'title' => get_the_title(),
      'permalink' => get_the_permalink(),
    ]);
  }

  return $rtn;
}
