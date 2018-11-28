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
function my_theme_search_results($data) {
  // return ['red', 'yellow', 'blue'];
  $the_query = new WP_Query([
    'post_type' => ['post', 'page', 'professor', 'program', 'campus', 'event'],
    's' => sanitize_text_field($data['term']),
  ]);

  $rtn = [
    'generalInfo' => [],
    'professors' => [],
    'programs' => [],
    'events' => [],
    'campuses' => [],
  ];

  while ($the_query->have_posts()) {
    $the_query->the_post();

    $post_type = get_post_type();
    $item = [
      'title' => get_the_title(),
      'permalink' => get_the_permalink(),
      'postType' => $post_type,
      'authorName' => get_the_author(),
    ];

    if ($post_type === 'professor') {
      array_push($rtn['professors'], [
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'image' => get_the_post_thumbnail_url(0, 'professorLandscape'),
      ]);
    } else if ($post_type === 'program') {
      array_push($rtn['programs'], $item);
    } else if ($post_type === 'campus') {
      array_push($rtn['campuses'], $item);
    } else if ($post_type === 'event') {
      $eventDate = new DateTime(get_field('event_date'));
      array_push($rtn['events'], [
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'month' => $eventDate->format('M'),
        'day' => $eventDate->format('d'),
        'description' => wp_trim_words(get_the_content(), 18),
      ]);
    } else {
      array_push($rtn['generalInfo'], $item);
    }
  }

  return $rtn;
}
