<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admtu.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "perkembangan_siswa_bulanan.php";
$tapelkd = nosql($_REQUEST['tapelkd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$ke = "$filenya?tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln";


//judul
$judul = "Data Perkembangan Siswa per Bulan";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;



//focus...
if (empty($tapelkd))
{
$diload = "document.formx.tapel.focus();";
}
else if (empty($ubln))
{
$diload = "document.formx.ublnx.focus();";
}






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admtu.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,

Bulan : ';
echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
{
echo '<p>
<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
</p>';
}
else if (empty($ubln))
{
echo '<p>
<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
</p>';
}
else
{
echo '
<p>
[<a href="perkembangan_siswa_bulanan_pdf.php?tapelkd='.$tapelkd.'&ubln='.$ubln.'&uthn='.$uthn.'"><img src="'.$sumber.'/img/pdf.gif" border="0" width="16" height="16"></a>]
</p>

<TABLE BORDER=1 CELLPADDING=3 CELLSPACING=0>
<TR ALIGN="CENTER" bgcolor="'.$warnaheader.'">
	<TD ROWSPAN=3>
	<strong>KELAS</strong>
	</TD>
	<TD COLSPAN=3>
	<strong>AWAL BULAN</strong>
	</TD>
	<TD COLSPAN=6>
	<strong>MUTASI</strong>
	</TD>
	<TD COLSPAN=3>
	<strong>AKHIR BULAN</strong>
	</TD>
</TR>

<TR ALIGN="CENTER" bgcolor="'.$warnaheader.'">
	<TD ROWSPAN=2>
	<strong>L</strong>
	</TD>
	<TD ROWSPAN=2>
	<strong>P</strong>
	</TD>
	<TD ROWSPAN=2>
	<strong>JML</strong>
	</TD>
	<TD COLSPAN=3>
	<strong>MASUK</strong>
	</TD>
	<TD COLSPAN=3>
	<strong>KELUAR</strong>
	</TD>
	<TD ROWSPAN=2>
	<strong>L</strong>
	</TD>
	<TD ROWSPAN=2>
	<strong>P</strong>
	</TD>
	<TD ROWSPAN=2>
	<strong>JML</strong>
	</TD>
</TR>
<TR ALIGN="CENTER" bgcolor="'.$warnaheader.'">
	<TD>
	<strong>L</strong>
	</TD>
	<TD>
	<strong>P</strong>
	</TD>
	<TD>
	<strong>JML</strong>
	</TD>
	<TD>
	<strong>L</strong>
	</TD>
	<TD>
	<strong>P</strong>
	</TD>
	<TD>
	<strong>JML</strong>
	</TD>
</TR>';


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



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<TD>'.$kel_kelas.'/'.$ru_ruang.'</TD>
		<TD>'.$tlki.'</TD>
		<TD>'.$tlki2.'</TD>
		<TD>'.$jml_awal.'</TD>
		<TD>'.$tlki3.'</TD>
		<TD>'.$tlki4.'</TD>
		<TD>'.$jml_mutasi_masuk.'</TD>
		<TD>'.$tlki5.'</TD>
		<TD>'.$tlki6.'</TD>
		<TD>'.$jml_mutasi_keluar.'</TD>
		<TD>'.$akhir_l.'</TD>
		<TD>'.$akhir_p.'</TD>
		<TD>'.$akhir_jml.'</TD>
		</TR>';
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




	echo '<TD>Subtotal :</TD>
	<TD>'.$tlkix.'</TD>
	<TD>'.$tlki2x.'</TD>
	<TD>'.$jml_awalx.'</TD>
	<TD>'.$tlki3x.'</TD>
	<TD>'.$tlki4x.'</TD>
	<TD>'.$jml_mutasi_masukx.'</TD>
	<TD>'.$tlki5x.'</TD>
	<TD>'.$tlki6x.'</TD>
	<TD>'.$jml_mutasi_keluarx.'</TD>
	<TD>'.$akhir_lx.'</TD>
	<TD>'.$akhir_px.'</TD>
	<TD>'.$akhir_jmlx.'</TD>
	</TR>';
	}
while ($rkel = mysql_fetch_assoc($qkel));



echo '</TABLE>';
}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>