<?php

/**
* @author Guillaume BONHOMMEAU
* @package lolthrow
* @version 1.0 -- 10/10/2015
* @license http://opensource.org/licenses/gpl-license.php GNU General Public License v3 or later
*/

require_once 'classLolQuery.php';

/**
*	@author Guillaume BONHOMMEAU
*	@version 1.1 -- 14/04/2016
*	@param Profil : Array contenant plusieurs types d'informations : player[], runes[], masteries[]
*	@return string semantique presentation
*/
function Profil($Profil)
{
	$return = '
		<div class="container">
			<div class="col-md-12">
				<div class="col-xs-6 col-xs-offset-3">
					<div class="profil-zone player">
					<img src="include/images/Profil/Icon_'. $Profil['player']['profileIconId'] .'.png" alt="Icon_'. $Profil['player']['profileIconId'] .'">
					<p>'. $Profil['player']['name'] .'</p>
					<p>Level '. $Profil['player']['summonerLevel'] .'</p>';

					$date = date("d-m-Y", $Profil['player']['revisionDate']/1000);
					$return .= '<div>Dernière activité : Il y a '. round((strtotime($date) - strtotime('now'))/-86400) .' jours</div>
					</div>
				</div>

				<div class="col-xs-6">
					<div class="profil-zone runes">
						<h2>GENERAL</h2><h3>Runes</h3>
						  	<form role="form" method="POST">
							    <div class="form-group col-xs-8 col-xs-offset-1">
							      	<label for="sel1">Sélectionnez une page de runes :</label>
							      	<select class="form-control" id="runesSelect" name="runesSelect">';
									// Récupère le premier élément, qui est ici, un tableau contenant les runes
									// Sans le '@' --> Erreur : Only variables should be passed by reference 
									$runesFirstKey = @array_shift(@array_values($Profil['runes']));
									// Pour toutes les pages de runes
									$i=1; // Iterateur
									foreach($runesFirstKey['pages'] as $runes => $runeValue)
									{
										$return .= '<option value="'. $runeValue['id'] .'"> '. $runeValue['name'] .'</option>';
										$i++;
									}
				$return .= '     	</select>
							    </div>
							</form> <br />
							<button type="submit" id="button_runes" name="AffichageProfil" value="Runes" class="btn btn-primary" 
									onclick="displayElements(\'runesSelect\', \''. json_encode($runesFirstKey['pages']).'\');">Afficher</button>
					</div>
				</div>

				<div class="col-xs-6">
					<div class="profil-zone masteries">
						<h2>GENERAL</h2><h3>Masteries</h3>
						  	<form role="form" method="POST">
							    <div class="form-group col-xs-8 col-xs-offset-1">
							      	<label for="sel1">Sélectionnez une page de masteries :</label>
							      	<select class="form-control" id="masteriesSelect" name="masteriesSelect">';
									// Récupère le premier élément, qui est ici, un tableau contenant les masteries
									// Sans le '@' --> Erreur : Only variables should be passed by reference 
									$masteriesFirstKey = @array_shift(@array_values($Profil['masteries']));
									// Pour toutes les pages de masteries
									$i=1; // Iterateur
									foreach($masteriesFirstKey['pages'] as $masteries => $masteriesValue)
									{
										$return .= '<option value="'. $masteriesValue['id'] .'">'. $masteriesValue['name'] .'</option>';
										$i++;			
									}
					$return .= '	</select>
								</div>
							</form> <br />
							<button type="submit" id="button_masteries" name="AffichageProfil" value="Masteries" class="btn btn-primary" 
								onclick="displayElements(\'masteriesSelect\', \''. json_encode($masteriesFirstKey['pages']).'\');">Afficher</button>
						</div>
				</div>

				<div class="col-xs-8 col-xs-offset-2">
					<div id="displayElement" class="profil-zone display-element" style="display: none;">
						damn
					</div>
				</div>
			</div>
		</div>';

	return $return;	
}

function getRunes($pageRunes, $idRune)
{
	var_dump(json_encode($pageRunes));
	$pageRunes = json_decode($pageRunes, true);
	foreach($pageRunes as $rune => $value)
	{
		if($value['id'] === $idRune)
		{
			return $value;
		}
	}
	return false;
}

function getMasteries($pageMasteries, $idMasterie)
{
	var_dump(json_encode($pageMasteries));
	$pageMasteries = json_decode($pageMasteries, true);
	foreach($pageMasteries as $masterie => $value)
	{
		if($value['id'] === $idMasterie)
		{
			return json_encode($value);
		}
	}
	return false;
}

?>