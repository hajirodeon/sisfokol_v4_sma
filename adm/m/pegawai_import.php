<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "pegawai_import.php";
$judul = "Import Pegawai";
$judulku = "[$adm_session] ==> $judul";
$juduly = $judul;




//PROSES //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batal
if ($_POST['btnBTL'])
	{
	//nilai
	$filex_namex = $_POST['filex_namex'];


	//hapus file
	$path1 = "../../filebox/excel/$filex_namex";
	chmod($path1,0777);
	unlink ($path1);

	//re-direct
	$ke = "pegawai.php";
	xloc($ke);
	exit();
	}





//import sekarang
if ($_POST['btnIMx'])
	{
	//nilai
	$filex_namex = $_POST['filex_namex'];

	//nek null
	if (empty($filex_namex))
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "pegawai.php?s=import";
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
			require_once '../../inc/class/excel/excel_reader2.php';


			// membaca file excel yang diupload
			$data = new Spreadsheet_Excel_Reader($uploadfile);

			// membaca jumlah baris dari data excel
			$baris = $data->rowcount($sheet_index=0);

			// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
			for ($i=2; $i<=$baris; $i++)
				{
				$i_xyz = md5("$x$i");
				$i_no_urut = $data->val($i, 1);
				$i_nama = $data->val($i, 2);

				$i_kelamin = $data->val($i, 3);
				$qkela = mysql_query("SELECT * FROM m_kelamin ".
										"WHERE kelamin = '$i_kelamin'");
				$rkela = mysql_fetch_assoc($qkela);
				$kela_kd = nosql($rkela['kd']);
				$i_kelamin = $kela_kd;

				$i_tmp_lahir = $data->val($i, 4);

				$i_tgl_lahir = $data->val($i, 5);
				$i_lahir_tgl = substr($i_tgl_lahir,0,2);
				$i_lahir_bln = substr($i_tgl_lahir,3,2);
				$i_lahir_thn = substr($i_tgl_lahir,-4);
				$i_tgl_lahir = "$i_lahir_thn:$i_lahir_bln:$i_lahir_tgl";

				$i_agama = $data->val($i, 6);
				$qagm = mysql_query("SELECT * FROM m_agama ".
										"WHERE agama = '$i_agama'");
				$ragm = mysql_fetch_assoc($qagm);
				$agm_kd = nosql($ragm['kd']);
				$i_agama = $agm_kd;

				$i_status = $data->val($i, 7);

				//jika kawin
				if ($i_status == "KAWIN")
					{
					$i_status = "true";
					}
				else
					{
					$i_status = "false";
					}


				$i_pasangan_nama = $data->val($i, 8);

				$i_pasangan_tgl_lahir = $data->val($i, 9);
				$i_pasangan_tgl = substr($i_pasangan_tgl_lahir,0,2);
				$i_pasangan_bln = substr($i_pasangan_tgl_lahir,3,2);
				$i_pasangan_thn = substr($i_pasangan_tgl_lahir,-4);
				$i_pasangan_tgl_lahir = "$i_pasangan_thn:$i_pasangan_bln:$i_pasangan_tgl";

				$i_pasangan_tgl_nikah = $data->val($i, 10);
				$i_pasangan_tgl = substr($i_pasangan_tgl_nikah,0,2);
				$i_pasangan_bln = substr($i_pasangan_tgl_nikah,3,2);
				$i_pasangan_thn = substr($i_pasangan_tgl_nikah,-4);
				$i_pasangan_tgl_nikah = "$i_pasangan_thn:$i_pasangan_bln:$i_pasangan_tgl";

				$i_anak_nama = $data->val($i, 11);
				$i_anak_tmp_lahir = $data->val($i, 12);

				$i_anak_tgl_lahir = $data->val($i, 13);
				$i_anak_tgl = substr($i_anak_tgl_lahir,0,2);
				$i_anak_bln = substr($i_anak_tgl_lahir,3,2);
				$i_anak_thn = substr($i_anak_tgl_lahir,-4);
				$i_anak_tgl_lahir = "$i_anak_thn:$i_anak_bln:$i_anak_tgl";

				$i_rumah_alamat = $data->val($i, 14);
				$i_rumah_telp = $data->val($i, 15);
				$i_gol_darah = $data->val($i, 16);

				$i_pddkn_ijazah = $data->val($i, 17);
				$qijzx = mysql_query("SELECT * FROM m_ijazah ".
										"WHERE ijazah = '$i_pddkn_ijazah'");
				$rijzx = mysql_fetch_assoc($qijzx);
				$i_pddkn_ijazah = balikin($rijzx['kd']);

				$i_pddkn_akta = $data->val($i, 18);
				$qaktx = mysql_query("SELECT * FROM m_akta ".
										"WHERE akta = '$i_pddkn_akta'");
				$raktx = mysql_fetch_assoc($qaktx);
				$i_pddkn_akta = balikin($raktx['kd']);

				$i_pddkn_thn_lulus = $data->val($i, 19);
				$i_pddkn_jurusan = $data->val($i, 20);
				$i_pddkn_nama_pt = $data->val($i, 21);
				$i_kursus_nama = $data->val($i, 22);
				$i_kursus_penyelenggara = $data->val($i, 23);
				$i_kursus_tempat = $data->val($i, 24);
				$i_kursus_tahun = $data->val($i, 25);
				$i_kursus_lama = $data->val($i, 26);

				$i_pegawai_status = $data->val($i, 27);
				$qtup = mysql_query("SELECT * FROM m_status ".
										"WHERE status = '$i_pegawai_status'");
				$rtup = mysql_fetch_assoc($qtup);
				$tup_kd = nosql($rtup['kd']);
				$i_pegawai_status = $tup_kd;

				$i_pegawai_nip = $data->val($i, 28);
				$i_pegawai_nuptk = $data->val($i, 29);
				$i_pegawai_karpeg = $data->val($i, 30);

				$i_kerja_pangkat = $data->val($i, 31);
				$qgol = mysql_query("SELECT * FROM m_golongan ".
										"WHERE golongan = '$i_kerja_pangkat'");
				$rgol = mysql_fetch_assoc($qgol);
				$gol_kd = nosql($rgol['kd']);
				$i_kerja_pangkat = $gol_kd;


				$i_kerja_jabatan = $data->val($i, 32);
				$qjbtx = mysql_query("SELECT * FROM m_jabatan ".
										"WHERE jabatan = '$i_kerja_jabatan'");
				$rjbtx = mysql_fetch_assoc($qjbtx);
				$i_kerja_jabatan = balikin($rjbtx['kd']);

				$i_kerja_tmt = $data->val($i, 33);
				$i_kerja_tmt_tgl = substr($i_kerja_tmt,0,2);
				$i_kerja_tmt_bln = substr($i_kerja_tmt,3,2);
				$i_kerja_tmt_thn = substr($i_kerja_tmt,-4);
				$i_kerja_tmt = "$i_kerja_tmt_thn:$i_kerja_tmt_bln:$i_kerja_tmt_tgl";


				$i_kerja_tmt2 = $data->val($i, 34);
				$i_kerja_tmt2_tgl = substr($i_kerja_tmt2,0,2);
				$i_kerja_tmt2_bln = substr($i_kerja_tmt2,3,2);
				$i_kerja_tmt2_thn = substr($i_kerja_tmt2,-4);
				$i_kerja_tmt2 = "$i_kerja_tmt2_thn:$i_kerja_tmt2_bln:$i_kerja_tmt2_tgl";



				//password...
				$i_pass = md5($i_pegawai_nip);


				//m_pegawai /////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_pegawai ".
										"WHERE nip = '$i_pegawai_nip'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);
				$cc_kd = nosql($rcc['kd']);


				//jika ada, update
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai SET usernamex = '$i_pegawai_nip', ".
									"passwordx = '$i_pass', ".
									"nip = '$i_pegawai_nip', ".
									"nuptk = '$i_pegawai_nuptk', ".
									"nama = '$i_nama', ".
									"no_karpeg = '$i_pegawai_karpeg', ".
									"tmp_lahir = '$i_tmp_lahir', ".
									"tgl_lahir = '$i_tgl_lahir', ".
									"kd_kelamin = '$i_kelamin', ".
									"kd_agama = '$i_agama', ".
									"alamat = '$i_rumah_alamat', ".
									"telp = '$i_rumah_telp', ".
									"gol_darah = '$i_gol_darah' ".
									"WHERE kd = '$cc_kd'");



					//update ke janissari
					mysql_query("UPDATE m_user SET usernamex = '$i_pegawai_nip', ".
							"passwordx = '$i_pass', ".
							"nomor = '$i_pegawai_nip', ".
							"nama = '$i_nama' ".
							"WHERE kd = '$cc_kd'");
					}

				//jika blm ada, insert
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai(kd, usernamex, passwordx, nip, nuptk, nama, ".
									"no_karpeg, tmp_lahir, tgl_lahir, kd_kelamin, kd_agama, ".
									"alamat, telp, gol_darah, postdate) VALUES ".
									"('$i_xyz', '$i_pegawai_nip', '$i_pass', '$i_pegawai_nip', '$i_pegawai_nuptk', '$i_nama', ".
									"'$i_pegawai_karpeg', '$i_tmp_lahir', '$i_tgl_lahir', '$i_kelamin', '$i_agama', ".
									"'$i_rumah_alamat', '$i_rumah_telp', '$i_gol_darah', '$today')");


					//masukkan ke janissari
					mysql_query("INSERT INTO m_user(kd, usernamex, passwordx, nomor, nama, tipe, postdate) VALUES ".
							"('$i_xyz', '$i_pegawai_nip', '$i_pass', '$i_pegawai_nip', '$i_nama', 'GURU', '$today')");
					}


				//m_pegawai_keluarga ////////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_pegawai_keluarga ".
										"WHERE kd_pegawai = '$cc_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai_keluarga SET status_kawin = '$i_status', ".
									"tgl_nikah = '$i_pasangan_tgl_nikah', ".
									"nama_pasangan = '$i_pasangan_nama', ".
									"tgl_lahir_pasangan = '$i_pasangan_tgl_lahir', ".
									"anak1_nama = '$i_anak_nama', ".
									"anak1_tmp_lahir = '$i_anak_tmp_lahir', ".
									"anak1_tgl_lahir = '$i_anak_tgl_lahir' ".
									"WHERE kd_pegawai = '$cc_kd'");
					}
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai_keluarga (kd, kd_pegawai, status_kawin, tgl_nikah, ".
									"nama_pasangan, tgl_lahir_pasangan, ".
									"anak1_nama, anak1_tmp_lahir, anak1_tgl_lahir) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_status', '$i_pasangan_tgl_nikah', ".
									"'$i_pasangan_nama', '$i_pasangan_tgl_lahir', ".
									"'$i_anak_nama', '$i_anak_tmp_lahir', '$i_anak_tgl_lahir')");
					}








				//m_pegawai_pendidikan //////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_pegawai_pendidikan ".
										"WHERE kd_pegawai = '$cc_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai_pendidikan SET kd_ijazah = '$i_pddkn_ijazah', ".
									"kd_akta = '$i_pddkn_akta', ".
									"thn_lulus = '$i_pddkn_thn_lulus', ".
									"jurusan = '$i_pddkn_jurusan', ".
									"nama_pt = '$i_pddkn_nama_pt' ".
									"WHERE kd_pegawai = '$cc_kd'");
					}
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai_pendidikan (kd, kd_pegawai, kd_ijazah, kd_akta, thn_lulus, ".
									"jurusan, nama_pt) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_pddkn_ijazah', '$i_pddkn_akta', '$i_pddkn_thn_lulus', ".
									"'$i_pddkn_jurusan', '$i_pddkn_nama_pt')");
					}




				//m_pegawai_diklat/kursus ///////////////////////////////////////////////////////////////////////////////////////////////
				//cek
				$qcc = mysql_query("SELECT * FROM m_pegawai_diklat ".
										"WHERE kd_pegawai = '$cc_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai_diklat SET nama = '$i_kursus_nama', ".
									"penyelenggara = '$i_kursus_penyelenggara', ".
									"tempat = '$i_kursus_penyelenggara', ".
									"tahun = '$i_kursus_tahun', ".
									"lama = '$i_kursus_lama' ".
									"WHERE kd_pegawai = '$cc_kd'");
					}
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai_diklat (kd, kd_pegawai, nama, penyelenggara, tempat, ".
									"tahun, lama) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_kursus_nama', '$i_kursus_penyelenggara', '$i_kursus_tempat', ".
									"'$i_kursus_tahun', '$i_kursus_lama')");
					}





				//m_pegawai_pekerjaan ///////////////////////////////////////////////////////////////////////////////////////////////////
				$qcc = mysql_query("SELECT * FROM m_pegawai_pekerjaan ".
										"WHERE kd_pegawai = '$cc_kd'");
				$rcc = mysql_fetch_assoc($qcc);
				$tcc = mysql_num_rows($qcc);

				//nek ada
				if ($tcc != 0)
					{
					//update
					mysql_query("UPDATE m_pegawai_pekerjaan SET kd_status = '$i_pegawai_status', ".
									"kd_golongan = '$i_kerja_pangkat', ".
									"kd_jabatan = '$i_kerja_jabatan', ".
									"tmt_awal = '$i_kerja_tmt', ".
									"tmt_akhir = '$i_kerja_tmt2' ".
									"WHERE kd_pegawai = '$cc_kd'");
					}
				else
					{
					//insert
					mysql_query("INSERT INTO m_pegawai_pekerjaan (kd, kd_pegawai, kd_status, kd_golongan, ".
									"kd_jabatan, tmt_awal, tmt_akhir) VALUES ".
									"('$i_xyz', '$i_xyz', '$i_pegawai_status', '$i_kerja_pangkat', ".
									"'$i_kerja_jabatan', '$i_kerja_tmt', '$i_kerja_tmt2')");
					}
				}


			//hapus file, jika telah import
			$path1 = "../../filebox/excel/$filex_namex";
			chmod($path1,0777);
			unlink ($path1);

			//null-kan
			xclose($koneksi);

			//re-direct
			$ke = "pegawai.php";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xclose($koneksi);

			//salah
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "pegawai.php?s=import";
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
require("../../inc/menu/adm.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" enctype="multipart/form-data" action="'.$filenya.'">';

//nama file...
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