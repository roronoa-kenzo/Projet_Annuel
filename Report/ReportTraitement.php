<?php
// Commence une session pour stocker des messages d'erreur ou des confirmations
include './../serveur/database.php';
session_start();

// Vérification des données envoyées par le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupérer les champs du formulaire
    $user_id = $_SESSION['user_id'];  // Récupérer l'ID utilisateur envoyé dans le formulaire
    $email = filter_var($_POST['userID'], FILTER_SANITIZE_EMAIL);
    $contentLink = htmlspecialchars($_POST['contentLink']);
    $reason = htmlspecialchars($_POST['reason']);
    $details = htmlspecialchars($_POST['additionalDetails']);

    $hasError = false;

    if (empty($user_id)) {
        $_SESSION['ErrorContentID'] = "Une connexion est requis.";
        $hasError = true;
    }
    // Valider le contenu ID ou URL
    if (empty($contentLink)) {
        $_SESSION['ErrorContentID'] = "L'URL ou l'ID du contenu est requis.";
        $hasError = true;
    }

    // Valider la raison du signalement
    if (empty($reason)) {
        $_SESSION['ErrorReason'] = "Veuillez sélectionner une raison pour ce signalement.";
        $hasError = true;
    }

    // Valider les détails
    if (empty($details)) {
        $_SESSION['ErrorDetails'] = "Veuillez fournir des détails supplémentaires.";
        $hasError = true;
    }

    // Si des erreurs existent, rediriger l'utilisateur vers la page du formulaire
    if ($hasError) {
        header("Location: reportContent.php");
        exit();
    }
    $status = 'Pending';
    // Si tout est valide, traiter le signalement (par exemple, en l'enregistrant en base de données)
    // Ici tu peux utiliser $user_id pour savoir qui a soumis le signalement
    // Exemple de requête d'insertion dans la base de données :
    try {
        // Requête d'insertion dans la table reports
        $sql = "INSERT INTO reports (user_id, reported_content_link, report_reason, additional_details, status) 
                VALUES (:user_id, :reported_content_link, :report_reason, :additional_details, :status)";

        // Préparer la requête
        $stmt = $pdo->prepare($sql); // Assurez-vous que `$db` est correctement défini dans `database.php`
        // Associer les valeurs aux paramètres de la requête
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':reported_content_link', $contentLink );
        $stmt->bindParam(':report_reason', $reason);
        $stmt->bindParam(':additional_details', $details );
        $stmt->bindParam(':status', $status);
    
        // Exécuter la requête
        $stmt->execute();
        } catch (Exception $e) {
            //page erreur
    }

    // Exemple de message de confirmation
    $_SESSION['SuccessMessage'] = "Votre signalement a bien été soumis. Merci pour votre vigilance.";
    header("Location: confirmationPage.php");  // Rediriger vers une page de confirmation
    exit();
} else {
    // Si quelqu'un essaie d'accéder directement à cette page sans soumettre de formulaire
    header("Location: reportContent.php");
    exit();
}
