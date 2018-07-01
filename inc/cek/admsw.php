<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd2_session = nosql($_SESSION['kd2_session']);
$kd1_session = nosql($_SESSION['kd1_session']);
$no2_session = nosql($_SESSION['no2_session']);
$no1_session = nosql($_SESSION['no1_session']);
$nis2_session = nosql($_SESSION['nis2_session']);
$username2_session = nosql($_SESSION['username2_session']);
$siswa_session = nosql($_SESSION['siswa_session']);
$nm2_session = balikin2($_SESSION['nm2_session']);
$nm1_session = balikin2($_SESSION['nm1_session']);
$pass2_session = nosql($_SESSION['pass2_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT kd FROM m_siswa ".
			"WHERE kd = '$kd2_session' ".
			"AND usernamex = '$username2_session' ".
			"AND passwordx = '$pass2_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd2_session))
	OR (empty($username2_session))
	OR (empty($nis2_session))
	OR (empty($pass2_session))
	OR (empty($siswa_session))
	OR (empty($hajirobe_session)))
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan, $sumber);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>