<div class="white-content-secondary">
    <?php include './composant/database.php'; ?>
    <?php include './composant/sessionStart.php'; ?>

    <h3>Parametre</h3>

    <!-- Supposons que $user est un tableau contenant les données de l'utilisateur actuel -->
    <!-- Bouton pour supprimer l'utilisateur en fonction de son ID -->
    <form method="post" action="./composant/OptionUser.php">
    <ul>
        <button type="submit" name="delete" value="delete">Remove user</button>
    </ul>
    <ul>
        <button type="submit" name="admin" value="admin"><?= $user['is_admin'] ? 'Non Admin' : 'Admin' ?></button>
    </ul>
    <ul>
        <button type="submit" name="banni" value="banni"><?= $user['is_banned'] ? 'Débanne' : 'Ban' ?></button>
    </ul>
    <ul>
        <button type="submit" name="message" value="message">Message User</button>
    </ul>
    </form>
</div>
