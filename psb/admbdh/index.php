<?php 



session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/psb_admbdh.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang....";
$judulku = "$judul  [$bdh_session]";


//isi *START
ob_start();

//menu
require("../../inc/menu/psb_admbdh.php");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" height="400" border="0" cellspacing="0" cellpadding="3">
<tr valign="middle">
<td valign="middle" align="center">
<p>
Anda Berada di <font color="blue"><strong>BENDAHARA AREA</strong></font>
</p>
<p><em>{Harap Dikelola Dengan Baik.)</em></p>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>