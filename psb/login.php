<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "login.php";
$judul = "Login";
$judulku = $judul;
$diload = "document.formx.tipe.focus();";
$pesan = "PASSWORD SALAH. HARAP DIULANGI...!!!";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//ambil nilai
	$tipe = nosql($_POST["tipe"]);
	$username = nosql($_POST["usernamex"]);
	$password = md5(nosql($_POST["passwordx"]));

	//cek null
	if ((empty($tipe)) OR (empty($username)) OR (empty($password)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//jika tp01 --> Administrator .......................................................................
		if ($tipe == "tp01")
			{
			//query
			$q = mysql_query("SELECT * FROM psb_m_login ".
								"WHERE level = '1' ".
								"AND username = '$username' ".
								"AND password = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd1_session'] = nosql($row['kd']);
				$_SESSION['username1_session'] = $username;
				$_SESSION['adm_session'] = "Administrator";

				//re-direct
				$ke = "adm/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp02 --> Bendahara ...........................................................................
		if ($tipe == "tp02")
			{
			//query
			$q = mysql_query("SELECT * FROM psb_m_login ".
								"WHERE level = '2' ".
								"AND username = '$username' ".
								"AND password = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd2_session'] = nosql($row['kd']);
				$_SESSION['username2_session'] = $username;
				$_SESSION['bdh_session'] = "Bendahara";

				//re-direct
				$ke = "admbdh/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp03 --> Pewawancara .........................................................................
		if ($tipe == "tp03")
			{
			//query
			$q = mysql_query("SELECT * FROM psb_m_login ".
								"WHERE level = '3' ".
								"AND username = '$username' ".
								"AND password = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd3_session'] = nosql($row['kd']);
				$_SESSION['username3_session'] = $username;
				$_SESSION['wwc_session'] = "Pewawancara";

				//re-direct
				$ke = "admwwc/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................





		//jika tp04 --> calon ...............................................................................
		if ($tipe == "tp04")
			{
			//query
			$q = mysql_query("SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
								"psb_siswa_calon.no_daftar AS scno, ".
								"psb_siswa_calon.nama AS scnama, ".
								"psb_m_login.* ".
								"FROM psb_siswa_calon, psb_m_login ".
								"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
								"AND psb_m_login.level = '4' ".
								"AND psb_m_login.username = '$username' ".
								"AND psb_m_login.password = '$password'");
			$row = mysql_fetch_assoc($q);
			$total = mysql_num_rows($q);

			//cek login
			if ($total != 0)
				{
				session_start();

				//nilai
				$_SESSION['kd4_session'] = nosql($row['sckd']);
				$_SESSION['no4_session'] = nosql($row['scno']);
				$_SESSION['nama4_session'] = nosql($row['scnama']);
				$_SESSION['username4_session'] = $username;
				$_SESSION['ppd_session'] = "Calon";

				//re-direct
				$ke = "ppd/index.php";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				pekem($pesan, $filenya);
				exit();
				}
			}
		//...................................................................................................
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


<TABLE WIDTH=400 BORDER=0 CELLPADDING=0 CELLSPACING=0>
<TR>
<TD>
<IMG SRC="'.$sumber.'/img/login_01.gif" WIDTH=17 HEIGHT=17 ALT="">
</TD>
<TD COLSPAN=2>
<IMG SRC="'.$sumber.'/img/login_02.gif" WIDTH=366 HEIGHT=17 ALT="">
</TD>
<TD>
<IMG SRC="'.$sumber.'/img/login_03.gif" WIDTH=17 HEIGHT=17 ALT="">
</TD>
</TR>
<TR>
<TD>
<IMG SRC="'.$sumber.'/img/login_04.gif" WIDTH=17 HEIGHT=226 ALT="">
</TD>
<TD>
<IMG SRC="'.$sumber.'/img/login_05.gif" WIDTH=203 HEIGHT=226 ALT="">
</TD>
<TD background="'.$sumber.'/img/login_06.gif">


Tipe :
<br>
<select name="tipe">
<option value="" selected></option>
<option value="tp01">Administrator</option>
<option value="tp02">Bendahara</option>
<option value="tp03">Pewawancara</option>
<option value="tp04">Calon</option>
</select>
<br>
<br>

Username :
<br>
<input name="usernamex" type="text" size="10" maxlength="15">
<br>
<br>

Password :
<br>
<input name="passwordx" type="password" size="10" maxlength="15">
<br>
<br>

<input name="btnBTL" type="reset" value="BATAL">
<input name="btnOK" type="submit" value="OK &gt;&gt;&gt;">


</TD>
<TD>
<IMG SRC="'.$sumber.'/img/login_07.gif" WIDTH=17 HEIGHT=226 ALT="">
</TD>
</TR>
<TR>
<TD>
<IMG SRC="'.$sumber.'/img/login_08.gif" WIDTH=17 HEIGHT=49 ALT="">
</TD>
<TD>
<IMG SRC="'.$sumber.'/img/login_09.gif" WIDTH=203 HEIGHT=49 ALT="">
</TD>
<TD>
<IMG SRC="'.$sumber.'/img/login_10.gif" WIDTH=163 HEIGHT=49 ALT="">
</TD>
<TD>
<IMG SRC="'.$sumber.'/img/login_11.gif" WIDTH=17 HEIGHT=49 ALT="">
</TD>
</TR>
</TABLE>





</td>
</tr>
</table>
</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>