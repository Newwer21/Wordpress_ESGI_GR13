<?php 

	$constructeurs = get_all_custom_fields_values('constructeur_tablette');
	$disques_durs = get_all_custom_fields_values('dd_tablette');
	$resolutions = get_all_custom_fields_values('resolution_tablette');

	// $args_terms = array('hide_empty' => false);

	// // var_dump($processeurs);
	// // var_dump($memoires);
	// // var_dump($system_expl);
	// // var_dump($constructeurs);

	// $taxonomy = get_object_taxonomies($post_type);
	// $terms = get_terms($taxonomy, $args_terms);
	// var_dump($memoires);
?>
		<p>Constructeurs</p>
		<?php foreach ($constructeurs as $key => $value) : ?>
				<p class="champs_critere"><input type="checkbox" name="constructeurs" id="constructeurs" value="<?= $key; ?>"><label for="constructeurs"> <?php echo $key." ($value) "; ?></label></p>
		<?php endforeach; ?>

		<p>Résolution d'écran</p>
		<?php foreach ($resolutions as $key => $value) : ?>
				<p class="champs_critere"><input type="checkbox" name="resolutions" id="resolutions" value="<?= $key; ?>"><label for="resolutions"> <?php echo $key." ($value) "; ?></label></p>
		<?php endforeach; ?>

		<p>Disques Durs</p>
		<?php foreach ($disques_durs as $key => $value) : ?>
				<p class="champs_critere"><input type="checkbox" name="disques_durs" id="disques_durs" value="<?= $key; ?>"><label for="disques_durs"> <?php echo $key." ($value) "; ?></label></p>
		<?php endforeach; ?>

		<p>Connectivite</p>
			<p class="champs_critere"><input type="checkbox" name="bluetooth" id="bluetooth" value="1"> <label for="bluetooth">Bluetooth</label></p>