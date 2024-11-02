<?php
// Commence une session pour stocker des messages d'erreur ou des confirmations
session_start();

// Vérification des données envoyées par le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupérer les champs du formulaire
    $user_id = $_POST['user_id'];  // Récupérer l'ID utilisateur envoyé dans le formulaire
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $content_id = htmlspecialchars($_POST['content_id']);
    $reason = htmlspecialchars($_POST['reason']);
    $details = htmlspecialchars($_POST['details']);

    $hasError = false;

    // Valider l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['ErrorEmail'] = "Veuillez entrer un email valide.";
        $hasError = true;
    }

    // Valider le contenu ID ou URL
    if (empty($content_id)) {
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

    // Si tout est valide, traiter le signalement (par exemple, en l'enregistrant en base de données)
    // Ici tu peux utiliser $user_id pour savoir qui a soumis le signalement
    // Exemple de requête d'insertion dans la base de données :

    // $sql = "INSERT INTO signalements (user_id, email, content_id, reason, details) VALUES (?, ?, ?, ?, ?)";
    // $stmt = $db->prepare($sql);
    // $stmt->execute([$user_id, $email, $content_id, $reason, $details]);

    // Exemple de message de confirmation
    $_SESSION['SuccessMessage'] = "Votre signalement a bien été soumis. Merci pour votre vigilance.";
    header("Location: confirmationPage.php");  // Rediriger vers une page de confirmation
    exit();
} else {
    // Si quelqu'un essaie d'accéder directement à cette page sans soumettre de formulaire
    header("Location: reportContent.php");
    exit();
}
