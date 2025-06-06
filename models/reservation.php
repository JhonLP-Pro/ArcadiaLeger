<?php


class reservation {
private $bdd;
    function __construct($bdd)
	{
		$this->bdd = $bdd;
        
	}
    // Méthodes pour les réservations
    public function creerReservation($utilisateur_id, $salle_id, $horaire_id, $nb_participants, $prix_total) {
        $req = $this->bdd->prepare("INSERT INTO reservations (utilisateur_id, salle_id, horaire_id, nb_participants, prix_total) 
                                   VALUES (:utilisateur_id, :salle_id, :horaire_id, :nb_participants, :prix_total)");
        
        $req->bindParam(':utilisateur_id', $utilisateur_id);
        $req->bindParam(':salle_id', $salle_id);
        $req->bindParam(':horaire_id', $horaire_id);
        $req->bindParam(':nb_participants', $nb_participants);
        $req->bindParam(':prix_total', $prix_total);

        if ($req->execute()) {
            // Mettre à jour la disponibilité de l'horaire
            $this->updateHoraireDisponibilite($horaire_id, false);
            return $this->bdd->lastInsertId();
        }
        return false;
    }

    public function getReservationsByUtilisateur($utilisateur_id) {
        $req = $this->bdd->prepare("SELECT r.id, r.salle_id, r.horaire_id, r.utilisateur_id, r.nb_participants, r.prix_total, s.nom, h.heure_debut, h.heure_fin 
                                    FROM reservations r 
                                    JOIN salles s ON r.salle_id = s.id 
                                    JOIN horaires h ON r.horaire_id = h.id 
                                    WHERE r.utilisateur_id = ?
                                    ORDER BY h.heure_debut DESC");
        $req->execute([$utilisateur_id]);
        return $req->fetchAll();
    }


    //fonctionnalité annuler une reservation en plus
    public function annulerReservation($reservation_id) {
        // Récupérer l'horaire_id avant de supprimer la réservation
        $req = $this->bdd->prepare("SELECT horaire_id FROM reservations WHERE id = ?");
        $req->execute([$reservation_id]);
        $horaire_id = $req->fetch()['horaire_id'];

        // Supprimer la réservation
        $req = $this->bdd->prepare("DELETE FROM reservations WHERE id = ?");
        if ($req->execute([$reservation_id])) {
            // Remettre l'horaire comme disponible
            return $this->updateHoraireDisponibilite($horaire_id, true);
        }
        return false;
    }

    
    public function getAllReservations() {
        $req = $this->bdd->prepare("SELECT r.id, r.salle_id, r.horaire_id, r.utilisateur_id, r.nb_participants, r.prix_total, s.nom, h.heure_debut, h.heure_fin, u.nom as utilisateur_nom, u.prenom as utilisateur_prenom
                                    FROM reservations r 
                                    JOIN salles s ON r.salle_id = s.id 
                                    JOIN horaires h ON r.horaire_id = h.id 
                                    JOIN utilisateurs u ON r.utilisateur_id = u.id 
                                    WHERE h.heure_debut > NOW()
                                    ORDER BY h.heure_debut ASC");
        $req->execute();
        return $req->fetchAll();
    }

    public function getReservationsSansGamemaster() {
        $req = $this->bdd->prepare("SELECT r.id, r.salle_id, r.horaire_id, r.utilisateur_id, 
                                          r.nb_participants, r.prix_total, s.nom, 
                                          h.heure_debut, h.heure_fin,
                                          u.nom as utilisateur_nom, u.prenom as utilisateur_prenom
                                   FROM reservations r 
                                   JOIN salles s ON r.salle_id = s.id 
                                   JOIN horaires h ON r.horaire_id = h.id 
                                   JOIN utilisateurs u ON r.utilisateur_id = u.id
                                   LEFT JOIN gamemaster_assignments ga ON r.id = ga.reservation_id 
                                   WHERE ga.id IS NULL 
                                   AND h.heure_debut > NOW()
                                   ORDER BY h.heure_debut ASC");
        $req->execute();
        return $req->fetchAll();
    }


    private function updateHoraireDisponibilite($horaire_id, $disponible) {
        $req = $this->bdd->prepare("UPDATE horaires SET disponible = ? WHERE id = ?");
        return $req->execute([$disponible ? 1 : 0 , $horaire_id]);
    }

    public function reservationbyGM($gamemaster_id)
    {
        $req = $this->bdd->prepare("SELECT r.*, s.nom as salle_nom, h.heure_debut, h.heure_fin,
                                          u.nom as utilisateur_nom, u.prenom as utilisateur_prenom
                                   FROM reservations r
                                   JOIN gamemaster_assignments ga ON r.id = ga.reservation_id
                                   JOIN salles s ON r.salle_id = s.id
                                   JOIN horaires h ON r.horaire_id = h.id
                                   JOIN utilisateurs u ON r.utilisateur_id = u.id
                                   WHERE ga.gamemaster_id = :gamemaster_id
                                   ORDER BY h.heure_debut ASC");
        $req->bindParam(':gamemaster_id', $gamemaster_id);
        $req->execute();
        return $req->fetchAll();
    }   

    // Méthodes pour les réservations d'hôtel
    public function creerReservationHotel($utilisateur_id, $date, $prix, $nbpersonne, $categorie) {
        $req = $this->bdd->prepare("INSERT INTO reservationHotel (utilisateur_id, date, prix, nbpersonne, categorie) 
                                   VALUES (:utilisateur_id, :date, :prix, :nbpersonne, :categorie)");
        
        $req->bindParam(':utilisateur_id', $utilisateur_id);
        $req->bindParam(':date', $date);
        $req->bindParam(':prix', $prix);
        $req->bindParam(':nbpersonne', $nbpersonne);
        $req->bindParam(':categorie', $categorie);

        if ($req->execute()) {
            return $this->bdd->lastInsertId();
        }
        return false;
    }
    
    /**
     * Récupère toutes les réservations d'hôtel d'un utilisateur
     * 
     * @param int $utilisateur_id ID de l'utilisateur
     * @return array Liste des réservations d'hôtel
     */
    public function getReservationsHotelByUtilisateur($utilisateur_id) {
        $req = $this->bdd->prepare("SELECT rh.*, u.nom, u.prenom 
                                    FROM reservationHotel rh 
                                    JOIN utilisateurs u ON rh.utilisateur_id = u.id 
                                    WHERE rh.utilisateur_id = ?
                                    ORDER BY rh.date DESC");
        $req->execute([$utilisateur_id]);
        return $req->fetchAll();
    }
    
    /**
     * Récupère une réservation d'hôtel par son ID
     * 
     * @param int $reservation_id ID de la réservation
     * @return array|bool Données de la réservation ou false si non trouvée
     */
    public function getReservationHotelById($reservation_id) {
        $req = $this->bdd->prepare("SELECT rh.*, u.nom, u.prenom 
                                    FROM reservationHotel rh 
                                    JOIN utilisateurs u ON rh.utilisateur_id = u.id 
                                    WHERE rh.id = ?");
        $req->execute([$reservation_id]);
        return $req->fetch();
    }
    
    /**
     * Récupère toutes les réservations d'hôtel
     * 
     * @return array Liste de toutes les réservations d'hôtel
     */
    public function getAllReservationsHotel() {
        $req = $this->bdd->prepare("SELECT rh.*, u.nom, u.prenom 
                                    FROM reservationHotel rh 
                                    JOIN utilisateurs u ON rh.utilisateur_id = u.id 
                                    ORDER BY rh.date DESC");
        $req->execute();
        return $req->fetchAll();
    }
    
    /**
     * Met à jour une réservation d'hôtel existante
     * 
     * @param int $reservation_id ID de la réservation
     * @param string $date Nouvelle date
     * @param int $prix Nouveau prix
     * @param int $nbpersonne Nouveau nombre de personnes
     * @param string $categorie Nouvelle catégorie
     * @return bool Succès ou échec de la mise à jour
     */
    public function updateReservationHotel($reservation_id, $date, $prix, $nbpersonne, $categorie) {
        $req = $this->bdd->prepare("UPDATE reservationHotel 
                                   SET date = :date, prix = :prix, nbpersonne = :nbpersonne, categorie = :categorie 
                                   WHERE id = :id");
        
        $req->bindParam(':date', $date);
        $req->bindParam(':prix', $prix);
        $req->bindParam(':nbpersonne', $nbpersonne);
        $req->bindParam(':categorie', $categorie);
        $req->bindParam(':id', $reservation_id);
        
        return $req->execute();
    }
    
    /**
     * Annule (supprime) une réservation d'hôtel
     * 
     * @param int $reservation_id ID de la réservation à annuler
     * @return bool Succès ou échec de l'annulation
     */
    public function annulerReservationHotel($reservation_id) {
        $req = $this->bdd->prepare("DELETE FROM reservationHotel WHERE id = ?");
        return $req->execute([$reservation_id]);
    }

}

?>