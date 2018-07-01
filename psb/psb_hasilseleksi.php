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
$filenya = "psb_hasilseleksi.php";
$judul = "Hasil Seleksi";
$judulku = $judul;
$keakd = nosql($_REQUEST['keakd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//isi *START
ob_start();


//js
require("../inc/js/jumpmenu.js");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';
echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="left">
<td width="25%">';
//ambil data menu
require("../inc/menu/psb_menu.php");
echo '</td>

<td align="left">
<big><strong>'.$judul.'</strong></big>
<br>';


//cek, sudah aktif belum
$qcc = mysql_query("SELECT * FROM psb_set_seleksi");
$rcc = mysql_fetch_assoc($qcc);
$cc_seleksi = nosql($rcc['seleksi']);

//aktif
if ($cc_seleksi == "true")
	{
	//terpilih
	$qtpx = mysql_query("SELECT * FROM psb_m_kelas");
	$rowtpx = mysql_fetch_assoc($qtpx);
	$tpx_kd = nosql($rowtpx['kd']);
	$tpx_kea = balikin($rowtpx['kelas']);
	$tpx_tampung = nosql($rowtpx['daya_tampung']);


	//query data
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT psb_siswa_calon.*, psb_siswa_calon.kd AS sckd, ".
					"psb_siswa_calon.nama AS scnama, psb_siswa_calon_rangking.* ".
					"FROM psb_siswa_calon, psb_siswa_calon_rangking ".
					"WHERE psb_siswa_calon.kd = psb_siswa_calon_rangking.kd_siswa_calon ".
					"AND psb_siswa_calon.status_daftar = 'true' ".
					"ORDER BY round(psb_siswa_calon_rangking.no) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);

	if ($count != 0)
		{
		echo '[Daya Tampung : <strong>'.$tpx_tampung.'</strong>].
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr align="center" bgcolor="'.$warnaheader.'">
		<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">No.Daftar</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Skor Ujian Mapel</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Skor Wawancara</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Nilai UN</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Nilai Prestasi</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Nilai US</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Rata-Rata</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Ket.</font></strong></td>
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

			$d_kd = nosql($data['sckd']);
			$d_no = nosql($data['no']);
			$d_noreg = nosql($data['no_daftar']);
			$d_nama = balikin($data['scnama']);
			$d_status = nosql($data['status_diterima']);
			$d_nil_mapel = nosql($data['nil_mapel']);
			$d_nil_wwc = nosql($data['nil_wwc']);
			$d_nil_un = nosql($data['nil_un']);
			$d_nil_prestasi = nosql($data['nil_prestasi']);
			$d_nil_us = nosql($data['nil_us']);
			$d_total_rata = nosql($data['total_rata']);


			//status diterima //////////////////////////////////////////////////////////////////////////////
			if ($d_status == "true")
				{
				$status_diterima = "<font color='red'><strong>DITERIMA</strong></font>";
				}
			else
				{
				$status_diterima = "<font color='blue'><i>DITOLAK</i></font>";
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$d_no.'.</td>
			<td>'.$d_noreg.'</td>

			<td>'.$d_nama.'</td>
			<td>'.$d_nil_mapel.'</td>

			<td>'.$d_nil_wwc.'</td>

			<td>'.$d_nil_un.'</td>

			<td>'.$d_nil_prestasi.'</td>

			<td>'.$d_nil_us.'</td>

			<td>'.$d_total_rata.'</td>

			<td>'.$status_diterima.'</td>

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
		echo '<font color="red"><strong>TIDAK ADA DATA CALON YANG DITERIMA</strong></font>';
		}
	}
else
	{
	echo '<font color="red"><strong>Hasil Seleksi Belum Bisa Diketahui.
	<br>
	Karena Proses Penerimaan Pendaftaran Peserta Didik Baru, Masih Berlangsung.
	<br>
	<br>
	<br>
	Ttd. Panitia</strong></font>';
	}

echo '</td>
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

require("../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>