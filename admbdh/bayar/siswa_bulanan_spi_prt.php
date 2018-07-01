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
$filenya = "siswa_bulanan_spi_prt.php";
$judul = "Laporan Bulanan : Uang SPI";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa_bulanan_spi.php?tapelkd=$tapelkd&uthn=$uthn&ubln=$ubln";
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
<strong>LAPORAN BULANAN</strong>
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
<strong>Per '.$arrbln1[$bulan].' '.$tahun.'</strong>
</big>
</p>

</td>
</tr>
<table>
<br>
<br>';

//mendapatkan jumlah tanggal maksimum dalam suatu bulan
$tgl = 0;
$bulan = $ubln;
$bln = $bulan + 1;
$thn = $uthn;

$lastday = mktime (0,0,0,$bln,$tgl,$thn);

//total tanggal dalam sebulan
$tkhir = strftime ("%d", $lastday);

//lopping tgl
for ($i=1;$i<=$tkhir;$i++)
	{
	//ketahui harinya
	$day = $i;
	$month = $bulan;
	$year = $thn;


	//mencari hari
	$a = substr($year, 2);
		//mengambil dua digit terakhir tahun

	$b = (int)($a/4);
		//membagi tahun dengan 4 tanpa memperhitungkan sisa

	$c = $month;
		//mengambil angka bulan

	$d = $day;
		//mengambil tanggal

	$tot1 = $a + $b + $c + $d;
		//jumlah sementara, sebelum dikurangani dengan angka kunci bulan

	//kunci bulanan
	if ($c == 1)
		{
		$kunci = "2";
		}

	else if ($c == 2)
		{
		$kunci = "7";
		}

	else if ($c == 3)
		{
		$kunci = "1";
		}

	else if ($c == 4)
		{
		$kunci = "6";
		}

	else if ($c == 5)
		{
		$kunci = "5";
		}

	else if ($c == 6)
		{
		$kunci = "3";
		}

	else if ($c == 7)
		{
		$kunci = "2";
		}

	else if ($c == 8)
		{
		$kunci = "7";
		}

	else if ($c == 9)
		{
		$kunci = "5";
		}

	else if ($c == 10)
		{
		$kunci = "4";
		}

	else if ($c == 11)
		{
		$kunci = "2";
		}

	else if ($c == 12)
		{
		$kunci = "1";
		}

	$total = $tot1 - $kunci;

	//angka hari
	$hari = $total%7;

	//jika angka hari == 0, sebenarnya adalah 7.
	if ($hari == 0)
		{
		$hari = ($hari +7);
		}

	//kabisat, tahun habis dibagi empat alias tanpa sisa
	$kabisat = (int)$year % 4;

	if ($kabisat ==0)
		{
		$hri = $hri-1;
		}



	//hari ke-n
	if ($hari == 3)
		{
		$hri = 4;
		$dino = "Rabu";
		}

	else if ($hari == 4)
		{
		$hri = 5;
		$dino = "Kamis";
		}

	else if ($hari == 5)
		{
		$hri = 6;
		$dino = "Jum'at";
		}

	else if ($hari == 6)
		{
		$hri = 7;
		$dino = "Sabtu";
		}

	else if ($hari == 7)
		{
		$hri = 1;
		$dino = "Minggu";
		}

	else if ($hari == 1)
		{
		$hri = 2;
		$dino = "Senin";
		}

	else if ($hari == 2)
		{
		$hri = 3;
		$dino = "Selasa";
		}


	//nek minggu, abang ngi wae
	if ($hri == 1)
		{
		$warna = "red";
		$mggu_attr = "disabled";
		}
	else
		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			$mggu_attr = "";
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			$mggu_attr = "";
			}
		}

	//nilai tanggal
	$i_tgl_bayar = "$dino, $i $arrbln[$ubln] $uthn";


	echo '<table width="600" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td><strong><font color="'.$warnatext.'">'.$i_tgl_bayar.'</font></strong></td>
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
				"AND round(DATE_FORMAT(siswa_uang_spi.tgl_bayar, '%d')) = '$i' ".
				"AND round(DATE_FORMAT(siswa_uang_spi.tgl_bayar, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(siswa_uang_spi.tgl_bayar, '%Y')) = '$uthn' ".
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
					"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$i' ".
					"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn' ".
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
							"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$i' ".
							"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
							"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
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
						"AND nilai <> '' ".
						"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
$rjmx2 = mysql_fetch_assoc($qjmx2);
$tjmx2 = mysql_num_rows($qjmx2);
$jmx2_total = nosql($rjmx2['total']);

echo '<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaover.'">
<td>
Total Nominal Bulan ini : <strong>'.xduit2($jmx2_total).'</strong>
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