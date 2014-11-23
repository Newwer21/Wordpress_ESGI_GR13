<?php

add_action( 'init', 'tab_register' );
function tab_register() {
 
	$labels = array(
		'name' => 'Tablettes', 'post type general name',
		'singular_name' => 'tablette', 'post type singular name',
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
		'supports' => array('title','thumbnail')
	  );
 	// add_theme_support('post-thumbnails');
	register_post_type( 'tablettes' , $args );

	register_taxonomy("marques", array("tablettes"), array("hierarchical" => true, "label" => "Types", "singular_label" => "type", "rewrite" => true));
/****************************/
}
/* admin - personalisation  ajout produits */
	// ajout de la meta box
	add_action('admin_init', "new_tab_init");

	function new_tab_init(){
		  add_meta_box("caracteristique_tab_id", "caracteristique tablettes", "caracteristique_tab", "tablettes", "normal", "low");
	}

	function caracteristique_tab($post){
	  
	  $custom = get_post_custom($post->ID);

	  /* get_post_meta() fonctionne pour récuperer les valeurs des meta box, 
	  get_post_custom() uniquement pour les custom fields ... */
	  $constructeur_tablette = $custom["constructeurtab_tablette"][0] ;
	  $os_tablette = $custom["os_tab"][0] ;
	  $taille_tablette =$custom["taille_tablette"][0] ; 
	  $dd_tablette = $custom["dd_tab"][0] ;
	  $bluetooth_tablette = $custom["bluetooth_tablette"][0] ;
	  $prix_tablette = $custom["prix_tablette"][0] ;
	  /* Source : http://wabeo.fr/jouons-avec-les-meta-boxes/ */
	/*  $constructeur_ordi = $custom["constructeur_ordi"][0];
	  $prix_ordi = $custom["prix_ordi"][0];
	  $processeur_ordi = $custom["processeur_ordi"][0] ;
	  $chipset_ordi = $custom["chipset_ordi"][0] ;
	  $ram_ordi = $custom["ram_ordi"][0] ;
	  $dd_ordi = $custom["dd_ordi"][0];
	  $tactile_ordi = $custom["tactile_ordi"][0] ;
	  $os_ordi = $custom["os_ordi"][0] ;
	  $poids_ordi = $custom["poids_ordi"][0] ;
	  $resolution_ordi = $custom["resolution_ordi"][0];*/
	  // var_dump($custom);
	   echo '<table>
	   <tr>
	   				<td>
		   				<label for="constructeur_tablette">constructeur </label>
		   				<input type="text" id="constructeur_tablette" name="constructeur_tablette" placeholder="'.$constructeur_tablette.'" value="'.$constructeur_tablette.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="os_tablette">Systeme d exploitation </label>
		   				<input type="text" id="os_tablette" name="os_tablette" placeholder="'.$os_tablette.'" value="'.$os_tablette.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="taille_tablette">Taille  </label>
		   				<input type="text" id="taille_tablette" name="taille_tablette" placeholder="'.$taille_tablette.'" value="'.$taille_tablette.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="dd_tablette">Capacité de stockage </label>
		   				<input type="text" id="dd_tablette" name="dd_tablette" placeholder="'.$dd_tablette.'" value="'.$dd_tablette.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="bluetooth_tablette">Bluetooth </label>
		   				<input type="text" id="bluetooth_tablette" name="bluetooth_tablette" placeholder="'.$bluetooth_tablette.'" value="'.$bluetooth_tablette.'">
		   			</td>
	   			</tr>
	   			<tr>
	   				<td>
		   				<label for="prix_tablette">Prix </label>
		   				<input type="text" id="prix_tablette" name="prix_tablette" placeholder="'.$prix_tablette.'" value="'.$prix_tablette.'">
		   			</td>
	   			</tr>
	   		</table>

	   		';
	}

add_action('save_post', 'save_tab');
	function save_tab(){

	  update_post_meta($post->ID, "constructeur_tablette", intval($_POST["constructeur_tablette"]));
	  update_post_meta($post->ID, "os_tablette", sanitize_text_field($_POST["os_tablette"]));
	  update_post_meta($post->ID, "taille_tablette", intval($_POST["taille_tablette"]));
	  update_post_meta($post->ID, "dd_tablette", sanitize_text_field($_POST["dd_tablette"]));
	  update_post_meta($post->ID, "bluetooth_tablette", sanitize_text_field($_POST["bluetooth_tablette"]));
	  update_post_meta($post->ID, "prix_tablette", intval($_POST["prix_tablette"]));

	}

add_action("manage_posts_custom_column",  "tab_custom_columns");
add_filter("manage_edit-tablettes_columns", "tab_edit_columns");
function tab_edit_columns($columns){
  $columns = array(
    "cb" => '<input type="checkbox" />',
    "title" => "Nom produit",
    "processeur" => "Processeur",
    "chipset" => "Chipset",
    "prix" => "Prix"
  );
  return $columns;
}
function tab_custom_columns($column){
  global $post;
 
  switch ($column) {
    case "title":
      $custom = get_post_custom();
      echo $custom[""][0];
      break;
      case "processeur":
      $custom = get_post_custom();
      echo $custom["processeur_ordi"][0];
      break;
      case "chipset":
      $custom = get_post_custom();
      echo $custom["chipset_ordi"][0];
      break;
    case "prix":
      $custom = get_post_custom();
      echo $custom["prix_ordi"][0];
      break;
    case "skills":
      echo get_the_term_list($post->ID, 'marques', '', ', ','');
      break;
  }
}

?>