<?php
require_once './composant/admin_check.php';
include './../composants/header.php';
include './composant/database.php';
include './composant/sessionStart.php';

$Report_id = $_GET['Report_id'] ?? null;
$sql = "
    SELECT 
        reports.id AS report_id,
        reports.reported_content_link,
        reports.report_reason,
        reports.additional_details,
        reports.status,
        reports.created_at AS report_created_at,
        reports.updated_at AS report_updated_at,
        users.username
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
$stmt->execute(['report_id' => $Report_id]);
$report = $stmt->fetch();

?>

<body>
    <?php
    include './../composants/navbar.php';
    ?>

    <main class="container">
        <div class="black-frame">
            <h1>Reporte by <?php echo $report['username'] ?></h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; ?>
            <div class="white-content-admin" style="height: 30rem;">
                <form action="./composant/updateReport.php" method="POST">
                    <h3>Raison de la <?php echo $report['report_reason'] ?></h3>
                    <p>Lien du report : <br>
                    <a href="<?php echo $report['reported_content_link'] ?>"><?php echo $report['reported_content_link'] ?></a></p>
                    <p>Detail du signalement :<br>
                        <?php echo $report['additional_details'] ?>
                    </p>
                    <p>Statut du Report : </p>
                    <p class="<?php echo $report['status'] ?>"><?php echo $report['status'] ?></p>
                    <input type="hidden" name="report_id" id="report_id" value="<?= $report['report_id'] ?>">
                    <select name="statut" id="statut">
                        <option value="Pending">Pending</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                    <div style="display: flex;justify-content: space-between;">
                        <p>Cree le :<br> <?php echo $report['report_created_at'] ?></p>
                        <p>Mise à jour le :<br> <?php echo $report['report_updated_at'] ?></p>
                    </div>
                    <div style="display: flex;justify-content: center;padding-top:20px">
                        <button class="btn-menu-admin" type="submit">Mettre à jours le statut</button>
                    </div>
                </form>
            </div>
            <style>
                select {
                    width: 6rem;
                    height: 2rem;
                    font-size: medium;
                    border-radius: 5px;
                }

                .Pending {
                    color: orange;
                    /* Orange pour les rapports en Pending */
                }

                .Resolved {
                    color: green;
                    /* Vert pour les rapports en Resolved */
                }

                .Rejected {
                    color: red;
                    /* Rouge pour les rapports en Rejected */
                }
            </style>
            <?php include './composant/white_content_right-report.php'; ?>

        </div>
    </main>

    <script src="./searchbar.js"></script>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>