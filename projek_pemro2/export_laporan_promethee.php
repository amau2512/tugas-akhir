<?php
include "koneksi.php";
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,7,'LAPORAN HASIL PENILAIAN SISWA BERPRESTASI',0,1,'C');

        $this->SetFont('Arial','',11);
        $this->Cell(0,6,'Metode PROMETHEE',0,1,'C');
        $this->Cell(0,6,'SMA Negeri 8 Tangerang Selatan',0,1,'C');

        $this->Ln(5);

        $this->SetFont('Arial','B',10);
        $this->Cell(10,8,'No',1,0,'C');
        $this->Cell(25,8,'NIS',1,0,'C');
        $this->Cell(55,8,'Nama Siswa',1,0,'C');
        $this->Cell(20,8,'Kelas',1,0,'C');
        $this->Cell(20,8,'Phi+',1,0,'C');
        $this->Cell(20,8,'Phi-',1,0,'C');
        $this->Cell(20,8,'Net',1,0,'C');
        $this->Cell(20,8,'Rank',1,0,'C');
        $this->Cell(30,8,'Keterangan',1,1,'C');
    }

    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial','I',9);
        $this->Cell(0,6,'Dicetak pada: '.date('d-m-Y H:i'),0,1,'R');
        $this->Cell(0,6,'Sistem Penunjang Keputusan PROMETHEE',0,0,'R');
    }
}

$pdf = new PDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

$query = mysqli_query($conn,"
    SELECT * FROM hasil_promethee
    ORDER BY ranking ASC
");

$no = 1;
while($row = mysqli_fetch_assoc($query)){

    $pdf->Cell(10,8,$no++,1,0,'C');
    $pdf->Cell(25,8,$row['nis'],1,0,'C');
    $pdf->Cell(55,8,$row['nama_siswa'],1,0);
    $pdf->Cell(20,8,$row['kelas'],1,0,'C');
    $pdf->Cell(20,8,number_format($row['leaving_flow'],4),1,0,'C');
    $pdf->Cell(20,8,number_format($row['entering_flow'],4),1,0,'C');
    $pdf->Cell(20,8,number_format($row['net_flow'],4),1,0,'C');
    $pdf->Cell(20,8,$row['ranking'],1,0,'C');
    $pdf->Cell(30,8,$row['keterangan'],1,1,'C');
}

// ----------- Halaman Rekomendasi Pemenang ----------
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'REKOMENDASI SISWA BERPRESTASI',0,1);

$pdf->SetFont('Arial','',11);

$top = mysqli_query($conn,"
    SELECT * FROM hasil_promethee
    ORDER BY ranking ASC LIMIT 3
");

$rank = 1;
while($d = mysqli_fetch_assoc($top)){
    $pdf->Cell(
        0,7,
        $rank++.". ".$d['nama_siswa']." (".$d['nis'].") - ".$d['kelas']."  |  ".$d['keterangan'],
        0,1
    );
}

$pdf->Output('D','Laporan_PROMETHEE_Siswa_Berprestasi.pdf');
?>
