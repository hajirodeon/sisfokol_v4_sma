<?php
//nilai
$maine = "$sumber/admks/index.php";


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
<a href="'.$sumber.'/admks/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>DATA</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="#" title="Mata Pelajaran">Mata Pelajaran</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admks/m/mapel.php" title="Data Mata Pelajaran">Data Mata Pelajaran</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admks/m/mapel_kelas.php" title="Mata Pelajaran per Kelas">Mata Pelajaran per Kelas</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Guru">Guru</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admks/m/guru.php" title="Guru">Guru</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admks/m/guru_mapel_r.php" title="Guru Mata Pelajaran per Ruang">Guru Mata Pelajaran per Ruang</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admks/m/guru_mapel_tmp.php" title="Penempatan Guru Mengajar">Penempatan Guru Mengajar</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admks/m/wk.php" title="Wali Kelas">Wali Kelas</a>
	</LI>
	</UL>
</LI>


<LI>
<a href="#" title="Siswa">Siswa</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admks/m/siswa.php" title="Data Siswa">Data Siswa</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admks/m/siswa_tmp_k.php" title="Data Siswa per Kelas">Data Siswa per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admks/m/siswa_tmp_p.php" title="Data Siswa per Program">Data Siswa per Program</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admks/m/siswa_tmp_r.php" title="Data Siswa per Ruang">Data Siswa per Ruang</a>
	</LI>
	</UL>
</LI>
</UL>';
//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$sumber.'/admks/jwl/jadwal.php" title="Jadwal Pelajaran" class="menuku"><strong>Jadwal Pelajaran</strong></a>&nbsp;&nbsp; | ';
//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//laporan ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu3"><strong>LAPORAN</strong></A> |
<UL id="flexmenu3" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admks/lap/raport.php" title="Raport Siswa">Raport Siswa</a>
</LI>
<LI>
<a href="'.$sumber.'/admks/lap/abs_rekap_kelas.php" title="Rekap Absensi per Kelas Ruang">Rekap Absensi per Kelas Ruang</a>
</LI>
</UL>';
//laporan ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu29" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu29" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admks/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admks/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admks/p/baru.php" title="Koleksi Item Terbaru">Koleksi Item Terbaru</a>
</LI>
</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//surat /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu4"><strong>SURAT</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu4" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admks/surat/masuk.php" title="Daftar Surat Masuk">Surat Masuk</a>
</LI>
<LI>
<a href="'.$sumber.'/admks/surat/keluar.php" title="Daftar Surat Keluar">Surat Keluar</a>
</LI>
</UL>';
//surat /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '</td>
<td width="10%" align="right">
<A href="'.$sumber.'/admks/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>