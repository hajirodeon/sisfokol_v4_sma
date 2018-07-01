<?php
//nilai
$maine = "$sumber/admtu/index.php";


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
<a href="'.$sumber.'/admtu/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>MASTER</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/m/tapel.php" title="Tahun Pelajaran">Tahun Pelajaran</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/ruang.php" title="Ruang">Ruang</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/pangkat.php" title="Pangkat">Pangkat</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/jabatan.php" title="Jabatan">Jabatan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/golongan.php" title="Golongan">Golongan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/agama.php" title="Agama">Agama</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/pekerjaan.php" title="Pekerjaan">Pekerjaan</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/ijazah.php" title="Ijazah">Ijazah</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/status.php" title="Status">Status</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/akta.php" title="Akta">Akta</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/m/pegawai.php" title="Pegawai">Pegawai</a>
</LI>
</UL>';
//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//akademik //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu3"><strong>AKADEMIK</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu3" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/akad/program.php" title="Program">Program</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/akad/ekstra.php" title="Ekstra">Ekstra</a>
</LI>

<LI>
<a href="#" title="Mata Pelajaran">Mata Pelajaran</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admtu/akad/mapel.php" title="Data Mata Pelajaran">Data Mata Pelajaran</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/mapel_kelas.php" title="Mata Pelajaran per Kelas">Mata Pelajaran per Kelas</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Guru">Guru</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admtu/akad/guru.php" title="Data Guru">Data Guru</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/guru_mapel_r.php" title="Guru Mata Pelajaran per Ruang">Guru Mata Pelajaran per Ruang</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/guru_mapel_tmp.php" title="Penempatan Guru Mengajar">Penempatan Guru Mengajar</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/wk.php" title="Wali Kelas">Wali Kelas</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="'.$sumber.'/admtu/akad/siswa.php" title="Siswa">Siswa</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa.php" title="Data Siswa">Data Siswa</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_tmp_k.php" title="Penempatan Siswa per Kelas">Penempatan Siswa per Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_tmp_p.php" title="Penempatan Siswa per Program">Penempatan Siswa per Program</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_tmp_r.php" title="Penempatan Siswa per Ruang">Penempatan Siswa per Ruang</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_kenaikan.php" title="Kenaikan Kelas">Kenaikan Kelas</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admtu/akad/siswa_history.php" title="History Kelas">History Kelas</a>
	</LI>
	</UL>
</LI>
</UL>';
//akademik //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu4"><strong>JADWAL</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu4" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/jwal/pel.php" title="Jadwal Pelajaran">Jadwal Pelajaran</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/jwal/guru.php" title="Jadwal Guru Mengajar">Jadwal Guru Mengajar</a>
</LI>
</UL>';
//jadwal ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//absensi ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu6"><strong>ABSENSI</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu6" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/abs/harian.php" title="Absensi Harian Siswa">Absensi Harian Siswa</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/abs/rekap_kelas.php" title="Rekap Absensi per Kelas Ruang">Rekap Absensi Per Kelas Ruang</a>
</LI>
</UL>';
//absensi ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu29" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu29" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admtu/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admtu/p/baru.php" title="Koleksi Item Terbaru">Koleksi Item Terbaru</a>
</LI>
</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '</td>
<td width="10%" align="right">
<A href="'.$sumber.'/admtu/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>