<?php
	session_start();

	// On va aller chercher les dernières review
	$url = $wc_url = "http://54.218.31.103:5555/lastreview/".$_SESSION['user_id']."";
	$res = get_data_with_curl($url);



	// On veut afficher sur la carte toutes les review de l'user
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
	      #mapLastReview { height: 50%; }
	</style>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDfna2y1msXURVroJD0PHWzUdJCG2yJLI&libraries=visualization"> </script>
	<script type="text/javascript" src="lastreview.js"></script>
	</head>
	
	<body>';
		
	
	// - On affiche la carte avec la postition du restaurant
	echo '<div id="mapLastReview"></div>';
	//echo '<script> showMarker('.$lat.','.$lng.');</script>';

	$res = json_decode($res);
	for($i = 0; $i < count($res); $i++){
		echo "Note :".$res[$i]->note;
		echo "Comment :".$res[$i]->comment;
		echo "</br>";

		// On ajoute les points sur la map
		echo '<script> showMarker('.$res[$i]->latitude.','.$res[$i]->longitude.');</script>';
	}



	function get_data_with_curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

?>