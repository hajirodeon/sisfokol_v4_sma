<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd3_session = nosql($_SESSION['kd3_session']);
$no3_session = nosql($_SESSION['no3_session']);
$nip3_session = nosql($_SESSION['nip3_session']);
$nm3_session = balikin2($_SESSION['nm3_session']);
$username3_session = nosql($_SESSION['username3_session']);
$wk_session = nosql($_SESSION['wk_session']);
$pass3_session = nosql($_SESSION['pass3_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT m_walikelas.kd ".
			"FROM m_walikelas, m_pegawai ".
			"WHERE m_walikelas.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd3_session' ".
			"AND m_pegawai.usernamex = '$username3_session' ".
			"AND m_pegawai.passwordx = '$pass3_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd3_session))
	OR (empty($username3_session))
	OR (empty($nip3_session))
	OR (empty($nm3_session))
	OR (empty($pass3_session))
	OR (empty($wk_session))
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