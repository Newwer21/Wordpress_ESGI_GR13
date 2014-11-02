<?php get_header(); ?>
<?php get_sidebar(); ?>

<section class="main home">
Home page
<?php

	/* Affichage Phablettes, modifier l'id en fonction de tes catégories */

	// query_posts('post_types=produits');

	// echo '<h1>'.get_cat_name('2').'</h1>';

	// while (have_posts()) : the_post();

	// 	echo '<h3>'.get_the_title().'</h3>';

	// 	the_excerpt();

	// endwhile; wp_reset_query();

	// /* Affichage Tablettes, modifier l'id en fonction de tes catégories  */

	// query_posts('cat=3');

	// echo '<h1>'.get_cat_name('3').'</h1>';

	// while (have_posts()) : the_post();

	// 	echo '<h3>'.get_the_title().'</h3>';

	// 	the_excerpt();
	
	// endwhile; wp_reset_query();

	// /* Affichage Ordinateurs, modifier l'id en fonction de tes catégories  */

	// query_posts('cat=4');

	// echo '<h1>'.get_cat_name('4').'</h1>';

	// while (have_posts()) : the_post();

	// 	echo '<h3>'.get_the_title().'</h3>';

	// 	the_excerpt();
	// endwhile; wp_reset_query(); 

?>

<?php
$home_paged = (get_query_var('paged'));
$arguments = array(
 'post_type' => 'produits',
 'post_status' => 'publish',
 'types' => 'ordinateurs',
 'paged' => $home_paged
);
query_posts($arguments);
?>

<?php while (have_posts()) : the_post(); ?>
<div class="content-produits">
    <h3 class="project-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p class="project-description"><?php single_term_title(); ?> 	<?php the_post_thumbnail(); ?></p>
    <?php single_term_title(); ?> 
</div>
<?php endwhile; ?>
</section>
<?php get_footer(); ?>