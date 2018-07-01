<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe15_session);
session_unset($kd15_session);
session_unset($nip15_session);
session_unset($nm15_session);
session_unset($bk_session);
session_unset($username15_session);
session_unset($pass15_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>