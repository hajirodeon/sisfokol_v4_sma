<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admtu.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "per_tgl_tulis.php";
$judul = "Data Alumni per Tgl.Edit/Entri";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$crkd = nosql($_REQUEST['crkd']);
$crtipe = balikin($_REQUEST['crtipe']);
$kunci = cegah($_REQUEST['kunci']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&page=$page";







//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//reset
if ($_POST['btnRST'])
	{
	$tapelkd = nosql($_POST['tapelkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd";
	xloc($ke);
	exit();
	}





//cari
if ($_POST['btnCARI'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$crkd = nosql($_POST['crkd']);
	$crtipe = balikin2($_POST['crtipe']);
	$kunci = cegah($_POST['kunci']);


	//cek
	if ((empty($crkd)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Pencarian Tidak Lengkap. Harap diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
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
require("../../inc/js/number.js");
require("../../inc/menu/admtu.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="500">
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
<input name="s" type="hidden" value="'.$s.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
</td>
<td align="right">';
echo "<select name=\"katcari\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$filenya.'?crkd='.$crkd.'&crtipe='.$crtipe.'&kunci='.$kunci.'" selected>'.$crtipe.'</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&crkd=cr01&crtipe=NIS&kunci='.$kunci.'">NIS</option>
<option value="'.$filenya.'?tapelkd='.$tapelkd.'&crkd=cr02&crtipe=Nama&kunci='.$kunci.'">Nama</option>
</select>
<input name="kunci" type="text" value="'.$kunci.'" size="20">
<input name="crkd" type="hidden" value="'.$crkd.'">
<input name="crtipe" type="hidden" value="'.$crtipe.'">
<input name="btnCARI" type="submit" value="CARI >>">
<input name="btnRST" type="submit" value="RESET">
</td>
</tr>
</table>
<br>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
	}
else
	{
	//query DATA
	$tapelkd = nosql($_REQUEST['tapelkd']);


	//nis
	if ($crkd == "cr01")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%d') AS 2tgl, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%m') AS 2bln, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%Y') AS 2thn, ".
				"m_siswa.kd AS mskd, ".
				"siswa_kelas.*, m_kelas.*, m_siswa_perkembangan.* ".
				"FROM m_siswa, siswa_kelas, m_kelas, m_siswa_perkembangan ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_kelas = m_kelas.kd ".
				"AND m_kelas.no = '3' ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND m_siswa_perkembangan.alumni = 'true' ".
				"AND m_siswa.nis LIKE '%$kunci%' ".
				"ORDER BY round(m_siswa.nis) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//nama
	else if ($crkd == "cr02")
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%d') AS 2tgl, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%m') AS 2bln, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%Y') AS 2thn, ".
				"m_siswa.kd AS mskd, ".
				"siswa_kelas.*, m_kelas.*, m_siswa_perkembangan.* ".
				"FROM m_siswa, siswa_kelas, m_kelas, m_siswa_perkembangan ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_kelas = m_kelas.kd ".
				"AND m_kelas.no = '3' ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND m_siswa_perkembangan.alumni = 'true' ".
				"AND m_siswa.nama LIKE '%$kunci%' ".
				"ORDER BY round(m_siswa.nama) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	else
		{
		//query
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%d') AS 2tgl, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%m') AS 2bln, ".
				"DATE_FORMAT(m_siswa_perkembangan.tgl_tulis, '%Y') AS 2thn, ".
				"m_siswa.kd AS mskd, ".
				"siswa_kelas.*, m_kelas.*, m_siswa_perkembangan.* ".
				"FROM m_siswa, siswa_kelas, m_kelas, m_siswa_perkembangan ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_kelas = m_kelas.kd ".
				"AND m_kelas.no = '3' ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND m_siswa_perkembangan.alumni = 'true' ".
				"ORDER BY m_siswa_perkembangan.tgl_terima_ijazah ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&crkd=$crkd&crtipe=$crtipe&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}



	//nek ada
	if ($count != 0)
		{
		echo '[<a href="per_tgl_tulis_prt.php?tapelkd='.$tapelkd.'"><img src="'.$sumber.'/img/print.gif" border="0" width="16" height="16"></a>]

		<p>
		<table width="100%" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="150"><strong>Tgl.Edit/Entri</strong></td>
		<td width="50"><strong>NIS</strong></td>
		<td width="150"><strong>Nama</strong></td>
		<td width="5"><strong>L/P</strong></td>
		<td width="150"><strong>TTL.</strong></td>
		<td width="150"><strong>No.Ijazah</strong></td>
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

			$kd = nosql($data['mskd']);
			$kelkd = nosql($data['kd_kelas']);
			$nis = nosql($data['nis']);
			$nama = balikin($data['nama']);
			$no_sttb = balikin($data['no_sttb']);
			$kd_kelamin = nosql($data['kd_kelamin']);
			$tmp_lahir = balikin2($data['tmp_lahir']);
			$tgl_lahir = $data['tgl'];
			$bln_lahir = $data['bln'];
			$thn_lahir = $data['thn'];
			$tgl_terima = $data['2tgl'];
			$bln_terima = $data['2bln'];
			$thn_terima = $data['2thn'];


			//kelamin
			$qmin = mysql_query("SELECT * FROM m_kelamin ".
									"WHERE kd = '$kd_kelamin'");
			$rmin = mysql_fetch_assoc($qmin);
			$min_kelamin = balikin2($rmin['kelamin']);


			//orang tua - ayah
			$qtun = mysql_query("SELECT * FROM m_siswa_ayah ".
									"WHERE kd_siswa = '$kd'");
			$rtun = mysql_fetch_assoc($qtun);
			$tun_nama = balikin2($rtun['nama']);
			$tun_alamat = balikin2($rtun['alamat']);
			$tun_telp = balikin2($rtun['telp']);


			//lulusan dari
			$qpend = mysql_query("SELECT * FROM m_siswa_pendidikan ".
						"WHERE kd_siswa = '$kd'");
			$rpend = mysql_fetch_assoc($qpend);
			$nama_sekolah = balikin2($rpend['nama_sekolah']);



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<a href="../akad/siswa.php?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&swkd='.$kd.'&a=i#i"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>
			</td>
			<td valign="top">
			 '.$tgl_terima.' '.$arrbln1[$bln_terima].' '.$thn_terima.'
			</td>
			<td valign="top">
			'.$nis.'
			</td>
			<td valign="top">
			'.$nama.'
			</td>
			<td valign="top">
			'.$min_kelamin.'
			</td>
			<td valign="top">
			'.$tmp_lahir.', '.$tgl_lahir.' '.$arrbln1[$bln_lahir].' '.$thn_lahir.'
			</td>
			<td valign="top">
			'.$no_sttb.'
			</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="jml" type="hidden" value="'.$limit.'">
		<input name="s" type="hidden" value="'.$s.'">
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="total" type="hidden" value="'.$count.'">
		</td>
		<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
		</tr>
		</table>
		</p>';
		}

	else
		{
		echo '<p><font color="red">
		<strong>TIDAK ADA DATA</strong>
		</font>.</p>';
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