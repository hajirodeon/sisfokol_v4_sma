<?php
//nilai
$maine = "$sumber/admsurat/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>Home</strong></a>&nbsp;&nbsp; | ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu1"><strong>SETTING</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu1" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admsurat/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//surat /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>SURAT</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="#" title="Master">Master</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/m_klasifikasi.php" title="Klasifikasi Surat">Klasifikasi Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/m_lemari.php" title="Lemari Surat">Lemari Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/m_rak.php" title="Rak Surat">Rak Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/m_ruang.php" title="Ruang Surat">Ruang Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/m_map.php" title="Map Surat">Map Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/m_sifat.php" title="Sifat Surat">Sifat Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/m_status.php" title="Status Surat">Status Surat</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/m_indeks.php" title="Indeks Berkas">Indeks Berkas</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Surat Masuk">Surat Masuk</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/masuk.php" title="Data Surat Masuk">Data Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/penempatan_masuk.php" title="Penempatan Surat Masuk">Penempatan Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/cari_masuk.php" title="Cari Surat Masuk">Cari Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/kendali_masuk.php" title="Kartu Kendali Surat Masuk">Kartu Kendali Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/masuk_berkas_disposisi.php" title="Indeks Berkas Disposisi">Indeks Berkas Disposisi</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/masuk_berkas_kendali.php" title="Indeks Berkas Kendali">Indeks Berkas Kendali</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/rekap_masuk.php" title="Rekap Surat Masuk">Rekap Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/rekap_bulanan_masuk.php" title="Rekap Bulanan Surat Masuk">Rekap Bulanan Surat Masuk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/rekap_terima_masuk.php" title="Rekap Terima Surat Masuk">Rekap Terima Surat Masuk</a>
	</LI>

	</UL>
</LI>



<LI>
<a href="#" title="Surat Keluar">Surat Keluar</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admsurat/surat/keluar.php" title="Data Surat Keluar">Data Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/penempatan_keluar.php" title="Penempatan Surat Masuk">Penempatan Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/cari_keluar.php" title="Cari Surat Keluar">Cari Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/kendali_keluar.php" title="Kartu Kendali Surat Keluar">Kartu Kendali Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/keluar_berkas_disposisi.php" title="Indeks Berkas Disposisi">Indeks Berkas Disposisi</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/keluar_berkas_kendali.php" title="Indeks Berkas Kendali">Indeks Berkas Kendali</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/rekap_keluar.php" title="Rekap Surat Keluar">Rekap Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/rekap_bulanan_keluar.php" title="Rekap Bulanan Surat Keluar">Rekap Bulanan Surat Keluar</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/admsurat/surat/rekap_kirim_keluar.php" title="Rekap Kirim Surat Keluar">Rekap Kirim Surat Keluar</a>
	</LI>
	</UL>
</LI>

</UL>';
//surat /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu29" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu29" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admsurat/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admsurat/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admsurat/p/baru.php" title="Koleksi Item Terbaru">Koleksi Item Terbaru</a>
</LI>
</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="'.$sumber.'/admsurat/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>