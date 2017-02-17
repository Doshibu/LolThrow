<?php

/**
* @author Guillaume BONHOMMEAU
* @package lolthrow
* @version 1.0 -- 10/10/2015
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v3 or later
*/

require_once 'classLolQuery.php';

abstract class LolSorting
{
	protected $LastSummonerId;
	protected $RecentGameDto; // Historique général
	protected $Game3C3 = array(); // Historique des games en mode 3c3
	protected $Game5C5 = array(); // Historique des games en mode 5c5
	protected $GameTest = array();

	protected static $SubTypesFormat = array(); // Constantes utilisées pour connaître le type
	protected static $GameTypesFormat = array(); // Game Personnalisée, Tutoriel, Autres
	protected static $GameModesFormat = array();
	protected static $MapNamesFormat = array(); // Nom et ID des différentes maps du jeu
	protected static $MatchmakingQueuesFormat = array();
	protected static $PlayerStatSummaryTypesFormat = array();
	protected static $RuneSlotIDFormat = array();

	
	function LolSorting($Object, $summoner_id)
	{
		$this->LastSummonerId = $summoner_id;
		$this->RecentGameDto = $Object;
	}

	function GetGame3c3()
	{
		return $this->Game3C3;
	}

	function GetGame5c5()
	{
		return $this->Game5c5;
	}

	function GetGameTest()
	{
		return $this->GameTest;
	}

	function Sorting()
	{
		$nbGame=0;
		$LolQuery = new LolQuery();
		foreach ($this->RecentGameDto['games'] as $games) 
		{			
			$nbPlayer=0;
			$this->GameTest[$nbGame]['Team_Bleu'] = array(); 
			$this->GameTest[$nbGame]['Team_Rouge'] = array();
			
			/*foreach($games['fellowPlayers'] as $players)
			{
				sleep(5);
				//$player = $LolQuery->getSummonerByID($players['summonerId']);
				$this->GameTest[$nbGame]['Team_Bleu'][$nbPlayer] = array(); 
				$this->GameTest[$nbGame]['Team_Rouge'][$nbPlayer] = array();

				// Résolution des membres par teams :: ID 100 = TEAM BLEU
				if($players['teamId'] === 100)
				{
					// Nom du joueur
					//$this->GameTest[$nbGame]['Team_Bleu'][$nbPlayer]['name'] = $player['name'];
					// Icone de profil du joueur
					//$this->GameTest[$nbGame]['Team_Bleu'][$nbPlayer]['icon'] = $player['profileIconId'];
					// Champion du joueur
					$this->GameTest[$nbGame]['Team_Bleu'][$nbPlayer]['champ'] = $LolQuery->getChampNameByID($players['championId']);
				}
				else
				{
					// Nom du joueur
					//$this->GameTest[$nbGame]['Team_Rouge'][$nbPlayer]['name'] = $player['name'];					
					// Icone de profil du joueur
					//$this->GameTest[$nbGame]['Team_Rouge'][$nbPlayer]['icon'] = $player['profileIconId'];
					// Champion du joueur
					$this->GameTest[$nbGame]['Team_Rouge'][$nbPlayer]['champ'] = $LolQuery->getChampNameByID($players['championId']);
				}
				$nbPlayer++;
			}

			if($games['teamId'] === 100)
			{
				$this->GameTest[$nbGame]['Team_Bleu'][$nbPlayer] = array();
				//$this->GameTest[$nbGame]['Team_Bleu'][$nbPlayer]['name'] = $player['name'];
				//$this->GameTest[$nbGame]['Team_Bleu'][$nbPlayer]['icon'] = $player['profileIconId'];
				$this->GameTest[$nbGame]['Team_Bleu'][$nbPlayer]['champ'] = $LolQuery->getChampNameByID($games['championId']); 
			}
			else
			{
				$this->GameTest[$nbGame]['Team_Rouge'][$nbPlayer] = array();
				//$this->GameTest[$nbGame]['Team_Rouge'][$nbPlayer]['name'] = $player['name'];
				//$this->GameTest[$nbGame]['Team_Rouge'][$nbPlayer]['icon'] = $player['profileIconId'];
				$this->GameTest[$nbGame]['Team_Rouge'][$nbPlayer]['champ'] = $LolQuery->getChampNameByID($games['championId']);
			}*/


			// Ajout de l'invocateur principal
			//$player = $LolQuery->getSummonerByID($this->LastSummonerId);
			//$this->GameTest[$nbGame]['icon'] = $player['profileIconId'];
			$this->GameTest[$nbGame]['champ'] = $LolQuery->getChampNameByID($games['championId']);
			$this->GameTest[$nbGame]['date'] = $games['createDate'];
			$this->GameTest[$nbGame]['type'] = $games['subType'];
			$this->GameTest[$nbGame]['level'] = $games['stats']['level'];

			// Spell -- Int ID Spell
			$this->GameTest[$nbGame]['spell1'] = $games['spell1'];
			$this->GameTest[$nbGame]['spell1-details'] = array();
			$this->GameTest[$nbGame]['spell1-details'] = $LolQuery->getSummonerSpellById($games['spell1']);

			$this->GameTest[$nbGame]['spell2'] = $games['spell2']; 
			$this->GameTest[$nbGame]['spell2-details'] = array();
			$this->GameTest[$nbGame]['spell2-details'] = $LolQuery->getSummonerSpellById($games['spell2']);

			// Indication WIN/LOOSE + Stats
			$this->GameTest[$nbGame]['time'] = $games['stats']['timePlayed'];
			$this->GameTest[$nbGame]['gold'] = $games['stats']['goldEarned']; 
			$this->GameTest[$nbGame]['minions'] = (isset($games['stats']['minionsKilled'])) ? $games['stats']['minionsKilled'] : 0;
			
			// KDA
			$this->GameTest[$nbGame]['kill'] = (isset($games['stats']['championsKilled'])) ? $games['stats']['championsKilled'] : 0;
			$this->GameTest[$nbGame]['death'] = (isset($games['stats']['numDeaths'])) ? $games['stats']['numDeaths'] : 0;
			$this->GameTest[$nbGame]['assist'] = (isset($games['stats']['assists'])) ? $games['stats']['assists'] : 0;
			
			// Degats
			$this->GameTest[$nbGame]['dealPhy'] = (isset($games['stats']['physicalDamageDealtToChampions'])) ? $games['stats']['physicalDamageDealtToChampions'] : 0;
			$this->GameTest[$nbGame]['dealMag'] = (isset($games['stats']['magicDamageDealtToChampions'])) ? $games['stats']['magicDamageDealtToChampions'] : 0;
			$this->GameTest[$nbGame]['dealTotal'] = (isset($games['stats']['totalDamageDealtToChampions'])) ? $games['stats']['totalDamageDealtToChampions'] : 0;
			$this->GameTest[$nbGame]['takenPhy'] = (isset($games['stats']['physicalDamageTaken'])) ? $games['stats']['physicalDamageTaken'] : 0;
			$this->GameTest[$nbGame]['takenMag'] = (isset($games['stats']['magicDamageTaken'])) ? $games['stats']['magicDamageTaken'] : 0;
			$this->GameTest[$nbGame]['takenTotal'] = (isset($games['stats']['totalDamageTaken'])) ? $games['stats']['totalDamageTaken'] : 0;

			// Role
			$this->GameTest[$nbGame]['position'] = (isset($games['stats']['playerPosition'])) ? $games['stats']['playerPosition'] : 0;
			$this->GameTest[$nbGame]['role'] = (isset($games['stats']['playerRole'])) ? $games['stats']['playerRole'] : 0;
			
			// Ward
			$this->GameTest[$nbGame]['visionBuy'] = (isset($games['stats']['visionWardsBought'])) ? $games['stats']['visionWardsBought'] : 0;
			$this->GameTest[$nbGame]['wardPlaced'] = (isset($games['stats']['wardPlaced'])) ? $games['stats']['wardPlaced'] : 0;
			$this->GameTest[$nbGame]['wardKill'] = (isset($games['stats']['wardKilled'])) ? $games['stats']['wardKilled'] : 0;

			// Objectif
			$this->GameTest[$nbGame]['tower'] = (isset($games['stats']['turretsKilled'])) ? $games['stats']['turretsKilled'] : 0;
			$this->GameTest[$nbGame]['killingSpree'] = (isset($games['stats']['largestKillingSpree'])) ? $games['stats']['largestKillingSpree'] : 1;

			if($games['stats']['win'] === TRUE)
			{
				$this->GameTest[$nbGame]['win'] = TRUE;
			}
			else
			{
				$this->GameTest[$nbGame]['win'] = FALSE;
			}

			// Itemisation / Build
			$this->GameTest[$nbGame]['stuff'] = array();
			for($i=0; $i<7; $i++)
			{
				if(isset($games['stats']['item'.$i]))
				{
					$this->GameTest[$nbGame]['stuff']['item'.$i] = $games['stats']['item'.$i];
					$this->GameTest[$nbGame]['stuff']['item'. $i .'-details'] = array();
					$this->GameTest[$nbGame]['stuff']['item'. $i .'-details'] = $LolQuery->getItemById($games['stats']['item'.$i]);					
				}
				else
				{
					$this->GameTest[$nbGame]['stuff']['item'.$i] = NULL;
				}	
			}

			if($nbGame == 9) break;
			$nbGame++;
		}
		unset($LolQuery, $games, $players, $TabHist);
		return $this->GameTest;
	}
}

class All extends LolSorting
{

}

class Ranked extends LolSorting
{

}

class Normal extends LolSorting
{

}

class Perso extends LolSorting
{

}

?>