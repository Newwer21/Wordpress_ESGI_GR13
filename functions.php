<?php
	/*include_once plugin_dir_path( __FILE__ ).'/types/produits.php';*/
	include_once plugin_dir_path( __FILE__ ).'/types/ordinateurs.php';
	include_once plugin_dir_path( __FILE__ ).'/types/tablettes.php';
	include_once plugin_dir_path(__FILE__ ).'/widget.php';
	
	add_action('wp_enqueue_scripts', 'init_js');

	function init_js()
	{
		wp_enqueue_script( 'jquery');
	}

	add_action('wp_head','pluginname_ajaxurl');

	function pluginname_ajaxurl() {
	?>
		<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
<?php 	
	}
	
	add_theme_support( 'post-thumbnails', array( 'produits' ) ); 
	
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
	add_action('widgets_init', 'recherche_sidebar');

	function theme_sidebars()
	{
		   /**
			* Creates a sidebar
			* @param string|array  Builds Sidebar based off of 'name' and 'id' values.
			*/
			$args = array(
				'name'          => 'Zone Latérale Gauche',
				'id'            => 'zone_widget_gauche',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => '</h2>'
			);
		
			register_sidebar( $args );
	}

	function recherche_sidebar()
	{
		   /**
			* Creates a sidebar
			* @param string|array  Builds Sidebar based off of 'name' and 'id' values.
			*/
			$args = array(
				'name'          => 'Zone Latérale Gauche Recherche',
				'id'            => 'zone_widget_gauche_recherche',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => '</h2>'
			);
		
			register_sidebar( $args );
	}

	/* Permet d'exécuter les codes PHP sur les widgets Textes */
	
	function php_execute($html){
		if(strpos($html,"<"."?php")!==false){ ob_start(); eval("?".">".$html);
		$html=ob_get_contents();
		ob_end_clean();
		}
		return $html;
	}
	
	add_filter('widget_text','php_execute',100);

	// surprime Article et page

function remove_menu_items() {
  	global $menu;
  	$restricted = array(__('Posts'));
  	end ($menu);
  	while (prev($menu)){
    	$value = explode(' ',$menu[key($menu)][0]);
    	if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
      		unset($menu[key($menu)]);
      	}
  	}
}

add_action('admin_menu', 'remove_menu_items');

/* Fonction Ajax permettant l'affichage Produit à l'appel 
d'une catégorie par défaut (sans choix critère)
*/

add_action( 'wp_ajax_search_produits_init', 'search_produits_init' );

	function search_produits_init() {
	    global $wpdb; // this is how you get access to the database

	    $home_paged = (get_query_var('paged'));
	    $type = $_POST ['type']; 

	    $arguments = array(
			'post_type' => $_POST['post_type'],
			'post_status' => 'publish',
			'types' => $type,
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
		</section> <!-- .content-produits-phablettes -->
	</article> <!-- .content-produit -->
<?php $content = ob_get_clean(); 
		echo $content;

	    die(); // this is required to return a proper result
	}

/* Fonction Ajax permettant l'affichage Produit après modification de critère */

add_action( 'wp_ajax_search_produits_critere', 'search_produits_critere' );

	function search_produits_critere() {
		$post_type = $_POST['post_type'];
		$type = $_POST['type'];

		$args = array(
			'post_type'  => $post_type,
			'types' => $type,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'     => 'processeur_produit',
					'value'   => 'Proc',
					'compare' => '=',
				),
				array(
					'key'     => 'prix_produit',
					'value'   => array( 20, 300 ),
					'type'    => 'numeric',
					'compare' => 'BETWEEN',
				),
			),
			
		);
		$query = new WP_Query( $args );

		ob_start(); 
		while ($query->have_posts()) : $query->the_post(); ?>
			<article class="article-<?= $type; ?>">
			 	<h3 class="phab-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			    <p class="phab-description"><?php ?> 	<?php the_post_thumbnail('medium'); ?></p> 
			</article>

<?php 	endwhile;
		$content = ob_get_clean();	
		echo $content;

		die;
	}

	/* Fonction qui permet d'afficher toutes les valeurs d'un champs personnalisé */
function get_all_custom_fields_values($custom_field) {
	global $wpdb;
	$result = array();
	$visited_values = array();

	$values = $wpdb->get_col("SELECT meta_value 
		FROM $wpdb->postmeta WHERE meta_key = '$custom_field'" );
	
	// var_dump($values);

	for($i = 0; $i < sizeof($values) - 1; $i++)
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
	return $result;
}
?>