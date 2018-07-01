<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/admwk.php");
$tpl = LoadTpl("../template/index.html");

nocache;

//nilai
$filenya = "index.php";
$judul = "Detail Wali Kelas : $nip3_session.$nm3_session";
$judulku = "[$wk_session : $nip3_session.$nm3_session] ==> $judul";
$juduli = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);





//isi *START
ob_start();

//js
require("../inc/js/swap.js");
require("../inc/js/jumpmenu.js");
require("../inc/menu/admwk.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);

echo '<option value="'.nosql($rowtpx['kd']).'">'.nosql($rowtpx['tahun1']).'/'.nosql($rowtpx['tahun2']).'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd <> '$tapelkd' ".
			"ORDER BY tahun1 DESC");
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


//nek null
if (empty($tapelkd))
	{
	echo '<p>
	<font color="red">
	<strong>TAHUN PELAJARAN Belum Ditentukan...!!</strong>
	</font>
	</p>';
	}

else
	{
	echo '<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
	<tr valign="top">
	<td valign="top">';


	//data ne
	$qdty = mysql_query("SELECT m_pegawai.*, m_walikelas.*, m_tapel.* ".
				"FROM m_pegawai, m_walikelas, m_tapel ".
				"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
				"AND m_walikelas.kd_tapel = m_tapel.kd ".
				"AND m_pegawai.kd = '$kd3_session' ".
				"AND m_tapel.kd = '$tapelkd'");
	$rdty = mysql_fetch_assoc($qdty);
	$tdty = mysql_num_rows($qdty);

	echo '<table border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="150"><strong>Tahun Pelajaran</strong></td>
	<td width="50"><strong>Kelas</strong></td>
	<td width="100"><strong>Program</strong></td>
	<td width="50"><strong>Ruang</strong></td>
	<td width="50"><strong>Siswa</strong></td>
	<td width="50"><strong>Rangking</strong></td>
	<td width="50"><strong>Ledger Nilai</strong></td>
	<td width="50"><strong>Jadwal</strong></td>
	</tr>';

	//nek gak null
	if ($tdty != 0)
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
			$dty_tapelkd = nosql($rdty['kd_tapel']);
			$dty_kelkd = nosql($rdty['kd_kelas']);
			$dty_progkd = nosql($rdty['kd_program']);
			$dty_rukd = nosql($rdty['kd_ruang']);

			//tapel
			$qytapel = mysql_query("SELECT * FROM m_tapel ".
										"WHERE kd = '$dty_tapelkd'");
			$rytapel = mysql_fetch_assoc($qytapel);
			$ytapel_thn1 = nosql($rytapel['tahun1']);
			$ytapel_thn2 = nosql($rytapel['tahun2']);

			//kelas
			$qykel = mysql_query("SELECT * FROM m_kelas ".
										"WHERE kd = '$dty_kelkd'");
			$rykel = mysql_fetch_assoc($qykel);
			$ykel_kelas = nosql($rykel['kelas']);

			//program
			$qyprog = mysql_query("SELECT * FROM m_program ".
										"WHERE kd = '$dty_progkd'");
			$ryprog = mysql_fetch_assoc($qyprog);
			$yprog_prog = balikin($ryprog['program']);

			//ruang
			$qyru = mysql_query("SELECT * FROM m_ruang ".
									"WHERE kd = '$dty_rukd'");
			$ryru = mysql_fetch_assoc($qyru);
			$yru_ru = balikin($ryru['ruang']);

			//nek null
			if (empty($yprog_prog))
				{
				$yprog_prog = "-";
				}




			echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$ytapel_thn1.'/'.$ytapel_thn2.'</td>
			<td>'.$ykel_kelas.'</td>
			<td>'.$yprog_prog.'</td>
			<td>'.$yru_ru.'</td>
			<td>
			<a href="d/detail.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&rukd='.$dty_rukd.'&progkd='.$dty_progkd.'"
			title="DAFTAR SISWA. Tahun Pelajaran = '.$ytapel_thn1.'/'.$ytapel_thn2.', Kelas = '.$ykel_kelas.', Ruang = '.$yru_ru.', Program = '.$yprog_prog.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="d/rangking.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&rukd='.$dty_rukd.'&progkd='.$dty_progkd.'"
			title="RANGKING. Tahun Pelajaran = '.$ytapel_thn1.'/'.$ytapel_thn2.', Kelas = '.$ykel_kelas.', Ruang = '.$yru_ru.', Program = '.$yprog_prog.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="d/ledger_nilai.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&rukd='.$dty_rukd.'&progkd='.$dty_progkd.'"
			title="LEDGER NILAI. Tahun Pelajaran = '.$ytapel_thn1.'/'.$ytapel_thn2.', Kelas = '.$ykel_kelas.', Ruang = '.$yru_ru.', Program = '.$yprog_prog.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			<td>
			<a href="d/jadwal.php?tapelkd='.$dty_tapelkd.'&kelkd='.$dty_kelkd.'&rukd='.$dty_rukd.'&progkd='.$dty_progkd.'"
			title="JADWAL PELAJARAN. Tahun Pelajaran = '.$ytapel_thn1.'/'.$ytapel_thn2.', Kelas = '.$ykel_kelas.', Ruang = '.$yru_ru.', Program = '.$yprog_prog.'">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>
			</td>
			</tr>';
			}
		while ($rdty = mysql_fetch_assoc($qdty));
		}

	echo '</table>
	<br>
	<br>
	<br>

	<td valign="middle" align="center">
	<p>
	Anda Berada di <font color="blue"><strong>WALI KELAS AREA</strong></font>
	</p>
	<p><em>{Harap Dikelola Dengan Baik.)</em></p>
	<p>&nbsp;</p>
	</td>
	</tr>
	</table>';
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>