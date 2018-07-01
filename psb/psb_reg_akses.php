<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_reg_akses.php";
$judul = "Akses User";
$judulku = $judul;
$userkd = nosql($_REQUEST['userkd']);
$noregx = nosql($_REQUEST['noregx']);
$ke = "$filenya?userkd=$userkd&noregx=$noregx";
$dt_pass = $passbaru;
$passbarux = md5($passbaru);

//cek
$qcc = mysql_query("SELECT * FROM psb_m_login ".
						"WHERE kd = '$userkd'");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);

//jika ada, update
if ($tcc != 0)
	{
	//update password...
	mysql_query("UPDATE psb_m_login SET password = '$passbarux' ".
					"WHERE kd = '$userkd'");
	}
else
	{
	//insert
	mysql_query("INSERT INTO psb_m_login(kd, username, password, nama, level) VALUES ".
					"('$userkd', '$noregx', '$passbarux', 'calon', '4')");
	}







//isi *START
ob_start();

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//data
$qdt = mysql_query("SELECT * FROM psb_m_login ".
						"WHERE kd = '$userkd' ".
						"AND username = '$noregx'");
$rdt = mysql_fetch_assoc($qdt);
$dt_user = nosql($rdt['username']);


echo '<form action="'.$ke.'" method="post" name="formx">';
echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="left">
<td width="25%">';
//ambil data menu
require("../inc/menu/psb_menu.php");
echo '</td>

<td align="left">
<big><strong>'.$judul.'</strong></big>
<p>
Berikut akses login anda :
</p>

<p>
<strong>Username :</strong>
<br>
<input name="username" type="text" value="'.$dt_user.'" size="20" class="input" readonly>
</p>

<p>
<strong>Password :</strong>
<br>
<input name="password" type="text" value="'.$dt_pass.'" size="20" class="input" readonly>
</p>

<br>
<br>
<br>
<strong>NB.</strong>
<br>
<UL>
<LI>Akses Login ini bisa langsung dipakai.

<LI>Sedangkan untuk Seleksi Penerimaan Peserta Didik Baru, Bisa Diikuti setelah melakukan pembayaran atau transfer biaya pendaftaran.
</UL>
<br>
Terima Kasih.
<br>

[<a href="index.php">Kembali ke Halaman Utama</a>].
</td>
</tr>
</table>
</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>