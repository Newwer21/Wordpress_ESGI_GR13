<?php
/*
Template Name: Produits
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="main single-produits">
  template tablettes
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <?php
      /* Récupération des données */
      $custom = get_post_custom();
      $prix_produit = $custom['prix_produit'][0];
      $processeur_produit = $custom['processeur_produit'][0];
      $chipset_produit = $custom['chipset_produit'][0];
      $ram_produit = $custom['ram_produit'][0];
      $stock_produit = $custom['stock_produit'][0];
    ?>
      <div class="single-produits-content">
        <h3 class="single-produits-title"><?php the_title(); ?></h3>
        <p class="single-category"><?php echo 'Catégorie : '; the_terms($post->ID, 'types');?></p>
        <fig class="single-produits-img"><?php the_post_thumbnail(); ?></fig>
        <p class="single-produits-description"><?php the_content(); ?></p>

         <?php 
              /* Affichage des données*/

              echo '<table>
                        <tr>
                          <td>Prix : </td>
                          <td>'.$prix_produit.'</td>
                        </tr>
                        <tr>
                          <td>Processeur : </td>
                          <td>'.$processeur_produit.'</td>
                        </tr>
                        <tr>
                          <td>Chipset : </td>
                          <td>'.$chipset_produit.'</td>
                        </tr>
                        <tr>
                          <td>RAM : </td>
                          <td>'.$ram_produit.'</td>
                        </tr>

                      </table>';
              if ($stock_produit > 0) {
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