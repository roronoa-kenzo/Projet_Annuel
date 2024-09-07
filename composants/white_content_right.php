
<div class="white-content-secondary">
    <h3>Mes Forum</h3>
    <ul>
        <?php
        // Afficher les pseudos des utilisateurs
        foreach ($users as $user) {
            echo "<li>" . htmlspecialchars($user['pseudo']) . "</li>";
        }
        ?>
        <a href="Back-log.php">Admin</a>
        <a href="index.php">index</a>

    </ul>
</div>