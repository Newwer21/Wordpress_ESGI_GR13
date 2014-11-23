<?php get_header(); ?> 
<script>
jQuery(function($) {


    var post_type = '';
    var categorie = '<?= $_GET["types"]; ?>';

    if (categorie)
    {
      post_type = 'ordinateurs';
      lib_categorie = 'types';
      
    }
    else if (categorie = '<?= $_GET["marques"]; ?>')
    {
      lib_categorie = 'marques';
      post_type = 'tablettes';
    }

  $('document').ready(function() {

    // alert('type ' + categorie + ' ' + post_type);
    
    // alert(ajaxurl);
      $.post(ajaxurl , { 'type' : categorie,
                         'post_type' : post_type,
                          lib_categorie : lib_categorie,
                         'action': 'search_produits_init'}
      )

      .done(function(data) {
        // alert(data);
        $('.results').html(data);
        $('div.spinner').toggle();
      });

      if (categorie == 'ipad')
      {
        $('#constructeurs input[value="apple"]').prop('checked');
      }

  }); /* .ready() */

  /* Choix par critères */
  $('#search_form').change(function() {

      $('div.spinner').toggle();
      $('#search_critere').empty();
      $('.results').empty();

      var cpt_check = 0;
      var rech_criteres = '';
      var rech_processeurs = '';
      var rech_memoire_vive = '';
      var rech_constructeurs = '';
      var rech_systemes_exp = '';
      var rech_disques_durs = '';
      var rech_resolutions_ecrans = '';

      var data = {};
      var type = $('#type').val();

      var tab_processeurs = [];
      var tab_memoire_vive = [];
      var tab_disques_durs = [];
      var tab_constructeurs = [];
      var tab_systemes_exp = [];
      var tab_resolutions_ecrans = [];
      
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

      $('#resolutions:checked').each(function() {
        rech_resolutions_ecrans += $(this).val() + ', ';
        tab_resolutions_ecrans.push($(this).val());
        cpt_check++;
      });

      if (cpt_check > 0)
      {
        rech_criteres += '<p>Résolutions écran: ';
        rech_criteres += rech_resolutions_ecrans.substring(0, rech_resolutions_ecrans.length - 1);
        rech_criteres += '</p>';
        cpt_check = 0;
      }

      $('#constructeurs:checked').each(function() {
        rech_constructeurs += $(this).val() + ', ';
        tab_constructeurs.push($(this).val());
        cpt_check++;
      });

      if (cpt_check > 0)
      {
        rech_criteres += '<p>Constructeurs : ';
        rech_criteres += rech_constructeurs.substring(0, rech_constructeurs.length - 1);
        rech_criteres += '</p>';
        cpt_check = 0;
      }

      $('#systemes_dexploitations:checked').each(function() {
        rech_systemes_exp += $(this).val() + ', ';
        tab_systemes_exp.push($(this).val());
        cpt_check++;
      });

      if (cpt_check > 0)
      {
        rech_criteres += "<p>Systèmes d'exploitation : ";
        rech_criteres += rech_systemes_exp.substring(0, rech_systemes_exp.length - 1);
        rech_criteres += '</p>';
        cpt_check = 0;
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

      $('#disques_durs:checked').each(function() {
        rech_disques_durs += $(this).val() + ', ';
        tab_disques_durs.push( $(this).val() );
        cpt_check++;
      });
      
      if (cpt_check > 0) 
      {
        rech_criteres += '<p>Disques durs : ';
        rech_criteres += rech_disques_durs.substring(0, rech_disques_durs.length - 1);
        rech_criteres += '</p>';
        cpt_check = 0;
      }

      if (rech_criteres != '') // Affiche si critère choisi.
        $('#search_critere').html('<h2>Filtre de recherche</h2>' + rech_criteres);
      // alert(rech_criteres);

      if (type == '')
        type = '<?= $_GET["types"]; ?>';

      // Vérification check
      if ($('#bluetooth').prop('checked'))
      {
        // alert('checked');
        data['bluetooth'] = 1;
      }



      // data['lib_categorie'] = lib_categorie;
      data['prix_min'] = prix_min;
      data['prix_max'] = prix_max;
      data['type'] = categorie;
      data['processeurs'] = tab_processeurs;
      data['memoires_vives'] = tab_memoire_vive;
      data['systemes_exploitations'] = tab_systemes_exp;
      data['constructeurs'] = tab_constructeurs;
      data['disques_durs'] = tab_disques_durs
      data['resolutions_ecrans'] = tab_resolutions_ecrans;

      data['action'] = 'search_produits_criteres';
      data['post_type'] = '<?= $_GET["post_type"]; ?>';
      // alert(data['action']);

      $.post(ajaxurl , data)

      .done(function(data) {
        // alert(data);
        $('.results').html(data);
        
        $('div.spinner').toggle();
      });
  });

  $('#search_form').submit(function() {
    return false;
  });
});
</script>
<?php get_sidebar('recherche-criteres'); ?>

<section class="main taxonomy">
	In taxonomy pages..
  <div class="fix_clear"></div>
  <div class="spinner"></div>
 
<div id="search_critere"></div>
<article class="results">
</article>
<div class="fix_clear"></div>


<?php


?>

<?php get_footer(); ?>