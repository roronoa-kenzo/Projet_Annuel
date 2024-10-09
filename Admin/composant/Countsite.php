    <?php

    //compter les user 
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Stocker le nombre d'utilisateurs dans une variable
    $userCount = $stmt->rowCount();
    $sql = "SELECT * from comments";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $commentsCount = $stmt->rowCount();
    
    // nombre de post
    $userCount = $stmt->rowCount();
    $sql = "SELECT * from posts";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $postCount = $stmt->rowCount();

        // nombre de Iceberg
    $userCount = $stmt->rowCount();
    $sql = "SELECT * from forums";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $icebergCount = $stmt->rowCount();

    ?>
