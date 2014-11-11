<?php
	
	$arguments = array(
	 'post_type' => 'produits',
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
?>