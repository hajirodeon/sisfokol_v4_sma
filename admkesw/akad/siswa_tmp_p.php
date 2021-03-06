<?php
 



session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admkesw.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "siswa_tmp_p.php";
$judul = "Penempatan Siswa per Program";
$judulku = "[$kesw_session : $nip10_session.$nm10_session] ==> $judul";
$judulx = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&page=$page";




//focus...
if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika simpan - pindahkan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$kelkd = nosql($_POST['kelkd']);
	$kelasx = nosql($_POST['kelasx']);
	$progx = nosql($_POST['progx']);
	$jml = nosql($_POST['jml']);

	//nek null
	if ((empty($kelasx)) OR (empty($progx)))
		{
		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//ambil semua
		for ($i=1; $i<=$jml;$i++)
			{
			//ambil nilai
			$yuk = "item";
			$yuhu = "$yuk$i";
			$kdix = nosql($_POST["$yuhu"]);

			//NULL-kan ruang e....
			mysql_query("UPDATE siswa_kelas SET kd_kelas = '$kelasx', ".
							"kd_program = '$progx' ".
							"WHERE kd_siswa = '$kdix'");
			}

		//diskonek
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		xloc($ke);
		exit();
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/menu/admkesw.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
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

echo '</select>

<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
</td>
</tr>
</table>
<br>';


//nek blm dipilih
if (empty($tapelkd))
	{
	echo '<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>';
	}

else if (empty($kelkd))
	{
	echo '<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>';
	}

else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.* ".
					"FROM m_siswa, siswa_kelas ".
					"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
					"AND siswa_kelas.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_kelas = '$kelkd' ".
					"ORDER BY round(m_siswa.nis) ASC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	echo '<table width="600" border="1" cellpadding="3" cellspacing="0">
    <tr bgcolor="'.$warnaheader.'">
	<td width="1" valign="top">&nbsp;</td>
	<td width="50" valign="top"><strong>NIS</strong></td>
	<td valign="top"><strong>Nama</strong></td>
	<td width="100" valign="top"><strong>Program</strong></td>
    </tr>';

	if ($count != 0)
		{
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

			$nomer = $nomer + 1;

			$kd = nosql($data['mskd']);
			$nis = nosql($data['nis']);
			$nama = balikin($data['nama']);
			$kd_program = nosql($data['kd_program']);

			//program e..
			$qggp = mysql_query("SELECT * FROM m_program ".
									"WHERE kd = '$kd_program'");
			$rggp = mysql_fetch_assoc($qggp);
			$ggp_program = balikin($rggp['program']);

			//nek null
			if (empty($ggp_program))
				{
				$ggp_program = "-";
				}

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top">
			<input name="kd'.$nomer.'" type="hidden" value="'.$kd.'">
			<input name="item'.$nomer.'" type="checkbox" value="'.$kd.'">
			</td>
			<td valign="top">'.$nis.'</td>
			<td valign="top">'.$nama.'</td>
			<td valign="top">'.$ggp_program.'</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));
		}

	echo '</table>
	<table width="600" border="0" cellspacing="0" cellpadding="3">
    <tr>
    <td align="right"><font color="#FF0000"><strong>'.$count.'</strong></font> Data '.$pagelist.'</td>
    </tr>
    <tr>
    <td></td>
    </tr>
    <tr>
    <td align="right">
    <input name="jml" type="hidden" value="'.$limit.'">
    <input name="tapelkd" type="hidden" value="'.$tapelkd.'">
    <input name="kelkd" type="hidden" value="'.$kelkd.'">
    <input name="total" type="hidden" value="'.$count.'">
    <select name="kelasx">
    <option value="">-KELAS-</option>';

	$qbtx = mysql_query("SELECT * FROM m_kelas ".
							"ORDER BY no ASC");
	$rowbtx = mysql_fetch_assoc($qbtx);

	do
		{
		$btkdx = nosql($rowbtx['kd']);
		$btkelasx = nosql($rowbtx['kelas']);

		echo '<option value="'.$btkdx.'">'.$btkelasx.'</option>';
		}
	while ($rowbtx = mysql_fetch_assoc($qbtx));

	echo '</select>,
    <select name="progx">
    <option value="">-PROGRAM-</option>';

	$qprox = mysql_query("SELECT * FROM m_program ".
							"ORDER BY program ASC");
	$rowprox = mysql_fetch_assoc($qprox);

	do
		{
		$pro_kd = nosql($rowprox['kd']);
		$pro_prog = balikin($rowprox['program']);

		echo '<option value="'.$pro_kd.'">'.$pro_prog.'</option>';
		}
	while ($rowprox = mysql_fetch_assoc($qprox));

	echo '</select>
	<input name="btnBTL" type="reset" value="BATAL">
	<input name="btnSMP" type="submit" value="PINDAHKAN &gt;&gt;&gt;">
	</td>
    </tr>
	</table>';
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