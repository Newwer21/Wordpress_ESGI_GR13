<?php
/*
Template Name: tablettess
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="main single-tablettes">
  template tablettess
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <?php
      /* Récupération des données */
      $custom = get_post_custom();
      $constructeur_tablettes = $custom["constructeur_tablettes"][0];
      $prix_tablettes = $custom['prix_tablettes'][0];
      $chipset_tablettes = $custom["chipset_tablettes"][0] ;
      $dd_tablettes = $custom["dd_tablettes"][0];
      $os_tablettes = $custom["os_tablettes"][0] ;
      $taille_tablettes = $custom["taille_tablettes"][0];

    ?>
      <div class="single-tablettess-content">
        <h3 class="single-tablettess-title"><?php the_title(); ?></h3>
        <p class="single-category"><?php echo 'Catégorie : '; the_terms($post->ID, 'marques');?></p>
        <fig class="single-tablettess-img"><?php the_post_thumbnail(); ?></fig>
        <p class="single-tablettess-description"><?php the_content(); ?></p>

         <?php 
              /* Affichage des données*/

              echo '<table>
                        <tr>
                          <td>Prix : </td>
                          <td>'.$prix_tablettes.'</td>
                        </tr>
                        <tr>
                          <td>Constructeur : </td>
                          <td>'.$constructeur_tablettes.'</td>
                        </tr>
                        <tr>
                          <td>Processeur : </td>
                          <td>'.$taille_tablettes.'</td>
                        </tr>
                        <tr>
                          <td>Chipset : </td>
                          <td>'.$chipset_tablettes.'</td>
                        </tr>
                        <tr>
                          <td>os : </td>
                          <td>'.$os_tablettes.'</td>
                        </tr>
                        <tr>
                          <td>Disque dur : </td>
                          <td>'.$dd_tablettes.' GO</td>
                        </tr>

                      </table>';
              if ($stock_tablettes > 0) {
                echo 'Réservation possible !';
              }
              else {
                echo 'Non disponible';
              }
        ?>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>

 <!-- form reservation -widget -->
 <input type="button" value="reserver ?" class="but-res" />
  <div id="reservation">
    <?php include_once plugin_dir_path(__FILE__ ).'/reservationform.php'; ?>
  </div>
<!--  -->
<?php get_footer(); ?>

<!-- script form reservation -WIDGET -->
<script type="text/javascript">
jQuery(document).ready(function($) {
  $('#reservation').hide();
  $('.but-res').click( function() {
    $('#reservation').toggle('slow'); 
});
})
</script>