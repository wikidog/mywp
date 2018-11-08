
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

<?php $theParent = wp_get_post_parent_id(get_the_id()); ?>
<?php if ($theParent) : ?>
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>
<?php endif; ?>

    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_the_permalink(get_the_id()) ?>"><?php the_title(); ?></a></h2>
      <ul class="min-list">
        <li class="current_page_item"><a href="#">Our History</a></li>
        <li><a href="#">Our Goals</a></li>
      </ul>
    </div>

    <div class="generic-content">
    <?php the_content(); ?>
    </div>

  </div>


  <!-- Display the Title as a link to the Post's permalink. -->
  <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

  <!-- Display the date (November 16th, 2009 format) and a link to other posts by this posts author. -->
  <small><?php the_time('F jS, Y'); ?> by <?php the_author_posts_link(); ?></small>

  <!-- Display the Post's content in a div box. -->
  <div class="entry">
    <?php the_content(); ?>
  </div>

  <!-- Display a comma separated list of the Post's Categories. -->
  <p class="postmetadata"><?php _e( 'Posted in' ); ?> <?php the_category( ', ' ); ?></p>
  </div> <!-- closes the first div box -->

  <!-- Stop The Loop (but note the "else:" - see next line). -->
<?php endwhile; else : ?>
  <!-- The very first "if" tested to see if there were any Posts to -->
  <!-- display.  This "else" part tells what do if there weren't any. -->
  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php get_footer(); ?>
