<?php
include('controllers/affichage/afficherEscapegame.php');

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['type_utilisateur'] != 3) {
    header('Location: index.php?page=accueil');
    exit();
}
?>

<div class="container-fluid py-5">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="display-4 mb-1">Gestion des Salles</h1>
                    <p class="text-muted">Gérez vos salles d'escape game et leurs horaires</p>
                </div>
                <div class="badge bg-primary p-3">
                    <i class="fas fa-door-open fa-2x"></i>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-primary text-white shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-2">Total Salles</h6>
                                    <h2 class="mb-0"><?= count($allsalles) ?></h2>
                                </div>
                                <div class="bg-white bg-opacity-25 p-3 rounded">
                                    <i class="fas fa-door-closed fa-2x text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-success text-white shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-2">Capacité Totale</h6>
                                    <h2 class="mb-0"><?= array_sum(array_column($allsalles, 'nb_joueurs_max')) ?> joueurs</h2>
                                </div>
                                <div class="bg-white bg-opacity-25 p-3 rounded">
                                    <i class="fas fa-users fa-2x text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-info text-white shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-2">Durée Moyenne</h6>
                                    <h2 class="mb-0"><?= round(array_sum(array_column($allsalles, 'duree')) / count($allsalles)) ?> min</h2>
                                </div>
                                <div class="bg-white bg-opacity-25 p-3 rounded">
                                    <i class="fas fa-clock fa-2x text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets principaux -->
    <ul class="nav nav-tabs nav-fill gap-2 mb-4" id="mainTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="salles-tab" data-bs-toggle="tab" data-bs-target="#salles" type="button" role="tab" aria-controls="salles" aria-selected="true">
                <i class="fas fa-door-closed fa-2x me-2"></i>Gestion des Salles
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="horaires-tab" data-bs-toggle="tab" data-bs-target="#horaires" type="button" role="tab" aria-controls="horaires" aria-selected="false">
                <i class="fas fa-clock fa-2x me-2"></i>Gestion des Horaires
            </button>
        </li>
    </ul>

    <!-- Contenu des onglets principaux -->
    <div class="tab-content" id="mainTabsContent">
        <!-- Onglet Gestion des Salles -->
        <div class="tab-pane fade show active" id="salles" role="tabpanel">
            <!-- Sous-onglets pour les salles -->
            <ul class="nav nav-tabs nav-fill gap-2 mb-4" id="sallesTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="liste-salles-tab" data-bs-toggle="tab" data-bs-target="#liste-salles" type="button" role="tab" aria-controls="liste-salles" aria-selected="true">
                        <i class="fas fa-list me-2"></i>Liste des Salles
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ajouter-salle-tab" data-bs-toggle="tab" data-bs-target="#ajouter-salle" type="button" role="tab" aria-controls="ajouter-salle" aria-selected="false">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter une Salle
                    </button>
                </li>
                <!-- Onglet Modifier une salle temporairement désactivé
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="modifier-salle-tab" data-bs-toggle="tab" data-bs-target="#modifier-salle" type="button" role="tab" aria-controls="modifier-salle" aria-selected="false">
                        <i class="fas fa-edit me-2"></i>Modifier une Salle
                    </button>
                </li>
                -->
            </ul>

            <!-- Contenu des sous-onglets salles -->
            <div class="tab-content" id="sallesTabsContent">
                <!-- Liste des salles -->
                <div class="tab-pane fade show active" id="liste-salles" role="tabpanel" aria-labelledby="liste-salles-tab">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 ps-4">Salle</th>
                                            <th class="border-0">Description</th>
                                            <th class="border-0 text-center">Durée</th>
                                            <th class="border-0 text-center">Capacité</th>
                                            <th class="border-0 text-center">Prix</th>
                                            <th class="border-0 text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($allsalles as $salle): ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light rounded-circle p-2 me-3">
                                                            <i class="fas fa-door-closed text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0"><?= htmlspecialchars($salle['nom']) ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-0" style="max-width: 300px;">
                                                        <?= htmlspecialchars(substr($salle['description'], 0, 100)) ?>...
                                                    </p>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info rounded-pill px-3 py-2">
                                                        <i class="fas fa-clock me-1"></i><?= $salle['duree'] ?> min
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <div class="badge bg-success rounded-pill px-3 py-2 mb-1">
                                                            <i class="fas fa-users me-1"></i><?= $salle['nb_joueurs_min'] ?> - <?= $salle['nb_joueurs_max'] ?> joueurs
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary rounded-pill px-3 py-2">
                                                        <i class="fas fa-euro-sign me-1"></i><?= $salle['prix'] ?>
                                                    </span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-outline-primary btn-sm" 
                                                                onclick="activateModifyTab(<?= $salle['id'] ?>)">
                                                            <i class="fas fa-edit me-2"></i>Modifier
                                                        </button>
                                                        <form method="post" action="/controllers/sallesController.php" class="d-inline ms-2">
                                                             <input type="hidden" name="action" value="supprimer">
                                                            <input type="hidden" name="id" value="<?= $salle['id'] ?>">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')">
                                                                <i class="fas fa-trash me-2"></i>Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ajouter une salle -->
                <div class="tab-pane fade" id="ajouter-salle" role="tabpanel" aria-labelledby="ajouter-salle-tab">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-plus-circle text-primary me-2"></i>Ajouter une nouvelle salle
                                </h5>
                            </div>
                            <form method="post" action="/controllers/sallesController.php" enctype="multipart/form-data" class="row g-4">
                                <input type="hidden" name="action" value="ajouter">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nom" class="form-label fw-bold mb-2">
                                                <i class="fas fa-signature text-primary me-2"></i>Nom de la salle
                                            </label>
                                            <input type="text" class="form-control form-control-lg bg-light border-0 text-dark" 
                                                   id="nom" name="nom" required placeholder="Ex: La Crypte Mystérieuse">
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bold mb-2">
                                                <i class="fas fa-align-left text-primary me-2"></i>Description
                                            </label>
                                            <textarea class="form-control bg-light border-0 text-dark" id="description" 
                                                      name="description" rows="4" required 
                                                      placeholder="Décrivez l'ambiance et l'histoire de la salle..."></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label fw-bold mb-2">
                                                <i class="fas fa-image text-primary me-2"></i>Image de la salle
                                            </label>
                                            <input type="file" class="form-control bg-light border-0 text-dark" 
                                                   id="image" name="image" accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <label for="theme" class="form-label fw-bold mb-2">
                                                <i class="fas fa-theater-masks text-primary me-2"></i>Thème
                                            </label>
                                            <select class="form-select bg-light border-0 text-dark" id="theme" name="theme_id" required>
                                                <option value="">Sélectionnez un thème</option>
                                                <?php foreach ($allThemes as $theme): ?>
                                                    <option value="<?= $theme['id'] ?>"><?= htmlspecialchars($theme['nom']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="duree" class="form-label fw-bold mb-2">
                                                <i class="fas fa-clock text-primary me-2"></i>Durée de la partie
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control bg-light border-0 text-dark" 
                                                       id="duree" name="duree" required placeholder="60">
                                                <span class="input-group-text bg-light border-0 text-dark">minutes</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold mb-2">
                                                <i class="fas fa-users text-primary me-2"></i>Capacité de la salle
                                            </label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-0 text-dark">Min</span>
                                                        <input type="number" class="form-control bg-light border-0 text-dark" 
                                                               id="nb_joueurs_min" name="nb_joueurs_min" required placeholder="2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-0 text-dark">Max</span>
                                                        <input type="number" class="form-control bg-light border-0 text-dark" 
                                                               id="nb_joueurs_max" name="nb_joueurs_max" required placeholder="6">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prix" class="form-label fw-bold mb-2">
                                                <i class="fas fa-euro-sign text-primary me-2"></i>Prix de la partie
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control bg-light border-0 text-dark" 
                                                       id="prix" name="prix" required placeholder="120">
                                                <span class="input-group-text bg-light border-0 text-dark">€</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="fas fa-plus-circle me-2"></i>Créer la salle
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modifier une salle - temporairement désactivé
                    <div class="tab-pane fade" id="modifier-salle" role="tabpanel" aria-labelledby="modifier-salle-tab">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-edit text-primary me-2"></i>Modifier une salle existante
                                    </h5>
                                </div>
                                <form method="post" action="/controllers/SallesController.php" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="update">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <label for="salle_id" class="form-label fw-bold mb-2">
                                                <i class="fas fa-door-closed text-primary me-2"></i>Sélectionner la salle à modifier
                                            </label>
                                            <select class="form-select form-select-lg bg-light border-0 text-dark" id="salle_id" name="id" required>
                                                <option value="">Sélectionner une salle</option>
                                                <?php foreach ($allsalles as $salle): ?>
                                                    <option value="<?= $salle['id'] ?>"><?= htmlspecialchars($salle['nom']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nom" class="form-label fw-bold mb-2">
                                                    <i class="fas fa-signature text-primary me-2"></i>Nom de la salle
                                                </label>
                                                <input type="text" class="form-control form-control-lg bg-light border-0 text-dark" 
                                                       id="nom" name="nom" required placeholder="Ex: La Crypte Mystérieuse">
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label fw-bold mb-2">
                                                    <i class="fas fa-align-left text-primary me-2"></i>Description
                                                </label>
                                                <textarea class="form-control bg-light border-0 text-dark" id="description" 
                                                      name="description" rows="4" required 
                                                      placeholder="Décrivez l'ambiance et l'histoire de la salle..."></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label fw-bold mb-2">
                                                    <i class="fas fa-image text-primary me-2"></i>Image de la salle
                                                </label>
                                                <input type="file" class="form-control bg-light border-0 text-dark" 
                                                       id="image" name="image" accept="image/*">
                                            </div>
                                            <div class="mb-3">
                                                <label for="theme_edit" class="form-label fw-bold mb-2">
                                                    <i class="fas fa-theater-masks text-primary me-2"></i>Thème
                                                </label>
                                                <select class="form-select bg-light border-0 text-dark" id="theme_edit" name="theme_id" required>
                                                    <option value="">Sélectionnez un thème</option>
                                                    <?php foreach ($allThemes as $theme): ?>
                                                        <option value="<?= $theme['id'] ?>">
                                                            <?= htmlspecialchars($theme['nom']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="duree" class="form-label fw-bold mb-2">
                                                    <i class="fas fa-clock text-primary me-2"></i>Durée de la partie
                                                </label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control bg-light border-0 text-dark" 
                                                           id="duree" name="duree" required placeholder="60">
                                                    <span class="input-group-text bg-light border-0 text-dark">minutes</span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold mb-2">
                                                    <i class="fas fa-users text-primary me-2"></i>Capacité de la salle
                                                </label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light border-0 text-dark">Min</span>
                                                            <input type="number" class="form-control bg-light border-0 text-dark" 
                                                                   id="nb_joueurs_min" name="nb_joueurs_min" required placeholder="2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-light border-0 text-dark">Max</span>
                                                            <input type="number" class="form-control bg-light border-0 text-dark" 
                                                                   id="nb_joueurs_max" name="nb_joueurs_max" required placeholder="6">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="prix" class="form-label fw-bold mb-2">
                                                    <i class="fas fa-euro-sign text-primary me-2"></i>Prix de la partie
                                                </label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control bg-light border-0 text-dark" 
                                                           id="prix" name="prix" required placeholder="120">
                                                    <span class="input-group-text bg-light border-0 text-dark">€</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>

        <!-- Onglet Gestion des Horaires -->
        <div class="tab-pane fade" id="horaires" role="tabpanel">
            <!-- Sous-onglets pour les horaires -->
            <ul class="nav nav-tabs mb-3" id="horairesTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="ponctuel-tab" data-bs-toggle="tab" data-bs-target="#ponctuel" type="button" role="tab" aria-controls="ponctuel" aria-selected="true">
                        Horaire Ponctuel
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="recurrent-tab" data-bs-toggle="tab" data-bs-target="#recurrent" type="button" role="tab" aria-controls="recurrent" aria-selected="false">
                        Horaire Récurrent
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="hebdomadaire-tab" data-bs-toggle="tab" data-bs-target="#hebdomadaire" type="button" role="tab" aria-controls="hebdomadaire" aria-selected="false">
                        Horaires Hebdomadaires
                    </button>
                </li>
            </ul>

            <!-- Contenu des sous-onglets horaires -->
            <div class="tab-content" id="horairesTabsContent">
                <!-- Horaire Ponctuel -->
                <div class="tab-pane fade show active" id="ponctuel" role="tabpanel">
                    <form method="post" action="/controllers/sallesController.php">
                        <input type="hidden" name="action" value="ajouterHoraire">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="salle_id" class="form-label">Sélectionner la salle</label>
                                    <select class="form-select" id="salle_id" name="salle_id" required>
                                        <option value="">Sélectionner une salle</option>
                                        <?php foreach ($allsalles as $salle): ?>
                                            <option value="<?= $salle['id'] ?>"><?= htmlspecialchars($salle['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="heure_debut" class="form-label">Heure de début</label>
                                    <input type="time" class="form-control" id="heure_debut" name="heure_debut" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="heure_fin" class="form-label">Heure de fin</label>
                                    <input type="time" class="form-control" id="heure_fin" name="heure_fin" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Ajouter l'horaire</button>
                    </form>
                </div>

                <!-- Horaire Récurrent -->
                <div class="tab-pane fade" id="recurrent" role="tabpanel">
                    <form method="post" action="/controllers/sallesController.php">
                        <input type="hidden" name="action" value="ajouterHoraireRecurent">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="salle_id_rec" class="form-label">Sélectionner la salle</label>
                                    <select class="form-select" id="salle_id_rec" name="salle_id" required>
                                        <option value="">Sélectionner une salle</option>
                                        <?php foreach ($allsalles as $salle): ?>
                                            <option value="<?= $salle['id'] ?>"><?= htmlspecialchars($salle['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="jour" class="form-label">Jour du mois</label>
                                    <select class="form-select" id="jour" name="jour" required>
                                        <?php for($i = 1; $i <= 31; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="mois" class="form-label">Mois</label>
                                    <select class="form-select" id="mois" name="mois" required>
                                        <?php
                                        $mois = [
                                            1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                                            4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                                            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                                            10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                                        ];
                                        foreach($mois as $num => $nom): ?>
                                            <option value="<?= $num ?>"><?= $nom ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="heure_debut_rec" class="form-label">Heure de début</label>
                                    <input type="time" class="form-control" id="heure_debut_rec" name="heure_debut" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="heure_fin_rec" class="form-label">Heure de fin</label>
                                    <input type="time" class="form-control" id="heure_fin_rec" name="heure_fin" required>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Cet horaire sera créé pour les 4 prochains mois, le même jour de chaque mois.
                        </div>

                        <button type="submit" class="btn btn-primary">Ajouter l'horaire récurrent</button>
                    </form>
                </div>

                <!-- Horaires Hebdomadaires -->
                <div class="tab-pane fade" id="hebdomadaire" role="tabpanel">
                    <form method="post" action="/controllers/sallesController.php">
                        <input type="hidden" name="action" value="ajouterHorairesHebdomadaires">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="salle_id_hebdo" class="form-label">Sélectionner la salle</label>
                                    <select class="form-select" id="salle_id_hebdo" name="salle_id" required>
                                        <option value="">Sélectionner une salle</option>
                                        <?php foreach ($allsalles as $salle): ?>
                                            <option value="<?= $salle['id'] ?>"><?= htmlspecialchars($salle['nom']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date_debut" class="form-label">Date de début de la semaine</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="heure_debut_hebdo" class="form-label">Heure de début</label>
                                    <input type="time" class="form-control" id="heure_debut_hebdo" name="heure_debut" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="heure_fin_hebdo" class="form-label">Heure de fin</label>
                                    <input type="time" class="form-control" id="heure_fin_hebdo" name="heure_fin" required>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Des horaires seront créés automatiquement pour les 7 jours suivant la date de début, à la même heure chaque jour.
                        </div>

                        <button type="submit" class="btn btn-primary">Ajouter les horaires hebdomadaires</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des onglets Bootstrap
    var allTabs = [].slice.call(document.querySelectorAll('[data-bs-toggle="tab"]'));
    allTabs.forEach(function(tab) {
        var tabTrigger = new bootstrap.Tab(tab);
        
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });

    // Fonction pour activer l'onglet de modification
    window.activateModifyTab = function(salleId) {
        console.log("Activation de l'onglet de modification pour la salle ID: " + salleId);
        
        try {
            // Activer l'onglet de modification directement avec Bootstrap 5
            var modifierTab = document.querySelector('#modifier-salle-tab');
            if (modifierTab) {
                // Forcer l'affichage de l'onglet de modification
                document.querySelector('#liste-salles').classList.remove('show', 'active');
                document.querySelector('#ajouter-salle').classList.remove('show', 'active');
                document.querySelector('#modifier-salle').classList.add('show', 'active');
                
                // Mettre à jour l'état des boutons d'onglets
                document.querySelector('#liste-salles-tab').classList.remove('active');
                document.querySelector('#liste-salles-tab').setAttribute('aria-selected', 'false');
                document.querySelector('#ajouter-salle-tab').classList.remove('active');
                document.querySelector('#ajouter-salle-tab').setAttribute('aria-selected', 'false');
                modifierTab.classList.add('active');
                modifierTab.setAttribute('aria-selected', 'true');
                
                console.log("Onglet activé manuellement");
                
                // Pré-remplir l'ID de la salle
                var select = document.getElementById('salle_id');
                if (select) {
                    console.log("Select trouvé, définition de la valeur: " + salleId);
                    select.value = salleId;
                    
                    // Récupérer les données de la salle sélectionnée
                    <?php
                    echo "var salles = {";
                    foreach ($allsalles as $s) {
                        echo $s['id'] . ': {"nom": "' . addslashes($s['nom']) . '", "description": "' . addslashes($s['description']) . '", "duree": ' . $s['duree'] . ', "nb_joueurs_min": ' . $s['nb_joueurs_min'] . ', "nb_joueurs_max": ' . $s['nb_joueurs_max'] . ', "prix": ' . $s['prix'] . ', "theme_id": ' . $s['theme_id'] . '},'; 
                    }
                    echo "};";
                    ?>
                    
                    // Pré-remplir les champs du formulaire avec les données de la salle
                    if (salles[salleId]) {
                        console.log("Pré-remplissage des champs avec les données de la salle: " + salleId);
                        document.getElementById('nom').value = salles[salleId].nom;
                        document.getElementById('description').value = salles[salleId].description;
                        document.getElementById('duree').value = salles[salleId].duree;
                        document.getElementById('nb_joueurs_min').value = salles[salleId].nb_joueurs_min;
                        document.getElementById('nb_joueurs_max').value = salles[salleId].nb_joueurs_max;
                        document.getElementById('prix').value = salles[salleId].prix;
                        document.getElementById('theme_edit').value = salles[salleId].theme_id;
                    }
                } else {
                    console.error("Élément select 'salle_id' non trouvé");
                }
            } else {
                console.error("Élément onglet 'modifier-salle-tab' non trouvé");
            }
        } catch (error) {
            console.error("Erreur lors de l'activation de l'onglet:", error);
        }
    }
});
</script>
</body>
</html>
