<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "nilai_mapel.php";
$judul = "Nilai Mata Pelajaran";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$swkd = nosql($_REQUEST['swkd']);
$noregx = nosql($_REQUEST['noregx']);



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//re-direct ke daftar nilai
if ($_POST['btnDNI'])
	{
	$ke = "nilai.php";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////











//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_adm.php"); 
xheadline($judul);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qdt = mysql_query("SELECT * FROM psb_siswa_calon ".
						"WHERE kd = '$swkd' ".
						"AND no_daftar = '$noregx'");
$rdt = mysql_fetch_assoc($qdt);
$dt_noregx = nosql($rdt['no_daftar']);
$dt_nama = balikin($rdt['nama']);


//total skor
$qtok = mysql_query("SELECT SUM(skor) AS total FROM psb_siswa_calon_soal_nilai ".
						"WHERE kd_siswa_calon = '$swkd'");
$rtok = mysql_fetch_assoc($qtok);
$tok_total = nosql($rtok['total']);
$tok_rata = round($tok_total/4,2);


echo '<form action="'.$filenya.'" method="post" name="formx">
<a href="nilai.php">Nilai-Nilai</a> > Nilai Mata Pelajaran
<br>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<strong>No. Pendaftaran :</strong> '.$dt_noregx.', <strong>Nama : </strong>'.$dt_nama.'.
</td>
<td align="right">
Total Skor : <strong>'.$tok_total.'</strong>, 
Total Rata - Rata : <strong>'.$tok_rata.'</strong>
</td>
</tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="1"><strong>No.</strong></td>
<td><strong>Mata Pelajaran</strong></td>
<td width="50"><strong>Bobot</strong></td>
<td width="50"><strong>Jml. Soal</strong></td>
<td width="100"><strong>Jml. Soal Yang Dikerjakan</strong></td>
<td width="100"><strong>Jml. Jawaban Benar</strong></td>
<td width="100"><strong>Jml. Jawaban Salah</strong></td>
<td width="100"><strong>Mulai Pengerjaan</strong></td>
<td width="100"><strong>Selesai Pengerjaan</strong></td>
<td width="50"><strong>Skor</strong></td>
</tr>';

//nilai mapel
$qdni = mysql_query("SELECT * FROM psb_m_mapel ".
						"ORDER BY nilkd ASC");
$rdni = mysql_fetch_assoc($qdni);
$tdni = mysql_num_rows($qdni);

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
	$dni_kd = nosql($rdni['kd']);
	$dni_nilkd = nosql($rdni['nilkd']);
	$dni_bobot = nosql($rdni['bobot']);
	$dni_mapel = balikin($rdni['mapel']);
	
	
	//jumlah soal
	$qsol = mysql_query("SELECT * FROM psb_m_soal ".
							"WHERE kd_mapel = '$dni_kd'");
	$rsol = mysql_fetch_assoc($qsol);
	$tsol = mysql_num_rows($qsol);	
	
	
	//soal yang dikerjakan
	$qsyd = mysql_query("SELECT * FROM psb_siswa_calon_soal ".
							"WHERE kd_siswa_calon = '$swkd' ".
							"AND kd_mapel = '$dni_kd'");
	$rsyd = mysql_fetch_assoc($qsyd);
	$tsyd = mysql_num_rows($qsyd);
	
	
	//jml. jawaban BENAR, SALAH, Skor, dan waktu mengerjakan
	$qwuk = mysql_query("SELECT * FROM psb_siswa_calon_soal_nilai ".
							"WHERE kd_siswa_calon ='$swkd' ".
							"AND kd_mapel = '$dni_kd'");
	$rwuk = mysql_fetch_assoc($qwuk);
	$wuk_jbenar = nosql($rwuk['jml_benar']);
	$wuk_jsalah = nosql($rwuk['jml_salah']);
	$wuk_skor = nosql($rwuk['skor']);
	$wuk_mulai = $rwuk['waktu_mulai'];
	$wuk_akhir = $rwuk['waktu_akhir'];
	
	
	
	
	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$nomer.'.</td>
    <td>'.$dni_mapel.'</td>
	<td>'.$dni_bobot.'</td>
	<td>'.$tsol.'</td>
	<td>'.$tsyd.'</td>
	<td>'.$wuk_jbenar.'</td>
	<td>'.$wuk_jsalah.'</td>
	<td>'.$wuk_mulai.'</td>
	<td>'.$wuk_akhir.'</td>
	<td><strong>'.$wuk_skor.'</strong></td>
	</tr>';
	}
while ($rdni = mysql_fetch_assoc($qdni));


echo '</table>
<br>

<input name="btnDNI" type="submit" value="<< Daftar Nilai lainnya">
</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>