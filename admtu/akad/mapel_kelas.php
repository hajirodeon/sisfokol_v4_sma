<?php
 



session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admtu.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "mapel_kelas.php";
$judul = "Mata Pelajaran Per Kelas";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd";



//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else if (empty($progkd))
	{
	$diload = "document.formx.program.focus();";
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$mapel = nosql($_POST['mapel']);
	$kkm = nosql($_POST['kkm']);

	//jika null
	if (empty($mapel))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT m_mapel_kelas.*, m_mapel.* ".
					"FROM m_mapel_kelas, m_mapel ".
					"WHERE m_mapel_kelas.kd_mapel = m_mapel.kd ".
					"AND m_mapel_kelas.kd_kelas = '$kelkd' ".
					"AND m_mapel_kelas.kd_program = '$progkd' ".
					"AND m_mapel_kelas.kd_mapel = '$mapel' ".
					"AND m_mapel_kelas.kd_tapel = '$tapelkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$pel = balikin2($rcc['pel']);

		//not null
		if ($tcc != 0)
			{
			//re-direct
			$pesan = "Mata Pelajaran Sudah Ada. Silahkan Ganti Yang Lain...!!";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//query
			mysql_query("INSERT INTO m_mapel_kelas(kd, kd_tapel, kd_kelas, kd_program, kd_mapel, kkm) VALUES ".
					"('$x', '$tapelkd', '$kelkd', '$progkd', '$mapel', '$kkm')");

			//diskonek
			xfree($qbw);
			xclose($koneksi);

			//re-direct
			xloc($ke);
			exit();
			}
		}
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);


	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM m_mapel_kelas ".
				"WHERE kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}





//jika simpan kkm
if ($_POST['btnSMP2'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);
	$progkd = nosql($_POST['progkd']);
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);


	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "i_kd";
		$yuhu = "$yuk$i";
		$kdku = nosql($_POST["$yuhu"]);

		$yuk2 = "i_kkm";
		$yuhu2 = "$yuk2$i";
		$kkmku = nosql($_POST["$yuhu2"]);

		//update
		mysql_query("UPDATE m_mapel_kelas SET kkm = '$kkmku' ".
				"WHERE kd = '$kdku'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admtu.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
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

echo '</select>,

Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

//kelas
$qbt = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd <> '$kelkd' ".
						"ORDER BY no ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,

Program : ';
echo "<select name=\"program\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbpx = mysql_query("SELECT * FROM m_program ".
						"WHERE kd = '$progkd'");
$rowbpx = mysql_fetch_assoc($qbpx);

$bpxkd = nosql($rowbpx['kd']);
$bpxprog = balikin($rowbpx['program']);

echo '<option value="'.$bpxkd.'">'.$bpxprog.'</option>';

//program
$qbp = mysql_query("SELECT * FROM m_program ".
						"WHERE kd <> '$progkd'");
$rowbp = mysql_fetch_assoc($qbp);

do
	{
	$bpkd = nosql($rowbp['kd']);
	$bpprog = balikin($rowbp['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$bpkd.'">'.$bpprog.'</option>';
	}
while ($rowbp = mysql_fetch_assoc($qbp));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
</td>
</tr>
</table>
<br>';


//nek blm
if (empty($tapelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">TAHUN PELAJARAN Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($kelkd))
	{
	echo '<p>
	<strong><font color="#FF0000">KELAS Belum Dipilih...!</font></strong>
	</p>';
	}
else if (empty($progkd))
	{
	echo '<p>
	<strong><font color="#FF0000">PROGRAM Belum Dipilih...!</font></strong>
	</p>';
	}
else
	{
	//query
	$q = mysql_query("SELECT m_mapel_kelas.*, m_mapel_kelas.kd AS mmkd, ".
				"m_mapel.* ".
				"FROM m_mapel_kelas, m_mapel ".
				"WHERE m_mapel_kelas.kd_mapel = m_mapel.kd ".
				"AND m_mapel_kelas.kd_kelas = '$kelkd' ".
				"AND m_mapel_kelas.kd_program = '$progkd' ".
				"AND m_mapel_kelas.kd_tapel = '$tapelkd' ".
				"ORDER BY round(m_mapel.no, m_mapel.no_sub) ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	echo '<select name="mapel">
    	<option value="" selected>-TAMBAH MATA PELAJARAN-</option>';

	//mapel
	$qsp = mysql_query("SELECT * FROM m_mapel ".
				"ORDER BY round(no) ASC, ".
				"round(no_sub) ASC");
	$rowsp = mysql_fetch_assoc($qsp);

	do
		{
		$i_spkd = nosql($rowsp['kd']);
		$i_spaspek = balikin2($rowsp['pel']);
		$i_mulo = nosql($rowsp['mulo']);

		//jika muatan lokal
		if ($i_mulo == "true")
			{
			echo '<option value="'.$i_spkd.'">Muatan Lokal --> '.$i_spaspek.'</option>';
			}
		else
			{
			echo '<option value="'.$i_spkd.'">'.$i_spaspek.'</option>';
			}
        	}
	while ($rowsp = mysql_fetch_assoc($qsp));

	echo '</select>,

	KKM : <INPUT type="text" name="kkm" size="5">

	<input name="btnSMP" type="submit" value="&gt;&gt;&gt;">';

	if ($total != 0)
		{
		echo '<table width="500" border="1" cellpadding="3" cellspacing="0">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td>&nbsp;</td>
		<td><strong><font color="'.$warnatext.'">Nama Mata Pelajaran</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">KKM</font></strong></td>
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
			$x_mmkd = nosql($row['mmkd']);
			$x_pel = balikin2($row['pel']);
			$x_mulo = nosql($row['mulo']);
			$x_kkm = nosql($row['kkm']);


			//jika muatan lokal
			if ($x_mulo == "true")
				{
				$x_pelx = "Muatan Lokal --> $x_pel";
				}
			else
				{
				$x_pelx = $x_pel;
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td width="20">
			<INPUT type="hidden" name="i_kd'.$nomer.'" value="'.$x_mmkd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$x_mmkd.'">
			</td>
			<td>'.$x_pelx.'</td>
			<td>
			<INPUT type="text" name="i_kkm'.$nomer.'" value="'.$x_kkm.'" size="5">
			</td>
			</tr>';
			}
		while ($row = mysql_fetch_assoc($q));

		echo '</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="326">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$total.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		<input name="btnSMP2" type="submit" value="SIMPAN">
		<input name="jml" type="hidden" value="'.$total.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<input name="progkd" type="hidden" value="'.$progkd.'">
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