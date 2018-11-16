
<?php get_header(); ?>

<?php pageBanner([
  'title' => 'Our Campuses',
  'subtitle' => 'We have several conveniently located campuses',
]); ?>

<div class="container container--narrow page-section">

<!-- Start the Loop. -->
<?php if ( have_posts() ) : ?>

<div class="acf-map">

<?php while ( have_posts() ) : the_post(); ?>

  <?php $mapLocation = get_field('map_location'); ?>

  <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>"></div>

<?php endwhile; ?>

</div>

<?php endif; ?>

<?php echo paginate_links(); ?>

</div> <!-- container -->

<?php get_footer(); ?>
