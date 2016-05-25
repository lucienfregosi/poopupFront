<?php
	session_start();
	$url = 'http://54.218.31.103:5555/login';
	$fields = array(
            	'login' => urlencode($_POST['login']),
            	'mdp' => urlencode($_POST['mdp'])
            );
	// On construit la chaine
 	$fields_string = "";
 	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');


	$res = post_data_with_curl($url, $fields_string);


	$res = json_decode($res);

	if($res->loginStatus->status == 'true'){
		$_SESSION['user_id'] = $res->loginStatus->user_id;
		header('Location: index.php'); 
	}
	else{
		header('Location: login.php'); 
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

?>