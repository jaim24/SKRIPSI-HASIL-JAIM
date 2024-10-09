<?php
require('fpdf/fpdf.php');
include('includes/db.php');

class PDF extends FPDF
{
    // Header Page
    function Header()
    {
        // Ganti 'path/to/logo.png' dengan path yang benar, misalnya 'images/logo.png'
        $this->Image('images/logo.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Laporan Pembayaran SPP', 0, 0, 'C');
        $this->Ln(20);
    }

    // Footer Page
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nama Siswa');
$pdf->Cell(30, 10, 'Kelas');
$pdf->Cell(50, 10, 'Bulan');
$pdf->Cell(30, 10, 'Jumlah Bayar');
$pdf->Ln();

// Ambil data dari database
$sql = "SELECT * FROM pembayaran_spp";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['nama_siswa']);
    $pdf->Cell(30, 10, $row['kelas']);
    $pdf->Cell(50, 10, $row['bulan']);
    $pdf->Cell(30, 10, $row['jumlah'], 0, 1);
}

$pdf->Output();
?>
