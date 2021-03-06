
<?php get_header(); ?>

<!-- Start the Loop. -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php pageBanner([]); ?>

<div class="container container--narrow page-section">

  <div class="metabox metabox--position-up metabox--with-home-link">
     <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home</a> <span class="metabox__main"><?php the_title(); ?></span></p>
  </div>

  <div class="generic-content">
    <?php the_content(); ?>
  </div>

<?php
  $relatedPrograms = get_field('related_programs');
  if ($relatedPrograms) {
?>
    <hr class="section-break">
    <h2 class="headline headline--medium">Related Program(s)</h2>
    <ul class="link-list min-list">
<?php foreach ($relatedPrograms as $program) { ?>
      <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
<?php } ?>
    </ul>
<?php } ?>

</div>

  <!-- Stop The Loop (but note the "else:" - see next line). -->
<?php endwhile; else : ?>
  <!-- The very first "if" tested to see if there were any Posts to -->
  <!-- display.  This "else" part tells what do if there weren't any. -->
  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <!-- REALLY stop The Loop. -->
<?php endif; ?>

<?php get_footer(); ?>
