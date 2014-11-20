<?php
	
/*
	Plugin Name: Search Criteres
	Plugin URI: 
	Description: Recherche par critères pour les posts personnalisés.
	Author: JJL
	Version: 1.0
*/

class Search_Criteres extends WP_Widget {

	function Search_Criteres() {
		$widget_prop = array(
						'classname' 	=> 'Recherche par critères',
						'description'	=> 'Permet la recherche par critères.'
						);
		$control = array(
					'width'		=> 250,
					'height'	=> 350,
					'id_base'	=> 'search-criteres-widget'
					);
		$this->WP_Widget('search-criteres-widget', 'Recherche par critères.', $widget_prop, $control);
	}

	function form ($instance) {

	}

	function update ($new_instance, $old_instance) {

	}

	function widget($args, $instance) {

		$infos = $this->get_taxonomy_for_post_types();
		
		// var_dump($infos);

		echo $before_wigdet;
		echo '<form role="search" method="GET" id="search_form" class="search_form" action="">';
			echo 'Filtres de recherche';

			/* On vérifie si une $_GET[] correspond à une taxonomie des post_type. */
			foreach ($infos as $key => $value) {
				
				if (isset($_GET[$value]))
				{
					$post_type = $key;
				}
			}

			if (!empty($post_type)) // On sait sur quel post custom on se trouve. On intègre le formulaire.
			{
				?>
				<div>
					<label for="prix_min">Min</label>
					<input type="text" name="prix_min" id="prix_min" size="2">

					<label for="prix_max">Max</label>
					<input type="text" name="prix_max" id="prix_max" size="2">
				</div>
				<?php

				// echo 'Need integration formulaire search/form-'. $post_type. '.php';
				include_once plugin_dir_path(__FILE__ ).'/search/form-'. $post_type .'.php';
			}
			else // Ce widget ne devrait pas être appeler.
			{
				echo 'Pas sur une zone de type produits.';
			}

		echo '</form>';
		echo $after_widget;
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


}
function init_search_critere_widget() {

	register_widget('Search_Criteres');
}

add_action('widgets_init', 'init_search_critere_widget');

?>