<?php



require_once(__DIR__ . '/../../config.php');
require_once(BASE_PATH . '/bdd/Database.php');
require_once(BASE_PATH . '/models/reservation.php');

// Débogage - Vérifier la connexion
if (!isset($bdd)) {
    die('Erreur : La connexion à la base de données n\'est pas établie');
}

// Débogage - Vérifier la session
if (!isset($_SESSION['utilisateur']) || !isset($_SESSION['utilisateur']['id'])) {
    die('Erreur : Session utilisateur non trouvée');
}

$reservation = new reservation($bdd);

// Récupération des réservations avec les informations des salles
$sallereserver = $reservation->getReservationsByUtilisateur($_SESSION['utilisateur']['id']);

// Débogage - Vérifier les résultats
if ($sallereserver === false) {
    die('Erreur lors de la récupération des réservations');
}

// Débogage - Afficher le nombre de réservations trouvées
echo '<!-- Nombre de réservations trouvées : ' . count($sallereserver) . ' -->';

// Pour la page assignationGM, on ne récupère que les réservations sans gamemaster
if (isset($page) && $page === 'assignationGM') {
    $allreservations = $reservation->getReservationsSansGamemaster();
} else {
    $allreservations = $reservation->getAllReservations();
}

$reservationsAssignees = $reservation->reservationbyGM($_SESSION['utilisateur']['id']);

// Récupération de toutes les réservations d'hôtel
$allreservationsHotel = $reservation->getAllReservationsHotel();

// Récupération des réservations d'hôtel de l'utilisateur connecté
$reservationsHotelUser = $reservation->getReservationsHotelByUser($_SESSION['utilisateur']['id']);

?>