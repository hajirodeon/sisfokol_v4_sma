<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe14_session);
session_unset($kd14_session);
session_unset($nip14_session);
session_unset($nm14_session);
session_unset($pus_session);
session_unset($username14_session);
session_unset($pass14_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>