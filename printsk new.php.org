<?php
//@require_once 'include/fpdf/fpdf.php';
@require_once 'include/config.php';
@require_once 'include/classes/database.class.php';
$servername    = "localhost";
$username    = "root";
$password    = "";
$dbname        = "smancaasik";
$dbclass    		= new database($dbtype, $dbhost, $dbname, $dbuser, $dbpass);
$mysqli     		= new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$conn    = mysqli_connect ($servername, $username, $password, $dbname);
if (!$conn){
    die ("Connection Failed: ". mysqli_connect_error());
    }

//Koneksi library FPDF
//class PDF extends FPDF
require('include/fpdf/fpdf.php');
// Setting halaman PDF
$pdf = new FPDF('l','mm','A5');
// Menambah halaman baru
$pdf->AddPage();
// Setting jenis font
$pdf->SetFont('Arial','B',16);
// Membuat string
// Membuat string
$pdf->Cell(190,7,'Daftar Harga Motor Dealer Maju Motor',0,1,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,7,'Jl. Abece No. 80 Kodamar, jakarta Utara.',0,1,'C');
// Setting spasi kebawah supaya tidak rapat

$noujian = $_REQUEST['noUjian'];
$sql    = "SELECT * FROM tbl_siswa WHERE noujian = '$noujian'";
$query  = $dbclass->query($sql);
$data   = $dbclass->get_row();
$ket    = $data['ket'];;
$nama        = $data['name'];
$tgllhr        = $data['tgllhr'];
$kelas       = $data['jurusan'];
$noujian     = $data['noujian'];
$sekolah = $data['sekolah'];



$text = "Yang bertanda tangan di bawah ini, Kepala Sekolah Menengah Atas Negeri 1 Pecangaan, menerangkan dengan sesungguhnya bahwa :";
//Instanciation of inherited class

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(25.4, 25.4, 25.4);
$pdf->SetFont('Times','U',12);
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"SURAT KETERANGAN LULUS",0,'C');
$pdf->SetFont('Times','',11);
$pdf->MultiCell(0,5,"Nomor : 421.3 / 1839",0,'C');
$pdf->SetFont('Times','B',12);
$pdf->Ln(5);

$pdf->MultiCell(0,5,"SMA NEGERI 1 PECANGAAN",0,'C');
$pdf->SetFont('Times','',11);
$pdf->MultiCell(0,5,"PEMINATAN : ".$kelas,0,'C');
$pdf->SetFont('Times','',11);
$pdf->MultiCell(0,5,"TAHUN PELAJARAN : 2019 / 2020",0,'C');
//Line break
$pdf->Ln(5);
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,$text,0,'J');
//Line break
$pdf->Ln(5);
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nama                    : ".$nama,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Tanggal lahir        : ".$tgllhr,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Jurusan                  : ".$kelas,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nomor Ujian         : ".$noujian,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Asal Sekolah         : ".$sekolah,0,'J');



$pdf->Cell(10,7,'',0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,6,'no',1,0);
//$pdf->Cell(50,6,'NIS',1,0);
$pdf->Cell(35,6,'MATA PELAJARAN',1,0);
$pdf->Cell(30,6,'R. Rapot',1,0);
$pdf->Cell(25,6,'US',1,0);
$pdf->Cell(25,6,'NA',1,1);
 
$pdf->SetFont('Arial','',10);
$query = mysqli_query($conn, "SELECT * FROM tbl_nilai WHERE noujian = '$noujian'");
while ($row = mysqli_fetch_array($query)){
    $pdf->Cell(10,6,$row['id_nilai'],1,0);
    //$pdf->Cell(50,6,$row['noujian'],1,0);
    $pdf->Cell(35,6,$row['nama_mapel'],1,0);
    $pdf->Cell(30,6,$row['nilai_sekolah'],1,0);
    $pdf->Cell(25,6,$row['nilai_un'],1,0);
    $pdf->Cell(25,6,$row['nilai_akhir'],1,1);
}


$pdf->Output();
?>