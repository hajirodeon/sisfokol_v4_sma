<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admbdh.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_les.php";
$judul = "Keuangan Siswa : Uang LES";
$judulku = "[$bdh_session : $nip8_session. $nm8_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$nis = nosql($_REQUEST['nis']);
$swkd = nosql($_REQUEST['swkd']);
$kelkd = nosql($_REQUEST['kelkd']);

$ke = "$filenya?tapelkd=$tapelkd&nis=$nis&swkd=$swkd&kelkd=$kelkd";







//focus...
if (empty($tapelkd))
{
$diload = "document.formx.tapel.focus();isodatetime();";
}
else if (empty($nis))
{
$diload = "document.formx.nis.focus();isodatetime();";
}
else
{
if (!empty($jml_bln))
	{
	$diload = "isodatetime();document.formx.btnSMP.focus();";
	}
else
	{
	$diload = "isodatetime();document.formx.nil_bayar.focus();";
	}
}



//keydown.
//tombol "CTRL"=17,
//tombol "HOME"=36,
//tombol "END"=35, utk. entri baru...
//tombol "DELETE"=45,
//tombol "ESC"=27,
$dikeydown = "var keyCode = event.keyCode;
		if (keyCode == 35)
			{
			var nyakin = window.confirm('Yakin Akan Memulai Entri Siswa Lainnya...?');

			if (nyakin)
				{
				location.href='$filenya?tapelkd=$tapelkd';
				}
			else
				{
				return false
				}
			}


		else if (keyCode == 46)
			{
			var nyakin = window.confirm('Yakin Batal Entri...?');

			if (nyakin)
				{
				location.href='$filenya?tapelkd=$tapelkd&swkd=$swkd&nis=$nis&kelkd=$kelkd&s=batal';
				}
			else
				{
				return false
				}
			}";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($s == "hapus")
{
//nilai
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$swkd = nosql($_REQUEST['swkd']);
$nis = nosql($_REQUEST['nis']);
$kd = nosql($_REQUEST['kd']);


//query
mysql_query("DELETE FROM siswa_uang_les ".
		"WHERE kd_tapel = '$tapelkd' ".
		"AND kd_kelas = '$kelkd' ".
		"AND kd_siswa = '$swkd' ".
		"AND kd = '$kd'");


//re-direct
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&nis=$nis&swkd=$swkd";
xloc($ke);
exit();
}





//nek batal
if (($_POST['btnBTL']) OR ($s == "batal"))
{
//nilai
$tapelkd = nosql($_POST['tapelkd']);
$kelkd = nosql($_POST['kelkd']);
$nis = nosql($_POST['nis']);
$swkd = nosql($_POST['swkd']);

$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$nis = nosql($_REQUEST['nis']);
$swkd = nosql($_REQUEST['swkd']);

//update
mysql_query("DELETE FROM siswa_uang_les ".
		"WHERE kd_tapel = '$tapelkd' ".
		"AND kd_kelas = '$kelkd' ".
		"AND kd_siswa = '$swkd' ".
		"AND DATE_FORMAT(tgl_bayar, '%d') = '$tanggal' ".
		"AND DATE_FORMAT(tgl_bayar, '%m') = '$bulan' ".
		"AND DATE_FORMAT(tgl_bayar, '%Y') = '$tahun'");


//re-direct
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&nis=$nis&swkd=$swkd";
xloc($ke);
exit();
}





//nek ok
if ($_POST['btnOK'])
{
//nilai
$tapelkd = nosql($_POST['tapelkd']);
$kelkd = nosql($_POST['kelkd']);
$nis = nosql($_POST['nis']);

//jika null
if (empty($nis))
	{
	//re-direct
	$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	pekem($pesan,$ke);
	exit();
	}
else
	{
	//cek
	$qcc = mysql_query("SELECT * FROM m_siswa ".
				"WHERE nis = '$nis'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);
	$cc_kd = nosql($rcc['kd']);
	$cc_nama = balikin($rcc['nama']);



	//ketahui nilai
	$qnil = mysql_query("SELECT m_uang_les.*, siswa_kelas.* ".
				"FROM m_uang_les, siswa_kelas ".
				"WHERE siswa_kelas.kd_tapel = m_uang_les.kd_tapel ".
				"AND siswa_kelas.kd_kelas = m_uang_les.kd_kelas ".
				"AND m_uang_les.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_siswa = '$cc_kd'");
	$rnil = mysql_fetch_assoc($qnil);
	$tnil = mysql_num_rows($qnil);
	$nil_kelkd = nosql($rnil['kd_kelas']);



	//jika ada
	if ($tcc != 0)
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$nil_kelkd&nis=$nis&swkd=$cc_kd";
		xloc($ke);
		exit();
		}
	else
		{
		//re-direct
		$pesan = "Tidak Ada Siswa dengan NIS : $nis. Harap Diperhatikan.";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$nil_kelkd";
		pekem($pesan,$ke);
		exit();
		}
	}
}





//jika simpan
if ($_POST['btnSMP'])
{
//nilai
$tapelkd = nosql($_POST['tapelkd']);
$kelkd = nosql($_POST['kelkd']);
$nis = nosql($_POST['nis']);
$swkd = nosql($_POST['swkd']);
$nil_bayar = nosql($_POST['nil_bayar']);


//total uang les
$qpkl = mysql_query("SELECT * FROM m_uang_les ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND kd_kelas = '$kelkd'");
$rpkl = mysql_fetch_assoc($qpkl);
$pkl_kd = nosql($rpkl['kd']);
$pkl_nilai = nosql($rpkl['nilai']);


//yang telah dibayar
$qcc = mysql_query("SELECT SUM(siswa_uang_les.nilai) AS nilaix ".
			"FROM siswa_uang_les, m_uang_les ".
			"WHERE siswa_uang_les.kd_uang_les = m_uang_les.kd ".
			"AND siswa_uang_les.kd_siswa = '$swkd' ".
			"AND siswa_uang_les.kd_tapel = '$tapelkd");
$rcc = mysql_fetch_assoc($qcc);
$cc_nilai = nosql($rcc['nilaix']);


//cek
if (empty($nil_bayar))
{
//re-direct
$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&nis=$nis&swkd=$swkd";
pekem($pesan,$ke);
exit();
}
else
{

//jika melebihi...
if (($cc_nilai + $nil_bayar) > $pkl_nilai)
	{
	//re-direct
	$pesan = "Jumlah Uang Yang Dibayarkan, Melebihi Jumlah Total Sisa Yang Ada. Harap Diperhatikan...!!";
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&nis=$nis&swkd=$swkd";
	pekem($pesan,$ke);
	exit();
	}

//jika kurang
else if ((($cc_nilai + $nil_bayar) < $pkl_nilai) OR (($cc_nilai + $nil_bayar) == $pkl_nilai))
	{
	mysql_query("INSERT INTO siswa_uang_les (kd, kd_tapel, kd_kelas, kd_siswa, tgl_bayar, nilai, postdate) VALUES ".
			"('$x', '$tapelkd', '$kelkd', '$swkd', '$today', '$nil_bayar', '$today3')");

	//re-direct
	$ke = "siswa_les_prt.php?tapelkd=$tapelkd&kelkd=$kelkd&nis=$nis&swkd=$swkd";
	xloc($ke);
	exit();
	}
}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/js/jam.js");
require("../../inc/js/down_enter.js");
require("../../inc/menu/admbdh.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';

echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
{
echo '<p>
<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
</p>';
}

else
{
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top" width="500">

<p>
Hari/Tanggal/Jam :
<br>
<input name="display_tgl" type="text" size="25" value="'.$arrhari[$hari].', '.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'" class="input" readonly>
<input type="text" name="display_jam" size="5" style="text-align:right" class="input" readonly>
</p>

<p>
NIS :
<br>
<input name="nis"
type="text"
size="20"
value="'.$nis.'"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnOK.focus();
	document.formx.btnOK.submit();
	}"
onKeyPress="return numbersonly(this, event)">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="btnOK" type="submit" value=">>">
</p>';

if (!empty($nis))
{
//cek
$qcc = mysql_query("SELECT * FROM m_siswa ".
						"WHERE nis = '$nis'");
$rcc = mysql_fetch_assoc($qcc);
$tcc = mysql_num_rows($qcc);
$cc_kd = nosql($rcc['kd']);
$cc_nama = balikin($rcc['nama']);


//ketahui nilai per bulan
$qnil = mysql_query("SELECT m_uang_les.*, siswa_kelas.* ".
			"FROM m_uang_les, siswa_kelas ".
			"WHERE siswa_kelas.kd_tapel = m_uang_les.kd_tapel ".
			"AND siswa_kelas.kd_kelas = m_uang_les.kd_kelas ".
			"AND m_uang_les.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_siswa = '$cc_kd'");
$rnil = mysql_fetch_assoc($qnil);
$tnil = mysql_num_rows($qnil);
$nil_kelkd = nosql($rnil['kd_kelas']);
$nil_progkd = nosql($rnil['kd_program']);
$nil_rukd = nosql($rnil['kd_ruang']);
$nil_uang = nosql($rnil['nilai']);

//total uang
$cc_sebesar = $jml_bln * $nil_uang;




//programnya...
$qpro = mysql_query("SELECT * FROM m_program ".
			"WHERE kd = '$nil_progkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);



//kelasnya...
$qkel = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$nil_kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = balikin($rkel['kelas']);


//ruangnya...
$qru = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$nil_rukd'");
$rru = mysql_fetch_assoc($qru);
$ru_ruang = balikin($rru['ruang']);




echo '<p>
Nama Siswa :
<br>
<input name="nama" type="text" value="'.$cc_nama.'" size="30" class="input" readonly>
</p>

<p>
Kelas/Program/Ruang :
<br>
<input name="kelru" type="text" value="'.$kel_kelas.'/'.$pro_program.'/'.$ru_ruang.'" size="10" class="input" readonly>
</p>

<p>
Pembayaran :
<br>
<input name="bayar" type="text" value="LES" size="10" class="input" readonly>
</p>


<p>
Jumlah Uang Yang Dibayar :
<br>
Rp.
<input name="nil_bayar"
type="text"
size="10"
value=""
style="text-align:right"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	document.formx.btnSMP.submit();
	}"
onKeyPress="return numbersonly(this, event)">,00
</p>';


//total uang . . .
$qpkl = mysql_query("SELECT * FROM m_uang_les ".
			"WHERE kd_tapel = '$tapelkd' ".
			"AND kd_kelas = '$kelkd'");
$rpkl = mysql_fetch_assoc($qpkl);
$pkl_nilai = nosql($rpkl['nilai']);


//yang telah dibayar
$qccx = mysql_query("SELECT SUM(siswa_uang_les.nilai) AS total ".
			"FROM siswa_uang_les ".
			"WHERE siswa_uang_les.kd_tapel = '$tapelkd' ".
			"AND siswa_uang_les.kd_kelas = '$kelkd' ".
			"AND siswa_uang_les.kd_siswa = '$cc_kd'");
$rccx = mysql_fetch_assoc($qccx);
$ccx_nilai = nosql($rccx['total']);

//sisa
$nil_sisa = $pkl_nilai - $ccx_nilai;


echo '<p>
Sisa :
<br>
Rp.	<input name="nil_sisa" type="text" size="10" value="'.$nil_sisa.'" style="text-align:right" class="input" readonly>,00
</p>


<p>
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$nil_kelkd.'">
<input name="swkd" type="hidden" value="'.$cc_kd.'">
<input name="btnSMP" type="submit" value="SIMPAN dan CETAK">
<input name="btnBTL" type="submit" value="BATAL">
<br>
[END : Entri Siswa Lainnya].
[DELETE : Batal Entri].
</p>';
}


echo '</td>
<td width="10">&nbsp;</td>
<td valign="top">';

//nek ada
if ($tcc != 0)
{
echo '<p>
<table height="300" border="1" cellspacing="0" cellpadding="3">
<tr valign="top">
<td valign="top">


<strong>HISTORY PEMBAYARAN</strong>
('.xduit2($nil_uang).')';


//total bayar
$qdftx2 = mysql_query("SELECT SUM(siswa_uang_les.nilai) AS total ".
			"FROM siswa_uang_les ".
			"WHERE siswa_uang_les.kd_siswa = '$cc_kd' ".
			"AND siswa_uang_les.kd_tapel = '$tapelkd' ".
			"AND siswa_uang_les.kd_kelas = '$kelkd'");
$rdftx2 = mysql_fetch_assoc($qdftx2);
$dftx2_total = nosql($rdftx2['total']);


//keterangan
if ($dftx2_total == $nil_uang)
	{
	$nil_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
	}
else
	{
	$nil_ket = "<font color=\"blue\"><strong>Belum Lunas</strong></font>";
	}



//daftar
$qdftx = mysql_query("SELECT siswa_uang_les.*, siswa_uang_les.kd AS sukd, ".
			"siswa_uang_les.nilai AS sunil, ".
			"DATE_FORMAT(siswa_uang_les.tgl_bayar, '%d') AS xtgl, ".
			"DATE_FORMAT(siswa_uang_les.tgl_bayar, '%m') AS xbln, ".
			"DATE_FORMAT(siswa_uang_les.tgl_bayar, '%Y') AS xthn ".
			"FROM siswa_uang_les ".
			"WHERE siswa_uang_les.kd_siswa = '$cc_kd' ".
			"AND siswa_uang_les.kd_tapel = '$tapelkd' ".
			"AND siswa_uang_les.kd_kelas = '$kelkd' ".
			"ORDER BY siswa_uang_les.tgl_bayar DESC");
$rdftx = mysql_fetch_assoc($qdftx);
$tdftx = mysql_num_rows($qdftx);

echo '<table border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
<td width="50" align="center"><strong><font color="'.$warnatext.'">&nbsp;</font></strong></td>
</tr>';


//jika gak null
if ($tdftx != 0)
	{
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

		//nilai
		$dft_kd = nosql($rdftx['sukd']);
		$dft_nilai = nosql($rdftx['sunil']);
		$dft_xtgl = nosql($rdftx['xtgl']);
		$dft_xbln = nosql($rdftx['xbln']);
		$dft_xthn = nosql($rdftx['xthn']);
		$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";

		//jika null
		if ($dft_tgl_bayar == "00/00/0000")
			{
			$dft_tgl_bayar = "-";
			}

		$dft_hapus = "[<a href=\"$filenya?s=hapus&tapelkd=$tapelkd&nis=$nis&swkd=$cc_kd&kd=$dft_kd\">HAPUS</a>]";



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		'.$dft_tgl_bayar.'
		</td>
		<td align="right">
		'.xduit2($dft_nilai).'
		</td>
		<td>
		[<a href="'.$filenya.'?s=hapus&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&nis='.$nis.'&swkd='.$cc_kd.'&kd='.$dft_kd.'">HAPUS</a>]
		</td>
		</tr>';
		}
	while ($rdftx = mysql_fetch_assoc($qdftx));
	}

echo '</table>
<p>
Total Bayar :
<br>
Rp.	<input name="nil_total" type="text" size="10" value="'.$dftx2_total.'" style="text-align:right" class="input" readonly>,00
</p>

<p>
Keterangan :
<br>
'.$nil_ket.'
</p>
</p>';



echo '</td>
</tr>
</table>
</p>';
}


echo '</td>
</tr>
</table>';
}

echo '</form>
<br>
<br>
<br>';
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