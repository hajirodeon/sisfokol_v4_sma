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
$filenya = "psb_bukutamu.php";
$judul = "Buku Tamu";
$judulku = $judul;




//isi *START
ob_start();

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM psb_buku_tamu ".
				"ORDER BY postdate DESC";
$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);


echo '<form action="'.$filenya.'" method="post" name="formx">';
echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr align="left" valign="top">
<td width="25%">';
//ambil data menu
require("../inc/menu/psb_menu.php");
echo '</td>

<td align="left">
<big><strong>'.$judul.'</strong></big>
<br>
[<a href="psb_bukutamu_post.php" title="Tulis Baru">Tulis Baru</a>]
<br>';

if ($count != 0)
	{
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">';

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

		$d_nama = balikin2($data['nama']);
		$d_alamat = balikin2($data['alamat']);
		$d_kelamin = nosql($data['kelamin']);
		$d_email = balikin2($data['email']);
		$d_web = balikin2($data['web']);
		$d_komentar = balikin2($data['komentar']);
		$d_ip = nosql($data['ip']);
		$d_postdate = $data['postdate'];

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<em>'.$d_komentar.'</em>
		<br>
		Nama : <em>'.$d_nama.'</em>,
		Alamat : <em>'.$d_alamat.'</em>,
		Kelamin : <em>'.$d_kelamin.'</em>,
		<br>
		E-Mail : <em>'.$d_email.'</em>,
		Web : <em>'.$d_web.'</em>,
		IP : <em>'.$d_ip.'</em>
		<br>
		Postdate : <em>'.$d_postdate.'</em>
		</td>
        </tr>';
		}
	while ($data = mysql_fetch_assoc($result));

	echo '</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Komentar.</td>
	</tr>
	</table>';
	}
else
	{
	echo '<font color="red"><strong>Belum Ada Yang Mengisi Buku Tamu.</strong></font>';
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