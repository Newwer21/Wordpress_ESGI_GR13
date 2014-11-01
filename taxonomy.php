<?php get_header(); ?>
<?php get_sidebar(); ?>

<div class="main taxonomy">
	In taxonomy pages..
  <h1>Produits concernant : <?php single_cat_title(); ?></h1>
  <div class="clear_fix"></div>
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <div class="content-produits">
        <h3 class="project-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p class="project-description"><?php the_excerpt(); ?></p>
        <?php the_category(); ?> 
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>
<div class="fix_clear"></div>

<?php get_footer(); ?>