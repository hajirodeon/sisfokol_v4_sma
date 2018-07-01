<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/class/paging.php");
require("../../../inc/cek/psb_admwwc.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "wawancara.php";
$judul = "Data Soal Wawancara";
$judulku = "[$wwc_session] ==> $judul";
$judulx = $judul;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}



//focus
$diload = "document.formx.y_no.focus();";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$jml = nosql($_POST['jml']);

	//ambil semua
	for ($i=1; $i<=$jml;$i++) 
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);
	
		//del wawancara
		mysql_query("DELETE FROM psb_m_wwc ".
						"WHERE kd = '$kd'");
		
		//del opst wawancara
		mysql_query("DELETE FROM psb_m_wwc_opsi ".
						"WHERE kd_wwc = '$kd'");		
		}

	//auto-kembali
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/checkall.js"); 
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_admwwc.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">';

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT * FROM psb_m_wwc ".
				"ORDER BY round(no) ASC";
$sqlresult = $sqlcount;
		
$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);
	
	
echo '<br>
[<a href="wawancara_post.php?s=baru">Input Baru</a>].
<table width="750" border="1" cellspacing="0" cellpadding="3">
<tr align="center" bgcolor="'.$warnaheader.'">
<td width="1">&nbsp;</td>
<td width="1">&nbsp;</td>
<td width="1"><strong><font color="'.$warnatext.'">No.</font></strong></td>
<td><strong><font color="'.$warnatext.'">Isi Soal</font></strong></td>
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
		$kd = nosql($data['kd']);
		$d_no = nosql($data['no']);
		$d_soal = balikin($data['soal']);
		
		//opsinya
		$qpo = mysql_query("SELECT * FROM psb_m_wwc_opsi ".
								"WHERE kd_wwc = '$kd' ".
								"ORDER BY skor DESC");
		$rpo = mysql_fetch_assoc($qpo);		
		
		
		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td> 
		<input type="checkbox" name="item'.$nomer.'" value="'.$kd.'"> 
        </td>
		<td>
		<a href="wawancara_post.php?s=edit&kd='.$kd.'&page='.$page.'">
		<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
		</a>
		</td>
		<td>'.$d_no.'</td>
		<td>
		'.$d_soal.'
		<br>
		<br>';
		
		//opsi
		do
			{
			//nilai
			$x_opsi = balikin($rpo['opsi']);
			$x_skor = nosql($rpo['skor']);
			
			echo "<strong>* </strong>$x_opsi. 
			<br>
			[Skor:<strong>$x_skor</strong>].
			<br>
			<br>";
			}
		while ($rpo = mysql_fetch_assoc($qpo));
		
		
		echo '</td>
        </tr>';				
		}
	while ($data = mysql_fetch_assoc($result)); 
	}

echo '</table>
<table width="750" border="0" cellspacing="0" cellpadding="3">
<tr> 
<td width="263">
<input name="jml" type="hidden" value="'.$count.'"> 
<input name="s" type="hidden" value="'.$s.'"> 
<input name="kd" type="hidden" value="'.$kdx.'"> 
<input name="page" type="hidden" value="'.$page.'"> 
<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$count.')"> 
<input name="btnBTL" type="submit" value="BATAL"> 
<input name="btnHPS" type="submit" value="HAPUS"> 
</td>
<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Data.</td>
</tr>
</table>
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