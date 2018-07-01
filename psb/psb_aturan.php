<?php 


session_start();


//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "psb_aturan.php";
$judul = "Aturan dan Prosedur";
$judulku = $judul;




//isi *START
ob_start();

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qdti = mysql_query("SELECT * FROM psb_set_waktu_daftar");
$rdti = mysql_fetch_assoc($qdti);
$dti_pendaftaran = balikin($rdti['pendaftaran']);
$dti_pengumuman_1 = balikin($rdti['pengumuman_1']);
$dti_daftar_ulang_1 = balikin($rdti['daftar_ulang_1']);
$dti_pengumuman_2 = balikin($rdti['pengumuman_2']);
$dti_daftar_ulang_2 = balikin($rdti['daftar_ulang_2']);
$dti_masuk = balikin($rdti['masuk']);
$dti_lokasi = balikin($rdti['lokasi']);
$dti_biaya = balikin($rdti['biaya']);



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


<strong>A. Jadwal Penerimaan Siswa Baru </strong>
<br>
<UL>

<table width="100%" border="0" cellspacing="3" cellpadding="0">
<tr>
<td>
1.	Pendaftaran
</td>
<td>
: '.$dti_pendaftaran.'
</td>
</tr>

<tr>
<td>
2.	Pengumuman 1
</td>
<td>
: '.$dti_pengumuman_1.'
</td>
</tr>

<tr>
<td>
3.	Daftar Ulang 1
</td>
<td>
: '.$dti_daftar_ulang_1.'
</td>
</tr>

<tr>
<td>
4.	Pengumuman 2
</td>
<td>
: '.$dti_pengumuman_2.'
</td>
</tr>

<tr>
<td>
5.	Daftar Ulang 2
</td>
<td>
: '.$dti_daftar_ulang_2.'
</td>
</tr>

<tr>
<td>
6.	Masuk sekolah hari pertama
</td>
<td>
: '.$dti_masuk.'
</td>
</tr>

</table>



</UL>
<br>
<br>

<strong>B. Lokasi Pendaftaran</strong>
<UL>
'.$sek_nama.', '.$sek_alamat.', '.$sek_telp.'
</UL>
<br>
<br>

<strong>C. Biaya Pendaftaran PSB </strong>
<UL>
'.xduit2($dti_biaya).'
</UL>
<br>
<br>


<strong>D. Syarat Pendaftaran PSB </strong>
<UL>
1.	Fotokopi STTB legalisir (1 lembar).
<br>
3.	Daftar Nominasi Ujian Naional DANUN Asli (1 lembar).
<br>
4.	Surat Rekomendasi Asli dari Dinas Pendidikan Kabupaten (berdasarkan Surat rekomendasi dari kepala sekolah dan kepala dinas pendidikan asal) bagi calon siswa asal luar Propinsi.
</UL>
<br>
<br>

<strong>E. Alur Pendaftaran PSB</strong>
<UL>
1.	Mengisi data yang diperlukan di komputer yang telah disediakan, didampingi oleh petugas PSB.
<br>
2.	Menerima print out pendaftaran.
<br>
3.	Menyerahkan berkas pendaftaran dan membayar uang pendaftaran di loket.
<br>
4.	Menerima Tanda Bukti Pendaftaran.
<br>
5.	Proses pendaftaran selesai.
</UL>
<br>
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