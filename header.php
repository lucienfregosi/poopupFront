<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<!-- General page information -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<meta http-equiv="Content-Language" content="fr" />

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDfna2y1msXURVroJD0PHWzUdJCG2yJLI&libraries=visualization"> </script>
  <?php
    if (strpos($_SERVER['PHP_SELF'], 'wc.detail')) {
      echo "<script type=\"text/javascript\" src=\"wcDetail.js\"></script>";
			echo "<script type=\"text/javascript\" src=\"js/rater/rater.min.js\"></script>";
		}
		else {
			echo "<script type=\"text/javascript\" src=\"main.js\"></script>";
		}
  ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.1.1/jquery.rateyo.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.1.1/jquery.rateyo.min.js"></script>


</head>

<header>
	<img class="menu-img" src="img/menu.png" alt="" />
	<img class="logo" src="img/logo.png" alt="" />
</header>

<div class="slider-menu">
	<div class="menu-header clearfix">
		<img class="menu-img-black close-menu" src="img/menu-black.png" alt="" />
		<div class="menu-profile">
			Timothee Dzik
		</div>
	</div>
	<ul>
    <?php
      if (strpos($_SERVER['PHP_SELF'], 'index.php')) {
        echo "<li class=\"menu-item close-menu\">Home</li>";
      } else {
        echo "<a href=\"index.php\"><li class=\"menu-item\">Home</li></a>";
      }
    ?>
		<a href="lastreview.php"><li class="menu-item">Mes Reviews</li></a>
		<a href="apropos.php"><li class="menu-item">A propos</li></a>
	</ul>
</div>
