
<div class="white-content-secondary">
    <h3>Liste des Utilisateurs</h3>
    <ul>
        <?php
        // Afficher les pseudos des utilisateurs
        foreach ($users as $user) {
            echo "<li>" . htmlspecialchars($user['pseudo']) . "</li>";
        }
        ?>
    </ul>
</div>
