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
$filenya = "siswa_prt.php";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulku = $judul;
$judulx = $judul;
$nis = nosql($_REQUEST['nis']);
$swkd = nosql($_REQUEST['swkd']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa.php?nis=$nis&swkd=$swkd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="500" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">


<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">
<P>
<big>
<strong><u>BUKTI DEBET/KREDIT TABUNGAN</u></strong>
</big>
</P>
<P>
<big>
<strong><u>'.$sek_nama.'</u></strong>
</big>
</P>

<hr height="1">
</td>
</tr>
</table>
<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="200">
Hari, Tanggal
</td>
<td width="1">:</td>
<td>
<strong>'.$arrhari[$hari].', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Nomor Induk
</td>
<td width="1">:</td>
<td>
<strong>'.$nis.'</strong>
</td>
</tr>';

//cek
$qcc = mysql_query("SELECT * FROM m_siswa ".
						"WHERE nis = '$nis'");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);
$cc_kd = nosql($rcc['kd']);
$cc_nama = balikin($rcc['nama']);



//debet/kredit terakhir
$qswu = mysql_query("SELECT * FROM siswa_tabungan ".
						"WHERE kd_siswa = '$swkd' ".
						"ORDER BY postdate DESC");
$rswu = mysql_fetch_assoc($qswu);
$swu_status = nosql($rswu['debet']);
$swu_nilai = nosql($rswu['nilai']);
$swu_saldo_akhir = nosql($rswu['saldo']);


//jika debet
if ($swu_status == "true")
	{
	$x_status = "DEBET";
	}
else
	{
	$x_status = "KREDIT";
	}




//ruang kelas
$qnily = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
			"FROM siswa_kelas, m_tapel ".
			"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
			"AND siswa_kelas.kd_siswa = '$cc_kd' ".
			"ORDER BY m_tapel.tahun1 DESC");
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




echo '<tr valign="top">
<td valign="top" width="200">
Nama Siswa
</td>
<td width="1">:</td>
<td>
<strong>'.$cc_nama.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Kelas/Ruang
</td>
<td width="1">:</td>
<td>
<strong>'.$kel_kelas.'/'.$ru_ruang.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Status
</td>
<td width="1">:</td>
<td>
<strong>'.$x_status.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Jumlah
</td>
<td width="1">:</td>
<td>
<strong>'.xduit2($swu_nilai).'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="200">
Saldo Akhir
</td>
<td width="1">:</td>
<td>
<strong>'.xduit2($swu_saldo_akhir).'</strong>
</td>
</tr>


</table>
<br>
<br>
<br>

<table width="500" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="200" align="center">
</td>
<td valign="top" align="center">
<strong>'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
<br>
<br>
<br>
<br>
<br>
(<strong>'.$nm8_session.'</strong>)
</td>
</tr>
<table>


<input name="swkd" type="hidden" value="'.$cc_kd.'">
<input name="nis" type="hidden" value="'.$nis.'">
</td>
</tr>
</table>

<br>
<br>

</td>
</tr>
</table>
<i>Code : '.$today3.'</i>


</form>
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