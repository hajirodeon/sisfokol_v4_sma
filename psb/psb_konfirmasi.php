<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_konfirmasi.php";
$judul = "Konfirmasi Pembayaran Calon Peserta Didik";
$judulku = $judul;
$diload = "document.formx.no_reg.focus();";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//nilai
	$no_reg = nosql($_POST['no_reg']);
	$nama = cegah($_POST['nama']);
	$jml_transfer = nosql($_POST['jml_transfer']);

	//tgl pendaftaran
	$dtgl = nosql($_POST['dtgl']);
	$dbln = nosql($_POST['dbln']);
	$dthn = nosql($_POST['dthn']);
	$tgl_daftar = "$dthn:$dbln:$dtgl";

	//tgl bayar
	$btgl = nosql($_POST['btgl']);
	$bbln = nosql($_POST['bbln']);
	$bthn = nosql($_POST['bthn']);
	$tgl_bayar = "$bthn:$bbln:$btgl";

	//cek
	$qcc = mysql_query("SELECT * FROM psb_siswa_calon ".
							"WHERE no_daftar = '$no_reg' ".
							"AND nama = '$nama' ".
							"AND round(DATE_FORMAT(tgl_daftar, '%d')) = '$dtgl' ".
							"AND round(DATE_FORMAT(tgl_daftar, '%m')) = '$dbln' ".
							"AND round(DATE_FORMAT(tgl_daftar, '%Y')) = '$dthn'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//nek ada
	if ($tcc != 0)
		{
		//update
		mysql_query("UPDATE psb_siswa_calon SET tgl_bayar = '$tgl_bayar', ".
						"jml_bayar = '$jml_transfer' ".
						"WHERE no_daftar = '$no_reg' ".
						"AND nama = '$nama'");

		//re-direct
		$pesan = "Konfirmasi Pembayaran Pendaftaran Peserta Didik Baru, Telah Berhasil. ".
					"Proses Seleksi Penerimaan Peserta Didik Baru, Bisa Diikuti. Terima Kasih.";
		$ke = "index.php";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$pesan = "Input Tidak Sesuai. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//isi *START
ob_start();



//js
require("../inc/js/number.js");



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

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warna02.'" valign="top" align="left">
<td>
Harap diisi form berikut ini, tepat sama dengan saat mengisi form pendaftaran.
<br>
Jika memang Anda telah melakukan pembayaran atau transfer biaya pendaftaran Penerimaan Peserta Didik baru.
</td>
</tr>
</table>

<br>

<TABLE WIDTH="400" BORDER="0" CELLPADDING="0" CELLSPACING="0">
<TR valign="top">
<TD>
<IMG SRC="'.$sumber.'/img/kotak_01.gif" WIDTH=8 HEIGHT=8 ALT="">
</TD>
<TD background="'.$sumber.'/img/kotak_02.gif" width="100%">
</TD>
<TD>
<IMG SRC="'.$sumber.'/img/kotak_03.gif" WIDTH=10 HEIGHT=8 ALT="">
</TD>
</TR>
<TR>
<TD background="'.$sumber.'/img/kotak_04.gif">
</TD>
<TD background="'.$sumber.'/img/kotak_05.gif" width="100%" valign="top">

No. Pendaftaran :
<br>
<input name="no_reg" type="text" size="10" value="" onKeyPress="return numbersonly(this, event)">
<br>
<br>

Nama :
<br>
<input name="nama" type="text" size="30" maxlength="30">
<br>
<br>

Tanggal Pendaftaran :
<br>
<select name="dtgl">
<option value="" selected></option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}

echo '</select>
<select name="dbln">
<option value="" selected></option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>
<select name="dthn">
<option value="" selected></option>';
for ($k=$daft01;$k<=$daft02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>
<br>
<br>
<br>
<br>

<strong>PEMBAYARAN :</strong>
<br>
Tanggal Pembayaran :
<br>
<select name="btgl">
<option value="" selected></option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}

echo '</select>
<select name="bbln">
<option value="" selected></option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>
<select name="bthn">
<option value="" selected></option>';
for ($k=$daft01;$k<=$daft02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>
<br>
<br>

Jumlah Yang Telah Ditransfer :
<br>
Rp. <input name="jml_transfer" type="text" size="10" onKeyPress="return numbersonly(this, event)">,00
<br>
<br>
<input name="btnBTL" type="reset" value="BATAL">
<input name="btnOK" type="submit" value="OK &gt;&gt;&gt;">


</TD>
<TD background="'.$sumber.'/img/kotak_06.gif">
</TD>
</TR>
<TR>
<TD>
<IMG SRC="'.$sumber.'/img/kotak_07.gif" WIDTH=8 HEIGHT=8 ALT="">
</TD>
<TD background="'.$sumber.'/img/kotak_08.gif" width="100%">
</TD>
<TD>
<IMG SRC="'.$sumber.'/img/kotak_09.gif" WIDTH=10 HEIGHT=8 ALT="">
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