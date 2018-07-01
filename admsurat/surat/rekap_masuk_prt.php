<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
$tpl = LoadTpl("../../template/window.html");

nocache;

//nilai
$filenya = "rekap_masuk.php";
$judul = "Rekap Surat Masuk";
$judulku = $judul;
$judulx = $judul;



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "rekap_masuk.php";
$diload = "window.print();location.href='$ke'";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();


//js
require("../../inc/js/swap.js");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="center">';
xheadline($judul);

echo '</td>
</tr>
</table>';


//daftar surat //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qdtu = mysql_query("SELECT * FROM surat_masuk ".
			"ORDER BY round(tgl_terima) DESC");
$rdtu = mysql_fetch_assoc($qdtu);
$tdtu = mysql_num_rows($qdtu);

if ($tdtu != 0)
	{
	echo '<p>
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="100"><strong><font color="'.$warnatext.'">Tgl. Terima</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">No. Urut</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Asal</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Tujuan</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Tgl. Surat</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Perihal</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Klasifikasi</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Status</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Ruang</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Lemari</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Rak</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">MAP</font></strong></td>
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
		$i_kd = nosql($rdtu['kd']);
		$i_no_urut = nosql($rdtu['no_urut']);
		$i_no_surat = balikin2($rdtu['no_surat']);
		$i_asal = balikin2($rdtu['asal']);
		$i_tujuan = balikin2($rdtu['tujuan']);
		$i_tgl_surat = $rdtu['tgl_surat'];
		$i_perihal = balikin2($rdtu['perihal']);
		$i_tgl_terima = $rdtu['tgl_terima'];

		$ku_kd_klasifikasi = nosql($rdtu['kd_klasifikasi']);
		$ku_kd_status = nosql($rdtu['kd_status']);
		$ku_tgl_surat = $rdtu['tgl_surat'];
		$ku_tgl_terima = $rdtu['tgl_terima'];
		$ku_kd_ruang = nosql($rdtu['kd_ruang']);
		$ku_kd_lemari = nosql($rdtu['kd_lemari']);
		$ku_kd_rak = nosql($rdtu['kd_rak']);
		$ku_kd_map = nosql($rdtu['kd_map']);


		//klasifikasi
		$qdtx = mysql_query("SELECT * FROM surat_m_klasifikasi ".
										"WHERE kd = '$ku_kd_klasifikasi'");
		$rdtx = mysql_fetch_assoc($qdtx);
		$dtx_klasifikasi = balikin($rdtx['klasifikasi']);

		//status
		$qdtx3 = mysql_query("SELECT * FROM surat_m_status ".
										"WHERE kd = '$ku_kd_status'");
		$rdtx3 = mysql_fetch_assoc($qdtx3);
		$dtx3_status = balikin($rdtx3['status']);


		//ruang
		$qdt1 = mysql_query("SELECT * FROM surat_m_ruang ".
										"WHERE kd = '$ku_kd_ruang'");
		$rdt1 = mysql_fetch_assoc($qdt1);
		$dt1_ruang = balikin($rdt1['ruang']);


		//lemari
		$qdt2 = mysql_query("SELECT * FROM surat_m_lemari ".
										"WHERE kd = '$ku_kd_lemari'");
		$rdt2 = mysql_fetch_assoc($qdt2);
		$dt2_lemari = balikin($rdt2['lemari']);


		//rak
		$qdt3 = mysql_query("SELECT * FROM surat_m_rak ".
										"WHERE kd = '$ku_kd_rak'");
		$rdt3 = mysql_fetch_assoc($qdt3);
		$dt3_rak = balikin($rdt3['rak']);


		//map
		$qdt4 = mysql_query("SELECT * FROM surat_m_map ".
										"WHERE kd = '$ku_kd_map'");
		$rdt4 = mysql_fetch_assoc($qdt4);
		$dt4_map = balikin($rdt4['map']);




		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tgl_terima.'</td>
		<td>'.$i_no_urut.'</td>
		<td>'.$i_no_surat.'</td>
		<td>'.$i_asal.'</td>
		<td>'.$i_tujuan.'</td>
		<td>'.$i_tgl_surat.'</td>
		<td>'.$i_perihal.'</td>
		<td>'.$dtx_klasifikasi.'</td>
		<td>'.$dtx3_status.'</td>
		<td>'.$dt1_ruang.'</td>
		<td>'.$dt2_lemari.'</td>
		<td>'.$dt3_rak.'</td>
		<td>'.$dt4_map.'</td>
		</tr>';
		}
	while ($rdtu = mysql_fetch_assoc($qdtu));

	echo '</table>
	</p>';
	}

//null
else
	{
	echo '<p>
	<font color="red"><strong>TIDAK ADA DATA SURAT MASUK</strong></font>
	<p>';
	}

echo '<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>