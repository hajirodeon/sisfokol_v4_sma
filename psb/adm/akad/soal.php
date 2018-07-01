<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php");
require("../../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "soal.php";
$judul = "Data Soal Ujian Online";
$judulku = "[$adm_session] ==> $judul";
$judulx = $judul;
$mapelkd = nosql($_REQUEST['mapelkd']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus
//nek null
if (empty($mapelkd))
	{
	$diload = "document.formx.mapel.focus();";
	}
else
	{
	$diload = "document.formx.y_no.focus();";
	}




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$mapelkd = nosql($_POST['mapelkd']);

	//ambil semua
	for ($i=1; $i<=$limit;$i++) 
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);
	
	
		//del
		mysql_query("DELETE FROM psb_m_soal ".
						"WHERE kd_mapel = '$mapelkd' ".
						"AND kd = '$kd'");
		
		
		//query
		$qcc = mysql_query("SELECT * FROM psb_m_soal_filebox ".
								"WHERE kd_mapel = '$mapelkd'");
		$rcc = mysql_fetch_assoc($qcc);
			
		do
			{
			//hapus file
			$cc_filex = $rcc['filex'];
			$path1 = "../../../filebox/soal/$soalkd/$cc_filex";
			unlink ($path1);	
			}
		while ($rcc = mysql_fetch_assoc($qcc));
		
		//hapus query
		mysql_query("DELETE FROM psb_m_soal_filebox ".
						"WHERE kd_mapel = '$mapelkd' ".
						"AND kd_soal = '$kd'");
		
		//nek $kd gak null
		if (!empty($kd))
			{
			//hapus folder
			$path2 = "../../../filebox/soal/$kd";
			delete ($path2);
			}
		}

	//auto-kembali
	$ke = "$filenya?mapelkd=$mapelkd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/checkall.js"); 
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_adm.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaover.'">
<td>
Mata Pelajaran : ';
echo "<select name=\"mapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qmpx = mysql_query("SELECT * FROM psb_m_mapel ".
						"WHERE kd = '$mapelkd'");
$rowmpx = mysql_fetch_assoc($qmpx);
$mpx_kd = nosql($rowmpx['kd']);
$mpx_mapel = balikin($rowmpx['mapel']);

echo '<option value="'.$mpx_kd.'">'.$mpx_mapel.'</option>';

$qmp = mysql_query("SELECT * FROM psb_m_mapel ".
						"WHERE kd <> '$mapelkd' ".
						"ORDER BY mapel ASC");
$rowmp = mysql_fetch_assoc($qtp);
				
do
	{
	$d_mpkd = nosql($rowmp['kd']);
	$d_mapel = balikin($rowmp['mapel']);

	echo '<option value="'.$filenya.'?mapelkd='.$d_mpkd.'">'.$d_mapel.'</option>';
	}
while ($rowmp = mysql_fetch_assoc($qmp));

echo '</select>
</td>
</tr>
</table>';

//nek blm dipilih
if (empty($mapelkd))
	{
	echo '<font color="#FF0000"><strong>MATA PELAJARAN Belum Dipilih...!</strong></font>';
	}
else
	{
	echo '<p>
	[<a href="soal_post.php?mapelkd='.$mapelkd.'&soalkd='.$x.'&s=baru">Input Soal Baru</a>].
	</p>';
	
	
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlcount = "SELECT * FROM psb_m_soal ".
					"WHERE kd_mapel = '$mapelkd' ".
					"ORDER BY round(no) ASC";
	$sqlresult = $sqlcount;
			
	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?mapelkd=$mapelkd";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	
	if ($count != 0)
		{
		echo '<p>
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
		<tr align="center" bgcolor="'.$warnaheader.'">
		<td width="1">&nbsp;</td>
		<td width="1">&nbsp;</td>
		<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Isi Soal</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Kunci Jawaban</font></strong></td>
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
			$kd = nosql($data['kd']);
			$d_no = nosql($data['no']);
			$d_isi = balikin($data['isi']);
			$d_kunci = nosql($data['kunci']);
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td> 
			<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'"> 
	        </td>
			<td>
			<a href="soal_post.php?s=edit&mapelkd='.$mapelkd.'&soalkd='.$kd.'&page='.$page.'">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$d_no.'.</td>
			<td>
			'.$d_isi.'
			</td>
			<td><strong>'.$d_kunci.'</strong></td>
	        </tr>';				
			} 
		while ($data = mysql_fetch_assoc($result)); 
		
	
		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr> 
		<td width="263">
		<input name="jml" type="hidden" value="'.$count.'"> 
		<input name="s" type="hidden" value="'.$s.'"> 
		<input name="kd" type="hidden" value="'.$kdx.'"> 
		<input name="mapelkd" type="hidden" value="'.$mapelkd.'"> 
		<input name="page" type="hidden" value="'.$page.'"> 
		<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')"> 
		<input name="btnBTL" type="submit" value="BATAL"> 
		<input name="btnHPS" type="submit" value="HAPUS"> 
		</td>
		<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
		</tr>
		</table>
		</p>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>Belum Ada Data Soal. Silahkan Entry...</strong>
		</font>
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

require("../../../inc/niltpl.php");



//diskonek
xclose($koneksi);
exit();
?>