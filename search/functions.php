<?php

add_action('init', 'create_table_ordinateurs');
add_action('init', 'create_table_tablettes');

function create_table_ordinateurs()
	{
		global $wpdb;

		$table = $wpdb->prefix . 'ordinateurs';
		
		if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table )
		{
			$sql = "CREATE TABLE $table (
					  `id_ordinateur` smallint(2) NOT NULL AUTO_INCREMENT,
					  `type_ordinateur` varchar(10) NOT NULL,
					  `constructeur_ordinateur` varchar(25) NOT NULL,
					  `prix_ordinateur` decimal(5,2) NOT NULL,
					  `processeur_ordinateur` varchar(10) NOT NULL,
					  `ram_ordinateur` tinyint(2) NOT NULL,
					  `chipset_ordinateur` varchar(15) NOT NULL,
					  `dd_ordinateur` smallint(4) NOT NULL,
					  `tactile_ordinateur` tinyint(1) NOT NULL COMMENT '1 = Oui/Non',
					  `os_ordinateur` varchar(15) NOT NULL,
					  `poids_ordinateur` decimal(2,1) NOT NULL,
					  `resolution_ordinateur` decimal(3,1) NOT NULL,
					  `id_post` int(11) NOT NULL,
					  PRIMARY KEY (`id_ordinateur`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			if (dbDelta($sql) == NULL)
			{
				echo "Erreur à la creation de la table $table"; 
				die();
			}
		} // if $wpdb->get_var();
	}

	function create_table_tablettes()
	{
		global $wpdb;

		$table = $wpdb->prefix . 'tablettes';
		
		if ( $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table )
		{
			$sql = "CREATE TABLE $table (
					  `id_tablette` smallint(2) NOT NULL AUTO_INCREMENT,
					  `type_tablette` varchar(10) NOT NULL,
					  `constructeur_tablette` varchar(25) NOT NULL,
					  `prix_tablette` decimal(5,2) NOT NULL,
					  -- `processeur_tablette` varchar(10) NOT NULL,
					  -- `ram_ordinateur` tinyint(2) NOT NULL,
					  -- `chipset_ordinateur` varchar(15) NOT NULL,
					  `dd_tablette` smallint(4) NOT NULL,
					  `bluetooth_tablette` tinyint(1) NOT NULL COMMENT '1 = Oui/Non',
					  -- `os_tablette` varchar(15) NOT NULL,
					  -- `poids_ordinateur` decimal(2,1) NOT NULL,
					  `resolution_tablette` decimal(3,1) NOT NULL,
					  `id_post` int(11) NOT NULL,
					  PRIMARY KEY (`id_tablette`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			if (dbDelta($sql) == NULL)
			{
				echo "Erreur à la creation de la table $table"; 
				die();
			}
		} // if $wpdb->get_var();
	}

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

		    $post_type = $_POST['post_type'];

		    if ($post_type == 'ordinateurs') $col = "ordinateur";
		    else $col = 'tablette';

		    $arguments = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				 $taxonomy => $type, // trie par type de Produits
				'paged' => $home_paged
			);

			query_posts($arguments);

			ob_start(); ?>
			<table>
				<tr>
					<th>Nom</th>
					<th>Prix</th>
				</tr>
	<?php while (have_posts()) : the_post(); ?>
	<?php $prix = get_post_custom_values("prix_$col"); ?>
				<tr>
					<td>
						<div class="title_resultat"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
						<div class="image_resultat"><?php the_post_thumbnail('medium' ); ?></div>
						<div class="description_resultat"><?php the_excerpt(); ?></div>
						<?php //single_cat_title(); ?>
					</td>
					<td><?= $prix[0]; ?></td>
				</tr>
	<?php endwhile; ?>
				</table>
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
			$prix_min = isset($_POST['prix_min']) ? $_POST['prix_min'] : '';
			$prix_max = isset($_POST['prix_max']) ? $_POST['prix_max'] : '';

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
				$tab_disques_durs = !empty($_POST['disques_durs']) ? $_POST['disques_durs'] : array();
				$tab_systemes_exp = !empty($_POST['systemes_exploitations']) ? $_POST['systemes_exploitations'] : array();
				$tab_resolutions_ecrans = !empty($_POST['resolutions_ecrans']) ? $_POST['resolutions_ecrans'] : array();

				// $taxonomy = $_POST['lib_categorie'];

				// SELECT * FROM `wp_ordinateurs` 
				// where (constructeur_ordinateur = 'samsung' OR constructeur_ordinateur = 'lenovo')
				// AND (ram_ordinateur = 6 OR ram_ordinateur = 4)
				// AND (processeur_ordinateur = 'intel' OR processeur_ordinateur = 'amd' OR processeur_ordinateur = 'proc')
				// AND (dd_ordinateur = 700)

				// print_r($tab_processeurs);

				$table = $wpdb->prefix. "$post_type ";

				$sql = "SELECT id_post FROM $table";
				
				print_r($_POST);

				// SQL processeur
				$taille = sizeof($tab_processeurs);

				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?

					if (sizeof($tab_processeurs) == 1)
					{
						// echo '<br />seul';
						$sql .= "processeur_$col = '$tab_processeurs[0]'";
					}
					else
					{
						// echo 'Pas seul';
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

				// SQL Disque Dur
				$taille = sizeof($tab_disques_durs);
				
				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?
					if (sizeof($tab_disques_durs) == 1)
					{
						// echo '<br />seul';
						$sql .= " dd_$col = $tab_disques_durs[0]";
					}
					else
					{
						// echo 'Pas seul';
						$sql .= "(";
						$dd_sql = '';
						
						foreach ($tab_disques_durs as $disque) {
							$dd_sql .= " dd_$col = $disque OR";
						}
						// $pos_dern_or = srtchr($processeurs_sql, 'OR');
						$dd_sql = substr($dd_sql, 0, strlen($dd_sql) - 2);

						$sql .= "$dd_sql ) ";
					}
				}// if !empty $taille

				// SQL OS
				$taille = sizeof($tab_systemes_exp);
				
				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?
					if (sizeof($tab_systemes_exp) == 1)
					{
						// echo '<br />seul';
						$sql .= " os_$col = '$tab_systemes_exp[0]'";
					}
					else
					{
						// echo 'Pas seul';
						$sql .= "(";
						$os_sql = '';
						
						foreach ($tab_systemes_exp as $os) {
							$os_sql .= " os_$col = '$os' OR";
						}
						// $pos_dern_or = srtchr($processeurs_sql, 'OR');
						$os_sql = substr($os_sql, 0, strlen($os_sql) - 2);

						$sql .= "$os_sql ) ";
					}
				}// if !empty $taille

				// SQL Résolution écran
				$taille = sizeof($tab_resolutions_ecrans);
				
				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?
					if (sizeof($tab_resolutions_ecrans) == 1)
					{
						// echo '<br />seul';
						$sql .= " resolution_$col = $tab_resolutions_ecrans[0]";
					}
					else
					{
						// echo 'Pas seul';
						$sql .= "(";
						$resolution_sql = '';
						
						foreach ($tab_resolutions_ecrans as $resolution) {
							$resolution_sql .= " resolution_$col = $resolution OR";
						}
						// $pos_dern_or = srtchr($processeurs_sql, 'OR');
						$resolution_sql = substr($resolution_sql, 0, strlen($resolution_sql) - 2);

						$sql .= "$resolution_sql ) ";
					}
				}// if !empty $taille

				// SQL Prix

				if ($prix_min && !$prix_max)
				{
					$sql .= where_or_and($sql) ."prix_$col > $prix_min"; 
				}
				else if ($prix_max && !$prix_min)
				{
					$sql .= where_or_and($sql) ."prix_$col < $prix_max"; 
				}
				else if ($prix_min  && $prix_max)
				{
					$sql .= where_or_and($sql) ."prix_$col BETWEEN $prix_min AND $prix_max"; 
				}

				$sql .= where_or_and($sql) ."type_$col = '$type';";
			} // if $post_type == ordinateurs

			else if ($post_type == 'tablettes')
			{
				
				$col = 'tablette';
				$tab_constructeurs = !empty($_POST['constructeurs']) ? $_POST['constructeurs'] : array();
				$tab_disques_durs = !empty($_POST['disques_durs']) ? $_POST['disques_durs'] : array();
				$tab_resolutions_ecrans = !empty($_POST['resolutions_ecrans']) ? $_POST['resolutions_ecrans'] : array();
				$bluetooth = !empty($_POST['bluetooth']) ? $_POST['bluetooth'] : '';

				$table = $wpdb->prefix. "$post_type ";

				$sql = "SELECT id_post FROM $table";
				
				// print_r($_POST);

				// SQL constructeur
				$taille = sizeof($tab_constructeurs);

				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?

					if (sizeof($tab_constructeurs) == 1)
					{
						// echo '<br />seul';
						$sql .= "constructeur_$col = '$tab_constructeurs[0]'";
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
				}// if !empty $taille

				// SQL Disque Dur
				$taille = sizeof($tab_disques_durs);
				
				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?
					if (sizeof($tab_disques_durs) == 1)
					{
						// echo '<br />seul';
						$sql .= " dd_$col = $tab_disques_durs[0]";
					}
					else
					{
						// echo 'Pas seul';
						$sql .= "(";
						$dd_sql = '';
						
						foreach ($tab_disques_durs as $disque) {
							$dd_sql .= " dd_$col = $disque OR";
						}
						// $pos_dern_or = srtchr($processeurs_sql, 'OR');
						$dd_sql = substr($dd_sql, 0, strlen($dd_sql) - 2);

						$sql .= "$dd_sql ) ";
					}
				}// if !empty $taille

				// SQL Résolution écran
				$taille = sizeof($tab_resolutions_ecrans);
				
				if (!empty($taille))
				{
					$sql .= where_or_and($sql); // Where ou and ?
					if (sizeof($tab_resolutions_ecrans) == 1)
					{
						// echo '<br />seul';
						$sql .= " resolution_$col = $tab_resolutions_ecrans[0]";
					}
					else
					{
						// echo 'Pas seul';
						$sql .= "(";
						$resolution_sql = '';
						
						foreach ($tab_resolutions_ecrans as $resolution) {
							$resolution_sql .= " resolution_$col = $resolution OR";
						}
						// $pos_dern_or = srtchr($processeurs_sql, 'OR');
						$resolution_sql = substr($resolution_sql, 0, strlen($resolution_sql) - 2);

						$sql .= "$resolution_sql ) ";
					}
				}// if !empty $taille

				// SQL Bluetooth

				if ($bluetooth != '')
				{
					$sql .= where_or_and($sql) ."bluetooth_$col = 1"; 
				}

				// SQL Prix

				if ($prix_min && !$prix_max)
				{
					$sql .= where_or_and($sql) ."prix_$col > $prix_min"; 
				}
				else if ($prix_max && !$prix_min)
				{
					$sql .= where_or_and($sql) ."prix_$col < $prix_max"; 
				}
				else if ($prix_min  && $prix_max)
				{
					$sql .= where_or_and($sql) ."prix_$col BETWEEN $prix_min AND $prix_max"; 
				}

				// Toujours en fonction du type.
				$sql .= where_or_and($sql) ."type_$col = '$type';";

			}	
			// echo $sql;

			$results = $wpdb->get_results($sql, OBJECT );

			// ob_start();

			if (sizeof($results) == 0)
			{
				echo 'Aucun ordinateur ne correspond à votre recherche.';
			}
			else
			{ 

			?>

			<table> 
				<tr>
					<th>Nom</th>
					<th>Prix</th>
				</tr>
			<?php
				foreach ($results as $sql_post) :

					$post = get_post($sql_post->id_post); // Récupration du post
					setup_postdata($post); // Récupréation des infos pour The Loop. 
					$prix = get_post_custom_values("prix_$col");
			?>

					<tr class="resultat">
						<td>
							<div class="title_resultat"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							<div class="image_resultat"><?php the_post_thumbnail('medium' ); ?></div>
							<div class="description_resultat"><?php the_excerpt(); ?></div>
						</td>
						<td><?= $prix[0]; ?> </td>
					
					
					</tr>

				<?php // print_r($post);
				endforeach;
			}
			// $content = ob_get_clean(); 
			// echo $content;
			// print_r($results);
			die(); // Nécéssaire !
				
		}	

		/* Renvoie where ou and pour créer la requete SQL */
		function where_or_and($chaine) {

			if (strstr($chaine, "WHERE") === false)

				return " WHERE ";
			else
				return " AND ";
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