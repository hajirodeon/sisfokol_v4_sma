<?php
//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/kelulusan_siswa.php");

nocache;


//start class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//nilai
$judul = "Rekap Data : Perkembangan Kelulusan Siswa";
$judulz = $judul;



//isi *START
ob_start();



$pdf->SetFont('Times','',8);
$pdf->SetFillColor(233,233,233);


//header
$pdf->AddPage();
$pdf->Cell(15,10,'TAPEL',1,0,'C',1);
$pdf->Cell(30,5,'JUMLAH PESERTA',1,0,'C',1);
$pdf->Cell(30,5,'LULUS',1,0,'C',1);
$pdf->Cell(30,5,'TIDAK LULUS',1,0,'C',1);



$pdf->SetY($pdf->GetY+46);
$pdf->SetX(25);
$pdf->Cell(10,5,'L',1,0,'C',1);
$pdf->Cell(10,5,'P',1,0,'C',1);
$pdf->Cell(10,5,'Jumlah',1,0,'C',1);

$pdf->Cell(10,5,'L',1,0,'C',1);
$pdf->Cell(10,5,'P',1,0,'C',1);
$pdf->Cell(10,5,'Jumlah',1,0,'C',1);

$pdf->Cell(10,5,'L',1,0,'C',1);
$pdf->Cell(10,5,'P',1,0,'C',1);
$pdf->Cell(10,5,'Jumlah',1,0,'C',1);
$pdf->Ln();






//looping tapel
$qkel = mysql_query("SELECT * FROM m_tapel ".
			"ORDER BY round(tahun1) ASC");
$rkel = mysql_fetch_assoc($qkel);

do
	{
	if ($warna_set ==0)
		{
		$warna = $warna01;
		$warna_set = 1;
		}
	else
		{
		$warna = $warna02;
		$warna_set = 0;
		}


	//nilai
	$kel_kd = nosql($rkel['kd']);
	$kel_tahun1 = nosql($rkel['tahun1']);
	$kel_tahun2 = nosql($rkel['tahun2']);
	$kel_tapel = "$kel_tahun1/$kel_tahun2";


	//jumlah peserta /////////////////////////////////////////////////////////////////////////////////////
	//jumlah siswa... L
	$qdt = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND m_kelamin.kelamin2 = 'L'");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);


	//jumlah siswa... P
	$qdt2 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND m_kelamin.kelamin2 = 'P'");
	$rdt2 = mysql_fetch_assoc($qdt2);
	$tdt2 = mysql_num_rows($qdt2);

	$jml_peserta = $tdt+$tdt2;





	//jumlah peserta, yang lulus //////////////////////////////////////////////////////////////////////////
	//jumlah siswa... L
	$qdt3 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND siswa_lulus.lulus = 'true' ".
				"AND m_kelamin.kelamin2 = 'L'");
	$rdt3 = mysql_fetch_assoc($qdt3);
	$tdt3 = mysql_num_rows($qdt3);


	//jumlah siswa... P
	$qdt4 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND siswa_lulus.lulus = 'true' ".
				"AND m_kelamin.kelamin2 = 'P'");
	$rdt4 = mysql_fetch_assoc($qdt4);
	$tdt4 = mysql_num_rows($qdt4);

	$jml_lulus = $tdt3+$tdt4;





	//jumlah peserta, yang tidak lulus //////////////////////////////////////////////////////////////////////////
	//jumlah siswa... L
	$qdt5 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND siswa_lulus.lulus = 'false' ".
				"AND m_kelamin.kelamin2 = 'L'");
	$rdt5 = mysql_fetch_assoc($qdt5);
	$tdt5 = mysql_num_rows($qdt5);


	//jumlah siswa... P
	$qdt6 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND siswa_lulus.lulus = 'false' ".
				"AND m_kelamin.kelamin2 = 'P'");
	$rdt6 = mysql_fetch_assoc($qdt6);
	$tdt6 = mysql_num_rows($qdt6);

	$jml_gak_lulus = $tdt5+$tdt6;




	$pdf->Cell(15,5,$kel_tapel,1,0,'C');
	$pdf->Cell(10,5,$tdt,1,0,'C');
	$pdf->Cell(10,5,$tdt2,1,0,'C');
	$pdf->Cell(10,5,$jml_peserta,1,0,'C');
	$pdf->Cell(10,5,$tdt3,1,0,'C');
	$pdf->Cell(10,5,$tdt4,1,0,'C');
	$pdf->Cell(10,5,$jml_lulus,1,0,'C');
	$pdf->Cell(10,5,$tdt5,1,0,'C');
	$pdf->Cell(10,5,$tdt6,1,0,'C');
	$pdf->Cell(10,5,$jml_gak_lulus,1,0,'C');
	$pdf->Ln();
	}
while ($rkel = mysql_fetch_assoc($qkel));







//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("kelulusan_siswa.pdf",I);
?>