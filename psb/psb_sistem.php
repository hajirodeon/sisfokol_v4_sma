<?php 



session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_sistem.php";
$judul = "Sistem PSB Online";
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
Dengan perkembangan Teknologi Informasi saat ini, pelaksanaan seleksi penerimaan siswa baru (PSB) di '.$sek_nama.' dapat dilakukan secara on line melalui Intranet.
Perkembangan seleksi calon siswa dapat langsung dipantau melalui intranet '.$sek_nama.' dan internet setelah melalui proses upload.
<br>
<br>

Sistem ini belum dapat dipantau di internet secara real time karena keterbatasan sumber daya yang ada. Insyaallah di masa mendatang hal tersebut dapat dilaksanakan.
<br>
<br>

<strong>Keuntungan dan Manfaat.</strong>
<br>
<br>

Keuntungan yang diperoleh dengan sistem PSB Online ini, antara lain:
<br>

A. Bagi Dinas Pendidikan dan Sekolah.
<br>
1. Meningkatkan kepercayaan masyarakat.
<br>
2. Meningkatkan efektifitas pelaksanaan PSB.
<br>
3. Efisiensi biaya penyelenggaraan PSB.
<br>
<br>

B. Bagi Calon Siswa dan Masyarakat.
<br>
1. Mempermudah proses pendfataran yang aman dan tertib.
<br>
2. Mempermudah dan mempercepat akses info PSB melalui Internet
<br>
3. Meningkatkan ketertiban dan kepercayaan pada pelaksanaan proses PSB.

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