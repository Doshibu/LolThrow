<?php
// if (substr_count($_SERVER[‘HTTP_ACCEPT_ENCODING’], ‘gzip’)) ob_start(“ob_gzhandler”); else ob_start();
@ob_start();
session_start();

include_once 'model/menus.php';
include_once 'controller/index.php';
/*require_once 'model/classLolRecord.php';

	$RecupSplash = AllSquare();*/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; utf-8">
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

	<title>LoL Junket</title>

	<!-- Bootstrap Core CSS -->
	<link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="include/css/style.css" rel="stylesheet" />
	<link href="include/css/index.css" rel="stylesheet" />

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
				<form action="summonerHistorique.php" method="post" class="col-md-8 col-md-offset-2">
					<fieldset>
						<div class="form-search form-group">
							<label class="control-label col-sm-4" for="name">Nom d'invocateur</label>
							<div class="col-sm-8" id="divInputName">
								<input class="form-control" name="NamePlayer" id="NamePlayer" placeholder="King Toy Throws" value="King Toy Throws" type="text">
							</div>
						</div>
						<button type="submit" id="activator" name="Recherche" value="Recherche" class="btn btn-primary" onclick="FuncLoad();" style="height: 50px;/*!  */font-size: 1.5em;margin: auto;display: block;margin-bottom: 25px;">Rechercher</button>

					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<script src="include/js/bootstrap.js"></script>
</body>
</html>