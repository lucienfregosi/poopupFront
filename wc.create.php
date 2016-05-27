<?php
	session_start();

	$lng =  $_POST['longitude'];
	$lat =  $_POST['latitude'];

	// On veut afficher le point sur une petite map
	// demander les infos de facon a akputer un wc et une review
	// revenir sur la page d"acceuil avec les toilettes nouvellemenet crée
	// A voir quand meme avec les mockups de tim

	echo '
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
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDfna2y1msXURVroJD0PHWzUdJCG2yJLI&libraries=visualization"> </script>
	<script type="text/javascript" src="wc.create.js"></script>
	</head>
	
	<body>';
		
	
	// - On affiche la carte avec la postition du restaurant
	echo '<div id="mapCreate"></div>';
	echo '<script> showMarker('.$lat.','.$lng.');</script>';

	// Formulaire pour rentrer les informations du WC
	// type / prix / adresse / place name / prix / count
	// Formulaire pour les faire une review

	echo '<form method="post" action="wc.add.php"/>';
	echo '<label> Nom du WC </label><input type="text" name="wc_name"></br>';
	echo '<label> Type de WC </label><input type="text" name="wc_type"></br>';
	echo '<label> Adress du WC</label><input type="text" name="wc_address"></br>';
	echo '<label> Prix des WC </label>  <input type="number" name="wc_prix"></br>';
	echo '<label> Nombre de WC  </label><input type="number" name="wc_cnt"></br>';

	echo '<label> Votre note </label><input type="number" name="wc_note"></br>';
	echo '<label> Votre commentaire </label><input type="text" name="wc_comment"></br>';
	
	// La longitude et la latitude dans des champs cachés, qui seront passé en $_POST
	echo '<input type="hidden" name="latitude" value="'.$lat.'">';
	echo '<input type="hidden" name="longitude" value="'.$lng.'">';

	echo '<input type="submit" value="Add WC">';
	echo '</form';
	// On affiche le HTML



  ?>
