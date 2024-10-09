<?php
session_start();
require_once('database.php');

require_once('logconnection.php');

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
    // Détruire la session
    logoutUser($_SESSION["user_id"]);
    session_unset();
    session_destroy();

    // Si l'utilisateur n'est pas connecté, redirection vers la page d'accueil
    header('Location: ../view/index.php');
    exit;
} else {
    // Redirection vers la page de connexion
    header('Location: connexion.php');
    exit;
}