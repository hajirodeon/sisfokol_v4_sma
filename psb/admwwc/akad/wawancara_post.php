<?php 





session_start();

require("../../../inc/config.php"); 
require("../../../inc/fungsi.php"); 
require("../../../inc/koneksi.php"); 
require("../../../inc/cek/psb_admwwc.php"); 
$tpl = LoadTpl("../../../template/index.html"); 

nocache;

//nilai
$filenya = "wawancara_post.php";
$judul = "Input/Edit Soal Wawancara";
$judulku = "[$wwc_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}




//focus
$diload = "document.formx.y_no.focus();";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//nilai
	$page = nosql($_POST['page']);
	
	
	//re-direct
	$ke = "wawancara.php?page=$page";
	xloc($ke);
	exit();
	}





//jika edit
if ($s == "edit")
	{
	//nilai
	$kdx = nosql($_REQUEST['kd']);
	$page= nosql($_REQUEST['page']);
	
	//query soal
	$qx = mysql_query("SELECT * FROM psb_m_wwc ".
						"WHERE kd = '$kdx'");
	$rowx = mysql_fetch_assoc($qx);
						
	$x_no = nosql($rowx['no']);
	$x_soal = balikin($rowx['soal']);
	}
	
	


	
//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$s = nosql($_POST['s']);
	$kd = nosql($_POST['kd']);
	$page = nosql($_POST['page']);
	$x_no = nosql($_POST['y_no']);
	$x_soal = cegah($_POST['y_soal']);
		
	//nek null
	if ((empty($x_no)) OR (empty($x_soal)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?s=baru";
		pekem($pesan,$ke);
		exit();
		}
	else
		{ 
		//jika baru
		if ($s == "baru")
			{
			///cek
			$qcc = mysql_query("SELECT * FROM psb_m_wwc ".
									"WHERE soal = '$x_soal'");
			$rcc = mysql_fetch_assoc($qcc);
			$tcc = mysql_num_rows($qcc);
				
			//nek ada
			if ($tcc != 0)
				{
				//re-direct	
				$pesan = "Soal Tersebut Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?s=baru";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//insert soal
				mysql_query("INSERT INTO psb_m_wwc(kd, no, soal) VALUES ".
								"('$x', '$x_no', '$x_soal')");		
											
								
								
				//insert opsi
				//looping
				for($i=1;$i<=3;$i++)
					{
					$xx = md5("$x$i");
					
					$opsix = "opsi";
					$opsix2 = "$opsix$i";
					$opsix3 = cegah2($_POST[$opsix2]);
					
					$skorx = "skor";
					$skorx2 = "$skorx$i";
					$skorx3 = nosql($_POST[$skorx2]);
										
					//insert opsi								
					mysql_query("INSERT INTO psb_m_wwc_opsi(kd, kd_wwc, opsi, skor) VALUES ".
								"('$xx', '$x', '$opsix3', '$skorx3')");		
					}
				
				
				//re-direct
				$ke = "wawancara.php";
				xloc($ke);
				exit();
				}
			}
			

		//jika update
		else if ($s == "edit")
			{
			//update soal
			mysql_query("UPDATE psb_m_wwc SET no = '$x_no', ".
							"soal = '$x_soal' ".
							"WHERE kd = '$kd'");
			
			//update opsi
			//looping
			for($i=1;$i<=3;$i++)
				{
				$pkdx = "pkd";
				$pkdx2 = "$pkdx$i";
				$pkdx3 = nosql($_POST[$pkdx2]);

				$opsix = "opsi";
				$opsix2 = "$opsix$i";
				$opsix3 = cegah2($_POST[$opsix2]);
					
				$skorx = "skor";
				$skorx2 = "$skorx$i";
				$skorx3 = nosql($_POST[$skorx2]);
										
				//update
				mysql_query("UPDATE psb_m_wwc_opsi SET opsi = '$opsix3', ".
								"skor = '$skorx3' ".
								"WHERE kd_wwc = '$kd' ".
								"AND kd = '$pkdx3'");												
				}
							
			//re-direct
			$ke = "wawancara.php?page=$page";
			xloc($ke);
			exit();
			}
		}	
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();



//js
require("../../../inc/js/jumpmenu.js");
require("../../../inc/js/number.js"); 
require("../../../inc/js/swap.js"); 
require("../../../inc/menu/psb_admwwc.php"); 
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
No. : 
<input name="y_no" type="text" value="'.$x_no.'" size="3" onKeyPress="return numbersonly(this, event)">, 
<br>

Soal : 
<br>
<textarea name="y_soal" cols="50" rows="5" wrap="VIRTUAL">'.$x_soal.'</textarea>
<br>
<br>';


//jika edit
$qedt = mysql_query("SELECT * FROM psb_m_wwc_opsi ".
						"WHERE kd_wwc = '$kdx'");
$redt = mysql_fetch_assoc($qedt);
$tedt = mysql_num_rows($qedt);

if ($tedt != 0)
	{
	do
		{
		//nilai
		$nomerx = $nomerx + 1;
		$x_kd = nosql($redt['kd']);
		$x_pil = balikin($redt['opsi']);
		$x_skor = nosql($redt['skor']);
		
		echo 'Pilihan #0'.$nomerx.' : 
		<br>
		<input name="pkd'.$nomerx.'" type="hidden" value="'.$x_kd.'">
		<input name="opsi'.$nomerx.'" type="text" value="'.$x_pil.'" size="50">, 
		Skor : <input name="skor'.$nomerx.'" type="text" value="'.$x_skor.'" size="1" maxlength="1" onKeyPress="return numbersonly(this, event)"> 
		<br>
		<br>';
		}
	while ($redt = mysql_fetch_assoc($qedt));
	}
else //jika baru
	{
	for ($i=1;$i<=3;$i++)
		{
		//nilai
		$nomerx = $nomerx + 1;
		
		echo 'Pilihan #0'.$nomerx.' : 
		<br>
		<input name="opsi'.$nomerx.'" type="text" value="" size="50">, 
		Skor : <input name="skor'.$nomerx.'" type="text" value="" size="1" maxlength="1" onKeyPress="return numbersonly(this, event)"> 
		<br>
		<br>';
		}
	}


echo '<input name="jml" type="hidden" value="'.$count.'"> 
<input name="s" type="hidden" value="'.$s.'"> 
<input name="kd" type="hidden" value="'.$kdx.'"> 
<input name="page" type="hidden" value="'.$page.'"> 
<input name="btnSMP" type="submit" value="SIMPAN">
<input name="btnBTL" type="submit" value="BATAL">
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