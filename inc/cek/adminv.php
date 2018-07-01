<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd12_session = nosql($_SESSION['kd12_session']);
$no12_session = nosql($_SESSION['no12_session']);
$nip12_session = nosql($_SESSION['nip12_session']);
$nm12_session = balikin2($_SESSION['nm12_session']);
$username12_session = nosql($_SESSION['username12_session']);
$inv_session = nosql($_SESSION['inv_session']);
$pass12_session = nosql($_SESSION['pass12_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_inv.kd ".
			"FROM admin_inv, m_pegawai ".
			"WHERE admin_inv.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd12_session' ".
			"AND m_pegawai.usernamex = '$username12_session' ".
			"AND m_pegawai.passwordx = '$pass12_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd12_session))
	OR (empty($username12_session))
	OR (empty($pass12_session))
	OR (empty($inv_session))
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