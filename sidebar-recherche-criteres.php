<aside class="sidebar-rech-criteres"><?php dynamic_sidebar('zone_widget_gauche_recherche'); ?>
	
	<div class="fix-clear"></div>
</aside>

<!-- 
Display posts that have meta key 'color' NOT LIKE value 'blue' OR meta key 'price' with values BETWEEN 20 and 100:

$args = array(
	'post_type'  => 'product',
	'meta_query' => array(
		'relation' => 'OR',
		array(
			'key'     => 'color',
			'value'   => 'blue',
			'compare' => 'NOT LIKE',
		),
		array(
			'key'     => 'price',
			'value'   => array( 20, 100 ),
			'type'    => 'numeric',
			'compare' => 'BETWEEN',
		),
	),
);
$query = new WP_Query( $args ); 
-->
<!-- Affiche produits de type tablettes avec processeur Proc et prix entre 20 et 300
$args = array(
	'post_type'  => 'produits',
	'types' => 'phablettes',
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key'     => 'processeur_produit',
			'value'   => 'Proc',
			'compare' => '=',
		),
		array(
			'key'     => 'prix_produit',
			'value'   => array( 20, 300 ),
			'type'    => 'numeric',
			'compare' => 'BETWEEN',
		),
	),
	
);
$query = new WP_Query( $args );

while ($query->have_posts()) : $query->the_post();
	the_title();
endwhile; -->