<?php
@require_once 'include/fpdf/fpdf.php';
@require_once 'include/config.php';
@require_once 'include/classes/database.class.php';

$dbclass    		= new database($dbtype, $dbhost, $dbname, $dbuser, $dbpass);
$mysqli     		= new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$conn    = mysqli_connect ($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn){
    die ("Connection Failed: ". mysqli_connect_error());
    }

include "config.php";
	
class PDF extends FPDF
{
//Page header
function Header()
{
	//Logo
	$this->Image('images/lpmaarif.gif',170,10,27);
	$this->Image('images/lpmaarif.gif',20,8,29);
	//Times bold 18
	$this->SetFont('Times','',14);
	//Move to the right
	$this->Cell(92);
	//Title
	$this->Cell(18,6,'BADAN PELAKSANA PENDIDIKAN MAARIF NU',0,1,'C');
	//$this->Cell(92);
	//$this->Cell(18,6,'DINAS PENDIDIKAN DAN KEBUDAYAAN',0,1,'C');
	//Times bold 12
	$this->SetFont('Times','',18);
	//Move to the right
	$this->Cell(92);
	//Title
	$this->Cell(18,6,'SMK NU MARIF KUDUS',0,1,'C');
	$this->Cell(92);
	$this->SetFont('Times','',12);
	$this->Cell(18,6,'TERAKREDITASI',0,1,'C');
	$this->SetFont('Times','',10);
	//Move to the right
	$this->Cell(92);
	$this->Cell(18,4,'Jl. Jepara Prambatan Lor 679 Telp. (0291) 434330 Kudus 59361',0,1,'C');
	$this->Cell(92);
	$this->Cell(18,6,'Faximile 0291-755218 Email : smkmaarifkudus@yahoo.com home page : http://www.smk-maarifkudus.sch.id',0,1,'C');
		//Set Line
		
    $this->SetLineWidth(0.5);
    //Line
	$this->Line(20,42,195,42);
	//Line break
	$this->Ln(2);
    
}

}
//$NoUjian = "$_POST[kd1]-$_POST[kd2]-$_POST[kd3]-$_POST[kd4]";
$noujian = $_REQUEST['noUjian'];
$sql    = "SELECT * FROM tbl_siswa WHERE noujian = '$noujian'";
$query  = $dbclass->query($sql);
$data   = $dbclass->get_row();
$ket    = $data['ket'];;
$nama        = $data['name'];
$tgllhr        = $data['tgllhr'];
$ortu			= $data['addresse'];
$kelas       = $data['jurusan'];
$noujian     = $data['noujian'];
$sekolah = $data['sekolah'];
$rata2 = $data['rata2'];

//$text = "Kepala SMA N 1 Pecangaan selaku Ketua Penyelenggara Ujian Sekolah Tahun pelajaran 2019/2020 berdasarkan :";

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetMargins(25.4, 20.4, 25.4);
$pdf->SetFont('Times','U',12);
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,10,"SURAT KETERANGAN LULUS",0,'C');
$pdf->SetFont('Times','',11);
$pdf->MultiCell(0,5,"Nomor : 421.3/277/2020",0,'C');
$pdf->SetFont('Times','B',12);
$pdf->Ln(2);

$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,"Kepala SMK NU MAARIF selaku Ketua Penyelenggara Ujian Sekolah Tahun pelajaran 2019/2020 berdasarkan :",0,'j');
$pdf->MultiCell(0,5,"1. Ketuntatasan dari seluruh program pembelajaran pada kurikulum 2013.",0,'j');
$pdf->MultiCell(0,5,"2. Kriteria kelulusan dari satuan pendidikan sesuai dengan peraturan perundang-undangan.",0,'j');
$pdf->MultiCell(0,5,"3. Rapat Pleno Dewan Pendidik tentang kelulusan pada tanggal 2 Mei 2020",0,'j');
$pdf->MultiCell(0,5,"Menerangkan bahwa :",0,'j');
//Line break
$pdf->Ln(1);
$pdf->SetFont('Times','',12);

//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nama                                      : ".$nama,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Tempat dan Tanggal lahir      : ".$tgllhr,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nama Orang Tua                    : ".$ortu,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nomor Induk Siswa                : ".$noujian,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nomor Induk Siswa Nasional : ".$sekolah,0,'J');
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Peminatan                                : ".$kelas,0,'J');
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Dinyatakan                              : ".$ket,0,'J');
//Line break
$pdf->Ln(1);
//$pdf->Image("images/".$ket.".jpg",80,125,60);
$pdf->MultiCell(0,5,"Dengan nilai sebagai berikut :",0,'L');
//Line break
$pdf->Ln(1);
//$pdf->Cell(10,7,'',0,1);
$pdf->Cell(12.4);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(12,10,'NO',1,0,'C');
//$pdf->Cell(50,6,'NIS',1,0);
$pdf->Cell(80,10,'MATA PELAJARAN',1,0,'C');
$pdf->Cell(40,10,'Nilai Ujian Sekolah',1,1,'C');
//$pdf->Cell(20,10,'US',1,0,'C');
//$pdf->Cell(20,10,'NS',1,1,'C');
$pdf->SetFont('Arial','',10);
$query2 = mysqli_query($conn, "SELECT * FROM tbl_nilai WHERE noujian = '$noujian'");
while ($row = mysqli_fetch_array($query2)){
    $pdf->Cell(12.4);
	$pdf->Cell(12,6,$row['nourut'],1,0);
    //$pdf->Cell(50,6,$row['noujian'],1,0);
    $pdf->Cell(80,6,$row['nama_mapel'],1,0);
    $pdf->Cell(40,6,$row['nilai_akhir'],1,1,'C');
    //$pdf->Cell(20,6,$row['nilai_un'],1,0,'C');
    //$pdf->Cell(20,6,$row['nilai_akhir'],1,1,'C');
}
$pdf->Cell(12.4);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(92,6,'Rata-rata',1,0,'C');
$pdf->Cell(40,6,$data['rata2'],1,1,'C');
$pdf->Ln(1);
//Move to the right
$pdf->SetFont('Times','',12);
$pdf->Cell(2.5);
$pdf->MultiCell(0,5,"Surat Keterangan Lulus ini berlaku sementara sampai dengan diterbitkannya ijazah kepada yang bersangkutan, untuk menjadikan maklum bagi yang berkepentingan",0,'J');
$pdf->Ln(2);
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"JKudus, 2 Mei 2020",0,'J');
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"Kepala Sekolah,",0,'J');
//Line break
$pdf->Image("images/ttd3.gif",142,257,40);
$pdf->Image("images/gadis.gif",88,252,25);
//$pdf->Image("images/stemp2.gif",120,244,30);
//$pdf->Image("images/".$noujian.".gif",42,249,20);
$pdf->Ln(7);
//Move to the right
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"Drs. Ahmad Nadlib, M.Pd.",0,'J');
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"NIP. 19611224 198903 1 006",0,'J');

//Line break
//$pdf->Ln(5);
//$pdf->MultiCell(0,5,"Catatan :",0,'J');
//$pdf->MultiCell(0,5,"- Bagi siswa yang belum mengembalikan buku perpustakaan harap segera dikembalikan.",0,'J');
//$pdf->MultiCell(0,5,"- Untuk siswa yang mendapatkan keterangan “PANGGILAN”. Silakan datang kesekolah hubungi panitia.",0,'J');

$pdf->Output();
?>
