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
$filenya = "konfirmasi.php";
$judul = "Data Konfirmasi";
$judulku = "[$bdh_session] ==> $judul";
$judulx = $judul;
$set = nosql($_REQUEST['set']);
$katcari = nosql($_REQUEST['katcari']);
$kunci = cegah2($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//aktifkan...
if ($set = "aktif")
	{
	//nilai
	$kd = nosql($_REQUEST['kd']);
	$noreg = nosql($_REQUEST['noreg']);
	
	//update
	mysql_query("UPDATE psb_siswa_calon SET status_daftar = 'true' ".
					"WHERE kd = '$kd' ".
					"AND no_daftar = '$noreg'");
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();



//query
$p = new Pager();
$start = $p->findStart($limit);



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
							"AND psb_siswa_calon.jml_bayar <> '' ".
							"AND psb_siswa_calon.tgl_bayar <> '0000-00-00 00:00:00' ".
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
							"AND psb_siswa_calon.jml_bayar <> '' ".
							"AND psb_siswa_calon.tgl_bayar <> '0000-00-00 00:00:00' ".
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
							"AND psb_siswa_calon.jml_bayar <> '' ".
							"AND psb_siswa_calon.tgl_bayar <> '0000-00-00 00:00:00' ".
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
					"AND psb_siswa_calon.jml_bayar <> '' ".
					"AND psb_siswa_calon.tgl_bayar <> '0000-00-00 00:00:00' ".
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
					"AND psb_siswa_calon.jml_bayar <> '' ".
					"AND psb_siswa_calon.tgl_bayar <> '0000-00-00 00:00:00' ".
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
require("../../../inc/menu/psb_admbdh.php"); 
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
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="150"><strong><font color="'.$warnatext.'">Asal Sekolah</font></strong></td>
<td width="150"><strong><font color="'.$warnatext.'">Waktu Pendaftaran</font></strong></td>
<td width="150"><strong><font color="'.$warnatext.'">Waktu Pembayaran</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Status</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Pembayaran</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Kuitansi</font></strong></td>
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
		$d_kd = nosql($data['sckd']);
		$d_noreg = nosql($data['no_daftar']);
		$d_username = nosql($data['username']);
		$d_nama = balikin($data['scnama']);
		$d_asal_sekolah = balikin($data['asal_sekolah']);
		$d_tgl_daftar = $data['tgl_daftar'];
		$d_tgl_bayar = $data['tgl_bayar'];
		$d_status_daftar = nosql($data['status_daftar']);
		
		//status
		if ($d_status_daftar == "false")
			{
			$status_ket = "<strong><font color='red'>BELUM BAYAR.</font></strong>";
			}
		else
			{
			$status_ket = "<strong><font color='blue'>SUDAH BAYAR.</font></strong>";
			}
			
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$d_noreg.'</td>
		<td>'.$d_nama.'</td>
		<td>'.$d_asal_sekolah.'</td>		
		<td>'.$d_tgl_daftar.'</td>
		<td>'.$d_tgl_bayar.'</td>
		<td>'.$status_ket.'</td>
		<td>
		[<a href="konfirmasi_bayar.php?swkd='.$d_kd.'&page='.$page.'" title="Print Kuitansi : ['.$d_noreg.']. '.$d_nama.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>]
		</td>
		<td>';
		
		//jika belum bayar, tidak bisa print kuitansi
		if ($d_status_daftar == "false")
			{
			echo '-';
			}
		else
			{		
			echo '[<a href="konfirmasi_kuitansi.php?swkd='.$d_kd.'&page='.$page.'" title="Print Kuitansi : ['.$d_noreg.']. '.$d_nama.'">
			<img src="'.$sumber.'/img/print.gif" width="16" height="16" border="0">
			</a>]';
			}	
		
		
		echo '</td>
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