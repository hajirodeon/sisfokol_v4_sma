<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_carakerja.php";
$judul = "Cara Kerja Sistem";
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
<br>

<img src="../img/cara_kerja_sistem.gif" width="494" height="295">
<br>
<br>

<strong><em>Keterangan Gambar : </em></strong>
<br>

<strong>Cara kerja sistem penerimaan Peserta Didik Baru di sekolah
'.$sek_nama.'.
</strong>
<br>

<UL>

<LI>
<strong>Pendaftaran (1) </strong>
<br>
<strong>Proses pendaftaran PPD bisa melalui 2 cara yakni :</strong>
<br>
<strong>Online : </strong>Siswa / orang tua murid bisa melakukan pendaftaran dan registrasi data melalui internet sehinga dengan cara ini
akan memberikan efisiensi waktu kepada calon siswa dalam melakukan registrasi pendaftaran di sekolah '.$sek_nama.'.
<br>
<br>
<strong>Offline : </strong>Cara pendaftaran siswa baru secara manual ketempat panitia pendaftaran siswa baru. sistem ini di siapkan bagi
orantua / siswa yang belum memiliki fasilitas online untuk melakukan pendaftaran.
<br>
<br>
</LI>

<LI>
<strong>Pengecekan dokumen hardcopy (2) </strong>
<br>
Sebelum di lakukan proses seleksi siswa baru melalui sistem elektronik , maka diwajibkan untuk melakukan klarifikasi / pengecekan
dokumentasi hardcopy sebagai bentuk bukti terhadap data yang telah di daftarkan dalam proses pendaftaran PPD Online / Offline.
<br>
<br>
</LI>

<LI>
<strong>Pendafataran Offline (3) & (4) </strong>
<br>
Sistem pendaftaran PPD dengan secara offline dengan cara datang langsung ke tempat panitia Penerimaan Peserta Didik Baru di tempat yang
sudah di sediakan oleh panitia PPD. Walaupun pendafataran secara offline maka tetap akan di lakukan sistem seleksi online yang
terintegrasi antara data Online dan Offline.
<br>
<br>
</LI>

<LI>
<strong>Upload data Offline (5) </strong>
<br>
Panitia PPD Offline akan melakukan upload data offline ke Online untuk setiap pendafataran yang melalui proses Offline. sehinga dalam
perhitungan nanti antara pendaftaran Online dan Offline tampa ada perbedaan perhitungan.
<br>
<br>
</LI>

<LI>
<strong>Seleksi PPD Otomatis (6)  </strong>
<br>
Setelah melalui waktu yang telah di tentukan maka akan di lakukan seleksi Penerimaan Peserta Didik Baru dengan menggunakan sistem
otomatis / Komputer, sehinga akan dihasilkan urutan rangking data hasil PPD berdasarkan kriteria yang telah di tetapkan oleh panitian
dalam tata cara Penerimaan Peserta Didik Baru yang diinginkan.
<br>
<br>
</LI>

<LI>
<strong>Rapat dewan Presidium (7)  </strong>
<br>
Hasil rangking yang telah dihasilkan Sistem PPD Otomatisasi sebelum di umumkan sebagai hasil akhir Penerimaan Peserta Didik Baru maka
akan di rapatkan oleh Panitia untuk memberikan hasil final penerimaan peserta didik.
<br>
<br>

<LI>
<strong>Pengumuman hasil PPD (8)  </strong>
<br>
Setelah adanya penetapan dari panitia PPD maka akan diumumkan hasil PPD Online/Offline dalam website '.$sek_nama.' dan bisa di akses
langsung secara online untuk melihat hasil pengumumannya.
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