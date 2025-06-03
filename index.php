<?php

session_start();

require_once(__DIR__ . '/config.php');

// Handle POST requests for controllers
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controllerName = '';
    
    // Déterminer le contrôleur à partir de l'action ou d'un paramètre explicite
    if (isset($_POST['controller'])) {
        $controllerName = ucfirst(strtolower($_POST['controller'])) . 'Controller';
    } else {
        // Par défaut, utiliser SallesController pour les actions liées aux salles
        if (in_array($_POST['action'], ['ajouter', 'update', 'supprimer', 'ajouterHoraire', 'ajouterHoraireRecurent', 'ajouterHorairesHebdomadaires', 'supprimerHoraire', 'getsallebyprixrange', 'getsallebyplayerrange'])) {
            $controllerName = 'SallesController';
        }
        // Ajouter d'autres contrôleurs au besoin
    }
    
    if (!empty($controllerName)) {
        $controllerFile = BASE_PATH . '/controllers/' . $controllerName . '.php';
        
        if (file_exists($controllerFile)) {
            require_once(BASE_PATH . '/bdd/Database.php'); // Ensure $bdd is available
            require_once($controllerFile);
            exit(); // Stop further script execution after controller has handled the action
        } else {
            // Optionally, handle controller not found error
            error_log('Controller not found: ' . $controllerFile);
        }
    }
}

require_once(BASE_PATH . '/views/commun/header.php');


//system de routing

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
	case 'connectioninscription':
		include('views/CI_compte.php');
		break;
	
	case 'deconnexion':
		include('views/commun/logout.php');
		break;
	
	case 'reservation':
		include('views/reservation/reservation.php');
		break;

	case 'horairesSalle':
		include('views/reservation/horairesSalle.php');
		break;

	case 'reservationHoraire':
		include('views/reservation/reservationHoraire.php');
		break;
	
	case 'faq':
		include('views/faq.php');
		break;
	
	case 'contact':
		include('views/contact.php');
		break;
	//Compte utilisateur
	case 'compte':
		include('views/compte.php');
		break;
	
	case 'modifierProfil':
		include('views/modifierCompte.php');
		break;

	case 'mesreservations':
		include('views/mesreservations.php');
		break;	
	//Compte admin

	case 'gestionSalles':
		include('views/admin/gestionSalles.php');
		break;

	case 'gestionGamemasters':
		include('views/admin/gestionGamemaster.php');
		break;

	case 'gestionReservations':
		include('views/admin/gestionReservations.php');
		break;

	//Compte gm

	case 'assignationGM':
		include('views/gameMaster/assignationGM.php');
		break;
	
		case 'salle-details':
		include('views/reservation/salle-details.php');
		break;


	default:
		include('views/accueil.php');
		break;
}


include('views/commun/footer.php');


?>