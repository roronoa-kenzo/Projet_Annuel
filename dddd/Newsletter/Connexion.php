<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Abyss";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour obtenir les posts les plus populaires
$sql = "SELECT title, link, votes FROM post ORDER BY likes DESC LIMIT 5";
$result = $conn->query($sql);

$posts = array();

if ($result->num_rows > 0) {
    // Boucle pour récupérer les posts dans un tableau
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
} else {
    echo "0 post found";
}

$conn->close();
?>
