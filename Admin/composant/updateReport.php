<?php
include './database.php';
session_start();

$statut = $_POST['statut'];
$UserReport = $_POST['UserReport'];
$Accuser = $_POST['Accuser'];
$RemoveContent = $_POST['RemoveContent'];

$report_id = $_POST['report_id'];
$sql = "
    SELECT 
        reports.id AS report_id,
        reports.reported_content_link,
        reports.report_reason,
        reports.additional_details,
        reports.status,
        reports.created_at,
        reports.user_id AS UserReport,
        reports.updated_at,
        users.username AS reported_by
    FROM 
        reports
    INNER JOIN 
        users 
    ON 
        reports.user_id = users.id
    WHERE 
        reports.id = :report_id
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['report_id' => $report_id]);
$report = $stmt->fetch();

$link = $report['reported_content_link'];

if (filter_var($link, FILTER_VALIDATE_URL) && isset($Accuser)) {
    //decoupe le liens jusqu'au ?
    $post_ice = explode('?', $link);
    $resul_link = $post_ice[1] ?? null;


    // Extraire uniquement les chiffres de la partie après "?"
    $link_id = filter_var($resul_link, FILTER_SANITIZE_NUMBER_INT);

    $get_link = explode('=', $resul_link)[0] ?? null;

    var_dump("post_ice: " . $post_ice);
    echo "<br>";
    var_dump("resul_link: " . $resul_link);
    echo "<br>";
    var_dump("get_link: " . $get_link);
    echo "<br>";
    var_dump("link_id: " . $link_id);

    if ($get_link == "Post") {
        $sql = "
        SELECT user_id 
FROM posts 
WHERE id = :post_id;

        ";
        $stmt = $pdo->prepare($sql);
        $stmt = $pdo->prepare($sql);

        // Utiliser bindParam pour lier les paramètres
        $stmt->bindParam(':post_id', $link_id, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        $result = $stmt->fetch();
        if (!$result) {
            die("Erreur : Aucun forum trouvé avec l'ID = $link_id.");
        }
        header('Location: ./../User.php?user=' . $result['user_id']);
        exit;
    } else if ($get_link == "forum_id" && isset($Accuser)) {
        $sql = "
        SELECT creator_id 
        FROM forums 
        WHERE id = :forum_id;
        ";

        $stmt = $pdo->prepare($sql);
        $stmt = $pdo->prepare($sql);

        // Utiliser bindParam pour lier les paramètres
        $stmt->bindParam(':forum_id', $link_id, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        $result = $stmt->fetch();
        //
        //exit;*/
        if (!$result) {
            die("Erreur : Aucun forum trouvé avec l'ID = $link_id.");
        }
        header('Location: ./../User.php?user=' . $result['creator_id']);
    }

}

if (isset($statut)) {
    $sql = "UPDATE reports SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => $statut, 'id' => $report_id]);
    header('Location: ./../ReportContent.php?Report_id=' . $report_id);
    exit();
}


if (isset($Accuser)) {

}

if (isset($RemoveContent)) {
    //decoupe le liens jusqu'au ?
    $post_ice = explode('?', $link);
    $resul_link = $post_ice[1] ?? null;


    // Extraire uniquement les chiffres de la partie après "?"
    $link_id = filter_var($resul_link, FILTER_SANITIZE_NUMBER_INT);

    $get_link = explode('=', $resul_link)[0] ?? null;

    var_dump("post_ice: " . $post_ice);
    echo "<br>";
    var_dump("resul_link: " . $resul_link);
    echo "<br>";
    var_dump("get_link: " . $get_link);
    echo "<br>";
    var_dump("link_id: " . $link_id);

    if ($get_link == "Post") {
        $sql = "
        DELETE FROM posts 
        WHERE id = :post_id;
        ";
        $stmt = $pdo->prepare($sql);
        // Utiliser bindParam pour lier les paramètres
        $stmt->bindParam(':post_id', $link_id, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Le post avec l'ID $link_id a été supprimé avec succès.";
        } else {
            echo "Erreur : Aucun post trouvé avec l'ID $link_id.";
        }
        header('Location: ./../ReportContent.php?Report_id=' . $report_id);
        exit;
    } else if ($get_link == "forum_id") {
        $sql = "
        DELETE FROM forums 
        WHERE id = :forum_id;
        ";

        $stmt = $pdo->prepare($sql);
        // Utiliser bindParam pour lier les paramètres
        $stmt->bindParam(':forum_id', $link_id, PDO::PARAM_INT);

        // Exécuter la requête
        $stmt->execute();

        $result = $stmt->fetch();
        //
        //exit;*/
        if ($stmt->rowCount() > 0) {
            echo "Le post avec l'ID $link_id a été supprimé avec succès.";
        } else {
            echo "Erreur : Aucun post trouvé avec l'ID $link_id.";
        }
        header('Location: ./../ReportContent.php?Report_id=' . $report_id);
        exit;
    }
}






