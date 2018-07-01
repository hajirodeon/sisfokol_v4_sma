<?php 



session_start();

//ambil nilai
require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "mapel.php";
$judul = "Set Aktif Ujian MaPel";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan	
if ($_POST['btnSMP'])
	{
	//nilai
	$mapel = nosql($_POST['mapel']);
	
	//cek
	$qcc = mysql_query("SELECT * FROM psb_set_mapel");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);
	
	//nek sudah ada, update
	if ($tcc != 0)
		{
		mysql_query("UPDATE psb_set_mapel SET mapel = '$mapel', ".
						"postdate = '$today'");
		}
	else
		{
		mysql_query("INSERT INTO psb_set_mapel(kd, mapel, postdate) VALUES ".
						"('$x', '$mapel', '$today')");
		}	
	
	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//js
require("../../../inc/menu/psb_adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//status
$qtsu = mysql_query("SELECT * FROM psb_set_mapel");
$rtsu = mysql_fetch_assoc($qtsu);
$tsu_mapel = nosql($rtsu['mapel']);
$tsu_postdate = $rtsu['postdate'];

//true false
if ($tsu_mapel == "true")
	{
	$tsu_status = "AKTIF";
	}
else
	{
	$tsu_status = "TIDAK Aktif";
	}

//null postdate
if (empty($tsu_postdate))
	{
	$tsu_postdate = "-";
	}

echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
<select name="mapel">
<option value="'.$tsu_mapel.'" selected>'.$tsu_status.'</option>
<option value="true">Aktif</option>
<option value="false">Tidak Aktif</option>
</select>
</p>

<p>Terhitung Sejak : <br>
<strong>'.$tsu_postdate.'</strong>
</p>

<p>
<em>NB. Jika Ujian Mata Pelajaran Telah Aktif, Maka Peserta Didik dapat melakukan Ujian Mata Pelajaran.</em>
</p>
<p> 
<input name="btnSMP" type="submit" value="SIMPAN">
</p>
</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>