<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abyss</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <nav class="navbar">
      <img src="img/icon.png" alt="Abyss" class="logo">
      <div id="searchBar" class="search-container">
        <input type="text" placeholder="Rechercher...">
        <div class="suggestions" style="display: none;">
          <p>Marvel</p>
          <p>Sonic</p>
        </div>
      </div>
      <button id="darkModeButton">Nuit</button>
    </nav>
  </header>

  <main class="container">
    <div class="black-frame">
      <h1>Welcome in Abyss</h1>
    </div>
    <div class="main-index">
      <div class="white-content-secondary">
        <h1>Liste des Utilisateurs</h1>
    <?php include 'afficher_utilisateurs.php'; ?>
      </div>
      <div class="white-content">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et urna vitae ex mollis tincidunt.</p>
      </div>
      <div class="white-content-secondary">
        <p>Sonic</p>
      </div>
    </div>
  </main>

  <script src="js/searchbar.js"></script>
  <script src="js/darkmode.js"></script>
</body>
</html>