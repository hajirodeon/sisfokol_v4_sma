<?php
session_start();

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admpus.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pinjam_item.php";
$judul = "Rekap per Item";
$judulku = "[$pus_session : $nip14_session. $nm14_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$itemkd = nosql($_REQUEST['itemkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}






//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika detail
if ($_POST['btnDTI'])
	{
	//nilai
	$item_kd = nosql($_POST['item_kd']);

	//cek
	if (empty($item_kd))
		{
		//re-direct
		$pesan = "Silahkan Tentukan Dahulu Item Barangnya...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//re-direct
		$ke = "$filenya?itemkd=$item_kd";
		xloc($ke);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();




//js
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
require("../../inc/js/number.js");
require("../../inc/menu/admpus.php");
xheadline($judul);


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<script type="text/javascript" src="'.$sumber.'/inc/js/dhtmlwindow_pus.js"></script>
<script type="text/javascript" src="'.$sumber.'/inc/js/modal.js"></script>
<script type="text/javascript">
function open_brg()
	{
	brg_window=dhtmlmodal.open(\'Daftar Item\',
	\'iframe\',
	\'popup_item.php\',
	\'Daftar Item\',
	\'width=550px,height=350px,center=1,resize=0,scrolling=0\')

	brg_window.onclose=function()
		{
		var item_kd=this.contentDoc.getElementById("item_kd");
		var item_nama=this.contentDoc.getElementById("item_nama");

		document.formx.item_kd.value=item_kd.value;
		document.formx.item_nama.value=item_nama.value;
		return true
		}
	}
</script>';


//terpilih
$qedt = mysql_query("SELECT * FROM perpus_item ".
						"WHERE kd = '$itemkd'");
$redt = mysql_fetch_assoc($qedt);
$edt_kd = nosql($redt['kd']);
$edt_nama = balikin2($redt['judul']);
$edt_kode = nosql($redt['kode']);

echo '<p>
Item :
<input name="item_nama" type="text" value="'.$edt_kode.'. '.$edt_nama.'" size="50" class="input" readonly>
<input name="btnITEM" type="button" value="..." onClick="open_brg(); return false">
<input name="item_kd" type="hidden" value="'.$edt_kd.'">
<input name="btnDTI" type="submit" value="DETAIL >>">
</p>';


//detail item
if (!empty($itemkd))
	{
	//cek
	$qcc = mysql_query("SELECT * FROM perpus_item ".
							"WHERE kd = '$itemkd'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//ada...?
	if ($tcc != 0)
		{
		//daftar perminjam
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%d') AS p_tgl, ".
						"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%m') AS p_bln, ".
						"DATE_FORMAT(perpus_pinjam.tgl_pinjam, '%Y') AS p_thn, ".
						"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%d') AS k_tgl, ".
						"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%m') AS k_bln, ".
						"DATE_FORMAT(perpus_pinjam.tgl_kembali, '%Y') AS k_thn, ".
						"perpus_pinjam.* ".
						"FROM perpus_pinjam ".
						"WHERE kd_item = '$itemkd' ".
						"ORDER BY tgl_pinjam DESC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?itemkd=$itemkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);


		//jika ada
		if ($count != 0)
			{
			echo '<table width="900" border="1" cellspacing="0" cellpadding="3">
			<tr bgcolor="'.$warnaheader.'">
			<td width="150"><strong><font color="'.$warnatext.'">Tgl. Pinjam</font></strong></td>
			<td width="150"><strong><font color="'.$warnatext.'">Tgl. Kembali</font></strong></td>
			<td width="50"><strong><font color="'.$warnatext.'">Jumlah Item</font></strong></td>
			<td><strong><font color="'.$warnatext.'">Peminjam</font></strong></td>
			<td width="200"><strong><font color="'.$warnatext.'">Status</font></strong></td>
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
				$nox = $nox + 1;
				$d_userkd = nosql($data['kd_user']);
				$d_p_tgl = nosql($data['p_tgl']);
				$d_p_bln = nosql($data['p_bln']);
				$d_p_thn = nosql($data['p_thn']);
				$d_k_tgl = nosql($data['k_tgl']);
				$d_k_bln = nosql($data['k_bln']);
				$d_k_thn = nosql($data['k_thn']);
				$d_jml = nosql($data['jml']);
				$d_status = nosql($data['status']);


				//user... pegawai...?.
				$qsuk = mysql_query("SELECT * FROM m_pegawai ".
										"WHERE kd = '$d_userkd'");
				$rsuk = mysql_fetch_assoc($qsuk);
				$tsuk = mysql_num_rows($qsuk);

				//jika pegawai
				if ($tsuk != 0)
					{
					//nilai
					$suk_tipe = "<font color=\"red\"><strong>Pegawai</strong></font>";
					$suk_nip = nosql($rsuk['nip']);
					$suk_nama = balikin2($rsuk['nama']);
					$suk_detail = "[$suk_tipe]. $suk_nip. $suk_nama";
					}
				else
					{
					//user... siswa...?.
					$qsuk = mysql_query("SELECT * FROM m_siswa ".
											"WHERE kd = '$d_userkd'");
					$rsuk = mysql_fetch_assoc($qsuk);
					$tsuk = mysql_num_rows($qsuk);

					//nilai
					$suk_tipe = "<font color=\"blue\"><strong>Siswa</strong></font>";
					$suk_nis = nosql($rsuk['nis']);
					$suk_nama = balikin2($rsuk['nama']);
					$suk_detail = "[$suk_tipe]. $suk_nis. $suk_nama";
					}



				//status
				if ($d_status == "true")
					{
					$d_status_ket = "<font color=\"blue\"><strong>Sedang Pinjam...</strong></font>";
					}
				else
					{
					$d_status_ket = "<font color=\"red\"><strong>Pernah Pinjam.</strong></font>";
					}


				echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
				echo '<td>'.$d_p_tgl.' '.$arrbln1[$d_p_bln].' '.$d_p_thn.'</td>
				<td>'.$d_k_tgl.' '.$arrbln1[$d_k_bln].' '.$d_k_thn.'</td>
				<td>'.$d_jml.'</td>
				<td>'.$suk_detail.'</td>
				<td>'.$d_status_ket.'</td>
				</tr>';
				}
			while ($data = mysql_fetch_assoc($result));

			echo '</tr>
			</table>

			<table width="900" border="0" cellspacing="0" cellpadding="3">
			<tr>
			<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
			</tr>
			</table>';
			}
		else
			{
			echo '<p>
			<font color="red">
			<strong>Tidak Ada Peminjam Item Ini. . .</strong>
			</font>
			</p>';
			}
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>Item Tersebut Tidak Ada. Harap Diperhatikan...!!</strong>
		</font>
		</p>';
		}
	}
else
	{
	echo '<p>
	<font color="red">
	<strong>Tentukan Dahulu Item Barangnya. . .</strong>
	</font>
	</p>';
	}

echo '</form>';
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