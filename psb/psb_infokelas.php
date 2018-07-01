<?php 



session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_infokelas.php";
$judul = "Info Kelas";
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
$qjur = mysql_query("SELECT * FROM psb_m_kelas");
$rjur = mysql_fetch_assoc($qjur);
$d_kelas = nosql($rjur['kelas']);
$d_jml_guru = nosql($rjur['jml_guru']);

echo '<table width="400" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
<td><strong><font color="'.$warnatext.'">Sumber Daya</font></strong></td>
<td><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
</tr>

<tr>
<td>1.</td>
<td>Guru</td>
<td>'.$d_jml_guru.'</td>
</tr>
</table>
<br>
<br>

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