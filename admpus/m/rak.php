<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admpus.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "rak.php";
$diload = "document.formx.rak.focus();";
$judul = "Rak";
$judulku = "[$pus_session : $nip14_session. $nm14_session] ==> $judul";
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
	$qx = mysql_query("SELECT * FROM perpus_rak ".
						"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$rak = balikin2($rowx['rak']);
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$rak = cegah2($_POST['rak']);

	//nek null
	if (empty($rak))
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
			$qcc = mysql_query("SELECT * FROM perpus_rak ".
									"WHERE rak = '$rak'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Rak : $rak, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO perpus_rak(kd, rak) VALUES ".
								"('$x', '$rak')");

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
			///cek
			$qcc = mysql_query("SELECT * FROM perpus_rak ".
									"WHERE rak = '$rak'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$cc_kd = nosql($rcc['kd']);

			//nek ada
			if (($tcc != 0) AND ($cc_kd != $kd))
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Rak : $rak, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=edit&kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("UPDATE perpus_rak SET rak = '$rak' ".
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
		mysql_query("DELETE FROM perpus_rak ".
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
$q = mysql_query("SELECT * FROM perpus_rak ".
					"ORDER BY round(rak) ASC");
$row = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);

//js
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admpus.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Rak :
<br>
<input name="rak" type="text" value="'.$rak.'" size="30">
<br>
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>';

if ($total != 0)
	{
	echo '<table width="400" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td><strong><font color="'.$warnatext.'">Rak</font></strong></td>
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
		$i_kd = nosql($row['kd']);
		$i_rak = balikin2($row['rak']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
        </td>
		<td>
		<a href="'.$filenya.'?s=edit&kd='.$i_kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>'.$i_rak.'</td>
        </tr>';
		}
	while ($row = mysql_fetch_assoc($q));

	echo '</table>
	<table width="400" border="0" cellspacing="0" cellpadding="3">
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