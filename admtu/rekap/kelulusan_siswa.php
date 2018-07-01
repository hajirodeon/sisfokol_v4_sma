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
$filenya = "kelulusan_siswa.php";
$ke = $filenya;


//judul
$judul = "Data Perkembangan Kelulusan Siswa";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
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
<p>
[<a href="kelulusan_siswa_pdf.php"><img src="'.$sumber.'/img/pdf.gif" border="0" width="16" height="16"></a>]
</p>

<TABLE BORDER=1 CELLPADDING=3 CELLSPACING=0>
<TR ALIGN="CENTER" bgcolor="'.$warnaheader.'">
	<TD ROWSPAN=2>
	<strong>TAHUN PELAJARAN</strong>
	</TD>
	<TD COLSPAN=3>
	<strong>JUMLAH PESERTA</strong>
	</TD>
	<TD COLSPAN=3>
	<strong>LULUS</strong>
	</TD>
	<TD COLSPAN=3>
	<strong>TIDAK LULUS</strong>
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


	//jumlah peserta /////////////////////////////////////////////////////////////////////////////////////
	//jumlah siswa... L
	$qdt = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND m_kelamin.kelamin2 = 'L'");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);


	//jumlah siswa... P
	$qdt2 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND m_kelamin.kelamin2 = 'P'");
	$rdt2 = mysql_fetch_assoc($qdt2);
	$tdt2 = mysql_num_rows($qdt2);

	$jml_peserta = $tdt+$tdt2;





	//jumlah peserta, yang lulus //////////////////////////////////////////////////////////////////////////
	//jumlah siswa... L
	$qdt3 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND siswa_lulus.lulus = 'true' ".
				"AND m_kelamin.kelamin2 = 'L'");
	$rdt3 = mysql_fetch_assoc($qdt3);
	$tdt3 = mysql_num_rows($qdt3);


	//jumlah siswa... P
	$qdt4 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND siswa_lulus.lulus = 'true' ".
				"AND m_kelamin.kelamin2 = 'P'");
	$rdt4 = mysql_fetch_assoc($qdt4);
	$tdt4 = mysql_num_rows($qdt4);

	$jml_lulus = $tdt3+$tdt4;





	//jumlah peserta, yang tidak lulus //////////////////////////////////////////////////////////////////////////
	//jumlah siswa... L
	$qdt5 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND siswa_lulus.lulus = 'false' ".
				"AND m_kelamin.kelamin2 = 'L'");
	$rdt5 = mysql_fetch_assoc($qdt5);
	$tdt5 = mysql_num_rows($qdt5);


	//jumlah siswa... P
	$qdt6 = mysql_query("SELECT siswa_lulus.*, siswa_kelas.*, m_siswa.*, m_kelamin.* ".
				"FROM siswa_lulus, siswa_kelas, m_siswa, m_kelamin ".
				"WHERE siswa_lulus.kd_siswa_kelas = siswa_kelas.kd ".
				"AND siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND m_siswa.kd_kelamin = m_kelamin.kd ".
				"AND siswa_lulus.kd_tapel = '$kel_kd' ".
				"AND siswa_lulus.lulus = 'false' ".
				"AND m_kelamin.kelamin2 = 'P'");
	$rdt6 = mysql_fetch_assoc($qdt6);
	$tdt6 = mysql_num_rows($qdt6);

	$jml_gak_lulus = $tdt5+$tdt6;






	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<TD>'.$kel_tahun1.'/'.$kel_tahun2.'</TD>
	<td>'.$tdt.'</td>
	<td>'.$tdt2.'</td>
	<td>'.$jml_peserta.'</td>
	<td>'.$tdt3.'</td>
	<td>'.$tdt4.'</td>
	<td>'.$jml_lulus.'</td>
	<td>'.$tdt5.'</td>
	<td>'.$tdt6.'</td>
	<td>'.$jml_gak_lulus.'</td>
	</TR>';
	}
while ($rkel = mysql_fetch_assoc($qkel));



echo '</TABLE>

</form>
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