<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
$tpl = LoadTpl("../../template/window.html");


nocache;

//nilai
$filenya = "per_tgl_tulis_prt.php";
$judul = "Data Alumni per Tgl.Edit/Entri";
$judulku = $judul;
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$tapelkd = nosql($_REQUEST['tapelkd']);

$ke = "$filenya?tapelkd=$tapelkd";







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct print...
$ke = "per_tgl_tulis.php?tapelkd=$tapelkd";
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
echo '<br>
Tahun Pelajaran : ';

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo ''.$tpx_thn1.'/'.$tpx_thn2.'
</td>
</tr>
</table>
<br>';

//query
$qdata = mysql_query("SELECT m_siswa.*, ".
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
			"ORDER BY m_siswa_perkembangan.tgl_terima_ijazah ASC");
$rdata = mysql_fetch_assoc($qdata);
$tdata = mysql_num_rows($qdata);


echo '<p>
<table width="100%" border="1" cellpadding="3" cellspacing="0">
<tr bgcolor="'.$warnaheader.'">
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

	$kd = nosql($rdata['mskd']);
	$kelkd = nosql($rdata['kd_kelas']);
	$nis = nosql($rdata['nis']);
	$nama = balikin($rdata['nama']);
	$no_sttb = balikin($rdata['no_sttb']);
	$kd_kelamin = nosql($rdata['kd_kelamin']);
	$tmp_lahir = balikin2($rdata['tmp_lahir']);
	$tgl_lahir = $rdata['tgl'];
	$bln_lahir = $rdata['bln'];
	$thn_lahir = $rdata['thn'];
	$tgl_terima = $rdata['2tgl'];
	$bln_terima = $rdata['2bln'];
	$thn_terima = $rdata['2thn'];


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
	echo '<td valign="top">
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
while ($rdata = mysql_fetch_assoc($qdata));

echo '</table>
</p>


<br>
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