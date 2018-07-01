<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe13_session);
session_unset($kd13_session);
session_unset($xkd13_session);
session_unset($nip13_session);
session_unset($nm13_session);
session_unset($surat_session);
session_unset($username13_session);
session_unset($pass13_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>