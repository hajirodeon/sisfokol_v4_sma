<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admgr.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nil_raport.php";
$judul = "Nilai Raport";
$judulku = "[$guru_session : $nip1_session.$nm1_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$progkd = nosql($_REQUEST['progkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$rukd = nosql($_REQUEST['rukd']);
$mapelkd = nosql($_REQUEST['mapelkd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&progkd=$progkd&smtkd=$smtkd&kelkd=$kelkd&".
			"rukd=$rukd&mapelkd=$mapelkd&page=$page";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$progkd = nosql($_POST['progkd']);
	$kelkd = nosql($_POST['kelkd']);
	$mapelkd = nosql($_POST['mapelkd']);
	$rukd = nosql($_POST['rukd']);


	//cek mapel
	if (empty($mapelkd))
		{
		//re-direct
		$pesan = "Mata Pelajaran Belum Dipilih. Harap Diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//re-direct
		$ke = "nil_raport.php?tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&rukd=$rukd&smtkd=$smtkd&mapelkd=$mapelkd&s=import";
		xloc($ke);
		exit();
		}
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$progkd = nosql($_POST['progkd']);
	$kelkd = nosql($_POST['kelkd']);
	$mapelkd = nosql($_POST['mapelkd']);
	$rukd = nosql($_POST['rukd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&mapelkd=$mapelkd&s=import";
		pekem($pesan,$ke);
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox/excel";
			chmod($path1,0777);

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex");

			//re-direct
			$ke = "nil_raport_import.php?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&mapelkd=$mapelkd&filex_namex=$filex_namex";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&mapelkd=$mapelkd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$progkd = nosql($_POST['progkd']);
	$kelkd = nosql($_POST['kelkd']);
	$mapelkd = nosql($_POST['mapelkd']);
	$rukd = nosql($_POST['rukd']);


	//cek mapel
	if (empty($mapelkd))
		{
		//re-direct
		$pesan = "Mata Pelajaran Belum Dipilih. Harap Diperhatikan...!!";
		$ke = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//require
		require('../../inc/class/excel/OLEwriter.php');
		require('../../inc/class/excel/BIFFwriter.php');
		require('../../inc/class/excel/worksheet.php');
		require('../../inc/class/excel/workbook.php');


		//mapel e...
		$qstdx = mysql_query("SELECT * FROM m_mapel ".
					"WHERE kd = '$mapelkd'");
		$rowstdx = mysql_fetch_assoc($qstdx);
		$stdx_kd = nosql($rowstdx['kd']);
		$stdx_jnskd = nosql($rowstdx['kd_jenis']);
		$stdx_pel = balikin($rowstdx['pel']);
		$stdx_pel2 = strip($stdx_pel);


		//KKM
		$qdt = mysql_query("SELECT * FROM m_mapel_kelas ".
					"WHERE kd_program = '$progkd' ".
					"AND kd_kelas = '$kelkd' ".
					"AND kd_mapel = '$mapelkd'");
		$rdt = mysql_fetch_assoc($qdt);
		$dt_kkm = nosql($rdt['kkm']);




		//nama file e...
		$i_filename = "Nilai_$stdx_pel2.xls";
		$i_judul = "Nilai";


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
		$worksheet1->set_column(0,0,5);
		$worksheet1->set_column(0,1,10);
		$worksheet1->set_column(0,2,30);
		$worksheet1->set_column(0,3,10);
		$worksheet1->set_column(0,4,10);
		$worksheet1->set_column(0,5,10);
		$worksheet1->set_column(0,6,10);
		$worksheet1->set_column(0,7,10);
		$worksheet1->set_column(0,8,10);
		$worksheet1->set_column(0,9,10);
		$worksheet1->set_column(0,10,10);
		$worksheet1->set_column(0,11,10);
		$worksheet1->set_column(0,12,10);
		$worksheet1->set_column(0,13,10);
		$worksheet1->set_column(0,14,10);
		$worksheet1->set_column(0,15,10);
		$worksheet1->set_column(0,16,10);
		$worksheet1->set_column(0,17,10);
		$worksheet1->set_column(0,18,10);
		$worksheet1->set_column(0,19,10);
		$worksheet1->set_column(0,20,10);
		$worksheet1->set_column(0,21,10);
		$worksheet1->set_column(0,22,10);
		$worksheet1->set_column(0,23,10);
		$worksheet1->set_column(0,24,10);
		$worksheet1->set_column(0,25,10);
		$worksheet1->set_column(0,26,10);
		$worksheet1->set_column(0,27,10);
		$worksheet1->set_column(0,28,10);
		$worksheet1->set_column(0,29,10);
		$worksheet1->set_column(0,30,10);
		$worksheet1->write_string(0,0,"NO");
		$worksheet1->write_string(0,1,"NIS");
		$worksheet1->write_string(0,2,"NAMA");
		$worksheet1->write_string(0,3,"NIL_UH1");
		$worksheet1->write_string(0,4,"NIL_UH2");
		$worksheet1->write_string(0,5,"NIL_UH3");
		$worksheet1->write_string(0,6,"NIL_UH4");
		$worksheet1->write_string(0,7,"NIL_UH5");
		$worksheet1->write_string(0,8,"NIL_UH6");
		$worksheet1->write_string(0,9,"NIL_UH7");
		$worksheet1->write_string(0,10,"NIL_UH8");
		$worksheet1->write_string(0,11,"NIL_UH9");
		$worksheet1->write_string(0,12,"NIL_UH10");
		$worksheet1->write_string(0,13,"R_UH");
		$worksheet1->write_string(0,14,"TUGAS1");
		$worksheet1->write_string(0,15,"TUGAS2");
		$worksheet1->write_string(0,16,"TUGAS3");
		$worksheet1->write_string(0,17,"TUGAS4");
		$worksheet1->write_string(0,18,"TUGAS5");
		$worksheet1->write_string(0,19,"R_TUGAS");
		$worksheet1->write_string(0,20,"UTS");
		$worksheet1->write_string(0,21,"UAS");
		$worksheet1->write_string(0,22,"PRAKTEK1");
		$worksheet1->write_string(0,23,"PRAKTEK2");
		$worksheet1->write_string(0,24,"PRAKTEK3");
		$worksheet1->write_string(0,25,"PRAKTEK4");
		$worksheet1->write_string(0,26,"PRAKTEK5");
		$worksheet1->write_string(0,27,"U_PRAKTEK");
		$worksheet1->write_string(0,28,"R_PRAKTEK");
		$worksheet1->write_string(0,29,"SIKAP");
		$worksheet1->write_string(0,30,"KOMENTAR");



		//data
		$qdt = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND siswa_kelas.kd_program = '$progkd' ".
					"AND siswa_kelas.kd_ruang = '$rukd' ".
					"ORDER BY round(siswa_kelas.no_absen) ASC");
		$rdt = mysql_fetch_assoc($qdt);

		do
		  	{
			//nilai
			$dt_nox = $dt_nox + 1;
			$dt_skkd = nosql($rdt['skkd']);
			$dt_no = nosql($rdt['no_absen']);
			$dt_nis = nosql($rdt['nis']);
			$dt_nama = balikin($rdt['nama']);


			//nilainya
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_mapel ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_mapel = '$mapelkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_tugas1 = nosql($rxpel['tugas1']);
			$xpel_tugas2 = nosql($rxpel['tugas2']);
			$xpel_tugas3 = nosql($rxpel['tugas3']);
			$xpel_tugas4 = nosql($rxpel['tugas4']);
			$xpel_tugas5 = nosql($rxpel['tugas5']);
			$xpel_tugas = nosql($rxpel['tugas']);
			$xpel_nh = nosql($rxpel['nh']);
			$xpel_uts = nosql($rxpel['uts']);
			$xpel_uas = nosql($rxpel['uas']);
			$xpel_rata = nosql($rxpel['total_kognitif']);
			$xpel_praktek = nosql($rxpel['praktek']);
			$xpel_sikap = nosql($rxpel['sikap']);
			$xpel_ket = balikin($rxpel['ket']);
			$xpel_praktek1 = nosql($rxpel['praktek1']);
			$xpel_praktek2 = nosql($rxpel['praktek2']);
			$xpel_praktek3 = nosql($rxpel['praktek3']);
			$xpel_praktek4 = nosql($rxpel['praktek4']);
			$xpel_praktek5 = nosql($rxpel['praktek5']);
			$xpel_praktek_ujian = nosql($rxpel['praktek_ujian']);
			$xpel_praktek = nosql($rxpel['praktek']);
			$xpel_praktek_total = round($xpel_praktek1 + $xpel_praktek2 + $xpel_praktek3 + $xpel_praktek4 + $xpel_praktek5 + $xpel_praktek_ujian,1);



/*
			//rata - rata NH
			$qsni = mysql_query("SELECT AVG(nilai) AS rata ".
						"FROM siswa_nh_rata ".
						"WHERE kd_siswa_kelas = '$dt_skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_mapel = '$mapelkd' ".
						"AND nilai <> '00'");
			$rsni = mysql_fetch_assoc($qsni);
			$tsni = mysql_num_rows($qsni);
			$sni_rata = round(nosql($rsni['rata']),1);
*/
			$sni_rata = $xpel_nh;


			//total
			$xpel_total = round($sni_rata + $xpel_tugas + $xpel_uts + $xpel_uas,1);

			//require rumus
			require("../../inc/rumus_kognitif.php");



			//ciptakan
			$worksheet1->write_string($dt_nox,0,$dt_no);
			$worksheet1->write_string($dt_nox,1,$dt_nis);
			$worksheet1->write_string($dt_nox,2,$dt_nama);




			//looping jml. NH
			for ($i=1;$i<=10;$i++)
				{
				//nilai
				$nh = "NH";
				$xnh = "$nh$i";
				$xnh2 = "$nh$i";

				//query
				$qnil = mysql_query("SELECT * FROM siswa_nh ".
							"WHERE kd_siswa_kelas = '$dt_skkd' ".
							"AND kd_smt = '$smtkd' ".
							"AND kd_mapel = '$mapelkd' ".
							"AND left(nilkd,3) = '$xnh2'");
				$rnil = mysql_fetch_assoc($qnil);
				$tnil = mysql_num_rows($qnil);
				$nil_nh = nosql($rnil['nilai']);


				$worksheet1->write_string($dt_nox,2+$i,$nil_nh);
				}





			if ($xpel_rata < $dt_kkm)
				{
				$iket = "Belum Tercapai";
				}
			else if ($xpel_rata == $dt_kkm)
				{
				$iket = "Tercapai";
				}
			else if ($xpel_rata > $dt_kkm)
				{
				$iket = "Terlampaui";
				}




			$worksheet1->write_string($dt_nox,13,$sni_rata);
			$worksheet1->write_string($dt_nox,14,$xpel_tugas1);
			$worksheet1->write_string($dt_nox,15,$xpel_tugas2);
			$worksheet1->write_string($dt_nox,16,$xpel_tugas3);
			$worksheet1->write_string($dt_nox,17,$xpel_tugas4);
			$worksheet1->write_string($dt_nox,18,$xpel_tugas5);
			$worksheet1->write_string($dt_nox,19,$xpel_tugas);
			$worksheet1->write_string($dt_nox,20,$xpel_uts);
			$worksheet1->write_string($dt_nox,21,$xpel_uas);
			$worksheet1->write_string($dt_nox,22,$xpel_praktek1);
			$worksheet1->write_string($dt_nox,23,$xpel_praktek2);
			$worksheet1->write_string($dt_nox,24,$xpel_praktek3);
			$worksheet1->write_string($dt_nox,25,$xpel_praktek4);
			$worksheet1->write_string($dt_nox,26,$xpel_praktek5);
			$worksheet1->write_string($dt_nox,27,$xpel_praktek_ujian);
			$worksheet1->write_string($dt_nox,28,$xpel_praktek);
			$worksheet1->write_string($dt_nox,29,$xpel_sikap);
			$worksheet1->write_string($dt_nox,30,$iket);
			}
		while ($rdt = mysql_fetch_assoc($qdt));


		//close
		$workbook->close();


		//diskonek
		xclose($koneksi);


		//re-direct
		$ke = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&mapelkd=$mapelkd";
		$pesan = "Export Berhasil.";
		pekem($pesan,$ke);
		exit();
		}
	}





//entry nilai mapel
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$progkd = nosql($_POST['progkd']);
	$kelkd = nosql($_POST['kelkd']);
	$rukd = nosql($_POST['rukd']);
	$mapelkd = nosql($_POST['mapelkd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}



	//daftar siswa
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
			"FROM m_siswa, siswa_kelas ".
			"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
			"AND siswa_kelas.kd_tapel = '$tapelkd' ".
			"AND siswa_kelas.kd_kelas = '$kelkd' ".
			"AND siswa_kelas.kd_program = '$progkd' ".
			"AND siswa_kelas.kd_ruang = '$rukd' ".
			"ORDER BY round(m_siswa.nis) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	do
		{
		//nilai
		$i_nomer = $i_nomer + 1;
		$xyz = md5("$x$i_nomer");
		$i_skkd = nosql($data['skkd']);
		$i_nis = nosql($data['nis']);
		$i_nama = balikin($data['nama']);


		//ambil nilai
		$xnh1 = "nh";
		$xnh2 = "$i_skkd$xnh1";
		$xnhx = nosql($_POST["$xnh2"]);

		$xtugas1 = "tugas1";
		$xtugas11 = "$i_skkd$xtugas1";
		$xtugasx1 = nosql($_POST["$xtugas11"]);

		$xtugas2 = "tugas2";
		$xtugas22 = "$i_skkd$xtugas2";
		$xtugasx2 = nosql($_POST["$xtugas22"]);

		$xtugas3 = "tugas3";
		$xtugas33 = "$i_skkd$xtugas3";
		$xtugasx3 = nosql($_POST["$xtugas33"]);

		$xtugas4 = "tugas4";
		$xtugas44 = "$i_skkd$xtugas4";
		$xtugasx4 = nosql($_POST["$xtugas44"]);

		$xtugas5 = "tugas5";
		$xtugas55 = "$i_skkd$xtugas5";
		$xtugasx5 = nosql($_POST["$xtugas55"]);

		$xtugas6 = "tugas";
		$xtugas66 = "$i_skkd$xtugas6";
		$xtugasx6 = nosql($_POST["$xtugas66"]);


		$xuts1 = "uts";
		$xuts2 = "$i_skkd$xuts1";
		$xutsx = nosql($_POST["$xuts2"]);

		$xuas1 = "uas";
		$xuas2 = "$i_skkd$xuas1";
		$xuasx = nosql($_POST["$xuas2"]);

		$xtotal_rata1 = "total_rata";
		$xtotal_rata2 = "$i_skkd$xtotal_rata1";
		$xtotal_ratax = nosql($_POST["$xtotal_rata2"]);

		$xpraktek1 = "praktek";
		$xpraktek2 = "$i_skkd$xpraktek1";
		$xpraktekx = nosql($_POST["$xpraktek2"]);

		$xsikap1 = "sikap";
		$xsikap2 = "$i_skkd$xsikap1";
		$xsikapx = nosql($_POST["$xsikap2"]);



		//jika ada yang null
		if ((empty($xtugasx5)) AND ((!empty($xtugasx4))))
			{
			//total tugas
			$total_tugas = round($xtugasx1+$xtugasx2+$xtugasx3+$xtugasx4,1);
			$xtugasx4i = round($total_tugas/4,1);
			}
		else if ((empty($xtugasx4)) AND ((!empty($xtugasx3))))
			{
			//total tugas
			$total_tugas = round($xtugasx1+$xtugasx2+$xtugasx3,1);
			$xtugasx4i = round($total_tugas/3,1);
			}
		else if ((empty($xtugasx3)) AND ((!empty($xtugasx2))))
			{
			//total tugas
			$total_tugas = round($xtugasx1+$xtugasx2,1);
			$xtugasx4i = round($total_tugas/2,1);
			}
		else if ((empty($xtugasx2)) AND ((!empty($xtugasx1))))
			{
			//total tugas
			$total_tugas = round($xtugasx1,1);
			$xtugasx4i = round($total_tugas,1);
			}
		else
			{
			//total tugas
			$total_tugas = round($xtugasx1+$xtugasx2+$xtugasx3+$xtugasx4+$xtugasx5,1);
			$xtugasx4i = round($total_tugas/5,1);
			}





		//nil mapel
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_mapel ".
					"WHERE kd_siswa_kelas = '$i_skkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_mapel = '$mapelkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);

		//total
		$xpel_total = round($xnhx + $xtugasx4i + $xutsx + $xuasx,1);

		//require rumus
		require("../../inc/rumus_kognitif.php");




		//jika ada, update
		if ($txpel != 0)
			{
			mysql_query("UPDATE siswa_nilai_mapel SET nh = '$xnhx', ".
					"tugas1 = '$xtugasx1', ".
					"tugas2 = '$xtugasx2', ".
					"tugas3 = '$xtugasx3', ".
					"tugas4 = '$xtugasx4', ".
					"tugas5 = '$xtugasx5', ".
					"tugas = '$xtugasx4i', ".
					"uts = '$xutsx', ".
					"uas = '$xuasx', ".
					"praktek = '$xpraktekx', ".
					"sikap = '$xsikapx', ".
					"total_kognitif = '$xpel_rata' ".
					"WHERE kd_siswa_kelas = '$i_skkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_mapel = '$mapelkd'");
			}

		//jika blm ada, insert
		else
			{
			mysql_query("INSERT INTO siswa_nilai_mapel(kd, kd_siswa_kelas, kd_smt, kd_mapel, ".
					"nh, tugas1, tugas2, tugas3, tugas4, tugas5, tugas, ".
					"uts, uas, praktek, sikap, ".
					"total_kognitif) VALUES ".
					"('$xyz', '$i_skkd', '$smtkd', '$mapelkd', ".
					"'$xnhx', '$xtugasx1', '$xtugasx2', '$xtugasx3', '$xtugasx4', '$xtugasx5', '$xtugasx4i', ".
					"'$xutsx', '$xuasx', '$xpraktekx', '$xsikapx', ".
					"'$xpel_rata')");
			}
		}
	while ($data = mysql_fetch_assoc($result));




	//diskonek
	xclose($koneksi);



	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&mapelkd=$mapelkd&smtkd=$smtkd";
	xloc($ke);
	exit();
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//focus....focus...
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







//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/menu/admgr.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php" title="Daftar Mata Pelajaran">Daftar Mata Pelajaran</a>]</td>
</tr>
</table>

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

echo '<b>'.$tpx_thn1.'/'.$tpx_thn2.'</b>,



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

echo '<b>'.$btxkelas.'</b>,

Ruang : ';
//terpilih
$qrux = mysql_query("SELECT * FROM m_ruang ".
			"WHERE kd = '$rukd'");
$rowrux = mysql_fetch_assoc($qrux);
$ruxkd = nosql($rowrux['kd']);
$ruxruang = balikin($rowrux['ruang']);

echo '<b>'.$ruxruang.'</b>,

Mata Pelajaran : ';
//terpilih
$qstdx = mysql_query("SELECT * FROM m_mapel ".
			"WHERE kd = '$mapelkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_pel = balikin($rowstdx['pel']);



//KKM
$qdt = mysql_query("SELECT * FROM m_mapel_kelas ".
			"WHERE kd_program = '$progkd' ".
			"AND kd_kelas = '$kelkd' ".
			"AND kd_mapel = '$mapelkd'");
$rdt = mysql_fetch_assoc($qdt);
$dt_kkm = nosql($rdt['kkm']);


echo '<b>'.$stdx_pel.' [KKM:'.$dt_kkm.'].</b>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
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

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&progkd='.$progkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&mapelkd='.$mapelkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="rukd" type="hidden" value="'.$rukd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="mapelkd" type="hidden" value="'.$mapelkd.'">
<input name="btnIM" type="submit" value="IMPORT">
<input name="btnEX" type="submit" value="EXPORT">
</td>
</tr>
</table>';

//nek drg
if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
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
		<input name="s" type="hidden" value="'.$s.'">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnIM2" type="submit" value="IMPORT >>">
		</p>';
		}
	else
		{
		//tertinggi
		$qxpel1 = mysql_query("SELECT siswa_kelas.*, siswa_nilai_mapel.* ".
					"FROM siswa_kelas, siswa_nilai_mapel ".
					"WHERE siswa_nilai_mapel.kd_siswa_kelas = siswa_kelas.kd ".
					"AND siswa_nilai_mapel.kd_smt = '$smtkd' ".
					"AND siswa_nilai_mapel.kd_mapel = '$mapelkd' ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND siswa_kelas.kd_program = '$progkd' ".
					"AND siswa_kelas.kd_ruang = '$rukd' ".
					"ORDER BY round(siswa_nilai_mapel.total_kognitif) DESC");
		$rxpel1 = mysql_fetch_assoc($qxpel1);
		$xpel1_nh = round(nosql($rxpel1['total_kognitif']),2);



		//terendah
		$qxpel2 = mysql_query("SELECT siswa_kelas.*, siswa_nilai_mapel.* ".
					"FROM siswa_kelas, siswa_nilai_mapel ".
					"WHERE siswa_nilai_mapel.kd_siswa_kelas = siswa_kelas.kd ".
					"AND siswa_nilai_mapel.kd_smt = '$smtkd' ".
					"AND siswa_nilai_mapel.kd_mapel = '$mapelkd' ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND siswa_kelas.kd_program = '$progkd' ".
					"AND siswa_kelas.kd_ruang = '$rukd' ".
					"ORDER BY round(siswa_nilai_mapel.total_kognitif) ASC");
		$rxpel2 = mysql_fetch_assoc($qxpel2);
		$xpel2_nh = round(nosql($rxpel2['total_kognitif']),2);



		//rata2 kelas
		$qxpel3 = mysql_query("SELECT AVG(siswa_nilai_mapel.total_kognitif) AS rnh ".
					"FROM siswa_kelas, siswa_nilai_mapel ".
					"WHERE siswa_nilai_mapel.kd_siswa_kelas = siswa_kelas.kd ".
					"AND siswa_nilai_mapel.kd_smt = '$smtkd' ".
					"AND siswa_nilai_mapel.kd_mapel = '$mapelkd' ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"AND siswa_kelas.kd_program = '$progkd' ".
					"AND siswa_kelas.kd_ruang = '$rukd'");
		$rxpel3 = mysql_fetch_assoc($qxpel3);
		$xpel3_rnh = round(nosql($rxpel3['rnh']),2);




		//daftar siswa
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
				"FROM m_siswa, siswa_kelas ".
				"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
				"AND siswa_kelas.kd_tapel = '$tapelkd' ".
				"AND siswa_kelas.kd_kelas = '$kelkd' ".
				"AND siswa_kelas.kd_program = '$progkd' ".
				"AND siswa_kelas.kd_ruang = '$rukd' ".
				"ORDER BY round(siswa_kelas.no_absen) ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&progkd=$progkd&kelkd=$kelkd&rukd=$rukd&smtkd=$smtkd&mapelkd=$mapelkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);






		echo '<p>
		Nilai Tertinggi : <strong>'.$xpel1_nh.'</strong>,
		Nilai Terendah : <strong>'.$xpel2_nh.'</strong>,
		Rata-Rata Kelas : <strong>'.$xpel3_rnh.'</strong>,
		Warna Merah : <strong>Belum Tercapai</strong>,
		Warna Hijau : <strong>Tercapai</strong>,
		Warna Biru : <strong>Terlampaui</strong>.
		<table width="1100" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1"><strong>NO. ABSEN</strong></td>
		<td width="100"><strong>NIS</strong></td>
		<td><strong>NAMA</strong></td>
		<td width="50"><strong>NH</strong></td>
		<td width="50"><strong>TUGAS1</strong></td>
		<td width="50"><strong>TUGAS2</strong></td>
		<td width="50"><strong>TUGAS3</strong></td>
		<td width="50"><strong>TUGAS4</strong></td>
		<td width="50"><strong>TUGAS5</strong></td>
		<td width="50"><strong>R.TUGAS</strong></td>
		<td width="50"><strong>UTS</strong></td>
		<td width="50"><strong>UAS</strong></td>
		<td width="50"><strong>TOTAL</strong></td>
		<td width="50"><strong>RATA</strong></td>
		<td width="50"><strong>PRAKTEK</strong></td>
		<td width="50"><strong>SIKAP</strong></td>
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

			//nilainya
			$i_skkd = nosql($data['skkd']);
			$i_nis = nosql($data['nis']);
			$i_abs = nosql($data['no_absen']);
			$i_nama = balikin($data['nama']);


			//nilainya
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_mapel ".
						"WHERE kd_siswa_kelas = '$i_skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_mapel = '$mapelkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_tugas1 = nosql($rxpel['tugas1']);
			$xpel_tugas2 = nosql($rxpel['tugas2']);
			$xpel_tugas3 = nosql($rxpel['tugas3']);
			$xpel_tugas4 = nosql($rxpel['tugas4']);
			$xpel_tugas5 = nosql($rxpel['tugas5']);
			$xpel_tugas = nosql($rxpel['tugas']);
			$xpel_nh = nosql($rxpel['nh']);
			$xpel_uts = nosql($rxpel['uts']);
			$xpel_uas = nosql($rxpel['uas']);
			$xpel_rata = nosql($rxpel['total_kognitif']);
			$xpel_praktek = nosql($rxpel['praktek']);
			$xpel_sikap = nosql($rxpel['sikap']);



/*
			//rata - rata NH
			$qsni = mysql_query("SELECT AVG(nilai) AS rata ".
						"FROM siswa_nh_rata ".
						"WHERE kd_siswa_kelas = '$i_skkd' ".
						"AND kd_smt = '$smtkd' ".
						"AND kd_mapel = '$mapelkd' ".
						"AND nilai <> '00'");
			$rsni = mysql_fetch_assoc($qsni);
			$tsni = mysql_num_rows($qsni);
			$sni_rata = round(nosql($rsni['rata']),1);
*/
			$sni_rata = $xpel_nh;


			//total
			$xpel_total = round($sni_rata + $xpel_tugas + $xpel_uts + $xpel_uas,1);


			//require rumus
			require("../../inc/rumus_kognitif.php");




			//lakukan update nilai raport
			mysql_query("UPDATE siswa_nilai_mapel SET total_kognitif = '$xpel_rata' ".
					"WHERE kd_siswa_kelas = '$i_skkd' ".
					"AND kd_smt = '$smtkd' ".
					"AND kd_mapel = '$mapelkd'");





			if ($xpel_rata < $dt_kkm)
				{
//				$iket = "Belum Tercapai";
				$warna = "red";
				}
			else if ($xpel_rata == $dt_kkm)
				{
//				$iket = "Tercapai";
				$warna = "green";
				}
			else if ($xpel_rata > $dt_kkm)
				{
//				$iket = "Terlampaui";
				$warna = "blue";
				}



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			'.$i_abs.'
			</td>
			<td>
			'.$i_nis.'
			</td>
			<td>
			'.$i_nama.'
			</td>
			<td>
			<input name="'.$i_skkd.'nh" type="text" value="'.$sni_rata.'" size="5" maxlength="5" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="'.$i_skkd.'tugas1" type="text" value="'.$xpel_tugas1.'" size="5" maxlength="5" style="text-align:right">
			</td>
			<td>
			<input name="'.$i_skkd.'tugas2" type="text" value="'.$xpel_tugas2.'" size="5" maxlength="5" style="text-align:right">
			</td>
			<td>
			<input name="'.$i_skkd.'tugas3" type="text" value="'.$xpel_tugas3.'" size="5" maxlength="5" style="text-align:right">
			</td>
			<td>
			<input name="'.$i_skkd.'tugas4" type="text" value="'.$xpel_tugas4.'" size="5" maxlength="5" style="text-align:right">
			</td>
			<td>
			<input name="'.$i_skkd.'tugas5" type="text" value="'.$xpel_tugas5.'" size="5" maxlength="5" style="text-align:right">
			</td>
			<td>
			<input name="'.$i_skkd.'tugas" type="text" value="'.$xpel_tugas.'" size="5" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="'.$i_skkd.'uts" type="text" value="'.$xpel_uts.'" size="5" maxlength="5" style="text-align:right">
			</td>
			<td>
			<input name="'.$i_skkd.'uas" type="text" value="'.$xpel_uas.'" size="5" maxlength="5" style="text-align:right">
			</td>
			<td>
			<input name="'.$i_skkd.'total_nil" type="text" value="'.$xpel_total.'" size="4" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="'.$i_skkd.'rata" type="text" value="'.$xpel_rata.'" size="4" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="'.$i_skkd.'praktek" type="text" value="'.$xpel_praktek.'" size="5" maxlength="5" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<select name="'.$i_skkd.'sikap">
			<option value="'.$xpel_sikap.'" selected>'.$xpel_sikap.'</option>
			<option value="B">B</option>
			<option value="C">C</option>
			<option value="K">K</option>
			</select>
			</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));


		echo '</table>
		<table width="990" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="300">
		<input name="page" type="hidden" value="'.$page.'">
		<input name="btnSMP" type="submit" value="SIMPAN">
		<font color="red"><strong>'.$count.'</strong></font> Data. '.$pagelist.'
		</td>
		</tr>
		</table>
		</p>';
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