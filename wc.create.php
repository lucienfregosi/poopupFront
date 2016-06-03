<?php
	session_start();

	$lng =  $_POST['longitude'];
	$lat =  $_POST['latitude'];
	// On veut afficher le point sur une petite map
	// demander les infos de facon a akputer un wc et une review
	// revenir sur la page d"acceuil avec les toilettes nouvellemenet crée
	// A voir quand meme avec les mockups de tim
	include 'header.php';
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
	<!-- General page information -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Language" content="fr" />

	<style type="text/css">
	      html, body { height: 100%; margin: 0; padding: 0; }
	      #mapCreate { height: 50%; }
	</style>

	</head>

	<body>


	<div id="mapCreate"></div>
	<?php echo "<script> showMarker('$lat', '$lng');</script>"; ?>


	<!-- Formulaire pour rentrer les informations du WC
	type / prix / adresse / place name / prix / count
	Formulaire pour les faire une review -->
	<form id="create" method="post" action="wc.add.php"/>
	<span class="input input--hoshi">
		<input class="input__field input__field--hoshi" type="text" name="wc_name" id="input-4" />
		<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="input-4">
			<span class="input__label-content input__label-content--hoshi">Nom du WC</span>
		</label>
	</span>
	<br>
	<span class="input input--hoshi" style="margin-top:40px">
		<input class="input__field input__field--hoshi" type="text" name="wc_type" id="input-5" />
		<label class="input__label input__label--hoshi input__label--hoshi-color-2" for="input-5">
			<span class="input__label-content input__label-content--hoshi">Type de WC</span>
		</label>
	</span>
	<span class="input input--hoshi">
		<input class="input__field input__field--hoshi" type="text" name="wc_address" id="input-4" />
		<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="input-4">
			<span class="input__label-content input__label-content--hoshi">Address du WC</span>
		</label>
	</span>
	<br>
	<span class="input input--hoshi">
		<input class="input__field input__field--hoshi" type="text" name="wc_prix" id="input-4" />
		<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="input-4">
			<span class="input__label-content input__label-content--hoshi">Prix</span>
		</label>
	</span>
	<br>
	<span class="input input--hoshi" style="margin-top:40px">
		<input class="input__field input__field--hoshi" type="text" name="wc_cnt" id="input-5" />
		<label class="input__label input__label--hoshi input__label--hoshi-color-2" for="input-5">
			<span class="input__label-content input__label-content--hoshi">Nombre de toilette</span>
		</label>
	</span>
	<span class="input input--hoshi">
		<input class="input__field input__field--hoshi" type="text" name="wc_note" id="input-4" />
		<label class="input__label input__label--hoshi input__label--hoshi-color-1" for="input-4">
			<span class="input__label-content input__label-content--hoshi">Note</span>
		</label>
	</span>
	<br>
	<span class="input input--hoshi" style="margin-top:40px">
		<input class="input__field input__field--hoshi" type="textarea" name="wc_comment" id="input-5" />
		<label class="input__label input__label--hoshi input__label--hoshi-color-2" for="input-5">
			<span class="input__label-content input__label-content--hoshi">Commentaire</span>
		</label>
	</span>
	<input type="hidden" name="latitude" value="<php echo $lat; ?>">
	<input type="hidden" name="longitude" value="<php echo $lng; ?>">
	<input class="button" type="submit" value="Add WC">
	</form>
