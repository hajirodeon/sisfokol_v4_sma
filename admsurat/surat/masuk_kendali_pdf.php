<?php
//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/kendali_masuk.php");

nocache;


//start class
//$pdf=new PDF("L","mm","F8");
$pdf=new PDF("P","mm","A4");
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);
$pdf->SetAutoPageBreak(true,1);


//nilai
$judul = "Kartu Kendali Surat Masuk";
$judulz = $judul;
$sukd = nosql($_REQUEST['sukd']);


//query
$qx = mysql_query("SELECT surat_masuk.*, ".
			"DATE_FORMAT(tgl_surat, '%d') AS surat_tgl, ".
			"DATE_FORMAT(tgl_surat, '%m') AS surat_bln, ".
			"DATE_FORMAT(tgl_surat, '%Y') AS surat_thn, ".
			"DATE_FORMAT(tgl_terima, '%d') AS terima_tgl, ".
			"DATE_FORMAT(tgl_terima, '%m') AS terima_bln, ".
			"DATE_FORMAT(tgl_terima, '%Y') AS terima_thn ".
			"FROM surat_masuk ".
			"WHERE kd = '$sukd'");
$rowx = mysql_fetch_assoc($qx);
$x_no_urut = nosql($rowx['no_urut']);
$x_no_surat = balikin2($rowx['no_surat']);
$x_asal = balikin2($rowx['asal']);
$x_tujuan = balikin2($rowx['tujuan']);
$x_kd_klasifikasi = nosql($rowx['kd_klasifikasi']);
$x_surat_tgl = nosql($rowx['surat_tgl']);
$x_surat_bln = nosql($rowx['surat_bln']);
$x_surat_thn = nosql($rowx['surat_thn']);
$x_perihal = balikin2($rowx['perihal']);
$x_lampiran = balikin2($rowx['lampiran']);
$x_terima_tgl = nosql($rowx['terima_tgl']);
$x_terima_bln = nosql($rowx['terima_bln']);
$x_terima_thn = nosql($rowx['terima_thn']);


//detail kendali
$qx2 = mysql_query("SELECT surat_masuk_kendali.*, ".
			"DATE_FORMAT(tgl_selesai, '%d') AS selesai_tgl, ".
			"DATE_FORMAT(tgl_selesai, '%m') AS selesai_bln, ".
			"DATE_FORMAT(tgl_selesai, '%Y') AS selesai_thn, ".
			"DATE_FORMAT(tgl_kembali, '%d') AS kembali_tgl, ".
			"DATE_FORMAT(tgl_kembali, '%m') AS kembali_bln, ".
			"DATE_FORMAT(tgl_kembali, '%Y') AS kembali_thn ".
			"FROM surat_masuk_kendali ".
			"WHERE kd_surat = '$sukd'");
$rowx2 = mysql_fetch_assoc($qx2);
$x2_inxkd = nosql($rowx2['kd_indeks']);
$x2_selesai_tgl = nosql($rowx2['selesai_tgl']);
$x2_selesai_bln = nosql($rowx2['selesai_bln']);
$x2_selesai_thn = nosql($rowx2['selesai_thn']);
$x2_kembali_tgl = nosql($rowx2['kembali_tgl']);
$x2_kembali_bln = nosql($rowx2['kembali_bln']);
$x2_kembali_thn = nosql($rowx2['kembali_thn']);
$x2_kepada = balikin($rowx2['kepada']);
$x2_lampiran = balikin($rowx2['lampiran']);



//terpilih
$qblsx = mysql_query("SELECT * FROM surat_m_indeks ".
			"WHERE kd = '$x2_inxkd'");
$rblsx = mysql_fetch_assoc($qblsx);
$blsx_indeks = balikin($rblsx['indeks']);


//kode
$qdtx = mysql_query("SELECT * FROM surat_m_klasifikasi ".
			"WHERE kd = '$x_kd_klasifikasi'");
$rdtx = mysql_fetch_assoc($qdtx);
$dtx_klasifikasi = balikin($rdtx['klasifikasi']);





//isi *START
ob_start();



$pdf->SetFont('Times','',8);


//header
$pdf->AddPage();


$pdf->SetY(4);
$pdf->SetX(10);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(55,15,'INDEKS BERKAS : ',1,0,'L');
$pdf->Cell(75,15,'',1,0,'L');


$pdf->SetY(7);
$pdf->SetX(47);
$pdf->SetFont('Arial','',10);
$pdf->Cell(55,15,$blsx_indeks,0,0,'L');

$pdf->SetY(4);
$pdf->SetX(68);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,15,'Tgl. : '.$x_terima_tgl.'/'.$x_terima_bln.'/'.$x_terima_thn.'',0,0,'L');


$pdf->SetY(9);
$pdf->SetX(68);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,15,'No.Urut : '.$x_no_urut.'',0,0,'L');


$pdf->SetY(9);
$pdf->SetX(100);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,15,'M',0,0,'L');



$pdf->SetY(9);
$pdf->SetX(110);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,15,'Kode : '.$dtx_klasifikasi.'',0,0,'L');


$pdf->SetY(19);
$pdf->Cell(130,16,'',1,0,'L');

$pdf->SetY(21);
$pdf->SetX(17);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(55,16,''.$x_perihal.'',0,0,'L');
$pdf->SetY(25);
$pdf->SetX(12);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,16,'Isi Ringkas',0,0,'L');




$pdf->SetY(35);
$pdf->Cell(130,13,'',1,0,'L');

$pdf->SetY(37);
$pdf->SetX(17);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(55,13,''.$x_lampiran.'',0,0,'L');
$pdf->SetY(40);
$pdf->SetX(12);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,13,'Lampiran',0,0,'L');




$pdf->SetY(48);
$pdf->Cell(55,12,'',1,0,'L');
$pdf->Cell(75,12,'',1,0,'L');

$pdf->SetY(52);
$pdf->SetX(12);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,12,'Dari : '.$x_asal.'',0,0,'L');

$pdf->SetY(52);
$pdf->SetX(67);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,12,'Kepada : '.$x_tujuan .'',0,0,'L');




$pdf->SetY(60);
$pdf->Cell(55,12,'',1,0,'L');
$pdf->Cell(75,12,'',1,0,'L');

$pdf->SetY(64);
$pdf->SetX(12);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,12,'Tanggal : '.$x_surat_tgl.'/'.$x_surat_bln.'/'.$x_surat_thn.'',0,0,'L');

$pdf->SetY(64);
$pdf->SetX(67);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,12,'No.Surat : '.$x_no_surat.'',0,0,'L');



$pdf->SetY(72);
$pdf->Cell(95,12,'',1,0,'L');
$pdf->Cell(35,12,'',1,0,'L');

$pdf->SetY(76);
$pdf->SetX(12);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,12,'Pengolah : '.$x2_kepada.'',0,0,'L');

$pdf->SetY(72);
$pdf->SetX(107);
$pdf->SetFont('Arial','',8);
$pdf->Cell(65,12,'Paraf : ',0,0,'L');




$pdf->SetY(84);
$pdf->Cell(130,12,'',1,0,'L');

$pdf->SetY(88);
$pdf->SetX(12);
$pdf->SetFont('Arial','',8);
$pdf->Cell(55,12,'Catatan : ',0,0,'L');




//panjangkan kebawah, sampe full ke A4.
$pdf->Ln();
$pdf->Cell(130,200,'',0,1,'L');




//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("kendali_surat_masuk.pdf",I);
?>