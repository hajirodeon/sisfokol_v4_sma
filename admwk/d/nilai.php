<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admwk.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nilai.php";
$swkd = nosql($_REQUEST['swkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$rukd = nosql($_REQUEST['rukd']);
$s = nosql($_REQUEST['s']);


$ke = "$filenya?swkd=$swkd&tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&rukd=$rukd";



//siswa ne
$qsiw = mysql_query("SELECT siswa_kelas.*, siswa_kelas.kd AS skkd, m_siswa.* ".
			"FROM siswa_kelas, m_siswa ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_program = '$progkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_ruang = '$rukd' ".
			"AND m_siswa.kd = '$swkd'");
$rsiw = mysql_fetch_assoc($qsiw);
$siw_nis = nosql($rsiw['nis']);
$siw_nama = balikin($rsiw['nama']);
$skkd = nosql($rsiw['skkd']);


//judul
$judul = "Nilai Siswa : ($siw_nis).$siw_nama";
$judulku = "[$wk_session : $nip3_session.$nm3_session] ==> $judul";
$juduly = $judul;


//focus
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}
else if (empty($mapelkd))
	{
	$diload = "document.formx.mapel.focus();";
	}



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admwk.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table>
<tr>
<td>';
xheadline($judul);
echo '</td>
<td>
[<a href="detail.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&rukd='.$rukd.'" title="Daftar Siswa">Daftar Siswa</a>]
</td>
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
<strong>Ruang :</strong> '.$ru_ruang.'
</td>
</tr>
</table>


<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_smt = nosql($rowstx['smt']);


echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst["kd"]);
	$st_smt = nosql($rowst["smt"]);

	echo '<option value="'.$filenya.'?swkd='.$swkd.'&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&rukd='.$rukd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
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
	echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td><strong>Mata Pelajaran</strong></td>';

	//looping jml. 10
	for ($i=1;$i<=10;$i++)
		{
		//nilai
		$nh = "NH";
		$xnh = "$nh$i";

		echo '<td width="10" align="center"><strong>'.$xnh.'</strong></td>';
		}

	echo '<td width="10"><strong>R.NH</strong></td>';


	//tugas
	for ($j=1;$j<=5;$j++)
		{
		echo '<td width="10"><strong>TGS'.$j.'</strong></td>';
		}


	echo '<td width="10"><strong>R.TGS</strong></td>
	<td width="10"><strong>UTS</strong></td>
	<td width="10"><strong>UAS</strong></td>';


	//tugas
	for ($ki=1;$ki<=5;$ki++)
		{
		echo '<td width="10"><strong>P'.$ki.'</strong></td>';
		}

	echo '
	<td width="10"><strong>U.P</strong></td>
	<td width="10"><strong>R.P</strong></td>
	<td width="10"><strong>TOTAL</strong></td>
	<td width="10"><strong>RAPORT</strong></td>
	<td width="10"><strong>SIKAP</strong></td>
	</tr>';


	//daftar
	$qstd = mysql_query("SELECT m_mapel.*, m_mapel.kd AS mpkd, m_mapel_kelas.* ".
				"FROM m_mapel, m_mapel_kelas ".
				"WHERE m_mapel_kelas.kd_mapel = m_mapel.kd ".
				"AND m_mapel_kelas.kd_tapel = '$tapelkd' ".
				"AND m_mapel_kelas.kd_kelas = '$kelkd' ".
				"AND m_mapel_kelas.kd_program = '$progkd' ".
				"ORDER BY round(m_mapel.no) ASC, ".
				"round(m_mapel.no_sub) ASC");
	$rowstd = mysql_fetch_assoc($qstd);

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

		$std_kd = nosql($rowstd['mpkd']);
		$std_pel = balikin2($rowstd['pel']);
		$std_mulo = nosql($rowstd['mulo']);

		//jika muatan lokal
		if ($std_mulo == "true")
			{
			$i_mapel = "Muatan Lokal --> $std_pel";
			}
		else
			{
			$i_mapel = "$std_pel";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_mapel.'</td>';

		//looping jml. NH
		for ($i=1;$i<=10;$i++)
			{
			//nilai
			$nh = "NH";
			$xnh = "$nh$i";
			$xnh2 = "$nh$i";

			//query
			$qnil = mysql_query("SELECT * FROM siswa_nh ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_mapel = '$std_kd' ".
						"AND left(nilkd,3) = '$xnh2'");
			$rnil = mysql_fetch_assoc($qnil);
			$tnil = mysql_num_rows($qnil);
			$nil_nh = nosql($rnil['nilai']);



			echo '<td align="right">'.$nil_nh.'</td>';
			}


		//nilainya
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_mapel ".
					"WHERE kd_siswa_kelas = '$skkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_mapel = '$std_kd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_tugas1 = nosql($rxpel['tugas1']);
		$xpel_tugas2 = nosql($rxpel['tugas2']);
		$xpel_tugas3 = nosql($rxpel['tugas3']);
		$xpel_tugas4 = nosql($rxpel['tugas4']);
		$xpel_tugas5 = nosql($rxpel['tugas5']);
		$xpel_tugas = nosql($rxpel['tugas']);
		$xpel_nh = nosql($rxpel['nh']);
		$xpel_uts = nosql($rxpel['uts']);
		$xpel_uas = nosql($rxpel['uas']);
		$xpel_praktek1 = nosql($rxpel['praktek1']);
		$xpel_praktek2 = nosql($rxpel['praktek2']);
		$xpel_praktek3 = nosql($rxpel['praktek3']);
		$xpel_praktek4 = nosql($rxpel['praktek4']);
		$xpel_praktek5 = nosql($rxpel['praktek5']);
		$xpel_u_praktek = nosql($rxpel['praktek_ujian']);
		$xpel_r_praktek = nosql($rxpel['praktek']);
		$xpel_sikap = nosql($rxpel['sikap']);



		$sni_rata = $xpel_nh;


		//total
		$xpel_total = round($sni_rata + $xpel_tugas + $xpel_uts + $xpel_uas);

		//require rumus
		require("../../inc/rumus_kognitif.php");


		echo '<td align="right"><strong>'.$sni_rata.'</strong></td>
		<td align="right">'.$xpel_tugas1.'</td>
		<td align="right">'.$xpel_tugas2.'</td>
		<td align="right">'.$xpel_tugas3.'</td>
		<td align="right">'.$xpel_tugas4.'</td>
		<td align="right">'.$xpel_tugas5.'</td>
		<td align="right"><strong>'.$xpel_tugas.'</strong></td>
		<td align="right"><strong>'.$xpel_uts.'</strong></td>
		<td align="right"><strong>'.$xpel_uas.'</strong></td>
		<td align="right">'.$xpel_praktek1.'</td>
		<td align="right">'.$xpel_praktek2.'</td>
		<td align="right">'.$xpel_praktek3.'</td>
		<td align="right">'.$xpel_praktek4.'</td>
		<td align="right">'.$xpel_praktek5.'</td>
		<td align="right">'.$xpel_u_praktek.'</td>
		<td align="right"><strong>'.$xpel_r_praktek.'</strong></td>
		<td align="right"><strong>'.$xpel_total.'</strong></td>
		<td align="right"><strong>'.$xpel_rata.'</strong></td>
		<td align="right"><strong>'.$xpel_sikap.'</strong></td>
		</tr>';
		}
	while ($rowstd = mysql_fetch_assoc($qstd));


	echo '</table>
	<br>';
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