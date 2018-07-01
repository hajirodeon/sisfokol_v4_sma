<?php 


session_start();

//ambil nilai
require("../../inc/config.php"); 
require("../../inc/fungsi.php"); 
require("../../inc/koneksi.php"); 
require("../../inc/class/paging.php"); 
require("../../inc/cek/psb_adm.php"); 
$tpl = LoadTpl("../../template/index.html"); 


nocache;

//nilai
$filenya = "berita.php";
$judul = "Berita";
$judulku = "$judul  [$adm_session]";
$s = nosql($_REQUEST['s']);
$brkd = nosql($_REQUEST['brkd']);

//focus
$diload = "document.formx.judul.focus();";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika edit
if ($s == "edit")
	{
	//query
	$qdt = mysql_query("SELECT * FROM psb_berita ".
							"WHERE kd = '$brkd'");
	$rdt = mysql_fetch_assoc($qdt);
	$d_judul = balikin($rdt['judul']);
	$d_isi = balikin($rdt['isi']);
	}




//jika hapus
if ($s == "hapus")
	{
	//hapus query
	mysql_query("DELETE FROM psb_berita ".
					"WHERE kd = '$brkd'");

	//re-direct
	$ke = "berita.php";
	xloc($ke);
	exit();
	}





//jika batal
if ($_POST['btnBTL'])
	{
	//re-direct
	$ke = "berita.php";
	xloc($ke);
	exit();
	}
	
	
	
	
	
//jika simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$judul = cegah2($_POST['judul']);
	$isi = cegah2($_POST['isi']);
	$s = nosql($_POST['s']);
	$brkd = nosql($_POST['brkd']);
	
	
	//jika edit
	if ($s == "edit")
		{
		//update
		mysql_query("UPDATE psb_berita SET judul = '$judul', ".
						"isi = '$isi' ".
						"WHERE kd = '$brkd'");
			
		//re-direct
		$ke = "berita.php";
		xloc($ke);
		exit();
		}
	
	
	//jika baru
	if ($s == "baru")
		{			
		//cek null
		if ((empty($judul)) OR (empty($isi)))
			{
			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
			$ke = "$filenya?s=baru&brkd=$brkd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//cek
			$qcc = mysql_query("SELECT * FROM psb_berita ".
									"WHERE judul = '$judul'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
			
			//nek ada
			if ($tcc != 0)
				{
				//re-direct
				$pesan = "Berita Tersebut Sudah Ada. Harap Diperhatikan...!!";
				$ke = "$filenya?s=baru&brkd=$brkd";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//entry
				mysql_query("INSERT INTO psb_berita(kd, judul, isi, postdate) VALUES ".
								"('$brkd', '$judul', '$isi', '$today')");
				
				//re-direct	
				$ke = "berita.php";	
				xloc($ke);
				exit();
				}
			}
		}	
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//isi *START
ob_start();

//menu
require("../../inc/menu/psb_adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
[<a href="berita.php?s=baru&brkd='.$x.'" title="Tulis Berita">Tulis Berita</a>]
<br>
<br>';


//jika baru ato edit
if (($s == "baru") OR ($s == "edit"))
	{
	echo '<table border="0" cellspacing="3" cellpadding="0">
	<tr valign="top">
	<td width-"100">
	Judul :
	<br>
	<input name="judul" type="text" value="'.$d_judul.'" size="75">
	<br>
	<br>
	
	Isi Berita :
	<br>
	<textarea name="isi" cols="75" rows="10" wrap="virtual">'.$d_isi.'</textarea>
	<br>
	<br>
	
	<input name="s" type="hidden" value="'.$s.'">
	<input name="brkd" type="hidden" value="'.$brkd.'">
	<input name="btnBTL" type="submit" value="BATAL">
	<input name="btnSMP" type="submit" value="SIMPAN">
	</td>
	</tr>
	</table>';
	}
else
	{
	//query
	$p = new Pager();
	$start = $p->findStart($limit);
	
	$sqlcount = "SELECT * FROM psb_berita ".
					"ORDER BY postdate DESC";
	$sqlresult = $sqlcount;	
		
	$count = mysql_num_rows(mysql_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysql_fetch_array($result);
	
	
	if ($count != 0)
		{
		echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">';
	
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
				
			$d_kd = nosql($data['kd']);
			$d_judul = balikin2($data['judul']);
			$d_isi = balikin($data['isi']);
			$d_postdate = $data['postdate'];
				
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";	
			echo '<td>
			<strong>'.$d_judul.'</strong>
			<br>
			'.$d_isi.', 
			<br>
			[<a href="berita.php?s=edit&brkd='.$d_kd.'">EDIT</a>] - 
			[<a href="berita.php?s=hapus&brkd='.$d_kd.'">HAPUS</a>] - 
			<em>Postdate : '.$d_postdate.'</em>
			</td>
	        </tr>';				
			} 
		while ($data = mysql_fetch_assoc($result)); 
		
		echo '</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
		<tr> 
		<td align="right">'.$pagelist.' <strong><font color="#FF0000">'.$count.'</font></strong> Komentar.</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<font color="red"><strong>Belum Ada Berita. Silahkan Anda Tulis...!!</strong></font>';
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
xclose($koneksi);
exit();
?>