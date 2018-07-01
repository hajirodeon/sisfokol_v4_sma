<?php
//nilai
$maine = "$sumber/admwaka/index.php";


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
<a href="'.$sumber.'/admwaka/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//akademik //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu3"><strong>AKADEMIK</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu3" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admwaka/akad/program.php" title="Program">Program</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/akad/ekstra.php" title="Ekstra">Ekstra</a>
</LI>

<LI>
<a href="#" title="Mata Pelajaran">Mata Pelajaran</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/mapel.php" title="Data Mata Pelajaran">Data Mata Pelajaran</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/mapel_kelas.php" title="Mata Pelajaran per Kelas">Mata Pelajaran per Kelas</a>
	</LI>
	</UL>
</LI>

<LI>
<a href="#" title="Guru">Guru</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/guru.php" title="Data Guru">Data Guru</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/guru_mapel_r.php" title="Guru Mata Pelajaran per Ruang">Guru Mata Pelajaran per Ruang</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/guru_mapel_tmp.php" title="Penempatan Guru Mengajar">Penempatan Guru Mengajar</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admwaka/akad/wk.php" title="Wali Kelas">Wali Kelas</a>
	</LI>
	</UL>
</LI>
</UL>';
//akademik //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu29" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu29" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admwaka/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admwaka/p/baru.php" title="Koleksi Item Terbaru">Koleksi Item Terbaru</a>
</LI>
</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '</td>
<td width="10%" align="right">
<A href="'.$sumber.'/admwaka/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>