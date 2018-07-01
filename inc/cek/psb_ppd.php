<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd4_session = nosql($_SESSION['kd4_session']);
$no4_session = nosql($_SESSION['no4_session']);
$nama4_session = balikin($_SESSION['nama4_session']);
$username4_session = nosql($_SESSION['username4_session']);
$ppd_session = nosql($_SESSION['ppd_session']);

$qbw = mysql_query("SELECT * FROM psb_m_login ".
						"WHERE level = '4' ".
						"AND kd = '$kd4_session' ".
						"AND username = '$username4_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd4_session))
	OR (empty($username4_session))
	OR (empty($ppd_session)))
	{
	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	$ke = "$sumber/psb/";
	pekem($pesan,$ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>