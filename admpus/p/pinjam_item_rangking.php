<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admpus.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pinjam_item_rangking.php";
$judul = "Rekap Rangking Item";
$judulku = "[$pus_session : $nip14_session. $nm14_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}








//isi *START
ob_start();




//js
require("../../inc/js/swap.js");
require("../../inc/menu/admpus.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//daftar item sedang dipinjam
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM perpus_item_rangking ".
				"ORDER BY round(jml) DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//jika ada
if ($count != 0)
	{
	echo '<table width="500" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama Item</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Jumlah Dipinjam</font></strong></td>
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


		//urutkan nomor rangking
		//nilai
		$nox = round($nox + 1);

		//page awal
		if ((empty($page)) OR ($page == "1"))
			{
			$nox2 = $nox;
			}
		else
			{
			$nox2 = round((($limit * $page) + $nox) - $limit);
			}


		$d_itemkd = nosql($data['kd_item']);
		$d_jml = nosql($data['jml']);


		//detail item
		$qdt = mysql_query("SELECT * FROM perpus_item ".
								"WHERE kd = '$d_itemkd'");
		$rdt = mysql_fetch_assoc($qdt);
		$dt_kode = nosql($rdt['kode']);
		$dt_judul = balikin2($rdt['judul']);



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$nox2.'.</td>
		<td>'.$dt_kode.'. '.$dt_judul.'</td>
		<td align="right"><strong>'.$d_jml.'</strong> kali.</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</tr>
	</table>

	<table width="500" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
	</tr>
	</table>';
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>Tidak Ada Item Yang Dipinjam. . .</strong>
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