<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe1_session);
session_unset($kd1_session);
session_unset($nip1_session);
session_unset($nm1_session);
session_unset($guru_session);
session_unset($username1_session);
session_unset($pass1_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>