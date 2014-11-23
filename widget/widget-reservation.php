
<?php

/*
Plugin Name: Reservation produit
Plugin URI: 
Description: Permet la réservation des produits.
Author: Fyl & JJL
Version: 1.0
*/

class Reservation_produits extends WP_Widget {

 function Reservation_produits() {

   $widget_proprietes = array(
   					'classname'   => 'Reservation de produits',
   					'description' => 'Formulaire de réservation des produits en fonction du stock.'
   						);
   $control_proprietes = array(
   							'width'   => 250,
   							'height'  => 350,
   							'id_base' => 'reservation-produit-widget'
   						);
   $this->WP_Widget('reservation-produit-widget', 'Réservation de produits', $widget_proprietes, $control_proprietes);

 }
 
 function form ($instance) {

 	// echo 'instance : '.var_dump($instance);

 }

 function update ($new_instance, $old_instance) {

 }

 function widget ($args,$instance) {

    if (is_single() ) // Affichage en de template
    {
   	  $html = '';

      echo $before_widget;

      $html .='<form method="post" id="formRes">'
   
                .'<label>Nom complet :</label>'
                .'<input type="text" id="full_name" name="full_name" value="Jane Doe" required>.'
             
                .'<label>Adresse e-mail :</label>.'
                .'<input type="email" id="email_addr" name="email_addr" value="philippesousa93@gmail.com" required>'
             
                .'<label>Confirmez l\'adresse e-mail :</label>.'
                .'<input type="email" id="email_addr_repeat" name="email_addr_repeat" value="philippesousa93@gmail.com" required oninput="check(this)">'
           
                .'<input id="subres" class="subres" type="submit" value="Effectuer la réservation" /> '
            .'</form>';

      echo $html;

      echo $after_widget;
    }
 }

}

function init_reservation_produits_widget() {
	
	register_widget('Reservation_produits');
}

add_action('widgets_init', 'init_reservation_produits_widget');

 ?>
