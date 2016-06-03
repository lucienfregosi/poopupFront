<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		$redirect = "http://" . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . '/poopupFront/login.php';
		header('Location: ' . $redirect);
	}

	include 'header.php';
?>
<body>
	<div id="map"></div>
</body>

</html>
