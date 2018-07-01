<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe9_session);
session_unset($kd9_session);
session_unset($nip9_session);
session_unset($nm9_session);
session_unset($waka_session);
session_unset($username9_session);
session_unset($pass9_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>