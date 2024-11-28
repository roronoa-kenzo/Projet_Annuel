<?php
require_once './database.php';
require_once './../../lib/fpdf.php'; // Inclure la bibliothèque FPDF

session_start();

try {
    // Récupérer les informations de tous les utilisateurs
    $stmt = $pdo->query("SELECT username, email, first_name, last_name, xp, level, created_at FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($users)) {
        die("Aucun utilisateur trouvé.");
    }

    // Initialiser le PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Liste des utilisateurs', 0, 1, 'C');
    $pdf->Ln(10); // Saut de ligne

    // En-têtes des colonnes
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Username', 1);
    $pdf->Cell(50, 10, 'Email', 1);
    $pdf->Cell(40, 10, 'Nom', 1);
    $pdf->Cell(40, 10, 'XP', 1);
    $pdf->Cell(20, 10, 'Niveau', 1);
    $pdf->Ln();

    // Contenu des utilisateurs
    $pdf->SetFont('Arial', '', 10);
    foreach ($users as $user) {
        $pdf->Cell(40, 10, $user['username'], 1);
        $pdf->Cell(50, 10, $user['email'], 1);
        $pdf->Cell(40, 10, $user['first_name'] . ' ' . $user['last_name'], 1);
        $pdf->Cell(40, 10, $user['xp'], 1);
        $pdf->Cell(20, 10, $user['level'], 1);
        $pdf->Ln();
    }

    // Envoyer le fichier au navigateur
    $pdf->Output('D', 'liste_utilisateurs.pdf');
} catch (PDOException $e) {
    error_log('Erreur lors de la récupération des utilisateurs : ' . $e->getMessage());
    die("Erreur lors de la génération du PDF.");
}
?>
