<?php
/*
Template Name: ordinateurs
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="main single-ordinateur">
  template ordinateurs
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <?php
      /* Récupération des données */
      $custom = get_post_custom();
      $constructeur_ordinateur = $custom["constructeur_ordinateur"][0];
      $prix_ordinateur = $custom['prix_ordinateur'][0];
      $processeur_ordinateur = $custom["processeur_ordinateur"][0] ;
      $chipset_ordinateur = $custom["chipset_ordinateur"][0] ;
      $ram_ordinateur = $custom["ram_ordinateur"][0] ;
      $dd_ordinateur = $custom["dd_ordinateur"][0];
      $tactile_ordinateur = $custom["tactile_ordinateur"][0] == 1 ? 'Oui' : 'Non';
      $os_ordinateur = $custom["os_ordinateur"][0] ;
      $poids_ordinateur = $custom["poids_ordinateur"][0] ;
      $resolution_ordinateur = $custom["resolution_ordinateur"][0];

    ?>
      <div class="single-ordinateurs-content">
        <h3 class="single-ordinateurs-title"><?php the_title(); ?></h3>
        <p class="single-category"><?php echo 'Catégorie : '; the_terms($post->ID, 'types');?></p>
        <fig class="single-ordinateurs-img"><?php the_post_thumbnail(); ?></fig>
        <p class="single-ordinateurs-description"><?php the_content(); ?></p>

         <?php 
              /* Affichage des données*/

              echo '<table>
                        <tr>
                          <td>Prix : </td>
                          <td>'.$prix_ordinateur.'</td>
                        </tr>
                        <tr>
                          <td>Constructeur : </td>
                          <td>'.$constructeur_ordinateur.'</td>
                        </tr>
                        <tr>
                          <td>Processeur : </td>
                          <td>'.$processeur_ordinateur.'</td>
                        </tr>
                        <tr>
                          <td>Chipset : </td>
                          <td>'.$chipset_ordinateur.'</td>
                        </tr>
                        <tr>
                          <td>RAM : </td>
                          <td>'.$ram_ordinateur.' Go</td>
                        </tr><tr>
                          <td>Disque dur : </td>
                          <td>'.$dd_ordinateur.' GO</td>
                        </tr>

                      </table>';
              if ($stock_ordinateur > 0) {
                echo 'Réservation possible !';
              }
              else {
                echo 'Non disponible';
              }
        ?>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

<?php get_footer(); ?>