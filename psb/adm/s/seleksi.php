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
$filenya = "seleksi.php";
$judul = "Set Aktif Seleksi";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan	
if ($_POST['btnSMP'])
	{
	//nilai
	$seleksi = nosql($_POST['seleksi']);
	
	//cek
	$qcc = mysql_query("SELECT * FROM psb_set_seleksi");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);
	
	//nek sudah ada, update
	if ($tcc != 0)
		{
		mysql_query("UPDATE psb_set_seleksi SET seleksi = '$seleksi', ".
						"postdate = '$today'");
		}
	else
		{
		mysql_query("INSERT INTO psb_set_seleksi(kd, seleksi, postdate) VALUES ".
						"('$x', '$seleksi', '$today')");
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
$qtsu = mysql_query("SELECT * FROM psb_set_seleksi");
$rtsu = mysql_fetch_assoc($qtsu);
$tsu_seleksi = nosql($rtsu['seleksi']);
$tsu_postdate = $rtsu['postdate'];

//true false
if ($tsu_seleksi == "true")
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
<select name="seleksi">
<option value="'.$tsu_seleksi.'" selected>'.$tsu_status.'</option>
<option value="true">Aktif</option>
<option value="false">Tidak Aktif</option>
</select>
</p>

<p>Terhitung Sejak : <br>
<strong>'.$tsu_postdate.'</strong>
</p>

<p>
<em>NB. Jika Seleksi Telah Aktif, Maka Pendaftaran Otomatis Ditutup.</em>
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