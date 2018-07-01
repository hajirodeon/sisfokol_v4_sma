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
$filenya = "wawancara.php";
$judul = "Set Aktif Wawacara";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan	
if ($_POST['btnSMP'])
	{
	//nilai
	$wawancara = nosql($_POST['wawancara']);
	
	//cek
	$qcc = mysql_query("SELECT * FROM psb_set_wwc");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);
	
	//nek sudah ada, update
	if ($tcc != 0)
		{
		mysql_query("UPDATE psb_set_wwc SET wwc = '$wawancara', ".
						"postdate = '$today'");
		}
	else
		{
		mysql_query("INSERT INTO psb_set_wwc(kd, wwc, postdate) VALUES ".
						"('$x', '$wawancara', '$today')");
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
$qtsu = mysql_query("SELECT * FROM psb_set_wwc");
$rtsu = mysql_fetch_assoc($qtsu);
$tsu_wwc = nosql($rtsu['wwc']);
$tsu_postdate = $rtsu['postdate'];

//true false
if ($tsu_wwc == "true")
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
<select name="wawancara">
<option value="'.$tsu_wwc.'" selected>'.$tsu_status.'</option>
<option value="true">Aktif</option>
<option value="false">Tidak Aktif</option>
</select>
</p>

<p>Terhitung Sejak : <br>
<strong>'.$tsu_postdate.'</strong>
</p>

<p>
<em>NB. Jika Wawancara Telah Aktif, Maka Peserta Didik dapat melakukan Tes Wawancara.</em>
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