<?php 

/**
* @author Guillaume BONHOMMEAU
* @package lolthrow
* @version 1.0 -- 10/10/2015
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v3 or later
*/

require_once 'classLolQuery.php';

static $version = '7.1.1';

/***********************************************************************/
/****************           CHAMPION PICTURE            ****************/
/***********************************************************************/
function AllLoadingScreenArt()
{
	/*if(! $Resultat = $this->getChampBasic() )
	{
		$this->AffichMsgErreur("Erreur dans la récupération des données des champions.");
	}*/

	$Lol = new LolQuery(); $Liste = $Lol->getChampBasic();
	$Resultat = json_decode($Liste, true);
	$TabName = array();
	$DossierImage = "include/images/Champions/Loading Screen/";

	$TabName = array();
	foreach($Resultat['data'] as $champ)
	{
		/*$LowString = strtolower(substr($champ['name'], 1)); // Met le nomen minuscule, excepté le premier charactère
		$varChamp = substr($champ['name'], 0, 1).$LowString;*/
		$varChamp = $champ['key'];
		array_push( $TabName, preg_replace( '/[^a-zA-Z]/', '', $varChamp));
	}
	unset($champ);

	foreach($TabName as $name)
	{
		$image = file_get_contents("http://ddragon.leagueoflegends.com/cdn/img/champion/loading/". $name ."_0.jpg");
		file_put_contents($DossierImage.$name.".jpg", $image);
	}
	unset($champ);

	return true;
}

function AllSquare()
{
	/*if(! $Resultat = $this->getChampBasic() )
	{
		$this->AffichMsgErreur("Erreur dans la récupération des données des champions.");
	}*/

	$Lol = new LolQuery(); $Liste = $Lol->getChampBasic();
	$Resultat = json_decode($Liste, true);
	$TabName = array();
	$DossierImage = "include/images/Champions/Square/";

	$TabName = array();
	foreach($Resultat['data'] as $champ)
	{
		/*$LowString = strtolower(substr($champ['name'], 1)); // Met le nomen minuscule, excepté le premier charactère
		$varChamp = substr($champ['name'], 0, 1).$LowString;*/
		$varChamp = $champ['key'];
		array_push( $TabName, preg_replace( '/[^a-zA-Z]/', '', $varChamp));
	}
	unset($champ);
		
	foreach($TabName as $name)
	{
		$image = file_get_contents("http://ddragon.leagueoflegends.com/cdn/". $GLOBALS['version'] ."/img/champion/".$name.".png");
		file_put_contents($DossierImage.$name.".jpg", $image);
	}
	unset($champ);

	return true;
}


function AllSplash()
{
	/*if(! $Resultat = $this->getChampBasic() )
	{
		$this->AffichMsgErreur("Erreur dans la récupération des données des champions.");
	}*/

	$Lol = new LolQuery(); $Liste = $Lol->getChampBasic();
	$Resultat = json_decode($Liste, true);
	$TabName = array();
	$DossierImage = "include/images/Champions/Splash/";

	$TabName = array();
	foreach($Resultat['data'] as $champ)
	{
		/*$LowString = strtolower(substr($champ['name'], 1)); // Met le nomen minuscule, excepté le premier charactère
		$varChamp = substr($champ['name'], 0, 1).$LowString;*/
		$varChamp = $champ['key'];
		array_push( $TabName, preg_replace( '/[^a-zA-Z]/', '', $varChamp));
	}
	unset($champ);
		
	foreach($TabName as $name)
	{
		$image = file_get_contents("http://ddragon.leagueoflegends.com/cdn/img/champion/splash/".$name."_0.jpg");
		file_put_contents($DossierImage.$name.".jpg", $image);
	}
	unset($champ);

	return true;
}

function AllItem($start, $end)
{
	$Lol = new LolQuery();
	$DossierImage = "include/images/Item/";	

	for($i=$start; $i<=$end; $i++)
	{
		$content = @file_get_contents("http://ddragon.leagueoflegends.com/cdn/". $GLOBALS['version'] ."/img/item/".$i.".png"); // Supprime le warning si echec
		if($content !== FALSE)
		{
			if( file_put_contents($DossierImage."Item_".$i.".png", $content) === FALSE)
			{
				echo "merde"; 
				//return false;
			}
		}
	}
	return true;
}

function AllSummonerSpell()
{
	$Lol = new LolQuery();
	$DossierImage = "include/images/SumSpell/";

	// Récupération des ID (type string) des summoners spells	
	$Lol->SetUrl('http://ddragon.leagueoflegends.com/cdn/'.$GLOBALS['version'].'/data/en_US/summoner.json');
	$json = $Lol->CurlRequest(); $json = json_decode($json, true);
	$SumFullName = array(); // Array summs full name picture

	foreach($json['data'] as $data)
	{
		array_push($SumFullName, $data['image']['full']);
	}
	unset($data);

	foreach($SumFullName as $full)
	{
		$content = @file_get_contents('http://ddragon.leagueoflegends.com/cdn/'.$GLOBALS['version'].'/img/spell/'.$full); // Supprime le warning si echec
		if($content !== FALSE)
		{
			if( file_put_contents($DossierImage.$full, $content) === FALSE)
			{
				echo "merde"; 
				//return false;
			}
		}
	}
	unset($full);

	return true;
}

/**
* Recupere toutes les icones de profil
* @param : start / end : int / int -> Intervalle pour l'itération
*/
function AllProfilIcon($start, $end)
{
	$Lol = new LolQuery();
	$DossierImage = "include/images/Profil/";	

	for($i=$start; $i<=$end; $i++)
	{
		$content = @file_get_contents("http://ddragon.leagueoflegends.com/cdn/". $GLOBALS['version'] ."/img/profileicon/". $i .".png"); // Supprime le warning si echec
		if($content !== FALSE)
		{
			if( file_put_contents($DossierImage."Icon_".$i.".png", $content) === FALSE)
			{
				echo "merde"; 
				//return false;
			}
		}
	}
	return true;
}

?>