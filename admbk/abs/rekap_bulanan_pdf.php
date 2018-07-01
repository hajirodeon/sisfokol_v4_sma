<?php
//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/rekap_bulanan.php");

nocache;


//start class
$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//nilai
$judul = "Rekap Absen Bulanan";
$judulz = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$rukd = nosql($_REQUEST['rukd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);




//isi *START
ob_start();



$pdf->SetFont('Times','B',10);
$pdf->SetFillColor(233,233,233);





//kelas
$qbt = mysql_query("SELECT * FROM m_kelas ".
			"ORDER BY round(no) ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);

	$pdf->Cell(20,5,'KELAS',1,0,'C',1);
	$pdf->Cell(30,5,'JML.SISWA',1,0,'C',1);
	$pdf->Cell(10,5,'S',1,0,'C',1);
	$pdf->Cell(10,5,'I',1,0,'C',1);
	$pdf->Cell(10,5,'A',1,0,'C',1);
	$pdf->Cell(20,5,'JUMLAH',1,0,'C',1);
	$pdf->Cell(20,5,'%',1,0,'C',1);
	$pdf->Cell(20,5,'KET',1,0,'C',1);
	$pdf->Ln();


	//daftar ruang
	$qru = mysql_query("SELECT * FROM m_ruang ".
				"ORDER BY ruang ASC");
	$rru = mysql_fetch_assoc($qru);

	do
		{
		$ru_kd = nosql($rru['kd']);
		$ru_ruang = balikin($rru['ruang']);

		$kelru = "$btkelas/$ru_ruang";


		//ketahui jumlah siswa
		$qjmu = mysql_query("SELECT siswa_kelas.*, m_siswa.* ".
					"FROM siswa_kelas, m_siswa ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$btkd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd'");
		$rjmu = mysql_fetch_assoc($qjmu);
		$tjmu = mysql_num_rows($qjmu);



		//ketahhui jumlah : SAKIT
		$qjuki = mysql_query("SELECT siswa_absensi.*, m_absensi.*, siswa_kelas.* ".
					"FROM siswa_absensi, m_absensi, siswa_kelas ".
					"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
					"AND siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$btkd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_absensi.absensi2 = 'S' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn'");
		$rjuki = mysql_fetch_assoc($qjuki);
		$tjuki = mysql_num_rows($qjuki);



		//ketahhui jumlah : IJIN
		$qjuki2 = mysql_query("SELECT siswa_absensi.*, m_absensi.*, siswa_kelas.* ".
					"FROM siswa_absensi, m_absensi, siswa_kelas ".
					"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
					"AND siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$btkd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_absensi.absensi2 = 'I' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn'");
		$rjuki2 = mysql_fetch_assoc($qjuki2);
		$tjuki2 = mysql_num_rows($qjuki2);



		//ketahhui jumlah : ALPHA
		$qjuki3 = mysql_query("SELECT siswa_absensi.*, m_absensi.*, siswa_kelas.* ".
					"FROM siswa_absensi, m_absensi, siswa_kelas ".
					"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
					"AND siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$btkd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_absensi.absensi2 = 'A' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn'");
		$rjuki3 = mysql_fetch_assoc($qjuki3);
		$tjuki3 = mysql_num_rows($qjuki3);



		//ketahhui jumlah total
		$qjuki4 = mysql_query("SELECT siswa_absensi.*, m_absensi.*, siswa_kelas.* ".
					"FROM siswa_absensi, m_absensi, siswa_kelas ".
					"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
					"AND siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$btkd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn'");
		$rjuki4 = mysql_fetch_assoc($qjuki4);
		$tjuki4 = mysql_num_rows($qjuki4);



		//prosentase
		$xnil_1 = $tjuki4/(22*$tjmu);
		$jml_persen = round($xnil_1*100,2);
		$jml_persen2 = "$jml_persen %";



		$pdf->Cell(20,5,$kelru,1,0,'C');
		$pdf->Cell(30,5,$tjmu,1,0,'C');
		$pdf->Cell(10,5,$tjuki,1,0,'C');
		$pdf->Cell(10,5,$tjuki2,1,0,'C');
		$pdf->Cell(10,5,$tjuki3,1,0,'C');
		$pdf->Cell(20,5,$tjuki4,1,0,'C');
		$pdf->Cell(20,5,$jml_persen2,1,0,'C');
		$pdf->Cell(20,5,'',1,0,'C');
		$pdf->Ln();
		}
	while ($rru = mysql_fetch_assoc($qru));


	//ketahui jumlah siswa
	$qjmux = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_ruang.* ".
				"FROM siswa_kelas, m_siswa, m_ruang ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_ruang = m_ruang.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$btkd'");
	$rjmux = mysql_fetch_assoc($qjmux);
	$tjmux = mysql_num_rows($qjmux);


	//ketahhui jumlah : SAKIT
	$qjukix = mysql_query("SELECT siswa_absensi.*, m_absensi.*, siswa_kelas.*, m_ruang.* ".
				"FROM siswa_absensi, m_absensi, siswa_kelas, m_ruang ".
				"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
				"AND siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_ruang = m_ruang.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$btkd' ".
				"AND m_absensi.absensi2 = 'S' ".
				"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn'");
	$rjukix = mysql_fetch_assoc($qjukix);
	$tjukix = mysql_num_rows($qjukix);


	//ketahhui jumlah : IJIN
	$qjukix2 = mysql_query("SELECT siswa_absensi.*, m_absensi.*, siswa_kelas.*, m_ruang.* ".
				"FROM siswa_absensi, m_absensi, siswa_kelas, m_ruang ".
				"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
				"AND siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_ruang = m_ruang.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$btkd' ".
				"AND m_absensi.absensi2 = 'I' ".
				"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn'");
	$rjukix2 = mysql_fetch_assoc($qjukix2);
	$tjukix2 = mysql_num_rows($qjukix2);


	//ketahhui jumlah : ALPHA
	$qjukix3 = mysql_query("SELECT siswa_absensi.*, m_absensi.*, siswa_kelas.*, m_ruang.* ".
				"FROM siswa_absensi, m_absensi, siswa_kelas, m_ruang ".
				"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
				"AND siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_ruang = m_ruang.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$btkd' ".
				"AND m_absensi.absensi2 = 'A' ".
				"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn'");
	$rjukix3 = mysql_fetch_assoc($qjukix3);
	$tjukix3 = mysql_num_rows($qjukix3);


	//ketahhui jumlah total
	$qjukix4 = mysql_query("SELECT siswa_absensi.*, m_absensi.*, siswa_kelas.*, m_ruang.* ".
				"FROM siswa_absensi, m_absensi, siswa_kelas, m_ruang ".
				"WHERE siswa_absensi.kd_absensi = m_absensi.kd ".
				"AND siswa_absensi.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_ruang = m_ruang.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$btkd' ".
				"AND round(DATE_FORMAT(siswa_absensi.tgl, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(siswa_absensi.tgl, '%Y')) = '$uthn'");
	$rjukix4 = mysql_fetch_assoc($qjukix4);
	$tjukix4 = mysql_num_rows($qjukix4);



	//prosentase
	$xnil_1x = $tjukix4/(22*$tjmux);
	$jml_persenx = round($xnil_1x*100,2);
	$jml_persenx2 = "$jml_persenx %";


	$pdf->Cell(20,5,"Jml/Rata2",1,0,'C',1);
	$pdf->Cell(30,5,$tjmux,1,0,'C',1);
	$pdf->Cell(10,5,$tjukix,1,0,'C',1);
	$pdf->Cell(10,5,$tjukix2,1,0,'C',1);
	$pdf->Cell(10,5,$tjukix3,1,0,'C',1);
	$pdf->Cell(20,5,$tjukix4,1,0,'C',1);
	$pdf->Cell(20,5,$jml_persenx2,1,0,'C',1);
	$pdf->Cell(20,5,'',1,0,'C',1);
	$pdf->Ln();


	$pdf->Ln();
	}
while ($rowbt = mysql_fetch_assoc($qbt));





//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("rekap_absen_bulanan.pdf",I);
?>