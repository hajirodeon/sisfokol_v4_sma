<?php
 



session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe12_session);
session_unset($kd12_session);
session_unset($nip12_session);
session_unset($nm12_session);
session_unset($inv_session);
session_unset($username12_session);
session_unset($pass12_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>