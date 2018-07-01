<?php 



session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_jmlsiswalalu.php";
$judul = "Jumlah Siswa Tahun Lalu";
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
<br>
<br>';

//kelas
$qjur = mysql_query("SELECT * FROm psb_m_kelas");
$rjur = mysql_fetch_assoc($qjur);


echo '<table width="400" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
<td><strong><font color="'.$warnatext.'">Jml.RuangKelas</font></strong></td>
<td><strong><font color="'.$warnatext.'">Jml.Siswa</font></strong></td>
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
	$d_jml_kls_lalu = nosql($rjur['jml_kls_lalu']);
	$d_jml_sw_lalu = nosql($rjur['jml_siswa_lalu']);


	echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
	echo '<td>'.$nomer.'</td>
	<td>'.$d_jml_kls_lalu.'</td>
	<td>'.$d_jml_sw_lalu.'</td>
    </tr>';
	}
while ($rjur = mysql_fetch_assoc($qjur));


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