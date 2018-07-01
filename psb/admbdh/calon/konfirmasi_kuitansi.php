<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_admbdh.php"); 
$tpl = LoadTpl("../../../template/print.html"); 

nocache;

//nilai
$filenya = "konfirmasi_kuitansi.php";
$judul = "Kuitansi";
$judulku = "[$bdh_session] ==> $judul";
$judulx = $judul;
$swkd = nosql($_REQUEST['swkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "konfirmasi.php?page=$page";
$diload = "window.print();location.href='$ke';";




//detail
$qdt = mysql_query("SELECT * FROM psb_siswa_calon ".
						"WHERE kd = '$swkd'");
$rdt = mysql_fetch_assoc($qdt);
$dt_no = nosql($rdt['no_daftar']);
$dt_nama = balikin($rdt['nama']);



//isi *START
ob_start();



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';


//looping kuitansi
for($i=1;$i<=2;$i++)
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr bgcolor="#CCCCCC">
	<td align="center"><big><strong>'.$judul.'</strong></big></td>
	</tr>
	</table>';
	
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="200" align="center">
	No. Pendaftaran :
	<br>
	<strong>'.$dt_no.'</strong>
	</td>
	
	<td>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr valign="top">
	<td width="150">
	Telah Diterima Dari 
	</td>
	<td width="10">:</td>
	<td><strong>'.$dt_nama.'</strong></td>
	</tr>
	<tr valign="top">
	<td>
	Uang Sebesar 
	</td>
	<td>:</td>
	<td>
	<em>';
	xongkof($psb_biaya);
	echo '</em>
	</td>
	</tr>
	<tr valign="top">
	<td>
	Untuk Pembayaran
	</td>
	<td>:</td>
	<td>
	<em>Biaya Pendaftaran Calon Siswa Baru '.$sek_nama.', </em>	
	<br>
	<em>Atas Nama : <strong>'.$dt_nama.'</strong></em>
	</td>
	</tr>
	</table>
	
	<br>
	<br>
	<br>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td valign="bottom">
	Terbilang : <strong>';
	xduit($psb_biaya);
	echo '</strong>
	</td>
	
	<td align="center">
	'.$sek_kota.', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'
	<br>
	<br>
	Petugas Pendaftaran
	<br>
	<br>
	<br>
	'.$psb_petugas.'
	</td>
	</tr>
	</table>

	</td>
	</tr>
	</table>
	<hr>
	<br>
	<br>';
	}



echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>