<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbp.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "pelanggaran_siswa.php";
$judul = "Pelanggaran Siswa";
$judulku = "[$bk_session : $nip15_session.$nm15_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$kdx = nosql($_REQUEST['kdx']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$nis = nosql($_REQUEST['nis']);
$jnskd = nosql($_REQUEST['jnskd']);
$pelkd = nosql($_REQUEST['pelkd']);
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&page=$page";




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else
	{
	if (empty($utgl))
		{
		$diload = "document.formx.utglx.focus();";
		}
	else if (empty($ubln))
		{
		$diload = "document.formx.ublnx.focus();";
		}
	else if (empty($nis))
		{
		$diload = "document.formx.nis.focus();";
		}
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$ikd = nosql($_POST["$yuhu"]);

		//del
		mysql_query("DELETE FROM siswa_pelanggaran ".
				"WHERE kd = '$ikd'");
		}


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}





//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}




//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$utgl = nosql($_POST['utgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_entry = "$uthn:$ubln:$utgl";
	$nis = nosql($_POST['nis']);
	$s = nosql($_POST['s']);
	$kdx = nosql($_POST['kdx']);



	//cek
	if (empty($nis))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?s=$s&tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ($s == "baru")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa ".
						"WHERE nis = '$nis'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$cc_kd = nosql($rcc['kd']);

			//nek ada
			if ($tcc != 0)
				{
				mysql_query("INSERT INTO siswa_pelanggaran (kd, kd_tapel, kd_kelas, kd_siswa, ".
						"tgl) VALUES ".
						"('$x', '$tapelkd', '$kelkd', '$cc_kd', ".
						"'$tgl_entry')");

				//re-direct
				$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
				xloc($ke);
				exit();
				}
			else
				{
				//re-direct
				$pesan = "Tidak Ada Siswa dengan NIS : $nis. Harap Diperhatikan...!!";
				$ke = "$filenya?s=$s&tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
				pekem($pesan,$ke);
				exit();
				}
			}

		else if ($s == "edit")
			{
			//cek
			$qcc = mysql_query("SELECT * FROM m_siswa ".
						"WHERE nis = '$nis'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			$cc_kd = nosql($rcc['kd']);

			//update
			mysql_query("UPDATE siswa_pelanggaran SET kd_point = '$pointkd', ".
					"kd_siswa = '$cc_kd' ".
					"WHERE kd = '$kdx'");

			//re-direct
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
			xloc($ke);
			exit();
			}
		}
	}





//ke detail pelanggaran
if ($_POST['btnSMPx'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$utgl = nosql($_POST['utgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_entry = "$uthn:$ubln:$utgl";
	$nis = nosql($_POST['nis']);
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);
	$kdx = nosql($_POST['kdx']);



	//cek
	if ((empty($nis)) OR (empty($utgl)) OR (empty($ubln)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?s=$s&tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
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

		//nek ada
		if ($tcc != 0)
			{
			//re-direct
			$ke = "$filenya?s=$s&a=detail&nis=$nis&&tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Tidak Ada Siswa dengan NIS : $nis. Harap Diperhatikan...!!";
			$ke = "$filenya?s=$s&nis=$nis&tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
			pekem($pesan,$ke);
			exit();
			}
		}
	}






//simpan pelanggaran
if ($_POST['btnSMPx2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$utgl = nosql($_POST['utgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_entry = "$uthn:$ubln:$utgl";
	$nis = nosql($_POST['nis']);
	$s = nosql($_POST['s']);
	$a = nosql($_POST['a']);
	$jnskd = nosql($_POST['jnskd']);
	$pelkd = nosql($_POST['pelkd']);
	$kdx = nosql($_POST['kdx']);
	$swkd = nosql($_POST['swkd']);




	//cek
	if ((empty($jnskd)) OR (empty($pelkd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?s=$s&nis=$nis&a=detail&jnskd=$jnskd&tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//insert
		mysql_query("INSERT INTO siswa_pelanggaran (kd, kd_tapel, kd_kelas, ".
				"kd_siswa, tgl, kd_point) VALUES ".
				"('$x', '$tapelkd', '$kelkd', ".
				"'$swkd', '$tgl_entry', '$pelkd')");


		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&utgl=$utgl&ubln=$ubln&uthn=$uthn";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/menu/admbp.php");
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

	echo '<option value="'.$filenya.'?s='.$s.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
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
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd <> '$kelkd' ".
						"ORDER BY no ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);

	echo '<option value="'.$filenya.'?s='.$s.'&tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>


[<a href="'.$filenya.'?s=baru&tapelkd='.$tapelkd.'&smtkd='.$smtkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'">Tulis Baru</a>].

</td>
</tr>
</table>';

//jika entry
if ($s == "baru")
	{
	//nek blm dipilih
	if (empty($tapelkd))
		{
		echo '<p>
		<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
		</p>';
		}

	else if (empty($kelkd))
		{
		echo '<p>
		<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
		</p>';
		}

	else
		{
		echo '<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		Tanggal : ';
		echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
		echo '<option value="'.$utgl.'">'.$utgl.'</option>';
		for ($itgl=1;$itgl<=31;$itgl++)
			{
			echo '<option value="'.$filenya.'?s='.$s.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&utgl='.$itgl.'">'.$itgl.'</option>';
			}
		echo '</select>';

		echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
		echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
		for ($i=1;$i<=12;$i++)
			{
			//nilainya
			if ($i<=6) //bulan juli sampai desember
				{
				$ibln = $i + 6;

				echo '<option value="'.$filenya.'?s='.$s.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
				}

			else if ($i>6) //bulan januari sampai juni
				{
				$ibln = $i - 6;

				echo '<option value="'.$filenya.'?s='.$s.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
				}
			}

		echo '</select>
		</td>
		</tr>
		</table>';

		//query
		$qccx = mysql_query("SELECT m_siswa.* ".
					"FROM m_siswa ".
					"WHERE nis = '$nis'");
		$rccx = mysql_fetch_assoc($qccx);
		$tccx = mysql_num_rows($qccx);
		$e_swkd = nosql($rccx['kd']);
		$e_nama = balikin($rccx['nama']);






		//entry
		echo '<p>
		NIS :
		<br>
		<input type="text" name="nis" value="'.$nis.'" size="10" onKeyPress="return numbersonly(this, event)">
		<br>
		<br>

		<input type="submit" name="btnBTL" value="BATAL">
		<input type="submit" name="btnSMPx" value="DETAIL >>">
		<input type="hidden" name="s" value="'.$s.'">
		<input type="hidden" name="tapelkd" value="'.$tapelkd.'">
		<input type="hidden" name="kelkd" value="'.$kelkd.'">
		<input type="hidden" name="utgl" value="'.$utgl.'">
		<input type="hidden" name="ubln" value="'.$ubln.'">
		<input type="hidden" name="uthn" value="'.$uthn.'">
		<input type="hidden" name="kdx" value="'.$kdx.'">
		<input type="hidden" name="swkd" value="'.$e_swkd.'">
		</p>';



		//jika detail pelanggaran
		if ($a == "detail")
			{
			echo '<p>
			<hr>
			Nama Siswa : <strong>'.$nis.'.'.$e_nama.'</strong>
			<hr>
			</p>

			<p>
			<strong>PELANGGARAN YANG TELAH DILAKUKAN :</strong>
			</p>

			<p>
			Jenis Pelanggaran :
			<br>';
			echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

			//terpilih
			$qtpx = mysql_query("SELECT * FROM m_bk_point_jenis ".
						"WHERE kd = '$jnskd'");
			$rowtpx = mysql_fetch_assoc($qtpx);
			$tpx_kd = nosql($rowtpx['kd']);
			$tpx_no = balikin($rowtpx['no']);
			$tpx_jenis = balikin($rowtpx['jenis']);


			echo '<option value="'.$tpx_kd.'">'.$tpx_no.'.'.$tpx_jenis.'</option>';

			$qtp = mysql_query("SELECT * FROM m_bk_point_jenis ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY round(no) ASC");
			$rowtp = mysql_fetch_assoc($qtp);

			do
				{
				$tpkd = nosql($rowtp['kd']);
				$tpno = nosql($rowtp['no']);
				$tpjenis = balikin($rowtp['jenis']);

				echo '<option value="'.$filenya.'?s='.$s.'&a=detail&nis='.$nis.'&&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'&jnskd='.$tpkd.'">'.$tpno.'.'.$tpjenis.'</option>';
				}
			while ($rowtp = mysql_fetch_assoc($qtp));

			echo '</select>
			</p>

			<p>
			Nama Pelanggaran :
			<br>';
			echo "<select name=\"pelkd\" onChange=\"MM_jumpMenu('self',this,0)\">";

			//terpilih
			$qtpx = mysql_query("SELECT * FROM m_bk_point ".
						"WHERE kd_jenis = '$jnskd' ".
						"AND kd = '$pelkd'");
			$rowtpx = mysql_fetch_assoc($qtpx);
			$tpx_kd = nosql($rowtpx['kd']);
			$tpx_no = balikin2($rowtpx['no']);
			$tpx_nama = balikin2($rowtpx['nama']);
			$tpx_point = balikin2($rowtpx['point']);


			echo '<option value="'.$tpx_kd.'">'.$tpx_no.'.'.$tpx_nama.' ['.$tpx_point.']</option>';

			$qtpi = mysql_query("SELECT * FROM m_bk_point ".
						"WHERE kd_jenis = '$jnskd' ".
						"AND kd <> '$pelkd' ".
						"ORDER BY round(no) ASC");
			$rowtpi = mysql_fetch_assoc($qtpi);

			do
				{
				$i_kd = nosql($rowtpi['kd']);
				$i_no = balikin2($rowtpi['no']);
				$i_nama = balikin2($rowtpi['nama']);
				$i_point = balikin2($rowtpi['point']);
				$i_sanksi = balikin2($rowtpi['sanksi']);

				echo '<option value="'.$filenya.'?s='.$s.'&a=detail&nis='.$nis.'&&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'&jnskd='.$jnskd.'&pelkd='.$i_kd.'">'.$i_no.'.'.$i_nama.' ['.$i_point.']</option>';
				}
			while ($rowtpi = mysql_fetch_assoc($qtpi));

			echo '</select>
			</p>

			<p>

			<input type="submit" name="btnSMPx2" value="SIMPAN >>">
			<input type="hidden" name="s" value="'.$s.'">
			<input type="hidden" name="tapelkd" value="'.$tapelkd.'">
			<input type="hidden" name="kelkd" value="'.$kelkd.'">
			<input type="hidden" name="utgl" value="'.$utgl.'">
			<input type="hidden" name="ubln" value="'.$ubln.'">
			<input type="hidden" name="uthn" value="'.$uthn.'">
			<input type="hidden" name="jnskd" value="'.$jnskd.'">
			<input type="hidden" name="kdx" value="'.$kdx.'">
			<input type="hidden" name="nis" value="'.$nis.'">
			<input type="hidden" name="swkd" value="'.$e_swkd.'">
			</p>';
			}
		}
	}

else
	{
	//jika tapel
	if (empty($tapelkd))
		{
		//query
		$qcc = mysql_query("SELECT DISTINCT(kd_siswa) AS swkd ".
					"FROM siswa_pelanggaran ".
					"ORDER BY tgl DESC");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		}

	else if (empty($kelkd))
		{
		//query
		$qcc = mysql_query("SELECT DISTINCT(kd_siswa) AS swkd ".
					"FROM siswa_pelanggaran ".
					"WHERE kd_tapel = '$tapelkd' ".
					"ORDER BY tgl DESC");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		}

	else
		{
		//query
		$qcc = mysql_query("SELECT DISTINCT(kd_siswa) AS swkd ".
					"FROM siswa_pelanggaran ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_kelas = '$kelkd' ".
					"ORDER BY tgl DESC");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		}


	//jika ada
	if ($tcc != 0)
		{
		echo '<p>
		<table width="980" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="250"><strong><font color="'.$warnatext.'">Siswa</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Data Pelanggaran</font></strong></td>
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

			$i_nomer = $i_nomer + 1;
			$i_kd = nosql($rcc['swkd']);



			//detail siswa
			$qswi = mysql_query("SELECT * FROM m_siswa ".
						"WHERE kd = '$i_kd'");
			$rswi = mysql_fetch_assoc($qswi);
			$swi_nis = nosql($rswi['nis']);
			$swi_nama = balikin($rswi['nama']);


			//data pelanggaran
			$qdt = mysql_query("SELECT m_bk_point.*, siswa_pelanggaran.*, ".
						"DATE_FORMAT(siswa_pelanggaran.tgl, '%d') AS utgl, ".
						"DATE_FORMAT(siswa_pelanggaran.tgl, '%m') AS ubln,  ".
						"DATE_FORMAT(siswa_pelanggaran.tgl, '%Y') AS uthn ".
						"FROM m_bk_point, siswa_pelanggaran ".
						"WHERE siswa_pelanggaran.kd_point = m_bk_point.kd ".
						"AND siswa_pelanggaran.kd_siswa = '$i_kd'");
			$rdt = mysql_fetch_assoc($qdt);
			$tdt = mysql_num_rows($qdt);


			//data point pelanggaran
			$qdtx = mysql_query("SELECT SUM(m_bk_point.point) AS poi ".
						"FROM m_bk_point, siswa_pelanggaran ".
						"WHERE siswa_pelanggaran.kd_point = m_bk_point.kd ".
						"AND siswa_pelanggaran.kd_siswa = '$i_kd'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$dtx_point = nosql($rdtx['poi']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="checkbox" name="item'.$i_nomer.'" value="'.$i_kd.'">
        		</td>
			<td>

			<strong>'.$swi_nis.'. '.$swi_nama.'</strong>
			<br>
			[Jumlah Pelanggaran : <strong>'.$tdt.'</strong> kali].
			<br>
			[Total Point : <strong>'.$dtx_point.'</strong>].

			</td>
			<td>';



			do
				{
				//nilai
				$dt_utgl = nosql($rdt['utgl']);
				$dt_ubln = nosql($rdt['ubln']);
				$dt_uthn = nosql($rdt['uthn']);
				$dt_no = nosql($rdt['no']);
				$dt_nama = balikin($rdt['nama']);
				$dt_point = nosql($rdt['point']);
				$dt_sanksi = balikin($rdt['sanksi']);


				echo "<strong>$dt_utgl/$dt_ubln/$dt_uthn</strong>
				<br>
				$dt_nama. [<strong>Point:$dt_point</strong>].
				<br>
				<em>$dt_sanksi</em>
				<hr>";
				}
			while ($rdt = mysql_fetch_assoc($qdt));

			echo '</td>
        		</tr>';
			}
		while ($rcc = mysql_fetch_assoc($qcc));

		echo '</table>
		<table width="980" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="500">
		<input type="hidden" name="tapelkd" value="'.$tapelkd.'">
		<input type="hidden" name="kelkd" value="'.$kelkd.'">
		<input type="hidden" name="utgl" value="'.$utgl.'">
		<input type="hidden" name="ubln" value="'.$ubln.'">
		<input type="hidden" name="uthn" value="'.$uthn.'">
		<input name="jml" type="hidden" value="'.$tcc.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="kd" type="hidden" value="'.$kdx.'">
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tcc.')">
		<input name="btnBTL" type="reset" value="BATAL">
		<input name="btnHPS" type="submit" value="HAPUS">
		</td>
		<td align="right">Total : <strong><font color="#FF0000">'.$tcc.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>
		</p>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<b>TIDAK ADA DATA PELANGGARAN</b>
		</font>
		</p>';
		}
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