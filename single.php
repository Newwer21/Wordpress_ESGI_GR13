<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="main single">
  Single page
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <div class="post">
        <h1 class="post-title"><?php the_title(); ?></h1>
        <p class="post-info">
          Posté le <?php the_date(); ?> dans <?php the_category(', '); ?> par <?php the_author(); ?>.
        </p>
        <div class="post-content">
          <?php the_content(); ?>
        </div>
        <div class="post-comments">
          <?php comments_template(); ?>
        </div>
      </div>
    <?php endwhile; ?>

     <input type="button" value="reserver ?" class="but-res" />

    <div id="reservation">
      <?php include_once plugin_dir_path(__FILE__ ).'/reservationform.php'; ?>
    </div>

  <?php endif; ?>
</div>

<?php get_footer(); ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

  $('#reservation').hide();
  $('.but-res').click( function() {
    $('#reservation').toggle('slow'); 
});

})
</script>