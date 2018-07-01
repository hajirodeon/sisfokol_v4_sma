<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admtu.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "jml_pegawai_agama.php";
$judul = "Jumlah Pegawai Menurut Agama";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;







//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/menu/admtu.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table border="1" cellpadding="3" cellspacing="0">
<tr bgcolor="'.$warnaheader.'">';

//agama
$qkdt = mysql_query("SELECT * FROM m_agama ".
			"ORDER BY agama ASC");
$rkdt = mysql_fetch_assoc($qkdt);
$tkdt = mysql_num_rows($qkdt);

do
	{
	//nilai
	$kdt_kd = nosql($rkdt['kd']);
	$kdt_agama = balikin2($rkdt['agama']);

	echo '<td width="50"><strong>'.$kdt_agama.'</strong></td>';
	}
while ($rkdt = mysql_fetch_assoc($qkdt));

echo '</tr>';
echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
//agama
$qkdt = mysql_query("SELECT * FROM m_agama ".
			"ORDER BY agama ASC");
$rkdt = mysql_fetch_assoc($qkdt);
$tkdt = mysql_num_rows($qkdt);

do
	{
	//nilai
	$i_kd = nosql($rkdt['kd']);
	$i_agama = balikin2($rkdt['agama']);


	//ketahui jumlahnya
	$qjlx = mysql_query("SELECT m_pegawai.* ".
				"FROM m_pegawai ".
				"WHERE kd_agama = '$i_kd'");
	$rjlx = mysql_fetch_assoc($qjlx);
	$tjlx = mysql_num_rows($qjlx);


	echo '<td valign="top">
	'.$tjlx.'
	</td>';
	}
while ($rkdt = mysql_fetch_assoc($qkdt));

echo '</tr>
</table>

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