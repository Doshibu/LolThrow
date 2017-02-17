<?php

require_once 'model/classLolQuery.php';
require_once 'model/challenger.php';
//require_once 'model/classLolRecord.php';

	//$RecupSplash = AllSplash();
	//$RecupLoading = AllLoadingScreenArt();
	//$RecupSquare = AllSquare();
	//$Icon = AllProfilIcon(900, 1200);
	//$Item = AllItem(1000, 5000);


function checkFreeToPrint()
{
	$str='
			<div class="flexslider">
				<ul class="slides">';
	$Lol = new LolQuery();
	if( !empty($_SESSION['Free']) )
	{
		foreach($_SESSION['Free'] as $img)
		{	
			$str .= '<li><img src="'.$img.'" alt="'.$img.'"/></li>';
		}
	}
	else
	{
		//$str .= '<li><img src="include/images/lolBackground2.jpeg" /></li>';
		$_SESSION['Free'] = $Lol->GetChampFree(true);
		header('location: #');
	}
	$str.='		</ul>
			</div>';
	echo $str;
}

function checkChallengerToPrint()
{	
	$Lol = new LolQuery();

	// Check TOP 5 challenger EU || TEAM 5C5
	/*if( !empty($_SESSION['Challenger5c5']))
	{
		$_SESSION['Challenger5c5'] = $Lol->getChallenger('TEAM', 5);
		echo Challenger($_SESSION['Challenger5c5']);
	}
	else
	{
		$_SESSION['Challenger5c5'] = $Lol->getChallenger('TEAM', 5);
	}*/

	// Check TOP 5 challenger EU || TEAM 3C3
	if( !empty($_SESSION['Challenger3c3']))
	{
		$_SESSION['Challenger3c3'] = $Lol->getChallenger('TEAM', 3);
		echo Ranked($_SESSION['Challenger3c3']);
	}	
	else
	{
		$_SESSION['Challenger3c3'] = $Lol->getChallenger('TEAM', 3);
	}

	// Check TOP 5 challenger EU || SOLO
	if( !empty($_SESSION['ChallengerSOLO']))
	{
		$_SESSION['ChallengerSOLO'] = $Lol->getChallenger('SOLO', 5);
		echo Ranked($_SESSION['ChallengerSOLO']);
	}
	else
	{
		$_SESSION['ChallengerSOLO'] = $Lol->getChallenger('SOLO', 5);
	}

	//---------- MASTER ----------------//
	// Check TOP 5 challenger EU || SOLO
	/*if( !empty($_SESSION['Master3c3']))
	{
		$_SESSION['Master3c3'] = $Lol->getMaster('TEAM', 3);
		echo Ranked($_SESSION['Master3c3']);
	}
	else
	{
		$_SESSION['Master3c3'] = $Lol->getMaster('TEAM', 3);
	}*/

	// Check TOP 5 challenger EU || SOLO
	if( !empty($_SESSION['MasterSOLO']))
	{
		$_SESSION['MasterSOLO'] = $Lol->getMaster('SOLO', 5);
		echo Ranked($_SESSION['MasterSOLO'], 'Master');
	}
	else
	{
		$_SESSION['MasterSOLO'] = $Lol->getMaster('SOLO', 5);
	}
}

?>