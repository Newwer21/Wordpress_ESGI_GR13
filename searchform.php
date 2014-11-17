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