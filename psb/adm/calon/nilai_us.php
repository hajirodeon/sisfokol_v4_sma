<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "nilai_us.php";
$judul = "Nilai US";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$swkd = nosql($_REQUEST['swkd']);
$noregx = nosql($_REQUEST['noregx']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



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
	$xbot = nosql($_POST['xbot']);
	$xnil1 = nosql($_POST['xnil1']);
	$xnil2 = nosql($_POST['xnil2']);
	

	//nek empty
	if (empty($xnil1))
		{
		$xnil1 = "00";
		}
		
	if (empty($xnil2))
		{
		$xnil2 = "00";
		}		
			
			
		
	//cek nol
	if (strlen($xnil1) == 1)
		{
		$xnil1 = "0$xnil1";
		}
		
	if (strlen($xnil2) == 1)
		{
		$xnil2 = "$xnil2"."0";
		}
			

	//nilai...
	$xnilx = "$xnil1.$xnil2";
		
	//total e...
	$xtotal = $xnilx * $xbotx;
				
	//cek
	$qcc = mysql_query("SELECT * FROM psb_siswa_calon_us ".
							"WHERE kd_siswa_calon = '$swkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);
		
	//nek ada
	if ($tcc != 0)
		{
		//update
		mysql_query("UPDATE psb_siswa_calon_us SET nilai = '$xnilx' ".
						"WHERE kd_siswa_calon = '$swkd'");
		}
	else
		{
		//insert
		mysql_query("INSERT INTO psb_siswa_calon_us(kd, kd_siswa_calon, nilai) VALUES ".
						"('$x', '$swkd', '$xnilx')");
		}
	
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


echo '<form action="'.$filenya.'" method="post" name="formx">
<a href="nilai.php">Nilai-Nilai</a> > Nilai US
<br>
<br>


<strong>No. Pendaftaran :</strong> '.$dt_noregx.', <strong>Nama : </strong>'.$dt_nama.'.
<br>
<br>

<table width="500" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="50"><strong>Kode</strong></td>
<td><strong>Jenis Nilai</strong></td>
<td width="50"><strong>Bobot</strong></td>
<td width="100"><strong>Nilai</strong></td>
<td width="50"><strong>Total</strong></td>
</tr>';

//nilai US
$qdni = mysql_query("SELECT * FROM psb_m_nilai ".
						"WHERE nilkd = 'N8'");
$rdni = mysql_fetch_assoc($qdni);
$tdni = mysql_num_rows($qdni);
$dni_nilkd = nosql($rdni['nilkd']);
$dni_jnil = balikin($rdni['nilai']);
$dni_bobot = nosql($rdni['bobot']);
	
//nilaine...
$qne = mysql_query("SELECT * FROM psb_siswa_calon_us ".
						"WHERE kd_siswa_calon = '$swkd'");	
$rne = mysql_fetch_assoc($qne);
$ne_nilai = nosql($rne['nilai']);
	
//angkane...
$ne_nilai1 = substr($ne_nilai,0,-3);
$ne_nilai2 = substr($ne_nilai,3,2);
	
//total
$ne_total = round($ne_nilai*$dni_bobot,2);
	
echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
echo '<td>'.$dni_nilkd.'</td>
<td>'.$dni_jnil.'</td>
<td>'.$dni_bobot.'</td>
<td>
<input name="xbot" type="hidden" value="'.$dni_bobot.'">
<input name="xnil1" type="text" value="'.$ne_nilai1.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
<input name="xnil2" type="text" value="'.$ne_nilai2.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
</td>
<td>'.$ne_total.'</td>
</tr>
</table>

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