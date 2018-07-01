<?php 



session_start();

//ambil nilai
require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "waktu_daftar.php";
$judul = "Set Waktu Daftar";
$judulku = "[$adm_session] ==> $judul";
$juduli = $judul;


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan	
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$pendaftaran = cegah($_POST["pendaftaran"]);
	$pengumuman_1 = cegah($_POST["pengumuman_1"]);
	$daftar_ulang_1 = cegah($_POST["daftar_ulang_1"]);
	$pengumuman_2 = cegah($_POST["pengumuman_2"]);
	$daftar_ulang_2 = cegah($_POST["daftar_ulang_2"]);
	$masuk = cegah($_POST["masuk"]);
	$biaya = cegah2($_POST["biaya"]);
	
	
	//query
	$qcc = mysql_query("SELECT * FROM psb_set_waktu_daftar");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);
	
	//cek	
	if ($tcc != 0) 
		{
		//update
		mysql_query("UPDATE psb_set_waktu_daftar SET pendaftaran = '$pendaftaran', ".
						"pengumuman_1 = '$pengumuman_1', ".
						"daftar_ulang_1 = '$daftar_ulang_1', ".
						"pengumuman_2 = '$pengumuman_2', ".
						"daftar_ulang_2 = '$daftar_ulang_2', ".
						"masuk = '$masuk', ".
						"biaya = '$biaya'");
		
		//re-direct
		xloc($filenya);
		exit();
		} 	
	else 
		{
		//insert
		mysql_query("INSERT INTO psb_set_waktu_daftar(kd, pendaftaran, pengumuman_1, daftar_ulang_1, ".
						"pengumuman_2, daftar_ulang_2, masuk, biaya) VALUES ".
						"('$x', '$pendaftaran', '$pengumuman_1', '$daftar_ulang_1', ".
						"'$pengumuman_2', '$daftar_ulang_2', '$masuk', '$biaya')");
				
		//re-direct
		xloc($filenya);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//js
require("../../../inc/js/number.js");
require("../../../inc/menu/psb_adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qdti = mysql_query("SELECT * FROM psb_set_waktu_daftar");
$rdti = mysql_fetch_assoc($qdti);
$dti_pendaftaran = balikin($rdti['pendaftaran']);
$dti_pengumuman_1 = balikin($rdti['pengumuman_1']);
$dti_daftar_ulang_1 = balikin($rdti['daftar_ulang_1']);
$dti_pengumuman_2 = balikin($rdti['pengumuman_2']);
$dti_daftar_ulang_2 = balikin($rdti['daftar_ulang_2']);
$dti_masuk = balikin($rdti['masuk']);
$dti_biaya = balikin($rdti['biaya']);




echo '<form action="'.$filenya.'" method="post" name="formx">
<p>
<strong>A. Jadwal Penerimaan Siswa Baru : </strong>
<br>
1. Pendaftaran : 
<br>
<input name="pendaftaran" type="text" size="50" value="'.$dti_pendaftaran.'">
<br>
<br>

2. Pengumuman 1: 
<br>
<input name="pengumuman_1" type="text" size="30" value="'.$dti_pengumuman_1.'">
<br>
<br>

3. Daftar Ulang 1 : 
<br>
<input name="daftar_ulang_1" type="text" size="30" value="'.$dti_daftar_ulang_1.'">
<br>
<br>

4. Pengumuman 2 : 
<br>
<input name="pengumuman_2" type="text" size="30" value="'.$dti_pengumuman_2.'">
<br>
<br>

5. Daftar Ulang 2 : 
<br>
<input name="daftar_ulang_2" type="text" size="30" value="'.$dti_daftar_ulang_2.'">
<br>
<br>

6. Masuk Sekolah hari Pertama : 
<br>
<input name="masuk" type="text" size="30" value="'.$dti_masuk.'">
</p>
<br>

<p>
<strong>B. Lokasi Pendaftaran</strong>
<br>
'.$sek_nama.'
</p>
<br>

<p>
<strong>C. Biaya Pendaftaran</strong>
<br>
Rp. <input name="biaya" type="text" size="10" value="'.$dti_biaya.'" onKeyPress="return numbersonly(this, event)">,00
</p>


<p> 
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="reset" value="BATAL">
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