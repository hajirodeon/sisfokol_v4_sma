<?php 


session_start();

//ambil nilai
require("../../inc/config.php"); 
require("../../inc/fungsi.php"); 

nocache;

//hapus session
session_unset($kd1_session);
session_unset($adm_session);
session_unset($username1_session);

session_unregister('$kd1_session');
session_unregister('$adm_session');
session_unregister('$username1_session');

//re-direct
$ke = "$sumber/psb/";
xloc($ke);
exit();
?>