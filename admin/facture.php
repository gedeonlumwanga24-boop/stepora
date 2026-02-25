<?php
require_once __DIR__ . '/../backend/config/database.php';
require_once __DIR__ . '/../backend/tcpdf/tcpdf.php';

if (!isset($_GET['id'])) {
    die("Commande introuvable");
}

$id = (int) $_GET['id'];

$database = new Database();
$pdo = $database->getConnection();

// ================= COMMANDE =================
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
$stmt->execute([$id]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$commande) die("Commande introuvable");

// ================= PRODUITS =================
$stmtProd = $pdo->prepare("SELECT * FROM commande_produits WHERE commande_id = ?");
$stmtProd->execute([$id]);
$produits = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

// ================= TCPDF =================
$pdf = new TCPDF();
$pdf->SetCreator('Stepora Shoes');
$pdf->SetAuthor('Stepora Shoes');
$pdf->SetTitle("Facture Commande #$id");
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();

// Logo boutique
$logoPath = __DIR__ . '/../public/images/logo.jpg';
if(file_exists($logoPath)){
    $pdf->Image($logoPath, 15, 10, 40);
}

// Titre facture
$pdf->SetFont('dejavusans', 'B', 16);
$pdf->Ln(25);
$pdf->Cell(0, 10, "Facture Commande #$id", 0, 1, 'R');

// Date
$pdf->SetFont('dejavusans', '', 12);
$pdf->Cell(0, 5, "Date : " . date('d/m/Y'), 0, 1, 'R');
$pdf->Ln(5);

// Infos client
$pdf->SetFont('dejavusans', '', 12);
$pdf->Cell(0, 5, "Client : " . $commande['prenom'] . ' ' . $commande['nom'], 0, 1);
$pdf->Cell(0, 5, "Email : " . $commande['email'], 0, 1);
$pdf->Ln(5);

// ================= PRODUITS =================
$html = '<table border="1" cellpadding="5">
<tr style="background-color:#eee;">
<th>Produit</th>
<th>Taille</th>
<th>Qté</th>
<th>Prix</th>
<th>Total</th>
</tr>';

foreach($produits as $p){
    $totalProduit = $p['prix'] * $p['quantite'];
    $html .= '<tr>
        <td>'.htmlspecialchars($p['nom_produit']).'</td>
        <td>'.htmlspecialchars($p['taille']).'</td>
        <td>'.$p['quantite'].'</td>
        <td>'.number_format($p['prix'],2,',',' ').' €</td>
        <td>'.number_format($totalProduit,2,',',' ').' €</td>
    </tr>';
}

$html .= '<tr>
<td colspan="4" align="right"><strong>Total :</strong></td>
<td><strong>'.number_format($commande['total'],2,',',' ').' €</strong></td>
</tr>';
$html .= '</table>';

// Afficher tableau
$pdf->writeHTML($html, true, false, true, false, '');

// ================= OUTPUT =================
$pdf->Output("facture_{$commande['id']}.pdf", 'I'); // I = afficher dans le navigateur
