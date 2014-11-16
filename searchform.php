<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<aside>

		<?php if ($_GET['types'] == 'ordinateurs') : ?>
		
		<?php $processeurs = get_all_custom_fields_values('processeur_produit'); ?>

		<label for="type">Type</label>
		<select name="type" id="type">
			<option></option>
			<option value="gamer">Gamer</option>
			<option value="multimedia">Multimédia</option>
		</select>

		<p>Processeur<p>
		<?php foreach ($processeurs as $key => $value) : ?>
				<input type="checkbox" name="processeurs[]" value="<?= $key; ?>"> <?php echo $key." ($value) "; ?>
		<?php endforeach; ?>

		<?php elseif ($_GET['types'] == 'tablettes') : ?>
			Affichage search tablettes
		<?php endif; ?>
</aside>
</form>
<?php

function get_all_custom_fields_values($custom_field) {
	global $wpdb;
	$result = array();
	$visited_values = array();

	$values = $wpdb->get_col("SELECT meta_value 
		FROM $wpdb->postmeta WHERE meta_key = '$custom_field'" );
	
	// var_dump($values);

	for($i = 0; $i < sizeof($values) - 1; $i++)
	{
		if ($values[$i] != '' && (!in_array($values[$i], $visited_values)))
		{	
			$cpt = 0;
			for ($j = $i; $j < sizeof($values); $j++)
			{
				if ($values[$j] == $values[$i])
					$cpt++;
			}

			$result[$values[$i]] = $cpt;
			$visited_values[] = $values[$i];
		}
	}
	return $result;
}

?>