<?php
//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/ledger_nilai.php");

nocache;

//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$rukd = nosql($_REQUEST['rukd']);
$judul = "LEGGER NILAI";



//start class
$pdf=new PDF('L','mm','A3');
$pdf->AliasNbPages();
$pdf->SetTitle($judul);
$pdf->SetAuthor($author);
$pdf->SetSubject($description);
$pdf->SetKeywords($keywords);


//kelas
$qk = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rk = mysql_fetch_assoc($qk);
$rkel = nosql($rk['kelas']);


//program
$qpro = mysql_query("SELECT * FROM m_program ".
			"WHERE kd = '$progkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);


//ruang
$qu = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$rukd'");
$ru = mysql_fetch_assoc($qu);
$rru = balikin($ru['ruang']);
$kelas = "$rkel-$rru";



//tapel
$qtp = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rtp = mysql_fetch_assoc($qtp);
$thn1 = nosql($rtp['tahun1']);
$thn2 = nosql($rtp['tahun2']);
$tapel = "$thn1/$thn2";



//header page /////////////////////////////////////////////////////////////////////////////////////////////////
$batas1 = 8; //jumlah data per halaman

//query
$q = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
			"siswa_kelas.*, siswa_kelas.kd AS skkd ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_program = '$progkd' ".
			"AND siswa_kelas.kd_ruang = '$rukd' ".
			"ORDER BY round(siswa_kelas.no_absen) ASC");
$r = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);
$npage = 0;




//tambah halaman
$pdf->AddPage();

$pdf->SetY(10);
$pdf->SetX(10);
$pdf->Headerku();

$pdf->SetFont('Times','B',18);

//kolom data
$pdf->SetY(40);
$pdf->SetFillColor(233,233,233);
$pdf->SetFont('Times','B',10);
$pdf->Cell(20,40,'NIS',1,0,'C',1);
$pdf->Cell(50,40,'NAMA',1,0,'C',1);

$pdf->GetX();
$nil_jml = $pdf->GetX();
$pdf->Cell(5,40,'',1,0,'L',1);
$pdf->TextWithDirection($nil_jml+3.5,78,'Semester','U');


$pdf->GetX();
$nil_jml = $pdf->GetX();
$pdf->Cell(12,40,'',1,0,'L',1);
$pdf->TextWithDirection($nil_jml+7,78,'Nilai Hasil Belajar','U');



//query
$qpel = mysql_query("SELECT m_mapel.*, m_mapel.kd AS pelkd, m_mapel_kelas.* ".
			"FROM m_mapel, m_mapel_kelas ".
			"WHERE m_mapel_kelas.kd_mapel = m_mapel.kd ".
			"AND m_mapel_kelas.kd_kelas = '$kelkd' ".
			"AND m_mapel_kelas.kd_program = '$progkd' ".
			"AND m_mapel_kelas.kd_tapel = '$tapelkd' ".
			"ORDER BY round(m_mapel.no) ASC, ".
			"round(m_mapel.no_sub) ASC");
$rpel = mysql_fetch_assoc($qpel);
$tpel = mysql_num_rows($qpel);


$pdf->Cell(7*$tpel,7,'Mata Pelajaran',1,0,'C',1);

$pdf->Cell(40,7,'Pengemb.Diri',1,0,'C',1);

$pdf->Cell(21,7,'Kehadiran',1,0,'C',1);

//daftar pribadi
$qpri = mysql_query("SELECT * FROM m_pribadi ".
			"ORDER BY pribadi ASC");
$rpri = mysql_fetch_assoc($qpri);
$tpri = mysql_num_rows($qpri);

$pdf->Cell(7*$tpri,7,'Akhlak Mulia dan Kebribadian',1,0,'C',1);

$pdf->GetX();
$nil_jml = $pdf->GetX();
$pdf->Cell(15,40,'',1,0,'L',1);
$pdf->TextWithDirection($nil_jml+8,78,'Jumlah','U');


$pdf->GetX();
$nil_jml = $pdf->GetX();
$pdf->Cell(7,40,'',1,0,'L',1);
$pdf->TextWithDirection($nil_jml+4.5,78,'Rangking','U');







$pdf->SetY(47);
$pdf->SetX(97);

do
	{
	//nilai
	$pelkd = nosql($rpel['pelkd']);
	$pelno = nosql($rpel['no']);
	$pel = substr(balikin2($rpel['xpel']),0,25);

	$pdf->GetX();
	$nil_jml = $pdf->GetX();
	$pdf->Cell(7,33,'',1,0,'L',1);
	$pdf->TextWithDirection($nil_jml+5,78,$pel,'U');
	}
while ($rpel = mysql_fetch_assoc($qpel));




$pdf->SetY(47);
$pdf->SetX(97+(7*$tpel));
$pdf->Cell(33,33,'Jenis Kegiatan',1,0,'C',1);
$pdf->Cell(7,33,'N',1,0,'C',1);




$qabs = mysql_query("SELECT * FROM m_absensi ".
			"ORDER BY absensi2 DESC");
$rabs = mysql_fetch_assoc($qabs);
$tabs = mysql_num_rows($qabs);

do
	{
	$abs_kd = nosql($rabs['kd']);
	$abs_absensi = balikin($rabs['absensi']);

	$pdf->GetX();
	$nil_jml = $pdf->GetX();
	$pdf->Cell(7,33,'',1,0,'L',1);
	$pdf->TextWithDirection($nil_jml+5,78,$abs_absensi,'U');
	}
while ($rabs = mysql_fetch_assoc($qabs));





do
	{
	$abs_kd = nosql($rpri['kd']);
	$abs_pribadi = balikin($rpri['pribadi']);

	$pdf->GetX();
	$nil_jml = $pdf->GetX();
	$pdf->Cell(7,33,'',1,0,'L',1);
	$pdf->TextWithDirection($nil_jml+5,78,substr($abs_pribadi,0,15),'U');
	}
while ($rpri = mysql_fetch_assoc($qpri));








//query
for ($we=0;$we<=($npage);$we++)
	{
	//nilai
	$page = $we + 1;

	//nek null
	if (empty($we))
		{
		$ken = $we;
		}
	else if ($we == 1)
		{
		$ken = $batas1;
		}
	else
		{
		$ken = $batas1 * $we;
		}








	//kolom nilai /////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->Ln();
	$pdf->SetFont('Times','',8);



	$qx = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
		"siswa_kelas.*, siswa_kelas.kd AS skkd ".
		"FROM m_siswa, siswa_kelas ".
		"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
		"AND siswa_kelas.kd_tapel = '$tapelkd' ".
		"AND siswa_kelas.kd_kelas = '$kelkd' ".
		"AND siswa_kelas.kd_program = '$progkd' ".
		"AND siswa_kelas.kd_ruang = '$rukd' ".
		"ORDER BY round(m_siswa.nis) ASC";
	$qr = $qx;

	$count = mysql_num_rows(mysql_query($qx));
	$result = mysql_query("$qr LIMIT ".$ken.", ".$batas1);
	$data = mysql_fetch_array($result);

	$pdf->SetY(80);
	$pdf->SetX(10);

	do
		{
		//nilai
		$jnspx_skkd = nosql($data['skkd']);
		$jnspx_nis = nosql($data['nis']);
		$jnspx_nama = balikin($data['nama']);
		$pdf->Cell(20,30,$jnspx_nis,1,0,'L');
		$pdf->Cell(50,30,$jnspx_nama,1,0,'L');


		$nil_ku = $pdf->GetY();

		//semester
		for ($i=1;$i<=2;$i++)
			{
			$pdf->SetX(80);
			$pdf->Cell(5,15,$i,1,0,'C');


			//smt
			$qmt = mysql_query("SELECT * FROM m_smt ".
						"WHERE no = '$i'");
			$rmt = mysql_fetch_assoc($qmt);
			$smtkd = balikin($rmt['kd']);




			//nilai pengetahuan ///////////////////////////////////////////////////////
			$pdf->SetX(85);
			$pdf->Cell(12,5,'Peng.',1,0,'L');

			//mapel
			$qpel = mysql_query("SELECT m_mapel.*, m_mapel.kd AS pelkd, m_mapel_kelas.* ".
						"FROM m_mapel, m_mapel_kelas ".
						"WHERE m_mapel_kelas.kd_mapel = m_mapel.kd ".
						"AND m_mapel_kelas.kd_kelas = '$kelkd' ".
						"AND m_mapel_kelas.kd_program = '$progkd' ".
						"AND m_mapel_kelas.kd_tapel = '$tapelkd' ".
						"ORDER BY round(m_mapel.no) ASC, ".
						"round(m_mapel.no_sub) ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);

			do
				{
				//nilai
				$pelkd = nosql($rpel['pelkd']);
				$pel = substr(balikin2($rpel['xpel']),0,25);
				$pdf->SetFont('Times','',8);

				//nilai mapel..
				$qkunil = mysql_query("SELECT * FROM siswa_nilai_mapel ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$pelkd'");
				$rkunil = mysql_fetch_assoc($qkunil);
				$tkunil = mysql_num_rows($qkunil);
				$kunil_nilai = nosql($rkunil['total_kognitif']);



				//nek null
				if (empty($kunil_nilai))
					{
					$kunil_nilai = "-";
					}

				$pdf->Cell(7,5,$kunil_nilai,1,0,'L');
				}
			while ($rpel = mysql_fetch_assoc($qpel));




			//kehadiran siswa /////////////////////////////////////////////////////////
			$pdf->SetX(167+(5*$tpel));
			$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi2 DESC");
			$rabs = mysql_fetch_assoc($qabs);
			$tabs = mysql_num_rows($qabs);

			do
				{
				$abs_kd = nosql($rabs['kd']);
				$abs_absensi2 = balikin($rabs['absensi2']);


				//jml. absensi...
				$qbsi = mysql_query("SELECT * FROM siswa_absensi ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_absensi = '$abs_kd'");
				$rbsi = mysql_fetch_assoc($qbsi);
				$tbsi = mysql_num_rows($qbsi);


				$pdf->Cell(7,5,$tbsi,1,0,'C');
				}
			while ($rabs = mysql_fetch_assoc($qabs));


			//daftar pribadi ///////////////////////////////////////////////////////////
			$qpri = mysql_query("SELECT * FROM m_pribadi ".
						"ORDER BY pribadi ASC");
			$rpri = mysql_fetch_assoc($qpri);
			$tpri = mysql_num_rows($qpri);

			do
				{
				$pri_kd = nosql($rpri['kd']);
				$pri_pribadi = balikin($rpri['pribadi']);

				//pribadinya...
				$qprix = mysql_query("SELECT * FROM siswa_pribadi ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_pribadi = '$pri_kd'");
				$rprix = mysql_fetch_assoc($qprix);
				$tprix = mysql_num_rows($qprix);
				$prix_predikat = nosql($rprix['predikat']);
				$prix_ket = balikin($rprix['ket']);


				$pdf->Cell(7,5,$prix_predikat,1,0,'C');
				}
			while ($rpri = mysql_fetch_assoc($qpri));



			//jumlah total nilai kognitif
			//nilainya...
			$qpelx = mysql_query("SELECT SUM(total_kognitif) AS total ".
						"FROM siswa_nilai_mapel ".
						"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
						"AND kd_smt = '$smtkd'");
			$rpelx = mysql_fetch_assoc($qpelx);
			$total_nilai = nosql($rpelx['total']);
			$pdf->Cell(15,5,$total_nilai,1,0,'C');


			//rangking..
			$qnilx = mysql_query("SELECT * FROM siswa_rangking ".
						"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_program = '$progkd' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_ruang = '$rukd' ".
						"AND kd_smt = '$smtkd'");
			$rnilx = mysql_fetch_assoc($qnilx);
			$tnilx = mysql_num_rows($qnilx);
			$nilx_rangking = nosql($rnilx['rangking']);
			$pdf->Cell(7,5,$nilx_rangking,1,0,'C');


			$pdf->Ln();




			//nilai praktek ///////////////////////////////////////////////////////////
			$pdf->SetX(85);
			$pdf->Cell(12,5,'Praktek',1,0,'L');

			//mapel
			$qpel = mysql_query("SELECT m_mapel.*, m_mapel.kd AS pelkd, m_mapel_kelas.* ".
						"FROM m_mapel, m_mapel_kelas ".
						"WHERE m_mapel_kelas.kd_mapel = m_mapel.kd ".
						"AND m_mapel_kelas.kd_kelas = '$kelkd' ".
						"AND m_mapel_kelas.kd_program = '$progkd' ".
						"AND m_mapel_kelas.kd_tapel = '$tapelkd' ".
						"ORDER BY round(m_mapel.no) ASC, ".
						"round(m_mapel.no_sub) ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);

			do
				{
				//nilai
				$pelkd = nosql($rpel['pelkd']);
				$pel = substr(balikin2($rpel['xpel']),0,25);
				$pdf->SetFont('Times','',8);

				//nilai mapel..
				$qkunil = mysql_query("SELECT * FROM siswa_nilai_mapel ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$pelkd'");
				$rkunil = mysql_fetch_assoc($qkunil);
				$tkunil = mysql_num_rows($qkunil);
				$kunil_nilai = nosql($rkunil['praktek']);



				//nek null
				if (empty($kunil_nilai))
					{
					$kunil_nilai = "-";
					}

				$pdf->Cell(7,5,$kunil_nilai,1,0,'L');
				}
			while ($rpel = mysql_fetch_assoc($qpel));





			//kehadiran siswa /////////////////////////////////////////////////////////
			$pdf->SetX(167+(5*$tpel));
			$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi2 DESC");
			$rabs = mysql_fetch_assoc($qabs);
			$tabs = mysql_num_rows($qabs);

			do
				{
				$abs_kd = nosql($rabs['kd']);
				$abs_absensi2 = balikin($rabs['absensi2']);


				$pdf->Cell(7,5,'-',1,0,'C');
				}
			while ($rabs = mysql_fetch_assoc($qabs));


			//daftar pribadi ///////////////////////////////////////////////////////////
			$qpri = mysql_query("SELECT * FROM m_pribadi ".
						"ORDER BY pribadi ASC");
			$rpri = mysql_fetch_assoc($qpri);
			$tpri = mysql_num_rows($qpri);

			do
				{
				$pri_kd = nosql($rpri['kd']);
				$pri_pribadi = balikin($rpri['pribadi']);


				$pdf->Cell(7,5,'-',1,0,'C');
				}
			while ($rpri = mysql_fetch_assoc($qpri));



			//jumlah total nilai kognitif
			$pdf->Cell(15,5,'-',1,0,'C');


			//rangking..
			$pdf->Cell(7,5,'-',1,0,'C');


			$pdf->Ln();





			//nilai sikap /////////////////////////////////////////////////////////////
			$pdf->SetX(85);
			$pdf->Cell(12,5,'Sikap',1,0,'L');

			//mapel
			$qpel = mysql_query("SELECT m_mapel.*, m_mapel.kd AS pelkd, m_mapel_kelas.* ".
						"FROM m_mapel, m_mapel_kelas ".
						"WHERE m_mapel_kelas.kd_mapel = m_mapel.kd ".
						"AND m_mapel_kelas.kd_kelas = '$kelkd' ".
						"AND m_mapel_kelas.kd_program = '$progkd' ".
						"AND m_mapel_kelas.kd_tapel = '$tapelkd' ".
						"ORDER BY round(m_mapel.no) ASC, ".
						"round(m_mapel.no_sub) ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);

			do
				{
				//nilai
				$pelkd = nosql($rpel['pelkd']);
				$pel = substr(balikin2($rpel['xpel']),0,25);
				$pdf->SetFont('Times','',8);

				//nilai mapel..
				$qkunil = mysql_query("SELECT * FROM siswa_nilai_mapel ".
							"WHERE kd_siswa_kelas = '$jnspx_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$pelkd'");
				$rkunil = mysql_fetch_assoc($qkunil);
				$tkunil = mysql_num_rows($qkunil);
				$kunil_nilai = nosql($rkunil['sikap']);



				//nek null
				if (empty($kunil_nilai))
					{
					$kunil_nilai = "-";
					}

				$pdf->Cell(7,5,$kunil_nilai,1,0,'L');
				}
			while ($rpel = mysql_fetch_assoc($qpel));




			//kehadiran siswa /////////////////////////////////////////////////////////
			$pdf->SetX(167+(5*$tpel));
			$qabs = mysql_query("SELECT * FROM m_absensi ".
						"ORDER BY absensi2 DESC");
			$rabs = mysql_fetch_assoc($qabs);
			$tabs = mysql_num_rows($qabs);

			do
				{
				$abs_kd = nosql($rabs['kd']);
				$abs_absensi2 = balikin($rabs['absensi2']);

				$pdf->Cell(7,5,'-',1,0,'C');
				}
			while ($rabs = mysql_fetch_assoc($qabs));


			//daftar pribadi ///////////////////////////////////////////////////////////
			$qpri = mysql_query("SELECT * FROM m_pribadi ".
						"ORDER BY pribadi ASC");
			$rpri = mysql_fetch_assoc($qpri);
			$tpri = mysql_num_rows($qpri);

			do
				{
				$pri_kd = nosql($rpri['kd']);
				$pri_pribadi = balikin($rpri['pribadi']);

				$pdf->Cell(7,5,'-',1,0,'C');
				}
			while ($rpri = mysql_fetch_assoc($qpri));



			//jumlah total nilai kognitif
			$pdf->Cell(15,5,'-',1,0,'C');


			//rangking..
			$pdf->Cell(7,5,'-',1,0,'C');


			$pdf->Ln();






			//jenis kegiatan /////////////////////////////////////////////////////////
			//mapel
			$qpel = mysql_query("SELECT m_mapel.*, m_mapel.kd AS pelkd, m_mapel_kelas.* ".
						"FROM m_mapel, m_mapel_kelas ".
						"WHERE m_mapel_kelas.kd_mapel = m_mapel.kd ".
						"AND m_mapel_kelas.kd_kelas = '$kelkd' ".
						"AND m_mapel_kelas.kd_program = '$progkd' ".
						"AND m_mapel_kelas.kd_tapel = '$tapelkd' ".
						"ORDER BY round(m_mapel.no) ASC, ".
						"round(m_mapel.no_sub) ASC");
			$rpel = mysql_fetch_assoc($qpel);
			$tpel = mysql_num_rows($qpel);

			$nil_ku = $pdf->GetY();
			$pdf->SetY($nil_ku-15);
			$pdf->SetX(127+(5*$tpel));


			//daftar ekstra yang diikuti
			$qkuti = mysql_query("SELECT siswa_ekstra.*, siswa_ekstra.kd AS sekd, m_ekstra.* ".
						"FROM siswa_ekstra, m_ekstra ".
						"WHERE siswa_ekstra.kd_ekstra = m_ekstra.kd ".
						"AND siswa_ekstra.kd_siswa_kelas = '$jnspx_skkd' ".
						"AND siswa_ekstra.kd_smt = '$smtkd' ".
						"ORDER BY m_ekstra.ekstra ASC LIMIT 0,2");
			$rkuti = mysql_fetch_assoc($qkuti);
			$tkuti = mysql_num_rows($qkuti);


			//jika 2
			if ($tkuti == "2")
				{
				do
					{
					$kuti_kd = nosql($rkuti['sekd']);
					$kuti_ekstra = balikin($rkuti['ekstra']);
					$kuti_predikat = nosql($rkuti['predikat']);

					$pdf->SetX(127+(5*$tpel));
					$pdf->Cell(33,5,"$kuti_ekstra $tkuti",1,0,'C');
					$pdf->Cell(7,5,$kuti_predikat,1,0,'C');
					$pdf->Ln();
					}
				while ($rkuti = mysql_fetch_assoc($qkuti));


				$pdf->SetX(127+(5*$tpel));
				$pdf->Cell(33,5,"-",1,0,'C');
				$pdf->Cell(7,5,"-",1,0,'C');
				$pdf->Ln();
				}

			else if ($tkuti == "1")
				{
				do
					{
					$kuti_kd = nosql($rkuti['sekd']);
					$kuti_ekstra = balikin($rkuti['ekstra']);
					$kuti_predikat = nosql($rkuti['predikat']);

					$pdf->SetX(127+(5*$tpel));
					$pdf->Cell(33,5,"$kuti_ekstra $tkuti",1,0,'C');
					$pdf->Cell(7,5,$kuti_predikat,1,0,'C');
					$pdf->Ln();
					}
				while ($rkuti = mysql_fetch_assoc($qkuti));


				$pdf->SetX(127+(5*$tpel));
				$pdf->Cell(33,5,"-",1,0,'C');
				$pdf->Cell(7,5,"-",1,0,'C');
				$pdf->Ln();
				$pdf->SetX(127+(5*$tpel));
				$pdf->Cell(33,5,"-",1,0,'C');
				$pdf->Cell(7,5,"-",1,0,'C');
				$pdf->Ln();
				}


			else if (empty($tkuti))
				{
				$pdf->SetX(127+(5*$tpel));
				$pdf->Cell(33,5,"-",1,0,'C');
				$pdf->Cell(7,5,"-",1,0,'C');
				$pdf->Ln();
				$pdf->SetX(127+(5*$tpel));
				$pdf->Cell(33,5,"-",1,0,'C');
				$pdf->Cell(7,5,"-",1,0,'C');
				$pdf->Ln();
				$pdf->SetX(127+(5*$tpel));
				$pdf->Cell(33,5,"-",1,0,'C');
				$pdf->Cell(7,5,"-",1,0,'C');
				$pdf->Ln();
				}

			else
				{
				do
					{
					$kuti_kd = nosql($rkuti['sekd']);
					$kuti_ekstra = balikin($rkuti['ekstra']);
					$kuti_predikat = nosql($rkuti['predikat']);

					$pdf->SetX(127+(5*$tpel));
					$pdf->Cell(33,5,"$kuti_ekstra $tkuti",1,0,'C');
					$pdf->Cell(7,5,$kuti_predikat,1,0,'C');
					$pdf->Ln();
					}
				while ($rkuti = mysql_fetch_assoc($qkuti));
				}
			}



		$pdf->SetX(10);
		}
	while ($data = mysql_fetch_assoc($result));
	}




//output-kan ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->Output("legger_nilai.pdf",I);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>