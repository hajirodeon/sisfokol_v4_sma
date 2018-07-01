<?php
//cek user SISWA
$qswa = mysql_query("SELECT * FROM m_user ".
			"WHERE kd = '$kd1_session' ".
			"AND tipe = 'SISWA'");
$rswa = mysql_fetch_assoc($qswa);
$tswa = mysql_num_rows($qswa);

//jika bukan
if ($tswa == 0)
	{
	//re-direct
	$pesan = "Anda Bukan Seorang Siswa. Terima Kasih.";
	$ke = "$sumber/janissari/index.php";
	pekem($pesan,$ke);
	exit();
	}
?>