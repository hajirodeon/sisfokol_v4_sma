<?php
session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsms.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pass.php";
$diload = "document.formx.passlama.focus();";
$judul = "Ganti Password";
$judulku = "[$sms_session : $nip17_session. $nm17_session] ==> $judul";
$juduli = $judul;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$passlama = md5(nosql($_POST["passlama"]));
	$passbaru = md5(nosql($_POST["passbaru"]));
	$passbaru2 = md5(nosql($_POST["passbaru2"]));

	//cek null
	if ((empty($passlama)) OR (empty($passbaru)) OR (empty($passbaru2)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	//nek pass baru, gak sama.
	else if ($passbaru != $passbaru2)
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Password Baru Tidak Sama. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		$q = mysql_query("SELECT * FROM m_pegawai ".
					"WHERE kd = '$kd17_session' ".
					"AND usernamex = '$username17_session' ".
					"AND passwordx = '$passlama'");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);

		//cek
		if ($total != 0)
			{
			//perintah SQL
			mysql_query("UPDATE m_pegawai SET passwordx = '$passbaru' ".
					"WHERE kd = '$kd17_session' ".
					"AND usernamex = '$username17_session'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//auto-kembali
			$pesan = "PASSWORD BERHASIL DIGANTI.";
			$ke = "../index.php";
			pekem($pesan, $ke);
			exit();
			}
		else
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "PASSWORD LAMA TIDAK COCOK. HARAP DIULANGI...!!!";
			pekem($pesan, $filenya);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//js
require("../../inc/menu/admsms.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>Password Lama : <br>
<input name="passlama" type="password" size="15">
</p>
<p>Password Baru : <br>
<input name="passbaru" type="password" size="15">
</p>
<p>RE-Password Baru : <br>
<input name="passbaru2" type="password" size="15">
</p>
<p>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="reset" value="BATAL">
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