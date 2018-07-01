<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "kkm.php";
$judul = "Setting KKM";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$progkd = nosql($_REQUEST['progkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$mapelkd = nosql($_REQUEST['mapelkd']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//entry KKM
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$progkd = nosql($_POST['progkd']);
	$kelkd = nosql($_POST['kelkd']);
	$mapelkd = nosql($_POST['mapelkd']);
	$nil_kkm = nosql($_POST['nil_kkm']);


	//update
	mysql_query("UPDATE m_mapel_kelas SET kkm = '$nil_kkm' ".
			"WHERE kd_kelas = '$kelkd' ".
			"AND kd_program = '$progkd' ".
			"AND kd_mapel = '$mapelkd' ".
			"AND kd_tapel = '$tapelkd'");


	//re-direct
	$ke = "../index.php?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/menu/admgr.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qdt = mysql_query("SELECT * FROM m_mapel_kelas ".
			"WHERE kd_kelas = '$kelkd' ".
			"AND kd_program = '$progkd' ".
			"AND kd_mapel = '$mapelkd' ".
			"AND kd_tapel = '$tapelkd'");
$rdt = mysql_fetch_assoc($qdt);
$dt_kkm = nosql($rdt['kkm']);



echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<b>'.$tpx_thn1.'/'.$tpx_thn2.'</b>,


Program : ';
//terpilih
$qprgx = mysql_query("SELECT * FROM m_program ".
			"WHERE kd = '$progkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['program']);

echo '<b>'.$prgx_prog.'</b>,


Kelas : ';

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>,

Mata Pelajaran : ';
//terpilih
$qstdx = mysql_query("SELECT * FROM m_mapel ".
			"WHERE kd = '$mapelkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_pel = balikin($rowstdx['pel']);

echo '<strong>'.$stdx_pel.'</strong>
</td>
</tr>
</table>


<p>
Silahkan set KKM-nya :
<br>
<input name="nil_kkm" type="text" value="'.$dt_kkm.'" size="2" maxlength="2" style="text-align:right" onKeyPress="return numbersonly(this, event)">


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="mapelkd" type="hidden" value="'.$mapelkd.'">
<INPUT type="submit" name="btnSMP" value="SIMPAN >>">
</p>


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