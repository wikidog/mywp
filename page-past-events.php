
<?php get_header(); ?>

<?php pageBanner([
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events.',
]); ?>

<div class="container container--narrow page-section">

<?php
  $today = date('Ymd');
  // the query
  $the_query = new WP_Query([
    'paged' => get_query_var('paged', 1),  //* pagination
    // 'posts_per_page' => 1,
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'desc',
    'meta_query' => [
      [
        'key' => 'event_date',
        'compare' => '<',
        'value' => $today,
        'type' => 'numeric',
      ]
    ]
  ]); ?>

<!-- Start the Loop. -->
<?php if ( $the_query->have_posts() ) : ?>


<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

<?php get_template_part('template-parts/content', 'event'); ?>

  <!-- Stop The Loop (but note the "else:" - see next line). -->
<?php endwhile; else : ?>
  <!-- The very first "if" tested to see if there were any Posts to -->
  <!-- display.  This "else" part tells what do if there weren't any. -->
  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php echo paginate_links([
  'total' => $the_query->max_num_pages,  //* pagination
]); ?>

</div> <!-- container -->

<?php get_footer(); ?>
