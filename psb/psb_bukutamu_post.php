<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_bukutamu_post.php";
$judul = "Tulis Buku Tamu";
$judulku = $judul;



//focus
$diload = "document.formx.nama.focus();";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$nama = cegah2($_POST['nama']);
	$alamat = cegah2($_POST['alamat']);
	$kelamin = nosql($_POST['kelamin']);
	$email = cegah2($_POST['email']);
	$web = cegah2($_POST['web']);
	$komentar = cegah2($_POST['komentar']);
	$ip = nosql($_SERVER['REMOTE_ADDR']);


	//cek null
	if ((empty($nama)) OR (empty($alamat)) OR (empty($komentar)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//entry data
		mysql_query("INSERT INTO psb_buku_tamu(kd, nama, alamat, kelamin, email, web, komentar, ip, postdate) VALUES ".
						"('$x', '$nama', '$alamat', '$kelamin', '$email', '$web', '$komentar', '$ip', '$today')");

		//re-direct
		$pesan = "Terima Kasih Anda Telah Turut Memberikan Saran dan Kritik.";
		$ke = "psb_bukutamu.php";
		pekem($pesan,$ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';
echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="left">
<td width="25%">';
//ambil data menu
require("../inc/menu/psb_menu.php");
echo '</td>

<td align="left">
<big><strong>'.$judul.'</strong></big>
<br>
<a href="psb_bukutamu.php" title="Buku Tamu">Buku Tamu</a> > Tulis Baru
<br>
<br>

Harap Diisi Form Berikut Ini dengan Lengkap :
<br>
Nama :
<br>
<input name="nama" type="text" value="" size="30">
<br>
<br>

Alamat :
<br>
<input name="alamat" type="text" value="" size="50">
<br>
<br>

Kelamin :
<br>
<select name="kelamin">
<option value="" selected></option>
<option value="L">Laki-Laki</option>
<option value="P">Perempuan</option>
</select>
<br>
<br>

E-Mail :
<br>
<input name="email" type="text" value="" size="30">
<br>
<br>

Web :
<br>
<input name="web" type="text" value="" size="30">
<br>
<br>

Komentar :
<br>
<textarea name="komentar" cols="50" rows="5" wrap="virtual"></textarea>
<br>
<br>

IP :
<br>
<strong>'.$_SERVER['REMOTE_ADDR'].'</strong>
<br>
<br>
<input name="btnRST" type="reset" value="BATAL">
<input name="btnSMP" type="submit" value="SIMPAN">
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