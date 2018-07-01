<?php
session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwk.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "rangking.php";
$judul = "Rangking";
$judulku = "[$wk_session : $nip3_session.$nm3_session] ==> $judul";
$juduli = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$rukd = nosql($_REQUEST['rukd']);
$smtkd = nosql($_REQUEST['smtkd']);
$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&rukd=$rukd&smtkd=$smtkd";





//isi *START
ob_start();

//js
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/menu/admwk.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table>
<tr>
<td>';
xheadline($judul);
echo '</td>
<td>[<a href="../index.php" title="Daftar Kelas">Daftar Kelas</a>]</td>
</table>';




//tapel
$qpel = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rpel = mysql_fetch_assoc($qpel);
$pel_thn1 = nosql($rpel['tahun1']);
$pel_thn2 = nosql($rpel['tahun2']);

//kelas
$qkel = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = nosql($rkel['kelas']);

//program
$qpro = mysql_query("SELECT * FROM m_program ".
						"WHERE kd = '$progkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);

//nek null
if (empty($pro_program))
	{
	$pro_program = "-";
	}


//ruang
$qru = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$rukd'");
$rru = mysql_fetch_assoc($qru);
$ru_ruang = balikin($rru['ruang']);




echo '<table bgcolor="'.$warnaover.'" width="100%" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<strong>Tahun Pelajaran :</strong> '.$pel_thn1.'/'.$pel_thn2.',
<strong>Kelas :</strong> '.$kel_kelas.',
<strong>Program :</strong> '.$pro_program.',
<strong>Ruang :</strong> '.$ru_ruang.',


<strong>Semester</strong> : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&rukd='.$rukd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>
<br>';


//nek drg
if (empty($smtkd))
	{
	echo '<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>';
	}

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
			"siswa_kelas.*, siswa_kelas.kd AS skkd, ".
			"siswa_rangking.* ".
			"FROM m_siswa, siswa_kelas, siswa_rangking ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_rangking.kd_siswa_kelas = siswa_kelas.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_program = '$progkd' ".
			"AND siswa_kelas.kd_ruang = '$rukd' ".
			"AND siswa_rangking.kd_smt = '$smtkd' ".
			"ORDER BY round(siswa_rangking.rangking) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	echo '<table width="400" border="1" cellpadding="3" cellspacing="0">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong>Rangking</strong></td>
	<td width="50"><strong>NIS</strong></td>
	<td><strong>Nama</strong></td>
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
		$i_kd = nosql($data['mskd']);
		$i_skkd = nosql($data['skkd']);
		$i_nis = nosql($data['nis']);
		$i_nama = balikin($data['nama']);
		$i_rangking = nosql($data['rangking']);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td valign="top" align="center">
		'.$i_rangking.'
		</td>
		<td valign="top">
		'.$i_nis.'
		</td>
		<td valign="top">
		'.$i_nama.'
		</td>
		</tr>';
		}
	while ($data = mysql_fetch_assoc($result));


	echo '</table>
	<font color="red">
	<strong>'.$count.'</strong>
	</font> Data. '.$pagelist.'';
	}

echo '<br><br><br>';
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