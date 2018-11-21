
<?php get_header(); ?>

<!-- Start the Loop. -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php pageBanner(); ?>

<div class="container container--narrow page-section">

  <div class="metabox metabox--position-up metabox--with-home-link">
     <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title(); ?></span></p>
  </div>

  <div class="generic-content">
    <?php the_content(); ?>
  </div>

  <?php $mapLocation = get_field('map_location'); ?>

  <div class="acf-map">
    <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
      <h3><?php the_title(); ?></h3>
      <?php echo $mapLocation['address']; ?>
    </div>
  </div>

<!-- "related professors" -->
 <?php
  /**
   * related programs
   */
  // the query
  $the_query = new WP_Query([
    'posts_per_page' => -1,
    'post_type' => 'program',
    'orderby' => 'title',
    'meta_query' => [
      [
        'key' => 'related_campus',
        'compare' => 'LIKE',
        'value' => '"' . get_the_id() . '"',
      ],
    ]
  ]);
?>

<?php if ( $the_query->have_posts() ) : ?>

<hr class="section-break">
<h2 class="headline headline--medium">Programs Available At This Campus</h2>

<ul class="min-list link-list">
    <!-- the loop -->
  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <li>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </li>

  <?php endwhile; ?>
    <!-- end of the loop -->
</ul>

  <?php wp_reset_postdata(); ?>

<?php endif; ?>
<!-- end of "related programs" -->

</div>


  <!-- Stop The Loop (but note the "else:" - see next line). -->
<?php endwhile; else : ?>
  <!-- The very first "if" tested to see if there were any Posts to -->
  <!-- display.  This "else" part tells what do if there weren't any. -->
  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php get_footer(); ?>
