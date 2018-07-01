<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_ppd.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "mapel_soal_finish.php";
$judul = "Ujian Telah Usai";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$mapelkd = nosql($_REQUEST['mapelkd']);




//PROSES/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika usai
if ($s == "selesai")
	{
	//update
	mysql_query("UPDATE psb_siswa_calon_soal_nilai ".
					"SET waktu_akhir = '$today' ".
					"WHERE kd_siswa_calon = '$kd4_session' ".
					"AND kd_mapel = '$mapelkd'");
					
	//re-direct
	$ke = "$filenya?mapelkd=$mapelkd";
	xloc($ke);
	exit();
	}





//jika lagi... pelajaran yang sama
if ($_POST['btnLGI'])
	{
	//ambil nilai
	$mapelkd = nosql($_POST['mapelkd']);
			
	//kosongkan session rimer
	$_SESSION['x_sesi'] = 0;
	
	
	//kosongkan pengerjaan yang telah ada
	mysql_query("DELETE FROM psb_siswa_calon_soal ".
					"WHERE kd_siswa_calon = '$kd4_session' ".
					"AND kd_mapel = '$mapelkd'");
	
	mysql_query("DELETE FROM psb_siswa_calon_soal_nilai ".
					"WHERE kd_siswa_calon = '$kd4_session' ".
					"AND kd_mapel = '$mapelkd'");
	
	//re-direct
	$ke = "mapel_soal.php?s=baru&mapelkd=$mapelkd";
	xloc($ke);
	exit();
	}





//kerjakan pelajaran lain
if ($_POST['btnPEL'])
	{
	//kosongkan session rimer
	$_SESSION['x_sesi'] = 0;
	
	//re-direct
	$ke = "mapel.php";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//isi *START
ob_start();


//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_ppd.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//mapel
$qmpx = mysql_query("SELECT * FROM psb_m_mapel ".
						"WHERE kd = '$mapelkd'");
$rowmpx = mysql_fetch_assoc($qmpx);
$mpx_kd = nosql($rowmpx['kd']);
$mpx_mapel = balikin($rowmpx['mapel']);
$mpx_bobot = nosql($rowmpx['bobot']);
$mpx_menit = nosql($rowmpx['menit']);


//m_soal
$qsol = mysql_query("SELECT * FROM psb_m_soal ".
						"WHERE kd_mapel = '$mapelkd'");
$rsol = mysql_fetch_assoc($qsol);
$tsol = mysql_num_rows($qsol);


//soal yang dikerjakan
$qsyd = mysql_query("SELECT * FROM psb_siswa_calon_soal ".
						"WHERE kd_siswa_calon = '$kd4_session' ".
						"AND kd_mapel = '$mapelkd'");
$rsyd = mysql_fetch_assoc($qsyd);
$tsyd = mysql_num_rows($qsyd);


//jml. jawaban BENAR
$qju = mysql_query("SELECT psb_siswa_calon_soal.*, psb_m_soal.* ".
						"FROM psb_siswa_calon_soal, psb_m_soal ".
						"WHERE psb_siswa_calon_soal.kd_soal = psb_m_soal.kd ".
						"AND psb_siswa_calon_soal.kd_siswa_calon = '$kd4_session' ".
						"AND psb_siswa_calon_soal.kd_mapel = '$mapelkd' ".
						"AND psb_siswa_calon_soal.jawab = psb_m_soal.kunci");
$rju = mysql_fetch_assoc($qju);
$tju = mysql_num_rows($qju);


//jml. jawaban SALAH
$tsalah = round($tsyd - $tju);

//waktu mulai dan akhir
$qjux = mysql_query("SELECT * FROM psb_siswa_calon_soal_nilai ".
						"WHERE kd_siswa_calon = '$kd4_session' ".
						"AND kd_mapel = '$mapelkd'");
$rjux = mysql_fetch_assoc($qjux);
$wk_mulai = $rjux['waktu_mulai'];
$wk_akhir = $rjux['waktu_akhir'];


//total skor
$tskor = $mpx_bobot * $tju;


//update nilai
mysql_query("UPDATE psb_siswa_calon_soal_nilai ".
				"SET jml_benar = '$tju', ".
				"jml_salah = '$tsalah', ".
				"skor = '$tskor' ".
				"WHERE kd_siswa_calon = '$kd4_session' ".
				"AND kd_mapel = '$mapelkd'");
					


echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
Mata Pelajaran : 
<br>
<input name="nil1" type="text" value="'.$mpx_mapel.'" size="30" class="input" readonly>
</p>

<p>
Bobot Nilai : 
<br>
<input name="nil2" type="text" value="'.$mpx_bobot.'" size="5" class="input" readonly>
</p>

<p>
Batas Waktu Pengerjaan : 
<br>
<input name="nil3" type="text" value="'.$mpx_menit.' Menit." size="15" class="input" readonly>
</p>

<p>
Jumlah Soal : 
<br>
<input name="nil3" type="text" value="'.$tsol.'" size="5" class="input" readonly>
</p>


<p>
Waktu Mulai Pengerjaan : 
<br>
<input name="nil4" type="text" value="'.$wk_mulai.'" size="20" class="input" readonly>
</p>

<p>
Waktu Selesai Pengerjaan : 
<br>
<input name="nil5" type="text" value="'.$wk_akhir.'" size="20" class="input" readonly>
</p>

<p>
Jumlah Soal yang Dikerjakan : 
<br>
<input name="nil6" type="text" value="'.$tsyd.'" size="5" class="input" readonly>
</p>

<p>
Jumlah Jawaban Benar : 
<br>
<input name="nil7" type="text" value="'.$tju.'" size="5" class="input" readonly>
</p>

<p>
jumlah Jawaban Salah : 
<br>
<input name="nil8" type="text" value="'.$tsalah.'" size="5" class="input" readonly>
</p>
<br>

<br>
<br>
<input name="mapelkd" type="hidden" value="'.$mapelkd.'">
<input name="btnLGI" type="submit" value="Kerjakan Lagi">
<input name="btnPEL" type="submit" value="Ujian Pelajaran Lain">
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