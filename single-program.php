
<?php get_header(); ?>

<!-- Start the Loop. -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php the_title(); ?></h1>
    <div class="page-banner__intro">
      <p>FIX ME!!!</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">

  <div class="metabox metabox--position-up metabox--with-home-link">
     <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Program Home</a> <span class="metabox__main"><?php the_title(); ?></span></p>
  </div>

  <div class="generic-content">
    <?php the_content(); ?>
  </div>

 <?php
  $today = date('Ymd');
  // the query
  $the_query = new WP_Query([
    'posts_per_page' => -1,
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'desc',
    'meta_query' => [
      [
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric',
      ],
      [
        'key' => 'related_programs',
        'compare' => 'LIKE',
        'value' => '"' . get_the_id() . '"',
      ],
    ]
  ]);
?>

<?php if ( $the_query->have_posts() ) : ?>

<hr class="section-break">
<h2 class="headline headline--medium">Upcoming <?php echo the_title(); ?> Events</h2>

    <!-- pagination here -->

    <!-- the loop -->
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

  <?php endwhile; ?>
    <!-- end of the loop -->

    <!-- pagination here -->

  <?php wp_reset_postdata(); ?>

<?php endif; ?>

</div>


  <!-- Stop The Loop (but note the "else:" - see next line). -->
<?php endwhile; else : ?>
  <!-- The very first "if" tested to see if there were any Posts to -->
  <!-- display.  This "else" part tells what do if there weren't any. -->
  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php get_footer(); ?>
