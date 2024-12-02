<?php
require_once './../serveur/database.php';
// Supposons que $forum_id est l'ID du forum sélectionné, passé par GET ou POST.
$forum_id = $_GET['forum_id'] ?? null;
if ($forum_id) {
    $query = $pdo->prepare("SELECT background FROM forums WHERE id = :forum_id");
    $query->execute(['forum_id' => $forum_id]);
    $forumBackground = $query->fetchColumn();

    if ($forumBackground) {
        echo '<link rel="stylesheet" href="' . htmlspecialchars($forumBackground) . '">';
    } else {
        echo '<link rel="stylesheet" href="css/themes/defaul.css">'; // Fallback si pas de background trouvé
    }
}
?>
?>