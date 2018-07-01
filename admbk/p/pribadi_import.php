<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admbp.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "pribadi_import.php";
$judul = "Import Kepribadian Siswa";
$judulku = "[$bk_session : $nip15_session.$nm15_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$rukd = nosql($_REQUEST['rukd']);
$smtkd = nosql($_REQUEST['smtkd']);





//PROSES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//fungsi baca file excel
function parseExcel($excel_file_name_with_path)
	{
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);

	$colname=array('NIS', 'NAMA', 'AKHLAK', 'AKHLAK_KET', 'KEPRIBADIAN', 'KEPRIBADIAN_KET', );


	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++)
		{
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++)
			{
			$product[$i-1][$j-1]=$data->sheets[0]['cells'][$i][$j];
			$product[$i-1][$colname[$j-1]]=$data->sheets[0]['cells'][$i][$j];
			}
		}

	return $product;
	}





//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$rukd = nosql($_POST['rukd']);
	$smtkd = nosql($_POST['smtkd']);
	$filex_namex = $_POST['filex_namex'];


	//hapus file
	$path1 = "../../filebox/excel/$filex_namex";
	unlink ($path1);

	//re-direct
	$ke = "pribadi.php?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}





//import sekarang
if ($_POST['btnIMx'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$rukd = nosql($_POST['rukd']);
	$smtkd = nosql($_POST['smtkd']);
	$filex_namex = $_POST['filex_namex'];

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "pribadi.php?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .jpg
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox/excel";

			//file-nya...
			$uploadfile = "$path1/$filex_namex";

			//require
			require_once '../../inc/class/excel/excel.php';

			$prod=parseExcel($uploadfile);
			$cprod = count($prod);
			for($i=1;$i<$cprod;$i++)
				{
				$i_xyz = md5("$x$i");
				$i_nis = addslashes($prod[$i][0]);
				$i_nama = addslashes($prod[$i][1]);
				$i_akhlak = addslashes($prod[$i][2]);
				$i_akhlak_ket = addslashes($prod[$i][3]);
				$i_kepribadian = addslashes($prod[$i][4]);
				$i_kepribadian_ket = addslashes($prod[$i][5]);


				//cek siswa
				$qccx = mysql_query("SELECT m_siswa.*, siswa_kelas.*, ".
							"siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND siswa_kelas.kd_ruang = '$rukd' ".
							"AND m_siswa.nis = '$i_nis'");
				$rccx = mysql_fetch_assoc($qccx);
				$tccx = mysql_num_rows($qccx);
				$ccx_skkd = nosql($rccx['skkd']);


				//cek pribadi
				$qcc = mysql_query("SELECT m_siswa.*, siswa_pribadi.*, siswa_kelas.*, ".
							"siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_pribadi, siswa_kelas ".
							"WHERE siswa_pribadi.kd_siswa_kelas = siswa_kelas.kd ".
							"AND siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND siswa_kelas.kd_ruang = '$rukd' ".
							"AND m_siswa.nis = '$i_nis' ".
							"AND siswa_pribadi.kd_smt = '$smtkd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_skkd = nosql($rcc['skkd']);


				//jika ada, update
				if ($tcc != 0)
					{
					//daftar pribadi
					$qpri = mysql_query("SELECT * FROM m_pribadi ".
								"ORDER BY pribadi ASC");
					$rpri = mysql_fetch_assoc($qpri);
					$tpri = mysql_num_rows($qpri);

					do
						{
						$pri_kd = nosql($rpri['kd']);
						$pri_pribadi = balikin($rpri['pribadi']);

						//jika akhlak
						if ($pri_pribadi == "Akhlak")
							{
							//pribadi siswa
							mysql_query("UPDATE siswa_pribadi SET predikat = '$i_akhlak', ".
									"ket = '$i_akhlak_ket' ".
									"WHERE kd_siswa_kelas = '$cc_skkd' ".
									"AND kd_pribadi = '$pri_kd' ".
									"AND kd_smt = '$smtkd'");
							}


						//jika kepribadian
						else if ($pri_pribadi == "Kepribadian")
							{
							//pribadi siswa
							mysql_query("UPDATE siswa_pribadi SET predikat = '$i_kepribadian', ".
									"ket = '$i_kepribadian_ket' ".
									"WHERE kd_siswa_kelas = '$cc_skkd' ".
									"AND kd_pribadi = '$pri_kd' ".
									"AND kd_smt = '$smtkd'");
							}
						}
					while ($rpri = mysql_fetch_assoc($qpri));
					}

				//jika blm ada, insert
				else
					{
					//daftar pribadi
					$qpri = mysql_query("SELECT * FROM m_pribadi ".
								"ORDER BY pribadi ASC");
					$rpri = mysql_fetch_assoc($qpri);
					$tpri = mysql_num_rows($qpri);

					do
						{
						$pri_kd = nosql($rpri['kd']);
						$pri_pribadi = balikin($rpri['pribadi']);

						//jika akhlak
						if ($pri_pribadi == "Akhlak")
							{
							//pribadi siswa
							mysql_query("INSERT INTO siswa_pribadi(kd, kd_siswa_kelas, kd_smt, ".
									"kd_pribadi, predikat, ket) VALUES ".
									"('$i_xyz', '$ccx_skkd', '$smtkd', ".
									"'$pri_kd', '$i_akhlak', '$i_akhlak_ket')");
							}

						//jika kepribadian
						else if ($pri_pribadi == "Kepribadian")
							{
							//pribadi siswa
							mysql_query("INSERT INTO siswa_pribadi(kd, kd_siswa_kelas, kd_smt, ".
									"kd_pribadi, predikat, ket) VALUES ".
									"('$i_xyz', '$ccx_skkd', '$smtkd', ".
									"'$pri_kd', '$i_kepribadian', '$i_kepribadian_ket')");
							}

						}
					while ($rpri = mysql_fetch_assoc($qpri));
					}
				}


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex";
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "pribadi.php?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "pribadi.php?tapelkd=$tapelkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admbp.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>,

Kelas : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>,



Ruang : ';
//ruang
$qstx = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$rukd'");
$rowstx = mysql_fetch_assoc($qstx);
$ruang = nosql($rowstx['ruang']);

echo '<strong>'.$ruang.'</strong>,


Semester : ';

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
			"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<strong>'.$stx_smt.'</strong>
</td>
</tr>
</table>';


$filex_namex = $_REQUEST['filex_namex'];

//nilai
$path1 = "../../filebox/excel/$filex_namex";

//file-nya...
$uploadfile = $path1;


echo '<p>
Nama File Yang di-Import : <strong>'.$filex_namex.'</strong>
<br>
<input name="filex_namex" type="hidden" value="'.$filex_namex.'">
<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="rukd" type="hidden" value="'.$rukd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="btnBTL" type="submit" value="<< BATAL">
<input name="btnIMx" type="submit" value="IMPORT Sekarang>>">
</p>
</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>