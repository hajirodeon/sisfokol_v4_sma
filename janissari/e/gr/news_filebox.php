<?php
//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
$tpl = LoadTpl("../../../template/window.html");


nocache;

//nilai
$filenya = "news_filebox.php";
$judul = "FileBox Image (.jpg) :";
$judulku = $judul;
$juduly = $judul;
$s = nosql($_REQUEST['s']);
$artkd = nosql($_REQUEST['artkd']);
$filekd = nosql($_REQUEST['filekd']);
$ke = "$filenya?artkd=$artkd";


//focus....focus...
$diload = "document.formx.filex.focus();";







//PROSES /////////////////////////////////////////////////////////////////////////////////////////////////
//hapus
if ($s == "hapus")
	{
	//nilai
	$artkd = nosql($_REQUEST['artkd']);
	$filekd = nosql($_REQUEST['filekd']);

	//query
	$qcc = mysql_query("SELECT * FROM guru_mapel_news_filebox ".
							"WHERE kd_guru_mapel_news = '$artkd' ".
							"AND kd = '$filekd'");
	$rcc = mysql_fetch_assoc($qcc);

	//hapus file
	$cc_filex = $rcc['filex'];
	$path1 = "../../../filebox/e/news/$artkd/$cc_filex";
	chmod($path1,0777);
	unlink ($path1);

	//hapus query
	mysql_query("DELETE FROM guru_mapel_news_filebox ".
					"WHERE kd_guru_mapel_news = '$artkd' ".
					"AND kd = '$filekd'");

	//null-kan
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}





//upload image
if ($_POST['btnUPL'])
	{
	//ambil nilai
	$artkd = nosql($_POST['artkd']);
	$filex_namex = strip(strtolower($_FILES['filex']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".jpg")
			{
			//nilai
			$filex1 = "../../../filebox/e/news/$artkd/$filex_namex";
			$filex2 = "../../../filebox/e/news/$artkd";
			chmod($filex2,0777);

			//cek, sudah ada belum
			if (!file_exists($filex1))
				{
				//mengkopi file
				copy($_FILES['filex']['tmp_name'],"../../../filebox/e/news/$artkd/$filex_namex");

				//query
				mysql_query("INSERT INTO guru_mapel_news_filebox(kd, kd_guru_mapel_news, filex) VALUES ".
								"('$x', '$artkd', '$filex_namex')");

				//null-kan
				xclose($koneksi);

				chmod($filex1,0755);

				//re-direct
				xloc($ke);
				exit();
				}
			else
				{
				//null-kan
				xclose($koneksi);

				//re-direct
				$pesan = "File : $filex_namex, Sudah Ada. Ganti Yang Lain...!!";
				pekem($pesan,$ke);
				exit();
				}
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="'.$e_warnaover.'" width="100%" border="0" cellpadding="3" cellspacing="0">
<tr>
<td>';

xheadline($judul);
echo '<br>
<input name="filex" type="file" size="30">
<input name="artkd" type="hidden" value="'.$artkd.'">
<input name="btnUPL" type="submit" value="UPLOAD">
</td>
</tr>
</table>

<table bgcolor="'.$e_warna02.'" width="100%" height="150" border="0" cellpadding="3" cellspacing="0">
<tr valign="top">
<td>';

//koleksi file
$qfle = mysql_query("SELECT * FROM guru_mapel_news_filebox ".
						"WHERE kd_guru_mapel_news = '$artkd' ".
						"ORDER BY filex ASC");
$rfle = mysql_fetch_assoc($qfle);
$tfle = mysql_num_rows($qfle);

//nek gak null
if ($tfle != 0)
	{
	do
		{
		//nilai
		$nomer = $nomer + 1;
		$fle_kd = nosql($rfle['kd']);
		$fle_filex = $rfle['filex'];

		echo '* <input name="filex'.$nomer.'" type="text" value="'.$sumber.'/filebox/e/news/'.$artkd.'/'.$fle_filex.'" size="75" readonly="true">';
		echo '  [<a href="'.$ke.'&s=hapus&filekd='.$fle_kd.'"><img src="'.$sumber.'/img/delete.gif" width="16" height="16" border="0"></a>]';
		echo '<br><br>';
		}
	while ($rfle = mysql_fetch_assoc($qfle));
	}

echo '</td>
</tr>
</table>

<table bgcolor="'.$e_warnaheader.'" width="100%" border="0" cellpadding="3" cellspacing="0">
<tr>
<td>
<input name="btnKLR" type="button" value="KELUAR" onClick="window.close();">
</td>
</tr>
</table>
<br><br><br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>