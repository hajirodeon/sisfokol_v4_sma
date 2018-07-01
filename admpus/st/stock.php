<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admpus.php");
require("../../inc/class/paging.php");
require("../../inc/class/thumbnail_images.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "stock.php";
$judul = "Stock Opname";
$judulku = "[$pus_session : $nip14_session. $nm14_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$diload = "document.formx.jml_bagus.focus();";
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}





//nek batal
if ($_POST['btnRST'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}





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





//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$page = nosql($_POST['page']);
	$kd = nosql($_POST['kd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);
	$jml_bagus = nosql($_POST['jml_bagus']);
	$jml_rusak = nosql($_POST['jml_rusak']);
	$jml_hilang = nosql($_POST['jml_hilang']);
	$jml_total = nosql($_POST['jml_total']);
	$status = nosql($_POST['status']);


	//cek
	$qcc = mysql_query("SELECT * FROM perpus_stock ".
							"WHERE kd_item = '$kd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//jika ada
	if ($tcc != 0)
		{
		//update
		mysql_query("UPDATE perpus_stock SET jml_bagus = '$jml_bagus', ".
						"jml_rusak = '$jml_rusak', ".
						"jml_hilang = '$jml_hilang', ".
						"jml_total = '$jml_total' ".
						"WHERE kd_item = '$kd'");

		//update2
		mysql_query("UPDATE perpus_item SET status = '$status' ".
						"WHERE kd = '$kd'");

		//re-direct
		$ke = "$filenya?page=$page&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	else
		{
		//insert
		mysql_query("INSERT INTO perpus_stock(kd, kd_item, jml_bagus, jml_rusak, jml_hilang, jml_total) VALUES ".
						"('$x', '$kd', '$jml_bagus', '$jml_rusak', '$jml_hilang', '$jml_total')");

		//re-direct
		$ke = "$filenya?page=$page&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();




//js
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/menu/admpus.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" enctype="multipart/form-data" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>';
xheadline($judul);
echo ' [<a href="'.$sumber.'/admpus/m/item.php?s=baru&kd='.$x.'" title="Entry Baru">Entry Baru</a>]</td>
<td align="right">';
echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$crkd.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?crkd=cr01&crtipe=BarCode">BarCode</option>
<option value="'.$filenya.'?crkd=cr02&crtipe=Kode">Kode</option>
<option value="'.$filenya.'?crkd=cr03&crtipe=Judul">Judul</option>
<option value="'.$filenya.'?crkd=cr04&crtipe=Kategori">Kategori</option>
<option value="'.$filenya.'?crkd=cr05&crtipe=Penerbit">Penerbit</option>
<option value="'.$filenya.'?crkd=cr06&crtipe=Penulis">Penulis</option>
<option value="'.$filenya.'?crkd=cr07&crtipe=Tempat Rak">Tempat Rak</option>
<option value="'.$filenya.'?crkd=cr08&crtipe=ISSN/ISBN">ISSN/ISBN</option>
</select>
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="btnCARI" type="submit" value="CARI">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>';


//barcode
if ($crkd == "cr01")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
					"FROM perpus_item ".
					"WHERE barkode LIKE '%$kunci%'".
					"ORDER BY round(barkode) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//kode
else if ($crkd == "cr02")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
					"FROM perpus_item ".
					"WHERE kode LIKE '%$kunci%' ".
					"ORDER BY round(kode) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//judul
else if ($crkd == "cr03")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
					"FROM perpus_item ".
					"WHERE judul LIKE '%$kunci%' ".
					"ORDER BY round(judul) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//kategori
else if ($crkd == "cr04")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_kategori.* ".
					"FROM perpus_item, perpus_kategori ".
					"WHERE perpus_item.kd_kategori = perpus_kategori.kd ".
					"AND perpus_kategori.kategori LIKE '%$kunci%' ".
					"ORDER BY round(perpus_kategori.kategori) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//penerbit
else if ($crkd == "cr05")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_penerbit.* ".
					"FROM perpus_item, perpus_penerbit ".
					"WHERE perpus_item.kd_penerbit = perpus_penerbit.kd ".
					"AND perpus_penerbit.nama LIKE '%$kunci%' ".
					"ORDER BY round(perpus_penerbit.nama) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//penulis
else if ($crkd == "cr06")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_penulis.* ".
					"FROM perpus_item, perpus_penulis ".
					"WHERE perpus_item.kd_penulis = perpus_penulis.kd ".
					"AND perpus_penulis.nama LIKE '%$kunci%' ".
					"ORDER BY round(perpus_penulis.nama) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//tempat rak
else if ($crkd == "cr07")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd, perpus_rak.* ".
					"FROM perpus_item, perpus_rak ".
					"WHERE perpus_item.kd_rak = perpus_rak.kd ".
					"AND perpus_rak.rak LIKE '%$kunci%' ".
					"ORDER BY round(perpus_rak.rak) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

//issn/isbn
else if ($crkd == "cr08")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
					"FROM perpus_item ".
					"WHERE issn_isbn LIKE '%$kunci%' ".
					"ORDER BY round(issn_isbn) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT perpus_item.*, perpus_item.kd AS pitkd ".
					"FROM perpus_item ".
					"ORDER BY tgl_masuk DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}





//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);

	//query
	$qx = mysql_query("SELECT DATE_FORMAT(tgl_masuk, '%d') AS masuk_tgl, ".
							"DATE_FORMAT(tgl_masuk, '%m') AS masuk_bln, ".
							"DATE_FORMAT(tgl_masuk, '%Y') AS masuk_thn, ".
							"perpus_item.* ".
							"FROM perpus_item ".
							"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
	$e_katkd = nosql($rowx['kd_kategori']);
	$e_kode = nosql($rowx['kode']);
	$e_barkode = nosql($rowx['barkode']);
	$e_judul = balikin2($rowx['judul']);
	$e_status = nosql($rowx['status']);
	$e_img_cover = balikin2($rowx['img_cover']);


	//kategori
	$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
							"WHERE kd = '$e_katkd'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_kategori_kode = nosql($rkatx['kode']);
	$e_kategori = balikin2($rkatx['kategori']);


	//status
	if ($e_status == "false")
		{
		$e_status_ket = "Belum Bisa Dipinjam";
		}
	else
		{
		$e_status_ket = "BISA DIPINJAM";
		}


	//stock
	$qsoki = mysql_query("SELECT * FROM perpus_stock ".
							"WHERE kd_item = '$kdx'");
	$rsoki = mysql_fetch_assoc($qsoki);
	$tsoki = mysql_num_rows($qsoki);
	$soki_bagus = round(nosql($rsoki['jml_bagus']));
	$soki_rusak = round(nosql($rsoki['jml_rusak']));
	$soki_hilang = round(nosql($rsoki['jml_hilang']));
	$soki_dipinjam = round(nosql($rsoki['jml_dipinjam']));
	$soki_total = round($soki_bagus + $soki_rusak + $soki_hilang + $soki_dipinjam);



	echo '<hr>
	Kode : <strong>'.$e_kode.'</strong>
	<br>
	Kategori : <strong>'.$e_kategori.'</strong>
	<br>
	Nama Item : <strong>'.$e_judul.'</strong>
	<br>
	<br>
	Jml. Bagus :
	<br>
	<input name="jml_bagus" type="text" value="'.$soki_bagus.'" size="5" onKeyPress="return numbersonly(this, event)" onKeyUp="document.formx.jml_total.value=eval(document.formx.jml_bagus.value) + eval(document.formx.jml_hilang.value) + eval(document.formx.jml_rusak.value) + eval(document.formx.jml_dipinjam.value);">
	<br>
	<br>

	Jml. Rusak :
	<br>
	<input name="jml_rusak" type="text" value="'.$soki_rusak.'" size="5" onKeyPress="return numbersonly(this, event)" onKeyUp="document.formx.jml_total.value=eval(document.formx.jml_bagus.value) + eval(document.formx.jml_hilang.value) + eval(document.formx.jml_rusak.value) + eval(document.formx.jml_dipinjam.value);">
	<br>
	<br>

	Jml. Hilang :
	<br>
	<input name="jml_hilang" type="text" value="'.$soki_hilang.'" size="5" onKeyPress="return numbersonly(this, event)" onKeyUp="document.formx.jml_total.value=eval(document.formx.jml_bagus.value) + eval(document.formx.jml_hilang.value) + eval(document.formx.jml_rusak.value) + eval(document.formx.jml_dipinjam.value);">
	<br>
	<br>

	Jml. Dipinjam :
	<br>
	<input name="jml_dipinjam" type="text" value="'.$soki_dipinjam.'" size="5" class="input" readonly>
	<br>
	<br>

	Jml. Total :
	<br>
	<input name="jml_total" type="text" value="'.$soki_total.'" size="5" class="input" readonly>
	<br>
	<br>

	Status Pinjam :
	<br>
	<select name="status">
	<option value="'.$e_status.'" selected>'.$e_status_ket.'</option>
	<option value="false">Belum Bisa Dipinjam</option>
	<option value="true">BISA DIPINJAM</option>
	</select>
	<br>
	<br>

	<input name="page" type="hidden" value="'.$page.'">
	<input name="crkd" type="hidden" value="'.$crkd.'">
	<input name="crtipe" type="hidden" value="'.$crtipe.'">
	<input name="kunci" type="hidden" value="'.$kunci.'">
	<input name="kd" type="hidden" value="'.$kd.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="DAFTAR STOCK >>">';
	}
else
	{
	//jika ada
	if ($count != 0)
		{
		echo '<table width="980" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="75"><strong><font color="'.$warnatext.'">Cover</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Keterangan</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml. Bagus</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml. Rusak</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml. Hilang</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Jml. Dipinjam</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Total</font></strong></td>
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
			$i_kd = nosql($data['pitkd']);
			$i_kode = nosql($data['kode']);
			$i_judul = balikin2($data['judul']);
			$i_status = nosql($data['status']);
			$i_katkd = nosql($data['kd_kategori']);
			$i_img_cover = balikin2($data['img_cover']);

			//kategori
			$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
									"WHERE kd = '$i_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$i_kategori_kode = nosql($rkatx['kode']);
			$i_kategori = balikin2($rkatx['kategori']);


			//stock
			$qsoki = mysql_query("SELECT * FROM perpus_stock ".
									"WHERE kd_item = '$i_kd'");
			$rsoki = mysql_fetch_assoc($qsoki);
			$tsoki = mysql_num_rows($qsoki);
			$soki_bagus = nosql($rsoki['jml_bagus']);
			$soki_rusak = nosql($rsoki['jml_rusak']);
			$soki_hilang = nosql($rsoki['jml_hilang']);
			$soki_dipinjam = nosql($rsoki['jml_dipinjam']);
			$soki_total = round($soki_bagus + $soki_rusak + $soki_hilang + $jml_dipinjam);



			//status
			if ($i_status == "false")
				{
				$i_status_ket = "<font color=\"brown\">Belum Bisa Dipinjam</font>";
				}
			else
				{
				$i_status_ket = "<font color=\"blue\">BISA DIPINJAM</font>";
				}


			//jika null
			if (empty($i_img_cover))
				{
				$i_foto = "<img src=\"$sumber/img/foto_blank.jpg\" alt=\"$e_judul\" width=\"75\" height=\"100\" border=\"1\">";
				}
			else
				{
				$i_foto = "<img src=\"$sumber/filebox/perpus/$i_kd/thumb2_$i_img_cover\" alt=\"$e_judul\" width=\"75\" height=\"100\" border=\"1\">";
				}

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			'.$i_foto.'
			</td>
			<td>
			<big>
			<font color="red">
			<strong>'.$i_judul.'</strong>
			</font>
			</big>
			<br>
			<br>
			Kategori : <strong>'.$i_kategori.'</strong>
			<br>
			Kode : <strong>'.$i_kode.'</strong>.
			<br>
			<br>
			[<strong>'.$i_status_ket.'</strong>].
			[<a href="'.$filenya.'?s=edit&kd='.$i_kd.'&page='.$page.'&crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" title="Edit Stock"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>]
			</td>
			<td>'.$soki_bagus.'</td>
			<td>'.$soki_rusak.'</td>
			<td>'.$soki_hilang.'</td>
			<td>'.$soki_dipinjam.'</td>
			<td>'.$soki_total.'</td>
	        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="980" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
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