<?php
session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admwk.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "keuangan.php";
$s = nosql($_REQUEST['s']);
$jenis = nosql($_REQUEST['jenis']);
$jnskd = nosql($_REQUEST['jnskd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$rukd = nosql($_REQUEST['rukd']);
$swkd = nosql($_REQUEST['swkd']);
$skkd = nosql($_REQUEST['skkd']);
$keu = nosql($_REQUEST['keu']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?swkd=$swkd&tapelkd=$tapelkd&kelkd=$kelkd&progkd=$progkd&rukd=$rukd&page=$page";


//siswa ne
$qsiw = mysql_query("SELECT * FROM m_siswa ".
			"WHERE kd = '$swkd'");
$rsiw = mysql_fetch_assoc($qsiw);
$siw_nis = nosql($rsiw['nis']);
$siw_nama = balikin($rsiw['nama']);

//judul
$judul = "Keuangan Siswa : ($siw_nis).$siw_nama";
$judulku = "[$wk_session : $nip3_session.$nm3_session] ==> $judul";
$judulx = $judul;



//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admwk.php");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">';
echo '<table>
<tr>
<td>';
xheadline($judul);
echo '</td>
<td>
[<a href="detail.php?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&rukd='.$rukd.'" title="Daftar Siswa">Daftar Siswa</a>]
</td>
</table>';


//tapel
$qpel = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rpel = mysql_fetch_assoc($qpel);
$pel_thn1 = nosql($rpel['tahun1']);
$pel_thn2 = nosql($rpel['tahun2']);

//kelas
$qkel = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rkel = mysql_fetch_assoc($qkel);
$kel_kelas = nosql($rkel['kelas']);

//program
$qpro = mysql_query("SELECT * FROM m_program ".
						"WHERE kd = '$progkd'");
$rpro = mysql_fetch_assoc($qpro);
$pro_program = balikin($rpro['program']);

//nek null
if (empty($pro_program))
	{
	$pro_program = "-";
	}


//ruang
$qru = mysql_query("SELECT * FROM m_ruang ".
						"WHERE kd = '$rukd'");
$rru = mysql_fetch_assoc($qru);
$ru_ruang = balikin($rru['ruang']);



echo '<table bgcolor="'.$warnaover.'" width="100%" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<strong>Tahun Pelajaran :</strong> '.$pel_thn1.'/'.$pel_thn2.',
<strong>Kelas :</strong> '.$kel_kelas.',
<strong>Program :</strong> '.$pro_program.',
<strong>Ruang :</strong> '.$ru_ruang.'
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<strong>Jenis Uang :</strong> ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$jnskd.'" selected>--'.$jenis.'--</option>
<option value="'.$filenya.'?swkd='.$swkd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&progkd='.$progkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&jnskd=spi&jenis=SPI">SPI</option>
<option value="'.$filenya.'?swkd='.$swkd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&progkd='.$progkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&jnskd=komite&jenis=Komite">Komite</option>
<option value="'.$filenya.'?swkd='.$swkd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&progkd='.$progkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&jnskd=les&jenis=LES">LES</option>';


//keuangan lain
$qdt = mysql_query("SELECT * FROM m_uang_lain_jns ".
			"ORDER BY nama ASC");
$rdt = mysql_fetch_assoc($qdt);
$tdt = mysql_num_rows($qdt);

//jika ada
if ($tdt != 0)
	{
        do
		{
		$dt_kd = nosql($rdt['kd']);
		$dt_nama = balikin($rdt['nama']);

		echo '<option value="'.$filenya.'?swkd='.$swkd.'&skkd='.$skkd.'&tapelkd='.$tapelkd.'&progkd='.$progkd.'&kelkd='.$kelkd.'&rukd='.$rukd.'&jnskd='.$dt_kd.'&jenis='.$dt_nama.'">'.$dt_nama.'</option>';
		}
	while ($rdt = mysql_fetch_assoc($qdt));
	}


echo '</select>
</td>
</tr>
</table>
</p>';



//jika null
if (empty($jnskd))
	{
	echo '<p>
	<font color="#FF0000"><strong>JENIS UANG Belum Dipilih...!!</strong></font>
	</p>';
	}
else
	{
	//jika SPI ////////////////////////////////////////////////////////////////////////////////////////
	if ($jnskd == "spi")
		{
		//ketahui ruang kelas siswa, yang terakhir
		$qske = mysql_query("SELECT siswa_kelas.*, m_tapel.* ".
					"FROM siswa_kelas, m_tapel ".
					"WHERE siswa_kelas.kd_tapel = m_tapel.kd ".
					"AND siswa_kelas.kd_siswa = '$swkd' ".
					"ORDER BY m_tapel.tahun1 DESC");
		$rske = mysql_fetch_assoc($qske);
		$tske = mysql_num_rows($qske);
		$ske_kelkd = nosql($rske['kd_kelas']);
		$ske_progkd = nosql($rske['kd_program']);
		$ske_rukd = nosql($rske['kd_ruang']);




		//programnya...
		$qpro = mysql_query("SELECT * FROM m_program ".
					"WHERE kd = '$ske_progkd'");
		$rpro = mysql_fetch_assoc($qpro);
		$pro_program = balikin($rpro['program']);



		//kelasnya...
		$qkel = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd = '$ske_kelkd'");
		$rkel = mysql_fetch_assoc($qkel);
		$kel_kelas = balikin($rkel['kelas']);


		//ruangnya...
		$qru = mysql_query("SELECT * FROM m_ruang ".
					"WHERE kd = '$ske_rukd'");
		$rru = mysql_fetch_assoc($qru);
		$ru_ruang = balikin($rru['ruang']);




		//total uang spi
		$qpkl = mysql_query("SELECT * FROM m_uang_spi ".
					"WHERE kd_tapel = '$tapelkd'");
		$rpkl = mysql_fetch_assoc($qpkl);
		$pkl_nilai = nosql($rpkl['nilai']);


		//yang telah dibayar
		$qccx = mysql_query("SELECT SUM(nilai) AS nilai FROM siswa_uang_spi ".
					"WHERE kd_siswa = '$swkd'");
		$rccx = mysql_fetch_assoc($qccx);
		$ccx_nilai = nosql($rccx['nilai']);

		//sisa
		$nil_sisa = $pkl_nilai - $ccx_nilai;



		echo '<p>
		<strong>HISTORY PEMBAYARAN</strong>
		<br>
		('.xduit2($pkl_nilai).')
		<p>';

		//total bayar
		$qdftx2 = mysql_query("SELECT SUM(nilai) AS total ".
					"FROM siswa_uang_spi ".
					"WHERE kd_siswa = '$swkd' ".
					"AND kd_tapel = '$tapelkd'");
		$rdftx2 = mysql_fetch_assoc($qdftx2);
		$dftx2_total = nosql($rdftx2['total']);


		//keterangan
		if ($dftx2_total == $pkl_nilai)
			{
			$nil_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
			}
		else
			{
			$nil_ket = "<font color=\"blue\"><strong>Belum Lunas</strong></font>";
			}



		//daftar
		$qdftx = mysql_query("SELECT siswa_uang_spi.*, ".
					"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
					"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
					"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
					"FROM siswa_uang_spi ".
					"WHERE kd_siswa = '$swkd' ".
					"AND kd_tapel = '$tapelkd' ".
					"ORDER BY tgl_bayar DESC");
		$rdftx = mysql_fetch_assoc($qdftx);
		$tdftx = mysql_num_rows($qdftx);

		echo '<table border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
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

			//nilai
			$dft_kd = nosql($rdftx['kd']);
			$dft_bln = nosql($rdftx['bln']);
			$dft_thn = nosql($rdftx['thn']);
			$dft_nilai = nosql($rdftx['nilai']);
			$dft_xtgl = nosql($rdftx['xtgl']);
			$dft_xbln = nosql($rdftx['xbln']);
			$dft_xthn = nosql($rdftx['xthn']);
			$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";

			//jika null
			if ($dft_tgl_bayar == "00/00/0000")
				{
				$dft_tgl_bayar = "-";
				}




			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			'.$dft_tgl_bayar.'
			</td>
			<td align="right">
			'.xduit2($dft_nilai).'
			</td>
			</tr>';
			}
		while ($rdftx = mysql_fetch_assoc($qdftx));

		echo '</table>
		<p>
		Total Bayar :
		<br>
		Rp.	<input name="nil_total" type="text" size="10" value="'.$dftx2_total.'" style="text-align:right" class="input" readonly>,00
		</p>

		<p>
		Keterangan :
		<br>
		'.$nil_ket.'
		</p>';
		}



	//jika komite /////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "komite")
		{
		//ketahui nilai per bulan
		$qnil = mysql_query("SELECT m_uang_komite.*, siswa_kelas.* ".
					"FROM m_uang_komite, siswa_kelas ".
					"WHERE siswa_kelas.kd_tapel = m_uang_komite.kd_tapel ".
					"AND siswa_kelas.kd_kelas = m_uang_komite.kd_kelas ".
					"AND m_uang_komite.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_siswa = '$swkd'");
		$rnil = mysql_fetch_assoc($qnil);
		$tnil = mysql_num_rows($qnil);
		$nil_kelkd = nosql($rnil['kd_kelas']);
		$nil_progkd = nosql($rnil['kd_program']);
		$nil_rukd = nosql($rnil['kd_ruang']);
		$nil_uang = nosql($rnil['nilai']);



		//kelasnya...
		$qkel = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd = '$nil_kelkd'");
		$rkel = mysql_fetch_assoc($qkel);
		$kel_kelas = balikin($rkel['kelas']);



		//programnya...
		$qpro = mysql_query("SELECT * FROM m_program ".
					"WHERE kd = '$nil_progkd'");
		$rpro = mysql_fetch_assoc($qpro);
		$pro_program = balikin($rpro['program']);



		//ruangnya...
		$qru = mysql_query("SELECT * FROM m_ruang ".
					"WHERE kd = '$nil_rukd'");
		$rru = mysql_fetch_assoc($qru);
		$ru_ruang = balikin($rru['ruang']);


		//total uang
		$cc_sebesar = $jml_bln * $nil_uang;


		echo '<p>
		<strong>HISTORY PEMBAYARAN</strong>
		('.xduit2($nil_uang).'/Bulan)';


		//daftar
		$qdftx = mysql_query("SELECT siswa_uang_komite.*, ".
					"DATE_FORMAT(tgl_bayar, '%d') AS xtgl, ".
					"DATE_FORMAT(tgl_bayar, '%m') AS xbln, ".
					"DATE_FORMAT(tgl_bayar, '%Y') AS xthn ".
					"FROM siswa_uang_komite ".
					"WHERE kd_siswa = '$swkd' ".
					"AND kd_tapel = '$tapelkd' ".
					"AND kd_kelas = '$nil_kelkd'");
		$rdftx = mysql_fetch_assoc($qdftx);
		$tdftx = mysql_num_rows($qdftx);

		echo '<table border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="120" align="center"><strong><font color="'.$warnatext.'">Bulan</font></strong></td>
		<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
		<td width="100" align="center"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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

			//nilai
			$dft_kd = nosql($rdftx['kd']);
			$dft_bln = nosql($rdftx['bln']);
			$dft_thn = nosql($rdftx['thn']);
			$dft_nilai = nosql($rdftx['nilai']);
			$dft_xtgl = nosql($rdftx['xtgl']);
			$dft_xbln = nosql($rdftx['xbln']);
			$dft_xthn = nosql($rdftx['xthn']);
			$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";
			$dft_status = nosql($rdftx['lunas']);

			//jika null
			if ($dft_tgl_bayar == "00/00/0000")
				{
				$dft_tgl_bayar = "-";
				}


			//nek lunas
			if ($dft_status == 'true')
				{
				$dft_status_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
				}
			else if ($dft_status == 'false')
				{
				$dft_status_ket = "<font color=\"blue\"><strong>Belum Bayar</strong></font>";
				}

			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td align="right">
			'.$arrbln[$dft_bln].' '.$dft_thn.'
			</td>
			<td>
			'.$dft_tgl_bayar.'
			</td>
			<td>
			'.$dft_status_ket.'
			</td>
			</tr>';
			}
		while ($rdftx = mysql_fetch_assoc($qdftx));

		echo '</table>
		</p>';
		}


	//jika les ////////////////////////////////////////////////////////////////////////////////////////
	else if ($jnskd == "les")
		{
		//total uang . . .
		$qpkl = mysql_query("SELECT * FROM m_uang_les ".
					"WHERE kd_tapel = '$tapelkd' ".
					"AND kd_kelas = '$kelkd'");
		$rpkl = mysql_fetch_assoc($qpkl);
		$pkl_nilai = nosql($rpkl['nilai']);



		//ketahui nilai
		$qnil = mysql_query("SELECT m_uang_les.*, siswa_kelas.* ".
					"FROM m_uang_les, siswa_kelas ".
					"WHERE siswa_kelas.kd_tapel = m_uang_les.kd_tapel ".
					"AND siswa_kelas.kd_kelas = m_uang_les.kd_kelas ".
					"AND m_uang_les.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_siswa = '$swkd'");
		$rnil = mysql_fetch_assoc($qnil);
		$tnil = mysql_num_rows($qnil);
		$nil_kelkd = nosql($rnil['kd_kelas']);
		$nil_progkd = nosql($rnil['kd_program']);
		$nil_rukd = nosql($rnil['kd_ruang']);
		$nil_uang = nosql($rnil['nilai']);

		//total uang
		$cc_sebesar = $nil_uang;


		//yang telah dibayar
		$qccx = mysql_query("SELECT SUM(siswa_uang_les.nilai) AS total ".
					"FROM siswa_uang_les ".
					"WHERE siswa_uang_les.kd_tapel = '$tapelkd' ".
					"AND siswa_uang_les.kd_kelas = '$kelkd' ".
					"AND siswa_uang_les.kd_siswa = '$swkd'");
		$rccx = mysql_fetch_assoc($qccx);
		$ccx_nilai = nosql($rccx['total']);

		//sisa
		$nil_sisa = $pkl_nilai - $ccx_nilai;



		echo '<p>
		<strong>HISTORY PEMBAYARAN</strong>
		('.xduit2($nil_uang).')';


		//total bayar
		$qdftx2 = mysql_query("SELECT SUM(siswa_uang_les.nilai) AS total ".
					"FROM siswa_uang_les ".
					"WHERE siswa_uang_les.kd_siswa = '$swkd' ".
					"AND siswa_uang_les.kd_tapel = '$tapelkd' ".
					"AND siswa_uang_les.kd_kelas = '$kelkd'");
		$rdftx2 = mysql_fetch_assoc($qdftx2);
		$dftx2_total = nosql($rdftx2['total']);


		//keterangan
		if ($dftx2_total == $nil_uang)
			{
			$nil_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
			}
		else
			{
			$nil_ket = "<font color=\"blue\"><strong>Belum Lunas</strong></font>";
			}



		//daftar
		$qdftx = mysql_query("SELECT siswa_uang_les.*, siswa_uang_les.kd AS sukd, ".
					"siswa_uang_les.nilai AS sunil, ".
					"DATE_FORMAT(siswa_uang_les.tgl_bayar, '%d') AS xtgl, ".
					"DATE_FORMAT(siswa_uang_les.tgl_bayar, '%m') AS xbln, ".
					"DATE_FORMAT(siswa_uang_les.tgl_bayar, '%Y') AS xthn ".
					"FROM siswa_uang_les ".
					"WHERE siswa_uang_les.kd_siswa = '$swkd' ".
					"AND siswa_uang_les.kd_tapel = '$tapelkd' ".
					"AND siswa_uang_les.kd_kelas = '$kelkd' ".
					"ORDER BY siswa_uang_les.tgl_bayar DESC");
		$rdftx = mysql_fetch_assoc($qdftx);
		$tdftx = mysql_num_rows($qdftx);

		echo '<table border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
		</tr>';


		//jika gak null
		if ($tdftx != 0)
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

				//nilai
				$dft_kd = nosql($rdftx['sukd']);
				$dft_nilai = nosql($rdftx['sunil']);
				$dft_xtgl = nosql($rdftx['xtgl']);
				$dft_xbln = nosql($rdftx['xbln']);
				$dft_xthn = nosql($rdftx['xthn']);
				$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";

				//jika null
				if ($dft_tgl_bayar == "00/00/0000")
					{
					$dft_tgl_bayar = "-";
					}




				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				'.$dft_tgl_bayar.'
				</td>
				<td align="right">
				'.xduit2($dft_nilai).'
				</td>
				</tr>';
				}
			while ($rdftx = mysql_fetch_assoc($qdftx));
			}

		echo '</table>
		<p>
		Total Bayar :
		<br>
		Rp.	<input name="nil_total" type="text" size="10" value="'.$dftx2_total.'" style="text-align:right" class="input" readonly>,00
		</p>

		<p>
		Keterangan :
		<br>
		'.$nil_ket.'
		</p>';
		}


	//yang lainnya ////////////////////////////////////////////////////////////////////////////////////
	else
		{
		//ruang kelas
		$qnily = mysql_query("SELECT m_uang_lain.*, siswa_kelas.* ".
					"FROM m_uang_lain, siswa_kelas ".
					"WHERE siswa_kelas.kd_tapel = m_uang_lain.kd_tapel ".
					"AND siswa_kelas.kd_kelas = m_uang_lain.kd_kelas ".
					"AND m_uang_lain.kd_tapel = '$tapelkd' ".
					"AND siswa_kelas.kd_siswa = '$swkd'");
		$rnily = mysql_fetch_assoc($qnily);
		$tnily = mysql_num_rows($qnily);
		$nily_kelkd = nosql($rnily['kd_kelas']);
		$nily_progkd = nosql($rnily['kd_program']);
		$nily_rukd = nosql($rnily['kd_ruang']);





		//programnya...
		$qpro = mysql_query("SELECT * FROM m_program ".
					"WHERE kd = '$nily_progkd'");
		$rpro = mysql_fetch_assoc($qpro);
		$pro_program = balikin($rpro['program']);


		//kelasnya...
		$qkel = mysql_query("SELECT * FROM m_kelas ".
					"WHERE kd = '$nily_kelkd'");
		$rkel = mysql_fetch_assoc($qkel);
		$kel_kelas = balikin($rkel['kelas']);


		//ruangnya...
		$qru = mysql_query("SELECT * FROM m_ruang ".
					"WHERE kd = '$nily_rukd'");
		$rru = mysql_fetch_assoc($qru);
		$ru_ruang = balikin($rru['ruang']);





		//total uang . . .
		$qpkl = mysql_query("SELECT * FROM m_uang_lain ".
					"WHERE kd_jenis = '$jnskd' ".
					"AND kd_tapel = '$tapelkd'");
		$rpkl = mysql_fetch_assoc($qpkl);
		$pkl_nilai = nosql($rpkl['nilai']);


		//yang telah dibayar
		$qccx = mysql_query("SELECT SUM(siswa_uang_lain.nilai) AS total ".
					"FROM siswa_uang_lain, m_uang_lain ".
					"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
					"AND m_uang_lain.kd_jenis = '$jnskd' ".
					"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
					"AND siswa_uang_lain.kd_siswa = '$swkd'");
		$rccx = mysql_fetch_assoc($qccx);
		$ccx_nilai = nosql($rccx['total']);

		//sisa
		$nil_sisa = $pkl_nilai - $ccx_nilai;





		echo '<strong>HISTORY PEMBAYARAN</strong>
		<br>
		('.xduit2($pkl_nilai).')
		<p>';

		//total bayar
		$qdftx2 = mysql_query("SELECT SUM(siswa_uang_lain.nilai) AS total ".
					"FROM m_uang_lain, siswa_uang_lain ".
					"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
					"AND m_uang_lain.kd_jenis = '$jnskd' ".
					"AND siswa_uang_lain.kd_siswa = '$swkd' ".
					"AND siswa_uang_lain.kd_tapel = '$tapelkd'");
		$rdftx2 = mysql_fetch_assoc($qdftx2);
		$dftx2_total = nosql($rdftx2['total']);


		//keterangan
		if ($dftx2_total == $pkl_nilai)
			{
			$nil_ket = "<font color=\"red\"><strong>LUNAS</strong></font>";
			}
		else
			{
			$nil_ket = "<font color=\"blue\"><strong>Belum Lunas</strong></font>";
			}



		//daftar
		$qdftx = mysql_query("SELECT siswa_uang_lain.*, siswa_uang_lain.kd AS sukd, ".
					"siswa_uang_lain.nilai AS sunil, m_uang_lain.*, ".
					"DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%d') AS xtgl, ".
					"DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%m') AS xbln, ".
					"DATE_FORMAT(siswa_uang_lain.tgl_bayar, '%Y') AS xthn ".
					"FROM siswa_uang_lain, m_uang_lain ".
					"WHERE siswa_uang_lain.kd_uang_lain = m_uang_lain.kd ".
					"AND m_uang_lain.kd_jenis = '$jnskd' ".
					"AND siswa_uang_lain.kd_siswa = '$swkd' ".
					"AND siswa_uang_lain.kd_tapel = '$tapelkd' ".
					"ORDER BY siswa_uang_lain.tgl_bayar DESC");
		$rdftx = mysql_fetch_assoc($qdftx);
		$tdftx = mysql_num_rows($qdftx);

		echo '<table border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="100" align="center"><strong><font color="'.$warnatext.'">Tgl.Bayar</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">Nilai</font></strong></td>
		</tr>';


		//jika gak null
		if ($tdftx != 0)
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

				//nilai
				$dft_kd = nosql($rdftx['sukd']);
				$dft_bln = nosql($rdftx['bln']);
				$dft_thn = nosql($rdftx['thn']);
				$dft_nilai = nosql($rdftx['sunil']);
				$dft_xtgl = nosql($rdftx['xtgl']);
				$dft_xbln = nosql($rdftx['xbln']);
				$dft_xthn = nosql($rdftx['xthn']);
				$dft_tgl_bayar = "$dft_xtgl/$dft_xbln/$dft_xthn";

				//jika null
				if ($dft_tgl_bayar == "00/00/0000")
					{
					$dft_tgl_bayar = "-";
					}




				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>
				'.$dft_tgl_bayar.'
				</td>
				<td align="right">
				'.xduit2($dft_nilai).'
				</td>
				</tr>';
				}
			while ($rdftx = mysql_fetch_assoc($qdftx));
			}

		echo '</table>
		<p>
		Total Bayar :
		<br>
		Rp.	<input name="nil_total" type="text" size="10" value="'.$dftx2_total.'" style="text-align:right" class="input" readonly>,00
		</p>

		<p>
		Keterangan :
		<br>
		'.$nil_ket.'
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