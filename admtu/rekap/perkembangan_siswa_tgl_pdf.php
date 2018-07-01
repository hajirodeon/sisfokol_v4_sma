<?php
//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/perkembangan_siswa_tgl.php");

nocache;


//start class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//nilai
$judul = "Rekap Data : Perkembangan Siswa per Tanggal";
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$utgl2 = nosql($_REQUEST['utgl2']);
$ubln2 = nosql($_REQUEST['ubln2']);
$judulz = $judul;



//isi *START
ob_start();



$pdf->SetFont('Times','',8);
$pdf->SetFillColor(233,233,233);


//header
$pdf->AddPage();
$pdf->Cell(15,15,'TAPEL',1,0,'C',1);
$pdf->Cell(63,5,'AWAL TAHUN PELAJARAN',1,0,'C',1);
$pdf->Cell(63,5,'MUTASI MASUK',1,0,'C',1);
$pdf->Cell(63,5,'MUTASI KELUAR',1,0,'C',1);
$pdf->Cell(63,5,'AKHIR TAHUN PELAJARAN',1,0,'C',1);


$pdf->SetY($pdf->GetY+56);
$pdf->SetX(25);
$pdf->Cell(21,5,'Kelas VII',1,0,'C',1);
$pdf->Cell(21,5,'Kelas VIII',1,0,'C',1);
$pdf->Cell(21,5,'Kelas IX',1,0,'C',1);
$pdf->Cell(21,5,'Kelas VII',1,0,'C',1);
$pdf->Cell(21,5,'Kelas VIII',1,0,'C',1);
$pdf->Cell(21,5,'Kelas IX',1,0,'C',1);
$pdf->Cell(21,5,'Kelas VII',1,0,'C',1);
$pdf->Cell(21,5,'Kelas VIII',1,0,'C',1);
$pdf->Cell(21,5,'Kelas IX',1,0,'C',1);
$pdf->Cell(21,5,'Kelas VII',1,0,'C',1);
$pdf->Cell(21,5,'Kelas VIII',1,0,'C',1);
$pdf->Cell(21,5,'Kelas IX',1,0,'C',1);


$pdf->SetY($pdf->GetY+61);
$pdf->SetX(25);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
$pdf->Cell(7,5,'L',1,0,'C',1);
$pdf->Cell(7,5,'P',1,0,'C',1);
$pdf->Cell(7,5,'JML',1,0,'C',1);
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

	$pdf->Cell(15,5,$kel_tapel,1,0,'C');


	//awal tapel//////////////////////////////////////////////////////////////////////////////////
	$tgl_awal = "$kel_tahun1:$ubln:$utgl";

	//looping kelas
	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"ORDER BY round(no) ASC");
	$rkelx = mysql_fetch_assoc($qkelx);

	do
		{
		//nilai
		$kelx_kd = nosql($rkelx['kd']);


		//jml. laki2
		$qlki = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
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
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'P' ".
					"AND m_siswa_diterima.tgl < '$tgl_awal'");
		$rlki2 = mysql_fetch_assoc($qlki2);
		$tlki2 = mysql_num_rows($qlki2);

		$jml_awal = round($tlki+$tlki2);


		$pdf->Cell(7,5,$tlki,1,0,'C');
		$pdf->Cell(7,5,$tlki2,1,0,'C');
		$pdf->Cell(7,5,$jml_awal,1,0,'C');
		}
	while ($rkelx = mysql_fetch_assoc($qkelx));







	//mutasi masuk ////////////////////////////////////////////////////////////////////////////////
	//looping kelas
	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"ORDER BY round(no) ASC");
	$rkelx = mysql_fetch_assoc($qkelx);

	do
		{
		//nilai
		$kelx_kd = nosql($rkelx['kd']);

		//jml. laki2
		$qlki3 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'L'");
		$rlki3 = mysql_fetch_assoc($qlki3);
		$tlki3 = mysql_num_rows($qlki3);


		//jml. perempuan
		$qlki4 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'P'");
		$rlki4 = mysql_fetch_assoc($qlki4);
		$tlki4 = mysql_num_rows($qlki4);

		$jml_mutasi_masuk = round($tlki3 + $tlki4);


		$pdf->Cell(7,5,$tlki3,1,0,'C');
		$pdf->Cell(7,5,$tlki4,1,0,'C');
		$pdf->Cell(7,5,$jml_mutasi_masuk,1,0,'C');
		}
	while ($rkelx = mysql_fetch_assoc($qkelx));





	//mutasi keluar ////////////////////////////////////////////////////////////////////////////////
	//looping kelas
	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"ORDER BY round(no) ASC");
	$rkelx = mysql_fetch_assoc($qkelx);

	do
		{
		//nilai
		$kelx_kd = nosql($rkelx['kd']);


		//jml. laki2
		$qlki5 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'L'");
		$rlki5 = mysql_fetch_assoc($qlki5);
		$tlki5 = mysql_num_rows($qlki5);


		//jml. perempuan
		$qlki6 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'P'");
		$rlki6 = mysql_fetch_assoc($qlki6);
		$tlki6 = mysql_num_rows($qlki6);

		$jml_mutasi_keluar = round($tlki5 + $tlki6);

		$pdf->Cell(7,5,$tlki5,1,0,'C');
		$pdf->Cell(7,5,$tlki6,1,0,'C');
		$pdf->Cell(7,5,$jml_mutasi_keluar,1,0,'C');
		}
	while ($rkelx = mysql_fetch_assoc($qkelx));






	//akhir tapel ////////////////////////////////////////////////////////////////////////////////
	$tgl_akhir = "$kel_tahun2:$ubln2:$utgl2";

	//looping kelas
	$qkelx = mysql_query("SELECT * FROM m_kelas ".
				"ORDER BY round(no) ASC");
	$rkelx = mysql_fetch_assoc($qkelx);

	do
		{
		//nilai
		$kelx_kd = nosql($rkelx['kd']);

		//jml. laki2
		$qlki = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
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
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'P' ".
					"AND m_siswa_diterima.tgl < '$tgl_awal'");
		$rlki2 = mysql_fetch_assoc($qlki2);
		$tlki2 = mysql_num_rows($qlki2);

		$jml_awal = round($tlki+$tlki2);







		//jml. laki2
		$qlki3 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'L'");
		$rlki3 = mysql_fetch_assoc($qlki3);
		$tlki3 = mysql_num_rows($qlki3);


		//jml. perempuan
		$qlki4 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'P'");
		$rlki4 = mysql_fetch_assoc($qlki4);
		$tlki4 = mysql_num_rows($qlki4);

		$jml_mutasi_masuk = round($tlki3 + $tlki4);






		//jml. laki2
		$qlki5 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'L'");
		$rlki5 = mysql_fetch_assoc($qlki5);
		$tlki5 = mysql_num_rows($qlki5);


		//jml. perempuan
		$qlki6 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
					"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND m_siswa.kd_kelamin = m_kelamin.kd ".
					"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$kel_kd' ".
					"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
					"AND m_kelamin.kelamin2 = 'P'");
		$rlki6 = mysql_fetch_assoc($qlki6);
		$tlki6 = mysql_num_rows($qlki6);

		$jml_mutasi_keluar = round($tlki5 + $tlki6);





		//jml. laki2
		$akhir_l = round(($tlki + $tlki3)-$tlki5);

		//jml. perempuan
		$akhir_p = round(($tlki2 + $tlki4)-$tlki6);

		//jml.akhir
		$akhir_jml = round($akhir_l+$akhir_p);


		$pdf->Cell(7,5,$akhir_l,1,0,'C');
		$pdf->Cell(7,5,$akhir_p,1,0,'C');
		$pdf->Cell(7,5,$akhir_jml,1,0,'C');
		}
	while ($rkelx = mysql_fetch_assoc($qkelx));


	$pdf->Ln();
	}
while ($rkel = mysql_fetch_assoc($qkel));








//isi
$isi = ob_get_contents();
ob_end_clean();


$pdf->WriteHTML($isi);
$pdf->Output("perkembangan_siswa_tgl.pdf",I);
?>