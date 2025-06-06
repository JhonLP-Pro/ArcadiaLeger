<?php

include('../bdd/Database.php');

include('../models/reservation.php');

if(isset($_POST['action'])) {
	
    $reservationController = new reservationsController($bdd);

    switch ($_POST['action']) {

        case 'ajouter':
        $reservationController->create();
            break;

        case 'annuler':
        $reservationController->annuler();
            break;

        case 'update':
		 $reservationController->update();
            break;
            
        // Actions pour les réservations d'hôtel
        case 'ajouterHotel':
        $reservationController->createHotel();
            break;
            
        case 'annulerHotel':
        $reservationController->annulerHotel();
            break;
            
        case 'updateHotel':
        $reservationController->updateHotel();
            break;

        default:
            # code...
            break;
    }
}

class reservationsController
{
    private $reservations;

    function __construct($bdd)
    {
        $this->reservations = new reservation($bdd);
    }

    public function create()
    {
        // Création de la réservation d'escape game
        $reservation_id = $this->reservations->creerReservation(
            $_POST['utilisateur_id'], 
            $_POST['salle_id'], 
            $_POST['horaire_id'], 
            $_POST['nb_participants'], 
            $_POST['prix_total']
        );
        
        // Vérifier si l'utilisateur a choisi l'offre package avec hôtel
        if (isset($_POST['avec_hotel']) && $_POST['avec_hotel'] == 1) {
            // Récupérer les données pour la réservation d'hôtel
            $date_escape = isset($_POST['date_escape']) ? $_POST['date_escape'] : date('Y-m-d', strtotime('+1 day')); // Date par défaut = lendemain
            $prix_hotel = isset($_POST['prix_hotel']) ? $_POST['prix_hotel'] : 80; // Prix par défaut
            $nb_personnes = isset($_POST['nb_participants']) ? $_POST['nb_participants'] : 2; // Même nombre que pour l'escape game
            $categorie = isset($_POST['categorie_hotel']) ? $_POST['categorie_hotel'] : 'Standard'; // Catégorie par défaut
            
            // Créer la réservation d'hôtel associée
            $hotel_id = $this->reservations->creerReservationHotel(
                $_POST['utilisateur_id'],
                $date_escape,
                $prix_hotel,
                $nb_personnes,
                $categorie
            );
            
            // Redirection avec message de succès pour le package
            header('Location: /index.php?page=mesReservation&success=PackageReservationAjouter');
        } else {
            // Redirection standard pour réservation simple
            header('Location: /index.php?page=mesReservation&success=ReservationAjouter');
        }
    }


    public function annuler()
    {
        $this->reservations->annulerReservation($_POST['id']);

        header('Location: /index.php?page=gestionReservations&success=ReservationAnnuler');
    }

    public function afficherSallesbyprix()
    {
        

    }

    // Méthodes pour les réservations d'hôtel
    
    /**
     * Crée une nouvelle réservation d'hôtel
     */
    public function createHotel()
    {
        $this->reservations->creerReservationHotel(
            $_POST['utilisateur_id'], 
            $_POST['date'], 
            $_POST['prix'], 
            $_POST['nbpersonne'], 
            $_POST['categorie']
        );
        
        header('Location: /index.php?page=gestionReservationsHotel&success=ReservationHotelAjouter');
    }
    
    /**
     * Annule une réservation d'hôtel
     */
    public function annulerHotel()
    {
        $this->reservations->annulerReservationHotel($_POST['id']);
        
        header('Location: /index.php?page=gestionReservationsHotel&success=ReservationHotelAnnuler');
    }
    
    /**
     * Met à jour une réservation d'hôtel
     */
    public function updateHotel()
    {
        $this->reservations->updateReservationHotel(
            $_POST['id'],
            $_POST['date'], 
            $_POST['prix'], 
            $_POST['nbpersonne'], 
            $_POST['categorie']
        );
        
        header('Location: /index.php?page=gestionReservationsHotel&success=ReservationHotelModifier');
    }
    
    /**
     * Récupère toutes les réservations d'hôtel pour l'affichage
     * 
     * @return array Liste des réservations d'hôtel
     */
    public function getAllReservationsHotel()
    {
        return $this->reservations->getAllReservationsHotel();
    }
    
    /**
     * Récupère les réservations d'hôtel d'un utilisateur spécifique
     * 
     * @param int $utilisateur_id ID de l'utilisateur
     * @return array Liste des réservations d'hôtel de l'utilisateur
     */
    public function getReservationsHotelByUser($utilisateur_id)
    {
        return $this->reservations->getReservationsHotelByUtilisateur($utilisateur_id);
    }
}

?>