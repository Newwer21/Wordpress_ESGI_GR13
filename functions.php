<?php
	/*include_once plugin_dir_path( __FILE__ ).'/types/produits.php';*/
	include_once plugin_dir_path( __FILE__ ).'/types/ordinateurs.php';
	include_once plugin_dir_path( __FILE__ ).'/types/tablettes.php';
	include_once plugin_dir_path(__FILE__ ).'/widget-recherche-criteres.php';
	include_once plugin_dir_path(__FILE__ ).'/widget-menu.php';
	include_once plugin_dir_path(__FILE__ ).'/search/functions.php'; // Function pour la recherche par critères.

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
	
	add_theme_support( 'post-thumbnails', array( 'ordinateurs', 'tablettes' ) ); 
	
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

/*----------------------------------------------Formulaire reservation------------------------------------------------*/
add_action( 'wp_ajax_valid_form_res', 'valid_form_resfunction' );
/*add_action( 'wp_ajax_nopriv_valid_form_res', 'valid_form_resfunction' );
*/
	function valid_form_resfunction() {
		global $wpdb;
$nom = $_POST['name'];
$email = $_POST['email'];
$idpost = $_POST['idPost'];
$date = date('Y-m-d H:i:s' ,mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

// reservationTable(); 
$result = $wpdb->insert('wp_reservation',
		array('nom_res' => $nom,
			'mail_res' => $email,
			'post_id' => $idpost,
			'date_res' => $date,
			'val_res' => false),
		array('%s','%s','%d')
	);
if ($result === false){ echo "fail";} 
if ($result === 0) { echo "no insert";}
if ($result > 0) {echo "insert";}
	die(); 
}
//creation table wp_reservation
function reservationTable(){
$reservation = $wpdb->prefix . "reservation";

if($wpdb->get_var('SHOW TABLE LIKE' . $reservation ) != $reservation)
{
$sql = 'CREATE TABLE ' .$reservation. '(
id_res INTEGER(20) NOT NULL AUTO_INCREMENT,
post_id INTEGER(20) NOT NULL,
nom_res VARCHAR( 20 ) NOT NULL,
mail_res VARCHAR(60) NOT NULL,
date_res VARCHAR(60) NOT NULL,
val_res BOOLEAN NOT NULL,
UNIQUE KEY id_res (id_res)
)Engine=INNODB';
}
require_once(ABSPATH . 'wp_admin/includes/upgrade.php');
dbDelta( $sql );
}


/* ------------------------------------------------------------------------------------------------------ */

?>