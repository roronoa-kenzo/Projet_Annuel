<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Requête pour récupérer les 5 posts les plus populaires
$query = "SELECT * FROM posts ORDER BY likes DESC LIMIT 5";
$result = mysqli_query($conn, $query);

// Stockage des résultats dans un tableau
$posts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = $row;
}

// Fermeture de la connexion
mysqli_close($conn);
?>