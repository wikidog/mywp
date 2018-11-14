
<?php get_header(); ?>

<?php pageBanner([
  'title' => 'All Programs',
  'subtitle' => 'There is something for everyone. Have a look around',
]); ?>

<div class="container container--narrow page-section">

<!-- Start the Loop. -->
<?php if ( have_posts() ) : ?>

<ul class="link-list min-list">

<?php while ( have_posts() ) : the_post(); ?>

  <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>


<?php endwhile; ?>

</ul>

<?php endif; ?>

<?php echo paginate_links(); ?>

</div> <!-- container -->

<?php get_footer(); ?>
