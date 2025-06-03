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

// Créer un fichier de log
$log_file = BASE_PATH . '/debug_log.txt';
file_put_contents($log_file, "=== DÉBOGAGE (" . date('Y-m-d H:i:s') . ") ===\n", FILE_APPEND);

// Vérifier la connexion à la base de données
try {
    $test_query = $bdd->query("SELECT 1");
    file_put_contents($log_file, "Connexion à la base de données : SUCCÈS\n", FILE_APPEND);
} catch (PDOException $e) {
    file_put_contents($log_file, "Erreur de connexion à la base de données : " . $e->getMessage() . "\n", FILE_APPEND);
}

// Afficher les informations de la requête
file_put_contents($log_file, "Méthode : " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);

// Afficher les données POST
if (!empty($_POST)) {
    file_put_contents($log_file, "Données POST : " . print_r($_POST, true) . "\n", FILE_APPEND);
} else {
    file_put_contents($log_file, "Aucune donnée POST\n", FILE_APPEND);
}

// Afficher les données GET
if (!empty($_GET)) {
    file_put_contents($log_file, "Données GET : " . print_r($_GET, true) . "\n", FILE_APPEND);
} else {
    file_put_contents($log_file, "Aucune donnée GET\n", FILE_APPEND);
}

// Afficher les informations de session
if (!empty($_SESSION)) {
    file_put_contents($log_file, "Données SESSION : " . print_r($_SESSION, true) . "\n", FILE_APPEND);
} else {
    file_put_contents($log_file, "Aucune donnée SESSION\n", FILE_APPEND);
}

file_put_contents($log_file, "=== FIN DÉBOGAGE ===\n\n", FILE_APPEND);

// Afficher un message à l'écran
echo "<h1>Débogage</h1>";
echo "<p>Les informations de débogage ont été enregistrées dans le fichier debug_log.txt</p>";
echo "<p>Vérifiez ce fichier pour voir les détails.</p>";

// Afficher le contenu du fichier de log
echo "<h2>Contenu du fichier de log :</h2>";
echo "<pre>";
echo file_get_contents($log_file);
echo "</pre>";
?>
