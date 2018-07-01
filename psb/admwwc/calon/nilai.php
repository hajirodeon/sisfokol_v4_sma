<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php");
require("../../../inc/cek/psb_admwwc.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "nilai.php";
$judul = "Nilai Wawancara";
$judulku = "[$wwc_session] ==> $judul";
$judulx = $judul;
$katcari = nosql($_REQUEST['katcari']);
$kunci = cegah2($_REQUEST['kunci']);
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
				"ORDER BY psb_siswa_calon.no_daftar DESC";
$sqlresult = $sqlcount;
			

//kondisi pencarian
if ($_POST['btnCRI'])
	{
	//cek
	if ((empty($katcari)) OR (empty($kunci)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{		
		//no daftar
		if ($katcari == "cr01")
			{
			$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
							"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
							"FROM psb_siswa_calon, psb_m_login ".
							"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
							"AND psb_siswa_calon.no_daftar LIKE '%$kunci%' ".
							"ORDER BY psb_siswa_calon.no_daftar DESC";
			$sqlresult = $sqlcount;
			}
		
		//nama
		else if ($katcari == "cr02")
			{
			$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
							"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
							"FROM psb_siswa_calon, psb_m_login ".
							"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
							"AND psb_siswa_calon.nama LIKE '%$kunci%' ".
							"ORDER BY psb_siswa_calon.no_daftar DESC";
			$sqlresult = $sqlcount;			
			}
		
		//asal sekolah
		else if ($katcari == "cr03")
			{
			$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
							"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
							"FROM psb_siswa_calon, psb_m_login ".
							"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
							"AND psb_siswa_calon.asal_sekolah LIKE '%$kunci%' ".
							"ORDER BY psb_siswa_calon.no_daftar DESC";
			$sqlresult = $sqlcount;			
			}
		}
	}
else
	{
	$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
					"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
					"FROM psb_siswa_calon, psb_m_login ".
					"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
					"ORDER BY psb_siswa_calon.no_daftar DESC";
	$sqlresult = $sqlcount;	
	}



//jika reset
if ($_POST['btnRST'])
	{
	$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
					"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
					"FROM psb_siswa_calon, psb_m_login ".
					"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
					"ORDER BY psb_siswa_calon.no_daftar DESC";
	$sqlresult = $sqlcount;
	}
	
	
$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_admwwc.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
<select name="katcari">
<option value="" selected></option>
<option value="cr01">No.pendaftaran</option>
<option value="cr02">Nama</option>
<option value="cr03">Asal Sekolah</option>
</select>
<input name="kunci" type="text" value="" size="20">
<input name="btnCRI" type="submit" value="CARI">
<input name="btnRST" type="submit" value="RESET">
</p>

<p>
<table width="700" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">No.Daftar</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="200"><strong><font color="'.$warnatext.'">Asal Sekolah</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Yang Dijawab</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Total Skor Wawancara</font></strong></td>
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
		$xx = md5("$x$nomer");
		$d_kd = nosql($data['sckd']);
		$d_noreg = nosql($data['no_daftar']);
		$d_nama = balikin($data['scnama']);
		$d_asal_sekolah = balikin($data['asal_sekolah']);
		
		
		//bobot nllai wawancara
		$qbow = mysql_query("SELECT * FROM psb_m_nilai ".
								"WHERE nilai = 'wawancara'");
		$rbow = mysql_fetch_assoc($qbow);
		$bow_bobot = nosql($rbow['bobot']);

		//total skor wawancara
		$qtwwc = mysql_query("SELECT SUM(skor) AS total ".
								"FROM psb_siswa_calon_wwc_nilai ".
								"WHERE kd_siswa_calon = '$d_kd'");
		$rtwwc = mysql_fetch_assoc($qtwwc);
		$twwc_total = nosql($rtwwc['total']);
		$twwc_totalx = $twwc_total * $bow_bobot;
		
			
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$d_noreg.'</td>
		<td>'.$d_nama.'</td>

		<td>'.$d_asal_sekolah.'</td>

		<td>
		<a href="nilai_wwc.php?swkd='.$d_kd.'&noregx='.$d_noreg.'&page='.$page.'" title="Nilai Wawancara : ['.$d_noreg.']. '.$d_nama.'">
		<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0">
		</a>
		</td>
		
		<td>'.$twwc_totalx.'</td>
        </tr>';				
		} 
	while ($data = mysql_fetch_assoc($result)); 
	}
	
	
echo '</table>
<table width="700" border="0" cellspacing="0" cellpadding="3">
<tr> 
<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
</tr>
</table>
</p>

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