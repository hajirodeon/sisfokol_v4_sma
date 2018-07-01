<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_admwwc.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "nilai_wwc.php";
$judul = "Detail Nilai Wawancara";
$judulku = "[$wwc_session] ==> $judul";
$judulx = $judul;
$swkd = nosql($_REQUEST['swkd']);
$noregx = nosql($_REQUEST['noregx']);







//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_admwwc.php"); 
xheadline($judul);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qdt = mysql_query("SELECT * FROM psb_siswa_calon ".
						"WHERE kd = '$swkd' ".
						"AND no_daftar = '$noregx'");
$rdt = mysql_fetch_assoc($qdt);
$dt_noregx = nosql($rdt['no_daftar']);
$dt_nama = balikin($rdt['nama']);



//bobot nllai wawancara
$qbow = mysql_query("SELECT * FROM psb_m_nilai ".
						"WHERE nilai = 'wawancara'");
$rbow = mysql_fetch_assoc($qbow);
$bow_bobot = nosql($rbow['bobot']);



//total skor
$qtok = mysql_query("SELECT SUM(psb_m_wwc_opsi.skor) AS total ".
						"FROM psb_siswa_calon_wwc, psb_m_wwc, psb_m_wwc_opsi ".
						"WHERE psb_m_wwc_opsi.kd_wwc = psb_m_wwc.kd ".
						"AND psb_siswa_calon_wwc.kd_wwc = psb_m_wwc.kd ".
						"AND psb_siswa_calon_wwc.kd_opsi = psb_m_wwc_opsi.kd ".
						"AND psb_siswa_calon_wwc.kd_siswa_calon ='$swkd'");
$rtok = mysql_fetch_assoc($qtok);
$tok_total = nosql($rtok['total']);


echo '<form action="'.$filenya.'" method="post" name="formx">
<a href="nilai.php">Daftar Nilai</a> > Detail Nilai Wawancara
<br>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<strong>No. Pendaftaran :</strong> '.$dt_noregx.', <strong>Nama : </strong>'.$dt_nama.'.
</td>
<td align="right">
Bobot : <strong>'.$bow_bobot.'</strong>, 
Total Sementara : <strong>'.$tok_total.'</strong>, 
Total Skor : <strong>'.$bow_bobot * $tok_total.'</strong>
</td>
</tr>
</table>

<table width="700" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="1"><strong>No.</strong></td>
<td><strong>Soal</strong></td>
<td width="200"><strong>Opsi Yang Dipilih</strong></td>
<td width="50"><strong>Skor</strong></td>
</tr>';

//wawancara
$qdni = mysql_query("SELECT * FROM psb_m_wwc ".
						"ORDER BY round(no) ASC");
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
	$dni_soal = balikin($rdni['soal']);
	
	//opsi yang dipilih
	$qpo = mysql_query("SELECT psb_m_wwc_opsi.*, psb_siswa_calon_wwc.* ".
							"FROM psb_m_wwc_opsi, psb_siswa_calon_wwc ".
							"WHERE psb_siswa_calon_wwc.kd_opsi = psb_m_wwc_opsi.kd ".
							"AND psb_siswa_calon_wwc.kd_siswa_calon = '$swkd' ".
							"AND psb_m_wwc_opsi.kd_wwc = '$dni_kd'");
	$rpo = mysql_fetch_assoc($qpo);
	$tpo = mysql_num_rows($qpo);
	$po_skor = nosql($rpo['skor']);
	$po_opsi = balikin($rpo['opsi']);
	
	//nek null
	if (empty($po_opsi))
		{
		$po_opsi = "-";
		}
		
	if (empty($po_skor))
		{
		$po_skor = "-";
		}
	
	
	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$nomer.'.</td>
    <td>'.$dni_soal.'</td>
	<td>'.$po_opsi.'</td>
	<td>'.$po_skor.'</td>
	</tr>';
	}
while ($rdni = mysql_fetch_assoc($qdni));


echo '</table>
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