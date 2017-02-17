<?php

/**
*	@author Guillaume BONHOMMEAU
*	@version 1.1 -- 05/04/2016
*	@param referer : string -> $_SERVER['PHP_SELF'] || Exemple : /PERSO_Run&Throw/index.php 
*/
function mainMenu($referer)
{
	$explode = explode('/', $referer); // Sépare toutes les parties en fonction du délimiteur
	if(count($explode) > 0)
	{
	    $activePage = array_pop($explode); // Récupère et retourne le dernier élément
	}

	$arrayMenu = array(
			'Accueil' => 'index.php',
			'Invocateur' => array(
                'Recherche' => 'summonerSearch.php',
                'Profil'=> 'summonerProfil.php',
                'Historique' => 'summonerHistorique.php',
                'Classé' => 'summonerRanked.php',
                ),
			);

	echo '
		<!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top mainMenu">
            <div class="container">
                <!-- Regroupement pour meilleur affichage version mobile -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Run&Throw</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">';
    
    foreach($arrayMenu as $page => $value)
    {
    	// Si l'élément un autre dropdown
        if(is_array($value))
        {
            echo '<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">'. $page .'
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">';

            foreach($value as $subMenu => $subMenuValue)
            {
                echo '<li><a href="'. $subMenuValue .'">'. $subMenu .'</a></li>';
            }

            echo '
                    </ul>
                </li>';
        }
        // Si c'est un élément simple
        else
        {
            // S'il s'agit de la page où se trouve l'utilisateur
            if($value === $activePage)
            {
                echo'<li class="active">';
            }
            else
            {
                echo '<li>';
            }
            echo '<a href="'. $value .'">'. $page .'</a>
            </li>';
        }
    }                    
                    
    echo '
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Communauté</a></li>
                        <li><a href="#">Profil</a></li>';

                        if(empty($_SESSION['login']))
                        {
                            echo '<li><a href="inscription.php"><span class="glyphicon glyphicon-user"></span> Inscription</a></li>
                                <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Connexion</a></li>';
                        }
                        else
                        {
                            echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>';
                        }
    echo '
                    </ul>
                </div> <!-- Fin nav-collapse -->
            </div>
        </nav>';
} // END MAIN MENU

/**
*   @author Guillaume BONHOMMEAU
*   @param $referer string -> active page
*   @return none -> echo directly html semantique
*/
function summonerMenu($referer)
{
    $explode = explode('/', $referer); // Sépare toutes les parties en fonction du délimiteur
    if(count($explode) > 0)
    {
        $activePage = array_pop($explode); // Récupère et retourne le dernier élément
    }

    $arrayMenu = array(
        'Profil' => 'summonerProfil.php',
        'Historique' => 'summonerHistorique.php',
        'Classé' => 'summonerRanked.php',
        );

    echo '<ul class="nav nav-tabs nav-justified summonerMenu">';

    foreach($arrayMenu as $page => $value)
    {
        if($value === $activePage)
        {
            echo'<li class="active">
                <a href="'. $value .'"><h4>'. $page .'</h4></a>
            </li>';
        }
        else
        {
            echo '<li>
                <a href="'. $value .'"><h4>'. $page .'</h4></a>
            </li>';
        }
    } 

    echo '</ul>';
} // END SOUS MENU SECTION SUMMONER

function footer()
{
    echo '
        <div class="container" style="width: 99.5%;">
            <div class="col-md-12">
                <footer>
                    <div class="col-md-12 col-lg-12">       
                        <p><a href="#" style="margin: 40%;">Copyright &copy; 2015 - Run&Throw.com</a></p>                   
                    </div>
                </footer>
            </div>
        </div>
    ';
}

?>