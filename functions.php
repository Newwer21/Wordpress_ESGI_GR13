<?php
	
include_once plugin_dir_path( __FILE__ ).'/types/produits.php';
	
	add_action( 'wp_enqueue_scripts', 'include_style' );

	function include_style() {
		wp_register_style('style', get_bloginfo('stylesheet_url' ), '', false, 'screen' );
		wp_enqueue_style( 'style' );
	}

	add_action('init', 'theme_menu');

	function theme_menu()
	{
		register_nav_menu( 'main_menu', 'Menu principal' );
	}

	add_action( 'widgets_init','theme_sidebars' );

	function theme_sidebars()
	{
		   /**
			* Creates a sidebar
			* @param string|array  Builds Sidebar based off of 'name' and 'id' values.
			*/
			$args = array(
				'name'          => 'Zone Latérale Gauche',
				'id'            => 'zone_widget_gauche',
			);
		
			register_sidebar( $args );
		
	}

	add_action( 'widgets_init', 'theme_register_widget' );

	function theme_register_widget()
	{
		register_widget( 'CustomWidget' );
	}

	class CustomWidget extends WP_Widget {

		function CustomWidget() 
		{
			parent::__construct( false, 'Mon Widget' );
		}

		function widget( $args, $instance )
		{
			echo $args['before_widget'];
		}

		function update($new, $old)
		{

		}

		function form($instance)
		{
			echo '<p>
					<label>Nom : </label><input type="text" name="nom" />
				 </p>';
		}

	}

?>