<?php

/*philippe test
*/


/**
 * @Author: Fy
 * @Date:   2014-10-28 23:23:34
 * @Last Modified by:   Fy
 * @Last Modified time: 2014-11-02 16:49:44
 */


/* Ajout produit type post*/
add_action( 'init', 'produits_register' );
function produits_register() {
 
	$labels = array(
		'name' => 'Produits', 'post type general name',
		'singular_name' => 'un produit', 'post type singular name',
		'add_new' => 'Add New', 'portfolio item',
		'add_new_item'> 'Add New Portfolio Item',
		'edit_item' => 'Edit Portfolio Item',
		'new_item' => 'New Portfolio Item',
		'view_item' => 'View Portfolio Item',
		'search_items' => 'Search Portfolio',
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
		'supports' => array('title','editor','thumbnail','custom-fields')
	  );
 
	register_post_type( 'produits' , $args );
/* Ajout d'une categorie (taxonomy) a produit*/
	register_taxonomy("types", array("produits"), array("hierarchical" => true, "label" => "Types", "singular_label" => "type", "rewrite" => true));
/****************************/

/* admin - personalisation  ajout produits */
	// ajout de la meta box
	add_action("admin_init", "newProduit_init");
	function newProduit_init(){
		  add_meta_box("caract_id", "caracteristique", "caract_produit", "produits", "normal", "low");
	}
	// ajout du code html
	function caract_produit(){
	  // global $post;
	  // $custom = get_post_custom($post->ID);
	  // $prix_produit = $custom["prix_produit"][0];
	  // $taille_produit = $custom["taille_produit"][0];
	  // $processeur_produit = $custom["processeur_produit"][0];
	  // $chipset_produit = $custom["chipset_produit"][0];
	  // $ram_produit = $custom["ram_produit"][0];

	  /* get_post_meta() fonctionne pour récuperer les valeurs des meta box, 
	  get_post_custom() uniquement pour les custom fields ... */

	  /* Source : http://wabeo.fr/jouons-avec-les-meta-boxes/ */

	  echo 'prix '.$prix_produit = get_post_meta($post->ID, 'prix_produit', true);
	  echo 'proc '.$processeur_produit = get_post_meta($post->ID, 'processeur_produit', true);
	  echo 'chip '.$chipset_produit = get_post_meta($post->ID, 'chipset_produit', true);
	  echo 'ram '.$ram_produit = get_post_meta($post->ID, 'ram_produit', true);

	   echo '<table>
	   			<tr>
	   				<td>
		   				<label for="prix_produit">Prix </label>
		   				<input type="text" id="prix_produit" name="prix_produit" value="'.$prix_produit.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="processeur_produit">Processeur  </label>
		   				<input type="text" id="processeur_produit" name="processeur_produit" value="'.$processeur_produit.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="chipset_produit">Chipset </label>
		   				<input type="text" id="chipset_produit" name="chipset_produit" value="'.$chipset_produit.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="ram_produit">RAM </label>
		   				<input type="text" id="ram_produit" name="ram_produit" value="'.$ram_produit.'">
		   			</td>
	   			</tr>
	   		</table>';	
	}
	//sauvegarde des données crées
	add_action('save_post', 'save_details');
	function save_details(){
	  global $post;
	  update_post_meta($post->ID, "prix_produit", intval($_POST["prix_produit"]));
	  update_post_meta($post->ID, "processeur_produit", sanitize_text_field($_POST["processeur_produit"]));
	  update_post_meta($post->ID, "chipset_produit", sanitize_text_field($_POST["chipset_produit"]));
	  update_post_meta($post->ID, "ram_produit", intval($_POST["ram_produit"]));

	}
/**************************************/

/* admin - personnalisation de l'affichage des produits*/
add_action("manage_posts_custom_column",  "produit_custom_columns");
add_filter("manage_edit-produits_columns", "produit_edit_columns");
function produit_edit_columns($columns){
  $columns = array(
    "cb" => '<input type="checkbox" />',
    "title" => "Nom produit",
    "processeur" => "Processeur",
    "chipset" => "Chipset",
    "prix" => "Prix",
  );
  return $columns;
}
function produit_custom_columns($column){
  global $post;
 
  switch ($column) {
    case "title":
      $custom = get_post_custom();
      echo $custom[""][0];
      break;
      case "processeur":
      $custom = get_post_custom();
      echo $custom["processeur_produit"][0];
      break;
      case "chipset":
      $custom = get_post_custom();
      echo $custom["chipset_produit"][0];
      break;
    case "prix":
      $custom = get_post_custom();
      echo $custom["prix_produit"][0];
      break;
    case "skills":
      echo get_the_term_list($post->ID, 'types', '', ', ','');
      break;
  }
}
/****************************************/


}
