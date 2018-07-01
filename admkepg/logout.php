<?php
 



session_start();

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

//hapus session
session_unset($hajirobe11_session);
session_unset($kd11_session);
session_unset($nip11_session);
session_unset($nm11_session);
session_unset($kepg_session);
session_unset($username11_session);
session_unset($pass11_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>