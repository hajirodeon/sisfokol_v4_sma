<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admbp.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "rekap_bulanan.php";
$judul = "Rekap Absensi per Bulan";
$judulku = "[$bk_session : $nip15_session.$nm15_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);


$ke = "$filenya?tapelkd=$tapelkd&ubln=$ubln&uthn=$uthn";



//cacah tapel
$qtpel = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rtpel = mysql_fetch_assoc($qtpel);
$tpel_thn1 = nosql($rtpel['tahun1']);
$tpel_thn2 = nosql($rtpel['tahun2']);






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
require("../../inc/menu/admbp.php");
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

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
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
	echo '<p>
	[<a href="rekap_bulanan_pdf.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$i_rukd.'&ubln='.$ubln.'&uthn='.$uthn.'" target="_blank" title="PRINT..."><img src="'.$sumber.'/img/pdf.gif" width="16" height="16" border="0"></a>].
	</p>';

	//kelas
	$qbt = mysql_query("SELECT * FROM m_kelas ".
				"ORDER BY round(no) ASC");
	$rowbt = mysql_fetch_assoc($qbt);

	do
		{
		$btkd = nosql($rowbt['kd']);
		$btkelas = nosql($rowbt['kelas']);

		echo '<p>
		<table border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'" align="center">
		<td width="50"><strong>KELAS</strong></td>
		<td width="50"><strong>JML.SISWA</strong></td>
		<td width="50"><strong>S</strong></td>
		<td width="50"><strong>I</strong></td>
		<td width="50"><strong>A</strong></td>
		<td width="50"><strong>JUMLAH</strong></td>
		<td width="50"><strong>%</strong></td>
		<td width="50"><strong>Ket.</strong></td>
		</tr>';

		//daftar ruang
		$qru = mysql_query("SELECT * FROM m_ruang ".
					"ORDER BY ruang ASC");
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

			$ru_kd = nosql($rru['kd']);
			$ru_ruang = balikin($rru['ruang']);


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




			echo "<tr valign=\"top\" align=\"center\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$btkelas.'.'.$ru_ruang.'</td>
			<td>'.$tjmu.'</td>
			<td>'.$tjuki.'</td>
			<td>'.$tjuki2.'</td>
			<td>'.$tjuki3.'</td>
			<td>'.$tjuki4.'</td>
			<td>'.$jml_persen.' %</td>
			<td></td>
			</tr>';
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


		echo '<tr bgcolor="'.$warnaheader.'" align="center">
		<td width="50"><strong>Jml/Rata2</strong></td>
		<td width="50"><strong>'.$tjmux.'</strong></td>
		<td width="50"><strong>'.$tjukix.'</strong></td>
		<td width="50"><strong>'.$tjukix2.'</strong></td>
		<td width="50"><strong>'.$tjukix3.'</strong></td>
		<td width="50"><strong>'.$tjukix4.'</strong></td>
		<td width="50"><strong>'.$jml_persenx.'</strong></td>
		<td width="50"></td>
		</tr>
		</table>
		</p>';
		}
	while ($rowbt = mysql_fetch_assoc($qbt));
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