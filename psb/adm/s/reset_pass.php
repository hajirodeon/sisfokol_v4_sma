<?php 



session_start();

//ambil nilai
require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "reset_pass.php";
$diload = "document.formx.akses.focus();";
$judul = "Reset Password";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;
$tpkd = nosql($_REQUEST['tpkd']);
$tipe = cegah($_REQUEST['tipe']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnRST'])
	{
	$tpkd = nosql($_POST['tpkd']);
	$tipe = cegah($_POST['tipe']);
	$ke = "$filenya?tpkd=$tpkd&tipe=$tipe&page=$page";
	$page = nosql($_POST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}

	
	//nek bendahara .....................................................................................................................
	if ($tpkd == "tp01")
		{
		//nilai
		$usernamex = nosql($_POST['usernamex']);
		$passbarux = md5($passbaru);

		//perintah SQL
		mysql_query("UPDATE psb_m_login SET password = '$passbarux' ".
						"WHERE level = '2' ".
						"AND username = 'bendahara'");
			
		//auto-kembali
		$pesan = "Password Baru : $passbaru";
		pekem($pesan,$ke);
		exit();
		}
	//...................................................................................................................................





	//nek pewawancara....................................................................................................................
	if ($tpkd == "tp02")
		{
		//nilai
		$usernamex = nosql($_POST['usernamex']);
		$passbarux = md5($passbaru);

		//perintah SQL
		mysql_query("UPDATE psb_m_login SET password = '$passbarux' ".
						"WHERE level = '3' ".
						"AND username = 'wawancara'");
		
		//auto-kembali
		$pesan = "Password Baru : $passbaru";
		pekem($pesan,$ke);
		exit();
		}





	//nek calon .........................................................................................................................
	if ($tpkd == "tp03")
		{
		//nilai
		$item = nosql($_POST['item']);
		$page = nosql($_POST['page']);
		$passbarux = md5($passbaru);

		//cek
		if (empty($item))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//update
			mysql_query("UPDATE psb_m_login SET password = '$passbarux' ".
							"WHERE level = '4' ".
							"AND nama = 'calon' ".
							"AND kd = '$item'");
			
			//auto-kembali
			$pesan = "Password Baru : $passbaru";
			pekem($pesan,$ke);
			exit();
			}
		}
	//...................................................................................................................................
	}	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/menu/psb_adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Akses : ';
echo "<select name=\"akses\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$filenya.'?tpkd='.$tpkd.'" selected>'.$tipe.'</option>
<option value="'.$filenya.'?tpkd=tp01&tipe=Bendahara">Bendahara</option>
<option value="'.$filenya.'?tpkd=tp02&tipe=Pewawancara">Pewawancara</option>
<option value="'.$filenya.'?tpkd=tp03&tipe=Calon">Calon</option>
</select>
</td>
</tr>
</table>

<p>';
//nek bendahara /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($tpkd == "tp01")
	{
	//query
	$qminx = mysql_query("SELECT * FROM psb_m_login ".
							"WHERE level = '2' ".
							"AND username = 'bendahara'");
	$rminx = mysql_fetch_assoc($qminx);
	$r_username = nosql($rminx['username']);
	
	//view
	echo '<input name="usernamex" type="hidden" value="'.$r_username.'">
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">	
	<input name="btnRST" type="submit" value="RESET">
	<br><br>';
	}



//nek pewawancara ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($tpkd == "tp02")
	{
	//query
	$qminx = mysql_query("SELECT * FROM psb_m_login ".
							"WHERE level = '3' ".
							"AND username = 'wawancara'");
	$rminx = mysql_fetch_assoc($qminx);	
	$r_username = nosql($rminx['username']);
	
	//view
	echo '<input name="usernamex" type="hidden" value="'.$r_username.'">
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="btnRST" type="submit" value="RESET">
	<br><br>';
	}
	

//nek siswa_calon ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($tpkd == "tp03")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.nama AS scnama, ".
					"psb_m_login.*, psb_m_login.kd AS mlkd ".
					"FROM psb_siswa_calon, psb_m_login ".
					"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
					"ORDER BY psb_siswa_calon.no_daftar DESC";
	$sqlresult = $sqlcount;
				
	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tpkd=$tpkd&tipe=$tipe";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);



	//view
	echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
	<tr align="center" bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="100"><strong><font color="'.$warnatext.'">No.Daftar/Username</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
	<td width="150"><strong><font color="'.$warnatext.'">Waktu Pendaftaran</font></strong></td>
	</tr>';
	
	if ($count != 0)
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
			$d_kd = nosql($data['mlkd']);
			$d_noreg = nosql($data['no_daftar']);
			$d_username = nosql($data['username']);
			$d_password = nosql($data['password']);
			$d_nama = balikin($data['scnama']);
			$d_tgl_daftar = $data['tgl_daftar'];

			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input type="radio" name="item" value="'.$d_kd.'">
			</td>
			<td>'.$d_noreg.'</td>
			<td>'.$d_nama.'</td>
			<td>'.$d_tgl_daftar.'</td>
	        </tr>';				
			} 
		while ($data = mysql_fetch_assoc($result)); 
		}
	
	echo '</table>
	<table width="700" border="0" cellspacing="0" cellpadding="3">
	<tr> 
	<td>
	<input name="tpkd" type="hidden" value="'.$tpkd.'">
	<input name="tipe" type="hidden" value="'.$tipe.'">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="btnRST" type="submit" value="RESET">	
	</td>
	<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
	</tr>
	</table>
	<br><br>';
	}
echo '</p></form>
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