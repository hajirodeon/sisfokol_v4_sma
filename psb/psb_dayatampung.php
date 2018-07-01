<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_dayatampung.php";
$judul = "Daya Tampung";
$judulku = $judul;




//isi *START
ob_start();

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

//query
$qkea = mysql_query("SELECT * FROM psb_m_kelas");
$rkea = mysql_fetch_assoc($qkea);

echo '<table border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Jml.RuangKelas</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Daya Tampung</font></strong></td>
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

	$nomer = $nomer + 1;
	$d_jml_kelas = nosql($rkea['jml_kelas']);
	$d_daya_tampung = nosql($rkea['daya_tampung']);

	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$nomer.'</td>
	<td>'.$d_jml_kelas.'</td>
	<td>'.$d_daya_tampung.'</td>
	</tr>';
	}
while ($rkea = mysql_fetch_assoc($qkea));

echo '</table>


</td>
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