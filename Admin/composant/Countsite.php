    <?php
    //compter les user 
// Récupération du nombre d'utilisateurs
$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$userCount = $stmt->rowCount(); // Correctement assigné à $userCount

// Récupération du nombre de commentaires
$sql = "SELECT * FROM comments";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$commentsCount = $stmt->rowCount(); // Correctement assigné à $commentsCount

// Récupération du nombre de posts
$sql = "SELECT * FROM posts";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$postCount = $stmt->rowCount(); // Correctement assigné à $postCount

// Récupération du nombre de forums (Icebergs)
$sql = "SELECT * FROM forums";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$icebergCount = $stmt->rowCount(); // Correctement assigné à $icebergCount

$sql = "SELECT COUNT(*) AS total_pending_reports FROM reports WHERE status = 'Pending'";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Récupération du résultat
$result = $stmt->fetch();
$totalPendingReports = $result['total_pending_reports'];

// recuperation rtiket
$sql = "SELECT COUNT(*) AS count FROM tickets";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Récupérer le résultat
$result = $stmt->fetch();

// Stocker le nombre de tickets dans $tiketCount
$tiketCount = $result['count'];
//useconnectCount
$sql = "SELECT COUNT(*) as connected_users FROM user_sessions WHERE is_connected = TRUE";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Récupérer le résultat et le stocker dans $useconnectCount
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$useconnectCount = $result['connected_users'];


?>
