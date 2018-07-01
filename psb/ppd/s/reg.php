<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php"); 
require("../../../inc/cek/psb_ppd.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "reg.php";
$judul = "Set Data Diri...";
$judulku = "[$ppd_session : $no4_session.$nama4_session] ==> $judul";
$judulx = $judul;



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	$ke = "../index.php";
	xloc($ke);
	exit();
	}
	
	
	
//nek simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$nama = cegah($_POST['nama']);
	$tmp_lahir = cegah($_POST['tmp_lahir']);
	
	$lxtgl = nosql($_POST['lxtgl']);
	$lxbln = nosql($_POST['lxbln']);
	$lxthn = nosql($_POST['lxthn']);
	$tgl_lahir = "$lxthn:$lxbln:$lxtgl";
	
	$alamat = cegah($_POST['alamat']);
	$kelamin = nosql($_POST['kelamin']);
	$agama = cegah($_POST['agama']);
	$nm_ortu = cegah($_POST['nm_ortu']);
	$almt_ortu = cegah($_POST['almt_ortu']);
	$ker_ortu = cegah($_POST['ker_ortu']);
	$nm_wali = cegah($_POST['nm_wali']);
	$almt_wali = cegah($_POST['almt_wali']);
	$ker_wali = cegah($_POST['ker_wali']);
	$asal_sek = cegah($_POST['asal_sek']);
	$status_sek = cegah($_POST['status_sek']);
	$almt_sek = cegah($_POST['almt_sek']);
	$no_sttb = cegah($_POST['no_sttb']);
	$thn_lulus = nosql($_POST['thn_lulus']);
	$us_nilx = nosql($_POST['us_nilx']);
	$us_nily = nosql($_POST['us_nily']);	
	
	//cek
	if (empty($nama))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query update //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		mysql_query("UPDATE psb_siswa_calon SET nama = '$nama', ".
						"tmp_lahir = '$tmp_lahir', ".
						"tgl_lahir = '$tgl_lahir', ".
						"alamat = '$alamat', ".
						"kelamin = '$kelamin', ".
						"agama = '$agama', ".
						"nama_ayah = '$nm_ortu', ".
						"alamat_ayah = '$almt_ortu', ".
						"kerja_ayah = '$ker_ortu', ".
						"nama_wali = '$nm_wali', ".
						"alamat_wali = '$almt_wali', ".
						"kerja_wali = '$ker_wali', ".
						"asal_sekolah = '$asal_sek', ".
						"status_sekolah = '$status_sek', ".
						"alamat_sekolah = '$almt_sek', ".
						"no_sttb = '$no_sttb', ".
						"tahun_lulus = '$thn_lulus' ".
						"WHERE kd = '$kd4_session'");
	
	
	
	
		//entry nilai UN ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$qpel = mysql_query("SELECT * FROM psb_m_mapel ".
								"ORDER BY mapel ASC");
		$rpel = mysql_fetch_assoc($qpel);
		
		do 
			{ 
			$nomer = $nomer + 1;
			$xx = md5("$x$nomer");	
			$d_kd = nosql($rpel['kd']);
			
			//nilai mapel
			$xnil = "nil";
			$xnil1 = "$xnil$nomer";
			$xnilx = nosql($_POST["$xnil1"]);
		
			$xkom = "kom";
			$xkom1 = "$xkom$nomer";
			$xkomx = nosql($_POST["$xkom1"]);
			
			//nek empty
			if (empty($xnilx))
				{
				$xnilx = "00";
				}
			
			if (empty($xkomx))
				{
				$xkomx = "00";
				}		
			
	
			//cek nol
			if (strlen($xnilx) == 1)
				{
				$xnilx = "0$xnilx";
				}
		
			if (strlen($xkomx) == 1)
				{
				$xkomx = "$xkomx"."0";
				}
		

			//nilai...
			$xnilku = "$xnilx.$xkomx";
			
			//entry update
			mysql_query("UPDATE psb_siswa_calon_un SET nilai = '$xnilku' ".
							"WHERE kd_siswa_calon = '$kd4_session' ".
							"AND kd_mapel = '$d_kd'");
			}
		while ($rpel = mysql_fetch_assoc($qpel)); 		

	
	
		//entry nilai US ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//nek empty
		if (empty($us_nilx))
			{
			$us_nilx = "00";
			}
			
		if (empty($us_nily))
			{
			$us_nily = "00";
			}		
			
	
		//cek nol
		if (strlen($us_nilx) == 1)
			{
			$us_nilx = "0$us_nilx";
			}
		
		if (strlen($us_nily) == 1)
			{
			$us_nily = "$us_nily"."0";
			}
		
			
		//nilai...
		$us_nil = "$us_nilx.$us_nily";
		


		//cek
		$qcc = mysql_query("SELECT * FROM psb_siswa_calon_us ".
								"WHERE kd_siswa_calon = '$kd4_session'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		
		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE psb_siswa_calon_us SET nilai = '$us_nil' ".
							"WHERE kd_siswa_calon = '$kd4_session'");
			}
		else
			{
			//insert
			mysql_query("INSERT INTO psb_siswa_calon_us(kd, kd_siswa_calon, nilai) VALUES ".
							"('$x', '$kd4_session', '$us_nil')");
			}
			
	
	
		//re-direct 
		xloc($filenya);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();



//js
require("../../../inc/js/swap.js"); 
require("../../../inc/js/number.js"); 
require("../../../inc/menu/psb_ppd.php"); 
xheadline($judul);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$qdt = mysql_query("SELECT DATE_FORMAT(tgl_lahir, '%d') AS ltgl, ".
						"DATE_FORMAT(tgl_lahir, '%m') AS lbln, ".
						"DATE_FORMAT(tgl_lahir, '%Y') AS lthn, ".
						"psb_siswa_calon.* ".
						"FROM psb_siswa_calon ".
						"WHERE kd = '$kd4_session'");
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
<p>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr>
<td width="250">
No. Pendaftaran
</td>
<td width="1">:</td>
<td>
<input name="no_reg" type="text" size="10" value="'.$dt_noregx.'" disabled>
</td>
</tr>
</table>
<br>
<br>
<br>

<strong>IDENTITAS PESERTA</strong>
<br>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr>
<td width="250">
1. Nama
</td>
<td width="1">:</td>
<td>
<input name="nama" type="text" value="'.$dt_nama.'" size="30" maxlength="30">
</td>
</tr>

<tr>
<td>
2. TTL
</td>
<td>:</td>
<td>
<input name="tmp_lahir" type="text" value="'.$dt_tmp_lahir.'" size="20">, 
<select name="lxtgl">
<option value="'.$dt_tgl.'" selected>'.$dt_tgl.'</option>';
for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$i.'">'.$i.'</option>';
	}
	
echo '</select>
<select name="lxbln">
<option value="'.$dt_bln.'" selected>'.$arrbln1[$dt_bln].'</option>';
for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
	}
	
echo '</select>
<select name="lxthn">
<option value="'.$dt_thn.'" selected>'.$dt_thn.'</option>';
for ($k=$lahir01;$k<=$lahir02;$k++)
	{
	echo '<option value="'.$k.'">'.$k.'</option>';
	}
echo '</select>
</td>
</tr>

<tr>
<td>
3. Alamat : 
</td>
<td>:</td>
<td>
<input name="alamat" type="text" value="'.$dt_alamat.'" size="50">
</td>
</tr>

<tr>
<td>
4. Jenis Kelamin (L/P) : 
</td>
<td>:</td>
<td>
<select name="kelamin">
<option value="'.$dt_kelamin.'" selected>'.$dt_kelamin.'</option>
<option value="L">L</option>
<option value="P">P</option>
</select>
</td>
</tr>

<tr>
<td>
5. Agama : 
</td>
<td>:</td>
<td>
<select name="agama">
<option value="'.$dt_agama.'" selected>'.$dt_agama.'</option>
<option value="Islam">Islam</option>
<option value-"Kristen">Kristen</option>
<option value="Katholik">Katholik</option>
<option value="Budha">Budha</option>
<option value="Hindu">Hindu</option>
<option value="Konghuchu">Konghuchu</option>
</select>
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
1. Nama Orang Tua / Ayah : 
</td>
<td width="1">:</td>
<td>
<input name="nm_ortu" type="text" value="'.$dt_nm_ortu.'" size="20">
</td>
</tr>

<tr>
<td>
2. Alamat Orang Tua / Ayah
</td>
<td>:</td>
<td>
<input name="almt_ortu" type="text" value="'.$dt_almt_ortu.'" size="50">
</td>
</tr>

<tr>
<td>
3. Pekerjaan Orang Tua / Ayah
</td>
<td>:</td>
<td>
<select name="ker_ortu">
<option value="'.$dt_ker_ortu.'" selected>'.$dt_ker_ortu.'</option>
<option value="PNS">PNS</option>
<option value="TNI/POLRI">TNI/POLRI</option>
<option value="Swasta">Swasta</option>
<option value="Tani">Tani</option>
<option value="Buruh">Buruh</option>
</select>
</td>
</tr>

<tr>
<td>
4. Nama Wali : 
</td>
<td>:</td>
<td>
<input name="nm_wali" type="text" value="'.$dt_nm_wali.'" size="20"> 
</td>
</tr>

<tr>
<td>
5. Alamat Wali : 
</td>
<td>:</td>
<td>
<input name="almt_wali" type="text" value="'.$dt_almt_wali.'" size="50">
</td>
</tr>

<tr>
<td>
6. Pekerjaan Wali : 
</td>
<td>:</td>
<td>
<select name="ker_wali">
<option value="'.$dt_ker_wali.'" selected>'.$dt_ker_wali.'</option>
<option value="PNS">PNS</option>
<option value="TNI/POLRI">TNI/POLRI</option>
<option value="Swasta">Swasta</option>
<option value="Tani">Tani</option>
<option value="Buruh">Buruh</option>
</select>
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
1. Asal Sekolah
</td>
<td width="1">:</td>
<td>
<input name="asal_sek" type="text" value="'.$dt_asal_sek.'" size="30">
</td>
</tr>

<tr>
<td>
2. Status Sekolah
</td>
<td>:</td>
<td>
<select name="status_sek">
<option value="'.$dt_status_sek.'" selected>'.$dt_status_sek.'</option>
<option value="Negeri">Negeri</option>
<option value="Swasta">Swasta</option>
</select>
</td>
</tr>

<tr>
<td>
3. Alamat Sekolah : 
</td>
<td>:</td>
<td>
<input name="almt_sek" type="text" value="'.$dt_almt_sek.'" size="50">
</td>
</tr>

<tr>
<td>
4. No. STTB :  
</td>
<td>:</td>
<td>
<input name="no_sttb" type="text" value="'.$dt_no_sttb.'" size="20">
</td>
</tr>

<tr>
<td>
5. Tahun Lulus : 
</td>
<td>:</td>
<td>
<input name="thn_lulus" type="text" value="'.$dt_thn_lulus.'" size="4" onKeyPress="return numbersonly(this, event)">
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
							"WHERE kd_siswa_calon = '$kd4_session' ".
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
	<td>
	<input name="nil'.$nomer.'" type="text" value="'.$nile_nilai1.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
	<input name="kom'.$nomer.'" type="text" value="'.$nile_nilai2.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
	</td>
    </tr>';				
	} 
while ($rpel = mysql_fetch_assoc($qpel)); 

echo '</table>
<br>
<br>
<br>
<br>';



//nilai US
$qnus = mysql_query("SELECT * FROM psb_siswa_calon_us ".
						"WHERE kd_siswa_calon = '$kd4_session'");
$rnus = mysql_fetch_assoc($qnus);
$nus_nilai = nosql($rnus['nilai']);

//angkane...
$nus_nilai1 = substr($nus_nilai,0,-3);
$nus_nilai2 = substr($nus_nilai,3,2);

echo '<strong>RATA - RATA NILAI US</strong>
<br>
<input name="us_nilx" type="text" value="'.$nus_nilai1.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">,
<input name="us_nily" type="text" value="'.$nus_nilai2.'" size="2" maxlength="2" onKeyPress="return numbersonly(this, event)">
<br>
<br>
<br>
<br>


<input name="btnBTL" type="submit" value="BATAL">
<input name="btnSMP" type="submit" value="SIMPAN">
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