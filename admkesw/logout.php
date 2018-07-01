<?php
 



session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe10_session);
session_unset($kd10_session);
session_unset($nip10_session);
session_unset($nm10_session);
session_unset($kesw_session);
session_unset($username10_session);
session_unset($pass10_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>