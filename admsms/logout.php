<?php
session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe17_session);
session_unset($kd17_session);
session_unset($nip17_session);
session_unset($nm17_session);
session_unset($sms_session);
session_unset($username17_session);
session_unset($pass17_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>