<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/window.html");


nocache;

//nilai
$filenya = "siswa_tahunan_spi_prt.php";
$judul = "Laporan Tahunan : Uang SPI";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);



//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa_tahunan_spi.php?tapelkd=$tapelkd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top" align="center">
<td>

<p>
<big>
<strong>LAPORAN TAHUNAN</strong>
</big>
</p>

<p>
<big>
<strong>PEMBAYARAN UANG SPI</strong>
</big>
</p>

<p>
<big>
<strong>'.$sek_nama.'</strong>
</big>
</p>

<p>
<big>
<strong>Tahun Pelajaran '.$tpx_thn1.'/'.$tpx_thn2.'</strong>
</big>
</p>

</td>
</tr>
<table>
<br>
<br>';

for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;
		$ithn = $tpx_thn1;
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;
		$ithn = $tpx_thn2;
		}


	echo '<table width="600" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td><strong><font color="'.$warnatext.'">'.$arrbln[$ibln].' '.$ithn.'</font></strong></td>
	</tr>
	</table>';

	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">NIS</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
	<td width="200" align="center"><strong><font color="'.$warnatext.'">Nominal</font></strong></td>
	</tr>';


	//query bayarnya...
	$qcc1 = mysql_query("SELECT m_siswa.*, ".
				"siswa_uang_spi.kd AS pkd, ".
				"siswa_uang_spi.kd_siswa AS kd_siswa ".
				"FROM siswa_uang_spi, m_siswa ".
				"WHERE siswa_uang_spi.kd_siswa = m_siswa.kd ".
				"AND siswa_uang_spi.kd_tapel = '$tapelkd' ".
				"AND siswa_uang_spi.nilai <> '' ".
				"AND round(DATE_FORMAT(siswa_uang_spi.tgl_bayar, '%m')) = '$ibln' ".
				"AND round(DATE_FORMAT(siswa_uang_spi.tgl_bayar, '%Y')) = '$ithn' ".
				"ORDER BY round(m_siswa.nis) ASC");
	$rcc1 = mysql_fetch_assoc($qcc1);
	$tcc1 = mysql_num_rows($qcc1);

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
		$i_pkd = nosql($rcc1['pkd']);
		$i_swkd = nosql($rcc1['kd_siswa']);
		$i_nis = nosql($rcc1['nis']);
		$i_nama = balikin($rcc1['nama']);


		//jumlah bayar spi
		$qjmx = mysql_query("SELECT * FROM siswa_uang_spi ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND nilai <> '' ".
					"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ibln' ".
					"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ithn' ".
					"AND kd_siswa = '$i_swkd' ".
					"AND kd = '$i_pkd'");
		$rjmx = mysql_fetch_assoc($qjmx);
		$tjmx = mysql_num_rows($qjmx);
		$jmx_nilai = nosql($rjmx['nilai']);


                //ruang kelas
		$qnily = mysql_query("SELECT siswa_uang_spi.*, siswa_kelas.* ".
					"FROM siswa_uang_spi, siswa_kelas ".
					"WHERE siswa_kelas.kd_tapel = siswa_uang_spi.kd_tapel ".
					"AND siswa_uang_spi.kd_tapel = '$tapelkd' ".
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
		<td align="right">'.xduit2($jmx_nilai).'</td>
	   	</tr>';
		}
	while ($rcc1 = mysql_fetch_assoc($qcc1));




	//ketahui jumlah uang spi-nya...
	$qjmx1 = mysql_query("SELECT SUM(nilai) AS total ".
							"FROM siswa_uang_spi ".
							"WHERE kd_tapel = '$tapelkd' ".
							"AND nilai <> '' ".
							"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ibln' ".
							"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$ithn'");
	$rjmx1 = mysql_fetch_assoc($qjmx1);
	$tjmx1 = mysql_num_rows($qjmx1);
	$jmx1_total = nosql($rjmx1['total']);

	echo '<tr bgcolor="'.$warnaover.'">
	<td></td>
	<td></td>
	<td></td>
	<td align="right"><strong>'.xduit2($jmx1_total).'</strong></td>
	</tr>
	</table>
	<br>
	<br>';
	}


//ketahui jumlah uang spi-nya... sebulan
$qjmx2 = mysql_query("SELECT SUM(nilai) AS total ".
			"FROM siswa_uang_spi ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND nilai <> ''");
$rjmx2 = mysql_fetch_assoc($qjmx2);
$tjmx2 = mysql_num_rows($qjmx2);
$jmx2_total = nosql($rjmx2['total']);

echo '<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaover.'">
<td>
Total Nominal Tahun Pelajaran ini : <strong>'.xduit2($jmx2_total).'</strong>
</td>
</tr>
</table>
<br>
<br>
<br>

<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="400" align="center">
</td>

<td valign="top" width="200" align="center">
<p>
<strong>'.$sek_kota.', '.$tanggal.' '.$arrbln[$bulan].' '.$tahun.'</strong>
</p>
<p>
<strong>Bendahara</strong>
<br>
<br>
<br>
<br>
<br>
(<strong>'.$nm8_session.'</strong>)
</p>
</td>
</tr>
<table>


</form>';
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