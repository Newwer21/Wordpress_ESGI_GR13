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
      $('.results').empty();
 
      var data = {};
      var type = $('#type').val();
      var processeurs = $('#processeurs').val();

      if (type == '')
        type = '<?= $_GET["types"]; ?>';

      data['type'] = type;
      data['processeurs'] = processeurs;
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
<article class="results"></article>
<div class="fix_clear"></div>
<?php

?>
<?php get_footer(); ?>