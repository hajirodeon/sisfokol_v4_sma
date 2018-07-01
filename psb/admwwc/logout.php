<?php 


session_start();

//ambil nilai
require("../../inc/config.php"); 
require("../../inc/fungsi.php"); 

nocache;

//hapus session
session_unset($kd3_session);
session_unset($wwc_session);
session_unset($username3_session);

session_unregister('$kd3_session');
session_unregister('$wwc_session');
session_unregister('$username3_session');

//re-direct
$ke = "$sumber/psb/";
xloc($ke);
exit();
?>