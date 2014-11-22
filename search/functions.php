<?php

	function get_taxonomy_for_post_types() {

		// $infos = array();
		$post = array();

		$terms_args = array('hide_empty' => false);
		$args_posts = array('_builtin' => false);

		$post_types = get_post_types($args_posts, 'names');

		foreach ($post_types as $post_type) {

			$taxonomy = get_object_taxonomies($post_type);

			$post[$post_type] = $taxonomy[0];
			// $infos[] = $post;
			
		}
		// var_dump($post);

		return $post;
	}

	/* Fonction Ajax permettant l'affichage Produit à l'appel 
	d'une catégorie par défaut (sans choix critère)
	*/

	add_action( 'wp_ajax_search_produits_init', 'search_produits_init' );

		function search_produits_init() {
		    global $wpdb; // this is how you get access to the database

		    $home_paged = (get_query_var('paged'));
		    $type = $_POST ['type']; 
		    $taxonomy = $_POST['lib_categorie'];

		    $arguments = array(
				'post_type' => $_POST['post_type'],
				'post_status' => 'publish',
				 $taxonomy => $type, // trie par type de Produits
				'paged' => $home_paged
			);

			query_posts($arguments);

			ob_start(); ?>
			<h2><?= $type; ?></h2>
	<?php while (have_posts()) : the_post(); ?>

				<article class="article-<?= $type; ?>">
				 	<h3 class="phab-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				    <p class="phab-description"><?php single_tag_title(); ?> 	<?php the_post_thumbnail('medium'); ?></p> 
				</article>
	<?php endwhile; ?>
				<div class="fix_clear"></div>
	<?php $content = ob_get_clean(); 
			echo $content;

		    die(); // this is required to return a proper result
		}

	/* Fonction Ajax permettant l'affichage Produit après modification de critère */

	add_action( 'wp_ajax_search_produits_critere', 'search_produits_critere' );

		function search_produits_critere() {
			$post_type = $_POST['post_type'];
			$type = $_POST['type'];
			$taxonomy = $_POST['lib_categorie'];
			$meta_relation_criteres = array();

			$tab_processeurs = isset($_POST['processeurs']) ? $_POST['processeurs'] : array();
			$tab_memoires_vives = isset($_POST['memoires_vives']) ? $_POST['memoires_vives'] : array();

			$array_processeurs = array();
			$array_memoires_vives = array();

			// $meta = array();
			$meta_relation_processeurs['relation'] = 'AND'; // 1ère meta avec les criteres

			if (sizeof($tab_processeurs) != 0)
			{
				foreach ($tab_processeurs as $process) {
					$array_processeurs['key'] = 'processeur_ordinateur';
					$array_processeurs['value'] = $process;
					$array_processeurs['compare'] = '=';

					$meta_relation_processeurs[] = $array_processeurs;
				}
				
			}
			$meta_relation_ram['relation'] = 'AND';
			if (sizeof($tab_memoires_vives) != 0)
			{
				foreach ($tab_memoires_vives as $ram) {
					$array_memoires_vives['key'] = 'ram_ordinateur';
					$array_memoires_vives['value'] = $ram;
					$array_memoires_vives['compare'] = '=';
				
				$meta_relation_processeurs[] = $array_memoires_vives;
				}

			}
			// $meta_relation[] = $meta_relation_criteres;

			$meta_relation[] = $meta_relation_processeurs;
			// $meta_relation[] = $meta_relation_ram;
			/* Prix à la fin ! */
			$array_prix = array('key' => 'prix_ordinateur', 'value' => array(20,300), 'type' => 'numeric', 'compare' => 'BETWEEN');

			// $meta_relation[] = $array_prix;
			// $meta_relation[] = $array_memoires_vives;
			$meta = $meta_relation;

			$args = array(
				'post_type'  => $post_type,
				 $taxonomy => $type,
				// 'meta_query' => array(
				// 	'relation' => 'OR',
				// 	// $meta_processeurs
				// 	$array_processeurs
				 'meta_query' => $meta
			 	   //  array (
			 	   	//  'key' 	=> 'processeur_ordinateur',
			 	   	//  'value' =>	'Intel',
			 	   	//  'compare' => '=',
			 	   //  ),
					// array(
					// 	'key'     => 'prix_produit',
					// 	'value'   => array( 20, 300 ),
					// 	'type'    => 'numeric',
					// 	'compare' => 'BETWEEN',
					// ),
				// ),
				
			);

			print_r($args);

			// die;
			$query = new WP_Query( $args );

			ob_start(); 
			while ($query->have_posts()) : $query->the_post(); ?>
				<article class="article-<?= $type; ?>">
				 	<h3 class="phab-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				    <p class="phab-description"><?php the_post_thumbnail('medium'); ?></p> 
				</article>

	<?php 	endwhile;
			$content = ob_get_clean();	
			echo $content;

			die;
		}

	/* Fonction qui permet d'afficher toutes les valeurs d'un champs personnalisé */
	function get_all_custom_fields_values($custom_field) {
		global $wpdb;
		$result = array();
		$visited_values = array();

		$values = $wpdb->get_col("SELECT meta_value 
			FROM $wpdb->postmeta WHERE meta_key = '$custom_field'" );
		
		// var_dump($values);

		for($i = 0; $i < sizeof($values); $i++)
		{
			if ($values[$i] != '' && (!in_array($values[$i], $visited_values)))
			{	
				$cpt = 0;
				for ($j = $i; $j < sizeof($values); $j++)
				{
					if ($values[$j] == $values[$i])
						$cpt++;
				}

				$result[$values[$i]] = $cpt;
				$visited_values[] = $values[$i];
			}
		}
		// var_dump($values);
		return $result;
	}
	
?>