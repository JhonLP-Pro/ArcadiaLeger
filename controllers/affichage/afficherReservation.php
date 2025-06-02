<?php



require_once(__DIR__ . '/../../config.php');
require_once(BASE_PATH . '/bdd/Database.php');
require_once(BASE_PATH . '/models/reservation.php');
$reservation = new reservation($bdd);

// Récupération des réservations avec les informations des salles
$sallereserver = $reservation->getReservationsByUtilisateur($_SESSION['utilisateur']['id']);

// Pour la page assignationGM, on ne récupère que les réservations sans gamemaster
if (isset($page) && $page === 'assignationGM') {
    $allreservations = $reservation->getReservationsSansGamemaster();
} else {
    $allreservations = $reservation->getAllReservations();
}

$reservationsAssignees = $reservation->reservationbyGM($_SESSION['utilisateur']['id']);





?>