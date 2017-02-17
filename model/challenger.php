<?php

require_once 'classLolQuery.php';

/**
*	@author Guillaume BONHOMMEAU
*	@version 1.1 -- 06/04/2016
*	@param $Challenger -> best of 5
*	@param $league string -> Division recherché (challenger / master)
*	@return string -> HTML structure to display challenger
*/
function Ranked($Challenger, $league = 'Challenger')
{
	$iterator = 0;
	$return = '<div class="col-md-4 planTop5">
					<div class="container"><h3>'. str_replace('_', ' ', $Challenger['queue']).'</h3>';
	foreach($Challenger['entries'] as $chall)
	{
		$return .= '<div class="col-md-12 challenger-plan">
						<div class="col-md-2 challenger-pic">
							<img src="include/images/'. strtolower($league) .'.png" alt="challenger_logo"/>
						</div>
						<div class="col-md-10">
							<div class="col-md-12 challenger-name">
								<span>'. $chall['playerOrTeamName'] .'</span>
							</div>';

		$purcentWin = round(($chall['wins']/($chall['wins']+$chall['losses']))*100, 2);
		$return .= '		<div class="col-md-12" style="padding-right: 0px;">
								<div class="progress">
								  	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'. $purcentWin .'"
								  			aria-valuemin="0" aria-valuemax="100" title="Pourcentage de victoire : '. $purcentWin .'%" 
								  				style="width:'. $purcentWin .'%">
								   		'. $chall['wins'] .' - Win
								  </div>
								</div>
							</div>';

		if($iterator === 0)
		{
			$bestLp = $chall['leaguePoints'];
		}
		$purcentLP = round(($chall['leaguePoints']/$bestLp)*100, 2);
		$return .= '		<div class="col-md-12" style="padding-right: 0px;">
								<div class="progress">
									<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'. $purcentLP .'"
										  	aria-valuemin="0" aria-valuemax="100" title="Pourcentage de League Points par rapport au 1er : '. $purcentLP .'%" 
										  		style="width:'. $purcentLP .'%">
										   		'. $chall['leaguePoints'] .' - LP
									</div>
								</div>
							</div>
						</div>
					</div>';
		$iterator++;
	}
	$return .= '</div></div>';
	
	return $return;
}

?>