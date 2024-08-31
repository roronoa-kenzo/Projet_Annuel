<?php
$servername = "localhost"; // Remplace par le nom de ton serveur
$username = "root"; // Ton nom d'utilisateur MariaDB
$password = "Vate200307"; // Ton mot de passe MariaDB
$dbname = "Abyss"; // Le nom de ta base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

echo "Connexion réussie à la base de données MariaDB!";

// Requête pour obtenir des données de la table Utilisateurs
$sql = "SELECT prenom, nom, FROM Utilisateurs";
$result = $conn->query($sql);

// Afficher les données dans un paragraphe HTML
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>Utilisateur : " . $row["prenom"] . " " . $row["nom"] . " (Pseudo : " . $row["pseudo"] . ")</p>";
    }
} else {
    echo "<p>Aucun utilisateur trouvé.</p>";
}
?>
