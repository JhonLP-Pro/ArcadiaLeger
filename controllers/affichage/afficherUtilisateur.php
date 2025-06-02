<?php


require_once(__DIR__ . '/../../config.php');
require_once(BASE_PATH . '/bdd/Database.php');
require_once(BASE_PATH . '/models/utilisateur.php');
$utilisateur = new utilisateur($bdd);


$allUsers = $utilisateur->allUtilisateur();
?>