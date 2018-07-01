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
$filenya = "jml_siswa_kelas.php";
$judul = "Jumlah Siswa Menurut Kelas";
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
<tr bgcolor="'.$warnaheader.'">
<td width="100"><strong>Tahun Pelajaran</strong></td>';

//kelas
$qkdt = mysql_query("SELECT * FROM m_kelas ".
			"ORDER BY round(no) ASC");
$rkdt = mysql_fetch_assoc($qkdt);
$tkdt = mysql_num_rows($qkdt);

do
	{
	//nilai
	$kdt_kd = nosql($rkdt['kd']);
	$kdt_kelas = balikin($rkdt['kelas']);

	echo '<td width="30"><strong>'.$kdt_kelas.'</strong></td>';
	}
while ($rkdt = mysql_fetch_assoc($qkdt));

echo '</tr>';



//tapel
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"ORDER BY tahun1 ASC");
$rowtpx = mysql_fetch_assoc($qtpx);

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

	$nomer = $nomer + 1;
	$tpx_kd = nosql($rowtpx['kd']);
	$tpx_thn1 = nosql($rowtpx['tahun1']);
	$tpx_thn2 = nosql($rowtpx['tahun2']);



	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td valign="top">
	'.$tpx_thn1.'/'.$tpx_thn2.'
	</td>';

	//kelas
	$qkdt = mysql_query("SELECT * FROM m_kelas ".
				"ORDER BY round(no) ASC");
	$rkdt = mysql_fetch_assoc($qkdt);
	$tkdt = mysql_num_rows($qkdt);

	do
		{
		//nilai
		$i_kd = nosql($rkdt['kd']);
		$i_kelas = balikin($rkdt['kelas']);


		//ketahui jumlahnya
		$qjlx = mysql_query("SELECT * FROM siswa_kelas ".
					"WHERE kd_tapel = '$tpx_kd' ".
					"AND kd_kelas = '$i_kd'");
		$rjlx = mysql_fetch_assoc($qjlx);
		$tjlx = mysql_num_rows($qjlx);


		echo '<td valign="top">
		'.$tjlx.'
		</td>';
		}
	while ($rkdt = mysql_fetch_assoc($qkdt));

	echo '</tr>';
	}
while ($rowtpx = mysql_fetch_assoc($qtpx));

echo '</table>

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