<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbp.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "pribadi.php";
$judul = "Kelakuan/Pribadi";
$judulku = "[$bk_session : $nip15_session.$nm15_session] ==> $judul";
$juduly = $judul;
$s = nosql($_REQUEST['s']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$rukd = nosql($_REQUEST['rukd']);
$smtkd = nosql($_REQUEST['smtkd']);
$skkd = nosql($_REQUEST['skkd']);
$swkd = nosql($_REQUEST['swkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&skkd=$skkd&swkd=$swkd";




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else if (empty($rukd))
	{
	$diload = "document.formx.ruang.focus();";
	}
else if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika batal
if ($_POST['btnBTL'])
	{
        //nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$rukd = nosql($_POST['rukd']);
	$smtkd = nosql($_POST['smtkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}





//jika simpan pribadi
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$rukd = nosql($_POST['rukd']);
	$skkd = nosql($_POST['skkd']);

	//query
	$qkst = mysql_query("SELECT * FROM m_pribadi ".
				"ORDER BY pribadi ASC");
	$rkst = mysql_fetch_assoc($qkst);
	$tkst = mysql_num_rows($qkst);

	//ambil semua
	do
		{
		//ambil nilai
		$noxzi = $noxzi + 1;

		$xkdt = "prikd";
		$xkdt1 = "$xkdt$noxzi";
		$xkdtxx = nosql($_POST["$xkdt1"]);

		$xkst = "predikat_pribadi";
		$xkst1 = "$xkst$noxzi";
		$xkstxx = nosql($_POST["$xkst1"]);

		$xket = "ket_pribadi";
		$xket1 = "$xket$noxzi";
		$xketxx = nosql($_POST["$xket1"]);


		//cek
		$qcc = mysql_query("SELECT * FROM siswa_pribadi ".
					"WHERE kd_siswa_kelas = '$skkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_pribadi = '$xkdtxx'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//nek ada
		if ($tcc != 0)
			{
			//update
			mysql_query("UPDATE siswa_pribadi SET predikat = '$xkstxx', ".
					"ket = '$xketxx' ".
					"WHERE kd_siswa_kelas = '$skkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_pribadi = '$xkdtxx'");
			}
		//jika blm ada
		else
			{
			mysql_query("INSERT INTO siswa_pribadi(kd, kd_siswa_kelas, kd_smt, kd_pribadi, predikat, ket) VALUES ".
					"('$x', '$skkd', '$smtkd', '$xkdtxx', '$xkstxx', '$xketxx')");
			}
		}
	while ($rkst = mysql_fetch_assoc($qkst));



	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}





//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$rukd = nosql($_POST['rukd']);
	$smtkd = nosql($_POST['smtkd']);



	//require
	require('../../inc/class/excel/OLEwriter.php');
	require('../../inc/class/excel/BIFFwriter.php');
	require('../../inc/class/excel/worksheet.php');
	require('../../inc/class/excel/workbook.php');


	//nama file e...
	$i_filename = "daftar_pribadi_siswa.xls";
	$i_judul = "Daftar Pribadi Siswa";


	//header file
	function HeaderingExcel($filename)
		{
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$filename" );
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		}


	//bikin...
	HeaderingExcel($i_filename);
	$workbook = new Workbook("-");
	$worksheet1 =& $workbook->add_worksheet($i_judul);
	$worksheet1->set_column(0,0,10);
	$worksheet1->set_column(0,1,20);
	$worksheet1->set_column(0,2,12);
	$worksheet1->set_column(0,3,12);
	$worksheet1->set_column(0,4,17);
	$worksheet1->set_column(0,5,17);
	$worksheet1->write_string(0,0,"NIS");
	$worksheet1->write_string(0,1,"NAMA");
	$worksheet1->write_string(0,2,"AKHLAK");
	$worksheet1->write_string(0,3,"AKHLAK_KET");
	$worksheet1->write_string(0,4,"KEPRIBADIAN");
	$worksheet1->write_string(0,5,"KEPRIBADIAN_KET");



	//data
	$qdt = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%d') AS lahir_tgl, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%m') AS lahir_bln, ".
				"DATE_FORMAT(m_siswa.tgl_lahir, '%Y') AS lahir_thn, ".
				"siswa_kelas.*, siswa_kelas.kd AS skkd ".
				"FROM m_siswa, siswa_kelas ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kelkd' ".
				"AND siswa_kelas.kd_ruang = '$rukd' ".
				"ORDER BY round(m_siswa.nis) ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
	  	{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_mskd = nosql($rdt['mskd']);
		$dt_skkd = nosql($rdt['skkd']);
		$dt_nis = nosql($rdt['nis']);
		$dt_nama = balikin($rdt['nama']);


		//akhlak...
		$qprix = mysql_query("SELECT m_pribadi.*, siswa_pribadi.* ".
					"FROM m_pribadi, siswa_pribadi ".
					"WHERE siswa_pribadi.kd_pribadi = m_pribadi.kd ".
					"AND siswa_pribadi.kd_siswa_kelas = '$dt_skkd' ".
					"AND siswa_pribadi.kd_smt = '$smtkd' ".
					"AND m_pribadi.pribadi = 'Akhlak'");
		$rprix = mysql_fetch_assoc($qprix);
		$tprix = mysql_num_rows($qprix);
		$prix_predikat = nosql($rprix['predikat']);
		$prix_ket = balikin($rprix['ket']);


		//pribadi...
		$qprix2 = mysql_query("SELECT m_pribadi.*, siswa_pribadi.* ".
					"FROM m_pribadi, siswa_pribadi ".
					"WHERE siswa_pribadi.kd_pribadi = m_pribadi.kd ".
					"AND siswa_pribadi.kd_siswa_kelas = '$dt_skkd' ".
					"AND siswa_pribadi.kd_smt = '$smtkd' ".
					"AND m_pribadi.pribadi = 'Kepribadian'");
		$rprix2 = mysql_fetch_assoc($qprix2);
		$tprix2 = mysql_num_rows($qprix2);
		$prix2_predikat = nosql($rprix2['predikat']);
		$prix2_ket = balikin($rprix2['ket']);


		//ciptakan
		$worksheet1->write_string($dt_nox,0,$dt_nis);
		$worksheet1->write_string($dt_nox,1,$dt_nama);
		$worksheet1->write_string($dt_nox,2,$prix_predikat);
		$worksheet1->write_string($dt_nox,3,$prix_ket);
		$worksheet1->write_string($dt_nox,4,$prix2_predikat);
		$worksheet1->write_string($dt_nox,5,$prix2_ket);
		}
	while ($rdt = mysql_fetch_assoc($qdt));


	//close
	$workbook->close();


	//diskonek
	xclose($koneksi);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}






//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$rukd = nosql($_POST['rukd']);
	$smtkd = nosql($_POST['smtkd']);

	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&s=import";
	xloc($ke);
	exit();
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$rukd = nosql($_POST['rukd']);
	$smtkd = nosql($_POST['smtkd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&s=import";
		pekem($pesan,$ke);
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox/excel";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex");

			//re-direct
			$ke = "pribadi_import.php?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&filex_namex=$filex_namex";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/menu/admbp.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
			"WHERE kd <> '$tapelkd' ".
			"ORDER BY tahun1 ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,

Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd <> '$kelkd' ".
			"ORDER BY no ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,

Ruang : ';
echo "<select name=\"ruang\" onChange=\"MM_jumpMenu('self',this,0)\">";

//ruang
$qstx = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$rukd'");
$rowstx = mysql_fetch_assoc($qstx);

$ruang = nosql($rowstx['ruang']);

echo '<option value="'.$rukd.'" selected>'.$ruang.'</option>';

$qst = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd <> '$rukd'");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$stkd = nosql($rowst['kd']);
	$struang = balikin($rowst['ruang']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$stkd.'">'.$struang.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>,


Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>';



//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($rukd))
	{
	echo '<p>
	<font color="#FF0000"><strong>RUANG Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	//jika edit
	if ($s == "edit")
		{
		//detail siswa
		$qsiw = mysql_query("SELECT * FROM m_siswa ".
					"WHERE kd = '$swkd'");
		$rsiw = mysql_fetch_assoc($qsiw);
		$siw_nis = nosql($rsiw['nis']);
		$siw_nama = balikin($rsiw['nama']);


		//skkd
		$qku = mysql_query("SELECT m_siswa.*, m_siswa.kd AS mskd, ".
					"siswa_kelas.*, siswa_kelas.kd AS skkd ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND siswa_kelas.kd_ruang = '$rukd' ".
					"AND m_siswa.kd = '$swkd'");
		$rku = mysql_fetch_assoc($qku);
		$tku = mysql_num_rows($qku);
		$ku_skkd = nosql($rku['skkd']);


		echo '<p>
		<big>Siswa : <strong>'.$siw_nis.'.'.$siw_nama.'</strong></big>
		</p>';
		//daftar pribadi
		$qpri = mysql_query("SELECT * FROM m_pribadi ".
					"ORDER BY pribadi ASC");
		$rpri = mysql_fetch_assoc($qpri);
		$tpri = mysql_num_rows($qpri);

		echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="5"><strong>No.</strong></td>
		<td><strong>Nama Kepribadian</strong></td>
		<td width="50"><strong>Predikat</strong></td>
		<td width="250"><strong>Keterangan</strong></td>
		</tr>';

		do
			{
			//nilai
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

			$nomxz = $nomxz + 1;
			$pri_kd = nosql($rpri['kd']);
			$pri_pribadi = balikin($rpri['pribadi']);

			//pribadinya...
			$qprix = mysql_query("SELECT * FROM siswa_pribadi ".
						"WHERE kd_siswa_kelas = '$skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_pribadi = '$pri_kd'");
			$rprix = mysql_fetch_assoc($qprix);
			$tprix = mysql_num_rows($qprix);
			$prix_predikat = nosql($rprix['predikat']);
			$prix_ket = balikin($rprix['ket']);

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input name="prikd'.$nomxz.'" type="hidden" value="'.$pri_kd.'">
			'.$nomxz.'.
			</td>
			<td>'.$pri_pribadi.'</td>
			<td>
			<select name="predikat_pribadi'.$nomxz.'">
			<option value="'.$prix_predikat.'" selected>'.$prix_predikat.'</option>
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
			<option value="K">K</option>
			</select>
			</td>
			<td>
			<input name="ket_pribadi'.$nomxz.'" type="text" size="50" value="'.$prix_ket.'">
			</td>
			</tr>';
			}
		while ($rpri = mysql_fetch_assoc($qpri));

		echo '</table>

		<p>
		<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
		<INPUT type="hidden" name="kelkd" value="'.$kelkd.'">
		<INPUT type="hidden" name="rukd" value="'.$rukd.'">
		<INPUT type="hidden" name="smtkd" value="'.$smtkd.'">
		<INPUT type="hidden" name="skkd" value="'.$skkd.'">
		<INPUT type="hidden" name="swkd" value="'.$swkd.'">
		<INPUT type="submit" name="btnSMP" value="SIMPAN">
		<INPUT type="submit" name="btnBTL" value="BATAL">
		</p>';
		}
	else
		{
		//jika import
		if ($s == "import")
			{
			echo '<p>
			Silahkan Masukkan File yang akan Di-Import :
			<br>
			<input name="filex_xls" type="file" size="30">
			<br>
			<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
			<input name="kelkd" type="hidden" value="'.$kelkd.'">
			<input name="rukd" type="hidden" value="'.$rukd.'">
			<input name="smtkd" type="hidden" value="'.$smtkd.'">
			<input name="s" type="hidden" value="'.$s.'">
			<input name="btnBTL" type="submit" value="BATAL">
			<input name="btnIM2" type="submit" value="IMPORT >>">
			</p>
			<p>
			<strong><em>NB. Pastikan Semua Kolom Data yang akan di-import, Telah Sesuai dengan Data Master.</em></strong>
			</p>';
			}
		else
			{
			//query
			$p = new Pager();
			$start = $p->findStart($limit);

			$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, ".
					"siswa_kelas.*, siswa_kelas.kd AS skkd ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND siswa_kelas.kd_ruang = '$rukd' ".
					"ORDER BY round(nis) ASC";
			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);


			//nek ada
			if ($count != 0)
				{
				echo '<br>
				<INPUT type="hidden" name="tapelkd" value="'.$tapelkd.'">
				<INPUT type="hidden" name="kelkd" value="'.$kelkd.'">
				<INPUT type="hidden" name="rukd" value="'.$rukd.'">
				<INPUT type="hidden" name="smtkd" value="'.$smtkd.'">
				<input name="btnIM" type="submit" value="IMPORT">
				<input name="btnEX" type="submit" value="EXPORT">
				<table width="700" border="1" cellpadding="3" cellspacing="0">
				<tr bgcolor="'.$warnaheader.'">
				<td width="1">&nbsp</td>
				<td width="50"><strong>NIS</strong></td>
				<td width="150"><strong>Nama</strong></td>
				<td><strong>Ket.</strong></td>
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

					$i_nomer = $i_nomer + 1;
					$i_skkd = nosql($data['skkd']);
					$i_mskd = nosql($data['mskd']);
					$i_nis = nosql($data['nis']);
					$i_nama = balikin($data['nama']);



					echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
					echo '<td valign="top">
					<a href="'.$filenya.'?s=edit&tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&smtkd='.$smtkd.'&skkd='.$i_skkd.'&swkd='.$i_mskd.'">
					<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
					</a>
					</td>
					<td valign="top">
					<input name="kd'.$i_nomer.'" type="hidden" value="'.$i_mskd.'">
					'.$i_nis.'
					</td>
					<td valign="top">
					'.$i_nama.'
					</td>
					<td valign="top">';
					//daftar pribadi
					$qpri = mysql_query("SELECT * FROM m_pribadi ".
								"ORDER BY pribadi ASC");
					$rpri = mysql_fetch_assoc($qpri);
					$tpri = mysql_num_rows($qpri);

					echo '<table border="0" cellspacing="0" cellpadding="3">';

					do
						{
						//nilai
						$nomxz = $nomxz + 1;
						$pri_kd = nosql($rpri['kd']);
						$pri_pribadi = balikin($rpri['pribadi']);

						//pribadinya...
						$qprix = mysql_query("SELECT * FROM siswa_pribadi ".
									"WHERE kd_siswa_kelas = '$i_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_pribadi = '$pri_kd'");
						$rprix = mysql_fetch_assoc($qprix);
						$tprix = mysql_num_rows($qprix);
						$prix_predikat = nosql($rprix['predikat']);
						$prix_ket = balikin($rprix['ket']);

						echo '<tr>
						<td>'.$pri_pribadi.'</td>
						<td>: [<strong>'.$prix_predikat.'</strong>].</td>
						<td><em>'.$prix_ket.'</em></td>
						</tr>';
						}
					while ($rpri = mysql_fetch_assoc($qpri));

					echo '</table>
					</td>
					</tr>';
					}
				while ($data = mysql_fetch_assoc($result));

				echo '</table>
				<table width="700" border="0" cellspacing="0" cellpadding="3">
				<tr>
				<td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
				</tr>
				</table>';
				}
			else
				{
				echo '<p>
				<strong>
				<font color="red">
				TIDAK ADA DATA.
				</font>
				</strong>
				</p>';
				}
			}
		}
	}

echo '</form>
<br>
<br>
<br>';
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