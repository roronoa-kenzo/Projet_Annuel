<?php
require_once './composant/admin_check.php';
include './../composants/header.php';
include './composant/database.php';
include './composant/sessionStart.php';

$sql = "
        SELECT 
            reports.id AS report_id,
            reports.reported_content_link,
            reports.report_reason,
            reports.additional_details,
            reports.status,
            reports.created_at AS report_created_at,
            reports.updated_at AS report_updated_at,
            users.username,
            users.email
        FROM 
            reports
        INNER JOIN 
            users 
        ON 
            reports.user_id = users.id
        ORDER BY 
            CASE WHEN reports.status = 'Pending' THEN 1 ELSE 2 END,
            reports.created_at DESC;
        ";
$stmt = $pdo->query($sql);
$reports = $stmt->fetchAll();
?>

<body>
    <?php include './../composants/navbar.php'; ?>
    <main class="container">
        <div class="black-frame">
            <h1>Report</h1>
        </div>
        <div class="main-index-admin">
            <?php include './composant/white_content_left-admin.php'; 

            ?>
            <div class="white-content-admin">

                <?php foreach ($reports as $report): 
                    ?>
                    <div class="post-container-admin">
                        <a class="userLien" href="./ReportContent.php?Report_id=<?php echo $report['report_id']; ?>">
                            <div class="iceberg-select">
                                <div style="display: flex;justify-content: space-between;">
                                    <span class="username">Report by :
                                        <br><?php echo $report['username']; ?></span>

                                    <span class="username status <?php echo strtolower($report['status']); ?>">Status :
                                        <br><?php echo $report['status']; ?>
                                    </span>
                                </div>
                                <br><br>
                                <span class="username">Content :
                                    <br><?php echo $report['reported_content_link']; ?></span><br><br>
                                <span class="username">Reason :
                                    <br><?php echo $report['report_reason']; ?></span><br><br>
                                <span class="username">Details :
                                    <br><?php echo $report['additional_details']; ?></span><br><br>
                                <div style="display: flex;justify-content: space-between;">

                                    <span class="username">Created at :
                                        <br><?php echo $report['report_created_at']; ?></span>
                                    <span class="username">Updated at :
                                        <br><?php echo $report['report_updated_at']; ?></span>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <style>
        .status.pending {
            color: orange;
            /* Orange pour les rapports en Pending */
        }

        .status.resolved {
            color: green;
            /* Vert pour les rapports en Resolved */
        }

        .status.rejected {
            color: red;
            /* Rouge pour les rapports en Rejected */
        }
    </style>
    <script src="./searchbar.js"></script>
    <script src="./../public/js/searchbar.js"></script>
    <script src="./../public/js/darkmode.js"></script>

</body>

</html>