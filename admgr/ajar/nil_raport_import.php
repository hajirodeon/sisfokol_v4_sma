<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nil_raport_import.php";
$judul = "Import Nilai";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$progkd = nosql($_REQUEST['progkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$mapelkd = nosql($_REQUEST['mapelkd']);
$rukd = nosql($_REQUEST['rukd']);




//PROSES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//fungsi baca file excel
function parseExcel($excel_file_name_with_path)
	{
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);


	$colname=array('NO', 'NIS', 'NAMA', 'NIL_UH1', 'NIL_UH2', 'NIL_UH3', 'NIL_UH4',
			'NIL_UH5', 'NIL_UH6', 'NIL_UH7', 'NIL_UH8', 'NIL_UH9', 'NIL_UH10',
			'R_UH', 'TUGAS1', 'TUGAS2', 'TUGAS3', 'TUGAS4', 'TUGAS5', 'R_TUGAS',
			'UTS', 'UAS', 'PRAKTEK1', 'PRAKTEK2', 'PRAKTEK3', 'PRAKTEK4',
			'PRAKTEK5', 'U_PRAKTEK', 'R_PRAKTEK', 'SIKAP', 'KOMENTAR',
			'KD_PROP', 'KD_RAYON', 'KD_SEK', 'TAPEL', 'NO_PES', 'NM_PES', );

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
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$mapelkd = nosql($_POST['mapelkd']);
	$rukd = nosql($_POST['rukd']);
	$filex_namex = $_POST['filex_namex'];


	//hapus file
	$path1 = "../../filebox/excel/$filex_namex";
	chmod($path1,0777);
	unlink ($path1);

	//re-direct
	$ke = "nil_raport.php?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&mapelkd=$mapelkd&rukd=$rukd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}





//import sekarang
if ($_POST['btnIMx'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$progkd = nosql($_POST['progkd']);
	$kelkd = nosql($_POST['kelkd']);
	$mapelkd = nosql($_POST['mapelkd']);
	$rukd = nosql($_POST['rukd']);
	$filex_namex = $_POST['filex_namex'];

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "nil_raport.php?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&mapelkd=$mapelkd&rukd=$rukd&smtkd=$smtkd&s=import";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi .xls
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
				$i_no = addslashes($prod[$i][0]);
				$i_nis = addslashes($prod[$i][1]);
				$i_nama = addslashes($prod[$i][2]);


				$i_uh1 = addslashes($prod[$i][3]);
				$i_uh2 = addslashes($prod[$i][4]);
				$i_uh3 = addslashes($prod[$i][5]);
				$i_uh4 = addslashes($prod[$i][6]);
				$i_uh5 = addslashes($prod[$i][7]);
				$i_uh6 = addslashes($prod[$i][8]);
				$i_uh7 = addslashes($prod[$i][9]);
				$i_uh8 = addslashes($prod[$i][10]);
				$i_uh9 = addslashes($prod[$i][11]);
				$i_uh10 = addslashes($prod[$i][12]);
				$i_r_uh = addslashes($prod[$i][13]);

				$i_tugas1 = addslashes($prod[$i][14]);
				$i_tugas2 = addslashes($prod[$i][15]);
				$i_tugas3 = addslashes($prod[$i][16]);
				$i_tugas4 = addslashes($prod[$i][17]);
				$i_tugas5 = addslashes($prod[$i][18]);
				$i_r_tugas = addslashes($prod[$i][19]);

				$i_uts = addslashes($prod[$i][20]);
				$i_uas = addslashes($prod[$i][21]);

				$i_praktek1 = addslashes($prod[$i][22]);
				$i_praktek2 = addslashes($prod[$i][23]);
				$i_praktek3 = addslashes($prod[$i][24]);
				$i_praktek4 = addslashes($prod[$i][25]);
				$i_praktek5 = addslashes($prod[$i][26]);
				$i_u_praktek = addslashes($prod[$i][27]);
				$i_r_praktek = addslashes($prod[$i][28]);
				$i_sikap = addslashes($prod[$i][29]);
				$i_komentar = addslashes($prod[$i][30]);





				//ke mysql
				$qcc = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"AND siswa_kelas.kd_program = '$progkd' ".
							"AND siswa_kelas.kd_ruang = '$rukd' ".
							"AND m_siswa.nis = '$i_nis'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_skkd = nosql($rcc['skkd']);



				//NIL_NH1 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH1";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh1;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}






				//NIL_NH2 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH2";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh2;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}







				//NIL_NH3 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH3";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh3;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}




				//NIL_NH4 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH4";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh4;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}





				//NIL_NH5 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH5";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh5;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}







				//NIL_NH6 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH6";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh6;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}





				//NIL_NH7 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH7";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh7;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}






				//NIL_NH8 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH8";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh8;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}





				//NIL_NH9 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH9";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh9;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}






				//NIL_NH10 ///////////////////////////////////////////////////////
				//nilai
				$xnh = "NH10";
				$xnh1 = $xnh;
				$xnh2 = $xnh;
				$xnhxx = $i_uh10;


				//nek se-digit
				if (strlen($xnhxx) == 1)
					{
					$xnhxx = "0$xnhxx";
					}

				//nek lebih dari 100
				if ($xnhxx > 100)
					{
					$xnhxx = "00";
					}


				//random
				$xxhr = rand(1,1000);
				$xxh = md5("$x$i$xxhr");

				//cek
				$qc = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rc = mysql_fetch_assoc($qc);
				$tc = mysql_num_rows($qc);


				//update
				if ($tc != 0)
					{
					mysql_query("UPDATE siswa_nh SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");

					mysql_query("UPDATE siswa_nh_rata SET nilai = '$xnhxx' ".
							"WHERE kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2' ".
							"AND kd_siswa_kelas = '$cc_skkd'");
					}
				else //insert
					{
					mysql_query("INSERT INTO siswa_nh(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");

					mysql_query("INSERT INTO siswa_nh_rata(kd, kd_siswa_kelas, kd_smt, ".
							"kd_mapel, nilkd, nilai) VALUES ".
							"('$xxh', '$cc_skkd', '$smtkd', ".
							"'$mapelkd', '$xnh2', '$xnhxx')");
					}







				//jika ada yang null
				if ((empty($i_praktek5)) AND ((!empty($i_praktek4))))
					{
					//total praktek
					$total_praktek = round($i_praktek1+$i_praktek2+$i_praktek3+$i_praktek4,1);
					$i_praktek = round($total_praktek/4,1);
					$i_praktekx = round($i_u_praktek,1);
					$i_praktekx2 = round(($i_praktek + $i_praktekx)/2,1);
					}
				else if ((empty($i_praktek4)) AND ((!empty($i_praktek3))))
					{
					//total praktek
					$total_praktek = round($i_praktek1+$i_praktek2+$i_praktek3,1);
					$i_praktek = round($total_praktek/3,1);
					$i_praktekx = round($i_u_praktek,1);
					$i_praktekx2 = round(($i_praktek + $i_praktekx)/2,1);
					}
				else if ((empty($i_praktek3)) AND ((!empty($i_praktek2))))
					{
					//total praktek
					$total_praktek = round($i_praktek1+$i_praktek2,1);
					$i_praktek = round($total_praktek/2,1);
					$i_praktekx = round($i_u_praktek,1);
					$i_praktekx2 = round(($i_praktek + $i_praktekx)/2,1);
					}
				else if ((empty($i_praktek2)) AND ((!empty($i_praktek1))))
					{
					//total praktek
					$total_praktek = round($i_praktek1,1);
					$i_praktek = round($total_praktek,1);
					$i_praktekx = round($i_u_praktek,1);
					$i_praktekx2 = round(($i_praktek + $i_praktekx)/2,1);
					}
				else
					{
					//total praktek
					$total_praktek = round($i_praktek1+$i_praktek2+$i_praktek3+$i_praktek4+$i_praktek5,1);
					$i_praktek = round($total_praktek/5,1);
					$i_praktekx = round($i_u_praktek,1);
					$i_praktekx2 = round(($i_praktek + $i_praktekx)/2,1);
					}




				//entry...
				$qcc1 = mysql_query("SELECT * FROM siswa_nilai_mapel ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd'");
				$rcc1 = mysql_fetch_assoc($qcc1);
				$tcc1 = mysql_num_rows($qcc1);


				//jika ada, update
				if ($tcc1 != 0)
					{
					mysql_query("UPDATE siswa_nilai_mapel SET tugas1 = '$i_tugas1', ".
							"tugas2 = '$i_tugas2', ".
							"tugas3 = '$i_tugas3', ".
							"tugas4 = '$i_tugas4', ".
							"tugas5 = '$i_tugas5', ".
							"tugas = '$i_r_tugas', ".
							"nh = '$i_r_uh', ".
							"uts = '$i_uts', ".
							"uas = '$i_uas', ".
							"praktek1 = '$i_praktek1', ".
							"praktek2 = '$i_praktek2', ".
							"praktek3 = '$i_praktek3', ".
							"praktek4 = '$i_praktek4', ".
							"praktek5 = '$i_praktek5', ".
							"praktek_ujian = '$i_u_praktek', ".
							"praktek = '$i_praktekx2', ".
							"sikap = '$i_sikap', ".
							"ket = '$i_komentar', ".
							"total_kognitif = '$i_rata' ".
							"WHERE kd_siswa_kelas = '$cc_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd'");
					}

				//jika blm ada, insert
				else
					{
					mysql_query("INSERT INTO siswa_nilai_mapel(kd, kd_siswa_kelas, kd_smt, kd_mapel, ".
							"tugas1, tugas2, tugas3, tugas4, tugas5, tugas, ".
							"nh, uts, uas, praktek1, praktek2, praktek3, praktek4, praktek5, ".
							"praktek_ujian, praktek, sikap, ket) VALUES ".
							"('$i_xyz', '$cc_skkd', '$smtkd', '$mapelkd', ".
							"'$i_tugas1', '$i_tugas2', '$i_tugas3', '$i_tugas4', '$i_tugas5', '$i_r_tugas', ".
							"'$i_r_uh', '$i_uts', '$i_uas', '$i_praktek1', '$i_praktek2', '$i_praktek3', '$i_praktek4', '$i_praktek5', ".
							"'$i_u_praktek', '$i_praktekx2', '$i_sikap', '$i_komentar')");
					}
				}


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex";
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "nil_raport.php?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&mapelkd=$mapelkd&rukd=$rukd&smtkd=$smtkd";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&mapelkd=$mapelkd&rukd=$rukd&smtkd=$smtkd&mapelkd=$mapelkd&s=import";
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
require("../../inc/menu/admgr.php");
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



Program : ';
//terpilih
$qprgx = mysql_query("SELECT * FROM m_program ".
			"WHERE kd = '$progkd'");
$rowprgx = mysql_fetch_assoc($qprgx);
$prgx_kd = nosql($rowprgx['kd']);
$prgx_prog = balikin($rowprgx['program']);

echo '<b>'.$prgx_prog.'</b>,



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
//terpilih
$qrux = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$rukd'");
$rowrux = mysql_fetch_assoc($qrux);
$ruxkd = nosql($rowrux['kd']);
$ruxruang = balikin($rowrux['ruang']);

echo '<strong>'.$ruxruang.'</strong>,

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
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mata Pelajaran : ';
//terpilih
$qstdx = mysql_query("SELECT * FROM m_mapel ".
			"WHERE kd = '$mapelkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_pel = balikin($rowstdx['pel']);


echo '<strong>'.$stdx_pel.'</strong>
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
<input name="rukd" type="hidden" value="'.$rukd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="mapelkd" type="hidden" value="'.$mapelkd.'">
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