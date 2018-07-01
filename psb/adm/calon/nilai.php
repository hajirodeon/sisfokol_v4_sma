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
$filenya = "nilai.php";
$judul = "Nilai-Nilai";
$judulku = "[$adm_session] ==> $judul";
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
require("../../../inc/menu/psb_adm.php"); 
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
<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">No.Daftar</font></strong></td>
<td width="200"><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td><strong><font color="'.$warnatext.'">Asal Sekolah</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Ujian MaPel</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Wawancara</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Nilai UN</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Nilai Prestasi</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Nilai US</font></strong></td>
<td width="75"><strong><font color="'.$warnatext.'">Total Rata-Rata</font></strong></td>
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
		
		
		//bobot nllai wawancara ////////////////////////////////////////////////////////////////////////////
		$qbow = mysql_query("SELECT * FROM psb_m_nilai ".
								"WHERE nilkd = 'N4'");
		$rbow = mysql_fetch_assoc($qbow);
		$bow_bobot = nosql($rbow['bobot']);
		
		
		//bobot nllai un ///////////////////////////////////////////////////////////////////////////////////
		$qbow1 = mysql_query("SELECT * FROM psb_m_nilai ".
								"WHERE nilkd = 'N6'");
		$rbow1 = mysql_fetch_assoc($qbow1);
		$bow_bobot1 = nosql($rbow1['bobot']);


		//bobot nilai prestasi /////////////////////////////////////////////////////////////////////////////
		$qdni = mysql_query("SELECT * FROM psb_m_nilai ".
								"WHERE nilkd = 'N7'");
		$rdni = mysql_fetch_assoc($qdni);
		$tdni = mysql_num_rows($qdni);
		$dni_bobot = nosql($rdni['bobot']);
		
		
		//bobot nilai US ///////////////////////////////////////////////////////////////////////////////////
		$qdns = mysql_query("SELECT * FROM psb_m_nilai ".
								"WHERE nilkd = 'N8'");
		$rdns = mysql_fetch_assoc($qdns);
		$tdns = mysql_num_rows($qdns);
		$dns_bobot = nosql($rdns['bobot']);
		

		//total skor ujian mapel ///////////////////////////////////////////////////////////////////////////
		$qtum = mysql_query("SELECT SUM(skor) AS total ".
								"FROM psb_siswa_calon_soal_nilai ".
								"WHERE kd_siswa_calon = '$d_kd'");
		$rtum = mysql_fetch_assoc($qtum);
		$tum_total = nosql($rtum['total']);
		$tum_rata = round($tum_total/4,2);
		
		//nek null
		if (empty($tum_rata))
			{
			$tum_rata = 0;
			}
		
		
		//total skor wawancara /////////////////////////////////////////////////////////////////////////////
		$qtwwc = mysql_query("SELECT SUM(skor) AS total ".
								"FROM psb_siswa_calon_wwc_nilai ".
								"WHERE kd_siswa_calon = '$d_kd'");
		$rtwwc = mysql_fetch_assoc($qtwwc);
		$twwc_total = nosql($rtwwc['total']);
		$twwc_totalx = round($twwc_total*$bow_bobot,2);
		
		
		//total nilai UN ///////////////////////////////////////////////////////////////////////////////////
		$qunm = mysql_query("SELECT AVG(nilai) AS total ".
								"FROM psb_siswa_calon_un ".
								"WHERE kd_siswa_calon = '$d_kd'");
		$runm = mysql_fetch_assoc($qunm);
		$unm_total = nosql($runm['total']);
		$unm_rata = round($unm_total*$bow_bobot1,2);

		//nek null
		if (empty($unm_rata))
			{
			$unm_rata = 0;
			}

		
		//total skor prestasi //////////////////////////////////////////////////////////////////////////////
		$qtla = mysql_query("SELECT * FROM psb_siswa_calon_prestasi ".
								"WHERE kd_siswa_calon = '$d_kd'");
		$rtla = mysql_fetch_assoc($qtla);
		$tla_nilai  = nosql($rtla['nilai']);
		$tla_rata = round($tla_nilai*$dni_bobot,2);
		
		//nek null
		if (empty($tla_rata))
			{
			$tla_rata = 0;
			}
		
		
		//total nilai US ///////////////////////////////////////////////////////////////////////////////////
		$qusm = mysql_query("SELECT * FROM psb_siswa_calon_us ".
								"WHERE kd_siswa_calon = '$d_kd'");
		$rusm = mysql_fetch_assoc($qusm);
		$usm_total = nosql($rusm['nilai']);
		$usm_rata = round($usm_total*$dns_bobot,2);

		//nek null
		if (empty($usm_rata))
			{
			$usm_rata = 0;
			}
		
		
		//total rata - rata ////////////////////////////////////////////////////////////////////////////////
		$tot_rata1 = round((($unm_rata+$usm_rata)*100)/50,2);
		$total_rata = $tot_rata1 + $tum_rata + $tla_rata + $twwc_totalx;
			
			
		
		//entry nilai rangking /////////////////////////////////////////////////////////////////////////////
		$qcri = mysql_query("SELECT * FROM psb_siswa_calon_rangking ".
								"WHERE kd_siswa_calon = '$d_kd'");
		$rcri = mysql_fetch_assoc($qcri);
		$tcri = mysql_num_rows($qcri);
		
		//nek sudah ada, update aja
		if ($tcri != 0)
			{
			mysql_query("UPDATE psb_siswa_calon_rangking SET nil_mapel = '$tum_rata', ".
							"nil_wwc = '$twwc_totalx', ".
							"nil_un = '$unm_rata', ".
							"nil_prestasi = '$tla_rata', ".
							"nil_us = '$usm_rata', ".
							"total_rata = '$total_rata' ".
							"WHERE kd_siswa_calon = '$d_kd'");
			}
		else
			{
			mysql_query("INSERT INTO psb_siswa_calon_rangking(kd, kd_siswa_calon, nil_mapel, nil_wwc, ".
							"nil_un, nil_prestasi, nil_us, total_rata) VALUES ".
							"('$xx', '$d_kd', '$tum_rata', '$twwc_totalx', ".
							"'$unm_rata', '$tla_rata', '$usm_rata', '$total_rata')");
			}
		/////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
			
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$d_noreg.'</td>
		<td>'.$d_nama.'</td>

		<td>'.$d_asal_sekolah.'</td>
	
		<td>
		[<a href="nilai_mapel.php?swkd='.$d_kd.'&noregx='.$d_noreg.'&page='.$page.'" title="Nilai MaPel : ['.$d_noreg.']. '.$d_nama.'"><img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>] 
		<br>
		[<strong>'.$tum_rata.'</strong>] 
		</td>

		<td>
		[<a href="nilai_wwc.php?swkd='.$d_kd.'&noregx='.$d_noreg.'&page='.$page.'" title="Nilai Wawancara : ['.$d_noreg.']. '.$d_nama.'"><img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0"></a>] 
		<br>
		[<strong>'.$twwc_totalx.'</strong>] 
		</td>

		<td>
		[<a href="nilai_un.php?swkd='.$d_kd.'&noregx='.$d_noreg.'&page='.$page.'" title="Nilai UN : ['.$d_noreg.']. '.$d_nama.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>] 
		<br>
		[<strong>'.$unm_rata.'</strong>] 
		</td>

		<td>
		[<a href="nilai_prestasi.php?swkd='.$d_kd.'&noregx='.$d_noreg.'&page='.$page.'" title="Nilai Prestasi : ['.$d_noreg.']. '.$d_nama.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>] 
		<br>
		[<strong>'.$tla_rata.'</strong>] 
		</td>

		<td>
		[<a href="nilai_us.php?swkd='.$d_kd.'&noregx='.$d_noreg.'&page='.$page.'" title="Nilai US : ['.$d_noreg.']. '.$d_nama.'"><img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0"></a>] 
		<br>
		[<strong>'.$usm_rata.'</strong>] 
		</td>
	
		<td><strong>'.$total_rata.'</strong></td>
		
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