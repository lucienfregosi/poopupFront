<?php
	session_start();

	// On teste les variables d'entrées
	if(isset($_POST['wc_id'])){
		$wc_id = $_POST['wc_id'];
	}
	else{$wc_id = '';}

	if(isset($_POST['user_id'])){
		$user_id = $_POST['user_id'];
	}
	else{$user_id = '';}

	if(isset($_POST['note'])){
		$note = $_POST['note'];
	}
	else{$note = '';}

	if(isset($_POST['comment'])){
		$comment = $_POST['comment'];
	}
	else{$comment = '';}

 		
	// On enregistre la review
 		$url = 'http://54.218.31.103:5555/insertreview';
 		$fields = array(
           	'user_id' => urlencode($_SESSION['user_id']),
           	'wc_id' => urlencode($wc_id),
           	'note' => urlencode($note),
           	'comment' => urlencode($comment),
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