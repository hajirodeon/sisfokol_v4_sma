<?php
///cek session //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$kd13_session = nosql($_SESSION['kd13_session']);
$no13_session = nosql($_SESSION['no13_session']);
$nip13_session = nosql($_SESSION['nip13_session']);
$nm13_session = balikin2($_SESSION['nm13_session']);
$username13_session = nosql($_SESSION['username13_session']);
$surat_session = nosql($_SESSION['surat_session']);
$pass13_session = nosql($_SESSION['pass13_session']);
$hajirobe_session = nosql($_SESSION['hajirobe_session']);

$qbw = mysql_query("SELECT admin_surat.kd ".
			"FROM admin_surat, m_pegawai ".
			"WHERE admin_surat.kd_pegawai = m_pegawai.kd ".
			"AND m_pegawai.kd = '$kd13_session' ".
			"AND m_pegawai.usernamex = '$username13_session' ".
			"AND m_pegawai.passwordx = '$pass13_session'");
$rbw = mysql_fetch_assoc($qbw);
$tbw = mysql_num_rows($qbw);

if (($tbw == 0) OR (empty($kd13_session))
	OR (empty($username13_session))
	OR (empty($pass13_session))
	OR (empty($surat_session))
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