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
	$this->Image('images/smanca.gif',27,8,29);
	//Times bold 18
	$this->SetFont('Times','',14);
	//Move to the right
	$this->Cell(92);
	//Title
	$this->Cell(30,6,'PEMERINTAH PROVINSI JAWA TENGAH',0,1,'C');
	$this->Cell(92);
	$this->Cell(30,6,'DINAS PENDIDIKAN DAN KEBUDAYAAN',0,1,'C');
	//Times bold 12
	$this->SetFont('Times','',18);
	//Move to the right
	$this->Cell(92);
	//Title
	$this->Cell(30,6,'SEKOLAH MENENGAH ATAS NEGERI 1',0,1,'C');
	$this->Cell(92);
	$this->Cell(30,6,'PECANGAAN',0,1,'C');
	$this->SetFont('Times','',10);
	//Move to the right
	$this->Cell(92);
	$this->Cell(30,4,'Jl. Raya Pecangaan – Jepara Km. 13 Jepara Kode Pos 59462 Telp. (0291) 755 218',0,1,'C');
	$this->Cell(92);
	$this->Cell(30,4,'Faximile 0291-755218 Surat Elektronik tu.sman1pecangaan@gmail.com',0,1,'C');
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

$text = "Yang bertanda tangan di bawah ini, Kepala Sekolah Menengah Atas Negeri 1 Pecangaan, menerangkan dengan sesungguhnya bahwa :";
//Instanciation of inherited class
$pdf=new PDF();
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
$pdf->Ln(2);
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,5,"SMA NEGERI 1 PECANGAAN",0,'C');
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,"PEMINATAN : ".$kelas,0,'C');
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,"TAHUN PELAJARAN 2019/2020",0,'C');
//Line break
$pdf->Ln(2);
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,$text,0,'J');
//Line break
//$pdf->Ln(2);
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nama                                      : ".$nama,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Tempat Tanggal lahir             : ".$tgllhr,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nama Orang Tua                    : ".$ortu,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nomor Induk Siswa                : ".$noujian,0,'J');
//Move to the right
$pdf->Cell(15.4);
$pdf->MultiCell(0,5,"Nomor Induk Siswa Nasional : ".$sekolah,0,'J');
//Line break
$pdf->Ln(1);
//$pdf->Image("images/".$ket.".jpg",80,125,60);
$pdf->MultiCell(0,5,"Yang bersangkutan dinyatakan LULUS berdasarkan hasil keputusan Rapat Pleno Kelulusan  Dewan Guru SMA Negeri 1 Pecangaan pada hari Selasa tanggal 28 April 2020 dengan nilai sebagai berikut :",0,'L');
//Line break
//$pdf->Ln(1);
$pdf->Cell(10,7,'',0,1);
$pdf->Cell(2.4);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,'NO',1,0,'C');
//$pdf->Cell(50,6,'NIS',1,0);
$pdf->Cell(80,10,'MATA PELAJARAN',1,0,'C');
$pdf->Cell(20,10,'R. RAPOT',1,0,'C');
$pdf->Cell(20,10,'US',1,0,'C');
$pdf->Cell(20,10,'NS',1,1,'C');
 
$pdf->SetFont('Arial','',10);
$query2 = mysqli_query($conn, "SELECT * FROM tbl_nilai WHERE noujian = '$noujian'");
while ($row = mysqli_fetch_array($query2)){
    $pdf->Cell(2.4);
	$pdf->Cell(10,6,$row['id_nilai'],1,0);
    //$pdf->Cell(50,6,$row['noujian'],1,0);
    $pdf->Cell(80,6,$row['nama_mapel'],1,0);
    $pdf->Cell(20,6,$row['nilai_sekolah'],1,0,'C');
    $pdf->Cell(20,6,$row['nilai_un'],1,0,'C');
    $pdf->Cell(20,6,$row['nilai_akhir'],1,1,'C');
}
//$pdf->Cell(10,6);
//$pdf->MultiCell(0,5,"TOTAL : ".$total,0,'J');
//$pdf->Ln(1);
$pdf->Cell(12.4);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(0,5,"Nilai Sekolah = (Nilai Rata-rata Rapot + Nilai Ujian Sekolah)/2.",0,'J');
$pdf->SetFont('Times','',12);
$pdf->Ln(1);
$pdf->MultiCell(0,5,"Surat Keterangan Lulus ini berlaku sementara sampai dengan diterbitkannya ijazah kepada yang bersangkutan, untuk menjadikan maklum bagi yang berkepentingan",0,'J');
//Line break
$pdf->Ln(3);
//Move to the right
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"Pecangaan, 2 Mei 2020",0,'J');
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"Kepala Sekolah,",0,'J');
//Line break
$pdf->Image("images/ttd.gif",142,254,40);
$pdf->Image("images/qrsmanca.gif",95,244,30);
//$pdf->Image("images/".$ket.".gif",90,210,30);
$pdf->Ln(10);
//Move to the right
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"Drs. Noor Kholiq, M.Pd.",0,'J');
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"NIP. 19611224 198903 1 006",0,'J');

//Line break
//$pdf->Ln(5);
//$pdf->MultiCell(0,5,"Catatan :",0,'J');
//$pdf->MultiCell(0,5,"- Bagi siswa yang belum mengembalikan buku perpustakaan harap segera dikembalikan.",0,'J');
//$pdf->MultiCell(0,5,"- Untuk siswa yang mendapatkan keterangan “PANGGILAN”. Silakan datang kesekolah hubungi panitia.",0,'J');

$pdf->Output();
?>
