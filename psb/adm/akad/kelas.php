<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "kelas.php";
$diload = "document.formx.jml_kelas.focus();";
$judul = "Data Kelas";
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
	//query
	$qx = mysql_query("SELECT * FROM psb_m_kelas");
	$rowx = mysql_fetch_assoc($qx);
	$e_jml_kelas = nosql($rowx['jml_kelas']);
	$e_daya_tampung = nosql($rowx['daya_tampung']);
	$e_jml_guru = nosql($rowx['jml_guru']);
	$e_jml_kelas_lalu = nosql($rowx['jml_kls_lalu']);
	$e_jml_siswa_lalu = nosql($rowx['jml_siswa_lalu']);
	}
	
	


	
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$jml_kelas = nosql($_POST['jml_kelas']);
	$daya_tampung = nosql($_POST['daya_tampung']);
	$jml_guru = nosql($_POST['jml_guru']);
	$jml_kls_lalu = nosql($_POST['jml_kelas_lalu']);
	$jml_siswa_lalu = nosql($_POST['jml_siswa_lalu']);
	
		
	//nek null
	if ((empty($jml_kelas)) OR (empty($daya_tampung)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{ 
		//jika baru
		if ($s == "baru")
			{
			///cek
			$qcc = mysql_query("SELECT * FROM psb_m_kelas");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
				
			//nek ada
			if ($tcc != 0)
				{
				//update
				mysql_query("UPDATE psb_m_kelas SET jml_kelas = '$jml_kelas', ".
								"daya_tampung = '$daya_tampung', ".
								"jml_guru = '$jml_guru', ".
								"jml_kls_lalu = '$jml_kls_lalu', ".
								"jml_siswa_lalu = '$jml_siswa_lalu'");
				}
			else
				{
				//insert
				mysql_query("INSERT INTO psb_m_kelas(kd, jml_kelas, daya_tampung, jml_guru, ".
								"jml_kls_lalu, jml_siswa_lalu) VALUES ".
								"('$x', '$jml_kelas', '$daya_tampung', '$jml_guru', ".
								"'$jml_kls_lalu', '$jml_siswa_lalu')");		
				}
			
			//re-direct
			xloc($filenya);
			exit();
			}
				
		//jika update
		else if ($s == "edit")
			{
			//update
			mysql_query("UPDATE psb_m_kelas SET jml_kelas = '$jml_kelas', ".
							"daya_tampung = '$daya_tampung', ".
							"jml_guru = '$jml_guru', ".
							"jml_kls_lalu = '$jml_kls_lalu', ".
							"jml_siswa_lalu = '$jml_siswa_lalu'");		
				
			//re-direct
			xloc($filenya);
			exit();
			}
		}	
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//js
require("../../../inc/js/checkall.js"); 
require("../../../inc/js/number.js"); 
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_adm.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
[<a href="'.$filenya.'?s=baru">Tulis Baru</a>]';

//jika baru atau edit
if (($s == "baru") OR ($s == "edit"))
	{
	echo '<p> 
	Jml.Ruang Kelas : 
	<br>
	<input name="jml_kelas" type="text" value="'.$e_jml_kelas.'" size="2" onKeyPress="return numbersonly(this, event)">
	</p>
	
	<p>
	Daya Tampung : 
	<br>
	<input name="daya_tampung" type="text" value="'.$e_daya_tampung.'" size="3" onKeyPress="return numbersonly(this, event)">
	</p>
	
	<p>
	Jml.Guru :
	<br>
	<input name="jml_guru" type="text" value="'.$e_jml_guru.'" size="3" onKeyPress="return numbersonly(this, event)">
	</p>
	
	<p>
	Jml.Kelas Lalu :
	<br>
	<input name="jml_kelas_lalu" type="text" value="'.$e_jml_kelas_lalu.'" size="3" onKeyPress="return numbersonly(this, event)">
	</p>
	
	<p>
	Jml.Siswa Lalu :
	<br>
	<input name="jml_siswa_lalu" type="text" value="'.$e_jml_siswa_lalu.'" size="3" onKeyPress="return numbersonly(this, event)">
	</p>
	
	<p>
	<input name="s" type="hidden" value="'.$s.'">
	<input name="btnSMP" type="submit" value="SIMPAN">
	<input name="btnBTL" type="submit" value="BATAL">
	</p>';
	}
else
	{
	//query
	$q = mysql_query("SELECT * FROM psb_m_kelas");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);
	
	echo '<p>
	<table width="251" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="50"><strong><font color="'.$warnatext.'">Jml.Ruang Kelas</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Daya Tampung</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Jml.Guru</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Jml.Kelas Lalu</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Jml.Siswa Lalu</font></strong></td>
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
			$kd = nosql($row['kd']);
			$jml_kelas = nosql($row['jml_kelas']);
			$daya_tampung = nosql($row['daya_tampung']);
			$jml_guru = nosql($row['jml_guru']);
			$jml_kelas_lalu = nosql($row['jml_kls_lalu']);
			$jml_siswa_lalu = nosql($row['jml_siswa_lalu']);
	
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<a href="'.$filenya.'?s=edit&kd='.$kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$jml_kelas.'</td>
			<td>'.$daya_tampung.'</td>
			<td>'.$jml_guru.'</td>
			<td>'.$jml_kelas_lalu.'</td>
			<td>'.$jml_siswa_lalu.'</td>
	        </tr>';				
			} 
		while ($row = mysql_fetch_assoc($q)); 
		}
	
	echo '</table>';
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