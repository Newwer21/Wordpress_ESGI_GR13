<?php get_header(); ?> 
<script>
jQuery(function($) {
  $('document').ready(function() {
    
    // alert(ajaxurl);
      $.post(ajaxurl , { 'type' : '<?= $_GET["types"] ; ?>', 
                         'post_type' : '<?= $_GET["post_type"]; ?>',
                         'action': 'search_produits_init',}
      )

      .done(function(data) {
        // alert(data);
        $('.results').html(data);
        $('div.spinner').toggle();
      });
  }); /* .ready() */

  /* Choix par critères */
  $('#searchform').change(function() {

      $('div.spinner').toggle();
      $('#search_critere').empty();
      $('.results').empty();

      var cpt_check = 0;
      var rech_criteres = '';
      var rech_processeurs = '';
      var rech_memoire_vive = '';
      var data = {};
      var type = $('#type').val();

      var tab_processeurs = [];
      var tab_memoire_vive = [];
      
      var prix_min = $('#prix_min').val();
      var prix_max = $('#prix_max').val();

      /* Récapitulatif des critères */

      if (prix_min) {
        rech_criteres += '<p>De ' + prix_min + '€';
      }

      if (prix_max) {
        rech_criteres += ' à ' + prix_max + '€';
      }

      rech_criteres += '</p>';

      if (type) 
      {
        rech_criteres += '<p>Catégorie : ' + type + '</p>';
      }

      $('#processeurs:checked').each(function() {
        rech_processeurs += $(this).val() + ', ';
        tab_processeurs.push($(this).val());
        cpt_check++;
      });
      
      if (cpt_check > 0)
      {
        rech_criteres += '<p>Processeurs : ';
        rech_criteres += rech_processeurs.substring(0, rech_processeurs.length - 1);
        rech_criteres += '</p>';
        cpt_check = 0;
      }

      $('#memoires_vives:checked').each(function() {
        rech_memoire_vive += $(this).val() + ', ';
        tab_memoire_vive.push( $(this).val() );
        cpt_check++;
      });
      
      if (cpt_check > 0) 
      {
        rech_criteres += '<p>Mémoire vive : ';
        rech_criteres += rech_memoire_vive.substring(0, rech_memoire_vive.length - 1);
        rech_criteres += '</p>';
        cpt_check = 0;
      }

      if (rech_criteres != '') // Affiche si critère choisi.
        $('#search_critere').html('<h2>Filtre de recherche</h2>' + rech_criteres);
      // alert(rech_criteres);

      if (type == '')
        type = '<?= $_GET["types"]; ?>';

      data['type'] = type;
      data['processeurs'] = tab_processeurs;
      data['action'] = 'search_produits_critere';
      data['post_type'] = '<?= $_GET["post_type"]; ?>';
      // alert(data['types']);
      $.post(ajaxurl , data)

      .done(function(data) {

        $('.results').html(data);
        
        $('div.spinner').toggle();
      });
  });

  $('#searchform').submit(function() {
    return false;
  });
});
</script>
<?php get_sidebar('recherche-criteres'); ?>

<section class="main taxonomy">
	In taxonomy pages..
  <div class="fix_clear"></div>
  <div class="spinner"></div>
  <!-- <label for="name">Name</label><input type="text" name="name"> -->
  <!-- <h1>Produits concernant : <?php single_cat_title(); ?></h1>
  <div class="clear_fix"></div>
  <?php //if (have_posts()) : ?>
    <?php //while (have_posts()) : the_post(); ?>
      <div class="content-produits">
        <h3 class="project-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p class="project-description"><?php //the_post_thumbnail("medium"); ?></p>
        <?php the_category(); ?> 
      </div>
    <?php //endwhile; ?>
  <?php //endif; ?>
</div> -->
<div id="search_critere"></div>
<article class="results"></article>
<div class="fix_clear"></div>
<?php

?>
<?php get_footer(); ?>