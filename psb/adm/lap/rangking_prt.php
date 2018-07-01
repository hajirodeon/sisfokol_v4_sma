<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/print.html"); 

nocache;

//nilai
$filenya = "rangking_prt.php";
$judul = "Rangking";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$ke = "rangking.php";
$diload = "window.print();location.href='$ke';";



//isi *START
ob_start();





//query data
$qdata = mysql_query("SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
						"psb_siswa_calon.nama AS scnama, psb_siswa_calon_rangking.* ".
						"FROM psb_siswa_calon, psb_siswa_calon_rangking ".
						"WHERE psb_siswa_calon.kd = psb_siswa_calon_rangking.kd_siswa_calon ".
						"AND psb_siswa_calon_rangking.nil_mapel >= '0' ".
						"AND psb_siswa_calon_rangking.nil_wwc <> '0' ".
						"AND psb_siswa_calon_rangking.nil_un <> '0' ".
						"AND psb_siswa_calon_rangking.nil_prestasi >= '0' ".
						"ORDER BY round(psb_siswa_calon_rangking.no) ASC");
$rdata = mysql_fetch_assoc($qdata);
$tdata = mysql_num_rows($qdata);


//js
require("../../../inc/js/swap.js"); 

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td>
<h1><strong>'.$sek_nama.'</strong></h1>
'.$sek_alamat.'. 

'.$sek_kontak.'
</td>
</tr>
</table>
<hr>


<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr align="center">
<td><h1><strong>'.$judul.'</strong></h1></td>
</tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">No.Daftar</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Skor Ujian Mapel</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Skor Wawancara</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Nilai UN</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Nilai Prestasi</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Nilai US</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Rata-Rata</font></strong></td>
</tr>';

if ($tdata != 0)
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
			
		$d_kd = nosql($rdata['sckd']);
		$d_no = nosql($rdata['no']);
		$d_noreg = nosql($rdata['no_daftar']);
		$d_nama = balikin($rdata['scnama']);
		$d_nil_mapel = nosql($rdata['nil_mapel']);
		$d_nil_wwc = nosql($rdata['nil_wwc']);
		$d_nil_un = nosql($rdata['nil_un']);
		$d_nil_prestasi = nosql($rdata['nil_prestasi']);
		$d_nil_us = nosql($rdata['nil_us']);
		$d_total_rata = nosql($rdata['total_rata']);
		
			
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$d_no.'.</td>
		<td>'.$d_noreg.'</td>
		
		<td>'.$d_nama.'</td>

		<td>'.$d_nil_mapel.'</td>
		
		<td>'.$d_nil_wwc.'</td>
		
		<td>'.$d_nil_un.'</td>
		
		<td>'.$d_nil_prestasi.'</td>
		
		<td>'.$d_nil_us.'</td>
		
		<td>'.$d_total_rata.'</td>
		
        </tr>';				
		} 
	while ($rdata = mysql_fetch_assoc($qdata)); 
	}
	
	
echo '</table>
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