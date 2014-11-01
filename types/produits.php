<?php

/*philippe test
*/


/**
 * @Author: Fy
 * @Date:   2014-10-28 23:23:34
 * @Last Modified by:   Fy
 * @Last Modified time: 2014-11-01 18:43:43
 */

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
		'supports' => array('title','editor','thumbnail')
	  );
 
	register_post_type( 'produits' , $args );
	register_taxonomy("types", array("produits"), array("hierarchical" => true, "label" => "Types", "singular_label" => "type", "rewrite" => true));
/* META_BOX PRODUITS */
	add_action("admin_init", "newProduit_init");
	function newProduit_init(){
		  add_meta_box("caract_id", "caracteristique", "caract_produit", "produits", "normal", "low");
	/*	  add_meta_box("credits_meta", "Design &amp; Build Credits", "credits_meta", "portfolio", "normal", "low");
	*/	}

	function caract_produit(){
	  global $post;
	  $custom = get_post_custom($post->ID);
	  $prix_produit = $custom["prix_produit"][0];
	  $taille_produit = $custom["taille_produit"][0];
	  $processeur_produit = $custom["processeur_produit"][0];
	  $chipset_produit = $custom["chipset_produit"][0];
	  $ram_produit = $custom["ram_produit"][0];

	   echo 'box prix';  
	   echo 'box taille ecran';  
	   echo 'box processeur';  
	}

	add_action('save_post', 'save_details');
	function save_details(){
	  global $post;
	  update_post_meta($post->ID, "prix_produit", $_POST["prix_produit"]);
	}
/* META_BOX PRODUITS */

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

/*function remove_extra_meta_boxes() {
	remove_meta_box( 'postcustom' , 'post' , 'normal' );
}
add_action( 'admin_menu' , 'remove_extra_meta_boxes' );*/

}
