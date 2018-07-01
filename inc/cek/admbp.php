<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd15_session = nosql($_SESSION['kd15_session']);
$no15_session = nosql($_SESSION['no15_session']);
$nip15_session = nosql($_SESSION['nip15_session']);
$nm15_session = balikin2($_SESSION['nm15_session']);
$username15_session = nosql($_SESSION['username15_session']);
$bk_session = $_SESSION['bk_session'];
$pass15_session = nosql($_SESSION['pass15_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_bk.kd ".
			"FROM admin_bk, m_pegawai ".
			"WHERE admin_bk.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd15_session' ".
			"AND m_pegawai.usernamex = '$username15_session' ".
			"AND m_pegawai.passwordx = '$pass15_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd15_session))
	OR (empty($username15_session))
	OR (empty($pass15_session))
	OR (empty($bk_session))
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