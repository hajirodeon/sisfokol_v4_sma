<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admsurat.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/surat.html");

nocache;

//nilai
$filenya = "kendali_keluar.php";
$judul = "Kartu Kendali Surat Keluar";
$judulku = "[$surat_session : $nip13_session. $nm13_session] ==> $judul";
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





//isi *START
ob_start();


//js
require("../../inc/js/swap.js");
require("../../inc/menu/admsurat.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//daftar surat //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM surat_keluar ".
					"ORDER BY tgl_kirim DESC";
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
	<td width="100"><strong><font color="'.$warnatext.'">Tgl. kirim</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">No. Urut</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Indeks Berkas</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">No. Surat</font></strong></td>
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
	<td width="50"><strong><font color="'.$warnatext.'">Kendali</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Disposisi</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Sah</font></strong></td>
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
		$i_tujuan = balikin2($data['tujuan']);
		$i_tgl_surat = $data['tgl_surat'];
		$i_perihal = balikin2($data['perihal']);
		$i_tgl_kirim = $data['tgl_kirim'];

		$ku_kd_klasifikasi = nosql($data['kd_klasifikasi']);
		$ku_kd_sifat = nosql($data['kd_sifat']);
		$ku_kd_status = nosql($data['kd_status']);
		$ku_blskd = nosql($data['kd_balas']);
		$ku_tgl_surat = $data['tgl_surat'];
		$ku_tgl_kirim = $data['tgl_kirim'];
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
		$qdux = mysql_query("SELECT * FROM surat_keluar_disposisi ".
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


		//indeks berkas
		$qblsx2 = mysql_query("SELECT surat_m_indeks.*, surat_keluar_disposisi.* ".
					"FROM surat_m_indeks, surat_keluar_disposisi ".
					"WHERE surat_keluar_disposisi.kd_indeks = surat_m_indeks.kd ".
					"AND surat_keluar_disposisi.kd_surat = '$i_kd'");
		$rblsx2 = mysql_fetch_assoc($qblsx2);
		$i_blsx2_indeks = balikin($rblsx2['indeks']);



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$i_tgl_kirim.'</td>
		<td>'.$i_no_urut.'</td>
		<td>'.$i_blsx2_indeks.'</td>
		<td>'.$i_no_surat.'</td>
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
		<td>
		<a href="keluar_kendali.php?sukd='.$i_kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>
		<a href="keluar_disposisi.php?sukd='.$i_kd.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>'.$dux_pengesahan_ket.'</td>
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
	<font color="red"><strong>TIDAK ADA DATA SURAT KELUAR</strong></font>
	<p>';
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