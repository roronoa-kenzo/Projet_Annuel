<?php 
    session_start(); 

    ?>
<div class="post-options">
   <p><strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></p>
    <button id="textButton" class="post-option">Text</button>
    <button id="imageVideoButton" class="post-option">Image & Video</button>
</div>
<!-- Ajout du script pour gérer l'affichage dynamique -->
<script>
        document.getElementById("textButton").addEventListener("click", function () {
            document.getElementById("textContent").style.display = "block";
            document.getElementById("imageVideoContent").style.display = "none";
            document.getElementById("linkContent").style.display = "none";
        });

        document.getElementById("imageVideoButton").addEventListener("click", function () {
            document.getElementById("textContent").style.display = "none";
            document.getElementById("imageVideoContent").style.display = "block";
            document.getElementById("linkContent").style.display = "none";
        });
</script>