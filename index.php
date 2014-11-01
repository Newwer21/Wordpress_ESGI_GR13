<?php get_header(); ?>

<div id="main-content">
	<?php get_sidebar(); ?>
	<section class="content">
		<?php 
			$cat = (get_terms( category )); 
			// print_r($cat);
			foreach ($cat as $c) :
				if ($c->parent == 0) : ?><!-- Permet la sélection des catégories parents uniquement. -->
					<?php $posts = new WP_Query('cat='.$c->term_id); ?>
					<article class="categories-list">
						<header class="categorie-title">
							<h3><?php echo $c->name; ?></h3>
						</header>
						<?php while ($posts->have_posts()): $posts->the_post(); ?>
							<section class="categories-sections">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<?php the_content(); ?>
							</section>
						<?php endwhile; ?>
					</article>
					<div class="fix_clear"></div><!-- Séparation entre les différents produits -->
				<?php endif; ?>
			<?php endforeach; ?>

<?php get_footer(); ?>