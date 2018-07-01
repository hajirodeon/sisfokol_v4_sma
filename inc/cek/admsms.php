<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd17_session = nosql($_SESSION['kd17_session']);
$no17_session = nosql($_SESSION['no17_session']);
$nip17_session = nosql($_SESSION['nip17_session']);
$nm17_session = balikin2($_SESSION['nm17_session']);
$username17_session = nosql($_SESSION['username17_session']);
$sms_session = nosql($_SESSION['sms_session']);
$pass17_session = nosql($_SESSION['pass17_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_sms.kd ".
			"FROM admin_sms, m_pegawai ".
			"WHERE admin_sms.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd17_session' ".
			"AND m_pegawai.usernamex = '$username17_session' ".
			"AND m_pegawai.passwordx = '$pass17_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd17_session))
	OR (empty($username17_session))
	OR (empty($pass17_session))
	OR (empty($sms_session))
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