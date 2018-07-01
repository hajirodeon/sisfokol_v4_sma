<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_fitur.php";
$judul = "Fitur Sistem PSB Online";
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
Fitur dan kemudahan yang disediakan oleh sistem PPDB Online adalah sebagai berikut:
<br>
<UL>

<LI>
<strong>Web based Aplikasi </strong>
<br>
Sistem Aplikasi PPDB ini menggunakan Web based aplikasi sehinga dengan tools ini akan lebih memberikan kemudahan kepada semua pihak
untuk mengakses aplikasi PPDB tersebut. dengan adanya konsep Web based akan memberikan kemudahan saat instalasi karena dengan
persyaratan browser sebagai interface nya akan lebih familiar untuk digunakan.
</LI>
<br>

<LI>
<strong>Online dan Offline </strong>
<br>
Konsep Online dan Offline merupakan salah satu karakter khusus yang dimiliki oleh PPDB '.$sek_nama.', dengan adanya konsep ini akan
memberikan keleluasan dan fleksibelitas kepada orang tua, calon siswa baru maupun masyarakat luas untuk bisa ikut dalam program
penerimaan siswa baru yang dilakukan pihak sekolah.
</LI>
<br>


<LI>
<strong>Real Time Process & Manual Sistem </strong>
<br>
Pusat server PPDB mempunyai kemampuan mengolah data calon siswa secara langsung setiap waktu (Real-Time Online Process) mulai dari
proses pendaftaran, penyeleksian hingga pengumuman hasil penerimaan siswa di masing-masing sekolah. Seluruh proses tersebut akan
dikendalikan oleh pusat server PPDB secara otomatis namun hasil akhir sistem PPDB ini masih tetap ada fungsi manusia yang menjadi
penentu akhir yang di lakukan oleh '.$sek_nama.' dalam menetapkan hasil PPDB tersebut.
</LI>
<br>



<LI>
<strong>Integrasi Internet dan Intranet </strong>
<br>
Aplikasi PPDB ini disimpan dalam server hosting yang ditempatkan dalam jaringan LAN '.$sek_nama.' namun aplikasi ini tetap bisa di akses
dari luar jaringan intranet '.$sek_nama.'.
</LI>
<br>


<LI>
<strong>Dynamic Konsep </strong>
<br>
Aplikasi PSB '.$sek_nama.' menggunakan konsep dynamic konsep sehinga dengan adanya konsep ini akan memberikan rule yang bebas untuk cara
pengaturan PSB di masing-masing sekolah berdasarkan kebijakan yang telah di tetapkan oleh management sekolah.
</LI>

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