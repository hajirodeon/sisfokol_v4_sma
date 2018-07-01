<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "mapel.php";
$diload = "document.formx.bobot.focus();";
$judul = "Data Pelajaran";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}





//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);
	
	//query
	$qx = mysql_query("SELECT * FROM psb_m_mapel ".
						"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
		
	$x_nilkd = nosql($rowx['nilkd']);				
	$x_mapel = balikin($rowx['mapel']);
	$x_bobot = nosql($rowx['bobot']);
	$x_menit = nosql($rowx['menit']);
	}
	
	


	
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$x_nilkd = nosql($_POST['nilkd']);
	$x_mapel = cegah($_POST['mapel']);
	$x_bobot = nosql($_POST['bobot']);
	$x_menit = nosql($_POST['menit']);
	
		
	//nek null
	if ((empty($s)))
		{
		//re-direct
		$pesan = "Silahkan Pilih Dahulu Data Yang Akan Di-Edit...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{ 
		//jika update
		if ($s == "edit")
			{
			//update
			mysql_query("UPDATE psb_m_mapel SET bobot = '$x_bobot', ".
							"menit = '$x_menit' ".
							"WHERE kd = '$kd'");		
			
			//re-direct
			xloc($filenya);
			exit();
			}
		}
	}	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//query
$q = mysql_query("SELECT * FROM psb_m_mapel ".
					"ORDER BY nilkd ASC");
$row = mysql_fetch_assoc($q);
$total = mysql_num_rows($q);

//js
require("../../../inc/js/checkall.js"); 
require("../../../inc/js/number.js"); 
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_adm.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p> 
nilkd : 
<input name="nilkd" type="text" value="'.$x_nilkd.'" size="2" disabled>, 

Nama MaPel : 
<input name="mapel" type="text" value="'.$x_mapel.'" size="30" disabled>, 
<br>

Bobot : 
<input name="bobot" type="text" value="'.$x_bobot.'" size="2" onKeyPress="return numbersonly(this, event)">, 

Jml.Menit Max. Ujian Online :
<input name="menit" type="text" value="'.$x_menit.'" size="2" onKeyPress="return numbersonly(this, event)"> 
<br>

<input name="s" type="hidden" value="'.$s.'">
<input name="kd" type="hidden" value="'.$kdx.'">
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>
<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1">&nbsp;</td>
<td width="50"><strong><font color="'.$warnatext.'">nilkd</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama Pelajaran</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Bobot</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Jml.Menit</font></strong></td>
</tr>';

if ($total != 0)
	{
	do { 
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
		echo '<td>
		<a href="'.$filenya.'?s=edit&kd='.$d_kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>'.$d_nilkd.'</td>
		<td>'.$d_mapel.'</td>
		<td>'.$d_bobot.'</td>
		<td>'.$d_menit.'</td>
        </tr>';				
		} 
	while ($row = mysql_fetch_assoc($q)); 
	}


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