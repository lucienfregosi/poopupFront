<?php
	session_start();
	// On doit d'abord tester si l'on vient d'un d'une google places ou de l'api interne
	if(isset($_POST['src_id'])){
		if($_POST['src_id'] == 'gplaces'){
			// On vient d'un google post, il va donc falloir l'ajouter si l'utilisateur le note ou met un commentaire
			$name  = $_POST['name'];
			$type = $_POST['type'];
 			$lat = $_POST['lat'];
 			$lng = $_POST['lng'];
 			$adress = $_POST['adress'];
 			$prix = 'undef';
 			$wc_cnt = 'unknown';
 			$note = 'undef';
 			$comment_flg = null;
 			$src_id = 'gplacesBDD';


 			// On ajoute le post a la base de données avec Curl
 			$url = 'http://54.218.31.103:5555/insertwc';
 			$fields = array(
            	'src_id' => urlencode($src_id),
            	'description' => urlencode(''),
            	'wc_cnt' => urlencode($wc_cnt),
            	'address' => urlencode($adress),
            	'type' => urlencode($type),
            	'prix' => urlencode($prix),
            	'latitude' => urlencode($lat),
            	'longitude' => urlencode($lng),
            	'wc_name' => urlencode($name)
            );
 			// On construit la chaine
 			$fields_string = "";
 			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');

 			$wc_id = post_data_with_curl($url,$fields_string);

 			// C'est bon le wc est sauvegardé

		}
		else if($_POST['src_id'] == 'internal'){
			$wc_id = $_POST['id'];
			// On vient d'un wc interne, il va donc falloir mettre à jour ses informations ou sa review/ note
			$wc_url = "http://54.218.31.103:5555/wcinfo/".$wc_id."";

			$wc_info_json = get_data_with_curl($wc_url);
        	// On décode le json pour pouvoir le traiter
        	$wc_info_array = json_decode($wc_info_json);

        	$name  = $wc_info_array->wc[0]->wc_name;
			$type = $wc_info_array->wc[0]->type;
 			$lat = $wc_info_array->wc[0]->latitude;
 			$lng = $wc_info_array->wc[0]->longitude;
 			$prix = $wc_info_array->wc[0]->prix;
 			$wc_cnt = $wc_info_array->wc[0]->wc_cnt;
 			$note = $wc_info_array->wc[0]->note;

 			// On va get la liste des review
 			$wc_url = "http://54.218.31.103:5555/wcreview/".$wc_id."";

			$wc_review_json = get_data_with_curl($wc_url);
        	// On décode le json pour pouvoir le traiter
        	$wc_review_array = json_decode($wc_review_json);

        	$review_message = '';
        	if(empty($wc_review_array->wc)){
        		// Il n'y a pas de review
        		$review_message = 'Pas de commentaires pour ces toilettes';
        	}

        	$src_id = 'internal';
        	
		}
		else{
			echo "error";
		}
	}
	else{
		echo "error";
	}

	// Ce qu'on veut afficher sur cette page:
	// - une carte en haut avec la position du toilette concerné
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
	      #mapDetail { height: 50%; }
	</style>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDfna2y1msXURVroJD0PHWzUdJCG2yJLI&libraries=visualization"> </script>
	<script type="text/javascript" src="wcDetail.js"></script>
	</head>
	
	<body>';
		
	
	// - On affiche la carte avec la postition du restaurant
	echo '<div id="mapDetail"></div>';
	echo '<script> showMarker('.$lat.','.$lng.');</script>';


	// On affiche le HTML
	echo '
	<h2>'.$name.'</h2>
	<label>Type : '.$type.'</label></br>
	<label>prix : '.$prix.'</label></br>
	<label>Nb Wc : '.$wc_cnt.'</label></br>
	<label>Note Globale : '.$note.'</label></br>';

	// On a des review des toilettes seulement si c'est un interal
	if($src_id == 'internal'){
		if($review_message != ''){
			// Le message est initilaisé on a pas de résultats donc on l'affiche
			echo '<label>review : '.$review_message.'</label></br>';
		}
		else{
			print_r($wc_review_array);
		}
	}

	// HTML pour ajouter note review. A voir comment gérer le user id (avec une variable de session mais attendre d'avoir set le login)
	echo '<form action = "http://54.218.31.103:5555/insertreview" method = "POST">
	<label>Votre note : </label><input type="number" name="note"/></br>
	<label>Votre review : </label><input type="text" name="comment"/></br>
	<input type="hidden" name="wc_id" value="'.$wc_id.'"/>
	<input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'"/>
	<input type="submit" value="Notez" />
	</form>';

	echo $wc_id;

	// On veut ensuite sauvegarder les modifications 
	// 1. Si c'est une google places, on va proposer de l'enregistrer dans la base de données

	//2.  Si c'est un wc internal on propose de sauvegarder les données si elles ont été modifiés et de sauvagarder la review

	// On ferme les balises
	echo '</body></html>';


	// Fonction pour faire des get
	function get_data_with_curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function post_data_with_curl($url,$str_value){

    	$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $str_value);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);

		return $server_output;
    }


