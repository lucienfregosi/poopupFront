<?php
	session_start();

	// On teste les variables d'entrées
	if(isset($_POST['wc_name'])){
		$wc_name = $_POST['wc_name'];
	}
	else{$wc_name = '';}

	if(isset($_POST['wc_type'])){
		$wc_type = $_POST['wc_type'];
	}
	else{$wc_type = '';}

	if(isset($_POST['wc_address'])){
		$wc_address = $_POST['wc_address'];
	}
	else{$wc_address = '';}

	if(isset($_POST['wc_prix'])){
		$wc_prix = $_POST['wc_prix'];
	}
	else{$wc_prix = '';}

	if(isset($_POST['wc_cnt'])){
		$wc_cnt = $_POST['wc_cnt'];
	}
	else{$wc_cnt = '';}

	if(isset($_POST['wc_note'])){
		$wc_note = $_POST['wc_note'];
	}
	else{$wc_note = '';}

	if(isset($_POST['wc_comment'])){
		$wc_comment = $_POST['wc_comment'];
	}
	else{$wc_comment = '';}

	if(isset($_POST['latitude'])){
		$latitude = $_POST['latitude'];
	}
	else{$latitude = '';}

	if(isset($_POST['longitude'])){
		$longitude = $_POST['longitude'];
	}
	else{$longitude = '';}


	// On va enregistrer le wc
		$url = 'http://54.218.31.103:5555/insertwc';
 		$fields = array(
           	'src_id' => urlencode("Added by user"),
           	'description' => urlencode(''),
           	'wc_cnt' => urlencode($wc_cnt),
           	'address' => urlencode($wc_address),
           	'type' => urlencode($wc_type),
           	'prix' => urlencode($wc_prix),
           	'latitude' => urlencode($latitude),
           	'longitude' => urlencode($longitude),
           	'wc_name' => urlencode($wc_name)
           );

 		// On construit la chaine
 		$fields_string = "";
 		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
 		$wc_id = post_data_with_curl($url,$fields_string);
 		

	// On enregistre la review
 		$url = 'http://54.218.31.103:5555/insertreview';
 		$fields = array(
           	'user_id' => urlencode($_SESSION['user_id']),
           	'wc_id' => urlencode($wc_id),
           	'note' => urlencode($wc_note),
           	'comment' => urlencode($wc_comment),
           );

 		// On construit la chaine
 		$fields_string = "";
 		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

 		$review_id = post_data_with_curl($url,$fields_string);




	// On fait la redirection vers la page d'accueil
 		header('Location: index.php');      


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


?>