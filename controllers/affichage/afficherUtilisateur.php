<?php


require_once(__DIR__ . '/../../config.php');
require_once(BASE_PATH . '/bdd/Database.php');
require_once(BASE_PATH . '/models/Utilisateur.php');
$utilisateur = new Utilisateur($bdd);


$allUsers = $utilisateur->allUtilisateur();
?>