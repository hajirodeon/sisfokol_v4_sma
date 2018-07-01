<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_ppd.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "mapel.php";
$judul = "Ujian Mata Pelajaran";
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


//cek, sudah aktif belum ujian mapel.
$qcc = mysql_query("SELECT * FROM psb_set_mapel");
$rcc = mysql_fetch_assoc($qcc);
$cc_mapel = nosql($rcc['mapel']);

//jika aktif, bisa mengikuti ujian mapel ////////////////////////////////////////////////////////////////////////////////////////////////
if ($cc_mapel == "true")
	{
	//query
	$q = mysql_query("SELECT * FROM psb_m_mapel ".
						"ORDER BY nilkd ASC");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);

	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr align="center" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">nilkd</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama Pelajaran</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Bobot</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Jml.Menit</font></strong></td>
	<td width="1">&nbsp;</td>
	</tr>';
	
	if ($total != 0)
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
			
			$nomer = $nomer + 1;
			$d_kd = nosql($row['kd']);
			$d_nilkd = nosql($row['nilkd']);
			$d_mapel = balikin($row['mapel']);
			$d_bobot = nosql($row['bobot']);
			$d_menit = nosql($row['menit']);
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$d_nilkd.'</td>
			<td>'.$d_mapel.'</td>
			<td>'.$d_bobot.'</td>
			<td>'.$d_menit.'</td>
			<td>
			<a href="mapel_soal.php?s=baru&mapelkd='.$d_kd.'" title="Ujian Mata Pelajaran : '.$d_mapel.'";>
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
	        </tr>';				
			} 
		while ($row = mysql_fetch_assoc($q)); 
		}

	echo '</table>';
	}
else
	{
	echo '<font color="red"><strong>UJIAN MATA PELAJARAN Masih Ditutup. Tidak Bisa Diikuti.</strong></font>';
	}

echo '</form>
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