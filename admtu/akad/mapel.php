<?php
 



session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admtu.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "mapel.php";
$diload = "document.formx.no.focus();";
$judul = "Mata Pelajaran";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}


//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT * FROM m_mapel ".
						"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);

	$no = nosql($rowx['no']);
	$no_sub = nosql($rowx['no_sub']);
	$pel = balikin($rowx['pel']);
	$xpel = balikin($rowx['xpel']);
	$mulo = nosql($rowx['mulo']);

	//jika true
	if ($mulo == "true")
		{
		$mulo_ket = "checked";
		}
	else
		{
		$mulo_ket = "";
		}
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$no = nosql($_POST['no']);
	$no_sub = nosql($_POST['no_sub']);
	$pel = cegah($_POST['pel']);
	$xpel = cegah($_POST['xpel']);
	$mulo = nosql($_POST['mulo']);

	//jika ada checked
	if (!empty($mulo))
		{
		$mulo_ket = "true";
		}
	else
		{
		$mulo_ket = "false";
		}



	//nek null
	if ((empty($no)) OR (empty($no_sub)) OR (empty($pel)) OR (empty($xpel)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//jika baru
		if (empty($s))
			{
			///cek
			$qcc = mysql_query("SELECT * FROM m_mapel ".
									"WHERE pel = '$pel'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Mata Pelajaran : $pel, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//insert
				mysql_query("INSERT INTO m_mapel(kd, no, no_sub, pel, xpel, mulo) VALUES ".
						"('$x', '$no', '$no_sub', '$pel', '$xpel', '$mulo_ket')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				xloc($filenya);
				exit();
				}
			}


		//jika update
		else if ($s == "edit")
			{
			//update
			mysql_query("UPDATE m_mapel SET no = '$no', ".
					"no_sub = '$no_sub', ".
					"pel = '$pel', ".
					"xpel = '$xpel', ".
					"mulo = '$mulo_ket' ".
					"WHERE kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_mapel ".
						"WHERE kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//query
$q = mysql_query("SELECT * FROM m_mapel ".
					"ORDER BY round(no) ASC, round(no_sub) ASC");
$row = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);

//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admtu.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
No. : <input name="no" type="text" value="'.$no.'" size="2" maxlength="2">,
No.Sub : <input name="no_sub" type="text" value="'.$no_sub.'" size="2" maxlength="2">,
<br>
Nama Pelajaran : <input name="pel" type="text" value="'.$pel.'" size="30">,
<br>
Singkatan : <input name="xpel" type="text" value="'.$xpel.'" size="10">,
<br>
Muatan Lokal : <input name="mulo" type="checkbox" value="'.$mulo.'" '.$mulo_ket.'>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>';

if ($total != 0)
	{
	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td width="10"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td width="10"><strong><font color="'.$warnatext.'">No.Sub</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Pelajaran</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Singkatan</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Muatan Lokal</font></strong></td>
	</tr>';

	do
		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}

		$nomer = $nomer + 1;
		$kd = nosql($row['kd']);
		$no = nosql($row['no']);
		$no_sub = nosql($row['no_sub']);
		$pel = balikin($row['pel']);
		$xpel = balikin($row['xpel']);
		$mulo = nosql($row['mulo']);

		//jika true
		if ($mulo == "true")
			{
			$mulo_ket = "<strong>V</strong>";
			}
		else
			{
			$mulo_ket = "-";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'">
		</td>
		<td>
		<a href="'.$filenya.'?s=edit&kd='.$kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>'.$no.'</td>
		<td>'.$no_sub.'</td>
		<td>'.$pel.'</td>
		<td>'.$xpel.'</td>
		<td align="center">'.$mulo_ket.'</td>
	        </tr>';
		}
	while ($row = mysql_fetch_assoc($q));

	echo '</table>
	<table width="600" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="263">
	<input name="jml" type="hidden" value="'.$total.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kdx.'">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
	<input name="btnBTL" type="submit" value="BATAL">
	<input name="btnHPS" type="submit" value="HAPUS">
	</td>
	<td align="right">Total : <strong><font color="#FF0000">'.$total.'</font></strong> Data.</td>
	</tr>
	</table>';
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>TIDAK ADA DATA. Silahkan Entry Dahulu...!!</strong>
	</font>
	</p>';
	}

echo '</form>';
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