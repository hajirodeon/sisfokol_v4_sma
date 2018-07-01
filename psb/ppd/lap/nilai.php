<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php");
require("../../../inc/cek/psb_ppd.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "nilai.php";
$judul = "Nilai-Nilai";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;



//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_ppd.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';
			
//bobot nllai wawancara ///////////////////////////////////////////////////////////////////////////////////
$qbow = mysql_query("SELECT * FROM psb_m_nilai ".
						"WHERE nilai = 'wawancara'");
$rbow = mysql_fetch_assoc($qbow);
$bow_bobot = nosql($rbow['bobot']);


//bobot nllai UN //////////////////////////////////////////////////////////////////////////////////////////
$qbow1 = mysql_query("SELECT * FROM psb_m_nilai ".
						"WHERE nilkd = 'N6'");
$rbow1 = mysql_fetch_assoc($qbow1);
$bow_bobot1 = nosql($rbow1['bobot']);
		
		
//bobot nilai prestasi ////////////////////////////////////////////////////////////////////////////////////
$qdni = mysql_query("SELECT * FROM psb_m_nilai ".
						"WHERE nilkd = 'N7' ".
						"AND nilai = 'Prestasi'");
$rdni = mysql_fetch_assoc($qdni);
$tdni = mysql_num_rows($qdni);
$dni_bobot = nosql($rdni['bobot']);


//bobot nilai US //////////////////////////////////////////////////////////////////////////////////////////
$qdns = mysql_query("SELECT * FROM psb_m_nilai ".
						"WHERE nilkd = 'N8'");
$rdns = mysql_fetch_assoc($qdns);
$tdns = mysql_num_rows($qdns);
$dns_bobot = nosql($rdns['bobot']);
		
		
//total skor ujian mapel //////////////////////////////////////////////////////////////////////////////////
$qtum = mysql_query("SELECT SUM(skor) AS total ".
						"FROM psb_siswa_calon_soal_nilai ".
						"WHERE kd_siswa_calon = '$kd4_session'");
$rtum = mysql_fetch_assoc($qtum);
$tum_total = nosql($rtum['total']);
$tum_rata = round($tum_total/4,2);
		
//nek null
if (empty($tum_rata))
	{
	$tum_rata = 0;
	}
		
		
//total skor wawancara ////////////////////////////////////////////////////////////////////////////////////
$qtwwc = mysql_query("SELECT SUM(skor) AS total ".
						"FROM psb_siswa_calon_wwc_nilai ".
						"WHERE kd_siswa_calon = '$kd4_session'");
$rtwwc = mysql_fetch_assoc($qtwwc);
$twwc_total = nosql($rtwwc['total']);
$twwc_totalx = $twwc_total * $bow_bobot;
		
		
//total nilai UN //////////////////////////////////////////////////////////////////////////////////////////
$qunm = mysql_query("SELECT AVG(nilai) AS total ".
						"FROM psb_siswa_calon_un ".
						"WHERE kd_siswa_calon = '$kd4_session'");
$runm = mysql_fetch_assoc($qunm);
$unm_total = nosql($runm['total']);
$unm_rata = round($unm_total*$bow_bobot1,2);

//nek null
if (empty($unm_rata))
	{
	$unm_rata = 0;
	}

		
//total skor prestasi /////////////////////////////////////////////////////////////////////////////////////
$qtla = mysql_query("SELECT * FROM psb_siswa_calon_prestasi ".
						"WHERE kd_siswa_calon = '$kd4_session'");
$rtla = mysql_fetch_assoc($qtla);
$tla_nilai  = nosql($rtla['nilai']);
$tla_rata = round($tla_nilai*$dni_bobot,2);
		
//nek null
if (empty($tla_rata))
	{
	$tla_rata = 0;
	}


//total nilai US //////////////////////////////////////////////////////////////////////////////////////////
$qusm = mysql_query("SELECT * FROM psb_siswa_calon_us ".
							"WHERE kd_siswa_calon = '$kd4_session'");
$rusm = mysql_fetch_assoc($qusm);
$usm_total = nosql($rusm['nilai']);
$usm_rata = round($usm_total*$dns_bobot,2);

//nek null
if (empty($usm_rata))
	{
	$usm_rata = 0;
	}

//total rata - rata
$tot_rata1 = round((($unm_rata+$usm_rata)*100)/50,2);
$total_rata = $tot_rata1 + $tum_rata + $tla_rata + $twwc_totalx;





echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="100"><strong><font color="'.$warnatext.'">Skor Ujian Mapel</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Skor Wawancara</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Nilai UN</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Nilai Prestasi</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Nilai US</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Rata-Rata</font></strong></td>
</tr>
<tr valign="top">
<td>'.$tum_rata.'</td>
<td>'.$twwc_totalx.'</td>
<td>'.$unm_rata.'</td>
<td>'.$tla_rata.'</td>
<td>'.$usm_rata.'</td>
<td>'.$total_rata.'</td>
</tr>
</table>
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