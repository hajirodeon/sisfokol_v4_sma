<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "nilai_un.php";
$judul = "Nilai UN";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$swkd = nosql($_REQUEST['swkd']);
$noregx = nosql($_REQUEST['noregx']);





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	$ke = "nilai.php";	
	xloc($ke);
	exit();
	}



//simpan data
if ($_POST['btnSMP'])
	{
	$swkd = nosql($_POST['swkd']);
	$noregx = nosql($_POST['noregx']);
	
	//looping
	$qpel = mysql_query("SELECT * FROM psb_m_mapel ".
							"ORDER BY mapel ASC");
	$rpel = mysql_fetch_assoc($qpel);

	do
		{
		$i = $i + 1;
		$mapelkd = nosql($rpel['kd']);
		
		//random utk ide
		$xx = md5("$x$i");
				
		//nilaikd
		$xkd = "xkd";
		$xkdx = "$xkd$i";
		$xkdx2 = nosql($_POST["$xkdx"]);

		//xnil
		$xnil1 = "xnil1";
		$xnil1x = "$xnil1$i";
		$xnil1x2 = nosql($_POST["$xnil1x"]);

		$xnil2 = "xnil2";
		$xnil2x = "$xnil2$i";
		$xnil2x2 = nosql($_POST["$xnil2x"]);


		//nek empty
		if (empty($xnil1x2))
			{
			$xnil1x2 = "00";
			}
		
		if (empty($xnil2x2))
			{
			$xnil2x2 = "00";
			}		
			
			
		
		//cek nol
		if (strlen($xnil1x2) == 1)
			{
			$xnil1x2 = "0$xnil1x2";
			}
		
		if (strlen($xnil2x2) == 1)
			{
			$xnil2x2 = "$xnil2x2"."0";
			}
		

		//nilai...
		$xnilx = "$xnil1x2.$xnil2x2";
		
		//total e...
		$xtotal = $xnilx * $xbotx2;
				
		//cek
		$qcc = mysql_query("SELECT * FROM psb_siswa_calon_un ".
								"WHERE kd_siswa_calon = '$swkd' ".
								"AND kd_mapel = '$mapelkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		
		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE psb_siswa_calon_un SET nilai = '$xnilx' ".
							"WHERE kd_siswa_calon = '$swkd' ".
							"AND kd_mapel = '$mapelkd'");
			}
		else
			{
			//insert
			mysql_query("INSERT INTO psb_siswa_calon_un(kd, kd_siswa_calon, kd_mapel, nilai) VALUES ".
							"('$xx', '$swkd', '$mapelkd', '$xnilx')");
			}
		}
	while ($rpel = mysql_fetch_assoc($qpel));
		
		
		
	
	//re-direct
	$ke = "nilai.php";
	xloc($ke);
	exit();	
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/js/number.js"); 
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



//bobot nllai un
$qbow = mysql_query("SELECT * FROM psb_m_nilai ".
						"WHERE nilkd = 'N6'");
$rbow = mysql_fetch_assoc($qbow);
$bow_bobot = nosql($rbow['bobot']);


//nilaine..
$qnilex = mysql_query("SELECT AVG(nilai) AS rata FROM psb_siswa_calon_un ".
						"WHERE kd_siswa_calon = '$swkd'");
$rnilex = mysql_fetch_assoc($qnilex);
$nilex_rata = nosql($rnilex['rata']);
$nilex_total = round($nilex_rata*$bow_bobot,2);


echo '<form action="'.$filenya.'" method="post" name="formx">
<a href="nilai.php">Nilai-Nilai</a> > Nilai UN
<br>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<strong>No. Pendaftaran :</strong> '.$dt_noregx.', <strong>Nama : </strong>'.$dt_nama.'.
</td>
</tr>
</table>
<br>
<br>

Bobot : <strong>'.$bow_bobot.'</strong>, 
Total Rata-Rata : <strong>'.$nilex_total.'</strong>
<table width="400" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1"><font color="'.$warnatext.'">No.</font></strong></td>
<td><strong><font color="'.$warnatext.'">Mata Pelajaran</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Total</font></strong></td>
</tr>';

//ambil data mata pelajaran
$qpel = mysql_query("SELECT * FROM psb_m_mapel ".
						"ORDER BY mapel ASC");
$rpel = mysql_fetch_assoc($qpel);

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
	$d_kd = nosql($rpel['kd']);
	$d_mapel = balikin2($rpel['mapel']);
	
	
	//nilaine...
	$qnile = mysql_query("SELECT * FROM psb_siswa_calon_un ".
							"WHERE kd_siswa_calon = '$swkd' ".
							"AND kd_mapel = '$d_kd'");
	$rnile = mysql_fetch_assoc($qnile);
	$nile_nilai = nosql($rnile['nilai']);
	
	//angkane...
	$nile_nilai1 = substr($nile_nilai,0,-3);
	$nile_nilai2 = substr($nile_nilai,3,2);
	
	//total
	$nile_total = round($nile_nilai*$bow_bobot,2);
	
			
	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>
	<input name="kd'.$d_kd.'" type="hidden" value="'.$d_kd.'">
	'.$nomer.'
	</td>
	<td>'.$d_mapel.'</td>
	<td>
	<input name="xnil1'.$nomer.'" type="text" value="'.$nile_nilai1.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
	<input name="xnil2'.$nomer.'" type="text" value="'.$nile_nilai2.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
	</td>
	<td>'.$nile_total.'</td>
    </tr>';				
	} 
while ($rpel = mysql_fetch_assoc($qpel)); 

echo '</table>

<input name="swkd" type="hidden" value="'.$swkd.'">
<input name="noregx" type="hidden" value="'.$noregx.'">
<input name="btnBTL" type="submit" value="BATAL">
<input name="btnSMP" type="submit" value="SIMPAN">
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