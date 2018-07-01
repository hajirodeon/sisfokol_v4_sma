<?php
session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_gr.php");
$tpl = LoadTpl("../../../template/janissari.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$gmkd = nosql($_REQUEST['gmkd']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);
$filenya = "kalender.php?gmkd=$gmkd";


//focus...
//jika edit
if ($s == "edit")
	{
	if (empty($ubln))
		{
		$diload = "document.formx.ubln.focus();";
		}
	else if (empty($uthn))
		{
		$diload = "document.formx.uthn.focus();";
		}
	else
		{
		$diload = "document.formx.uket.focus();";
		}
	}
else
	{
	if (empty($ubln))
		{
		$diload = "document.formx.ubln.focus();";
		}
	else if (empty($uthn))
		{
		$diload = "document.formx.uthn.focus();";
		}
	}



//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($s == "hapus")
	{
	//cek digit
	//tgl
	if (strlen($utgl) == 1)
		{
		$utglx = "0$utgl";
		}
	else
		{
		$utglx = $utgl;
		}


	//bln
	if (strlen($ubln) == 1)
		{
		$ublnx = "0$ubln";
		}
	else
		{
		$ublnx = $ubln;
		}


	//hapus
	mysql_query("DELETE FROM guru_mapel_kalender ".
					"WHERE kd_guru_mapel = '$gmkd' ".
					"AND DATE_FORMAT(tgl, '%d') = '$utglx' ".
					"AND DATE_FORMAT(tgl, '%m') = '$ublnx' ".
					"AND DATE_FORMAT(tgl, '%Y') = '$uthn'");

	//re-direct
	$ke = "$filenya&ubln=$ubln&uthn=$uthn";
	xloc($ke);
	exit();
	}





//jika batal
if ($_POST['btnBTL'])
	{
	//nilai
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$gmkd = nosql($_POST['gmkd']);

	//re-direct
	$ke = "$filenya&ubln=$ubln&uthn=$uthn";
	xloc($ke);
	exit();
	}





//jika edit simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$utgl = nosql($_POST['utgl']);
	$ubln = nosql($_POST['ubln']);
	$uthn = nosql($_POST['uthn']);
	$tgl_u = "$uthn:$ubln:$utgl";
	$gmkd = nosql($_POST['gmkd']);
	$uket = cegah($_POST['uket']);

	//cek digit
	//tgl
	if (strlen($utgl) == 1)
		{
		$utglx = "0$utgl";
		}
	else
		{
		$utglx = $utgl;
		}


	//bln
	if (strlen($ubln) == 1)
		{
		$ublnx = "0$ubln";
		}
	else
		{
		$ublnx = $ubln;
		}




	//jika null
	if (empty($uket))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya&s=edit&ubln=$ubln&uthn=$uthn";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM guru_mapel_kalender ".
								"WHERE kd_guru_mapel = '$gmkd' ".
								"AND DATE_FORMAT(tgl, '%d') = '$utglx' ".
								"AND DATE_FORMAT(tgl, '%m') = '$ublnx' ".
								"AND DATE_FORMAT(tgl, '%Y') = '$uthn'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//jika update
		if ($tcc != 0)
			{
			//query
			mysql_query("UPDATE guru_mapel_kalender ".
							"SET ket = '$uket' ".
							"WHERE kd_guru_mapel = '$gmkd' ".
							"AND DATE_FORMAT(tgl, '%d') = '$utglx' ".
							"AND DATE_FORMAT(tgl, '%m') = '$ublnx' ".
							"AND DATE_FORMAT(tgl, '%Y') = '$uthn'");
			}
		//jika baru
		else
			{
			//entry
			mysql_query("INSERT INTO guru_mapel_kalender(kd, kd_guru_mapel, tgl, ket) VALUES ".
							"('$x', '$gmkd', '$tgl_u', '$uket')");
			}


		//re-direct
		$ke = "$filenya&ubln=$ubln&uthn=$uthn";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/swap.js");
require("../../../inc/js/checkall.js");
require("../../../inc/menu/janissari.php");


//view : guru ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika belum pilih mapel
if (empty($gmkd))
	{
	//re-direct
	$ke = "mapel.php";
	xloc($ke);
	exit();
	}

//nek mapel telah dipilih
else
	{
	//mapel-nya...
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.* ".
							"FROM guru_mapel, m_mapel ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = '$kd1_session' ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);


	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "kalender.php?gmkd=$gmkd";
		$judul = "E-Learning : $pel_nm --> Kalender";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    	<td>
		<p>
		<big><strong>:::Kalender...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>

		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr valign="top">
		<td>
		<strong>Bulan : </strong>';
		echo "<select name=\"ubln\" onChange=\"MM_jumpMenu('self',this,0)\">";
		echo '<option value="'.$ubln.'">'.$arrbln[$ubln].'</option>';
		for ($ibln=1;$ibln<=12;$ibln++)
			{
			echo '<option value="'.$filenya.'&ubln='.$ibln.'">'.$arrbln[$ibln].'</option>';
			}
		echo '</select>';

		//tahun
		echo "<select name=\"uthn\" onChange=\"MM_jumpMenu('self',this,0)\">";
		echo '<option value="'.$uthn.'">'.$uthn.'</option>';
		for ($ithn=$tpel01;$ithn<=$tpel02;$ithn++)
			{
			echo '<option value="'.$filenya.'&ubln='.$ubln.'&uthn='.$ithn.'">'.$ithn.'</option>';
			}
		echo '</select>
		</td>
		</tr>
		</table>
		<br>';

		//cek
		if (empty($ubln))
			{
			echo '<font color="blue"><strong>BULAN Belum Dipilih...!!</strong></font>';
			}

		else if (empty($uthn))
			{
			echo '<font color="blue"><strong>TAHUN Belum Dipilih...!!</strong></font>';
			}
		else
			{
			//jika edit
			if ($s == "edit")
				{
				//cek digit
				//tgl
				if (strlen($utgl) == 1)
					{
					$utglx = "0$utgl";
					}
				else
					{
					$utglx = $utgl;
					}

				//bln
				if (strlen($ubln) == 1)
					{
					$ublnx = "0$ubln";
					}
				else
					{
					$ublnx = $ubln;
					}


				//nilainya...
				$qdtf = mysql_query("SELECT * FROM guru_mapel_kalender ".
										"WHERE kd_guru_mapel = '$gmkd' ".
										"AND DATE_FORMAT(tgl, '%d') = '$utglx' ".
										"AND DATE_FORMAT(tgl, '%m') = '$ublnx' ".
										"AND DATE_FORMAT(tgl, '%Y') = '$uthn'");
				$rdtf = mysql_fetch_assoc($qdtf);
				$tdtf = mysql_num_rows($qdtf);
				$dtf_ket = balikin($rdtf['ket']);

				echo 'Agenda Tanggal : <strong>'.$utgl.'</strong>
				<br>
				<textarea name="uket" cols="50" rows="5" wrap="virtual">'.$dtf_ket.'</textarea>
				<br>
				<input name="utgl" type="hidden" value="'.$utgl.'">
				<input name="ubln" type="hidden" value="'.$ubln.'">
				<input name="uthn" type="hidden" value="'.$uthn.'">
				<input name="s" type="hidden" value="'.$s.'">
				<input name="gmkd" type="hidden" value="'.$gmkd.'">
				<input name="btnSMP" type="submit" value="SIMPAN">
				<input name="btnBTL" type="submit" value="BATAL">';
				}


			//lihat
			else
				{
				echo '<table width="550" border="1" cellspacing="0" cellpadding="3">
				<tr bgcolor="'.$e_warnaheader.'">
			    	<td width="30"><strong>Tgl.</strong></td>
				<td width="75"><strong>Hari</strong></td>
				<td><strong>Ket.</strong></td>
				</tr>';

				//mendapatkan jumlah tanggal maksimum dalam suatu bulan
				$tgl = 0;
				$bulan = $ubln;
				$bln = $bulan + 1;
				$thn = $uthn;

				$lastday = mktime (0,0,0,$bln,$tgl,$thn);

				//total tanggal dalam sebulan
				$tkhir = strftime ("%d", $lastday);

				//lopping tgl
				for ($i=1;$i<=$tkhir;$i++)
					{
					//ketahui harinya
					$day = $i;
					$month = $bulan;
					$year = $thn;


					//mencari hari
					$a = substr($year, 2);
						//mengambil dua digit terakhir tahun

					$b = (int)($a/4);
						//membagi tahun dengan 4 tanpa memperhitungkan sisa

					$c = $month;
						//mengambil angka bulan

					$d = $day;
						//mengambil tanggal

					$tot1 = $a + $b + $c + $d;
						//jumlah sementara, sebelum dikurangani dengan angka kunci bulan

					//kunci bulanan
					if ($c == 1)
						{
						$kunci = "2";
						}

					else if ($c == 2)
						{
						$kunci = "7";
						}

					else if ($c == 3)
						{
						$kunci = "1";
						}

					else if ($c == 4)
						{
						$kunci = "6";
						}

					else if ($c == 5)
						{
						$kunci = "5";
						}

					else if ($c == 6)
						{
						$kunci = "3";
						}

					else if ($c == 7)
						{
						$kunci = "2";
						}

					else if ($c == 8)
						{
						$kunci = "7";
						}

					else if ($c == 9)
						{
						$kunci = "5";
						}

					else if ($c == 10)
						{
						$kunci = "4";
						}

					else if ($c == 11)
						{
						$kunci = "2";
						}

					else if ($c == 12)
						{
						$kunci = "1";
						}

					$total = $tot1 - $kunci;

					//angka hari
					$hari = $total%7;

					//jika angka hari == 0, sebenarnya adalah 7.
					if ($hari == 0)
						{
						$hari = ($hari +7);
						}

					//kabisat, tahun habis dibagi empat alias tanpa sisa
					$kabisat = (int)$year % 4;

					if ($kabisat ==0)
						{
						$hri = $hri-1;
						}



					//hari ke-n
					if ($hari == 3)
						{
						$hri = 4;
						$dino = "Rabu";
						}

					else if ($hari == 4)
						{
						$hri = 5;
						$dino = "Kamis";
						}

					else if ($hari == 5)
						{
						$hri = 6;
						$dino = "Jum'at";
						}

					else if ($hari == 6)
						{
						$hri = 7;
						$dino = "Sabtu";
						}

					else if ($hari == 7)
						{
						$hri = 1;
						$dino = "Minggu";
						}

					else if ($hari == 1)
						{
						$hri = 2;
						$dino = "Senin";
						}

					else if ($hari == 2)
						{
						$hri = 3;
						$dino = "Selasa";
						}


					//nek minggu,
					if ($hri == 1)
						{
						$warna = $e_warnaover;
						$mggu_attr = "disabled";
						}
					else
						{
						if ($warna_set ==0)
							{
							$warna = $e_warna01;
							$warna_set = 1;
							$mggu_attr = "";
							}
						else
							{
							$warna = $e_warna02;
							$warna_set = 0;
							$mggu_attr = "";
							}
						}


					//cek digit
					//tgl
					if (strlen($i) == 1)
						{
						$utglx = "0$i";
						}
					else
						{
						$utglx = $i;
						}


					//bln
					if (strlen($ubln) == 1)
						{
						$ublnx = "0$ubln";
						}
					else
						{
						$ublnx = $ubln;
						}


					//nilainya...
					$qdtf = mysql_query("SELECT * FROM guru_mapel_kalender ".
											"WHERE kd_guru_mapel = '$gmkd' ".
											"AND DATE_FORMAT(tgl, '%d') = '$utglx' ".
											"AND DATE_FORMAT(tgl, '%m') = '$ublnx' ".
											"AND DATE_FORMAT(tgl, '%Y') = '$uthn'");
					$rdtf = mysql_fetch_assoc($qdtf);
					$tdtf = mysql_num_rows($qdtf);
					$dtf_ket = balikin($rdtf['ket']);


					//jika ada
					if ($tdtf != 0)
						{
						$dtf_ketx = "$dtf_ket <br> [<a href=\"$filenya&s=edit&utgl=$i&ubln=$ubln&uthn=$uthn\" title=\"Edit\"><img src=\"$sumber/img/edit.gif\" width=\"16\" height=\"16\" border=\"0\"></a>]. [<a href=\"$filenya&s=hapus&utgl=$i&ubln=$ubln&uthn=$uthn\" title=\"Hapus\"><img src=\"$sumber/img/delete.gif\" width=\"16\" height=\"16\" border=\"0\"></a>]";
						}
					else
						{
						$dtf_ketx = "- [<a href=\"$filenya&s=edit&utgl=$i&ubln=$ubln&uthn=$uthn\" title=\"Tulis Agenda : $dino\"><img src=\"$sumber/img/edit.gif\" width=\"16\" height=\"16\" border=\"0\"></a>]";
						}


					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td valign="top" align="center"><strong>'.$i.'.</strong></td>
					<td valign="top"><strong>'.$dino.'</strong></td>
					<td valign="top">
					'.$dtf_ketx.'
					</td>
					</tr>';
					}

				echo '</table>
				<input name="gmkd" type="hidden" value="'.$gmkd.'">
				<input name="ubln" type="hidden" value="'.$ubln.'">
				<input name="uthn" type="hidden" value="'.$uthn.'">
				<input name="tkhir" type="hidden" value="'.$tkhir.'">';
				}
			}
		}

	//jika tidak
	else
		{
		//re-direct
		$pesan = "Silahkan Lihat Daftar Mata Pelajaran.";
		$ke = "mapel.php";
		pekem($pesan,$ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>