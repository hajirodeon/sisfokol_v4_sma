<?php
//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/perkembangan_siswa_bulanan.php");

nocache;


//start class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$judul = "Rekap Data : Perkembangan Siswa per Bulan";
$judulz = $judul;



//isi *START
ob_start();



$pdf->SetFont('Times','',8);
$pdf->SetFillColor(233,233,233);


//header
$pdf->AddPage();
$pdf->Cell(15,15,'KELAS',1,0,'C',1);
$pdf->Cell(30,5,'AWAL BULAN',1,0,'C',1);
$pdf->Cell(60,5,'MUTASI',1,0,'C',1);
$pdf->Cell(30,5,'AKHIR BULAN',1,0,'C',1);
$pdf->Cell(20,15,'KET',1,0,'C',1);


$pdf->SetY($pdf->GetY+56);
$pdf->SetX(25);
$pdf->Cell(10,10,'L',1,0,'C',1);
$pdf->Cell(10,10,'P',1,0,'C',1);
$pdf->Cell(10,10,'JML',1,0,'C',1);


$pdf->SetY($pdf->GetY+56);
$pdf->SetX(55);
$pdf->Cell(30,5,'MASUK',1,0,'C',1);
$pdf->Cell(30,5,'KELUAR',1,0,'C',1);
$pdf->SetY($pdf->GetY+61);
$pdf->SetX(55);
$pdf->Cell(10,5,'L',1,0,'C',1);
$pdf->Cell(10,5,'P',1,0,'C',1);
$pdf->Cell(10,5,'JML',1,0,'C',1);
$pdf->Cell(10,5,'L',1,0,'C',1);
$pdf->Cell(10,5,'P',1,0,'C',1);
$pdf->Cell(10,5,'JML',1,0,'C',1);


$pdf->SetY($pdf->GetY+56);
$pdf->SetX(115);
$pdf->Cell(10,10,'L',1,0,'C',1);
$pdf->Cell(10,10,'P',1,0,'C',1);
$pdf->Cell(10,10,'JML',1,0,'C',1);

$pdf->Ln();




//looping kelas
$qkel = mysql_query("SELECT * FROM m_kelas ".
			"ORDER BY round(no) ASC");
$rkel = mysql_fetch_assoc($qkel);

do
	{
	//nilai
	$kel_kd = nosql($rkel['kd']);
	$kel_kelas = balikin($rkel['kelas']);


	//looping ruang
	$qru = mysql_query("SELECT * FROM m_ruang ".
				"ORDER BY round(ruang2) ASC");
	$rru = mysql_fetch_assoc($qru);

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
		$ru_kd = nosql($rru['kd']);
		$ru_ruang = balikin($rru['ruang']);
		$kelru = "$kel_kelas/$ru_ruang";



		//awal bulan //////////////////////////////////////////////////////////////////////////////////
		$tgl_awal = "$uthn:$ubln:01";

		//jml. laki2
		$qlki = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_kelamin.kelamin2 = 'L' ".
					"AND m_siswa_diterima.tgl < '$tgl_awal'");
		$rlki = mysql_fetch_assoc($qlki);
		$tlki = mysql_num_rows($qlki);


		//jml. perempuan
		$qlki2 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_kelamin.kelamin2 = 'P' ".
					"AND m_siswa_diterima.tgl < '$tgl_awal'");
		$rlki2 = mysql_fetch_assoc($qlki2);
		$tlki2 = mysql_num_rows($qlki2);

		$jml_awal = round($tlki+$tlki2);







		//mutasi masuk ////////////////////////////////////////////////////////////////////////////////
		//jml. laki2
		$qlki3 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_kelamin.kelamin2 = 'L' ".
					"AND round(DATE_FORMAT(m_siswa_diterima.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(m_siswa_diterima.tgl, '%Y')) = '$uthn'");
		$rlki3 = mysql_fetch_assoc($qlki3);
		$tlki3 = mysql_num_rows($qlki3);


		//jml. perempuan
		$qlki4 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_kelamin.kelamin2 = 'P' ".
					"AND round(DATE_FORMAT(m_siswa_diterima.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(m_siswa_diterima.tgl, '%Y')) = '$uthn'");
		$rlki4 = mysql_fetch_assoc($qlki4);
		$tlki4 = mysql_num_rows($qlki4);

		$jml_mutasi_masuk = round($tlki3 + $tlki4);





		//mutasi keluar ////////////////////////////////////////////////////////////////////////////////
		//jml. laki2
		$qlki5 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_kelamin.kelamin2 = 'L' ".
					"AND round(DATE_FORMAT(m_siswa_perkembangan.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(m_siswa_perkembangan.tgl, '%Y')) = '$uthn'");
		$rlki5 = mysql_fetch_assoc($qlki5);
		$tlki5 = mysql_num_rows($qlki5);


		//jml. perempuan
		$qlki6 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND siswa_kelas.kd_ruang = '$ru_kd' ".
					"AND m_kelamin.kelamin2 = 'P' ".
					"AND round(DATE_FORMAT(m_siswa_perkembangan.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(m_siswa_perkembangan.tgl, '%Y')) = '$uthn'");
		$rlki6 = mysql_fetch_assoc($qlki6);
		$tlki6 = mysql_num_rows($qlki6);

		$jml_mutasi_keluar = round($tlki5 + $tlki6);





		//akhir bulan ////////////////////////////////////////////////////////////////////////////////
		//jml. laki2
		$akhir_l = round(($tlki + $tlki3)-$tlki5);

		//jml. perempuan
		$akhir_p = round(($tlki2 + $tlki4)-$tlki6);

		//jml.akhir
		$akhir_jml = round($akhir_l+$akhir_p);


		$pdf->Cell(15,5,$kelru,1,0,'C',0);
		$pdf->Cell(10,5,$tlki,1,0,'C',0);
		$pdf->Cell(10,5,$tlki2,1,0,'C',0);
		$pdf->Cell(10,5,$jml_awal,1,0,'C',0);
		$pdf->Cell(10,5,$tlki3,1,0,'C',0);
		$pdf->Cell(10,5,$tlki4,1,0,'C',0);
		$pdf->Cell(10,5,$jml_mutasi_masuk,1,0,'C',0);
		$pdf->Cell(10,5,$tlki5,1,0,'C',0);
		$pdf->Cell(10,5,$tlki6,1,0,'C',0);
		$pdf->Cell(10,5,$jml_mutasi_keluar,1,0,'C',0);
		$pdf->Cell(10,5,$akhir_l,1,0,'C',0);
		$pdf->Cell(10,5,$akhir_p,1,0,'C',0);
		$pdf->Cell(10,5,$akhir_jml,1,0,'C',0);
		$pdf->Cell(20,5,'',1,0,'C',0);
		$pdf->Ln();
		}
	while ($rru = mysql_fetch_assoc($qru));




	//awal bulan //////////////////////////////////////////////////////////////////////////////////
	$tgl_awal = "$uthn:$ubln:01";

	//jml. laki2
	$qlkix = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
				"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kel_kd' ".
				"AND m_kelamin.kelamin2 = 'L' ".
				"AND m_siswa_diterima.tgl < '$tgl_awal'");
	$rlkix = mysql_fetch_assoc($qlkix);
	$tlkix = mysql_num_rows($qlkix);


	//jml. perempuan
	$qlki2x = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
				"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kel_kd' ".
				"AND m_kelamin.kelamin2 = 'P' ".
				"AND m_siswa_diterima.tgl < '$tgl_awal'");
	$rlki2x = mysql_fetch_assoc($qlki2x);
	$tlki2x = mysql_num_rows($qlki2x);

	$jml_awalx = round($tlkix+$tlki2x);







	//mutasi masuk ////////////////////////////////////////////////////////////////////////////////
	//jml. laki2
	$qlki3x = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND m_kelamin.kelamin2 = 'L' ".
					"AND round(DATE_FORMAT(m_siswa_diterima.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(m_siswa_diterima.tgl, '%Y')) = '$uthn'");
	$rlki3x = mysql_fetch_assoc($qlki3x);
	$tlki3x = mysql_num_rows($qlki3x);


	//jml. perempuan
	$qlki4x = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND m_kelamin.kelamin2 = 'P' ".
					"AND round(DATE_FORMAT(m_siswa_diterima.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(m_siswa_diterima.tgl, '%Y')) = '$uthn'");
	$rlki4x = mysql_fetch_assoc($qlki4x);
	$tlki4x = mysql_num_rows($qlki4x);

	$jml_mutasi_masukx = round($tlki3x + $tlki4x);





	//mutasi keluar ////////////////////////////////////////////////////////////////////////////////
	//jml. laki2
	$qlki5x = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND m_kelamin.kelamin2 = 'L' ".
					"AND round(DATE_FORMAT(m_siswa_perkembangan.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(m_siswa_perkembangan.tgl, '%Y')) = '$uthn'");
	$rlki5x = mysql_fetch_assoc($qlki5x);
	$tlki5x = mysql_num_rows($qlki5x);


	//jml. perempuan
	$qlki6x = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kel_kd' ".
					"AND m_kelamin.kelamin2 = 'P' ".
					"AND round(DATE_FORMAT(m_siswa_perkembangan.tgl, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(m_siswa_perkembangan.tgl, '%Y')) = '$uthn'");
	$rlki6x = mysql_fetch_assoc($qlki6x);
	$tlki6x = mysql_num_rows($qlki6x);

	$jml_mutasi_keluarx = round($tlki5x + $tlki6x);





	//akhir bulan ////////////////////////////////////////////////////////////////////////////////
	//jml. laki2
	$akhir_lx = round(($tlkix + $tlki3x)-$tlki5x);

	//jml. perempuan
	$akhir_px = round(($tlki2x + $tlki4x)-$tlki6x);

	//jml.akhir
	$akhir_jmlx = round($akhir_lx+$akhir_px);




	$pdf->Cell(15,5,'SUBTOTAL',1,0,'C',1);
	$pdf->Cell(10,5,$tlkix,1,0,'C',1);
	$pdf->Cell(10,5,$tlki2x,1,0,'C',1);
	$pdf->Cell(10,5,$jml_awalx,1,0,'C',1);
	$pdf->Cell(10,5,$tlki3x,1,0,'C',1);
	$pdf->Cell(10,5,$tlki4x,1,0,'C',1);
	$pdf->Cell(10,5,$jml_mutasi_masukx,1,0,'C',1);
	$pdf->Cell(10,5,$tlki5x,1,0,'C',1);
	$pdf->Cell(10,5,$tlki6x,1,0,'C',1);
	$pdf->Cell(10,5,$jml_mutasi_keluarx,1,0,'C',1);
	$pdf->Cell(10,5,$akhir_lx,1,0,'C',1);
	$pdf->Cell(10,5,$akhir_px,1,0,'C',1);
	$pdf->Cell(10,5,$akhir_jmlx,1,0,'C',1);
	$pdf->Cell(20,5,'',1,0,'C',1);
	$pdf->Ln();
	}
while ($rkel = mysql_fetch_assoc($qkel));









//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("perkembangan_siswa_bulanan.pdf",I);
?>