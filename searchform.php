<!-- Formulaire de recherche par critères relié à taxonomy.php -->
<!-- Structure du formulaire :
- 2 champs prix : prix min, prix max. Pour les 3.
- Partie processeurs en affichant une liste checkbox des processeurs existants grâce à get_all_custom_fields_values(). PC
- Partie Carte graphique comme processeurs PC.
- Partie mémoire vive comme pour processeurs. Les 3
- Choix du type produits (gamer, multimédia, Mac...) => Liste déroulante.
... Plus d'idées...

- Choix type Tablettes : Android/Windows ?/Ipad.

- Choix phablettes : ...

Design :

Champs pri_min 	Champs prix_max
Processeurs 
▄ AMD
▄ Pentium
▄ I5
▄ i7
...

Graphique
▄ Nvidia
▄ ATI
▄ Intel
...

Mémoire vive
▄ 2 Go
▄ 4 Go
▄ 6 Go
▄ 8 Go
▄ 16 Go
...
Un truc de ce genre sachant que chaque checkbox est un produit ayant au moins 
1 de ses caractéristiques.

 -->
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<aside>

		<?php if ($_GET['types'] == 'gamer') : ?>
		
		<?php 
			$processeurs = get_all_custom_fields_values('processeur_produit');
			$memoires = get_all_custom_fields_values('ram_produit');
			// var_dump($memoires);
		?>
		<div>
				<label for="prix_min">Min</label>
				<input type="text" name="prix_min" id="prix_min" size="2">

				<label for="prix_max">Max</label>
				<input type="text" name="prix_max" id="prix_max" size="2">
		</div>
		
		<label for="type">Type</label>
		<select name="type" id="type">
			<option></option>
			<option value="gamer">Gamer</option>
			<option value="multimedia">Multimédia</option>
		</select>

		<p>Processeur</p>
		<?php foreach ($processeurs as $key => $value) : ?>
				<p class="champs_critere"><span><label for="processeurs"><input type="checkbox" name="processeurs[]" id="processeurs" value="<?= $key; ?>"> <?php echo $key." ($value) "; ?></label></span></p>
		<?php endforeach; ?>

		<p>Mémoire vive</p>
		<?php foreach ($memoires as $key => $value) : ?>
				<p class="champs_critere"><span><input type="checkbox" name="memoires_vives[]" id="memoires_vives" value="<?= $key; ?>"> <?php echo $key." Go ($value) "; ?></span></p>
		<?php endforeach; ?>

		<?php elseif ($_GET['types'] == 'tablettes') : ?>
			Affichage search tablettes
		<?php endif; ?>
</aside>
</form>