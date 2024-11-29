<footer class="footer">
    <div class="footer-container">
        <!-- Logo ou Nom du site -->
        <div class="footer-logo">
        <a href="index.php"><img src="./../public/img/abyssicon.png" alt="Logo"></a>
        </div>
        
        <!-- Liens utiles -->
        <div class="footer-links">
            <ul>
                <li><a href="#">Mentions légales</a></li>
                <li><a href="#">Politique de confidentialité</a></li>
                <li><a href="#">Conditions d'utilisation</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="./Create_Tiket.php">Faire un tiket</a></li>
            </ul>
        </div>
        
        <!-- Réseaux sociaux -->
        <div class="footer-social">
            <a href="#"><img src="./../public/img/twitter-logo.png" alt="Twitter"></a>
            <a href="#"><img src="./../public/img/insta-logo.png" alt="Instagram"></a>
        </div>

        <!-- Newsletter -->
        <div class="footer-newsletter">
            <form action="#" method="post">
                <label for="email">Abonnez-vous à notre newsletter :</label>
                <input type="email" id="email" name="email" placeholder="Votre email">
                <button type="submit">S'abonner</button>
            </form>
        </div>
        <div class="footer-p">
        <p>&copy; <?php echo date("Y"); ?> ABYSS. Tous droits réservés.</p>
        </div>

    </div>
    
</footer>
</body>
</html>