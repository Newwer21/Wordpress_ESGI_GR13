<?php

/*philippe test
*/


/**
 * @Author: Fy
 * @Date:   2014-10-28 23:23:34
 * @Last Modified by:   Fy
 * @Last Modified time: 2014-10-30 22:56:58
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
	register_taxonomy("Types", array("produits"), array("hierarchical" => true, "label" => "Types", "singular_label" => "type", "rewrite" => true));

/* META_BOX PRODUITS */
	add_action("admin_init", "newProduit_init");
	function newProduit_init(){
		  add_meta_box("caract_id", "caracteristique", "caract_produit", "produits", "normal", "low");
	/*	  add_meta_box("credits_meta", "Design &amp; Build Credits", "credits_meta", "portfolio", "normal", "low");
	*/	}

	function caract_produit(){
	  global $post;
	  $custom = get_post_custom($post->ID);
	  $year_completed = $custom["prix_prod"][0];

	   echo 'box prix';  
	   echo 'box taille ecran';  
	   echo 'box processeur';  

	}
/* META_BOX PRODUITS */
}
