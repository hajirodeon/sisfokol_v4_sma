<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_help.php";
$judul = "Bantuan Pengoperasian web";
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

<strong>Prosedur pengoperasian web bagi pendaftar
</strong>
<br>

<UL>

<LI>
<strong>Pendaftaran  </strong>
<br>
<strong>pilih menu Pendaftaran :</strong>
<br>
Isi semua informasi yang diaggap paling penting, kemudian simpan. setelah itu anda mendapatkan username dan password untuk login ke sistem. catat password dan username tersebut
<br>
<br>
</LI>

<LI>
<strong>Konfirmasi Pembayaran  </strong>
<br>
Sebelum di lakukan proses seleksi siswa baru melalui sistem elektronik , maka diwajibkan untuk melakukan Pembayaran uang pendaftaran. pembayaran ini dapat dilakukan dengan mentransfer atau bayar langsung di tempat jika anda mendaftar langsung di sekolah.
<br>
setelah anda melakukan pembayaran maka anda diwajibkan melakukan konfirmasi pendaftaran dengan memilih menu <B>Konformasi Pendaftaran</B>, isikan informasi sesuai dengan data waktu pendaftaran
<br>
<br>
</LI>

<LI>
<strong>Tes Wawancara  </strong>
<br>
Sistem penerimaan peserta didik di '.$sek_nama.' memakai tes khusus berupa tes wawancara. nilai akan diakumulasi untuk mendapatkan skor. oleh karena itu
anda <strong>diwajibkan</strong> untuk mengikutinya. untuk dapat menggunakan fasilitas ini maka anda wajib melakukan login dengan username dan password yang telah diberikan oleh sistem
setelah anda amsuk ke sistem anda pilih menu ujian dan pilih ujian wawancara. pilihlah jawaban sesuai pendapat anda. setelah selesai tekan tombol <b> simpan</B> kemudian <I>Selesai</i>
<br>
<br>
</LI>

<LI>
<strong>Seleksi PPD Otomatis </strong>
<br>
Setelah melalui waktu yang telah di tentukan maka akan di lakukan seleksi Penerimaan Peserta Didik Baru dengan menggunakan sistem otomatis / Komputer, sehinga akan dihasilkan urutan rangking data hasil PPD berdasarkan kriteria yang telah di tetapkan oleh panitian dalam tata cara Penerimaan Peserta Didik Baru yang diinginkan.
<br>
<br>
</LI>

<LI>
<strong>Rapat dewan Presidium </strong>
<br>
Hasil rangking yang telah dihasilkan Sistem PPD Otomatisasi sebelum di umumkan sebagai hasil akhir Penerimaan Peserta Didik Baru maka akan di rapatkan oleh Panitia untuk memberikan hasil final penerimaan peserta didik.
<br>
<br>

<LI>
<strong>Pengumuman hasil PPD </strong>
<br>
Setelah adanya penetapan dari panitia PPD maka akan diumumkan hasil PPD Online/Offline dalam website '.$sek_nama.' dan bisa di akses langsung secara online untuk melihat hasil pengumumannya.
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