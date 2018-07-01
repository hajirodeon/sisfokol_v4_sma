<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php");
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "daftar.php";
$judul = "Data Pendaftar";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//isi *START
ob_start();



//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
				"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
				"FROM psb_siswa_calon, psb_m_login ".
				"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
				"ORDER BY round(psb_siswa_calon.no_daftar) DESC";
$sqlresult = $sqlcount;
			
$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_adm.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1">&nbsp;</td>
<td width="100"><strong><font color="'.$warnatext.'">No.Daftar/Username</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td><strong><font color="'.$warnatext.'">Asal Sekolah</font></strong></td>
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
		$kd = nosql($data['sckd']);
		$d_noreg = nosql($data['no_daftar']);
		$d_username = nosql($data['username']);
		$d_nama = balikin($data['scnama']);
		$d_asal_sekolah = balikin($data['asal_sekolah']);
		$d_tgl_daftar = $data['tgl_daftar'];
		

			
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<a href="daftar_prt.php?swkd='.$kd.'&noregx='.$d_noreg.'&page='.$page.'" title="Print...">
		<img src="'.$sumber.'/img/print.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>'.$d_noreg.'</td>
		<td>'.$d_nama.'</td>
		<td>'.$d_asal_sekolah.'</td>
		<td>'.$d_tgl_daftar.'</td>
        </tr>';				
		} 
	while ($data = mysql_fetch_assoc($result)); 
	}
	
	
echo '</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr> 
<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
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