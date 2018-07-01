<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd1_session = nosql($_SESSION['kd1_session']);
$username1_session = nosql($_SESSION['username1_session']);
$adm_session = nosql($_SESSION['adm_session']);

$qbw = mysql_query("SELECT * FROM psb_m_login ".
						"WHERE level = '1' ".
						"AND kd = '$kd1_session' ".
						"AND username = '$username1_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd1_session))
	OR (empty($username1_session))
	OR (empty($adm_session)))
	{
	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	$ke = "$sumber/psb/";
	pekem($pesan,$ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>