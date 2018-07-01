<?php
session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "backup.php";
$judul = "Backup Database";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;
$s = nosql($_REQUEST['s']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika backup
if ($_POST['btnBK'])
	{
	//require
	require_once("../../inc/class/mysql_backup.php");

	$mysql_dump = new MYSQL_DUMP($xhostname,$xusername,$xpassword);
	$sql = $mysql_dump->dumpDB($xdatabase,HAR_ALL_TABLES, HAR_ALL_OPTIONS);

	if($sql==false)
		echo $mysql_dump->error();

	//dump backup
	$nilx1 = "$tahun$bulan$tanggal";
	$nilx2 = "_$jam$menit$detik";
	$nama_file = "$nilx1$nilx2.sql";
	$mysql_dump->download_sql($sql,$nama_file);


	//selesai...
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/menu/adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Backup Database SISFOKOL, via MySQL Dump.
<br>
<input name="btnBK" type="submit" value="BACKUP Sekarang >>">
</p>
<br>

<p>
NB.
<br>
<em>Jangan lupa, Backup juga folder "/filebox", dengan <strong>copyfolder</strong> secara manual.</em>
</p>
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