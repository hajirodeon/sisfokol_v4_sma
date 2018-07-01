<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe2_session);
session_unset($kd2_session);
session_unset($nis2_session);
session_unset($nm2_session);
session_unset($siswa_session);
session_unset($username2_session);
session_unset($pass2_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>