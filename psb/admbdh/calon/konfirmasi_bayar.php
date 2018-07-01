<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_admbdh.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "konfirmasi_bayar.php";
$judul = "Pembayaran";
$judulku = "[$bdh_session] ==> $judul";
$judulx = $judul;
$swkd = nosql($_REQUEST['swkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batal
if ($_POST['btnBTL'])
	{
	//ambil nilai
	$page = nosql($_POST['page']);
	
	//re-direct
	$ke = "konfirmasi.php?page=$page";	
	xloc($ke);
	exit();
	}





//aktifkan
if ($_POST['btnOK'])
	{
	//ambil nilai
	$page = nosql($_POST['page']);
	$swkd = nosql($_POST['swkd']);
	
	//update
	mysql_query("UPDATE psb_siswa_calon SET status_daftar = 'true' ".
					"WHERE kd = '$swkd'");	
	
	//re-direct
	$ke = "konfirmasi.php?page=$page";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_admbdh.php"); 
xheadline($judul);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qdt = mysql_query("SELECT DATE_FORMAT(tgl_daftar, '%d') AS dtgl, ".
						"DATE_FORMAT(tgl_daftar, '%m') AS dbln, ".
						"DATE_FORMAT(tgl_daftar, '%Y') AS dthn, ".
						"DATE_FORMAT(tgl_bayar, '%d') AS btgl, ".
						"DATE_FORMAT(tgl_bayar, '%m') AS bbln, ".
						"DATE_FORMAT(tgl_bayar, '%Y') AS bthn, ".
						"psb_siswa_calon.* ".
						"FROM psb_siswa_calon ".
						"WHERE kd = '$swkd'");
$rdt = mysql_fetch_assoc($qdt);
$dt_noregx = nosql($rdt['no_daftar']);
$dt_nama = balikin($rdt['nama']);
$dt_jml_bayar = nosql($rdt['jml_bayar']);

//tgl daftar
$dt_dtgl = nosql($rdt['dtgl']);
$dt_dbln = nosql($rdt['dbln']);
$dt_dthn = nosql($rdt['dthn']);

//tgl bayar
$dt_btgl = nosql($rdt['btgl']);
$dt_bbln = nosql($rdt['bbln']);
$dt_bthn = nosql($rdt['bthn']);


echo '<form action="'.$filenya.'" method="post" name="formx">
<a href="konfirmasi.php">Data Konfirmasi</a> > Pembayaran
<br>
<br>

No. Pendaftaran : 
<br>
<strong>'.$dt_noregx.'</strong>
<br>
<br>

Nama : 
<br>
<strong>'.$dt_nama.'</strong>
<br>
<br>

Tanggal Pendaftaran : 
<br>
<strong>'.$dt_dtgl.' '.$arrbln1[$dt_dbln].' '.$dt_dthn.'</strong>
<br>
<br>
<br>
<br>

<strong>PEMBAYARAN :</strong>
<br>
Tanggal Pembayaran : 
<br>
<strong>'.$dt_btgl.' '.$arrbln1[$dt_bbln].' '.$dt_bthn.'</strong>
<br>
<br>

Jumlah Yang Telah Ditransfer : 
<br>
<strong>'.xduit2($dt_jml_bayar).'</strong>
<br>
<br>
<input name="page" type="hidden" value="'.$page.'">
<input name="swkd" type="hidden" value="'.$swkd.'">
<input name="btnBTL" type="submit" value="BATAL">
<input name="btnOK" type="submit" value="SIMPAN & Aktifkan">
</form>
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