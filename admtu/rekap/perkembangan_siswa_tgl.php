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
$filenya = "perkembangan_siswa_tgl.php";
$ke = $filenya;


//judul
$judul = "Data Perkembangan Siswa per Tanggal";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$utgl2 = nosql($_REQUEST['utgl2']);
$ubln2 = nosql($_REQUEST['ubln2']);
$judulx = $judul;







//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admtu.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mulai Tanggal : ';
echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?utgl='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	echo '<option value="'.$filenya.'?utgl='.$utgl.'&ubln='.$i.'">'.$arrbln[$i].'</option>';
	}

echo '</select>,

Sampai : ';
echo "<select name=\"utglx2\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl2.'">'.$utgl2.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?utgl='.$utgl.'&ubln='.$ubln.'&utgl2='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx2\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln2.''.$uthn2.'" selected>'.$arrbln[$ubln2].' '.$uthn2.'</option>';
for ($i=1;$i<=12;$i++)
	{
	echo '<option value="'.$filenya.'?utgl='.$utgl.'&ubln='.$ubln.'&utgl2='.$utgl2.'&ubln2='.$i.'">'.$arrbln[$i].'</option>';
	}

echo '</select>
</td>
</tr>
</table>';




if ((empty($utgl)) OR (empty($utgl2)))
	{
	echo '<p>
	<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!</strong></font>
	</p>';
	}
else if ((empty($ubln)) OR (empty($ubln2)))
	{
	echo '<p>
	<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	echo '<p>
	[<a href="perkembangan_siswa_tgl_pdf.php?utgl='.$utgl.'&ubln='.$ubln.'&utgl2='.$utgl2.'&ubln2='.$ubln2.'"><img src="'.$sumber.'/img/pdf.gif" border="0" width="16" height="16"></a>]
	</p>

	<TABLE BORDER=1 CELLPADDING=3 CELLSPACING=0>
	<TR ALIGN="CENTER" bgcolor="'.$warnaheader.'">
		<TD ROWSPAN=3>
		<strong>TAHUN PELAJARAN</strong>
		</TD>
		<TD COLSPAN=9>
		<strong>AWAL TAHUN PELAJARAN</strong>
		</TD>
		<TD COLSPAN=9>
		<strong>MUTASI MASUK</strong>
		</TD>
		<TD COLSPAN=9>
		<strong>MUTASI KELUAR</strong>
		</TD>
		<TD COLSPAN=9>
		<strong>AKHIR TAHUN PELAJARAN</strong>
		</TD>
	</TR>

	<TR ALIGN="CENTER" bgcolor="'.$warnaheader.'">
		<TD COLSPAN=3>
		<strong>Kelas VII</strong>
		</TD>
		<TD COLSPAN=3>
		<strong>Kelas VIII</strong>
		</TD>
		<TD COLSPAN=3>
		<strong>Kelas IX</strong>
		</TD>

		<TD COLSPAN=3>
		<strong>Kelas VII</strong>
		</TD>
		<TD COLSPAN=3>
		<strong>Kelas VIII</strong>
		</TD>
		<TD COLSPAN=3>
		<strong>Kelas IX</strong>
		</TD>

		<TD COLSPAN=3>
		<strong>Kelas VII</strong>
		</TD>
		<TD COLSPAN=3>
		<strong>Kelas VIII</strong>
		</TD>
		<TD COLSPAN=3>
		<strong>Kelas IX</strong>
		</TD>

		<TD COLSPAN=3>
		<strong>Kelas VII</strong>
		</TD>
		<TD COLSPAN=3>
		<strong>Kelas VIII</strong>
		</TD>
		<TD COLSPAN=3>
		<strong>Kelas IX</strong>
		</TD>
	</TR>
	<TR ALIGN="CENTER" bgcolor="'.$warnaheader.'">
		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>

		<TD>
		<strong>L</strong>
		</TD>
		<TD>
		<strong>P</strong>
		</TD>
		<TD>
		<strong>JML</strong>
		</TD>
	</TR>';


	//looping tapel
	$qkel = mysql_query("SELECT * FROM m_tapel ".
				"ORDER BY round(tahun1) ASC");
	$rkel = mysql_fetch_assoc($qkel);

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
		$kel_kd = nosql($rkel['kd']);
		$kel_tahun1 = nosql($rkel['tahun1']);
		$kel_tahun2 = nosql($rkel['tahun2']);


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<TD>'.$kel_tahun1.'/'.$kel_tahun2.'</TD>';




		//awal tapel//////////////////////////////////////////////////////////////////////////////////
		$tgl_awal = "$kel_tahun1:$ubln:$utgl";

		//looping kelas
		$qkelx = mysql_query("SELECT * FROM m_kelas ".
					"ORDER BY round(no) ASC");
		$rkelx = mysql_fetch_assoc($qkelx);

		do
			{
			//nilai
			$kelx_kd = nosql($rkelx['kd']);


			//jml. laki2
			$qlki = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'L' ".
						"AND m_siswa_diterima.tgl < '$tgl_awal'");
			$rlki = mysql_fetch_assoc($qlki);
			$tlki = mysql_num_rows($qlki);


			//jml. perempuan
			$qlki2 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'P' ".
						"AND m_siswa_diterima.tgl < '$tgl_awal'");
			$rlki2 = mysql_fetch_assoc($qlki2);
			$tlki2 = mysql_num_rows($qlki2);

			$jml_awal = round($tlki+$tlki2);


			echo '<TD>'.$tlki.'</TD>
			<TD>'.$tlki2.'</TD>
			<TD>'.$jml_awal.'</TD>';
			}
		while ($rkelx = mysql_fetch_assoc($qkelx));







		//mutasi masuk ////////////////////////////////////////////////////////////////////////////////
		//looping kelas
		$qkelx = mysql_query("SELECT * FROM m_kelas ".
					"ORDER BY round(no) ASC");
		$rkelx = mysql_fetch_assoc($qkelx);

		do
			{
			//nilai
			$kelx_kd = nosql($rkelx['kd']);

			//jml. laki2
			$qlki3 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'L'");
			$rlki3 = mysql_fetch_assoc($qlki3);
			$tlki3 = mysql_num_rows($qlki3);


			//jml. perempuan
			$qlki4 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'P'");
			$rlki4 = mysql_fetch_assoc($qlki4);
			$tlki4 = mysql_num_rows($qlki4);

			$jml_mutasi_masuk = round($tlki3 + $tlki4);

			echo '<TD>'.$tlki3.'</TD>
			<TD>'.$tlki4.'</TD>
			<TD>'.$jml_mutasi_masuk.'</TD>';
			}
		while ($rkelx = mysql_fetch_assoc($qkelx));





		//mutasi keluar ////////////////////////////////////////////////////////////////////////////////
		//looping kelas
		$qkelx = mysql_query("SELECT * FROM m_kelas ".
					"ORDER BY round(no) ASC");
		$rkelx = mysql_fetch_assoc($qkelx);

		do
			{
			//nilai
			$kelx_kd = nosql($rkelx['kd']);


			//jml. laki2
			$qlki5 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'L'");
			$rlki5 = mysql_fetch_assoc($qlki5);
			$tlki5 = mysql_num_rows($qlki5);


			//jml. perempuan
			$qlki6 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'P'");
			$rlki6 = mysql_fetch_assoc($qlki6);
			$tlki6 = mysql_num_rows($qlki6);

			$jml_mutasi_keluar = round($tlki5 + $tlki6);

			echo '<TD>'.$tlki5.'</TD>
			<TD>'.$tlki6.'</TD>
			<TD>'.$jml_mutasi_keluar.'</TD>';
			}
		while ($rkelx = mysql_fetch_assoc($qkelx));






		//akhir tapel ////////////////////////////////////////////////////////////////////////////////
		$tgl_akhir = "$kel_tahun2:$ubln2:$utgl2";

		//looping kelas
		$qkelx = mysql_query("SELECT * FROM m_kelas ".
					"ORDER BY round(no) ASC");
		$rkelx = mysql_fetch_assoc($qkelx);

		do
			{
			//nilai
			$kelx_kd = nosql($rkelx['kd']);

			//jml. laki2
			$qlki = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'L' ".
						"AND m_siswa_diterima.tgl < '$tgl_awal'");
			$rlki = mysql_fetch_assoc($qlki);
			$tlki = mysql_num_rows($qlki);


			//jml. perempuan
			$qlki2 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'P' ".
						"AND m_siswa_diterima.tgl < '$tgl_awal'");
			$rlki2 = mysql_fetch_assoc($qlki2);
			$tlki2 = mysql_num_rows($qlki2);

			$jml_awal = round($tlki+$tlki2);







			//jml. laki2
			$qlki3 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'L'");
			$rlki3 = mysql_fetch_assoc($qlki3);
			$tlki3 = mysql_num_rows($qlki3);


			//jml. perempuan
			$qlki4 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_diterima.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_diterima ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_diterima.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'P'");
			$rlki4 = mysql_fetch_assoc($qlki4);
			$tlki4 = mysql_num_rows($qlki4);

			$jml_mutasi_masuk = round($tlki3 + $tlki4);






			//jml. laki2
			$qlki5 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'L'");
			$rlki5 = mysql_fetch_assoc($qlki5);
			$tlki5 = mysql_num_rows($qlki5);


			//jml. perempuan
			$qlki6 = mysql_query("SELECT siswa_kelas.*, m_siswa.*, m_kelamin.*, m_siswa_perkembangan.* ".
						"FROM siswa_kelas, m_siswa, m_kelamin, m_siswa_perkembangan ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND m_siswa.kd_kelamin = m_kelamin.kd ".
						"AND m_siswa_perkembangan.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$kel_kd' ".
						"AND siswa_kelas.kd_kelas = '$kelx_kd' ".
						"AND m_kelamin.kelamin2 = 'P'");
			$rlki6 = mysql_fetch_assoc($qlki6);
			$tlki6 = mysql_num_rows($qlki6);

			$jml_mutasi_keluar = round($tlki5 + $tlki6);





			//jml. laki2
			$akhir_l = round(($tlki + $tlki3)-$tlki5);

			//jml. perempuan
			$akhir_p = round(($tlki2 + $tlki4)-$tlki6);

			//jml.akhir
			$akhir_jml = round($akhir_l+$akhir_p);


			echo '<TD>'.$akhir_l.'</TD>
			<TD>'.$akhir_p.'</TD>
			<TD>'.$akhir_jml.'</TD>';
			}
		while ($rkelx = mysql_fetch_assoc($qkelx));



		echo '</TR>';
		}
	while ($rkel = mysql_fetch_assoc($qkel));



	echo '</TABLE>';
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