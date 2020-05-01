<?php
@require_once 'include/fpdf/fpdf.php';
@require_once 'include/config.php';
@require_once 'include/classes/database.class.php';

$dbclass    		= new database($dbtype, $dbhost, $dbname, $dbuser, $dbpass);
$mysqli     		= new mysqli($dbhost, $dbuser, $dbpass, $dbname);

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
	$this->Ln(12);
    
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
//Line break
$pdf->Ln(5);
//$pdf->Image("images/".$ket.".jpg",80,125,60);
$pdf->MultiCell(0,5,"Yang bersangkutan dinyatakan LULUS berdasarkan hasil keputusan Rapat Pleno Kelulusan  Dewan Guru SMA Negeri 1 Pecangaan pada hari Selasa tanggal 28 April 2020 dengan nilai sebagai berikut :",0,'C');
//Line break
$pdf->Ln(5);
$pdf->SetFont('Times','',10);
$pdf->Cell(10,6,'NO',1,0);
$pdf->Cell(50,6,'MATA PELAJARAN',1,0);
$pdf->Cell(35,6,'PENGETAHUAN',1,0);
$pdf->Cell(30,6,'KETRAMPILAN',1,0);
$pdf->Cell(25,6,'RATA-RATA',1,0);
$pdf->SetFont('Arial','',10);


$pdf->Ln(5);
$pdf->MultiCell(0,5,"Demikian pemberitahuan ini kami sampaikan agar diketahui dan dimaklumi.",0,'J');
//Line break
$pdf->Ln(5);
//Move to the right
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"Demak, 14 Juni 2014",0,'J');
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"Kepala Sekolah,",0,'J');
//Line break
$pdf->Ln(25);
//Move to the right
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"H. SAKDULLAH.S.Ag.",0,'J');
$pdf->Cell(105.4);
$pdf->MultiCell(0,5,"NIY. 49.001.0710",0,'J');
//Line break
$pdf->Ln(5);
$pdf->MultiCell(0,5,"Catatan :",0,'J');
$pdf->MultiCell(0,5,"- Bagi siswa yang belum mengembalikan buku perpustakaan harap segera dikembalikan.",0,'J');
$pdf->MultiCell(0,5,"- Untuk siswa yang mendapatkan keterangan “PANGGILAN”. Silakan datang kesekolah hubungi panitia.",0,'J');

$pdf->Output();
?>
