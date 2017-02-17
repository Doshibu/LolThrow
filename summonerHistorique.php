<?php
	// if (substr_count($_SERVER[‘HTTP_ACCEPT_ENCODING’], ‘gzip’)) ob_start(“ob_gzhandler”); else ob_start();
@ob_start();
session_start();

include_once 'model/menus.php';
include_once 'controller/summoner.php';
include_once 'controller/index.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width, initial-scale=1.0" />
	<meta name="description" content="Le meilleur outil pour vos games sur League of Legends.">
	<meta name="author" content="BONHOMMEAU Guillaume">
	<meta name="publisher" content="Bonhommeau Guillaume">
	<meta name="format-detection" content="telephone=no"/>

	<meta property="og:description" content="Le meilleur outil pour vos games sur League of Legends.">
	<meta property="og:url" content="http://bonhommeaupaysage.webou.net/Run&Throw/">
	<meta property="og:title" content="Run&Throw pour perdre vos games !">
	<meta property="og:type" content="website">

	<link rel="icon" type="image/png" href="include/images/lolLogo.png" /> 
	<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="images/logo.png" /><![endif]-->

	<title>Perdez vos games !</title>

	<!-- Bootstrap Core CSS -->
	<link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="include/css/style.css" rel="stylesheet" />
	<link href="include/css/historique.css" rel="stylesheet" />

	<!-- Javascript Ressources -->
	<script src="include/js/jquery.min.js"></script>	
	<script type="text/javascript" src="http://www.laurendeauimmobilier.fr/script/jquery.flexslider-min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.flexslider').flexslider({
				animation: "fade",
				controlNav: false,
				animationSpeed: 2000,
				slideshowSpeed: 1000,
			});
		});
	</script>
	
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-68416120-2', 'auto');
		ga('send', 'pageview');
	</script>
</head>
<body>
	<div id="container">
		<?php checkFreeToPrint(); ?>
		<div id="content">
			<div class="wrapper">
				<div class="clip-text clip-text_four">LoL Junket</div>
			</div>

			<div class="container body-plan">
				<?php
						// Affichage du résumé des games
				checkHistoricToPrint();
				?>
			</div>
		</div>
	</div>

	<script>
		function displayStats(calledBy, id) 
		{
			var button = document.getElementById(calledBy);
			var div = document.getElementById(id);
			if (div.style.display !== 'none') 
			{
				div.style.display = 'none';
				button.innerHTML = 'Voir plus <span class="glyphicon glyphicon-circle-arrow-down"></span>';
			}
			else 
			{
				div.style.display = 'block';
				button.innerHTML = 'Voir moins <span class="glyphicon glyphicon-circle-arrow-up"></span>';
			}
		}

		$(document).ready(function()
		{
			$('[data-toggle="tooltip"]').tooltip();   
		});
	</script>
	<script src="include/js/bootstrap.js"></script>
</body>
</html>