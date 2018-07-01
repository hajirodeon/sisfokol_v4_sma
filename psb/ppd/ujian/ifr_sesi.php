<?php
session_start();

//fungsi - fungsi
require("../../../inc/config.php");
require("../../../inc/fungsi.php");
$tpl = LoadTpl("../../../template/ifr_sesi.html"); 

nocache;

//nilai
$s = $_REQUEST['s'];
$xsesi = $_SESSION['x_sesi'];
$filenya = "ifr_sesi.php";
$nilai = 1; //per detik refresh

//deteksi
if ($s == "baru")
	{
	if (empty($_SESSION['x_sesi']))
		{
		session_register("x_sesi");
		$_SESSION['x_sesi'] = $nilai;
		}
	else
		{
		$_SESSION['x_sesi'] = $_SESSION['x_sesi'] + $nilai;
		}
	
	echo "<script>location.href='$filenya'</script>";
	}




//isi *START
ob_start();



echo 'Detik Ke-'.$xsesi.'
<script>
setTimeout("location.href=\''.$filenya.'?s=baru\'", '.$nilai.'000);
</script>';


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../../inc/niltpl.php");


//null-kan
exit();
?>