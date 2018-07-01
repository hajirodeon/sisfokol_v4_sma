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
$filenya = "siswa_spi_prt.php";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulku = $judul;
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$nis = nosql($_REQUEST['nis']);
$swkd = nosql($_REQUEST['swkd']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "siswa_spi.php?tapelkd=$tapelkd&nis=$nis&swkd=$swkd";
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
<strong><u>BUKTI PEMBAYARAN UANG SPI</u></strong>
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


//total uang spi
$qpkl = mysql_query("SELECT * FROM m_uang_spi ".
						"WHERE kd_tapel = '$tapelkd'");
$rpkl = mysql_fetch_assoc($qpkl);
$pkl_nilai = nosql($rpkl['nilai']);


//yang sedang dibayar
$qccx1 = mysql_query("SELECT SUM(nilai) AS nilai ".
			"FROM siswa_uang_spi ".
			"WHERE kd_siswa = '$cc_kd' ".
			"AND DATE_FORMAT(tgl_bayar, '%d') = '$tanggal' ".
			"AND DATE_FORMAT(tgl_bayar, '%m') = '$bulan' ".
			"AND DATE_FORMAT(tgl_bayar, '%Y') = '$tahun'");
$rccx1 = mysql_fetch_assoc($qccx1);
$ccx1_nilai = nosql($rccx1['nilai']);


//yang telah dibayar
$qccx2 = mysql_query("SELECT SUM(nilai) AS nilai FROM siswa_uang_spi ".
			"WHERE kd_siswa = '$cc_kd'");
$rccx2 = mysql_fetch_assoc($qccx2);
$ccx2_nilai = nosql($rccx2['nilai']);


//sisa
$nil_sisa = $pkl_nilai - $ccx2_nilai;





//ketahui ruang kelas siswa, yang terakhir
$qske = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
			"FROM siswa_kelas, m_tapel ".
			"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
			"AND siswa_kelas.kd_siswa = '$cc_kd' ".
			"ORDER BY m_tapel.tahun1 DESC");
$rske = mysql_fetch_assoc($qske);
$tske = mysql_num_rows($qske);
$ske_kelkd = nosql($rske['kd_kelas']);
$ske_progkd = nosql($rske['kd_program']);
$ske_rukd = nosql($rske['kd_ruang']);



//programnya...
$qpro = mysql_query("SELECT * FROM m_program ".
			"WHERE kd = '$ske_progkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);



//kelasnya...
$qkel = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$ske_kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = balikin($rkel['kelas']);


//ruangnya...
$qru = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$ske_rukd'");
$rru = mysql_fetch_assoc($qru);
$ru_ruang = balikin($rru['ruang']);


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
Ruang Kelas terakhir
</td>
<td width="1">:</td>
<td>
<strong>'.$kel_kelas.'/'.$pro_program.'/'.$ru_ruang.'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Jumlah Uang Yang Dibayar
</td>
<td width="1">:</td>
<td>
<strong>'.xduit2($ccx1_nilai).'</strong>
</td>
</tr>

<tr valign="top">
<td valign="top" width="100">
Sisa
</td>
<td width="1">:</td>
<td>
<strong>'.xduit2($nil_sisa).'</strong>
</td>
</tr>

</table>
<br>
<br>
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
(<strong>'.$nm8_session.'</strong>)
</td>
</tr>
<table>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$nil_kelkd.'">
<input name="swkd" type="hidden" value="'.$cc_kd.'">
<input name="nis" type="hidden" value="'.$nis.'">
</td>
</tr>
</table>


</td>
</tr>
</table>
<i>Code : '.$today3.'</i>
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