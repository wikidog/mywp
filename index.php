
<?php get_header(); ?>

<?php pageBanner([
  'title' => 'Welcome to our blog!',
  'subtitle' => 'Keep up with our latest news.',
]); ?>

<div class="container container--narrow page-section">

<!-- Start the Loop. -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="post-item">
  <!-- Display the Title as a link to the Post's permalink. -->
  <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

  <!-- Display the date (November 16th, 2009 format) and a link to other posts by this posts author. -->
  <div class="metabox">
    <p><?php the_time('F jS, Y'); ?> by <?php the_author_posts_link(); ?> in <?php echo get_the_category_list('; '); ?></p>
  </div>

  <!-- Display the Post's content in a div box. -->
  <div class="generic-content">
    <?php the_excerpt(); ?>
    <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
  </div>

</div>

  <!-- Stop The Loop (but note the "else:" - see next line). -->
<?php endwhile; else : ?>
  <!-- The very first "if" tested to see if there were any Posts to -->
  <!-- display.  This "else" part tells what do if there weren't any. -->
  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php echo paginate_links(); ?>

</div> <!-- container -->

<?php get_footer(); ?>
