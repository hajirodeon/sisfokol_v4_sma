<?php 



session_start();

//ambil nilai
require("../../inc/config.php"); 
require("../../inc/fungsi.php"); 

nocache;

//hapus session
session_unset($kd2_session);
session_unset($bdh_session);
session_unset($username2_session);

session_unregister('$kd2_session');
session_unregister('$bdh_session');
session_unregister('$username2_session');

//re-direct
$ke = "$sumber/psb/";
xloc($ke);
exit();
?>