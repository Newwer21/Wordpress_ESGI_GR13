<?php 
	$processeurs = get_all_custom_fields_values('processeur_produit');
	$memoires = get_all_custom_fields_values('ram_produit');
	$args_terms = array('hide_empty' => false);

	$taxonomy = get_object_taxonomies($post_type);
	$terms = get_terms($taxonomy, $args_terms);
	// var_dump($memoires);
?>
<label for="type">Type</label>
		<select name="type" id="type">
			<option></option>
<?php foreach ($terms as $term) : ?>

	<option value="<?= $term->name; ?>"><?= $term->name; ?></option>

<?php endforeach; ?>
		</select>
		<p>Processeur</p>
		<?php foreach ($processeurs as $key => $value) : ?>
				<p class="champs_critere"><span><label for="processeurs"><input type="checkbox" name="processeurs[]" id="processeurs" value="<?= $key; ?>"> <?php echo $key." ($value) "; ?></label></span></p>
		<?php endforeach; ?>

		<p>Mémoire vive</p>
		<?php foreach ($memoires as $key => $value) : ?>
				<p class="champs_critere"><span><input type="checkbox" name="memoires_vives[]" id="memoires_vives" value="<?= $key; ?>"> <?php echo $key." Go ($value) "; ?></span></p>
		<?php endforeach; ?>