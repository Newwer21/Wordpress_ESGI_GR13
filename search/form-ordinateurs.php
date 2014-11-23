<?php 

	$processeurs = get_all_custom_fields_values('processeur_ordinateur');
	$memoires = get_all_custom_fields_values('ram_ordinateur');
	$system_expl = get_all_custom_fields_values('os_ordinateur');
	$constructeurs = get_all_custom_fields_values('constructeur_ordinateur');
	$args_terms = array('hide_empty' => false);

	// var_dump($processeurs);
	// var_dump($memoires);
	// var_dump($system_expl);
	// var_dump($constructeurs);

	$taxonomy = get_object_taxonomies($post_type);
	$terms = get_terms($taxonomy, $args_terms);
	// var_dump($memoires);
?>
<!-- <label for="type">Type</label>
		<select name="type" id="type">
			<option></option>
<?php //foreach ($terms as $term) : ?>

	<option value="<?php //echo $term->name; ?>"><?php //echo $term->name; ?></option>

<?php //endforeach; ?> -->
		</select>
		<p>Processeurs</p>
		<?php foreach ($processeurs as $key => $value) : ?>
				<p class="champs_critere"><span><label for="processeurs"><input type="checkbox" name="processeurs" id="processeurs" value="<?= $key; ?>"> <?php echo $key." ($value) "; ?></label></span></p>
		<?php endforeach; ?>

		<p>Mémoires vives</p>
		<?php foreach ($memoires as $key => $value) : ?>
				<p class="champs_critere"><span><input type="checkbox" name="memoires_vives" id="memoires_vives" value="<?= $key; ?>"> <?php echo $key." Go ($value) "; ?></span></p>
		<?php endforeach; ?>

		<p>Systèmes d'exploitation</p>
		<?php foreach ($system_expl as $key => $value) : ?>
				<p class="champs_critere"><span><input type="checkbox" name="systemes_exploitations" id="systemes_exploitations" value="<?= $key; ?>"> <?php echo $key." ($value) "; ?></span></p>
		<?php endforeach; ?>

		<p>Constructeurs</p>
		<?php foreach ($constructeurs as $key => $value) : ?>
				<p class="champs_critere"><span><input type="checkbox" name="constructeurs" id="constructeurs" value="<?= $key; ?>"> <?php echo $key." ($value) "; ?></span></p>
		<?php endforeach; ?>