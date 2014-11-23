<?php

/*philippe test
*/


/**
 * @Author: Fy
 * @Date:   2014-10-28 23:23:34
 * @Last Modified by:   Fy
 * @Last Modified time: 2014-11-02 18:30:57
 */

add_action( 'init', 'ordi_register' );

function ordi_register() {
 
	$labels = array(
		'name' => 'Ordinateurs', 'post type general name',
		'singular_name' => 'un ordinateur', 'post type singular name',
		'add_new' => 'Add New', 'portfolio item',
		'add_new_item'> 'Add New Portfolio Item',
		'edit_item' => 'Edit Portfolio Item',
		'new_item' => 'New Portfolio Item',
		'view_item' => 'View Portfolio Item',
		'search_items' => 'Search ordinateurs',
		'not_found' => 'Nothing found',
		'not_found_in_trash' => 'Nothing found in Trash',
		'parent_item_colon' => 	''
		);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		/*'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',*/
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail')
	  );
 	// add_theme_support('post-thumbnails');
	register_post_type( 'ordinateurs' , $args );
	register_taxonomy("types", array("ordinateurs"), array("hierarchical" => true, "label" => "Types", "singular_label" => "type", "rewrite" => true));

/* META_BOX PRODUITS */
	add_action("admin_init", "newProduit_init");
	function newProduit_init(){
		  add_meta_box("caract_id", "caracteristique", "caract_ordi", "ordinateurs", "normal", "low");
	/*	  add_meta_box("credits_meta", "Design &amp; Build Credits", "credits_meta", "portfolio", "normal", "low");
	*/	}

	function caract_ordi(){
	
	  /* Source : http://wabeo.fr/jouons-avec-les-meta-boxes/ */
	  $custom = get_post_custom($post->ID);
	  
	  $constructeur_ordinateur = $custom["constructeur_ordinateur"][0];
	  $prix_ordinateur = $custom['prix_ordinateur'][0];
	  $processeur_ordinateur = $custom["processeur_ordinateur"][0] ;
	  $chipset_ordinateur = $custom["chipset_ordinateur"][0] ;
	  $ram_ordinateur = $custom["ram_ordinateur"][0] ;
	  $dd_ordinateur = $custom["dd_ordinateur"][0];
	  $tactile_ordinateur = $custom["tactile_ordinateur"][0] == 1 ? 'Oui' : 'Non';
	  $os_ordinateur = $custom["os_ordinateur"][0] ;
	  $poids_ordinateur = $custom["poids_ordinateur"][0] ;
	  $resolution_ordinateur = $custom["resolution_ordinateur"][0];

	 	// var_dump($custom);

	   echo '<table>
	   				<td>
		   				<label for="constructeur_ordinateur">Constructeur </label>
		   				<input type="text" id="constructeur_ordinateur" name="constructeur_ordinateur" placeholder="'.$constructeur_ordinateur.'" value="'.$constructeur_ordinateur.'" required>
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="prix_ordinateur">Prix </label>
		   				<input type="text" id="prix_ordinateur" name="prix_ordinateur" placeholder="'.$prix_ordinateur.'" value="'.$prix_ordinateur.'" required>
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="processeur_ordinateur">Processeur  </label>
		   				<input type="text" id="processeur_ordinateur" name="processeur_ordinateur" placeholder="'.$processeur_ordinateur.'" value="'.$processeur_ordinateur.'" required>
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="chipset_ordinateur">Chipset </label>
		   				<input type="text" id="chipset_ordinateur" name="chipset_ordinateur" placeholder="'.$chipset_ordinateur.'" value="'.$chipset_ordinateur.'" required>
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="ram_ordinateur">RAM </label>
		   				<input type="text" id="ram_ordinateur" name="ram_ordinateur" placeholder="'.$ram_ordinateur.'" value="'.$ram_ordinateur.'" required>
		   			</td>
	   			</tr>

	   				<tr>
	   				<td>
		   				<label for="dd_ordinateur">Disque dur </label>
		   				<input type="text" id="dd_ordinateur" name="dd_ordinateur" placeholder="'.$dd_ordinateur.'" value="'.$dd_ordinateur.'" required>
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="tactile_ordinateur">Ecran tactile </label>
		   				<input type="text" id="tactile_ordinateur" name="tactile_ordinateur" placeholder="'.$tactile_ordinateur.'" value="'.$tactile_ordinateur.'"> 
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="os_ordinateur">Système dexploitation  </label>
		   				<input type="text" id="os_ordinateur" name="os_ordinateur" placeholder="'.$os_ordinateur.'" value="'.$os_ordinateur.'" required>
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="poids_ordinateur">Poids </label>
		   				<input type="text" id="poids_ordnateurinateur" name="poids_ordinateur" placeholder="'.$poids_ordinateur.'" value="'.$poids_ordinateur.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="resolution_ordinateur">Résolution </label>
		   				<input type="text" id="resolution_ordinateur" name="resolution_ordinateur" placeholder="'.$resolution_ordinateur.'" value="'.$resolution_ordinateur.'" required>
		   			</td>
	   			</tr>
	   		</table>

	   		';	
	}

	add_action('save_post', 'save_details');

	function save_details(){
	  global $post, $wpdb;

	  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)

        return;

	/*  update_post_meta($post->ID, "prix_ordinateur", intval($_POST["prix_ordinateur"]));
	  update_post_meta($post->ID, "processeur_ordinateur", sanitize_text_field($_POST["processeur_ordinateur"]));
	  update_post_meta($post->ID, "chipset_produit", sanitize_text_field($_POST["chipset_produit"]));
	  update_post_meta($post->ID, "ram_produit", intval($_POST["ram_produit"]));
	  update_post_meta($post->ID, "stock_produit", intval($_POST["stock_produit"]));*/
	  if (empty($_POST["constructeur_ordinateur"]) || 
	  	  empty($_POST["prix_ordinateur"]) ||
	  	  empty($_POST["processeur_ordinateur"]) ||
	  	  empty($_POST["ram_ordinateur"]) ||
	  	  empty($_POST["chipset_ordinateur"]) ||
	  	  empty($_POST["dd_ordinateur"]) ||
	  	  empty($_POST["os_ordinateur"]) ||
	  	  empty($_POST["resolution_ordinateur"])
	  	 )
	  	return;
	 	
	  $constructeur_ordinateur = strtolower(sanitize_text_field($_POST["constructeur_ordinateur"]));
	
	  $prix_ordinateur = floatval($_POST["prix_ordinateur"]);
	  $processeur_ordinateur = strtolower(sanitize_text_field($_POST["processeur_ordinateur"]));
	  $ram_ordinateur = intval($_POST["ram_ordinateur"]);
	  $chipset_ordinateur = strtolower(sanitize_text_field($_POST["chipset_ordinateur"]));
	  $dd_ordinateur = intval($_POST["dd_ordinateur"]);
	  $tactile_ordinateur = intval($_POST["tactile_ordinateur"]);
	  $os_ordinateur = strtolower(sanitize_text_field($_POST["os_ordinateur"]));
	  $poids_ordinateur = floatval($_POST["poids_ordinateur"]);
	  $resolution_ordinateur = floatval(($_POST["resolution_ordinateur"]));

	  // Mise a jour post meta
	  update_post_meta($post->ID, "constructeur_ordinateur", $constructeur_ordinateur);
	  update_post_meta($post->ID, "prix_ordinateur", $prix_ordinateur);
	  update_post_meta($post->ID, "processeur_ordinateur", $processeur_ordinateur);
	  update_post_meta($post->ID, "ram_ordinateur", $ram_ordinateur);
	  update_post_meta($post->ID, "chipset_ordinateur", $chipset_ordinateur);
	  update_post_meta($post->ID, "dd_ordinateur", $dd_ordinateur);
	  update_post_meta($post->ID, "tactile_ordinateur", $tactile_ordinateur);
	  update_post_meta($post->ID, "os_ordinateur", $os_ordinateur );
	  update_post_meta($post->ID, "poids_ordinateur", $poids_ordinateur);
	  update_post_meta($post->ID, "resolution_ordinateur", $resolution_ordinateur);

	  /* ajout sur table wp_ordinateurs */
	  $table = $wpdb->prefix. 'ordinateurs';

	  $terms = get_the_terms( $post->ID, 'types' );
	  $term = $terms[0]->slug;
	  /* vérification si existe une ligne de post */
	  $exist = $wpdb->get_row("SELECT id_ordinateur FROM $table WHERE id_post = $post->ID;");
// var_dump($exist);
	  if (isset($exist->id_ordinateur))
	  {
	  	$wpdb->query("UPDATE $table 
	   						SET type_ordinateur = '$term',
	   							constructeur_ordinateur = '$constructeur_ordinateur',
	   							prix_ordinateur = $prix_ordinateur,
	   							processeur_ordinateur = '$processeur_ordinateur',
	   							ram_ordinateur = $ram_ordinateur,
	   							chipset_ordinateur = '$chipset_ordinateur',
	   							dd_ordinateur = $dd_ordinateur,
	   							tactile_ordinateur= $tactile_ordinateur,
	   							os_ordinateur = '$os_ordinateur',
	   							poids_ordinateur = $poids_ordinateur,
	   							resolution_ordinateur = $resolution_ordinateur
	   						WHERE id_post = $post->ID;");
	  	// $wpdb->show_errors();
	  	// exit( var_dump( $wpdb->last_query ) );
	  }
	  else
	  {
		   $wpdb->insert($table,
			  	array(
			  		'type_ordinateur'		 	=> $term,
			  		'constructeur_ordinateur' 	=> $constructeur_ordinateur,
			   		'prix_ordinateur' 		  	=> $prix_ordinateur,
			   		'processeur_ordinateur'   	=> $processeur_ordinateur,
			   		'ram_ordinateur' 		  	=> $ram_ordinateur,
			   		'chipset_ordinateur'      	=> $chipset_ordinateur,
			   		'dd_ordinateur' 		  	=> $dd_ordinateur,
			   		'tactile_ordinateur' 	  	=> $tactile_ordinateur,
			   		'os_ordinateur' 	  	  	=> $os_ordinateur,
			   		'poids_ordinateur' 		  	=> $poids_ordinateur,
			   		'resolution_ordinateur'   	=> $resolution_ordinateur,
			   		'id_post' 		  		  	=> $post->ID

			   	),
			  	array('%s', '%s', '%f', '%s', '%d', '%s', '%d', '%d', '%s', '%f', '%f', '%d')
			);
		}
	}

	/* META_BOX PRODUITS */

	add_action("manage_posts_custom_column",  "ordi_custom_columns");
	add_filter("manage_edit-ordinateurs_columns", "ordi_edit_columns");

	/* Création de Colonnes personnalisées à l'affichage des Produits */ 
	function ordi_edit_columns($columns){
	  $columns = array(
	    "cb" => '<input type="checkbox" />',
	    "title" => "Nom produit",
	    "processeur" => "Processeur",
	    "chipset" => "Chipset",
	    "prix" => "Prix",
	    "ram" => "Mémoire Vive",
	    "marques" => "marque du produit",
	    "stock" => "Stock restant" /* Pour pouvoir créer la réservation des produits en front*/
	  );
	  return $columns;
	}

	/* Gestion de l'affichage des données dans les colonnes */
	function ordi_custom_columns($column){
	  global $post;
	  $custom = get_post_custom();

	  switch ($column) {

	    case "title":
	      echo $custom[""][0];
	      break;

	      case "processeur":
	      // $custom = get_post_custom();
	      echo $custom["processeur_ordinateur"][0];
	      break;

	      case "chipset":
	      // $custom = get_post_custom();
	      echo $custom["chipset_ordinateur"][0];
	      break;

	    case "prix":
	      // $custom = get_post_custom();
	      echo $custom["prix_ordinateur"][0];
	      break;

	    case "ram" :
	      // $custom = get_post_custom();
	      echo $custom['ram_ordinateur'][0];
	      break;

	    case "type":
	      echo get_the_term_list($post->ID, 'types', '', ', ','');
	      break;

	    case "stock" :
	      echo $custom['stock_ordinateur'][0];
	      break;
	  }
	}
}

?>