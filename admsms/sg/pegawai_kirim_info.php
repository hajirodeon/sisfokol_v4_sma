<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMA_v4.0_(NyurungBAN)                          ///////
/////// (Sistem Informasi Sekolah untuk SMA)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS	: 081-829-88-54                                 ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsms.php");
$tpl = LoadTpl("../../template/sms.html");

nocache;

//nilai
$filenya = "pegawai_kirim_info.php";
$judul = "Pegawai : Kirim Info";
$judulku = "[$sms_session : $nip17_session. $nm17_session] ==> $judul";
$judulx = $judul;





//kirim sms massal ////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnKRM'])
	{
	//total
	$qdata = mysql_query("SELECT m_pegawai.* ".
				"FROM m_pegawai ".
				"ORDER BY round(nip) ASC");
	$rdata = mysql_fetch_assoc($qdata);
	$tdata = mysql_num_rows($qdata);

	do
		{
		$nomer = $nomer + 1;
		$xyz = md5("$x$nomer");
		$data_swkd = nosql($rdata['kd']);
		$data_swnis = nosql($rdata['nip']);


		//cek punya no.hp
		$qcc = mysql_query("SELECT * FROM sms_nohp_pegawai ".
					"WHERE kd_pegawai = '$data_swkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_nohp = nosql($rcc['nohp']);


		//data info
		$qcc2 = mysql_query("SELECT * FROM sms_pegawai_info");
		$rcc2 = mysql_fetch_assoc($qcc2);
		$tcc2 = mysql_num_rows($qcc2);
		$cc2_info = balikin($rcc2['info']);


		//simpan ke database ///////////////////////////////////////////////////////
		mysql_query("INSERT INTO sms_pegawai_sent (kd, kd_pegawai, info, postdate) VALUES ".
				"('$xyz', '$data_swkd', '$cc2_info', '$today')");


		//kirim sms-nya
		//kirim sms, melalui service mysql khusus gammu
		mysql_query("INSERT INTO outbox (DestinationNumber, TextDecoded, CreatorID, SendingDateTime) VALUES ".
				"('$cc_nohp', '$cc2_info', 'gammu', '$today')");
		}
	while ($rdata = mysql_fetch_assoc($qdata));


	//re-direct
	$pesan = "SMS Dalam Proses Pengiriman. Silahkan cek status pada Outbox.";
	pekem($pesan,$filenya);
	exit();
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();




//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admsms.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">';

//total
$qdata = mysql_query("SELECT m_pegawai.* ".
				"FROM m_pegawai");
$rdata = mysql_fetch_assoc($qdata);
$tdata = mysql_num_rows($qdata);



//query
$qx = mysql_query("SELECT * FROM sms_pegawai_info");
$rowx = mysql_fetch_assoc($qx);
$x_info = balikin2($rowx['info']);


echo '<p>
[Total Pegawai : <strong>'.$tdata.'</strong>].
</p>
<p>
<strong>Info Saat ini :</strong>
<br>
<em>'.$x_info.'</em>. [<a href="pegawai_info.php">EDIT</a>]
</p>

<p>
<INPUT type="submit" name="btnKRM" value="Kirim SMS Sekarang >>">
</p>';


echo '</form>
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