<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admpus.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pinjam_user.php";
$judul = "User Pinjam";
$judulku = "[$pus_session : $nip14_session. $nm14_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$usrkd = nosql($_REQUEST['usrkd']);
$usrtipe = nosql($_REQUEST['usrtipe']);
$pg_kd = nosql($_REQUEST['pg_kd']);
$p_tgl = nosql($_REQUEST['p_tgl']);
$p_bln = nosql($_REQUEST['p_bln']);
$p_thn = nosql($_REQUEST['p_thn']);
$k_tgl = nosql($_REQUEST['k_tgl']);
$k_bln = nosql($_REQUEST['k_bln']);
$k_thn = nosql($_REQUEST['k_thn']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//focus
if (empty($pg_kd))
	{
	$diload = "document.formx.peminjam.focus();";
	}
else if (empty($a))
	{
	$diload = "document.formx.pinjam_tgl.focus();";
	}







//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ok..
if ($_POST['btnOK'])
	{
	//nilai
	$usrkd = nosql($_POST['usrkd']);
	$usrtipe = nosql($_POST['usrtipe']);
	$pg_kd = nosql($_POST['pg_kd']);


	//cek
	if ((empty($usrkd)) OR (empty($usrtipe)) OR (empty($pg_kd)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd";
		xloc($ke);
		exit();
		}
	}





//pinjam baru
if ($_POST['btnBR'])
	{
	//nilai
	$usrkd = nosql($_POST['usrkd']);
	$usrtipe = nosql($_POST['usrtipe']);
	$pg_kd = nosql($_POST['pg_kd']);

	//re-direct
	$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&s=baru";
	xloc($ke);
	exit();
	}





//pernah pinjam
if ($_POST['btnPR'])
	{
	//nilai
	$usrkd = nosql($_POST['usrkd']);
	$usrtipe = nosql($_POST['usrtipe']);
	$pg_kd = nosql($_POST['pg_kd']);

	//re-direct
	$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&s=pernah";
	xloc($ke);
	exit();
	}





//sedang pinjam
if ($_POST['btnSD'])
	{
	//nilai
	$usrkd = nosql($_POST['usrkd']);
	$usrtipe = nosql($_POST['usrtipe']);
	$pg_kd = nosql($_POST['pg_kd']);

	//re-direct
	$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd";
	xloc($ke);
	exit();
	}





//jika detail item
if ($_POST['btnDTI'])
	{
	//nilai
	$usrkd = nosql($_POST['usrkd']);
	$usrtipe = nosql($_POST['usrtipe']);
	$pg_kd = nosql($_POST['pg_kd']);
	$pinjam_tgl = nosql($_POST['pinjam_tgl']);
	$pinjam_bln = nosql($_POST['pinjam_bln']);
	$pinjam_thn = nosql($_POST['pinjam_thn']);
	$tgl_pinjam = "$pinjam_thn:$pinjam_bln:$pinjam_tgl";
	$kembali_tgl = nosql($_POST['kembali_tgl']);
	$kembali_bln = nosql($_POST['kembali_bln']);
	$kembali_thn = nosql($_POST['kembali_thn']);
	$tgl_kembali = "$kembali_thn:$kembali_bln:$kembali_tgl";


	//null . . .?
	if ((empty($pinjam_tgl)) OR (empty($pinjam_bln)) OR (empty($pinjam_thn)) OR (empty($kembali_tgl)) OR (empty($kembali_tgl))
	OR (empty($kembali_bln)) OR (empty($kembali_thn)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&p_tgl=$pinjam_tgl&p_bln=$pinjam_bln&p_thn=$pinjam_thn&k_tgl=$kembali_tgl&k_bln=$kembali_bln&k_thn=$kembali_thn&s=baru";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&p_tgl=$pinjam_tgl&p_bln=$pinjam_bln&p_thn=$pinjam_thn&k_tgl=$kembali_tgl&k_bln=$kembali_bln&k_thn=$kembali_thn&s=baru&a=detail";
		xloc($ke);
		exit();
		}
	}





//pinjam item
if ($_POST['btnSMP2'])
	{
	//nilai
	$usrkd = nosql($_POST['usrkd']);
	$usrtipe = nosql($_POST['usrtipe']);
	$pg_kd = nosql($_POST['pg_kd']);
	$p_tgl = nosql($_POST['p_tgl']);
	$p_bln = nosql($_POST['p_bln']);
	$p_thn = nosql($_POST['p_thn']);
	$tgl_pinjam = "$p_thn:$p_bln:$p_tgl";
	$k_tgl = nosql($_POST['k_tgl']);
	$k_bln = nosql($_POST['k_bln']);
	$k_thn = nosql($_POST['k_thn']);
	$tgl_kembali = "$k_thn:$k_bln:$k_tgl";
	$item_kd = nosql($_POST['item_kd']);
	$item_jml = nosql($_POST['item_jml']);


	//null . . .?
	if ((empty($p_tgl)) OR (empty($p_bln)) OR (empty($p_thn)) OR (empty($k_tgl)) OR (empty($k_tgl))
	OR (empty($k_bln)) OR (empty($k_thn)) OR (empty($item_kd)) OR (empty($item_jml)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diperhatikan...!!";
		$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&k_tgl=$k_tgl&k_bln=$k_bln&k_thn=$k_thn&s=baru&a=detail";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//cek
		$qcc = mysql_query("SELECT * FROM perpus_pinjam ".
								"WHERE kd_user = '$pg_kd' ".
								"AND tgl_pinjam = '$tgl_pinjam' ".
								"AND tgl_kembali = '$tgl_kembali' ".
								"AND kd_item = '$item_kd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);


		//jika iya
		if ($tcc != 0)
			{
			//re-direct
			$pesan = "Item Tersebut Telah Dipinjam. Harap Diperhatikan...!!";
			$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&k_tgl=$k_tgl&k_bln=$k_bln&k_thn=$k_thn&s=baru&a=detail";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//cek stock
			$qcc1 = mysql_query("SELECT * FROM perpus_stock ".
									"WHERE kd_item = '$item_kd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$tcc1 = mysql_num_rows($qcc1);
			$cc1_bagus = nosql($rcc1['jml_bagus']);
			$cc1_dipinjam = nosql($rcc1['jml_dipinjam']);
			$cc1_sisa = round($cc1_bagus - $cc1_dipinjam);

			//jika tidak sesuai stock
			if ($cc1_sisa < $item_jml)
				{
				//re-direct
				$pesan = "Jumlah item yang akan dipinjam, melebihi stock yang ada. Harap Diperhatikan...!!";
				$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&k_tgl=$k_tgl&k_bln=$k_bln&k_thn=$k_thn&s=baru&a=detail";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//cek, boleh dipinjam atau tidak
				$qbleh = mysql_query("SELECT * FROM perpus_item ".
										"WHERE kd = '$item_kd'");
				$rbleh = mysql_fetch_assoc($qbleh);
				$bleh_status = nosql($rbleh['status']);


				//jika boleh
				if ($bleh_status == "true")
					{
					//total dipinjam
					$total_dipinjam = round($cc1_dipinjam + $item_jml);

					//insert
					mysql_query("INSERT INTO perpus_pinjam(kd, kd_user, tgl_pinjam, tgl_kembali, kd_item, jml, status) VALUES ".
									"('$x', '$pg_kd', '$tgl_pinjam', '$tgl_kembali', '$item_kd', '$item_jml', 'true')");


					//update sisa stock
					mysql_query("UPDATE perpus_stock SET jml_dipinjam = '$total_dipinjam' ".
									"WHERE kd_item = '$item_kd'");


					//rangking
					$qkki = mysql_query("SELECT * FROM perpus_item_rangking ".
											"WHERE kd_item = '$item_kd'");
					$rkki = mysql_fetch_assoc($qkki);
					$tkki = mysql_num_rows($qkki);
					$kki_jml = nosql($rkki['jml']);
					$kki_total = round($kki_jml + $item_jml);

					//ada...?
					if ($tkki != 0)
						{
						//update rangking
						mysql_query("UPDATE perpus_item_rangking SET jml = '$kki_total' ".
										"WHERE kd_item = '$item_kd'");
						}
					else
						{
						//insert
						mysql_query("INSERT INTO perpus_item_rangking(kd, kd_item, jml) VALUES ".
										"('$x', '$item_kd', '$kki_total')");
						}


					//re-direct
					$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&k_tgl=$k_tgl&k_bln=$k_bln&k_thn=$k_thn&s=baru&a=detail";
					xloc($ke);
					exit();
					}

				//jika tidak boleh dipinjam
				else
					{
					//re-direct
					$pesan = "Item ini Belum Bisa Dipinjam. Harap Diperhatikan...!!";
					$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&k_tgl=$k_tgl&k_bln=$k_bln&k_thn=$k_thn&s=baru&a=detail";
					pekem($pesan,$ke);
					exit();
					}
				}
			}
		}
	}





//kembalikan item
if ($_POST['btnKBL'])
	{
	//nilai
	$usrkd = nosql($_POST['usrkd']);
	$usrtipe = nosql($_POST['usrtipe']);
	$pg_kd = nosql($_POST['pg_kd']);

	//ambil semua
	for ($i=1; $i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);


		//ketahui jml. yg dipinjam
		$qcc = mysql_query("SELECT * FROM perpus_pinjam ".
								"WHERE kd_user = '$pg_kd' ".
								"AND kd = '$kd'");
		$rcc = mysql_fetch_assoc($qcc);
		$cc_itemkd = nosql($rcc['kd_item']);
		$cc_jml = nosql($rcc['jml']);


		//ketahui jml. stock
		$qcc1 = mysql_query("SELECT * FROM perpus_stock ".
								"WHERE kd_item = '$cc_itemkd'");
		$rcc1 = mysql_fetch_assoc($qcc1);
		$cc1_dipinjam = nosql($rcc1['jml_dipinjam']);


		//kembalikan ke stock
		$jml_baru = round($cc1_dipinjam - $cc_jml);
		mysql_query("UPDATE perpus_stock SET jml_dipinjam = '$jml_baru' ".
						"WHERE kd_item = '$cc_itemkd'");


		//update ke pernah pinjam
		mysql_query("UPDATE perpus_pinjam SET status = 'false' ".
						"WHERE kd_user = '$pg_kd' ".
						"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd";
	xloc($ke);
	exit();
	}






//hapus item
if ($_POST['btnHPS2'])
	{
	//nilai
	$usrkd = nosql($_POST['usrkd']);
	$usrtipe = nosql($_POST['usrtipe']);
	$pg_kd = nosql($_POST['pg_kd']);
	$p_tgl = nosql($_POST['p_tgl']);
	$p_bln = nosql($_POST['p_bln']);
	$p_thn = nosql($_POST['p_thn']);
	$tgl_pinjam = "$p_thn:$p_bln:$p_tgl";
	$k_tgl = nosql($_POST['k_tgl']);
	$k_bln = nosql($_POST['k_bln']);
	$k_thn = nosql($_POST['k_thn']);
	$tgl_kembali = "$k_thn:$k_bln:$k_tgl";



	//ambil semua
	for ($i=1; $i=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);


		//ketahui jml. yg dipinjam
		$qcc = mysql_query("SELECT * FROM perpus_pinjam ".
								"WHERE kd_user = '$pg_kd' ".
								"AND kd = '$kd'");
		$rcc = mysql_fetch_assoc($qcc);
		$cc_itemkd = nosql($rcc['kd_item']);
		$cc_jml = nosql($rcc['jml']);


		//ketahui jml. stock
		$qcc1 = mysql_query("SELECT * FROM perpus_stock ".
								"WHERE kd_item = '$cc_itemkd'");
		$rcc1 = mysql_fetch_assoc($qcc1);
		$cc1_dipinjam = nosql($rcc1['jml_dipinjam']);


		//kembalikan ke stock
		$jml_baru = round($cc1_dipinjam - $cc_jml);
		mysql_query("UPDATE perpus_stock SET jml_dipinjam = '$jml_baru' ".
						"WHERE kd_item = '$cc_itemkd'");


		//del
		mysql_query("DELETE FROM perpus_pinjam ".
						"WHERE kd_user = '$pg_kd' ".
						"AND kd = '$kd'");
		}

	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&p_tgl=$p_tgl&p_bln=$p_bln&p_thn=$p_thn&k_tgl=$k_tgl&k_bln=$k_bln&k_thn=$k_thn&s=baru&a=detail";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();




//js
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/js/checkall.js");
require("../../inc/menu/admpus.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaover.'">
<td>';
echo "Peminjam : <select name=\"peminjam\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$usrkd.'" selected>'.$usrtipe.'</option>
<option value="'.$filenya.'?usrkd=usr01&usrtipe=Pegawai">Pegawai</option>
<option value="'.$filenya.'?usrkd=usr02&usrtipe=Siswa">Siswa</option>
</select>
</td>
</tr>
</table>';

//jika pegawai //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($usrkd == "usr01")
	{
	///data...
	$qdt = mysql_query("SELECT * FROM m_pegawai ".
							"WHERE kd = '$pg_kd'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_nip = nosql($rdt['nip']);
	$dt_nama = balikin2($rdt['nama']);



	//popup
	echo '<script type="text/javascript" src="'.$sumber.'/inc/js/dhtmlwindow_pus.js"></script>
	<script type="text/javascript" src="'.$sumber.'/inc/js/modal.js"></script>
	<script type="text/javascript">

	function open_pg()
		{
		pg_window=dhtmlmodal.open(\'Daftar Pegawai\',
		\'iframe\',
		\'popup_pegawai.php\',
		\'Daftar Pegawai\',
		\'width=550px,height=350px,center=1,resize=0,scrolling=0\')

		pg_window.onclose=function()
			{
			var pg_kd=this.contentDoc.getElementById("pg_kd");
			var pg_nip=this.contentDoc.getElementById("pg_nip");
			var pg_nama=this.contentDoc.getElementById("pg_nama");

			document.formx.pg_kd.value=pg_kd.value;
			document.formx.pg_nip.value=pg_nip.value;
			document.formx.pg_nama.value=pg_nama.value;
			return true
			}
		}


	function open_brg()
		{
		brg_window=dhtmlmodal.open(\'Daftar Item\',
		\'iframe\',
		\'popup_item.php\',
		\'Daftar Item\',
		\'width=550px,height=350px,center=1,resize=0,scrolling=0\')

		brg_window.onclose=function()
			{
			var item_kd=this.contentDoc.getElementById("item_kd");
			var item_nama=this.contentDoc.getElementById("item_nama");

			document.formx.item_kd.value=item_kd.value;
			document.formx.item_nama.value=item_nama.value;
			document.formx.item_jml.focus();
			return true
			}
		}
	</script>';


	echo '<p>
	NIP :
	<input name="pg_nip" type="text" value="'.$dt_nip.'" size="20" class="input" readonly>,
	Nama :
	<input name="pg_nama" type="text" value="'.$dt_nama.'" size="30" class="input" readonly>
	<input name="pg_kd" type="hidden" value="'.$pg_kd.'">
	<input name="usrkd" type="hidden" value="'.$usrkd.'">
	<input name="usrtipe" type="hidden" value="'.$usrtipe.'">
	<input name="btnDFT" type="button" value="..." onClick="open_pg(); return false">
	<input name="btnOK" type="submit" value="DETAIL >>>">
	</p>
	<hr>';


	//jika iya...
	if (!empty($pg_kd))
		{
		//jika pinjam baru
		if ($s == "baru")
			{
			$d1_nil = "disabled";
			}

		//jika pernah pinjam
		else if ($s == "pernah")
			{
			$d2_nil = "disabled";
			}

		//jika sedang pinjam
		else if (empty($s))
			{
			$d3_nil = "disabled";
			}


		echo '<p>
		<input name="btnBR" type="submit" value="Pinjam Baru >>" '.$d1_nil.'>
		<input name="btnPR" type="submit" value="Pernah Pinjam >>" '.$d2_nil.'>
		<input name="btnSD" type="submit" value="Sedang Pinjam >>" '.$d3_nil.'>
		<hr>
		</p>';

		//jika baru
		if ($s == "baru")
			{
			//jika detail
			if ($a == "detail")
				{
				$st_detail = "disabled";
				}


			echo '<p>
			Tgl. Pinjam :
			<select name="pinjam_tgl" '.$st_detail.'>
			<option value="'.$p_tgl.'" selected>'.$p_tgl.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="pinjam_bln" '.$st_detail.'>
			<option value="'.$p_bln.'" selected>'.$arrbln[$p_bln].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="pinjam_thn" '.$st_detail.'>
			<option value="'.$p_thn.'" selected>'.$p_thn.'</option>';
			for ($k=$pinjam01;$k<=$pinjam02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>,

			Tgl. Kembali :
			<select name="kembali_tgl" '.$st_detail.'>
			<option value="'.$k_tgl.'" selected>'.$k_tgl.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="kembali_bln" '.$st_detail.'>
			<option value="'.$k_bln.'" selected>'.$arrbln[$k_bln].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="kembali_thn" '.$st_detail.'>
			<option value="'.$k_thn.'" selected>'.$k_thn.'</option>';
			for ($k=$pinjam01;$k<=$pinjam02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			<input name="p_tgl" type="hidden" value="'.$p_tgl.'">
			<input name="p_bln" type="hidden" value="'.$p_bln.'">
			<input name="p_thn" type="hidden" value="'.$p_thn.'">
			<input name="k_tgl" type="hidden" value="'.$k_tgl.'">
			<input name="k_bln" type="hidden" value="'.$k_bln.'">
			<input name="k_thn" type="hidden" value="'.$k_thn.'">
			<input name="btnDTI" type="submit" value="Detail Item >>" '.$st_detail.'>
			</p>';



			//detail item
			if ($a == "detail")
				{
				echo '<p>
				Item :
				<input name="item_nama" type="text" value="" size="30" class="input" readonly>
				<input name="btnITEM" type="button" value="..." onClick="open_brg(); return false">
				<input name="item_kd" type="hidden" value="">
				Jumlah :
				<input name="item_jml" type="text" value="" size="5" onKeyPress="return numbersonly(this, event)">
				<input name="btnSMP2" type="submit" value="PINJAM >>">
				</p>

				<p>';
				//detail item
				$qdt = mysql_query("SELECT perpus_pinjam.*, perpus_pinjam.kd AS dkd, ".
										"perpus_item.* ".
										"FROM perpus_pinjam, perpus_item ".
										"WHERE perpus_pinjam.kd_item = perpus_item.kd ".
										"AND perpus_pinjam.kd_user = '$pg_kd' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d')) = '$p_tgl' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$p_bln' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$p_thn' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d')) = '$k_tgl' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m')) = '$k_bln' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y')) = '$k_thn' ".
										"ORDER BY round(perpus_item.kode) ASC");
				$rdt = mysql_fetch_assoc($qdt);
				$tdt = mysql_num_rows($qdt);

				//nek ada
				if ($tdt != 0)
					{
					echo '<table width="500" border="1" cellspacing="0" cellpadding="3">
					<tr bgcolor="'.$warnaheader.'">
					<td width="1">&nbsp;</td>
					<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
					<td width="50"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
					</tr>';

					do
						{
						if ($warna_set ==0)
							{
							$warna = $warna01;
							$warna_set = 1;
							}
						else
							{
							$warna = $warna02;
							$warna_set = 0;
							}

						$nox = $nox + 1;
						$i_kd = nosql($rdt['dkd']);
						$i_itemkd = nosql($rdt['kd_item']);
						$i_jml = nosql($rdt['jml']);

						//brg item
						$qtemx = mysql_query("SELECT * FROM perpus_item ".
												"WHERE kd = '$i_itemkd'");
						$rtemx = mysql_fetch_assoc($qtemx);
						$temx_kode = nosql($rtemx['kode']);
						$temx_nama = balikin2($rtemx['judul']);


						echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
						echo '<td>
						<input type="checkbox" name="item'.$nox.'" value="'.$i_kd.'">
				        </td>
						<td>'.$temx_kode.'. '.$temx_nama.'</td>
						<td>'.$i_jml.'</td>
				        </tr>';
						}
					while ($rdt = mysql_fetch_assoc($qdt));

					echo '</tr>
					</td>
					</table>
					<table width="500" border="0" cellspacing="0" cellpadding="3">
					<tr>
					<td>
					<input name="jml" type="hidden" value="'.$tdt.'">
					<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tdt.')">
					<input name="btnHPS2" type="submit" value="HAPUS">
					</td>
					</tr>
					</table>';
					}
				else
					{
					echo '<font color="red"><strong>Belum Ada Data Item.</strong></font>';
					}

				echo '</p>';
				}
			}



		//pernah pinjam
		else if ($s == "pernah")
			{
			//data pinjam item
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
							"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
							"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
							"perpus_pinjam.* ".
							"FROM perpus_pinjam ".
							"WHERE kd_user = '$pg_kd' ".
							"AND status = 'false'";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&s=pernah";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//jika ada
			if ($count != 0)
				{
				echo '<table width="800" border="1" cellspacing="0" cellpadding="3">
				<tr bgcolor="'.$warnaheader.'">
				<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
				<td width="50"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Kembali</font></strong></td>
				</tr>';

				do
					{
					if ($warna_set ==0)
						{
						$warna = $warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $warna02;
						$warna_set = 0;
						}

					$nox = $nox + 1;
					$buk_kd = nosql($data['kd']);
					$buk_ptgl = nosql($data['p_tgl']);
					$buk_pbln = nosql($data['p_bln']);
					$buk_pthn = nosql($data['p_thn']);
					$buk_ktgl = nosql($data['k_tgl']);
					$buk_kbln = nosql($data['k_bln']);
					$buk_kthn = nosql($data['k_thn']);
					$buk_itemkd = nosql($data['kd_item']);
					$buk_jml = nosql($data['jml']);
					$buk_status = nosql($data['status']);

					//brg item
					$qtemx = mysql_query("SELECT * FROM perpus_item ".
											"WHERE kd = '$buk_itemkd'");
					$rtemx = mysql_fetch_assoc($qtemx);
					$temx_kode = nosql($rtemx['kode']);
					$temx_nama = balikin2($rtemx['judul']);


					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>'.$temx_kode.'. <strong>'.$temx_nama.'</strong></td>
					<td>'.$buk_jml.'</td>
					<td>'.$buk_ptgl.' '.$arrbln1[$buk_pbln].' '.$buk_pthn.'</td>
					<td>'.$buk_ktgl.' '.$arrbln1[$buk_kbln].' '.$buk_kthn.'</td>
			        </tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="800" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
				</tr>
				</table>';
				}
			else
				{
				echo '<p>
				<font color="red">
				<strong>BELUM PERNAH PINJAM ITEM. . .</strong>
				</font>
				</p>';
				}
			}



		//daftar aja..., sedang pinjam...
		else
			{
			//data pinjam item
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
							"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
							"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
							"perpus_pinjam.* ".
							"FROM perpus_pinjam ".
							"WHERE kd_user = '$pg_kd' ".
							"AND status = 'true'";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//jika ada
			if ($count != 0)
				{
				echo '<table width="900" border="1" cellspacing="0" cellpadding="3">
				<tr bgcolor="'.$warnaheader.'">
				<td width="1">&nbsp;</td>
				<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
				<td width="50"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Kembali</font></strong></td>
				</tr>';

				do
					{
					if ($warna_set ==0)
						{
						$warna = $warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $warna02;
						$warna_set = 0;
						}

					$nox = $nox + 1;
					$buk_kd = nosql($data['kd']);
					$buk_ptgl = nosql($data['p_tgl']);
					$buk_pbln = nosql($data['p_bln']);
					$buk_pthn = nosql($data['p_thn']);
					$buk_ktgl = nosql($data['k_tgl']);
					$buk_kbln = nosql($data['k_bln']);
					$buk_kthn = nosql($data['k_thn']);
					$buk_itemkd = nosql($data['kd_item']);
					$buk_jml = nosql($data['jml']);
					$buk_status = nosql($data['status']);

					//brg item
					$qtemx = mysql_query("SELECT * FROM perpus_item ".
											"WHERE kd = '$buk_itemkd'");
					$rtemx = mysql_fetch_assoc($qtemx);
					$temx_kode = nosql($rtemx['kode']);
					$temx_nama = balikin2($rtemx['judul']);


					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
					<input type="checkbox" name="item'.$nox.'" value="'.$buk_kd.'">
			        </td>
					<td>'.$temx_kode.'. <strong>'.$temx_nama.'</strong></td>
					<td>'.$buk_jml.'</td>
					<td>'.$buk_ptgl.' '.$arrbln1[$buk_pbln].' '.$buk_pthn.'</td>
					<td>'.$buk_ktgl.' '.$arrbln1[$buk_kbln].' '.$buk_kthn.'</td>
			        </tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="900" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td width="300">
				<input name="s" type="hidden" value="'.$s.'">
				<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
				<input name="btnKBL" type="submit" value="DIKEMBALIKAN >>">
				</td>
				<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
				</tr>
				</table>';
				}
			else
				{
				echo '<p>
				<font color="red">
				<strong>TIDAK ADA DATA. SEDANG TIDAK MELAKUKAN PEMINJAMAN ITEM. . .</strong>
				</font>
				</p>';
				}
			}
		}
	}





//jika siswa ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if ($usrkd == "usr02")
	{
	///data...
	$qdt = mysql_query("SELECT * FROM m_siswa ".
							"WHERE kd = '$pg_kd'");
	$rdt = mysql_fetch_assoc($qdt);
	$dt_nis = nosql($rdt['nis']);
	$dt_nama = balikin2($rdt['nama']);



	//popup
	echo '<script type="text/javascript" src="'.$sumber.'/inc/js/dhtmlwindow_pus.js"></script>
	<script type="text/javascript" src="'.$sumber.'/inc/js/modal.js"></script>
	<script type="text/javascript">

	function open_pg()
		{
		pg_window=dhtmlmodal.open(\'Daftar Siswa\',
		\'iframe\',
		\'popup_siswa.php\',
		\'Daftar Siswa\',
		\'width=550px,height=350px,center=1,resize=0,scrolling=0\')

		pg_window.onclose=function()
			{
			var pg_kd=this.contentDoc.getElementById("pg_kd");
			var pg_nis=this.contentDoc.getElementById("pg_nis");
			var pg_nama=this.contentDoc.getElementById("pg_nama");

			document.formx.pg_kd.value=pg_kd.value;
			document.formx.pg_nis.value=pg_nis.value;
			document.formx.pg_nama.value=pg_nama.value;
			return true
			}
		}


		function open_brg()
		{
		brg_window=dhtmlmodal.open(\'Daftar Item\',
		\'iframe\',
		\'popup_item.php\',
		\'Daftar Item\',
		\'width=550px,height=350px,center=1,resize=0,scrolling=0\')

		brg_window.onclose=function()
			{
			var item_kd=this.contentDoc.getElementById("item_kd");
			var item_nama=this.contentDoc.getElementById("item_nama");

			document.formx.item_kd.value=item_kd.value;
			document.formx.item_nama.value=item_nama.value;
			document.formx.item_jml.focus();
			return true
			}
		}
	</script>';


	echo '<p>
	NIS :
	<input name="pg_nis" type="text" value="'.$dt_nis.'" size="20" class="input" readonly>,
	Nama :
	<input name="pg_nama" type="text" value="'.$dt_nama.'" size="30" class="input" readonly>
	<input name="pg_kd" type="hidden" value="'.$pg_kd.'">
	<input name="usrkd" type="hidden" value="'.$usrkd.'">
	<input name="usrtipe" type="hidden" value="'.$usrtipe.'">
	<input name="btnDFT" type="button" value="..." onClick="open_pg(); return false">
	<input name="btnOK" type="submit" value="DETAIL >>>">
	</p>
	<hr>';


	//jika iya...
	if (!empty($pg_kd))
		{
		//jika pinjam baru
		if ($s == "baru")
			{
			$d1_nil = "disabled";
			}

		//jika pernah pinjam
		else if ($s == "pernah")
			{
			$d2_nil = "disabled";
			}

		//jika sedang pinjam
		else if (empty($s))
			{
			$d3_nil = "disabled";
			}


		echo '<p>
		<input name="btnBR" type="submit" value="Pinjam Baru >>" '.$d1_nil.'>
		<input name="btnPR" type="submit" value="Pernah Pinjam >>" '.$d2_nil.'>
		<input name="btnSD" type="submit" value="Sedang Pinjam >>" '.$d3_nil.'>
		<hr>
		</p>';

		//jika baru
		if ($s == "baru")
			{
			//jika detail
			if ($a == "detail")
				{
				$st_detail = "disabled";
				}


			echo '<p>
			Tgl. Pinjam :
			<select name="pinjam_tgl" '.$st_detail.'>
			<option value="'.$p_tgl.'" selected>'.$p_tgl.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="pinjam_bln" '.$st_detail.'>
			<option value="'.$p_bln.'" selected>'.$arrbln[$p_bln].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="pinjam_thn" '.$st_detail.'>
			<option value="'.$p_thn.'" selected>'.$p_thn.'</option>';
			for ($k=$pinjam01;$k<=$pinjam02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>,

			Tgl. Kembali :
			<select name="kembali_tgl" '.$st_detail.'>
			<option value="'.$k_tgl.'" selected>'.$k_tgl.'</option>';
			for ($i=1;$i<=31;$i++)
				{
				echo '<option value="'.$i.'">'.$i.'</option>';
				}

			echo '</select>
			<select name="kembali_bln" '.$st_detail.'>
			<option value="'.$k_bln.'" selected>'.$arrbln[$k_bln].'</option>';
			for ($j=1;$j<=12;$j++)
				{
				echo '<option value="'.$j.'">'.$arrbln[$j].'</option>';
				}

			echo '</select>
			<select name="kembali_thn" '.$st_detail.'>
			<option value="'.$k_thn.'" selected>'.$k_thn.'</option>';
			for ($k=$pinjam01;$k<=$pinjam02;$k++)
				{
				echo '<option value="'.$k.'">'.$k.'</option>';
				}
			echo '</select>
			<input name="p_tgl" type="hidden" value="'.$p_tgl.'">
			<input name="p_bln" type="hidden" value="'.$p_bln.'">
			<input name="p_thn" type="hidden" value="'.$p_thn.'">
			<input name="k_tgl" type="hidden" value="'.$k_tgl.'">
			<input name="k_bln" type="hidden" value="'.$k_bln.'">
			<input name="k_thn" type="hidden" value="'.$k_thn.'">
			<input name="btnDTI" type="submit" value="Detail Item >>" '.$st_detail.'>
			</p>';



			//detail item
			if ($a == "detail")
				{
				echo '<p>
				Item :
				<input name="item_nama" type="text" value="" size="30" class="input" readonly>
				<input name="btnITEM" type="button" value="..." onClick="open_brg(); return false">
				<input name="item_kd" type="hidden" value="">
				Jumlah :
				<input name="item_jml" type="text" value="" size="5" onKeyPress="return numbersonly(this, event)">
				<input name="btnSMP2" type="submit" value="PINJAM >>">
				</p>

				<p>';
				//detail item
				$qdt = mysql_query("SELECT perpus_pinjam.*, perpus_pinjam.kd AS dkd, ".
										"perpus_item.* ".
										"FROM perpus_pinjam, perpus_item ".
										"WHERE perpus_pinjam.kd_item = perpus_item.kd ".
										"AND perpus_pinjam.kd_user = '$pg_kd' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d')) = '$p_tgl' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m')) = '$p_bln' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y')) = '$p_thn' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d')) = '$k_tgl' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m')) = '$k_bln' ".
										"AND round(DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y')) = '$k_thn' ".
										"ORDER BY round(perpus_item.kode) ASC");
				$rdt = mysql_fetch_assoc($qdt);
				$tdt = mysql_num_rows($qdt);

				//nek ada
				if ($tdt != 0)
					{
					echo '<table width="500" border="1" cellspacing="0" cellpadding="3">
					<tr bgcolor="'.$warnaheader.'">
					<td width="1">&nbsp;</td>
					<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
					<td width="50"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
					</tr>';

					do
						{
						if ($warna_set ==0)
							{
							$warna = $warna01;
							$warna_set = 1;
							}
						else
							{
							$warna = $warna02;
							$warna_set = 0;
							}

						$nox = $nox + 1;
						$i_kd = nosql($rdt['dkd']);
						$i_itemkd = nosql($rdt['kd_item']);
						$i_jml = nosql($rdt['jml']);

						//brg item
						$qtemx = mysql_query("SELECT * FROM perpus_item ".
												"WHERE kd = '$i_itemkd'");
						$rtemx = mysql_fetch_assoc($qtemx);
						$temx_kode = nosql($rtemx['kode']);
						$temx_nama = balikin2($rtemx['judul']);


						echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
						echo '<td>
						<input type="checkbox" name="item'.$nox.'" value="'.$i_kd.'">
				        </td>
						<td>'.$temx_kode.'. '.$temx_nama.'</td>
						<td>'.$i_jml.'</td>
				        </tr>';
						}
					while ($rdt = mysql_fetch_assoc($qdt));

					echo '</tr>
					</td>
					</table>
					<table width="500" border="0" cellspacing="0" cellpadding="3">
					<tr>
					<td>
					<input name="jml" type="hidden" value="'.$tdt.'">
					<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$tdt.')">
					<input name="btnHPS2" type="submit" value="HAPUS">
					</td>
					</tr>
					</table>';
					}
				else
					{
					echo '<font color="red"><strong>Belum Ada Data Item.</strong></font>';
					}

				echo '</p>';
				}
			}



		//pernah pinjam
		else if ($s == "pernah")
			{
			//data pinjam item
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
							"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
							"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
							"perpus_pinjam.* ".
							"FROM perpus_pinjam ".
							"WHERE kd_user = '$pg_kd' ".
							"AND status = 'false'";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd&s=pernah";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//jika ada
			if ($count != 0)
				{
				echo '<table width="800" border="1" cellspacing="0" cellpadding="3">
				<tr bgcolor="'.$warnaheader.'">
				<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
				<td width="50"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Kembali</font></strong></td>
				</tr>';

				do
					{
					if ($warna_set ==0)
						{
						$warna = $warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $warna02;
						$warna_set = 0;
						}

					$nox = $nox + 1;
					$buk_kd = nosql($data['kd']);
					$buk_ptgl = nosql($data['p_tgl']);
					$buk_pbln = nosql($data['p_bln']);
					$buk_pthn = nosql($data['p_thn']);
					$buk_ktgl = nosql($data['k_tgl']);
					$buk_kbln = nosql($data['k_bln']);
					$buk_kthn = nosql($data['k_thn']);
					$buk_itemkd = nosql($data['kd_item']);
					$buk_jml = nosql($data['jml']);
					$buk_status = nosql($data['status']);

					//brg item
					$qtemx = mysql_query("SELECT * FROM perpus_item ".
											"WHERE kd = '$buk_itemkd'");
					$rtemx = mysql_fetch_assoc($qtemx);
					$temx_kode = nosql($rtemx['kode']);
					$temx_nama = balikin2($rtemx['judul']);


					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>'.$temx_kode.'. <strong>'.$temx_nama.'</strong></td>
					<td>'.$buk_jml.'</td>
					<td>'.$buk_ptgl.' '.$arrbln1[$buk_pbln].' '.$buk_pthn.'</td>
					<td>'.$buk_ktgl.' '.$arrbln1[$buk_kbln].' '.$buk_kthn.'</td>
			        </tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="800" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
				</tr>
				</table>';
				}
			else
				{
				echo '<p>
				<font color="red">
				<strong>BELUM PERNAH PINJAM ITEM. . .</strong>
				</font>
				</p>';
				}
			}



		//daftar aja..., sedang pinjam...
		else
			{
			//data pinjam item
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
							"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
							"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
							"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
							"perpus_pinjam.* ".
							"FROM perpus_pinjam ".
							"WHERE kd_user = '$pg_kd' ".
							"AND status = 'true'";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);

			$target = "$filenya?usrkd=$usrkd&usrtipe=$usrtipe&pg_kd=$pg_kd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//jika ada
			if ($count != 0)
				{
				echo '<table width="900" border="1" cellspacing="0" cellpadding="3">
				<tr bgcolor="'.$warnaheader.'">
				<td width="1">&nbsp;</td>
				<td><strong><font color="'.$warnatext.'">Item</font></strong></td>
				<td width="50"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
				<td width="150"><strong><font color="'.$warnatext.'">Tgl. Kembali</font></strong></td>
				</tr>';

				do
					{
					if ($warna_set ==0)
						{
						$warna = $warna01;
						$warna_set = 1;
						}
					else
						{
						$warna = $warna02;
						$warna_set = 0;
						}

					$nox = $nox + 1;
					$buk_kd = nosql($data['kd']);
					$buk_ptgl = nosql($data['p_tgl']);
					$buk_pbln = nosql($data['p_bln']);
					$buk_pthn = nosql($data['p_thn']);
					$buk_ktgl = nosql($data['k_tgl']);
					$buk_kbln = nosql($data['k_bln']);
					$buk_kthn = nosql($data['k_thn']);
					$buk_itemkd = nosql($data['kd_item']);
					$buk_jml = nosql($data['jml']);
					$buk_status = nosql($data['status']);

					//brg item
					$qtemx = mysql_query("SELECT * FROM perpus_item ".
											"WHERE kd = '$buk_itemkd'");
					$rtemx = mysql_fetch_assoc($qtemx);
					$temx_kode = nosql($rtemx['kode']);
					$temx_nama = balikin2($rtemx['judul']);


					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td>
					<input type="checkbox" name="item'.$nox.'" value="'.$buk_kd.'">
			        </td>
					<td>'.$temx_kode.'. <strong>'.$temx_nama.'</strong></td>
					<td>'.$buk_jml.'</td>
					<td>'.$buk_ptgl.' '.$arrbln1[$buk_pbln].' '.$buk_pthn.'</td>
					<td>'.$buk_ktgl.' '.$arrbln1[$buk_kbln].' '.$buk_kthn.'</td>
			        </tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="900" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td width="300">
				<input name="s" type="hidden" value="'.$s.'">
				<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')">
				<input name="btnKBL" type="submit" value="DIKEMBALIKAN >>">
				</td>
				<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
				</tr>
				</table>';
				}
			else
				{
				echo '<p>
				<font color="red">
				<strong>TIDAK ADA DATA. SEDANG TIDAK MELAKUKAN PEMINJAMAN ITEM. . .</strong>
				</font>
				</p>';
				}
			}
		}
	}


echo '</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");



//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>