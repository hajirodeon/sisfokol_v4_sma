<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd3_session = nosql($_SESSION['kd3_session']);
$username3_session = nosql($_SESSION['username3_session']);
$wwc_session = nosql($_SESSION['wwc_session']);

$qbw = mysql_query("SELECT * FROM psb_m_login ".
						"WHERE level = '3' ".
						"AND kd = '$kd3_session' ".
						"AND username = '$username3_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd3_session))
	OR (empty($username3_session))
	OR (empty($wwc_session)))
	{
	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	$ke = "$sumber/psb/";
	pekem($pesan,$ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>