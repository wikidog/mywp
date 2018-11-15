
<?php get_header(); ?>

<?php pageBanner([
  'title' => 'Our Campuses',
  'subtitle' => 'We have several conveniently located campuses',
]); ?>

<div class="container container--narrow page-section">

<!-- Start the Loop. -->
<?php if ( have_posts() ) : ?>

<ul class="link-list min-list">

<?php while ( have_posts() ) : the_post(); ?>

  <?php $mapLocation = get_field('map_location'); ?>

  <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>"></div>

  <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

  <?php print_r(get_field('map_location')); ?>


<?php endwhile; ?>

</ul>

<?php endif; ?>

<?php echo paginate_links(); ?>

</div> <!-- container -->

<?php get_footer(); ?>
