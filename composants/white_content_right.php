<?php 
if(!empty($_SESSION["email"]) && !empty($_SESSION["user_profile"]) && !empty($_SESSION["user_id"])){
    include './../serveur/database.php';
    $idUser = $_SESSION["user_id"];

        // Requête pour récupérer tous les forums auxquels l'utilisateur est abonné
        try {
            // Requête pour récupérer tous les forums auxquels l'utilisateur est abonné
            $query = "
                SELECT forums.id AS forum_id, forums.name AS forum_name
                FROM forum_subscribers
                INNER JOIN forums ON forum_subscribers.forum_id = forums.id
                WHERE forum_subscribers.user_id = :user_id
            ";
    
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user_id', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            $subscribedForums = $stmt->fetchAll();
    
        } catch (Exception $e) {
            echo 'Erreur lors de la récupération des abonnements : ' . $e->getMessage();
        }

?>
    <div class="white-content-secondary">
    <h3>Add Iceberg</h3>
    <button id="openModalButton" class="btn-menu">Créer un Forum</button>
        <h3>Your Iceberg</h3>
        <?php if (!empty($subscribedForums)) : ?>
            <?php foreach ($subscribedForums as $forum) : ?>
                <a class="btn-menu" href="./Abyss-Forum.php?forum_id=<?= $forum['forum_id']; ?>">
                    <?= htmlspecialchars($forum['forum_name']); ?>
                </a>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Vous n'êtes abonné à aucun forum.</p>
        <?php endif; ?>
    </div>
<?php
}else{

?>
<div class="white-content-secondary">
    
    <h3>Contact</h3>

</div>
<?php
}
?>