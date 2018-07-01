<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_ppd.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "wawancara_finish.php";
$judul = "Wawancara Telah Usai";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);




//PROSES/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika usai
if ($s == "selesai")
	{
	//update
	mysql_query("UPDATE psb_siswa_calon_wwc_nilai ".
					"SET waktu_akhir = '$today' ".
					"WHERE kd_siswa_calon = '$kd4_session'");
					
	//re-direct
	$ke = $filenya;
	xloc($ke);
	exit();
	}





//jika lagi... pelajaran yang sama
if ($_POST['btnLGI'])
	{
	//kosongkan session rimer
	$_SESSION['wwc_sesi'] = 0;
	
	
	//kosongkan pengerjaan yang telah ada
	mysql_query("DELETE FROM psb_siswa_calon_wwc ".
					"WHERE kd_siswa_calon = '$kd4_session'");
	
	mysql_query("DELETE FROM psb_siswa_calon_wwc_nilai ".
					"WHERE kd_siswa_calon = '$kd4_session'");
	
	//re-direct
	$ke = "wawancara.php?s=baru";
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
//waktu mulai dan akhir
$qjux = mysql_query("SELECT * FROM psb_siswa_calon_wwc_nilai ".
						"WHERE kd_siswa_calon = '$kd4_session'");
$rjux = mysql_fetch_assoc($qjux);
$wk_mulai = $rjux['waktu_mulai'];
$wk_akhir = $rjux['waktu_akhir'];


//bobot
$qbot = mysql_query("SELECT * FROM psb_m_nilai ".
						"WHERE nilkd = 'N4'");
$rbot = mysql_fetch_assoc($qbot);
$bot_bobot = nosql($rbot['bobot']);


//skor
$qtok = mysql_query("SELECT SUM(psb_m_wwc_opsi.skor) AS total ".
						"FROM psb_siswa_calon_wwc, psb_m_wwc, psb_m_wwc_opsi ".
						"WHERE psb_m_wwc_opsi.kd_wwc = psb_m_wwc.kd ".
						"AND psb_siswa_calon_wwc.kd_wwc = psb_m_wwc.kd ".
						"AND psb_siswa_calon_wwc.kd_opsi = psb_m_wwc_opsi.kd ".
						"AND psb_siswa_calon_wwc.kd_siswa_calon ='$kd4_session'");
$rtok = mysql_fetch_assoc($qtok);
$tok_total = nosql($rtok['total']);


//skor total
$total_wwc = round($tok_total * $bot_bobot);

//update nilai
mysql_query("UPDATE psb_siswa_calon_wwc_nilai SET skor = '$total_wwc' ".
				"WHERE kd_siswa_calon = '$kd4_session'");


echo '<form action="'.$filenya.'" method="post" name="formx">
Waktu Mulai Pengerjaan : <font color="blue"><strong>'.$wk_mulai.'</strong></font>
<br>

Waktu Selesai Pengerjaan : <font color="blue"><strong>'.$wk_akhir.'</strong></font>
<br>
<br>
<br>
<input name="btnLGI" type="submit" value="Kerjakan Lagi">
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