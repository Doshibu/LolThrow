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
*	@version 1.1 -- 24/03/2016
*	@param hist : Array contenant les informations des games recentes
*	@return string semantique presentation
*/
function Historique($hist)
{
	$i=0;

	$return = '<div id="histData">'; $nbGame = 1;
	foreach($_SESSION['Historique'] as $histo => $valHisto) 
	{
		$return .= '<div class="container">';
		$liste_admin = ($valHisto['win'] === TRUE) ? 
						'<div class="col-md-10 col-md-offset-1 box-game win" id="liste_admin">' 
						: '<div class="col-md-10 col-md-offset-1 box-game loose" id="liste_admin">';
		
	//---- Invocateurs  ----//
		$return .= $liste_admin;
		$return .= '<div class="col-md-4">
						<div id="cell11" class="col-md-6">
							<a href="#">
								<div class="champPic">
									<img src="include/images/Champions/Square/'. $valHisto['champ'] .'.jpg" alt="'. $valHisto['champ'] .'" />
									<div class="textbox">
										<p class="text">'. $valHisto['champ'] .'</p>
									</div>
								</div>
							</a>
							<p>'. str_replace('_', ' ', $valHisto['type']) .'</p>
						</div>
						<div id="cell12" class="col-md-6">
							<div class="game-result">';
						
						$return .= ($valHisto['win'] === TRUE) ?
							'<span style="color: rgb(94, 154, 1);">Partie Gagné</span>'
							: '<span style="color: rgb(204, 0, 0);">Partie Perdue</span>';

						$date = date("d-m-Y", $valHisto['date']/1000);
						$return .= '<div>Il y a '. round((strtotime($date) - strtotime('now'))/-86400) .' jours</div>';

						$return .= '
							</div>
							<div class="game-length">
								<span style="color: #e79d1d;">'. (int) ($valHisto['time']/60) .' min</span>
								<div>Durée de la partie</div>
							</div>
						</div>';
		$return .= '</div>'; // Fin Team Bleu

	//---- Statistiques  ----//
		$return .= '<div class="col-md-2" style="text-align: center;">';
		
		$totalKDA = $valHisto['kill'] + $valHisto['death'] + $valHisto['assist'];
		
		// On vérifie qu'on ne divise pas par 0
		$KDA = ($valHisto['death'] > 0) ? round(($valHisto['kill'] + $valHisto['assist'])/$valHisto['death'], 1)
										: round(($valHisto['kill'] + $valHisto['assist']), 1);
		
		$return .= '	<div class="col-md-7 kda">
							<div class="kills">
								<span>'.$valHisto['kill'].' Tués</span>
							</div>
							<div class="deaths">
								<span>'.$valHisto['death'].' Morts</span>
							</div>
							<div class="assists">
								<span>'.$valHisto['assist'].' Assists</span>
							</div>
							<div class="kda-label">
								<span>KDA</span> '. $KDA .'
							</div>
						</div>
						<div class="col-md-5 kda-bar">
							<div class="kda-score kills" style="height: '. round(($valHisto['kill']/$totalKDA)*100, 2) .'%;"
								title="Tués : '. round(($valHisto['kill']/$totalKDA)*100, 2) .'%"></div>
							<div class="kda-score deaths" style="height: '. round(($valHisto['death']/$totalKDA)*100, 2) .'%;"
								title="Morts : '. round(($valHisto['death']/$totalKDA)*100, 2) .'%"></div>
							<div class="kda-score assists" style="height: '. round(($valHisto['assist']/$totalKDA)*100, 2) .'%;"
								title="Assistances : '. round(($valHisto['assist']/$totalKDA)*100, 2) .'%"></div>
						</div>';
		$return .= '</div>';

		$return .= '<div class="col-md-2">
						<div class="gold">
							<span>'. $valHisto['gold'] .' Gold<br />
								'. (int)($valHisto['gold']/((int) ($valHisto['time']/60))) .' 
							</span>
							<div class="acronyme" title="Gold Per Minute">
								GPM
							</div>
						</div>		
						<div class="minions">
							<span>'. $valHisto['minions'] .' Minions<br />
								'. round(($valHisto['minions']/((int) ($valHisto['time']/60))), 1) .'
							</span>
							<div class="acronyme" title="Minions Per Minute">								 
								MPM
							</div>
						</div>
					</div>


		<div class="col-md-4">
			<div id="TabStuff">';
		// Tableau affichant les équipements du joueur
		for($i=0; $i<7; $i++)
		{
			// Ne pas afficher l'objet gratuit (trinket)
			if($i != 6)
			{
				if(!is_int($valHisto['stuff']['item'.$i]))
				{
					$return .= '<img src="include/images/Item/Item_0.png" alt="">';
				}
				else
				{
					$return .= '<img class="tooltip-item" src="include/images/Item/Item_'. $valHisto['stuff']['item'.$i] .'.png" 
						data-toggle="tooltip" data-placement="left" data-html="true" title="<name>'.$valHisto['stuff']['item'.$i.'-details']['name'] . '</name><br /><br />'. $valHisto['stuff']['item'.$i.'-details']['description'].'" alt="">';
				}
			}
		}

		// Tableau affichant les "sorts d'invocateurs" utilisés pour cette game et la dernière "trinket" choisie
		$return .= '<br />
					<img class="tooltip-item" src="include/images/SumSpell/spell'. $valHisto['spell1'] .'.png" alt=""
					data-toggle="tooltip" data-placement="left" data-html="true" 
						title="<name>'.$valHisto['spell1-details']['name'] . '</name><br /><br />
									'. $valHisto['spell1-details']['description'].'">

					<img class="tooltip-item" src="include/images/SumSpell/spell'. $valHisto['spell2'] .'.png" alt=""
						data-toggle="tooltip" data-placement="left" data-html="true" 
						title="<name>'.$valHisto['spell2-details']['name'] . '</name><br /><br />
									'. $valHisto['spell2-details']['description'].'">';

		$return .= (!is_null($valHisto['stuff']['item6'])) ? 
					'<img class="tooltip-item" src="include/images/Item/Item_'. $valHisto['stuff']['item6'] .'.png" alt=""
							data-toggle="tooltip" data-placement="left" data-html="true" 
							title="<name>'.$valHisto['stuff']['item6-details']['name'] . '</name><br /><br />
										'. $valHisto['stuff']['item6-details']['description'].'">' : '';
					
		$return .=	'<button type="button" id="button_'. $nbGame .'" class="btn btn-primary btn-displayStats" 
							onclick="displayStats(\'button_'. $nbGame .'\',\'more-stats_'. $nbGame .'\');" >Voir plus <span class="glyphicon glyphicon-circle-arrow-down"></span></button>'; // Fin Div Statistics

		$return .= '	</div>
					</div>

		<div id="more-stats_'. $nbGame .'" class="col-md-10 col-md-offset-1" style="display: none;">
			<div class="col-md-12 more-stats">
				<div class="col-md-6">
					<div class="col-md-5 team bleu">';
				/*		<h5>Equipe Bleu</h5>;

					foreach($valHisto['Team_Bleu'] as $Tbleu => $value)
					{
						if(!empty($value))
						{			
							$return .= '<div>
										<img src="include/images/Champions/Square/'. $value['champ'] .'.jpg" alt="'. $value['champ'] .'">
									</div>';
						}
					}

		$return .= '</div>
					<div class="col-md-2 vs">VS</div>
					<div class="col-md-5 team rouge">
						<h5>Equipe Rouge</h5>';

					foreach($valHisto['Team_Rouge'] as $Trouge => $value)
					{
						if(!empty($value))
						{
							$return .= '<div>
										<img src="include/images/Champions/Square/'. $value['champ'] .'.jpg" alt="'. $value['champ'] .'">
									</div>';
						}
					} */

		$return .= '</div>
				</div>
				<div class="col-md-6">
					<div class="other-stats">
						<h5>Plus de statistiques</h5>
						<div class="damage">
							<span>'. round($valHisto['dealTotal']/1000, 1) .'K Dégats Total Infligés Aux Champions</span>
						 	<div class="progress">
						  		<div class="progress-bar progress-bar-success" role="progressbar" style="width:'. ($valHisto['dealPhy']/$valHisto['dealTotal'])*100 .'%"
						  			title="Dégats physique infligés : '. round($valHisto['dealPhy']/1000, 1) .'K">
						  		</div>
						  		<div class="progress-bar" role="progressbar" style="width:'. ($valHisto['dealMag']/$valHisto['dealTotal'])*100 .'%"
						  			title="Dégats magique infligés : '. round($valHisto['dealMag']/1000, 1) .'K">
						  		</div>
						  		<div class="progress-bar progress-bar-warning" role="progressbar" style="width:
						  				'. (1 - (($valHisto['dealPhy']/$valHisto['dealTotal']) + ($valHisto['dealMag']/$valHisto['dealTotal'])))*100 .'%"
						  			title="Dégats brut infligés : '. round(($valHisto['dealTotal']-($valHisto['dealPhy'] + $valHisto['dealMag']))/1000, 1) .'K">
						  		</div>
							</div>
						</div>
						<div class="damage">
							<span>'. round($valHisto['takenTotal']/1000, 1) .'K Dégats Total Reçus</span>
						 	<div class="progress">
						  		<div class="progress-bar progress-bar-success" role="progressbar" style="width:'. ($valHisto['takenPhy']/$valHisto['takenTotal'])*100 .'%"
						  			title="Dégats physique reçus : '. round($valHisto['takenPhy']/1000, 1) .'K">
						  		</div>
						  		<div class="progress-bar" role="progressbar" style="width:'. ($valHisto['takenMag']/$valHisto['takenTotal'])*100 .'%"
						  			title="Dégats magique reçus : '. round($valHisto['takenMag']/1000, 1) .'K">
						  		</div>
						  		<div class="progress-bar progress-bar-warning" role="progressbar" style="width:
						  				'. (1 - (($valHisto['takenPhy']/$valHisto['takenTotal']) + ($valHisto['takenMag']/$valHisto['takenTotal'])))*100 .'%"
						  			title="Dégats brut reçus : '. round(($valHisto['takenTotal']-($valHisto['takenPhy'] + $valHisto['takenMag']))/1000, 1) .'K">
						  		</div>
							</div>
						</div>
						<div class="more-scores">
							<div class="col-md-4">
								<span class="label label-info">'. $valHisto['level'] .'</span>
								<div>Level</div>
							</div>							
							<div class="col-md-4">
								<span class="label label-info">'; 
									switch($valHisto['position'])
									{
										case 1 : $pos = 'TOP'; break;
										case 2 : $pos = 'MID'; break;
										case 3 : $pos = 'JUNGLE'; break;
										case 4 : $pos = 'BOT'; break;
										default : $pos = 'Non définis'; break;
									}
								$return .= $pos.'</span>
								<div>Position</div>
							</div>							
							<div class="col-md-4">
								<span class="label label-info">';
									switch($valHisto['role'])
									{
										case 1 : $role = 'DUO'; break;
										case 2 : $role = 'SUPPORT'; break;
										case 3 : $role = 'CARRY'; break;
										case 4 : $role = 'SOLO'; break;
										default : $role = 'Non définis'; break; 
									}
								$return .= $role.'</span>
								<div>Role</div>
							</div>
						</div>
						<div class="more-scores">
							<div class="col-md-6">
								<span class="label label-info">'. $valHisto['tower'] .'</span>
								<div>Tourelles détruites</div>
							</div>							
							<div class="col-md-6">
								<span class="label label-info">'. $valHisto['killingSpree'] .'</span>
								<div>Meilleurs Série d\'éliminations</div>
							</div>
						</div>
						<div class="more-scores">
							<div class="col-md-4">
								<span class="label label-info">'. $valHisto['visionBuy'] .'</span>
								<div>Pink achetées</div>
							</div>														
							<div class="col-md-4">
								<span class="label label-info">'. $valHisto['wardPlaced'] .'</span>
								<div>Balise posées</div>
							</div>							
							<div class="col-md-4">
								<span class="label label-info">'. $valHisto['wardKill'] .'</span>
								<div>Balise détruites</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';

		$return .= '</div></div><br />';

		/*if($nbGame < count($_SESSION['Historique']))
		{
			$return .= '<div class="col-md-12 line-separator"></div><br />';
		}*/

		$nbGame++;
	}				

	unset($histo, $tb, $tr);
	return $return.'</div>';
}
?>