<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tipe_session = nosql($_SESSION['tipe_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);
$kd1_session = nosql($_SESSION['kd1_session']);
$no1_session = nosql($_SESSION['no1_session']);
$nm1_session = balikin2($_SESSION['nm1_session']);
$username1_session = nosql($_SESSION['username1_session']);
$pass1_session = nosql($_SESSION['pass1_session']);


/*
//query
$qbw = mysql_query("SELECT * FROM m_user ".
			"WHERE kd = '$kd1_session' ".
			"AND usernamex = '$username1_session' ".
			"AND passwordx = '$pass1_session' ".
			"AND tipe = '$tipe_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

//cek
if (($tbw == 0) OR (empty($kd1_session))
	OR (empty($username1_session))
	OR (empty($pass1_session))
	OR (empty($tipe_session))
	OR (empty($hajirobe_session)))
	{
	//diskonek
	xfree($qbw);
	xclose($koneksi);

	//redirect
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan, $sumber);
	exit();
	}
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>