
<?php get_header(); ?>

<!-- Start the Loop. -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php pageBanner(); ?>

  <div class="container container--narrow page-section">

<?php
  // only display the following section if the page has parent page
  //
  $theParent = wp_get_post_parent_id(get_the_id());

  if ($theParent) {
?>
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>
<?php
  }
?>

<?php
  // only display the following section
  //   if the page has parent page or has child page(s)
  //
  $hasChildren = get_pages(array(
    'child_of' => get_the_ID(),
  ));

  if ($theParent || $hasChildren) {
?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_the_permalink(get_the_id($theParent)) ?>"><?php echo get_the_title($theParent); ?></a></h2>
      <ul class="min-list">
        <?php
          if ($theParent) {
            $findChildrenOf = $theParent;
          } else {
            $findChildrenOf = get_the_id();
          }
          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order',
          ));
        ?>
      </ul>
    </div>
<?php
  }
?>

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
