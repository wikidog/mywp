
<?php get_header(); ?>

<!-- Start the Loop. -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php pageBanner(); ?>

<div class="container container--narrow page-section">

  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main"><?php the_time('F jS, Y'); ?> by <?php the_author_posts_link(); ?> in <?php echo get_the_category_list('; '); ?></span></p>
  </div>

  <div class="generic-content">
    <?php the_content(); ?>
  </div>

</div>


  <!-- Stop The Loop (but note the "else:" - see next line). -->
<?php endwhile; else : ?>
  <!-- The very first "if" tested to see if there were any Posts to -->
  <!-- display.  This "else" part tells what do if there weren't any. -->
  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php get_footer(); ?>
