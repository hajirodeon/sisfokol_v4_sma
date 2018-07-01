<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/class/paging.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_cari.php";
$judul = "Hasil Pencarian";
$judulku = $judul;
$katkunci = nosql($_REQUEST['katkunci']);
$kunci = cegah2($_REQUEST['kunci']);



//isi *START
ob_start();




//kondisi pencarian
//nama
if ($katkunci == "cn01")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
					"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
					"FROM psb_siswa_calon, psb_m_login ".
					"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
					"AND psb_siswa_calon.nama LIKE '%$kunci%' ".
					"ORDER BY psb_siswa_calon.no_daftar DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?katkunci=$katkunci&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}


//alamat
else if ($katkunci == "cn02")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
					"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
					"FROM psb_siswa_calon, psb_m_login ".
					"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
					"AND psb_siswa_calon.alamat LIKE '%$kunci%' ".
					"ORDER BY psb_siswa_calon.no_daftar DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?katkunci=$katkunci&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}


//asal sekolah
else if ($katkunci == "cn03")
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
					"psb_siswa_calon.nama AS scnama, psb_m_login.* ".
					"FROM psb_siswa_calon, psb_m_login ".
					"WHERE psb_siswa_calon.kd = psb_m_login.kd ".
					"AND psb_siswa_calon.asal_sekolah LIKE '%$kunci%' ".
					"ORDER BY psb_siswa_calon.no_daftar DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?katkunci=$katkunci&kunci=$kunci";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	}








//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';
//pencarian
require("../inc/menu/psb_cari.php");

echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="left">
<td width="25%">';
//ambil data menu
require("../inc/menu/psb_menu.php");
echo '</td>

<td align="left">
<big><strong>'.$judul.'</strong></big>
<br>';

//jika blm cari
if ((empty($katkunci)) OR (empty($kunci)))
	{
	echo "<font color='red'><strong>Anda Belum Melakukan Pencarian...!!</strong></font>";
	}
else
	{
	if ($count != 0)
		{
		echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr align="center" bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">No.Daftar</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Alamat</font></strong></td>
		<td width="150"><strong><font color="'.$warnatext.'">Asal Sekolah</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Waktu Pendaftaran</font></strong></td>
		</tr>';

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

			$kd = nosql($data['sckd']);
			$d_noreg = nosql($data['no_daftar']);
			$d_nama = balikin($data['scnama']);
			$d_alamat = balikin($data['alamat']);
			$d_asal_sekolah = balikin($data['asal_sekolah']);
			$d_tgl_daftar = $data['tgl_daftar'];


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$d_noreg.'</td>
			<td>'.$d_nama.'</td>
			<td>'.$d_alamat.'</td>
			<td>'.$d_asal_sekolah.'</td>
			<td>'.$d_tgl_daftar.'</td>
	        	</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
		</tr>
		</table>';
		}
	else
		{
		echo "<font color='red'><strong>Yang Anda Cari Tidak Ada.</strong></font>";
		}
	}


echo '</td>
</tr>
</table>


</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>