<?php get_header(); ?>
<?php get_sidebar(); ?>

<div class="main search">
  Search pages
  <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyfourteen' ), get_search_query() ); ?></h1>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <div class="project">
        <h3 class="project-name"><?php the_title(); ?></h3>
        <p class="project-description"><?php the_excerpt(); ?></p>
        <?php the_category(); ?>
      </div>
    <?php endwhile; ?>
  <?php else : echo 'Désolé aucun résultat.'; ?>
  <?php endif; ?>
</div>

<?php get_footer(); ?>