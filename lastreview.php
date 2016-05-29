<?php
	session_start();

	// On va aller chercher les dernières review
	$url = $wc_url = "http://54.218.31.103:5555/lastreview/".$_SESSION['user_id']."";
	$res = get_data_with_curl($url);

	include 'header.php';
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
