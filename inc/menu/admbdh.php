<?php
//nilai
$maine = "$sumber/admbdh/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';
//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<a href="'.$maine.'" title="Home" class="menuku"><strong>HOME</strong>&nbsp;&nbsp;</a> | ';
//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu1" class="menuku"><strong>SETTING</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu1" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admbdh/s/pass.php" title="Ganti Password">Ganti Password</a>
</LI>
</UL>';
//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//bayar /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu2" class="menuku"><strong>PEMBAYARAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu2" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admbdh/bayar/m_uang_lain.php" title="Data Keuangan Lain">Data Keuangan Lain</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/bayar/set.php" title="Set Keuangan">Set Keuangan</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/bayar/siswa_komite.php" title="Uang Komite">Uang Komite</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/bayar/siswa_spi.php" title="Uang SPI">Uang SPI</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/bayar/siswa_les.php" title="Uang Les">Uang Les</a>
</LI>';


//keuangan lain
$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
			"ORDER BY nama ASC");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);

//jika ada
if ($tdt != 0)
	{
        do
		{
		$dt_kd = nosql($rdt['kd']);
		$dt_nama = balikin($rdt['nama']);

		echo '<LI>
		<a href="'.$sumber.'/admbdh/bayar/siswa_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
		</LI>';
		}
	while ($rdt = mysql_fetch_assoc($qdt));
	}


echo '<LI>
<a href="#" title="Laporan Harian">Laporan Harian</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_harian_komite.php" title="Uang Komite">Uang Komite</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_harian_spi.php" title="Uang SPI">Uang SPI</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_harian_les.php" title="Uang Les">Uang Les</a>
	</LI>';

	//keuangan lain
	$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//jika ada
	if ($tdt != 0)
		{
		do
			{
			$dt_kd = nosql($rdt['kd']);
			$dt_nama = balikin($rdt['nama']);

			echo '<LI>
			<a href="'.$sumber.'/admbdh/bayar/siswa_harian_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
			</LI>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}

	echo '</UL>
</LI>

<LI>
<a href="#" title="Laporan Bulanan">Laporan Bulanan</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_bulanan_komite.php" title="Uang Komite">Uang Komite</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_bulanan_spi.php" title="Uang SPI">Uang SPI</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_bulanan_les.php" title="Uang Les">Uang Les</a>
	</LI>';

	//keuangan lain
	$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//jika ada
	if ($tdt != 0)
		{
		do
			{
			$dt_kd = nosql($rdt['kd']);
			$dt_nama = balikin($rdt['nama']);

			echo '<LI>
			<a href="'.$sumber.'/admbdh/bayar/siswa_bulanan_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
			</LI>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}


	echo '</UL>
</LI>


<LI>
<a href="#" title="Laporan Tahunan">Laporan Tahunan</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_tahunan_komite.php" title="Uang Komite">Uang Komite</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_tahunan_spi.php" title="Uang SPI">Uang SPI</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_tahunan_les.php" title="Uang Les">Uang Les</a>
	</LI>';

	//keuangan lain
	$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//jika ada
	if ($tdt != 0)
		{
		do
			{
			$dt_kd = nosql($rdt['kd']);
			$dt_nama = balikin($rdt['nama']);

			echo '<LI>
			<a href="'.$sumber.'/admbdh/bayar/siswa_tahunan_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
			</LI>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}


	echo '</UL>
</LI>



<LI>
<a href="#" title="Laporan per Tanggal">Laporan per Tanggal</a>
	<UL>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_tgl_komite.php" title="Uang Komite">Uang Komite</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_tgl_spi.php" title="Uang SPI">Uang SPI</a>
	</LI>
	<LI>
	<a href="'.$sumber.'/admbdh/bayar/siswa_tgl_les.php" title="Uang Les">Uang Les</a>
	</LI>';

	//keuangan lain
	$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
				"ORDER BY nama ASC");
	$rdt = mysql_fetch_assoc($qdt);
	$tdt = mysql_num_rows($qdt);

	//jika ada
	if ($tdt != 0)
		{
		do
			{
			$dt_kd = nosql($rdt['kd']);
			$dt_nama = balikin($rdt['nama']);

			echo '<LI>
			<a href="'.$sumber.'/admbdh/bayar/siswa_tgl_lain.php?jnskd='.$dt_kd.'" title="'.$dt_nama.'">'.$dt_nama.'</a>
			</LI>';
			}
		while ($rdt = mysql_fetch_assoc($qdt));
		}


	echo '</UL>
</LI>

<LI>
<a href="'.$sumber.'/admbdh/bayar/daftar_setoran_komite.php" title="Daftar Setoran Uang Komite Bulanan">Daftar Setoran Uang KOMITE Bulanan</a>
</LI>
</UL>';
//pembayaran ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//tabungan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu3" class="menuku"><strong>TABUNGAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu3" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admbdh/nabung/set.php" title="Set Debet/Kredit/Saldo">Set Debet/Kredit/Saldo</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/nabung/siswa.php" title="Debet/Kredit Siswa">Debet/Kredit Siswa</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/nabung/lap_harian.php" title="Laporan Tabungan Harian">Laporan Tabungan Harian</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/nabung/lap_bulanan.php" title="Laporan Tabungan Bulanan">Laporan Tabungan Bulanan</a>
</LI>
</UL>';
//tabungan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="#" data-flexmenu="flexmenu29" class="menuku"><strong>PERPUSTAKAAN</strong>&nbsp;&nbsp;</A> |
<UL id="flexmenu29" class="flexdropdownmenu">
<LI>
<a href="'.$sumber.'/admbdh/p/pinjam_sedang.php" title="Sedang Pinjam">Sedang Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/p/pinjam_pernah.php" title="Pernah Pinjam">Pernah Pinjam</a>
</LI>
<LI>
<a href="'.$sumber.'/admbdh/p/baru.php" title="Koleksi Item Terbaru">Koleksi Item Terbaru</a>
</LI>
</UL>';
//perpustakaan //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//logout ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<A href="'.$sumber.'/admbdh/logout.php" title="Logout / KELUAR" class="menuku"><strong>LogOut</strong></A>
</td>
</tr>
</table>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>