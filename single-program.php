
<?php get_header(); ?>

<!-- Start the Loop. -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php pageBanner(); ?>

<div class="container container--narrow page-section">

  <div class="metabox metabox--position-up metabox--with-home-link">
     <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Programs Home</a> <span class="metabox__main"><?php the_title(); ?></span></p>
  </div>

  <div class="generic-content">
    <?php the_content(); ?>
  </div>

<!-- "related professors" -->
 <?php
  /**
   * related professors
   */
  // the query
  $the_query = new WP_Query([
    'posts_per_page' => -1,
    'post_type' => 'professor',
    'orderby' => 'title',
    'meta_query' => [
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
<h2 class="headline headline--medium"><?php echo the_title(); ?> Professor(s)</h2>

<ul class="professor-cards">
    <!-- the loop -->
  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <li class="professor-card__list-item">
      <a  class="professor-card" href="<?php the_permalink(); ?>">
        <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
        <span class="professor-card__name"><?php the_title(); ?></span>
      </a>
    </li>

  <?php endwhile; ?>
    <!-- end of the loop -->
</ul>

  <?php wp_reset_postdata(); ?>

<?php endif; ?>
<!-- end of "related professors" -->

<!-- "related events" -->
 <?php
  /**
   * related events
   */
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

    <!-- the loop -->
  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

  <?php get_template_part('template-parts/content', 'event'); ?>

  <?php endwhile; ?>
    <!-- end of the loop -->

  <?php wp_reset_postdata(); ?>

<?php endif; ?>
<!-- end of "related events" -->

</div>


  <!-- Stop The Loop (but note the "else:" - see next line). -->
<?php endwhile; else : ?>
  <!-- The very first "if" tested to see if there were any Posts to -->
  <!-- display.  This "else" part tells what do if there weren't any. -->
  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php get_footer(); ?>
