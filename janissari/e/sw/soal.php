<?php
session_start();

//ambil nilai
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/janissari.php");
require("../../../inc/cek/e_sw.php");
require("../../../inc/class/paging.php");
$tpl = LoadTpl("../../../template/ujian.html");

nocache;

//nilai
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$x_sesi = nosql($_SESSION['x_sesi']);
$gmkd = nosql($_REQUEST['gmkd']);
$katkd = nosql($_REQUEST['katkd']);
$ke_sli = "soal_finish.php?s=selesai&gmkd=$gmkd&katkd=$katkd"; //target re-direct selesai
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$filenya = "soal.php?gmkd=$gmkd&page=$page";


//focus...
if (empty($a))
	{
	$diload = "document.formx.judulx.focus();";
	}

else if ($a == "baru")
	{
	$diload = "document.formx.dt_no.focus();";
	}

else
	{
	$diload = "Up();";
	}




//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek baru
if ($s == "baru")
	{
	//null-kan session
	$_SESSION['x_sesi'] = 0;

	//kosongkan pengerjaan yang telah ada
	mysql_query("DELETE FROM siswa_mapel_soal ".
					"WHERE kd_user = '$kd1_session' ".
					"AND kd_guru_mapel = '$gmkd' ".
					"AND kd_guru_mapel_soal = '$katkd'");

	mysql_query("DELETE FROM siswa_mapel_soal_detail ".
					"WHERE kd_user = '$kd1_session' ".
					"AND kd_guru_mapel = '$gmkd' ".
					"AND kd_guru_mapel_soal = '$katkd'");

	//insert baru
	mysql_query("INSERT INTO siswa_mapel_soal(kd, kd_user, kd_guru_mapel, kd_guru_mapel_soal, waktu_mulai) VALUES ".
					"('$x', '$kd1_session', '$gmkd', '$katkd', '$today')");

	//re-direct
	$ke = "$filenya&katkd=$katkd&a=detail";
	xloc($ke);
	exit();
	}





//jika ke daftar judul/topik/bab
if ($_POST['btnDF'])
	{
	//nilai
	$gmkd = nosql($_POST['gmkd']);
	$a = nosql($_POST['a']);

	//re-direct
	$ke = "soal.php?gmkd=$gmkd&a=$a";
	xloc($ke);
	exit();
	}





//jika selesai
if ($_POST['btnSLS'])
	{
	//ambil nilai
	$gmkd = nosql($_POST['gmkd']);
	$katkd = nosql($_POST['katkd']);


	//update
	mysql_query("UPDATE siswa_mapel_soal ".
			"SET waktu_akhir = '$today' ".
			"WHERE kd_user = '$kd1_session' ".
			"AND kd_guru_mapel = '$gmkd' ".
			"AND kd_guru_mapel_soal = '$katkd'");

	//re-direct
	$ke = "soal_finish.php?s=selesai&gmkd=$gmkd&katkd=$katkd";
	xloc($ke);
	exit();
	}





//jika selesai
if ($s == "selesai")
	{
	//ambil nilai
	$gmkd = nosql($_REQUEST['gmkd']);
	$katkd = nosql($_REQUEST['katkd']);


	//update
	mysql_query("UPDATE siswa_mapel_soal ".
			"SET waktu_akhir = '$today' ".
			"WHERE kd_user = '$kd1_session' ".
			"AND kd_guru_mapel = '$gmkd' ".
			"AND kd_guru_mapel_soal = '$katkd'");

	//re-direct
	$ke = "soal_finish.php?s=selesai&gmkd=$gmkd&katkd=$katkd";
	xloc($ke);
	exit();
	}




//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$gmkd = nosql($_POST['gmkd']);
	$katkd = nosql($_POST['katkd']);
	$page = nosql($_POST['page']);
	$soalkd = nosql($_POST['soalkd']);
	$jwb = nosql($_POST['jwb']);
	$disp1 = nosql($_POST['disp1']);

	//ambil jml.detik berjalan
	$nil1_disp1 = substr($disp1,0,2); //menit

	if (strlen($nil1_disp1) == 1)
		{
		$nil1_disp1 = "0$nil1_disp1";
		}

	$nil1x_disp1 = (int)($nil1_disp1 * 60); //jadikan detik
	$nil2_disp1 = substr($disp1,-2); //detik
	$nilx_disp1 = (int)($nil1x_disp1 + $nil2_disp1);

	//penanda session timer
	if (empty($_SESSION['x_sesi']))
		{
		session_register("x_sesi");
		$_SESSION['x_sesi'] = $nilx_disp1;
		}
	else
		{
		$_SESSION['x_sesi'] = $nilx_disp1;
		}



	//jika null
	if (empty($jwb))
		{
		//re-direct
		$pesan = "Silahkan Jawab Terlebih Dahulu...!!.";
		$ke = "$filenya&a=detail&katkd=$katkd";
		pekem($pesan,$ke);
		exit();

		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
					"WHERE kd_user = '$kd1_session' ".
					"AND kd_guru_mapel = '$gmkd' ".
					"AND kd_guru_mapel_soal = '$katkd' ".
					"AND kd_guru_mapel_soal_detail = '$soalkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE siswa_mapel_soal_detail SET jawab = '$jwb', ".
					"postdate = '$today' ".
					"WHERE kd_user = '$kd1_session' ".
					"AND kd_guru_mapel = '$gmkd' ".
					"AND kd_guru_mapel_soal = '$katkd' ".
					"AND kd_guru_mapel_soal_detail = '$soalkd'");
			}
		else
			{
			//deteksi nomor urut terakhir
			$qdtu = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
						"WHERE kd_user = '$kd1_session' ".
						"AND kd_guru_mapel = '$gmkd' ".
						"AND kd_guru_mapel_soal = '$katkd' ".
						"ORDER BY round(no) DESC");
			$rdtu = mysql_fetch_assoc($qdtu);
			$dtu_no = nosql($rdtu['no']);

			//beri nomor
			$dtu_nox = $dtu_no + 1;

			//insert
			mysql_query("INSERT INTO siswa_mapel_soal_detail(kd, kd_user, kd_guru_mapel, kd_guru_mapel_soal, ".
					"kd_guru_mapel_soal_detail, no, jawab, postdate) VALUES".
					"('$x', '$kd1_session', '$gmkd', '$katkd', ".
					"'$soalkd', '$dtu_nox', '$jwb', '$today')");
			}


		//re-direct
		$ke = "$filenya&a=detail&katkd=$katkd";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//judul/topik/bab terpilih //////////////////////////////////////////////////////////////////////////////////////////////////////////////
$qmpx = mysql_query("SELECT * FROM guru_mapel_soal ".
						"WHERE kd_guru_mapel = '$gmkd' ".
						"AND kd = '$katkd'");
$rowmpx = mysql_fetch_assoc($qmpx);
$mpx_kd = nosql($rowmpx['kd']);
$mpx_judul = balikin($rowmpx['judul']);
$mpx_menit = nosql($rowmpx['waktu']);
$mpx_detik = $mpx_menit * 60; //detik


//ujian. utk. tag META Refresh & settimeout //////////////////////////////////////////////////////////////
if (empty($s)) //jika bukan baru, apalagi edit. ini real time...
	{
	$wkdet = (($mpx_menit * 60) - $x_sesi); //detik
	$ke_sli = "soal_finish.php?s=selesai&gmkd=$gmkd&katkd=$katkd";
	$wkurl = $ke_sli;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////





//utk. counter real time (js) ////////////////////////////////////////////////////////////////////////////
$nil_mnt = (int)($wkdet / 60); //batas waktu menit
$nil_dtk = $wkdet % 60; //batas waktu detik

//ke-n
$nil_mnt_seli = $mpx_menit - $nil_mnt; //menit ke-n
$nil_dtk_seli = 60 - $nil_dtk; //detik ke-n

//nek 1
if ($nil_mnt_seli >= 1)
	{
	$nil_mnt_seli = $nil_mnt_seli - 1;
	}


//nek 60 ////////////////////////////////////////////////////
if ($nil_dtk_seli == 60)
	{
	if ($x_sesi < 60)
		{
		$nil_mnt_seli = 0;
		}

	else if ($x_sesi == 60)
		{
		$nil_mnt_seli = 1;
		}

	else if ($x_sesi >= 120)
		{
		$nil_mnt_seli = $nil_mnt_seli + 1;
		}


	//nol-kan detik
	$nil_dtk_seli = 0;
	}
//nek 60 ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////



//deteksi jika telah dikerjakan
$qdte = mysql_query("SELECT * FROM siswa_mapel_soal ".
						"WHERE kd_user = '$kd1_session' ".
						"AND kd_guru_mapel = '$gmkd' ".
						"AND kd_guru_mapel_soal = '$katkd'");
$rdte = mysql_fetch_assoc($qdte);
$dte_akhir = $rdte['waktu_akhir'];

if ((!empty($_SESSION['x_sesi'])) AND ($dte_akhir != "0000-00-00 00:00:00"))
	{
	//re-direct
	$pesan = "Anda Sudah Melakukan Ujian. Jika Ingin Melakukan Lagi, Silahkan Kerjakan Lagi. Terima Kasih.";
	$ke = "$filenya&s=baru&katkd=$katkd";
	pekem($pesan,$ke);
	exit();
	}




//isi *START
ob_start();

require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/openwindow.js");
require("../../../inc/js/swap.js");
require("inc_counter.php");
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
	$qpel = mysql_query("SELECT guru_mapel.*, m_mapel.*, m_user.* ".
							"FROM guru_mapel, m_mapel, m_user ".
							"WHERE guru_mapel.kd_mapel = m_mapel.kd ".
							"AND guru_mapel.kd_user = m_user.kd ".
							"AND guru_mapel.kd = '$gmkd'");
	$rpel = mysql_fetch_assoc($qpel);
	$tpel = mysql_num_rows($qpel);
	$pel_nm = balikin($rpel['mapel']);
	$pel_usnm = balikin($rpel['nama']);


	//jika iya
	if ($tpel != 0)
		{
		//nilai
		$filenya = "soal.php?gmkd=$gmkd";
		$judul = "$pel_nm [Guru : $pel_usnm] --> Soal";
		$judulku = "[$tipe_session : $no1_session.$nm1_session] ==> $judul";
		$juduli = $judul;

		echo '<form name="formx" method="post" action="'.$filenya.'">
		<table width="100%" height="300" border="0" cellspacing="0" cellpadding="3">
		<tr bgcolor="#E3EBFD" valign="top">
		<td>';
		//judul
		xheadline($judul);

		//menu elearning
		require("../../../inc/menu/e.php");

		echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">
  		<tr valign="top">
    		<td width="100">
		<p>
		<big><strong>:::Soal...</strong></big>
		</p>
		</td>
  		</tr>
		</table>
		<br>';


		//jika detail topik/judul, alias daftar soalnya... //////////////////////////////////////////////////////////////////////////////
		if ($a == "detail")
			{
			//nilai
			$katkd = nosql($_REQUEST['katkd']);
			$gmkd = nosql($_REQUEST['gmkd']);
			$solkd = nosql($_REQUEST['solkd']);
			$page = nosql($_REQUEST['page']);

			//query
			$qdt = mysql_query("SELECT * FROM guru_mapel_soal ".
						"WHERE kd = '$katkd'");
			$rdt = mysql_fetch_assoc($qdt);
			$tdt = mysql_num_rows($qdt);
			$dt_kd = nosql($rdt['kd']);
			$dt_judul = balikin($rdt['judul']);
			$dt_bobot = nosql($rdt['bobot']);
			$dt_waktu = nosql($rdt['waktu']);


			//query
			$qdku = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
						"WHERE kd_guru_mapel_soal = '$dt_kd' ".
						"ORDER BY RAND() ASC");
			$rdku = mysql_fetch_assoc($qdku);
			$tdku = mysql_num_rows($qdku);


			//waktu mulai
			$qmul = mysql_query("SELECT * FROM siswa_mapel_soal ".
						"WHERE kd_user = '$kd1_session' ".
						"AND kd_guru_mapel = '$gmkd' ".
						"AND kd_guru_mapel_soal = '$katkd'");
			$rmul = mysql_fetch_assoc($qmul);
			$mul_mulai = $rmul['waktu_mulai'];


			//jml. soal
			$qju = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
						"WHERE kd_guru_mapel_soal = '$katkd'");
			$rju = mysql_fetch_assoc($qju);
			$tju = mysql_num_rows($qju);
			$jml_soal = $tju;


			//nilai
			$d_kd = nosql($rdku['kd']);
			$d_no = nosql($rdku['no']);
			$d_soal = balikin2($rdku['soal']);
			$d_postdate = $rdku['postdate'];


			//yang dijawab
			$qjbu = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
						"WHERE kd_user = '$kd1_session' ".
						"AND kd_guru_mapel = '$gmkd' ".
						"AND kd_guru_mapel_soal = '$katkd' ".
						"AND kd_guru_mapel_soal_detail = '$d_kd'");
			$rjbu = mysql_fetch_assoc($qjbu);
			$tjbu = mysql_num_rows($qjbu);
			$d_jawab = nosql($rjbu['jawab']);


			//yang sudah dijawab
			$qjbu2 = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
						"WHERE kd_user = '$kd1_session' ".
						"AND kd_guru_mapel = '$gmkd' ".
						"AND kd_guru_mapel_soal = '$katkd' ".
						"AND jawab <> ''");
			$rjbu2 = mysql_fetch_assoc($qjbu2);
			$tjbu2 = mysql_num_rows($qjbu2);


			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr valign="top">
			<td>
			Judul/Topik/Bab :
			<strong>'.$dt_judul.'</strong>
			<br>

			Jumlah Soal :
			<strong>'.$jml_soal.'</strong>.
			<br>

			Bobot :
			<strong>'.$dt_bobot.'</strong>.
			<br>

			Waktu Maksimal Mengerjakan :
			<strong>'.$dt_waktu.'</strong> Menit.
			</td>
			</tr>
			</table>
			<input name="a" type="hidden" value="'.$a.'">
			<input name="gmkd" type="hidden" value="'.$gmkd.'">
			<input name="katkd" type="hidden" value="'.$katkd.'">
			<input name="page" type="hidden" value="'.$page.'">
			<br>
			<br>';

			//jika belum selesai mengerjakan
			if ($tjbu2 <> $jml_soal)
				{
				//jika ada
				if ($tdku != 0)
					{
					echo 'Tgl & Jam Mulai :
					<strong>'.$mul_mulai.'</strong>,
					Waktu Pengerjaan :
					<input name="disp1" size="7" type="text" class="input" readonly>.
					Jumlah Soal Yang Sudah Dikerjakan :
					<input name="jml_sudah" size="2" type="text" class="input" value="'.$tjbu2.'" readonly>
					<br>';

					//timeout
					echo '<script>setTimeout("location.href=\''.$ke_sli.'\'", '.$wkdet.'000);</script>
					<iframe name="ifr_sesi" frameborder="0" height="0" width="0" src="ifr_sesi.php"></iframe>';


					//deteksi, jika sudah mengerjakan dan menjawab, random dengan yang lain.
					if ($tjbu != 0)
						{
						//re-direct
						$ke = "$filenya&a=detail&katkd=$katkd";
						xloc($ke);
						exit();
						}

					//jika ada yang belum dikerjakan
					else if ($tjbu == 0)
						{
						echo '<table width="950" border="1" cellpadding="3" cellspacing="0">
						<tr bgcolor="'.$e_warnaheader.'">
						<td><strong>Soal</strong></td>
						</tr>';
						echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
						echo '<td valign="top">
						<input name="soalkd" type="hidden" value="'.$d_kd.'">
						'.$d_soal.'
						<br>
						<br>

						[<strong>Jawaban</strong> :
						<select name="jwb">
						<option value="'.$d_jawab.'" selected>'.$d_jawab.'</option>
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
						<option value="E">E</option>
						</select>].
						</td>
						</tr>
						</table>
						<table width="950" border="0" cellpadding="3" cellspacing="0">
						<tr>
						<td width="270">
						<input name="jml" type="hidden" value="'.$count.'">
						<input name="btnSMP" type="submit" value="SIMPAN">
						<input name="btnSLS" type="submit" value="SELESAI >>">
						</td>
						<td align="right">
						<font color="blue"><strong>'.$tdku.'</strong></font> Data Soal
						'.$pagelist.'</td>
						</tr>
						</table>';
						}
					}

				//tidak ada
				else
					{
					echo '<big>
					<font color="blue"><strong>Belum Ada Soal.</strong></font>
					</big>';
					}
				}
			else
				{
				//re-direct ke selesai
				$ke = "$filenya&a=detail&katkd=$katkd&s=selesai";
				xloc($ke);
				exit();
				}
			}


		//jika daftar topik/judul ///////////////////////////////////////////////////////////////////////////////////////////////////////
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT guru_mapel.*, guru_mapel_soal.*, guru_mapel_soal.kd AS katkd ".
							"FROM guru_mapel, guru_mapel_soal ".
							"WHERE guru_mapel_soal.kd_guru_mapel = guru_mapel.kd ".
							"AND guru_mapel.kd = '$gmkd' ".
							"AND guru_mapel_soal.status = 'true' ".
							"ORDER BY guru_mapel_soal.judul ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = $filenya;
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//nek ada
			if ($count != 0)
				{
				echo '<table width="700" border="1" cellpadding="3" cellspacing="0">
				<tr bgcolor="'.$e_warnaheader.'">
				<td><strong>Judul/Topik/Bab</strong></td>
				<td width="50"><strong>Bobot</strong></td>
				<td width="100"><strong>Waktu</strong></td>
				<td width="200"><strong>Soal</strong></td>
				<td width="10"><strong>Rekap Jawaban</strong></td>
				</tr>';

				do
			  		{
					if ($warna_set ==0)
						{
						$warna = $e_warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $e_warna02;
						$warna_set = 0;
						}

					$nomer = $nomer + 1;

					$kd = nosql($data['katkd']);
					$judulx = balikin($data['judul']);
					$bobot = nosql($data['bobot']);
					$waktu = nosql($data['waktu']);


					//jml. soal
					$qju = mysql_query("SELECT * FROM guru_mapel_soal_detail ".
											"WHERE kd_guru_mapel_soal = '$kd'");
					$rju = mysql_fetch_assoc($qju);
					$tju = mysql_num_rows($qju);
					$jml_soal = $tju;

					//cek, telah dikerjakan atau belum...
					$qkjk = mysql_query("SELECT * FROM siswa_mapel_soal_detail ".
											"WHERE kd_user = '$kd1_session' ".
											"AND kd_guru_mapel = '$gmkd' ".
											"AND kd_guru_mapel_soal = '$kd'");
					$rkjk = mysql_fetch_assoc($qkjk);
					$tkjk = mysql_num_rows($qkjk);

					//status
					if ($tkjk != 0)
						{
//						$kjk_status = "[<strong>Telah Dikerjakan</strong>].<br> [<a href=\"$filenya&s=baru&a=detail&katkd=$kd\" title=\"Kerjakan Lagi...\">Kerjakan lagi</a>].";
						$kjk_status = "[<strong>Telah Dikerjakan</strong>].";
						}
					else
						{
						$kjk_status = "[<a href=\"$filenya&s=baru&a=detail&katkd=$kd\" title=\"KERJAKAN...\">KERJAKAN</a>].";
						}

					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$e_warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td valign="top">
					'.$judulx.'
					</td>
					<td valign="top">
					<strong>'.$bobot.'</strong>.
					</td>
					<td valign="top">
					<strong>'.$waktu.'</strong> Menit.
					</td>
					<td valign="top">
					[<strong>'.$jml_soal.'</strong> Soal].
					<br>
					'.$kjk_status.'</a>
					</td>
					<td valign="top">
					[<a href="soal_finish_pdf.php?swkd='.$kd1_session.'&gmkd='.$gmkd.'&katkd='.$kd.'" target="_blank"><img src="'.$sumber.'/img/pdf.gif" width="16" height="16" border="0"></a>].
					</td>
					</tr>';
			  		}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="700" border="0" cellspacing="0" cellpadding="3">
			    	<tr>
				<td align="right">
				<font color="blue"><strong>'.$count.'</strong></font> Data '.$pagelist.'
				</td>
			    	</tr>
				</table>';
				}
			else
				{
				echo '<font color="blue"><strong>TIDAK ADA DATA SOAL YANG AKTIF. Mungkin Lain Waktu...</strong></font>';
				}
			}

		echo '<br><br><br>
		</td>
		</tr>
		</table>
		</form>';
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