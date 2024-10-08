<?php
// Inclusion du fichier de connexion à la base de données
require_once 'co_database.php';

// Requête pour supprimer les abonnés non confirmés après une semaine
$query = "DELETE FROM subscribers WHERE confirmed = 0 AND created_at < NOW() - INTERVAL 7 DAY";
mysqli_query($conn, $query);

// Fermeture de la connexion
mysqli_close($conn);

echo "Suppression des abonnés non confirmés effectuée avec succès.";
?>
