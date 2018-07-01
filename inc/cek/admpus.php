<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd14_session = nosql($_SESSION['kd14_session']);
$no14_session = nosql($_SESSION['no14_session']);
$nip14_session = nosql($_SESSION['nip14_session']);
$nm14_session = balikin2($_SESSION['nm14_session']);
$username14_session = nosql($_SESSION['username14_session']);
$pus_session = nosql($_SESSION['pus_session']);
$pass14_session = nosql($_SESSION['pass14_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_pus.kd ".
			"FROM admin_pus, m_pegawai ".
			"WHERE admin_pus.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd14_session' ".
			"AND m_pegawai.usernamex = '$username14_session' ".
			"AND m_pegawai.passwordx = '$pass14_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd14_session))
	OR (empty($username14_session))
	OR (empty($pass14_session))
	OR (empty($pus_session))
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