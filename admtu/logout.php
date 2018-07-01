<?php
 



session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe5_session);
session_unset($kd5_session);
session_unset($nip5_session);
session_unset($nm5_session);
session_unset($tu_session);
session_unset($username5_session);
session_unset($pass5_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>