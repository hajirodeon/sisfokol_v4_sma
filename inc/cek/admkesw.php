<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd10_session = nosql($_SESSION['kd10_session']);
$no10_session = nosql($_SESSION['no10_session']);
$nip10_session = nosql($_SESSION['nip10_session']);
$nm10_session = balikin2($_SESSION['nm10_session']);
$username10_session = nosql($_SESSION['username10_session']);
$kesw_session = nosql($_SESSION['kesw_session']);
$pass10_session = nosql($_SESSION['pass10_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_kesw.kd ".
			"FROM admin_kesw, m_pegawai ".
			"WHERE admin_kesw.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd10_session' ".
			"AND m_pegawai.usernamex = '$username10_session' ".
			"AND m_pegawai.passwordx = '$pass10_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd10_session))
	OR (empty($username10_session))
	OR (empty($pass10_session))
	OR (empty($kesw_session))
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