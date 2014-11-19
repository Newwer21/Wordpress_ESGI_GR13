<?php get_header(); ?>
<?php get_sidebar(); ?>

<section class="main home">
Home page
	<div class="fix_clear"></div>

	<article class="content-produits">
		<section class="content-produits-ordinateurs">
			<header class="content-title"><h3>Les ordinateurs</h3></header>
			<div class="fix_clear"></div>
		
<?php
	$home_paged = (get_query_var('paged'));
	$arguments = array(
	 'post_type' => 'ordinateurs',
	 'post_status' => 'publish',
/*	 'types' => 'ordinateurs',
*/	 'paged' => $home_paged
	);
	query_posts($arguments);
	
	while (have_posts()) : the_post(); 
?>
			<article class="article-ordinateurs">
			 	 <h3 class="ordi-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			    <p class="ordi-description"><?php single_tag_title(); ?> 	<?php the_post_thumbnail('medium'); ?></p> 
			</article>
<?php endwhile; ?>
			<div class="fix_clear"></div>
		</section> <!-- .content-produits-ordinateurs -->

		<section class="content-produits-tablettes">
			<header class="content-title"><h3>Les tablettes</h3></header>
<?php


	$arguments = array(
	 'post_type' => 'tablettes',
	 'post_status' => 'publish',
	 'paged' => $home_paged
	);
	query_posts($arguments);
	
	while (have_posts()) : the_post(); 
?>
			<article class="article-tablettes">
			 	<h3 class="tab-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			    <p class="tab-description"><?php single_tag_title(); ?> 	<?php the_post_thumbnail('medium'); ?></p> 
			</article>
<?php endwhile; ?>
			<div class="fix_clear"></div>
		</section>

		<section class="content-produits-phablettes">
			<header class="content-title"><h3>Les phablettes</h3></header>
<?php
	$arguments = array(
	 'post_type' => 'tablettes',
	 'post_status' => 'publish',
	 'types' => 'phablettes',
	 'paged' => $home_paged
	);
	query_posts($arguments);
	
	while (have_posts()) : the_post(); 
?>
			<article class="article-phablettes">
			 	<h3 class="phab-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			    <p class="phab-description"><?php single_tag_title(); ?> 	<?php the_post_thumbnail('medium'); ?></p> 
			</article>
<?php endwhile; ?>
			<div class="fix_clear"></div>
		</section> <!-- .content-produits-phablettes -->
	</article> <!-- .content-produit -->
<?php get_footer(); ?>