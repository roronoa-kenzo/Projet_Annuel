
<style>
        .xp-bar-container {
            width: 75%;
            height: 12px;
            background-color: #cccccc; /* Fond gris */
            border-radius: 8px;
            overflow: hidden;
            margin: 20px 0;
            position: relative;
        }

        .xp-bar-fill {
            height: 100%;
            background-color: #000000; /* Barre noire */
            width: 0%;
            transition: width 0.3s ease;
        }


</style>
<div class="xp-bar-container">
    <div id="xp-bar-fill" class="xp-bar-fill"></div>
</div>

<script>
    // Valeurs d'XP et de niveau actuelles
    const userXP = 120;          // XP actuelle de l'utilisateur
    const nextLevelXP = 200;     // XP nécessaire pour atteindre le prochain niveau

    // Calculer le pourcentage de la barre
    const xpPercentage = (userXP / nextLevelXP) * 100;

    // Mettre à jour la barre d'XP et le texte
    const xpBarFill = document.getElementById('xp-bar-fill');
    const xpBarText = document.getElementById('xp-bar-text');

    xpBarFill.style.width = `${xpPercentage}%`;
    xpBarText.textContent = `XP: ${userXP} / ${nextLevelXP}`;

</script>