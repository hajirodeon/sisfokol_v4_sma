<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php");
require("../../../inc/cek/psb_admbdh.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "reg_view.php";
$judul = "Data Diri...";
$judulku = "[$bdh_session] ==> $judul";
$judulx = $judul;
$swkd = nosql($_REQUEST['swkd']);
$noregx = nosql($_REQUEST['noregx']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//re-direct
	$ke = "reg.php";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_admbdh.php"); 
xheadline($judul);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qdt = mysql_query("SELECT DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
						"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
						"DATE_FORMAT(tgl_lahir, '%Y') AS lthn, ".
						"psb_siswa_calon.* ".
						"FROM psb_siswa_calon ".
						"WHERE kd = '$swkd' ".
						"AND no_daftar = '$noregx'");
$rdt = mysql_fetch_assoc($qdt);
$dt_noregx = nosql($rdt['no_daftar']);
$dt_nama = balikin($rdt['nama']);
$dt_tmp_lahir = balikin($rdt['tmp_lahir']);

$dt_tgl = nosql($rdt['ltgl']);
$dt_bln = nosql($rdt['lbln']);
$dt_thn = nosql($rdt['lthn']);

$dt_alamat = balikin($rdt['alamat']);
$dt_kelamin = nosql($rdt['kelamin']);
$dt_agama = balikin($rdt['agama']);
$dt_nm_ortu = balikin($rdt['nama_ayah']);
$dt_almt_ortu = balikin($rdt['alamat_ayah']);
$dt_ker_ortu = balikin($rdt['kerja_ayah']);
$dt_nm_wali = balikin($rdt['nama_wali']);
$dt_almt_wali = balikin($rdt['alamat_wali']);
$dt_ker_wali = balikin($rdt['kerja_wali']);
$dt_asal_sek = balikin($rdt['asal_sekolah']);
$dt_status_sek = balikin($rdt['status_sekolah']);
$dt_almt_sek = balikin($rdt['alamat_sekolah']);
$dt_no_sttb = balikin($rdt['no_sttb']);
$dt_thn_lulus = nosql($rdt['tahun_lulus']);



echo '<form action="'.$filenya.'" method="post" name="formx">
<a href="reg.php">Data Pendaftaran</a> > Data Diri

<p>
<strong>No. Pendaftaran : </strong>
<br>
'.$dt_noregx.'
<br>
<br>
<br>



<strong>IDENTITAS PESERTA</strong>
<br>

<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr>
<td width="250"><strong>1. Nama </strong></td>
<td width="1">:</td>
<td>'.$dt_nama.'</td>
</tr>

<tr>
<td>
<strong>2. TTL</strong>
</td>
<td>:</td>
<td>
'.$dt_tmp_lahir.', 
'.$dt_tgl.' '.$arrbln1[$dt_bln].' '.$dt_thn.'
</td>
</tr>

<tr>
<td>
<strong>3. Alamat</strong>
</td>
<td>:</td>
<td>
'.$dt_alamat.'
</td>
</tr>

<tr>
<td>
<strong>4. Jenis Kelamin (L/P)</strong>
</td>
<td>:</td>
<td>
'.$dt_kelamin.'
</td>
</tr>

<tr>
<td>
<strong>5. Agama</strong>
</td>
<td>:</td>
<td>
'.$dt_agama.'
</td>
</tr>
</table>
<br>
<br>
<br>

<strong>IDENTITAS ORANG TUA </strong>
<br>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr>
<td width="250">
<strong>1. Nama Orang Tua / Ayah </strong>
</td>
<td width="1">:</td>
<td>
'.$dt_nm_ortu.'
</td>
</tr>

<tr>
<td>
<strong>2. Alamat Orang Tua / Ayah</strong>
</td>
<td>:</td>
<td>
'.$dt_almt_ortu.'
</td>
</tr>


<tr>
<td>
<strong>3. Pekerjaan Orang Tua / Ayah</strong>
</td>
<td>:</td>
<td>
'.$dt_ker_ortu.'
</td>
</tr>

<tr>
<td>
<strong>4. Nama Wali</strong>
</td>
<td>:</td>
<td>
'.$dt_nm_wali.'
</td>
</tr>

<tr>
<td>
<strong>5. Alamat Wali</strong>
</td>
<td>:</td>
<td>
'.$dt_almt_wali.'
</td>
</tr>

<tr>
<td>
<strong>6. Pekerjaan Wali</strong>
</td>
<td>:</td>
<td>
'.$dt_ker_wali.'
</td>
</tr>
</table>
<br>
<br>
<br>

<strong>ASAl SEKOLAH</strong>
<br>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr>
<td width="250">
<strong>1. Asal Sekolah</strong>
</td>
<td width="1">:</td>
<td>
'.$dt_asal_sek.'
</td>
</tr>

<tr>
<td>
<strong>2. Status Sekolah : </strong>
</td>
<td>:</td>
<td>
'.$dt_status_sek.'
</td>
</tr>

<tr>
<td>
<strong>3. Alamat Sekolah : </strong>
</td>
<td>:</td>
<td>
'.$dt_almt_sek.'
</td>
</tr>

<tr>
<td>
<strong>4. No. STTB :  </strong>
</td>
<td>:</td>
<td>
'.$dt_no_sttb.'
</td>
</tr>

<tr>
<td>
<strong>5. Tahun Lulus : </strong>
</td>
<td>:</td>
<td>
'.$dt_thn_lulus.'
</td>
</tr>
</table>
<br>
<br>
<br>


<strong>NILAI UJIAN NASIONAL</strong>
<br>
<table width="400" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1"><font color="'.$warnatext.'">No.</font></strong></td>
<td><strong><font color="'.$warnatext.'">Mata Pelajaran</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
</tr>';

//ambil data mata pelajaran
$qpel = mysql_query("SELECT * FROM psb_m_mapel ".
						"ORDER BY mapel ASC");
$rpel = mysql_fetch_assoc($qpel);

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
	$d_kd = nosql($rpel['kd']);
	$d_mapel = balikin2($rpel['mapel']);
	
	//nilaine...
	$qnile = mysql_query("SELECT * FROM psb_siswa_calon_un ".
							"WHERE kd_siswa_calon = '$swkd' ".
							"AND kd_mapel = '$d_kd'");
	$rnile = mysql_fetch_assoc($qnile);
	$nile_nilai = nosql($rnile['nilai']);
	
	//angkane...
	$nile_nilai1 = substr($nile_nilai,0,-3);
	$nile_nilai2 = substr($nile_nilai,3,2);
	
	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>
	<input name="kd'.$d_kd.'" type="hidden" value="'.$d_kd.'">
	'.$nomer.'
	</td>
	<td>'.$d_mapel.'</td>
	<td>'.$nile_nilai1.','.$nile_nilai2.'</td>
    </tr>';				
	} 
while ($rpel = mysql_fetch_assoc($qpel)); 

echo '</table>
<br>
<br>
<br>';




//nilai US
$qnus = mysql_query("SELECT * FROM psb_siswa_calon_us ".
						"WHERE kd_siswa_calon = '$swkd'");
$rnus = mysql_fetch_assoc($qnus);
$nus_nilai = nosql($rnus['nilai']);

//angkane...
$nus_nilai1 = substr($nus_nilai,0,-3);
$nus_nilai2 = substr($nus_nilai,3,2);

echo '<strong>RATA - RATA NILAI US</strong>
<br>
'.$nus_nilai1.','.$nus_nilai2.'
<br>
<br>
<br>
</p>


<input name="btnOK" type="submit" value="Daftar Calon Lainnya >>">
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