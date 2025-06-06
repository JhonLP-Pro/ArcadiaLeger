<?php
require_once(__DIR__ . '/../config.php');
require_once(BASE_PATH . '/controllers/affichage/afficherReservation.php');
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Mes Réservations</h1>
                <a href="index.php?page=reservation" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Nouvelle réservation
                </a>
            </div>
            
            <!-- Onglets pour séparer les types de réservations -->
            <ul class="nav nav-tabs mb-4" id="reservationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="escape-tab" data-bs-toggle="tab" data-bs-target="#escape-content" 
                            type="button" role="tab" aria-controls="escape-content" aria-selected="true">
                        <i class="fas fa-door-closed me-2"></i>Escape Game
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="hotel-tab" data-bs-toggle="tab" data-bs-target="#hotel-content" 
                            type="button" role="tab" aria-controls="hotel-content" aria-selected="false">
                        <i class="fas fa-bed me-2"></i>Hôtel
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="reservationTabsContent">
                <!-- Onglet Escape Game -->
                <div class="tab-pane fade show active" id="escape-content" role="tabpanel" aria-labelledby="escape-tab">
                    <?php if (empty($sallereserver)): ?>
                        <div class="text-center py-5" style="background: rgba(0,0,0,0.03); border-radius: 10px;">
                            <i class="fas fa-door-closed fa-4x mb-3 text-muted"></i>
                            <h3 class="text-muted">Aucune réservation d'escape game</h3>
                            <p class="text-muted mb-4">Vous n'avez pas encore de réservations d'escape game actives.</p>
                            <a href="index.php?page=reservation" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>Découvrir nos salles
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row g-4">
                    <?php foreach ($sallereserver as $reservation): 
                        $now = new DateTime();
                        $reservation_date = new DateTime($reservation['heure_debut']);
                        $is_future = $reservation_date > $now;
                        $status_class = $is_future ? 'border-primary' : 'border-secondary';
                        $status_bg = $is_future ? 'bg-primary' : 'bg-secondary';
                    ?>
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm border-2 <?= $status_class ?>" style="border-radius: 15px;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title mb-0"><?= htmlspecialchars($reservation['nom']) ?></h4>
                                    <span class="badge <?= $status_bg ?> rounded-pill">
                                        <?= $is_future ? 'À venir' : 'Passée' ?>
                                    </span>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar me-2 text-primary"></i>
                                        <span><?= date('d/m/Y', strtotime($reservation['heure_debut'])) ?></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock me-2 text-primary"></i>
                                        <span><?= date('H:i', strtotime($reservation['heure_debut'])) ?> - <?= date('H:i', strtotime($reservation['heure_fin'])) ?></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-users me-2 text-primary"></i>
                                        <span><?= htmlspecialchars($reservation['nb_participants']) ?> participants</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-euro-sign me-2 text-primary"></i>
                                        <span><?= htmlspecialchars($reservation['prix_total']) ?> €</span>
                                    </div>
                                </div>

                                <?php if ($is_future): ?>
                                    <button class="btn btn-outline-danger w-100" 
                                            onclick="if(confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) 
                                                    window.location.href='index.php?page=contact'">
                                        <i class="fas fa-times me-2"></i>Annuler la réservation
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Onglet Hôtel -->
                <div class="tab-pane fade" id="hotel-content" role="tabpanel" aria-labelledby="hotel-tab">
                    <?php if (empty($reservationsHotelUser)): ?>
                        <div class="text-center py-5" style="background: rgba(0,0,0,0.03); border-radius: 10px;">
                            <i class="fas fa-bed fa-4x mb-3 text-muted"></i>
                            <h3 class="text-muted">Aucune réservation d'hôtel</h3>
                            <p class="text-muted mb-4">Vous n'avez pas encore de réservations d'hôtel actives.</p>
                        </div>
                    <?php else: ?>
                        <div class="row g-4">
                            <?php foreach ($reservationsHotelUser as $reservationHotel): 
                                $now = new DateTime();
                                $reservation_date = new DateTime($reservationHotel['date']);
                                $is_future = $reservation_date > $now;
                                $status_class = $is_future ? 'border-success' : 'border-secondary';
                                $status_bg = $is_future ? 'bg-success' : 'bg-secondary';
                            ?>
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm border-2 <?= $status_class ?>" style="border-radius: 15px;">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title mb-0">Chambre <?= htmlspecialchars($reservationHotel['categorie']) ?></h4>
                                            <span class="badge <?= $status_bg ?> rounded-pill">
                                                <?= $is_future ? 'À venir' : 'Passée' ?>
                                            </span>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar me-2 text-success"></i>
                                                <span><?= date('d/m/Y', strtotime($reservationHotel['date'])) ?></span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-users me-2 text-success"></i>
                                                <span><?= htmlspecialchars($reservationHotel['nb_personnes']) ?> personnes</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-euro-sign me-2 text-success"></i>
                                                <span><?= htmlspecialchars($reservationHotel['prix']) ?> €</span>
                                            </div>
                                        </div>

                                        <?php if ($is_future): ?>
                                            <button class="btn btn-outline-danger w-100" 
                                                    onclick="if(confirm('Êtes-vous sûr de vouloir annuler cette réservation d\'hôtel ?')) 
                                                            window.location.href='index.php?page=contact'">
                                                <i class="fas fa-times me-2"></i>Annuler la réservation
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialisation des onglets Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    var tabTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tab"]'));
    var tabList = tabTriggerList.map(function(tabTriggerEl) {
        return new bootstrap.Tab(tabTriggerEl);
    });
});
</script>
