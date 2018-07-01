<?php 





session_start();

require("../../../inc/config.php");
require("../../../inc/fungsi.php");
require("../../../inc/koneksi.php");
require("../../../inc/cek/psb_adm.php");
$tpl = LoadTpl("../../../template/index.html");

nocache;

//nilai
$filenya = "soal_post.php";
$judul = "Input/Edit Soal";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$mapelkd = nosql($_REQUEST['mapelkd']);
$s = nosql($_REQUEST['s']);
$soalkd = nosql($_REQUEST['soalkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//focus
$diload = "document.formx.y_no.focus();";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//bikin folder
//jika baru
if ($s == "baru")
	{
	//nilai
	$path3 = "../../../filebox";
	$path2 = "../../../filebox/soal";
	$path1 = "../../../filebox/soal/$soalkd";
	chmod($path3,0777);
	chmod($path2,0777);

	//cek, sudah ada belum
	if (!file_exists($path1))
		{
		mkdir("$path1", 0777);
		}
	}




//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$mapelkd = nosql($_POST['mapelkd']);
	$page = nosql($_POST['page']);


	//re-direct
	$ke = "soal.php?mapelkd=$mapelkd&page=$page";
	xloc($ke);
	exit();
	}





//jika edit
if ($s == "edit")
	{
	//nilai
	$mapelkd = nosql($_REQUEST['mapelkd']);
	$soalkd = nosql($_REQUEST['soalkd']);
	$page= nosql($_REQUEST['page']);

	//query soal
	$qx = mysql_query("SELECT * FROM psb_m_soal ".
						"WHERE kd_mapel = '$mapelkd' ".
						"AND kd = '$soalkd'");
	$rowx = mysql_fetch_assoc($qx);

	$x_no = nosql($rowx['no']);
	$x_isi = balikin($rowx['isi']);
	$x_kunci = nosql($rowx['kunci']);
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$mapelkd = nosql($_POST['mapelkd']);
	$soalkd = nosql($_POST['soalkd']);
	$page = nosql($_POST['page']);
	$x_no = nosql($_POST['y_no']);
	$x_isi = cegah2($_POST['editor']);
	$x_kunci = nosql($_POST['y_kunci']);

	//nek null
	if ((empty($x_no)) OR (empty($x_isi)) OR (empty($x_kunci)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?mapelkd=$mapelkd&soalkd=$soalkd&s=baru";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//jika baru
		if ($s == "baru")
			{
			///cek
			$qcc = mysql_query("SELECT * FROM psb_m_soal ".
									"WHERE kd_mapel = '$mapelkd' ".
									"AND isi = '$x_isi'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);

			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Soal Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?mapelkd=$mapelkd&soalkd=$soalkd&s=baru";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert soal
				mysql_query("INSERT INTO psb_m_soal(kd, kd_mapel, no, isi, kunci) VALUES ".
								"('$soalkd', '$mapelkd', '$x_no', '$x_isi', '$x_kunci')");


				//re-direct
				$ke = "soal.php?mapelkd=$mapelkd";
				xloc($ke);
				exit();
				}
			}


		//jika update
		else if ($s == "edit")
			{
			//update soal
			mysql_query("UPDATE psb_m_soal SET no = '$x_no', ".
							"isi = '$x_isi', ".
							"kunci = '$x_kunci' ".
							"WHERE kd_mapel = '$mapelkd' ".
							"AND kd = '$soalkd'");


			//re-direct
			$ke = "soal.php?mapelkd=$mapelkd&page=$page";
			xloc($ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//js
require("../../../inc/js/editor.js");
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/number.js");
require("../../../inc/js/swap.js");
require("../../../inc/js/openwindow.js");
require("../../../inc/menu/psb_adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaover.'">
<td>
<strong>Mata Pelajaran :</strong> ';

//terpilih
$qmpx = mysql_query("SELECT * FROM psb_m_mapel ".
						"WHERE kd = '$mapelkd'");
$rowmpx = mysql_fetch_assoc($qmpx);
$mpx_kd = nosql($rowmpx['kd']);
$mpx_mapel = balikin($rowmpx['mapel']);

echo ''.$mpx_mapel.'
</td>
</tr>
</table>
<p>
<strong>No. Soal : </strong>
<br>
<input name="y_no" type="text" value="'.$x_no.'" size="3" onKeyPress="return numbersonly(this, event)">,
</p>

<p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<strong>Isi Soal : </strong>
</td>
<td align="right">
<input name="btnUPL" type="button" value="FileBox Image >>" OnClick="javascript:MM_openBrWindow(\'soal_post_filebox.php?mapelkd='.$mapelkd.'&soalkd='.$soalkd.'\',\'FileBOX Image (.jpg) :\',\'width=650,height=300,toolbar=no,menubar=no,location=no,scrollbars=yes,resize=no\')"">
</td>
</tr>
</table>
<br>
<textarea id="editor" name="editor" rows="20" cols="80" style="width: 100%">'.$x_isi.'</textarea>
</p>

<p>
<strong>Kunci Jawaban :</strong>
<br>
<select name="y_kunci">
<option value="'.$x_kunci.'" selected>'.$x_kunci.'</option>';

//looping opsi
for ($j=1;$j<=5;$j++)
	{
	//array pilihan
	$arrpil = array('1' => 'A',
					'2' => 'B',
					'3' => 'C',
					'4' => 'D',
					'5' => 'E');

	echo '<option value="'.$arrpil[$j].'">'.$arrpil[$j].'</option>';
	}

echo '</select>
</p>

<p>
<input name="jml" type="hidden" value="'.$count.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="soalkd" type="hidden" value="'.$soalkd.'">
<input name="mapelkd" type="hidden" value="'.$mapelkd.'">
<input name="page" type="hidden" value="'.$page.'">
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
</p>
</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>