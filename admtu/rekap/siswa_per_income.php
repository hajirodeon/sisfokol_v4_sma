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
$filenya = "siswa_per_income.php";
$judul = "Rekap Data : Siswa (Berdasarkan Income Orang Tua)";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;
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

	$sqlcount = "SELECT m_siswa.*, ".
			"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS tgl, ".
			"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS bln, ".
			"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS thn, ".
			"m_siswa.kd AS mskd, ".
			"siswa_kelas.*, m_kelas.*, m_ruang.*, m_siswa_ayah.* ".
			"FROM m_siswa, siswa_kelas, m_kelas, m_ruang, m_siswa_ayah ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_kelas = m_kelas.kd ".
			"AND siswa_kelas.kd_ruang = m_ruang.kd ".
			"AND m_siswa_ayah.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"ORDER BY round(m_siswa_ayah.penghasilan) ASC";
	$sqlresult = $sqlcount;

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
		[<a href="siswa_per_income_pdf.php?tapelkd='.$tapelkd.'"><img src="'.$sumber.'/img/pdf.gif" border="0" width="16" height="16"></a>]
		</p>

		<table width="100%" border="1" cellpadding="3" cellspacing="0">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td width="150"><strong>Nama</strong></td>
		<td width="5"><strong>L/P</strong></td>
		<td width="20"><strong>Kelas</strong></td>
		<td width="150"><strong>TTL.</strong></td>
		<td width="100"><strong>Asal Sekolah</strong></td>
		<td width="75"><strong>Nama ORTU</strong></td>
		<td width="75"><strong>Pekerjaan ORTU</strong></td>
		<td width="75"><strong>Penghasilan</strong></td>
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
			$kd = nosql($data['mskd']);
			$nis = nosql($data['nis']);
			$nisn = nosql($data['nisn']);
			$nama = balikin($data['nama']);
			$kd_kelamin = nosql($data['kd_kelamin']);
			$tmp_lahir = balikin2($data['tmp_lahir']);
			$tgl_lahir = nosql($data['tgl']);
			$bln_lahir = nosql($data['bln']);
			$thn_lahir = nosql($data['thn']);
			$kelas = balikin($data['kelas']);
			$ruang = nosql($data['ruang']);
			$penghasilan = nosql($data['penghasilan']);



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
			$tun_kd_pendidikan = nosql($rtun['kd_pendidikan']);




			$dt_ayah_pekerjaan = balikin($rtun['kd_pekerjaan']);
			$qayah_pek = mysql_query("SELECT * FROM m_pekerjaan ".
							"WHERE kd = '$dt_ayah_pekerjaan'");
			$rayah_pek = mysql_fetch_assoc($qayah_pek);
			$dt_ayah_pekerjaan = balikin($rayah_pek['pekerjaan']);




			//lulusan dari
			$qpend = mysql_query("SELECT * FROM m_siswa_pendidikan ".
						"WHERE kd_siswa = '$kd'");
			$rpend = mysql_fetch_assoc($qpend);
			$nama_sekolah = balikin2($rpend['nama_sekolah']);
			$uasbn = nosql($rpend['r_uasbn']);



			//detail penghasilan
			if ($penghasilan < '250000')
				{
				$dt_ket = "...<250.000";
				}
			else if (($penghasilan >= '250000') AND ($penghasilan < '500000'))
				{
				$dt_ket = "250RB - 500RB";
				}
			else if (($penghasilan >= '500000') AND ($penghasilan < '750000'))
				{
				$dt_ket = "500RB - 750RB";
				}
			else if (($penghasilan >= '750000') AND ($penghasilan < '1000000'))
				{
				$dt_ket = "750RB - 1Jt";
				}
			else if (($penghasilan >= '1000000') AND ($penghasilan < '1500000'))
				{
				$dt_ket = "1Jt - 1.5Jt";
				}
			else if ($penghasilan >= '1500000')
				{
				$dt_ket = "...> 1.5Jt";
				}



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">
			'.$nis.'
			</td>
			<td valign="top">
			'.$nama.'
			</td>
			<td valign="top">
			'.$min_kelamin.'
			</td>
			<td valign="top">
			'.$kelas.'/'.$ruang.'
			</td>
			<td valign="top">
			'.$tmp_lahir.', '.$tgl_lahir.' '.$arrbln1[$bln_lahir].' '.$thn_lahir.'
			</td>
			<td valign="top">
			'.$nama_sekolah.'
			</td>

			<td valign="top">
			'.$tun_nama.'
			</td>

			<td valign="top">
			'.$dt_ayah_pekerjaan.'
			</td>

			<td valign="top">
			'.$dt_ket.'
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