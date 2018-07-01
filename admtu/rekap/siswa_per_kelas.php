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
$filenya = "siswa_per_kelas.php";
$judul = "Rekap Data : Siswa (Berdasarkan Kelas)";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$rukd = nosql($_REQUEST['rukd']);
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
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else if (empty($rukd))
	{
	$diload = "document.formx.ruang.focus();";
	}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admtu.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
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

Ruang : ';
echo "<select name=\"ruang\" onChange=\"MM_jumpMenu('self',this,0)\">";

//ruang
$qstx = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$rukd'");
$rowstx = mysql_fetch_assoc($qstx);

$ruang = nosql($rowstx['ruang']);

echo '<option value="'.$rukd.'" selected>'.$ruang.'</option>';

$qst = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd <> '$rukd'");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$stkd = nosql($rowst['kd']);
	$struang = balikin($rowst['ruang']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$stkd.'">'.$struang.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
	}

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	if (empty($kelkd))
		{
		$sqlcount = "SELECT DISTINCT(m_siswa.nis) AS msnis ".
				"FROM m_siswa, siswa_kelas, m_kelas, m_ruang, m_kelamin ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_kelas = m_kelas.kd ".
				"AND siswa_kelas.kd_ruang = m_ruang.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"ORDER BY m_kelas.no ASC, ".
				"m_ruang.ruang ASC, ".
				"m_kelamin.kelamin ASC, ".
				"m_siswa.nama ASC";
		$sqlresult = $sqlcount;
		}
	else if (empty($rukd))
		{
		$sqlcount = "SELECT DISTINCT(m_siswa.nis) AS msnis ".
				"FROM m_siswa, siswa_kelas, m_kelas, m_ruang, m_kelamin ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_kelas = m_kelas.kd ".
				"AND siswa_kelas.kd_ruang = m_ruang.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kelkd' ".
				"ORDER BY m_kelas.no ASC, ".
				"m_ruang.ruang ASC, ".
				"m_kelamin.kelamin ASC, ".
				"m_siswa.nama ASC";
		$sqlresult = $sqlcount;
		}
	else
		{
		$sqlcount = "SELECT DISTINCT(m_siswa.nis) AS msnis ".
				"FROM m_siswa, siswa_kelas, m_kelas, m_ruang, m_kelamin ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_kelas = m_kelas.kd ".
				"AND siswa_kelas.kd_ruang = m_ruang.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kelkd' ".
				"AND siswa_kelas.kd_ruang = '$rukd' ".
				"ORDER BY m_kelas.no ASC, ".
				"m_ruang.ruang ASC, ".
				"m_kelamin.kelamin ASC, ".
				"m_siswa.nama ASC";
		$sqlresult = $sqlcount;
		}

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);




	//nek ada
	if ($count != 0)
		{
		echo '<p>
		[<a href="siswa_per_kelas_pdf.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'"><img src="'.$sumber.'/img/pdf.gif" border="0" width="16" height="16"></a>]
		</p>

		<table width="100%" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td width="150"><strong>Nama</strong></td>
		<td width="5"><strong>L/P</strong></td>
		<td width="20"><strong>Kelas</strong></td>
		<td width="150"><strong>TTL.</strong></td>
		<td width="100"><strong>Asal Sekolah</strong></td>
		<td width="75"><strong>R.UASBN</strong></td>
		<td width="75"><strong>Nama ORTU</strong></td>
		<td width="75"><strong>Pddkn. ORTU</strong></td>
		<td width="75"><strong>Pekerjaan ORTU</strong></td>
		<td><strong>Alamat</strong></td>
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


			//nilai
			$i_nis = nosql($data['msnis']);


			if (empty($kelkd))
				{
				//detail siswa
				$qdtx = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
							"siswa_kelas.*, ".
							"m_kelas.*, ".
							"m_ruang.*, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn ".
							"FROM m_siswa, siswa_kelas, m_kelas, m_ruang ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_kelas = m_kelas.kd ".
							"AND siswa_kelas.kd_ruang = m_ruang.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND m_siswa.nis = '$i_nis'");
				$rdtx = mysql_fetch_assoc($qdtx);
				}
			else if (empty($rukd))
				{
				//detail siswa
				$qdtx = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
							"siswa_kelas.*, ".
							"m_kelas.*, ".
							"m_ruang.*, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn ".
							"FROM m_siswa, siswa_kelas, m_kelas, m_ruang ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_kelas = m_kelas.kd ".
							"AND siswa_kelas.kd_ruang = m_ruang.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND m_siswa.nis = '$i_nis'");
				$rdtx = mysql_fetch_assoc($qdtx);
				}
			else
				{
				//detail siswa
				$qdtx = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
							"siswa_kelas.*, ".
							"m_kelas.*, ".
							"m_ruang.*, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
							"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn ".
							"FROM m_siswa, siswa_kelas, m_kelas, m_ruang ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_kelas = m_kelas.kd ".
							"AND siswa_kelas.kd_ruang = m_ruang.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND siswa_kelas.kd_ruang = '$rukd' ".
							"AND m_siswa.nis = '$i_nis'");
				$rdtx = mysql_fetch_assoc($qdtx);
				}

			$i_kd = nosql($rdtx['mskd']);
			$i_nama = balikin($rdtx['nama']);
			$i_kd_kelamin = nosql($rdtx['kd_kelamin']);
			$i_tmp_lahir = balikin2($rdtx['tmp_lahir']);
			$i_tgl_lahir = nosql($rdtx['tgl']);
			$i_bln_lahir = nosql($rdtx['bln']);
			$i_thn_lahir = nosql($rdtx['thn']);
			$i_kelas = balikin($rdtx['kelas']);
			$i_ruang = nosql($rdtx['ruang']);


			//kelamin
			$qmin = mysql_query("SELECT * FROM m_kelamin ".
									"WHERE kd = '$i_kd_kelamin'");
			$rmin = mysql_fetch_assoc($qmin);
			$min_kelamin = balikin2($rmin['kelamin']);


			//orang tua - ayah
			$qtun = mysql_query("SELECT * FROM m_siswa_ayah ".
									"WHERE kd_siswa = '$i_kd'");
			$rtun = mysql_fetch_assoc($qtun);
			$tun_nama = balikin2($rtun['nama']);
			$tun_alamat = balikin2($rtun['alamat']);
			$tun_telp = balikin2($rtun['telp']);
			$tun_kd_pendidikan = nosql($rtun['kd_pendidikan']);

			$dt_ayah_pekerjaan = balikin($rtun['kd_pekerjaan']);
			$qayah_pek = mysql_query("SELECT * FROM m_pekerjaan ".
							"WHERE kd = '$dt_ayah_pekerjaan'");
			$rayah_pek = mysql_fetch_assoc($qayah_pek);
			$dt_ayah_pekerjaan = balikin($rayah_pek['pekerjaan']);


			//terpilih
			$qpki = mysql_query("SELECT * FROM m_pendidikan ".
						"WHERE kd = '$tun_kd_pendidikan'");
			$rpki = mysql_fetch_assoc($qpki);
			$dt_ayah_pendidikan = balikin($rpki['pendidikan']);



			//lulusan dari
			$qpend = mysql_query("SELECT * FROM m_siswa_pendidikan ".
						"WHERE kd_siswa = '$i_kd'");
			$rpend = mysql_fetch_assoc($qpend);
			$nama_sekolah = balikin2($rpend['nama_sekolah']);
			$uasbn = nosql($rpend['r_uasbn']);


			//tmp_tinggal
			$qtpg = mysql_query("SELECT * FROM m_siswa_tmp_tinggal ".
						"WHERE kd_siswa = '$i_kd'");
			$rtpg = mysql_fetch_assoc($qtpg);
			$dt_alamat = balikin($rtpg['alamat']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">
			'.$i_nis.'
			</td>
			<td valign="top">
			'.$i_nama.'
			</td>
			<td valign="top">
			'.$min_kelamin.'
			</td>
			<td valign="top">
			'.$i_kelas.'/'.$i_ruang.'
			</td>
			<td valign="top">
			'.$i_tmp_lahir.', '.$i_tgl_lahir.' '.$arrbln1[$i_bln_lahir].' '.$i_thn_lahir.'
			</td>
			<td valign="top">
			'.$nama_sekolah.'
			</td>
			<td valign="top">
			'.$uasbn.'
			</td>

			<td valign="top">
			'.$tun_nama.'
			</td>

			<td valign="top">
			'.$dt_ayah_pendidikan.'
			</td>

			<td valign="top">
			'.$dt_ayah_pekerjaan.'
			</td>

			<td valign="top">
			'.$dt_alamat.'
			</td>

			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="250">
		<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
		<input name="kelkd" type="hidden" value="'.$kelkd.'">
		<font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>TIDAK ADA DATA</strong>
		</font>.
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