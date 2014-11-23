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

	add_action( 'wp_ajax_search_produits_criteres', 'search_produits_criteres' );

		function search_produits_criteres() {

			global $wpdb, $post;
			$post_type = $_POST['post_type'];

			$type = $_POST['type'];
			// Partie ordinateurs
			if ( $post_type != 'ordinateurs' && $post_type != 'tablettes' )
			{
				echo 'KO';
				return;
			}

			if ($post_type == 'ordinateurs')
			{
				// echo 'iici';
				$col = 'ordinateur';
				$tab_processeurs = !empty($_POST['processeurs']) ? $_POST['processeurs'] : array();
				$tab_memoires_ram = !empty($_POST['memoires_vives']) ? $_POST['memoires_vives'] : array();
				$tab_constructeurs = !empty($_POST['constructeurs']) ? $_POST['constructeurs'] : array();

				// $taxonomy = $_POST['lib_categorie'];

				// SELECT * FROM `wp_ordinateurs` 
				// where (constructeur_ordinateur = 'samsung' OR constructeur_ordinateur = 'lenovo')
				// AND (ram_ordinateur = 6 OR ram_ordinateur = 4)
				// AND (processeur_ordinateur = 'intel' OR processeur_ordinateur = 'amd' OR processeur_ordinateur = 'proc')
				// AND (dd_ordinateur = 700)

				// print_r($tab_processeurs);

				$table = $wpdb->prefix. "$post_type ";

				$sql = "SELECT id_post FROM $table";
				
				// print_r($_POST);

				// SQL processeur
				$taille = sizeof($tab_processeurs);

				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?

					if (sizeof($tab_processeurs) == 1)
					{
						// echo '<br />seul';
						$sql .= " processeur_$col = '$tab_processeurs[0]'";
					}
					else
					{
						echo 'Pas seul';
						$sql .= "(";
							$processeurs_sql = '';
						foreach ($tab_processeurs as $process) {
							$processeurs_sql .= " processeur_$col = '$process' OR";
						}
						// $pos_dern_or = srtchr($processeurs_sql, 'OR');
						$processeurs_sql = substr($processeurs_sql, 0, strlen($processeurs_sql) - 2);

						$sql .= "$processeurs_sql ) ";
					}
				}// if !empty $taille

				// SQL constructeurs
				$taille = sizeof($tab_constructeurs);

				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?
					
					if (sizeof($tab_constructeurs) == 1)
					{
						// echo '<br />seul';
						$sql .= " constructeur_$col = '$tab_constructeurs[0]'";
					}
					else
					{
						// echo 'Pas seul';
						$sql .= "(";
						$constructeurs_sql = '';
						
						foreach ($tab_constructeurs as $construct) {
							$constructeurs_sql .= " constructeur_$col = '$construct' OR";
						}
						// $pos_dern_or = srtchr($processeurs_sql, 'OR');
						$constructeurs_sql = substr($constructeurs_sql, 0, strlen($constructeurs_sql) - 2);

						$sql .= "$constructeurs_sql ) ";
					}
				} // if !empty $taille

				// SQL memoire vive
				$taille = sizeof($tab_memoires_ram);
				
				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?
					if (sizeof($tab_memoires_ram) == 1)
					{
						// echo '<br />seul';
						$sql .= " ram_$col = $tab_memoires_ram[0]";
					}
					else
					{
						// echo 'Pas seul';
						$sql .= "(";
						$ram_sql = '';
						
						foreach ($tab_memoires_ram as $ram) {
							$ram_sql .= " ram_$col = $ram OR";
						}
						// $pos_dern_or = srtchr($processeurs_sql, 'OR');
						$ram_sql = substr($ram_sql, 0, strlen($ram_sql) - 2);

						$sql .= "$ram_sql ) ";
					}
				}// if !empty $taille

				echo $sql .= " AND type_$col = '$type';";
			} // if $post_type == ordinateurs
			else if ($post_type == 'tablettes')
			{


			}	
			// echo $sql;

			$results = $wpdb->get_results($sql, OBJECT );

			// ob_start();

			foreach ($results as $sql_post) :

				$post = get_post($sql_post->id_post); // Récupration du post
				setup_postdata($post); // Récupréation des infos pour The Loop. ?>

				<div class="resultat">
					<div class="title_resultat"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
					<div class="image_resultat"><?php the_post_thumbnail('medium' ); ?></div>
					<div class="description_resultat"><?php the_excerpt(); ?></div>
				</div>

			<?php // print_r($post);
			endforeach;

			// $content = ob_get_clean(); 
			// echo $content;
			// print_r($results);
			die; // Nécéssaire !
				
		}	

		/* Renvoie where ou and pour créer la requete SQL */
		function where_or_and($chaine) {

			if (strstr($chaine, "WHERE") === false)

				return "WHERE";
			else
				return "AND";
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