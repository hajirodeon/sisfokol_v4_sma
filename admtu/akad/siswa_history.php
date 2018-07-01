<?php
 




session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admtu.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_history.php";
$judul = "History Kelas";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$rukd = nosql($_REQUEST['rukd']);
$swkd = nosql($_REQUEST['swkd']);

$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&rukd=$rukd&swkd=$swkd";




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
else if (empty($rukd))
	{
	$diload = "document.formx.ruang.focus();";
	}
else if (empty($swkd))
	{
	$diload = "document.formx.siswa.focus();";
	}







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

$qbt = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd <> '$kelkd' ".
						"ORDER BY round(no) ASC");
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
$qkeax = mysql_query("SELECT * FROM m_program ".
						"WHERE kd = '$progkd'");
$rowkeax = mysql_fetch_assoc($qkeax);

$keax_kd = nosql($rowkeax['kd']);
$keax_pro = balikin($rowkeax['program']);

echo '<option value="'.$keax_kd.'">'.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_program ".
						"WHERE kd <> '$progkd' ".
						"ORDER BY program ASC");
$rowkea = mysql_fetch_assoc($qkea);

do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_pro = balikin($rowkea['program']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$kea_kd.'">'.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&rukd='.$stkd.'">'.$struang.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Siswa : ';
echo "<select name=\"siswa\" onChange=\"MM_jumpMenu('self',this,0)\">";
//terpilih
$qswx = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_program = '$progkd' ".
						"AND siswa_kelas.kd_ruang = '$rukd' ".
						"AND siswa_kelas.kd_siswa = '$swkd'");
$rowswx = mysql_fetch_assoc($qswx);

$swx_kd = nosql($rowswx['mskd']);
$swx_nis = nosql($rowswx['nis']);
$swx_nm = balikin($rowswx['nama']);


echo '<option value="'.$swx_kd.'">'.$swx_nis.'. '.$swx_nm.'</option>';

$qsw = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"AND siswa_kelas.kd_program = '$progkd' ".
						"AND siswa_kelas.kd_ruang = '$rukd' ".
						"AND siswa_kelas.kd_siswa <> '$swkd' ".
						"ORDER BY round(nis) ASC");
$rowsw = mysql_fetch_assoc($qsw);

do
	{
	$sw_kd = nosql($rowsw['mskd']);
	$sw_nis = nosql($rowsw['nis']);
	$sw_nm = balikin($rowsw['nama']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&rukd='.$rukd.'&swkd='.$sw_kd.'">'.$sw_nis.'. '.$sw_nm.'</option>';
	}
while ($rowsw = mysql_fetch_assoc($qsw));

echo '</select>
</td>
</tr>
</table>';

//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
	}

else if (empty($kelkd))
	{
	echo '<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>';
	}

else if (empty($progkd))
	{
	echo '<font color="#FF0000"><strong>PROGRAM Belum Dipilih...!</strong></font>';
	}

else if (empty($swkd))
	{
	echo '<font color="#FF0000"><strong>SISWA Belum Dipilih...!</strong></font>';
	}

else
	{
	//query
	$qhst = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.*, ".
				"m_tapel.*, m_kelas.* ".
				"FROM m_siswa, siswa_kelas, m_tapel, m_kelas ".
				"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
				"AND siswa_kelas.kd_kelas = m_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_siswa = '$swkd' ".
				"ORDER BY round(m_tapel.tahun1) ASC, round(m_kelas.no) ASC");
	$rhst = mysql_fetch_assoc($qhst);

	echo '<br>
	<table width="500" border="1" cellpadding="3" cellspacing="0">
    	<tr bgcolor="'.$warnaheader.'">
	<td width="100"><strong>Tahun Pelajaran</strong></td>
	<td><strong>Program</strong></td>
	<td width="100"><strong>Kelas/Ruang</strong></td>
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
		$d_thn1 = nosql($rhst['tahun1']);
		$d_thn2 = nosql($rhst['tahun2']);
		$d_kelas = nosql($rhst['kelas']);
		$d_kd_program = nosql($rhst['kd_program']);
		$d_kd_ruang = nosql($rhst['kd_ruang']);

		//program
		$qprgx2 = mysql_query("SELECT * FROM m_program ".
					"WHERE kd = '$d_kd_program'");
		$rowprgx2 = mysql_fetch_assoc($qprgx2);
		$d_program = balikin($rowprgx2['program']);


		//ruang
		$qstx2 = mysql_query("SELECT * FROM m_ruang ".
					"WHERE kd = '$d_kd_ruang'");
		$rowstx2 = mysql_fetch_assoc($qstx2);
		$d_ruang = nosql($rowstx2['ruang']);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top">
		'.$d_thn1.'/'.$d_thn2.'
		</td>
		<td valign="top">
		'.$d_program.'
		</td>
		<td valign="top">
		'.$d_kelas.'/'.$d_ruang.'
		</td>
		</tr>';
		}
	while ($rhst = mysql_fetch_assoc($qhst));

	echo '</table>';
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