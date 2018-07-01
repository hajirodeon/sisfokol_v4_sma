<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_harian_komite.php";
$judul = "Laporan Harian : Uang Komite";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);

$ke = "$filenya?tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln&utgl=$utgl";



//focus...
if (empty($tapelkd))
{
$diload = "document.formx.tapel.focus();";
}
else if (empty($utgl))
{
$diload = "document.formx.utglx.focus();";
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
require("../../inc/menu/admbdh.php");
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

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tanggal : ';
echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&utgl='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

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
else if (empty($utgl))
{
echo '<p>
<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!</strong></font>
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


//query
$qcc = mysql_query("SELECT DISTINCT(siswa_uang_komite.kd_siswa) AS kd_siswa, ".
						"m_siswa.* ".
						"FROM siswa_uang_komite, m_siswa ".
						"WHERE siswa_uang_komite.kd_siswa = m_siswa.kd ".
						"AND siswa_uang_komite.kd_tapel = '$tapelkd' ".
						"AND siswa_uang_komite.nilai <> '' ".
						"AND siswa_uang_komite.lunas = 'true' ".
						"AND round(DATE_FORMAT(siswa_uang_komite.tgl_bayar, '%d')) = '$utgl' ".
						"AND round(DATE_FORMAT(siswa_uang_komite.tgl_bayar, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(siswa_uang_komite.tgl_bayar, '%Y')) = '$uthn' ".
						"ORDER BY round(m_siswa.nis) ASC");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);


//jika ada
if ($tcc != 0)
{
echo '<br>
[<a href="siswa_harian_komite_prt.php?tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'"><img src="'.$sumber.'/img/print.gif" border="0" width="16" height="16"></a>]
<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Kelas</font></strong></td>
<td width="10" align="center"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
<td width="200" align="center"><strong><font color="'.$warnatext.'">Nominal</font></strong></td>
</tr>';

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

	$i_nomer = $i_nomer + 1;
	$i_swkd = nosql($rcc['kd_siswa']);
	$i_nis = nosql($rcc['nis']);
	$i_nama = balikin($rcc['nama']);


	//jumlah bayar komite
	$qjmx = mysql_query("SELECT * FROM siswa_uang_komite ".
				"WHERE kd_tapel = '$tapelkd' ".
				"AND nilai <> '' ".
				"AND lunas = 'true' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$utgl' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn' ".
				"AND kd_siswa = '$i_swkd'");
	$rjmx = mysql_fetch_assoc($qjmx);
	$tjmx = mysql_num_rows($qjmx);


	//ketahui jumlah uang komite-nya...
	$qjmx1 = mysql_query("SELECT SUM(nilai) AS total ".
				"FROM siswa_uang_komite ".
				"WHERE kd_tapel = '$tapelkd' ".
				"AND nilai <> '' ".
				"AND lunas = 'true' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$utgl' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn' ".
				"AND kd_siswa = '$i_swkd'");
	$rjmx1 = mysql_fetch_assoc($qjmx1);
	$tjmx1 = mysql_num_rows($qjmx1);
	$jmx1_total = nosql($rjmx1['total']);



	//ruang kelas
	$qnily = mysql_query("SELECT m_uang_lain.*, siswa_kelas.* ".
				"FROM m_uang_lain, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = m_uang_lain.kd_tapel ".
				"AND siswa_kelas.kd_kelas = m_uang_lain.kd_kelas ".
				"AND m_uang_lain.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_siswa = '$i_swkd'");
	$rnily = mysql_fetch_assoc($qnily);
	$tnily = mysql_num_rows($qnily);
	$nily_kelkd = nosql($rnily['kd_kelas']);
	$nily_rukd = nosql($rnily['kd_ruang']);



	//kelasnya...
	$qkel = mysql_query("SELECT * FROM m_kelas ".
				"WHERE kd = '$nily_kelkd'");
	$rkel = mysql_fetch_assoc($qkel);
	$kel_kelas = balikin($rkel['kelas']);


	//ruangnya...
	$qru = mysql_query("SELECT * FROM m_ruang ".
				"WHERE kd = '$nily_rukd'");
	$rru = mysql_fetch_assoc($qru);
	$ru_ruang = balikin($rru['ruang']);



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$i_nis.'</td>
	<td>'.$i_nama.'</td>
	<td>'.$kel_kelas.'/'.$ru_ruang.'</td>
	<td align="right">'.$tjmx.'</td>
	<td align="right">'.xduit2($jmx1_total).'</td>
   	</tr>';
	}
while ($rcc = mysql_fetch_assoc($qcc));


//jumlah bayar komite
$qjmx = mysql_query("SELECT * FROM siswa_uang_komite ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND nilai <> '' ".
			"AND lunas = 'true' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$utgl' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
$rjmx = mysql_fetch_assoc($qjmx);
$tjmx = mysql_num_rows($qjmx);


//ketahui jumlah uang komite-nya...
$qjmx1 = mysql_query("SELECT SUM(nilai) AS total ".
			"FROM siswa_uang_komite ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND nilai <> '' ".
			"AND lunas = 'true' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$utgl' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
			"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
$rjmx1 = mysql_fetch_assoc($qjmx1);
$tjmx1 = mysql_num_rows($qjmx1);
$jmx1_total = nosql($rjmx1['total']);

echo '<tr bgcolor="'.$warnaover.'">
<td></td>
<td></td>
<td></td>
<td align="right"><strong>'.$tjmx.'</strong></td>
<td align="right"><strong>'.xduit2($jmx1_total).'</strong></td>
</tr>
</table>';
}
else
{
echo '<p>
<font color="red">
<strong>Tidak Ada Data</strong>
</font>
</p>';
}



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