<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL_SLTP_v3.0_(cegunan)_DONASI         ///////
/////// (Sistem Informasi Sekolah untuk SLTP)       ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh : 								///////
/////// Agus Muhajir, S.Kom 						///////
/////// URL 	: http://sisfokol.wordpress.com 	///////
/////// E-Mail	: 									///////
///////		* hajirodeon@yahoo.com 					///////
///////		* hajirodeon@gmail.com					///////
/////// HP/SMS	: 081-829-88-54 					///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////




session_start();

//ambil nilai
require("../inc/config.php"); 
require("../inc/fungsi.php"); 

nocache;

//hapus session
session_unset($hajirobe8_session);
session_unset($kd8_session);
session_unset($nip8_session);
session_unset($nm8_session);
session_unset($bdh_session);
session_unset($username8_session);
session_unset($pass8_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>