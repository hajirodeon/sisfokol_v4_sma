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
$filenya = "index.php";
$judul = "S.I Penerimaan Peserta Didik Baru, $sek_nama";
$judulku = $judul;



//isi *START
ob_start();

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//berita
//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT DATE_FORMAT(postdate, '%d') AS ptgl, ".
				"DATE_FORMAT(postdate, '%m') AS pbln, ".
				"DATE_FORMAT(postdate, '%Y') AS pthn, ".
				"DATE_FORMAT(postdate, '%H') AS pjam, ".
				"DATE_FORMAT(postdate, '%i') AS pmnt, ".
				"DATE_FORMAT(postdate, '%w') AS phri, ".
				"psb_berita.* FROM psb_berita ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr valign="top" align="left">
<td width="25%">';
//ambil data menu
require("../inc/menu/psb_menu.php");
echo '</td>

<td align="left">


<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaover.'" valign="top" align="left">
<td>
<big><strong>Selamat Datang di Situs PPD Online</strong></big>
<br>

<strong>'.$sek_nama.'</strong>
<br>
<br>

Situs ini dirancang khusus sebagai pusat informasi Penerimaan Peserta Didik Baru di '.$sek_nama.'. Melalui situs ini Anda mendapatkan informasi secara up to date proses pelaksanaan PPD secara real time online yang jujur, transparan dan demokratis.
Gunakan daftar link di samping untuk mempermudah Anda mengakses informasi penting yang Anda dibutuhkan.
</td>
</tr>
</table>

<hr>
<br>
<br>

<big>
<strong>Info Terbaru PPD Online</strong>
</big>';

//jika ada
if ($count != 0)
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">';
	do
		{
		//nilai
		$d_kd = nosql($data['kd']);
		$d_judul = balikin2($data['judul']);
		$d_isi = balikin($data['isi']);
		$d_ptgl = nosql($data['ptgl']);
		$d_pbln = nosql($data['pbln']);
		$d_pthn = nosql($data['pthn']);
		$d_pjam = nosql($data['pjam']);
		$d_pmnt = nosql($data['pmnt']);
		$d_phri = nosql($data['phri']);


		echo '<tr valign="top">
		<td>
		<br>
		<br>
		<em><font color="brown">'.$sek_kota.', '.$d_ptgl.' '.$arrbln1[$d_pbln].' '.$d_pthn.' - '.$d_pjam.':'.$d_pmnt.' WIB</font></em>
		<br>

		<font color="red"><big><strong>'.$d_judul.'</strong></big></font>
		<br>
		'.$d_isi.'
		<br>
		<br>
		</td>
	    </tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>';
	}
else
	{
	echo '<p>
	<font color="blue">
	<strong>Belum Ada Info Terbaru...</strong>
	</font>
	</p>';
	}

echo '<hr>
<br>
<br>


<big>
<strong>Link-link Penting </strong>
</big>
<br>
<UL>

<LI>
<a href="psb_hasilseleksi.php">Hasil Seleksi</a>
<br>
Klik link ini untuk melihat daftar peserta didik yang diterima.
<br>
<br>
</LI>

<LI>
<a href="psb_reg.php">Pendaftaran</a>
<br>
Klik link ini bila akan mendaftarkan menjadi peserta didik '.$sek_nama.'
<br>
<br>
</LI>


<LI>
<a href="psb_infokelas.php">Daftar Kelas</a>
<br>
Klik link ini untuk mengetahui Kelas yang ada di '.$sek_nama.'
<br>
<br>
</LI>


<LI>
<a href="psb_aturan.php">Aturan dan Prosedur</a>
<br>
Klik link ini untuk melihat aturan dan prosedur pelaksanaan PPD '.$sek_nama.'.
<br>
<br>
</LI>
</UL>
</td>
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