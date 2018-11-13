
<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Past Events</h1>
    <div class="page-banner__intro">
      <p>A recap of our past events.</p>
    </div>
  </div>
</div>

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

  <div class="event-summary">
    <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
      <span class="event-summary__month">
        <?php
          $eventDate = new DateTime(get_field('event_date'));
          echo $eventDate->format('M');
        ?>
      </span>
      <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
    </a>
    <div class="event-summary__content">
      <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
      <p><?php echo wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
    </div>
  </div>

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
