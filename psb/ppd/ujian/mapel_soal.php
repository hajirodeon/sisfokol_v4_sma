<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php");
require("../../../inc/cek/psb_ppd.php"); 
$tpl = LoadTpl("../../../template/ujian.html"); 

nocache;

//nilai
$filenya = "mapel_soal.php";
$judul = "Soal Ujian";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$x_sesi = nosql($_SESSION['x_sesi']);
$mapelkd = nosql($_REQUEST['mapelkd']);
$ke_sli = "mapel_soal_finish.php?s=selesai&mapelkd=$mapelkd"; //target re-direct selesai
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//body onload
$diload = "Up();";








//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek baru
if ($s == "baru")
	{
	//null-kan session
	$_SESSION['x_sesi'] = 0;
	
	//kosongkan pengerjaan yang telah ada
	mysql_query("DELETE FROM psb_siswa_calon_soal ".
					"WHERE kd_siswa_calon = '$kd4_session' ".
					"AND kd_mapel = '$mapelkd'");
	
	mysql_query("DELETE FROM psb_siswa_calon_soal_nilai ".
					"WHERE kd_siswa_calon = '$kd4_session' ".
					"AND kd_mapel = '$mapelkd'");
					
	//insert baru
	mysql_query("INSERT INTO psb_siswa_calon_soal_nilai(kd, kd_siswa_calon, kd_mapel, waktu_mulai) VALUES ".
					"('$x', '$kd4_session', '$mapelkd', '$today')");	
	
	//re-direct
	$ke = "$filenya?mapelkd=$mapelkd";
	xloc($ke);
	exit();
	}





//jika selesai
if ($_POST['btnSLS'])
	{
	//ambil nilai
	$mapelkd = nosql($_POST['mapelkd']);
	
	//update
	mysql_query("UPDATE psb_siswa_calon_soal_nilai ".
					"SET waktu_akhir = '$today' ".
					"WHERE kd_siswa_calon = '$kd4_session' ".
					"AND kd_mapel = '$mapelkd'");
	
	//re-direct
	$ke = "mapel_soal_finish.php?s=selesai&mapelkd=$mapelkd";
	xloc($ke);
	exit();
	}
	
	
	
	
	
//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$mapelkd = nosql($_POST['mapelkd']);
	$page = nosql($_POST['page']);
	$disp1 = nosql($_POST['disp1']);
	
	//ambil jml.detik berjalan
	$nil1_disp1 = substr($disp1,0,2); //menit
			
	if (strlen($nil1_disp1) == 1)
		{
		$nil1_disp1 = "0$nil1_disp1";
		}
				
	$nil1x_disp1 = (int)($nil1_disp1 * 60); //jadikan detik
	$nil2_disp1 = substr($disp1,-2); //detik
	$nilx_disp1 = (int)($nil1x_disp1 + $nil2_disp1);
	
	//penanda session timer
	if (empty($_SESSION['x_sesi']))
		{
		session_register("x_sesi");
		$_SESSION['x_sesi'] = $nilx_disp1;
		}
	else
		{
		$_SESSION['x_sesi'] = $nilx_disp1;
		}
	
	
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlcount = "SELECT * FROM psb_m_soal ".
					"WHERE kd_mapel = '$mapelkd' ".
					"ORDER BY round(no) ASC";
	$sqlresult = $sqlcount;
		
	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?mapelkd=$mapelkd";
	$pagelist = $p->pageList($page, $pages, $target);
	$data = mysql_fetch_array($result);
	
	do
		{
		$nomer = $nomer + 1;
		$xx = md5("$x$nomer");
		
		//soalkd
		$xsoalkd = "soalkd";
		$xsoalkdx = "$xsoalkd$nomer";
		$xsoalkdx2 = nosql($_POST["$xsoalkdx"]);
		
		//jawab
		$xjawab = "jawab";
		$xjawabx = "$xjawab$nomer";
		$xjawabx2 = nosql($_POST["$xjawabx"]);
		
		//cek
		$qcc = mysql_query("SELECT * FROM psb_siswa_calon_soal ".
								"WHERE kd_siswa_calon = '$kd4_session' ".
								"AND kd_mapel = '$mapelkd' ".
								"AND kd_soal = '$xsoalkdx2'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		
		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE psb_siswa_calon_soal SET jawab = '$xjawabx2' ".
							"WHERE kd_siswa_calon = '$kd4_session' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND kd_soal = '$xsoalkdx2'");
			}
		else
			{
			//insert
			mysql_query("INSERT INTO psb_siswa_calon_soal(kd, kd_siswa_calon, kd_mapel, kd_soal, jawab) VALUES".
							"('$xx', '$kd4_session', '$mapelkd', '$xsoalkdx2', '$xjawabx2')");
			}
		}
	while ($data = mysql_fetch_assoc($result));
	
	
	//re-direct
	$ke = "$filenya?mapelkd=$mapelkd&page=$page";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//mapel terpilih ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qmpx = mysql_query("SELECT * FROM psb_m_mapel ".
						"WHERE kd = '$mapelkd'");
$rowmpx = mysql_fetch_assoc($qmpx);
$mpx_kd = nosql($rowmpx['kd']);
$mpx_mapel = balikin($rowmpx['mapel']);
$mpx_bobot = nosql($rowmpx['bobot']);
$mpx_menit = nosql($rowmpx['menit']);
$mpx_detik = $mpx_menit * 60; //detik


//ujian. utk. tag META Refresh & settimeout //////////////////////////////////////////////////////////////
if (empty($s)) //jika bukan baru, apalagi edit. ini real time...
	{		
	$wkdet = (($mpx_menit * 60) - $x_sesi); //detik
	$ke_sli = "mapel_soal_finish.php?s=selesai&mapelkd=$mapelkd";
	$wkurl = $ke_sli;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////





//utk. counter real time (js) ////////////////////////////////////////////////////////////////////////////
$nil_mnt = (int)($wkdet / 60); //batas waktu menit
$nil_dtk = $wkdet % 60; //batas waktu detik

//ke-n
$nil_mnt_seli = $mpx_menit - $nil_mnt; //menit ke-n
$nil_dtk_seli = 60 - $nil_dtk; //detik ke-n

//nek 1
if ($nil_mnt_seli >= 1)
	{
	$nil_mnt_seli = $nil_mnt_seli - 1;
	}


//nek 60 ////////////////////////////////////////////////////
if ($nil_dtk_seli == 60)
	{
	if ($x_sesi < 60)
		{
		$nil_mnt_seli = 0;
		}
	
	else if ($x_sesi == 60)
		{
		$nil_mnt_seli = 1;
		}
	
	else if ($x_sesi >= 120)
		{
		$nil_mnt_seli = $nil_mnt_seli + 1;
		}
		
	
	//nol-kan detik
	$nil_dtk_seli = 0;
	}
//nek 60 ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////



//deteksi jika telah dikerjakan
$qdte = mysql_query("SELECT * FROM psb_siswa_calon_soal_nilai ".
						"WHERE kd_siswa_calon = '$kd4_session' ".
						"AND kd_mapel = '$mapelkd'");
$rdte = mysql_fetch_assoc($qdte);
$dte_akhir = $rdte['waktu_akhir'];

if ((!empty($_SESSION['x_sesi'])) AND ($dte_akhir != "0000-00-00 00:00:00"))
	{
	//re-direct
	$pesan = "Anda Sudah Melakukan Ujian. Jika Ingin Melakukan Lagi, Silahkan Kerjakan Lagi. Terima Kasih.";
	$ke = "$filenya?s=baru&mapelkd=$mapelkd";
	pekem($pesan,$ke);
	exit();
	}







//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_ppd.php"); 
require("inc_counter.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Mata Pelajaran : 
<br>
<input name="nilx3" size="30" type="text" value="'.$mpx_mapel.'" class="input" readonly> 
</p>

<p>
Bobot Nilai : 
<br>
<input name="nilx4" size="5" type="text" value="'.$mpx_bobot.'" class="input" readonly>
</p>
<p>
Waktu Pengerjaan : 
<br>
<input name="nilx5" size="10" type="text" value="'.$mpx_menit.' Menit." class="input" readonly> 
<br>
<br>';

//query
$p = new Pager();
$start = $p->findStart($limit);
	
$sqlcount = "SELECT * FROM psb_m_soal ".
				"WHERE kd_mapel = '$mapelkd' ".
				"ORDER BY round(no) ASC";
$sqlresult = $sqlcount;
		
$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?mapelkd=$mapelkd";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);
	

//waktu mulai
$qmul = mysql_query("SELECT * FROM psb_siswa_calon_soal_nilai ".
						"WHERE kd_siswa_calon = '$kd4_session' ".
						"AND kd_mapel = '$mapelkd'");
$rmul = mysql_fetch_assoc($qmul);
$mul_mulai = $rmul['waktu_mulai'];




echo 'Tgl & Jam Mulai : 
<input name="nilx2" size="20" type="text" value="'.$mul_mulai.'" class="input" readonly>, 
Waktu Pengerjaan : 
<input name="disp1" size="7" type="text" class="input" readonly> 
<img src="'.$sumber.'/img/sebentar.gif" width="16" height="16">
<br>';

//timeout 
echo '<script>setTimeout("location.href=\''.$ke_sli.'\'", '.$wkdet.'000);</script>
<iframe name="ifr_sesi" frameborder="0" height="0" width="0" src="ifr_sesi.php"></iframe>
<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
<td><strong><font color="'.$warnatext.'">Soal</font></strong></td>
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
		$kd = nosql($data['kd']);
		$d_no = nosql($data['no']);
		$d_isi = balikin($data['isi']);
		
		//yang dijawab
		$qjbu = mysql_query("SELECT * FROM psb_siswa_calon_soal ".
								"WHERE kd_siswa_calon = '$kd4_session' ".
								"AND kd_mapel = '$mapelkd' ".
								"AND kd_soal = '$kd'");
		$rjbu= mysql_fetch_assoc($qjbu);		
		$d_jawab = nosql($rjbu['jawab']);
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input name="soalkd'.$nomer.'" type="hidden" value="'.$kd.'">
		'.$d_no.'
		</td>
		<td>
		'.$d_isi.' 
		<p>
		<hr>
		<strong>Jawab :</strong> 
		<select name="jawab'.$nomer.'">
		<option value="'.$d_jawab.'" selected>'.$d_jawab.'</option>
		<option value="A">A</option>
		<option value="B">B</option>
		<option value="C">C</option>
		<option value="D">D</option>
		<option value="E">E</option>
		</select>
		<hr>
		</p>
		</td>
        </tr>';				
		} 
	while ($data = mysql_fetch_assoc($result)); 
	}
	
	
echo '</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr> 
<td width="263">
<input name="jml" type="hidden" value="'.$total.'"> 
<input name="mapelkd" type="hidden" value="'.$mapelkd.'"> 
<input name="page" type="hidden" value="'.$page.'"> 
<input name="btnSMP" type="submit" value="SIMPAN"> 
<input name="btnSLS" type="submit" value="SELESAI >>"> 
</td>
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