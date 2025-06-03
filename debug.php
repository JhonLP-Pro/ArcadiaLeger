<?php
// Fichier de débogage pour tester le traitement des formulaires

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Inclure les fichiers nécessaires
require_once(__DIR__ . '/config.php');
require_once(BASE_PATH . '/bdd/Database.php');

// Utiliser la sortie standard au lieu d'un fichier de log
echo "<h1>Débogage</h1>";
echo "<pre>";
echo "=== DÉBOGAGE (" . date('Y-m-d H:i:s') . ") ===\n";


// Vérifier la connexion à la base de données
try {
    $test_query = $bdd->query("SELECT 1");
    echo "Connexion à la base de données : SUCCÈS\n";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage() . "\n";
}

// Afficher les informations de la requête
echo "Méthode : " . $_SERVER['REQUEST_METHOD'] . "\n";

// Afficher les données POST
if (!empty($_POST)) {
    echo "Données POST : " . print_r($_POST, true) . "\n";
} else {
    echo "Aucune donnée POST\n";
}

// Afficher les données GET
if (!empty($_GET)) {
    echo "Données GET : " . print_r($_GET, true) . "\n";
} else {
    echo "Aucune donnée GET\n";
}

// Afficher les informations de session
if (!empty($_SESSION)) {
    echo "Données SESSION : " . print_r($_SESSION, true) . "\n";
} else {
    echo "Aucune donnée SESSION\n";
}

echo "=== FIN DÉBOGAGE ===\n\n";
echo "</pre>";

// Ajouter un bouton pour retourner à la page de gestion des salles
echo "<p><a href='index.php?page=gestionSalles' class='btn btn-primary'>Retour à la gestion des salles</a></p>";
?>
