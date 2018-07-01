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
$filenya = "item.php";
$judul = "Item";
$judulku = "[$pus_session : $nip14_session. $nm14_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$kd = nosql($_REQUEST['kd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus
if ($s == "baru")
	{
	$diload = "document.formx.barkode.focus();";
	}
else
	{
	$diload = "document.formx.kategori.focus();";
	}


//nek enter
$x_enter = 'onkeydown="return handleEnter(this, event)"';
$x_enter2 = 'onkeydown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	document.formx.btnSMP.submit();
	}"';



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
	$e_pnukd = nosql($rowx['kd_penulis']);
	$e_bitkd = nosql($rowx['kd_penerbit']);
	$e_rakkd = nosql($rowx['kd_rak']);
	$e_kode = nosql($rowx['kode']);
	$e_barkode = nosql($rowx['barkode']);
	$e_judul = balikin2($rowx['judul']);
	$e_tahun_terbit = nosql($rowx['tahun_terbit']);
	$e_issn_isbn = nosql($rowx['issn_isbn']);
	$e_percetakan = balikin2($rowx['percetakan']);
	$e_editor = balikin2($rowx['editor']);
	$e_ukuran = balikin2($rowx['ukuran']);
	$e_jml_halaman = balikin2($rowx['jml_halaman']);
	$e_tebal = balikin2($rowx['tebal']);
	$e_cetakan_ke = balikin2($rowx['cetakan_ke']);
	$e_harga = nosql($rowx['harga']);
	$e_bahasa = balikin2($rowx['bahasa']);
	$e_rangkuman = balikin2($rowx['rangkuman']);
	$e_masuk_tgl = nosql($rowx['masuk_tgl']);
	$e_masuk_bln = nosql($rowx['masuk_bln']);
	$e_masuk_thn = nosql($rowx['masuk_thn']);
	$e_status = nosql($rowx['status']);
	$e_img_cover = balikin2($rowx['img_cover']);
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$kategori = nosql($_POST['kategori']);
	$penulis = nosql($_POST['penulis']);
	$penerbit = nosql($_POST['penerbit']);
	$rak = nosql($_POST['rak']);
	$kode = nosql($_POST['kode']);
	$barkode = nosql($_POST['barkode']);
	$judul = cegah2($_POST['judul']);
	$tahun_terbit = nosql($_POST['tahun_terbit']);
	$issn_isbn = nosql($_POST['issn_isbn']);
	$percetakan = balikin2($_POST['percetakan']);
	$editor = balikin2($_POST['editor']);
	$ukuran = balikin2($_POST['ukuran']);
	$jml_halaman = balikin2($_POST['jml_halaman']);
	$tebal = balikin2($_POST['tebal']);
	$cetakan_ke = balikin2($_POST['cetakan_ke']);
	$harga = nosql($_POST['harga']);
	$bahasa = balikin2($_POST['bahasa']);
	$rangkuman = balikin2($_POST['rangkuman']);
	$masuk_tgl = nosql($_POST['masuk_tgl']);
	$masuk_bln = nosql($_POST['masuk_bln']);
	$masuk_thn = nosql($_POST['masuk_thn']);
	$tgl_masuk = "$masuk_thn:$masuk_bln:$masuk_tgl";
	$status = nosql($_POST['status']);


	//jika baru
	if ($s == "baru")
		{
		//cek barkode, ok.
		if (!empty($barkode))
			{
			///cek
			$qcc = mysql_query("SELECT * FROM perpus_item ".
									"WHERE barkode = '$barkode'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "BarKode Item : $barkode, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=baru&kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//query
				mysql_query("INSERT INTO perpus_item(kd, barkode) VALUES ".
								"('$kd', '$barkode')");

				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=edit&kd=$kd";
				xloc($ke);
				exit();
				}
			}


		//null barkode...
		else
			{
			//nek null
			if ((empty($kode)) OR (empty($judul)))
				{
				//diskonek
				xfree($qbw);
				xclose($koneksi);

				//re-direct
				$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
				$ke = "$filenya?s=baru&kd=$kd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				///cek
				$qcc = mysql_query("SELECT * FROM perpus_item ".
										"WHERE kode = '$kode'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//diskonek
					xfree($qbw);
					xclose($koneksi);

					//re-direct
					$pesan = "Kode Item : $kode, Sudah Ada. Silahkan Ganti Yang Lain...!!";
					$ke = "$filenya?s=baru&kd=$kd";
					pekem($pesan,$ke);
					exit();
					}
				else
					{
					//query
					mysql_query("INSERT INTO perpus_item(kd, kd_kategori, kd_penulis, kd_penerbit, kd_rak, kode, barkode, judul, ".
									"tahun_terbit, issn_isbn, percetakan, editor, ukuran, jml_halaman, tebal, ".
									"cetakan_ke, harga, bahasa, rangkuman, tgl_masuk, status) VALUES ".
									"('$kd', '$kategori', '$penulis', '$penerbit', '$rak', '$kode', '$barkode', '$judul', ".
									"'$tahun_terbit', '$issn_isbn', '$percetakan', '$editor', '$ukuran', '$jml_halaman', '$tebal', ".
									"'$cetakan_ke', '$harga', '$bahasa', '$rangkuman', '$tgl_masuk', '$status')");

					//diskonek
					xfree($qbw);
					xclose($koneksi);

					//re-direct
					$ke = "$filenya?s=edit&kd=$kd";
					xloc($ke);
					exit();
					}
				}
			}
		}



	//jika update
	else if ($s == "edit")
		{
		///cek
		$qcc = mysql_query("SELECT * FROM perpus_item ".
								"WHERE barkode = '$barkode'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_kd = nosql($rcc['kd']);

		//jika ada duplikasi
		if (($tcc != 0) AND ($cc_kd != $kd))
			{
			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$pesan = "BarCode : $barkode, Sudah Ada. Harap Diperhatikan...!!";
			$ke = "$filenya?s=edit&kd=$kd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			mysql_query("UPDATE perpus_item SET kd_kategori = '$kategori', ".
							"kd_penulis = '$penulis', ".
							"kd_penerbit = '$penerbit', ".
							"kd_rak = '$rak', ".
							"kode = '$kode', ".
							"barkode = '$barkode', ".
							"judul = '$judul', ".
							"tahun_terbit = '$tahun_terbit', ".
							"issn_isbn = '$issn_isbn', ".
							"percetakan = '$percetakan', ".
							"editor = '$editor', ".
							"ukuran = '$ukuran', ".
							"jml_halaman = '$jml_halaman', ".
							"tebal = '$tebal', ".
							"cetakan_ke = '$cetakan_ke', ".
							"harga = '$harga', ".
							"bahasa = '$bahasa', ".
							"rangkuman = '$rangkuman', ".
							"tgl_masuk = '$tgl_masuk', ".
							"status = '$status' ".
							"WHERE kd = '$kd'");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			$ke = "$filenya?s=edit&kd=$kd";
			xloc($ke);
			exit();
			}
		}
	}





//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//hapus file yang ada dulu
		//query
		$qcc = mysql_query("SELECT * FROM perpus_item ".
								"WHERE kd = '$kd'");
		$rcc = mysql_fetch_assoc($qcc);

		//hapus file
		$cc_filex = $rcc['img_cover'];
		$path1 = "../../filebox/perpus/$kd/$cc_filex";
		unlink ($path1);


		//del
		mysql_query("DELETE FROM perpus_item ".
						"WHERE kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($filenya);
	exit();
	}





//ganti foto profil
if ($_POST['btnGNT'])
	{
	//nilai
	$kd = nosql($_POST['kd']);
	$s = nosql($_POST['s']);
	$filex_namex = strip(strtolower($_FILES['filex_foto']['name']));


	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=$s&kd=$kd";
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
			$path1 = "../../filebox/perpus/$kd";
			chmod($path1,0777);

			//cek, sudah ada belum
			if (!file_exists($path1))
				{
				//bikin folder kd_user
				mkdir("$path1", $chmod);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/perpus/$kd/$filex_namex");

				//query
				mysql_query("UPDATE perpus_item SET img_cover = '$filex_namex' ".
								"WHERE kd = '$kd'");

				//null-kan
				xclose($koneksi);

				chmod($path1,0755);

				//re-direct
				$ke = "$filenya?s=$s&kd=$kd";
				xloc($ke);
				exit();
				}
			else
				{
				//hapus file yang ada dulu
				//query
				$qcc = mysql_query("SELECT * FROM perpus_item ".
										"WHERE kd = '$kd'");
				$rcc = mysql_fetch_assoc($qcc);

				//hapus file
				$cc_filex = $rcc['img_cover'];
				$path1 = "../../filebox/perpus/$kd/$cc_filex";
				chmod($path1,0777);
				unlink ($path1);

				//mengkopi file
				copy($_FILES['filex_foto']['tmp_name'],"../../filebox/perpus/$kd/$filex_namex");

				//query
				mysql_query("UPDATE perpus_item SET img_cover = '$filex_namex' ".
								"WHERE kd = '$kd'");

				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?s=$s&kd=$kd";
				xloc($ke);
				exit();
				}
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan FIle Image .jpg . Harap Diperhatikan...!!";
			$ke = "$filenya?s=$s&kd=$kd";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();




//js
require("../../inc/js/checkall.js");
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
echo ' [<a href="'.$filenya.'?s=baru&kd='.$x.'" title="Entry Baru">Entry Baru</a>]
</td>
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

//jika baru/edit
if (($s == "baru") OR ($s == "edit"))
	{
	//kategori
	$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
							"WHERE kd = '$e_katkd'");
	$rkatx = mysql_fetch_assoc($qkatx);
	$e_kategori_kode = nosql($rkatx['kode']);
	$e_kategori = balikin2($rkatx['kategori']);


	//rak
	$qrakx = mysql_query("SELECT * FROM perpus_rak ".
							"WHERE kd = '$e_rakkd'");
	$rrakx = mysql_fetch_assoc($qrakx);
	$e_rak = balikin2($rrakx['rak']);


	//penulis
	$qpnux = mysql_query("SELECT * FROM perpus_penulis ".
							"WHERE kd = '$e_pnukd'");
	$rpnux = mysql_fetch_assoc($qpnux);
	$e_pnu = balikin2($rpnux['nama']);


	//penerbit
	$qbitx = mysql_query("SELECT * FROM perpus_penerbit ".
							"WHERE kd = '$e_bitkd'");
	$rbitx = mysql_fetch_assoc($qbitx);
	$e_bit = balikin2($rbitx['nama']);


	//status
	if ($e_status == "false")
		{
		$e_status_ket = "Belum Bisa Dipinjam";
		}
	else
		{
		$e_status_ket = "BISA DIPINJAM";
		}

	echo '<hr>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td width="600">
	<p>
	BarCode :
	<br>
	<input name="barkode" type="text" value="'.$e_barkode.'" size="30" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>
	<br>
	<br>
	Kategori :
	<br>
	<select name="kategori">
	<option value="'.$e_katkd.'" selected>'.$e_kategori_kode.'. '.$e_kategori.'</option>';

	//list kategori
	$qkat = mysql_query("SELECT * FROM perpus_kategori ".
							"WHERE kd <> '$e_katkd' ".
							"ORDER BY kategori ASC");
	$rkat = mysql_fetch_assoc($qkat);

	do
		{
		//nilai
		$kat_kd = nosql($rkat['kd']);
		$kat_kategori_kode = nosql($rkat['kode']);
		$kat_kategori = balikin($rkat['kategori']);

		echo '<option value="'.$kat_kd.'">'.$kat_kategori_kode.'. '.$kat_kategori.'</option>';
		}
	while ($rkat = mysql_fetch_assoc($qkat));

	echo '</select>
	<br>
	<br>
	Tempat Rak :
	<br>
	<select name="rak">
	<option value="'.$e_rakkd.'" selected>'.$e_rak.'</option>';

	//list rak
	$qrak = mysql_query("SELECT * FROM perpus_rak ".
							"WHERE kd <> '$e_rakkd' ".
							"ORDER BY rak ASC");
	$rrak = mysql_fetch_assoc($qrak);

	do
		{
		//nilai
		$rak_kd = nosql($rrak['kd']);
		$rak_rak = balikin($rrak['rak']);

		echo '<option value="'.$rak_kd.'">'.$rak_rak.'</option>';
		}
	while ($rrak = mysql_fetch_assoc($qrak));

	echo '</select>
	<br>
	<br>
	Kode Item :
	<br>
	<input name="kode" type="text" value="'.$e_kode.'" size="10"  '.$x_enter2.'>
	<br>
	<br>
	Judul :
	<br>
	<input name="judul" type="text" value="'.$e_judul.'" size="50"  '.$x_enter2.'>
	<br>
	<br>
	Penulis :
	<br>
	<select name="penulis">
	<option value="'.$e_pnukd.'" selected>'.$e_pnu.'</option>';

	//list penulis
	$qpnu = mysql_query("SELECT * FROM perpus_penulis ".
							"WHERE kd <> '$e_pnukd' ".
							"ORDER BY nama ASC");
	$rpnu = mysql_fetch_assoc($qpnu);

	do
		{
		//nilai
		$pnu_kd = nosql($rpnu['kd']);
		$pnu_nama = balikin($rpnu['nama']);

		echo '<option value="'.$pnu_kd.'">'.$pnu_nama.'</option>';
		}
	while ($rpnu = mysql_fetch_assoc($qpnu));

	echo '</select>
	<br>
	<br>
	Editor :
	<br>
	<input name="editor" type="text" value="'.$e_editor.'" size="30"  '.$x_enter2.'>
	<br>
	<br>
	Penerbit :
	<br>
	<select name="penerbit">
	<option value="'.$e_bitkd.'" selected>'.$e_bit.'</option>';

	//list penerbit
	$qbit = mysql_query("SELECT * FROM perpus_penerbit ".
							"WHERE kd <> '$e_bitkd' ".
							"ORDER BY nama ASC");
	$rbit = mysql_fetch_assoc($qbit);

	do
		{
		//nilai
		$bit_kd = nosql($rbit['kd']);
		$bit_nama = balikin($rbit['nama']);

		echo '<option value="'.$bit_kd.'">'.$bit_nama.'</option>';
		}
	while ($rbit = mysql_fetch_assoc($qbit));

	echo '</select>
	<br>
	<br>
	Percetakan :
	<br>
	<input name="percetakan" type="text" value="'.$e_percetakan.'" size="50"  '.$x_enter2.'>
	<br>
	<br>
	Tahun Terbit :
	<br>
	<input name="tahun_terbit" type="text" value="'.$e_tahun_terbit.'" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)"  '.$x_enter2.'>
	<br>
	<br>
	ISSN/ISBN :
	<br>
	<input name="issn_isbn" type="text" value="'.$e_issn_isbn.'" size="20" onKeyPress="return numbersonly(this, event)"  '.$x_enter2.'>
	<br>
	<br>
	Ukuran :
	<br>
	<input name="ukuran" type="text" value="'.$e_ukuran.'" size="20" '.$x_enter2.'>
	<br>
	<br>
	Jumlah Halaman :
	<br>
	<input name="jml_halaman" type="text" value="'.$e_jml_halaman.'" size="20" '.$x_enter2.'>
	<br>
	<br>
	Tebal :
	<br>
	<input name="tebal" type="text" value="'.$e_tebal.'" size="10" '.$x_enter2.'>
	<br>
	<br>
	Cetakan Ke-:
	<br>
	<input name="cetakan_ke" type="text" value="'.$e_cetakan_ke.'" size="5" maxlength="5" '.$x_enter2.'>
	<br>
	<br>
	Bahasa :
	<br>
	<input name="bahasa" type="text" value="'.$e_bahasa.'" size="20" '.$x_enter2.'>
	<br>
	<br>
	Harga :
	<br>
	Rp. <input name="harga" type="text" value="'.$e_harga.'" size="10" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>,00
	<br>
	<br>
	Rangkuman :
	<br>
	<textarea name="rangkuman" cols="50" rows="5" wrap="virtual">'.$e_rangkuman.'</textarea>
	<br>
	<br>
	Tgl. Masuk :
	<br>
	<select name="masuk_tgl">
	<option value="'.$e_masuk_tgl.'" selected>'.$e_masuk_tgl.'</option>';
	for ($i=1;$i<=31;$i++)
		{
		echo '<option value="'.$i.'">'.$i.'</option>';
		}

	echo '</select>
	<select name="masuk_bln">
	<option value="'.$e_masuk_bln.'" selected>'.$arrbln1[$e_masuk_bln].'</option>';
	for ($j=1;$j<=12;$j++)
		{
		echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
		}

	echo '</select>
	<select name="masuk_thn">
	<option value="'.$e_masuk_thn.'" selected>'.$e_masuk_thn.'</option>';
	for ($k=$masuk01;$k<=$masuk02;$k++)
		{
		echo '<option value="'.$k.'">'.$k.'</option>';
		}
	echo '</select>
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
	<input name="s" type="hidden" value="'.$s.'">
	<input name="kd" type="hidden" value="'.$kd.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="DAFTAR ITEM >>">
	</p>
	</td>
	<td>';
	//nek null foto
	if (empty($e_img_cover))
		{
		$nil_foto = "$sumber/img/foto_blank.jpg";
		}
	else
		{
		//gawe thumnail #1
		$obj_img2 = new thumbnail_images();
		$obj_img2->PathImgOld = "$sumber/filebox/perpus/$kd/$e_img_cover";
		$obj_img2->PathImgNew = "../../filebox/perpus/$kd/thumb_$e_img_cover";
		$obj_img2->NewHeight = 300;
		$obj_img2->NewWidth = 195;
		if (!$obj_img2->create_thumbnail_images())
			{
			echo '<font color="red"><strong>Gagal Membuat Thumbnail...!</strong></font>';
			}
		else
			{
			$nil_foto = $obj_img2->PathImgNew;
			}


		//gawe thumnail #2
		$obj_img3 = new thumbnail_images();
		$obj_img3->PathImgOld = "$sumber/filebox/perpus/$kd/thumb_$e_img_cover";
		$obj_img3->PathImgNew = "../../filebox/perpus/$kd/thumb2_$e_img_cover";
		$obj_img3->NewHeight = 100;
		$obj_img3->NewWidth = 75;
		if (!$obj_img3->create_thumbnail_images())
			{
			echo '<font color="red"><strong>Gagal Membuat Thumbnail...!</strong></font>';
			}
		else
			{
			$nil_foto2 = $obj_img3->PathImgNew;
			}
		}

	echo '<img src="'.$nil_foto.'" alt="'.$e_judul.'" width="195" height="300" border="5">
	<br><br>
	<input name="filex_foto" type="file" size="15">
	<br>
	<input name="btnGNT" type="submit" value="GANTI">
	</td>
	</tr>
	</table>';
	}

else
	{
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


	if ($count != 0)
		{
		echo '<table width="980" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="75"><strong><font color="'.$warnatext.'">Cover</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Keterangan</font></strong></td>
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
			$i_barkode = nosql($data['barkode']);
			$i_judul = balikin2($data['judul']);
			$i_katkd = nosql($data['kd_kategori']);
			$i_pnukd = nosql($data['kd_penulis']);
			$i_editor = balikin2($data['editor']);
			$i_bitkd = nosql($data['kd_penerbit']);
			$i_percetakan = balikin2($data['percetakan']);
			$i_tahun_terbit = balikin2($data['tahun_terbit']);
			$i_issn_isbn = balikin2($data['issn_isbn']);
			$i_status = nosql($data['status']);
			$i_rangkuman = balikin2($data['rangkuman']);
			$i_img_cover = balikin2($data['img_cover']);


			//kategori
			$qkatx = mysql_query("SELECT * FROM perpus_kategori ".
									"WHERE kd = '$i_katkd'");
			$rkatx = mysql_fetch_assoc($qkatx);
			$i_kategori_kode = nosql($rkatx['kode']);
			$i_kategori = balikin2($rkatx['kategori']);


			//penulis
			$qpnux = mysql_query("SELECT * FROM perpus_penulis ".
									"WHERE kd = '$i_pnukd'");
			$rpnux = mysql_fetch_assoc($qpnux);
			$i_penulis = balikin2($rpnux['nama']);


			//penerbit
			$qbitx = mysql_query("SELECT * FROM perpus_penerbit ".
									"WHERE kd = '$i_bitkd'");
			$rbitx = mysql_fetch_assoc($qbitx);
			$i_penerbit = balikin2($rbitx['nama']);


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
			<input type="checkbox" name="item'.$nomer.'" value="'.$i_kd.'">
	        </td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'" title="'.$i_judul.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="'.$filenya.'?s=edit&kd='.$i_kd.'" title="'.$i_judul.'">'.$i_foto.'</a>
			</td>
			<td>
			<big>
			<font color="red">
			<strong>'.$i_judul.'</strong>
			</font>
			</big>
			<br>
			Kode :
			<strong><em>'.$i_kode.'</em></strong>
			<br>
			BarCode :
			<strong><em>'.$i_barkode.'</em></strong>
			<br>
			Kategori :
			<strong><em>'.$i_kategori_kode.'. '.$i_kategori.'</em></strong>
			<br>
			Penulis :
			<strong><em>'.$i_penulis.'</em></strong>
			<br>
			Editor :
			<strong><em>'.$i_editor.'</em></strong>
			<br>
			Penerbit :
			<strong><em>'.$i_penerbit.'</em></strong>
			<br>
			Percetakan :
			<strong><em>'.$i_percetakan.'</em></strong>
			<br>
			Tahun Terbit :
			<strong><em>'.$i_tahun_terbit.'</em></strong>
			<br>
			ISSN/ISBN :
			<strong><em>'.$i_issn_isbn.'</em></strong>
			<br>
			<br>
			<em>'.$i_rangkuman.'</em>
			<br>
			<br>
			[...<a href="'.$filenya.'?s=edit&kd='.$i_kd.'" title="'.$i_judul.'">SELENGKAPNYA</a>].
			[<strong>'.$i_status_ket.'</strong>].
			</td>
	        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="980" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="263">
		<input name="jml" type="hidden" value="'.$count.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
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