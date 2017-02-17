<?php

require_once 'model/profil.php';
require_once 'model/historique.php';
require_once 'model/classLolQuery.php';

//--- Formulaire de recherche de summoner ---//
$FormRecherche=(!empty($_POST["Recherche"]))? $_POST["Recherche"]:"";
$FormRecherche=(!empty($_GET["Recherche"]))? $_GET["Recherche"]:$FormRecherche;

if( !empty($FormRecherche) )
{
	$Lol = new LolQuery();

	$_SESSION['Profil'] = array();
	$_SESSION['Profil']['player'] = $Lol->getSummonerByName($_POST['NamePlayer']);

	//$_SESSION['Free'] = $Lol->GetChampFree(true);

	//$RecupLoading = AllLoadingScreenArt();
	//$RecupSquare = AllSquare();
	//$Icon = AllProfilIcon(900, 1200);
	//$Item = AllItem(1000, 5000);
	//$Spell = AllSummonerSpell();

	//$currentGame = $Lol->getCurrentGame($id); var_dump($currentGame);
	
	
	$_SESSION['Historique'] = $Lol->getHistoric($_SESSION['Profil']['player']['id']); // var_dump($_SESSION['Historique']);

	// $league = $Lol->getLeague($id); var_dump($league);	
	// $stats = $Lol->getStatsRanked($id); var_dump($stats);
}

//--- Formulaire de recherche de summoner ---//
$FormProfil=(!empty($_POST["AffichageProfil"]))? $_POST["AffichageProfil"]:"";
$FormProfil=(!empty($_GET["AffichageProfil"]))? $_GET["AffichageProfil"]:$FormProfil;
if( !empty($FormProfil) )
{

}

//--- Affiche le profil actuellement recherché ---//
function checkProfilToPrint()
{
	if( !empty($_SESSION['Profil']) )
	{
		$Lol = new LolQuery();
		$_SESSION['Profil']['runes'] = $Lol->getRunesById($_SESSION['Profil']['player']['id']);
		$_SESSION['Profil']['masteries'] = $Lol->getMasteriesById($_SESSION['Profil']['player']['id']);
		$print = Profil($_SESSION['Profil']);
		echo $print;
	}
	else
	{
		echo '<div class="container">
				<div class="col-md-6 col-md-offset-3 alert alert-info" style="margin-top: 30px;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Recherchez un joueur afin d\'afficher son profil !
				</div>
			</div>';
	}
}

//--- Affiche l'historique ---//
function checkHistoricToPrint()
{
	if( !empty($_SESSION['Historique']) )
	{
		$print = Historique($_SESSION['Historique']);
		echo $print;
	}
	else
	{
		echo '<div class="container">
				<div class="col-md-6 col-md-offset-3 alert alert-info" style="margin-top: 30px;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Recherchez un joueur afin d\'afficher son historique !
				</div>
			</div>';
	} 
}

//--- Affiche les données des parties classés ---//
function checkRankedToPrint()
{
	if( !empty($_SESSION['Ranked']) )
	{
		$print = Ranked($_SESSION['Ranked']);
		echo $print;
	}
	else
	{
		echo '<div class="container">
				<div class="col-md-6 col-md-offset-3 alert alert-info" style="margin-top: 30px;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Recherchez un joueur afin d\'afficher ses statistiques en classé !
				</div>
			</div>';
	}
}
?>