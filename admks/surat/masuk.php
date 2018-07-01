<?php
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMA_v4.0_(NyurungBAN)                          ///////
/////// (Sistem Informasi Sekolah untuk SMA)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS	: 081-829-88-54                                 ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////



session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admks.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/surat.html");

nocache;

//nilai
$filenya = "masuk.php";
$judul = "Data Surat Masuk";
$judulku = "$judul  [$ks_session : $nip4_session.$nm4_session]";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$sukd = nosql($_REQUEST['sukd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

//focus
$diload = "document.formx.no_surat.focus();";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}






//jika edit
if ($s == "edit")
	{
	//nilai
	$sukd = nosql($_REQUEST['sukd']);
	$page = nosql($_REQUEST['page']);

	//query
	$qx = mysql_query("SELECT surat_masuk.*, ".
							"DATE_FORMAT(tgl_surat, '%d') AS surat_tgl, ".
							"DATE_FORMAT(tgl_surat, '%m') AS surat_bln, ".
							"DATE_FORMAT(tgl_surat, '%Y') AS surat_thn, ".
							"DATE_FORMAT(tgl_terima, '%d') AS terima_tgl, ".
							"DATE_FORMAT(tgl_terima, '%m') AS terima_bln, ".
							"DATE_FORMAT(tgl_terima, '%Y') AS terima_thn, ".
							"DATE_FORMAT(tgl_deadline_balas, '%d') AS deadline_tgl, ".
							"DATE_FORMAT(tgl_deadline_balas, '%m') AS deadline_bln, ".
							"DATE_FORMAT(tgl_deadline_balas, '%Y') AS deadline_thn ".
							"FROM surat_masuk ".
							"WHERE kd = '$sukd'");
	$rowx = mysql_fetch_assoc($qx);
	$x_no_urut = nosql($rowx['no_urut']);
	$x_no_surat = balikin2($rowx['no_surat']);
	$x_asal = balikin2($rowx['asal']);
	$x_tujuan = balikin2($rowx['tujuan']);
	$x_kd_lemari = nosql($rowx['kd_lemari']);
	$x_kd_rak = nosql($rowx['kd_rak']);
	$x_kd_ruang = nosql($rowx['kd_ruang']);
	$x_kd_map = nosql($rowx['kd_map']);
	$x_kd_sifat = nosql($rowx['kd_sifat']);
	$x_kd_status = nosql($rowx['kd_status']);
	$x_kd_klasifikasi = nosql($rowx['kd_klasifikasi']);
	$x_lokasi = balikin2($rowx['lokasi']);
	$x_lampiran = balikin2($rowx['lampiran']);
	$x_tembusan = balikin2($rowx['tembusan']);
	$x_ket = balikin2($rowx['ket']);
	$x_blskd = nosql($rowx['kd_balas']);
	$x_surat_tgl = nosql($rowx['surat_tgl']);
	$x_surat_bln = nosql($rowx['surat_bln']);
	$x_surat_thn = nosql($rowx['surat_thn']);
	$x_perihal = balikin2($rowx['perihal']);
	$x_terima_tgl = nosql($rowx['terima_tgl']);
	$x_terima_bln = nosql($rowx['terima_bln']);
	$x_terima_thn = nosql($rowx['terima_thn']);
	$x_de_tgl = nosql($rowx['deadline_tgl']);
	$x_de_bln = nosql($rowx['deadline_bln']);
	$x_de_thn = nosql($rowx['deadline_thn']);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//js
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/menu/admks.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';


//nek baru ato edit /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($s == "edit")
	{
	$cc_no_urut = $x_no_urut;

	echo '<p>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="150">
	No. Urut
	</td>
	<td>:
	<input name="no_urut" type="text" value="'.$cc_no_urut.'" size="10" class="input" readonly>
	</td>
	</tr>

	<tr>
	<td width="150">
	Klasifikasi Surat
	</td>
	<td>: ';

	//terpilih
	$qdtx = mysql_query("SELECT * FROM surat_m_klasifikasi ".
				"WHERE kd = '$x_kd_klasifikasi'");
	$rdtx = mysql_fetch_assoc($qdtx);
	$dtx_klasifikasi = balikin($rdtx['klasifikasi']);

	echo '<strong>'.$dtx_klasifikasi.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Sifat Surat
	</td>
	<td>: ';

	//terpilih
	$qdtx = mysql_query("SELECT * FROM surat_m_sifat ".
				"WHERE kd = '$x_kd_sifat'");
	$rdtx = mysql_fetch_assoc($qdtx);
	$dtx_sifat = balikin($rdtx['sifat']);

	echo '<strong>'.$dtx_sifat.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	No. Surat
	</td>
	<td>:
	<strong>'.$x_no_surat.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Tgl. Surat
	</td>
	<td>:
	<strong>'.$x_surat_tgl.' '.$arrbln1[$x_surat_bln].' '.$x_surat_thn.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Tgl. Diterima
	</td>
	<td>:
	<strong>'.$x_terima_tgl.' '.$arrbln1[$x_terima_bln].' '.$x_terima_thn.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Tgl. Deadline Balasan Surat
	</td>
	<td>:
	<strong>'.$x_de_tgl.' '.$arrbln1[$x_de_bln].' '.$x_de_thn.'</strong>
	</td>
	</tr>

	<tr>
	<td>
	Asal Surat
	</td>
	<td>:
	<strong>'.$x_asal.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Tujuan Surat
	</td>
	<td>:
	<strong>'.$x_tujuan.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Perihal Surat
	</td>
	<td>:
	<strong>'.$x_perihal.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Lampiran Surat
	</td>
	<td>:
	<strong>'.$x_lampiran.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Tembusan Surat
	</td>
	<td>:
	<strong>'.$x_tembusan.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Status Keberadaan Surat
	</td>
	<td>: ';

	//terpilih
	$qdtx = mysql_query("SELECT * FROM surat_m_status ".
				"WHERE kd = '$x_kd_status'");
	$rdtx = mysql_fetch_assoc($qdtx);
	$dtx_status = balikin($rdtx['status']);

	echo '<strong>'.$dtx_status.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Apakah Sudah Dibalas...?
	</td>
	<td>: ';

	//terpilih
	$qblsx = mysql_query("SELECT * FROM surat_m_balas ".
				"WHERE kd = '$x_blskd'");
	$rblsx = mysql_fetch_assoc($qblsx);
	$blsx_balas = balikin($rblsx['balas']);


	echo '<strong>'.$blsx_balas.'</strong>
	</td>
	</tr>

	<tr>
	<td width="150">
	Keterangan Lain
	</td>
	<td>:
	<strong>'.$x_ket.'</strong>
	</td>
	</tr>
	</table>
	<br>
	<br>

	<p>
	Lokasi Pengarsipan :
	</p>
	<p>
	Ruang :  ';

	//terpilih
	$qdt1 = mysql_query("SELECT * FROM surat_m_ruang ".
				"WHERE kd = '$x_kd_ruang'");
	$rdt1 = mysql_fetch_assoc($qdt1);
	$dt1_ruang = balikin($rdt1['ruang']);

	echo '<strong>'.$dt1_ruang.'</strong>,

	Lemari : ';

	//terpilih
	$qdt2 = mysql_query("SELECT * FROM surat_m_lemari ".
				"WHERE kd = '$x_kd_lemari'");
	$rdt2 = mysql_fetch_assoc($qdt2);
	$dt2_lemari = balikin($rdt2['lemari']);

	echo '<strong>'.$dt2_lemari.'</strong>,

	Rak : ';

	//terpilih
	$qdt3 = mysql_query("SELECT * FROM surat_m_rak ".
				"WHERE kd = '$x_kd_rak'");
	$rdt3 = mysql_fetch_assoc($qdt3);
	$dt3_rak = balikin($rdt3['rak']);

	echo '<strong>'.$dt3_rak.'</strong>,

	MAP : ';

	//terpilih
	$qdt4 = mysql_query("SELECT * FROM surat_m_map ".
				"WHERE kd = '$x_kd_map'");
	$rdt4 = mysql_fetch_assoc($qdt4);
	$dt4_map = balikin($rdt4['map']);

	echo '<strong>'.$dt4_map.'</strong>
	</p>
	<br>


	<input name="page" type="hidden" value="'.$page.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="sukd" type="hidden" value="'.$sukd.'">
	<input name="no_urut" type="hidden" value="'.$cc_no_urut.'">
	<input name="btnBTL" type="submit" value="DAFTAR SURAT MASUK >>">
	<br>';
	}


//daftar surat //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);

	$sqlcount = "SELECT * FROM surat_masuk ".
			"ORDER BY tgl_terima DESC";
	$sqlresult = $sqlcount;

	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);


	if ($count != 0)
		{
		echo '<p>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="50"><strong><font color="'.$warnatext.'">Disposisi</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Sah</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Tgl. Terima</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">No. Urut</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Asal</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Tujuan</font></strong></td>
		<td width="100"><strong><font color="'.$warnatext.'">Tgl. Surat</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Perihal</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Klasifikasi</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Sifat</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Status</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Balasan</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Ruang</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Lemari</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Rak</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">MAP</font></strong></td>
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

			$nomer = $nomer + 1;
			$i_kd = nosql($data['kd']);
			$i_no_urut = nosql($data['no_urut']);
			$i_no_surat = balikin2($data['no_surat']);
			$i_asal = balikin2($data['asal']);
			$i_tujuan = balikin2($data['tujuan']);
			$i_tgl_surat = $data['tgl_surat'];
			$i_perihal = balikin2($data['perihal']);
			$i_tgl_terima = $data['tgl_terima'];

			$ku_kd_klasifikasi = nosql($data['kd_klasifikasi']);
			$ku_kd_sifat = nosql($data['kd_sifat']);
			$ku_kd_status = nosql($data['kd_status']);
			$ku_blskd = nosql($data['kd_balas']);
			$ku_tgl_surat = $data['tgl_surat'];
			$ku_tgl_terima = $data['tgl_terima'];
			$ku_kd_ruang = nosql($data['kd_ruang']);
			$ku_kd_lemari = nosql($data['kd_lemari']);
			$ku_kd_rak = nosql($data['kd_rak']);
			$ku_kd_map = nosql($data['kd_map']);


			//terpilih
			$qbls = mysql_query("SELECT * FROM surat_m_balas ".
						"WHERE kd = '$ku_blskd'");
			$rbls = mysql_fetch_assoc($qbls);
			$bls_balas = balikin($rbls['balas']);




			//klasifikasi
			$qdtx = mysql_query("SELECT * FROM surat_m_klasifikasi ".
											"WHERE kd = '$ku_kd_klasifikasi'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$dtx_klasifikasi = balikin($rdtx['klasifikasi']);

			//sifat
			$qdtx2 = mysql_query("SELECT * FROM surat_m_sifat ".
											"WHERE kd = '$ku_kd_sifat'");
			$rdtx2 = mysql_fetch_assoc($qdtx2);
			$dtx2_sifat = balikin($rdtx2['sifat']);

			//status
			$qdtx3 = mysql_query("SELECT * FROM surat_m_status ".
											"WHERE kd = '$ku_kd_status'");
			$rdtx3 = mysql_fetch_assoc($qdtx3);
			$dtx3_status = balikin($rdtx3['status']);


			//ruang
			$qdt1 = mysql_query("SELECT * FROM surat_m_ruang ".
											"WHERE kd = '$ku_kd_ruang'");
			$rdt1 = mysql_fetch_assoc($qdt1);
			$dt1_ruang = balikin($rdt1['ruang']);


			//lemari
			$qdt2 = mysql_query("SELECT * FROM surat_m_lemari ".
											"WHERE kd = '$ku_kd_lemari'");
			$rdt2 = mysql_fetch_assoc($qdt2);
			$dt2_lemari = balikin($rdt2['lemari']);


			//rak
			$qdt3 = mysql_query("SELECT * FROM surat_m_rak ".
											"WHERE kd = '$ku_kd_rak'");
			$rdt3 = mysql_fetch_assoc($qdt3);
			$dt3_rak = balikin($rdt3['rak']);


			//map
			$qdt4 = mysql_query("SELECT * FROM surat_m_map ".
											"WHERE kd = '$ku_kd_map'");
			$rdt4 = mysql_fetch_assoc($qdt4);
			$dt4_map = balikin($rdt4['map']);


			//pengesahan disposisi
			$qdux = mysql_query("SELECT * FROM surat_masuk_disposisi ".
						"WHERE kd_surat = '$i_kd'");
			$rdux = mysql_fetch_assoc($qdux);
			$tdux = mysql_num_rows($qdux);
			$dux_pengesahan = nosql($rdux['pengesahan']);


			//sah...?
			if ($dux_pengesahan == "true")
				{
				$dux_pengesahan_ket = "<font color=\"blue\"><strong>SAH</strong>.</font>";
				}
			else
				{
				$dux_pengesahan_ket = "<font color=\"red\"><b>Belum Sah.</b></font>";
				}



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<a href="'.$filenya.'?page='.$page.'&s=edit&sukd='.$i_kd.'" title="EDIT">
			<img src="'.$sumber.'/img/preview.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>
			<a href="masuk_disposisi.php?sukd='.$i_kd.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$dux_pengesahan_ket.'</td>
			<td>'.$i_tgl_terima.'</td>
			<td>'.$i_no_urut.'</td>
			<td>'.$i_no_surat.'</td>
			<td>'.$i_asal.'</td>
			<td>'.$i_tujuan.'</td>
			<td>'.$i_tgl_surat.'</td>
			<td>'.$i_perihal.'</td>
			<td>'.$dtx_klasifikasi.'</td>
			<td>'.$dtx2_sifat.'</td>
			<td>'.$dtx3_status.'</td>
			<td>'.$bls_balas.'</td>
			<td>'.$dt1_ruang.'</td>
			<td>'.$dt2_lemari.'</td>
			<td>'.$dt3_rak.'</td>
			<td>'.$dt4_map.'</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td align="right">Total : <strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</td>
		</tr>
		</table>
		</p>';
		}

	//null
	else
		{
		echo '<p>
		<font color="red"><strong>TIDAK ADA DATA SURAT MASUK</strong></font>
		<p>';
		}
	}

echo '<br>
<br>
<br>
</form>';
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