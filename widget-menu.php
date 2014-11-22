
<?php

/*
Plugin Name: Theme Menu
Plugin URI: 
Description: Créer un menu personnalisé en fonction des custom post choisi par l'utilisateur.
Author: JJL
Version: 1.0
*/

class Theme_Menu extends WP_Widget {

 function Theme_Menu() {

   $widget_proprietes = array(
   					'classname'   => 'Menu du thème',
   					'description' => 'Permet de créer un menu personnalisé avec les posts personnalisés.'
   						);
   $control_proprietes = array(
   							'width'   => 250,
   							'height'  => 350,
   							'id_base' => 'theme-menu-widget'
   						);
   $this->WP_Widget('theme-menu-widget', 'Menu avec des posts', $widget_proprietes, $control_proprietes);

 }
 
 function form ($instance) {

 	echo 'instance : '.var_dump($instance);

 	$instance = wp_parse_args( (array) $instance, $defaults ); 
 	
 	/* Récupération des posts custom types. */
	$args = array(
	   '_builtin' => false
	);

	$post_types = get_post_types( $args, 'names' ); 

	foreach ( $post_types as $post_type ) {

		$checked = '';

		if ($instance[$post_type][$post_type] == 'on')
		{
			$checked ="checked";
		}

	   echo '<p> <input type="checkbox" name="'.$this->get_field_name($post_type).'" id="'.$this->get_field_id($post_type).'"'. $checked .' ><label for="'.$this->get_field_id($post_type).'">' . $post_type . '</label></p>';
	}

 }

 function update ($new_instance, $old_instance) {


 	foreach ($new_instance as $new => $value) {
 		// On format pour obtenir : ['post_type']['post_type']['on']
 		$instance[$new][$new] = $value; 
 	}

 	return $instance;
  
 }

 function widget ($args,$instance) {

  $args = array( '_builtin' => false); // affiche uniquement custom_post.
  $output = 'names';

  $posts = get_post_types( $args, $output );

// var_dump($posts);
  $terms_args = array('hide_empty' => false); // Affiche les catégories même non relié à un post.
 	$html = '';

    echo $before_widget;

    foreach ($instance as $key => $value) {
    	// Récupération du post_type
    	$post_type = $key;
    	$html .= '<h3>'. ucfirst($post_type) .'</h3>';
    	
    	// Récupération du custom taxonomy relié au post_type.

    	$taxonomy = get_object_taxonomies($post_type);

    	// Récupération des terms grâce à la taxonomie.
    	$tax_terms = get_terms($taxonomy, $terms_args  );
  		
      $html .= '<ul>';

      foreach ($tax_terms as $tax_term) {
  			$html .= '<li><a href="' . esc_attr(get_term_link($tax_term, $taxonomy)).'&post_type='. $post_type . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name.'</a></li>';
  		}

      $html .= '</ul>';
    	
    }

    echo $html;

    echo $after_widget;
 }

}

function init_theme_menu_widget() {
	
	register_widget('Theme_menu');
}

add_action('widgets_init', 'init_theme_menu_widget');

 ?>
