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
$filenya = "wawancara.php";
$judul = "Ujian Wawancara";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$wwc_sesi = nosql($_SESSION['wwc_sesi']);
$ke_sli = "wawancara_finish.php?s=selesai"; //target re-direct selesai
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//body onload
$diload = "Up();";








//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek baru
if (($_POST['btnBR']) OR ($s == "baru"))
	{
	//null-kan session
	$_SESSION['wwc_sesi'] = 0;
	
	//kosongkan pengerjaan yang telah ada
	mysql_query("DELETE FROM psb_siswa_calon_wwc ".
					"WHERE kd_siswa_calon = '$kd4_session'");

	//kosongkan pengerjaan yang telah ada
	mysql_query("DELETE FROM psb_siswa_calon_wwc_nilai ".
					"WHERE kd_siswa_calon = '$kd4_session'");
	
	//insert baru
	mysql_query("INSERT INTO psb_siswa_calon_wwc_nilai(kd, kd_siswa_calon, waktu_mulai) VALUES ".
					"('$x', '$kd4_session', '$today')");	
		
	//re-direct	
	xloc($filenya);
	exit();
	}





//jika selesai
if ($_POST['btnSLS'])
	{
	//update
	mysql_query("UPDATE psb_siswa_calon_wwc_nilai ".
					"SET waktu_akhir = '$today' ".
					"WHERE kd_siswa_calon = '$kd4_session'");
	
	//re-direct
	$ke = "wawancara_finish.php?s=selesai";
	xloc($ke);
	exit();
	}
	
	
	
	
	
//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
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
	if (empty($_SESSION['wwc_sesi']))
		{
		session_register("wwc_sesi");
		$_SESSION['wwc_sesi'] = $nilx_disp1;
		}
	else
		{
		$_SESSION['wwc_sesi'] = $nilx_disp1;
		}
	
	
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlcount = "SELECT * FROM psb_m_wwc ".
					"ORDER BY round(no) ASC";
	$sqlresult = $sqlcount;
		
	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
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
		
		//opsi
		$xopsi = "opsi";
		$xopsix = "$xopsi$xsoalkdx2";
		$xopsix2 = nosql($_POST["$xopsix"]);
		
		//cek
		$qcc = mysql_query("SELECT * FROM psb_siswa_calon_wwc ".
								"WHERE kd_siswa_calon = '$kd4_session' ".
								"AND kd_wwc = '$xsoalkdx2'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		
		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE psb_siswa_calon_wwc SET kd_opsi = '$xopsix2' ".
							"WHERE kd_siswa_calon = '$kd4_session' ".
							"AND kd_wwc = '$xsoalkdx2'");
			}
		else
			{
			//insert
			mysql_query("INSERT INTO psb_siswa_calon_wwc(kd, kd_siswa_calon, kd_wwc, kd_opsi) VALUES".
							"('$xx', '$kd4_session', '$xsoalkdx2', '$xopsix2')");
			}
		}
	while ($data = mysql_fetch_assoc($result));
	
	
	//re-direct
	$ke = "$filenya?page=$page";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//wawancara /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batas waktu
$mpx_menit = 3; //3 menit
$mpx_detik = $mpx_menit * 60; //detik




//ujian. utk. tag META Refresh & settimeout //////////////////////////////////////////////////////////////
if (empty($s)) //jika bukan baru, apalagi edit. ini real time...
	{		
	$wkdet = (($mpx_menit * 60) - $wwc_sesi); //detik
	$ke_sli = "wawancara_finish.php?s=selesai";
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
	if ($wwc_sesi < 60)
		{
		$nil_mnt_seli = 0;
		}
	
	else if ($wwc_sesi == 60)
		{
		$nil_mnt_seli = 1;
		}
	
	else if ($wwc_sesi >= 120)
		{
		$nil_mnt_seli = $nil_mnt_seli + 1;
		}
		
	
	//nol-kan detik
	$nil_dtk_seli = 0;
	}
//nek 60 ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_ppd.php"); 
require("inc_counter.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//cek, sudah aktif belum tes wawancara.
$qccx = mysql_query("SELECT * FROM psb_set_wwc");
$rccx = mysql_fetch_assoc($qccx);
$ccx_wwc = nosql($rccx['wwc']);

//jika aktif, bisa mengikuti tes wawancara //////////////////////////////////////////////////////////////////////////////////////////////
if ($ccx_wwc == "true")
	{
	echo 'Status :
	<br>';
	
	//deteksi jika telah mengerjakan
	$qdte = mysql_query("SELECT psb_siswa_calon_wwc.*, psb_siswa_calon_wwc_nilai.* ".
							"FROM psb_siswa_calon_wwc, psb_siswa_calon_wwc_nilai ".
							"WHERE psb_siswa_calon_wwc_nilai.kd_siswa_calon = psb_siswa_calon_wwc.kd_siswa_calon ".
							"AND psb_siswa_calon_wwc_nilai.kd_siswa_calon = '$kd4_session'");
	$rdte = mysql_fetch_assoc($qdte);
	$tdte = mysql_num_rows($qdte);
	$dte_akhir = $rdte['waktu_akhir'];
	$dte_mulai = $rdte['waktu_mulai'];

	if (($tdte != 0) AND ($dte_akhir != "0000-00-00 00:00:00"))
		{
		echo "<font color=\"red\"><strong>SUDAH MELAKUKAN WAWANCARA</strong></font>
		<p>
		Waktu Mulai Pengerjaan : 
		<br>
		<input name=\"nilx2\" size=\"20\" type=\"text\" value=\"$dte_mulai\" class=\"input\" readonly>
		</p>
		<p>
		Waktu Selesai Pengerjaan : 
		<br>
		<input name=\"nilx3\" size=\"20\" type=\"text\" value=\"$dte_akhir\" class=\"input\" readonly>
		</p>
		<p>
		<input name=\"btnBR\" type=\"submit\" value=\"Kerjakan Lagi\">
		</p>";
		}

	//jika belum pernah 
	else if ((empty($s)) OR ($s == "baru") OR ($dte_akhir == "0000-00-00 00:00:00"))
		{
		//cek udah ada belum
		$qcc = mysql_query("SELECT * FROM psb_siswa_calon_wwc_nilai ".
								"WHERE kd_siswa_calon = '$kd4_session'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		
		if ($tcc != 0)
			{
			//tidak entry baru
			}
		else
			{
			//insert baru
			mysql_query("INSERT INTO psb_siswa_calon_wwc_nilai(kd, kd_siswa_calon, waktu_mulai) VALUES ".
							"('$x', '$kd4_session', '$today')");	
			}
	

		echo '<font color="blue"><strong>Sedang Melakukan Wawancara... </strong></font> 
		<img src="'.$sumber.'/img/sebentar.gif" width="16" height="16">
		<br>
		<br>
		Batas Waktu Pengerjaan : 
		<input name="nilx2" size="20" type="text" value="'.$mpx_menit.' Menit." class="input" readonly>
		<br>
		<br>';
		
		//query
		$p = new Pager();
		$start = $p->findStart($limit);
		
		$sqlcount = "SELECT * FROM psb_m_wwc ".
						"ORDER BY round(no) ASC";
		$sqlresult = $sqlcount;
				
		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		

		//waktu mulai
		$qmul = mysql_query("SELECT * FROM psb_siswa_calon_wwc_nilai ".
								"WHERE kd_siswa_calon = '$kd4_session'");
		$rmul = mysql_fetch_assoc($qmul);
		$mul_mulai = $rmul['waktu_mulai'];

		echo 'Tgl & Jam Mulai : 
		<input name="nilx1" size="20" type="text" value="'.$mul_mulai.'" class="input" readonly>, 
		Waktu Pengerjaan : 
		<input name="disp1" size="7" type="text" class="input" readonly>
		<br>';
		
		//timeout 
		echo '<script>setTimeout("location.href=\''.$ke_sli.'\'", '.$wkdet.'000);</script>
		<iframe name="ifr_sesi_wwc" frameborder="0" height="0" width="0" src="ifr_sesi_wwc.php"></iframe>
		<table width="750" border="1" cellspacing="0" cellpadding="3">
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
				$d_isi = balikin($data['soal']);

				//opsinya
				$qpo = mysql_query("SELECT * FROM psb_m_wwc_opsi ".
										"WHERE kd_wwc = '$kd' ".
										"ORDER BY skor DESC");
				$rpo = mysql_fetch_assoc($qpo);
		
		
				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				<input name="soalkd'.$nomer.'" type="hidden" value="'.$kd.'">
				'.$d_no.'
				</td>
				<td>
				'.$d_isi.'
				<br>
				<br>';
			
				//opsi
				do
					{
					//nilai
					$x_opkd = nosql($rpo['kd']);
					$x_opsi = balikin($rpo['opsi']);
		
					//yang dijawab
					$qju = mysql_query("SELECT * FROM psb_siswa_calon_wwc ".
											"WHERE kd_siswa_calon = '$kd4_session' ".
											"AND kd_wwc = '$kd' ".
											"AND kd_opsi = '$x_opkd'");
					$rju = mysql_fetch_assoc($qju);
					$tju = mysql_num_rows($qju);
					
					//nek iya
					if ($tju != 0)
						{
						$status_check = "checked";
						}
					else
						{
						$status_check = "";
						}
			
						
					echo "<input name=\"opsi$kd\" type=\"radio\" value=\"$x_opkd\" $status_check>$x_opsi. 
					<br>
					<br>";
					}
				while ($rpo = mysql_fetch_assoc($qpo));
				
				echo '</td>
		        </tr>';				
				} 
			while ($data = mysql_fetch_assoc($result)); 
			}
			
		echo '</table>
		<table width="750" border="0" cellspacing="0" cellpadding="3">
		<tr> 
		<td width="263">
		<input name="jml" type="hidden" value="'.$total.'"> 
		<input name="page" type="hidden" value="'.$page.'"> 
		<input name="btnSMP" type="submit" value="SIMPAN"> 
		<input name="btnSLS" type="submit" value="SELESAI >>"> 
		</td>
		<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
		</tr>
		</table>';
		}
	}

else
	{
	echo '<font color="red"><strong>TES WAWANCARA Tidak Aktif. Tidak Bisa Diikuti.</strong></font>';
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