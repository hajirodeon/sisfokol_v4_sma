<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/nota.html");


nocache;

//nilai
$filenya = "siswa_komite_prt.php";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulku = $judul;
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$nis = nosql($_REQUEST['nis']);
$swkd = nosql($_REQUEST['swkd']);
$kelkd = nosql($_REQUEST['kelkd']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa_komite.php?tapelkd=$tapelkd&nis=$nis&swkd=$swkd&kelkd=$kelkd";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">


<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" align="center">
<P>
<big>
<strong><u>BUKTI PEMBAYARAN KOMITE</u></strong>
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
<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="100">
Hari, Tanggal
</td>
<td width="1">:</td>
<td>
<strong>'.$arrhari[$hari].', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
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


//ketahui nilai per bulan
$qnil = mysql_query("SELECT m_uang_komite.*, siswa_kelas.* ".
			"FROM m_uang_komite, siswa_kelas ".
			"WHERE siswa_kelas.kd_tapel = m_uang_komite.kd_tapel ".
			"AND siswa_kelas.kd_kelas = m_uang_komite.kd_kelas ".
			"AND m_uang_komite.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_siswa = '$cc_kd'");
$rnil = mysql_fetch_assoc($qnil);
$tnil = mysql_num_rows($qnil);
$nil_kelkd = nosql($rnil['kd_kelas']);
$nil_progkd = nosql($rnil['kd_program']);
$nil_rukd = nosql($rnil['kd_ruang']);
$nil_uang = nosql($rnil['nilai']);



//kelasnya...
$qkel = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$nil_kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = balikin($rkel['kelas']);



//programnya...
$qpro = mysql_query("SELECT * FROM m_program ".
			"WHERE kd = '$nil_progkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);



//ruangnya...
$qru = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$nil_rukd'");
$rru = mysql_fetch_assoc($qru);
$ru_ruang = balikin($rru['ruang']);



//ketahui bulan yang sedang dibayar
$qswp = mysql_query("SELECT siswa_uang_komite.*, siswa_kelas.* ".
			"FROM siswa_uang_komite, siswa_kelas ".
			"WHERE siswa_kelas.kd_tapel = siswa_uang_komite.kd_tapel ".
			"AND siswa_kelas.kd_kelas = siswa_uang_komite.kd_kelas ".
			"AND siswa_uang_komite.kd_tapel = '$tapelkd' ".
			"AND siswa_uang_komite.kd_siswa = siswa_kelas.kd_siswa ".
			"AND siswa_kelas.kd_siswa = '$cc_kd' ".
			"AND siswa_uang_komite.lunas = 'true' ".
			"AND DATE_FORMAT(tgl_bayar, '%d') = '$tanggal' ".
			"AND DATE_FORMAT(tgl_bayar, '%m') = '$bulan' ".
			"AND DATE_FORMAT(tgl_bayar, '%Y') = '$tahun'");
$rswp = mysql_fetch_assoc($qswp);
$tswp = mysql_num_rows($qswp);


//total uang
$cc_sebesar = $tswp * $nil_uang;


echo '<tr valign="top">
<td valign="top" width="100">
Nama Siswa
</td>
<td width="1">:</td>
<td>
<strong>'.$cc_nama.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Kelas/Program/Ruang
</td>
<td width="1">:</td>
<td>
<strong>'.$kel_kelas.'/'.$pro_program.'/'.$ru_ruang.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Pembayaran
</td>
<td width="1">:</td>
<td>
<strong>Komite</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Jumlah Bulan Yang Dibayar
</td>
<td width="1">:</td>
<td>
<strong>'.$tswp.'</strong> Bulan,
Sebesar :
<strong>'.xduit2($cc_sebesar).'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Bulan
</td>
<td width="1">:</td>
<td>';

do
	{
	//nilai
	$swp_bln = nosql($rswp['bln']);
	$swp_thn = nosql($rswp['thn']);

	echo "<strong>$arrbln[$swp_bln] $swp_thn, </strong>";
	}
while ($rswp = mysql_fetch_assoc($qswp));

echo '</td>
</tr>
</table>
<br>

<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="300" align="center">
</td>
<td valign="top" align="center">
<strong>'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'</strong>
<br>
<br>
<br>
<br>
(<strong>'.$nm8_session.'</strong>)
</td>
</tr>
</table>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$nil_kelkd.'">
<input name="swkd" type="hidden" value="'.$cc_kd.'">
<input name="nis" type="hidden" value="'.$nis.'">
</td>
</tr>
</table>
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