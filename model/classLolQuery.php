<?php

/**
* @author Guillaume BONHOMMEAU
* @package lolthrow
* @version 1.0 -- 10/10/2015
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v3 or later
*/

require_once "classLolSorting.php";

define("API_KEY", '64b83c8e-55a1-49b2-99fd-114a7d337435', true);

// Définition des constantes pour les erreurs possibles
define("CODE_400", 'Erreur dans la requête.', true);
define("CODE_401", 'Non autorisé. Vous ne disposez pas de la bonne permission pour cette requête.', true);
define("CODE_404", 'Aucune donnée trouvé.', true);
define("CODE_429", 'Temps d\'exécution dépassé.', true);
define("CODE_500", 'Erreur de serveur interne.', true);
define("CODE_503", 'Service indisponible.', true);

/**
 * LolQuery class
 *
 * @author Guillaume BONHOMMEAU
 * @since v1.0 -- 10/10/2015
 */
class LolQuery
{	
	private $url;
	private $NbQuery;

	/**
	 * Main object LolQuery
	 */
	function LolQuery()
	{
		$this->url = '';
	}

	function SetUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * Send curl request method
	 * @return string : curl_exec()
	 */
	function CurlRequest()
	{
		$curl = curl_init($this->url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		$curl_exec = curl_exec($curl);
		$curl_info = curl_getinfo($curl);

		if(curl_errno($curl))
		{
			$this->AffichMsgErreur("Erreur curl : ". curl_error($curl) .". Code HTTP : ". $curl_info["http_code"] .".");
			return false;
		}

		if($curl_info["http_code"] !== 200)
		{
			$message = "Erreur HTTP, code [". $curl_info["http_code"] ."]. ";
			$message.=(defined("CODE_".$curl_info['http_code']))? constant("CODE_".$curl_info['http_code'])."." : "";
			$this->AffichMsgErreur($message);
			return false;
		}

		curl_close($curl);
		return $curl_exec; // var_dump($json); echo "<br /><br /><br />";
	}

	/**
	* @param $erreur string : erreur a affiché
	* @return void
	*/
	function AffichMsgErreur($erreur)
	{
		echo '<div class="container">
				<div class="col-md-6 col-md-offset-3 alert alert-danger" style="margin-top: 30px;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					'. $erreur .'
				</div>
			</div>';
	}

/***********************************************************************/
/****************                CHAMPION               ****************/
/***********************************************************************/
	function getChampion()
	{
		$this->url = "https://euw.api.pvp.net/api/lol/euw/v1.2/champion?api_key=".API_KEY;
		$Resultat = $this->CurlRequest();

		return $Resultat;
	}

	function getChampionByID($id)
	{
		$this->url = "https://euw.api.pvp.net/api/lol/euw/v1.2/champion/". $id ."?api_key=".API_KEY;
		$Resultat = $this->CurlRequest();

		return $Resultat;
	}

	/**
	* Récupère les champions gratuits de la semaine
	* @param : $Image boolean NULL defaut
	* @return : BOOLEAN
	*/
	function GetChampFree($Image=NULL, $SkinVersion="0")
	{
		$Resultat = $this->getChampion(); $Resultat = json_decode($Resultat, true);

		$FreeToPlay = array();
		foreach($Resultat['champions'] as $champ)
		{
			if($champ['freeToPlay'] === true)
			{
				// On récupère le nom du champion
				array_push( $FreeToPlay, $this->getChampNameByID($champ['id']) );
			}
		}

		// On récupère les chemins d'images de chaque champion gratuit, stockés dans include/images/champions/...
		if($Image === TRUE)
		{
			$TabImage = array();
			//$CheminImage = "include/images/Champions/Loading Screen/";
			$CheminImage = "include/images/Champions/Splash/";

			foreach($FreeToPlay as $champ)
			{
				array_push($TabImage, $CheminImage.$champ.".jpg");
			}

			return $TabImage;
		}
		else
		{
			return $FreeToPlay;
		}
	}

/***********************************************************************/
/****************             CURRENT-GAME              ****************/
/***********************************************************************/
	/**
	 * get current game's info method
	 *
	 * @param string $platform_id
	 * @param string $summoner_id
	 * @return string : curl_exec()
	 */
	function getCurrentGame($summoner_id, $platform_id = "EUW1")
	{
		$this->url = "https:/observer-mode/rest/consumer/getSpectatorGameInfo/". $platform_id ."/". $summoner_id ."?api_key=".API_KEY;
		$Resultat = $this->CurlRequest();

		return $Resultat;
	}

/***********************************************************************/
/****************               	GAME                ****************/
/***********************************************************************/
	/**
	 * Method called getGame by LoLAPI
	 *
	 * @param string $summoner_id
	  * @return string : curl_exec()
	 */
	function getHistoric($summoner_id)
	{
		$this->url = "https://euw.api.pvp.net/api/lol/euw/v1.3/game/by-summoner/". $summoner_id ."/recent?api_key=".API_KEY;
		$Resultat = $this->CurlRequest();
		$Resultat = json_decode($Resultat, true);

		$Sorting = new All($Resultat, $summoner_id);
		$Historique = $Sorting->Sorting(); 

		// Pour rajouter l'id de l'invocateur demandeur
		/*foreach($Historique as $TabHist => $value)
		{
			if(count($value["Team_Bleu"]) == 2 || count($value["Team_Bleu"]) == 4)
			{
				array_push($value["Team_Bleu"], $summoner_id);

			}
			else
			{
				array_push($value["Team_Rouge"], $summoner_id);
			}
		}
		unset($TabHist);*/

		return $Historique;
	}

/***********************************************************************/
/****************                LEAGUE                 ****************/
/***********************************************************************/
	/**
	 * get league's info method
	 *
	 * @param string $summoner_id
	 * @return string : curl_exec()rn void
	 */
	function getLeague($summoner_id)
	{
		$this->url = "https://euw.api.pvp.net/api/lol/euw/v2.5/league/by-summoner/". $summoner_id ."?api_key=".API_KEY;
		$Resultat = $this->CurlRequest(); $Resultat = json_decode($Resultat, true);

		return $Resultat;
	}

	/**
	* Get The whole Challenger's id for a specific region 
	*
	* @param string = SOLO or TEAM
	* @param int = 5 or 3
	*/
	function getChallenger($typeMatch, $nbTeammates)
	{
		// STRING Verif
		if(!is_string($typeMatch))
		{
			return false;
		}
		$typeMatch = strtoupper($typeMatch);

		// Valeurs valides
		if($typeMatch !== 'SOLO' && $typeMatch !== 'TEAM')
		{
			return false;
		}

		// INT Verif
		if(!is_int($nbTeammates))
		{
			return false;
		}

		if($nbTeammates !== 5 && $nbTeammates !== 3)
		{
			return false;
		}

		$this->url = 'https://euw.api.pvp.net/api/lol/euw/v2.5/league/challenger?type=RANKED_'. $typeMatch .'_'. (string)$nbTeammates .'x'. (string)$nbTeammates .'&api_key='. API_KEY;
		$Resultat = $this->CurlRequest(); $Resultat = json_decode($Resultat, true);

		/* Reference : http://stackoverflow.com/questions/2699086/sort-multi-dimensional-array-by-value
		//http://php.net/manual/fr/function.usort.php
		//var_dump($Resultat['entries']);
		usort($Resultat['entries'], function($a, $b) 
				{
					return ($a['leaguePoints'] > $b['leaguePoints'])? -1 : 1;
				});
		*/

		$this->array_sort_by_column($Resultat['entries'], 'leaguePoints', SORT_DESC);

		// On conserve les 5 premiers enregistrements
		$temp = array_slice($Resultat['entries'], 0, 5);

		// Array to return -- Sauvegarde du top 5
		$topFive = array();
		$topFive['queue'] = '<h3><strong>Challenger</strong> : '. strtolower($Resultat['queue']) .'</h3>';
		$topFive['entries'] = array();
		$topFive['entries'] = $temp;

		return $topFive;
	}

	/**
	* Get The whole Challenger's id for a specific region 
	*
	* @param string = SOLO or TEAM
	* @param int = 5 or 3
	*/
	function getMaster($typeMatch, $nbTeammates)
	{
		// STRING Verif
		if(!is_string($typeMatch))
		{
			return false;
		}
		$typeMatch = strtoupper($typeMatch);

		// Valeurs valides
		if($typeMatch !== 'SOLO' && $typeMatch !== 'TEAM')
		{
			return false;
		}

		// INT Verif
		if(!is_int($nbTeammates))
		{
			return false;
		}

		if($nbTeammates !== 5 && $nbTeammates !== 3)
		{
			return false;
		}

		$this->url = 'https://euw.api.pvp.net/api/lol/euw/v2.5/league/master?type=RANKED_'. $typeMatch .'_'. (string)$nbTeammates .'x'. (string)$nbTeammates .'&api_key='. API_KEY;
		$Resultat = $this->CurlRequest(); $Resultat = json_decode($Resultat, true);

		/* Reference : http://stackoverflow.com/questions/2699086/sort-multi-dimensional-array-by-value
		//http://php.net/manual/fr/function.usort.php
		//var_dump($Resultat['entries']);
		usort($Resultat['entries'], function($a, $b) 
				{
					return ($a['leaguePoints'] > $b['leaguePoints'])? -1 : 1;
				});
		*/

		$this->array_sort_by_column($Resultat['entries'], 'leaguePoints', SORT_DESC);

		// On conserve les 5 premiers enregistrements
		$temp = array_slice($Resultat['entries'], 0, 5);

		// Array to return -- Sauvegarde du top 5
		$topFive = array();
		$topFive['queue'] =  '<h3><strong>Master</strong> : '. strtolower($Resultat['queue']) .'</h3>';
		$topFive['entries'] = array();
		$topFive['entries'] = $temp;

		return $topFive;
	}

	/**
	* Special Method to sort array by column
	*
	*	@author Guillaume BONHOMMEAU
	*	@param $arr string array --> Passage par référence
	*	@param $col string --> Colonne utilisé comme référence de trie
	*	@param $dir constant --> Constante prédéfini utilisé comme type de tri
	*/
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) 
	{
		$sort_col = array();
		foreach ($arr as $key=> $row) 
		{
		    $sort_col[$key] = $row[$col];
		}

		array_multisort($sort_col, $dir, $arr);
	}

/***********************************************************************/
/****************           LOL-STATIC-DATA             ****************/
/***********************************************************************/
	function getChampBasic()
	{
		$this->url = "https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?api_key=".API_KEY;
		$Resultat = $this->CurlRequest();

		return $Resultat;
	}

	function getChampNameByID($id)
	{
		$this->url = "https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion/". $id ."?api_key=".API_KEY;
		$Resultat = $this->CurlRequest(); $Resultat = json_decode($Resultat, true);

		return $Resultat['key'];
	}

	function getProfilIcon($id_icon)
	{
		$Chemin =  "include/images/Profil/";
		if( file_exists($Chemin."Icon_". $id_icon .".png") )
		{
			return $Chemin . 'Icon_'. $id_icon .'.png'; // Renvoi chemin image
		}
		else
		{
			//return "Icon Profil Num : ". $id_icon ." unfound.";
			return false;
		}
	}

	function getItemById($idItem)
	{
		$this->url = 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/item/'. $idItem .'?locale=fr_FR&api_key='. API_KEY;
		$Resultat = $this->CurlRequest(); $Resultat = json_decode($Resultat, true);

		return $Resultat;
	}

	function getSummonerSpellById($idSumSpell)
	{
		$this->url = 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/summoner-spell/'. $idSumSpell .'?api_key='. API_KEY;
		$Resultat = $this->CurlRequest(); $Resultat = json_decode($Resultat, true);

		return $Resultat;
	}

/***********************************************************************/
/****************              LOL-STATUS               ****************/
/***********************************************************************/
	function GetServiceStatus($region = "")
	{
		$this->url = (!empty($region)) ? "http://status.leagueoflegends.com/shards/". $region : "http://status.leagueoflegends.com/shards/euw";
		$Resultat = $this->CurlRequest(); $Resultat = json_decode($Resultat, true);

		foreach($Resultat['services'] as $services)
		{
			if( $services['name'] == "Client" && $services['status'] == "online")
			{
				return true;
			}
		}

		return false;
	}


/***********************************************************************/
/****************                STATS                  ****************/
/***********************************************************************/
	/**
	 * get ranked stats's info method
	 *
	 * @param string $summoner_id_id
	  * @return string : curl_exec()
	 */
	function getStatsRanked($summoner_id)
	{
		$this->url = "https://euw.api.pvp.net/api/lol/euw/v1.3/stats/by-summoner/". $summoner_id ."/ranked?api_key=".API_KEY;
		$Resultat = $this->CurlRequest();

		return $Resultat;
	}

/***********************************************************************/
/****************                SUMMONER               ****************/
/***********************************************************************/
	/**
	 * get summoner's info method
	*
	 * @param string $summoner_name
	 * @return string : id of a summoner
	 */
	function getSummonerByName($summoner_name)
	{
		$this->url = "https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/". rawurlencode($summoner_name) ."?api_key=".API_KEY;
		$request = $this->CurlRequest(); 

		$request = json_decode($request, true);

		$summoner_name = mb_strtolower($summoner_name, 'UTF-8');
		$summoner_name = str_replace(' ', '', $summoner_name);
		//echo $summoner_name;

		return $request[$summoner_name];
	}

	/**
	 * get summoner's info method thanks to his id
	*
	 * @param string $summoner_name
	 * @return string : id of a summoner
	 */
	function getSummonerByID($id)
	{
		$this->url = "https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/". $id ."?api_key=".API_KEY;
		$request = $this->CurlRequest(); $request = json_decode($request, true);

		return $request[$id];
	}

	function getMasteriesById($id)
	{
		$this->url = 'https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/'. $id .'/masteries?api_key='. API_KEY;
		$request = $this->CurlRequest(); $request = json_decode($request, true);

		return $request;		
	}

	function getRunesById($id)
	{
		$this->url = 'https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/'. $id .'/runes?api_key='. API_KEY;
		$request = $this->CurlRequest(); $request = json_decode($request, true);

		return $request;		
	}
}

?>