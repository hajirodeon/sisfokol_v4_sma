<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe_session);
session_unset($kd6_session);
session_unset($adm_session);
session_unset($username6_session);
session_unset($pass6_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>