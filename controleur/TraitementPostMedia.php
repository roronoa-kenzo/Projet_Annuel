<?php
session_start();
require_once './../serveur/database.php'; // Connexion à la base de données
require_once './../composants/expSysteme/xpSystem.php'; // Inclure le fichier pour gérer les XP

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ./../view/login.php');
    exit();
}

// Vérifiez que l'ID du forum est présent dans la session
if (!isset($_SESSION['forum_id'])) {
    $_SESSION['ErrorForum'] = 'Aucun forum sélectionné pour créer un post.';
    header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
    exit();
}

// Récupération de l'ID du forum depuis la session
$forum_id = $_SESSION['forum_id'];

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']); // Récupère le titre du formulaire
    $description = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];
    $imagePath = null;

    // Vérifiez si un fichier a été envoyé
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
        $fileName = $_FILES['fileToUpload']['name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $fileType = $_FILES['fileToUpload']['type'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['png', 'mp4'];
        $maxFileSize = 5000000; // Taille maximale : 5 Mo

        // Validation : vérifier le type et la taille du fichier
        if (!in_array($fileExtension, $allowedExtensions)) {
            $_SESSION['ErrorFile'] = 'Seuls les fichiers PNG ou MP4 sont autorisés.';
            header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
            exit();
        }

        if ($fileSize > $maxFileSize) {
            $_SESSION['ErrorFile'] = 'Le fichier est trop volumineux. La taille maximale autorisée est de 5 Mo.';
            header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
            exit();
        }

        // Déplacement du fichier dans le dossier upload
        $uploadFolder = './../public/upload/';
        $newFileName = uniqid('upload_', true) . '.' . $fileExtension;
        $destination = $uploadFolder . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $imagePath = $destination; // Chemin du fichier sauvegardé
        } else {
            $_SESSION['ErrorFile'] = "Erreur lors de l'enregistrement du fichier.";
            header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
            exit();
        }
    } else {
        $_SESSION['ErrorFile'] = "Aucun fichier n'a été téléchargé.";
        header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
        exit();
    }

    // Insertion du post dans la base de données
    try {
        $query = $pdo->prepare('
            INSERT INTO posts (title, content, image, user_id, forum_id, created_at)
            VALUES (:title, :content, :image, :user_id, :forum_id, NOW())
        ');

        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':content', $description, PDO::PARAM_STR);
        $query->bindParam(':image', $imagePath, PDO::PARAM_STR);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);

        if ($query->execute()) {
            // Ajouter de l'XP à l'utilisateur
            $xpReward = 15; // XP attribuée pour un post avec média
            $updateResult = updateXP($user_id, $xpReward, $pdo);

            // Notifier la montée de niveau (si applicable)
            if ($updateResult['level'] > $_SESSION['current_level']) {
                $_SESSION['SuccessLevelUp'] = "Félicitations ! Vous êtes passé au niveau " . $updateResult['level'] . " !";
                $_SESSION['current_level'] = $updateResult['level'];
            }

            $_SESSION['SuccessPost'] = 'Votre post avec média a été créé avec succès.';
        } else {
            $_SESSION['ErrorPost'] = 'Une erreur est survenue lors de la création de votre post.';
        }
    } catch (PDOException $e) {
        $_SESSION['ErrorPost'] = 'Erreur lors de la connexion à la base de données : ' . $e->getMessage();
    }

    header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
    exit();
} else {
    header('Location:./../view/Abyss-Forum.php?forum_id='.$forum_id);
    exit();
}
