<?php
//nilai
$maine = "$sumber/adm/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>Home</strong></A>&nbsp;&nbsp; | ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu1"><strong>SETTING</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu1" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/adm/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/s/sekolah.php" title="Set Sekolah">Set Sekolah</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/s/reset_pass.php" title="Reset Password">Reset Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu2"><strong>MASTER</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/adm/m/tapel.php" title="Tahun Pelajaran">Tahun Pelajaran</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/ruang.php" title="Ruang">Ruang</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/pangkat.php" title="Pangkat">Pangkat</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/jabatan.php" title="Jabatan">Jabatan</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/golongan.php" title="Golongan">Golongan</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/agama.php" title="Agama">Agama</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/pekerjaan.php" title="Pekerjaan">Pekerjaan</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/ijazah.php" title="Ijazah">Ijazah</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/status.php" title="Status">Status</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/akta.php" title="Akta">Akta</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/m/pegawai.php" title="Pegawai">Pegawai</a>
</LI>
</UL>';
//master ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//backup restore ///////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" class="menuku" data-flexmenu="flexmenu21"><strong>BACKUP dan RESTORE</strong></A>&nbsp;&nbsp; |
<UL id="flexmenu21" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/adm/br/backup.php" title="Backup Database">Backup Database</a>
</LI>
<LI>
<a href="'.$sumber.'/adm/br/restore.php" title="Restore Backup">Restore Database</a>
</LI>
</UL>';
//backup restore ///////////////////////////////////////////////////////////////////////////////////////////////





//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '</td>
<td width="10%" align="right">
<A href="'.$sumber.'/adm/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>