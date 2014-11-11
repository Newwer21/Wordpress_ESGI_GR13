<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<aside>

		<?php if ($_GET['types'] == 'ordinateurs') : ?>

		<label for="type">Type</label>
		<select name="type" id="type">
			<option></option>
			<option value="gamer">Gamer</option>
			<option value="multimedia">Multimédia</option>
		</select>

		1<input type="checkbox">
		<label for="text">Text</label><input type="text" name="text" id="text">
		
		<?php elseif ($_GET['types'] == 'tablettes') : ?>
			Affichage search tablettes
		<?php endif; ?>
</aside>
</form>


