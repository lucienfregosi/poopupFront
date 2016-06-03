<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		$redirect = "http://" . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . '/poopupFront/login.php';
		header('Location: ' . $redirect);
	}

	include 'header.php';
?>
<body>
<div class="spinner-container">
	<div class="spinner">
	  <div class="dot1"></div>
	  <div class="dot2"></div>
	</div>
	
</div>
	<div id="map"></div>
</body>

</html>
